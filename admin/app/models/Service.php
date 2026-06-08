<?php
declare(strict_types=1);

namespace Calyo\Models;

use Calyo\Core\Model;

final class Service extends Model
{
    protected string $table = 'services';

    public const TYPES = ['service', 'workshop'];

    public function paginate(array $f, int $page, int $perPage = 20): array
    {
        [$where, $params] = $this->buildWhere($f);
        $offset = max(0, ($page - 1) * $perPage);

        $countStmt = $this->db()->prepare("SELECT COUNT(*) FROM services $where");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $stmt = $this->db()->prepare(
            "SELECT * FROM services $where ORDER BY sort_order ASC, created_at DESC LIMIT $perPage OFFSET $offset"
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

    public function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $base = self::slug($base) ?: 'item';
        $slug = $base;
        $i    = 2;
        while ($this->slugTaken($slug, $ignoreId)) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function slugTaken(string $slug, ?int $ignoreId): bool
    {
        $sql = 'SELECT COUNT(*) FROM services WHERE slug = :slug';
        $params = [':slug' => $slug];
        if ($ignoreId !== null) {
            $sql .= ' AND id <> :id';
            $params[':id'] = $ignoreId;
        }
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return ((int) $stmt->fetchColumn()) > 0;
    }

    private function buildWhere(array $f): array
    {
        $cond   = [];
        $params = [];

        if (!empty($f['search'])) {
            $cond[] = '(title LIKE :s1 OR description LIKE :s2)';
            $term   = '%' . $f['search'] . '%';
            $params += [':s1' => $term, ':s2' => $term];
        }
        if (!empty($f['type']) && in_array($f['type'], self::TYPES, true)) {
            $cond[]          = 'type = :type';
            $params[':type'] = $f['type'];
        }
        if (isset($f['is_active']) && $f['is_active'] !== '') {
            $cond[]               = 'is_active = :is_active';
            $params[':is_active'] = (int) $f['is_active'];
        }

        $where = $cond ? 'WHERE ' . implode(' AND ', $cond) : '';
        return [$where, $params];
    }

    public static function slug(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        return trim($value, '-');
    }
}
