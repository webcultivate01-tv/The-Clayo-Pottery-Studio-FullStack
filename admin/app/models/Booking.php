<?php
declare(strict_types=1);

namespace Calyo\Models;

use Calyo\Core\Model;

final class Booking extends Model
{
    protected string $table = 'bookings';

    /** Hard cap on reference images stored per booking. */
    public const MAX_REFERENCE_IMAGES = 5;

    /** The service value that marks a row as an enquiry rather than a scheduled booking. */
    public const ENQUIRY_SERVICE = 'General Enquiry';

    const WORKSHOP_SERVICES = [
        'Beginner Wheel Throwing Class',
        'Intermediate Wheel Throwing',
        'Advanced Throwing & Trimming',
        'Hand-Building (Coil & Slab)',
        'Kids Pottery Camp (Age 7–14)',
        'Corporate Team Workshop',
        'Couples Pottery Experience',
        'Weekend Intensive (2 Days)',
    ];

    const STUDIO_SERVICES = [
        'Custom Ceramic Piece Order',
        'Open Studio Access',
        'Kiln Firing Service',
        'Private Tuition (1-on-1)',
        'Birthday / Event Package',
        'General Enquiry',
    ];

    public function paginate(array $f, int $page, int $perPage = 20): array
    {
        [$where, $params] = $this->buildWhere($f);
        $offset = max(0, ($page - 1) * $perPage);

        $countStmt = $this->db()->prepare("SELECT COUNT(*) FROM bookings $where");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $stmt = $this->db()->prepare(
            "SELECT * FROM bookings $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset"
        );
        $stmt->execute($params);

        return [
            'data'     => $stmt->fetchAll(),
            'total'    => $total,
            'pages'    => max(1, (int) ceil($total / $perPage)),
            'page'     => $page,
            'per_page' => $perPage,
        ];
    }

