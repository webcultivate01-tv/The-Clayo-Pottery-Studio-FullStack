<?php
declare(strict_types=1);

namespace Calyo\Models;

use Calyo\Core\Model;

final class Popup extends Model
{
    protected string $table = 'popups';

    public function paginate(array $f, int $page, int $perPage = 20): array
    {
        [$where, $params] = $this->buildWhere($f);
        $offset = max(0, ($page - 1) * $perPage);

        $countStmt = $this->db()->prepare("SELECT COUNT(*) FROM popups $where");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $stmt = $this->db()->prepare(
            "SELECT * FROM popups $where ORDER BY sort_order ASC, created_at DESC LIMIT $perPage OFFSET $offset"
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

    private function buildWhere(array $f): array
    {
        $cond   = [];
        $params = [];

        if (!empty($f['search'])) {
            $cond[] = '(title LIKE :s1 OR subtitle LIKE :s2 OR description LIKE :s3)';
            $term   = '%' . $f['search'] . '%';
            $params += [':s1' => $term, ':s2' => $term, ':s3' => $term];
        }
        if (isset($f['is_active']) && $f['is_active'] !== '') {
            $cond[]               = 'is_active = :is_active';
            $params[':is_active'] = (int) $f['is_active'];
        }
        if (!empty($f['when'])) {
            if ($f['when'] === 'live') {
                $cond[] = 'is_active = 1 AND (starts_at IS NULL OR starts_at <= CURDATE()) AND (expires_at IS NULL OR expires_at >= CURDATE())';
            } elseif ($f['when'] === 'expired') {
                $cond[] = '(expires_at IS NOT NULL AND expires_at < CURDATE())';
            } elseif ($f['when'] === 'scheduled') {
                $cond[] = '(starts_at IS NOT NULL AND starts_at > CURDATE())';
            }
        }

        $where = $cond ? 'WHERE ' . implode(' AND ', $cond) : '';
        return [$where, $params];
    }
}
