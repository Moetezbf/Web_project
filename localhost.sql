-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 21, 2024 at 12:30 AM
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
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--


-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--


-- ---------------------------------------------------------

-- Database: `project`
--
CREATE DATABASE IF NOT EXISTS `project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project`;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `CIN` int(11) NOT NULL,
  `numtel` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `licenseNum` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `CIN`, `numtel`, `age`, `licenseNum`, `password`) VALUES
(1, 'ahmedDFreecs', 'DFreecs@gmail.com', 1234000, 98661215, 24, 10000255, '856a307f2c7f3b6b52198a7d2bb3843ad397e09b0bbba9dd140af2da8e6bbd3f528952110a09ac77167ba77bf2c3e3a393d7b47432aba9827843e51adb22780f'),
(2, 'ging', 'ging@gmail.com', 123456, 645231, 25, 222222555, '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2'),
(3, 'gon', 'gon@gmail.com', 1234560012, 215698730, 12, 125463078, 'cd17d963a84d81c5b31a71314b1800d1921c9fdbc518490d95109f574428f633e80d10a3bac8b3166a334f6516061034cc2b6b30ba6f02d3ef897b34979e03b6'),
(4, 'ahmed', 'a@gmail.com', 14725836, 94134518, 24, 12369587, 'cf83e1357eefb8bdf1542850d66d8007d620e4050b5715dc83f4a921d36ce9ce47d0d13c5d85f2b0ff8318d2877eec2f63b931bd47417a81a538327af927da3e'),
(5, 'ahmed', 'h@h.com', 10000, 14752, 20, 122654, '16b7aa7f7e549ba129c776bb91ce1e692da103271242d44a9bc145cf338450c90132496ead2530f527b1bd7f50544f37e7d27a2d2bbb58099890aa320f40aca9'),
(6, 'fahmi', 'fahmi@gmail.com', 123456789, 25836945, 24, 2222222, 'd9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85');

-- --------------------------------------------------------

--
-- Table structure for table `clients_images`
--

CREATE TABLE `clients_images` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `upload_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients_images`
--

INSERT INTO `clients_images` (`id`, `client_id`, `image_name`, `image_path`, `upload_timestamp`) VALUES
(1, 2, 'profile.png', './uploads/2/profile.png', '2024-03-19 08:02:11'),
(2, 2, 'profile_4x-1576817779.jpg', './uploads/2/profile_4x-1576817779.jpg', '2024-03-19 11:10:08'),
(3, 6, 'profile_4x-1576817779.jpg', './uploads/6/profile_4x-1576817779.jpg', '2024-03-20 00:51:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `licenseNum` (`licenseNum`),
  ADD UNIQUE KEY `CIN` (`CIN`),
  ADD UNIQUE KEY `CIN_2` (`CIN`);

--
-- Indexes for table `clients_images`
--
ALTER TABLE `clients_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clients_images`
--
ALTER TABLE `clients_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients_images`
--
ALTER TABLE `clients_images`
  ADD CONSTRAINT `clients_images_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test`;
--
-- Database: `testdb`
--
CREATE DATABASE IF NOT EXISTS `testdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `testdb`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'ahmed', 'ahmed@gmail.com', '1234'),
(2, 'ging', 'ging@gmail.com', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
