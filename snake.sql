-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 23, 2023 at 06:05 AM
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
-- Database: `snake`
--
CREATE DATABASE IF NOT EXISTS `snake` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `snake`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `address_id` int(255) NOT NULL,
  `street_number` varchar(20) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `city` varchar(64) NOT NULL,
  `state_or_region` varchar(64) DEFAULT NULL,
  `postal_code` varchar(16) NOT NULL,
  `country` varchar(64) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `street_number`, `street_name`, `city`, `state_or_region`, `postal_code`, `country`, `user_id`) VALUES
(1, '789', 'Maple Street', 'Toronto', 'ON', 'M5V 2Y1', 'Canada', 1),
(2, '456', 'Birch Avenue', 'Vancouver', 'BC', 'V6C 2R7', 'Canada', 2),
(3, '321', 'Pine Road', 'Montreal', 'QC', 'H2Y 1Z9', 'Canada', 3),
(4, '555', 'Cedar Lane', 'Calgary', 'AB', 'T2P 1H7', 'Canada', 4),
(5, '999', 'Oak Drive', 'Ottawa', 'ON', 'K1P 5H9', 'Canada', 5);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `cart_id` int(255) NOT NULL DEFAULT 1,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

DROP TABLE IF EXISTS `cart_item`;
CREATE TABLE `cart_item` (
  `cart_item_id` int(255) NOT NULL,
  `cart_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `donation_id` int(255) DEFAULT NULL,
  `test_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `user_id`, `donation_id`, `test_id`) VALUES
