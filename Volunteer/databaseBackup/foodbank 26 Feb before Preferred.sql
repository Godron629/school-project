-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2017 at 06:04 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar_entry`
--

CREATE TABLE `calendar_entry` (
  `calendar_entry_id` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL,
  `calendar_date` date NOT NULL,
  `calendar_dept` varchar(32) NOT NULL,
  `calendar_shift` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar_entry`
--

INSERT INTO `calendar_entry` (`calendar_entry_id`, `volunteer_id`, `calendar_date`, `calendar_dept`, `calendar_shift`) VALUES
(1, 1, '2017-02-22', 'Kitchen', 'Morning'),
(2, 1, '2017-02-23', 'Kitchen', 'Morning'),
(3, 2, '2017-02-22', 'Kitchen', 'Morning'),
(4, 1, '2017-02-01', 'Kitchen', 'Morning'),
(5, 2, '2017-02-01', 'Kitchen', 'Morning'),
(6, 1, '2017-02-02', 'Kitchen', 'Morning'),
(7, 2, '2017-02-02', 'Kitchen', 'Morning'),
(8, 1, '2017-02-03', 'Kitchen', 'Morning'),
(9, 2, '2017-02-03', 'Kitchen', 'Morning'),
(10, 1, '2017-02-04', 'Kitchen', 'Morning'),
(11, 2, '2017-02-04', 'Kitchen', 'Morning');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contact`
--

CREATE TABLE `emergency_contact` (
  `emergency_contact_id` int(11) NOT NULL,
  `emergency_contact_fname` varchar(32) NOT NULL,
  `emergency_contact_lname` varchar(32) NOT NULL,
  `emergency_contact_phone` varchar(20) NOT NULL,
  `emergency_contact_relationship` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jnct_volunteer_emergency_contact`
--

CREATE TABLE `jnct_volunteer_emergency_contact` (
  `volunteer_emergency_contact_id` int(11) NOT NULL,
  `volunteer_fk` int(11) NOT NULL,
  `emergency_contact_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `preferred_avail`
--

CREATE TABLE `preferred_avail` (
  `volunteer_id_fk` int(11) NOT NULL,
  `pref_weekday` varchar(20) NOT NULL,
  `pref_shift` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `volunteer_id` int(11) NOT NULL,
  `volunteer_fname` varchar(32) NOT NULL,
  `volunteer_lname` varchar(32) NOT NULL,
  `volunteer_email` varchar(64) NOT NULL,
  `volunteer_birthdate` date NOT NULL,
  `volunteer_gender` varchar(32) NOT NULL,
  `volunteer_street` varchar(32) NOT NULL,
  `volunteer_city` varchar(32) NOT NULL,
  `volunteer_province` varchar(32) NOT NULL,
  `volunteer_postcode` varchar(10) NOT NULL,
  `volunteer_primaryphone` varchar(20) NOT NULL,
  `volunteer_secondaryphone` varchar(20) DEFAULT 'None',
  `volunteer_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar_entry`
--
ALTER TABLE `calendar_entry`
  ADD PRIMARY KEY (`calendar_entry_id`);

--
-- Indexes for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  ADD UNIQUE KEY `emergency_contact_id` (`emergency_contact_id`);

--
-- Indexes for table `jnct_volunteer_emergency_contact`
--
ALTER TABLE `jnct_volunteer_emergency_contact`
  ADD PRIMARY KEY (`volunteer_emergency_contact_id`),
  ADD KEY `volunteer_fk` (`volunteer_fk`),
  ADD KEY `emergency_contact_fk` (`emergency_contact_fk`);

--
-- Indexes for table `preferred_avail`
--
ALTER TABLE `preferred_avail`
  ADD PRIMARY KEY (`volunteer_id_fk`),
  ADD KEY `volunteer_id_fk` (`volunteer_id_fk`),
  ADD KEY `pref_weekday` (`pref_weekday`),
  ADD KEY `pref_shift` (`pref_shift`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`volunteer_id`),
  ADD KEY `volunteer_id` (`volunteer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar_entry`
--
ALTER TABLE `calendar_entry`
  MODIFY `calendar_entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  MODIFY `emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jnct_volunteer_emergency_contact`
--
ALTER TABLE `jnct_volunteer_emergency_contact`
  MODIFY `volunteer_emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `jnct_volunteer_emergency_contact`
--
ALTER TABLE `jnct_volunteer_emergency_contact`
  ADD CONSTRAINT `jnct_volunteer_emergency_contact_ibfk_1` FOREIGN KEY (`volunteer_fk`) REFERENCES `volunteer` (`volunteer_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `jnct_volunteer_emergency_contact_ibfk_2` FOREIGN KEY (`emergency_contact_fk`) REFERENCES `emergency_contact` (`emergency_contact_id`) ON UPDATE CASCADE;

--
-- Constraints for table `preferred_avail`
--
ALTER TABLE `preferred_avail`
  ADD CONSTRAINT `preferred_avail_ibfk_1` FOREIGN KEY (`volunteer_id_fk`) REFERENCES `volunteer` (`volunteer_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
