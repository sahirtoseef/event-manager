-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2019 at 10:32 PM
-- Server version: 5.7.27-0ubuntu0.16.04.1
-- PHP Version: 7.1.30-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `venue_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `venue_name`, `user_id`, `start_date`, `end_date`, `description`, `event_avatar`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Bonnaroo', 'Bonnaroo', 3, '2019/25/6 16:I', '2019/25/6 16:I', 'Test', '', '2019-09-26 06:25:59', '2019-09-26 12:27:38', 1),
(2, 'Football World Cup', 'Football World Cup', 3, '2019-06-20 00:00', '2019-06-20 00:00', 'This is Football World Cup.', '', '2019-09-26 12:28:27', '2019-09-26 12:28:27', 1),
(3, '24 Hours of Le Mans', '24 Hours of Le Mans', 3, '2019-06-20 00:00', '2019-06-20 00:00', 'This is 24 Hours of Le Mans', '', '2019-09-26 12:28:51', '2019-09-26 12:28:51', 1),
(4, 'Inti Raymi', 'Inti Raymi', 3, '2019-06-20 00:00', '2019-06-20 00:00', 'This is Inti Raymi', '', '2019-09-26 12:29:14', '2019-09-26 12:29:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_09_23_075523_create_roles_table', 1),
(4, '2019_09_23_123642_add_avatar_to_users', 2),
(5, '2019_09_24_072502_add_phone_address_to_users', 2),
(6, '2019_09_24_120549_create_events_table', 2),
(7, '2019_09_24_130703_create_user_events_table', 2),
(8, '2019_09_26_053706_visitor', 2),
(9, '2019_09_25_150742_add_status_to_user', 3),
(10, '2019_09_26_065355_add_status_to_events', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2019-09-16 19:00:00', '2019-09-27 19:00:00'),
(2, 'manager', '2019-09-04 19:00:00', '2019-09-12 19:00:00'),
(3, 'client', '2019-09-25 19:00:00', '2019-09-27 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`, `avatar`, `phone`, `address`, `status`) VALUES
(1, 'ashtex', 'admin@admin.com', NULL, '$2y$10$305gh0TcZZHxjSH27Gp76ue2ea7uM/JquNt6yKSlLORkONPwx8k0m', 1, '0V8TccSgxo7zHKQHCRd59Ptr6DSPZiAcrjMFwSlwoxsPXhbwZNOT0j9CulvI', '2019-09-23 03:55:48', '2019-09-23 03:55:48', '', 'N/A', 'N/A', 1),
(2, 'ashtex', 'ashtexmanager@gmail.com', NULL, '$2y$10$ilE3XVglOXQY8IBlm91ef.PuU1DIxqAn762TZMnf7nc6dsGdCmwzm', 2, 'xLHtgzB7mEAaxfjuoNfEUKAZuRhT6kHsFQHzUVsN4x9LHje17isYUED6Msq0', '2019-09-23 04:26:45', '2019-09-23 04:26:45', '', 'N/A', 'N/A', 1),
(3, 'ashtex', 'ashtexclient@gmail.com', NULL, '$2y$10$/oEOMpfiYcJGeBrBDqrT6.XKhpxkDJEk2j5MMvvjpdnrZbVxVZlk6', 3, 'TGECKSRONotABdoIWTc4VRDGa3FPyvoxg1IPSK9ziIFlHgJ0Kj2xJg9F5yH8', '2019-09-23 04:27:22', '2019-09-23 04:27:22', '', 'N/A', 'N/A', 1),
(4, 'Altaf', 'altaf@gmail.com', NULL, '$2y$10$pWRmRobDndp9//b2dL17FOizxrmcgqZ/HvUUiOEYy5clEUAmkpyf2', 3, NULL, '2019-09-26 12:30:03', '2019-09-26 12:30:03', '', '123123123', 'garden town', 1),
(5, 'Sadaam', 'sadaam@gmail.com', NULL, '$2y$10$OXxbvAW1bIVwyHN1eBpaFer3WXTU/SzHR7JxF0EYcVrExFlykQRmq', 3, NULL, '2019-09-26 12:30:41', '2019-09-26 12:30:41', '', '12312313', 'Karachi', 1),
(6, 'Waqas', 'waqas@gamil.com', NULL, '$2y$10$HiqUM9K.gJhtNnGOKnDu7.0JUiNmG8BvVTDn1d5yOIsXsmpwNti.u', 2, NULL, '2019-09-26 12:31:17', '2019-09-26 12:31:17', '', '123123123', 'Gujranawala', 1),
(7, 'Awais', 'awais@gmail.com', NULL, '$2y$10$0ikjM6.lLh6q1Fih26a0b.Bhf4G919hkqTtz8YKJpXAlqicnS1th.', 2, NULL, '2019-09-26 12:31:38', '2019-09-26 12:31:38', '', '123123123', 'Islamabad', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_events`
--

CREATE TABLE `user_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_events`
--

INSERT INTO `user_events` (`id`, `event_id`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 1, 2, '2019-09-26 12:27:38', '2019-09-26 12:27:38'),
(3, 2, 2, '2019-09-26 12:28:27', '2019-09-26 12:28:27'),
(4, 3, 2, '2019-09-26 12:28:52', '2019-09-26 12:28:52'),
(5, 4, 2, '2019-09-26 12:29:14', '2019-09-26 12:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attendee_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed_registration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_and_conditions_accepted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `directory_opt_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `directory_opt_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kliks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_connections` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkin_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wearable_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wearable_rf_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `manager_id`, `event_id`, `display_name`, `first_name`, `last_name`, `email`, `password`, `attendee_type`, `occupation`, `company`, `phone`, `mobile_phone`, `photo`, `tags`, `language`, `location`, `city`, `state`, `country`, `completed_registration`, `checked_in`, `terms_and_conditions_accepted`, `directory_opt_in`, `directory_opt_out`, `score`, `kliks`, `number_of_connections`, `registration_status`, `checkin_time`, `login_link`, `wearable_id`, `wearable_rf_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Sahir', 'Sahir', 'Toseef', 'sahir@gmail.com', 'asdasdasd', 'guest', 'developer', 'Ashtex', '123', '1234', '', 'tags', 'english', 'garden town', 'lahore', 'Punjab', 'Pakistan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-26 03:24:01', '2019-09-26 12:20:04'),
(2, 2, 2, 'Kashif', 'Kashif', 'Ali', 'kashif@gmail.com', 'asdasdasd', 'guest', 'Accountant', 'HBL Bank', '12312313', '1231321321', '', 'tags', 'Urdu', 'garden town', 'lahore', 'Punjab', 'Pakistan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-26 04:25:38', '2019-09-26 12:32:04'),
(7, 2, 1, 'Hassan', 'Hassan', 'Shahbaz', 'hassan@gmail.com', 'asdasdasd', 'Golden', 'developer', 'Ashtex', '12312313', '1231321321', '', 'tags', 'english', 'garden town', 'lahore', 'Punjab', 'Pakistan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-26 12:23:43', '2019-09-26 12:23:43'),
(8, 2, 3, 'Mustafa', 'Mustafa', 'Kamal', 'mustafa@gmail.com', 'asdasdasd', 'Premium', 'Sales man', 'Nestle', '12312313', '1231321321', '', 'tags', 'english', 'Lahore', 'lahore', 'Punjab', 'Pakistan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-26 12:25:15', '2019-09-26 12:32:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_events`
--
ALTER TABLE `user_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visitors_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_events`
--
ALTER TABLE `user_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
