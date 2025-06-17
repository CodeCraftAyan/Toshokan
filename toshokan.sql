-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 04:04 PM
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
-- Database: `toshokan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `name`, `email`, `password`, `role`) VALUES
(2, 'Ayan Mandal', 'mandalayan624@gmail.com', '$2y$10$Ps7kHietJbK432TpRzToheBh0j7OSm/zailG0AGlm6N5XozKqrWpO', 'admin'),
(3, 'Arnab Das', 'arnab4373@gmail.com', '$2y$10$SNmDqPaOR0xFwuAJPqI7Je9gbsV.r2XMotbN5DaOzoPkmmkS1kh9K', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `author_bio` varchar(1000) NOT NULL,
  `author_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `author_name`, `nationality`, `author_bio`, `author_image`) VALUES
(2, 'Jonathan Hickman', 'american', 'Jonathan Hickman is an American comic book writer and artist, best known for his creator-owned series The Nightly News, The Manhattan Projects and East of West, as well as his lengthy stints as a writer on Marvel\'s Fantastic Four, The Avengers and The New Avengers.', 'uploads/6713972b45d515.65062021.jpeg'),
(11, ' Sui Ishida', 'japanese', 'Sui Ishida (Japanese: 石田 スイ, Hepburn: Ishida Sui, born December 28, 1986) is a Japanese manga artist. He is popularly known for his dark fantasy manga series Tokyo Ghoul and Choujin X.', 'uploads/6713974159fee0.22835972.jpeg'),
(12, 'Kentaro Miura', 'japanese', 'Kentarou Miura was born in Chiba City, Japan, in 1966. While attending college at Nihon University, in 1988, Miura debuted a 48-page manga known as Berserk Prototype, an introduction to the current Berserk fantasy world. It went on to win Miura a prize from the Comi Manga School.', 'uploads/6713974c470296.26155526.jpg'),
(13, 'Chugong', 'south_korean', 'Chugong is known for Solo Leveling (2024), Solo Leveling - ReAwakening (2024) and Solo Leveling, Vol. I (2021).', 'uploads/6713975c3ba3b1.28279216.jpg'),
(14, 'Stan Lee', 'american', 'died November 12, 2018, Los Angeles, California) was an American comic book writer best known for his work with Marvel Comics. Among the hundreds of characters and teams that he helped to create were the Fantastic Four, Spider-Man, the Avengers, and the X-Men.', 'uploads/67139704854be2.66368020.webp');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `rating` float NOT NULL,
  `book_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `book_name`, `author_name`, `rating`, `book_image`) VALUES
(11, 'The Jungle Book ', 'Rudyard Kipling', 7.6, 'uploads/moogli.jpeg'),
(12, 'Secret Wars ', 'Jonathan Hickman', 9.6, 'uploads/secret war.jpeg'),
(15, 'Tokyo Ghoul - Vol 1', ' Sui Ishida', 9.2, 'uploads/tokiyo goal.jpg'),
(16, 'Berserk - Vol 1', 'Kentaro Miura', 8.7, 'uploads/berserk.jpg'),
(17, 'Solo Leveling', 'Chugong', 8.3, 'uploads/solo.webp'),
(18, 'The X-Men', 'Stan Lee', 7.2, 'uploads/portrait_uncanny.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `borrow_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('issued','returned') NOT NULL DEFAULT 'issued'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`borrow_id`, `admin_id`, `book_id`, `borrow_date`, `due_date`, `return_date`, `status`) VALUES
(13, 2, 15, '2024-10-19', '2024-11-02', '2024-10-19', 'returned'),
(14, 2, 16, '2024-10-19', '2024-11-02', '2024-10-19', 'returned'),
(15, 3, 18, '2024-10-19', '2024-11-02', '2024-10-20', 'returned'),
(16, 3, 18, '2024-10-19', '2024-11-02', '2024-10-19', 'returned'),
(17, 2, 17, '2024-10-20', '2024-11-03', '2024-10-21', 'returned'),
(18, 2, 16, '2024-10-21', '2024-11-04', '2024-10-23', 'returned');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `borrows_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrows_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
