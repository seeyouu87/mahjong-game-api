-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2017 at 04:24 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mahjong`
--

-- --------------------------------------------------------

--
-- Table structure for table `gameroom`
--

CREATE TABLE `gameroom` (
  `roomid` int(11) NOT NULL,
  `roomlevel` int(11) NOT NULL,
  `roompoints` int(11) NOT NULL,
  `roomname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gameroom`
--

INSERT INTO `gameroom` (`roomid`, `roomlevel`, `roompoints`, `roomname`) VALUES
(1, 10, 1000, 'beginner room'),
(2, 20, 2000, 'Intermediate Room');

-- --------------------------------------------------------

--
-- Table structure for table `gamesession`
--

CREATE TABLE `gamesession` (
  `roomid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `isuseractive` tinyint(4) NOT NULL,
  `userlastactive` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userjoined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gamesession`
--

INSERT INTO `gamesession` (`roomid`, `userid`, `isuseractive`, `userlastactive`, `userjoined`) VALUES
(1, 1, 1, '2017-01-13 01:13:20', '2017-01-13 08:09:39');

-- --------------------------------------------------------

--
-- Table structure for table `mahjongtable`
--

CREATE TABLE `mahjongtable` (
  `tableid` int(11) NOT NULL,
  `roomid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `userstatus` varchar(255) NOT NULL DEFAULT 'waiting',
  `useraction` varchar(255) DEFAULT NULL,
  `gametoken` varchar(255) DEFAULT NULL,
  `actiontime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahjongtable`
--

INSERT INTO `mahjongtable` (`tableid`, `roomid`, `userid`, `userstatus`, `useraction`, `gametoken`, `actiontime`) VALUES
(1, 1, 4, 'waiting', NULL, NULL, '2017-01-16 14:55:09'),
(1, 1, 1, 'waiting', 'throw', 'Zhong', '2017-01-16 08:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `email`, `password`) VALUES
(1, 'test@test.com', 'eaf0035f027b9f44b788181eb16e77e5cd9816848f14ea1f91ef25a480556f6484541ea42ea75530c27bf53deed9dd068d7b851b2756e92f4ae0b78d0e2c4969');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gameroom`
--
ALTER TABLE `gameroom`
  ADD PRIMARY KEY (`roomid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gameroom`
--
ALTER TABLE `gameroom`
  MODIFY `roomid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
