<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Accept JSON body (fetch) or form-encoded POST
$ct    = $_SERVER['CONTENT_TYPE'] ?? '';
$input = str_contains($ct, 'application/json')
    ? (json_decode(file_get_contents('php://input'), true) ?? [])
    : $_POST;

function sanitize(mixed $v): string
{
    return htmlspecialchars(trim(strip_tags((string) $v)), ENT_QUOTES, 'UTF-8');
}

$name    = sanitize($input['customer_name'] ?? '');
$phone   = sanitize($input['phone']         ?? '');
$email   = trim((string)($input['email']    ?? ''));
$dob     = sanitize($input['dob']           ?? '');
$address = sanitize($input['address']       ?? '');
$service = sanitize($input['service']       ?? '');
$pdate   = sanitize($input['preferred_date'] ?? '');
$ptime   = sanitize($input['preferred_time'] ?? '');
$message = sanitize($input['message']       ?? '');

// Validate email
$email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;

$isEnquiry = ($service === 'General Enquiry');

// Required fields — date/time are optional for general enquiries
if ($name === '' || $phone === '' || $service === '' || (!$isEnquiry && ($pdate === '' || $ptime === ''))) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

// Validate preferred_date when provided
if ($pdate !== '' && !strtotime($pdate)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please select a valid preferred date.']);
    exit;
}

// Connect to DB using the same config as the admin panel
try {
    $cfg = require __DIR__ . '/admin/config/database.php';
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $cfg['host'],
        $cfg['port'] ?? '3306',
        $cfg['database']
    );
    $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (Throwable) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Could not reach the server. Please call us directly.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // 1) Insert the booking
    $stmt = $pdo->prepare("
        INSERT INTO bookings
            (customer_name, phone, email, dob, address, service, preferred_date, preferred_time, message, status, source)
        VALUES
            (:name, :phone, :email, :dob, :address, :service, :pdate, :ptime, :message, 'pending', 'website')
    ");
    $stmt->execute([
        ':name'    => $name,
        ':phone'   => $phone,
        ':email'   => $email,
        ':dob'     => ($dob !== '' ? $dob : null),
        ':address' => ($address !== '' ? $address : null),
        ':service' => $service,
        ':pdate'   => ($pdate !== '' ? $pdate : null),
        ':ptime'   => ($ptime !== '' ? $ptime : null),
        ':message' => ($message !== '' ? $message : null),
    ]);

    // 2) Upsert into clients so the booker shows up on the Clients page.
    //    Match by email when present, otherwise by phone — avoids duplicates
    //    when the same person books multiple times. Existing client data is
    //    left untouched; we only fill blanks (address) and append a note.
    $existingId = null;

    if ($email !== null) {
        $find = $pdo->prepare("SELECT id, address FROM clients WHERE email = :email LIMIT 1");
        $find->execute([':email' => $email]);
        $existingId = $find->fetch();
    }
    if (!$existingId && $phone !== '') {
        $find = $pdo->prepare("SELECT id, address FROM clients WHERE phone = :phone LIMIT 1");
        $find->execute([':phone' => $phone]);
        $existingId = $find->fetch();
    }

    $noteLine = sprintf(
        '[%s] Booked %s for %s %s via website.',
        date('Y-m-d'),
        $service,
        $pdate,
        $ptime
    );

    if ($existingId) {
        $sets   = ['notes = TRIM(CONCAT_WS(\'\n\', notes, :note))'];
        $params = [':note' => $noteLine, ':id' => $existingId['id']];

        // Fill address only if the client record had none
        if (empty($existingId['address']) && $address !== '') {
            $sets[]              = 'address = :address';
            $params[':address']  = $address;
        }
        $upd = $pdo->prepare('UPDATE clients SET ' . implode(', ', $sets) . ' WHERE id = :id');
        $upd->execute($params);
    } else {
        // Split "First Last Names" → first_name / last_name on first space.
        $parts     = preg_split('/\s+/', $name, 2);
        $firstName = $parts[0] ?? $name;
        $lastName  = $parts[1] ?? '';

        $ins = $pdo->prepare("
            INSERT INTO clients
                (first_name, last_name, email, phone, address, notes, status)
            VALUES
                (:first_name, :last_name, :email, :phone, :address, :notes, 'active')
        ");
        $ins->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':email'      => $email,
            ':phone'      => $phone,
            ':address'    => ($address !== '' ? $address : null),
            ':notes'      => $noteLine,
        ]);
    }

    $pdo->commit();
    echo json_encode(['ok' => true, 'message' => 'Booking received! We will contact you shortly to confirm your seat.']);
} catch (Throwable) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Could not save your booking. Please try again or call us directly.']);
}
