-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.6.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table secure-auth.audit_logs
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table secure-auth.audit_logs: ~6 rows (approximately)
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `timestamp`) VALUES
	(27, 23, 'Login sukses', '2024-12-03 13:47:39'),
	(28, 23, 'Login sukses', '2024-12-03 14:30:12'),
	(29, 22, 'Login sukses', '2024-12-03 18:04:34'),
	(30, 23, 'Login sukses', '2024-12-03 18:04:48'),
	(31, 23, 'Login sukses', '2024-12-03 18:04:57'),
	(32, 24, 'Login sukses', '2024-12-03 18:05:21');

-- Dumping structure for table secure-auth.login_attempts
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `attempts` int(11) DEFAULT 0,
  `last_attempt` datetime DEFAULT current_timestamp(),
  `locked_until` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table secure-auth.login_attempts: ~0 rows (approximately)

-- Dumping structure for table secure-auth.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table secure-auth.password_resets: ~4 rows (approximately)
INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
	(1, 'heryandi2806@gmail.com', '473225', '2024-12-03 18:19:39'),
	(2, 'heryandi2880@gmail.com', '456797', '2024-12-03 18:19:45'),
	(3, 'heryandi2806@gmail.com', '888519', '2024-12-03 18:21:25'),
	(4, 'heryandi2806@gmail.com', '807958', '2024-12-03 18:31:10'),
	(5, 'heryandi2806@gmail.com', '198393', '2024-12-03 18:34:11'),
	(6, 'heryandi2806@gmail.com', '414369', '2024-12-03 18:34:20'),
	(7, 'heryandi2806@gmail.com', '770501', '2024-12-03 18:35:46');

-- Dumping structure for table secure-auth.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','moderator','user') DEFAULT 'user',
  `mfa_secret` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table secure-auth.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `mfa_secret`, `created_at`) VALUES
	(22, 'heryandi', 'heryandi2806@gmail.com', '$2y$10$hMVHgUSOxYtINYpmD3ssGegcb3MxF9ka.np8QeHPWv9TgPKVu3WVG', 'user', NULL, '2024-12-03 13:47:19'),
	(23, 'hery', 'heryandi2880@gmail.com', '$2y$10$bNZk13g0tnhQiHDeuHYau.gHTPyuJpEhM0XMnYLqOL8w3p7OJu3mS', 'user', NULL, '2024-12-03 13:47:33'),
	(24, 'manik', 'manik@s.id', '$2y$10$llUKQoHH68RvW8ojw38wm.o69EHgCFj7MfS3TUq/YrhAT9tiG7SIa', 'user', NULL, '2024-12-03 18:05:14');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
