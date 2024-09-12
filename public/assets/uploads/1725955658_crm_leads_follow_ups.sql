-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 05, 2024 at 07:49 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrterp`
--

-- --------------------------------------------------------

--
-- Table structure for table `crm_leads_follow_ups`
--

DROP TABLE IF EXISTS `crm_leads_follow_ups`;
CREATE TABLE IF NOT EXISTS `crm_leads_follow_ups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `lead_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sources` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pipeline_id` int DEFAULT NULL,
  `stage_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_leads_follow_ups_lead_id_foreign` (`lead_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `crm_leads_follow_ups`
--

INSERT INTO `crm_leads_follow_ups` (`id`, `lead_id`, `title`, `description`, `date`, `time`, `sources`, `pipeline_id`, `stage_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Demo meeting', '<p>Demo meeting<br></p>', '2024-09-05', '13:37', '9', 2, 6, '2024-09-04 07:40:24', '2024-09-04 07:40:24'),
(2, 1, 'Test', '<p>Test<br></p>', '2024-09-05', '19:10', '9', 2, 7, '2024-09-04 08:10:17', '2024-09-04 08:10:17');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
