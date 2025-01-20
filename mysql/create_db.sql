-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 10:19 PM
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
-- Database: `shortenurl`
--

-- --------------------------------------------------------

--
-- Table structure for table `expiration_type`
--

CREATE TABLE `expiration_type` (
                                   `days_amount` smallint(6) NOT NULL,
                                   `display_text` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expiration_type`
--

INSERT INTO `expiration_type` (`days_amount`, `display_text`) VALUES
                                                                  (0, 'Never'),
                                                                  (1, '1'),
                                                                  (5, '5'),
                                                                  (10, '10'),
                                                                  (30, '30');

-- --------------------------------------------------------

--
-- Table structure for table `redirect_url`
--

CREATE TABLE `redirect_url` (
                                `pk_redirect_url_id` bigint(30) NOT NULL,
                                `original_url` varchar(2048) NOT NULL,
                                `expiration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `redirect_url_category`
--

CREATE TABLE `redirect_url_category` (
                                         `pk_redirect_url_category_id` int(11) NOT NULL,
                                         `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redirect_url_category`
--

INSERT INTO `redirect_url_category` (`pk_redirect_url_category_id`, `name`) VALUES
                                                                                (1, 'None'),
                                                                                (5, 'Other'),
                                                                                (2, 'Todo'),
                                                                                (3, 'Entertainment'),
                                                                                (4, 'News'),
                                                                                (6, 'School'),
                                                                                (7, 'Work');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
                        `pk_user_id` bigint(20) NOT NULL,
                        `login_id` varchar(50) NOT NULL,
                        `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_redirect_url`
--

CREATE TABLE `user_redirect_url` (
                                     `fk_user_id` bigint(20) NOT NULL,
                                     `fk_redirect_url_id` bigint(20) NOT NULL,
                                     `num_visits` bigint(20) NOT NULL DEFAULT 0,
                                     `fk_redirect_url_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expiration_type`
--
ALTER TABLE `expiration_type`
    ADD PRIMARY KEY (`days_amount`);

--
-- Indexes for table `redirect_url`
--
ALTER TABLE `redirect_url`
    ADD PRIMARY KEY (`pk_redirect_url_id`) USING BTREE;

--
-- Indexes for table `redirect_url_category`
--
ALTER TABLE `redirect_url_category`
    ADD PRIMARY KEY (`pk_redirect_url_category_id`),
    ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`pk_user_id`);

--
-- Indexes for table `user_redirect_url`
--
ALTER TABLE `user_redirect_url`
    ADD PRIMARY KEY (`fk_user_id`,`fk_redirect_url_id`),
    ADD KEY `fk_redirect_url_id` (`fk_redirect_url_id`),
    ADD KEY `fk_redirect_url_category_id` (`fk_redirect_url_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `redirect_url`
--
ALTER TABLE `redirect_url`
    MODIFY `pk_redirect_url_id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `redirect_url_category`
--
ALTER TABLE `redirect_url_category`
    MODIFY `pk_redirect_url_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `pk_user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_redirect_url`
--
ALTER TABLE `user_redirect_url`
    ADD CONSTRAINT `user_redirect_url_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `user` (`pk_user_id`),
    ADD CONSTRAINT `user_redirect_url_ibfk_2` FOREIGN KEY (`fk_redirect_url_id`) REFERENCES `redirect_url` (`pk_redirect_url_id`),
    ADD CONSTRAINT `user_redirect_url_ibfk_3` FOREIGN KEY (`fk_redirect_url_category_id`) REFERENCES `redirect_url_category` (`pk_redirect_url_category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;