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
  `booking_time` time NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_room` bigint unsigned NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `list_student` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_no_room_foreign` (`no_room`),
  KEY `bookings_list_student_foreign` (`list_student`),
  CONSTRAINT `FK_bookings_list_student_booking` FOREIGN KEY (`list_student`) REFERENCES `list_student_booking` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_bookings_rooms` FOREIGN KEY (`no_room`) REFERENCES `rooms` (`no_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.bookings: ~0 rows (approximately)

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

-- Dumping data for table libraroom reservation system.courses: ~1 rows (approximately)
INSERT INTO `courses` (`no_course`, `name`, `department`, `created_at`, `updated_at`) VALUES
	(1, ' BACHELOR OF COMPUTER SCIENCE (SOFTWARE ENGINEERING) WITH HONOURS', 1, '2024-11-26 00:18:40', '2024-11-26 00:18:40');

-- Dumping structure for table libraroom reservation system.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `no_department` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_department`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.departments: ~1 rows (approximately)
INSERT INTO `departments` (`no_department`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'software engineering', '2024-11-26 00:18:11', '2024-11-26 00:18:11');

-- Dumping structure for table libraroom reservation system.electronic_equipment
CREATE TABLE IF NOT EXISTS `electronic_equipment` (
  `no_electronicEquipment` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_electronicEquipment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.electronic_equipment: ~0 rows (approximately)

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.faculty_offices: ~1 rows (approximately)
INSERT INTO `faculty_offices` (`no_facultyOffice`, `name`, `department`, `created_at`, `updated_at`) VALUES
	(2, 'FSKTM', 1, '2024-11-26 00:18:47', '2024-11-26 00:18:47');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.furniture: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.list_student_booking
CREATE TABLE IF NOT EXISTS `list_student_booking` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_no_matriks1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_no_matriks2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_no_matriks3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_no_matriks4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_no_matriks5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_no_matriks6` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_no_matriks7` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_no_matriks8` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_no_matriks9` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_no_matriks10` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `list_student_booking_user_no_matriks1_foreign` (`user_no_matriks1`),
  KEY `list_student_booking_user_no_matriks2_foreign` (`user_no_matriks2`),
  KEY `list_student_booking_user_no_matriks3_foreign` (`user_no_matriks3`),
  KEY `list_student_booking_user_no_matriks4_foreign` (`user_no_matriks4`),
  KEY `list_student_booking_user_no_matriks5_foreign` (`user_no_matriks5`),
  KEY `list_student_booking_user_no_matriks6_foreign` (`user_no_matriks6`),
  KEY `list_student_booking_user_no_matriks7_foreign` (`user_no_matriks7`),
  KEY `list_student_booking_user_no_matriks8_foreign` (`user_no_matriks8`),
  KEY `list_student_booking_user_no_matriks9_foreign` (`user_no_matriks9`),
  KEY `list_student_booking_user_no_matriks10_foreign` (`user_no_matriks10`),
  CONSTRAINT `list_student_booking_user_no_matriks10_foreign` FOREIGN KEY (`user_no_matriks10`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks1_foreign` FOREIGN KEY (`user_no_matriks1`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks2_foreign` FOREIGN KEY (`user_no_matriks2`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks3_foreign` FOREIGN KEY (`user_no_matriks3`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks4_foreign` FOREIGN KEY (`user_no_matriks4`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks5_foreign` FOREIGN KEY (`user_no_matriks5`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks6_foreign` FOREIGN KEY (`user_no_matriks6`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks7_foreign` FOREIGN KEY (`user_no_matriks7`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks8_foreign` FOREIGN KEY (`user_no_matriks8`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `list_student_booking_user_no_matriks9_foreign` FOREIGN KEY (`user_no_matriks9`) REFERENCES `users` (`no_matriks`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.list_student_booking: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.migrations: ~20 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2024_10_25_092523_create_students_table', 1),
	(7, '2024_10_25_092606_create_staff_table', 1),
	(8, '2024_10_25_092607_create_faculty_offices_table', 2),
	(9, '2024_10_25_092609_create_departments_table', 2),
	(10, '2024_10_25_092611_create_courses_table', 2),
	(11, '2024_10_25_092612_create_rooms_table', 2),
	(12, '2024_10_25_092614_create_furniture_table', 2),
	(13, '2024_10_25_092615_create_electronic_equipment_table', 2),
	(14, '2024_10_27_115533_add_email_password_notifications_to_student_and_staff_tables', 2),
	(15, '2024_10_30_173224_add_nomatriks_to_users', 2),
	(16, '2024_10_31_072629_add_timestamps_to_users_table', 2),
	(17, '2024_11_05_142112_create_bookings_table', 2),
	(18, '2024_11_09_113733_create_settings_table', 2),
	(19, '2024_11_26_060340_create_list_student_booking_table', 2),
	(21, '2024_11_29_104016_create_notifications_table', 4);

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
  `furniture` bigint unsigned NOT NULL,
  `electronicEquipment` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_room`),
  KEY `rooms_furniture_index` (`furniture`),
  KEY `rooms_electronicequipment_index` (`electronicEquipment`),
  CONSTRAINT `FK_rooms_electronic_equipment` FOREIGN KEY (`electronicEquipment`) REFERENCES `electronic_equipment` (`no_electronicEquipment`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_rooms_furniture` FOREIGN KEY (`furniture`) REFERENCES `furniture` (`no_furniture`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.rooms: ~0 rows (approximately)

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.settings: ~1 rows (approximately)
INSERT INTO `settings` (`id`, `description`, `short_des`, `logo`, `photo`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
	(1, '', '', '', '', '', '', '', '2024-11-29 04:33:51', '2024-11-29 04:33:51');

-- Dumping structure for table libraroom reservation system.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `no_staff` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `facultyOffice` bigint unsigned NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_staff`),
  UNIQUE KEY `staff_email_unique` (`email`),
  KEY `staff_facultyoffice_index` (`facultyOffice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.staff: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.students
CREATE TABLE IF NOT EXISTS `students` (
  `no_matriks` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `facultyOffice` bigint unsigned NOT NULL,
  `course` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`no_matriks`),
  UNIQUE KEY `students_email_unique` (`email`),
  KEY `students_facultyoffice_index` (`facultyOffice`),
  KEY `students_course_index` (`course`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.students: ~0 rows (approximately)

-- Dumping structure for table libraroom reservation system.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('student','staff','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table libraroom reservation system.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `facultyOffice`, `course`, `no_matriks`, `created_at`, `updated_at`) VALUES
	(7, 'NABIL', 'nabil@gmail.com', NULL, '$2y$12$teyEZ7TqZ3s9QRGT9SQ1u.OhpCP.XA1GEqszpo0X7UsZv04X6BLAa', 'admin', 2, 1, 'MATR123456', '2024-11-26 00:20:45', '2024-11-26 00:20:45');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
