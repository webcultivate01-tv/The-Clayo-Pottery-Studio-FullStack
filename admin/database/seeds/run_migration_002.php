<?php
declare(strict_types=1);

/**
 * Apply migration 002 — replace `appointments` with `bookings`.
 * Run from CLI:  php admin/database/seeds/run_migration_002.php
 */

$cfg = require __DIR__ . '/../../config/database.php';

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $cfg['host'],
        $cfg['port'] ?? '3306',
        $cfg['database']
    );
    $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (Throwable $e) {
    fwrite(STDERR, "❌ Could not connect: " . $e->getMessage() . PHP_EOL);
    exit(1);
}

$sqlFile = __DIR__ . '/../migrations/002_rename_appointments_to_bookings.sql';
if (!file_exists($sqlFile)) {
    fwrite(STDERR, "❌ Migration file not found: $sqlFile" . PHP_EOL);
    exit(1);
}

$sql = file_get_contents($sqlFile);

// Split on semicolons (simple split; this migration has no embedded ;)
$statements = array_filter(array_map('trim', explode(';', $sql)));

$pdo->beginTransaction();
try {
    foreach ($statements as $stmt) {
        if ($stmt === '' || str_starts_with($stmt, '--')) continue;
        $pdo->exec($stmt);
    }
    $pdo->commit();
    echo "✅ Migration 002 applied successfully." . PHP_EOL;
    echo "   - `appointments` table dropped" . PHP_EOL;
    echo "   - `bookings` table created" . PHP_EOL;
    echo "   - `files.attachable_type` ENUM updated" . PHP_EOL;
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, "❌ Migration failed: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
