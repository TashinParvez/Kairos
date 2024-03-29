-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 07:13 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kairos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `userHandle` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `userHandle` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `topicName` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `cntUser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `userHandle` varchar(20) DEFAULT NULL,
  `countPushup` int(11) DEFAULT NULL,
  `countSeatup` int(11) DEFAULT NULL,
  `countRunDistance` int(11) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `userHandle` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `goalName` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `done` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `good_and_bad_things`
--

CREATE TABLE `good_and_bad_things` (
  `title` varchar(50) DEFAULT NULL,
  `type` bit(1) DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `details` varchar(100) DEFAULT NULL,
  `userHandle` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `good_and_bad_things`
--

INSERT INTO `good_and_bad_things` (`title`, `type`, `date`, `details`, `userHandle`) VALUES
('NULL', b'1', '2024-03-26', 'Watched a movie', 'antarsah'),
('NULL', b'1', '2024-03-26', 'ate good food', 'antarsah'),
('NULL', b'1', '2024-03-26', 'Roja', 'munna'),
('NULL', b'1', '2024-03-26', 'Namaj', 'munna'),
('NULL', b'1', '2024-03-26', 'Quarrel with sisters', 'munna');

-- --------------------------------------------------------

--
-- Table structure for table `label`
--

CREATE TABLE `label` (
  `userHandle` varchar(20) NOT NULL,
  `labelName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `label`
--

INSERT INTO `label` (`userHandle`, `labelName`) VALUES
('bijoy123', 'Books'),
('bijoy123', 'Poem'),
('bijoy123', 'UIU'),
('musfiqur', 'UIU');

-- --------------------------------------------------------

--
-- Table structure for table `life_library`
--

