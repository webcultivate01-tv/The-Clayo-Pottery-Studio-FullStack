<?php
declare(strict_types=1);

namespace Calyo\Core;

use RuntimeException;

/**
 * Minimal SMTP client — STARTTLS + AUTH LOGIN (Gmail-compatible).
 * No external dependencies; reads config from config/mail.php.
 */
final class Mailer
{
    /** @var resource|null */
    private $socket = null;
    private array $cfg;

    public function __construct(?array $cfg = null)
    {
        $this->cfg = $cfg ?? require ROOT_PATH . '/config/mail.php';
    }

    /**
     * Send one message. Recipients should be a list of email addresses (TO).
     * For broadcasts use the controller's per-recipient loop so each customer
     * sees only their own address (no BCC).
     *
     * @param string[] $to
     */
    public function send(array $to, string $subject, string $htmlBody, ?string $replyTo = null): void
    {
        if (empty($to)) {
            throw new RuntimeException('Mailer: at least one recipient required.');
        }

        $this->connect();
        $this->expect(220);

        $this->writeLine('EHLO ' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
        $this->expect(250);

        if (($this->cfg['encryption'] ?? 'tls') === 'tls') {
            $this->writeLine('STARTTLS');
            $this->expect(220);

            $crypto = STREAM_CRYPTO_METHOD_TLS_CLIENT
                | STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT
                | STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
            if (!stream_socket_enable_crypto($this->socket, true, $crypto)) {
                throw new RuntimeException('Mailer: STARTTLS handshake failed.');
            }

            $this->writeLine('EHLO ' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
            $this->expect(250);
        }

        $this->writeLine('AUTH LOGIN');
        $this->expect(334);
        $this->writeLine(base64_encode((string) $this->cfg['username']));
        $this->expect(334);
        $this->writeLine(base64_encode((string) $this->cfg['password']));
        $this->expect(235); // auth ok

        $this->writeLine('MAIL FROM:<' . $this->cfg['from_email'] . '>');
        $this->expect(250);

        foreach ($to as $addr) {
            $this->writeLine('RCPT TO:<' . $addr . '>');
            $this->expect(250);
        }

        $this->writeLine('DATA');
        $this->expect(354);

        $headers = $this->buildHeaders($to, $subject, $replyTo);
        // Body: dot-stuff lines that start with "." and use CRLF line endings
        $body = preg_replace('/^\./m', '..', $htmlBody);
        $body = preg_replace('/\r\n|\r|\n/', "\r\n", $body);

        $this->writeRaw($headers . "\r\n\r\n" . $body . "\r\n.\r\n");
        $this->expect(250);

        $this->writeLine('QUIT');
        $this->close();
    }

    // ── internals ────────────────────────────────────────────────────────────

    private function connect(): void
    {
        $host    = (string) $this->cfg['host'];
        $port    = (int)    $this->cfg['port'];
        $timeout = (int)   ($this->cfg['timeout'] ?? 15);
        $useSsl  = ($this->cfg['encryption'] ?? '') === 'ssl';

        $ctx = stream_context_create([
            'ssl' => [
                'verify_peer'       => (bool) ($this->cfg['verify_peer'] ?? true),
                'verify_peer_name'  => (bool) ($this->cfg['verify_peer'] ?? true),
                'allow_self_signed' => false,
            ],
        ]);

        $dsn = ($useSsl ? 'ssl://' : 'tcp://') . $host . ':' . $port;
        $sock = @stream_socket_client($dsn, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $ctx);
        if (!$sock) {
            throw new RuntimeException("Mailer: connect to {$dsn} failed ({$errno}: {$errstr})");
        }

        stream_set_timeout($sock, $timeout);
        $this->socket = $sock;
    }

    private function writeLine(string $line): void
    {
        $this->writeRaw($line . "\r\n");
    }

    private function writeRaw(string $bytes): void
    {
        if (!is_resource($this->socket)) {
            throw new RuntimeException('Mailer: socket not open.');
        }
        if (@fwrite($this->socket, $bytes) === false) {
            throw new RuntimeException('Mailer: write failed.');
        }
    }

    private function expect(int $code): string
    {
        $response = '';
        while (is_resource($this->socket) && !feof($this->socket)) {
            $line = @fgets($this->socket, 1024);
            if ($line === false) {
                throw new RuntimeException('Mailer: read failed (timeout?).');
            }
            $response .= $line;
            // Multi-line responses have "<code>-..." until the final "<code> ..." line
            if (strlen($line) >= 4 && $line[3] === ' ') break;
        }
        $actual = (int) substr($response, 0, 3);
        if ($actual !== $code) {
            throw new RuntimeException("Mailer: expected {$code}, got: " . trim($response));
        }
        return $response;
    }

    private function close(): void
    {
        if (is_resource($this->socket)) {
            @fclose($this->socket);
        }
        $this->socket = null;
    }

    private function buildHeaders(array $to, string $subject, ?string $replyTo): string
    {
        $fromName  = $this->encodeHeader((string) $this->cfg['from_name']);
        $fromEmail = (string) $this->cfg['from_email'];

        $lines   = [];
        $lines[] = 'Date: ' . date('r');
        $lines[] = 'From: ' . $fromName . ' <' . $fromEmail . '>';
        $lines[] = 'To: ' . implode(', ', array_map(fn($e) => '<' . $e . '>', $to));
        if ($replyTo) {
            $lines[] = 'Reply-To: <' . $replyTo . '>';
        }
        $lines[] = 'Subject: =?UTF-8?B?' . base64_encode($subject) . '?=';
        $lines[] = 'MIME-Version: 1.0';
        $lines[] = 'Content-Type: text/html; charset=UTF-8';
        $lines[] = 'Content-Transfer-Encoding: 8bit';
        $lines[] = 'X-Mailer: Calyo SMS';
        $lines[] = 'Message-ID: <' . bin2hex(random_bytes(8)) . '@' . ($_SERVER['HTTP_HOST'] ?? 'calyo.local') . '>';

        return implode("\r\n", $lines);
    }

    private function encodeHeader(string $value): string
    {
        return preg_match('/[^\x20-\x7e]/', $value)
            ? '=?UTF-8?B?' . base64_encode($value) . '?='
            : $value;
    }
}
