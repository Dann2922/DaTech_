-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 03:24 AM
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
-- Database: `db_datech`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_id` int(10) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cate_id` int(10) NOT NULL,
  `cate_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `cus_id` int(10) NOT NULL,
  `cus_fullname` varchar(255) NOT NULL,
  `cus_username` varchar(255) NOT NULL,
  `cus_pass` varchar(50) NOT NULL,
  `cus_phone` text NOT NULL,
  `cus_email` varchar(100) NOT NULL,
  `cus_birthdate` date NOT NULL,
  `cus_address` varchar(255) NOT NULL,
  `cus_state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery`
--

CREATE TABLE `tbl_delivery` (
  `delivery_id` int(10) NOT NULL,
  `delivery_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discount`
--

CREATE TABLE `tbl_discount` (
  `discount_id` int(10) NOT NULL,
  `discount_name` varchar(50) NOT NULL,
  `discount_value` decimal(20,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `feedback_id` int(10) NOT NULL,
  `order_detail_id` int(10) NOT NULL,
  `cus_id` int(10) NOT NULL,
  `feedback_content` varchar(255) NOT NULL,
  `feedback_image` varchar(255) NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_import_invoice`
--

CREATE TABLE `tbl_import_invoice` (
  `import_invoice_id` int(10) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `sup_id` int(10) NOT NULL,
  `import_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_detail`
--

CREATE TABLE `tbl_invoice_detail` (
  `invoice_detail_id` int(10) NOT NULL,
  `import_invoice_id` int(10) NOT NULL,
  `pro_id` int(10) NOT NULL,
  `import_quant` int(5) NOT NULL,
  `disbursement` decimal(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(10) NOT NULL,
  `cus_id` int(10) NOT NULL,
  `discount_id` int(10) NOT NULL,
  `payment_id` int(10) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` int(1) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `order_detail_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `pro_id` int(10) NOT NULL,
  `delivery_id` int(10) NOT NULL,
  `order_quant` int(11) NOT NULL,
  `order_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `payment_id` int(10) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `payment_bank` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pro_id` int(10) NOT NULL,
  `cate_id` int(10) NOT NULL,
  `brand_id` int(10) NOT NULL,
  `pro_name` varchar(255) NOT NULL,
  `pro_img` char(255) NOT NULL,
  `pro_old_price` decimal(10,2) NOT NULL,
  `pro_price` decimal(10,2) NOT NULL,
  `pro_date` date NOT NULL,
  `pro_quant` int(10) NOT NULL,
  `pro_desc` text NOT NULL,
  `pro_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_response`
--

CREATE TABLE `tbl_response` (
  `res_id` int(10) NOT NULL,
  `feeback_id` int(10) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `res_content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `staff_id` int(10) NOT NULL,
  `staff_fullname` varchar(255) NOT NULL,
  `staff_username` varchar(255) NOT NULL,
  `staff_pass` varchar(255) NOT NULL,
  `staff_email` varchar(255) NOT NULL,
  `staff_phone` text NOT NULL,
  `staff_birthday` date NOT NULL,
  `staff_address` varchar(255) NOT NULL,
  `staff_state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `sup_id` int(10) NOT NULL,
  `sup_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cate_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `tbl_delivery`
--
ALTER TABLE `tbl_delivery`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `tbl_discount`
--
ALTER TABLE `tbl_discount`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `cart_id` (`order_detail_id`),
  ADD KEY `cus_id` (`cus_id`);

--
-- Indexes for table `tbl_import_invoice`
--
ALTER TABLE `tbl_import_invoice`
  ADD PRIMARY KEY (`import_invoice_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `sup_id` (`sup_id`);

--
-- Indexes for table `tbl_invoice_detail`
--
ALTER TABLE `tbl_invoice_detail`
  ADD PRIMARY KEY (`invoice_detail_id`),
  ADD KEY `import_invoice_id` (`import_invoice_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `user_id` (`cus_id`),
  ADD KEY `discount_id` (`discount_id`);

--
-- Indexes for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `delivery_id` (`delivery_id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `cate_id` (`cate_id`);

--
-- Indexes for table `tbl_response`
--
ALTER TABLE `tbl_response`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `feeback_id` (`feeback_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`sup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cate_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `cus_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_delivery`
--
ALTER TABLE `tbl_delivery`
  MODIFY `delivery_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_discount`
--
ALTER TABLE `tbl_discount`
  MODIFY `discount_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `feedback_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_import_invoice`
--
ALTER TABLE `tbl_import_invoice`
  MODIFY `import_invoice_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_invoice_detail`
--
ALTER TABLE `tbl_invoice_detail`
  MODIFY `invoice_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `order_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pro_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_response`
--
ALTER TABLE `tbl_response`
  MODIFY `res_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `staff_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `sup_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD CONSTRAINT `tbl_feedback_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `tbl_customer` (`cus_id`),
  ADD CONSTRAINT `tbl_feedback_ibfk_2` FOREIGN KEY (`order_detail_id`) REFERENCES `tbl_order_detail` (`order_detail_id`);

--
-- Constraints for table `tbl_import_invoice`
--
ALTER TABLE `tbl_import_invoice`
  ADD CONSTRAINT `tbl_import_invoice_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `tbl_staff` (`staff_id`),
  ADD CONSTRAINT `tbl_import_invoice_ibfk_2` FOREIGN KEY (`sup_id`) REFERENCES `tbl_supplier` (`sup_id`);

--
-- Constraints for table `tbl_invoice_detail`
--
ALTER TABLE `tbl_invoice_detail`
  ADD CONSTRAINT `tbl_invoice_detail_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `tbl_product` (`pro_id`),
  ADD CONSTRAINT `tbl_invoice_detail_ibfk_2` FOREIGN KEY (`import_invoice_id`) REFERENCES `tbl_import_invoice` (`import_invoice_id`);

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `tbl_customer` (`cus_id`),
  ADD CONSTRAINT `tbl_order_ibfk_2` FOREIGN KEY (`payment_id`) REFERENCES `tbl_payment` (`payment_id`),
  ADD CONSTRAINT `tbl_order_ibfk_3` FOREIGN KEY (`discount_id`) REFERENCES `tbl_discount` (`discount_id`);

--
-- Constraints for table `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD CONSTRAINT `tbl_order_detail_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `tbl_product` (`pro_id`),
  ADD CONSTRAINT `tbl_order_detail_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`order_id`),
  ADD CONSTRAINT `tbl_order_detail_ibfk_3` FOREIGN KEY (`delivery_id`) REFERENCES `tbl_delivery` (`delivery_id`);

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `tbl_product_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `tbl_category` (`cate_id`),
  ADD CONSTRAINT `tbl_product_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `tbl_brand` (`brand_id`);

--
-- Constraints for table `tbl_response`
--
ALTER TABLE `tbl_response`
  ADD CONSTRAINT `tbl_response_ibfk_1` FOREIGN KEY (`feeback_id`) REFERENCES `tbl_feedback` (`feedback_id`),
  ADD CONSTRAINT `tbl_response_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `tbl_staff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
