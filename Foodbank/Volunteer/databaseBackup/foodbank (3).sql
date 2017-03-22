-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2017 at 11:27 PM
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
  `calendar_shift` varchar(20) NOT NULL,
  `crossed_out` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar_entry`
--

INSERT INTO `calendar_entry` (`calendar_entry_id`, `volunteer_id`, `calendar_date`, `calendar_dept`, `calendar_shift`, `crossed_out`) VALUES
(1, 1, '2017-02-22', 'Kitchen', 'Morning', 0),
(2, 1, '2017-02-23', 'Kitchen', 'Morning', 0),
(3, 2, '2017-02-22', 'Kitchen', 'Morning', 0),
(4, 1, '2017-02-01', 'Kitchen', 'Morning', 0),
(5, 2, '2017-02-01', 'Kitchen', 'Morning', 0),
(6, 1, '2017-02-02', 'Kitchen', 'Morning', 0),
(7, 2, '2017-02-02', 'Kitchen', 'Morning', 0),
(8, 1, '2017-02-03', 'Kitchen', 'Morning', 0),
(9, 2, '2017-02-03', 'Kitchen', 'Morning', 0),
(10, 1, '2017-02-04', 'Kitchen', 'Morning', 0),
(11, 2, '2017-02-04', 'Kitchen', 'Morning', 0),
(12, 1, '2017-03-13', 'Front', 'Afternoon', 0),
(14, 4, '2017-03-13', 'Front', 'Morning', 0),
(15, 1, '2017-03-14', 'Front', 'Morning', 0),
(16, 2, '2017-03-14', 'Front', 'Morning', 0),
(17, 4, '2017-03-14', 'Front', 'Morning', 0),
(18, 1, '2017-03-15', 'Front', 'Morning', 1),
(19, 2, '2017-03-15', 'Front', 'Morning', 1),
(20, 4, '2017-03-15', 'Front', 'Morning', 0),
(21, 1, '2017-03-17', 'Front', 'Morning', 0),
(22, 2, '2017-03-17', 'Front', 'Morning', 0),
(23, 4, '2017-03-17', 'Front', 'Morning', 0),
(24, 7, '2017-03-14', 'Warehouse', 'Afternoon', 0),
(26, 3, '2017-03-13', 'Front', 'Morning', 0),
(27, 3, '2017-03-14', 'Front', 'Morning', 0),
(28, 3, '2017-03-15', 'Front', 'Morning', 0),
(29, 3, '2017-03-16', 'Front', 'Morning', 0),
(30, 4, '2017-03-16', 'Front', 'Morning', 0),
(31, 3, '2017-03-17', 'Front', 'Morning', 0);

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
(1, 'Darlene', 'Richter'),
(2, 'Chocolate', 'Nancy'),
(3, 'Tim', 'Franz'),
(4, 'Barry ', 'Robinson'),
(5, 'Simone', 'Poland'),
(6, 'Jeffery', 'Stone'),
(7, 'Norm', 'Nelson'),
(13, 'Ryan', 'BadIdea'),
(14, 'Travis', 'Mom');

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
(1, 1, 1, 'Mother', '4034789810'),
(2, 2, 1, 'Mother', '4034789810'),
(3, 3, 2, 'Significant Other', '4039620982'),
(4, 4, 3, 'Teacher', '4035738596'),
(5, 5, 4, 'Teacher', '4037588947'),
(6, 6, 5, 'Friend', '1239329810'),
(7, 7, 1, 'Wife', '4034789810');

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
(1, 1, 'monday', 'yes', 'no'),
(2, 1, 'tuesday', 'yes', 'no'),
(3, 1, 'wednesday', 'no', 'no'),
(4, 1, 'thursday', 'no', 'yes'),
(5, 1, 'friday', 'no', 'yes'),
(6, 2, 'monday', 'no', 'no'),
(7, 2, 'tuesday', 'no', 'yes'),
(8, 2, 'wednesday', 'no', 'yes'),
(9, 2, 'thursday', 'no', 'yes'),
(10, 2, 'friday', 'no', 'no'),
(11, 3, 'monday', 'no', 'no'),
(12, 3, 'tuesday', 'yes', 'no'),
(13, 3, 'wednesday', 'yes', 'no'),
(14, 3, 'thursday', 'no', 'no'),
(15, 3, 'friday', 'no', 'yes'),
(16, 4, 'monday', 'yes', 'yes'),
(17, 4, 'tuesday', 'yes', 'yes'),
(18, 4, 'wednesday', 'yes', 'yes'),
(19, 4, 'thursday', 'no', 'no'),
(20, 4, 'friday', 'no', 'no'),
(21, 5, 'monday', 'no', 'no'),
(22, 5, 'tuesday', 'no', 'no'),
(23, 5, 'wednesday', 'yes', 'no'),
(24, 5, 'thursday', 'yes', 'yes'),
(25, 5, 'friday', 'yes', 'yes'),
(26, 6, 'monday', 'no', 'no'),
(27, 6, 'tuesday', 'no', 'no'),
(28, 6, 'wednesday', 'yes', 'no'),
(29, 6, 'thursday', 'no', 'no'),
(30, 6, 'friday', 'no', 'no'),
(31, 7, 'monday', 'yes', 'yes'),
(32, 7, 'tuesday', 'yes', 'yes'),
(33, 7, 'wednesday', 'yes', 'yes'),
(34, 7, 'thursday', 'yes', 'yes'),
(35, 7, 'friday', 'yes', 'yes');

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
(1, 1, 'front', 'no'),
(2, 1, 'vio', 'no'),
(3, 1, 'kitchen', 'no'),
(4, 1, 'warehouse', 'yes'),
(5, 2, 'front', 'no'),
(6, 2, 'vio', 'no'),
(7, 2, 'kitchen', 'yes'),
(8, 2, 'warehouse', 'no'),
(9, 3, 'front', 'no'),
(10, 3, 'vio', 'yes'),
(11, 3, 'kitchen', 'no'),
(12, 3, 'warehouse', 'no'),
(13, 4, 'front', 'no'),
(14, 4, 'vio', 'no'),
(15, 4, 'kitchen', 'no'),
(16, 4, 'warehouse', 'no'),
(17, 5, 'front', 'yes'),
(18, 5, 'vio', 'yes'),
(19, 5, 'kitchen', 'yes'),
(20, 5, 'warehouse', 'yes'),
(21, 6, 'front', 'no'),
(22, 6, 'vio', 'yes'),
(23, 6, 'kitchen', 'yes'),
(24, 6, 'warehouse', 'no'),
(25, 7, 'front', 'no'),
(26, 7, 'vio', 'yes'),
(27, 7, 'kitchen', 'yes'),
(28, 7, 'warehouse', 'yes');

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
(1, 'Gideon', 'Richter', 'gideonrich@hotmail.ca', '1996-02-13', 'male', '33 Chilcotin Rd W', 'Lethbridge', 'AB', 'T1K7G9', '4034839810', 'None', 1),
(2, 'Erin ', 'Richter', 'erin@hotmail.ca', '1994-03-17', 'female', 'Beaver St.', 'Red Lake', 'ON', 'T8K4I9', '4034919810', 'None', 1),
(3, 'Jeff ', 'Emshey', 'jeff@hotmail.ca', '1992-08-14', 'male', 'Poverty Rd.', 'Lethbridge', 'AB', 'T2K8J0', '4033594343', 'None', 1),
(4, 'Brayden', 'Sipko', 'brayden@hotmail.ca', '1990-10-04', 'male', 'Egg Rd ', 'Lethbridge', 'AB', 'T3F9G4', '4034769180', 'None', 1),
(5, 'Ryan ', 'Lockett', 'ryan@hotmail.ca', '1996-03-01', 'male', 'Ryans House', 'Lethbridge', 'AB', 'T2G9G0', '4039998594', 'None', 1),
(6, 'Edith', 'Denton', 'edith@hotmail.ca', '1997-04-15', 'female', 'Humber College', 'Toronto', 'ON', 'T8F9K0', '4038597584', 'None', 1),
(7, 'Mike', 'Richter', 'mike@telus.net', '1960-03-08', 'male', '8 Glenhill Crescent', 'Cochrane', 'AB', 'T4C1G7', '4039329810', 'None', 1);

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
  MODIFY `calendar_entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `emergency_contact`
