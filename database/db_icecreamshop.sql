-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 05:03 PM
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
-- Database: `db_icecreamshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `price` int(50) NOT NULL,
  `qty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `id` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `seller_id` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `address_type` varchar(30) NOT NULL,
  `method` varchar(30) NOT NULL,
  `product_id` varchar(30) NOT NULL,
  `price` int(10) NOT NULL,
  `qty` int(2) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'In Progress',
  `payment_status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(30) NOT NULL,
  `seller_id` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL,
  `product_detail` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `name`, `price`, `image`, `stock`, `product_detail`, `status`) VALUES
('FTye6Z0bMrxM4aiU8qir', 'zbGZSnYthMgxn3k6aZTp', 'Cookies & Cream', 75, 'prod1.jpg', 10, 'Indulge in creamy vanilla ice cream swirled with chunks of chocolate cookies for the ultimate sweet treat that&#39;s both classic and comforting.', 'Active'),
('YeoVj78icnEqGSlOATCN', 'zbGZSnYthMgxn3k6aZTp', 'Mango', 60, 'prod2.jpg', 8, 'Transport yourself to a tropical paradise with every scoop of our refreshing mango ice cream, bursting with the vibrant flavor of sun-ripened mangoes.', 'Active'),
('5DvAilhG18PrMV4wnszd', 'zbGZSnYthMgxn3k6aZTp', 'strawberry', 80, 'prod3.jpg', 15, 'Dive into a bowl of summer bliss with our luscious strawberry ice cream, made with ripe, juicy strawberries for a fruity explosion in every bite.', 'Active'),
('yMp9Csa7p4QKLLPsMOEf', 'zbGZSnYthMgxn3k6aZTp', 'Vanilla', 60, 'prod4.jpg', 15, 'Experience pure delight with our creamy vanilla ice cream, crafted with the finest Madagascar vanilla beans for a rich and aromatic flavor that&#39;s simply irresistible.', 'Active'),
('7CqRdAFOKUwDNSTcZsAr', 'zbGZSnYthMgxn3k6aZTp', 'macha', 60, 'prod5.jpg', 9, 'Elevate your taste buds with the unique and exquisite flavor of our matcha green tea ice cream, blending delicate green tea notes with creamy goodness.\r\n', 'Active'),
('AaILmy9Dhs7Q6wbbRVOm', 'zbGZSnYthMgxn3k6aZTp', 'chocolate', 70, 'prod6.jpg', 13, 'Surrender to temptation with our decadent chocolate ice cream, made with the finest cocoa for a rich, velvety texture that will satisfy any chocolate lover&#39;s cravings.', 'Active'),
('KayQDQ6hOC9eeMzxHnpY', 'zbGZSnYthMgxn3k6aZTp', 'blueberry', 65, 'prod7.jpg', 5, 'Delight in the sweet and tangy taste of summer with our blueberry ice cream, brimming with plump, juicy blueberries for a burst of flavor in every spoonful.', 'Active'),
('xDcJ3gwp3yf99aVtHViW', 'zbGZSnYthMgxn3k6aZTp', 'Double Dutch', 65, 'double.png', 10, 'Get ready for a flavor explosion with our Double Dutch ice cream, combining rich chocolate and creamy vanilla swirled together with fudge and chocolate chips for a doubly delicious treat.', 'Active'),
('hAezCkhkRuMWt217WF83', 'zbGZSnYthMgxn3k6aZTp', 'Rocky Road', 70, 'rocky.png', 6, 'Embark on a rocky road adventure with our indulgent ice cream, packed with chocolate chunks, marshmallows, and crunchy nuts for a truly satisfying flavor experience.', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(30) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
