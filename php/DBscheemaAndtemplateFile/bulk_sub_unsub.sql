-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2022 at 02:14 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bulk_sub_unsub`
--

-- --------------------------------------------------------

--
-- Table structure for table `bulk_sub_unsub_job`
--

CREATE TABLE `bulk_sub_unsub_job` (
  `id` int(11) NOT NULL,
  `paid_wall_id` int(11) NOT NULL,
  `paid_wall_code` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT -100 COMMENT '-100=created\n0=ready\n20=running\n40=pause\n60-reuse\n100=completed\n',
  `action` int(11) NOT NULL COMMENT '100=sub\n200=unsub ',
  `upload_dt` datetime DEFAULT NULL,
  `file_name` varchar(45) DEFAULT NULL,
  `max_ptr` int(11) DEFAULT NULL,
  `last_ptr` int(11) DEFAULT NULL,
  `generated_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `paid_wall_id` int(11) NOT NULL,
  `paid_wall_name` varchar(45) NOT NULL,
  `sub_url` varchar(200) DEFAULT NULL,
  `unsub_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `services_payplan`
--

CREATE TABLE `services_payplan` (
  `id` int(11) NOT NULL,
  `paid_wall_id` int(11) NOT NULL,
  `paid_point_description` varchar(1024) NOT NULL,
  `paid_wall_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulk_sub_unsub_job`
--
ALTER TABLE `bulk_sub_unsub_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_payplan`
--
ALTER TABLE `services_payplan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulk_sub_unsub_job`
--
ALTER TABLE `bulk_sub_unsub_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services_payplan`
--
ALTER TABLE `services_payplan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
