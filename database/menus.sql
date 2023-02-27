-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 27, 2023 at 05:17 PM
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
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_parent_id_foreign` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `url`, `status`, `parent_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'فروش ویژه', '/products/special-sale', 1, NULL, '2023-02-26 09:48:16', '2023-02-26 09:48:16', NULL),
(2, 'سابقه شغلی', '/pages/career', 1, 13, '2023-02-26 09:48:16', '2023-02-27 16:31:53', NULL),
(3, 'شرایط گارانتی', '/pages/warranty-rules', 1, NULL, '2023-02-26 09:48:16', '2023-02-27 16:33:13', NULL),
(4, 'درباره ما', '/pages/about-us', 1, 13, '2023-02-26 09:48:16', '2023-02-27 16:33:57', NULL),
(5, 'تماس با ما', '/pages/contact-us', 1, 13, '2023-02-26 09:48:16', '2023-02-27 16:34:21', NULL),
(6, 'شرایط و قوانین ما', '/pages/privacy-policy', 1, 13, '2023-02-26 09:48:16', '2023-02-27 16:34:44', NULL),
(7, 'خرید اقساطی', '/pages/installment', 1, NULL, '2023-02-26 09:48:16', '2023-02-26 09:48:16', NULL),
(8, 'ثبت قرار ملاقات', '/pages/make-appointment', 1, 13, '2023-02-26 09:48:16', '2023-02-27 16:35:21', NULL),
(9, 'راهنمای خرید', '/pages/how-to-buy', 1, NULL, '2023-02-26 09:48:16', '2023-02-26 09:48:16', NULL),
(10, 'پلن های قیمت گذاری ما', '/pages/price-plans', 1, 13, '2023-02-26 09:48:16', '2023-02-26 09:48:16', NULL),
(11, 'چرا شاپ بیز', '/pages/why-this-shop', 1, NULL, '2023-02-26 09:48:16', '2023-02-26 09:48:16', NULL),
(12, 'سوالات متداول', '/pages/faq', 1, 13, '2023-02-26 09:48:16', '2023-02-26 09:48:16', NULL),
(13, 'سایر ...', '/', 1, NULL, '2023-02-01 16:31:27', '2023-02-27 16:31:27', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
