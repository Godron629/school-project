-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2017 at 05:18 AM
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
  `emergency_contact_lname` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emergency_contact`
--

INSERT INTO `emergency_contact` (`emergency_contact_id`, `emergency_contact_fname`, `emergency_contact_lname`) VALUES
(62, 'Darlene', 'Richter');

-- --------------------------------------------------------

--
-- Table structure for table `jnct_volunteer_emergency_contact`
--

CREATE TABLE `jnct_volunteer_emergency_contact` (
  `volunteer_emergency_contact_id` int(11) NOT NULL,
  `volunteer_fk` int(11) NOT NULL,
  `emergency_contact_fk` int(11) NOT NULL,
  `relationship` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jnct_volunteer_emergency_contact`
--

INSERT INTO `jnct_volunteer_emergency_contact` (`volunteer_emergency_contact_id`, `volunteer_fk`, `emergency_contact_fk`, `relationship`, `phone`) VALUES
(61, 158, 62, 'Mother', '4034789810'),
(62, 159, 62, 'Nurse', '4039119100');

-- --------------------------------------------------------

--
-- Table structure for table `pref_avail`
--

CREATE TABLE `pref_avail` (
  `pref_avail_id` int(11) NOT NULL,
  `volunteer_fk` int(11) NOT NULL,
  `weekday` varchar(20) DEFAULT NULL,
  `am` varchar(10) DEFAULT NULL,
  `pm` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pref_avail`
--

INSERT INTO `pref_avail` (`pref_avail_id`, `volunteer_fk`, `weekday`, `am`, `pm`) VALUES
(141, 158, 'monday', 'yes', 'yes'),
(142, 158, 'tuesday', 'no', 'no'),
(143, 158, 'wednesday', 'no', 'yes'),
(144, 158, 'thursday', 'no', 'no'),
(145, 158, 'friday', 'yes', 'yes'),
(146, 159, 'monday', 'yes', 'no'),
(147, 159, 'tuesday', 'yes', 'no'),
(148, 159, 'wednesday', 'no', 'no'),
(149, 159, 'thursday', 'no', 'no'),
(150, 159, 'friday', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `pref_dept`
--

CREATE TABLE `pref_dept` (
  `pref_dept_id` int(11) NOT NULL,
  `volunteer_fk` int(11) NOT NULL,
  `department` varchar(30) NOT NULL,
  `allow` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pref_dept`
--

INSERT INTO `pref_dept` (`pref_dept_id`, `volunteer_fk`, `department`, `allow`) VALUES
(69, 158, 'front', 'yes'),
(70, 158, 'vio', 'no'),
(71, 158, 'kitchen', 'no'),
(72, 158, 'warehouse', 'no'),
(73, 159, 'front', 'no'),
(74, 159, 'vio', 'yes'),
(75, 159, 'kitchen', 'no'),
(76, 159, 'warehouse', 'no');

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
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`volunteer_id`, `volunteer_fname`, `volunteer_lname`, `volunteer_email`, `volunteer_birthdate`, `volunteer_gender`, `volunteer_street`, `volunteer_city`, `volunteer_province`, `volunteer_postcode`, `volunteer_primaryphone`, `volunteer_secondaryphone`, `volunteer_status`) VALUES
(158, 'Gideon', 'Richter', 'gideon@hotmail.ca', '2017-02-01', 'male', '33 Chilcotin Dr', 'Lethbridge', 'AB', 'T1K7G9', '4034839810', 'None', 1),
(159, 'Erin', 'Richter', 'erin@hotmail.ca', '2017-03-01', 'female', '33 Chilcotin Dr', 'Lethbridge', 'AB', 'T1K7G9', '4039329810', '4031239810', 1);

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
-- Indexes for table `pref_avail`
--
ALTER TABLE `pref_avail`
  ADD PRIMARY KEY (`pref_avail_id`),
  ADD KEY `volunteer_fk` (`volunteer_fk`);

--
-- Indexes for table `pref_dept`
--
ALTER TABLE `pref_dept`
  ADD PRIMARY KEY (`pref_dept_id`),
  ADD KEY `volunteer_fk` (`volunteer_fk`);

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
  MODIFY `emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `jnct_volunteer_emergency_contact`
--
ALTER TABLE `jnct_volunteer_emergency_contact`
  MODIFY `volunteer_emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `pref_avail`
--
ALTER TABLE `pref_avail`
  MODIFY `pref_avail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;
--
-- AUTO_INCREMENT for table `pref_dept`
--
ALTER TABLE `pref_dept`
  MODIFY `pref_dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;
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
-- Constraints for table `pref_avail`
--
ALTER TABLE `pref_avail`
  ADD CONSTRAINT `pref_avail_ibfk_1` FOREIGN KEY (`volunteer_fk`) REFERENCES `volunteer` (`volunteer_id`) ON UPDATE CASCADE;

--
-- Constraints for table `pref_dept`
--
ALTER TABLE `pref_dept`
  ADD CONSTRAINT `pref_dept_ibfk_1` FOREIGN KEY (`volunteer_fk`) REFERENCES `volunteer` (`volunteer_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
