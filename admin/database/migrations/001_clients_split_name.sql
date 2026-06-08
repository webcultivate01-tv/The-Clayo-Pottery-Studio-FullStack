-- Migration: split clients.name into first_name + last_name
-- Run this once against the calyo_sms database.

ALTER TABLE `clients`
    CHANGE `name` `first_name` VARCHAR(80) NOT NULL,
    ADD    `last_name` VARCHAR(80) NOT NULL DEFAULT '' AFTER `first_name`;
