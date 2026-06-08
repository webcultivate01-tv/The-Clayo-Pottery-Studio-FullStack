-- ============================================================================
-- Calyo Studio Management System — MySQL Schema (Phase 1)
-- Target: MySQL 5.7+ / MariaDB 10.3+, utf8mb4
-- ============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `calyo_sms`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE `calyo_sms`;

-- ----------------------------------------------------------------------------
-- users — staff accounts that can log in to the admin panel
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`            VARCHAR(120) NOT NULL,
    `email`           VARCHAR(190) NOT NULL,
    `password`        VARCHAR(255) NOT NULL,
    `role`            ENUM('admin','staff') NOT NULL DEFAULT 'staff',
    `is_active`       TINYINT(1) NOT NULL DEFAULT 1,
    `avatar`          VARCHAR(255) DEFAULT NULL,
    `phone`           VARCHAR(40) DEFAULT NULL,
    `last_login_at`   DATETIME DEFAULT NULL,
    `last_login_ip`   VARCHAR(45) DEFAULT NULL,
    `failed_attempts` INT UNSIGNED NOT NULL DEFAULT 0,
    `last_failed_at`  DATETIME DEFAULT NULL,
    `created_at`      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`),
    KEY `users_role_idx` (`role`)
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- clients — agency/studio clients
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(80) NOT NULL,
    `last_name`  VARCHAR(80) NOT NULL DEFAULT '',
    `company`    VARCHAR(150) DEFAULT NULL,
    `email`      VARCHAR(190) DEFAULT NULL,
    `phone`      VARCHAR(40)  DEFAULT NULL,
    `address`    TEXT DEFAULT NULL,
    `notes`      TEXT DEFAULT NULL,
    `status`     ENUM('active','inactive','archived') NOT NULL DEFAULT 'active',
    `created_by` INT UNSIGNED DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `clients_email_idx` (`email`),
    KEY `clients_status_idx` (`status`),
    CONSTRAINT `fk_clients_created_by` FOREIGN KEY (`created_by`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- leads — incoming inquiries / sales pipeline
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `leads`;
CREATE TABLE `leads` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(150) NOT NULL,
    `email`        VARCHAR(190) DEFAULT NULL,
    `phone`        VARCHAR(40)  DEFAULT NULL,
    `source`       VARCHAR(80)  DEFAULT NULL,
    `status`       ENUM('new','contacted','qualified','proposal_sent','won','lost') NOT NULL DEFAULT 'new',
    `notes`        TEXT DEFAULT NULL,
    `next_followup_at` DATETIME DEFAULT NULL,
    `assigned_to`  INT UNSIGNED DEFAULT NULL,
    `converted_client_id` INT UNSIGNED DEFAULT NULL,
    `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `leads_status_idx` (`status`),
    KEY `leads_assigned_idx` (`assigned_to`),
    CONSTRAINT `fk_leads_assigned` FOREIGN KEY (`assigned_to`)
        REFERENCES `users` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_leads_client` FOREIGN KEY (`converted_client_id`)
        REFERENCES `clients` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- employees — team members (separate from login users)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT UNSIGNED DEFAULT NULL,
    `name`       VARCHAR(150) NOT NULL,
    `email`      VARCHAR(190) DEFAULT NULL,
    `phone`      VARCHAR(40)  DEFAULT NULL,
    `job_title` VARCHAR(120) DEFAULT NULL,
    `department` VARCHAR(120) DEFAULT NULL,
    `joined_at` DATE DEFAULT NULL,
    `is_active`  TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `employees_email_idx` (`email`),
    CONSTRAINT `fk_employees_user` FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- projects — studio projects/engagements
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `client_id`    INT UNSIGNED NOT NULL,
    `name`         VARCHAR(180) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `status`       ENUM('planning','active','on_hold','completed','cancelled') NOT NULL DEFAULT 'planning',
    `priority`     ENUM('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
    `progress`     TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `budget`       DECIMAL(12,2) DEFAULT NULL,
    `starts_on`    DATE DEFAULT NULL,
    `due_on`       DATE DEFAULT NULL,
    `completed_at` DATETIME DEFAULT NULL,
    `created_by`   INT UNSIGNED DEFAULT NULL,
    `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `projects_status_idx` (`status`),
    KEY `projects_due_idx` (`due_on`),
    CONSTRAINT `fk_projects_client` FOREIGN KEY (`client_id`)
        REFERENCES `clients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_projects_creator` FOREIGN KEY (`created_by`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- project_members — pivot: which employees are on which project
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `project_members`;
CREATE TABLE `project_members` (
    `project_id`  INT UNSIGNED NOT NULL,
    `employee_id` INT UNSIGNED NOT NULL,
    `role_on_project` VARCHAR(80) DEFAULT NULL,
    `assigned_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`project_id`, `employee_id`),
    CONSTRAINT `fk_pm_project` FOREIGN KEY (`project_id`)
        REFERENCES `projects` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pm_employee` FOREIGN KEY (`employee_id`)
        REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- tasks — work items inside projects
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `project_id` INT UNSIGNED NOT NULL,
    `title`       VARCHAR(200) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `status`      ENUM('todo','in_progress','review','done') NOT NULL DEFAULT 'todo',
    `priority`    ENUM('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
    `assigned_to` INT UNSIGNED DEFAULT NULL,
    `due_on`      DATE DEFAULT NULL,
    `completed_at`DATETIME DEFAULT NULL,
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `tasks_status_idx` (`status`),
    CONSTRAINT `fk_tasks_project` FOREIGN KEY (`project_id`)
        REFERENCES `projects` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_tasks_assignee` FOREIGN KEY (`assigned_to`)
        REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- bookings — workshop / studio session bookings from the public website
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
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
    `status`         ENUM('pending','confirmed','completed','delivered','cancelled','no_show') NOT NULL DEFAULT 'pending',
    `notes`          TEXT DEFAULT NULL,
    `reference_images` TEXT DEFAULT NULL,
    `source`         ENUM('website','admin','phone','walk_in') NOT NULL DEFAULT 'website',
    `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `bookings_status_idx` (`status`),
    KEY `bookings_date_idx` (`preferred_date`),
    KEY `bookings_created_idx` (`created_at`)
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- files — uploaded files attached to clients/projects/leads
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `original_name` VARCHAR(255) NOT NULL,
    `stored_name`   VARCHAR(255) NOT NULL,
    `mime_type`     VARCHAR(120) DEFAULT NULL,
    `size_bytes`    BIGINT UNSIGNED DEFAULT NULL,
    `category`       VARCHAR(60) DEFAULT NULL,
    `attachable_type` ENUM('client','project','lead','booking') DEFAULT NULL,
    `attachable_id`  INT UNSIGNED DEFAULT NULL,
    `version`        INT UNSIGNED NOT NULL DEFAULT 1,
    `uploaded_by`    INT UNSIGNED DEFAULT NULL,
    `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `files_attachable_idx` (`attachable_type`, `attachable_id`),
    CONSTRAINT `fk_files_uploader` FOREIGN KEY (`uploaded_by`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- notifications — in-app notifications for users
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT UNSIGNED NOT NULL,
    `type`       VARCHAR(60) NOT NULL,
    `title`      VARCHAR(200) NOT NULL,
    `body`       TEXT DEFAULT NULL,
    `url`        VARCHAR(255) DEFAULT NULL,
    `read_at`    DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `notif_user_unread_idx` (`user_id`, `read_at`),
    CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- settings — key/value app settings (studio info, theme, email config, etc.)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
    `key_name`   VARCHAR(100) NOT NULL,
    `value`      TEXT DEFAULT NULL,
    `group_name` VARCHAR(60) NOT NULL DEFAULT 'general',
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`key_name`),
    KEY `settings_group_idx` (`group_name`)
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- audit_logs — security / activity audit trail
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE `audit_logs` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT UNSIGNED DEFAULT NULL,
    `action`     VARCHAR(80) NOT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `meta`       JSON DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `audit_user_idx` (`user_id`),
    KEY `audit_action_idx` (`action`),
    CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ----------------------------------------------------------------------------
-- popups — promotional modals shown on the public website (see migration 006)
-- ----------------------------------------------------------------------------
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

-- ----------------------------------------------------------------------------
-- gallery_images — website gallery, managed from the admin panel (see migration 007)
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE `gallery_images` (
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

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================================
-- Seed data — NON-credentialed settings only.
-- The admin user is created by running:
--     php admin/database/seeds/create_admin.php
-- (which generates a real bcrypt hash). See admin/README.md for setup steps.
-- ============================================================================
INSERT INTO `settings` (`key_name`, `value`, `group_name`) VALUES
    ('studio_name',  'Calyo Studio',  'general'),
    ('studio_email', 'hello@calyo.local', 'general'),
    ('theme',        'light',         'appearance');
