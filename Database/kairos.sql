-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2024 at 09:03 PM
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

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`userHandle`, `created_at`, `topicName`, `description`) VALUES
('aarifeen', '2024-04-02 06:35:58', 'Technology Trends in 2024', 'In this blog post, we will explore the latest trends in technology, including AI, blockchain, and cy'),
('antarsah', '2024-04-02 06:36:15', 'Healthy Eating Habits', 'Learn about the importance of maintaining a balanced diet and incorporating healthy eating habits in'),
('ashrafu1', '2024-04-02 06:36:31', 'Fitness Tips for Beginners', 'Starting a fitness journey can be daunting, but with the right guidance, anyone can achieve their fi'),
('bijoy123', '2024-04-02 06:37:18', 'Traveling on a Budget', 'Traveling doesn\'t have to break the bank! Discover budget-friendly travel tips, including how to fin'),
('bintesai', '2024-04-02 06:37:37', 'Effective Time Management Techniques', 'Mastering time management is essential for productivity and success. Explore proven techniques for p'),
('munna', '2024-04-02 06:38:11', 'Mindfulness Meditation for Stress Relief', 'Reduce stress and enhance well-being with mindfulness meditation. Learn how to incorporate mindfulne'),
('musfiqur', '2024-04-02 06:38:11', 'DIY Home Improvement Projects', 'Transform your living space with these DIY home improvement projects. From painting techniques to fu'),
('noman123', '2024-04-02 06:38:11', 'Effective Communication Skills', 'Communication is key in both personal and professional relationships. Explore strategies for improvi'),
('rifatibn', '2024-04-02 06:38:29', 'Exploring World Cuisine', 'Embark on a culinary journey around the globe and discover the diverse flavors of world cuisine. Fro'),
('rrumon71', '2024-04-02 06:38:41', 'Introduction to Sustainable Living', 'Learn about the principles of sustainable living and how to reduce your environmental footprint. Dis'),
('sliza221', '2024-04-02 06:39:56', 'Topic_350', 'Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, Lorem ipsum dolor sit amet, Lorem ipsum dolo');

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
  `bookName` varchar(100) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `details` varchar(500) DEFAULT NULL,
  `clicked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `life_library`
--

INSERT INTO `life_library` (`bookName`, `authorName`, `details`, `clicked`) VALUES
('Atomic Habits', 'James Clear', 'James Clear presents a comprehensive guide to building and sustaining habits that lead to lasting chcomprehensive guide to building and sustaining habits that lead to lasting chcomprehensive guide to building and sustaining habits that lead to lasting chcomprehensive guide to building and sustaining habits that lead to lasting chcomprehensive guide to building and sustaining habits that lead to lasting chcomprehensive', 0),
('Daring Greatly', 'Brené Brown', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 0),
('Eat That Frog!', 'Brian Tracy', 'Brian Tracy provides practical strategies for overcoming procrastination and increasing productivity', 0),
('Emotional Intelligence', 'Daniel Goleman', 'Daniel Goleman introduces the concept of emotional intelligence (EQ) and its critical role in person', 0),
('Man\'s Search for Meaning', 'Viktor E. Frankl', 'Psychiatrist Viktor Frankl reflects on his experiences as a Holocaust survivor and shares insights i', 0),
('Mindset', 'Carol S. Dweck', 'Psychologist Carol S. Dweck explores the concept of mindset and its impact on achievement and person', 15),
('Quiet', 'Susan Cain', 'Susan Cain celebrates the unique strengths of introverted individuals and', 0),
('Start with Why', 'Simon Sinek', 'Simon Sinek explores the concept of the \"Golden Circle\" and the importance of starting with why – th', 0),
('The 7 Habits of Highly Effective People', 'Stephen R. Covey', 'In this classic self-help book, Stephen Covey presents seven foundational habits that are key to per', 0),
('The Four Agreements', 'Don Miguel Ruiz', 'Don Miguel Ruiz presents four guiding principles rooted in ancient Toltec wisdom that can transform ', 0),
('The Power of Habit', 'Charles Duhigg', 'This book explores the science behind habit formation and how habits shape our lives, from individua', 10),
('The Power of Now', 'Eckhart Tolle', 'Eckhart Tolle explores the concept of mindfulness and present moment awareness as a path to spiritua', 0),
('The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'Mark Manson challenges conventional self-help advice and encourages readers to embrace discomfort an', 0),
('Thinking, Fast and Slow', 'Daniel Kahneman', 'Psychologist Daniel Kahneman delves into the workings of the human mind, exploring the interplay bet', 0);

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
  `details` varchar(5000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `public` tinyint(1) NOT NULL,
  `admin_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`userHandle`, `title`, `details`, `created_at`, `public`, `admin_approved`) VALUES
