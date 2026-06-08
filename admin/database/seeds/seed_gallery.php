<?php
declare(strict_types=1);

/**
 * Seed the gallery_images table with the images that used to be hard-coded in
 * gallery.php, so the public gallery is preserved and the admin can manage them.
 * Idempotent: only seeds when the table is empty.
 *
 * Run from CLI:  php admin/database/seeds/seed_gallery.php
 */

$cfg = require __DIR__ . '/../../config/database.php';
$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $cfg['host'], $cfg['port'] ?? '3306', $cfg['database']);
$pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$count = (int) $pdo->query('SELECT COUNT(*) FROM gallery_images')->fetchColumn();
if ($count > 0) {
    echo "ℹ️  gallery_images already has $count row(s) — skipping seed." . PHP_EOL;
    exit(0);
}

$items = [
    ['Terracotta Handthrown Mugs', 'mugs',      'https://lh3.googleusercontent.com/p/AF1QipMek6DSF0mIfrXIZiRgf0exIC4W2-NcorfnzIm3=s1360-w1360-h1020-rw'],
    ['Clay Throwing Workshop',     'workshop',  'https://lh3.googleusercontent.com/gps-cs-s/APNQkAGJktboAfwbGLOBWSxrFXPQeEJ1Pc3anKv2dkYDbs16CQ3yclvhMxWDmsfvIWsNeG2nSgU1O5hXb9ZowrhY0uR_SfzAsSm1Z32kHUp4i76GNkxuKrQTfORQc-LIXIKEYKXVAUEA34EjVrwk=s1360-w1360-h1020-rw'],
    ['Clay Throwing Workshop',     'workshop',  'https://lh3.googleusercontent.com/gps-cs-s/APNQkAHJNU35qY3KrrpZlzCVbau_fqNdXj6p9kUAfyoKSRBmvhyikNs1IBo489S90GQqNnR6WEdtM8XMTH-Y6FWrOO9xiCfVG4RXcaQoebTnJkaTpBnVIVksi8IE3ULa-VrMu4FgsSuHh3TiE3U=s1360-w1360-h1020-rw'],
    ['Ceramic Serving Bowls',      'bowls',     'https://lh3.googleusercontent.com/gps-cs-s/APNQkAF9VawBHSiFaBLEQBXnRWnR_LRhJGJR_VijNFfCPlZ4etItWmcGma4AVmtdAtIRFQMpqQlFzXT7iao6CvZeFPVOWhaxV9UJBptowveR8rWh1-F5YzEoIB75xdRtjTybanCvsDJJsfbdXbI3=s1360-w1360-h1020-rw'],
    ['Rustic Clay Vases',          'vases',     'https://lh3.googleusercontent.com/p/AF1QipPYEnyKsB8AslgFyIN_RAP2kESwAbeE-_oYTgM3=s1360-w1360-h1020-rw'],
    ['The Clayo Studio Interior',  'studio',    'https://lh3.googleusercontent.com/p/AF1QipPeYONHlNH0PtKmeVIX4MFq8tBLorP6IwIQUGyT=s1360-w1360-h1020-rw'],
    ['Hand Building Class',        'workshop',  'https://lh3.googleusercontent.com/gps-cs-s/APNQkAEuCdpowxDHI6m0z3APLXdCgnBlJZ8yQ-FEpLmm6J7G6lFytOV77WN3gGTLYA-6TVQloMusbl8USNj75J7FpCaUlekV5tY6kPE5RyXJ28UsBELoVZ5PpDcFQeEzv66vHuRtPWvHgIjrTRip=s1360-w1360-h1020-rw'],
    ['Abstract Clay Sculpture',    'sculpture', 'https://lh3.googleusercontent.com/p/AF1QipM8GHMzFOjTtxeNOyKNrFp3zZzkJc1Rr_kQ2gSn=s1360-w1360-h1020-rw'],
    ['Glazed Artisan Mugs',        'mugs',      'https://lh3.googleusercontent.com/gps-cs-s/APNQkAHDkRQjfPsTmv9lsNMYjvFMwSs-0kLsSSevQKygCqHp8xZYCyu1rWmGlAxi4trRndkKJ8T2x0y2VSzaEbE0vYZd4ptooDBSu29_cMJVjYIZgXnChZZvYV15cZMN1iKo40502XMtc1R3VIY=s1360-w1360-h1020-rw'],
    ['Pottery Wheel at Work',      'studio',    'https://lh3.googleusercontent.com/p/AF1QipPMKTbob9-fvJ4X8FvkRdFVR4nWsmtCS0S4WonR=s1360-w1360-h1020-rw'],
    ['Earthy Glaze Bowls',         'bowls',     'https://lh3.googleusercontent.com/gps-cs-s/APNQkAGdXOLQZgVPBbUtxm2nO71n12ExnvbRX6FLm4BWt3hFQTkSej5ap4HNGJMg1rmFw2jezfrS9VK0qR9n0AFKV-5-OGT3U8de3MSwc-suqLWR1MGL86_chSdh8NxfB2XNTlXR0UzbjSqMsFpO=s1360-w1360-h1020-rw'],
    ['Textured Tall Vases',        'vases',     'https://lh3.googleusercontent.com/gps-cs-s/APNQkAG58Zcm4wYH7rdOoAcSTLNSirRqwYBqlvfvP7IBIHR4712NNlj9TbwCKqzQTcE5-WSSS4hZpqvHoGfdD2z4UUjyHRskrkoNEnV-hsqd7RD1nsKeHFiarSRTi2csMpJkYtHhleNBWocpdrs=s1360-w1360-h1020-rw'],
    ['Glazing & Firing Session',   'workshop',  'https://lh3.googleusercontent.com/gps-cs-s/APNQkAG99aSQ5ZuIpYIJEfs1ADjHKmLZZ3yhhH-RLYkITkgLS6sKZn6uNkw_1J1Q5t8bdl0gsC-Db0Rci8u8NVJCrkVznTd2g37tJiKOnMDhGAWOsNHbqy3Q5Jj4LXBSWkXJQfEZMG9q_-eICDZL=s1360-w1360-h1020-rw'],
    ['Kiln Room – The Clayo',      'studio',    'https://lh3.googleusercontent.com/p/AF1QipOlSlJF-kUvoXeXpSzLlITKgVX-0K6eadvGEGEF=s1360-w1360-h1020-rw'],
];

$stmt = $pdo->prepare(
    "INSERT INTO gallery_images (title, category, source_type, image_url, sort_order, is_active)
     VALUES (:title, :category, 'url', :image_url, :sort_order, 1)"
);

$n = 0;
foreach ($items as $i => [$title, $category, $url]) {
    $stmt->execute([
        ':title'      => $title,
        ':category'   => $category,
        ':image_url'  => $url,
        ':sort_order' => $i,
    ]);
    $n++;
}

echo "✅ Seeded $n gallery image(s)." . PHP_EOL;
