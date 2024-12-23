-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for libraroom reservation system
CREATE DATABASE IF NOT EXISTS `libraroom reservation system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `libraroom reservation system`;

-- Dumping structure for table libraroom reservation system.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_date` date NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_time_start` time DEFAULT NULL,
  `booking_time_end` time DEFAULT NULL,
  `duration` int DEFAULT NULL COMMENT 'Duration in minutes',
  `no_room` bigint unsigned NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_bookings_rooms` (`no_room`),
  CONSTRAINT `FK_bookings_rooms` FOREIGN KEY (`no_room`) REFERENCES `rooms` (`no_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.bookings: ~2 rows (approximately)
INSERT INTO `bookings` (`id`, `booking_date`, `purpose`, `booking_time_start`, `booking_time_end`, `duration`, `no_room`, `phone_number`, `status`, `created_at`, `updated_at`) VALUES
	(12, '2024-12-27', 'test1', '13:31:00', '16:31:00', 180, 34, '0102907671', 'approved', '2024-12-19 20:05:58', '2024-12-19 20:05:58'),
	(13, '2024-12-31', 'test2', '16:06:00', '18:06:00', 120, 20, '0102907671', 'approved', '2024-12-19 20:07:20', '2024-12-19 20:07:20');

-- Dumping structure for table libraroom reservation system.booking_user
CREATE TABLE IF NOT EXISTS `booking_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `list_student_booking_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_booking_user_bookings` (`booking_id`),
  KEY `FK_booking_user_list_student_booking` (`list_student_booking_id`),
  CONSTRAINT `FK_booking_user_bookings` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_booking_user_list_student_booking` FOREIGN KEY (`list_student_booking_id`) REFERENCES `list_student_booking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.booking_user: ~8 rows (approximately)
INSERT INTO `booking_user` (`id`, `booking_id`, `list_student_booking_id`, `created_at`, `updated_at`) VALUES
	(24, 12, 2, NULL, NULL),
	(25, 12, 3, NULL, NULL),
	(26, 12, 4, NULL, NULL),
	(27, 12, 5, NULL, NULL),
	(28, 13, 2, NULL, NULL),
	(29, 13, 3, NULL, NULL),
	(30, 13, 4, NULL, NULL),
	(31, 13, 5, NULL, NULL);

-- Dumping structure for table libraroom reservation system.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `no_course` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_course`),
  KEY `courses_department_index` (`department`),
  CONSTRAINT `FK_courses_departments` FOREIGN KEY (`department`) REFERENCES `departments` (`no_department`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.courses: ~0 rows (approximately)
INSERT INTO `courses` (`no_course`, `name`, `department`, `created_at`, `updated_at`) VALUES
	(1, 'bip', 1, '2024-12-06 08:27:51', '2024-12-06 08:27:53');

-- Dumping structure for table libraroom reservation system.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `no_department` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_department`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.departments: ~0 rows (approximately)
INSERT INTO `departments` (`no_department`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'BIP', '2024-12-06 08:27:57', '2024-12-06 08:27:58');

-- Dumping structure for table libraroom reservation system.electronic_equipment
CREATE TABLE IF NOT EXISTS `electronic_equipment` (
  `no_electronicEquipment` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_electronicEquipment`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.electronic_equipment: ~2 rows (approximately)
INSERT INTO `electronic_equipment` (`no_electronicEquipment`, `name`, `category`, `status`, `created_at`, `updated_at`) VALUES
	(8, 'ComputerHP', 'computer', 'Active', '2024-12-18 03:04:44', '2024-12-18 03:04:44'),
	(9, 'LCD Projector Sony1', 'LCD Projector', 'Active', '2024-12-18 03:05:12', '2024-12-18 03:05:12');

-- Dumping structure for table libraroom reservation system.electronic_equipment_room
CREATE TABLE IF NOT EXISTS `electronic_equipment_room` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint unsigned NOT NULL,
  `electronic_equipment_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_electronic_equipment_room_rooms` (`room_id`),
  KEY `FK_electronic_equipment_room_electronic_equipment` (`electronic_equipment_id`),
  CONSTRAINT `FK_electronic_equipment_room_electronic_equipment` FOREIGN KEY (`electronic_equipment_id`) REFERENCES `electronic_equipment` (`no_electronicEquipment`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_electronic_equipment_room_rooms` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`no_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.electronic_equipment_room: ~24 rows (approximately)
INSERT INTO `electronic_equipment_room` (`id`, `room_id`, `electronic_equipment_id`, `created_at`, `updated_at`) VALUES
	(7, 16, 8, NULL, NULL),
	(8, 17, 8, NULL, NULL),
	(9, 18, 8, NULL, NULL),
	(10, 19, 8, NULL, NULL),
	(11, 20, 8, NULL, NULL),
	(12, 20, 9, NULL, NULL),
	(13, 21, 8, NULL, NULL),
	(14, 21, 9, NULL, NULL),
	(15, 22, 8, NULL, NULL),
	(16, 22, 9, NULL, NULL),
	(17, 23, 8, NULL, NULL),
	(18, 23, 9, NULL, NULL),
	(19, 24, 8, NULL, NULL),
	(20, 24, 9, NULL, NULL),
	(21, 27, 8, NULL, NULL),
	(22, 27, 9, NULL, NULL),
	(23, 33, 8, NULL, NULL),
	(24, 34, 8, NULL, NULL),
	(25, 36, 8, NULL, NULL),
	(26, 36, 9, NULL, NULL),
	(27, 37, 8, NULL, NULL),
	(28, 37, 9, NULL, NULL),
	(29, 38, 9, NULL, NULL),
	(30, 39, 9, NULL, NULL);

-- Dumping structure for table libraroom reservation system.faculty_offices
CREATE TABLE IF NOT EXISTS `faculty_offices` (
  `no_facultyOffice` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_facultyOffice`),
  KEY `faculty_offices_department_index` (`department`),
  CONSTRAINT `FK_faculty_offices_departments` FOREIGN KEY (`department`) REFERENCES `departments` (`no_department`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.faculty_offices: ~0 rows (approximately)
INSERT INTO `faculty_offices` (`no_facultyOffice`, `name`, `department`, `created_at`, `updated_at`) VALUES
	(1, 'FSKTM', 1, '2024-12-06 08:28:15', '2024-12-06 08:28:16');

-- Dumping structure for table libraroom reservation system.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.furniture
CREATE TABLE IF NOT EXISTS `furniture` (
  `no_furniture` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_furniture`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.furniture: ~11 rows (approximately)
INSERT INTO `furniture` (`no_furniture`, `name`, `category`, `status`, `created_at`, `updated_at`) VALUES
	(10, 'Chair1', 'Chair', 'Active', '2024-12-18 03:05:30', '2024-12-18 03:05:30'),
	(11, 'Japanese desk1', 'Japaness Table', 'Active', '2024-12-18 03:05:53', '2024-12-18 03:06:17'),
	(12, 'Japanese desk2', 'Japaness Table', 'Active', '2024-12-18 03:06:30', '2024-12-18 03:06:30'),
	(13, 'Desk1', 'Desk', 'Active', '2024-12-18 03:06:43', '2024-12-18 03:06:43'),
	(14, 'Desk2', 'Desk', 'Active', '2024-12-18 03:06:56', '2024-12-18 03:06:56'),
	(15, 'Chair2', 'Chair', 'Active', '2024-12-18 03:07:09', '2024-12-18 03:07:09'),
	(16, 'Desk3', 'Desk', 'Active', '2024-12-18 03:07:27', '2024-12-18 03:07:27'),
	(17, 'Chair3', 'Chair', 'Active', '2024-12-18 03:07:39', '2024-12-18 03:07:39'),
	(18, 'Japanese desk3', 'Japaness Table', 'Active', '2024-12-18 03:11:06', '2024-12-18 03:11:06'),
	(19, 'Japanese desk4', 'Japaness Table', 'Active', '2024-12-18 03:11:16', '2024-12-18 03:11:16'),
	(20, 'Whiteboard', 'Whiteboard', 'Active', '2024-12-18 03:21:07', '2024-12-18 03:21:07');

-- Dumping structure for table libraroom reservation system.furniture_room
CREATE TABLE IF NOT EXISTS `furniture_room` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint unsigned NOT NULL,
  `furniture_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_furniture_room_rooms` (`room_id`),
  KEY `FK_furniture_room_furniture` (`furniture_id`),
  CONSTRAINT `FK_furniture_room_furniture` FOREIGN KEY (`furniture_id`) REFERENCES `furniture` (`no_furniture`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_furniture_room_rooms` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`no_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.furniture_room: ~65 rows (approximately)
INSERT INTO `furniture_room` (`id`, `room_id`, `furniture_id`, `created_at`, `updated_at`) VALUES
	(7, 14, 11, NULL, NULL),
	(8, 15, 18, NULL, NULL),
	(9, 16, 12, NULL, NULL),
	(10, 17, 10, NULL, NULL),
	(11, 17, 13, NULL, NULL),
	(12, 18, 15, NULL, NULL),
	(13, 18, 14, NULL, NULL),
	(14, 19, 16, NULL, NULL),
	(15, 19, 17, NULL, NULL),
	(16, 20, 13, NULL, NULL),
	(17, 20, 15, NULL, NULL),
	(18, 21, 13, NULL, NULL),
	(19, 21, 10, NULL, NULL),
	(20, 22, 13, NULL, NULL),
	(21, 22, 17, NULL, NULL),
	(22, 23, 15, NULL, NULL),
	(23, 23, 16, NULL, NULL),
	(24, 24, 15, NULL, NULL),
	(25, 24, 16, NULL, NULL),
	(26, 25, 14, NULL, NULL),
	(27, 25, 15, NULL, NULL),
	(28, 26, 15, NULL, NULL),
	(29, 26, 13, NULL, NULL),
	(30, 27, 16, NULL, NULL),
	(31, 27, 15, NULL, NULL),
	(32, 28, 15, NULL, NULL),
	(33, 28, 16, NULL, NULL),
	(34, 29, 16, NULL, NULL),
	(35, 29, 15, NULL, NULL),
	(36, 30, 15, NULL, NULL),
	(37, 30, 14, NULL, NULL),
	(38, 31, 16, NULL, NULL),
	(39, 31, 10, NULL, NULL),
	(40, 32, 14, NULL, NULL),
	(41, 32, 10, NULL, NULL),
	(42, 33, 20, NULL, NULL),
	(43, 34, 10, NULL, NULL),
	(44, 34, 13, NULL, NULL),
	(45, 34, 20, NULL, NULL),
	(46, 35, 20, NULL, NULL),
	(47, 35, 16, NULL, NULL),
	(48, 35, 10, NULL, NULL),
	(49, 36, 13, NULL, NULL),
	(50, 36, 15, NULL, NULL),
	(51, 37, 14, NULL, NULL),
	(52, 37, 17, NULL, NULL),
	(53, 38, 16, NULL, NULL),
	(54, 38, 17, NULL, NULL),
	(55, 39, 16, NULL, NULL),
	(56, 39, 15, NULL, NULL),
	(57, 40, 17, NULL, NULL),
	(58, 40, 13, NULL, NULL),
	(59, 41, 16, NULL, NULL),
	(60, 41, 15, NULL, NULL),
	(61, 42, 14, NULL, NULL),
	(62, 42, 17, NULL, NULL),
	(63, 43, 13, NULL, NULL),
	(64, 43, 15, NULL, NULL),
	(65, 43, 20, NULL, NULL),
	(66, 44, 20, NULL, NULL),
	(67, 44, 17, NULL, NULL),
	(68, 44, 13, NULL, NULL),
	(69, 45, 20, NULL, NULL),
	(70, 45, 16, NULL, NULL),
	(71, 45, 15, NULL, NULL);

-- Dumping structure for table libraroom reservation system.list_student_booking
CREATE TABLE IF NOT EXISTS `list_student_booking` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_matriks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_list_student_booking_users` (`no_matriks`),
  CONSTRAINT `FK_list_student_booking_users` FOREIGN KEY (`no_matriks`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.list_student_booking: ~8 rows (approximately)
INSERT INTO `list_student_booking` (`id`, `no_matriks`, `created_at`, `updated_at`) VALUES
	(1, 'AI230077', '2024-12-13 00:17:39', '2024-12-13 00:17:39'),
	(2, 'AI230046', '2024-12-13 00:17:39', '2024-12-13 00:17:39'),
	(3, 'Ai230065', '2024-12-13 00:17:39', '2024-12-13 00:17:39'),
	(4, 'AI230087', '2024-12-13 00:17:39', '2024-12-13 00:17:39'),
	(5, 'AB230016', '2024-12-13 00:17:39', '2024-12-13 00:17:39'),
	(6, 'AI230008', '2024-12-15 07:41:10', '2024-12-15 07:41:10'),
	(7, 'AI230009', '2024-12-15 07:41:10', '2024-12-15 07:41:10'),
	(8, 'AI230010', '2024-12-15 07:41:10', '2024-12-15 07:41:10');

-- Dumping structure for table libraroom reservation system.maintenance
CREATE TABLE IF NOT EXISTS `maintenance` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemType` enum('furniture','electronic_equipment','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` bigint unsigned DEFAULT NULL,
  `item_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_id` bigint unsigned DEFAULT NULL,
  `date_maintenance` date NOT NULL,
  `status` enum('pending','in_progress','completed','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_maintenance_rooms` (`room_id`),
  CONSTRAINT `FK_maintenance_rooms` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`no_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.maintenance: ~3 rows (approximately)
INSERT INTO `maintenance` (`id`, `title`, `description`, `itemType`, `item_id`, `item_text`, `room_id`, `date_maintenance`, `status`, `created_at`, `updated_at`) VALUES
	(2, 'test 2', 'test 2', 'electronic_equipment', 2, NULL, NULL, '2024-12-16', 'pending', '2024-12-13 10:19:09', '2024-12-13 11:18:28');

-- Dumping structure for table libraroom reservation system.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.migrations: ~27 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2024_10_25_092523_create_students_table', 1),
	(7, '2024_10_25_092606_create_staff_table', 1),
	(8, '2024_10_25_092607_create_faculty_offices_table', 1),
	(9, '2024_10_25_092609_create_departments_table', 1),
	(10, '2024_10_25_092611_create_courses_table', 1),
	(11, '2024_10_25_092612_create_rooms_table', 1),
	(12, '2024_10_25_092614_create_furniture_table', 1),
	(13, '2024_10_25_092615_create_electronic_equipment_table', 1),
	(14, '2024_10_27_115533_add_email_password_notifications_to_student_and_staff_tables', 1),
	(15, '2024_10_30_173224_add_nomatriks_to_users', 1),
	(16, '2024_10_31_072629_add_timestamps_to_users_table', 1),
	(17, '2024_11_05_142112_create_bookings_table', 1),
	(18, '2024_11_09_113733_create_settings_table', 1),
	(20, '2024_11_29_104016_create_notifications_table', 1),
	(21, '2024_12_03_090437_type_room__to_rooms_table', 1),
	(22, '2024_12_03_110325_furniture_room', 2),
	(23, '2024_12_03_110448_electronic_equipment_room', 2),
	(24, '2024_12_11_061203_update_bookings_table', 3),
	(26, '2024_12_11_121244_create_list_student_booking_table', 4),
	(29, '2024_12_12_142925_create_schedule_booking_table', 5),
	(30, '2024_12_11_121329_create_booking_user_table', 6),
	(31, '2024_12_13_093730_create_maintenance_table', 7),
	(32, '2024_12_13_170552_add_item_text_to_maintenance_table', 8);

-- Dumping structure for table libraroom reservation system.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.notifications: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.password_resets: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `no_room` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type_room` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`no_room`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.rooms: ~31 rows (approximately)
INSERT INTO `rooms` (`no_room`, `name`, `capacity`, `status`, `created_at`, `updated_at`, `type_room`) VALUES
	(14, 'HIKMAH2', 10, 'valid', '2024-12-18 03:10:07', '2024-12-18 03:10:07', 'HIKMAH'),
	(15, 'HIKMAH6', 10, 'valid', '2024-12-18 03:11:34', '2024-12-18 03:11:34', 'HIKMAH'),
	(16, 'HIKMAH3', 10, 'valid', '2024-12-18 03:11:58', '2024-12-18 03:11:58', 'HIKMAH'),
	(17, 'HIKMAH7', 10, 'valid', '2024-12-18 03:13:18', '2024-12-18 03:13:18', 'HIKMAH'),
	(18, 'HIKMAH9', 10, 'valid', '2024-12-18 03:13:59', '2024-12-18 03:13:59', 'HIKMAH'),
	(19, 'HIKMAH11', 10, 'valid', '2024-12-18 03:14:22', '2024-12-18 03:14:22', 'HIKMAH'),
	(20, 'HIKMAH13', 10, 'valid', '2024-12-18 03:14:56', '2024-12-18 03:14:56', 'HIKMAH'),
	(21, 'HIKMAH15', 10, 'valid', '2024-12-18 03:15:17', '2024-12-18 03:15:17', 'HIKMAH'),
	(22, 'HIKMAH17', 10, 'valid', '2024-12-18 03:15:37', '2024-12-18 03:15:37', 'HIKMAH'),
	(23, 'HIKMAH19', 10, 'valid', '2024-12-18 03:15:56', '2024-12-18 03:15:56', 'HIKMAH'),
	(24, 'HIKMAH4', 10, 'valid', '2024-12-18 03:16:24', '2024-12-18 03:16:24', 'HIKMAH'),
	(25, 'HIKMAH1', 10, 'valid', '2024-12-18 03:16:40', '2024-12-18 03:16:40', 'HIKMAH'),
	(26, 'HIKMAH8', 10, 'valid', '2024-12-18 03:16:53', '2024-12-18 03:16:53', 'HIKMAH'),
	(27, 'HIKMAH10', 10, 'valid', '2024-12-18 03:17:19', '2024-12-18 03:17:19', 'HIKMAH'),
	(28, 'HIKMAH12', 10, 'valid', '2024-12-18 03:17:39', '2024-12-18 03:17:39', 'HIKMAH'),
	(29, 'HIKMAH14', 10, 'valid', '2024-12-18 03:18:19', '2024-12-18 03:18:19', 'HIKMAH'),
	(30, 'HIKMAH16', 10, 'valid', '2024-12-18 03:18:34', '2024-12-18 03:18:34', 'HIKMAH'),
	(31, 'Hikmah18', 10, 'valid', '2024-12-18 03:18:59', '2024-12-18 03:18:59', 'HIKMAH'),
	(32, 'Hikmah20', 10, 'valid', '2024-12-18 03:19:22', '2024-12-18 03:19:22', 'HIKMAH'),
	(33, 'EKSPLORASI5', 10, 'valid', '2024-12-18 03:21:36', '2024-12-18 03:21:36', 'EKSPLORASI'),
	(34, 'EKSPLORASI7', 10, 'valid', '2024-12-18 03:22:01', '2024-12-18 03:22:17', 'EKSPLORASI'),
	(35, 'EKSPLORASI19', 10, 'valid', '2024-12-18 03:22:47', '2024-12-18 03:22:47', 'EKSPLORASI'),
	(36, 'EKSPLORASI11', 10, 'valid', '2024-12-18 03:23:07', '2024-12-18 03:23:20', 'EKSPLORASI'),
	(37, 'EKSPLORASI15', 10, 'valid', '2024-12-18 03:23:51', '2024-12-18 03:23:51', 'EKSPLORASI'),
	(38, 'EKSPLORASI13', 10, 'valid', '2024-12-18 03:24:15', '2024-12-18 03:24:15', 'EKSPLORASI'),
	(39, 'EKSPLORASI17', 10, 'valid', '2024-12-18 03:24:35', '2024-12-18 03:24:35', 'EKSPLORASI'),
	(40, 'EKSPLORASI8', 10, 'valid', '2024-12-18 03:24:55', '2024-12-18 03:24:55', 'EKSPLORASI'),
	(41, 'EKSPLORASI9', 10, 'valid', '2024-12-18 03:25:12', '2024-12-18 03:25:12', 'EKSPLORASI'),
	(42, 'EKSPLORASI10', 10, 'valid', '2024-12-18 03:25:26', '2024-12-18 03:25:26', 'EKSPLORASI'),
	(43, 'EKSPLORASI12', 10, 'valid', '2024-12-18 03:26:11', '2024-12-18 03:26:11', 'EKSPLORASI'),
	(44, 'EKSPLORASI14', 10, 'valid', '2024-12-18 03:26:36', '2024-12-18 03:26:36', 'EKSPLORASI'),
	(45, 'EKSPLORASI16', 10, 'valid', '2024-12-18 03:26:58', '2024-12-18 03:26:58', 'EKSPLORASI');

-- Dumping structure for table libraroom reservation system.schedule_booking
CREATE TABLE IF NOT EXISTS `schedule_booking` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invalid_date` date NOT NULL,
  `invalid_time_start` time NOT NULL,
  `invalid_time_end` time NOT NULL,
  `roomid` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_schedule_booking_rooms` (`roomid`),
  CONSTRAINT `FK_schedule_booking_rooms` FOREIGN KEY (`roomid`) REFERENCES `rooms` (`no_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.schedule_booking: ~1 rows (approximately)

-- Dumping structure for table libraroom reservation system.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_des` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.settings: ~0 rows (approximately)
INSERT INTO `settings` (`id`, `description`, `short_des`, `logo`, `photo`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
	(2, '✨ Why choose LibraRoom?\r\n1. Simple and user-friendly booking process: Select your preferred day, time, and place, and your reservation will be verified promptly!\r\n2. Modern Design: An engaging and beautiful interface enhances the booking experience.\r\n3. Automatic Notifications: No need to worry about forgetting! This system will give you reminders before your reservation time.\r\n4. 24/7 Access: Book anytime, anyplace using our website or mobile app.\r\n5. Convenient Booking: Book small conference rooms, group study spaces, and more with a few clicks!', 'LibraRoom Reservation System is an innovative program that aims to make space booking easier, quicker, and more efficient for university students and staff. With a few simple actions, you can verify that your selected spot is ready for usage!', 'http://localhost/storage/photos/3/PTTA Logo Footer.png', 'http://localhost/storage/photos/3/PTTA Logo Footer.png', 'Tunku Tun Aminah Library  Tun Hussein Onn Malaysia University (UTHM) 86400 Parit Raja , Batu Pahat , Johor , Malaysia', '+607-4533318', 'ptta@uthm.edu.my', '2024-12-16 05:06:50', '2024-12-22 05:11:23');

-- Dumping structure for table libraroom reservation system.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin','ppp') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facultyOffice` bigint unsigned DEFAULT NULL,
  `course` bigint unsigned DEFAULT NULL,
  `no_matriks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_no_matriks_unique` (`no_matriks`),
  KEY `users_role_index` (`role`),
  KEY `users_facultyoffice_index` (`facultyOffice`),
  KEY `users_course_index` (`course`),
  CONSTRAINT `FK_users_courses` FOREIGN KEY (`course`) REFERENCES `courses` (`no_course`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_users_faculty_offices` FOREIGN KEY (`facultyOffice`) REFERENCES `faculty_offices` (`no_facultyOffice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.users: ~29 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `facultyOffice`, `course`, `no_matriks`, `created_at`, `updated_at`) VALUES
	(3, 'NABIL', 'nabil@gmail.com', NULL, '$2y$12$7YC9y36czWNax1tAr4/3nOn/pt.rytYg74BFkMuU4HmQ06GXOP3QK', 'admin', 1, 1, 'MATR0001', '2024-12-06 00:32:15', '2024-12-14 02:49:08'),
	(4, 'SYED NABIL', 'syed0413@gmail.com', NULL, '$2y$12$e.zD.sB3TRFvjWvqJybyueNoS7TjQd4nrOmAfc.Oqpu8JYokbqlay', 'user', 1, 1, 'AI230046', '2024-12-06 03:25:46', '2024-12-22 02:12:58'),
	(5, 'NurAin Zaf', 'ZafZul@gmail.com', NULL, '$2y$12$ue2oErGNMn1LMqO2hx37aeJYBUFCnGQAItlSOGkDV2rJOHvTK7062', 'user', 1, 1, 'Ai230065', '2024-12-07 01:59:46', '2024-12-07 01:59:46'),
	(7, 'Nik faiz', 'Nikfazi@gmail.com', NULL, '$2y$12$BwKOv.rrg4DUo1ySGMYlfu3qu2ihOLBWeHKg72.Kx4EYoKct3VE4W', 'user', 1, 1, 'AI230087', '2024-12-10 21:51:30', '2024-12-10 21:51:30'),
	(8, 'Fazly', 'Faz@gmail.com', NULL, '$2y$12$7fhAiO/CHYoRZm4BhIEfrekatbNs1eturFNliB42syHr.6Q7/OUCK', 'user', 1, 1, 'AB230016', '2024-12-10 21:52:27', '2024-12-10 21:52:27'),
	(9, 'IRFAN', 'Ipanalpha@gmail.com', NULL, '$2y$12$XwyG2hvYT2/DuRuGQPbxB.xQzF9L7AMLAbnNf0WJy5ZhpnMPGM0nW', 'user', 1, 1, 'AI230077', '2024-12-10 21:53:52', '2024-12-10 21:53:52'),
	(10, 'PPP', 'ppp12@gmail.com', NULL, '$2y$12$Q4QIQnEkjj46PGDADkK7mujFsJ0H/Gjk9w0HLVTl0owqh0wn95gs2', 'ppp', NULL, NULL, 'P00012', '2024-12-13 01:06:13', '2024-12-13 01:06:13'),
	(11, 'SHAM', 'CI230043@student.uthm.edu.my', NULL, '$2y$12$CjH/Glz3iO8X8QirkHKhduy2UjB3WhOHxmgJ6GWCF6X35uyy3fqcy', 'user', NULL, NULL, 'CI230043', '2024-12-15 05:06:13', '2024-12-15 05:06:13'),
	(12, 'SHAM', 'CB00043@student.uthm.edu.my', NULL, '$2y$12$nf1MjfpZpngHlt6E73eD.OvP0urXCUk7foz37SVnuWVErkK40FTki', 'user', NULL, NULL, 'CB00043', '2024-12-15 05:24:24', '2024-12-15 05:24:24'),
	(13, 'AKHAI', 'CS0323@student.uthm.edu.my', NULL, '$2y$12$X938j8XvKy/BW235RdUiwud.kY6H8zGQfnjp9VaO0o34MYokRa4FK', 'user', NULL, NULL, 'CS0323', '2024-12-15 05:24:25', '2024-12-15 05:24:25'),
	(14, 'neil', 'AI23434@student.uthm.edu.my', NULL, '$2y$12$bki6f09gATs4ljSvrYxbHeCuYe.R1UZoMdnbVNYPIccQ.rR6Qy/.u', 'user', NULL, NULL, 'AI23434', '2024-12-15 06:53:00', '2024-12-15 06:53:00'),
	(15, 'aiman', 'CM0134@student.uthm.edu.my', NULL, '$2y$12$Ivl.81y8LIkhOUZSgasFL.67huuTyi66Hg8rfsVAa7zpDCjio641G', 'user', NULL, NULL, 'CM0134', '2024-12-15 06:53:00', '2024-12-15 06:53:00'),
	(16, 'nazmi', 'CD231177@student.uthm.edu.my', NULL, '$2y$12$R8DsO7UD8FDAkOcdsQUEPuA6kUVQOY9C.DC282kSToFp38JpfAyCu', 'user', NULL, NULL, 'CD231177', '2024-12-15 06:53:01', '2024-12-15 06:53:01'),
	(17, 'SYED', 'CA232045@student.uthm.edu.my', NULL, '$2y$12$UZ5agc5s43VDmjk2fhjG1.QZdV0Orvjtr2RuTGokhAx48k346RGfm', 'user', NULL, NULL, 'CA232045', '2024-12-15 06:53:01', '2024-12-15 06:53:01'),
	(18, 'Naffisa', 'CI230076@student.uthm.edu.my', NULL, '$2y$12$zl3ugeLjPY5WB5NukarayuL94JjoHJv5hkpwRskZBGkL0GHdBl.Vq', 'user', NULL, NULL, 'CI230076', '2024-12-15 07:02:27', '2024-12-15 07:02:27'),
	(19, 'Aimi', 'AI233452@student.uthm.edu.my', NULL, '$2y$12$0GhNXm/TuAfJMkdTRMJ.HOqrMMHFYXvrRAblZ9.od7vxLGZhj6t0S', 'user', NULL, NULL, 'AI233452', '2024-12-15 07:02:27', '2024-12-15 07:02:27'),
	(20, 'NAJIHA', 'AI23012@student.uthm.edu.my', NULL, '$2y$12$J5doTen4czOj3LKtBzbh2eUwin3FSPtO.QAsQfOY4w.Hh4LC7QLZu', 'user', NULL, NULL, 'AI23012', '2024-12-15 07:02:28', '2024-12-15 07:02:28'),
	(21, 'AIMI', 'CI230231@student.uthm.edu.my', NULL, '$2y$12$Sez2ZGkRk0iP1RI/ey2O/.2D8kVyGipvc6SDomHH4Zx3siUlfXWh2', 'user', NULL, NULL, 'CI230231', '2024-12-15 07:06:02', '2024-12-15 07:06:02'),
	(22, 'NAJIHA', 'CI230052@student.uthm.edu.my', NULL, '$2y$12$5LW5FviPtqYyy9/nv0j.EOb./1atPRvyzSf/.rpeprXnxo429ZJoC', 'user', NULL, NULL, 'CI230052', '2024-12-15 07:06:03', '2024-12-15 07:06:03'),
	(23, 'naffisa', 'CI232323@student.uthm.edu.my', NULL, '$2y$12$OLaGr99MExPXgyNk1EFZdOXBbOKMg5XADAwNglsvg3ixHYROy2kDK', 'user', NULL, NULL, 'CI232323', '2024-12-15 07:06:03', '2024-12-15 07:06:03'),
	(24, 'mail', 'Ai230001@student.uthm.edu.my', NULL, '$2y$12$uDST55qJkPVQXO2suSNad.UBtvXXxr1TuS.yMOjeoZH1ITwD9mDYi', 'user', NULL, NULL, 'Ai230001', '2024-12-15 07:30:47', '2024-12-15 07:30:47'),
	(25, 'Abu', 'Ai230002@student.uthm.edu.my', NULL, '$2y$12$9IA/Um9c5/dklsSBzMYKLOUkrgsyqHlJPe74P2dK9LE1sAAvh/05m', 'user', NULL, NULL, 'Ai230002', '2024-12-15 07:30:48', '2024-12-15 07:30:48'),
	(26, 'Sofia', 'AI230003@student.uthm.edu.my', NULL, '$2y$12$tf2uZCaZftb9y74SmD.cMOHSPC0g7aEbufxENeCFuFZGkV4bEUKwm', 'user', NULL, NULL, 'AI230003', '2024-12-15 07:30:48', '2024-12-15 07:30:48'),
	(27, 'Aisyah', 'AI230004@student.uthm.edu.my', NULL, '$2y$12$FYEc1fGwYlKTPc40cyiUDulSIWprBpseSM5iNyN3X71yTpFBTWVj6', 'user', NULL, NULL, 'AI230004', '2024-12-15 07:30:49', '2024-12-15 07:30:49'),
	(28, 'Nafiz', 'Ai230005@student.uthm.edu.my', NULL, '$2y$12$z6OKewtDjMVNs1pY6NrEF.C6s4aucB5iSDD2aO/lw9QBXTY9gWAzy', 'user', NULL, NULL, 'Ai230005', '2024-12-15 07:35:23', '2024-12-15 07:35:23'),
	(29, 'Farhan', 'Ai230006@student.uthm.edu.my', NULL, '$2y$12$KfRALkYeZyf83AulJs7Vue/hlORSbOJaN.xxpEVkmCCeTgnKT.DtO', 'user', NULL, NULL, 'Ai230006', '2024-12-15 07:35:23', '2024-12-15 07:35:23'),
	(30, 'NAZIM FARHAN', 'AI230007@student.uthm.edu.my', NULL, '$2y$12$86mnXfcbMUxokISLAjgWeOmpCAG6.KcTxMfMbr7wBSQOTFMT3zN2O', 'user', NULL, NULL, 'AI230007', '2024-12-15 07:35:24', '2024-12-15 07:35:24'),
	(31, 'SYARIFAH', 'AI230008@student.uthm.edu.my', NULL, '$2y$12$WPW7rATV9W1sA4goqRxpXOPiDZkjmdcMVrUJ/XZ11AF4AIutrwICW', 'user', NULL, NULL, 'AI230008', '2024-12-15 07:41:09', '2024-12-15 07:41:09'),
	(32, 'FAIZ', 'AI230009@student.uthm.edu.my', NULL, '$2y$12$Vo.S4R/paWJZOKiIcMgCK./eFVgo/Vzf1N9yt/h/X0os5UpWISTMK', 'user', NULL, NULL, 'AI230009', '2024-12-15 07:41:09', '2024-12-15 07:41:09'),
	(33, 'WAN ZAHARAH', 'AI230010@student.uthm.edu.my', NULL, '$2y$12$dzGLIaiwujvNT98KnfAtguny/6HjXnFru3osnx2M4AmjmsSyjImvu', 'user', NULL, NULL, 'AI230010', '2024-12-15 07:41:10', '2024-12-15 07:41:10');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
