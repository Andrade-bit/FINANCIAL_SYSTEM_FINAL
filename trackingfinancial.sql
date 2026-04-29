-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 04:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trackingfinancial`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `encoderaddexpenses`
--

CREATE TABLE `encoderaddexpenses` (
  `encoderAddexpensesID` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `encoderaddmoney`
--

CREATE TABLE `encoderaddmoney` (
  `encoderAddmoneyID` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `encoders`
--

CREATE TABLE `encoders` (
  `encodersID` bigint(20) UNSIGNED NOT NULL,
  `encoderTransactionsID` bigint(20) UNSIGNED DEFAULT NULL,
  `encoderAddmoneyID` bigint(20) UNSIGNED DEFAULT NULL,
  `encoderAddexpensesID` bigint(20) UNSIGNED DEFAULT NULL,
  `usersID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `encoder_transactions`
--

CREATE TABLE `encoder_transactions` (
  `encoderTransactionsID` bigint(20) UNSIGNED NOT NULL,
  `usersID` bigint(20) UNSIGNED NOT NULL,
  `encoderAddmoneyID` bigint(20) UNSIGNED DEFAULT NULL,
  `encoderAddexpensesID` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `funds_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `expenses_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `type` enum('funds','expenses','both') NOT NULL DEFAULT 'funds',
  `notes` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `treasureraddexpenses`
--

CREATE TABLE `treasureraddexpenses` (
  `treasurerAddexpensesID` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treasureraddmoney`
--

CREATE TABLE `treasureraddmoney` (
  `treasurerAddmoneyID` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `description` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treasurerquickacts`
--

CREATE TABLE `treasurerquickacts` (
  `treasurerQuickactsID` bigint(20) UNSIGNED NOT NULL,
  `actions` enum('approve','no') NOT NULL DEFAULT 'no',
  `encoderAddmoneyID` bigint(20) UNSIGNED DEFAULT NULL,
  `encoderAddexpensesID` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treasurerreports`
--

CREATE TABLE `treasurerreports` (
  `treasurerReportsID` bigint(20) UNSIGNED NOT NULL,
  `treasurerTransactionsID` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treasurers`
--

CREATE TABLE `treasurers` (
  `treasurersID` bigint(20) UNSIGNED NOT NULL,
  `treasurerDashboardID` bigint(20) UNSIGNED DEFAULT NULL,
  `treasurerQuickactsID` bigint(20) UNSIGNED DEFAULT NULL,
  `treasurerAddexpensesID` bigint(20) UNSIGNED DEFAULT NULL,
  `treasurerAddmoneyID` bigint(20) UNSIGNED DEFAULT NULL,
  `treasurerTransactionsID` bigint(20) UNSIGNED DEFAULT NULL,
  `usersID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treasurer_dashboard`
--

CREATE TABLE `treasurer_dashboard` (
  `treasurerDashboardID` bigint(20) UNSIGNED NOT NULL,
  `usersID` bigint(20) UNSIGNED NOT NULL,
  `total_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_collections` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_expenses` decimal(15,2) NOT NULL DEFAULT 0.00,
  `monthly_overview` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treasurer_dashboard`
--

INSERT INTO `treasurer_dashboard` (`treasurerDashboardID`, `usersID`, `total_balance`, `total_collections`, `total_expenses`, `monthly_overview`) VALUES
(1, 2, 20801.00, 32000.00, 11199.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `treasurer_transactions`
--

CREATE TABLE `treasurer_transactions` (
  `treasurerTransactionsID` bigint(20) UNSIGNED NOT NULL,
  `usersID` bigint(20) UNSIGNED NOT NULL,
  `treasurerAddmoneyID` bigint(20) UNSIGNED DEFAULT NULL,
  `treasurerAddexpensesID` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('funds','expenses','both') NOT NULL DEFAULT 'funds',
  `description` varchar(255) DEFAULT NULL,
  `funds_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `expenses_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treasurer_transactions`
--

INSERT INTO `treasurer_transactions` (`treasurerTransactionsID`, `usersID`, `treasurerAddmoneyID`, `treasurerAddexpensesID`, `type`, `description`, `funds_amount`, `expenses_amount`, `total_amount`, `date`, `notes`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, 'both', 'sunday offering', 10000.00, 1000.00, 9000.00, '2026-04-23', 'notes', 'approved', NULL, NULL, '2026-04-23 04:30:48', '2026-04-23 05:37:59'),
(2, 3, NULL, NULL, 'expenses', NULL, 0.00, 0.00, 0.00, '2026-04-23', '', 'pending', NULL, NULL, '2026-04-23 04:33:16', '2026-04-23 04:33:16'),
(3, 2, NULL, NULL, 'both', 'wednesday offering', 1000.00, 199.00, 801.00, '2026-04-23', '', 'approved', NULL, NULL, '2026-04-23 04:48:57', '2026-04-23 05:38:00'),
(4, 3, NULL, NULL, 'both', 'sunday offering', 1000.00, 100.00, 900.00, '2026-04-23', '', 'pending', NULL, NULL, '2026-04-23 04:49:58', '2026-04-23 04:49:58'),
(5, 3, NULL, NULL, 'both', 'sunday offering', 11.00, 2.00, 9.00, '2026-04-23', '', 'pending', NULL, NULL, '2026-04-23 05:05:05', '2026-04-23 05:05:05'),
(6, 2, NULL, NULL, 'expenses', 'sunday expenses', 0.00, 10000.00, -10000.00, '2026-04-23', '', 'approved', NULL, NULL, '2026-04-23 05:38:23', '2026-04-23 05:38:28'),
(7, 2, NULL, NULL, 'funds', 'sunday offering', 1000.00, 0.00, 1000.00, '2026-04-23', '', 'approved', NULL, NULL, '2026-04-23 05:38:49', '2026-04-23 05:38:51'),
(8, 2, NULL, NULL, 'funds', 'sunday offering', 20000.00, 0.00, 20000.00, '2026-04-23', '', 'approved', NULL, NULL, '2026-04-23 05:52:16', '2026-04-23 05:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersID` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','treasurer','encoder') NOT NULL DEFAULT 'encoder',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersID`, `firstName`, `middleName`, `lastName`, `username`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Andy', 'Mina', 'Andrade', 'andy', '$2y$12$1U5egPdeX04Rye7GTG3jOe3oi5g9y.z4ngI93effqPxPaKgVj5oty', 'admin', 'Active', NULL, '2026-04-23 12:18:50', '2026-04-23 04:25:58'),
(2, 'joen', 'relsb', 'jomaine', 'joen', '$2y$12$Hy35vT7EhGBP7PoZfvH/7eZdaMDNM1U1kYV2A3aNE8KMCovy6trCG', 'treasurer', 'Active', NULL, '2026-04-23 04:27:00', '2026-04-23 04:27:00'),
(3, 'claude', 'bayt', 'galon', 'encoder', '$2y$12$4Oo5wVUA0BpwDHjhLTOkUe7/A/R29CB6HQ6FAKyZOSq2vn2DDxGyS', 'encoder', 'Active', NULL, '2026-04-23 04:31:49', '2026-04-23 04:32:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `encoderaddexpenses`
--
ALTER TABLE `encoderaddexpenses`
  ADD PRIMARY KEY (`encoderAddexpensesID`);

--
-- Indexes for table `encoderaddmoney`
--
ALTER TABLE `encoderaddmoney`
  ADD PRIMARY KEY (`encoderAddmoneyID`);

--
-- Indexes for table `encoders`
--
ALTER TABLE `encoders`
  ADD PRIMARY KEY (`encodersID`),
  ADD KEY `fk_encoders_user` (`usersID`),
  ADD KEY `fk_encoders_addmoney` (`encoderAddmoneyID`),
  ADD KEY `fk_encoders_addexpenses` (`encoderAddexpensesID`);

--
-- Indexes for table `encoder_transactions`
--
ALTER TABLE `encoder_transactions`
  ADD PRIMARY KEY (`encoderTransactionsID`),
  ADD KEY `fk_enc_transaction_user` (`usersID`),
  ADD KEY `fk_enc_transaction_addmoney` (`encoderAddmoneyID`),
  ADD KEY `fk_enc_transaction_addexpenses` (`encoderAddexpensesID`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treasureraddexpenses`
--
ALTER TABLE `treasureraddexpenses`
  ADD PRIMARY KEY (`treasurerAddexpensesID`);

--
-- Indexes for table `treasureraddmoney`
--
ALTER TABLE `treasureraddmoney`
  ADD PRIMARY KEY (`treasurerAddmoneyID`);

--
-- Indexes for table `treasurerquickacts`
--
ALTER TABLE `treasurerquickacts`
  ADD PRIMARY KEY (`treasurerQuickactsID`),
  ADD KEY `fk_quickacts_addmoney` (`encoderAddmoneyID`),
  ADD KEY `fk_quickacts_addexpenses` (`encoderAddexpensesID`);

--
-- Indexes for table `treasurerreports`
--
ALTER TABLE `treasurerreports`
  ADD PRIMARY KEY (`treasurerReportsID`),
  ADD KEY `fk_reports_transaction` (`treasurerTransactionsID`);

--
-- Indexes for table `treasurers`
--
ALTER TABLE `treasurers`
  ADD PRIMARY KEY (`treasurersID`),
  ADD KEY `fk_treasurers_user` (`usersID`),
  ADD KEY `fk_treasurers_dashboard` (`treasurerDashboardID`),
  ADD KEY `fk_treasurers_quickacts` (`treasurerQuickactsID`),
  ADD KEY `fk_treasurers_addexpenses` (`treasurerAddexpensesID`),
  ADD KEY `fk_treasurers_addmoney` (`treasurerAddmoneyID`);

--
-- Indexes for table `treasurer_dashboard`
--
ALTER TABLE `treasurer_dashboard`
  ADD PRIMARY KEY (`treasurerDashboardID`),
  ADD UNIQUE KEY `treasurer_dashboard_usersID_unique` (`usersID`);

--
-- Indexes for table `treasurer_transactions`
--
ALTER TABLE `treasurer_transactions`
  ADD PRIMARY KEY (`treasurerTransactionsID`),
  ADD KEY `fk_transaction_user` (`usersID`),
  ADD KEY `fk_transaction_addmoney` (`treasurerAddmoneyID`),
  ADD KEY `fk_transaction_addexpenses` (`treasurerAddexpensesID`),
  ADD KEY `fk_transaction_approved_by` (`approved_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `encoderaddexpenses`
--
ALTER TABLE `encoderaddexpenses`
  MODIFY `encoderAddexpensesID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encoderaddmoney`
--
ALTER TABLE `encoderaddmoney`
  MODIFY `encoderAddmoneyID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encoders`
--
ALTER TABLE `encoders`
  MODIFY `encodersID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encoder_transactions`
--
ALTER TABLE `encoder_transactions`
  MODIFY `encoderTransactionsID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `treasureraddexpenses`
--
ALTER TABLE `treasureraddexpenses`
  MODIFY `treasurerAddexpensesID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treasureraddmoney`
--
ALTER TABLE `treasureraddmoney`
  MODIFY `treasurerAddmoneyID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treasurerquickacts`
--
ALTER TABLE `treasurerquickacts`
  MODIFY `treasurerQuickactsID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treasurerreports`
--
ALTER TABLE `treasurerreports`
  MODIFY `treasurerReportsID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treasurers`
--
ALTER TABLE `treasurers`
  MODIFY `treasurersID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `treasurer_dashboard`
--
ALTER TABLE `treasurer_dashboard`
  MODIFY `treasurerDashboardID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `treasurer_transactions`
--
ALTER TABLE `treasurer_transactions`
  MODIFY `treasurerTransactionsID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `encoders`
--
ALTER TABLE `encoders`
  ADD CONSTRAINT `fk_encoders_addexpenses` FOREIGN KEY (`encoderAddexpensesID`) REFERENCES `encoderaddexpenses` (`encoderAddexpensesID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_encoders_addmoney` FOREIGN KEY (`encoderAddmoneyID`) REFERENCES `encoderaddmoney` (`encoderAddmoneyID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_encoders_user` FOREIGN KEY (`usersID`) REFERENCES `users` (`usersID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `encoder_transactions`
--
ALTER TABLE `encoder_transactions`
  ADD CONSTRAINT `fk_enc_transaction_addexpenses` FOREIGN KEY (`encoderAddexpensesID`) REFERENCES `encoderaddexpenses` (`encoderAddexpensesID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enc_transaction_addmoney` FOREIGN KEY (`encoderAddmoneyID`) REFERENCES `encoderaddmoney` (`encoderAddmoneyID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enc_transaction_user` FOREIGN KEY (`usersID`) REFERENCES `users` (`usersID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `treasurerquickacts`
--
ALTER TABLE `treasurerquickacts`
  ADD CONSTRAINT `fk_quickacts_addexpenses` FOREIGN KEY (`encoderAddexpensesID`) REFERENCES `encoderaddexpenses` (`encoderAddexpensesID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_quickacts_addmoney` FOREIGN KEY (`encoderAddmoneyID`) REFERENCES `encoderaddmoney` (`encoderAddmoneyID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `treasurerreports`
--
ALTER TABLE `treasurerreports`
  ADD CONSTRAINT `fk_reports_transaction` FOREIGN KEY (`treasurerTransactionsID`) REFERENCES `treasurer_transactions` (`treasurerTransactionsID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `treasurers`
--
ALTER TABLE `treasurers`
  ADD CONSTRAINT `fk_treasurers_addexpenses` FOREIGN KEY (`treasurerAddexpensesID`) REFERENCES `treasureraddexpenses` (`treasurerAddexpensesID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_treasurers_addmoney` FOREIGN KEY (`treasurerAddmoneyID`) REFERENCES `treasureraddmoney` (`treasurerAddmoneyID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_treasurers_dashboard` FOREIGN KEY (`treasurerDashboardID`) REFERENCES `treasurer_dashboard` (`treasurerDashboardID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_treasurers_quickacts` FOREIGN KEY (`treasurerQuickactsID`) REFERENCES `treasurerquickacts` (`treasurerQuickactsID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_treasurers_user` FOREIGN KEY (`usersID`) REFERENCES `users` (`usersID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `treasurer_dashboard`
--
ALTER TABLE `treasurer_dashboard`
  ADD CONSTRAINT `fk_dashboard_user` FOREIGN KEY (`usersID`) REFERENCES `users` (`usersID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `treasurer_transactions`
--
ALTER TABLE `treasurer_transactions`
  ADD CONSTRAINT `fk_transaction_addexpenses` FOREIGN KEY (`treasurerAddexpensesID`) REFERENCES `treasureraddexpenses` (`treasurerAddexpensesID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaction_addmoney` FOREIGN KEY (`treasurerAddmoneyID`) REFERENCES `treasureraddmoney` (`treasurerAddmoneyID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaction_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`usersID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaction_user` FOREIGN KEY (`usersID`) REFERENCES `users` (`usersID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