--
ALTER TABLE `emergency_contact`
  MODIFY `emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `jnct_volunteer_emergency_contact`
--
ALTER TABLE `jnct_volunteer_emergency_contact`
  MODIFY `volunteer_emergency_contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `pref_avail`
--
ALTER TABLE `pref_avail`
  MODIFY `pref_avail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `pref_dept`
--
ALTER TABLE `pref_dept`
  MODIFY `pref_dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `jnct_volunteer_emergency_contact`
--
ALTER TABLE `jnct_volunteer_emergency_contact`
  ADD CONSTRAINT `jnct_volunteer_emergency_contact_ibfk_1` FOREIGN KEY (`volunteer_fk`) REFERENCES `volunteer` (`volunteer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jnct_volunteer_emergency_contact_ibfk_2` FOREIGN KEY (`emergency_contact_fk`) REFERENCES `emergency_contact` (`emergency_contact_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pref_avail`
--
ALTER TABLE `pref_avail`
  ADD CONSTRAINT `pref_avail_ibfk_1` FOREIGN KEY (`volunteer_fk`) REFERENCES `volunteer` (`volunteer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pref_dept`
--
ALTER TABLE `pref_dept`
  ADD CONSTRAINT `pref_dept_ibfk_1` FOREIGN KEY (`volunteer_fk`) REFERENCES `volunteer` (`volunteer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
