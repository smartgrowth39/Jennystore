-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2026 at 03:30 PM
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
-- Database: `jenny_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_to_cart`
--

CREATE TABLE `add_to_cart` (
  `ip_address` varchar(500) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_image` varchar(500) NOT NULL,
  `product_quantity` varchar(6000) NOT NULL,
  `product_price` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_password` varchar(200) NOT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `role` enum('super_admin','admin') NOT NULL DEFAULT 'admin',
  `status` enum('active','pending','rejected') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_password`, `admin_email`, `role`, `status`, `created_at`) VALUES
(1, 'admin', 'admin12345', NULL, 'super_admin', 'active', '2026-03-12 13:28:16'),
(2, 'Abdul Samad', 'samadlull', 'abdulsamad2505b@aptechsite.net', 'admin', 'active', '2026-03-12 13:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'jewellery'),
(2, 'cosmetics');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`) VALUES
(1, 'Abdul Hadi', 'abdulhadi@gmail.com', '+920408505', 'general', 'this is me ', '2026-03-09 16:56:48'),
(2, 'Muhammad Shayan', 'shayan2505b@aptechsite.net', '03322327180', 'product', 'This is my first overview', '2026-03-13 07:16:59'),
(3, 'Ahmed Raza', 'ahmedraza@gmail.com', '03243264366', 'general', 'This is my first Experience', '2026-03-13 07:20:53'),
(4, 'Abdul Samad', 'abdulsamad2505b@aptechsite.net', '03132847392', 'feedback', 'please  contact with me I am Your Big Fan', '2026-03-13 07:22:09'),
(5, 'Rashid', 'rashid213@gmail.com', '03836184629', 'complaint', 'I am Rashid Please contact with me', '2026-03-13 07:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `work_phone` varchar(20) DEFAULT NULL,
  `cell_phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_phone` varchar(50) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `city` varchar(255) NOT NULL,
  `state` varchar(6000) NOT NULL,
  `select_country` varchar(2000) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_name`, `user_email`, `user_phone`, `user_address`, `zip_code`, `order_date`, `city`, `state`, `select_country`, `total_amount`, `status`, `created_at`) VALUES
(55, 'Abdul Kamal', 'abdulkamal1234@gmail.com', '829855', 'Aisha Manzil', '2425', '2026-03-14', 'Karachi', 'kemari', 'Pakistan', 23000.00, 'cancelled', '2026-03-14 06:15:23'),
(56, 'kinza khan', 'kinzakhan213@gmail.com', '829855', 'Baldia Town Karachi', '2425', '2026-03-14', 'Karachi', 'kemari', 'Pakistan', 11650.00, 'processing', '2026-03-14 06:25:56'),
(57, 'kashaf', 'kashaf1843@gmail.com', '829855', 'alid tower', '2425', '2026-03-14', 'Karachi', 'kemari', 'Pakistan', 8270.00, 'shipped', '2026-03-14 06:27:52'),
(58, 'Rahila Ali', 'rahila123@gmail.com', '829855', 'Taa gali', '2425', '2026-03-14', 'Karachi', 'kemari', 'Pakistan', 7380.00, 'pending', '2026-03-14 06:35:10'),
(59, 'shahida', 'shahid@gmail.com', '829855', 'raja Road', '2425', '2026-03-14', 'Karachi', 'kemari', 'Pakistan', 40740.00, 'delivered', '2026-03-14 06:37:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `product_name` varchar(250) DEFAULT NULL,
  `product_image` varchar(500) DEFAULT NULL,
  `product_price` int(11) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `product_image`, `product_price`, `product_quantity`) VALUES
(60, 55, '45', 'Silk Touch Liquid Foundation', '../assets/c12.jfif', 3500, 5),
(61, 55, '52', 'Velvet Matte Lipstick', '../assets/c12.jfif', 1400, 1),
(62, 55, '55', 'Diamond Style Bracelet', '../assets/j3.jpg', 1600, 1),
(63, 55, '49', 'Smooth Finish Compact Powder', '../assets/c17.jfif', 2500, 1),
(64, 56, '46', 'Rose Glow Blush', '../assets/c3.jpg', 3300, 1),
(65, 56, '50', 'Luxury Gold Bangle Set', '../assets/1.jpg', 1300, 5),
(66, 56, '53', 'Hydrating Aloe Vera Face Wash', '../assets/c9.webp', 1850, 1),
(67, 57, '60', 'Volume Boost Eyebrow Pencil', '../assets/c14.jfif', 1370, 1),
(68, 57, '50', 'Luxury Gold Bangle Set', '../assets/1.jpg', 1300, 1),
(69, 57, '51', 'Elegant Crystal Drop Earrings', '../assets/j2.jpg', 1400, 4),
(70, 58, '46', 'Rose Glow Blush', '../assets/c3.jpg', 3300, 1),
(71, 58, '54', 'Vitamin C Brightening Serum', '../assets/c13.jfif', 1780, 1),
(72, 58, '61', 'Herbal Skin Brightening Cream', '../assets/c20.jfif', 2300, 1),
(73, 59, '57', 'Modern Gold Cuff Bracelet', '../assets/j14.jpg', 1740, 1),
(74, 59, '48', 'Natural Glow BB Cream', '../assets/c19.jfif', 4000, 1),
(75, 59, '59', 'Bridal Crystal Necklace Set', '../assets/j19.jpg', 35000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `product_description` varchar(6000) NOT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_cat` varchar(200) NOT NULL,
  `featured_products` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_price`, `product_image`, `product_cat`, `featured_products`, `created_at`) VALUES
(46, 'Rose Glow Blush', 'Rose Glow Blush adds a soft and natural pink glow to the cheeks. Rose Glow Blush enhances your facial features with a fresh and vibrant look.\r\n\r\nRose Glow Blush has a silky texture that blends smoothly on the skin. The formula of Rose Glow Blush gives a natural and radiant finish.\r\n\r\nRose Glow Blush is perfect for both light daytime makeup and evening looks. Many beauty lovers use Rose Glow Blush to achieve a healthy glow.', 3300.00, '../assets/c11.jfif', 'Cosmetics', 0, '2026-03-14 07:35:14'),
(48, 'Natural Glow BB Cream', 'Natural Glow BB Cream is a lightweight beauty product that helps create a smooth and even skin tone. Natural Glow BB Cream gives your face a natural and fresh appearance.\r\n\r\nNatural Glow BB Cream combines skincare and makeup benefits in one formula. The texture of Natural Glow BB Cream blends easily into the skin.\r\n\r\nNatural Glow BB Cream is perfect for everyday makeup and quick beauty routines. Many people prefer Natural Glow BB Cream for its natural looking finish.', 4000.00, '../assets/c19.jfif', 'Cosmetics', 0, '2026-03-14 07:00:10'),
(50, 'Luxury Gold Bangle Set', 'Luxury Gold Bangle Set is a beautiful collection of elegant gold style bangles. Luxury Gold Bangle Set adds a rich and traditional touch to any outfit.\r\n\r\nLuxury Gold Bangle Set is designed with fine detailing and a shiny finish. The design of Luxury Gold Bangle Set looks stylish and premium.\r\n\r\nLuxury Gold Bangle Set is perfect for weddings, parties, and festive occasions. Many women choose Luxury Gold Bangle Set to enhance their jewelry collection.', 1300.00, '../assets/1.jpg', 'Jewellery', 1, '2026-03-12 20:05:02'),
(51, 'Elegant Crystal Drop Earrings', 'Elegant Crystal Drop Earrings are designed to give a classy and sparkling look. Elegant Crystal Drop Earrings beautifully highlight your facial features.\r\n\r\nElegant Crystal Drop Earrings contain shining crystals that reflect light beautifully. The design of Elegant Crystal Drop Earrings is both modern and stylish.\r\n\r\nElegant Crystal Drop Earrings are perfect for parties and formal events. Many fashion lovers prefer Elegant Crystal Drop Earrings for their elegant style.', 1400.00, '../assets/j2.jpg', 'Jewellery', 1, '2026-03-12 20:05:39'),
(52, 'Velvet Matte Lipstick', 'Velvet Matte Lipstick is a premium beauty product designed to give your lips a rich and elegant matte finish. Velvet Matte Lipstick provides intense color that enhances your overall makeup look.\r\n\r\nVelvet Matte Lipstick has a smooth texture that glides easily on the lips without feeling heavy. The formula of Velvet Matte Lipstick keeps your lips comfortable throughout the day.\r\n\r\nVelvet Matte Lipstick is long-lasting and perfect for both daily wear and special occasions. Many makeup lovers prefer Velvet Matte Lipstick because of its bold and beautiful sh', 1400.00, '../assets/c12.jfif', 'Cosmetics', 1, '2026-03-12 20:09:27'),
(53, 'Hydrating Aloe Vera Face Wash', 'Hydrating Aloe Vera Face Wash is a gentle cleanser that removes dirt and excess oil from the skin. Hydrating Aloe Vera Face Wash helps keep the skin fresh and clean after every wash.\r\n\r\nHydrating Aloe Vera Face Wash contains natural aloe vera extracts that soothe and hydrate the skin. The formula of Hydrating Aloe Vera Face Wash is suitable for daily skincare routines.\r\n\r\nHydrating Aloe Vera Face Wash leaves the skin feeling soft, smooth, and refreshed. Many people use Hydrating Aloe Vera Face Wash to maintain healthy and glowing skin.', 1850.00, '../assets/c9.webp', 'Cosmetics', 1, '2026-03-12 20:10:33'),
(54, 'Vitamin C Brightening Serum', 'Vitamin C Brightening Serum is a powerful skincare product that helps improve skin tone and brightness. Vitamin C Brightening Serum supports healthy and radiant looking skin.\r\n\r\nVitamin C Brightening Serum contains antioxidants that protect the skin from environmental damage. Regular use of Vitamin C Brightening Serum helps reduce dullness.\r\n\r\nVitamin C Brightening Serum absorbs quickly into the skin without leaving a sticky feeling. Many skincare users love Vitamin C Brightening Serum for its glowing results.', 1780.00, '../assets/c13.jfif', 'Cosmetics', 1, '2026-03-12 20:11:45'),
(55, 'Diamond Style Bracelet', 'Diamond Style Bracelet is a luxurious bracelet inspired by diamond jewelry. Diamond Style Bracelet gives a glamorous and sophisticated look.\r\n\r\nDiamond Style Bracelet features a line of sparkling stones with a smooth finish. The design of Diamond Style Bracelet feels elegant and timeless.\r\n\r\nDiamond Style Bracelet is perfect for special occasions and celebrations. Many women love Diamond Style Bracelet for its shining appearance.', 1600.00, '../assets/j3.jpg', 'Jewellery', 1, '2026-03-12 20:12:36'),
(56, 'Minimal Silver Chain Bracelet', 'Minimal Silver Chain Bracelet is a simple yet stylish jewelry piece. Minimal Silver Chain Bracelet gives a modern and elegant look.\r\n\r\nMinimal Silver Chain Bracelet is made with a delicate chain style design. The lightweight design of Minimal Silver Chain Bracelet makes it comfortable.\r\n\r\nMinimal Silver Chain Bracelet is perfect for daily wear and casual outfits. Many people prefer Minimal Silver Chain Bracelet for its minimalist beauty.', 3870.00, '../assets/j5.webp', 'Jewellery', 1, '2026-03-12 20:13:18'),
(57, 'Modern Gold Cuff Bracelet', 'Modern Gold Cuff Bracelet is a trendy jewelry accessory with a bold design. Modern Gold Cuff Bracelet adds a fashionable touch to any look.\r\n\r\nModern Gold Cuff Bracelet has a smooth polished finish that looks elegant. The design of Modern Gold Cuff Bracelet is both modern and stylish.\r\n\r\nModern Gold Cuff Bracelet is perfect for parties and stylish outfits. Many fashion lovers choose Modern Gold Cuff Bracelet for its unique design.', 1740.00, '../assets/j14.jpg', 'Jewellery', 1, '2026-03-12 20:13:55'),
(58, 'Antique Silver Statement Necklace', 'Antique Silver Statement Necklace is a bold jewelry piece with a vintage design. Antique Silver Statement Necklace gives a unique traditional look.\r\n\r\nAntique Silver Statement Necklace features detailed patterns and layered elements. The design of Antique Silver Statement Necklace is eye catching.\r\n\r\nAntique Silver Statement Necklace is perfect for traditional outfits. Many fashion lovers enjoy Antique Silver Statement Necklace.', 25000.00, '../assets/j16.jpg', 'Jewellery', 0, '2026-03-13 05:40:50'),
(59, 'Bridal Crystal Necklace Set', 'Bridal Crystal Necklace Set is a luxurious jewelry set designed for brides. Bridal Crystal Necklace Set gives a sparkling and royal appearance.\r\n\r\nBridal Crystal Necklace Set features shining crystals and elegant stones. The design of Bridal Crystal Necklace Set looks glamorous.\r\n\r\nBridal Crystal Necklace Set is perfect for weddings and grand events. Many brides choose Bridal Crystal Necklace Set for their special day.', 35000.00, '../assets/j19.jpg', 'Jewellery', 1, '2026-03-13 05:42:07'),
(60, 'Volume Boost Eyebrow Pencil', 'Volume Boost Eyebrow Pencil helps shape and define the eyebrows. Volume Boost Eyebrow Pencil creates a natural eyebrow look.\r\n\r\nVolume Boost Eyebrow Pencil has a smooth texture for easy application. The formula of Volume Boost Eyebrow Pencil fills gaps in the brows.\r\n\r\nVolume Boost Eyebrow Pencil is perfect for everyday makeup. Many makeup users rely on Volume Boost Eyebrow Pencil for neat eyebrows.', 1370.00, '../assets/c14.jfif', 'Cosmetics', 1, '2026-03-13 05:43:56'),
(61, 'Herbal Skin Brightening Cream', 'Herbal Skin Brightening Cream helps improve the natural glow of the skin. Herbal Skin Brightening Cream supports a brighter complexion.\r\n\r\nHerbal Skin Brightening Cream contains herbal extracts that nourish the skin. The formula of Herbal Skin Brightening Cream keeps the skin soft.\r\n\r\nHerbal Skin Brightening Cream is suitable for daily skincare routines. Many skincare lovers choose Herbal Skin Brightening Cream for glowing skin.', 2300.00, '../assets/c20.jfif', 'Cosmetics', 1, '2026-03-13 05:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `reviewer_name` varchar(100) DEFAULT NULL,
  `reviewer_email` varchar(150) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `review_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `reviewer_name`, `reviewer_email`, `rating`, `review_text`, `review_date`) VALUES