CREATE TABLE `life_library` (
  `bookName` varchar(20) NOT NULL,
  `authorName` varchar(20) NOT NULL,
  `details` varchar(100) DEFAULT NULL,
  `userHandle` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `namaz_c`
--

CREATE TABLE `namaz_c` (
  `userHandle` varchar(20) DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `categoryID` int(11) DEFAULT NULL,
  `userInteractions` int(11) DEFAULT NULL,
  `inMosque` int(11) DEFAULT NULL,
  `fajar` bit(1) DEFAULT NULL,
  `asr` bit(1) DEFAULT NULL,
  `dhuhr` bit(1) DEFAULT NULL,
  `isha` bit(1) DEFAULT NULL,
  `magrib` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `userHandle` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `details` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`userHandle`, `title`, `details`, `created_at`) VALUES
('bijoy123', 'Course Withdraw', 'Students, willing to “Withdraw” course(s) in Spring 2024 Trimester, are requested to submit Course w', '2024-03-26 14:36:30'),
('bijoy123', 'LIBRARY HOUR DURING THE HOLY MONTH OF RAMADAN', 'Please be informed that during the Holy Month of Ramadan, the library hours including three group st', '2024-03-26 14:38:54'),
('bijoy123', 'The Great Gatsby', 'A classic novel set in the Jazz Age, portraying the glamorous and often tragic lives of the wealthy ', '2024-03-26 14:39:37'),
('bijoy123', 'To Kill a Mockingbird', 'A timeless story of racial injustice and moral growth in the American South, told through the eyes o', '2024-03-26 14:39:58'),
('bijoy123', 'The Road Not Taken', 'A reflective poem about decision-making and the choices we face in life, symbolized by a diverging p', '2024-03-26 14:43:25'),
('bijoy123', 'Stopping by Woods on a Snowy Evening', 'A contemplative poem that captures the beauty of nature and the allure of a tranquil snowy landscape', '2024-03-26 14:43:41'),
('musfiqur', 'UIU present ', 'ALTER TABLE label\r\nADD PRIMARY KEY (labelName,userHandle)ALTER TABLE label\r\nADD PRIMARY KEY (labelNa', '2024-03-26 15:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `page_count`
--

CREATE TABLE `page_count` (
  `userHandle` varchar(20) DEFAULT NULL,
  `dailyCount` int(11) DEFAULT NULL,
  `totalCount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_journal`
--

CREATE TABLE `personal_journal` (
  `userHandle` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `details` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `puja_c`
--

CREATE TABLE `puja_c` (
  `userHandle` varchar(20) DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `categoryID` int(11) DEFAULT NULL,
  `morningPrayer` bit(1) DEFAULT NULL,
  `eveningPrayer` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `firstName` varchar(20) DEFAULT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `nationality` varchar(20) DEFAULT NULL,
  `userHandle` varchar(20) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `religion` varchar(20) DEFAULT NULL,
  `joinDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `about` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`firstName`, `lastName`, `nationality`, `userHandle`, `password`, `mail`, `religion`, `joinDate`, `about`) VALUES
('Abtahi', 'Arifeen', 'Bangladeshi', 'aarifeen', 'P@ssw0rd', 'aarifeen212044@bscse', 'ISLAM', '2024-03-26 18:35:33', ''),
('Antar', 'Saha', 'Bangladeshi', 'antarsah', 'P@ssw0rd', 'antarsahaopeth@gmail', 'HINDU', '2024-03-26 18:35:33', ''),
('Ashraful', 'Islam', 'Bangladeshi', 'ashrafu1', 'P@ssw0rd', 'ni7339849@gmail.com', 'ISLAM', '2024-03-26 18:35:33', ''),
('Bijoy', 'Das Gupta', 'Bangladeshi', 'bijoy123', 'bijoy123', 'bgupta2330355@bscse.uiu.ac.bd', 'HINDU', '2024-03-26 18:35:33', ''),
('Saira Binte', 'Salek', 'Bangladeshi', 'bintesai', 'P@ssw0rd', 'bintesaira@gmail.com', 'ISLAM', '2024-03-26 18:35:33', ''),
('Munna', NULL, 'Bangladeshi', 'munna', 'P@ssw0rd', 'mohaiminul010@gmail.', 'ISLAM', '2024-03-26 18:35:33', ''),
('Musfiqur', NULL, 'Bangladeshi', 'musfiqur', 'P@ssw0rd', 'musfiqurm669@gmail.c', 'ISLAM', '2024-03-26 18:35:33', ''),
('MD', 'Noman', 'B', 'noman123', 'noman123', 'noman@gmail.com', 'I', '2024-03-26 18:35:33', ''),
('Rifat', 'Ibne Yousuf', 'Bangladeshi', 'rifatibn', 'P@ssw0rd', 'rifatibneyousuf@gmai', 'ISLAM', '2024-03-26 18:35:33', ''),
('Readwanur', NULL, 'Bangladeshi', 'rrumon71', 'P@ssw0rd', 'rrumon710@gmail.com', 'ISLAM', '2024-03-26 18:35:33', ''),
('Sharmin Sultana', 'Liza', 'Bangladeshi', 'sliza221', 'P@ssw0rd', 'sliza221331@bscse.ui', 'ISLAM', '2024-03-26 18:35:33', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_post`
--

CREATE TABLE `user_post` (
  `userHandle` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `userInteractions` int(11) DEFAULT NULL,
  `categoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD KEY `bfk` (`userHandle`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD KEY `efk` (`userHandle`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD KEY `gfk` (`userHandle`);

--
-- Indexes for table `good_and_bad_things`
--
ALTER TABLE `good_and_bad_things`
  ADD KEY `gbtfk` (`userHandle`);

--
-- Indexes for table `label`
--
ALTER TABLE `label`
  ADD PRIMARY KEY (`labelName`,`userHandle`),
  ADD KEY `lfk` (`userHandle`);

--
-- Indexes for table `life_library`
--
ALTER TABLE `life_library`
  ADD PRIMARY KEY (`bookName`,`authorName`),
  ADD KEY `llfk` (`userHandle`,`date`);

--
-- Indexes for table `namaz_c`
--
ALTER TABLE `namaz_c`
  ADD KEY `ncfk` (`userHandle`),
  ADD KEY `ncfk2` (`categoryID`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`userHandle`,`created_at`),
  ADD KEY `userHandle` (`userHandle`);

--
-- Indexes for table `page_count`
--
ALTER TABLE `page_count`
  ADD KEY `pcfk` (`userHandle`) USING BTREE;

--
-- Indexes for table `personal_journal`
--
ALTER TABLE `personal_journal`
  ADD KEY `pjfk` (`userHandle`);

--
-- Indexes for table `puja_c`
--
ALTER TABLE `puja_c`
  ADD KEY `pcfk` (`userHandle`),
  ADD KEY `pcfk2` (`categoryID`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`userHandle`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Indexes for table `user_post`
--
ALTER TABLE `user_post`
  ADD KEY `upfk` (`userHandle`),
  ADD KEY `upfk2` (`categoryID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `bfk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`);

--
-- Constraints for table `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `efk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`);

--
-- Constraints for table `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `gfk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`);

--
-- Constraints for table `good_and_bad_things`
--
ALTER TABLE `good_and_bad_things`
  ADD CONSTRAINT `gbtfk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`);

--
-- Constraints for table `label`
--
ALTER TABLE `label`
  ADD CONSTRAINT `lfk` FOREIGN KEY (`userHandle`) REFERENCES `notes` (`userHandle`);

--
-- Constraints for table `namaz_c`
--
ALTER TABLE `namaz_c`
  ADD CONSTRAINT `ncfk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`),
  ADD CONSTRAINT `ncfk2` FOREIGN KEY (`categoryID`) REFERENCES `category` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `nfk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`);

--
-- Constraints for table `page_count`
--
ALTER TABLE `page_count`
  ADD CONSTRAINT `uh` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`);

--
-- Constraints for table `personal_journal`
--
ALTER TABLE `personal_journal`
  ADD CONSTRAINT `pjfk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`);

--
-- Constraints for table `puja_c`
--
ALTER TABLE `puja_c`
  ADD CONSTRAINT `pcfk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`),
  ADD CONSTRAINT `pcfk2` FOREIGN KEY (`categoryID`) REFERENCES `category` (`id`);

--
-- Constraints for table `user_post`
--
ALTER TABLE `user_post`
  ADD CONSTRAINT `upfk` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`),
  ADD CONSTRAINT `upfk2` FOREIGN KEY (`categoryID`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
