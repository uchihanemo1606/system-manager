-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 14, 2025 lúc 11:37 PM
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `database`
--
ALTER TABLE `database`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `database_version`
--
ALTER TABLE `database_version`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hardware_access_domain`
--
ALTER TABLE `hardware_access_domain`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hardware_permissions`
--
ALTER TABLE `hardware_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `os`
--
ALTER TABLE `os`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `os_version`
--
ALTER TABLE `os_version`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `route_permission`
--
ALTER TABLE `route_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `rules`
--
ALTER TABLE `rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `software`
--
ALTER TABLE `software`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `software_file`
--
ALTER TABLE `software_file`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `software_permissions`
--
ALTER TABLE `software_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `software_rule`
--
ALTER TABLE `software_rule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `systemproject`
--
ALTER TABLE `systemproject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
