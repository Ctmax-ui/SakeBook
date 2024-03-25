-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2024 at 11:43 AM
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
-- Database: `sakebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `userpost`
--

CREATE TABLE `userpost` (
  `postid` int(11) NOT NULL,
  `which_user_posted` varchar(255) NOT NULL,
  `postname` varchar(255) NOT NULL,
  `post_description` varchar(255) NOT NULL,
  `postimg` varchar(255) DEFAULT NULL,
  `posttime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userpost`
--

INSERT INTO `userpost` (`postid`, `which_user_posted`, `postname`, `post_description`, `postimg`, `posttime`) VALUES
(1, '10', 'hello', 'world', 'sakebook_1707227028_Capture.PNG', '0'),
(2, '10', 'helllo_world', 'hi_my_new_post', 'sakebook_1707227813_ty4.PNG', '06-02-2024_19:26:53pm'),
(3, '10', 'hola_pasta', 'i_cooked_pasta_in_this_morning', 'sakebook_1707232978_Capture4.PNG', '06-02-2024_20:52:58pm'),
(4, '10', 'i_created_a_website', 'my_new_website', 'sakebook_1707233141_tt.PNG', '06-02-2024_20:55:41pm'),
(5, '1', 'lol', '2nd_post', 'sakebook_1707234564_Capture3.PNG', '06-02-2024_21:19:24pm'),
(6, '9', 'lllllllllllllllllllllllllllllllllllll', 'llllllllllllllllllllllllllllllllllllllllllll', 'sakebook_1707234924_search_for.PNG', '06-02-2024_21:25:24pm'),
(7, '10', 'My_dog_died', 'wow_my_dog_got_shit_ass_beeten_black_bllue!!!!!!!!!', 'sakebook_1707279639_tttttttttttttttt.PNG', '07-02-2024_09:50:39am'),
(8, '10', 'hola', 'hola_pasta&amp;#13;&amp;#10;', 'NULL', '07-02-2024_10:37:42am'),
(9, '10', 'wwrwrwer', 'fwwefwefwef', 'NULL', '07-02-2024_10:38:18am'),
(10, '10', 'lol', 'lol', 'sakebook_1707384716_png_20211207_003153_0000.png', '08-02-2024_15:01:56pm'),
(11, '1', 'hola', 'pasta', 'sakebook_1707393160_helloworld_383x215.png', '08-02-2024_17:22:40pm'),
(12, '1', 'fsdgsgg', 'sadfsdffsaf', 'sakebook_1707393325_Capture3.PNG', '08-02-2024_17:25:25pm'),
(13, '1', 'sss', 'sss', 'NULL', '08-02-2024_17:26:19pm'),
(14, '9', 'hello_world', 'hola&amp;#13;&amp;#10;', 'NULL', '09-02-2024_09:42:58am'),
(15, '1', 'meawwww', 'meawwwwww', 'NULL', '10-02-2024_22:49:06pm');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `usermail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userimg` varchar(255) DEFAULT NULL,
  `user_otp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `usermail`, `password`, `userimg`, `user_otp`) VALUES
(1, 'dave', 'dave@gmail.com', 'dave123', 'simple-form_1707388893_user2.jpg', NULL),
(9, 'mona', 'mona2@gmail.com', 'mona123', 'simple-form_1707452703_user2.jpg', NULL),
(10, 'admin', 'admin@gamil.com', 'admin', 'simple-form_1707377900_user3.jpg', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userpost`
--
ALTER TABLE `userpost`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userpost`
--
ALTER TABLE `userpost`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
