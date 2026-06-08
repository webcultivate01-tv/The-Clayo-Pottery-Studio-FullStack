-- ============================================================================
-- 008_create_gallery_categories.sql
-- Gallery categories managed from the admin panel (Admin → Gallery →
-- Manage Categories). Each gallery image references one of these by `slug`.
-- Seeds the six categories that used to be hard-coded in GalleryImage and
-- gallery.php so the public gallery keeps working after the migration.
-- ============================================================================

USE `calyo_sms`;

CREATE TABLE IF NOT EXISTS `gallery_categories` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug`       VARCHAR(40)  NOT NULL,
    `label`      VARCHAR(80)  NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active`  TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `gallery_categories_slug_uniq` (`slug`),
    KEY `gallery_categories_active_idx` (`is_active`),
    KEY `gallery_categories_sort_idx` (`sort_order`)
) ENGINE=InnoDB;

INSERT IGNORE INTO `gallery_categories` (`slug`, `label`, `sort_order`) VALUES
    ('mugs',      'Mugs & Cups', 1),
    ('bowls',     'Bowls',       2),
    ('vases',     'Vases',       3),
    ('sculpture', 'Sculpture',   4),
    ('workshop',  'Workshop',    5),
    ('studio',    'Studio',      6);
