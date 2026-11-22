-- =============================================================================
-- NUAP On-Demand Beverage Delivery Platform
-- Complete Database Schema (MySQL 5.7+ / 8.0+)
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `session_logs`;
DROP TABLE IF EXISTS `config`;
DROP TABLE IF EXISTS `ticket_messages`;
DROP TABLE IF EXISTS `tickets`;
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `balances`;
DROP TABLE IF EXISTS `bank_accounts`;
DROP TABLE IF EXISTS `payu_payments`;
DROP TABLE IF EXISTS `order_products`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `user_locations`;
DROP TABLE IF EXISTS `clients`;
DROP TABLE IF EXISTS `commerces`;
DROP TABLE IF EXISTS `distributors`;
DROP TABLE IF EXISTS `admin_users`;
DROP TABLE IF EXISTS `users`;

-- 1. Users table (Central authentication entity)
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `phone` VARCHAR(10) NOT NULL,
  `phone_validated` TINYINT(1) NOT NULL DEFAULT 0,
  `phone_validated_date` DATETIME NULL DEFAULT NULL,
  `password` VARCHAR(191) NOT NULL,
  `api_token` VARCHAR(80) NULL DEFAULT NULL UNIQUE,
  `status` TINYINT(1) NOT NULL DEFAULT 0,
  `role` ENUM('Administrador', 'Distribuidor', 'Comercio', 'Usuario') NOT NULL DEFAULT 'Usuario',
  `last_logged_in` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_users_role` (`role`),
  INDEX `idx_users_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Admin Users table
CREATE TABLE `admin_users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `last_name` VARCHAR(191) NOT NULL,
  `identity_number` VARCHAR(191) NOT NULL,
  `image_url` VARCHAR(191) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_admin_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Distributors table (Couriers / Delivery Fleet)
CREATE TABLE `distributors` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `business_name` VARCHAR(191) NOT NULL,
  `nit` VARCHAR(191) NOT NULL,
  `second_phone` VARCHAR(191) NOT NULL,
  `commission` DOUBLE NOT NULL DEFAULT 0.0,
  `type` ENUM('Mayorista', 'Distribuidor') NOT NULL DEFAULT 'Distribuidor',
  `name_legal_representative` VARCHAR(191) NOT NULL,
  `cc_legal_representative` VARCHAR(191) NOT NULL,
  `contact_legal_representative` VARCHAR(191) NOT NULL,
  `url_rut` VARCHAR(191) NULL DEFAULT NULL,
  `url_commerce_room` VARCHAR(191) NULL DEFAULT NULL,
  `url_cc_legal_representative` VARCHAR(191) NULL DEFAULT NULL,
  `url_establishment_image` VARCHAR(191) NULL DEFAULT NULL,
  `url_interior_image` VARCHAR(191) NULL DEFAULT NULL,
  `url_contract` VARCHAR(191) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_distributor_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Commerces table (Partner Beverage & Liquor Stores / Bodegas)
CREATE TABLE `commerces` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `business_name` VARCHAR(191) NOT NULL,
  `nit` VARCHAR(191) NOT NULL,
  `second_phone` VARCHAR(191) NOT NULL,
  `commission` DOUBLE NOT NULL DEFAULT 0.0,
  `type` ENUM(
    'Cigarreria',
    'Drogueria',
    'Ferreteria',
    'Licorera',
    'Miscelanea',
    'Mini mercado',
    'Prestador de servicios',
    'Profesional independiente',
    'Supermercado'
  ) NOT NULL DEFAULT 'Licorera',
  `name_legal_representative` VARCHAR(191) NOT NULL,
  `cc_legal_representative` VARCHAR(191) NOT NULL,
  `contact_legal_representative` VARCHAR(191) NOT NULL,
  `url_rut` VARCHAR(191) NULL DEFAULT NULL,
  `url_commerce_room` VARCHAR(191) NULL DEFAULT NULL,
  `url_cc_legal_representative` VARCHAR(191) NULL DEFAULT NULL,
  `url_establishment_image` VARCHAR(191) NULL DEFAULT NULL,
  `url_interior_image` VARCHAR(191) NULL DEFAULT NULL,
  `url_contract` VARCHAR(191) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_commerce_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Clients table (End Consumer Profile)
CREATE TABLE `clients` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `last_name` VARCHAR(191) NOT NULL,
  `identity_number` VARCHAR(191) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_client_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. User Locations table (GPS Delivery Addresses)
CREATE TABLE `user_locations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `city` VARCHAR(191) NOT NULL,
  `location` VARCHAR(191) NOT NULL,
  `neighborhood` VARCHAR(191) NOT NULL,
  `address` VARCHAR(191) NOT NULL,
  `latitude` VARCHAR(191) NOT NULL,
  `longitude` VARCHAR(191) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_user_locations_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Categories table (Beverage Taxonomy)
