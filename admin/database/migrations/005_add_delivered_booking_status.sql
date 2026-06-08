-- ============================================================================
-- 005_add_delivered_booking_status.sql
-- Adds 'delivered' to the bookings.status ENUM.
-- Workflow: pending → confirmed → completed → delivered
-- 'delivered' means the product is ready, customer has been called,
-- and the customer has come in to pick up the order.
-- ============================================================================

USE `calyo_sms`;

ALTER TABLE `bookings`
    MODIFY COLUMN `status`
        ENUM('pending','confirmed','completed','delivered','cancelled','no_show')
        NOT NULL DEFAULT 'pending';
