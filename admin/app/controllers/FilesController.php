<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Database;
use Calyo\Models\Booking;

final class FilesController extends Controller
{
    public function index(): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->query("
            SELECT id, customer_name, phone, email, service,
                   preferred_date, preferred_time, reference_images,
                   status, updated_at, created_at
            FROM bookings
            WHERE status = 'delivered'
              AND reference_images IS NOT NULL
              AND reference_images <> ''
              AND reference_images <> '[]'
            ORDER BY updated_at DESC, id DESC
        ");
        $rows = $stmt->fetchAll();

        $bookings    = [];
        $totalImages = 0;
        foreach ($rows as $row) {
            $images = Booking::decodeImages($row['reference_images'] ?? null);
            if (empty($images)) continue;
            $row['images'] = $images;
            $bookings[]    = $row;
            $totalImages  += count($images);
        }

        $this->view('files.index', [
            'title'       => 'Files',
            'bookings'    => $bookings,
            'totalImages' => $totalImages,
        ]);
    }
}
