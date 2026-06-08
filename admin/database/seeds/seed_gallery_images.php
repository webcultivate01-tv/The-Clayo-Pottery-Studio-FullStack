<?php
/**
 * Seed gallery images with sample pottery photos
 * Usage: php admin/database/seeds/seed_gallery_images.php
 */
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('ROOT_PATH', dirname(dirname(__DIR__)));
require_once ROOT_PATH . '/core/Autoloader.php';
Calyo\Core\Autoloader::register();

use Calyo\Core\Database;

$db = Database::connection();

$images = [
    // Mugs & Cups
    [
        'title'       => 'Handthrown Terracotta Mugs',
        'category'    => 'mugs',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=800&q=85',
        'sort_order'  => 1,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Ceramic Coffee Cups - Earth Tones',
        'category'    => 'mugs',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1514432324607-2e467f4af445?w=800&q=85',
        'sort_order'  => 2,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Glazed Pottery Mugs Set',
        'category'    => 'mugs',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1563418883-7f51cfeb5d17?w=800&q=85',
        'sort_order'  => 3,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Artisan Ceramic Drinkware',
        'category'    => 'mugs',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800&q=85',
        'sort_order'  => 4,
        'is_active'   => 1,
    ],

    // Bowls
    [
        'title'       => 'Handcrafted Ceramic Bowls',
        'category'    => 'bowls',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=800&q=85',
        'sort_order'  => 1,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Rustic Pottery Serving Bowls',
        'category'    => 'bowls',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800&q=85',
        'sort_order'  => 2,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Glazed Ceramic Nesting Bowls',
        'category'    => 'bowls',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=800&q=85',
        'sort_order'  => 3,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Earthy Tone Pottery Bowls',
        'category'    => 'bowls',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=800&q=85',
        'sort_order'  => 4,
        'is_active'   => 1,
    ],

    // Vases
    [
        'title'       => 'Tall Decorative Ceramic Vase',
        'category'    => 'vases',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=800&q=85',
        'sort_order'  => 1,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Modern Minimalist Pottery Vase',
        'category'    => 'vases',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=800&q=85',
        'sort_order'  => 2,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Textured Ceramic Vase',
        'category'    => 'vases',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800&q=85',
        'sort_order'  => 3,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Hand-Thrown Flower Vase',
        'category'    => 'vases',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1563418883-7f51cfeb5d17?w=800&q=85',
        'sort_order'  => 4,
        'is_active'   => 1,
    ],

    // Sculpture
    [
        'title'       => 'Abstract Ceramic Sculpture',
        'category'    => 'sculpture',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=800&q=85',
        'sort_order'  => 1,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Handcrafted Pottery Art Piece',
        'category'    => 'sculpture',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=800&q=85',
        'sort_order'  => 2,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Contemporary Ceramic Figure',
        'category'    => 'sculpture',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800&q=85',
        'sort_order'  => 3,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Sculptural Pottery Installation',
        'category'    => 'sculpture',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1563418883-7f51cfeb5d17?w=800&q=85',
        'sort_order'  => 4,
        'is_active'   => 1,
    ],

    // Workshop
    [
        'title'       => 'Students at the Pottery Wheel',
        'category'    => 'workshop',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=800&q=85',
        'sort_order'  => 1,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Pottery Workshop Class',
        'category'    => 'workshop',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=800&q=85',
        'sort_order'  => 2,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Expert Guidance in Hand-Building',
        'category'    => 'workshop',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800&q=85',
        'sort_order'  => 3,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Students Creating Their First Pot',
        'category'    => 'workshop',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=800&q=85',
        'sort_order'  => 4,
        'is_active'   => 1,
    ],

    // Studio
    [
        'title'       => 'The Clayo Studio Workspace',
        'category'    => 'studio',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=800&q=85',
        'sort_order'  => 1,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Studio Kilns and Equipment',
        'category'    => 'studio',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=800&q=85',
        'sort_order'  => 2,
        'is_active'   => 1,
    ],
    [
        'title'       => 'The Heart of Our Creative Space',
        'category'    => 'studio',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?w=800&q=85',
        'sort_order'  => 3,
        'is_active'   => 1,
    ],
    [
        'title'       => 'Artisan Workstations',
        'category'    => 'studio',
        'source_type' => 'url',
        'image_url'   => 'https://images.unsplash.com/photo-1563418883-7f51cfeb5d17?w=800&q=85',
        'sort_order'  => 4,
        'is_active'   => 1,
    ],
];

try {
    $insertCount = 0;

    foreach ($images as $img) {
        try {
            $stmt = $db->prepare(
                "INSERT INTO gallery_images (title, category, source_type, image_url, image_path, sort_order, is_active, created_at, updated_at)
                 VALUES (:title, :category, :source_type, :image_url, :image_path, :sort_order, :is_active, NOW(), NOW())"
            );
            $stmt->execute([
                ':title'       => $img['title'],
                ':category'    => $img['category'],
                ':source_type' => $img['source_type'],
                ':image_url'   => $img['image_url'] ?? null,
                ':image_path'  => null,
                ':sort_order'  => $img['sort_order'],
                ':is_active'   => $img['is_active'],
            ]);
            $insertCount++;
        } catch (Exception $e) {
            echo "Error inserting '{$img['title']}': " . $e->getMessage() . "\n";
        }
    }

    echo "\n✓ Successfully seeded gallery with $insertCount images!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
