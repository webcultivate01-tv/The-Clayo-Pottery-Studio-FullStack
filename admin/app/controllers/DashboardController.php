<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Database;
use Calyo\Core\Request;

final class DashboardController extends Controller
{
    public function index(Request $request): void
    {
        $db = Database::connection();

        $stats = [
            'total_clients'       => $this->count($db, 'clients'),
            'total_bookings'      => $this->count($db, 'bookings'),
            'pending_bookings'    => $this->count($db, 'bookings', "status = 'pending'"),
            'confirmed_bookings'  => $this->count($db, 'bookings', "status = 'confirmed'"),
            'completed_bookings'  => $this->count($db, 'bookings', "status = 'completed'"),
            'delivered_bookings'  => $this->count($db, 'bookings', "status = 'delivered'"),
            'new_enquiries'       => $this->count($db, 'bookings', "service = 'General Enquiry'"),
            'bookings_this_month' => $this->count($db, 'bookings', "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())"),
            // kept for legacy chart compat
            'active_projects'    => $this->count($db, 'projects', "status = 'active'"),
            'completed_projects' => $this->count($db, 'projects', "status = 'completed'"),
            'pending_tasks'      => 0,
            'team_members'       => $this->count($db, 'employees'),
            'leads_generated'    => $this->count($db, 'leads'),
            'new_inquiries'      => $this->count($db, 'leads', "status = 'new'"),
        ];

        $recentBookings = $this->fetchSafe($db,
            "SELECT id, customer_name, phone, email, service, status,
                    preferred_date, preferred_time, notes, created_at
             FROM bookings ORDER BY created_at DESC LIMIT 5"
        );

        // Monthly bookings for bar chart — last 12 months, exclude enquiries
        $rawMonthly = $this->fetchSafe($db,
            "SELECT DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as cnt
             FROM bookings
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
               AND service != 'General Enquiry'
             GROUP BY ym ORDER BY ym"
        );
        $monthlyBookings = [];
        for ($i = 11; $i >= 0; $i--) {
            $key = date('Y-m', strtotime("-{$i} months"));
            $monthlyBookings[$key] = ['label' => date('M', strtotime("-{$i} months")), 'count' => 0];
        }
        foreach ($rawMonthly as $row) {
            if (isset($monthlyBookings[$row['ym']])) {
                $monthlyBookings[$row['ym']]['count'] = (int) $row['cnt'];
            }
        }

        $sourceCounts = ['website' => 0, 'admin' => 0, 'phone' => 0, 'walk_in' => 0];
        foreach ($this->fetchSafe($db, "SELECT source, COUNT(*) as cnt FROM bookings WHERE source != '' GROUP BY source") as $row) {
            $sourceCounts[$row['source']] = (int) $row['cnt'];
        }

        $this->view('dashboard.index', [
            'title'           => 'Dashboard',
            'stats'           => $stats,
            'recentBookings'  => $recentBookings,
            'monthlyBookings' => array_values($monthlyBookings),
            'sourceCounts'    => $sourceCounts,
        ]);
    }

    private function count(\PDO $db, string $table, string $where = ''): int
    {
        try {
            $sql = "SELECT COUNT(*) FROM {$table}" . ($where ? " WHERE {$where}" : '');
            return (int) $db->query($sql)->fetchColumn();
        } catch (\Throwable) {
            return 0;
        }
    }

    private function fetchSafe(\PDO $db, string $sql): array
    {
        try {
            return $db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable) {
            return [];
        }
    }
}