('bijoy123', 'Course Withdraw', 'Students, willing to “Withdraw” course(s) in Spring 2024 Trimester, are requested to submit Course w', '2024-03-26 14:36:30', 0, 0),
('bijoy123', 'LIBRARY HOUR DURING THE HOLY MONTH OF RAMADAN', 'Please be informed that during the Holy Month of Ramadan, the library hours including three group st', '2024-03-26 14:38:54', 0, 0),
('bijoy123', 'The Great Gatsby', 'A classic novel set in the Jazz Age, portraying the glamorous and often tragic lives of the wealthy ', '2024-03-26 14:39:37', 0, 0),
('bijoy123', 'To Kill a Mockingbird', 'A timeless story of racial injustice and moral growth in the American South, told through the eyes o', '2024-03-26 14:39:58', 0, 0),
('bijoy123', 'The Road Not Taken', 'A reflective poem about decision-making and the choices we face in life, symbolized by a diverging p', '2024-03-26 14:43:25', 0, 0),
('bijoy123', 'Stopping by Woods on a Snowy Evening', 'A contemplative poem that captures the beauty of nature and the allure of a tranquil snowy landscape', '2024-03-26 14:43:41', 0, 0),
('bijoy123', 'Atomic Habits', 'If you find yourself struggling to build a good habit or break a bad one, it is not because you have scientific research, Clear explains how tiny changes in behavior can lead to remarkable results over time. What sets this book apart is its emphasis on identity-based habits, which focus on becoming the type of person you want to be rather than just achieving specific outcomes.', '2024-03-29 06:36:07', 1, 0),
('bijoy123', 'Atomic Habits', '“When nothing seems to help, I go and look at a stonecutter hammering away at his rock, perhaps a hu', '2024-03-29 06:36:38', 1, 0),
('bijoy123', 'Atomic Habits', 'To form good habits, make them a part of your identity\r\nOur habits should be a part of our identity ', '2024-03-29 06:36:52', 0, 0),
('bijoy123', 'Quiet', 'As a bookish, introverted child, I would have loved to have found this on a ‘books for introverts’ s', '2024-04-01 13:11:04', 1, 0),
('musfiqur', 'UIU present ', 'ALTER TABLE label\r\nADD PRIMARY KEY (labelName,userHandle)ALTER TABLE label\r\nADD PRIMARY KEY (labelNa', '2024-03-26 15:23:28', 0, 0),
('musfiqur', 'Atomic Habits', 'Over the long run, however, the real reason you fail to stick with habits is that your self-image ge', '2024-03-29 06:37:07', 0, 0),
('musfiqur', 'Atomic Habits', 'If you’re still having trouble determining how to rate a particular habit, here is a question I like scientific research, Clear explains how tiny changes in behavior can lead to remarkable results over time. What sets this book apart is its emphasis on identity-based habits, which focus on becoming the type of person you want to be rather than just. ', '2024-03-29 06:37:22', 1, 0),
('noman123', 'Eat That Frog!', 'Since being founded in 2011, we have steadily become the South Wests’ No.1 alternative education cen', '2024-03-29 06:38:14', 1, 0),
('rifatibn', 'Eat That Frog!', 'Set the table”. This is your goal setting step, where you decide what you want to achieve and you wr', '2024-03-29 06:39:13', 1, 0),
('rrumon71', 'Eat That Frog!', 'This month’s book review is of a book that was recommended to me by Coach Cati and instead of readin', '2024-03-29 06:38:56', 1, 0),
('rrumon71', 'Atomic Habits', 'Atomic Habits\" by James Clear is a transformative guide to understanding and optimizing the power of habits in our lives. Clear\'s insights are practical, actionable, and backed by scientific research, making them accessible to readers of all backgrounds. Through compelling anecdotes and relatable examples, Clear illustrates how small changes in behavior can lead to remarkable outcomes over time. What sets this book apart is its focus on the underlying mechanisms of habit formation and the strategies for effectively implementing change. Whether you\'re looking to break bad habits, build new ones, or simply optimize your daily routines, \"Atomic Habits\" provides a comprehensive blueprint for personal transformation', '2024-04-02 17:56:01', 1, 1),
('tashin19', 'Atomic Habits', 'Atomic Habits\" by James Clear is a game-changer for anyone looking to make positive changes in their life. Clear\'s approach to habit formation is refreshingly practical and actionable, making it easy for readers to implement his strategies into their daily lives. Through engaging storytelling and scientific research, Clear explains how tiny changes in behavior can lead to remarkable results over time. What sets this book apart is its emphasis on identity-based habits, which focus on becoming the type of person you want to be rather than just achieving specific outcomes. Overall, \"Atomic Habits\" is a must-read for anyone seeking to cultivate lasting habits and achieve their goals.', '2024-04-01 14:05:49', 1, 0),
('tashin19', 'The Power of Habit', 'Through compelling narratives and insightful research, Duhigg explores how habits shape our lives and offers practical strategies for harnessing their power. From personal anecdotes to organizational case studies, the book provides valuable insights into the neurological processes behind habit formation and the role of cues, routines, and rewards. Duhigg\'s engaging storytelling and actionable advice make this book a must-read for anyone seeking to understand and change their habits for the better. ', '2024-04-02 17:19:59', 1, 1);

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
('Sharmin Sultana', 'Liza', 'Bangladeshi', 'sliza221', 'P@ssw0rd', 'sliza221331@bscse.ui', 'ISLAM', '2024-03-26 18:35:33', ''),
('Tashin', 'Parvez', 'Bangladeshi', 'tashin19', '123456789', 'tashin@gmail.com', 'Islam', '2024-04-01 14:04:19', '');

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
  ADD PRIMARY KEY (`bookName`,`authorName`);

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
