-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2023 at 11:15 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bankdb`
--
CREATE DATABASE IF NOT EXISTS `bankdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bankdb`;

-- --------------------------------------------------------

--
-- Table structure for table `finalusers`
--

CREATE TABLE `finalusers` (
  `email` varchar(150) NOT NULL,
  `country` varchar(150) NOT NULL,
  `region` varchar(150) NOT NULL,
  `city` varchar(150) NOT NULL,
  `street` varchar(150) NOT NULL,
  `number` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `finalusers`
--

INSERT INTO `finalusers` (`email`, `country`, `region`, `city`, `street`, `number`) VALUES
('teszt1@gmail.com', 'Romania', 'Hargita', 'Csikszereda', 'Sziv', 64),
('teszt2@gmail.com', 'Romania', 'Hargita', 'Gyergyo', 'Revolucio', 72);


-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `datum` date NOT NULL,
  `tipus` varchar(150) NOT NULL,
  `ertek` int(150) NOT NULL,
  `szamlaszam` varchar(150) NOT NULL,
  `uzenet` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`datum`, `tipus`, `ertek`, `szamlaszam`, `uzenet`) VALUES
('2023-02-02', 'Penz feltoltes', 5000, 'RO5650556732', 'Nincs megjegyzes'),
('2023-02-02', 'Penz kiveves', 5000, 'RO5650556732', 'Nincs megjegyzes'),
('2023-02-02', 'Penz feltoltes', 5000, 'RO5650556732', 'Nincs megjegyzes'),
('2023-02-02', 'Penzt utalt', 2000, 'RO5650556732', 'hello'),
('2023-02-02', 'Penzt kapott', 2000, 'RO3125040756', 'hello');


-- --------------------------------------------------------

--
-- Table structure for table `registeredusers`
--

CREATE TABLE `registeredusers` (
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `cnp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registeredusers`
--

INSERT INTO `registeredusers` (`fname`, `lname`, `email`, `password`, `cnp`) VALUES
('John', 'Doe', 'teszt1@gmail.com', 'jelszo', 1890713647),
('Jane', 'Doe', 'teszt2@gmail.com', 'jelszo', 2921122647);

-- --------------------------------------------------------

--
-- Table structure for table `userpersonal`
--

CREATE TABLE `userpersonal` (
  `email` varchar(150) NOT NULL,
  `szamlaszam` varchar(150) NOT NULL,
  `pin` int(15) NOT NULL,
  `egyenleg` int(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userpersonal`
--

INSERT INTO `userpersonal` (`email`, `szamlaszam`, `pin`, `egyenleg`) VALUES
('teszt1@gmail.com', 'RO5650556732', 5101, 0),
('teszt2@gmail.com', 'RO3125040756', 8605, 0);


--
-- Indexes for dumped tables
--

--
-- Indexes for table `finalusers`
--
ALTER TABLE `finalusers`
  ADD KEY `useremail` (`email`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD KEY `szamlaszam` (`szamlaszam`);

--
-- Indexes for table `registeredusers`
--
ALTER TABLE `registeredusers`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `userpersonal`
--
ALTER TABLE `userpersonal`
  ADD PRIMARY KEY (`szamlaszam`),
  ADD KEY `email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `finalusers`
--
ALTER TABLE `finalusers`
  ADD CONSTRAINT `finalusers_ibfk_1` FOREIGN KEY (`email`) REFERENCES `registeredusers` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`szamlaszam`) REFERENCES `userpersonal` (`szamlaszam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userpersonal`
--
ALTER TABLE `userpersonal`
  ADD CONSTRAINT `userpersonal_ibfk_1` FOREIGN KEY (`email`) REFERENCES `registeredusers` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
