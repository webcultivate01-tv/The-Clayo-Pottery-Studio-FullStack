<?php
/**
 * Create or reset the default admin user for Calyo SMS.
 *
 * Usage (from project root):
 *     "C:\xampp\php\php.exe" admin/database/seeds/create_admin.php
 *     "C:\xampp\php\php.exe" admin/database/seeds/create_admin.php --email=you@you.com --password=YourPass
 *
 * If the email already exists, the password is reset and the account re-activated.
 */
declare(strict_types=1);

$opts = getopt('', ['email::', 'password::', 'name::']);
$email    = $opts['email']    ?? 'admin@gmail.com';
$password = $opts['password'] ?? 'admin123';
$name     = $opts['name']     ?? 'Calyo Admin';

$config = require __DIR__ . '/../../config/database.php';

$dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
    $config['host'], $config['port'], $config['database'], $config['charset']);

try {
    $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
} catch (PDOException $e) {
    fwrite(STDERR, "Could not connect to MySQL: " . $e->getMessage() . PHP_EOL);
    fwrite(STDERR, "Did you import schema.sql first?" . PHP_EOL);
    exit(1);
}

$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

$find = $pdo->prepare('SELECT id FROM users WHERE email = :email');
$find->execute(['email' => $email]);
$existing = $find->fetch(PDO::FETCH_ASSOC);

if ($existing) {
    $upd = $pdo->prepare(
        'UPDATE users
            SET password = :pw, name = :name, role = "admin", is_active = 1,
                failed_attempts = 0, last_failed_at = NULL
          WHERE id = :id'
    );
    $upd->execute(['pw' => $hash, 'name' => $name, 'id' => $existing['id']]);
    echo "Admin user UPDATED: {$email}" . PHP_EOL;
} else {
    $ins = $pdo->prepare(
        'INSERT INTO users (name, email, password, role, is_active)
         VALUES (:name, :email, :pw, "admin", 1)'
    );
    $ins->execute(['name' => $name, 'email' => $email, 'pw' => $hash]);
    echo "Admin user CREATED: {$email}" . PHP_EOL;
}

echo "Login with:" . PHP_EOL;
echo "  Email:    {$email}" . PHP_EOL;
echo "  Password: {$password}" . PHP_EOL;
echo "Change this password after first login." . PHP_EOL;
