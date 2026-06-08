<?php
declare(strict_types=1);

/**
 * One-off backfill: walk every booking and ensure the customer also exists in
 * `clients`. Mirrors the upsert logic in /booking-submit.php so the result is
 * identical to what new bookings now produce.
 *
 * Usage (from project root):
 *   C:\xampp\php\php.exe admin\database\seeds\backfill_clients_from_bookings.php
 */

$cfg = require __DIR__ . '/../../config/database.php';
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

$bookings = $pdo->query(
    "SELECT id, customer_name, phone, email, address, service, preferred_date, preferred_time, created_at
     FROM bookings
     ORDER BY created_at ASC"
)->fetchAll();

$inserted = 0;
$updated  = 0;
$skipped  = 0;

foreach ($bookings as $b) {
    $name    = trim((string) $b['customer_name']);
    $phone   = trim((string) $b['phone']);
    $email   = $b['email'] !== null && $b['email'] !== '' ? trim((string) $b['email']) : null;
    $address = $b['address'] !== null && $b['address'] !== '' ? (string) $b['address'] : null;

    if ($name === '' || $phone === '') {
        $skipped++;
        continue;
    }

    $existing = null;
    if ($email !== null) {
        $stmt = $pdo->prepare("SELECT id, address FROM clients WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $existing = $stmt->fetch() ?: null;
    }
    if (!$existing) {
        $stmt = $pdo->prepare("SELECT id, address FROM clients WHERE phone = :phone LIMIT 1");
        $stmt->execute([':phone' => $phone]);
        $existing = $stmt->fetch() ?: null;
    }

    $noteLine = sprintf(
        '[%s] Booked %s for %s %s via website.',
        date('Y-m-d', strtotime((string) $b['created_at'])),
        (string) $b['service'],
        (string) $b['preferred_date'],
        (string) $b['preferred_time']
    );

    if ($existing) {
        $sets   = ["notes = TRIM(CONCAT_WS('\n', notes, :note))"];
        $params = [':note' => $noteLine, ':id' => $existing['id']];
        if (empty($existing['address']) && $address !== null) {
            $sets[]              = 'address = :address';
            $params[':address']  = $address;
        }
        $upd = $pdo->prepare('UPDATE clients SET ' . implode(', ', $sets) . ' WHERE id = :id');
        $upd->execute($params);
        $updated++;
    } else {
        $parts     = preg_split('/\s+/', $name, 2) ?: [$name];
        $firstName = $parts[0] ?? $name;
        $lastName  = $parts[1] ?? '';

        $ins = $pdo->prepare("
            INSERT INTO clients (first_name, last_name, email, phone, address, notes, status, created_at)
            VALUES (:first_name, :last_name, :email, :phone, :address, :notes, 'active', :created_at)
        ");
        $ins->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':email'      => $email,
            ':phone'      => $phone,
            ':address'    => $address,
            ':notes'      => $noteLine,
            ':created_at' => (string) $b['created_at'],
        ]);
        $inserted++;
    }
}

echo "Done.\n";
echo "  Bookings scanned: " . count($bookings) . "\n";
echo "  Clients inserted: $inserted\n";
echo "  Clients updated:  $updated (note line appended)\n";
echo "  Skipped (missing name/phone): $skipped\n";
