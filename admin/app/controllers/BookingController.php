<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Database;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\Booking;
use Calyo\Services\ImageUploader;
use Throwable;

final class BookingController extends Controller
{
    private Booking $model;
    private ImageUploader $uploader;

    public function __construct()
    {
        $this->model    = new Booking();
        $this->uploader = new ImageUploader();
    }

    public function index(Request $request): void
    {
        $filters = $this->readFilters($request);
        // Scheduled bookings only — General Enquiry rows live on the /enquiries page
        $filters['exclude_service'] = Booking::ENQUIRY_SERVICE;
        $page    = max(1, (int) $request->input('page', 1));
        $result  = $this->model->paginate($filters, $page);

        $this->view('bookings.index', [
            'title'   => 'Bookings',
            'result'  => $result,
            'filters' => $filters,
        ]);
    }

    public function updateStatus(Request $request, string $id): void
    {
        $booking = $this->model->find((int) $id);
        if (!$booking) {
            Session::flash('error', 'Booking not found.');
            $this->redirect('/bookings');
        }

        $allowed = ['pending', 'confirmed', 'completed', 'delivered', 'cancelled', 'no_show'];
        $status  = clean((string) $request->input('status', 'pending'));

        $update = [
            'status' => in_array($status, $allowed, true) ? $status : 'pending',
        ];

        // Only overwrite notes when the form actually submitted them
        // (inline status dropdowns do not send a notes field).
        $notes = $request->input('notes');
        if ($notes !== null) {
            $update['notes'] = clean((string) $notes);
        }

        $this->model->update((int) $id, $update);

        Session::flash('success', 'Booking status updated.');
        $this->redirect('/bookings');
    }

    public function store(Request $request): void
    {
        // Required fields
        $name    = clean((string) $request->input('customer_name', ''));
        $phone   = clean((string) $request->input('phone', ''));
        $service = clean((string) $request->input('service', ''));
        $pdate   = clean((string) $request->input('preferred_date', ''));
        $ptime   = clean((string) $request->input('preferred_time', ''));

        // Optional
        $emailRaw = clean((string) $request->input('email', ''));
        $email    = ($emailRaw !== '' && filter_var($emailRaw, FILTER_VALIDATE_EMAIL)) ? $emailRaw : null;
        $dob      = clean((string) $request->input('dob', ''))     ?: null;
        $address  = clean((string) $request->input('address', '')) ?: null;
        $message  = clean((string) $request->input('message', '')) ?: null;
        $notes    = clean((string) $request->input('notes', ''))   ?: null;

        $allowedSources = ['walk_in', 'phone', 'admin', 'website'];
        $source = clean((string) $request->input('source', 'walk_in'));
        if (!in_array($source, $allowedSources, true)) $source = 'walk_in';

        // Server-side validation
        if ($name === '' || $phone === '' || $service === '' || $pdate === '' || $ptime === '') {
            Session::flash('error', 'Please fill in customer name, phone, service, date and time.');
            $this->redirect('/bookings');
        }
        if (!in_array($service, Booking::allServices(), true)) {
            Session::flash('error', 'Please pick a valid service.');
            $this->redirect('/bookings');
        }
        if (!strtotime($pdate)) {
            Session::flash('error', 'Please pick a valid preferred date.');
            $this->redirect('/bookings');
        }

        // Insert booking + upsert client in one transaction
        $pdo = Database::connection();
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO bookings
                    (customer_name, phone, email, dob, address, service,
                     preferred_date, preferred_time, message, notes, status, source)
                VALUES
                    (:name, :phone, :email, :dob, :address, :service,
                     :pdate, :ptime, :message, :notes, 'pending', :source)
            ");
            $stmt->execute([
                ':name'    => $name,
                ':phone'   => $phone,
                ':email'   => $email,
                ':dob'     => $dob,
                ':address' => $address,
                ':service' => $service,
                ':pdate'   => $pdate,
                ':ptime'   => $ptime,
                ':message' => $message,
                ':notes'   => $notes,
                ':source'  => $source,
            ]);

            // Mirror booking-submit.php behaviour: upsert client so they appear
            // on the Clients page. Match by email first, then phone.
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

            $noteLine = sprintf('[%s] Walk-in booking: %s for %s %s.', date('Y-m-d'), $service, $pdate, $ptime);

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
            Session::flash('error', 'Could not save booking: ' . $e->getMessage());
            $this->redirect('/bookings');
        }

