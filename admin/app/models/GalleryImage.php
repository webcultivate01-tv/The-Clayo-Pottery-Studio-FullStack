<?php
declare(strict_types=1);

namespace Calyo\Models;

use Calyo\Core\Model;

final class GalleryImage extends Model
{
    protected string $table = 'gallery_images';

    public function paginate(array $f, int $page, int $perPage = 24): array
    {
        [$where, $params] = $this->buildWhere($f);
        $offset = max(0, ($page - 1) * $perPage);

        $countStmt = $this->db()->prepare("SELECT COUNT(*) FROM gallery_images $where");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $stmt = $this->db()->prepare(
            "SELECT * FROM gallery_images $where ORDER BY sort_order ASC, created_at DESC LIMIT $perPage OFFSET $offset"
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
            $cond[] = '(title LIKE :s1 OR category LIKE :s2)';
            $term   = '%' . $f['search'] . '%';
            $params += [':s1' => $term, ':s2' => $term];
        }
        if (!empty($f['category']) && array_key_exists($f['category'], GalleryCategory::map())) {
            $cond[]              = 'category = :category';
            $params[':category'] = $f['category'];
        }
        if (isset($f['is_active']) && $f['is_active'] !== '') {
            $cond[]               = 'is_active = :is_active';
            $params[':is_active'] = (int) $f['is_active'];
        }

        $where = $cond ? 'WHERE ' . implode(' AND ', $cond) : '';
        return [$where, $params];
    }

    /** Human label for a category slug, falling back to the slug itself. */
    public static function categoryLabel(string $slug): string
    {
        return GalleryCategory::map()[$slug] ?? ucfirst($slug);
    }

    /**
     * Normalize a submitted category to a known slug. Falls back to the first
     * available category (or 'studio') when the submitted slug is unknown.
     */
    public static function normalizeCategory(string $slug): string
    {
        $slug = strtolower(trim($slug));
        $map  = GalleryCategory::map();
        if (array_key_exists($slug, $map)) {
            return $slug;
        }
        return array_key_first($map) ?? 'studio';
    }
}
