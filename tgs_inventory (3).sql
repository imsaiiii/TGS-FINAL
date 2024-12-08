-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 09:23 AM
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
-- Database: `tgs_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Espresso'),
(2, 'Fruit Tea'),
(3, 'Mocktails'),
(4, 'Smoothies'),
(5, 'Frappe'),
(6, 'Croffle'),
(7, 'Fries'),
(8, 'Cakes'),
(9, 'Sandwich'),
(10, 'Rice Meal');

-- --------------------------------------------------------

--
-- Table structure for table `completed_orders`
--

CREATE TABLE `completed_orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `paid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_orders`
--

INSERT INTO `completed_orders` (`order_id`, `order_date`, `payment_method`, `total_amount`, `paid`) VALUES
(23, '2024-12-05 14:51:10', 'Cash', 198.00, ''),
(24, '2024-12-05 14:51:23', 'Cash', 198.00, ''),
(25, '2024-12-05 14:59:33', 'Cash', 99.00, ''),
(26, '2024-12-05 14:59:45', 'Cash', 198.00, ''),
(27, '2024-12-05 15:09:39', 'credit_card', 99.00, ''),
(28, '2024-12-05 15:17:36', 'Cash', 99.00, ''),
(29, '2024-12-05 15:25:00', 'Cash', 99.00, ''),
(30, '2024-12-05 15:26:04', 'Cash', 99.00, ''),
(31, '2024-12-05 15:30:44', 'Cash', 99.00, 'No'),
(32, '2024-12-05 15:34:38', 'Cash', 99.00, 'No'),
(33, '2024-12-05 15:36:21', 'Cash', 99.00, 'No'),
(34, '2024-12-05 15:37:06', 'Cash', 99.00, 'No'),
(35, '2024-12-05 15:45:10', 'Cash', 99.00, 'No'),
(36, '2024-12-05 15:47:22', 'Cash', 99.00, 'No'),
(37, '2024-12-05 15:48:03', 'Cash', 99.00, 'No'),
(38, '2024-12-05 15:49:24', 'Cash', 99.00, 'No'),
(39, '2024-12-05 15:54:44', 'Cash', 99.00, 'No'),
(40, '2024-12-05 16:20:34', 'Cash', 99.00, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `completed_orders_details`
--

  CREATE TABLE `completed_orders_details` (
    `id` int(11) NOT NULL,
    `order_id` int(11) NOT NULL,
    `product_id` int(11) NOT NULL,
    `product_name` varchar(255) NOT NULL,
    `quantity` int(11) NOT NULL,
    `price_total` decimal(10,2) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_orders_details`
--

INSERT INTO `completed_orders_details` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price_total`) VALUES
(22, 23, 0, 'Cappucino', 2, 198.00),
(23, 24, 0, 'Cappucino', 2, 198.00),
(24, 25, 0, 'Cappucino', 1, 99.00),
(25, 26, 0, 'Cappucino', 2, 198.00),
(26, 27, 2, 'Cappucino', 1, 99.00),
(27, 28, 2, 'Cappucino', 1, 99.00),
(28, 29, 2, 'Cappucino', 1, 99.00),
(29, 30, 2, 'Cappucino', 1, 99.00),
(30, 31, 2, 'Cappucino', 1, 99.00),
(31, 32, 2, 'Cappucino', 1, 99.00),
(32, 33, 2, 'Cappucino', 1, 99.00),
(33, 34, 2, 'Cappucino', 1, 99.00),
(34, 35, 2, 'Cappucino', 1, 99.00),
(35, 36, 2, 'Cappucino', 1, 99.00),
(36, 37, 2, 'Cappucino', 1, 99.00),
(37, 38, 2, 'Cappucino', 1, 99.00),
(38, 39, 2, 'Cappucino', 1, 99.00),
(39, 40, 2, 'Cappucino', 1, 99.00);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `package_quantity` int(11) NOT NULL,
  `measurement_per_package` int(11) NOT NULL,
  `total_measurement` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `supplier`, `product_name`, `package_quantity`, `measurement_per_package`, `total_measurement`, `category`, `unit`, `expiry_date`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'HeBrews Kape', 'Coffee Beans', 10, 1000, '9948', '', 'grams', '2024-12-28', '2024-12-05 09:42:06', '2024-12-05 16:20:34', NULL),
