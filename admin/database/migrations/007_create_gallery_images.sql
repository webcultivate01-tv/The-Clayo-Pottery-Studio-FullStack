-- ============================================================================
-- 007_create_gallery_images.sql
-- Website gallery managed from the admin panel (Admin → Gallery).
-- Each image is either UPLOADED from the system (image_path, relative to
-- /public) or referenced by a DIRECT URL (image_url). source_type records
-- which one to render.
-- ============================================================================

USE `calyo_sms`;

CREATE TABLE IF NOT EXISTS `gallery_images` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`       VARCHAR(180) NOT NULL,
    `category`    VARCHAR(40)  NOT NULL DEFAULT 'studio',
    `source_type` ENUM('upload','url') NOT NULL DEFAULT 'upload',
    `image_path`  VARCHAR(255)  DEFAULT NULL,
    `image_url`   VARCHAR(1000) DEFAULT NULL,
    `sort_order`  INT NOT NULL DEFAULT 0,
    `is_active`   TINYINT(1) NOT NULL DEFAULT 1,
    `created_by`  INT UNSIGNED DEFAULT NULL,
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `gallery_active_idx` (`is_active`),
    KEY `gallery_category_idx` (`category`),
    KEY `gallery_sort_idx` (`sort_order`),
    CONSTRAINT `fk_gallery_created_by` FOREIGN KEY (`created_by`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;
