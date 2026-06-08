<?php
// Run from terminal: php admin/database/seeds/generate_password_hash.php "YourPassword"
// Outputs a bcrypt hash you can paste into the users table.

if ($argc < 2) {
    fwrite(STDERR, "Usage: php generate_password_hash.php <password>\n");
    exit(1);
}

echo password_hash($argv[1], PASSWORD_BCRYPT, ['cost' => 12]) . PHP_EOL;
