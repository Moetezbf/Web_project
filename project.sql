-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2024 at 01:33 AM
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
-- Database: `project`
--

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
(6, 'fahmi', 'fahmi@gmail.com', 123456789, 25836945, 24, 2222222, 'd9e6762dd1c8eaf6d61b3c6192fc408d4d6d5f1176d0c29169bc24e71c3f274ad27fcd5811b313d681f7e55ec02d73d499c95455b6b5bb503acf574fba8ffe85'),
(7, 'ahmed', 'ahmed@gmail.com', 114445, 9413451, 24, 2222555, '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2'),
(8, 'kaiji', 'k@k', 111444, 11225, 25, 5555777, '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2'),
(12, 'kaiji', 'k@k.com', 4444, 454, 52, 445454, '8ab3361c051a97ddc3c665d29f2762f8ac4240d08995f8724b6d07d8cbedd32c28f589ccdae514f20a6c8eea6f755408dd3dd6837d66932ca2352eaeab594427');

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
(4, 2, 'profile.png', './uploads/2/profile.png', '2024-04-10 23:27:40'),
(5, 7, 'profile_4x-1576817779.jpg', './uploads/7/profile_4x-1576817779.jpg', '2024-04-24 00:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id_location` int(11) NOT NULL,
  `id_vehicule` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `ville_reservation` varchar(100) DEFAULT NULL,
  `cout_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voiture`
--

CREATE TABLE `voiture` (
  `id_voiture` int(11) NOT NULL,
  `matricule` varchar(50) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `annee_de_fabrication` int(11) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `prix_par_jour` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voiture`
--

INSERT INTO `voiture` (`id_voiture`, `matricule`, `marque`, `modele`, `annee_de_fabrication`, `couleur`, `prix_par_jour`) VALUES
(1, 'FVM922', 'Ford', 'Ford', 0, 'White', 35.00),
(2, 'RNS824', 'Golf 7', 'Golf 7', 0, 'Yellow', 60.00),
(3, 'VTD406', 'White-Mini-Cooper', 'Mini Cooper', 0, 'Red', 50.00),
(4, 'KVA571', 'Renault-Megane', 'Renault Megane', 0, 'Blue', 45.00),
(5, 'NBT545', 'Volkswagen8', 'Golf 8', 0, 'Blue', 55.00),
(6, 'KJR237', 'kia', 'Kia Sportage', 0, 'Black', 52.00),
(7, 'VXA381', 'hundai', 'Hundai', 0, 'Red', 30.00),
(8, 'AVY379', 'golf8', 'Golf', 0, 'Gray', 40.00),
(9, 'FGT943', 'golf7', 'Golf 7', 0, 'Silver', 37.00),
(10, 'MGX795', 'Ford-Transit', 'Ford Transit', 0, 'White', 60.00),
(11, 'YAI598', 'BMW', 'BMW', 0, 'Orange', 54.00),
(12, 'MWY188', 'audi', 'Audi', 0, 'Gray', 58.00);

-- --------------------------------------------------------

--
-- Table structure for table `voiture_images`
--

CREATE TABLE `voiture_images` (
  `id` int(11) NOT NULL,
  `voiture_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `upload_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voiture_images`
--

INSERT INTO `voiture_images` (`id`, `voiture_id`, `image_name`, `image_path`, `upload_timestamp`) VALUES
(1, 1, 'Ford', './assets/img/clients/Ford.png', '2024-04-10 02:07:25'),
(2, 2, 'Golf 7', './assets/img/clients/golf7.png', '2024-04-10 02:07:25'),
(3, 3, 'Mini Cooper', './assets/img/clients/White-Mini-Cooper.png', '2024-04-10 02:07:25'),
(4, 4, 'Renault Megane', './assets/img/clients/Renault-Megane.png', '2024-04-10 02:07:25'),
(5, 5, 'Golf 8', './assets/img/clients/Volkswagen8.png', '2024-04-10 02:07:25'),
(6, 6, 'Kia Sportage', './assets/img/clients/kia.jpg', '2024-04-10 02:07:25'),
(7, 7, 'Hundai', './assets/img/clients/hundai.jpg', '2024-04-10 02:07:25'),
(8, 8, 'Golf', './assets/img/clients/golf8.png', '2024-04-10 02:07:25'),
(9, 9, 'Golf 7', './assets/img/clients/golf7.png', '2024-04-10 02:07:25'),
(10, 10, 'Ford Transit', './assets/img/clients/Ford-Transit.jpg', '2024-04-10 02:07:25'),
(11, 11, 'BMW', './assets/img/clients/BMW.jpg', '2024-04-10 02:07:25'),
(12, 12, 'Audi', './assets/img/clients/audi.png', '2024-04-10 02:07:25');

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
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_location`),
  ADD KEY `id_vehicule` (`id_vehicule`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id_voiture`),
  ADD UNIQUE KEY `matricule` (`matricule`);

--
-- Indexes for table `voiture_images`
--
ALTER TABLE `voiture_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voiture_images_ibfk_1` (`voiture_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `clients_images`
--
ALTER TABLE `clients_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `voiture_images`
--
ALTER TABLE `voiture_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients_images`
--
ALTER TABLE `clients_images`
  ADD CONSTRAINT `clients_images_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `voiture` (`id_voiture`),
  ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`);

--
-- Constraints for table `voiture_images`
--
ALTER TABLE `voiture_images`
  ADD CONSTRAINT `voiture_images_ibfk_1` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id_voiture`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
