-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 03, 2024 at 06:47 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `butiktrend`
--

-- --------------------------------------------------------

--
-- Table structure for table `boutiques`
--

DROP TABLE IF EXISTS `boutiques`;
CREATE TABLE IF NOT EXISTS `boutiques` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image3` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `view` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `boutiques`
--

INSERT INTO `boutiques` (`id`, `name`, `address`, `email`, `phone`, `image`, `image2`, `image3`, `description`, `created_at`, `updated_at`, `view`) VALUES
(1, 'TRIO', 'Banja Luka', 'trio@gmail.com', '065555555', '17101786201.jpg', '17101786202.jpg', '17101786203.jpg', 'Roba vrhunskog kvaliteta,trajno niske cijene', '2024-03-11 16:37:00', '2024-04-03 16:43:39', 121),
(3, 'SKOPI', 'Banja Luka i Celinac', 'skopi@gmail.com', '066666666', '17101794921.jpg', '17101794922.jpg', '17101794923.jpg', 'Nalazimo se na atraktivnim lokacijama u Banja Luci i Celincu', '2024-03-11 16:51:32', '2024-04-03 16:41:33', 28),
(6, 'NEW YORKER', 'TC DELTA', 'newyorker@gmail.com', '+38766462107', '17101797421.jpg', '17101797422.jpg', '17101797423.jpg', '', NULL, '2024-03-27 17:50:22', 10);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`, `image`) VALUES
(1, 'Muskarci', NULL, NULL, 'muskarci.jpg'),
(2, 'Zene', NULL, NULL, 'zene.jpg'),
(3, 'Djeca', NULL, NULL, 'djeca.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 'bvbvbbxc', '2024-03-28 17:45:06', '2024-03-28 17:45:06'),
(2, 1, 'sgg', '2024-03-28 17:47:03', '2024-03-28 17:47:03'),
(3, 1, 'bnnvncb', '2024-03-28 17:47:45', '2024-03-28 17:47:45'),
(4, 1, 'mmmb', '2024-03-28 17:48:43', '2024-03-28 17:48:43'),
(5, 1, 'NBMM', '2024-03-28 17:51:04', '2024-03-28 17:51:04'),
(6, 1, 'pORUKA', '2024-03-28 17:51:59', '2024-03-28 17:51:59'),
(7, 1, 'b,,b', '2024-03-28 18:14:59', '2024-03-28 18:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE IF NOT EXISTS `favorite` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favorite_product_id_foreign` (`product_id`),
  KEY `favorite_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`id`, `product_id`, `user_id`, `created_at`, `updated_at`) VALUES
(127, 17, 2, '2024-03-24 16:06:30', '2024-03-24 16:06:30'),
(120, 1, 1, '2024-03-18 19:00:23', '2024-03-18 19:00:23'),
(119, 4, 1, '2024-03-18 19:00:21', '2024-03-18 19:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_02_09_120908_create_boutiques_table', 2),
(13, '2024_02_11_184121_add_description_to_products', 7),
(8, '2024_02_10_141224_create_category_table', 4),
(9, '2024_02_10_141534_create_subcategory_table', 5),
(12, '2024_02_10_150240_create_products_table', 6),
(14, '2024_02_18_104431_add_color_to_products', 8),
(15, '2024_02_18_135316_add_size_to_products', 9),
(16, '2024_02_20_164922_add_quantity_to_products', 10),
(17, '2024_02_20_171914_add_total_to_products', 11),
(18, '2024_02_24_122749_add_image_to_category', 12),
(19, '2024_02_24_175411_add_featured_in_products', 13),
(20, '2024_02_26_153239_add_image_to_boutiques', 14),
(21, '2024_02_26_154940_add_description_to_boutiques', 15),
(22, '2024_02_27_191515_create_order_table', 16),
(23, '2024_02_28_180448_create_order_items_table', 17),
(24, '2024_02_28_183539_add_column_to_order_items', 18),
(25, '2024_02_28_184748_add_boutique_to_order_items', 19),
(26, '2024_02_28_184922_add_price_to_order_items', 20),
(27, '2024_03_06_181442_add_ordered_to_products', 21),
(28, '2024_03_11_155913_add_view_to_products', 22),
(29, '2024_03_11_155945_add_view_to_boutiques', 23),
(30, '2024_03_17_090410_create_favorite_table', 24),
(31, '2024_03_17_091408_change_boutique_id_in_products_table', 25),
(32, '2024_03_27_191524_create_contact_table', 26);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_surname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `customer_name`, `customer_surname`, `customer_address`, `customer_phone`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 'Sinisa', 'kuzmanovic', 'celinac', '066462107', '15.00', '2024-03-04 17:51:56', '2024-03-04 17:51:56'),
(2, 'sinisa', 'kuzma', 'cel', '111111111', '4544.00', '2024-03-06 17:04:12', '2024-03-06 17:04:12'),
(3, 'vxvxv', 'vxv', 'vxvx', '1111111111', '4544.00', '2024-03-06 17:07:42', '2024-03-06 17:07:42'),
(4, 'nmv,mn', ',n,', ',', '1111111111', '4544.00', '2024-03-06 17:17:49', '2024-03-06 17:17:49'),
(5, '.mm.', '.m.', '.m.', '111111111', '4544.00', '2024-03-06 17:18:37', '2024-03-06 17:18:37'),
(6, 'n.,//', '/,/', '/,/1111', '111111111', '4544.00', '2024-03-06 17:19:58', '2024-03-06 17:19:58'),
(7, ',mn,', ',n,', ',n,', '111111111', '4544.00', '2024-03-06 17:22:35', '2024-03-06 17:22:35'),
(8, ',mn,,', ',n,n,n', ',,n,n', '1111111111', '4544.00', '2024-03-06 17:23:18', '2024-03-06 17:23:18'),
(9, 'vjjbj', 'jbjjv', 'bjbjb', '111111111', '4544.00', '2024-03-06 18:59:09', '2024-03-06 18:59:09'),
(10, ',///m', '/,//', '/,/,/,', '111111111', '65.00', '2024-03-06 18:59:34', '2024-03-06 18:59:34'),
(11, ',,,,nn,m', 'nm,n,', ',n,n,n', '111111111', '25.00', '2024-03-07 14:56:49', '2024-03-07 14:56:49'),
(12, ',m..mm.', '.,mm', '.,m.m', '111111111', '130.00', '2024-03-10 10:02:28', '2024-03-10 10:02:28'),
(13, ',mn,n', ',n,n,', ',n,n,', '1111111111', '65.00', '2024-03-10 10:17:33', '2024-03-10 10:17:33'),
(14, 'vnbbv', 'nvnnvnvnv', 'nvnvnvv', '555555555', '9138.00', '2024-03-10 10:39:48', '2024-03-10 10:39:48'),
(15, 'mn,,n', ',n,n,', ',n,n', '066462107', '25.00', '2024-03-23 08:52:43', '2024-03-23 08:52:43'),
(16, 'mnbmbnv', 'mbnnv', 'mbm', '066462107', '130.00', '2024-03-27 17:45:12', '2024-03-27 17:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `product_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boutique` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_name_foreign` (`product_name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `product_id`, `order_id`, `product_name`, `product_size`, `quantity`, `product_color`, `boutique`, `product_price`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 'ffsfsd', 'bmbnmb', 1, 'red', 'TRIO', '4544.00', '2024-03-06 18:59:09', '2024-03-06 18:59:09'),
(3, 4, 11, 'Muske hlace jeans', 'S', 1, 'blue', 'TRIO', '25.00', '2024-03-07 14:56:49', '2024-03-07 14:56:49'),
(9, 18, 16, 'Trenerka muska', 'XL', 2, 'black', 'SKOPI', '65.00', '2024-03-27 17:45:12', '2024-03-27 17:45:12'),
(8, 5, 15, 'Zenske hlace jeans', 'S', 1, 'blue', 'TRIO', '25.00', '2024-03-23 08:52:43', '2024-03-23 08:52:43'),
(6, 3, 14, 'Muske hlace jeans', 'S', 2, 'blue', 'TRIO', '25.00', '2024-03-10 10:39:48', '2024-03-10 10:39:48'),
(7, 1, 14, 'ffsfsd', 'bmbnmb', 2, 'red', 'TRIO', '4544.00', '2024-03-10 10:39:48', '2024-03-10 10:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('112kuzmanovic@gmail.com', '$2y$12$W1H63DPZMgdMV1v/7GtO3uSvr.aByTjkP8r7c1ADPfkGKfpXir5XG', '2024-03-23 08:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `subcategory_id` bigint UNSIGNED NOT NULL,
  `boutique_id` bigint UNSIGNED NOT NULL,
  `image1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_price` decimal(8,2) DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart_quantity` int NOT NULL DEFAULT '1',
  `cart_total` decimal(8,2) NOT NULL DEFAULT '1.00',
  `ordered` int DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `view` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_subcategory_id_foreign` (`subcategory_id`),
  KEY `products_boutique_id_foreign` (`boutique_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `subcategory_id`, `boutique_id`, `image1`, `image2`, `image3`, `price`, `created_at`, `updated_at`, `description`, `old_price`, `color`, `size`, `cart_quantity`, `cart_total`, `ordered`, `featured`, `view`) VALUES
(14, 'product', 2, 15, 1, '17112667461.jpg', NULL, NULL, '44.00', '2024-03-24 06:52:26', '2024-03-26 18:26:57', ',kn,n,m,n', '444.00', 'white,yellow', 'XXL,XL,M,S,L', 1, '44.00', NULL, 1, 3),
(13, 'Muski vuneni Dzemper izmjena', 1, 8, 1, '17112045191.jpg', NULL, NULL, '35.00', '2024-03-23 13:35:19', '2024-03-31 12:23:26', 'Vuneni muski dzemper', '55.00', 'black,gray,green', 'XXL,XL,M,S,L', 1, '35.00', NULL, 0, 7),
(18, 'Trenerka muska', 1, 20, 3, '17114813941.jpg', '17114813942.jpg', '17114813943.jpg', '65.00', '2024-03-26 18:29:54', '2024-03-27 17:44:58', 'Muske pamucne trenerke,raznih modela po vrlo povoljnim cijenama', '85.00', 'blue,black,white', 'XXL,XL,M,S,L', 1, '65.00', NULL, 0, 3),
(16, 'Majica Nike kratki rukav', 1, 5, 1, '17112668201.jpg', NULL, NULL, '21.00', '2024-03-24 06:53:40', '2024-03-26 18:24:50', 'kljkljblblj', '32.00', 'red,orange,blue,green', 'XXL,XL,M,S,L', 1, '21.00', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE IF NOT EXISTS `subcategory` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subcategory_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `name`, `category_id`, `created_at`, `updated_at`) VALUES
(2, 'Zimske jakne', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Kosulje', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Proljetne jakne', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Majice kratki rukav', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Majice dugi rukav', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Duksevi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Dzemperi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Hlace', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Odijela', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Kravate', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Zimske jakne', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Kaputi', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Helanke', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Hlace', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'Majice', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'Duksevi', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'Majice kratki rukav', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Tunike', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'Trenerke', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sinisa', '112kuzmanovic@gmail.com', NULL, '$2y$12$LikTwVCFhY320F/G2faQ/.whmii8u7Eh6QL6dmLseCGhzSJUY.35e', NULL, '2024-02-09 11:04:25', '2024-02-09 11:04:25'),
(2, 'Leonrdo', 'leo@gmail.com', NULL, '$2y$12$7Iluo4eZv1m3M8KRne.zbu4hBWWPHANEXEJYBB2VFrJ7hpYcTrMyW', NULL, '2024-02-10 18:00:56', '2024-02-10 18:00:56'),
(3, 'Sinisa', 'trio@gmail.com', NULL, '$2y$12$UoJ7Jg/c9wBpggs2lJPVZOtElCWLH8HTL7nuPTnl0jOY.mdD7qAAO', NULL, '2024-03-02 12:59:10', '2024-03-02 12:59:10'),
(4, 'marko', 'dash@gmail.com', NULL, '$2y$12$9CRnD3xzwcctNuSpe1xdCOqQbctlgjVouBz40EYxwfUakQ0OfBwze', NULL, '2024-03-04 18:19:04', '2024-03-04 18:19:04'),
(5, 'Skopi', 'skopi@gmail.com', NULL, '$2y$12$SdGAO2K6Vg9gPv8hzzKyd.rWSvjEI5aK8DUi0fUI7VP0zoZzvF4tG', NULL, '2024-03-26 18:28:28', '2024-03-26 18:28:28');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
