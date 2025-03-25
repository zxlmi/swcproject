-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2025 at 11:07 AM
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
-- Database: `opos`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(30) NOT NULL,
  `client_ip` varchar(20) NOT NULL,
  `user_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`) VALUES
(1, 'Thin Crust Pizza'),
(2, 'Thick Crust Pizza'),
(3, 'Sicilian Pizza'),
(4, 'Beverage');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `mobile` text NOT NULL,
  `email` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(30) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `address`, `mobile`, `email`, `status`, `order_date`, `user_id`, `total_amount`) VALUES
(2, 'hi hi', 'hi', 'hi', 'hi@gmail.com', 1, '2025-03-07 23:24:22', 0, 0.00),
(3, 'Zul', '123 Pizza Street', '0123456789', 'Zul@example.com', 1, '2025-03-07 23:24:22', 0, 0.00),
(10, 'hi hi', 'hi', 'hi', 'hi@gmail.com', 0, '2025-03-08 09:30:12', 2, 0.00),
(11, 'hi hi', 'hi', 'hi', 'hi@gmail.com', 0, '2025-03-08 09:30:29', 2, 0.00),
(12, 'hi hi', 'hi', 'hi', 'hi@gmail.com', 0, '2025-03-08 09:45:24', 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `product_id`, `qty`) VALUES
(1, 1, 2, 2),
(2, 2, 1, 1),
(3, 4, 1, 1),
(4, 5, 1, 1),
(5, 6, 1, 1),
(6, 7, 1, 1),
(7, 8, 1, 1),
(8, 9, 4, 1),
(9, 10, 3, 1),
(10, 11, 1, 1),
(11, 12, 5, 1),
(12, 12, 3, 1),
(13, 12, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `img_path` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0= unavailable, 2 Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `name`, `description`, `price`, `img_path`, `status`) VALUES
(1, 3, 'New Pizza Name', 'Updated description', 20.99, '1676512620_Sicilian.jpg', 1),
(2, 1, 'Pepperoni Thin', 'Pepperoni thin-crust', 380, '1676512800_thin-pepperoni.png', 1),
(3, 2, 'Detroit Style', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent suscipit porttitor dui, a accumsan metus molestie vel. Quisque luctus eros interdum, facilisis lectus at, aliquam lacus.', 360, '1676512980_detroit-style-thick.jpg', 1),
(4, 4, 'new Pizza', 'a pizza', 111, '1681114260_klara-kulikova-jvWZYnxBDlQ-unsplash.jpg', 1),
(5, 3, 'pizza sic', 'pizza', 123, '1681114320_fernando-andrade-_P76trHTWDE-unsplash.jpg', 1),
(6, 0, 'Pepperoni Pizza', 'Classic pizza with spicy pepperoni and cheese.', 200, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Online Pizza Ordering System', 'info@abcpizaa.com', '0912654789', '1234.jpg', '&lt;h1 style=&quot;margin-bottom: 0px; padding: 0px; line-height: 90px; color: rgb(0, 0, 0); text-align: center; font-size: 70px; font-family: DauphinPlain;&quot;&gt;About Us&lt;/h1&gt;&lt;h4 style=&quot;margin: 10px 10px 5px; padding: 0px; font-size: 14px; line-height: 18px; text-align: center; font-style: italic; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif;&quot;&gt;&quot;Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...&quot;&lt;/h4&gt;&lt;h5 style=&quot;margin: 5px 10px 20px; padding: 0px; font-size: 12px; line-height: 14px; text-align: center; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif;&quot;&gt;&quot;There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...&quot;&lt;/h5&gt;&lt;hr style=&quot;margin: 0px; padding: 0px; clear: both; border-top: 0px; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0)); color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: center;&quot;&gt;&lt;p id=&quot;Content&quot; style=&quot;margin-bottom: 0px; padding: 0px; position: relative; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: center;&quot;&gt;&lt;p class=&quot;boxed&quot; style=&quot;margin: 10px 28.7969px; padding: 0px; clear: both;&quot;&gt;&lt;p id=&quot;lipsum&quot; style=&quot;margin-bottom: 0px; padding: 0px; text-align: justify;&quot;&gt;&lt;p style=&quot;margin-bottom: 15px; padding: 0px;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent suscipit porttitor dui, a accumsan metus molestie vel. Quisque luctus eros interdum, facilisis lectus at, aliquam lacus. Etiam blandit lectus imperdiet nisi finibus posuere. Quisque in dolor id quam rhoncus sollicitudin sed id nisi. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin sed odio luctus, tempus dui quis, aliquet arcu. Nunc a sagittis dui, ut lacinia risus. Pellentesque nec leo ut quam varius semper quis ut ligula. Proin feugiat, nisl sed facilisis dignissim, augue mauris cursus elit, at mattis lectus urna in est. Quisque venenatis quam vitae mauris tincidunt, et facilisis purus tincidunt. Sed arcu lacus, maximus quis lorem eget, auctor maximus felis. Cras tristique, ligula eu iaculis feugiat, purus sapien tristique velit, non consequat quam ante sed velit.&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=admin , 2 = staff',
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`, `email`) VALUES
(1, 'Administrator', 'admin', '$2y$10$b.U/uJXcy1G3eE..hbzWcOkknjZqjCoggCIpg90llvzme20fB09i6', 1, ''),
(2, 'Staff', 'staff', '$2y$10$DJbGDnA6bkOiS0TW08R5FOPruw0wRW4maShgWK8k6FlEfgNjbXsvm', 2, ''),
(3, 'testkhai', '', '$2y$10$bddsDmftzI4JxmOf9tKNi.W9EJB7wIMHb3/E0eOPLBtPT050A8NTC', 2, 'khaitest@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address`) VALUES
(1, 'Mark', 'Cooper', 'mcooper@mail.com', '$2y$10$Z.LYi0zrDsrCYIgU1e7yCOkn1lbREGbUcIpSvgkB0OPapDfp7Xc0a', '0912345698', 'Sample Address'),
(2, 'hi', 'hi', 'hi@gmail.com', '$2y$10$rI43A.ZP4bu1PdvhiKpthuLI/JqoDA4NnE9dG7ziqkomI3Cz8todK', 'hi', 'hi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
