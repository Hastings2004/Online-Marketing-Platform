-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 12:35 PM
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
-- Database: `online_marketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `user_id`) VALUES
(3, 1),
(1, 2),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `merchant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`merchant_id`, `user_id`, `business_name`) VALUES
(1, 3, 'selling clothes'),
(4, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_created` text NOT NULL,
  `created_time` date NOT NULL DEFAULT current_timestamp(),
  `is_read` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message_created`, `created_time`, `is_read`) VALUES
(1, 1, 'You have new application from Shad', '2024-12-28', 1),
(2, 4, 'Welcome shadreck', '2024-12-28', 1),
(3, 3, 'You have new order from Allan', '2024-12-28', 1),
(4, 3, 'You have new order from Shad', '2024-12-29', 1),
(5, 3, 'You have new order from Allan', '2024-12-29', 1),
(6, 3, 'You have new order from Shad', '2024-12-29', 1),
(7, 3, 'You have new order from Shad', '2024-12-29', 1),
(8, 2, 'good night Allan', '2024-12-29', 1),
(9, 3, 'You have new order from Allan', '2024-12-29', 1),
(10, 2, 'your oders successfully processed', '2024-12-30', 1),
(11, 2, 'your oders successfully processed', '2024-12-30', 1),
(12, 3, 'You have new order from Allan', '2024-12-31', 1),
(13, 2, 'your oders successfully processed', '2024-12-31', 1),
(14, 1, 'i want to sell my product', '2024-12-31', 1),
(15, 3, 'You have new order from Shad', '2025-01-01', 1),
(16, 3, 'You have new order from Shad', '2025-01-01', 1),
(17, 3, 'You have new order from Shad', '2025-01-01', 1),
(18, 3, 'You have new order from Shad', '2025-01-01', 1),
(19, 3, 'You have new order from Hastings', '2025-01-01', 1),
(20, 3, 'You have new order from Hastings', '2025-01-01', 1),
(21, 5, 'You have new order from Shad', '2025-01-02', 1),
(22, 4, 'your oders successfully processed wait for approval', '2025-01-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `order_status` varchar(20) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `total_amount`, `order_status`, `created_at`) VALUES
(1, 2, 1500000, 'pending', '2024-12-29'),
(2, 2, 1500000, 'pending', '2024-12-29'),
(3, 2, 1500000, 'pending', '2024-12-29'),
(4, 2, 10000, 'pending', '2024-12-29'),
(5, 1, 310000, 'pending', '2024-12-29'),
(6, 1, 310000, 'pending', '2024-12-31'),
(7, 2, 300000, 'pending', '2025-01-01'),
(8, 2, 610000, 'pending', '2025-01-01'),
(9, 2, 20000, 'pending', '2025-01-01'),
(10, 2, 1900000, 'pending', '2025-01-01'),
(11, 3, 300000, 'pending', '2025-01-01'),
(12, 3, 1030000, 'pending', '2025-01-01'),
(13, 2, 600000, 'pending', '2025-01-02');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `product_price`, `total_price`) VALUES
(1, 1, 6, 1, 1200000, 1500000),
(2, 1, 3, 1, 300000, 1500000),
(3, 6, 7, 1, 10000, 10000),
(4, 6, 3, 1, 300000, 310000),
(5, 6, 7, 1, 10000, 310000),
(6, 6, 7, 1, 10000, 310000),
(7, 6, 3, 1, 300000, 310000),
(8, 11, 11, 1, 300000, 300000),
(9, 0, 11, 2, 300000, 610000),
(10, 0, 7, 1, 10000, 610000),
(11, 9, 8, 1, 20000, 20000),
(12, 10, 6, 1, 1200000, 1900000),
(13, 10, 11, 1, 300000, 1900000),
(14, 10, 5, 2, 200000, 1900000),
(15, 11, 11, 1, 300000, 300000),
(16, 12, 3, 3, 300000, 1030000),
(17, 12, 10, 5, 20000, 1030000),
(18, 12, 7, 3, 10000, 1030000),
(19, 13, 11, 2, 300000, 600000);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `paymemt_amount` float NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` float NOT NULL,
  `category` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `merchant_id`, `product_name`, `product_description`, `product_price`, `category`, `image_url`) VALUES
(3, 1, 'Redimi', 'redimi is new morden phone ', 300000, 'phones', 'Redimi.jpg'),
(4, 1, 'Iphone 14', 'Iphone is new morden phone ', 1000000, 'phones', 'Iphone 14.jpg'),
(5, 1, 'Techno POP', 'techno pop 7', 200000, 'phone', 'Techno POP.jpg'),
(6, 3, 'HP laptop', 'Modern HP ', 1200000, 'electronic device', 'HP laptop.jpg'),
(7, 1, 'Descent Trouser', 'Descent Trouser', 10000, 'Clothes', 'Descent Trouser.jpg'),
(8, 1, 'Women Dress', 'Modern women dresses', 20000, 'clothes', 'Women Dress.jpg'),
(10, 1, 'Men trouser', 'Modern men trousers', 20000, 'electronic', 'Men trouser.jpg'),
(11, 4, 'Itel A45', 'New itels smart phone ', 300000, 'electronic', 'Itel A45.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'customer'),
(2, 'admin'),
(3, 'merchant');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `shopping_cart` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `is_placed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`shopping_cart`, `customer_id`, `product_id`, `quantity_sold`, `product_price`, `is_placed`) VALUES
(9, 1, 5, 4, 200000, 1),
(14, 2, 3, 1, 300000, 1),
(17, 1, 3, 1, 300000, 1),
(18, 1, 3, 1, 300000, 1),
(25, 2, 6, 1, 1200000, 1),
(26, 2, 3, 1, 300000, 1),
(27, 2, 7, 1, 10000, 1),
(28, 1, 7, 1, 10000, 1),
(31, 1, 7, 1, 10000, 1),
(32, 1, 3, 1, 300000, 1),
(33, 2, 11, 1, 300000, 1),
(35, 2, 11, 2, 300000, 1),
(36, 2, 7, 1, 10000, 1),
(37, 2, 8, 1, 20000, 1),
(38, 2, 6, 1, 1200000, 1),
(39, 2, 11, 1, 300000, 1),
(40, 2, 5, 2, 200000, 1),
(41, 3, 11, 1, 300000, 1),
(42, 3, 3, 3, 300000, 1),
(43, 3, 10, 5, 20000, 1),
(44, 3, 7, 3, 10000, 1),
(45, 2, 11, 2, 300000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `user_password` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `user_email`, `username`, `user_password`) VALUES
(1, 'Hastings', 'Chitenje', 'hastingschitenje81@gmail.com', 'Hastings2004', '$2y$10$XEeOv.F/eR0l5/nZ/rAVD.iUcXwP7t3HGYa23KnCEHmTt/yFmy71i'),
(2, 'Allan', 'Moyo', 'moyo@gmail.com', 'Allan28', '$2y$10$hZLFWFnItsxANHzD61OSCeHpsYtHVJG6eT8tU6Ra6bRm1jXtB.fZe'),
(3, 'Charity', 'Chunga', 'chungacharity0@gmail.com', 'charity25', '$2y$10$t7pEzKtAUJxNwS3oXotoj.kNKZzDVRkGZ0ORpwgiUcPaCq0V0oUqu'),
(4, 'Shad', 'Chitenje', 'shad@gmail.com', 'Shad08', '$2y$10$4Mb9AHxcb9iEf0wbYtCkl.wlwknt9KADv9ROb7bqTT4TeKVQsBP6W'),
(5, 'Junior', 'Chitenje', 'ju@gmail.com', 'Ju2024', '$2y$10$ymbqrZMHvjcXo70A9.eGDeqned.da.VOOQG0dfhFfM3RSpGI75fx6');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `initial` varchar(4) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `marital_status` varchar(10) NOT NULL,
  `title` varchar(20) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `passport` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`profile_id`, `user_id`, `initial`, `gender`, `nationality`, `marital_status`, `title`, `phone_number`, `national_id`, `passport`) VALUES
(1, 1, 'HC', 'Male', 'Malawi', 'Single', 'Mr', '0884371527', '009GQSME', 'NO'),
(2, 2, 'AM', 'Male', 'Malawi', 'Single', 'MR', '0983128580', 'NO', 'NO'),
(3, 4, 'SC', 'Male', 'Malawi', 'Single', 'MR', '0983128580', 'NO', 'NO'),
(4, 5, 'JC', 'Male', 'Malawi', 'Single', 'MR', '0983128580', 'ju', '009GQSME');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_role_id`, `user_id`, `role_id`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 3),
(4, 4, 1),
(5, 1, 1),
(6, 5, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`merchant_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`shopping_cart`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_role_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `merchant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `shopping_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `merchants`
--
ALTER TABLE `merchants`
  ADD CONSTRAINT `merchants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
