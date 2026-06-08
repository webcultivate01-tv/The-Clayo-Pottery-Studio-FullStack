<?php
declare(strict_types=1);

namespace Calyo\Models;

use Calyo\Core\Model;

final class Client extends Model
{
    protected string $table = 'clients';

    public function paginate(array $f, int $page, int $perPage = 20): array
    {
        [$where, $params] = $this->buildWhere($f);
        $offset = max(0, ($page - 1) * $perPage);

        $countStmt = $this->db()->prepare("SELECT COUNT(*) FROM clients $where");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $stmt = $this->db()->prepare(
            "SELECT * FROM clients $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset"
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
        $stmt = $this->db()->prepare("SELECT * FROM clients $where ORDER BY created_at DESC");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    private function buildWhere(array $f): array
    {
        $cond   = [];
        $params = [];

        if (!empty($f['search'])) {
            $cond[] = '(first_name LIKE :s1 OR last_name LIKE :s2 OR email LIKE :s3 OR phone LIKE :s4 OR company LIKE :s5)';
            $term   = '%' . $f['search'] . '%';
            $params += [':s1' => $term, ':s2' => $term, ':s3' => $term, ':s4' => $term, ':s5' => $term];
        }
        if (!empty($f['status'])) {
            $cond[]           = 'status = :status';
            $params[':status'] = $f['status'];
        }
        if (!empty($f['date_from'])) {
            $cond[]              = 'DATE(created_at) >= :date_from';
            $params[':date_from'] = $f['date_from'];
        }
        if (!empty($f['date_to'])) {
            $cond[]            = 'DATE(created_at) <= :date_to';
            $params[':date_to'] = $f['date_to'];
        }

        $where = $cond ? 'WHERE ' . implode(' AND ', $cond) : '';
        return [$where, $params];
    }

    public static function fullName(array $c): string
    {
        return trim(($c['first_name'] ?? '') . ' ' . ($c['last_name'] ?? ''));
    }

    public static function initials(array $c): string
    {
        $f = strtoupper(substr($c['first_name'] ?? '', 0, 1));
        $l = strtoupper(substr($c['last_name'] ?? '', 0, 1));
        return ($f . $l) ?: 'CL';
    }

    public static function waPhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone);
    }
}
