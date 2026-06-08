<?php
declare(strict_types=1);

/**
 * Apply migration 007 — create the `gallery_images` table (website gallery).
 * Run from CLI:  php admin/database/seeds/run_migration_007.php
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

$sqlFile = __DIR__ . '/../migrations/007_create_gallery_images.sql';
if (!file_exists($sqlFile)) {
    fwrite(STDERR, "❌ Migration file not found: $sqlFile" . PHP_EOL);
    exit(1);
}

$sql        = file_get_contents($sqlFile);
$statements = array_filter(array_map('trim', explode(';', $sql)));

try {
    foreach ($statements as $stmt) {
        if ($stmt === '' || str_starts_with($stmt, '--')) continue;
        $pdo->exec($stmt);
    }
    echo "✅ Migration 007 applied successfully." . PHP_EOL;
    echo "   - `gallery_images` table created" . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, "❌ Migration failed: " . $e->getMessage() . PHP_EOL);
    exit(1);
}
