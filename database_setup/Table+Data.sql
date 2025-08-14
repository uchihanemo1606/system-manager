-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 14, 2025 lúc 11:35 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sys_mng`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_rule`
--

CREATE TABLE `category_rule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `database`
--

CREATE TABLE `database` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dbname` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `decription` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `database`
--

INSERT INTO `database` (`id`, `dbname`, `created_by`, `decription`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'mysql', 'ono', NULL, 0, '2025-07-24 00:52:12', '2025-07-24 00:52:12'),
(5, 'dsqz', 'ono', NULL, 0, '2025-07-24 01:35:35', '2025-07-24 01:35:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `database_version`
--

CREATE TABLE `database_version` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dbname` varchar(100) NOT NULL,
  `version` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `decription` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `database_version`
--

INSERT INTO `database_version` (`id`, `dbname`, `version`, `created_by`, `decription`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'mysql', '1.0', 'ono', NULL, 1, '2025-07-24 00:52:12', '2025-07-24 00:52:12'),
(2, 'dsqz', '2.0.0', 'ono', NULL, 1, '2025-07-24 01:35:35', '2025-07-24 01:35:35'),
(3, 'dsqz', '1.1.1', 'ono', NULL, 1, '2025-07-24 01:35:43', '2025-07-24 01:35:43'),
(4, 'mysql', '2.0.0', 'ono', NULL, 1, '2025-07-24 19:25:41', '2025-07-24 19:25:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `domain`
--

CREATE TABLE `domain` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `software_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `link` varchar(500) NOT NULL,
  `createBy` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hardware`
--

CREATE TABLE `hardware` (
  `ip` varchar(25) NOT NULL,
  `dbname` varchar(100) NOT NULL,
  `dbversion` varchar(100) NOT NULL,
  `isVirtualServer` tinyint(1) NOT NULL DEFAULT 0,
  `OS` varchar(100) NOT NULL,
  `OSver` varchar(100) NOT NULL,
  `hdd` varchar(50) NOT NULL,
  `ram` varchar(50) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `services` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hardware_access_domain`
--

CREATE TABLE `hardware_access_domain` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hardware_ip` varchar(25) NOT NULL,
  `domain_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hardware_permissions`
--

CREATE TABLE `hardware_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hardware_ip` varchar(25) NOT NULL,
  `permissions_name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_createby` varchar(100) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `log`
--

CREATE TABLE `log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `software_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hardware_ip` varchar(25) DEFAULT NULL,
  `rule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `software_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `link_domain` varchar(500) DEFAULT NULL,
  `sw_permission_user` varchar(100) DEFAULT NULL,
  `hw_permission_user` varchar(100) DEFAULT NULL,
  `permission_name` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_rule` varchar(300) DEFAULT NULL,
  `database_name` varchar(100) DEFAULT NULL,
  `os_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(26, '2025_06_30_041329_create_password_reset', 1),
(27, '2025_07_01_074919_create_log_table', 1),
(28, '2025_07_12_070500_add_foreign_key', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `os`
--

CREATE TABLE `os` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `architecture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `os`
--

INSERT INTO `os` (`id`, `name`, `architecture`, `is_active`, `is_deleted`, `created_by`, `updated_by`, `deleted_by`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'windows', 'bug', 1, 0, 'ono', NULL, NULL, NULL, NULL, '2025-07-24 01:22:26', '2025-07-24 01:22:26'),
(2, 'windowss', 'bug', 1, 0, 'ono', NULL, NULL, NULL, NULL, '2025-07-24 01:23:43', '2025-07-24 01:23:43'),
(4, 'linuxx', 'bug', 1, 0, 'ono', NULL, NULL, NULL, NULL, '2025-07-24 01:26:03', '2025-07-24 01:26:03'),
(5, 'ubuntu', 'bug', 1, 0, 'ono', NULL, NULL, NULL, NULL, '2025-07-24 01:34:52', '2025-07-24 01:34:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `os_version`
--

CREATE TABLE `os_version` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `os_name` varchar(100) NOT NULL,
  `version` varchar(100) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `os_version`
--

INSERT INTO `os_version` (`id`, `os_name`, `version`, `created_by`, `description`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'linuxx', '1.0', 'ono', NULL, 1, '2025-07-24 01:26:03', '2025-07-24 01:26:03'),
(2, 'ubuntu', '1.0', 'ono', NULL, 1, '2025-07-24 01:34:52', '2025-07-24 01:34:52'),
(3, 'ubuntu', '2.0.0', 'ono', NULL, 1, '2025-07-24 01:35:00', '2025-07-24 01:35:00'),
(4, 'ubuntu', '3.2', 'ono', NULL, 1, '2025-07-24 02:14:10', '2025-07-24 02:14:10'),
(5, 'windows', '2.0.0', 'ono', NULL, 1, '2025-07-24 02:16:15', '2025-07-24 02:16:15'),
(6, 'windowss', '1.1.0', 'ono', NULL, 1, '2025-07-24 02:16:23', '2025-07-24 02:16:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset`
--

CREATE TABLE `password_reset` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL,
  `otp_attempts` int(11) NOT NULL DEFAULT 0,
  `isVerified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `user_creately` varchar(100) NOT NULL,
  `permissions_name` varchar(150) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permissions`
--

INSERT INTO `permissions` (`user_creately`, `permissions_name`, `type`, `created_at`, `updated_at`) VALUES
('ono', 'quản lý người dùng', 'user', NULL, NULL),
('ono', 'quản lý phần cứng', 'hardware', NULL, NULL),
('ono', 'quản lý phần mềm', 'software', NULL, NULL),
('ono', 'sửa danh mục', 'category', '2025-07-31 14:16:59', '2025-07-31 14:16:59'),
('ono', 'sửa hệ thống', 'system', '2025-07-10 07:57:24', '2025-07-10 07:57:24'),
('ono', 'sửa người dùng', 'user', '2025-06-24 12:09:16', '2025-06-24 12:09:16'),
('ono', 'sửa người dùng quản lý phần cứng', 'hardwarepermission', '2025-07-03 02:20:35', '2025-07-03 02:20:35'),
('ono', 'sửa người dùng quản lý phần mềm', 'softwarepermission', '2025-07-03 04:46:57', '2025-07-03 04:46:57'),
('ono', 'sửa phần cứng', 'hardware', '2025-06-24 12:15:15', '2025-06-24 12:15:15'),
('ono', 'sửa phần cứng vào domain', 'hardwaredomain', '2025-06-25 21:26:58', '2025-06-25 21:26:58'),
('ono', 'sửa phần mềm', 'software', '2025-07-02 19:43:53', '2025-07-02 19:43:53'),
('ono', 'sửa pháp lý', 'legal', '2025-07-17 05:18:45', '2025-07-17 05:18:45'),
('ono', 'sửa quyền hạn', 'permission', '2025-06-24 12:09:39', '2025-06-24 12:09:39'),
('ono', 'sửa quyền hệ thống', 'systempermission', '2025-06-25 17:04:41', '2025-06-25 17:04:41'),
('ono', 'sửa quyền người dùng', 'userrole', '2025-06-24 12:11:12', '2025-06-24 12:11:12'),
('ono', 'sửa tên miền', 'domain', '2025-06-25 20:14:47', '2025-06-25 20:14:47'),
('ono', 'sửa tệp tin phần mềm', 'softwarefile', '2025-07-10 05:37:37', '2025-07-10 05:37:37'),
('ono', 'sửa vai trò', 'role', '2025-06-24 12:10:01', '2025-06-24 12:10:01'),
('ono', 'thêm danh mục', 'category', '2025-07-31 14:16:58', '2025-07-31 14:16:58'),
('ono', 'thêm hệ thống', 'system', '2025-07-10 07:57:20', '2025-07-10 07:57:20'),
('ono', 'thêm người dùng', 'user', '2025-06-25 10:14:03', '2025-06-25 10:14:03'),
('ono', 'thêm người dùng quản lý phần cứng', 'hardwarepermission', '2025-07-03 02:20:38', '2025-07-03 02:20:38'),
('ono', 'thêm người dùng quản lý phần mềm', 'softwarepermission', '2025-07-03 04:46:53', '2025-07-03 04:46:53'),
('ono', 'thêm phần cứng', 'hardware', '2025-06-24 12:15:11', '2025-06-24 12:15:11'),
('ono', 'thêm phần cứng vào domain', 'hardwaredomain', '2025-06-25 21:26:54', '2025-06-25 21:26:54'),
('ono', 'thêm phần mềm', 'software', '2025-06-25 10:11:35', '2025-06-25 10:11:35'),
('ono', 'thêm pháp lý', 'legal', '2025-07-17 05:18:42', '2025-07-17 05:18:42'),
('nemoadmin', 'thêm quyền hạn', 'Quyền hạn', '2025-06-05 04:05:10', '2025-06-05 04:05:10'),
('ono', 'thêm quyền hệ thống', 'systempermission', '2025-06-25 17:04:34', '2025-06-25 17:04:34'),
('ono', 'thêm quyền người dùng', 'userrole', '2025-06-18 21:25:25', '2025-06-18 21:25:25'),
('ono', 'thêm tên miền', 'domain', '2025-06-25 20:14:39', '2025-06-25 20:14:39'),
('ono', 'thêm tệp tin phần mềm', 'softwarefile', '2025-07-10 05:37:32', '2025-07-10 05:37:32'),
('ono', 'thêm vai trò', 'role', '2025-06-18 13:57:59', '2025-06-18 13:57:59'),
('ono', 'xem chi tiết danh mục', 'category', '2025-07-31 14:17:02', '2025-07-31 14:17:02'),
('ono', 'xem chi tiết hệ thống', 'system', '2025-07-10 07:57:33', '2025-07-10 07:57:33'),
('ono', 'xem chi tiết người dùng', 'user', '2025-06-25 10:14:09', '2025-06-25 10:14:09'),
('ono', 'xem chi tiết người dùng quản lý phần cứng', 'hardwarepermission', '2025-07-03 02:20:40', '2025-07-03 02:20:40'),
('ono', 'xem chi tiết người dùng quản lý phần mềm', 'softwarepermission', '2025-07-03 04:47:06', '2025-07-03 04:47:06'),
('ono', 'xem chi tiết phần cứng', 'hardware', '2025-06-24 12:15:28', '2025-06-24 12:15:28'),
('ono', 'xem chi tiết phần cứng vào domain', 'hardwaredomain', '2025-06-25 21:27:05', '2025-06-25 21:27:05'),
('ono', 'xem chi tiết phần mềm', 'software', '2025-06-25 10:11:49', '2025-06-25 10:11:49'),
('ono', 'xem chi tiết pháp lý', 'legal', '2025-07-17 05:18:50', '2025-07-17 05:18:50'),
('ono', 'xem chi tiết quyền hạn', 'permission', '2025-07-03 04:52:18', '2025-07-03 04:52:18'),
('ono', 'xem chi tiết quyền hệ thống', 'systempermission', '2025-07-31 14:17:16', '2025-07-31 14:17:16'),
('ono', 'xem chi tiết quyền người dùng', 'userrole', '2025-07-31 14:17:20', '2025-07-31 14:17:20'),
('ono', 'xem chi tiết tên miền', 'domain', '2025-06-25 20:16:54', '2025-06-25 20:16:54'),
('ono', 'xem chi tiết tệp tin phần mềm', 'softwarefile', '2025-07-10 05:37:50', '2025-07-10 05:37:50'),
('ono', 'xem chi tiết vai trò', 'role', '2025-06-25 17:10:08', '2025-06-25 17:10:08'),
('ono', 'xem danh mục', 'category', '2025-07-31 14:17:01', '2025-07-31 14:17:01'),
('ono', 'xem danh sách danh mục', 'category', '2025-07-31 14:17:01', '2025-07-31 14:17:01'),
('ono', 'xem danh sách hệ thống', 'system', '2025-07-10 07:57:30', '2025-07-10 07:57:30'),
('ono', 'xem danh sách người dùng', 'user', '2025-06-18 11:59:24', '2025-06-18 11:59:24'),
('ono', 'xem danh sách người dùng quản lý phần cứng', 'hardwarepermission', '2025-07-03 02:20:12', '2025-07-03 02:20:12'),
('ono', 'xem danh sách người dùng quản lý phần mềm', 'softwarepermission', '2025-07-03 04:47:03', '2025-07-03 04:47:03'),
('ono', 'xem danh sách phần cứng', 'hardware', '2025-06-24 12:15:22', '2025-06-24 12:15:22'),
('ono', 'xem danh sách phần cứng vào domain', 'hardwaredomain', '2025-06-25 21:27:02', '2025-06-25 21:27:02'),
('ono', 'xem danh sách phần mềm', 'software', '2025-06-25 10:11:46', '2025-06-25 10:11:46'),
('ono', 'xem danh sách pháp lý', 'legal', '2025-06-25 20:18:19', '2025-06-25 20:18:19'),
('nemoadmin', 'xem danh sách quyền hạn', 'Quyền hạn', '2025-06-05 04:05:30', '2025-06-05 04:05:30'),
('ono', 'xem danh sách quyền hệ thống', 'systempermission', '2025-07-31 14:17:17', '2025-07-31 14:17:17'),
('ono', 'xem danh sách quyền người dùng', 'userrole', '2025-06-24 12:11:01', '2025-06-24 12:11:01'),
('ono', 'xem danh sách tên miền', 'domain', '2025-06-25 20:15:02', '2025-06-25 20:15:02'),
('ono', 'xem danh sách tệp tin phần mềm', 'softwarefile', '2025-07-10 05:37:48', '2025-07-10 05:37:48'),
('ono', 'xem danh sách vai trò', 'Quyền hạn', '2025-06-01 22:22:24', '2025-06-01 22:22:24'),
('ono', 'xem hệ thống', 'system', '2025-07-10 07:57:28', '2025-07-10 07:57:28'),
('ono', 'xem người dùng', 'user', '2025-07-02 21:13:12', '2025-07-02 21:13:12'),
('ono', 'xem người dùng quản lý phần cứng', 'hardwarepermission', '2025-07-03 02:20:28', '2025-07-03 02:20:28'),
('ono', 'xem người dùng quản lý phần mềm', 'softwarepermission', '2025-07-03 04:47:01', '2025-07-03 04:47:01'),
('ono', 'xem phần cứng', 'hardware', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
('ono', 'xem phần cứng vào domain', 'hardwaredomain', '2025-07-10 11:58:23', '2025-07-10 11:58:23'),
('ono', 'xem phần mềm', 'software', '2025-07-02 21:09:22', '2025-07-02 21:09:22'),
('ono', 'xem pháp lý', 'legal', '2025-07-17 05:18:47', '2025-07-17 05:18:47'),
('ono', 'xem quyền hạn', 'permission', '2025-07-03 04:52:17', '2025-07-03 04:52:17'),
('ono', 'xem quyền hệ thống', 'systempermission', '2025-07-31 14:17:15', '2025-07-31 14:17:15'),
('ono', 'xem quyền người dùng', 'userrole', '2025-07-31 14:17:19', '2025-07-31 14:17:19'),
('ono', 'xem tên miền', 'domain', '2025-07-03 12:29:16', '2025-07-03 12:29:16'),
('ono', 'xem tệp tin phần mềm', 'softwarefile', '2025-07-10 05:37:45', '2025-07-10 05:37:45'),
('ono', 'xem vai trò', 'role', '2025-07-03 04:51:59', '2025-07-03 04:51:59'),
('ono', 'xoá danh mục', 'category', '2025-07-31 14:17:00', '2025-07-31 14:17:00'),
('ono', 'xoá hệ thống', 'system', '2025-07-10 07:57:26', '2025-07-10 07:57:26'),
('ono', 'xoá người dùng', 'user', '2025-06-25 10:14:07', '2025-06-25 10:14:07'),
('ono', 'xoá người dùng quản lý phần cứng', 'hardwarepermission', '2025-07-03 02:20:31', '2025-07-03 02:20:31'),
('ono', 'xoá người dùng quản lý phần mềm', 'softwarepermission', '2025-07-03 04:46:59', '2025-07-03 04:46:59'),
('ono', 'xoá phần cứng', 'hardware', '2025-06-24 12:15:20', '2025-06-24 12:15:20'),
('ono', 'xoá phần cứng vào domain', 'hardwaredomain', '2025-06-25 21:27:00', '2025-06-25 21:27:00'),
('ono', 'xoá phần mềm', 'software', '2025-06-25 10:11:42', '2025-06-25 10:11:42'),
('ono', 'xoá pháp lý', 'legal', '2025-06-25 20:18:00', '2025-06-25 20:18:00'),
('ono', 'xoá quyền hạn', 'permission', '2025-06-25 17:03:24', '2025-06-25 17:03:24'),
('ono', 'xoá quyền hệ thống', 'systempermission', '2025-07-31 14:16:53', '2025-07-31 14:16:53'),
('ono', 'xoá quyền người dùng', 'userrole', '2025-06-25 17:04:47', '2025-06-25 17:04:47'),
('ono', 'xoá tên miền', 'domain', '2025-06-25 20:14:55', '2025-06-25 20:14:55'),
('ono', 'xoá tệp tin phần mềm', 'softwarefile', '2025-07-10 05:37:41', '2025-07-10 05:37:41'),
('ono', 'xoá vai trò', 'role', '2025-06-25 17:03:37', '2025-06-25 17:03:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `assigned_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-06-26 18:39:52', '2025-07-10 08:02:11', '2025-07-10 08:02:11'),
(2, 'quản lý phần cứng', '2025-06-26 18:40:00', '2025-07-10 08:02:11', '2025-07-10 08:02:11'),
(3, 'quản lý phần mềm', '2025-06-26 18:40:12', '2025-07-10 08:02:11', '2025-07-10 08:02:11'),
(6, 'người dùng cơ bản', '2025-07-10 08:02:11', '2025-07-10 08:02:11', '2025-07-10 08:02:11'),
(7, 'quản lý hệ thống', '2025-07-17 05:19:01', '2025-07-17 05:19:01', '2025-07-17 05:19:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `permission_name` varchar(100) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_name`, `permission_name`, `assigned_at`, `created_at`, `updated_at`) VALUES
(32, 'admin', 'xem danh sách vai trò', '2025-06-18 19:18:33', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(37, 'admin', 'thêm quyền hạn', '2025-06-18 20:36:04', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(38, 'admin', 'xem danh sách quyền hạn', '2025-06-18 20:36:27', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(45, 'admin', 'thêm vai trò', '2025-06-18 13:58:17', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(93, 'admin', 'thêm quyền người dùng', '2025-06-18 22:45:40', '2025-06-18 22:45:40', '2025-06-18 22:45:40'),
(100, 'admin', 'sửa quyền hạn', '2025-06-24 12:10:17', '2025-06-24 12:10:17', '2025-06-24 12:10:17'),
(101, 'admin', 'xem danh sách quyền người dùng', '2025-06-24 12:11:10', '2025-06-24 12:11:10', '2025-06-24 12:11:10'),
(102, 'admin', 'sửa quyền người dùng', '2025-06-24 12:11:27', '2025-06-24 12:11:27', '2025-06-24 12:11:27'),
(103, 'admin', 'sửa vai trò', '2025-06-24 12:12:43', '2025-06-24 12:12:43', '2025-06-24 12:12:43'),
(104, 'quản lý phần cứng', 'thêm phần cứng', '2025-06-24 12:15:35', '2025-06-24 12:15:35', '2025-06-24 12:15:35'),
(105, 'quản lý phần cứng', 'sửa phần cứng', '2025-06-24 12:15:36', '2025-06-24 12:15:36', '2025-06-24 12:15:36'),
(106, 'quản lý phần cứng', 'xoá phần cứng', '2025-06-24 12:15:36', '2025-06-24 12:15:36', '2025-06-24 12:15:36'),
(108, 'quản lý phần cứng', 'xem chi tiết phần cứng', '2025-06-24 12:15:36', '2025-06-24 12:15:36', '2025-06-24 12:15:36'),
(113, 'quản lý phần mềm', 'thêm phần mềm', '2025-06-25 10:12:05', '2025-06-25 10:12:05', '2025-06-25 10:12:05'),
(115, 'quản lý phần mềm', 'xoá phần mềm', '2025-06-25 10:12:06', '2025-06-25 10:12:06', '2025-06-25 10:12:06'),
(116, 'quản lý phần mềm', 'xem danh sách phần mềm', '2025-06-25 10:12:06', '2025-06-25 10:12:06', '2025-06-25 10:12:06'),
(129, 'quản lý phần cứng', 'xem danh sách phần cứng', '2025-06-25 11:34:11', '2025-06-25 11:34:11', '2025-06-25 11:34:11'),
(131, 'admin', 'xoá quyền hạn', '2025-06-25 17:03:32', '2025-06-25 17:03:32', '2025-06-25 17:03:32'),
(132, 'admin', 'xoá vai trò', '2025-06-25 17:03:44', '2025-06-25 17:03:44', '2025-06-25 17:03:44'),
(133, 'admin', 'xoá quyền người dùng', '2025-06-25 17:04:52', '2025-06-25 17:04:52', '2025-06-25 17:04:52'),
(134, 'admin', 'xem chi tiết vai trò', '2025-06-25 17:10:10', '2025-06-25 17:10:10', '2025-06-25 17:10:10'),
(135, 'quản lý phần mềm', 'xem chi tiết phần mềm', '2025-06-25 18:29:18', '2025-06-25 18:29:18', '2025-06-25 18:29:18'),
(152, 'quản lý phần cứng', 'xem phần cứng', '2025-07-02 21:08:34', '2025-07-02 21:08:34', '2025-07-02 21:08:34'),
(153, 'quản lý phần mềm', 'xem phần mềm', '2025-07-02 21:09:28', '2025-07-02 21:09:28', '2025-07-02 21:09:28'),
(154, 'quản lý phần cứng', 'thêm người dùng quản lý phần cứng', '2025-07-03 02:20:55', '2025-07-03 02:20:55', '2025-07-03 02:20:55'),
(155, 'quản lý phần cứng', 'sửa người dùng quản lý phần cứng', '2025-07-03 02:20:55', '2025-07-03 02:20:55', '2025-07-03 02:20:55'),
(156, 'quản lý phần cứng', 'xoá người dùng quản lý phần cứng', '2025-07-03 02:20:56', '2025-07-03 02:20:56', '2025-07-03 02:20:56'),
(157, 'quản lý phần cứng', 'xem danh sách người dùng quản lý phần cứng', '2025-07-03 02:20:56', '2025-07-03 02:20:56', '2025-07-03 02:20:56'),
(158, 'quản lý phần cứng', 'xem người dùng quản lý phần cứng', '2025-07-03 02:20:56', '2025-07-03 02:20:56', '2025-07-03 02:20:56'),
(159, 'quản lý phần cứng', 'xem chi tiết người dùng quản lý phần cứng', '2025-07-03 02:20:56', '2025-07-03 02:20:56', '2025-07-03 02:20:56'),
(160, 'quản lý phần mềm', 'thêm người dùng quản lý phần mềm', '2025-07-03 11:51:25', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(161, 'admin', 'xem vai trò', '2025-07-03 04:52:06', '2025-07-03 04:52:06', '2025-07-03 04:52:06'),
(162, 'admin', 'xem quyền hạn', '2025-07-03 04:52:24', '2025-07-03 04:52:24', '2025-07-03 04:52:24'),
(163, 'admin', 'xem chi tiết quyền hạn', '2025-07-03 04:52:25', '2025-07-03 04:52:25', '2025-07-03 04:52:25'),
(164, 'quản lý phần mềm', 'xem danh sách người dùng quản lý phần mềm', '2025-07-03 11:55:28', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(165, 'quản lý phần mềm', 'xem chi tiết người dùng quản lý phần mềm', '2025-07-03 12:13:50', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(166, 'quản lý phần mềm', 'xem người dùng quản lý phần mềm', '2025-07-03 12:14:37', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(167, 'quản lý phần mềm', 'xoá người dùng quản lý phần mềm', '2025-07-03 12:17:10', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(170, 'quản lý phần mềm', 'sửa phần mềm', '2025-07-10 05:45:23', '2025-07-10 05:45:23', '2025-07-10 05:45:23'),
(171, 'quản lý phần mềm', 'xem danh sách tệp tin phần mềm', '2025-07-10 05:56:23', '2025-07-10 05:56:23', '2025-07-10 05:56:23'),
(172, 'quản lý phần mềm', 'xem tệp tin phần mềm', '2025-07-10 05:56:31', '2025-07-10 05:56:31', '2025-07-10 05:56:31'),
(173, 'quản lý phần mềm', 'xoá tệp tin phần mềm', '2025-07-10 05:56:32', '2025-07-10 05:56:32', '2025-07-10 05:56:32'),
(174, 'quản lý phần mềm', 'sửa tệp tin phần mềm', '2025-07-10 05:56:32', '2025-07-10 05:56:32', '2025-07-10 05:56:32'),
(175, 'quản lý phần mềm', 'thêm tệp tin phần mềm', '2025-07-10 05:56:32', '2025-07-10 05:56:32', '2025-07-10 05:56:32'),
(176, 'quản lý phần mềm', 'xem chi tiết tệp tin phần mềm', '2025-07-10 05:56:32', '2025-07-10 05:56:32', '2025-07-10 05:56:32'),
(177, 'admin', 'thêm hệ thống', '2025-07-10 07:57:43', '2025-07-10 07:57:43', '2025-07-10 07:57:43'),
(178, 'admin', 'sửa hệ thống', '2025-07-10 07:57:43', '2025-07-10 07:57:43', '2025-07-10 07:57:43'),
(179, 'admin', 'xoá hệ thống', '2025-07-10 07:57:43', '2025-07-10 07:57:43', '2025-07-10 07:57:43'),
(180, 'admin', 'xem hệ thống', '2025-07-10 07:57:44', '2025-07-10 07:57:44', '2025-07-10 07:57:44'),
(181, 'admin', 'xem danh sách hệ thống', '2025-07-10 07:57:44', '2025-07-10 07:57:44', '2025-07-10 07:57:44'),
(182, 'admin', 'xem chi tiết hệ thống', '2025-07-10 07:57:44', '2025-07-10 07:57:44', '2025-07-10 07:57:44'),
(183, 'người dùng cơ bản', 'xem người dùng', '2025-07-10 08:02:11', '2025-07-10 08:02:11', '2025-07-10 08:02:11'),
(185, 'người dùng cơ bản', 'xem chi tiết người dùng', '2025-07-10 08:02:11', '2025-07-10 08:02:11', '2025-07-10 08:02:11'),
(186, 'người dùng cơ bản', 'xem phần cứng', '2025-07-10 08:02:12', '2025-07-10 08:02:12', '2025-07-10 08:02:12'),
(188, 'người dùng cơ bản', 'xem chi tiết phần cứng', '2025-07-10 08:02:12', '2025-07-10 08:02:12', '2025-07-10 08:02:12'),
(202, 'người dùng cơ bản', 'xem phần mềm', '2025-07-16 15:26:43', '2025-07-16 15:26:43', '2025-07-16 15:26:43'),
(203, 'người dùng cơ bản', 'xem chi tiết phần mềm', '2025-07-16 15:26:44', '2025-07-16 15:26:44', '2025-07-16 15:26:44'),
(254, 'quản lý hệ thống', 'thêm pháp lý', '2025-07-31 22:58:10', '2025-07-31 22:58:10', '2025-07-31 22:58:10'),
(255, 'quản lý hệ thống', 'sửa pháp lý', '2025-07-31 22:58:10', '2025-07-31 22:58:10', '2025-07-31 22:58:10'),
(256, 'quản lý hệ thống', 'xoá pháp lý', '2025-07-31 22:58:11', '2025-07-31 22:58:11', '2025-07-31 22:58:11'),
(257, 'quản lý hệ thống', 'xem pháp lý', '2025-07-31 22:58:11', '2025-07-31 22:58:11', '2025-07-31 22:58:11'),
(258, 'quản lý hệ thống', 'xem danh sách pháp lý', '2025-07-31 22:58:11', '2025-07-31 22:58:11', '2025-07-31 22:58:11'),
(259, 'quản lý hệ thống', 'xem chi tiết pháp lý', '2025-07-31 22:58:11', '2025-07-31 22:58:11', '2025-07-31 22:58:11'),
(260, 'quản lý hệ thống', 'thêm danh mục', '2025-07-31 22:58:11', '2025-07-31 22:58:11', '2025-07-31 22:58:11'),
(261, 'quản lý hệ thống', 'sửa danh mục', '2025-07-31 22:58:12', '2025-07-31 22:58:12', '2025-07-31 22:58:12'),
(262, 'quản lý hệ thống', 'xoá danh mục', '2025-07-31 22:58:12', '2025-07-31 22:58:12', '2025-07-31 22:58:12'),
(263, 'quản lý hệ thống', 'xem danh mục', '2025-07-31 22:58:12', '2025-07-31 22:58:12', '2025-07-31 22:58:12'),
(264, 'quản lý hệ thống', 'xem danh sách danh mục', '2025-07-31 22:58:12', '2025-07-31 22:58:12', '2025-07-31 22:58:12'),
(265, 'quản lý hệ thống', 'xem chi tiết danh mục', '2025-07-31 22:58:12', '2025-07-31 22:58:12', '2025-07-31 22:58:12'),
(266, 'quản lý hệ thống', 'sửa quyền hệ thống', '2025-07-31 22:58:33', '2025-07-31 22:58:33', '2025-07-31 22:58:33'),
(267, 'quản lý hệ thống', 'thêm quyền hệ thống', '2025-07-31 22:58:33', '2025-07-31 22:58:33', '2025-07-31 22:58:33'),
(268, 'quản lý hệ thống', 'xoá quyền hệ thống', '2025-07-31 22:58:34', '2025-07-31 22:58:34', '2025-07-31 22:58:34'),
(269, 'quản lý hệ thống', 'xem quyền hệ thống', '2025-07-31 22:58:34', '2025-07-31 22:58:34', '2025-07-31 22:58:34'),
(270, 'quản lý hệ thống', 'xem danh sách quyền hệ thống', '2025-07-31 22:58:34', '2025-07-31 22:58:34', '2025-07-31 22:58:34'),
(271, 'quản lý hệ thống', 'xem chi tiết quyền hệ thống', '2025-07-31 22:58:34', '2025-07-31 22:58:34', '2025-07-31 22:58:34'),
(272, 'quản lý hệ thống', 'thêm người dùng quản lý phần cứng', '2025-07-31 23:00:20', '2025-07-31 23:00:20', '2025-07-31 23:00:20'),
(273, 'quản lý hệ thống', 'xem người dùng quản lý phần cứng', '2025-07-31 23:00:20', '2025-07-31 23:00:20', '2025-07-31 23:00:20'),
(274, 'quản lý hệ thống', 'xem danh sách người dùng quản lý phần cứng', '2025-07-31 23:00:20', '2025-07-31 23:00:20', '2025-07-31 23:00:20'),
(275, 'quản lý hệ thống', 'xem chi tiết người dùng quản lý phần cứng', '2025-07-31 23:00:21', '2025-07-31 23:00:21', '2025-07-31 23:00:21'),
(276, 'quản lý hệ thống', 'thêm người dùng quản lý phần mềm', '2025-07-31 23:00:21', '2025-07-31 23:00:21', '2025-07-31 23:00:21'),
(277, 'quản lý hệ thống', 'xem người dùng quản lý phần mềm', '2025-07-31 23:00:21', '2025-07-31 23:00:21', '2025-07-31 23:00:21'),
(278, 'quản lý hệ thống', 'xem danh sách người dùng quản lý phần mềm', '2025-07-31 23:00:21', '2025-07-31 23:00:21', '2025-07-31 23:00:21'),
(279, 'quản lý hệ thống', 'xem chi tiết người dùng quản lý phần mềm', '2025-07-31 23:00:21', '2025-07-31 23:00:21', '2025-07-31 23:00:21'),
(280, 'quản lý phần mềm', 'sửa người dùng quản lý phần mềm', '2025-07-31 23:00:44', '2025-07-31 23:00:44', '2025-07-31 23:00:44'),
(281, 'quản lý phần mềm', 'thêm tên miền', '2025-07-31 23:00:58', '2025-07-31 23:00:58', '2025-07-31 23:00:58'),
(282, 'quản lý phần mềm', 'sửa tên miền', '2025-07-31 23:00:58', '2025-07-31 23:00:58', '2025-07-31 23:00:58'),
(283, 'quản lý phần mềm', 'xoá tên miền', '2025-07-31 23:00:58', '2025-07-31 23:00:58', '2025-07-31 23:00:58'),
(284, 'quản lý phần mềm', 'xem tên miền', '2025-07-31 23:00:58', '2025-07-31 23:00:58', '2025-07-31 23:00:58'),
(285, 'quản lý phần mềm', 'xem danh sách tên miền', '2025-07-31 23:00:59', '2025-07-31 23:00:59', '2025-07-31 23:00:59'),
(286, 'quản lý phần mềm', 'xem chi tiết tên miền', '2025-07-31 23:00:59', '2025-07-31 23:00:59', '2025-07-31 23:00:59'),
(287, 'quản lý phần mềm', 'thêm phần cứng vào domain', '2025-07-31 23:01:14', '2025-07-31 23:01:14', '2025-07-31 23:01:14'),
(288, 'quản lý phần mềm', 'sửa phần cứng vào domain', '2025-07-31 23:01:14', '2025-07-31 23:01:14', '2025-07-31 23:01:14'),
(289, 'quản lý phần mềm', 'xoá phần cứng vào domain', '2025-07-31 23:01:15', '2025-07-31 23:01:15', '2025-07-31 23:01:15'),
(290, 'quản lý phần mềm', 'xem phần cứng vào domain', '2025-07-31 23:01:15', '2025-07-31 23:01:15', '2025-07-31 23:01:15'),
(291, 'quản lý phần mềm', 'xem danh sách phần cứng vào domain', '2025-07-31 23:01:15', '2025-07-31 23:01:15', '2025-07-31 23:01:15'),
(292, 'quản lý phần mềm', 'xem chi tiết phần cứng vào domain', '2025-07-31 23:01:15', '2025-07-31 23:01:15', '2025-07-31 23:01:15'),
(293, 'quản lý phần mềm', 'thêm pháp lý', '2025-07-31 23:01:39', '2025-07-31 23:01:39', '2025-07-31 23:01:39'),
(294, 'quản lý phần mềm', 'sửa pháp lý', '2025-07-31 23:01:39', '2025-07-31 23:01:39', '2025-07-31 23:01:39'),
(295, 'quản lý phần mềm', 'xoá pháp lý', '2025-07-31 23:01:40', '2025-07-31 23:01:40', '2025-07-31 23:01:40'),
(296, 'quản lý phần mềm', 'xem pháp lý', '2025-07-31 23:01:40', '2025-07-31 23:01:40', '2025-07-31 23:01:40'),
(297, 'quản lý phần mềm', 'xem chi tiết pháp lý', '2025-07-31 23:01:40', '2025-07-31 23:01:40', '2025-07-31 23:01:40'),
(305, 'admin', 'quản lý người dùng', '2025-07-31 23:27:37', NULL, NULL),
(306, 'quản lý phần cứng', 'quản lý phần cứng', '2025-07-31 23:27:54', NULL, NULL),
(307, 'quản lý phần mềm', 'quản lý phần mềm', '2025-07-31 23:28:03', NULL, NULL),
(310, 'người dùng cơ bản', 'xem chi tiết pháp lý', '2025-08-07 19:19:25', '2025-08-07 19:19:25', '2025-08-07 19:19:25'),
(311, 'người dùng cơ bản', 'xem danh sách pháp lý', '2025-08-07 19:19:25', '2025-08-07 19:19:25', '2025-08-07 19:19:25'),
(312, 'người dùng cơ bản', 'xem pháp lý', '2025-08-07 19:19:26', '2025-08-07 19:19:26', '2025-08-07 19:19:26'),
(316, 'quản lý hệ thống', 'xem chi tiết hệ thống', '2025-08-07 19:30:14', '2025-08-07 19:30:14', '2025-08-07 19:30:14'),
(317, 'quản lý hệ thống', 'xem hệ thống', '2025-08-07 19:30:14', '2025-08-07 19:30:14', '2025-08-07 19:30:14'),
(318, 'quản lý hệ thống', 'xem danh sách hệ thống', '2025-08-07 19:30:14', '2025-08-07 19:30:14', '2025-08-07 19:30:14'),
(319, 'quản lý hệ thống', 'xoá hệ thống', '2025-08-07 19:30:14', '2025-08-07 19:30:14', '2025-08-07 19:30:14'),
(320, 'quản lý hệ thống', 'sửa hệ thống', '2025-08-07 19:30:15', '2025-08-07 19:30:15', '2025-08-07 19:30:15'),
(321, 'quản lý hệ thống', 'thêm hệ thống', '2025-08-07 19:30:15', '2025-08-07 19:30:15', '2025-08-07 19:30:15'),
(322, 'người dùng cơ bản', 'xem danh sách tên miền', '2025-08-07 20:00:33', '2025-08-07 20:00:33', '2025-08-07 20:00:33'),
(323, 'người dùng cơ bản', 'xem chi tiết tên miền', '2025-08-07 20:00:33', '2025-08-07 20:00:33', '2025-08-07 20:00:33'),
(324, 'người dùng cơ bản', 'xem tên miền', '2025-08-07 20:00:33', '2025-08-07 20:00:33', '2025-08-07 20:00:33'),
(325, 'người dùng cơ bản', 'xem danh sách quyền hạn', '2025-08-07 20:00:33', '2025-08-07 20:00:33', '2025-08-07 20:00:33'),
(326, 'người dùng cơ bản', 'xem chi tiết quyền hạn', '2025-08-07 20:00:34', '2025-08-07 20:00:34', '2025-08-07 20:00:34'),
(327, 'người dùng cơ bản', 'xem quyền hạn', '2025-08-07 20:00:34', '2025-08-07 20:00:34', '2025-08-07 20:00:34'),
(328, 'người dùng cơ bản', 'xem danh mục', '2025-08-07 20:00:34', '2025-08-07 20:00:34', '2025-08-07 20:00:34'),
(329, 'người dùng cơ bản', 'xem danh sách danh mục', '2025-08-07 20:00:34', '2025-08-07 20:00:34', '2025-08-07 20:00:34'),
(330, 'người dùng cơ bản', 'xem chi tiết danh mục', '2025-08-07 20:00:34', '2025-08-07 20:00:34', '2025-08-07 20:00:34'),
(331, 'quản lý phần mềm', 'xem danh sách pháp lý', '2025-08-07 20:01:38', '2025-08-07 20:01:38', '2025-08-07 20:01:38'),
(332, 'quản lý phần mềm', 'xem danh mục', '2025-08-07 20:02:24', '2025-08-07 20:02:24', '2025-08-07 20:02:24'),
(333, 'quản lý phần mềm', 'xem danh sách danh mục', '2025-08-07 20:02:24', '2025-08-07 20:02:24', '2025-08-07 20:02:24'),
(334, 'quản lý phần mềm', 'xem chi tiết danh mục', '2025-08-07 20:02:25', '2025-08-07 20:02:25', '2025-08-07 20:02:25'),
(335, 'admin', 'xem chi tiết quyền người dùng', '2025-08-07 20:04:57', '2025-08-07 20:04:57', '2025-08-07 20:04:57'),
(336, 'admin', 'xem quyền người dùng', '2025-08-07 20:04:57', '2025-08-07 20:04:57', '2025-08-07 20:04:57'),
(337, 'admin', 'thêm quyền hệ thống', '2025-08-07 20:05:06', '2025-08-07 20:05:06', '2025-08-07 20:05:06'),
(338, 'admin', 'sửa quyền hệ thống', '2025-08-07 20:05:07', '2025-08-07 20:05:07', '2025-08-07 20:05:07'),
(339, 'admin', 'xoá quyền hệ thống', '2025-08-07 20:05:07', '2025-08-07 20:05:07', '2025-08-07 20:05:07'),
(340, 'admin', 'xem quyền hệ thống', '2025-08-07 20:05:07', '2025-08-07 20:05:07', '2025-08-07 20:05:07'),
(341, 'admin', 'xem danh sách quyền hệ thống', '2025-08-07 20:05:07', '2025-08-07 20:05:07', '2025-08-07 20:05:07'),
(342, 'admin', 'xem chi tiết quyền hệ thống', '2025-08-07 20:05:08', '2025-08-07 20:05:08', '2025-08-07 20:05:08'),
(355, 'admin', 'thêm người dùng', '2025-08-07 20:11:20', '2025-08-07 20:11:20', '2025-08-07 20:11:20'),
(356, 'admin', 'sửa người dùng', '2025-08-07 20:11:20', '2025-08-07 20:11:20', '2025-08-07 20:11:20'),
(357, 'admin', 'xoá người dùng', '2025-08-07 20:11:21', '2025-08-07 20:11:21', '2025-08-07 20:11:21'),
(358, 'admin', 'xem người dùng', '2025-08-07 20:11:21', '2025-08-07 20:11:21', '2025-08-07 20:11:21'),
(359, 'admin', 'xem danh sách người dùng', '2025-08-07 20:11:21', '2025-08-07 20:11:21', '2025-08-07 20:11:21'),
(360, 'admin', 'xem chi tiết người dùng', '2025-08-07 20:11:21', '2025-08-07 20:11:21', '2025-08-07 20:11:21'),
(361, 'quản lý hệ thống', 'xem danh sách người dùng', '2025-08-07 21:47:48', '2025-08-07 21:47:48', '2025-08-07 21:47:48'),
(362, 'quản lý hệ thống', 'xem chi tiết người dùng', '2025-08-07 21:47:48', '2025-08-07 21:47:48', '2025-08-07 21:47:48'),
(363, 'quản lý hệ thống', 'xem người dùng', '2025-08-07 21:47:48', '2025-08-07 21:47:48', '2025-08-07 21:47:48'),
(364, 'quản lý hệ thống', 'xem chi tiết quyền hạn', '2025-08-07 21:47:48', '2025-08-07 21:47:48', '2025-08-07 21:47:48'),
(365, 'quản lý hệ thống', 'xem quyền hạn', '2025-08-07 21:47:48', '2025-08-07 21:47:48', '2025-08-07 21:47:48'),
(366, 'quản lý hệ thống', 'xem danh sách quyền hạn', '2025-08-07 21:47:49', '2025-08-07 21:47:49', '2025-08-07 21:47:49'),
(367, 'quản lý hệ thống', 'xem quyền người dùng', '2025-08-07 21:47:49', '2025-08-07 21:47:49', '2025-08-07 21:47:49'),
(368, 'quản lý hệ thống', 'xem danh sách quyền người dùng', '2025-08-07 21:47:49', '2025-08-07 21:47:49', '2025-08-07 21:47:49'),
(369, 'quản lý hệ thống', 'xem chi tiết quyền người dùng', '2025-08-07 21:47:49', '2025-08-07 21:47:49', '2025-08-07 21:47:49'),
(370, 'quản lý hệ thống', 'xoá quyền người dùng', '2025-08-07 21:47:49', '2025-08-07 21:47:49', '2025-08-07 21:47:49'),
(371, 'quản lý hệ thống', 'sửa quyền người dùng', '2025-08-07 21:47:50', '2025-08-07 21:47:50', '2025-08-07 21:47:50'),
(372, 'quản lý hệ thống', 'thêm quyền người dùng', '2025-08-07 21:47:50', '2025-08-07 21:47:50', '2025-08-07 21:47:50'),
(373, 'quản lý hệ thống', 'xem chi tiết vai trò', '2025-08-07 21:50:06', '2025-08-07 21:50:06', '2025-08-07 21:50:06'),
(374, 'quản lý hệ thống', 'xem danh sách vai trò', '2025-08-07 21:50:07', '2025-08-07 21:50:07', '2025-08-07 21:50:07'),
(375, 'quản lý hệ thống', 'xem vai trò', '2025-08-07 21:50:07', '2025-08-07 21:50:07', '2025-08-07 21:50:07'),
(378, 'quản lý hệ thống', 'thêm người dùng', '2025-08-07 21:50:40', '2025-08-07 21:50:40', '2025-08-07 21:50:40'),
(381, 'người dùng cơ bản', 'xem danh sách người dùng', '2025-08-14 21:19:51', '2025-08-14 21:19:51', '2025-08-14 21:19:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `route_permission`
--

CREATE TABLE `route_permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `permissions_name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `route_permission`
--

INSERT INTO `route_permission` (`id`, `route_name`, `permissions_name`, `created_at`, `updated_at`) VALUES
(24, 'permission.create', 'thêm quyền hạn', '2025-06-05 04:05:10', '2025-06-05 04:05:10'),
(27, 'permission.list', 'xem danh sách quyền hạn', '2025-06-05 04:05:30', '2025-06-05 04:05:30'),
(33, 'role.list', 'xem danh sách vai trò', '2025-06-01 22:22:24', '2025-06-01 22:22:24'),
(36, 'user.list', 'xem danh sách người dùng', '2025-06-18 11:59:24', '2025-06-18 11:59:24'),
(43, 'role.create', 'thêm vai trò', '2025-06-18 13:57:59', '2025-06-18 13:57:59'),
(44, 'userrole.create', 'thêm quyền người dùng', '2025-06-18 21:25:25', '2025-06-18 21:25:25'),
(45, 'user.edit', 'sửa người dùng', '2025-06-24 12:09:16', '2025-06-24 12:09:16'),
(46, 'permission.edit', 'sửa quyền hạn', '2025-06-24 12:09:39', '2025-06-24 12:09:39'),
(47, 'role.edit', 'sửa vai trò', '2025-06-24 12:10:01', '2025-06-24 12:10:01'),
(48, 'userrole.list', 'xem danh sách quyền người dùng', '2025-06-24 12:11:01', '2025-06-24 12:11:01'),
(49, 'userrole.edit', 'sửa quyền người dùng', '2025-06-24 12:11:12', '2025-06-24 12:11:12'),
(50, 'hardware.create', 'thêm phần cứng', '2025-06-24 12:15:11', '2025-06-24 12:15:11'),
(51, 'hardware.edit', 'sửa phần cứng', '2025-06-24 12:15:15', '2025-06-24 12:15:15'),
(52, 'hardware.delete', 'xoá phần cứng', '2025-06-24 12:15:20', '2025-06-24 12:15:20'),
(53, 'hardware.list', 'xem danh sách phần cứng', '2025-06-24 12:15:22', '2025-06-24 12:15:22'),
(54, 'hardware.detail', 'xem chi tiết phần cứng', '2025-06-24 12:15:28', '2025-06-24 12:15:28'),
(55, 'software.create', 'thêm phần mềm', '2025-06-25 10:11:35', '2025-06-25 10:11:35'),
(57, 'software.delete', 'xoá phần mềm', '2025-06-25 10:11:42', '2025-06-25 10:11:42'),
(58, 'software.list', 'xem danh sách phần mềm', '2025-06-25 10:11:46', '2025-06-25 10:11:46'),
(59, 'software.detail', 'xem chi tiết phần mềm', '2025-06-25 10:11:49', '2025-06-25 10:11:49'),
(61, 'user.create', 'thêm người dùng', '2025-06-25 10:14:03', '2025-06-25 10:14:03'),
(62, 'user.delete', 'xoá người dùng', '2025-06-25 10:14:07', '2025-06-25 10:14:07'),
(63, 'user.detail', 'xem chi tiết người dùng', '2025-06-25 10:14:09', '2025-06-25 10:14:09'),
(66, 'hardware.get', 'xem phần cứng', '2025-06-18 13:58:17', '2025-06-18 13:58:17'),
(67, 'permission.delete', 'xoá quyền hạn', '2025-06-25 17:03:24', '2025-06-25 17:03:24'),
(68, 'role.delete', 'xoá vai trò', '2025-06-25 17:03:37', '2025-06-25 17:03:37'),
(69, 'systempermission.create', 'thêm quyền hệ thống', '2025-06-25 17:04:34', '2025-06-25 17:04:34'),
(70, 'systempermission.edit', 'sửa quyền hệ thống', '2025-06-25 17:04:41', '2025-06-25 17:04:41'),
(71, 'userrole.delete', 'xoá quyền người dùng', '2025-06-25 17:04:47', '2025-06-25 17:04:47'),
(72, 'role.detail', 'xem chi tiết vai trò', '2025-06-25 17:10:08', '2025-06-25 17:10:08'),
(73, 'domain.create', 'thêm tên miền', '2025-06-25 20:14:39', '2025-06-25 20:14:39'),
(74, 'domain.edit', 'sửa tên miền', '2025-06-25 20:14:47', '2025-06-25 20:14:47'),
(75, 'domain.delete', 'xoá tên miền', '2025-06-25 20:14:55', '2025-06-25 20:14:55'),
(76, 'domain.list', 'xem danh sách tên miền', '2025-06-25 20:15:02', '2025-06-25 20:15:02'),
(77, 'domain.detail', 'xem chi tiết tên miền', '2025-06-25 20:16:54', '2025-06-25 20:16:54'),
(79, 'legal.delete', 'xoá pháp lý', '2025-06-25 20:18:00', '2025-06-25 20:18:00'),
(80, 'legal.list', 'xem danh sách pháp lý', '2025-06-25 20:18:19', '2025-06-25 20:18:19'),
(81, 'hardwaredomain.create', 'thêm phần cứng vào domain', '2025-06-25 21:26:54', '2025-06-25 21:26:54'),
(82, 'hardwaredomain.edit', 'sửa phần cứng vào domain', '2025-06-25 21:26:58', '2025-06-25 21:26:58'),
(83, 'hardwaredomain.delete', 'xoá phần cứng vào domain', '2025-06-25 21:27:00', '2025-06-25 21:27:00'),
(84, 'hardwaredomain.list', 'xem danh sách phần cứng vào domain', '2025-06-25 21:27:02', '2025-06-25 21:27:02'),
(85, 'hardwaredomain.detail', 'xem chi tiết phần cứng vào domain', '2025-06-25 21:27:05', '2025-06-25 21:27:05'),
(87, 'software.edit', 'sửa phần mềm', '2025-07-02 19:43:53', '2025-07-02 19:43:53'),
(88, 'software.get', 'xem phần mềm', '2025-07-02 21:09:22', '2025-07-02 21:09:22'),
(89, 'user.get', 'xem người dùng', '2025-07-02 21:13:12', '2025-07-02 21:13:12'),
(90, 'hardwarepermission.list', 'xem danh sách người dùng quản lý phần cứng', '2025-07-03 02:20:12', '2025-07-03 02:20:12'),
(91, 'hardwarepermission.get', 'xem người dùng quản lý phần cứng', '2025-07-03 02:20:28', '2025-07-03 02:20:28'),
(92, 'hardwarepermission.delete', 'xoá người dùng quản lý phần cứng', '2025-07-03 02:20:31', '2025-07-03 02:20:31'),
(93, 'hardwarepermission.edit', 'sửa người dùng quản lý phần cứng', '2025-07-03 02:20:35', '2025-07-03 02:20:35'),
(94, 'hardwarepermission.create', 'thêm người dùng quản lý phần cứng', '2025-07-03 02:20:38', '2025-07-03 02:20:38'),
(95, 'hardwarepermission.detail', 'xem chi tiết người dùng quản lý phần cứng', '2025-07-03 02:20:40', '2025-07-03 02:20:40'),
(96, 'softwarepermission.create', 'thêm người dùng quản lý phần mềm', '2025-07-03 04:46:53', '2025-07-03 04:46:53'),
(97, 'softwarepermission.edit', 'sửa người dùng quản lý phần mềm', '2025-07-03 04:46:57', '2025-07-03 04:46:57'),
(98, 'softwarepermission.delete', 'xoá người dùng quản lý phần mềm', '2025-07-03 04:46:59', '2025-07-03 04:46:59'),
(99, 'softwarepermission.get', 'xem người dùng quản lý phần mềm', '2025-07-03 04:47:01', '2025-07-03 04:47:01'),
(100, 'softwarepermission.list', 'xem danh sách người dùng quản lý phần mềm', '2025-07-03 04:47:03', '2025-07-03 04:47:03'),
(101, 'softwarepermission.detail', 'xem chi tiết người dùng quản lý phần mềm', '2025-07-03 04:47:06', '2025-07-03 04:47:06'),
(102, 'role.get', 'xem vai trò', '2025-07-03 04:51:59', '2025-07-03 04:51:59'),
(103, 'permission.get', 'xem quyền hạn', '2025-07-03 04:52:17', '2025-07-03 04:52:17'),
(104, 'permission.detail', 'xem chi tiết quyền hạn', '2025-07-03 04:52:18', '2025-07-03 04:52:18'),
(105, 'domain.get', 'xem tên miền', '2025-07-03 12:29:16', '2025-07-03 12:29:16'),
(106, 'softwarefile.create', 'thêm tệp tin phần mềm', '2025-07-10 05:37:32', '2025-07-10 05:37:32'),
(107, 'softwarefile.edit', 'sửa tệp tin phần mềm', '2025-07-10 05:37:37', '2025-07-10 05:37:37'),
(108, 'softwarefile.delete', 'xoá tệp tin phần mềm', '2025-07-10 05:37:41', '2025-07-10 05:37:41'),
(109, 'softwarefile.get', 'xem tệp tin phần mềm', '2025-07-10 05:37:45', '2025-07-10 05:37:45'),
(110, 'softwarefile.list', 'xem danh sách tệp tin phần mềm', '2025-07-10 05:37:48', '2025-07-10 05:37:48'),
(111, 'softwarefile.detail', 'xem chi tiết tệp tin phần mềm', '2025-07-10 05:37:50', '2025-07-10 05:37:50'),
(112, 'system.create', 'thêm hệ thống', '2025-07-10 07:57:20', '2025-07-10 07:57:20'),
(113, 'system.edit', 'sửa hệ thống', '2025-07-10 07:57:24', '2025-07-10 07:57:24'),
(114, 'system.delete', 'xoá hệ thống', '2025-07-10 07:57:26', '2025-07-10 07:57:26'),
(115, 'system.get', 'xem hệ thống', '2025-07-10 07:57:28', '2025-07-10 07:57:28'),
(116, 'system.list', 'xem danh sách hệ thống', '2025-07-10 07:57:30', '2025-07-10 07:57:30'),
(117, 'system.detail', 'xem chi tiết hệ thống', '2025-07-10 07:57:33', '2025-07-10 07:57:33'),
(118, 'hardwaredomain.get', 'xem phần cứng vào domain', '2025-07-10 11:58:23', '2025-07-10 11:58:23'),
(119, 'legal.create', 'thêm pháp lý', '2025-07-17 05:18:42', '2025-07-17 05:18:42'),
(120, 'legal.edit', 'sửa pháp lý', '2025-07-17 05:18:45', '2025-07-17 05:18:45'),
(121, 'legal.get', 'xem pháp lý', '2025-07-17 05:18:47', '2025-07-17 05:18:47'),
(122, 'legal.detail', 'xem chi tiết pháp lý', '2025-07-17 05:18:50', '2025-07-17 05:18:50'),
(123, 'systempermission.delete', 'xoá quyền hệ thống', '2025-07-31 14:16:53', '2025-07-31 14:16:53'),
(124, 'category.create', 'thêm danh mục', '2025-07-31 14:16:58', '2025-07-31 14:16:58'),
(125, 'category.edit', 'sửa danh mục', '2025-07-31 14:16:59', '2025-07-31 14:16:59'),
(126, 'category.delete', 'xoá danh mục', '2025-07-31 14:17:00', '2025-07-31 14:17:00'),
(127, 'category.get', 'xem danh mục', '2025-07-31 14:17:01', '2025-07-31 14:17:01'),
(128, 'category.list', 'xem danh sách danh mục', '2025-07-31 14:17:01', '2025-07-31 14:17:01'),
(129, 'category.detail', 'xem chi tiết danh mục', '2025-07-31 14:17:02', '2025-07-31 14:17:02'),
(130, 'systempermission.get', 'xem quyền hệ thống', '2025-07-31 14:17:15', '2025-07-31 14:17:15'),
(131, 'systempermission.detail', 'xem chi tiết quyền hệ thống', '2025-07-31 14:17:16', '2025-07-31 14:17:16'),
(132, 'systempermission.list', 'xem danh sách quyền hệ thống', '2025-07-31 14:17:17', '2025-07-31 14:17:17'),
(133, 'userrole.get', 'xem quyền người dùng', '2025-07-31 14:17:19', '2025-07-31 14:17:19'),
(134, 'userrole.detail', 'xem chi tiết quyền người dùng', '2025-07-31 14:17:20', '2025-07-31 14:17:20'),
(135, 'hardware.manager', 'quản lý phần cứng', NULL, NULL),
(136, 'software.manager', 'quản lý phần mềm', NULL, NULL),
(137, 'user.manager', 'quản lý người dùng', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rules`
--

CREATE TABLE `rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `file_url` varchar(250) NOT NULL,
  `category_rule_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `date_release` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `software`
--

CREATE TABLE `software` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `softwareName` varchar(100) NOT NULL,
  `language` varchar(15) NOT NULL,
  `version` varchar(100) NOT NULL,
  `user_createby` varchar(100) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `software_file`
--

CREATE TABLE `software_file` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `software_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `software_permissions`
--

CREATE TABLE `software_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `create_by` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `permissions_name` varchar(100) NOT NULL,
  `software_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `software_rule`
--

CREATE TABLE `software_rule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rule_id` bigint(20) UNSIGNED NOT NULL,
  `software_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `systemproject`
--

CREATE TABLE `systemproject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `foodter` varchar(255) DEFAULT NULL,
  `namesystem` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `systemproject`
--

INSERT INTO `systemproject` (`id`, `avatar`, `foodter`, `namesystem`, `created_at`, `updated_at`) VALUES
(1, NULL, '\"name_company\": \"tập đoàn A\", \"name_system\": \"Hệ thống quản lý phần cứng và phần mềm\", \"phone\": \"0123456789\"', NULL, '2025-07-31 20:49:32', '2025-08-08 00:47:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `fullName` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(12) DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `department` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`username`, `password`, `fullName`, `email`, `phone_number`, `hidden`, `is_delete`, `department`, `created_at`, `updated_at`) VALUES
('nemoadmin', '$2y$12$K/5nix96QGwoKF0VougvHuInDBDudz/ADB2IomxeaZh6Z3TG0q426', 'nemoadmin', 'nemoadmin@gmail.com', NULL, 0, 0, NULL, '2025-06-04 05:51:58', '2025-06-04 05:51:58'),
('nemosystem', '$2y$12$kqXMqqv4LWp9Y7iVp5cpA.yVt2bNjarBCCHgUGN/7TPBbRdnhVpiq', 'nemosystem', 'nemosystem@gmail.com', NULL, 0, 0, NULL, '2025-06-04 05:52:25', '2025-06-04 05:52:25'),
('ono', '$2y$12$XkjbrIXVT.EmKjDCCbuJE.UAuZ1Z1Ka72ppjE03z8oYhrseaM7oWO', 'onoono', 'lephuc0167282223@gmail.com', NULL, 0, 0, NULL, '2025-06-01 20:10:11', '2025-07-24 15:09:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_role`
--

CREATE TABLE `user_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_role`
--

INSERT INTO `user_role` (`id`, `username`, `role_name`, `assigned_at`, `created_at`, `updated_at`) VALUES
(1, 'ono', 'admin', '2025-06-24 19:07:00', '2025-06-24 12:15:48', '2025-06-24 12:15:48'),
(2, 'ono', 'quản lý phần cứng', '2025-06-24 12:15:48', '2025-06-24 12:15:48', '2025-06-24 12:15:48'),
(6, 'nemosystem', 'quản lý phần cứng', '2025-06-25 17:03:51', '2025-06-25 17:03:51', '2025-06-25 17:03:51'),
(7, 'nemosystem', 'quản lý phần mềm', '2025-06-25 17:03:52', '2025-06-25 17:03:52', '2025-06-25 17:03:52'),
(8, 'nemosystem', 'quản lý phần mềm', '2025-06-25 17:03:54', '2025-06-25 17:03:54', '2025-06-25 17:03:54'),
(9, 'nemosystem', 'quản lý phần cứng', '2025-06-25 17:03:57', '2025-06-25 17:03:57', '2025-06-25 17:03:57'),
(10, 'nemosystem', 'quản lý phần mềm', '2025-06-25 17:03:58', '2025-06-25 17:03:58', '2025-06-25 17:03:58'),
(22, 'ono', 'quản lý phần mềm', '2025-07-10 11:44:58', '2025-07-10 11:44:58', '2025-07-10 11:44:58'),
(33, 'ono', 'người dùng cơ bản', '2025-07-31 23:13:39', '2025-07-31 23:13:39', '2025-07-31 23:13:39'),
(37, 'ono', 'quản lý hệ thống', '2025-08-07 19:53:57', '2025-08-07 19:53:57', '2025-08-07 19:53:57');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `category_rule`
--
ALTER TABLE `category_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_rule_name_unique` (`name`);

--
-- Chỉ mục cho bảng `database`
--
ALTER TABLE `database`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `database_dbname_unique` (`dbname`),
  ADD KEY `database_created_by_foreign` (`created_by`);

--
-- Chỉ mục cho bảng `database_version`
--
ALTER TABLE `database_version`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `database_version_unique` (`dbname`,`version`),
  ADD KEY `database_version_created_by_foreign` (`created_by`),
  ADD KEY `database_version_version_index` (`version`);

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`),
  ADD KEY `departments_created_by_foreign` (`created_by`);

--
-- Chỉ mục cho bảng `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domain_link_unique` (`link`),
  ADD KEY `domain_software_id_foreign` (`software_id`),
  ADD KEY `domain_createby_foreign` (`createBy`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `hardware`
--
ALTER TABLE `hardware`
  ADD PRIMARY KEY (`ip`),
  ADD KEY `hardware_created_by_foreign` (`created_by`),
  ADD KEY `hardware_dbname_dbversion_foreign` (`dbname`,`dbversion`),
  ADD KEY `hardware_os_osver_foreign` (`OS`,`OSver`);

--
-- Chỉ mục cho bảng `hardware_access_domain`
--
ALTER TABLE `hardware_access_domain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hardware_access_domain_hardware_ip_foreign` (`hardware_ip`);

--
-- Chỉ mục cho bảng `hardware_permissions`
--
ALTER TABLE `hardware_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hardware_permissions_hardware_ip_foreign` (`hardware_ip`),
  ADD KEY `hardware_permissions_permissions_name_foreign` (`permissions_name`),
  ADD KEY `hardware_permissions_user_name_foreign` (`user_name`),
  ADD KEY `hardware_permissions_user_createby_foreign` (`user_createby`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_software_id_foreign` (`software_id`),
  ADD KEY `log_hardware_ip_foreign` (`hardware_ip`),
  ADD KEY `log_username_foreign` (`username`),
  ADD KEY `log_rule_id_foreign` (`rule_id`),
  ADD KEY `log_software_file_id_foreign` (`software_file_id`),
  ADD KEY `log_sw_permission_user_foreign` (`sw_permission_user`),
  ADD KEY `log_hw_permission_user_foreign` (`hw_permission_user`),
  ADD KEY `log_permission_name_foreign` (`permission_name`),
  ADD KEY `log_role_id_foreign` (`role_id`),
  ADD KEY `log_department_foreign` (`department`),
  ADD KEY `log_link_domain_foreign` (`link_domain`),
  ADD KEY `log_category_rule_foreign` (`category_rule`),
  ADD KEY `log_database_name_foreign` (`database_name`),
  ADD KEY `log_os_name_foreign` (`os_name`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `os`
--
ALTER TABLE `os`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `os_name_unique` (`name`),
  ADD KEY `os_created_by_foreign` (`created_by`),
  ADD KEY `os_updated_by_foreign` (`updated_by`),
  ADD KEY `os_deleted_by_foreign` (`deleted_by`);

--
-- Chỉ mục cho bảng `os_version`
--
ALTER TABLE `os_version`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `os_version_unique` (`os_name`,`version`),
  ADD KEY `_o_s_version_created_by_foreign` (`created_by`);

--
-- Chỉ mục cho bảng `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_reset_email_index` (`email`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permissions_name`),
  ADD KEY `permissions_user_creately_foreign` (`user_creately`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_name_unique` (`role_name`);

--
-- Chỉ mục cho bảng `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permissions_role_name_foreign` (`role_name`),
  ADD KEY `role_permissions_permission_name_foreign` (`permission_name`);

--
-- Chỉ mục cho bảng `route_permission`
--
ALTER TABLE `route_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_permission_permissions_name_foreign` (`permissions_name`);

--
-- Chỉ mục cho bảng `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rules_category_id_foreign` (`category_rule_id`),
  ADD KEY `rules_username_foreign` (`username`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id`),
  ADD KEY `software_user_createby_foreign` (`user_createby`);

--
-- Chỉ mục cho bảng `software_file`
--
ALTER TABLE `software_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `software_file_username_foreign` (`username`),
  ADD KEY `software_file_software_id_foreign` (`software_id`);

--
-- Chỉ mục cho bảng `software_permissions`
--
ALTER TABLE `software_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `software_permissions_create_by_foreign` (`create_by`),
  ADD KEY `software_permissions_user_name_foreign` (`user_name`),
  ADD KEY `software_permissions_software_id_foreign` (`software_id`);

--
-- Chỉ mục cho bảng `software_rule`
--
ALTER TABLE `software_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `software_rule_software_id_foreign` (`software_id`),
  ADD KEY `software_rule_rule_id_foreign` (`rule_id`);

--
-- Chỉ mục cho bảng `systemproject`
--
ALTER TABLE `systemproject`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_department_foreign` (`department`);

--
-- Chỉ mục cho bảng `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role_username_foreign` (`username`),
  ADD KEY `user_role_role_name_foreign` (`role_name`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category_rule`
--
ALTER TABLE `category_rule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `database`
--
ALTER TABLE `database`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `database_version`
--
ALTER TABLE `database_version`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `domain`
--
ALTER TABLE `domain`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hardware_access_domain`
--
ALTER TABLE `hardware_access_domain`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `hardware_permissions`
--
ALTER TABLE `hardware_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2118;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `os`
--
ALTER TABLE `os`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `os_version`
--
ALTER TABLE `os_version`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

--
-- AUTO_INCREMENT cho bảng `route_permission`
--
ALTER TABLE `route_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT cho bảng `rules`
--
ALTER TABLE `rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `software`
--
ALTER TABLE `software`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `software_file`
--
ALTER TABLE `software_file`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `software_permissions`
--
ALTER TABLE `software_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT cho bảng `software_rule`
--
ALTER TABLE `software_rule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `systemproject`
--
ALTER TABLE `systemproject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `database`
--
ALTER TABLE `database`
  ADD CONSTRAINT `database_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `database_version`
--
ALTER TABLE `database_version`
  ADD CONSTRAINT `database_version_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `database_version_dbname_foreign` FOREIGN KEY (`dbname`) REFERENCES `database` (`dbname`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `domain`
--
ALTER TABLE `domain`
  ADD CONSTRAINT `domain_createby_foreign` FOREIGN KEY (`createBy`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `domain_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hardware`
--
ALTER TABLE `hardware`
  ADD CONSTRAINT `hardware_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hardware_dbname_dbversion_foreign` FOREIGN KEY (`dbname`,`dbversion`) REFERENCES `database_version` (`dbname`, `version`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hardware_dbname_foreign` FOREIGN KEY (`dbname`) REFERENCES `database` (`dbname`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hardware_os_foreign` FOREIGN KEY (`OS`) REFERENCES `os` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hardware_os_osver_foreign` FOREIGN KEY (`OS`,`OSver`) REFERENCES `os_version` (`os_name`, `version`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hardware_access_domain`
--
ALTER TABLE `hardware_access_domain`
  ADD CONSTRAINT `hardware_access_domain_hardware_ip_foreign` FOREIGN KEY (`hardware_ip`) REFERENCES `hardware` (`ip`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hardware_permissions`
--
ALTER TABLE `hardware_permissions`
  ADD CONSTRAINT `hardware_permissions_hardware_ip_foreign` FOREIGN KEY (`hardware_ip`) REFERENCES `hardware` (`ip`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hardware_permissions_permissions_name_foreign` FOREIGN KEY (`permissions_name`) REFERENCES `permissions` (`permissions_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hardware_permissions_user_createby_foreign` FOREIGN KEY (`user_createby`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hardware_permissions_user_name_foreign` FOREIGN KEY (`user_name`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_category_rule_foreign` FOREIGN KEY (`category_rule`) REFERENCES `category_rule` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_database_name_foreign` FOREIGN KEY (`database_name`) REFERENCES `database` (`dbname`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_department_foreign` FOREIGN KEY (`department`) REFERENCES `departments` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_hardware_ip_foreign` FOREIGN KEY (`hardware_ip`) REFERENCES `hardware` (`ip`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_hw_permission_user_foreign` FOREIGN KEY (`hw_permission_user`) REFERENCES `hardware_permissions` (`user_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_link_domain_foreign` FOREIGN KEY (`link_domain`) REFERENCES `domain` (`link`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_os_name_foreign` FOREIGN KEY (`os_name`) REFERENCES `os` (`name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_permission_name_foreign` FOREIGN KEY (`permission_name`) REFERENCES `permissions` (`permissions_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `rules` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_software_file_id_foreign` FOREIGN KEY (`software_file_id`) REFERENCES `software_file` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_sw_permission_user_foreign` FOREIGN KEY (`sw_permission_user`) REFERENCES `software_permissions` (`user_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_username_foreign` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `os`
--
ALTER TABLE `os`
  ADD CONSTRAINT `os_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `os_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `os_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `os_version`
--
ALTER TABLE `os_version`
  ADD CONSTRAINT `_o_s_version_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `_o_s_version_os_name_foreign` FOREIGN KEY (`os_name`) REFERENCES `os` (`name`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_email_foreign` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_user_creately_foreign` FOREIGN KEY (`user_creately`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_name_foreign` FOREIGN KEY (`permission_name`) REFERENCES `permissions` (`permissions_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_role_name_foreign` FOREIGN KEY (`role_name`) REFERENCES `roles` (`role_name`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `route_permission`
--
ALTER TABLE `route_permission`
  ADD CONSTRAINT `route_permission_permissions_name_foreign` FOREIGN KEY (`permissions_name`) REFERENCES `permissions` (`permissions_name`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `rules`
--
ALTER TABLE `rules`
  ADD CONSTRAINT `rules_category_id_foreign` FOREIGN KEY (`category_rule_id`) REFERENCES `category_rule` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rules_username_foreign` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `software`
--
ALTER TABLE `software`
  ADD CONSTRAINT `software_user_createby_foreign` FOREIGN KEY (`user_createby`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `software_file`
--
ALTER TABLE `software_file`
  ADD CONSTRAINT `software_file_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `software_file_username_foreign` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `software_permissions`
--
ALTER TABLE `software_permissions`
  ADD CONSTRAINT `software_permissions_create_by_foreign` FOREIGN KEY (`create_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `software_permissions_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `software_permissions_user_name_foreign` FOREIGN KEY (`user_name`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `software_rule`
--
ALTER TABLE `software_rule`
  ADD CONSTRAINT `software_rule_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `rules` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `software_rule_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_foreign` FOREIGN KEY (`department`) REFERENCES `departments` (`name`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_role_name_foreign` FOREIGN KEY (`role_name`) REFERENCES `roles` (`role_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_username_foreign` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
