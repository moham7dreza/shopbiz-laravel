-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 07, 2023 at 04:44 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopbiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `city_id` bigint UNSIGNED NOT NULL,
  `province_id` bigint UNSIGNED NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `recipient_first_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `recipient_last_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  KEY `addresses_city_id_foreign` (`city_id`),
  KEY `addresses_province_id_foreign` (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `amazing_sales`
--

DROP TABLE IF EXISTS `amazing_sales`;
CREATE TABLE IF NOT EXISTS `amazing_sales` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `percentage` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `amazing_sales_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
CREATE TABLE IF NOT EXISTS `attributes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` tinyint NOT NULL DEFAULT '0',
  `unit` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `type`, `unit`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'صفحه نمایش', 0, 'اینچ', 1, '2023-02-07 16:33:15', '2023-02-07 16:33:15', NULL),
(2, 'حافظه رم', 0, 'گیگابایت', 1, '2023-02-07 16:33:37', '2023-02-07 16:33:37', NULL),
(3, 'نوع صفحه نمایش', 0, 'پنل', 1, '2023-02-07 16:34:11', '2023-02-07 16:34:11', NULL),
(4, 'اندازه باتری', 0, 'میلی امپر', 1, '2023-02-07 16:34:38', '2023-02-07 16:34:38', NULL),
(5, 'دوربین', 0, 'مگاپیکسل', 1, '2023-02-07 16:35:14', '2023-02-07 16:35:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attribute_category`
--

DROP TABLE IF EXISTS `attribute_category`;
CREATE TABLE IF NOT EXISTS `attribute_category` (
  `attribute_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`attribute_id`,`category_id`),
  KEY `attribute_category_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attribute_category`
--

INSERT INTO `attribute_category` (`attribute_id`, `category_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `attribute_default_values`
--

DROP TABLE IF EXISTS `attribute_default_values`;
CREATE TABLE IF NOT EXISTS `attribute_default_values` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_default_values_attribute_id_foreign` (`attribute_id`),
  KEY `attribute_default_values_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

DROP TABLE IF EXISTS `attribute_values`;
CREATE TABLE IF NOT EXISTS `attribute_values` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `value` text COLLATE utf8mb4_general_ci NOT NULL,
  `type` tinyint NOT NULL DEFAULT '0' COMMENT 'value type is 0 => simple, 1 => multi values select by customers (affected on price)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_values_product_id_foreign` (`product_id`),
  KEY `attribute_values_attribute_id_foreign` (`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE IF NOT EXISTS `banners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` text COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `persian_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `persian_name`, `original_name`, `slug`, `logo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'سامسونگ', 'Samsung', 'Samsung', '\"images\\\\brand\\\\2023\\\\02\\\\07\\\\1675779968.png\"', 1, '2023-02-07 14:26:08', '2023-02-07 14:26:08', NULL),
(2, 'اپل', 'apple', 'apple', '\"images\\\\brand\\\\2023\\\\02\\\\07\\\\1675779991.png\"', 1, '2023-02-07 14:26:31', '2023-02-07 14:26:31', NULL),
(3, 'جی پلاس', 'Gplus', 'Gplus', '\"images\\\\brand\\\\2023\\\\02\\\\07\\\\1675780041.jpg\"', 1, '2023-02-07 14:27:21', '2023-02-07 14:27:21', NULL),
(4, 'هواوی', 'huawei', 'huawei', '\"images\\\\brand\\\\2023\\\\02\\\\07\\\\1675780092.jpg\"', 1, '2023-02-07 14:28:12', '2023-02-07 14:28:12', NULL),
(5, 'لاجیتک', 'logitech', 'logitech', '\"images\\\\brand\\\\2023\\\\02\\\\07\\\\1675780126.jpg\"', 1, '2023-02-07 14:28:46', '2023-02-07 14:28:46', NULL),
(6, 'شیائومی', 'xiaomi', 'xiaomi', '\"images\\\\brand\\\\2023\\\\02\\\\07\\\\1675780277.png\"', 1, '2023-02-07 14:31:17', '2023-02-07 14:31:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `guarantee_id` bigint UNSIGNED DEFAULT NULL,
  `number` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_user_id_foreign` (`user_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  KEY `cart_items_color_id_foreign` (`color_id`),
  KEY `cart_items_guarantee_id_foreign` (`guarantee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_item_selected_attributes`
--

DROP TABLE IF EXISTS `cart_item_selected_attributes`;
CREATE TABLE IF NOT EXISTS `cart_item_selected_attributes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_item_id` bigint UNSIGNED NOT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `attribute_value_id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_item_selected_attributes_cart_item_id_foreign` (`cart_item_id`),
  KEY `cart_item_selected_attributes_attribute_id_foreign` (`attribute_id`),
  KEY `cart_item_selected_attributes_attribute_value_id_foreign` (`attribute_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_payments`
--

DROP TABLE IF EXISTS `cash_payments`;
CREATE TABLE IF NOT EXISTS `cash_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` decimal(20,3) NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `cash_receiver` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pay_date` timestamp NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cash_payments_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `province_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_province_id_foreign` (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=473 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `body` text COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `commentable_id` bigint UNSIGNED NOT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `seen` tinyint NOT NULL DEFAULT '0' COMMENT '0 => unseen, 1 => seen',
  `approved` tinyint NOT NULL DEFAULT '0' COMMENT '0 => not approved, 1 => approved',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  KEY `comments_author_id_foreign` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `common_discount`
--

DROP TABLE IF EXISTS `common_discount`;
CREATE TABLE IF NOT EXISTS `common_discount` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `percentage` int NOT NULL,
  `discount_ceiling` bigint UNSIGNED DEFAULT NULL,
  `minimal_order_amount` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `copans`
--

DROP TABLE IF EXISTS `copans`;
CREATE TABLE IF NOT EXISTS `copans` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `amount_type` tinyint NOT NULL DEFAULT '0' COMMENT '0 => percentage, 1 => price unit',
  `discount_ceiling` bigint UNSIGNED DEFAULT NULL,
  `type` tinyint NOT NULL DEFAULT '0' COMMENT '0 => common (each user can use one time), 1 => private (one user can use one time)',
  `status` tinyint NOT NULL DEFAULT '0',
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uses` bigint NOT NULL DEFAULT '0' COMMENT 'number of times can be used bu user',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `copans_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `capital_city` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `capital_city`, `name`, `name_en`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 88, 'ایران', 'iran', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

DROP TABLE IF EXISTS `delivery`;
CREATE TABLE IF NOT EXISTS `delivery` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(20,3) DEFAULT NULL,
  `delivery_time` int DEFAULT NULL,
  `delivery_time_unit` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faqs_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'user_id',
  `favoriteable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `favoriteable_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favorites_favoriteable_type_favoriteable_id_index` (`favoriteable_type`,`favoriteable_id`),
  KEY `favorites_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guarantees`
--

DROP TABLE IF EXISTS `guarantees`;
CREATE TABLE IF NOT EXISTS `guarantees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `price_increase` decimal(20,3) NOT NULL DEFAULT '0.000',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guarantees_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guarantees`
--

INSERT INTO `guarantees` (`id`, `name`, `duration`, `product_id`, `price_increase`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'الماس رایان ایرانیان', NULL, 8, '500000.000', 1, '2023-02-07 16:11:35', '2023-02-07 16:11:35', NULL),
(2, 'ماتریس', NULL, 8, '200002.000', 1, '2023-02-07 16:11:58', '2023-02-07 16:11:58', NULL),
(3, 'الماس رایان ایرانیان', NULL, 1, '500000.000', 1, '2023-02-07 16:11:35', '2023-02-07 16:11:35', NULL),
(4, 'ماتریس', NULL, 1, '200002.000', 1, '2023-02-07 16:11:58', '2023-02-07 16:11:58', NULL),
(5, 'الماس رایان ایرانیان', NULL, 2, '500000.000', 1, '2023-02-07 16:11:35', '2023-02-07 16:11:35', NULL),
(6, 'ماتریس', NULL, 2, '200002.000', 1, '2023-02-07 16:11:58', '2023-02-07 16:11:58', NULL),
(7, 'الماس رایان ایرانیان', NULL, 3, '500000.000', 1, '2023-02-07 16:11:35', '2023-02-07 16:11:35', NULL),
(8, 'ماتریس', NULL, 3, '200002.000', 1, '2023-02-07 16:11:58', '2023-02-07 16:11:58', NULL),
(9, 'الماس رایان ایرانیان', NULL, 4, '500000.000', 1, '2023-02-07 16:11:35', '2023-02-07 16:11:35', NULL),
(10, 'ماتریس', NULL, 4, '200002.000', 1, '2023-02-07 16:11:58', '2023-02-07 16:11:58', NULL),
(11, 'الماس رایان ایرانیان', NULL, 5, '500000.000', 1, '2023-02-07 16:11:35', '2023-02-07 16:11:35', NULL),
(12, 'ماتریس', NULL, 5, '200002.000', 1, '2023-02-07 16:11:58', '2023-02-07 16:11:58', NULL),
(13, 'الماس رایان ایرانیان', NULL, 6, '500000.000', 1, '2023-02-07 16:11:35', '2023-02-07 16:11:35', NULL),
(14, 'ماتریس', NULL, 6, '200002.000', 1, '2023-02-07 16:11:58', '2023-02-07 16:11:58', NULL),
(15, 'الماس رایان ایرانیان', NULL, 7, '500000.000', 1, '2023-02-07 16:11:35', '2023-02-07 16:11:35', NULL),
(16, 'ماتریس', NULL, 7, '200002.000', 1, '2023-02-07 16:11:58', '2023-02-07 16:11:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'user_id',
  `likeable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `likeable_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `likes_likeable_type_likeable_id_index` (`likeable_type`,`likeable_id`),
  KEY `likes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_parent_id_foreign` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2018_12_14_000000_create_favorites_table', 1),
(5, '2018_12_14_000000_create_likes_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(8, '2021_01_14_234522_create_countries_table', 1),
(9, '2021_01_29_211219_create_attributes_table', 1),
(10, '2021_08_01_075829_create_sessions_table', 1),
(11, '2021_08_02_141330_create_post_categories_table', 1),
(12, '2021_08_02_141937_create_posts_table', 1),
(13, '2021_08_04_132104_create_menus_table', 1),
(14, '2021_08_04_132444_create_faqs_table', 1),
(15, '2021_08_06_133729_create_pages_table', 1),
(16, '2021_08_06_134109_create_comments_table', 1),
(17, '2021_08_07_144900_create_ticket_categories_table', 1),
(18, '2021_08_07_144919_create_ticket_priorities_table', 1),
(19, '2021_08_07_144926_create_ticket_admins_table', 1),
(20, '2021_08_09_083455_create_tickets_table', 1),
(21, '2021_08_09_083503_create_ticket_files_table', 1),
(22, '2021_08_21_151131_create_product_categories_table', 1),
(23, '2021_08_21_151142_create_brands_table', 1),
(24, '2021_08_22_144038_create_attribute_product_category_table', 1),
(25, '2021_08_22_144419_create_attribute_default_values_table', 1),
(26, '2021_08_22_144422_create_products_table', 1),
(27, '2021_08_23_072607_create_product_images_table', 1),
(28, '2021_08_23_072756_create_guarantees_table', 1),
(29, '2021_08_23_072836_create_product_colors_table', 1),
(30, '2021_08_23_072920_create_attribute_values_table', 1),
(31, '2021_08_23_073005_create_product_meta_table', 1),
(32, '2021_08_24_150339_create_copans_table', 1),
(33, '2021_08_24_150350_create_amazing_sales_table', 1),
(34, '2021_08_24_150404_create_common_discount_table', 1),
(35, '2021_08_28_123746_create_provinces_table', 1),
(36, '2021_08_28_123756_create_cities_table', 1),
(37, '2021_08_28_123805_create_addresses_table', 1),
(38, '2021_08_28_123825_create_delivery_table', 1),
(39, '2021_08_29_142632_create_public_sms_table', 1),
(40, '2021_08_29_142639_create_public_mail_table', 1),
(41, '2021_08_29_142649_create_public_mail_files_table', 1),
(42, '2021_09_03_114522_create_offline_payments_table', 1),
(43, '2021_09_03_114531_create_online_payments_table', 1),
(44, '2021_09_03_114544_create_cash_payments_table', 1),
(45, '2021_09_03_114550_create_payments_table', 1),
(46, '2021_09_05_102055_create_cart_items_table', 1),
(47, '2021_09_05_102113_create_cart_item_selected_attributes_table', 1),
(48, '2021_09_06_125842_create_orders_table', 1),
(49, '2021_09_08_132452_create_order_items_table', 1),
(50, '2021_09_08_132505_create_order_item_selected_attributes_table', 1),
(51, '2021_12_15_220744_create_settings_table', 1),
(52, '2022_03_10_194506_create_notifications_table', 1),
(53, '2022_03_12_025919_create_banners_table', 1),
(54, '2022_04_02_111354_create_otps_table', 1),
(55, '2023_01_23_210940_create_permission_tables', 1),
(56, '2023_01_30_160407_create_views_table', 1),
(57, '2023_02_01_212517_create_reviews_table', 1),
(58, '2023_02_01_215309_create_tag_tables', 1),
(59, '2023_02_02_203818_create_activity_log_table', 1),
(60, '2023_02_02_203819_add_event_column_to_activity_log_table', 1),
(61, '2023_02_02_203820_add_batch_uuid_column_to_activity_log_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'Modules\\ACL\\Entities\\Role', 1),
(1, 'Modules\\User\\Entities\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'Modules\\User\\Entities\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_general_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_payments`
--

DROP TABLE IF EXISTS `offline_payments`;
CREATE TABLE IF NOT EXISTS `offline_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` decimal(20,3) NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pay_date` timestamp NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `offline_payments_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_payments`
--

DROP TABLE IF EXISTS `online_payments`;
CREATE TABLE IF NOT EXISTS `online_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` decimal(20,3) NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `gateway` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_first_response` text COLLATE utf8mb4_general_ci,
  `bank_second_response` text COLLATE utf8mb4_general_ci,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `online_payments_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `address_id` bigint UNSIGNED DEFAULT NULL,
  `address_object` longtext COLLATE utf8mb4_general_ci,
  `payment_id` bigint UNSIGNED DEFAULT NULL,
  `payment_object` longtext COLLATE utf8mb4_general_ci,
  `payment_type` tinyint NOT NULL DEFAULT '0',
  `payment_status` tinyint NOT NULL DEFAULT '0',
  `delivery_id` bigint UNSIGNED DEFAULT NULL,
  `delivery_object` longtext COLLATE utf8mb4_general_ci,
  `delivery_amount` decimal(20,3) DEFAULT NULL,
  `delivery_status` tinyint NOT NULL DEFAULT '0',
  `delivery_date` timestamp NULL DEFAULT NULL,
  `order_final_amount` decimal(20,3) DEFAULT NULL,
  `order_discount_amount` decimal(20,3) DEFAULT NULL,
  `copan_id` bigint UNSIGNED DEFAULT NULL,
  `copan_object` longtext COLLATE utf8mb4_general_ci,
  `order_copan_discount_amount` decimal(20,3) DEFAULT NULL,
  `common_discount_id` bigint UNSIGNED DEFAULT NULL,
  `common_discount_object` longtext COLLATE utf8mb4_general_ci,
  `order_common_discount_amount` decimal(20,3) DEFAULT NULL,
  `order_total_products_discount_amount` decimal(20,3) DEFAULT NULL,
  `order_status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_address_id_foreign` (`address_id`),
  KEY `orders_payment_id_foreign` (`payment_id`),
  KEY `orders_delivery_id_foreign` (`delivery_id`),
  KEY `orders_copan_id_foreign` (`copan_id`),
  KEY `orders_common_discount_id_foreign` (`common_discount_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product` longtext COLLATE utf8mb4_general_ci,
  `amazing_sale_id` bigint UNSIGNED DEFAULT NULL,
  `amazing_sale_object` longtext COLLATE utf8mb4_general_ci,
  `amazing_sale_discount_amount` decimal(20,3) DEFAULT NULL,
  `number` int NOT NULL DEFAULT '1',
  `final_product_price` decimal(20,3) DEFAULT NULL,
  `final_total_price` decimal(20,3) DEFAULT NULL COMMENT 'number * final_product_price',
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `guarantee_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_amazing_sale_id_foreign` (`amazing_sale_id`),
  KEY `order_items_color_id_foreign` (`color_id`),
  KEY `order_items_guarantee_id_foreign` (`guarantee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item_selected_attributes`
--

DROP TABLE IF EXISTS `order_item_selected_attributes`;
CREATE TABLE IF NOT EXISTS `order_item_selected_attributes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `attribute_value_id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_item_selected_attributes_order_item_id_foreign` (`order_item_id`),
  KEY `order_item_selected_attributes_attribute_id_foreign` (`attribute_id`),
  KEY `order_item_selected_attributes_attribute_value_id_foreign` (`attribute_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

DROP TABLE IF EXISTS `otps`;
CREATE TABLE IF NOT EXISTS `otps` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `otp_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'email address or mobile number',
  `type` tinyint NOT NULL DEFAULT '0' COMMENT '0 => mobile number , 1 => email',
  `used` tinyint NOT NULL DEFAULT '0' COMMENT '0 => not used , 1 => used',
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otps_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `body` text COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` decimal(20,3) NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `type` tinyint NOT NULL DEFAULT '0' COMMENT '0 => online, 1 => offline, 2 => cash',
  `paymentable_id` bigint UNSIGNED NOT NULL,
  `paymentable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'permission super admin', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(2, 'permission admin panel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(3, 'permission market', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(4, 'permission vitrine', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(5, 'permission product categories', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(6, 'permission product category create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(7, 'permission product category edit', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(8, 'permission product category delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(9, 'permission product category status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(10, 'permission product properties', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(11, 'permission product property create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(12, 'permission product property edit', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(13, 'permission product property delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(14, 'permission product property status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(15, 'permission product property values', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(16, 'permission product property value create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(17, 'permission product property value edit', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(18, 'permission product property value delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(19, 'permission product property value status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(20, 'permission product brands', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(21, 'permission product brand create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(22, 'permission product brand edit', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(23, 'permission product brand delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(24, 'permission product brand status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(25, 'permission products', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(26, 'permission product create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(27, 'permission product edit', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(28, 'permission product delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(29, 'permission product status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(30, 'permission product gallery', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(31, 'permission product gallery create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(32, 'permission product gallery delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(33, 'permission product guarantees', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(34, 'permission product guarantee create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(35, 'permission product guarantee delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(36, 'permission product colors', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(37, 'permission product color create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(38, 'permission product color delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(39, 'permission product warehouse', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(40, 'permission product warehouse add', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(41, 'permission product warehouse modify', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(42, 'permission product comments', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(43, 'permission product comment show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(44, 'permission product comment status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(45, 'permission product comment approve', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(46, 'permission product orders', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(47, 'permission product new orders', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(48, 'permission product new order show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(49, 'permission product new order detail', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(50, 'permission product new order print', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(51, 'permission product new order cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(52, 'permission product new order status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(53, 'permission product new order send status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(54, 'permission product sending orders', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(55, 'permission product sending order show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(56, 'permission product sending order detail', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(57, 'permission product sending order print', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(58, 'permission product sending order cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(59, 'permission product sending order status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(60, 'permission product sending order send status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(61, 'permission product unpaid orders', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(62, 'permission product unpaid order show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(63, 'permission product unpaid order detail', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(64, 'permission product unpaid order print', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(65, 'permission product unpaid order cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(66, 'permission product unpaid order status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(67, 'permission product unpaid order send status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(68, 'permission product canceled orders', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(69, 'permission product canceled order show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(70, 'permission product canceled order detail', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(71, 'permission product canceled order print', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(72, 'permission product canceled order cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(73, 'permission product canceled order status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(74, 'permission product canceled order send status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(75, 'permission product returned orders', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(76, 'permission product returned order show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(77, 'permission product returned order detail', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(78, 'permission product returned order print', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(79, 'permission product returned order cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(80, 'permission product returned order status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(81, 'permission product returned order send status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(82, 'permission product all orders', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(83, 'permission product order show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(84, 'permission product order detail', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(85, 'permission product order print', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(86, 'permission product order cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(87, 'permission product order status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(88, 'permission product order send status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(89, 'permission product payments', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(90, 'permission product all payments', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(91, 'permission product payment show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(92, 'permission product payment cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(93, 'permission product payment return', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(94, 'permission product online payments', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(95, 'permission product online payment show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(96, 'permission product online payment cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(97, 'permission product online payment return', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(98, 'permission product offline payments', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(99, 'permission product offline payment show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(100, 'permission product offline payment cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(101, 'permission product offline payment return', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(102, 'permission product cash payments', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(103, 'permission product cash payment show', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(104, 'permission product cash payment cancel', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(105, 'permission product cash payment return', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(106, 'permission product discounts', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(107, 'permission product coupon discounts', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(108, 'permission product coupon discount create', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(109, 'permission product coupon discount edit', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(110, 'permission product coupon discount delete', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(111, 'permission product coupon discount status', 'web', NULL, 1, '2023-02-07 11:17:38', '2023-02-07 11:17:38', NULL),
(112, 'permission product common discounts', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(113, 'permission product common discount create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(114, 'permission product common discount edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(115, 'permission product common discount delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(116, 'permission product common discount status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(117, 'permission product amazing sales', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(118, 'permission product amazing sale create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(119, 'permission product amazing sale edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(120, 'permission product amazing sale delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(121, 'permission product amazing sale status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(122, 'permission delivery methods', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(123, 'permission delivery method create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(124, 'permission delivery method edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(125, 'permission delivery method delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(126, 'permission delivery method status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(127, 'permission content', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(128, 'permission post categories', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(129, 'permission post category create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(130, 'permission post category edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(131, 'permission post category delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(132, 'permission post category status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(133, 'permission post', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(134, 'permission post create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(135, 'permission post edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(136, 'permission post delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(137, 'permission post status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(138, 'permission authors', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(139, 'permission post comments', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(140, 'permission post comment status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(141, 'permission post comment show', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(142, 'permission post comment approve', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(143, 'permission faqs', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(144, 'permission faq create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(145, 'permission faq edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(146, 'permission faq delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(147, 'permission faq status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(148, 'permission pages', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(149, 'permission page create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(150, 'permission page edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(151, 'permission page delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(152, 'permission page status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(153, 'permission menus', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(154, 'permission menu create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(155, 'permission menu edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(156, 'permission menu delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(157, 'permission menu status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(158, 'permission banners', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(159, 'permission banner create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(160, 'permission banner edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(161, 'permission banner delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(162, 'permission banner status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(163, 'permission post set tags', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(164, 'permission post update tags', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(165, 'permission tags', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(166, 'permission tag create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(167, 'permission tag edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(168, 'permission tag delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(169, 'permission tag status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(170, 'permission users', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(171, 'permission admin users', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(172, 'permission admin user create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(173, 'permission admin user edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(174, 'permission admin user delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(175, 'permission admin user status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(176, 'permission admin user roles', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(177, 'permission admin user activation', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(178, 'permission customer users', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(179, 'permission customer user create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(180, 'permission customer user edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(181, 'permission customer user delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(182, 'permission customer user status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(183, 'permission customer user activation', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(184, 'permission customer user roles', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(185, 'permission user roles', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(186, 'permission user role create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(187, 'permission user role edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(188, 'permission user role delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(189, 'permission user role status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(190, 'permission user role permissions', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(191, 'permission user permissions import', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(192, 'permission user permissions export', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(193, 'permission tickets', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(194, 'permission ticket categories', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(195, 'permission ticket category create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(196, 'permission ticket category edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(197, 'permission ticket category delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(198, 'permission ticket category status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(199, 'permission ticket priorities', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(200, 'permission ticket priority create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(201, 'permission ticket priority edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(202, 'permission ticket priority delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(203, 'permission ticket priority status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(204, 'permission admin tickets', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(205, 'permission admin ticket add', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(206, 'permission new tickets', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(207, 'permission new ticket show', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(208, 'permission new ticket change', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(209, 'permission open tickets', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(210, 'permission open ticket show', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(211, 'permission open ticket change', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(212, 'permission close tickets', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(213, 'permission close ticket show', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(214, 'permission close ticket change', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(215, 'permission all tickets', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(216, 'permission ticket show', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(217, 'permission ticket change', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(218, 'permission notify', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(219, 'permission email notify', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(220, 'permission email notify create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(221, 'permission email notify edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(222, 'permission email notify delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(223, 'permission email notify status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(224, 'permission email notify files', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(225, 'permission email notify file create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(226, 'permission email notify file edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(227, 'permission email notify file delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(228, 'permission email notify file status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(229, 'permission sms notify', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(230, 'permission sms notify create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(231, 'permission sms notify edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(232, 'permission sms notify delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(233, 'permission sms notify status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(234, 'permission setting', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(235, 'permission setting edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(236, 'permission office', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(237, 'permission service categories', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(238, 'permission service category create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(239, 'permission service category edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(240, 'permission service category delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(241, 'permission service category status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(242, 'permission service', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(243, 'permission service create', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(244, 'permission service edit', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(245, 'permission service delete', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(246, 'permission service status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(247, 'permission service comments', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(248, 'permission service comment status', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(249, 'permission service comment show', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL),
(250, 'permission service comment approve', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_general_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_general_ci NOT NULL,
  `body` text COLLATE utf8mb4_general_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `popular` tinyint NOT NULL DEFAULT '0',
  `selected` tinyint NOT NULL DEFAULT '0',
  `commentable` tinyint NOT NULL DEFAULT '0' COMMENT '0 => uncommentable, 1 => commentable',
  `published_at` timestamp NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `time_to_read` tinyint NOT NULL DEFAULT '0',
  `view_count` int NOT NULL DEFAULT '0',
  `comment_count` int NOT NULL DEFAULT '0',
  `like_count` int NOT NULL DEFAULT '0',
  `rating` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_author_id_foreign` (`author_id`),
  KEY `posts_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
CREATE TABLE IF NOT EXISTS `post_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_kala` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `introduction` text COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_general_ci NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `length` decimal(10,1) NOT NULL COMMENT 'cm unit',
  `width` decimal(10,1) NOT NULL COMMENT 'cm unit',
  `height` decimal(10,1) NOT NULL COMMENT 'cm unit',
  `price` decimal(20,3) NOT NULL,
  `active_discount_percentage` tinyint DEFAULT NULL,
  `rating` double(8,2) NOT NULL DEFAULT '0.00',
  `popular` tinyint NOT NULL DEFAULT '0',
  `selected` tinyint NOT NULL DEFAULT '0',
  `marketable` tinyint NOT NULL DEFAULT '0' COMMENT '1 => marketable, 0 => is not marketable',
  `sold_number` smallint NOT NULL DEFAULT '0',
  `frozen_number` smallint NOT NULL DEFAULT '0',
  `marketable_number` smallint NOT NULL DEFAULT '0',
  `views_count` int NOT NULL DEFAULT '0',
  `comments_count` int NOT NULL DEFAULT '0',
  `likes_count` int NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `brand_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `published_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_code_kala_unique` (`code_kala`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_category_id_foreign` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code_kala`, `name`, `introduction`, `slug`, `image`, `weight`, `length`, `width`, `height`, `price`, `active_discount_percentage`, `rating`, `popular`, `selected`, `marketable`, `sold_number`, `frozen_number`, `marketable_number`, `views_count`, `comments_count`, `likes_count`, `status`, `brand_id`, `category_id`, `published_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'پوکو ایکس ۳', '<p>پوکو ایکس ۳پوکو ایکس ۳پوکو ایکس ۳پوکو ایکس ۳پوکو ایکس ۳</p>\r\n\r\n<p>پوکو ایکس ۳پوکو ایکس ۳پوکو ایکس ۳پوکو ایکس ۳</p>\r\n\r\n<p>پوکو ایکس ۳پوکو ایکس ۳پوکو ایکس ۳پوکو ایکس ۳</p>', 'پوکو-ایکس-۳', '{\"indexArray\":{\"large\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675780598\\\\1675780598_large.jpg\",\"medium\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675780598\\\\1675780598_medium.jpg\",\"small\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675780598\\\\1675780598_small.jpg\"},\"directory\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675780598\",\"currentImage\":\"medium\"}', '111.00', '100.0', '777.0', '777.0', '5700000.000', NULL, 0.00, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 6, 4, '2023-02-07 14:35:13', '2023-02-07 14:36:38', '2023-02-07 14:36:38', NULL),
(2, NULL, 'شیائومی ۲', '<p>شیائومی ۲شیائومی ۲شیائومی ۲شیائومی ۲شیائومی ۲شیائومی ۲</p>', 'شیائومی-۲', '{\"indexArray\":{\"large\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675784983\\\\1675784983_large.jpg\",\"medium\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675784983\\\\1675784983_medium.jpg\",\"small\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675784983\\\\1675784983_small.jpg\"},\"directory\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675784983\",\"currentImage\":\"medium\"}', '111.00', '222.0', '777.0', '777.0', '3500000.000', NULL, 0.00, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 6, 4, '2023-02-07 15:48:07', '2023-02-07 15:49:43', '2023-02-07 15:49:43', NULL),
(3, NULL, 'شیائومی ۳', '<p>شیائومی ۳شیائومی ۳شیائومی ۳شیائومی ۳شیائومی ۳شیائومی ۳شیائومی ۳</p>', 'شیائومی-۳', '{\"indexArray\":{\"large\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785111\\\\1675785111_large.jpg\",\"medium\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785111\\\\1675785111_medium.jpg\",\"small\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785111\\\\1675785111_small.jpg\"},\"directory\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785111\",\"currentImage\":\"medium\"}', '111.00', '222.0', '777.0', '777.0', '5700000.000', NULL, 0.00, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 6, 4, '2023-02-07 15:49:55', '2023-02-07 15:51:52', '2023-02-07 15:51:52', NULL),
(4, NULL, 'ایفون 12', '<p>ایفون 12ایفون 12ایفون 12ایفون 12ایفون 12ایفون 12</p>', 'ایفون-12', '{\"indexArray\":{\"large\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785334\\\\1675785334_large.jpg\",\"medium\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785334\\\\1675785334_medium.jpg\",\"small\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785334\\\\1675785334_small.jpg\"},\"directory\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785334\",\"currentImage\":\"medium\"}', '111.00', '222.0', '777.0', '777.0', '25500000.000', NULL, 0.00, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 2, 2, '2023-02-07 15:52:03', '2023-02-07 15:55:34', '2023-02-07 16:22:46', NULL),
(5, NULL, 'سامسونگ ۱', '<p>سامسونگ ۱سامسونگ ۱سامسونگ ۱سامسونگ ۱سامسونگ ۱سامسونگ ۱سامسونگ ۱</p>', 'سامسونگ-۱', '{\"indexArray\":{\"large\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785418\\\\1675785418_large.jpg\",\"medium\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785418\\\\1675785418_medium.jpg\",\"small\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785418\\\\1675785418_small.jpg\"},\"directory\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785418\",\"currentImage\":\"medium\"}', '111.00', '222.0', '777.0', '777.0', '5700000.000', NULL, 0.00, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 3, '2023-02-07 15:55:48', '2023-02-07 15:56:58', '2023-02-07 16:23:40', NULL),
(6, NULL, 'سامسونگ ۱۲', '<p>سامسونگ ۱۲سامسونگ ۱۲سامسونگ ۱۲سامسونگ ۱۲سامسونگ ۱۲سامسونگ ۱۲سامسونگ ۱۲سامسونگ ۱۲سامسونگ ۱۲</p>', 'سامسونگ-۱۲', '{\"indexArray\":{\"large\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785496\\\\1675785496_large.jpg\",\"medium\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785496\\\\1675785496_medium.jpg\",\"small\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785496\\\\1675785496_small.jpg\"},\"directory\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785496\",\"currentImage\":\"medium\"}', '111.00', '222.0', '777.0', '777.0', '3500000.000', NULL, 0.00, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 3, '2023-02-07 15:57:38', '2023-02-07 15:58:16', '2023-02-07 16:23:32', NULL),
(7, NULL, 'سامسونگ ۱۱', '<p>سامسونگ ۱۱سامسونگ ۱۱سامسونگ ۱۱سامسونگ ۱۱سامسونگ ۱۱سامسونگ ۱۱سامسونگ ۱۱سامسونگ ۱۱</p>', 'سامسونگ-۱۱', '{\"indexArray\":{\"large\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785617\\\\1675785617_large.jpg\",\"medium\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785617\\\\1675785617_medium.jpg\",\"small\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785617\\\\1675785617_small.jpg\"},\"directory\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785617\",\"currentImage\":\"medium\"}', '111.00', '222.0', '777.0', '777.0', '25500000.000', NULL, 0.00, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 3, '2023-02-07 15:59:23', '2023-02-07 16:00:17', '2023-02-07 16:23:12', NULL),
(8, NULL, 'شیائومی ۳4', '<p>شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4شیائومی ۳4</p>', 'شیائومی-۳4', '{\"indexArray\":{\"large\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785806\\\\1675785806_large.jpg\",\"medium\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785806\\\\1675785806_medium.jpg\",\"small\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785806\\\\1675785806_small.jpg\"},\"directory\":\"images\\\\product\\\\2023\\\\02\\\\07\\\\1675785806\",\"currentImage\":\"medium\"}', '111.00', '222.0', '777.0', '777.0', '3500000.000', NULL, 0.00, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 6, 3, '2023-02-07 16:00:31', '2023-02-07 16:03:26', '2023-02-07 16:23:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_general_ci,
  `status` tinyint NOT NULL DEFAULT '0',
  `show_in_menu` tinyint NOT NULL DEFAULT '0',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_slug_unique` (`slug`),
  KEY `product_categories_parent_id_foreign` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `description`, `slug`, `image`, `status`, `show_in_menu`, `parent_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'گوشی های هوشمند', '<p>گوشی های هوشمندگوشی های هوشمندگوشی های هوشمندگوشی های هوشمندگوشی های هوشمند</p>', 'گوشی-های-هوشمند', '{\"indexArray\":{\"large\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779627\\\\1675779627_large.jpg\",\"medium\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779627\\\\1675779627_medium.jpg\",\"small\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779627\\\\1675779627_small.jpg\"},\"directory\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779627\",\"currentImage\":\"medium\"}', 1, 1, NULL, '2023-02-07 14:20:28', '2023-02-07 14:20:28', NULL),
(2, 'گوشی های اپل', '<p>گوشی های اپلگوشی های اپلگوشی های اپلگوشی های اپلگوشی های اپلگوشی های اپلگوشی های اپلگوشی های اپل</p>', 'گوشی-های-اپل', '{\"indexArray\":{\"large\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779709\\\\1675779709_large.jpg\",\"medium\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779709\\\\1675779709_medium.jpg\",\"small\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779709\\\\1675779709_small.jpg\"},\"directory\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779709\",\"currentImage\":\"medium\"}', 1, 1, 1, '2023-02-07 14:21:49', '2023-02-07 14:21:49', NULL),
(3, 'گوشی های سامسونگ', '<p>گوشی های سامسونگگوشی های سامسونگگوشی های سامسونگگوشی های سامسونگگوشی های سامسونگگوشی های سامسونگگوشی های سامسونگ</p>', 'گوشی-های-سامسونگ', '{\"indexArray\":{\"large\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779754\\\\1675779754_large.jpg\",\"medium\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779754\\\\1675779754_medium.jpg\",\"small\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779754\\\\1675779754_small.jpg\"},\"directory\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675779754\",\"currentImage\":\"medium\"}', 1, 1, 1, '2023-02-07 14:22:34', '2023-02-07 14:22:34', NULL),
(4, 'گوشی های شیائومی', '<p>گوشی های شیائومیگوشی های شیائومیگوشی های شیائومیگوشی های شیائومیگوشی های شیائومیگوشی های شیائومیگوشی های شیائومی</p>', 'گوشی-های-شیائومی', '{\"indexArray\":{\"large\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675780334\\\\1675780334_large.png\",\"medium\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675780334\\\\1675780334_medium.png\",\"small\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675780334\\\\1675780334_small.png\"},\"directory\":\"images\\\\product-category\\\\2023\\\\02\\\\07\\\\1675780334\",\"currentImage\":\"medium\"}', 1, 1, 1, '2023-02-07 14:32:14', '2023-02-07 14:32:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

DROP TABLE IF EXISTS `product_colors`;
CREATE TABLE IF NOT EXISTS `product_colors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `color_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `price_increase` decimal(20,3) NOT NULL DEFAULT '0.000',
  `status` tinyint NOT NULL DEFAULT '0',
  `sold_number` smallint NOT NULL DEFAULT '0',
  `frozen_number` smallint NOT NULL DEFAULT '0',
  `marketable_number` smallint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_colors_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`id`, `color_name`, `color`, `product_id`, `price_increase`, `status`, `sold_number`, `frozen_number`, `marketable_number`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'سفید', '#ffffff', 8, '500000.000', 1, 0, 0, 20, '2023-02-07 16:10:33', '2023-02-07 16:10:33', NULL),
(2, 'بنفش', '#7d3fd9', 8, '500000.000', 1, 0, 0, 10, '2023-02-07 16:11:00', '2023-02-07 16:11:00', NULL),
(3, 'سفید', '#ffffff', 7, '500000.000', 1, 0, 0, 20, '2023-02-07 16:10:33', '2023-02-07 16:10:33', NULL),
(4, 'بنفش', '#7d3fd9', 7, '500000.000', 1, 0, 0, 10, '2023-02-07 16:11:00', '2023-02-07 16:11:00', NULL),
(5, 'سفید', '#ffffff', 6, '500000.000', 1, 0, 0, 20, '2023-02-07 16:10:33', '2023-02-07 16:10:33', NULL),
(6, 'بنفش', '#7d3fd9', 6, '500000.000', 1, 0, 0, 10, '2023-02-07 16:11:00', '2023-02-07 16:11:00', NULL),
(7, 'سفید', '#ffffff', 5, '500000.000', 1, 0, 0, 20, '2023-02-07 16:10:33', '2023-02-07 16:10:33', NULL),
(8, 'بنفش', '#7d3fd9', 5, '500000.000', 1, 0, 0, 10, '2023-02-07 16:11:00', '2023-02-07 16:11:00', NULL),
(9, 'سفید', '#ffffff', 1, '500000.000', 1, 0, 0, 20, '2023-02-07 16:10:33', '2023-02-07 16:10:33', NULL),
(10, 'بنفش', '#7d3fd9', 1, '500000.000', 1, 0, 0, 10, '2023-02-07 16:11:00', '2023-02-07 16:11:00', NULL),
(11, 'سفید', '#ffffff', 2, '500000.000', 1, 0, 0, 20, '2023-02-07 16:10:33', '2023-02-07 16:10:33', NULL),
(12, 'بنفش', '#7d3fd9', 2, '500000.000', 1, 0, 0, 10, '2023-02-07 16:11:00', '2023-02-07 16:11:00', NULL),
(13, 'سفید', '#ffffff', 3, '500000.000', 1, 0, 0, 20, '2023-02-07 16:10:33', '2023-02-07 16:10:33', NULL),
(14, 'بنفش', '#7d3fd9', 3, '500000.000', 1, 0, 0, 10, '2023-02-07 16:11:00', '2023-02-07 16:11:00', NULL),
(15, 'سفید', '#ffffff', 4, '500000.000', 1, 0, 0, 20, '2023-02-07 16:10:33', '2023-02-07 16:10:33', NULL),
(16, 'بنفش', '#7d3fd9', 4, '500000.000', 1, 0, 0, 10, '2023-02-07 16:11:00', '2023-02-07 16:11:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image`, `product_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786167\\\\1675786167_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786167\\\\1675786167_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786167\\\\1675786167_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786167\",\"currentImage\":\"medium\"}', 8, '2023-02-07 16:09:27', '2023-02-07 16:09:27', NULL),
(2, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786195\\\\1675786195_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786195\\\\1675786195_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786195\\\\1675786195_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786195\",\"currentImage\":\"medium\"}', 8, '2023-02-07 16:09:55', '2023-02-07 16:09:55', NULL),
(3, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786986\\\\1675786986_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786986\\\\1675786986_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786986\\\\1675786986_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675786986\",\"currentImage\":\"medium\"}', 7, '2023-02-07 16:23:06', '2023-02-07 16:23:06', NULL),
(4, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787039\\\\1675787039_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787039\\\\1675787039_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787039\\\\1675787039_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787039\",\"currentImage\":\"medium\"}', 7, '2023-02-07 16:23:59', '2023-02-07 16:23:59', NULL),
(5, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787159\\\\1675787159_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787159\\\\1675787159_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787159\\\\1675787159_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787159\",\"currentImage\":\"medium\"}', 6, '2023-02-07 16:26:00', '2023-02-07 16:26:00', NULL),
(6, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787178\\\\1675787178_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787178\\\\1675787178_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787178\\\\1675787178_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787178\",\"currentImage\":\"medium\"}', 6, '2023-02-07 16:26:18', '2023-02-07 16:26:18', NULL),
(7, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787216\\\\1675787216_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787216\\\\1675787216_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787216\\\\1675787216_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787216\",\"currentImage\":\"medium\"}', 5, '2023-02-07 16:26:56', '2023-02-07 16:26:56', NULL),
(8, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787234\\\\1675787234_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787234\\\\1675787234_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787234\\\\1675787234_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787234\",\"currentImage\":\"medium\"}', 5, '2023-02-07 16:27:15', '2023-02-07 16:27:15', NULL),
(9, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787279\\\\1675787279_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787279\\\\1675787279_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787279\\\\1675787279_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787279\",\"currentImage\":\"medium\"}', 4, '2023-02-07 16:27:59', '2023-02-07 16:27:59', NULL),
(10, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787297\\\\1675787297_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787297\\\\1675787297_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787297\\\\1675787297_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787297\",\"currentImage\":\"medium\"}', 4, '2023-02-07 16:28:17', '2023-02-07 16:28:17', NULL),
(11, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787332\\\\1675787332_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787332\\\\1675787332_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787332\\\\1675787332_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787332\",\"currentImage\":\"medium\"}', 3, '2023-02-07 16:28:52', '2023-02-07 16:28:52', NULL),
(12, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787355\\\\1675787355_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787355\\\\1675787355_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787355\\\\1675787355_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787355\",\"currentImage\":\"medium\"}', 3, '2023-02-07 16:29:15', '2023-02-07 16:29:15', NULL),
(13, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787380\\\\1675787380_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787380\\\\1675787380_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787380\\\\1675787380_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787380\",\"currentImage\":\"medium\"}', 2, '2023-02-07 16:29:40', '2023-02-07 16:29:40', NULL),
(14, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787402\\\\1675787402_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787402\\\\1675787402_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787402\\\\1675787402_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787402\",\"currentImage\":\"medium\"}', 2, '2023-02-07 16:30:02', '2023-02-07 16:30:02', NULL),
(15, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787433\\\\1675787433_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787433\\\\1675787433_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787433\\\\1675787433_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787433\",\"currentImage\":\"medium\"}', 1, '2023-02-07 16:30:33', '2023-02-07 16:30:33', NULL),
(16, '{\"indexArray\":{\"large\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787550\\\\1675787550_large.jpg\",\"medium\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787550\\\\1675787550_medium.jpg\",\"small\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787550\\\\1675787550_small.jpg\"},\"directory\":\"images\\\\product-gallery\\\\2023\\\\02\\\\07\\\\1675787550\",\"currentImage\":\"medium\"}', 1, '2023-02-07 16:32:30', '2023-02-07 16:32:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_meta`
--

DROP TABLE IF EXISTS `product_meta`;
CREATE TABLE IF NOT EXISTS `product_meta` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `meta_value` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_meta_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_meta`
--

INSERT INTO `product_meta` (`id`, `meta_key`, `meta_value`, `product_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ضداب', 'هست', 1, '2023-02-07 14:36:39', '2023-02-07 14:36:39', NULL),
(2, 'گواهی', 'دارد', 1, '2023-02-07 14:36:39', '2023-02-07 14:36:39', NULL),
(3, 'ضداب', 'هست', 2, '2023-02-07 15:49:43', '2023-02-07 15:49:43', NULL),
(4, 'ضداب', 'هست', 3, '2023-02-07 15:51:52', '2023-02-07 15:51:52', NULL),
(5, 'ضداب', 'هست', 4, '2023-02-07 15:55:34', '2023-02-07 15:55:34', NULL),
(6, 'ضداب', 'هست', 5, '2023-02-07 15:56:58', '2023-02-07 15:56:58', NULL),
(7, 'ضداب', 'هست', 6, '2023-02-07 15:58:16', '2023-02-07 15:58:16', NULL),
(8, 'ضداب', 'هست', 7, '2023-02-07 16:00:17', '2023-02-07 16:00:17', NULL),
(9, 'ضداب', 'هست', 8, '2023-02-07 16:03:26', '2023-02-07 16:03:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provinces_country_id_foreign` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `country_id`, `name`, `name_en`, `latitude`, `longitude`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'آذربایجان شرقی', 'East Azerbaijan', '37.90357330', '46.26821090', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(2, 1, 'آذربایجان غربی', 'West Azerbaijan', '37.45500620', '45.00000000', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(3, 1, 'اردبیل', 'Ardabil', '38.48532760', '47.89112090', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(4, 1, 'اصفهان', 'Isfahan', '32.65462750', '51.66798260', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(5, 1, 'البرز', 'Alborz', '35.99604670', '50.92892460', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(6, 1, 'ایلام', 'Ilam', '33.29576180', '46.67053400', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(7, 1, 'بوشهر', 'Bushehr', '28.92338370', '50.82031400', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(8, 1, 'تهران', 'Tehran', '35.69611100', '51.42305600', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(9, 1, 'چهارمحال و بختیاری', 'Chaharmahal and Bakhtiari ', '31.96143480', '50.84563230', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(10, 1, 'خراسان جنوبی', 'South Khorasan', '32.51756430', '59.10417580', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(11, 1, 'خراسان رضوی', 'Razavi Khorasan', '35.10202530', '59.10417580', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(12, 1, 'خراسان شمالی', 'North Khorasan', '37.47103530', '57.10131880', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(13, 1, 'خوزستان', 'Khuzestan', '31.43601490', '49.04131200', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(14, 1, 'زنجان', 'Zanjan', '36.50181850', '48.39881860', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(15, 1, 'سمنان', 'Semnan', '35.22555850', '54.43421380', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(16, 1, 'سیستان و بلوچستان', 'Sistan and Baluchestan ', '27.52999060', '60.58206760', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(17, 1, 'فارس', 'Fars', '29.10438130', '53.04589300', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(18, 1, 'قزوین', 'Qazvin', '36.08813170', '49.85472660', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(19, 1, 'قم', 'Qom', '34.63994430', '50.87594190', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(20, 1, 'كردستان', 'Kurdistan', '35.95535790', '47.13621250', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(21, 1, 'كرمان', 'Kerman', '30.28393790', '57.08336280', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(22, 1, 'كرمانشاه', 'Kermanshah', '34.31416700', '47.06500000', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(23, 1, 'کهگیلویه و بویراحمد', 'Kohgiluyeh and Boyer-Ahmad ', '30.65094790', '51.60525000', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(24, 1, 'گلستان', 'Golestan', '37.28981230', '55.13758340', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(25, 1, 'گیلان', 'Gilan', '37.11716170', '49.52799960', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(26, 1, 'لرستان', 'Lorestan', '33.58183940', '48.39881860', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(27, 1, 'مازندران', 'Mazandaran', '36.22623930', '52.53186040', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(28, 1, 'مركزی', 'Markazi', '33.50932940', '-92.39611900', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(29, 1, 'هرمزگان', 'Hormozgan', '27.13872300', '55.13758340', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(30, 1, 'همدان', 'Hamadan', '34.76079990', '48.39881860', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL),
(31, 1, 'یزد', 'Yazd', '32.10063870', '54.43421380', '2023-02-07 13:34:12', '2023-02-07 13:34:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `public_mail`
--

DROP TABLE IF EXISTS `public_mail`;
CREATE TABLE IF NOT EXISTS `public_mail` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `body` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `published_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `public_mail_files`
--

DROP TABLE IF EXISTS `public_mail_files`;
CREATE TABLE IF NOT EXISTS `public_mail_files` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `public_mail_id` bigint UNSIGNED NOT NULL,
  `file_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `file_size` bigint NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `public_mail_files_public_mail_id_foreign` (`public_mail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `public_sms`
--

DROP TABLE IF EXISTS `public_sms`;
CREATE TABLE IF NOT EXISTS `public_sms` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `body` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `published_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `reviewable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `reviewable_id` bigint UNSIGNED NOT NULL,
  `rate` enum('1','2','3','4','5') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'role super admin', 'web', NULL, 1, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `payload` text COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9IOPtl9blfz7mxhW3Gf5DhsEkvDXxiK9a59rODOS', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTo1OntzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NjoiX3Rva2VuIjtzOjQwOiJMN3lWbnBiV0dON01STEs1ZjlXZ2RlaFVCREtlZ0w0OENFWFNqR0JYIjtzOjU6ImFsZXJ0IjthOjA6e31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoxNzoiaHR0cDovL3Nob3BiaXouaXIiO319', 1675788227);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `keywords` text COLLATE utf8mb4_general_ci,
  `logo` text COLLATE utf8mb4_general_ci,
  `icon` text COLLATE utf8mb4_general_ci,
  `low_count_products` smallint NOT NULL DEFAULT '0' COMMENT 'count of products which have low marketable number',
  `rating_score` double(8,2) NOT NULL DEFAULT '0.00' COMMENT 'calculate avg rating of all items',
  `author` text COLLATE utf8mb4_general_ci,
  `address` text COLLATE utf8mb4_general_ci,
  `mobile` text COLLATE utf8mb4_general_ci,
  `email` text COLLATE utf8mb4_general_ci,
  `postal_code` text COLLATE utf8mb4_general_ci,
  `social_media` text COLLATE utf8mb4_general_ci,
  `bank_account` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `description`, `keywords`, `logo`, `icon`, `low_count_products`, `rating_score`, `author`, `address`, `mobile`, `email`, `postal_code`, `social_media`, `bank_account`, `created_at`, `updated_at`) VALUES
(1, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 11:18:40', '2023-02-07 11:18:40'),
(2, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 12:05:56', '2023-02-07 12:05:56'),
(3, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 12:08:35', '2023-02-07 12:08:35'),
(4, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 12:09:48', '2023-02-07 12:09:48'),
(5, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 12:17:19', '2023-02-07 12:17:19'),
(6, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 12:52:17', '2023-02-07 12:52:17'),
(7, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 12:58:53', '2023-02-07 12:58:53'),
(8, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 12:59:20', '2023-02-07 12:59:20'),
(9, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 13:00:39', '2023-02-07 13:00:39'),
(10, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 13:16:40', '2023-02-07 13:16:40'),
(11, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 13:29:50', '2023-02-07 13:29:50'),
(12, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 13:32:31', '2023-02-07 13:32:31'),
(13, 'عنوان سایت', 'توضیحات سایت', 'کلمات کلیدی سایت', '\"logo.png\"', '\"icon.png\"', 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 13:34:12', '2023-02-07 13:34:12');

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

DROP TABLE IF EXISTS `taggables`;
CREATE TABLE IF NOT EXISTS `taggables` (
  `tag_id` bigint UNSIGNED NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `taggable_id` bigint UNSIGNED NOT NULL,
  UNIQUE KEY `taggables_tag_id_taggable_id_taggable_type_unique` (`tag_id`,`taggable_id`,`taggable_type`),
  KEY `taggables_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taggables`
--

INSERT INTO `taggables` (`tag_id`, `taggable_type`, `taggable_id`) VALUES
(3, 'Modules\\Product\\Entities\\Product', 1),
(4, 'Modules\\Product\\Entities\\Product', 1),
(3, 'Modules\\Product\\Entities\\Product', 2),
(4, 'Modules\\Product\\Entities\\Product', 2),
(3, 'Modules\\Product\\Entities\\Product', 3),
(4, 'Modules\\Product\\Entities\\Product', 3),
(1, 'Modules\\Product\\Entities\\Product', 4),
(6, 'Modules\\Product\\Entities\\Product', 4),
(2, 'Modules\\Product\\Entities\\Product', 5),
(5, 'Modules\\Product\\Entities\\Product', 5),
(2, 'Modules\\Product\\Entities\\Product', 6),
(5, 'Modules\\Product\\Entities\\Product', 6),
(2, 'Modules\\Product\\Entities\\Product', 7),
(5, 'Modules\\Product\\Entities\\Product', 7),
(3, 'Modules\\Product\\Entities\\Product', 8),
(4, 'Modules\\Product\\Entities\\Product', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` json NOT NULL,
  `slug` json NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_column` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `type`, `order_column`, `status`, `created_at`, `updated_at`) VALUES
(1, '{\"fa\": \"آیفون\"}', '{\"fa\": \"آیفون\"}', 'پردازنده', 1, 1, '2023-02-07 16:06:48', '2023-02-07 16:06:48'),
(2, '{\"fa\": \"سامسونگ\"}', '{\"fa\": \"سامسونگ\"}', 'پردازنده', 2, 1, '2023-02-07 16:07:42', '2023-02-07 16:07:42'),
(3, '{\"fa\": \"شیائومی\"}', '{\"fa\": \"شیائومی\"}', 'پردازنده', 3, 1, '2023-02-07 16:08:12', '2023-02-07 16:08:12'),
(4, '{\"fa\": \"xiaomi\"}', '{\"fa\": \"xiaomi\"}', 'پردازنده', 4, 1, '2023-02-07 16:17:37', '2023-02-07 16:17:37'),
(5, '{\"fa\": \"samsung\"}', '{\"fa\": \"samsung\"}', 'پردازنده', 5, 1, '2023-02-07 16:18:00', '2023-02-07 16:18:00'),
(6, '{\"fa\": \"apple\"}', '{\"fa\": \"apple\"}', 'پردازنده', 6, 1, '2023-02-07 16:18:17', '2023-02-07 16:18:17');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `seen` tinyint NOT NULL DEFAULT '0' COMMENT '0 => unseen, 1 => seen',
  `reference_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `priority_id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_reference_id_foreign` (`reference_id`),
  KEY `tickets_user_id_foreign` (`user_id`),
  KEY `tickets_category_id_foreign` (`category_id`),
  KEY `tickets_priority_id_foreign` (`priority_id`),
  KEY `tickets_ticket_id_foreign` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_admins`
--

DROP TABLE IF EXISTS `ticket_admins`;
CREATE TABLE IF NOT EXISTS `ticket_admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_admins_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_categories`
--

DROP TABLE IF EXISTS `ticket_categories`;
CREATE TABLE IF NOT EXISTS `ticket_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_files`
--

DROP TABLE IF EXISTS `ticket_files`;
CREATE TABLE IF NOT EXISTS `ticket_files` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_path` text COLLATE utf8mb4_general_ci NOT NULL,
  `file_size` bigint NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `ticket_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_files_ticket_id_foreign` (`ticket_id`),
  KEY `ticket_files_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_priorities`
--

DROP TABLE IF EXISTS `ticket_priorities`;
CREATE TABLE IF NOT EXISTS `ticket_priorities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_type` tinyint NOT NULL DEFAULT '0' COMMENT '0 => user, 1 => admin',
  `national_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile_verified_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `activation` tinyint NOT NULL DEFAULT '0' COMMENT '0 => inactive, 1 => active',
  `activation_date` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_general_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_general_ci,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_general_ci COMMENT 'avatar',
  `bio` text COLLATE utf8mb4_general_ci,
  `social_media` text COLLATE utf8mb4_general_ci,
  `followers_count` bigint DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_national_code_unique` (`national_code`),
  UNIQUE KEY `users_mobile_unique` (`mobile`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_type`, `national_code`, `mobile`, `mobile_verified_at`, `email`, `email_verified_at`, `activation`, `activation_date`, `status`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `slug`, `profile_photo_path`, `bio`, `social_media`, `followers_count`, `current_team_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'admin', 1, NULL, NULL, NULL, 'admin@admin.com', NULL, 1, NULL, 1, '$2y$10$tuhJv8qwiDvC.5zCX3aZAupB.BCltEm1SYWjsQgcmaUm46XDy4NsK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-07 11:17:39', '2023-02-07 11:17:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

DROP TABLE IF EXISTS `views`;
CREATE TABLE IF NOT EXISTS `views` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `viewable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `viewable_id` bigint UNSIGNED NOT NULL,
  `visitor` text COLLATE utf8mb4_general_ci,
  `collection` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `views_viewable_type_viewable_id_index` (`viewable_type`,`viewable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `addresses_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `amazing_sales`
--
ALTER TABLE `amazing_sales`
  ADD CONSTRAINT `amazing_sales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attribute_category`
--
ALTER TABLE `attribute_category`
  ADD CONSTRAINT `attribute_category_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attribute_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attribute_default_values`
--
ALTER TABLE `attribute_default_values`
  ADD CONSTRAINT `attribute_default_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attribute_default_values_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attribute_values_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `product_colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_guarantee_id_foreign` FOREIGN KEY (`guarantee_id`) REFERENCES `guarantees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_item_selected_attributes`
--
ALTER TABLE `cart_item_selected_attributes`
  ADD CONSTRAINT `cart_item_selected_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_item_selected_attributes_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_item_selected_attributes_cart_item_id_foreign` FOREIGN KEY (`cart_item_id`) REFERENCES `cart_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cash_payments`
--
ALTER TABLE `cash_payments`
  ADD CONSTRAINT `cash_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`);

--
-- Constraints for table `copans`
--
ALTER TABLE `copans`
  ADD CONSTRAINT `copans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guarantees`
--
ALTER TABLE `guarantees`
  ADD CONSTRAINT `guarantees_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offline_payments`
--
ALTER TABLE `offline_payments`
  ADD CONSTRAINT `offline_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `online_payments`
--
ALTER TABLE `online_payments`
  ADD CONSTRAINT `online_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_common_discount_id_foreign` FOREIGN KEY (`common_discount_id`) REFERENCES `common_discount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_copan_id_foreign` FOREIGN KEY (`copan_id`) REFERENCES `copans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_delivery_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `delivery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_amazing_sale_id_foreign` FOREIGN KEY (`amazing_sale_id`) REFERENCES `amazing_sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `product_colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_guarantee_id_foreign` FOREIGN KEY (`guarantee_id`) REFERENCES `guarantees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item_selected_attributes`
--
ALTER TABLE `order_item_selected_attributes`
  ADD CONSTRAINT `order_item_selected_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_selected_attributes_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_selected_attributes_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `otps`
--
ALTER TABLE `otps`
  ADD CONSTRAINT `otps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `post_categories` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_meta`
--
ALTER TABLE `product_meta`
  ADD CONSTRAINT `product_meta_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `provinces`
--
ALTER TABLE `provinces`
  ADD CONSTRAINT `provinces_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `public_mail_files`
--
ALTER TABLE `public_mail_files`
  ADD CONSTRAINT `public_mail_files_public_mail_id_foreign` FOREIGN KEY (`public_mail_id`) REFERENCES `public_mail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `taggables`
--
ALTER TABLE `taggables`
  ADD CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `ticket_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_priority_id_foreign` FOREIGN KEY (`priority_id`) REFERENCES `ticket_priorities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_reference_id_foreign` FOREIGN KEY (`reference_id`) REFERENCES `ticket_admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_admins`
--
ALTER TABLE `ticket_admins`
  ADD CONSTRAINT `ticket_admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_files`
--
ALTER TABLE `ticket_files`
  ADD CONSTRAINT `ticket_files_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
