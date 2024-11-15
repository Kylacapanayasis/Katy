-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 11:37 PM
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
-- Database: `ecom_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) NOT NULL,
  `admin_name` varchar(65) NOT NULL,
  `admin_email` varchar(65) NOT NULL,
  `admin_pass` varchar(50) NOT NULL,
  `admin_image` varchar(100) NOT NULL,
  `admin_contact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_pass`, `admin_image`, `admin_contact`) VALUES
(1, 'admin', 'admin@gmail.com', '123', 'eren.jpg', '09569321078');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `p_id` int(10) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `qty` int(10) NOT NULL,
  `p_price` varchar(255) NOT NULL,
  `size` text NOT NULL,
  `roast` text NOT NULL,
  `coffee` text NOT NULL,
  `total` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) NOT NULL,
  `cat_title` varchar(20) NOT NULL,
  `cat_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_image`) VALUES
(6, 'Beans', '1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(15) NOT NULL,
  `product_id` int(20) NOT NULL,
  `coupon_title` varchar(20) NOT NULL,
  `coupon_price` int(5) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `coupon_limit` int(5) NOT NULL,
  `coupon_used` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `product_id`, `coupon_title`, `coupon_price`, `coupon_code`, `coupon_limit`, `coupon_used`) VALUES
(2, 5, 'For Melon Milk', 100, 'masarap123', 3, 2),
(4, 9, 'For Syrup', 250, 'syrupsarap', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(65) NOT NULL,
  `customer_email` varchar(65) DEFAULT NULL,
  `customer_pass` varchar(50) NOT NULL,
  `customer_city` varchar(20) NOT NULL,
  `customer_contact` varchar(13) NOT NULL,
  `customer_address` varchar(50) NOT NULL,
  `customer_image` varchar(100) NOT NULL,
  `verification_code` int(50) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_email`, `customer_pass`, `customer_city`, `customer_contact`, `customer_address`, `customer_image`, `verification_code`, `email_verified_at`) VALUES
