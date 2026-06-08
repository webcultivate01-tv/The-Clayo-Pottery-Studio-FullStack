-- ============================================================================
-- 004_create_events.sql
-- Events shown on the public website. Image stored as WebP under
-- project-root /public/uploads/events/  (image_path is the path relative to
-- the project's public folder, e.g. "uploads/events/foo.webp").
-- ============================================================================

USE `calyo_sms`;

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`        VARCHAR(180) NOT NULL,
    `slug`         VARCHAR(200) NOT NULL,
    `description`  TEXT DEFAULT NULL,
    `image_path`   VARCHAR(255) DEFAULT NULL,
    `event_date`   DATE DEFAULT NULL,
    `event_time`   VARCHAR(40)  DEFAULT NULL,
    `location`     VARCHAR(180) DEFAULT NULL,
    `price`        VARCHAR(80)  DEFAULT NULL,
    `capacity`     VARCHAR(80)  DEFAULT NULL,
    `sort_order`   INT NOT NULL DEFAULT 0,
    `is_active`    TINYINT(1) NOT NULL DEFAULT 1,
    `created_by`   INT UNSIGNED DEFAULT NULL,
    `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `events_slug_unique` (`slug`),
    KEY `events_active_idx` (`is_active`),
    KEY `events_date_idx` (`event_date`),
    CONSTRAINT `fk_events_created_by` FOREIGN KEY (`created_by`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;
