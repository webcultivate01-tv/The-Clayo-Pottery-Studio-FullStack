-- ============================================================================
-- 006_create_popups.sql
-- Promotional pop-ups shown to visitors when they open the public website
-- (a centered modal with a close button). Managed from the admin panel.
-- Image stored as WebP under project-root /public/uploads/popups/ — image_path
-- is the path relative to the project's public folder
-- (e.g. "uploads/popups/foo.webp").
--
-- A pop-up is shown on the site only when:
--   is_active = 1
--   AND (starts_at IS NULL OR starts_at <= CURDATE())
--   AND (expires_at IS NULL OR expires_at >= CURDATE())
-- When several qualify, the one with the lowest sort_order (then newest) wins.
-- ============================================================================

USE `calyo_sms`;

DROP TABLE IF EXISTS `popups`;
CREATE TABLE `popups` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`         VARCHAR(180) NOT NULL,
    `subtitle`      VARCHAR(180) DEFAULT NULL,
    `description`   TEXT DEFAULT NULL,
    `image_path`    VARCHAR(255) DEFAULT NULL,
    `button_label`  VARCHAR(80)  DEFAULT NULL,
    `button_url`    VARCHAR(255) DEFAULT NULL,
    `starts_at`     DATE DEFAULT NULL,
    `expires_at`    DATE DEFAULT NULL,
    `sort_order`    INT NOT NULL DEFAULT 0,
    `is_active`     TINYINT(1) NOT NULL DEFAULT 1,
    `created_by`    INT UNSIGNED DEFAULT NULL,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `popups_active_idx` (`is_active`),
    KEY `popups_window_idx` (`starts_at`, `expires_at`),
    CONSTRAINT `fk_popups_created_by` FOREIGN KEY (`created_by`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;
