-- -------------------------------------------------------------
-- TablePlus 6.6.8(632)
--
-- https://tableplus.com/
--
-- Database: laravel
-- Generation Time: 2025-08-08 12:23:19.0540
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `authentication_logs`;
CREATE TABLE `authentication_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_type` enum('email','username') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'email',
  `status` enum('success','failed','blocked','logout') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failure_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_data` json DEFAULT NULL,
  `login_at` timestamp NOT NULL,
  `logout_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `authentication_logs_user_id_login_at_index` (`user_id`,`login_at`),
  KEY `authentication_logs_email_login_at_index` (`email`,`login_at`),
  KEY `authentication_logs_ip_address_login_at_index` (`ip_address`,`login_at`),
  KEY `authentication_logs_status_index` (`status`),
  CONSTRAINT `authentication_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `authentication_logs` (`id`, `user_id`, `email`, `username`, `login_type`, `status`, `ip_address`, `user_agent`, `device`, `location`, `failure_reason`, `additional_data`, `login_at`, `logout_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'huank@ice.edu.com', 'huannk', 'email', 'logout', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-08 05:16:27', '2025-08-08 05:16:27', '2025-08-08 05:16:27', '2025-08-08 05:16:27'),
(2, 1, 'huank@ice.edu.com', 'huannk', 'email', 'logout', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-08 05:16:27', '2025-08-08 05:16:27', '2025-08-08 05:16:27', '2025-08-08 05:16:27'),
(3, 1, 'huank@ice.edu.com', 'huannk', 'username', 'success', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'desktop', NULL, NULL, NULL, '2025-08-08 05:16:31', NULL, '2025-08-08 05:16:31', '2025-08-08 05:16:31');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;