(6, 1, 1, NULL, 6),
(7, 1, 1, NULL, 7),
(8, 1, 1, NULL, 8),
(9, 1, 1, NULL, 9),
(10, 1, 1, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `customersnakename`
--

DROP TABLE IF EXISTS `customersnakename`;
CREATE TABLE `customersnakename` (
  `customer_snake_id` varchar(256) NOT NULL,
  `user_id` int(255) NOT NULL,
  `snake_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customersnakename`
--

INSERT INTO `customersnakename` (`customer_snake_id`, `user_id`, `snake_id`) VALUES
('Serpentia', 1, 1),
('Slitherscale', 1, 2),
('Venomstrike', 1, 3),
('Coilcharm', 1, 4),
('Fangtail', 1, 5),
('Vipernox', 1, 6),
('Hisscoil', 1, 7),
('Shadowserpent', 1, 8),
('Twiststrike', 1, 9),
('Silverslink', 1, 10),
('Pythonic', 1, 11),
('Cobratic', 1, 12),
('Viperic', 1, 13),
('Boatic', 1, 14),
('Fangtastic', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

DROP TABLE IF EXISTS `donation`;
CREATE TABLE `donation` (
  `donation_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `order_id` int(255) DEFAULT NULL,
  `snake_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `user_id`, `order_id`, `snake_id`) VALUES
(1, 1, 5, 6),
(2, 1, 5, 7),
(3, 1, 5, 8),
(4, 1, 5, 9),
(5, 1, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `knownpossiblemorph`
--

DROP TABLE IF EXISTS known_possible_morph;
CREATE TABLE `knownpossiblemorph` (
  `snake_id` int(255) NOT NULL,
  `morph_id` int(255) NOT NULL,
  `is_known` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knownpossiblemorph`
--

INSERT INTO known_possible_morph (`snake_id`, `morph_id`, `is_known`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 6, 0),
(1, 7, 0),
(2, 3, 1),
(2, 4, 1),
(2, 5, 0),
(2, 6, 0),
(3, 1, 1),
(3, 2, 1),
(3, 6, 0),
(3, 9, 0),
(4, 1, 1),
(4, 2, 1),
(4, 3, 0),
(4, 4, 0),
(5, 2, 1),
(5, 3, 1),
(5, 4, 1),
(5, 7, 0),
(5, 9, 0),
(11, 1, 0),
(11, 2, 0),
(11, 3, 1),
(11, 6, 1),
(12, 1, 1),
(12, 2, 1),
(12, 4, 0),
(12, 10, 0),
(13, 1, 1),
(13, 2, 1),
(13, 4, 0),
(13, 10, 0),
(14, 1, 1),
(14, 4, 1),
(14, 7, 0),
(14, 9, 0),
(15, 3, 0),
(15, 4, 1),
(15, 7, 1),
(15, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `morph`
--

DROP TABLE IF EXISTS `morph`;
CREATE TABLE `morph` (
  `morph_id` int(255) NOT NULL,
  `morph_name` varchar(32) NOT NULL,
  `is_tested` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `morph`
--

INSERT INTO `morph` (`morph_id`, `morph_name`, `is_tested`) VALUES
(1, 'Acid', 0),
(2, 'Albino', 0),
(3, 'Champagne', 1),
(4, 'Chocolate', 1),
(5, 'Pastel', 0),
(6, 'Clown', 1),
(7, 'Butter', 1),
(8, 'Cinnamon', 1),
(9, 'Calico', 0),
(10, 'Mystic', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(255) NOT NULL,
  `payment_status` tinyint(4) NOT NULL,
  `seen_status` tinyint(1) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` double DEFAULT NULL,
  `user_id` int(255) NOT NULL,
  `order_status_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `payment_status`, `seen_status`, `order_date`, `total`, `user_id`, `order_status_id`) VALUES
(3, 0, 0, '2023-12-22 21:49:14', 100, 1, 3),
(4, 0, 0, '2023-12-23 04:49:10', 500, 1, 3),
(5, 0, 0, '2023-12-23 04:57:53', 0, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

DROP TABLE IF EXISTS `orderstatus`;
CREATE TABLE `orderstatus` (
  `order_status_id` int(255) NOT NULL,
  `order_status_name` enum('Processing','To be Processed','Unpaid','Results Pending','Completed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderstatus`
--

INSERT INTO `orderstatus` (`order_status_id`, `order_status_name`) VALUES
(1, 'Processing'),
(2, 'To be Processed'),
(3, 'Unpaid'),
(4, 'Results Pending'),
(5, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role_id` int(255) NOT NULL,
  `role_name` enum('Admin','Partner','User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Partner'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `sex`
--

DROP TABLE IF EXISTS `sex`;
CREATE TABLE `sex` (
  `sex_id` int(255) NOT NULL,
  `sex_name` enum('Male','Female','Unknown') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sex`
--

INSERT INTO `sex` (`sex_id`, `sex_name`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Unknown');

-- --------------------------------------------------------

--
-- Table structure for table `snake`
--

DROP TABLE IF EXISTS `snake`;
CREATE TABLE `snake` (
  `snake_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `sex_id` int(255) NOT NULL,
  `snake_origin` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `snake`
--

INSERT INTO `snake` (`snake_id`, `user_id`, `sex_id`, `snake_origin`) VALUES
(1, 1, 2, 'Canada'),
(2, 1, 3, 'Canada'),
(3, 1, 1, 'Canada'),
(4, 1, 3, 'Canada'),
(5, 1, 2, 'Canada'),
(6, 1, 3, 'Canada'),
(7, 1, 2, 'Canada'),
(8, 1, 1, 'Canada'),
(9, 1, 3, 'Canada'),
(10, 1, 1, 'Canada'),
(11, 1, 1, 'Canada'),
(12, 1, 3, 'Canada'),
(13, 1, 1, 'Canada'),
(14, 1, 3, 'Canada'),
(15, 1, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `test_id` int(255) NOT NULL,
  `snake_id` int(255) DEFAULT NULL,
  `order_id` int(255) DEFAULT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `snake_id`, `order_id`, `user_id`) VALUES
(1, 1, 4, 1),
(2, 2, 4, 1),
(3, 3, 4, 1),
(4, 4, 4, 1),
(5, 5, 4, 1),
(6, 11, NULL, 1),
(7, 12, NULL, 1),
(8, 13, NULL, 1),
(9, 14, NULL, 1),
(10, 15, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testedmorph`
--

DROP TABLE IF EXISTS tested_morph;
CREATE TABLE `testedmorph` (
  `test_id` int(255) NOT NULL,
  `morph_id` int(255) NOT NULL,
  `result` varchar(16) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `result_image_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testedmorph`
--

INSERT INTO tested_morph (`test_id`, `morph_id`, `result`, `comment`, `result_image_path`) VALUES
(1, 3, NULL, NULL, NULL),
(4, 3, NULL, NULL, NULL),
(7, 3, NULL, NULL, NULL),
(8, 3, NULL, NULL, NULL),
(9, 3, NULL, NULL, NULL),
(1, 4, NULL, NULL, NULL),
(4, 6, NULL, NULL, NULL),
(6, 6, NULL, NULL, NULL),
(8, 6, NULL, NULL, NULL),
(10, 6, NULL, NULL, NULL),
(2, 7, NULL, NULL, NULL),
(2, 8, NULL, NULL, NULL),
(3, 8, NULL, NULL, NULL),
(5, 8, NULL, NULL, NULL),
(7, 8, NULL, NULL, NULL),
(9, 8, NULL, NULL, NULL),
(3, 10, NULL, NULL, NULL),
(5, 10, NULL, NULL, NULL),
(6, 10, NULL, NULL, NULL),
(10, 10, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(255) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `phone_number` varchar(32) DEFAULT NULL,
  `company_name` varchar(32) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `role_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `company_name`, `registration_date`, `last_login`, `role_id`) VALUES
(1, 'Arsh', 'Singh', 'arshmain@gmail.com', 'e6d927b58c0b3d54caee6dc87b7f4922', '450-000-0000', NULL, '2023-11-15 01:49:40', NULL, 3),
(2, 'Logan', 'Luo', 'logan@gmail.com', 'e6d927b58c0b3d54caee6dc87b7f4922', '450-100-0000', NULL, '2023-11-28 00:24:44', NULL, 3),
(3, 'Megane', 'Kickouama', 'megane@gmail.com', '9126b5c3299e4a590ab7baf486494591', NULL, NULL, '2023-12-23 04:30:26', NULL, 3),
(4, 'Hong', 'Hien', 'hong@gmail.com', '88163c52fdb7520d2da5295dcb52bff0', NULL, NULL, '2023-12-23 04:31:24', NULL, 3),
(5, 'Alex', 'Steinheuser', 'alex@gmail.com', '534b44a19bf18d20b71ecc4eb77c572f', NULL, NULL, '2023-12-23 04:32:16', NULL, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `address_user_user_id_fk` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`cart_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_item_cart_cart_id_fk` (`cart_id`),
  ADD KEY `cart_item_cart_user_id_cart_id_fk` (`user_id`,`cart_id`),
  ADD KEY `cart_item_donation_donation_id_fk` (`donation_id`),
  ADD KEY `cart_item_test_test_id_fk` (`test_id`);

--
-- Indexes for table `customersnakename`
--
ALTER TABLE `customersnakename`
  ADD PRIMARY KEY (`customer_snake_id`,`user_id`),
  ADD KEY `CustomerSnakeName_user_user_id_fk` (`user_id`),
  ADD KEY `customersnakename_snake_snake_id_fk` (`snake_id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `Donation_order_order_id_fk` (`order_id`),
  ADD KEY `Donation_snake_snake_id_fk` (`snake_id`),
  ADD KEY `Donation_user_user_id_fk` (`user_id`);

--
-- Indexes for table `knownpossiblemorph`
--
ALTER TABLE known_possible_morph
  ADD PRIMARY KEY (`snake_id`,`morph_id`),
  ADD KEY `KnownPossibleMorph_morph_morph_id_fk` (`morph_id`);

--
-- Indexes for table `morph`
--
ALTER TABLE `morph`
  ADD PRIMARY KEY (`morph_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `Order_orderstatus_order_status_id_fk` (`order_status_id`),
  ADD KEY `Order_user_user_id_fk` (`user_id`);

--
-- Indexes for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sex`
--
ALTER TABLE `sex`
  ADD PRIMARY KEY (`sex_id`);

--
-- Indexes for table `snake`
--
ALTER TABLE `snake`
  ADD PRIMARY KEY (`snake_id`),
  ADD KEY `snake_sex_sex_id_fk` (`sex_id`),
  ADD KEY `snake_user_user_id_fk` (`user_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `Test_user_user_id_fk` (`user_id`),
  ADD KEY `test_snake_snake_id_fk` (`snake_id`);

--
-- Indexes for table `testedmorph`
--
ALTER TABLE tested_morph
  ADD PRIMARY KEY (`morph_id`,`test_id`),
  ADD KEY `TestedMorph_test_test_id_fk` (`test_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_pk` (`email`),
  ADD KEY `user_role_role_id_fk` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donation_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `morph`
--
ALTER TABLE `morph`
  MODIFY `morph_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `order_status_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sex`
--
ALTER TABLE `sex`
  MODIFY `sex_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `snake`
--
ALTER TABLE `snake`
  MODIFY `snake_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `Cart_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_cart_user_id_cart_id_fk` FOREIGN KEY (`user_id`,`cart_id`) REFERENCES `cart` (`user_id`, `cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_item_donation_donation_id_fk` FOREIGN KEY (`donation_id`) REFERENCES `donation` (`donation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_item_test_test_id_fk` FOREIGN KEY (`test_id`) REFERENCES `test` (`test_id`) ON DELETE CASCADE;

--
-- Constraints for table `customersnakename`
--
ALTER TABLE `customersnakename`
  ADD CONSTRAINT `CustomerSnakeName_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `customersnakename_snake_snake_id_fk` FOREIGN KEY (`snake_id`) REFERENCES `snake` (`snake_id`) ON DELETE CASCADE;

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `Donation_order_order_id_fk` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Donation_snake_snake_id_fk` FOREIGN KEY (`snake_id`) REFERENCES `snake` (`snake_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Donation_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `knownpossiblemorph`
--
ALTER TABLE known_possible_morph
  ADD CONSTRAINT `KnownPossibleMorph_morph_morph_id_fk` FOREIGN KEY (`morph_id`) REFERENCES `morph` (`morph_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `KnownPossibleMorph_snake_snake_id_fk` FOREIGN KEY (`snake_id`) REFERENCES `snake` (`snake_id`) ON DELETE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `Order_orderstatus_order_status_id_fk` FOREIGN KEY (`order_status_id`) REFERENCES `orderstatus` (`order_status_id`),
  ADD CONSTRAINT `Order_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `snake`
--
ALTER TABLE `snake`
  ADD CONSTRAINT `snake_sex_sex_id_fk` FOREIGN KEY (`sex_id`) REFERENCES `sex` (`sex_id`),
  ADD CONSTRAINT `snake_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `Test_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_snake_snake_id_fk` FOREIGN KEY (`snake_id`) REFERENCES `snake` (`snake_id`) ON DELETE CASCADE;

--
-- Constraints for table `testedmorph`
--
ALTER TABLE tested_morph
  ADD CONSTRAINT `TestedMorph_morph_morph_id_fk` FOREIGN KEY (`morph_id`) REFERENCES `morph` (`morph_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `TestedMorph_test_test_id_fk` FOREIGN KEY (`test_id`) REFERENCES `test` (`test_id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