(2, 'Southside Supplier', 'Sugar Syrup ', 10, 750, '7500.00', '', 'milliliter', '2024-12-28', '2024-12-05 09:42:27', '2024-12-05 09:42:27', NULL),
(3, 'Southside Supplier', 'Hazlenut Sauce', 10, 1890, '18900.00', '', 'milliliter', '2024-12-28', '2024-12-05 09:44:43', '2024-12-05 09:44:43', NULL),
(4, 'Southside Supplier', 'Choco Caramel Sauce', 10, 1890, '18900.00', '', 'milliliter', '2024-12-28', '2024-12-05 09:44:58', '2024-12-05 09:44:58', NULL),
(5, 'Southside Supplier', 'Dark Mocha Sauce', 10, 1890, '18900.00', '', 'milliliter', '2024-12-28', '2024-12-05 09:45:10', '2024-12-05 09:45:10', NULL),
(6, 'Southside Supplier', 'Spanish Latte Sauce', 10, 1890, '18900.00', '', 'milliliter', '2024-12-28', '2024-12-05 09:45:25', '2024-12-05 09:45:25', NULL),
(7, 'Southside Supplier', 'White Caramel Sauce', 10, 1890, '18900.00', '', 'milliliter', '2024-12-28', '2024-12-05 09:46:11', '2024-12-05 09:46:11', NULL),
(8, 'Southside Supplier', 'White Mocha Sauce', 10, 1890, '18900.00', '', 'milliliter', '2024-12-28', '2024-12-05 09:46:26', '2024-12-05 09:46:26', NULL),
(9, 'Wonder Bake Supplies', 'Milk', 10, 1000, '9600', '', 'milliliter', '2024-12-13', '2024-12-05 09:47:27', '2024-12-05 16:20:34', NULL),
(10, 'Wonder Bake Supplies', 'Matcha Powder', 10, 100, '1000.00', '', 'grams', '2024-12-28', '2024-12-05 09:48:20', '2024-12-05 09:48:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_reference` varchar(50) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `payment_reference`, `amount_paid`, `payment_date`) VALUES
(22, 23, 'Cash', '67514d5e253af', 198.00, '2024-12-05 14:51:10'),
(23, 24, 'Cash', '67514d6b30a42', 198.00, '2024-12-05 14:51:23'),
(24, 25, 'Cash', '67514f55dee3b', 99.00, '2024-12-05 14:59:33'),
(25, 26, 'Cash', '67514f6152d36', 198.00, '2024-12-05 14:59:45'),
(26, 27, 'credit_card', '675151b3c534d', 99.00, '2024-12-05 15:09:39'),
(27, 28, 'Cash', '6751539011e75', 99.00, '2024-12-05 15:17:36'),
(28, 37, 'Cash', '67515ab3eaf51', 99.00, '2024-12-05 15:48:03'),
(29, 38, 'Cash', '67515b04d2b3a', 99.00, '2024-12-05 15:49:24'),
(30, 39, 'Cash', '67515c44b4bf5', 99.00, '2024-12-05 15:54:44'),
(31, 40, 'Cash', '67516252659e7', 99.00, '2024-12-05 16:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `image`, `price`, `category`, `created_at`) VALUES
(2, 'Cappucino', 'images/6751239a09402_Cup of Coffee PNG Clipart.jpg', 99.00, 'Espresso', '2024-12-05 03:52:58');

-- --------------------------------------------------------

--
-- Table structure for table `product_ingredients_detail`
--

CREATE TABLE `product_ingredients_detail` (
  `product_detail_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ingredient_name` varchar(255) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_ingredients_detail`
--

INSERT INTO `product_ingredients_detail` (`product_detail_id`, `product_id`, `ingredient_name`, `quantity`, `unit`) VALUES
(3, 2, 'Coffee Beans', 13.00, 'grams'),
(4, 2, 'Milk', 100.00, 'milliliter');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL,
  `po_number` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `qty_received` int(11) NOT NULL,
  `acc_id` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `received_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `po_number`, `created_at`, `qty_received`, `acc_id`, `total_amount`, `received_date`) VALUES
(26, 'PORD0001', '2024-12-05 01:41:46', 0, NULL, 2583.00, '2024-12-05 01:41:46'),
(27, 'PORD0002', '2024-12-05 01:42:52', 0, NULL, 2583.00, '2024-12-05 01:42:52'),
(28, 'PORD0003', '2024-12-05 01:45:09', 0, NULL, 2583.00, '2024-12-05 01:45:09'),
(29, 'PORD0004', '2024-12-05 01:53:58', 0, NULL, 2583.00, '2024-12-05 01:53:58'),
(30, 'PORD0005', '2024-12-05 01:58:12', 0, NULL, 68166.00, '2024-12-05 01:58:12'),
(31, 'PORD0006', '2024-12-05 01:59:01', 0, NULL, 42804.00, '2024-12-05 01:59:01'),
(32, 'PORD0007', '2024-12-05 01:59:26', 0, NULL, 110577.00, '2024-12-05 01:59:26'),
(33, 'PORD0008', '2024-12-05 02:00:45', 0, NULL, 3852.00, '2024-12-05 02:00:45'),
(34, 'PORD0009', '2024-12-05 02:00:56', 0, NULL, 2583.00, '2024-12-05 02:00:56'),
(35, 'PORD0010', '2024-12-05 02:01:33', 0, NULL, 6741.00, '2024-12-05 02:01:33'),
(36, 'PORD0011', '2024-12-05 02:03:30', 0, NULL, 2583.00, '2024-12-05 02:03:30'),
(37, 'PORD0012', '2024-12-05 02:09:07', 0, NULL, 1476.00, '2024-12-05 02:09:07'),
(38, 'PORD0013', '2024-12-05 02:26:46', 0, NULL, 2583.00, '2024-12-05 02:26:46'),
(42, 'PORD0014', '2024-12-05 02:27:07', 0, NULL, 2583.00, '2024-12-05 02:27:07'),
(43, 'PORD0015', '2024-12-05 02:28:50', 0, NULL, 2583.00, '2024-12-05 02:28:50'),
(44, 'PORD0016', '2024-12-05 02:37:36', 0, NULL, 2583.00, '2024-12-05 02:37:36'),
(45, 'PORD0017', '2024-12-05 02:40:12', 0, NULL, 11907.00, '2024-12-05 02:40:12'),
(47, 'PORD0018', '2024-12-05 02:44:16', 0, NULL, 2583.00, '2024-12-05 02:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_details`
--

CREATE TABLE `purchase_order_details` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `qty_received` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `supplier_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_order_details`
--

INSERT INTO `purchase_order_details` (`id`, `po_id`, `product_name`, `unit_price`, `quantity`, `qty_received`, `status`, `supplier_name`, `amount`) VALUES
(3, 26, 'kristicks', 123.00, 0, 0, 'pending', 'default_supplier', 0.00),
(4, 27, 'kristicks', 123.00, 0, 0, 'pending', 'default_supplier', 0.00),
(5, 28, 'kristicks', 123.00, 0, 0, 'pending', 'default_supplier', 0.00),
(6, 29, 'kristicks', 123.00, 21, 0, 'pending', 'default_supplier', 2583.00),
(7, 30, 'kristicks', 123.00, 21, 0, 'pending', 'default_supplier', 2583.00),
(8, 30, 'saiden', 3123.00, 21, 0, 'pending', 'default_supplier', 65583.00),
(9, 31, 'kristicks', 123.00, 12, 0, 'pending', 'default_supplier', 1476.00),
(10, 31, 'Eden Cheese | 170g', 321.00, 12, 0, 'pending', 'default_supplier', 3852.00),
(11, 31, 'saiden', 3123.00, 12, 0, 'pending', 'default_supplier', 37476.00),
(12, 32, 'Eden Cheese | 170g', 321.00, 31, 0, 'pending', 'default_supplier', 9951.00),
(13, 32, 'kristicks', 123.00, 31, 0, 'pending', 'default_supplier', 3813.00),
(14, 32, 'saiden', 3123.00, 31, 0, 'pending', 'default_supplier', 96813.00),
(15, 33, 'Eden Cheese | 170g', 321.00, 12, 0, 'pending', 'default_supplier', 3852.00),
(16, 34, 'kristicks', 123.00, 21, 0, 'pending', 'default_supplier', 2583.00),
(17, 35, 'Eden Cheese | 170g', 321.00, 21, 0, 'pending', 'default_supplier', 6741.00),
(18, 36, 'kristicks', 123.00, 21, 0, 'pending', 'default_supplier', 2583.00),
(19, 37, 'kristicks', 123.00, 12, 0, 'pending', 'default_supplier', 1476.00),
(20, 38, 'kristicks', 123.00, 21, 0, 'pending', '', 2583.00),
(21, 42, 'kristicks', 123.00, 21, 0, 'pending', 'default_supplier', 2583.00),
(22, 43, 'kristicks', 123.00, 21, 0, 'pending', 'default_supplier', 2583.00),
(23, 44, 'kristicks', 123.00, 21, 0, 'pending', 'HeBrews Kape', 2583.00),
(24, 45, 'kristicks', 123.00, 42, 0, 'pending', 'HeBrews Kape', 5166.00),
(25, 45, 'Eden Cheese | 170g', 321.00, 21, 0, 'pending', 'asdasd', 6741.00),
(26, 47, 'kristicks', 123.00, 21, 0, 'pending', 'asd', 2583.00);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `contact_number` bigint(20) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `contact_number`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'HeBrews Kape', 9272222920, 'active', '2024-12-05 07:58:12', '2024-12-05 07:58:12', NULL),
(2, 'Southside Supplier', 9499811272, 'active', '2024-12-05 07:58:40', '2024-12-05 07:58:40', NULL),
(3, 'Wonder Bake Supplies', 9637181565, 'active', '2024-12-05 07:59:28', '2024-12-05 07:59:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_products`
--

CREATE TABLE `supplier_products` (
  `id` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `reorder_level` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_products`
--

INSERT INTO `supplier_products` (`id`, `supplier`, `product_name`, `price`, `quantity`, `unit`, `reorder_level`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'HeBrews Kape', 'Coffee Beans', 100.00, 0, '', '', '2024-12-05 08:00:14', '2024-12-05 08:00:14', NULL),
(2, 'Southside Supplier', 'Sugar Syrup ', 495.00, 0, '', '', '2024-12-05 08:01:23', '2024-12-05 08:01:23', NULL),
(3, 'Southside Supplier', 'Hazlenut Sauce', 995.00, 0, '', '', '2024-12-05 08:02:23', '2024-12-05 08:02:23', NULL),
(4, 'Southside Supplier', 'Choco Caramel Sauce', 995.00, 0, '', '', '2024-12-05 08:02:44', '2024-12-05 08:05:27', NULL),
(5, 'Southside Supplier', 'Dark Mocha Sauce', 995.00, 0, '', '', '2024-12-05 08:03:31', '2024-12-05 08:03:31', NULL),
(6, 'Southside Supplier', 'Spanish Latte Sauce', 995.00, 0, '', '', '2024-12-05 08:03:55', '2024-12-05 08:03:55', NULL),
(7, 'Southside Supplier', 'White Caramel Sauce', 995.00, 0, '', '', '2024-12-05 08:06:35', '2024-12-05 08:06:35', NULL),
(8, 'Southside Supplier', 'White Mocha Sauce', 995.00, 0, '', '', '2024-12-05 08:07:40', '2024-12-05 08:07:40', NULL),
(9, 'HeBrews Kape', 'beans', 100.00, 1, 'pack', '3', '2024-12-05 09:13:47', '2024-12-05 09:13:47', NULL),
(10, 'Wonder Bake Supplies', 'Milk', 960.00, 10, 'box', '5', '2024-12-05 09:36:32', '2024-12-05 09:36:32', NULL),
(11, 'Wonder Bake Supplies', 'Matcha Powder', 300.00, 1, 'pieces', '2', '2024-12-05 09:37:39', '2024-12-05 09:37:39', NULL),
(12, 'Southside Supplier', 'Caramel Sauce', 995.00, 1, 'pack', '3', '2024-12-05 10:22:00', '2024-12-05 10:22:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `role`, `created_at`) VALUES
(2, 'saiden', 'abbas', 'saidenabbas21@gmail.com', 'superadmin1', '123123', 'superadmin', '2024-12-03 16:08:29'),
(3, 'saiden', 'asdasd', 'abbas.104661@laspinas.sti.edu.ph', 'superadmin2', '123123', 'admin', '2024-12-03 16:28:28'),
(4, 'saiden', 'abbas', 'saidenabbas@gmail.com', 'superadmin3', '123123', 'user', '2024-12-03 16:31:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `completed_orders`
--
ALTER TABLE `completed_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `completed_orders_details`
--
ALTER TABLE `completed_orders_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_ingredients_detail`
--
ALTER TABLE `product_ingredients_detail`
  ADD PRIMARY KEY (`product_detail_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_number` (`po_number`);

--
-- Indexes for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_id` (`po_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_products`
--
ALTER TABLE `supplier_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `completed_orders`
--
ALTER TABLE `completed_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `completed_orders_details`
--
ALTER TABLE `completed_orders_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_ingredients_detail`
--
ALTER TABLE `product_ingredients_detail`
  MODIFY `product_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_products`
--
ALTER TABLE `supplier_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `completed_orders_details`
--
ALTER TABLE `completed_orders_details`
  ADD CONSTRAINT `completed_orders_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `completed_orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `completed_orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_ingredients_detail`
--
ALTER TABLE `product_ingredients_detail`
  ADD CONSTRAINT `product_ingredients_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  ADD CONSTRAINT `purchase_order_details_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
