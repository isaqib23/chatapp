-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 22, 2019 at 03:51 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Test Book 1', '2019-09-12 15:04:54', '2019-09-12 15:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `type` enum('open','closed','selected') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `price`, `category_id`, `type`, `photo`, `user_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Test Group 11', '200', 1, 'open', 'bc5e8356f7ee49fb23c01aefb0058b05.jpg', 2, 'sdsad', '2019-09-19 12:13:57', '2019-09-19 16:14:33'),
(2, 'Test Group 1', '200', 1, 'open', '8dc9076eff125a4b825ed5631b9c180c.jpg', 1, 'sdsad', '2019-09-19 12:14:03', '2019-09-19 12:14:03'),
(3, 'Test Group 3', '200', 1, 'open', 'f854780b03ecbfc42905eb66728e3d02.jpg', 1, 'sdsad', '2019-09-19 12:14:09', '2019-09-19 12:14:09'),
(4, 'Test Group', '200', 1, 'open', 'e2c5f05bb44dc2375d96d087d831281a.jpg', 2, 'sdsad', '2019-09-19 12:14:16', '2019-09-19 12:14:16'),
(5, 'Test Group 5', '200', 1, 'open', 'f0d959ffe6823085a76b468c39be5a74.jpg', 2, 'sdsad', '2019-09-19 12:14:21', '2019-09-19 12:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

DROP TABLE IF EXISTS `group_users`;
CREATE TABLE IF NOT EXISTS `group_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `can_send_text` enum('yes','no') NOT NULL,
  `status` enum('join','leave','remove') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_users`
--

INSERT INTO `group_users` (`id`, `group_id`, `user_id`, `can_send_text`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'yes', 'join', '2019-09-19 13:18:04', '2019-09-19 13:18:04'),
(2, 5, 1, 'yes', 'join', '2019-09-19 13:53:49', '2019-09-19 13:53:49'),
(3, 2, 2, 'yes', 'join', '2019-09-21 06:16:20', '2019-09-21 06:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `message` longtext NOT NULL,
  `text_type` enum('text','image','audio','video') NOT NULL,
  `type` enum('single','group') NOT NULL,
  `status` enum('unseen','seen') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_05_093234_create_permission_tables', 1),
(9, '2019_08_06_100453_add_new_culumns_in_users', 1),
(10, '2019_08_08_042618_update_reset_password_table', 1),
(11, '2019_08_08_042939_update_columns_reset_password_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0cfb2675590dbb78c1960c2d0fb39c6d8cf8f20d347fe01e48079e5e8240560add10341640b52c8d', 2, 3, 'Personal Access Token', '[]', 0, '2019-08-30 12:48:22', '2019-08-30 12:48:22', '2020-08-30 17:48:22'),
('4b4daf8ffe233203c80b24e16b55b976fa1e98f5df037a37dfa5021757d081b4031d43e70413a230', 1, 3, 'Personal Access Token', '[]', 0, '2019-09-11 08:55:07', '2019-09-11 08:55:07', '2020-09-11 13:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'jelnkHPDe5rAl9OYYx30IL3DHjD0LhghYqPUbfJK', 'http://localhost', 1, 0, 0, '2019-08-27 09:12:46', '2019-08-27 09:12:46'),
(2, NULL, 'Laravel Password Grant Client', 'yDC8uSnHSKl4hy4jKunWPEcFbthOoulZsKEoYYTs', 'http://localhost', 0, 1, 0, '2019-08-27 09:12:46', '2019-08-27 09:12:46'),
(3, NULL, 'Laravel Personal Access Client', 'q96MMZ5FuciTkHcPXYQ9qrYGg4t1TC8GsXa8Ium2', 'http://localhost', 1, 0, 0, '2019-08-27 09:12:58', '2019-08-27 09:12:58'),
(4, NULL, 'Laravel Password Grant Client', 'EPa2mLE1xnA6MG1LYhP3Ww1I2k47KFSFp97HKkFV', 'http://localhost', 0, 1, 0, '2019-08-27 09:12:58', '2019-08-27 09:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-08-27 09:12:46', '2019-08-27 09:12:46'),
(2, 3, '2019-08-27 09:12:58', '2019-08-27 09:12:58');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`, `updated_at`) VALUES
(1, 'isaqib23@gmail.com', '$2y$10$hsc9rNHEzx1CRw6vcpWp1OsRwqMPO5o9Dn.pGwgiw.sea.BYvCM/u', '2019-08-29 10:34:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `plan_id` varchar(255) NOT NULL,
  `subscription_id` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `card_expiry` varchar(255) NOT NULL,
  `card_digits` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `next_charge_date` varchar(255) NOT NULL,
  `status` enum('active','expired','cancelled') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `group_id`, `user_id`, `customer_id`, `plan_id`, `subscription_id`, `transaction_id`, `amount`, `card_number`, `card_expiry`, `card_digits`, `product_id`, `next_charge_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'cus_Fq5hKERp2I87Vf', 'plan_Fq5hpzilcazypy', 'sub_Fq5htOzL1MwC4b', 'ch_1FKPWIJB8LH5cIrZ0t2dpNfH', '200', 'card_1FKPWGJB8LH5cIrZ4ZRy8dMI', '9/2020', '4242', 'prod_Fq5hO6LA1Iwb8m', '1571494683', 'active', '2019-09-19 13:18:04', '2019-09-19 13:18:04'),
(2, 5, 1, 'cus_Fq6HjoEEO3OBGn', 'plan_Fq6HiKKGCOKN3P', 'sub_Fq6HYGviA9RBMx', 'ch_1FKQ4sJB8LH5cIrZ3NAhKnz9', '200', 'card_1FKQ4qJB8LH5cIrZp6w2xtAI', '9/2020', '4242', 'prod_Fq6Hl1WbUJGVhC', '1571496827', 'cancelled', '2019-09-19 13:53:49', '2019-09-19 13:54:23'),
(3, 2, 2, 'cus_FqjLO2frX0nRyW', 'plan_FqjLZHxIHbSyKD', 'sub_FqjLV0utqvGxxv', 'ch_1FL1tFJB8LH5cIrZ7fyHkP3i', '200', 'card_1FL1tDJB8LH5cIrZgI5LLU7b', '9/2020', '4242', 'prod_FqjLTjvxNPXvKL', '1571642178', 'active', '2019-09-21 06:16:20', '2019-09-21 06:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activation_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `type`, `phone`, `address`, `photo`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `active`, `activation_token`, `deleted_at`) VALUES
(1, 'Mahtab', 'Ali', 'caiocalimann@gmail.com', 'member', '123456', 'Islamabad, Pakistan', 'e309621adcf34dd3942449fb0ddf0a21.jpg', NULL, '$2y$10$TK.xjfqUBXsFFkvsepXTHuBzn2s8eIxA0F8NXBPWKrJcuzdSbfRr6', NULL, '2019-09-19 07:12:53', '2019-09-19 07:12:53', 0, 'iWyBxVPigK79YUSlHBgH4S6LHRVILQPKZfyxOE7MvGWOLQ2IExOLbgTnujUf', NULL),
(2, 'Mahtab', 'Khan', 'caiocalimann@gmail.com1', 'member', '123456', 'Islamabad, Pakistan', '203bd42e22f721a62c1bc022300f14b6.jpg', NULL, '$2y$10$VkRBfEG0EauKbCsIyG/UOeyENHgkM9TKB.kwSfNgaI0pVBjKM7KTm', NULL, '2019-09-19 07:13:37', '2019-09-19 07:13:37', 0, 'jaXFeFBQwbBVbKPgt4Y3YRubfs6NSnv4tf89SOSeWG9cEqHZbhobE1jiCI1e', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percentage` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` enum('active','de-active') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `percentage`, `code`, `user_id`, `group_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 20, 'WdL8WycDUc', 2, 4, 'active', '2019-09-19 13:00:38', '2019-09-19 13:00:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