(1, 'Christian Mendoza', 'chan@gmail.com', '123', 'Manila', '09569321078', 'Pasigxd', '48046637_2149093078735525_2122338508562497536_n.jpg', NULL, NULL),
(2, 'jer', 'jeriannamae@gmail.com', 'jer', 'Laguna', '343242342423', '2312733313', 'matthew-hamilton-qKpEYgWKogU-unsplash.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE `customer_orders` (
  `order_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `invoice_no` int(100) NOT NULL,
  `qty` int(10) NOT NULL,
  `size` text NOT NULL,
  `roast` text NOT NULL,
  `coffee` text NOT NULL,
  `order_date` date NOT NULL,
  `order_status` text NOT NULL,
  `payment_method` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`order_id`, `product_id`, `customer_id`, `due_amount`, `invoice_no`, `qty`, `size`, `roast`, `coffee`, `order_date`, `order_status`, `payment_method`) VALUES
(25, 30, 2, 320, 1236474726, 1, '2kg', 'Regular', 'Fine Grind', '2024-10-31', 'Complete', 'Offline'),
(26, 30, 2, 320, 1830045159, 1, '', 'Regular', 'Whole Beans', '2024-10-31', 'Complete', 'Offline'),
(27, 30, 2, 320, 749381591, 1, '', 'Regular', 'Fine Grind', '2024-10-31', 'pending', 'Offline'),
(28, 28, 2, 240, 808574628, 1, '', 'Regular', 'Whole Beans', '2024-10-31', 'pending', 'Offline'),
(29, 29, 2, 300, 1139359198, 1, '', 'Regular', 'Fine Grind', '2024-10-31', 'pending', 'Offline'),
(30, 28, 2, 240, 1085756999, 1, '', 'Regular', 'Fine Grind', '2024-10-31', 'pending', 'Offline'),
(31, 30, 2, 320, 2033538772, 1, '', 'Regular', 'Fine Grind', '2024-10-31', 'pending', 'Offline'),
(32, 28, 2, 240, 2033538772, 1, '', 'Regular', 'Whole Beans', '2024-10-31', 'pending', 'Offline'),
(33, 30, 2, 640, 863579011, 2, '', 'Regular', 'Whole Beans', '2024-11-01', 'pending', 'Offline');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `manufacturer_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(15) NOT NULL,
  `invoice_no` int(20) NOT NULL,
  `amount` int(10) NOT NULL,
  `due_amount` int(10) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `ref_no` varchar(15) NOT NULL,
  `payment_date` date NOT NULL,
  `proof` varchar(100) NOT NULL,
  `payment_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `p_cat_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `manufacturer_id` int(10) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `product_title` text NOT NULL,
  `product_url` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_img3` text DEFAULT NULL,
  `product_price` int(10) DEFAULT NULL,
  `product_keywords` text NOT NULL,
  `product_desc` text NOT NULL,
  `product_label` text NOT NULL,
  `product_sale` int(100) NOT NULL,
  `product_quan` int(10) NOT NULL,
  `product_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_cat_id`, `cat_id`, `manufacturer_id`, `expiry_date`, `product_title`, `product_url`, `product_img1`, `product_img2`, `product_img3`, `product_price`, `product_keywords`, `product_desc`, `product_label`, `product_sale`, `product_quan`, `product_status`) VALUES
(28, 20, 6, 0, '2024-10-29', 'Liberica', 'li-be-ri-ca', 'dfbe9404-98d6-486b-a889-ab3934de2f0d.jpg', 'd15be7bf-5bf1-458a-aa23-7d4ff83fbc5d.jpg', '801e27b1-195d-450f-a94e-e297bc4d4f48.jpg', 240, 'LIBERICA BEANS', '<p style=\"margin-top: 0pt; margin-bottom: 0pt; margin-left: 0in; direction: ltr; unicode-bidi: embed; word-break: normal;\"><span style=\"font-size: 18pt; font-family: Calibri;\">-Best seller l</span><span style=\"font-size: 18pt; font-family: Calibri;\">ocally known as </span><span style=\"font-size: 18pt; font-family: Calibri;\">kapeng</span> <span style=\"font-size: 18pt; font-family: Calibri;\">barako p</span><span style=\"font-size: 18pt; font-family: Calibri;\">owerful flavor with smoky and chocolatey tastes.</span></p>', 'new', 200, 20, 'LB Beans'),
(29, 20, 6, 0, '2024-10-30', 'Robusta', 'rob-usta', '205d9a51-2968-4999-8621-cde0e33716dd.jpg', '00664657-d4d7-475f-be9f-84bee4e4fbe3.jpg', '801e27b1-195d-450f-a94e-e297bc4d4f48.jpg', 300, 'Robusta Beans', '<p><span style=\"font-size: 18pt; font-family: Calibri;\">Widely used in espresso blends and produced a better crema.</span></p>', 'new', 0, 20, 'Latest'),
(30, 20, 6, 0, '2024-10-30', 'Arabica', 'ara-bica', '00664657-d4d7-475f-be9f-84bee4e4fbe3.jpg', '00664657-d4d7-475f-be9f-84bee4e4fbe3.jpg', 'd1a0e341-f050-46ed-bd82-62494eaf8013.jpg', 320, 'Arabica', '<p><span style=\"font-size: 18pt; font-family: Calibri;\">After taste of caramel and nuts.</span></p>', 'new', 0, 10, 'Arabica');

-- --------------------------------------------------------

--
-- Table structure for table `product_classifications`
--

CREATE TABLE `product_classifications` (
  `p_cat_id` int(10) NOT NULL,
  `p_cat_title` varchar(20) NOT NULL,
  `p_cat_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_classifications`
--

INSERT INTO `product_classifications` (`p_cat_id`, `p_cat_title`, `p_cat_image`) VALUES
(20, 'Robusta', '1.jpg'),
(21, 'Arabica', '2.jpg'),
(22, 'Liberica', '3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `review_section`
--

CREATE TABLE `review_section` (
  `review_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slide_id` int(10) NOT NULL,
  `slide_name` varchar(65) NOT NULL,
  `slide_image` varchar(100) NOT NULL,
  `slide_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slide_id`, `slide_name`, `slide_image`, `slide_url`) VALUES
(2, 'Feature2', 'photo0.png', 'shop.php');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `term_id` int(10) NOT NULL,
  `term_title` varchar(20) NOT NULL,
  `term_link` varchar(100) NOT NULL,
  `term_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`term_id`, `term_title`, `term_link`, `term_desc`) VALUES
