<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Database;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\Booking;
use Throwable;

/**
 * EnquiryController — thin wrapper around the bookings table that filters to
 * rows where service = "General Enquiry". Enquiries don't require a preferred
 * date/time (they're questions, not scheduled visits).
 */
final class EnquiryController extends Controller
{
    private Booking $model;

    public function __construct()
    {
        $this->model = new Booking();
    }

    public function index(Request $request): void
    {
        $filters = $this->readFilters($request);
        $filters['service'] = Booking::ENQUIRY_SERVICE; // force-filter to enquiries
        $page    = max(1, (int) $request->input('page', 1));
        $result  = $this->model->paginate($filters, $page);

        $this->view('enquiries.index', [
            'title'   => 'Enquiries',
            'result'  => $result,
            'filters' => $filters,
        ]);
    }

    public function store(Request $request): void
    {
        $name     = clean((string) $request->input('customer_name', ''));
        $phone    = clean((string) $request->input('phone', ''));
        $emailRaw = clean((string) $request->input('email', ''));
        $email    = ($emailRaw !== '' && filter_var($emailRaw, FILTER_VALIDATE_EMAIL)) ? $emailRaw : null;
        $address  = clean((string) $request->input('address', '')) ?: null;
        $subject  = clean((string) $request->input('subject', '')) ?: null;
        $message  = clean((string) $request->input('message', '')) ?: null;
        $notes    = clean((string) $request->input('notes', ''))   ?: null;

        $allowedSources = ['walk_in', 'phone', 'admin', 'website'];
        $source = clean((string) $request->input('source', 'phone'));
        if (!in_array($source, $allowedSources, true)) $source = 'phone';

        if ($name === '' || $phone === '' || ($message === null && $subject === null)) {
            Session::flash('error', 'Customer name, phone and a subject or message are required.');
            $this->redirect('/enquiries');
        }

        // Compose the message body — prepend subject if provided so it survives in
        // the same column the website uses.
        $finalMessage = $subject ? ($subject . "\n\n" . ($message ?? '')) : $message;

        $pdo = Database::connection();
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO bookings
                    (customer_name, phone, email, address, service,
                     preferred_date, preferred_time, message, notes, status, source)
                VALUES
                    (:name, :phone, :email, :address, :service,
                     NULL, NULL, :message, :notes, 'pending', :source)
            ");
            $stmt->execute([
                ':name'    => $name,
                ':phone'   => $phone,
                ':email'   => $email,
                ':address' => $address,
                ':service' => Booking::ENQUIRY_SERVICE,
                ':message' => $finalMessage,
                ':notes'   => $notes,
                ':source'  => $source,
            ]);

            // Same client-upsert behaviour as the public booking form so the
            // enquiry contact lands in Clients too.
            $existing = null;
            if ($email !== null) {
                $find = $pdo->prepare("SELECT id, address FROM clients WHERE email = :email LIMIT 1");
                $find->execute([':email' => $email]);
                $existing = $find->fetch();
            }
            if (!$existing) {
                $find = $pdo->prepare("SELECT id, address FROM clients WHERE phone = :phone LIMIT 1");
                $find->execute([':phone' => $phone]);
                $existing = $find->fetch();
            }

            $noteLine = sprintf('[%s] Enquiry: %s', date('Y-m-d'), $subject ?? 'general question');

            if ($existing) {
                $sets   = ["notes = TRIM(CONCAT_WS('\n', notes, :note))"];
                $params = [':note' => $noteLine, ':id' => $existing['id']];
                if (empty($existing['address']) && $address !== null) {
                    $sets[]             = 'address = :address';
                    $params[':address'] = $address;
                }
                $upd = $pdo->prepare('UPDATE clients SET ' . implode(', ', $sets) . ' WHERE id = :id');
                $upd->execute($params);
            } else {
                $parts     = preg_split('/\s+/', $name, 2);
                $firstName = $parts[0] ?? $name;
                $lastName  = $parts[1] ?? '';
                $ins = $pdo->prepare("
                    INSERT INTO clients (first_name, last_name, email, phone, address, notes, status)
                    VALUES (:first_name, :last_name, :email, :phone, :address, :notes, 'active')
                ");
                $ins->execute([
                    ':first_name' => $firstName,
                    ':last_name'  => $lastName,
                    ':email'      => $email,
                    ':phone'      => $phone,
                    ':address'    => $address,
                    ':notes'      => $noteLine,
                ]);
            }

            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            Session::flash('error', 'Could not save enquiry: ' . $e->getMessage());
            $this->redirect('/enquiries');
        }

        Session::flash('success', 'Enquiry added.');
        $this->redirect('/enquiries');
    }

    public function updateStatus(Request $request, string $id): void
    {
        $booking = $this->model->find((int) $id);
        if (!$booking || $booking['service'] !== Booking::ENQUIRY_SERVICE) {
            Session::flash('error', 'Enquiry not found.');
            $this->redirect('/enquiries');
        }

        $allowed = ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'];
        $status  = clean((string) $request->input('status', 'pending'));

        $update = ['status' => in_array($status, $allowed, true) ? $status : 'pending'];
        $notes = $request->input('notes');
        if ($notes !== null) {
            $update['notes'] = clean((string) $notes);
        }

        $this->model->update((int) $id, $update);
        Session::flash('success', 'Enquiry updated.');
        $this->redirect('/enquiries');
    }

    public function destroy(Request $request, string $id): void
    {
        $booking = $this->model->find((int) $id);
        if (!$booking || $booking['service'] !== Booking::ENQUIRY_SERVICE) {
            Session::flash('error', 'Enquiry not found.');
            $this->redirect('/enquiries');
        }

        $this->model->delete((int) $id);
        Session::flash('success', 'Enquiry deleted.');
        $this->redirect('/enquiries');
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function readFilters(Request $request): array
    {
        $rcv = clean((string) $request->input('received_range', ''));
        if ($rcv === '' || !array_key_exists($rcv, Booking::quickRanges())) {
            $rcv = 'all';
        }
        return [
            'search'         => clean((string) $request->input('search', '')),
            'status'         => clean((string) $request->input('status', '')),
            'source'         => clean((string) $request->input('source', '')),
            'received_range' => $rcv,
        ];
    }
}
