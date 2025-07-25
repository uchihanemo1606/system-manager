-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 03, 2025 lúc 01:43 PM
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
-- Cơ sở dữ liệu: `systemmanager`
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

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_kRtb9geMNMl3XicQ', 'a:1:{s:11:\"valid_until\";i:1751534272;}', 1752743332),
('laravel_cache_permission_name_for_hardware.edit', 's:19:\"sửa phần cứng\";', 1751545112),
('laravel_cache_permission_name_for_software.edit', 's:18:\"sửa phần mềm\";', 1751546525),
('laravel_cache_route_override_permission_domain.create', 's:17:\"thêm tên miền\";', 1751546103),
('laravel_cache_route_override_permission_domain.edit', 's:17:\"sửa tên miền\";', 1751546216),
('laravel_cache_route_override_permission_domain.list', 's:26:\"xem danh sách tên miền\";', 1751545088),
('laravel_cache_route_override_permission_hardware.create', 's:19:\"thêm phần cứng\";', 1751541762),
('laravel_cache_route_override_permission_hardware.edit', 's:19:\"sửa phần cứng\";', 1751545112),
('laravel_cache_route_override_permission_hardware.list', 's:28:\"xem danh sách phần cứng\";', 1751544818),
('laravel_cache_route_override_permission_hardwaredomain.create', 's:31:\"thêm phần cứng vào domain\";', 1751546126),
('laravel_cache_route_override_permission_hardwaredomain.list', 's:40:\"xem danh sách phần cứng vào domain\";', 1751546116),
('laravel_cache_route_override_permission_permission.create', 's:19:\"thêm quyền hạn\";', 1751544099),
('laravel_cache_route_override_permission_permission.list', 's:28:\"xem danh sách quyền hạn\";', 1751543954),
('laravel_cache_route_override_permission_role.list', 's:23:\"xem danh sách vai trò\";', 1751546048),
('laravel_cache_route_override_permission_software.create', 's:18:\"thêm phần mềm\";', 1751542563),
('laravel_cache_route_override_permission_software.detail', 's:27:\"xem chi tiết phần mềm\";', 1751546083),
('laravel_cache_route_override_permission_software.edit', 's:18:\"sửa phần mềm\";', 1751546525),
('laravel_cache_route_override_permission_software.list', 's:27:\"xem danh sách phần mềm\";', 1751546021),
('laravel_cache_route_override_permission_software.update', 's:18:\"sửa phần mềm\";', 1751538757),
('laravel_cache_route_override_permission_user.list', 's:29:\"xem danh sách người dùng\";', 1751546063),
('laravel_cache_route_override_permission_userrole.create', 's:28:\"thêm quyền người dùng\";', 1751540294),
('laravel_cache_route_override_permission_userrole.list', 's:37:\"xem danh sách quyền người dùng\";', 1751546054),
('laravel_cache_user_permissions_ono', 'a:40:{i:0;s:23:\"xem danh sách vai trò\";i:1;s:19:\"thêm quyền hạn\";i:2;s:28:\"xem danh sách quyền hạn\";i:3;s:14:\"thêm vai trò\";i:4;s:28:\"thêm quyền người dùng\";i:5;s:19:\"sửa quyền hạn\";i:6;s:37:\"xem danh sách quyền người dùng\";i:7;s:28:\"sửa quyền người dùng\";i:8;s:14:\"sửa vai trò\";i:9;s:19:\"thêm phần cứng\";i:10;s:19:\"sửa phần cứng\";i:11;s:18:\"xoá phần cứng\";i:12;s:28:\"xem chi tiết phần cứng\";i:13;s:18:\"thêm phần mềm\";i:14;s:17:\"xoá phần mềm\";i:15;s:27:\"xem danh sách phần mềm\";i:16;s:29:\"xem chi tiết người dùng\";i:17;s:29:\"xem danh sách người dùng\";i:18;s:19:\"xoá người dùng\";i:19;s:20:\"sửa người dùng\";i:20;s:20:\"thêm người dùng\";i:21;s:28:\"xem danh sách phần cứng\";i:22;s:18:\"xoá quyền hạn\";i:23;s:13:\"xoá vai trò\";i:24;s:27:\"xoá quyền người dùng\";i:25;s:23:\"xem chi tiết vai trò\";i:26;s:27:\"xem chi tiết phần mềm\";i:27;s:17:\"thêm tên miền\";i:28;s:17:\"sửa tên miền\";i:29;s:16:\"xoá tên miền\";i:30;s:31:\"thêm phần cứng vào domain\";i:31;s:31:\"sửa phần cứng vào domain\";i:32;s:30:\"xoá phần cứng vào domain\";i:33;s:40:\"xem danh sách phần cứng vào domain\";i:34;s:40:\"xem chi tiết phần cứng vào domain\";i:35;s:26:\"xem chi tiết tên miền\";i:36;s:26:\"xem danh sách tên miền\";i:37;s:18:\"sửa phần mềm\";i:38;s:17:\"xem phần cứng\";i:39;s:16:\"xem phần mềm\";}', 1751546529),
('laravel_cache_user_permissions_ono1', 'a:6:{i:0;s:18:\"thêm phần mềm\";i:1;s:17:\"xoá phần mềm\";i:2;s:27:\"xem danh sách phần mềm\";i:3;s:24:\"tìm kiếm phần mềm\";i:4;s:27:\"xem chi tiết phần mềm\";i:5;s:18:\"sửa phần mềm\";}', 1751541465);

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
  `name` varchar(255) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `domain`
--

INSERT INTO `domain` (`id`, `software_id`, `name`, `link`, `createBy`, `created_at`, `updated_at`, `description`) VALUES
(8, 25, 'ono12345', 'ono.com.vn', 'ono', '2025-07-03 04:35:03', '2025-07-03 04:39:34', NULL),
(9, 25, 'esp', 'esp.com.vb', 'ono', '2025-07-03 04:35:13', '2025-07-03 04:35:13', NULL);

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

--
-- Đang đổ dữ liệu cho bảng `hardware`
--

INSERT INTO `hardware` (`ip`, `dbname`, `dbversion`, `isVirtualServer`, `OS`, `OSver`, `hdd`, `ram`, `is_delete`, `services`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
('192.168.1.1', 'Mysql', '1.0.0', 1, 'WINDOW', '1.0.1', '10 GB', '10 GB', 0, '\"no\"', 1, 'ono', '2025-07-03 03:34:49', '2025-07-03 04:18:32'),
('192.168.1.2', 'Mysql', '1.0.0', 1, 'WINDOW', '1.0.0', '20 GB', '20 GB', 0, '\"o\"', 1, 'ono', '2025-07-03 03:35:07', '2025-07-03 03:35:07'),
('192.168.1.3', 'MongoDb', '1.0.0', 1, 'LUNIX', '1.0.1', '1 GB', '2 GB', 0, '\"o\"', 1, 'ono', '2025-07-03 03:35:32', '2025-07-03 03:35:32');

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

--
-- Đang đổ dữ liệu cho bảng `hardware_access_domain`
--

INSERT INTO `hardware_access_domain` (`id`, `hardware_ip`, `domain_id`, `created_at`, `updated_at`) VALUES
(14, '192.168.1.1', 8, '2025-07-03 04:35:26', '2025-07-03 04:35:26'),
(15, '192.168.1.1', 9, '2025-07-03 04:35:33', '2025-07-03 04:35:33');

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

--
-- Đang đổ dữ liệu cho bảng `hardware_permissions`
--

INSERT INTO `hardware_permissions` (`id`, `hardware_ip`, `permissions_name`, `user_name`, `user_createby`, `assigned_at`, `created_at`, `updated_at`) VALUES
(5, '192.168.1.1', 'xem phần cứng', 'ono', 'ono', '2025-07-03 03:34:49', '2025-07-03 03:34:49', '2025-07-03 03:34:49'),
(6, '192.168.1.1', 'sửa phần cứng', 'ono', 'ono', '2025-07-03 03:34:49', '2025-07-03 03:34:49', '2025-07-03 03:34:49'),
(7, '192.168.1.1', 'xóa phần cứng', 'ono', 'ono', '2025-07-03 03:34:49', '2025-07-03 03:34:49', '2025-07-03 03:34:49'),
(8, '192.168.1.2', 'xem phần cứng', 'ono', 'ono', '2025-07-03 03:35:07', '2025-07-03 03:35:07', '2025-07-03 03:35:07'),
(9, '192.168.1.2', 'sửa phần cứng', 'ono', 'ono', '2025-07-03 03:35:07', '2025-07-03 03:35:07', '2025-07-03 03:35:07'),
(10, '192.168.1.2', 'xóa phần cứng', 'ono', 'ono', '2025-07-03 03:35:07', '2025-07-03 03:35:07', '2025-07-03 03:35:07'),
(11, '192.168.1.3', 'xem phần cứng', 'ono', 'ono', '2025-07-03 03:35:32', '2025-07-03 03:35:32', '2025-07-03 03:35:32'),
(12, '192.168.1.3', 'sửa phần cứng', 'ono', 'ono', '2025-07-03 03:35:32', '2025-07-03 03:35:32', '2025-07-03 03:35:32'),
(13, '192.168.1.3', 'xóa phần cứng', 'ono', 'ono', '2025-07-03 03:35:32', '2025-07-03 03:35:32', '2025-07-03 03:35:32');

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
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `log`
--

INSERT INTO `log` (`id`, `username`, `software_id`, `hardware_ip`, `rule_id`, `message`, `software_file_id`, `link_domain`, `sw_permission_user`, `hw_permission_user`, `permission_name`, `role_id`, `is_delete`, `created_at`, `updated_at`) VALUES
(86, 'ono', NULL, '192.168.1.1', NULL, 'User lehoangphucs Created new hardware with IP 192.168.1.1', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 03:34:49', '2025-07-03 03:34:49'),
(87, 'ono', NULL, '192.168.1.2', NULL, 'User lehoangphucs Created new hardware with IP 192.168.1.2', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 03:35:07', '2025-07-03 03:35:07'),
(88, 'ono', NULL, '192.168.1.3', NULL, 'User lehoangphucs Created new hardware with IP 192.168.1.3', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 03:35:32', '2025-07-03 03:35:32'),
(91, 'ono', NULL, NULL, NULL, 'User lehoangphucs created role permission \'quản lý phần cứng\' with permission \'xem phần cứng\'.', NULL, NULL, NULL, NULL, 'xem phần cứng', NULL, 0, '2025-07-03 04:08:34', '2025-07-03 04:08:34'),
(92, 'ono', NULL, NULL, NULL, 'user lehoangphucs has been create new permission: \' . xem phần mềm', NULL, NULL, NULL, NULL, 'xem phần mềm', NULL, 0, '2025-07-03 04:09:22', '2025-07-03 04:09:22'),
(93, 'ono', NULL, NULL, NULL, 'User lehoangphucs created role permission \'quản lý phần mềm\' with permission \'xem phần mềm\'.', NULL, NULL, NULL, NULL, 'xem phần mềm', NULL, 0, '2025-07-03 04:09:28', '2025-07-03 04:09:28'),
(94, 'ono', NULL, NULL, NULL, 'user lehoangphucs has been create new permission: \' . xem người dùng', NULL, NULL, NULL, NULL, 'xem người dùng', NULL, 0, '2025-07-03 04:13:12', '2025-07-03 04:13:12'),
(95, 'ono', NULL, NULL, NULL, 'User lehoangphucs deleted role permission \'admin\' with permission \'thêm người dùng\'.', NULL, NULL, NULL, NULL, 'thêm người dùng', NULL, 0, '2025-07-03 04:13:28', '2025-07-03 04:13:28'),
(102, 'ono', 25, NULL, NULL, ' user lehoangphucs created software \'công cụ A1\'.', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:17:24', '2025-07-03 04:17:24'),
(103, 'ono', 26, NULL, NULL, ' user lehoangphucs created software \'công cụ A2\'.', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:17:30', '2025-07-03 04:17:30'),
(104, 'ono', 27, NULL, NULL, ' user lehoangphucs created software \'công cụ A3\'.', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:17:38', '2025-07-03 04:17:38'),
(105, 'ono', 28, NULL, NULL, ' user lehoangphucs created software \'công cụ A122\'.', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:17:44', '2025-07-03 04:17:44'),
(106, 'ono', 29, NULL, NULL, ' user lehoangphucs created software \'hệ hỗ trợ ứng dụng\'.', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:17:55', '2025-07-03 04:17:55'),
(107, 'ono', NULL, NULL, NULL, 'lehoangphucs đã đăng nhập vào hệ thống.', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:18:22', '2025-07-03 04:18:22'),
(108, 'ono', NULL, '192.168.1.1', NULL, 'User lehoangphucs updated hardware with IP 192.168.1.1. Changes: OSver: \'1.0.0\' => \'1.0.1\'', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:18:32', '2025-07-03 04:18:32'),
(109, 'ono', NULL, NULL, NULL, ' user lehoangphucs created domain \'ono\'.', NULL, 'ono.com.vn', NULL, NULL, NULL, NULL, 0, '2025-07-03 04:35:03', '2025-07-03 04:35:03'),
(110, 'ono', NULL, NULL, NULL, ' user lehoangphucs created domain \'esp\'.', NULL, 'esp.com.vb', NULL, NULL, NULL, NULL, 0, '2025-07-03 04:35:13', '2025-07-03 04:35:13'),
(111, 'ono', NULL, '192.168.1.1', NULL, 'User lehoangphucs added hardware in ono.com.vn to hardware with IP 192.168.1.1', NULL, 'ono.com.vn', NULL, NULL, NULL, NULL, 0, '2025-07-03 04:35:26', '2025-07-03 04:35:26'),
(112, 'ono', NULL, '192.168.1.1', NULL, 'User lehoangphucs added hardware in esp.com.vb to hardware with IP 192.168.1.1', NULL, 'esp.com.vb', NULL, NULL, NULL, NULL, 0, '2025-07-03 04:35:33', '2025-07-03 04:35:33'),
(113, 'ono', NULL, NULL, NULL, 'User ono updated domain \'ono1\'. Changes: No changes', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:36:56', '2025-07-03 04:36:56'),
(114, 'ono', NULL, NULL, NULL, 'User ono updated domain \'ono12\'. Changes: No changes', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:37:01', '2025-07-03 04:37:01'),
(115, 'ono', NULL, NULL, NULL, 'User ono updated domain \'ono123\'. Changes: No changes', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:37:10', '2025-07-03 04:37:10'),
(116, 'ono', NULL, NULL, NULL, 'User ono updated domain \'ono1234\'. Changes: No changes', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:37:39', '2025-07-03 04:37:39'),
(117, 'ono', NULL, NULL, NULL, 'User ono updated domain \'ono12345\'. Changes: No changes', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:39:34', '2025-07-03 04:39:34'),
(118, 'ono', 25, NULL, NULL, 'user lehoangphucs updated software \'công cụ A1\'.', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:42:05', '2025-07-03 04:42:05'),
(119, 'ono', 25, NULL, NULL, 'user lehoangphucs updated software \'công cụ A1\'.', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-07-03 04:42:09', '2025-07-03 04:42:09');

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_05_24_022512_create_departments_table', 1),
(4, '2025_05_27_065543_users', 1),
(5, '2025_05_27_065544_create_software_table', 1),
(6, '2025_05_27_070853_create_domain_table', 1),
(7, '2025_05_27_074128_create_hardware_table', 1),
(8, '2025_05_27_074218_create_category_rule', 1),
(9, '2025_05_27_074308_create_rules_table', 1),
(10, '2025_05_27_074437_create_roles_table', 1),
(11, '2025_05_27_074801_create_software_file_table', 1),
(12, '2025_05_27_075315_create_permissions_table', 1),
(13, '2025_05_27_075336_create_user_role_table', 1),
(14, '2025_05_27_075402_create_role_permissions_table', 1),
(15, '2025_05_27_075418_create_hardware_permissions_table', 1),
(16, '2025_05_27_075437_create_software_permissions_table', 1),
(17, '2025_05_27_085339_create_software_rule', 1),
(18, '2025_05_28_021131_create_personal_access_tokens_table', 1),
(19, '2025_05_29_023313_create_hardware_access_domain', 1),
(20, '2025_06_01_035653_create_route_permission', 1),
(21, '2025_06_27_012709_recreate_hardware_permissions_table', 1),
(22, '2025_06_27_074919_create_log_table', 1);

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
('ono', 'sửa người dùng', 'user', '2025-06-24 19:09:16', '2025-06-24 19:09:16'),
('ono', 'sửa phần cứng', 'hardware', '2025-06-24 19:15:15', '2025-06-24 19:15:15'),
('ono', 'sửa phần cứng vào domain', 'hardwaredomain', '2025-06-26 04:26:58', '2025-06-26 04:26:58'),
('ono', 'sửa phần mềm', 'software', '2025-07-03 02:43:53', '2025-07-03 02:43:53'),
('ono', 'sửa quyền hạn', 'permission', '2025-06-24 19:09:39', '2025-06-24 19:09:39'),
('ono', 'sửa quyền hệ thống', 'systempermission', '2025-06-26 00:04:41', '2025-06-26 00:04:41'),
('ono', 'sửa quyền người dùng', 'userrole', '2025-06-24 19:11:12', '2025-06-24 19:11:12'),
('ono', 'sửa tên miền', 'domain', '2025-06-26 03:14:47', '2025-06-26 03:14:47'),
('ono', 'sửa vai trò', 'role', '2025-06-24 19:10:01', '2025-06-24 19:10:01'),
('ono', 'thêm người dùng', 'user', '2025-06-25 17:14:03', '2025-06-25 17:14:03'),
('ono', 'thêm phần cứng', 'hardware', '2025-06-24 19:15:11', '2025-06-24 19:15:11'),
('ono', 'thêm phần cứng vào domain', 'hardwaredomain', '2025-06-26 04:26:54', '2025-06-26 04:26:54'),
('ono', 'thêm phần mềm', 'software', '2025-06-25 17:11:35', '2025-06-25 17:11:35'),
('nemoadmin', 'thêm quyền hạn', 'Quyền hạn', '2025-06-05 11:05:10', '2025-06-05 11:05:10'),
('ono', 'thêm quyền hệ thống', 'systempermission', '2025-06-26 00:04:34', '2025-06-26 00:04:34'),
('ono', 'thêm quyền người dùng', 'userrole', '2025-06-19 04:25:25', '2025-06-19 04:25:25'),
('ono', 'thêm tên miền', 'domain', '2025-06-26 03:14:39', '2025-06-26 03:14:39'),
('ono', 'thêm vai trò', 'role', '2025-06-18 20:57:59', '2025-06-18 20:57:59'),
('ono', 'xem chi tiết người dùng', 'user', '2025-06-25 17:14:09', '2025-06-25 17:14:09'),
('ono', 'xem chi tiết phần cứng', 'hardware', '2025-06-24 19:15:28', '2025-06-24 19:15:28'),
('ono', 'xem chi tiết phần cứng vào domain', 'hardwaredomain', '2025-06-26 04:27:05', '2025-06-26 04:27:05'),
('ono', 'xem chi tiết phần mềm', 'software', '2025-06-25 17:11:49', '2025-06-25 17:11:49'),
('ono', 'xem chi tiết tên miền', 'domain', '2025-06-26 03:16:54', '2025-06-26 03:16:54'),
('ono', 'xem chi tiết vai trò', 'role', '2025-06-26 00:10:08', '2025-06-26 00:10:08'),
('ono', 'xem danh sách người dùng', 'user', '2025-06-18 18:59:24', '2025-06-18 18:59:24'),
('ono', 'xem danh sách phần cứng', 'hardware', '2025-06-24 19:15:22', '2025-06-24 19:15:22'),
('ono', 'xem danh sách phần cứng vào domain', 'hardwaredomain', '2025-06-26 04:27:02', '2025-06-26 04:27:02'),
('ono', 'xem danh sách phần mềm', 'software', '2025-06-25 17:11:46', '2025-06-25 17:11:46'),
('ono', 'xem danh sách pháp lý', 'legal', '2025-06-26 03:18:19', '2025-06-26 03:18:19'),
('nemoadmin', 'xem danh sách quyền hạn', 'Quyền hạn', '2025-06-05 11:05:30', '2025-06-05 11:05:30'),
('ono', 'xem danh sách quyền người dùng', 'userrole', '2025-06-24 19:11:01', '2025-06-24 19:11:01'),
('ono', 'xem danh sách tên miền', 'domain', '2025-06-26 03:15:02', '2025-06-26 03:15:02'),
('ono', 'xem danh sách vai trò', 'Quyền hạn', '2025-06-02 05:22:24', '2025-06-02 05:22:24'),
('ono', 'xem người dùng', 'user', '2025-07-03 04:13:12', '2025-07-03 04:13:12'),
('ono', 'xem phần cứng', 'hardware', NULL, NULL),
('ono', 'xem phần mềm', 'software', '2025-07-03 04:09:22', '2025-07-03 04:09:22'),
('ono', 'xoá người dùng', 'user', '2025-06-25 17:14:07', '2025-06-25 17:14:07'),
('ono', 'xoá phần cứng', 'hardware', '2025-06-24 19:15:20', '2025-06-24 19:15:20'),
('ono', 'xoá phần cứng vào domain', 'hardwaredomain', '2025-06-26 04:27:00', '2025-06-26 04:27:00'),
('ono', 'xoá phần mềm', 'software', '2025-06-25 17:11:42', '2025-06-25 17:11:42'),
('ono', 'xoá pháp lý', 'legal', '2025-06-26 03:18:00', '2025-06-26 03:18:00'),
('ono', 'xoá quyền hạn', 'permission', '2025-06-26 00:03:24', '2025-06-26 00:03:24'),
('ono', 'xoá quyền người dùng', 'userrole', '2025-06-26 00:04:47', '2025-06-26 00:04:47'),
('ono', 'xoá tên miền', 'domain', '2025-06-26 03:14:55', '2025-06-26 03:14:55'),
('ono', 'xoá vai trò', 'role', '2025-06-26 00:03:37', '2025-06-26 00:03:37');

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
(1, 'admin', '2025-06-27 01:39:52', NULL, NULL),
(2, 'quản lý phần cứng', '2025-06-27 01:40:00', NULL, NULL),
(3, 'quản lý phần mềm', '2025-06-27 01:40:12', NULL, NULL),
(4, 'quản lý người dùng', '2025-06-27 01:40:20', NULL, NULL),
(5, 'Tên miền', '2025-06-27 01:40:29', NULL, NULL);

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
(32, 'admin', 'xem danh sách vai trò', '2025-06-19 02:18:33', NULL, NULL),
(37, 'admin', 'thêm quyền hạn', '2025-06-19 03:36:04', NULL, NULL),
(38, 'admin', 'xem danh sách quyền hạn', '2025-06-19 03:36:27', NULL, NULL),
(45, 'admin', 'thêm vai trò', '2025-06-18 20:58:17', '2025-06-18 20:58:17', '2025-06-18 20:58:17'),
(93, 'admin', 'thêm quyền người dùng', '2025-06-19 05:45:40', '2025-06-19 05:45:40', '2025-06-19 05:45:40'),
(100, 'admin', 'sửa quyền hạn', '2025-06-24 19:10:17', '2025-06-24 19:10:17', '2025-06-24 19:10:17'),
(101, 'admin', 'xem danh sách quyền người dùng', '2025-06-24 19:11:10', '2025-06-24 19:11:10', '2025-06-24 19:11:10'),
(102, 'admin', 'sửa quyền người dùng', '2025-06-24 19:11:27', '2025-06-24 19:11:27', '2025-06-24 19:11:27'),
(103, 'admin', 'sửa vai trò', '2025-06-24 19:12:43', '2025-06-24 19:12:43', '2025-06-24 19:12:43'),
(104, 'quản lý phần cứng', 'thêm phần cứng', '2025-06-24 19:15:35', '2025-06-24 19:15:35', '2025-06-24 19:15:35'),
(105, 'quản lý phần cứng', 'sửa phần cứng', '2025-06-24 19:15:36', '2025-06-24 19:15:36', '2025-06-24 19:15:36'),
(106, 'quản lý phần cứng', 'xoá phần cứng', '2025-06-24 19:15:36', '2025-06-24 19:15:36', '2025-06-24 19:15:36'),
(108, 'quản lý phần cứng', 'xem chi tiết phần cứng', '2025-06-24 19:15:36', '2025-06-24 19:15:36', '2025-06-24 19:15:36'),
(113, 'quản lý phần mềm', 'thêm phần mềm', '2025-06-25 17:12:05', '2025-06-25 17:12:05', '2025-06-25 17:12:05'),
(115, 'quản lý phần mềm', 'xoá phần mềm', '2025-06-25 17:12:06', '2025-06-25 17:12:06', '2025-06-25 17:12:06'),
(116, 'quản lý phần mềm', 'xem danh sách phần mềm', '2025-06-25 17:12:06', '2025-06-25 17:12:06', '2025-06-25 17:12:06'),
(119, 'quản lý người dùng', 'xem chi tiết người dùng', '2025-06-25 17:14:16', '2025-06-25 17:14:16', '2025-06-25 17:14:16'),
(120, 'quản lý người dùng', 'xem danh sách người dùng', '2025-06-25 17:14:16', '2025-06-25 17:14:16', '2025-06-25 17:14:16'),
(121, 'quản lý người dùng', 'xoá người dùng', '2025-06-25 17:14:16', '2025-06-25 17:14:16', '2025-06-25 17:14:16'),
(122, 'quản lý người dùng', 'sửa người dùng', '2025-06-25 17:14:16', '2025-06-25 17:14:16', '2025-06-25 17:14:16'),
(123, 'quản lý người dùng', 'thêm người dùng', '2025-06-25 17:14:16', '2025-06-25 17:14:16', '2025-06-25 17:14:16'),
(129, 'quản lý phần cứng', 'xem danh sách phần cứng', '2025-06-25 18:34:11', '2025-06-25 18:34:11', '2025-06-25 18:34:11'),
(131, 'admin', 'xoá quyền hạn', '2025-06-26 00:03:32', '2025-06-26 00:03:32', '2025-06-26 00:03:32'),
(132, 'admin', 'xoá vai trò', '2025-06-26 00:03:44', '2025-06-26 00:03:44', '2025-06-26 00:03:44'),
(133, 'admin', 'xoá quyền người dùng', '2025-06-26 00:04:52', '2025-06-26 00:04:52', '2025-06-26 00:04:52'),
(134, 'admin', 'xem chi tiết vai trò', '2025-06-26 00:10:10', '2025-06-26 00:10:10', '2025-06-26 00:10:10'),
(135, 'quản lý phần mềm', 'xem chi tiết phần mềm', '2025-06-26 01:29:18', '2025-06-26 01:29:18', '2025-06-26 01:29:18'),
(136, 'Tên miền', 'thêm tên miền', '2025-06-26 03:19:06', '2025-06-26 03:19:06', '2025-06-26 03:19:06'),
(137, 'Tên miền', 'sửa tên miền', '2025-06-26 03:19:07', '2025-06-26 03:19:07', '2025-06-26 03:19:07'),
(138, 'Tên miền', 'xoá tên miền', '2025-06-26 03:19:07', '2025-06-26 03:19:07', '2025-06-26 03:19:07'),
(142, 'Tên miền', 'thêm phần cứng vào domain', '2025-06-26 04:27:17', '2025-06-26 04:27:17', '2025-06-26 04:27:17'),
(143, 'Tên miền', 'sửa phần cứng vào domain', '2025-06-26 04:27:17', '2025-06-26 04:27:17', '2025-06-26 04:27:17'),
(144, 'Tên miền', 'xoá phần cứng vào domain', '2025-06-26 04:27:17', '2025-06-26 04:27:17', '2025-06-26 04:27:17'),
(145, 'Tên miền', 'xem danh sách phần cứng vào domain', '2025-06-26 04:27:17', '2025-06-26 04:27:17', '2025-06-26 04:27:17'),
(146, 'Tên miền', 'xem chi tiết phần cứng vào domain', '2025-06-26 04:27:18', '2025-06-26 04:27:18', '2025-06-26 04:27:18'),
(148, 'Tên miền', 'xem chi tiết tên miền', '2025-06-26 04:59:35', '2025-06-26 04:59:35', '2025-06-26 04:59:35'),
(149, 'Tên miền', 'xem danh sách tên miền', '2025-06-26 05:00:06', '2025-06-26 05:00:06', '2025-06-26 05:00:06'),
(151, 'quản lý phần mềm', 'sửa phần mềm', '2025-07-03 02:43:59', '2025-07-03 02:43:59', '2025-07-03 02:43:59'),
(152, 'quản lý phần cứng', 'xem phần cứng', '2025-07-03 04:08:34', '2025-07-03 04:08:34', '2025-07-03 04:08:34'),
(153, 'quản lý phần mềm', 'xem phần mềm', '2025-07-03 04:09:28', '2025-07-03 04:09:28', '2025-07-03 04:09:28');

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
(24, 'permission.create', 'thêm quyền hạn', '2025-06-05 11:05:10', '2025-06-05 11:05:10'),
(27, 'permission.list', 'xem danh sách quyền hạn', '2025-06-05 11:05:30', '2025-06-05 11:05:30'),
(33, 'role.list', 'xem danh sách vai trò', '2025-06-02 05:22:24', '2025-06-02 05:22:24'),
(36, 'user.list', 'xem danh sách người dùng', '2025-06-18 18:59:24', '2025-06-18 18:59:24'),
(43, 'role.create', 'thêm vai trò', '2025-06-18 20:57:59', '2025-06-18 20:57:59'),
(44, 'userrole.create', 'thêm quyền người dùng', '2025-06-19 04:25:25', '2025-06-19 04:25:25'),
(45, 'user.edit', 'sửa người dùng', '2025-06-24 19:09:16', '2025-06-24 19:09:16'),
(46, 'permission.edit', 'sửa quyền hạn', '2025-06-24 19:09:39', '2025-06-24 19:09:39'),
(47, 'role.edit', 'sửa vai trò', '2025-06-24 19:10:01', '2025-06-24 19:10:01'),
(48, 'userrole.list', 'xem danh sách quyền người dùng', '2025-06-24 19:11:01', '2025-06-24 19:11:01'),
(49, 'userrole.edit', 'sửa quyền người dùng', '2025-06-24 19:11:12', '2025-06-24 19:11:12'),
(50, 'hardware.create', 'thêm phần cứng', '2025-06-24 19:15:11', '2025-06-24 19:15:11'),
(51, 'hardware.edit', 'sửa phần cứng', '2025-06-24 19:15:15', '2025-06-24 19:15:15'),
(52, 'hardware.delete', 'xoá phần cứng', '2025-06-24 19:15:20', '2025-06-24 19:15:20'),
(53, 'hardware.list', 'xem danh sách phần cứng', '2025-06-24 19:15:22', '2025-06-24 19:15:22'),
(54, 'hardware.detail', 'xem chi tiết phần cứng', '2025-06-24 19:15:28', '2025-06-24 19:15:28'),
(55, 'software.create', 'thêm phần mềm', '2025-06-25 17:11:35', '2025-06-25 17:11:35'),
(57, 'software.delete', 'xoá phần mềm', '2025-06-25 17:11:42', '2025-06-25 17:11:42'),
(58, 'software.list', 'xem danh sách phần mềm', '2025-06-25 17:11:46', '2025-06-25 17:11:46'),
(59, 'software.detail', 'xem chi tiết phần mềm', '2025-06-25 17:11:49', '2025-06-25 17:11:49'),
(61, 'user.create', 'thêm người dùng', '2025-06-25 17:14:03', '2025-06-25 17:14:03'),
(62, 'user.delete', 'xoá người dùng', '2025-06-25 17:14:07', '2025-06-25 17:14:07'),
(63, 'user.detail', 'xem chi tiết người dùng', '2025-06-25 17:14:09', '2025-06-25 17:14:09'),
(66, 'hardware.get', 'xem phần cứng', NULL, NULL),
(67, 'permission.delete', 'xoá quyền hạn', '2025-06-26 00:03:24', '2025-06-26 00:03:24'),
(68, 'role.delete', 'xoá vai trò', '2025-06-26 00:03:37', '2025-06-26 00:03:37'),
(69, 'systempermission.create', 'thêm quyền hệ thống', '2025-06-26 00:04:34', '2025-06-26 00:04:34'),
(70, 'systempermission.edit', 'sửa quyền hệ thống', '2025-06-26 00:04:41', '2025-06-26 00:04:41'),
(71, 'userrole.delete', 'xoá quyền người dùng', '2025-06-26 00:04:47', '2025-06-26 00:04:47'),
(72, 'role.detail', 'xem chi tiết vai trò', '2025-06-26 00:10:08', '2025-06-26 00:10:08'),
(73, 'domain.create', 'thêm tên miền', '2025-06-26 03:14:39', '2025-06-26 03:14:39'),
(74, 'domain.edit', 'sửa tên miền', '2025-06-26 03:14:47', '2025-06-26 03:14:47'),
(75, 'domain.delete', 'xoá tên miền', '2025-06-26 03:14:55', '2025-06-26 03:14:55'),
(76, 'domain.list', 'xem danh sách tên miền', '2025-06-26 03:15:02', '2025-06-26 03:15:02'),
(77, 'domain.detail', 'xem chi tiết tên miền', '2025-06-26 03:16:54', '2025-06-26 03:16:54'),
(79, 'legal.delete', 'xoá pháp lý', '2025-06-26 03:18:00', '2025-06-26 03:18:00'),
(80, 'legal.list', 'xem danh sách pháp lý', '2025-06-26 03:18:19', '2025-06-26 03:18:19'),
(81, 'hardwaredomain.create', 'thêm phần cứng vào domain', '2025-06-26 04:26:54', '2025-06-26 04:26:54'),
(82, 'hardwaredomain.edit', 'sửa phần cứng vào domain', '2025-06-26 04:26:58', '2025-06-26 04:26:58'),
(83, 'hardwaredomain.delete', 'xoá phần cứng vào domain', '2025-06-26 04:27:00', '2025-06-26 04:27:00'),
(84, 'hardwaredomain.list', 'xem danh sách phần cứng vào domain', '2025-06-26 04:27:02', '2025-06-26 04:27:02'),
(85, 'hardwaredomain.detail', 'xem chi tiết phần cứng vào domain', '2025-06-26 04:27:05', '2025-06-26 04:27:05'),
(87, 'software.edit', 'sửa phần mềm', '2025-07-03 02:43:53', '2025-07-03 02:43:53'),
(88, 'software.get', 'xem phần mềm', '2025-07-03 04:09:22', '2025-07-03 04:09:22'),
(89, 'user.get', 'xem người dùng', '2025-07-03 04:13:12', '2025-07-03 04:13:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rules`
--

CREATE TABLE `rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `file_url` varchar(250) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
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
  `user_id` varchar(200) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8rFn8tmmzVhL8HPzuwcDLcCToJalXZo90EdLQgyd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1NWRDJyVmpteDdsUVNQRm1QSnZ3NUI4QlFsWE1OWVh5a3FDam5tZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751538820),
('Dm3ggKR11T0E1qJGCVdEETMQIq06JS8F3dTyqnkH', 'ono', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnJCckdUNUJ1alRUWFpVTXRtbWtjeFFyVWdjTXc2M1RpZUZvcmtWayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tb2RhbC9kb21haW5fZGV0YWlsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751542876);

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

--
-- Đang đổ dữ liệu cho bảng `software`
--

INSERT INTO `software` (`id`, `softwareName`, `language`, `version`, `user_createby`, `is_delete`, `description`, `created_at`, `updated_at`) VALUES
(25, 'công cụ A1', 'javaScript', '2.0.0', 'ono', 0, '1', '2025-07-03 04:17:24', '2025-07-03 04:42:09'),
(26, 'công cụ A2', 'TypeScript', '2.0.0', 'ono', 0, '2', '2025-07-03 04:17:30', '2025-07-03 04:17:30'),
(27, 'công cụ A3', 'TypeScript', '1.1.0', 'ono', 0, '3', '2025-07-03 04:17:38', '2025-07-03 04:17:38'),
(28, 'công cụ A122', 'javaScript', '1.1.0', 'ono', 0, '1', '2025-07-03 04:17:44', '2025-07-03 04:17:44'),
(29, 'hệ hỗ trợ ứng dụng', 'java', '2.0.0', 'ono', 0, '1', '2025-07-03 04:17:55', '2025-07-03 04:17:55');

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
  `permissions_name` varchar(150) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `software_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `software_permissions`
--

INSERT INTO `software_permissions` (`id`, `create_by`, `permissions_name`, `user_name`, `software_id`, `assigned_at`, `created_at`, `updated_at`) VALUES
(17, 'ono', 'xem phần mềm', 'ono', 25, '2025-07-03 04:17:24', '2025-07-03 04:17:24', '2025-07-03 04:17:24'),
(18, 'ono', 'sửa phần mềm', 'ono', 25, '2025-07-03 04:17:24', '2025-07-03 04:17:24', '2025-07-03 04:17:24'),
(19, 'ono', 'xóa phần mềm', 'ono', 25, '2025-07-03 04:17:24', '2025-07-03 04:17:24', '2025-07-03 04:17:24'),
(20, 'ono', 'xem phần mềm', 'ono', 26, '2025-07-03 04:17:30', '2025-07-03 04:17:30', '2025-07-03 04:17:30'),
(21, 'ono', 'sửa phần mềm', 'ono', 26, '2025-07-03 04:17:30', '2025-07-03 04:17:30', '2025-07-03 04:17:30'),
(22, 'ono', 'xóa phần mềm', 'ono', 26, '2025-07-03 04:17:30', '2025-07-03 04:17:30', '2025-07-03 04:17:30'),
(23, 'ono', 'xem phần mềm', 'ono', 27, '2025-07-03 04:17:38', '2025-07-03 04:17:38', '2025-07-03 04:17:38'),
(24, 'ono', 'sửa phần mềm', 'ono', 27, '2025-07-03 04:17:38', '2025-07-03 04:17:38', '2025-07-03 04:17:38'),
(25, 'ono', 'xóa phần mềm', 'ono', 27, '2025-07-03 04:17:38', '2025-07-03 04:17:38', '2025-07-03 04:17:38'),
(26, 'ono', 'xem phần mềm', 'ono', 28, '2025-07-03 04:17:44', '2025-07-03 04:17:44', '2025-07-03 04:17:44'),
(27, 'ono', 'sửa phần mềm', 'ono', 28, '2025-07-03 04:17:44', '2025-07-03 04:17:44', '2025-07-03 04:17:44'),
(28, 'ono', 'xóa phần mềm', 'ono', 28, '2025-07-03 04:17:44', '2025-07-03 04:17:44', '2025-07-03 04:17:44'),
(29, 'ono', 'xem phần mềm', 'ono', 29, '2025-07-03 04:17:55', '2025-07-03 04:17:55', '2025-07-03 04:17:55'),
(30, 'ono', 'sửa phần mềm', 'ono', 29, '2025-07-03 04:17:55', '2025-07-03 04:17:55', '2025-07-03 04:17:55'),
(31, 'ono', 'xóa phần mềm', 'ono', 29, '2025-07-03 04:17:55', '2025-07-03 04:17:55', '2025-07-03 04:17:55');

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
('lehoangphuc', '$2y$12$Q7RdlewNlJmMQUcmIHohk..l92Xw1TBpw.j5QdnxdLFINFVl9D1nO', NULL, NULL, NULL, 0, 0, NULL, '2025-07-02 04:46:12', '2025-07-02 04:46:12'),
('lephuc', '$2y$12$3mJ7KxFWGzIZKr/SkFonxea.Ou6GL3RdNELU2.Je4f28unMZplU6C', NULL, NULL, NULL, 0, 0, NULL, '2025-07-02 04:47:29', '2025-07-02 04:47:29'),
('nemoadmin', '$2y$12$K/5nix96QGwoKF0VougvHuInDBDudz/ADB2IomxeaZh6Z3TG0q426', NULL, NULL, NULL, 0, 0, NULL, '2025-06-04 12:51:58', '2025-06-04 12:51:58'),
('nemohardware', '$2y$12$rXMBIE.ShWra4nVrTwLJCOG56VdPu8u/Zz0TuFas0satM.XomOGyC', NULL, NULL, NULL, 0, 0, NULL, '2025-06-04 12:52:13', '2025-06-04 12:52:13'),
('nemosoftware', '$2y$12$BcBcHJadD8IzRX3xY5SPMOsu3oPasOM2lo2PERev1UjooGt1l7WtS', NULL, NULL, NULL, 0, 0, NULL, '2025-06-04 12:52:18', '2025-06-04 12:52:18'),
('nemosystem', '$2y$12$kqXMqqv4LWp9Y7iVp5cpA.yVt2bNjarBCCHgUGN/7TPBbRdnhVpiq', NULL, NULL, NULL, 0, 0, NULL, '2025-06-04 12:52:25', '2025-06-04 12:52:25'),
('ono', '$2y$12$s0ms/LSQOgfFn3LIntFmieUems7jyLuPt/3FUdFLHU4M1ispJvvIu', 'lehoangphucs', 'lehoangphuc01052003@gmail.com', '0372830048', 0, 0, NULL, '2025-06-02 03:10:11', '2025-07-02 05:07:04');

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
(1, 'ono', 'admin', '2025-06-25 02:07:00', NULL, NULL),
(2, 'ono', 'quản lý phần cứng', '2025-06-24 19:15:48', '2025-06-24 19:15:48', '2025-06-24 19:15:48'),
(3, 'ono', 'quản lý người dùng', '2025-06-25 17:26:09', '2025-06-25 17:26:09', '2025-06-25 17:26:09'),
(4, 'ono', 'quản lý phần mềm', '2025-06-26 00:00:11', '2025-06-26 00:00:11', '2025-06-26 00:00:11'),
(6, 'nemosystem', 'quản lý phần cứng', '2025-06-26 00:03:51', '2025-06-26 00:03:51', '2025-06-26 00:03:51'),
(7, 'nemosystem', 'quản lý phần mềm', '2025-06-26 00:03:52', '2025-06-26 00:03:52', '2025-06-26 00:03:52'),
(8, 'nemosystem', 'quản lý phần mềm', '2025-06-26 00:03:54', '2025-06-26 00:03:54', '2025-06-26 00:03:54'),
(9, 'nemosystem', 'quản lý phần cứng', '2025-06-26 00:03:57', '2025-06-26 00:03:57', '2025-06-26 00:03:57'),
(10, 'nemosystem', 'quản lý phần mềm', '2025-06-26 00:03:58', '2025-06-26 00:03:58', '2025-06-26 00:03:58'),
(11, 'ono', 'Tên miền', '2025-06-26 03:19:28', '2025-06-26 03:19:28', '2025-06-26 03:19:28');

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
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

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
  ADD KEY `hardware_created_by_foreign` (`created_by`);

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
  ADD KEY `log_link_domain_foreign` (`link_domain`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `rules_category_id_foreign` (`category_id`),
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
  ADD KEY `software_permissions_software_id_foreign` (`software_id`),
  ADD KEY `software_permissions_user_name_foreign` (`user_name`) USING BTREE,
  ADD KEY `fk_software_permissions_name` (`permissions_name`);

--
-- Chỉ mục cho bảng `software_rule`
--
ALTER TABLE `software_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `software_rule_software_id_foreign` (`software_id`),
  ADD KEY `software_rule_rule_id_foreign` (`rule_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `domain`
--
ALTER TABLE `domain`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hardware_access_domain`
--
ALTER TABLE `hardware_access_domain`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `hardware_permissions`
--
ALTER TABLE `hardware_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT cho bảng `route_permission`
--
ALTER TABLE `route_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT cho bảng `rules`
--
ALTER TABLE `rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `software`
--
ALTER TABLE `software`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `software_file`
--
ALTER TABLE `software_file`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `software_permissions`
--
ALTER TABLE `software_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `software_rule`
--
ALTER TABLE `software_rule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

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
  ADD CONSTRAINT `hardware_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `log_hardware_ip_foreign` FOREIGN KEY (`hardware_ip`) REFERENCES `hardware` (`ip`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_hw_permission_user_foreign` FOREIGN KEY (`hw_permission_user`) REFERENCES `hardware_permissions` (`user_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_link_domain_foreign` FOREIGN KEY (`link_domain`) REFERENCES `domain` (`link`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_permission_name_foreign` FOREIGN KEY (`permission_name`) REFERENCES `permissions` (`permissions_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_rule_id_foreign` FOREIGN KEY (`rule_id`) REFERENCES `rules` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_software_file_id_foreign` FOREIGN KEY (`software_file_id`) REFERENCES `software_file` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_software_id_foreign` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_sw_permission_user_foreign` FOREIGN KEY (`sw_permission_user`) REFERENCES `software_permissions` (`user_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `log_username_foreign` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `rules_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category_rule` (`id`) ON UPDATE CASCADE,
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
  ADD CONSTRAINT `fk_software_permissions_name` FOREIGN KEY (`permissions_name`) REFERENCES `permissions` (`permissions_name`) ON DELETE CASCADE ON UPDATE CASCADE,
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