(1, 35, 'Abdul Hadi', 'abdulhadi@gmai.com', 4, '12345678', '2026-03-10 19:42:52'),
(5, 28, 'sir hamza', 'hamza@gmail.com', 4, 'bhai prodct acha hai', '2026-03-12 11:49:37'),
(6, 61, 'Aysha', 'aysha2594@gmail.com', 3, ' Herbal Skin Brightening Cream is suitable for daily skincare routines. Many skincare lovers choose Herbal Skin Brightening Cream for glowing skin.', '2026-03-13 10:57:03'),
(7, 61, 'Zainab ', 'zainab647@gmail.com', 3, ' Herbal Skin Brightening Cream supports a brighter complexion. Herbal Skin Brightening Cream contains herbal extracts that nourish the skin', '2026-03-13 10:59:02'),
(8, 60, 'Rahila', 'rahila57@gmail.com', 4, 'Volume Boost Eyebrow Pencil is perfect for everyday makeup. Many makeup users rely on Volume Boost Eyebrow Pencil for neat eyebrows.', '2026-03-14 10:37:22'),
(9, 59, 'ahmed', 'ahmed76@gmail.com', 0, 'Bridal Crystal Necklace Set is perfect for weddings and grand events. Many brides choose Bridal Crystal Necklace Set for their special day.', '2026-03-14 10:39:04'),
(10, 59, 'khizar', 'khizar88@gmail.com', 3, 'Bridal Crystal Necklace Set features shining crystals and elegant stones. The design of Bridal', '2026-03-14 10:40:10'),
(11, 58, 'shamasa ', 'shamasa54@gmail.com', 4, '. Many fashion lovers enjoy Antique Silver Statement Necklace.', '2026-03-14 10:41:45'),
(12, 58, 'ramla', 'ramla92@gmail.com', 5, 'Antique Silver Statement Necklace is a bold jewelry piece with a vintage design. Antique Silver Statement Necklace gives a unique traditional look', '2026-03-14 10:42:48'),
(13, 58, 'ramlasaqib', 'ramlasaqib33@gmail.com', 5, '. The design of Antique Silver Statement Necklace is eye catching. Antique Silver Statement Necklace is perfect for traditional outfits', '2026-03-14 10:43:58'),
(14, 58, 'hibbaarshad', 'hibbaarshad37898739@gmail.com', 3, 'Antique Silver Statement Necklace is a bold jewelry piece with a vintage design. Antique Silver Statement Necklace gives a unique traditional look', '2026-03-14 10:45:09'),
(15, 57, 'tahreem', 'tahreem6673@gmail.com', 5, 'Modern Gold Cuff Bracelet is a trendy jewelry accessory with a bold design. Modern Gold Cuff Bracelet adds a fashionable touch to any look.', '2026-03-14 10:46:21'),
(16, 57, 'javeria', 'javeriasadiq@gmail.com', 5, ' Many fashion lovers choose Modern Gold Cuff Bracelet for its unique design.', '2026-03-14 10:47:20'),
(17, 56, 'ayeshabano', 'ayeshabano@gmail.com', 3, 'Minimal Silver Chain Bracelet is a simple yet stylish jewelry piece. Minimal Silver Chain Bracelet gives a modern and elegant look', '2026-03-14 10:48:34'),
(18, 56, 'maidafarooqui', 'maidafarooqui@gmail.com', 4, ' Minimal Silver Chain Bracelet is perfect for daily wear and casual outfits. Many people prefer Minimal Silver Chain Bracelet for its minimalist beauty.', '2026-03-14 10:49:31'),
(19, 55, 'areebamomin', 'areebamomin6675@gmail.com', 3, 'Diamond Style Bracelet is a luxurious bracelet inspired by diamond jewelry. Diamond Style Bracelet gives a glamorous and sophisticated look', '2026-03-14 10:50:42'),
(20, 55, 'khizrafarooqui', 'khizrafarooqui3217@gmail.com', 3, 'Diamond Style Bracelet is a luxurious bracelet inspired by diamond jewelry. Diamond Style Bracelet gives a glamorous and sophisticated look', '2026-03-14 10:51:55'),
(21, 54, 'gulabqamar', 'gulabqamar537@gmail.com', 4, 'Vitamin C Brightening Serum is a powerful skincare product that helps improve skin tone and brightness. ', '2026-03-14 10:53:11'),
(22, 54, 'hajrasadiq', 'hajrasadiq56@gmail.com', 5, 'Vitamin C Brightening Serum absorbs quickly into the skin without leaving a sticky feeling. Many skincare users love Vitamin C Brightening Serum for its glowing results.\r\n\r\n', '2026-03-14 10:54:14'),
(23, 53, 'ayshwariya', 'ayshwariya23374673@gmail.com', 5, 'Hydrating Aloe Vera Face Wash is a gentle cleanser that removes dirt and excess oil from the skin.', '2026-03-14 10:55:19'),
(24, 53, 'sabinaayoub', 'sabinaayoub@47847gmail.com', 4, 'Hydrating Aloe Vera Face Wash is a gentle cleanser that removes dirt and excess oil from the skin. ', '2026-03-14 10:56:10'),
(25, 52, 'maahakfatim', 'maahakfatim7846@gmil.com', 5, 'Velvet Matte Lipstick is a premium beauty product designed to give your lips a rich and elegant matte finish.', '2026-03-14 10:57:22'),
(26, 51, 'tayyabaahmed', 'tayyabaahmed37763@gmail.com', 5, 'Elegant Crystal Drop Earrings are designed to give a classy and sparkling look. Elegant Crystal Drop Earrings beautifully highlight your facial features.', '2026-03-14 10:58:24'),
(27, 51, 'ayeshamustafa', 'ayeshamustafa44826@gmail.com', 3, '. The design of Elegant Crystal Drop Earrings is both modern and stylish. Elegant Crystal Drop Earrings are perfect for parties and formal events. Many fashion lovers prefer Elegant Crystal Drop Earrings for their elegant style.', '2026-03-14 10:59:16'),
(28, 50, 'khalda', 'khalda3563@gmaail.com', 4, ' Luxury Gold Bangle Set is perfect for weddings, parties, and festive occasions. Many women choose Luxury Gold Bangle Set to enhance their jewelry collection.', '2026-03-14 11:01:08'),
(29, 49, 'razia', 'raziia@gmail.com', 4, 'Smooth Finish Compact Powder gives the skin a soft and matte look. Smooth Finish Compact Powder has a silky texture that blends smooth.', '2026-03-14 11:02:00'),
(30, 49, 'Rumaisa', 'rumisa24@gmail.com', 2, 'The formula of Smooth Finish Compact Powder keeps your makeup fresh. Smooth Finish Compact Powder is ideal for daily use and touch ups during the day.', '2026-03-14 11:02:43'),
(31, 48, 'salma ', 'salmasaqib@gmail.com', 4, 'Natural Glow BB Cream is a lightweight beauty product that helps create a smooth and even skin tone.', '2026-03-14 11:03:36'),
(32, 48, 'zakiya', 'zakiya67122@gmail.com', 5, ' Natural Glow BB Cream is perfect for everyday makeup and quick beauty routines. Many people prefer Natural Glow BB Cream for its natural looking finish.', '2026-03-14 11:04:26'),
(33, 46, 'nimraahmed', 'nimraahmed556@gmail.com', 5, 'The formula of Rose Glow Blush gives a natural and radiant finish. Rose Glow Blush is perfect for both light daytime makeup and evening looks. Many beauty lovers use Rose Glow Blush to achieve a healthy glow.', '2026-03-14 11:05:13'),
(34, 46, 'ammaraahmed', 'ammaraahmed73288@gmail.com', 3, 'Rose Glow Blush adds a soft and natural pink glow to the cheeks. Rose Glow Blush enhances your facial features with a fresh and vibrant look.', '2026-03-14 11:05:55'),
(35, 45, 'amina ', 'amina456@gmail.com', 4, 'Silk Touch Liquid Foundation is designed to give your skin a smooth and flawless finish. ', '2026-03-14 11:06:47'),
(36, 45, 'rukhsana', 'rukhsana@gmail.com', 5, 'Silk Touch Liquid Foundation is designed to give your skin a smooth and flawless finish', '2026-03-14 11:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` mediumtext NOT NULL,
  `review_text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `image`, `review_text`, `rating`, `created_at`) VALUES
(22, 'Ayesha Khan', 't2.jfif', 'I ordered a skincare cream and a necklace from Jenny Store. The quality is amazing and packaging was very elegant. Delivery was also very fast. Highly recommended!', 3, '2026-03-13 06:36:19'),
(23, 'Sana Malik', 't1.jfif', 'The lipstick shade I ordered is exactly the same as shown in the pictures. Long lasting and very smooth texture. I will definitely shop again.', 4, '2026-03-13 06:36:57'),
(24, 'Hira Ahmed', 't3.jfif', 'I bought a gold plated bracelet and it looks very beautiful. The design is elegant and perfect for daily wear. Very satisfied with my purchase.', 5, '2026-03-13 06:38:04'),
(25, 'Mahnoor Ali', 't4.jfif', 'Jenny Store has the best beauty products. I ordered a face serum and it worked really well for my skin. My skin feels brighter and smoother now.', 4, '2026-03-13 06:39:23'),
(26, 'Fatima Noor', 't5.jpg', 'The earrings I purchased are absolutely stunning. They look premium and match perfectly with my outfits. Great customer service too.', 5, '2026-03-13 06:40:01'),
(27, 'Zara Sheikh', 't6.jfif', 'Very nice collection of cosmetics. The foundation blends perfectly and gives a natural look. Delivery was on time as well.', 5, '2026-03-13 06:40:39'),
(28, 'Iqra Siddiqui', 't7.jfif', 'I love the jewelry collection on this website. The ring I ordered is beautiful and exactly like the pictures. Very happy with my order.', 5, '2026-03-13 07:08:05'),
(29, 'Komal Raza', 't8.jfif', 'The perfume and makeup products are original and long lasting. Packaging was very secure and professional.', 4, '2026-03-13 07:08:45'),
(30, 'Rabia Khan', 't9.jfif', 'Amazing shopping experience. The necklace and skincare products are high quality. I will recommend Jenny Store to my friends.', 4, '2026-03-13 07:09:30'),
(31, 'Areeba Hussain', 't10.jpg', 'Beautiful designs and affordable prices. I ordered earrings and a lipstick and both were perfect.', 5, '2026-03-13 07:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(50) DEFAULT NULL,
  `user_lastname` varchar(50) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_pass` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_phone`, `user_pass`) VALUES
(1, 'Abdul', 'Hadi', 'rahul@gmail.com', '+920408505', '$2y$10$mkV9EW4xoosUk26UfblTyOimLN22F4sG3pMLrdjSJxhxnH6qDSRSy'),
(2, 'abdul', 'samad', 'abdulsamad2505b@aptechsite.net', '0321324354', '$2y$10$A139izirWKlwqu8HDgHTNOSyZTqiQY8l/NhgkWR/pk3w1jlzwFHDS'),
(3, 'Muhammad', 'Sufiyan', 'sufiyan@gmail.com', '032121212121', '$2y$10$mhdksYtniLLK3okEMfLcTOlW9UNirOINk0.oD3golNvxtJtDt/WQu'),
(5, 'abdul', 'malik', 'abdulmalik12345@gmail.com', '+920408505', '$2y$10$IeCi1X8Qg4oPe4M.C6TzmuL0h6uB12ECueLtKKgGUGfjfu1eLdTUK'),
(6, 'Abdul', 'kamal', 'abdulkamal1234@gmail.com', '+920408505', '$2y$10$uMKqN/KPAN7TS9f2qJRAUe0GxCHYHU8o75yW5p7zYmW9/tQNS.HNa'),
(7, 'Kinza', 'khan', 'kinza21@gmail.com', '+920408505', '$2y$10$Fj0xUUPG2pB9o.47vlWnd.768MtbnTx6hfWmfG5o4clxY2FHutua6'),
(8, 'kashaf', 'khalid', 'kashaf21@gmail.com', '+92829855', '$2y$10$ZG3AR33AWrbRebdJ/j2mPedj.qBzgYn0dFGLVUz2lPGekGxktskfq'),
(9, 'rahila', 'ali', 'rahila123@gmail.com', '+92829855', '$2y$10$ByUh6ekQy1GbvWRglWhuWuIbBhN9tASwEWLmF1kQdlj3np0lEivXK'),
(10, 'shahida', 'bano', 'shahida12@gmail.com', '+920408505', '$2y$10$3ICIVT.6b/DDpA5ROSjM8erBUSmgIaG7.mKXL6lEBkdvrXU6j0.X6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