        Session::flash('success', 'Walk-in booking added successfully.');
        $this->redirect('/bookings');
    }

    public function destroy(Request $request, string $id): void
    {
        $booking = $this->model->find((int) $id);
        if (!$booking) {
            Session::flash('error', 'Booking not found.');
            $this->redirect('/bookings');
        }

        $this->model->delete((int) $id);
        Session::flash('success', 'Booking deleted.');
        $this->redirect('/bookings');
    }

    public function export(Request $request): void
    {
        $filters  = $this->readFilters($request);
        $bookings = $this->model->filter($filters);
        $format   = (string) $request->input('format', 'csv');

        if ($format === 'pdf') {
            $this->view('bookings.print', [
                'title'    => 'Bookings Export',
                'bookings' => $bookings,
                'filters'  => $filters,
            ], null);
            return;
        }

        // CSV / Excel (UTF-8 BOM so Excel opens correctly)
        $filename = 'bookings_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['#', 'Name', 'Phone', 'Email', 'DOB', 'Address', 'Service', 'Preferred Date', 'Preferred Time', 'Message', 'Status', 'Source', 'Admin Notes', 'Received On']);
        foreach ($bookings as $i => $b) {
            fputcsv($out, [
                $i + 1,
                $b['customer_name'],
                $b['phone'],
                $b['email']          ?? '',
                $b['dob']            ?? '',
                $b['address']        ?? '',
                $b['service'],
                $b['preferred_date'],
                $b['preferred_time'],
                $b['message']        ?? '',
                ucfirst(str_replace('_', ' ', $b['status'])),
                ucfirst(str_replace('_', ' ', $b['source'])),
                $b['notes']          ?? '',
                date('d M Y', strtotime($b['created_at'])),
            ]);
        }
        fclose($out);
        exit;
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function readFilters(Request $request): array
    {
        $quick = clean((string) $request->input('quick_range', ''));
        if ($quick === '' || !array_key_exists($quick, Booking::quickRanges())) {
            $quick = 'all';
        }
        return [
            'search'        => clean((string) $request->input('search', '')),
            'status'        => clean((string) $request->input('status', '')),
            'service_group' => clean((string) $request->input('service_group', '')),
            'service'       => clean((string) $request->input('service', '')),
            'date_from'     => clean((string) $request->input('date_from', '')),
            'date_to'       => clean((string) $request->input('date_to', '')),
            'quick_range'   => $quick,
        ];
    }

    // ── Reference images ─────────────────────────────────────────────────────

    public function uploadImage(Request $request, string $id): void
    {
        $booking = $this->model->find((int) $id);
        if (!$booking) {
            Session::flash('error', 'Booking not found.');
            $this->redirect('/bookings');
        }

        $images = Booking::decodeImages($booking['reference_images'] ?? null);
        if (count($images) >= Booking::MAX_REFERENCE_IMAGES) {
            Session::flash('error', 'Maximum ' . Booking::MAX_REFERENCE_IMAGES . ' reference images per booking.');
            $this->redirect('/bookings');
        }

        try {
            $relativePath = $this->uploader->store(
                $_FILES['image'] ?? [],
                'uploads/bookings',
                'booking-' . $id
            );
        } catch (Throwable $e) {
            Session::flash('error', 'Image upload failed: ' . $e->getMessage());
            $this->redirect('/bookings');
        }

        if ($relativePath === null) {
            Session::flash('error', 'No image was uploaded.');
            $this->redirect('/bookings');
        }

        $images[] = $relativePath;
        $this->model->update((int) $id, [
            'reference_images' => Booking::encodeImages($images),
        ]);

        Session::flash('success', 'Reference image uploaded.');
        $this->redirect('/bookings');
    }

    public function deleteImage(Request $request, string $id): void
    {
        $booking = $this->model->find((int) $id);
        if (!$booking) {
            Session::flash('error', 'Booking not found.');
            $this->redirect('/bookings');
        }

        $index  = (int) $request->input('index', -1);
        $images = Booking::decodeImages($booking['reference_images'] ?? null);

        if (!isset($images[$index])) {
            Session::flash('error', 'Image not found.');
            $this->redirect('/bookings');
        }

        $this->uploader->delete($images[$index]);
        array_splice($images, $index, 1);

        $this->model->update((int) $id, [
            'reference_images' => Booking::encodeImages($images),
        ]);

        Session::flash('success', 'Reference image removed.');
        $this->redirect('/bookings');
    }
}
