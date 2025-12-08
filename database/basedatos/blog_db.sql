-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2025 at 09:11 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED NOT NULL,
  `treatment_id` bigint UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `duration` int NOT NULL DEFAULT '30',
  `status` enum('scheduled','confirmed','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `disease` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `slug`, `patient_id`, `doctor_id`, `treatment_id`, `appointment_date`, `appointment_time`, `duration`, `status`, `disease`, `cost`, `paid`, `notes`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'COEs44inu8ZT6y7MDVYiDG', 4, 2, 7, '2025-12-20', '16:44:00', 30, 'scheduled', NULL, 100.00, 0.00, NULL, 1, NULL, NULL, '2025-12-01 21:44:54', '2025-12-02 21:03:10', NULL),
(2, 'MVEj4NcMzyWYjTaExhVOG4', 3, 1, 15, '2025-12-10', '16:03:00', 30, 'scheduled', NULL, 100.00, 0.00, NULL, 1, NULL, NULL, '2025-12-02 21:03:55', '2025-12-02 21:03:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_histories`
--

CREATE TABLE `appointment_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `changed_by` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:6:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";s:1:\"j\";s:4:\"slug\";s:1:\"k\";s:11:\"description\";}s:11:\"permissions\";a:121:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:18:\"consultations.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:18:\"consultations.show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:20:\"consultations.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:18:\"consultations.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:20:\"consultations.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:20:\"consultations.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:22:\"consultations.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"languages.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"languages.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:14:\"languages.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"languages.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:16:\"languages.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:18:\"languages.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:5;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:12:\"tenants.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"tenants.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:12:\"tenants.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:14:\"tenants.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"tenants.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:16:\"tenants.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:12:\"regions.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:14:\"regions.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"regions.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"regions.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:14:\"regions.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:16:\"regions.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:10:\"roles.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:12:\"roles.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:10:\"roles.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:12:\"roles.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:12:\"roles.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:14:\"roles.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:14:\"countries.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:16:\"countries.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:14:\"countries.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:16:\"countries.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:16:\"countries.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:18:\"countries.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:10:\"users.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:12:\"users.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:14:\"users.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:14:\"companies.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:16:\"companies.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:14:\"companies.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:16:\"companies.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:16:\"companies.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:18:\"companies.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:12:\"doctors.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:14:\"doctors.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:12:\"doctors.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:14:\"doctors.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:14:\"doctors.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:16:\"doctors.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:13:\"patients.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:15:\"patients.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:13:\"patients.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:15:\"patients.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:15:\"patients.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:17:\"patients.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:15:\"treatments.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:17:\"treatments.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:15:\"treatments.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:17:\"treatments.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:17:\"treatments.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:19:\"treatments.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:17:\"appointments.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:19:\"appointments.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:17:\"appointments.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:19:\"appointments.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:19:\"appointments.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:21:\"appointments.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:16:\"specialties.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:18:\"specialties.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:16:\"specialties.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:18:\"specialties.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:18:\"specialties.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:20:\"specialties.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:15:\"odontogram.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:17:\"odontogram.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:15:\"odontogram.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:17:\"odontogram.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:17:\"odontogram.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:19:\"odontogram.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:13:\"payments.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:15:\"payments.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:13:\"payments.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:15:\"payments.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:15:\"payments.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:17:\"payments.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:12:\"reports.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:14:\"reports.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:12:\"reports.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:14:\"reports.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:14:\"reports.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:16:\"reports.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:12:\"summary.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:14:\"summary.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:12:\"summary.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:14:\"summary.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:14:\"summary.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:16:\"summary.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:13:\"calendar.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:15:\"calendar.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:13:\"calendar.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:15:\"calendar.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:15:\"calendar.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:108;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:17:\"calendar.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:109;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:24:\"appointment_history.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:110;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:26:\"appointment_history.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:111;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:24:\"appointment_history.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:112;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:26:\"appointment_history.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:113;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:26:\"appointment_history.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:114;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:28:\"appointment_history.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:115;a:4:{s:1:\"a\";i:116;s:1:\"b\";s:19:\"system_modules.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:116;a:4:{s:1:\"a\";i:117;s:1:\"b\";s:21:\"system_modules.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:117;a:4:{s:1:\"a\";i:118;s:1:\"b\";s:19:\"system_modules.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:118;a:4:{s:1:\"a\";i:119;s:1:\"b\";s:21:\"system_modules.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:119;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:21:\"system_modules.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:120;a:4:{s:1:\"a\";i:121;s:1:\"b\";s:23:\"system_modules.edit_all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}}s:5:\"roles\";a:5:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"super\";s:1:\"j\";s:22:\"JYIDmXiHqvdnpqEbfgmUf9\";s:1:\"k\";s:24:\"Super Admin: Full Access\";s:1:\"c\";s:3:\"web\";}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"admin\";s:1:\"j\";s:22:\"sjZfgRgFeOC8tZUfRIED2H\";s:1:\"k\";s:20:\"Tenant Administrator\";s:1:\"c\";s:3:\"web\";}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:6:\"doctor\";s:1:\"j\";s:22:\"v6yAp49NB3JoFlfORnv8o0\";s:1:\"k\";s:43:\"Medical Doctor: Access to dental management\";s:1:\"c\";s:3:\"web\";}i:3;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:16:\"language_manager\";s:1:\"j\";s:22:\"bVQuVqiFVIxNqne1jZs1aE\";s:1:\"k\";s:24:\"Manages system languages\";s:1:\"c\";s:3:\"web\";}i:4;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:4:\"user\";s:1:\"j\";s:22:\"fN9RAImaZtzE1TJL8BWDBY\";s:1:\"k\";s:18:\"User with profiles\";s:1:\"c\";s:3:\"web\";}}}', 1764794628);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `treatment_id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED NOT NULL,
  `consultation_date` date NOT NULL,
  `consultation_time` time DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `consultation_reason` text COLLATE utf8mb4_unicode_ci,
  `diagnosis` text COLLATE utf8mb4_unicode_ci,
  `fever` decimal(4,1) DEFAULT NULL,
  `blood_pressure` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `slug`, `patient_id`, `treatment_id`, `doctor_id`, `consultation_date`, `consultation_time`, `cost`, `description`, `consultation_reason`, `diagnosis`, `fever`, `blood_pressure`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'aJs4Mwno9zAN3kwWBTwiuW', 1, 2, 1, '2025-12-10', '15:43:00', 300.00, 'wefwf', NULL, NULL, 36.0, '120/80', 1, 1, NULL, NULL, '2025-12-01 20:45:06', '2025-12-01 20:45:06', NULL),
(2, 'Hj19rW5FDhg82EIAvQpdPQ', 2, 1, 1, '2025-12-15', '15:46:00', 200.00, 'feqwfw', NULL, NULL, 38.0, '120/80', 1, 1, NULL, NULL, '2025-12-01 20:47:49', '2025-12-01 20:47:49', NULL),
(3, 'o5i7ukA3EpBk1rSfKFUHtA', 3, 7, 3, '2025-12-10', '15:58:00', 100.00, 'aaaaaaaaaaa', NULL, NULL, 37.0, NULL, 1, 1, NULL, NULL, '2025-12-02 21:00:18', '2025-12-02 21:00:18', NULL),
(4, 'V4bQWOJYOqURHt5d5Zeus1', 4, 15, 2, '2025-12-20', '16:00:00', 100.00, 'aaaaaaaaaaaaa', NULL, NULL, 38.0, '120/80', 1, 1, NULL, NULL, '2025-12-02 21:02:03', '2025-12-02 21:02:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_locale_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `slug`, `region_id`, `name`, `iso_code`, `currency`, `timezone`, `default_locale_id`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'xuGjmrGfpwvkZj9CjUVvck', 1, 'Perú', 'PE', 'PEN', 'America/Lima', 1, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(2, 'AOVHOy5wYHxKCfigxiP1ag', 1, 'Venezuela', 'VE', 'VES', 'America/Caracas', 2, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(3, 'QgcqvIusLvfaIDSzs7AVlK', 1, 'Brasil', 'BR', 'BRL', 'America/Sao_Paulo', 3, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(4, 'C1Wny6KBnkbhnYBWswz9tl', 2, 'Estados Unidos', 'US', 'USD', 'America/New_York', 4, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(5, 'JiUlPCoYUkvYn6xAnGlzJD', 1, 'Chile', 'CL', 'CLP', 'America/Santiago', 5, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `country_languages`
--

CREATE TABLE `country_languages` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `slug`, `name`, `last_name`, `document_type`, `document`, `email`, `phone`, `address`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'efOqTjB7usVwjPgyoAq8Rl', 'LIZ LADY', 'CARBAJAL RAIME', 'dni', '45424165', 'frank45@nerio18pe.com', '987654321', 'Av. Los Pinos 234, Santiago de Surco, Lima', 1, 1, NULL, NULL, 13, '2025-12-01 20:43:46', '2025-12-02 20:55:33', NULL),
(2, 'QPxgCehRufMt459BGnXgZK', 'SANTOS', 'SEMBRERA SANTOS', 'dni', '45139751', 'disney.family@email.com', '999999999', 'Jr. Libertad 582, Cercado de Arequipa, Arequipa', 1, 1, NULL, NULL, 14, '2025-12-01 21:26:45', '2025-12-02 20:55:49', NULL),
(3, 'mYfTqvE0eNmVpkHBLDrZUS', 'LUIS RODOLFO', 'GAMERO LOPEZ', 'dni', '45249541', 'marcos.perez92@gmail.com', '954123548', 'Calle Las Gardenias 119, San Isidro, Lima', 1, 1, NULL, NULL, 15, '2025-12-02 20:57:09', '2025-12-02 20:57:09', NULL),
(4, 'sH3zW7GWNdP08mVMyovdU0', 'BETTY LUCIA', 'INGUNZA RODRIGUEZ', 'dni', '43615487', 'bettyd43@gmail.com', '984215741', 'Mz. B Lt. 14, Urb. Santa Rosa, Trujillo', 1, 1, NULL, NULL, 16, '2025-12-02 20:57:54', '2025-12-02 20:57:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_specialty`
--

CREATE TABLE `doctor_specialty` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED NOT NULL,
  `specialty_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_specialty`
--

INSERT INTO `doctor_specialty` (`id`, `doctor_id`, `specialty_id`, `created_at`, `updated_at`) VALUES
(3, 2, 6, '2025-12-01 21:26:45', '2025-12-01 21:26:45'),
(4, 2, 7, '2025-12-01 21:26:45', '2025-12-01 21:26:45'),
(5, 1, 2, '2025-12-02 20:55:33', '2025-12-02 20:55:33'),
(6, 1, 4, '2025-12-02 20:55:33', '2025-12-02 20:55:33'),
(7, 3, 6, '2025-12-02 20:57:09', '2025-12-02 20:57:09'),
(8, 3, 14, '2025-12-02 20:57:09', '2025-12-02 20:57:09'),
(9, 4, 11, '2025-12-02 20:57:54', '2025-12-02 20:57:54'),
(10, 4, 14, '2025-12-02 20:57:54', '2025-12-02 20:57:54');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('pdf','excel','word') COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','processing','ready','expired','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `expires_at` timestamp NULL DEFAULT NULL,
  `downloaded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `slug`, `name`, `iso_code`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'tKBIHza5PpKpejS6yxncmc', 'es', 'es', 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(2, 'nTBycxIxRGm5N2JglPclVr', 'en', 'en', 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(3, 'lqXD1rozMupV3O8Se7ZyT7', 'pt', 'pt', 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(4, 'ilpOWhxSrzRYqskObjiOVy', 'fr', 'fr', 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locales`
--

CREATE TABLE `locales` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locales`
--

INSERT INTO `locales` (`id`, `slug`, `code`, `name`, `language_id`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'x7or09jZ73Wrdaw8PC4sMi', 'es_PE', 'es_PE', 1, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(2, 'WhHEgwqn9Ryc52tBl1flxo', 'es_VE', 'es_VE', 1, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(3, '1lzcwBKGQm8YQbNqFnRgMk', 'pt_BR', 'pt_BR', 3, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(4, '74yNLOTzHQgQ6X0VqQ8iqo', 'en_US', 'en_US', 2, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(5, 'JwaYuVtyCWw5NmDOxE1R2K', 'es_CL', 'es_CL', 1, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_01_01_000001_create_cache_table', 1),
(2, '2025_01_01_000002_create_jobs_table', 1),
(3, '2025_09_18_090001_create_tenants_table', 1),
(4, '2025_09_18_090006_create_tenant_countries_table', 1),
(5, '2025_09_18_090021_create_regions_table', 1),
(6, '2025_09_18_090150_create_languages_table', 1),
(7, '2025_09_18_090436_create_locales_table', 1),
(8, '2025_09_18_090437_create_countries_table', 1),
(9, '2025_09_18_093342_create_country_languages_table', 1),
(10, '2025_09_18_093438_create_settings_table', 1),
(11, '2025_09_18_093438_create_users_table', 1),
(12, '2025_09_18_093509_create_permission_tables', 1),
(13, '2025_09_18_093709__create_downloads_table', 1),
(14, '2025_09_20_230937_create_system_modules_table', 1),
(15, '2025_09_24_070056_create_personal_access_tokens_table', 1),
(16, '2025_10_14_033502_add_slug_to_roles_table', 1),
(17, '2025_10_14_052447_add_deleted_at_to_roles_table', 1),
(18, '2025_11_03_203637_create_patients_table', 1),
(19, '2025_11_03_203851_create_specialties_table', 1),
(20, '2025_11_03_204525_create_doctors_table', 1),
(21, '2025_11_03_204849_create_treatments_table', 1),
(22, '2025_11_03_205205_create_appointments_table', 1),
(23, '2025_11_03_205514_create_odontograms_table', 1),
(24, '2025_11_03_210110_create_appointment_histories_table', 1),
(25, '2025_11_03_211028_create_payments_table', 1),
(26, '2025_11_04_010000_add_missing_fields_to_patients_table', 1),
(27, '2025_11_04_034939_add_missing_fields_to_doctors_table', 1),
(28, '2025_11_05_055940_add_license_number_to_doctors_table', 1),
(29, '2025_11_05_220500_remove_license_number_from_doctors_table', 1),
(30, '2025_11_06_035000_create_doctor_specialty_table', 1),
(31, '2025_11_06_035100_migrate_doctor_specialty_data', 1),
(32, '2025_11_06_040000_update_doctor_specialty_timestamps', 1),
(33, '2025_11_06_050000_add_user_id_to_doctors_table', 1),
(34, '2025_11_07_120000_remove_duration_from_treatments_table', 1),
(35, '2025_11_07_130500_add_financial_fields_to_appointments_table', 1),
(36, '2025_11_11_030000_add_disease_column_to_appointments_table', 1),
(37, '2025_11_16_214633_add_description_fields_to_patients_table', 1),
(38, '2025_11_16_215706_add_gender_to_patients_table', 1),
(39, '2025_11_16_233744_make_pregnant_nullable_in_patients_table', 1),
(40, '2025_11_18_000000_create_consultations_table', 1),
(41, '2025_11_18_190000_add_consultations_module_permissions', 1),
(42, '2025_11_19_021700_add_color_to_treatments_table', 1),
(43, '2025_11_19_064344_create_patient_images_table', 1),
(44, '2025_11_19_090500_add_coverage_to_treatments_table', 1),
(45, '2025_11_20_010000_create_treatment_history_table', 1),
(46, '2025_11_24_054529_remove_unused_patient_columns', 1),
(47, '2025_11_25_000000_add_consultation_reason_and_diagnosis_to_consultations_table', 1),
(48, '2025_11_25_000000_update_odontogram_storage', 1),
(49, '2025_11_25_090027_drop_unused_description_columns_from_patients_table', 1),
(50, '2025_11_25_212800_add_deleted_at_to_treatment_history_table', 1),
(51, '2025_11_26_000100_add_missing_medical_descriptions_to_patients_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(5, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16);

-- --------------------------------------------------------

--
-- Table structure for table `odontograms`
--

CREATE TABLE `odontograms` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `odontograms`
--

INSERT INTO `odontograms` (`id`, `slug`, `patient_id`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'kiuKMi0UsIL1rW11BzB2B8', 1, 1, 1, NULL, NULL, '2025-12-01 20:45:06', '2025-12-01 21:12:22', NULL),
(2, 'quu0HKiZg09yqKdCzPqcqw', 2, 1, 1, NULL, NULL, '2025-12-01 20:47:49', '2025-12-01 20:47:49', NULL),
(3, 'c8EaZsKwrg0FK8duU1ueor', 3, 1, 1, NULL, NULL, '2025-12-02 21:00:18', '2025-12-02 21:06:35', NULL),
(4, 'eBUgFtNWWaRaojlQlKAu3i', 4, 1, 1, NULL, NULL, '2025-12-02 21:02:03', '2025-12-02 21:02:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `odontogram_details`
--

CREATE TABLE `odontogram_details` (
  `id` bigint UNSIGNED NOT NULL,
  `odontogram_history_id` bigint UNSIGNED NOT NULL,
  `treatment_id` bigint UNSIGNED DEFAULT NULL,
  `tooth_number_surfaces` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `odontogram_details`
--

INSERT INTO `odontogram_details` (`id`, `odontogram_history_id`, `treatment_id`, `tooth_number_surfaces`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '{\"surfaces\": {\"center\": {\"color\": \"#00ff6e\", \"condition\": \"treatment_2\"}}, \"condition\": \"healthy\", \"tooth_number\": 18}', '2025-12-01 21:07:31', '2025-12-01 21:07:31'),
(2, 2, 2, '{\"surfaces\": {\"center\": {\"color\": \"#00ff6e\", \"condition\": \"treatment_2\"}}, \"condition\": \"healthy\", \"tooth_number\": 18}', '2025-12-01 21:08:00', '2025-12-01 21:08:00'),
(3, 2, 2, '{\"surfaces\": {\"center\": {\"color\": \"#00ff6e\", \"condition\": \"treatment_2\"}}, \"condition\": \"healthy\", \"tooth_number\": 17}', '2025-12-01 21:08:00', '2025-12-01 21:08:00'),
(4, 3, 2, '{\"surfaces\": {\"center\": {\"color\": \"#00ff6e\", \"condition\": \"treatment_2\"}}, \"condition\": \"healthy\", \"tooth_number\": 18}', '2025-12-01 21:12:22', '2025-12-01 21:12:22'),
(5, 3, 2, '{\"surfaces\": {\"center\": {\"color\": \"#00ff6e\", \"condition\": \"treatment_2\"}}, \"condition\": \"healthy\", \"tooth_number\": 17}', '2025-12-01 21:12:22', '2025-12-01 21:12:22'),
(6, 3, 1, '{\"color\": \"#007bff\", \"surfaces\": {\"top\": {\"color\": \"#007bff\", \"condition\": \"treatment_1\"}, \"left\": {\"color\": \"#007bff\", \"condition\": \"treatment_1\"}, \"right\": {\"color\": \"#007bff\", \"condition\": \"treatment_1\"}, \"bottom\": {\"color\": \"#007bff\", \"condition\": \"treatment_1\"}, \"center\": {\"color\": \"#007bff\", \"condition\": \"treatment_1\"}}, \"condition\": \"treatment_1\", \"tooth_number\": 16}', '2025-12-01 21:12:22', '2025-12-01 21:12:22'),
(7, 4, 7, '{\"surfaces\": {\"center\": {\"color\": \"#ffff00\", \"condition\": \"treatment_7\"}}, \"condition\": \"healthy\", \"tooth_number\": 47}', '2025-12-02 21:05:24', '2025-12-02 21:05:24'),
(8, 5, 7, '{\"surfaces\": {\"center\": {\"color\": \"#ffff00\", \"condition\": \"treatment_7\"}}, \"condition\": \"healthy\", \"tooth_number\": 47}', '2025-12-02 21:05:55', '2025-12-02 21:05:55'),
(9, 5, 11, '{\"color\": \"#808080\", \"surfaces\": {\"top\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}, \"left\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}, \"right\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}, \"bottom\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}, \"center\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}}, \"condition\": \"treatment_11\", \"tooth_number\": 72}', '2025-12-02 21:05:55', '2025-12-02 21:05:55'),
(10, 6, 7, '{\"surfaces\": {\"center\": {\"color\": \"#ffff00\", \"condition\": \"treatment_7\"}}, \"condition\": \"healthy\", \"tooth_number\": 47}', '2025-12-02 21:06:35', '2025-12-02 21:06:35'),
(11, 6, 11, '{\"color\": \"#808080\", \"surfaces\": {\"top\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}, \"left\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}, \"right\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}, \"bottom\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}, \"center\": {\"color\": \"#808080\", \"condition\": \"treatment_11\"}}, \"condition\": \"treatment_11\", \"tooth_number\": 72}', '2025-12-02 21:06:35', '2025-12-02 21:06:35'),
(12, 6, 14, '{\"surfaces\": {\"top\": {\"color\": \"#800080\", \"condition\": \"treatment_14\"}, \"left\": {\"color\": \"#800080\", \"condition\": \"treatment_14\"}, \"right\": {\"color\": \"#800080\", \"condition\": \"treatment_14\"}, \"bottom\": {\"color\": \"#800080\", \"condition\": \"treatment_14\"}}, \"condition\": \"healthy\", \"tooth_number\": 42}', '2025-12-02 21:06:35', '2025-12-02 21:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `odontogram_histories`
--

CREATE TABLE `odontogram_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `odontogram_id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `date_procedure` datetime DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `odontogram_histories`
--

INSERT INTO `odontogram_histories` (`id`, `odontogram_id`, `doctor_id`, `created_by`, `date_procedure`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '2025-12-01 16:07:31', 'aaaaa', '2025-12-01 21:07:31', '2025-12-01 21:07:31', NULL),
(2, 1, 1, 1, '2025-12-01 16:08:00', 'bbbbbb', '2025-12-01 21:08:00', '2025-12-01 21:08:00', NULL),
(3, 1, 2, 1, '2025-12-01 16:12:22', 'ddddd', '2025-12-01 21:12:22', '2025-12-01 21:35:17', NULL),
(4, 3, 2, 1, '2025-12-02 16:05:24', 'aaaa', '2025-12-02 21:05:24', '2025-12-02 21:05:24', NULL),
(5, 3, 2, 1, '2025-12-02 16:05:55', 'bbb', '2025-12-02 21:05:55', '2025-12-02 21:05:55', NULL),
(6, 3, 2, 1, '2025-12-02 16:06:35', 'cccc', '2025-12-02 21:06:35', '2025-12-02 21:06:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_history` text COLLATE utf8mb4_unicode_ci,
  `under_medical_treatment` tinyint(1) NOT NULL DEFAULT '0',
  `under_medical_treatment_description` text COLLATE utf8mb4_unicode_ci,
  `prone_to_bleeding` tinyint(1) NOT NULL DEFAULT '0',
  `allergic_to_medication` tinyint(1) NOT NULL DEFAULT '0',
  `allergic_to_medication_description` text COLLATE utf8mb4_unicode_ci,
  `hypertensive` tinyint(1) NOT NULL DEFAULT '0',
  `diabetic` tinyint(1) NOT NULL DEFAULT '0',
  `pregnant` tinyint(1) DEFAULT NULL,
  `pregnant_description` text COLLATE utf8mb4_unicode_ci,
  `diabetic_description` text COLLATE utf8mb4_unicode_ci,
  `hypertensive_description` text COLLATE utf8mb4_unicode_ci,
  `prone_to_bleeding_description` text COLLATE utf8mb4_unicode_ci,
  `observations` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `slug`, `document_type`, `document`, `name`, `last_name`, `gender`, `email`, `phone`, `birth_date`, `address`, `emergency_contact`, `medical_history`, `under_medical_treatment`, `under_medical_treatment_description`, `prone_to_bleeding`, `allergic_to_medication`, `allergic_to_medication_description`, `hypertensive`, `diabetic`, `pregnant`, `pregnant_description`, `diabetic_description`, `hypertensive_description`, `prone_to_bleeding_description`, `observations`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '4tBWx9MZj0pT2EOxdOtfqo', 'dni', '76754922', 'NERIO', 'CRUZ AYQUIPA', 'M', 'cruzmaster18full@gmail.com', '977675651', '2004-11-21', 'Nuevo San Juan MZ D Lote 15', '914006847', NULL, 0, NULL, 0, 1, 'paracetamol', 0, 0, NULL, NULL, NULL, NULL, NULL, 'aaaaaa', 1, 1, 1, 'gggggggggggggggggggg', '2025-12-01 20:45:05', '2025-12-02 20:58:25', '2025-12-02 20:58:25'),
(2, 'SHVdwL4rGfx5pUl1VLNED8', 'dni', '76736002', 'KENIN', 'CRUZ AYQUIPA', 'M', 'moracas33@nerio18pe.com', '988888888', '2002-06-16', 'Nuevo San Juan MZ D Lote 15', '955457655', NULL, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 'fwef', 1, 1, 1, 'aaaaaaaaaaaaaaaaaa', '2025-12-01 20:47:49', '2025-12-02 20:58:18', '2025-12-02 20:58:18'),
(3, 'gHvHCBmPwpmGkVSUCabApU', 'dni', '42165874', 'MERY', 'CHAMBI ALCA', 'F', 'mery@gmail.com', '965418745', '2000-07-21', 'Av. Independencia 902, Chiclayo', '951235417', NULL, 0, NULL, 0, 1, 'paracetamol', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-02 21:00:18', '2025-12-02 21:00:18', NULL),
(4, 'k7DPJRwft23bRBzVnA4Qs1', 'dni', '45246384', 'LOURDES GIOVANA', 'ARONI MURILLO', 'F', 'lourdes@gmail.com', '954123654', '2002-10-23', 'Calle Lima 214, Cajamarca', '984125648', NULL, 0, NULL, 0, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-02 21:02:03', '2025-12-02 21:02:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_images`
--

CREATE TABLE `patient_images` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient_images`
--

INSERT INTO `patient_images` (`id`, `slug`, `patient_id`, `title`, `filename`, `description`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'CkxJXSCQnyGRhUgaO14LL1', 1, 'aaaa', 'patient_1_img_1764622594_692e010297e88.png', 'fewf', 1, 1, 1, 'frrrrrrrrrrrrrrrr', '2025-12-01 20:56:34', '2025-12-01 20:57:12', '2025-12-01 20:57:12'),
(2, '6h2OIL3MNI57sEtYVgkFkE', 1, 'aaaaaa', 'patient_1_img_1764622647_692e0137c971c.png', 'aaaaaaaaa', 1, 1, NULL, NULL, '2025-12-01 20:57:27', '2025-12-01 20:57:27', NULL),
(3, 'e4fp7MA6qaSMP1GAIpDRoX', 1, 'bbbbbbbbb', 'patient_1_img_1764622870_692e02162ece2.png', 'bbbbbbbbbb', 1, 1, NULL, NULL, '2025-12-01 21:01:10', '2025-12-01 21:01:10', NULL),
(4, 'eXF8GbyMyo2SbuLqB1b6aL', 1, 'cccc', 'patient_1_img_1764623206_692e03663b2c4.png', 'cccc', 1, 1, NULL, NULL, '2025-12-01 21:06:46', '2025-12-01 21:06:46', NULL),
(5, '9gFFBNwRfwCZT7uWGTvPYC', 3, 'aaaa', 'patient_3_img_1764709751_692f55777d2b7.png', 'ccccccccccccccccccccc', 1, 1, NULL, NULL, '2025-12-02 21:09:11', '2025-12-02 21:09:11', NULL),
(6, 'FGtlhHEtZutR5bdP8fdCzF', 3, 'bbbb', 'patient_3_img_1764709786_692f559a871a9.png', 'ddddddd', 1, 1, NULL, NULL, '2025-12-02 21:09:46', '2025-12-02 21:09:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_id` bigint UNSIGNED DEFAULT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` enum('cash','card','transfer','check') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `status` enum('pending','completed','cancelled','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reference_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `slug`, `appointment_id`, `patient_id`, `amount`, `payment_date`, `payment_method`, `status`, `reference_number`, `notes`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'h1zY35ESLJFDS66NOJpWs7', 2, 3, 50.00, '2025-12-02', 'cash', 'completed', '12', NULL, 1, NULL, NULL, '2025-12-02 21:07:17', '2025-12-02 21:07:31', NULL),
(2, 'CW6PUxwMLKC7AkSMMM6dRO', 2, 3, 50.00, '2025-12-02', 'cash', 'completed', '13', NULL, 1, NULL, NULL, '2025-12-02 21:07:54', '2025-12-02 21:07:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'consultations.view', 'web', '2025-12-01 19:02:00', '2025-12-01 19:02:00'),
(2, 'consultations.show', 'web', '2025-12-01 19:02:00', '2025-12-01 19:02:00'),
(3, 'consultations.create', 'web', '2025-12-01 19:02:00', '2025-12-01 19:02:00'),
(4, 'consultations.edit', 'web', '2025-12-01 19:02:00', '2025-12-01 19:02:00'),
(5, 'consultations.delete', 'web', '2025-12-01 19:02:00', '2025-12-01 19:02:00'),
(6, 'consultations.export', 'web', '2025-12-01 19:02:00', '2025-12-01 19:02:00'),
(7, 'consultations.edit_all', 'web', '2025-12-01 19:02:00', '2025-12-01 19:02:00'),
(8, 'languages.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(9, 'languages.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(10, 'languages.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(11, 'languages.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(12, 'languages.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(13, 'languages.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(14, 'tenants.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(15, 'tenants.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(16, 'tenants.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(17, 'tenants.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(18, 'tenants.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(19, 'tenants.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(20, 'regions.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(21, 'regions.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(22, 'regions.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(23, 'regions.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(24, 'regions.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(25, 'regions.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(26, 'roles.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(27, 'roles.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(28, 'roles.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(29, 'roles.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(30, 'roles.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(31, 'roles.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(32, 'countries.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(33, 'countries.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(34, 'countries.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(35, 'countries.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(36, 'countries.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(37, 'countries.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(38, 'users.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(39, 'users.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(40, 'users.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(41, 'users.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(42, 'users.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(43, 'users.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(44, 'companies.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(45, 'companies.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(46, 'companies.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(47, 'companies.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(48, 'companies.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(49, 'companies.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(50, 'doctors.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(51, 'doctors.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(52, 'doctors.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(53, 'doctors.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(54, 'doctors.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(55, 'doctors.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(56, 'patients.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(57, 'patients.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(58, 'patients.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(59, 'patients.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(60, 'patients.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(61, 'patients.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(62, 'treatments.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(63, 'treatments.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(64, 'treatments.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(65, 'treatments.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(66, 'treatments.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(67, 'treatments.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(68, 'appointments.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(69, 'appointments.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(70, 'appointments.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(71, 'appointments.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(72, 'appointments.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(73, 'appointments.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(74, 'specialties.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(75, 'specialties.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(76, 'specialties.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(77, 'specialties.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(78, 'specialties.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(79, 'specialties.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(80, 'odontogram.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(81, 'odontogram.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(82, 'odontogram.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(83, 'odontogram.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(84, 'odontogram.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(85, 'odontogram.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(86, 'payments.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(87, 'payments.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(88, 'payments.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(89, 'payments.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(90, 'payments.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(91, 'payments.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(92, 'reports.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(93, 'reports.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(94, 'reports.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(95, 'reports.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(96, 'reports.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(97, 'reports.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(98, 'summary.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(99, 'summary.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(100, 'summary.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(101, 'summary.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(102, 'summary.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(103, 'summary.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(104, 'calendar.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(105, 'calendar.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(106, 'calendar.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(107, 'calendar.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(108, 'calendar.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(109, 'calendar.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(110, 'appointment_history.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(111, 'appointment_history.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(112, 'appointment_history.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(113, 'appointment_history.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(114, 'appointment_history.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(115, 'appointment_history.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(116, 'system_modules.view', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(117, 'system_modules.create', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(118, 'system_modules.edit', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(119, 'system_modules.delete', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(120, 'system_modules.export', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01'),
(121, 'system_modules.edit_all', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `slug`, `name`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'y2WdPvEIAEXeaGjjJJiZ2k', 'América del Sur', 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(2, 'J55C4gxbc74pUJRXmpVcjx', 'América del Norte', 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(3, 'RmP93FmxpeJq2MeSJBLz3D', 'Europa', 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(4, 'jZysnTIeSvMLCVOfuO4akn', 'aaa', 1, 1, NULL, NULL, '2025-12-01 19:40:00', '2025-12-01 19:40:00', NULL),
(5, 'QkutAHAtJsjxjDgMNO8312', 'bbbb', 1, 1, NULL, NULL, '2025-12-01 19:40:06', '2025-12-01 19:40:06', NULL),
(6, 'CXm44EZ46wXa5S4aRew0PZ', 'cccc', 1, 1, NULL, NULL, '2025-12-01 19:40:16', '2025-12-01 19:40:16', NULL),
(7, 'kLWTWeWSGCrJ4Opbg38PUB', 'dasd', 1, 1, NULL, NULL, '2025-12-01 19:40:21', '2025-12-01 19:40:21', NULL),
(8, 'TxiuVg9mZUksASJItFzcXW', 'gfbs', 1, 1, NULL, NULL, '2025-12-01 19:40:28', '2025-12-01 19:40:28', NULL),
(9, 'HCqJ0wgsyGOioX0FLtuGGJ', 'abredf', 1, 1, NULL, NULL, '2025-12-01 19:40:34', '2025-12-01 19:40:34', NULL),
(10, '0Qis62EiAtEkOdLfEHGj6A', 'fewq', 1, 1, NULL, NULL, '2025-12-01 19:40:40', '2025-12-01 19:40:40', NULL),
(11, '4klg6lOUnHaptawkO7c6D4', 'sbgf', 1, 1, NULL, NULL, '2025-12-01 19:40:48', '2025-12-01 19:40:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'super', 'JYIDmXiHqvdnpqEbfgmUf9', 'Super Admin: Full Access', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(2, 'admin', 'sjZfgRgFeOC8tZUfRIED2H', 'Tenant Administrator', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(3, 'doctor', 'v6yAp49NB3JoFlfORnv8o0', 'Medical Doctor: Access to dental management', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(4, 'user', 'fN9RAImaZtzE1TJL8BWDBY', 'User with profiles', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(5, 'language_manager', 'bVQuVqiFVIxNqne1jZs1aE', 'Manages system languages', 'web', '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(115, 2),
(116, 2),
(117, 2),
(118, 2),
(119, 2),
(120, 2),
(121, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(50, 3),
(51, 3),
(52, 3),
(53, 3),
(54, 3),
(55, 3),
(56, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(80, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(104, 3),
(105, 3),
(106, 3),
(107, 3),
(108, 3),
(109, 3),
(32, 4),
(38, 4),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('sR6XDiFW1GtGWhnf4JaAp5UTAvLPOP1MRpRK4KNc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNUJENUsyMkVpSUhnUUxiQXVoNlhJbVR1S0QwUGhWbTRldVUwNU9OSiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lcy9kZW50YWxfbWFuYWdlbWVudC9hcHBvaW50bWVudHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6ImxvY2FsZSI7czoyOiJlcyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1764709814);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `slug`, `name`, `description`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ULquJnFhnnAGEWQMcxMg49', 'Odontología general', NULL, 1, 1, NULL, NULL, '2025-12-01 19:11:01', '2025-12-01 19:11:01', NULL),
(2, 'aQnYDAf3bmAtdE0mbD5ZGV', 'Ortodoncia', NULL, 1, 1, NULL, NULL, '2025-12-01 19:11:09', '2025-12-01 19:11:09', NULL),
(3, 'bDFbBL9kVPREtZRxtvQLyv', 'Endodoncia', NULL, 1, 1, NULL, NULL, '2025-12-01 19:11:17', '2025-12-01 19:11:17', NULL),
(4, '6AFveyeRjaqqR4AOvpWuwY', 'Periodoncia', NULL, 1, 1, NULL, NULL, '2025-12-01 19:11:26', '2025-12-01 19:11:26', NULL),
(5, 'XuiIVSY1INPZ0FbLrTzSln', 'Implantes dentales', NULL, 1, 1, NULL, NULL, '2025-12-01 19:11:37', '2025-12-01 19:11:37', NULL),
(6, 'NIRYWZcKoJk0xwW3rlLDJO', 'Cirugía oral', NULL, 1, 1, NULL, NULL, '2025-12-01 19:11:45', '2025-12-01 19:11:45', NULL),
(7, 'M7He31QNJ50vDiKTBT0tmb', 'Odontopediatría', NULL, 1, 1, NULL, NULL, '2025-12-01 19:11:51', '2025-12-01 19:11:51', NULL),
(8, 'zgY1JLy3O4haTjWtIyyM4S', 'Estética dental', NULL, 1, 1, NULL, NULL, '2025-12-01 19:11:59', '2025-12-01 19:11:59', NULL),
(9, '9OQyLkcvHV56lSCdiREC9c', 'Prostodoncia', NULL, 1, 1, NULL, NULL, '2025-12-01 19:12:07', '2025-12-01 19:12:07', NULL),
(10, 'm3jZCKatttOIIc1QEcVCYt', 'Radiología dental', NULL, 1, 1, NULL, NULL, '2025-12-01 19:12:15', '2025-12-01 19:12:15', NULL),
(11, 'A7CU2Frt8YA8ZR84Pijr14', 'Odontología geriátrica', NULL, 1, 1, NULL, NULL, '2025-12-01 19:12:26', '2025-12-01 19:12:26', NULL),
(12, 'zfLWMg5aTaCsOnMde2wVSA', 'Temporomandibular (ATM)', NULL, 1, 1, NULL, NULL, '2025-12-01 19:12:37', '2025-12-01 19:12:37', NULL),
(13, 'S41uySk0hkZVLCPp1X1CAN', 'Odontología forense', NULL, 1, 1, NULL, NULL, '2025-12-01 19:12:45', '2025-12-01 19:12:45', NULL),
(14, 'oJCpWDrNLo3kLPV67qOidf', 'Odontología restauradora', NULL, 1, 1, NULL, NULL, '2025-12-01 19:13:26', '2025-12-01 19:13:26', NULL),
(15, 'ETpzZYI8QYfu7aVi0Hzwi8', 'Odontología preventiva', NULL, 1, 1, NULL, NULL, '2025-12-01 19:13:33', '2025-12-01 19:13:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_modules`
--

CREATE TABLE `system_modules` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_modules`
--

INSERT INTO `system_modules` (`id`, `slug`, `name`, `permission_key`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2V5wxyfruaYwmeSAoGrUW4', 'Consultations', 'consultations', 1, NULL, NULL, '2025-12-01 19:02:00', '2025-12-01 19:02:00', NULL),
(2, 'drg4q0ww7vemsXUqBq9oSb', 'Countries', 'countries', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(3, 'lbc80pjJYAh6ncCbp0haRU', 'Users', 'users', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(4, 'UjWtLCoHerRqhue4arYGZd', 'Companies', 'companies', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(5, 'zehrFJsf2noUvbXpbbEwEq', 'Doctors', 'doctors', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(6, 'OiOFrOaF7NxMqSzjzlsBfM', 'Patients', 'patients', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(7, 'Mus0DfBA2buG6RiH8piOZP', 'Treatments', 'treatments', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(8, 'aEvZqlLRwVHHcNa8ygMVFg', 'Appointments', 'appointments', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(9, 'oomuNswEZJsp3tLs5bqk4x', 'Specialties', 'specialties', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(10, 'Ec4YfT3bBXlIlWSmLUxj50', 'Odontogram', 'odontogram', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(11, '2zUkloQTa1f29v35g3PRv6', 'Payments', 'payments', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(12, '6Za7G3RVayecq6mYDBj4r8', 'Reports', 'reports', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(13, 'kNh5c4KtSLUoxQRfF3HXdH', 'Summary', 'summary', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(14, 'W3HO7IdlSDx4bLqbIYp4lG', 'Calendar', 'calendar', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(15, 'QW5Ocd98G2oE3y9S7OAc2X', 'Appointment History', 'appointment_history', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(16, 'wda7gRTD8J6KalGMp4N7M0', 'Languages', 'languages', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(17, 'RTfy2amrT3fbt7DesaxBDr', 'Regions', 'regions', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(18, 'Zqw9kUvjXVR6CPxUOXP7HS', 'Tenants', 'tenants', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(19, 'wFFKUPB1GwJ536YmPheq79', 'System Modules', 'system_modules', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL),
(20, 'v4xWLz0UOn05c28WAg6vLf', 'Roles', 'roles', 1, NULL, NULL, '2025-12-01 19:02:01', '2025-12-01 19:02:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `slug`, `name`, `logo`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'OXao46aBlKyLBchU2TBvwp', 'HITACHI ENERGY', NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(2, '1scEEwZ0yEa3jHtjwJPwGK', 'SIEMBRES', NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_countries`
--

CREATE TABLE `tenant_countries` (
  `id` bigint UNSIGNED NOT NULL,
  `tenant_id` bigint UNSIGNED DEFAULT NULL,
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#007bff',
  `coverage` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'partial',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treatments`
--

INSERT INTO `treatments` (`id`, `slug`, `name`, `description`, `cost`, `color`, `coverage`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'kUnMe1uY2gvFhKwEs1TE4c', 'limpieza', NULL, 200.00, '#007bff', 'full', 1, 1, 1, 'fasdfqdqwdqwd', '2025-12-01 20:42:46', '2025-12-02 20:45:31', '2025-12-02 20:45:31'),
(2, 'Wn8aTaBv1ytnA8eKqXfpEl', 'extraccion', NULL, 300.00, '#00ff6e', 'partial', 1, 1, 1, 'wefowejfwvfvw', '2025-12-01 20:43:03', '2025-12-02 20:45:43', '2025-12-02 20:45:43'),
(3, 'WspRTqpNhYav4rkeB1L171', 'aaaa', NULL, 2000.00, '#ffdd00', 'partial', 1, 1, 1, 'reggggggergerger', '2025-12-01 21:40:46', '2025-12-02 20:44:51', '2025-12-02 20:44:51'),
(4, '3DHODvMwWO7388hqeCGeKn', 'bbbb', NULL, 600.00, '#ff0033', 'partial', 1, 1, 1, 'gregrweqwefwf', '2025-12-01 21:40:58', '2025-12-02 20:44:59', '2025-12-02 20:44:59'),
(5, 'XcJ7dvDH20BAxnKMbYj24m', 'bbrff', NULL, 155.00, '#00fffb', 'partial', 1, 1, 1, 'gvwewfwfwe', '2025-12-01 21:41:12', '2025-12-02 20:45:08', '2025-12-02 20:45:08'),
(6, 'bW6nosxjhAlKsjOayrTw7o', 'Limpieza dental profesional', NULL, 100.00, '#00ff00', 'full', 1, 1, NULL, NULL, '2025-12-02 20:48:08', '2025-12-02 20:48:08', NULL),
(7, '5OVK4G64KsmpBdcIfcrNpX', 'Blanqueamiento dental', NULL, 100.00, '#ffff00', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:48:28', '2025-12-02 20:48:28', NULL),
(8, 'Hq787jxnC3puSpoDwghZZs', 'Resina estética / Empaste', NULL, 100.00, '#00c8ff', 'full', 1, 1, NULL, NULL, '2025-12-02 20:48:54', '2025-12-02 20:48:54', NULL),
(9, '3UbcIEVgIeE4dypGCEdPXO', 'Tratamiento de caries', NULL, 100.00, '#ffa500', 'full', 1, 1, NULL, NULL, '2025-12-02 20:49:16', '2025-12-02 20:49:16', NULL),
(10, 'vzaULpc96r0VbWdfFjtn4Y', 'Endodoncia (Conducto)', NULL, 100.00, '#ff0000', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:49:42', '2025-12-02 20:49:42', NULL),
(11, 'I8vOdyw26AAyHbYvTTD5wW', 'Extracción simple', NULL, 100.00, '#808080', 'full', 1, 1, NULL, NULL, '2025-12-02 20:50:03', '2025-12-02 20:50:03', NULL),
(12, 'XIT2fAwwVfoHNtMOuR4Q8o', 'Extracción quirúrgica', NULL, 100.00, '#8b4513', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:50:24', '2025-12-02 20:50:24', NULL),
(13, 'UVS3noaDbg0nvNIQbSX82x', 'Colocación de corona', NULL, 100.00, '#ffd700', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:50:42', '2025-12-02 20:50:42', NULL),
(14, 'dMI7yczXLPrpYCbOaEDPN1', 'Puente dental', NULL, 100.00, '#800080', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:51:03', '2025-12-02 20:51:03', NULL),
(15, '9yRYFIJyZdw2iqenyhuZ9o', 'Implante dental', NULL, 100.00, '#003366', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:51:24', '2025-12-02 20:51:24', NULL),
(16, 'i6LGoDrMVnPJDw7OJzLMDL', 'Ortodoncia (brackets)', NULL, 100.00, '#ff66cc', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:51:45', '2025-12-02 20:51:45', NULL),
(17, '5hwDPZUcdevBzRhPoAghCN', 'Ortodoncia invisible (alineadores)', NULL, 100.00, '#f5f5f5', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:52:10', '2025-12-02 20:52:10', NULL),
(18, 'uCSBOFo4chqsAGW5QGoXUi', 'Tratamiento de encías (Periodoncia)', NULL, 100.00, '#006400', 'full', 1, 1, NULL, NULL, '2025-12-02 20:52:31', '2025-12-02 20:52:31', NULL),
(19, 'dYquU2gDfJJbEELWluYb6P', 'Limpieza profunda (Raspado y alisado)', NULL, 100.00, '#40e0d0', 'partial', 1, 1, NULL, NULL, '2025-12-02 20:52:50', '2025-12-02 20:52:50', NULL),
(20, 'cCwlpIsDiEWaH1dUP53Ei7', 'Sellantes dentales', NULL, 100.00, '#add8e6', 'full', 1, 1, NULL, NULL, '2025-12-02 20:53:11', '2025-12-02 20:53:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `treatment_history`
--

CREATE TABLE `treatment_history` (
  `id` bigint UNSIGNED NOT NULL,
  `odontogram_id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `doctor_id` bigint UNSIGNED NOT NULL,
  `tooth_number` int NOT NULL,
  `surface` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `treatment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `treatment_data` json DEFAULT NULL,
  `treatment_date` timestamp NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `locale_id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `slug`, `tenant_id`, `country_id`, `locale_id`, `email`, `google_id`, `password`, `name`, `photo`, `remember_token`, `email_verified_at`, `is_active`, `created_by`, `deleted_by`, `deleted_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'vZRlDvSUnN4zUGttCKWQer', 1, 1, 1, 'pingo@gmail.com', NULL, '$2y$12$KMXkFHsV970AcUkSruKUY.m87Hi4aBhSSzLwakZDc6FNN8s6ZaA6u', 'Alexander Pingo', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(2, 'Ghpcd6Qa1SYVVLO5IeFAaG', 1, 1, 1, 'pinga@gmail.com', NULL, '$2y$12$CkWDYgUcCLwd5dfYYgErw.MWGZdUe3uJkB3PKniCkWJ6rDbwEYKDO', 'Manuela Pinga', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:02', '2025-12-01 19:02:02', NULL),
(3, 'whQmEDOdWMYczqh2Ftimq5', 1, 1, 1, 'joel@gmail.com', NULL, '$2y$12$2pCo1Wvyd2Bu2rl/McAlAOjI8hA/UJ0VpKoYQgeWfmO3TfKDBiIvy', 'Joel Jimenez', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:03', '2025-12-01 19:02:03', NULL),
(4, 'C2Cl8j5tpZPJ9ri0xYMtcw', 1, 1, 1, 'kiara@gmail.com', NULL, '$2y$12$fu/9fz8dTeiYJW7AjA1/OuDLnMqI88MfuFBr8ZSCZ7lmmDcy7A1Te', 'Yunikua', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:03', '2025-12-01 19:02:03', NULL),
(5, 'Tz802PEml35ky5UsTwhAnL', 1, 1, 1, 'misari@gmail.com', NULL, '$2y$12$/jjuZxWsgzW5Hf1F.Sh3guDGIZXBx1eQfCK.Z3DeTavKhfR0d/H9y', 'Tayron Misari', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:03', '2025-12-01 19:02:03', NULL),
(6, 'owgacIenGTabOZshXk8Vep', 1, 1, 1, 'yasumy@gmail.com', NULL, '$2y$12$/8hTwG.e//dN9YWLLiR2PO/n0/EKuZZ1WWYqW2sgHmOjZ5iLr0KgK', 'Yasumy Pastor', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:03', '2025-12-01 19:02:03', NULL),
(7, 'dOCjtobzQLrgNGmv4WtvEa', 1, 1, 1, 'nerio@gmail.com', NULL, '$2y$12$OUarHzCM1W0E2Za4W.LOc.74cCVUlopD5i9VXrowpNuWXOWGqnU6C', 'Nerio Vasquez', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:03', '2025-12-01 19:02:03', NULL),
(8, 'QTtcILFTE8WzhAJbm8IN5m', 1, 1, 1, 'jhon@gmail.com', NULL, '$2y$12$r93WCg2FJuqyq/AaLIN5FeGAEQ3NRE.QY7kzvDmHwEoyrHLx7LNLm', 'Jhon Pastor', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:03', '2025-12-01 19:02:03', NULL),
(9, '8FIsojkd6ApXleKFtRMF6u', 1, 1, 1, 'jose@gmail.com', NULL, '$2y$12$HpOnnqWfM7NBnIY5NshVu.L3md06WyV5i4mhXZ4MWfnio/.WD3DAC', 'Jose de los Bayardigans', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:04', '2025-12-01 19:02:04', NULL),
(10, '9ZblymXbOIEbE21xJChVze', 1, 1, 1, 'boris@gmail.com', NULL, '$2y$12$S.C3CLizTx6eGL39lwdGU.rMxF2S6v8ABzzuhF4.uFM.dzyHwroIe', 'Boris el Varon', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:04', '2025-12-01 19:02:04', NULL),
(11, 'VS7XlLnmr5z2L8WuFFnP1n', 1, 1, 1, 'jefferson@gmail.com', NULL, '$2y$12$ky7DI6WA2ZDrseQmLE1GOua7Mf7l0GDnGDCTPec1rbEkzPMW3zePS', 'Jefferson el Delegado', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:04', '2025-12-01 19:02:04', NULL),
(12, 'cJiyj484toCinYF9qWDDFo', 1, 1, 1, 'fabio@gmail.com', NULL, '$2y$12$dTYVI73Kc/Mu4Ya9DB2sqejae0aFZT3S0p3R08.WhlEyi3dkDMSRi', 'Pampis de Tiktok', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 19:02:04', '2025-12-01 19:02:04', NULL),
(13, 'yEcFRPpZ1f5XBF70tepz3g', 1, 1, 1, 'frank45@nerio18pe.com', NULL, '$2y$12$e8So549x9FWo4MM/kh8nX.q9rPiK03xeaBdGUEPfE92ct3yseKcNa', 'LIZ LADY CARBAJAL RAIME', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 20:43:46', '2025-12-01 20:43:46', NULL),
(14, 'cKUhruRI3rTTEdhCuqpFDS', 1, 1, 1, 'disney.family@email.com', NULL, '$2y$12$NmqqlaJR/VF.tosmknrSqut71d5gKAUBWYPgC.O.d2KlY5fv4JheG', 'SANTOS SEMBRERA SANTOS', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-01 21:26:45', '2025-12-01 21:26:45', NULL),
(15, '27fsz12cjIfc4HhzyXWij4', 1, 1, 1, 'marcos.perez92@gmail.com', NULL, '$2y$12$4Tb195aNVzwpFaHdHyQrIOImwPZDfs5HMah.pqQeob1vvhDUBECsm', 'LUIS RODOLFO GAMERO LOPEZ', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-02 20:57:09', '2025-12-02 20:57:09', NULL),
(16, 'GPWBk3zSf5XgLkMlY59xTv', 1, 1, 1, 'bettyd43@gmail.com', NULL, '$2y$12$XIqK8BYceyvkSw5mAEwVPut7UsQEUHEjlqjkkTxWuhr7DBEBM1qAy', 'BETTY LUCIA INGUNZA RODRIGUEZ', NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-12-02 20:57:54', '2025-12-02 20:57:54', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointments_slug_unique` (`slug`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_doctor_id_foreign` (`doctor_id`),
  ADD KEY `appointments_treatment_id_foreign` (`treatment_id`),
  ADD KEY `appointments_created_by_foreign` (`created_by`),
  ADD KEY `appointments_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `appointment_histories`
--
ALTER TABLE `appointment_histories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointment_histories_slug_unique` (`slug`),
  ADD KEY `appointment_histories_appointment_id_foreign` (`appointment_id`),
  ADD KEY `appointment_histories_changed_by_foreign` (`changed_by`),
  ADD KEY `appointment_histories_created_by_foreign` (`created_by`),
  ADD KEY `appointment_histories_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consultations_slug_unique` (`slug`),
  ADD KEY `consultations_patient_id_foreign` (`patient_id`),
  ADD KEY `consultations_treatment_id_foreign` (`treatment_id`),
  ADD KEY `consultations_doctor_id_foreign` (`doctor_id`),
  ADD KEY `consultations_created_by_foreign` (`created_by`),
  ADD KEY `consultations_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_slug_unique` (`slug`),
  ADD KEY `countries_region_id_foreign` (`region_id`),
  ADD KEY `countries_default_locale_id_foreign` (`default_locale_id`);

--
-- Indexes for table `country_languages`
--
ALTER TABLE `country_languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_languages_country_id_foreign` (`country_id`),
  ADD KEY `country_languages_language_id_foreign` (`language_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_slug_unique` (`slug`),
  ADD UNIQUE KEY `doctors_email_unique` (`email`),
  ADD UNIQUE KEY `doctors_document_unique` (`document`),
  ADD KEY `doctors_created_by_foreign` (`created_by`),
  ADD KEY `doctors_deleted_by_foreign` (`deleted_by`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Indexes for table `doctor_specialty`
--
ALTER TABLE `doctor_specialty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctor_specialty_doctor_id_specialty_id_unique` (`doctor_id`,`specialty_id`),
  ADD KEY `doctor_specialty_specialty_id_foreign` (`specialty_id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `downloads_slug_unique` (`slug`),
  ADD KEY `downloads_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_slug_unique` (`slug`);

--
-- Indexes for table `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locales_slug_unique` (`slug`),
  ADD KEY `locales_language_id_foreign` (`language_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `odontograms`
--
ALTER TABLE `odontograms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `odontograms_slug_unique` (`slug`),
  ADD KEY `odontograms_patient_id_foreign` (`patient_id`),
  ADD KEY `odontograms_created_by_foreign` (`created_by`),
  ADD KEY `odontograms_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `odontogram_details`
--
ALTER TABLE `odontogram_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `odontogram_details_odontogram_history_id_foreign` (`odontogram_history_id`),
  ADD KEY `odontogram_details_treatment_id_foreign` (`treatment_id`);

--
-- Indexes for table `odontogram_histories`
--
ALTER TABLE `odontogram_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `odontogram_histories_odontogram_id_foreign` (`odontogram_id`),
  ADD KEY `odontogram_histories_doctor_id_foreign` (`doctor_id`),
  ADD KEY `odontogram_histories_created_by_foreign` (`created_by`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_slug_unique` (`slug`),
  ADD UNIQUE KEY `patients_email_unique` (`email`),
  ADD KEY `patients_created_by_foreign` (`created_by`),
  ADD KEY `patients_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `patient_images`
--
ALTER TABLE `patient_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_images_slug_unique` (`slug`),
  ADD KEY `patient_images_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_images_created_by_foreign` (`created_by`),
  ADD KEY `patient_images_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_slug_unique` (`slug`),
  ADD KEY `payments_appointment_id_foreign` (`appointment_id`),
  ADD KEY `payments_patient_id_foreign` (`patient_id`),
  ADD KEY `payments_created_by_foreign` (`created_by`),
  ADD KEY `payments_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regions_slug_unique` (`slug`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_slug_unique` (`slug`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `specialties_slug_unique` (`slug`),
  ADD KEY `specialties_created_by_foreign` (`created_by`),
  ADD KEY `specialties_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `system_modules`
--
ALTER TABLE `system_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `system_modules_slug_unique` (`slug`),
  ADD UNIQUE KEY `system_modules_permission_key_unique` (`permission_key`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenants_slug_unique` (`slug`);

--
-- Indexes for table `tenant_countries`
--
ALTER TABLE `tenant_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `treatments_slug_unique` (`slug`),
  ADD KEY `treatments_created_by_foreign` (`created_by`),
  ADD KEY `treatments_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `treatment_history`
--
ALTER TABLE `treatment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treatment_history_doctor_id_foreign` (`doctor_id`),
  ADD KEY `treatment_history_odontogram_id_tooth_number_index` (`odontogram_id`,`tooth_number`),
  ADD KEY `treatment_history_patient_id_treatment_date_index` (`patient_id`,`treatment_date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_slug_unique` (`slug`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD KEY `users_tenant_id_foreign` (`tenant_id`),
  ADD KEY `users_country_id_foreign` (`country_id`),
  ADD KEY `users_locale_id_foreign` (`locale_id`),
  ADD KEY `users_created_by_foreign` (`created_by`),
  ADD KEY `users_deleted_by_foreign` (`deleted_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointment_histories`
--
ALTER TABLE `appointment_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `country_languages`
--
ALTER TABLE `country_languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctor_specialty`
--
ALTER TABLE `doctor_specialty`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `locales`
--
ALTER TABLE `locales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `odontograms`
--
ALTER TABLE `odontograms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `odontogram_details`
--
ALTER TABLE `odontogram_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `odontogram_histories`
--
ALTER TABLE `odontogram_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient_images`
--
ALTER TABLE `patient_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specialties`
--
ALTER TABLE `specialties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `system_modules`
--
ALTER TABLE `system_modules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenant_countries`
--
ALTER TABLE `tenant_countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `treatment_history`
--
ALTER TABLE `treatment_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `appointments_treatment_id_foreign` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`);

--
-- Constraints for table `appointment_histories`
--
ALTER TABLE `appointment_histories`
  ADD CONSTRAINT `appointment_histories_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `appointment_histories_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointment_histories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `appointment_histories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `consultations_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `consultations_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `consultations_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `consultations_treatment_id_foreign` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`);

--
-- Constraints for table `countries`
--
ALTER TABLE `countries`
  ADD CONSTRAINT `countries_default_locale_id_foreign` FOREIGN KEY (`default_locale_id`) REFERENCES `locales` (`id`),
  ADD CONSTRAINT `countries_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);

--
-- Constraints for table `country_languages`
--
ALTER TABLE `country_languages`
  ADD CONSTRAINT `country_languages_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `country_languages_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `doctors_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `doctor_specialty`
--
ALTER TABLE `doctor_specialty`
  ADD CONSTRAINT `doctor_specialty_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_specialty_specialty_id_foreign` FOREIGN KEY (`specialty_id`) REFERENCES `specialties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `locales`
--
ALTER TABLE `locales`
  ADD CONSTRAINT `locales_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

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
-- Constraints for table `odontograms`
--
ALTER TABLE `odontograms`
  ADD CONSTRAINT `odontograms_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `odontograms_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `odontograms_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `odontogram_details`
--
ALTER TABLE `odontogram_details`
  ADD CONSTRAINT `odontogram_details_odontogram_history_id_foreign` FOREIGN KEY (`odontogram_history_id`) REFERENCES `odontogram_histories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `odontogram_details_treatment_id_foreign` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `odontogram_histories`
--
ALTER TABLE `odontogram_histories`
  ADD CONSTRAINT `odontogram_histories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `odontogram_histories_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `odontogram_histories_odontogram_id_foreign` FOREIGN KEY (`odontogram_id`) REFERENCES `odontograms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `patients_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `patient_images`
--
ALTER TABLE `patient_images`
  ADD CONSTRAINT `patient_images_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `patient_images_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `patient_images_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `specialties`
--
ALTER TABLE `specialties`
  ADD CONSTRAINT `specialties_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `specialties_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `treatments`
--
ALTER TABLE `treatments`
  ADD CONSTRAINT `treatments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `treatments_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `treatment_history`
--
ALTER TABLE `treatment_history`
  ADD CONSTRAINT `treatment_history_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatment_history_odontogram_id_foreign` FOREIGN KEY (`odontogram_id`) REFERENCES `odontograms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatment_history_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_locale_id_foreign` FOREIGN KEY (`locale_id`) REFERENCES `locales` (`id`),
  ADD CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
