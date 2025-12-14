-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2025 at 03:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_pets`
--

CREATE TABLE `adoption_pets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `species` varchar(100) NOT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `size` enum('small','medium','large') NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `health_status` text DEFAULT NULL,
  `vaccinated` tinyint(1) DEFAULT 0,
  `neutered` tinyint(1) DEFAULT 0,
  `good_with_kids` tinyint(1) DEFAULT 0,
  `good_with_pets` tinyint(1) DEFAULT 0,
  `adoption_fee` decimal(10,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `is_adopted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pet_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `found_pets`
--

CREATE TABLE `found_pets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `species` varchar(100) NOT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `approximate_age` varchar(50) DEFAULT NULL,
  `gender` enum('male','female','unknown') DEFAULT 'unknown',
  `description` text DEFAULT NULL,
  `found_location` varchar(255) NOT NULL,
  `found_date` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `is_claimed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lost_pets`
--

CREATE TABLE `lost_pets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `species` varchar(100) NOT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('male','female','unknown') DEFAULT 'unknown',
  `description` text DEFAULT NULL,
  `last_seen_location` varchar(255) NOT NULL,
  `last_seen_date` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `is_reunited` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lost_pets`
--

INSERT INTO `lost_pets` (`id`, `user_id`, `name`, `species`, `breed`, `color`, `age`, `gender`, `description`, `last_seen_location`, `last_seen_date`, `image`, `contact_phone`, `is_reunited`, `created_at`, `updated_at`) VALUES
(2, 1, 'jericoro', 'Dog', 'belguim', 'gikagid', 20, 'male', 'og makita ninyo ayaw na ninyog iuli', 'ipil sanito bgry kaymito', '2025-12-14', 'lost_pets/7w36igr0M4BvmJn23iqi5hn3t3CzClggfYYEMdPQ.jpg', '09280485536', 0, '2025-12-14 06:24:27', '2025-12-14 06:24:27'),
(3, 1, 'jericoro', 'Dog', 'belguim', 'gikagid', 20, 'male', 'og makita ninyo ayaw na ninyog iuli', 'ipil sanito bgry kaymito', '2025-12-14', 'lost_pets/jZnF8M3tW2wcmkpiupAzBvXVFGvx3Iq6XATKERTc.jpg', '09280485536', 0, '2025-12-14 06:26:35', '2025-12-14 06:26:35'),
(5, 1, 'adad', 'Dog', 'adad', 'asad', 123, 'female', 'adsdad', 'asd', '2025-12-14', 'lost_pets/EUtqzYBPmms99n13mzyXin0yXyx6p7EXFYXbw8b6.jpg', 'ads13331', 0, '2025-12-14 06:43:45', '2025-12-14 06:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
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

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `age` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'safe',
  `microchip` varchar(255) DEFAULT NULL,
  `vaccinated` tinyint(1) DEFAULT 0,
  `neutered` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Francis D.', 'admin@gmail.com', NULL, '$2y$12$MA8tEp8XdWmRlB4E0Gu1uukGEDf2k5B8f.w3XzICS3EWEhja.fGk.', NULL, '2025-12-14 05:41:23', '2025-12-14 05:41:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_pets`
--
ALTER TABLE `adoption_pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adoption_pets_user_id_foreign` (`user_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_pet_id_unique` (`user_id`,`pet_id`),
  ADD KEY `favorites_pet_id_foreign` (`pet_id`);

--
-- Indexes for table `found_pets`
--
ALTER TABLE `found_pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `found_pets_user_id_foreign` (`user_id`);

--
-- Indexes for table `lost_pets`
--
ALTER TABLE `lost_pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lost_pets_user_id_foreign` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pets_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_pets`
--
ALTER TABLE `adoption_pets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `found_pets`
--
ALTER TABLE `found_pets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lost_pets`
--
ALTER TABLE `lost_pets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_pets`
--
ALTER TABLE `adoption_pets`
  ADD CONSTRAINT `adoption_pets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `found_pets`
--
ALTER TABLE `found_pets`
  ADD CONSTRAINT `found_pets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lost_pets`
--
ALTER TABLE `lost_pets`
  ADD CONSTRAINT `lost_pets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
