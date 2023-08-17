-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2023 at 10:47 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ishare_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentications`
--

CREATE TABLE `authentications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `otp_code` int(11) NOT NULL,
  `expired` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0-No, 1-Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authentications`
--

INSERT INTO `authentications` (`id`, `otp_code`, `expired`, `created_at`, `updated_at`) VALUES
(1, 348580, 0, '2023-08-12 02:45:53', NULL),
(2, 569731, 0, '2023-08-12 02:46:32', NULL),
(3, 538073, 0, '2023-08-17 05:53:26', NULL),
(4, 380514, 0, '2023-08-17 06:29:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_code` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT '1' COMMENT '0-Not Active, 1-Active',
  `created_by` bigint(20) UNSIGNED NOT NULL COMMENT 'users(table)',
  `is_deleted` tinyint(4) DEFAULT 0 COMMENT '0-Active, 1-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `group_code`, `status`, `created_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Main Group', '729172', '1', 4, 0, '2023-08-17 06:41:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_leaders`
--

CREATE TABLE `group_leaders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL COMMENT 'groups(table)',
  `group_leader_name` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'users(table)',
  `group_number` varchar(255) DEFAULT NULL,
  `group_section` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'sections(table)',
  `status` varchar(255) DEFAULT '1' COMMENT '0-Not Active, 1-Active',
  `is_deleted` tinyint(4) DEFAULT 0 COMMENT '0-Active, 1-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_leaders`
--