(1, 'STORE POLICY', 'link_1', '<p><strong>Store Hours:</strong></p>\r\n    <p>Monday - Sunday: 7:00 AM - 7:00 PM</p>\r\n\r\n    <p><strong>How to Order:</strong></p>\r\n    <ul>\r\n        <li>Explore our shop and add desired products to your cart.</li>\r\n        <li>Proceed to checkout and complete your payment.</li>\r\n        <li>Await your receipt.</li>\r\n    </ul>\r\n\r\n    <p>Thank you for choosing us! Kindly rate our service to help us improve.</p>'),
(2, 'PAYMENT POLICY', 'link_2', '<p><strong>Payment Details</strong></p>\r\n\r\n<p><strong>Mode of Payments:</strong> GCash, Cash, PayMaya (optional)</p>\r\n\r\n<p><strong>GCash Details:</strong></p>\r\n<ul>\r\n    <li>Winnie Castro: 0915-6968682</li>\r\n    <li>Carmela Castro: 0960-8648358</li>\r\n    <li>Sean Castro: 0933-8598333</li>\r\n</ul>\r\n\r\n<p><strong>PayMaya Details:</strong> 0976 2810901</p>\r\n\r\n<p><strong>No Payment, No Booking, No Pick-Up.</strong></p>\r\n<p>Please allow 1-2 hours for order preparation.</p>\r\n<p>Order cut-off time is 6:00 PM.</p>\r\n<p>Store closes promptly at 7:00 PM.</p>\r\n<p>Delivery is arranged by the customer through a 3rd party rider.</p>\r\n<p>Items are not reserved unless fully paid.</p>\r\n<p>Follow our Payment First policy, unless the rider agrees to cover payment upfront.</p>\r\n<p>After the 6:00 PM cut-off, we may not be able to respond, but you can submit orders for the next day\'s pick-up.</p>\r\n'),
(3, 'CANCELLED ORDERS', 'link_3', '<p><strong>Online Payment:</strong></p>\r\n    <ul>\r\n        <li>Orders made with online payment must be confirmed within 24 hours of placing the order.</li>\r\n        <li>Upon order confirmation, payment must be made within the specified time frame.</li>\r\n        <li>Failure to confirm the order within 24 hours or make payment within the specified time frame will result in automatic cancellation of the order.</li>\r\n        <li>No payment will be processed until the order is confirmed.</li>\r\n    </ul>\r\n\r\n    <p><strong>Offline Payment:</strong></p>\r\n    <ul>\r\n        <li>For orders with offline payment methods, customers are required to confirm their order within 24 hours.</li>\r\n        <li>Upon confirmation, payment must be made before delivery or within the agreed-upon time frame.</li>\r\n        <li>Failure to confirm the order within 24 hours or make payment within the specified time frame will result in automatic cancellation of the order.</li>\r\n    </ul>\r\n\r\n    <p><strong>Cancellation by Customer:</strong></p>\r\n    <ul>\r\n        <li>If a customer wishes to cancel their order, they must do so before the order is confirmed.</li>\r\n        <li>Once the order is confirmed, cancellation requests may not be accommodated as the order is being processed for delivery or pick-up.</li>\r\n    </ul>\r\n\r\n    <p><strong>Cancellation Process:</strong></p>\r\n    <ul>\r\n        <li>In the event of order cancellation due to non-confirmation or non-payment, customers will see it via their account.</li>\r\n        <li>The cancelled order will not be processed for payment, and no refund will be issued as payment has not been made.</li>\r\n    </ul>\r\n\r\n    <p><strong>Note:</strong></p>\r\n    <p>We reserve the right to modify or update this policy at any time without prior notice.</p>\r\n    <p>Thank you for your understanding and cooperation.</p>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`,`admin_contact`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email` (`customer_email`,`customer_contact`);

--
-- Indexes for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_classifications`
--
ALTER TABLE `product_classifications`
  ADD PRIMARY KEY (`p_cat_id`);

--
-- Indexes for table `review_section`
--
ALTER TABLE `review_section`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`term_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_orders`
--
ALTER TABLE `customer_orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `product_classifications`
--
ALTER TABLE `product_classifications`
  MODIFY `p_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `review_section`
--
ALTER TABLE `review_section`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slide_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `term_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
