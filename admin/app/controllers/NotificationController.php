<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Database;
use Calyo\Core\Mailer;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Throwable;

/**
 * NotificationController — admin broadcast tool. Composes a single email
 * and sends it (BCC) to every client that has a valid email on file.
 */
final class NotificationController extends Controller
{
    public function index(Request $request): void
    {
        $stats = $this->recipientStats();

        $this->view('notifications.index', [
            'title'             => 'Notifications',
            'recipientCount'    => $stats['count'],
            'totalClients'      => $stats['total'],
            'sampleRecipients'  => $stats['sample'],
        ]);
    }

    public function send(Request $request): void
    {
        $subject = clean((string) $request->input('subject', ''));
        $message = trim((string) $request->input('message', ''));
        $audience = clean((string) $request->input('audience', 'active'));

        if ($subject === '' || $message === '') {
            Session::flash('error', 'Subject and message are required.');
            $this->redirect('/notifications');
        }

        if (mb_strlen($subject) > 200) {
            Session::flash('error', 'Subject must be 200 characters or fewer.');
            $this->redirect('/notifications');
        }

        $recipients = $this->fetchRecipients($audience);
        if (empty($recipients)) {
            Session::flash('error', 'No clients with a valid email address were found.');
            $this->redirect('/notifications');
        }

        $studioName  = $this->setting('studio_name',  'Clayo Pottery Studio');
        $studioEmail = $this->setting('studio_email', 'webcultivate01@gmail.com');
        $body        = $this->renderEmailBody($subject, $message, $studioName);

        $sent   = 0;
        $failed = [];

        try {
            $mailer = new Mailer();
            foreach ($recipients as $address) {
                try {
                    // One message per recipient — clean inbox view, no BCC leak.
                    $mailer->send([$address], $subject, $body, $studioEmail);
                    $sent++;
                    // Gmail throttles aggressive bursts; small pause keeps us safe.
                    usleep(150_000);
                } catch (Throwable $e) {
                    $failed[] = $address;
                }
            }
        } catch (Throwable $e) {
            Session::flash('error', 'Could not connect to the mail server: ' . $e->getMessage());
            $this->redirect('/notifications');
        }

        if ($sent === 0) {
            Session::flash('error', 'No emails were delivered. Check SMTP credentials in config/mail.php.');
            $this->redirect('/notifications');
        }

        $msg = sprintf('Notification sent to %d client%s.', $sent, $sent === 1 ? '' : 's');
        if (!empty($failed)) {
            $msg .= sprintf(' %d address%s failed.', count($failed), count($failed) === 1 ? '' : 'es');
        }
        Session::flash('success', $msg);
        $this->redirect('/notifications');
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function recipientStats(): array
    {
        $pdo = Database::connection();

        $total = (int) $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();

        $count = (int) $pdo->query("
            SELECT COUNT(*) FROM clients
            WHERE status = 'active'
              AND email IS NOT NULL
              AND email <> ''
        ")->fetchColumn();

        $sample = $pdo->query("
            SELECT email FROM clients
            WHERE status = 'active'
              AND email IS NOT NULL
              AND email <> ''
            ORDER BY created_at DESC
            LIMIT 6
        ")->fetchAll(\PDO::FETCH_COLUMN);

        return ['count' => $count, 'total' => $total, 'sample' => $sample];
    }

    private function fetchRecipients(string $audience): array
    {
        $sql = "SELECT email FROM clients WHERE email IS NOT NULL AND email <> ''";
        if ($audience !== 'all') {
            $sql .= " AND status = 'active'";
        }

        $stmt   = Database::connection()->query($sql);
        $emails = $stmt->fetchAll(\PDO::FETCH_COLUMN) ?: [];

        $clean = [];
        foreach ($emails as $e) {
            $e = trim((string) $e);
            if (filter_var($e, FILTER_VALIDATE_EMAIL)) {
                $clean[strtolower($e)] = $e;
            }
        }
        return array_values($clean);
    }

    private function setting(string $key, string $default): string
    {
        try {
            $stmt = Database::connection()->prepare("SELECT value FROM settings WHERE key_name = :k LIMIT 1");
            $stmt->execute([':k' => $key]);
            $v = $stmt->fetchColumn();
            return is_string($v) && $v !== '' ? $v : $default;
        } catch (Throwable $e) {
            return $default;
        }
    }

    private function renderEmailBody(string $subject, string $message, string $studioName): string
    {
        $safeSubject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
        $safeStudio  = htmlspecialchars($studioName, ENT_QUOTES, 'UTF-8');
        $safeBody    = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
        $year        = date('Y');

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>{$safeSubject}</title></head>
<body style="margin:0;padding:0;background:#f6f7fb;font-family:Arial,Helvetica,sans-serif;color:#0f172a;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f6f7fb;padding:24px 0;">
    <tr><td align="center">
      <table role="presentation" width="560" cellspacing="0" cellpadding="0" style="background:#ffffff;border:1px solid #e9ecf3;border-radius:14px;overflow:hidden;">
        <tr><td style="padding:22px 28px;background:linear-gradient(135deg,#4f46e5,#4338ca);color:#ffffff;font-weight:700;font-size:16px;letter-spacing:.5px;">
          {$safeStudio}
        </td></tr>
        <tr><td style="padding:28px;">
          <h1 style="margin:0 0 14px;font-size:20px;line-height:1.3;color:#0f172a;">{$safeSubject}</h1>
          <div style="font-size:14px;line-height:1.65;color:#334155;">{$safeBody}</div>
        </td></tr>
        <tr><td style="padding:16px 28px;background:#f8fafc;border-top:1px solid #e9ecf3;font-size:12px;color:#64748b;">
          You're receiving this because you're a customer of {$safeStudio}.<br>
          &copy; {$year} {$safeStudio}. All rights reserved.
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;
    }
}
