<?php
declare(strict_types=1);

namespace Calyo\Models;

use Calyo\Core\Database;
use Calyo\Core\Model;
use PDO;
use Throwable;

final class GalleryCategory extends Model
{
    protected string $table = 'gallery_categories';

    /**
     * Built-in fallback used before the table exists or while it is empty
     * (e.g. before migration 008 has been applied). Keep in sync with the
     * seed rows in 008_create_gallery_categories.sql.
     */
    public const DEFAULTS = [
        'mugs'      => 'Mugs & Cups',
        'bowls'     => 'Bowls',
        'vases'     => 'Vases',
        'sculpture' => 'Sculpture',
        'workshop'  => 'Workshop',
        'studio'    => 'Studio',
    ];

    /** Cache of map() results within a request, keyed by active-only flag. */
    private static array $mapCache = [];

    /** All categories as full rows, ordered for display. */
    public function ordered(bool $activeOnly = false): array
    {
        $sql = "SELECT * FROM {$this->table}"
             . ($activeOnly ? ' WHERE is_active = 1' : '')
             . ' ORDER BY sort_order ASC, label ASC';
        return $this->db()->query($sql)->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch() ?: null;
    }

    /** How many gallery images currently use a category slug. */
    public function imageCount(string $slug): int
    {
        $stmt = $this->db()->prepare('SELECT COUNT(*) FROM gallery_images WHERE category = :slug');
        $stmt->execute([':slug' => $slug]);
        return (int) $stmt->fetchColumn();
    }

    /** Image counts for every slug in one query: [slug => count]. */
    public function imageCounts(): array
    {
        $rows = $this->db()
            ->query('SELECT category, COUNT(*) AS n FROM gallery_images GROUP BY category')
            ->fetchAll();
        $out = [];
        foreach ($rows as $r) {
            $out[(string) $r['category']] = (int) $r['n'];
        }
        return $out;
    }

    /** Re-point gallery images from an old category slug to a new one. */
    public function renameOnImages(string $oldSlug, string $newSlug): void
    {
        if ($oldSlug === $newSlug) return;
        $stmt = $this->db()->prepare('UPDATE gallery_images SET category = :new WHERE category = :old');
        $stmt->execute([':new' => $newSlug, ':old' => $oldSlug]);
    }

    /**
     * slug => label map, ordered. Reads from the DB and falls back to the
     * built-in defaults if the table is missing or empty. Cached per request.
     */
    public static function map(bool $activeOnly = false): array
    {
        $key = $activeOnly ? '1' : '0';
        if (isset(self::$mapCache[$key])) {
            return self::$mapCache[$key];
        }

        try {
            $sql = 'SELECT slug, label FROM gallery_categories'
                 . ($activeOnly ? ' WHERE is_active = 1' : '')
                 . ' ORDER BY sort_order ASC, label ASC';
            $rows = Database::connection()->query($sql)->fetchAll(PDO::FETCH_KEY_PAIR);
            if ($rows) {
                return self::$mapCache[$key] = $rows;
            }
        } catch (Throwable $e) {
            // table not migrated yet — fall through to defaults
        }

        return self::$mapCache[$key] = self::DEFAULTS;
    }

    /** Turn an arbitrary label/input into a url-safe slug. */
    public static function slugify(string $value): string
    {
        $slug = strtolower(trim($value));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
        return trim($slug, '-');
    }
}
