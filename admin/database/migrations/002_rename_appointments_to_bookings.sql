-- ============================================================================
-- Migration 002 — Replace appointments with bookings
-- Run this against an EXISTING database that already has the schema from 001.
-- ============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- Drop the old appointments table (no data to keep at this stage)
DROP TABLE IF EXISTS `appointments`;

-- Create the new bookings table
CREATE TABLE IF NOT EXISTS `bookings` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `customer_name`  VARCHAR(150) NOT NULL,
    `phone`          VARCHAR(40)  NOT NULL,
    `email`          VARCHAR(190) DEFAULT NULL,
    `dob`            DATE DEFAULT NULL,
    `address`        TEXT DEFAULT NULL,
    `service`        VARCHAR(200) NOT NULL,
    `preferred_date` DATE NOT NULL,
    `preferred_time` VARCHAR(20)  NOT NULL,
    `message`        TEXT DEFAULT NULL,
    `status`         ENUM('pending','confirmed','completed','cancelled','no_show') NOT NULL DEFAULT 'pending',
    `notes`          TEXT DEFAULT NULL,
    `source`         ENUM('website','admin','phone','walk_in') NOT NULL DEFAULT 'website',
    `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `bookings_status_idx` (`status`),
    KEY `bookings_date_idx` (`preferred_date`),
    KEY `bookings_created_idx` (`created_at`)
) ENGINE=InnoDB;

-- Update files.attachable_type to use 'booking' instead of 'appointment'
ALTER TABLE `files`
    MODIFY COLUMN `attachable_type`
        ENUM('client','project','lead','booking') DEFAULT NULL;

SET FOREIGN_KEY_CHECKS = 1;
