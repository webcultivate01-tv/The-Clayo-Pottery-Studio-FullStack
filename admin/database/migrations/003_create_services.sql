-- ============================================================================
-- 003_create_services.sql
-- Services & Workshops shown on the public website. Image stored as WebP under
-- project-root /public/uploads/services/  (image_path is the path relative to
-- the project's public folder, e.g. "uploads/services/foo.webp").
-- ============================================================================

USE `calyo_sms`;

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `type`        ENUM('service','workshop') NOT NULL DEFAULT 'service',
    `title`       VARCHAR(180) NOT NULL,
    `slug`        VARCHAR(200) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `image_path`  VARCHAR(255) DEFAULT NULL,
    `price`       VARCHAR(80)  DEFAULT NULL,
    `duration`    VARCHAR(80)  DEFAULT NULL,
    `sort_order`  INT NOT NULL DEFAULT 0,
    `is_active`   TINYINT(1) NOT NULL DEFAULT 1,
    `created_by`  INT UNSIGNED DEFAULT NULL,
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `services_slug_unique` (`slug`),
    KEY `services_type_idx` (`type`),
    KEY `services_active_idx` (`is_active`),
    CONSTRAINT `fk_services_created_by` FOREIGN KEY (`created_by`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;
