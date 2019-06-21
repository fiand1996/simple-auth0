-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2019 at 06:10 AM
-- Server version: 10.3.13-MariaDB-log
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nama`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'general.site_name', 'AdminLTE'),
(2, 'general.site_title', 'Free Bootstrap Admin Template'),
(3, 'general.site_description', 'Best open source admin dashboard & control panel theme. Built on top of Bootstrap 3, AdminLTE provides a range of responsive, reusable, and commonly used components.'),
(4, 'general.site_keywords', 'html, css, js, bootstrap,template'),
(5, 'email.host', NULL),
(6, 'email.port', NULL),
(7, 'email.encryption', NULL),
(8, 'email.auth', NULL),
(9, 'email.username', NULL),
(10, 'email.password', NULL),
(11, 'email.from', NULL),
(21, 'recaptcha.site_key', NULL),
(22, 'recaptcha.secret_key', NULL),
(23, 'recaptcha.signin', NULL),
(24, 'recaptcha.signup', NULL),
(25, 'recaptcha.forgot', NULL),
(26, 'oauth.api_key', NULL),
(27, 'oauth.facebook', NULL),
(28, 'oauth.google', NULL),
(29, 'oauth.twitter', NULL),
(30, 'oauth.github', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time_format` int(2) NOT NULL DEFAULT 24,
  `date_format` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'd F Y',
  `timezone` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Asia/Jakarta',
  `is_active` int(11) NOT NULL,
  `code_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code_time` int(11) DEFAULT NULL,
  `code` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `expire_date` datetime NOT NULL,
  `app_theme` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'skin-blue-light',
  `app_layout` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(225) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `account_type`, `email`, `password`, `firstname`, `lastname`, `time_format`, `date_format`, `timezone`, `is_active`, `code_type`, `code_time`, `code`, `expire_date`, `app_theme`, `app_layout`, `picture`, `date`) VALUES
(1, 'admin', 'fiand@admin.com', '$2y$10$Xi4GzDRfJI84ILIupZQxou0rF2s/zICKWf9aTmqkpvm1qbhOcDIcu', 'Fiand', 'T', 24, 'Y-m-d', 'Asia/Jakarta', 1, '', NULL, NULL, '2035-06-02 13:30:00', 'skin-blue-light', 'fixed', 'avatar.png', '2019-05-23 10:39:19');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
