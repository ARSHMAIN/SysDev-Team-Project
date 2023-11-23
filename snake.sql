-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 23, 2023 at 06:46 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(255) NOT NULL DEFAULT 1,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int(255) NOT NULL,
  `cart_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `donation_id` int(255) DEFAULT NULL,
  `test_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customersnakename`
--

CREATE TABLE `customersnakename` (
  `customer_snake_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `snake_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donation_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `order_id` int(255) NOT NULL,
  `snake_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knownpossiblemorph`
--

CREATE TABLE `knownpossiblemorph` (
  `snake_id` int(255) NOT NULL,
  `morph_id` int(255) NOT NULL,
  `is_known` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `morph`
--

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

CREATE TABLE `order` (
  `order_id` int(255) NOT NULL,
  `payment_status` tinyint(4) NOT NULL,
  `seen_status` tinyint(1) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` double NOT NULL,
  `user_id` int(255) NOT NULL,
  `order_status_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `order_status_id` int(255) NOT NULL,
  `order_status_name` enum('Processing','To be Processed','Unpaid','Results Pending','Completed') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

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

CREATE TABLE `snake` (
  `snake_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `sex_id` int(255) NOT NULL,
  `snake_origin` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(255) NOT NULL,
  `snake_id` int(255) NOT NULL,
  `order_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testedmorph`
--

CREATE TABLE `testedmorph` (
  `test_id` int(255) NOT NULL,
  `morph_id` int(255) NOT NULL,
  `result` varchar(16) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `result_image_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

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
(1, 'Arsh', 'Singh', 'arshsingh@gmail.com', '1234', '450-000-0000', NULL, '2023-11-15 01:49:40', NULL, 3);

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
  ADD PRIMARY KEY (`user_id`,`cart_id`),
  ADD UNIQUE KEY `Cart_pk2` (`cart_id`);

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
ALTER TABLE `knownpossiblemorph`
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
  ADD KEY `Test_snake_snake_id_fk` (`snake_id`),
  ADD KEY `Test_user_user_id_fk` (`user_id`);

--
-- Indexes for table `testedmorph`
--
ALTER TABLE `testedmorph`
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
  MODIFY `address_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customersnakename`
--
ALTER TABLE `customersnakename`
  MODIFY `customer_snake_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donation_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `morph`
--
ALTER TABLE `morph`
  MODIFY `morph_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `order_status_id` int(255) NOT NULL AUTO_INCREMENT;

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
  MODIFY `snake_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
ALTER TABLE `knownpossiblemorph`
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
  ADD CONSTRAINT `Test_snake_snake_id_fk` FOREIGN KEY (`snake_id`) REFERENCES `snake` (`snake_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Test_user_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `testedmorph`
--
ALTER TABLE `testedmorph`
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