INSERT INTO `group_leaders` (`id`, `group_id`, `group_leader_name`, `group_number`, `group_section`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(5, 1, 5, NULL, NULL, '1', 0, '2023-08-17 06:41:12', NULL),
(6, 1, 6, NULL, NULL, '1', 0, '2023-08-17 06:41:12', NULL),
(7, 1, 4, 'Group 1', 1, '1', 0, '2023-08-17 06:41:13', '2023-08-17 06:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `group_leader_members`
--

CREATE TABLE `group_leader_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL COMMENT 'groups(table) id',
  `group_leader_id` bigint(20) UNSIGNED NOT NULL COMMENT 'group_leaders(table) id',
  `member_name` bigint(20) UNSIGNED NOT NULL COMMENT 'users(table) id',
  `status` varchar(255) DEFAULT NULL COMMENT '0-Not exist in Group, 1-Exist in Group',
  `is_deleted` tinyint(4) DEFAULT 0 COMMENT '0-Active, 1-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_leader_members`
--

INSERT INTO `group_leader_members` (`id`, `group_id`, `group_leader_id`, `member_name`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 1, 7, 5, '1', 0, '2023-08-17 06:41:45', NULL),
(3, 1, 7, 6, '1', 0, '2023-08-17 06:41:45', NULL),
(4, 1, 7, 4, '1', 0, '2023-08-17 06:41:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_leader_titles`
--

CREATE TABLE `group_leader_titles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL COMMENT 'groups(table)',
  `group_leader_id` bigint(20) UNSIGNED NOT NULL COMMENT 'group_leaders(table)',
  `title` varchar(255) DEFAULT NULL,
  `approval_status` varchar(255) DEFAULT NULL COMMENT '0-Pending, 1-Approved, 2-Rejected',
  `is_deleted` tinyint(4) DEFAULT 0 COMMENT '0-Active, 1-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_leader_titles`
--

INSERT INTO `group_leader_titles` (`id`, `group_id`, `group_leader_id`, `title`, `approval_status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 1, 7, 'taaaa 1', '0', 0, '2023-08-17 06:41:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `libraries`
--

CREATE TABLE `libraries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '0-Not exist in Group, 1-Exist in Group',
  `author` varchar(255) DEFAULT NULL,
  `original_file_name` varchar(255) DEFAULT NULL,
  `generated_file_name` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0' COMMENT '0-Pending, 1-Approved, 2-Rejected',
  `created_by` bigint(20) UNSIGNED NOT NULL COMMENT 'users(table)',
  `is_deleted` tinyint(4) DEFAULT 0 COMMENT '0-Active, 1-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2023_06_03_022111_create_user_levels_table', 1),
(4, '2023_06_03_022207_create_sections_table', 1),
(5, '2023_06_03_024144_create_authentications_table', 1),
(13, '2023_06_04_100000_create_users_table', 2),
(14, '2023_06_04_115813_create_groups_table', 2),
(15, '2023_06_06_015606_create_group_leaders_table', 3),
(16, '2023_06_06_034603_create_group_leader_titles_table', 4),
(17, '2023_06_06_034912_create_group_leader_members_table', 5),
(18, '2023_06_11_085915_create_libraries_table', 6),
(19, '2023_06_27_050813_create_reset_password_codes_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_codes`
--

CREATE TABLE `reset_password_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reset_password_code` int(11) NOT NULL,
  `expired` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0-No, 1-Yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `section_name_status` varchar(255) DEFAULT '1' COMMENT '0-Not Active, 1-Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT 0 COMMENT '0-active, 1-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_name`, `section_name_status`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'BTVTE CH-2A', '1', NULL, NULL, 0),
(2, 'BTVTE CH-2B', '1', NULL, NULL, 0),
(3, 'BTVTE CH-2C', '1', NULL, NULL, 0),
(4, 'BTVTE CH-2D', '1', NULL, NULL, 0),
(5, 'BTVTE CH-3A', '1', NULL, NULL, 0),
(6, 'BTVTE CH-3B', '1', NULL, NULL, 0),
(7, 'BTVTE CH-3C', '1', NULL, NULL, 0),
(8, 'BTVTE CH-3D', '1', NULL, NULL, 0),
(9, 'BTVTE CP-2A', '1', NULL, NULL, 0),
(10, 'BTVTE CP-2B', '1', NULL, NULL, 0),
(11, 'BTVTE CP-2C', '1', NULL, NULL, 0),
(12, 'BTVTE CP-2D', '1', NULL, NULL, 0),
(13, 'BTVTE CP-3A', '1', NULL, NULL, 0),
(14, 'BTVTE CP-3B', '1', NULL, NULL, 0),
(15, 'BTVTE CP-3C', '1', NULL, NULL, 0),
(16, 'BTVTE CP-3D', '1', NULL, NULL, 0),
(17, 'BTVTE ELEXT-2A', '1', NULL, NULL, 0),
(18, 'BTVTE ELEXT-2B', '1', NULL, NULL, 0),
(19, 'BTVTE ELEXT-2C', '1', NULL, NULL, 0),
(20, 'BTVTE ELEXT-2D', '1', NULL, NULL, 0),
(21, 'BTVTE ELEXT-3A', '1', NULL, NULL, 0),
(22, 'BTVTE ELEXT-3B', '1', NULL, NULL, 0),
(23, 'BTVTE ELEXT-3C', '1', NULL, NULL, 0),
(24, 'BTVTE ELEXT-3D', '1', NULL, NULL, 0),
(25, 'BTVTE IT-2A', '1', NULL, NULL, 0),
(26, 'BTVTE IT-2B', '1', NULL, NULL, 0),
(27, 'BTVTE IT-2C', '1', NULL, NULL, 0),
(28, 'BTVTE IT-2D', '1', NULL, NULL, 0),
(29, 'BTVTE IT-3A', '1', NULL, NULL, 0),
(30, 'BTVTE IT-3B', '1', NULL, NULL, 0),
(31, 'BTVTE IT-3C', '1', NULL, NULL, 0),
(32, 'BTVTE IT-3D', '1', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tupt_id_number` varchar(255) NOT NULL COMMENT 'Username',
  `password` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT '1' COMMENT '0-Not Active, 1-Active',
  `is_password_changed` tinyint(4) DEFAULT 0 COMMENT '0-No, 1-Yes',
  `user_level_id` bigint(20) UNSIGNED NOT NULL COMMENT '1-Admin, 2-Faculty, 3-Student',
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT 0 COMMENT '0-Active, 1-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `tupt_id_number`, `password`, `status`, `is_password_changed`, `user_level_id`, `section_id`, `created_by`, `last_updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(4, 'Jannus Domingo', 'jdomingo@tup.edu.ph', 'TUPT-23-0001', '$2y$10$7JRVEg6k.8F9grLZVEjYIuRtsZCCs/uDqrKbs123AU.GQT8uGhpmq', '1', 0, 3, 1, NULL, NULL, 0, '2023-08-12 02:48:51', NULL),
(5, 'Alexandria', 'alexandria@tup.edu.ph', 'TUPT-23-0002', '$2y$10$u0Fe/pjwflqsOcZATea5UexyFc1XwJsw.PcwFel7/gcifsbN3SwfW', '1', 0, 3, 1, NULL, NULL, 0, '2023-08-17 05:53:46', NULL),
(6, 'Alexandria2', 'Alexandria2@tup.edu.ph', 'TUPT-23-0003', '$2y$10$7cMONzpxoUO9Yzoyl68iIedy/x08liFUIXkAn0WDwjZk32wGzitL.', '1', 0, 3, 2, NULL, NULL, 0, '2023-08-17 06:29:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_level_name` varchar(255) NOT NULL,
  `user_level_status` varchar(255) DEFAULT '1' COMMENT '0-Not Active, 1-Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT 0 COMMENT '0-active, 1-deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`id`, `user_level_name`, `user_level_status`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'Admin', '1', '2023-06-02 18:47:53', '2023-06-02 18:47:53', 0),
(2, 'Faculty', '1', '2023-06-02 18:47:53', '2023-06-02 18:47:53', 0),
(3, 'Student', '1', '2023-06-02 18:48:19', '2023-06-02 18:48:19', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentications`
--
ALTER TABLE `authentications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_group_code_unique` (`group_code`),
  ADD KEY `groups_created_by_foreign` (`created_by`);

--
-- Indexes for table `group_leaders`
--
ALTER TABLE `group_leaders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_leaders_group_id_foreign` (`group_id`),
  ADD KEY `group_leaders_group_leader_name_foreign` (`group_leader_name`),
  ADD KEY `group_leaders_group_section_foreign` (`group_section`);

--
-- Indexes for table `group_leader_members`
--
ALTER TABLE `group_leader_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_leader_members_group_id_foreign` (`group_id`),
  ADD KEY `group_leader_members_group_leader_id_foreign` (`group_leader_id`),
  ADD KEY `group_leader_members_member_name_foreign` (`member_name`);

--
-- Indexes for table `group_leader_titles`
--
ALTER TABLE `group_leader_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_leader_titles_group_id_foreign` (`group_id`),
  ADD KEY `group_leader_titles_group_leader_id_foreign` (`group_leader_id`);

--
-- Indexes for table `libraries`
--
ALTER TABLE `libraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `libraries_created_by_foreign` (`created_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `reset_password_codes`
--
ALTER TABLE `reset_password_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_user_level_id_foreign` (`user_level_id`),
  ADD KEY `users_section_id_foreign` (`section_id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authentications`
--
ALTER TABLE `authentications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `group_leaders`
--
ALTER TABLE `group_leaders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `group_leader_members`
--
ALTER TABLE `group_leader_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `group_leader_titles`
--
ALTER TABLE `group_leader_titles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `libraries`
--
ALTER TABLE `libraries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `reset_password_codes`
--
ALTER TABLE `reset_password_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `group_leaders`
--
ALTER TABLE `group_leaders`
  ADD CONSTRAINT `group_leaders_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `group_leaders_group_leader_name_foreign` FOREIGN KEY (`group_leader_name`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `group_leaders_group_section_foreign` FOREIGN KEY (`group_section`) REFERENCES `sections` (`id`);

--
-- Constraints for table `group_leader_members`
--
ALTER TABLE `group_leader_members`
  ADD CONSTRAINT `group_leader_members_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `group_leader_members_group_leader_id_foreign` FOREIGN KEY (`group_leader_id`) REFERENCES `group_leaders` (`id`),
  ADD CONSTRAINT `group_leader_members_member_name_foreign` FOREIGN KEY (`member_name`) REFERENCES `users` (`id`);

--
-- Constraints for table `group_leader_titles`
--
ALTER TABLE `group_leader_titles`
  ADD CONSTRAINT `group_leader_titles_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `group_leader_titles_group_leader_id_foreign` FOREIGN KEY (`group_leader_id`) REFERENCES `group_leaders` (`id`);

--
-- Constraints for table `libraries`
--
ALTER TABLE `libraries`
  ADD CONSTRAINT `libraries_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `users_user_level_id_foreign` FOREIGN KEY (`user_level_id`) REFERENCES `user_levels` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
