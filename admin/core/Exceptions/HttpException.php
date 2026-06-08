<?php
declare(strict_types=1);

namespace Calyo\Core\Exceptions;

class HttpException extends \RuntimeException
{
    private int $statusCode;

    public function __construct(int $statusCode, string $message = '')
    {
        parent::__construct($message ?: 'HTTP ' . $statusCode);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