CREATE TABLE `categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `parent_id` INT UNSIGNED NOT NULL DEFAULT 0,
  `name` VARCHAR(191) NOT NULL,
  `description` VARCHAR(191) NOT NULL,
  `image` VARCHAR(191) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_categories_parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Products table (Beverage & Grocery Catalog)
CREATE TABLE `products` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `brand` VARCHAR(191) NOT NULL,
  `description` VARCHAR(191) NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `stock` INT NOT NULL DEFAULT 0,
  `weight` DOUBLE NOT NULL DEFAULT 0,
  `length` DOUBLE NOT NULL DEFAULT 0,
  `width` DOUBLE NOT NULL DEFAULT 0,
  `height` DOUBLE NOT NULL DEFAULT 0,
  `purchase_price` DOUBLE NOT NULL DEFAULT 0,
  `sale_price` DOUBLE NOT NULL DEFAULT 0,
  `special_price` DOUBLE NOT NULL DEFAULT 0,
  `has_special_price` TINYINT(1) NOT NULL DEFAULT 0,
  `image` VARCHAR(191) NOT NULL,
  `position` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_products_user_id` (`user_id`),
  INDEX `idx_products_category_id` (`category_id`),
  INDEX `idx_products_featured` (`is_featured`),
  INDEX `idx_products_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Orders table (Deliveries & Transactions)
CREATE TABLE `orders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `user_type` VARCHAR(191) NOT NULL,
  `status` ENUM('Iniciado', 'Aceptado', 'Alistamiento', 'Circulacion', 'Entregado', 'Cancelado') NOT NULL DEFAULT 'Iniciado',
  `cancel_reason` VARCHAR(191) NULL DEFAULT NULL,
  `client_id` INT UNSIGNED NOT NULL,
  `client_type` VARCHAR(191) NOT NULL,
  `total_products` INT NOT NULL DEFAULT 1,
  `total_amount` DOUBLE NOT NULL DEFAULT 0,
  `delivery_amount` DOUBLE NOT NULL DEFAULT 0,
  `total_discount` DOUBLE NOT NULL DEFAULT 0,
  `total` DOUBLE NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_orders_user` (`user_id`),
  INDEX `idx_orders_client` (`client_id`),
  INDEX `idx_orders_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Order Products table
CREATE TABLE `order_products` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `price` DOUBLE NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_order_products_order` (`order_id`),
  INDEX `idx_order_products_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. PayU Payments table (Payment Gateway Webhooks & Transactions)
CREATE TABLE `payu_payments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_payu_payments_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Bank Accounts table (Payouts for Commerces and Couriers)
CREATE TABLE `bank_accounts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `user_type` VARCHAR(191) NOT NULL,
  `owner_name` VARCHAR(191) NOT NULL,
  `owner_document` VARCHAR(191) NOT NULL,
  `account` VARCHAR(191) NOT NULL,
  `account_type` VARCHAR(191) NOT NULL,
  `bank` VARCHAR(191) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_bank_accounts_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Balances table
CREATE TABLE `balances` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `user_type` VARCHAR(191) NOT NULL,
  `balance` DOUBLE NOT NULL DEFAULT 0,
  `paid_out` DOUBLE NOT NULL DEFAULT 0,
  `total` DOUBLE NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_balances_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Payments table (Commerce Payout Requests & Disbursements)
CREATE TABLE `payments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `user_type` VARCHAR(191) NOT NULL,
  `account_id` INT UNSIGNED NOT NULL,
  `value` DOUBLE NOT NULL DEFAULT 0,
  `request_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_date` DATETIME NULL DEFAULT NULL,
  `status` ENUM('Pendiente', 'Aprobado', 'Cancelado') NOT NULL DEFAULT 'Pendiente',
  `voucher` VARCHAR(191) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_payments_user` (`user_id`),
  INDEX `idx_payments_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Tickets table (Customer & Store Support Tickets)
CREATE TABLE `tickets` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `user_type` VARCHAR(191) NOT NULL,
  `issues` VARCHAR(191) NOT NULL,
  `init_date` DATE NOT NULL,
  `finish_date` DATE NOT NULL,
  `is_closed` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_tickets_user` (`user_id`),
  INDEX `idx_tickets_closed` (`is_closed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. Ticket Messages table (Support Chat Threads)
CREATE TABLE `ticket_messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `ticket_id` INT UNSIGNED NOT NULL,
  `message` VARCHAR(191) NOT NULL,
  `sender_id` INT UNSIGNED NOT NULL,
  `sender_type` VARCHAR(191) NOT NULL,
  `sender_date` DATE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_ticket_messages_ticket` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 17. Config table (Dynamic Logistics Distance & Shipping Calculation)
CREATE TABLE `config` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `shipping_cost` DOUBLE NOT NULL DEFAULT 3500.0,
  `distance` DOUBLE NOT NULL DEFAULT 5.0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 18. Session Logs table (Audit Trails & Activity Logs)
CREATE TABLE `session_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `user_type` VARCHAR(191) NOT NULL,
  `login_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_session_logs_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
