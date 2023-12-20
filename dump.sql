-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2023 at 07:51 PM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `customer_id` int(11) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `cart_item_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Mawar'),
(2, 'Melati'),
(3, 'Lavender'),
(4, 'Bunga Sepatu');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(17) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_phone`, `customer_email`, `customer_password`) VALUES
(1, 'Naufal Alifiansyah', '081234567891', 'naufal@example.com', '$2y$10$YpsuVarBbWQP9bDd4K4pI.JjpAP.unxUWAsS/XJHofTR/PdcEV8Bu'),
(2, 'Shafy Gunawan', '081234567891', 'shafy@example.com', '$2y$10$YpsuVarBbWQP9bDd4K4pI.JjpAP.unxUWAsS/XJHofTR/PdcEV8Bu');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `order_total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `payment_method_id`, `order_date`, `order_status`, `order_total_price`) VALUES
(1, 1, 1, '2023-11-17', 'paid', 40000),
(2, 2, 2, '2023-11-17', 'unpaid', 100000),
(3, 2, 3, '2023-11-19', 'paid', 120000);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `order_detail_qty` int(11) NOT NULL,
  `order_detail_unit_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `plant_id`, `order_detail_qty`, `order_detail_unit_price`) VALUES
(1, 1, 3, 1, 20000),
(2, 1, 7, 2, 10000),
(3, 2, 12, 2, 50000),
(4, 3, 2, 1, 75000),
(5, 3, 3, 1, 20000),
(6, 3, 4, 1, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL,
  `payment_method_name` varchar(255) NOT NULL,
  `payment_method_number` varchar(50) NOT NULL,
  `payment_method_bank` varchar(50) NOT NULL,
  `payment_method_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`payment_method_id`, `payment_method_name`, `payment_method_number`, `payment_method_bank`, `payment_method_logo`) VALUES
(1, 'PT FloraFavs Indonesia', '673892017384', 'Permata', 'permata.svg'),
(2, 'PT FloraFavs Indonesia', '923456129083', 'BCA', 'bca.svg'),
(3, 'PT FloraFavs Indonesia', '384789263892', 'Mandiri', 'mandiri.svg');

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE `plants` (
  `plant_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `plant_name` varchar(255) NOT NULL,
  `plant_price` int(11) NOT NULL,
  `plant_stock` int(11) NOT NULL,
  `plant_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`plant_id`, `supplier_id`, `category_id`, `plant_name`, `plant_price`, `plant_stock`, `plant_photo`) VALUES
(1, 1, 1, 'Mawar Double Delight', 50000, 20, '655eea074f000.jpg'),
(2, 1, 1, 'Mawar Eden', 75000, 15, '655eeb2c4929e.jpg'),
(3, 1, 1, 'Mawar Mega Putih', 20000, 15, '655eed4066c32.jpeg'),
(4, 1, 1, 'Mawar Putri', 25000, 12, '655eed59ed050.jpg'),
(5, 1, 1, 'Mawar Sunsprite', 22000, 13, '655eef0382fe4.jpg'),
(6, 2, 2, 'Melati Gambir', 17000, 16, '655eef3c6c515.jpg'),
(7, 2, 2, 'Melati Putih', 10000, 18, '655eef669e1eb.jpg'),
(8, 2, 2, 'Melati Raja', 18000, 19, '655eef95e2da9.jpg'),
(9, 2, 2, 'Melati Primpose', 27000, 20, '655eefbc9a3b2.jpg'),
(10, 2, 2, 'Melati Spanyol', 35000, 22, '655ef006584e5.jpg'),
(11, 3, 3, 'Lavender English', 32000, 30, '655f09fb45a67.jpg'),
(12, 3, 3, 'Lavender Putih', 50000, 20, '655f184e3e176.jpg'),
(13, 3, 3, 'Lavender Sage', 31000, 23, '65601b3b0fff0.jpg'),
(14, 3, 3, 'Lavendula Pedunculata', 32000, 13, '65601b8dd7bc1.jpeg'),
(15, 4, 4, 'Hibiscus Calyphyllus', 24000, 5, '6560397845cc6.jpg'),
(16, 4, 4, 'Hibiscus Cannabinus', 30000, 11, '656039cc98fdf.jpg'),
(17, 4, 4, 'Hibiscus Coccineus', 23000, 13, '656039f17b993.jpg'),
(18, 4, 4, 'Hibiscus Acetosella', 34000, 14, '65603a5a2c572.jpg'),
(19, 4, 4, 'Hibiscus Genevil', 29000, 17, '65603a9c34bad.jpeg'),
(20, 4, 4, 'Hibiscus Rosa Sinensis', 37000, 29, '65603ac4ddcb0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'administrator'),
(2, 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `staff_phone` varchar(17) NOT NULL,
  `staff_email` varchar(255) NOT NULL,
  `staff_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `role_id`, `staff_name`, `staff_phone`, `staff_email`, `staff_password`) VALUES
(1, 1, 'Andre Eka', '081234567891', 'andre@example.com', '$2y$10$YpsuVarBbWQP9bDd4K4pI.JjpAP.unxUWAsS/XJHofTR/PdcEV8Bu'),
(2, 2, 'Umar Muchtar', '081234567891', 'umar@example.com', '$2y$10$YpsuVarBbWQP9bDd4K4pI.JjpAP.unxUWAsS/XJHofTR/PdcEV8Bu');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_phone` varchar(17) NOT NULL,
  `supplier_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `supplier_phone`, `supplier_address`) VALUES
(1, 'PT Nusa Bangsa', '081234567891', 'Jl. Semarang No. 33 Surabaya'),
(2, 'PT Taman Indah', '081234567891', 'Jl. Pahlawan No. 17 Bangkalan'),
(3, 'PT Kebun Merdeka', '081234567891', 'Jl. Telang Indah No. 19 Bangkalan'),
(4, 'PT Rumput Hijau', '081234567891', 'Jl. Cempaka No. 27 Surabaya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`customer_id`,`plant_id`),
  ADD KEY `FK_cart_item_plant` (`plant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `FK_customer_order` (`customer_id`),
  ADD KEY `FK_payment_method_order` (`payment_method_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `FK_order_detail_order` (`order_id`),
  ADD KEY `FK_order_detail_plant` (`plant_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`plant_id`),
  ADD KEY `FK_category_plant` (`category_id`),
  ADD KEY `FK_plant_supplier` (`supplier_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `FK_role_staff` (`role_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `plant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `FK_cart_item_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `FK_cart_item_plant` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`plant_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_customer_order` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `FK_payment_method_order` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`payment_method_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `FK_order_detail_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `FK_order_detail_plant` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`plant_id`);

--
-- Constraints for table `plants`
--
ALTER TABLE `plants`
  ADD CONSTRAINT `FK_category_plant` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `FK_plant_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `FK_role_staff` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
