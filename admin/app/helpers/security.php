<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function clean(?string $value): string
{
    return trim((string) $value);
}

function bcrypt_hash(string $password): string
{
    $cost = \Calyo\Core\App::config('security.bcrypt_cost', 12);
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
}

function bcrypt_verify(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}