    public function filter(array $f): array
    {
        [$where, $params] = $this->buildWhere($f);
        $stmt = $this->db()->prepare("SELECT * FROM bookings $where ORDER BY created_at DESC");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    private function buildWhere(array $f): array
    {
        $cond   = [];
        $params = [];

        if (!empty($f['search'])) {
            $term   = '%' . $f['search'] . '%';
            $cond[] = '(customer_name LIKE :s1 OR phone LIKE :s2 OR email LIKE :s3)';
            $params += [':s1' => $term, ':s2' => $term, ':s3' => $term];
        }
        if (!empty($f['status'])) {
            $cond[]            = 'status = :status';
            $params[':status'] = $f['status'];
        }
        if (!empty($f['source'])) {
            $cond[]            = 'source = :source';
            $params[':source'] = $f['source'];
        }
        if (!empty($f['service_group'])) {
            $services = $f['service_group'] === 'workshop'
                ? self::WORKSHOP_SERVICES
                : self::STUDIO_SERVICES;
            $placeholders = [];
            foreach ($services as $i => $s) {
                $key               = ':sg_' . $i;
                $placeholders[]    = $key;
                $params[$key]      = $s;
            }
            $cond[] = 'service IN (' . implode(',', $placeholders) . ')';
        }
        if (!empty($f['service'])) {
            $cond[]            = 'service = :service';
            $params[':service'] = $f['service'];
        }
        if (!empty($f['exclude_service'])) {
            $cond[]                    = 'service <> :exclude_service';
            $params[':exclude_service'] = $f['exclude_service'];
        }
        if (!empty($f['date_from'])) {
            $cond[]               = 'preferred_date >= :date_from';
            $params[':date_from'] = $f['date_from'];
        }
        if (!empty($f['date_to'])) {
            $cond[]             = 'preferred_date <= :date_to';
            $params[':date_to'] = $f['date_to'];
        }
        if (!empty($f['quick_range']) && $f['quick_range'] !== 'all') {
            [$rangeFrom, $rangeTo] = $this->resolveQuickRange((string) $f['quick_range']);
            if ($rangeFrom !== null) {
                $cond[]                = 'preferred_date >= :range_from';
                $params[':range_from'] = $rangeFrom;
            }
            if ($rangeTo !== null) {
                $cond[]              = 'preferred_date <= :range_to';
                $params[':range_to'] = $rangeTo;
            }
        }
        if (!empty($f['received_range']) && $f['received_range'] !== 'all') {
            [$rFrom, $rTo] = $this->resolveQuickRange((string) $f['received_range']);
            if ($rFrom !== null) {
                $cond[]                  = 'DATE(created_at) >= :rcv_from';
                $params[':rcv_from'] = $rFrom;
            }
            if ($rTo !== null) {
                $cond[]                = 'DATE(created_at) <= :rcv_to';
                $params[':rcv_to'] = $rTo;
            }
        }

        $where = $cond ? 'WHERE ' . implode(' AND ', $cond) : '';
        return [$where, $params];
    }

    /** Map a quick-range key to [from, to] dates (inclusive) for preferred_date. */
    private function resolveQuickRange(string $key): array
    {
        $today = date('Y-m-d');
        return match ($key) {
            'today'      => [$today, $today],
            'tomorrow'   => [date('Y-m-d', strtotime('+1 day')), date('Y-m-d', strtotime('+1 day'))],
            'this_week'  => [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))],
            'this_month' => [date('Y-m-01'), date('Y-m-t')],
            'this_year'  => [date('Y-01-01'), date('Y-12-31')],
            'upcoming'   => [$today, null],
            'past'       => [null, date('Y-m-d', strtotime('-1 day'))],
            default      => [null, null],
        };
    }

    public static function quickRanges(): array
    {
        return [
            'all'        => 'All bookings',
            'today'      => 'Today',
            'tomorrow'   => 'Tomorrow',
            'this_week'  => 'This week',
            'this_month' => 'This month',
            'this_year'  => 'This year',
            'upcoming'   => 'Upcoming',
            'past'       => 'Past',
        ];
    }

    /** Decode the stored JSON list of reference image paths. */
    public static function decodeImages(?string $raw): array
    {
        if (!$raw) return [];
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? array_values(array_filter($decoded, 'is_string')) : [];
    }

    public static function encodeImages(array $paths): ?string
    {
        $paths = array_values(array_filter($paths, 'is_string'));
        return $paths ? json_encode($paths, JSON_UNESCAPED_SLASHES) : null;
    }

    public static function allServices(): array
    {
        return array_merge(self::WORKSHOP_SERVICES, self::STUDIO_SERVICES);
    }

    public static function statusMeta(): array
    {
        return [
            'pending'   => ['label' => 'New Order',     'cls' => 'bg-warn-50 text-warn border-warn/20',         'dot' => '#f59e0b'],
            'confirmed' => ['label' => 'In Production', 'cls' => 'bg-brand-50 text-brand border-brand/20',       'dot' => '#4f46e5'],
            'completed' => ['label' => 'Completed',     'cls' => 'bg-success-50 text-success border-success/20', 'dot' => '#10b981'],
            'delivered' => ['label' => 'Delivered',     'cls' => 'bg-teal-50 text-teal border-teal/20',          'dot' => '#0891b2'],
            'cancelled' => ['label' => 'Cancelled',     'cls' => 'bg-danger-50 text-danger border-danger/20',    'dot' => '#ef4444'],
            'no_show'   => ['label' => 'No Show',       'cls' => 'bg-line-soft text-muted border-line',          'dot' => '#94a3b8'],
        ];
    }

    /**
     * Workflow steps for the inline status dropdown.
     * Order matters — drives the dropdown order in the table.
     */
    public static function workflowStatuses(): array
    {
        return ['pending', 'confirmed', 'completed', 'delivered'];
    }

    public static function sourceMeta(): array
    {
        return [
            'website'  => ['label' => 'Website',   'icon' => 'globe'],
            'admin'    => ['label' => 'Admin',      'icon' => 'shield'],
            'phone'    => ['label' => 'Phone',      'icon' => 'phone'],
            'walk_in'  => ['label' => 'Walk-in',    'icon' => 'footprints'],
        ];
    }
}
