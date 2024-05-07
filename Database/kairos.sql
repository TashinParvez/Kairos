-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 11:39 PM
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
  `goalName` varchar(50) DEFAULT NULL,
  `status` bit(1) NOT NULL DEFAULT b'0',
  `startDate` date NOT NULL DEFAULT current_timestamp(),
  `endDate` date NOT NULL,
  `completedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`userHandle`, `goalName`, `status`, `startDate`, `endDate`, `completedDate`) VALUES
('tashin19', 'Finish Kairos Project', b'0', '2024-04-30', '2024-04-07', NULL),
('tashin19', 'Finished deception point Book', b'0', '2024-04-30', '2024-05-07', NULL),
('tashin19', 'Reach Pupil', b'0', '2024-04-30', '2024-01-03', NULL),
('tashin19', 'Poster Done', b'0', '2024-04-30', '2024-05-02', NULL),
('tashin19', 'Build CV', b'1', '2024-04-30', '2024-03-07', '2024-04-30'),
('tashin19', 'Creat new Website', b'0', '2024-04-30', '2024-01-03', NULL),
('tashin19', 'Solve 200 Problems', b'0', '2024-04-30', '2024-05-12', NULL),
('tashin19', 'Goals page Work Done', b'0', '2024-04-30', '2024-04-30', NULL);

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
('NULL', b'0', '2024-03-26', 'Quarrel with sisters', 'munna'),
(NULL, b'1', '2024-05-07', 'Ghumai nai bikale', 'noman123'),
(NULL, b'0', '2024-05-07', 'Namaz pori nai', 'noman123'),
(NULL, b'1', '2024-05-07', 'first', 'tashin19'),
(NULL, b'0', '2024-05-07', 'third', 'tashin19'),
(NULL, b'0', '2024-05-07', 'fourth', 'tashin19');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `No` int(11) NOT NULL,
  `File` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`No`, `File`) VALUES
(21, '661185c5082366.78224636_Screenshot_29-3-2024_122032_docs.google.com.jpeg'),
(31, '66118d77f2bb54.74476261_434726312_122136934178048970_1403408500134376963_n.jpg'),
(32, '66118d9991ab40.10792232_a66d9cc6455ceaa8d1e188562ddfe94d.jpg'),
(33, '66118f2d90e968.40675815_Screenshot_25-3-2024_161711_www.figma.com.jpeg'),
(34, 'lenovo.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

CREATE TABLE `interest` (
  `NO` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `imageUrl` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interest`
--

INSERT INTO `interest` (`NO`, `Name`, `imageUrl`) VALUES
(1, 'Reading books', 'https://img.freepik.com/free-vector/hand-drawn-flat-design-stack-books-illustration_23-2149341898.jpg'),
(2, 'Cricket', 'https://img.freepik.com/free-vector/ipl-cricket-illustration-hand-drawn-style_23-2149201607.jpg?size=338&ext=jpg&ga=GA1.1.1546980028.1703548800&semt=ais'),
(3, 'Swimming', 'https://img.freepik.com/premium-vector/cute-little-kid-boy-swim-water-summer-holiday_97632-4498.jpg'),
(4, 'Watching movies', 'https://img.freepik.com/free-vector/people-watching-movie-home_23-2148555711.jpg'),
(5, 'Listening to music', 'https://img.freepik.com/free-vector/headphone-concept-illustration_114360-2132.jpg?size=338&ext=jpg'),
(6, 'Listening to Podcast', 'https://img.freepik.com/premium-vector/podcast-logo-design_642050-2.jpg'),
(7, 'Cooking', 'https://img.freepik.com/free-vector/cooking-concept-illustration_114360-1396.jpg?w=360'),
(8, 'walking', 'https://img.freepik.com/free-vector/moving-forward-concept-illustration_114360-1641.jpg'),
(9, 'baking', 'https://img.freepik.com/premium-vector/bank-building-money-bank-financing-money-exchange-financial-services-atm-giving-out-money_625536-194.jpg'),
(10, 'Doing arts', 'https://img.freepik.com/free-vector/making-art-concept-illustration_114360-2174.jpg'),
(11, 'Gardening', 'https://img.freepik.com/free-vector/hand-drawn-texture-gardening-pattern_23-2149702331.jpg'),
(12, 'Socializing with friends', 'https://img.freepik.com/free-vector/hand-drawn-diversity-illustration_52683-125683.jpg?size=338&ext=jpg&ga=GA1.1.1700460183.1712102400&semt=ais'),
(14, 'Learning something new', 'https://img.freepik.com/premium-vector/curious-woman-looking-far-away-with-hand-head-trying-see-something-bad-vision-searching-holding-palm-forehead-gasping-surprised-amazed-concept-illustration_270158-265.jpg'),
(15, 'Exercise', 'https://img.freepik.com/premium-vector/happy-man-exercising-park_113065-39.jpg'),
(16, 'Singing', 'https://img.freepik.com/free-vector/popular-music-abstract-concept-illustration-popular-singer-tour-pop-music-industry-top-chart-artist-musical-band-production-service-recording-studio-book-event_335657-3656.jpg'),
(17, '', '');

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
  `clicked` int(11) NOT NULL,
  `fileName` varchar(200) NOT NULL,
  `bookNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `life_library`
--

INSERT INTO `life_library` (`bookName`, `authorName`, `details`, `clicked`, `fileName`, `bookNo`) VALUES
('Atomic Habits', 'James Clear', 'James Clear presents a comprehensive guide to building and sustaining habits that lead to lasting chcomprehensive guide to building and sustaining habits that lead to lasting chcomprehensive guide to building and sustaining habits that lead to lasting chcomprehensive guide to building and sustaining habits that lead to lasting chcomprehensive guide to building and sustaining habits that lead to lasting chcomprehensive', 0, '', 1),
('Daring Greatly', 'Brené Brown', 'Daring Greatly is a 2012 self-help book written by Brené Brown. It is a New York Times bestseller and covers topics of vulnerability and shame.', 0, '', 2),
('Eat That Frog!', 'Brian Tracy', 'Brian Tracy provides practical strategies for overcoming procrastination and increasing productivity', 0, '', 3),
('Emotional Intelligence', 'Daniel Goleman', 'Daniel Goleman introduces the concept of emotional intelligence (EQ) and its critical role in person', 0, '', 4),
('Man\'s Search for Meaning', 'Viktor E. Frankl', 'Psychiatrist Viktor Frankl reflects on his experiences as a Holocaust survivor and shares insights i', 0, '', 5),
('Mindset', 'Carol S. Dweck', 'Psychologist Carol S. Dweck explores the concept of mindset and its impact on achievement and person', 15, '', 6),
('Quiet', 'Susan Cain', 'Susan Cain celebrates the unique strengths of introverted individuals and', 0, '', 7),
('Start with Why', 'Simon Sinek', 'Simon Sinek explores the concept of the \"Golden Circle\" and the importance of starting with why – th', 0, '', 8),
('The 7 Habits of Highly Effective People', 'Stephen R. Covey', 'In this classic self-help book, Stephen Covey presents seven foundational habits that are key to per', 0, '', 9),
('The Four Agreements', 'Don Miguel Ruiz', 'Don Miguel Ruiz presents four guiding principles rooted in ancient Toltec wisdom that can transform ', 0, '', 10),
('The Power of Habit', 'Charles Duhigg', 'This book explores the science behind habit formation and how habits shape our lives, from individua', 10, '', 11),
('The Power of Now', 'Eckhart Tolle', 'Eckhart Tolle explores the concept of mindfulness and present moment awareness as a path to spiritua', 0, '', 12),
('The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'Mark Manson challenges conventional self-help advice and encourages readers to embrace discomfort an', 0, '', 13),
('Thinking, Fast and Slow', 'Daniel Kahneman', 'Psychologist Daniel Kahneman delves into the workings of the human mind, exploring the interplay bet', 0, '', 14);

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
('aarifeen', 'The Power of Habit', 'This book explores the science behind habit formation and how habits shape our lives, from individual routines to organizational behavior. Charles Duhigg delves into the neurological processes that drive habits and offers practical insights on how to change them to achieve personal and professional success', '2024-04-06 12:11:38', 1, 0),
('aarifeen', 'The Great Gatsby', 'F. Scott Fitzgerald\'s novel captures the decadence and disillusionment of the Jazz Age, exploring themes of love, wealth, and the American Dream. Set against the backdrop of the Roaring Twenties, the story follows the enigmatic Jay Gatsby as he pursues his elusive vision of success and happiness', '2024-04-06 12:14:21', 1, 1),
('bijoy123', 'Course Withdraw', 'Students, willing to “Withdraw” course(s) in Spring 2024 Trimester, are requested to submit Course w', '2024-03-26 14:36:30', 0, 0),
('bijoy123', 'LIBRARY HOUR DURING THE HOLY MONTH OF RAMADAN', 'Please be informed that during the Holy Month of Ramadan, the library hours including three group st', '2024-03-26 14:38:54', 0, 0),
('bijoy123', 'The Great Gatsby', 'A classic novel set in the Jazz Age, portraying the glamorous and often tragic lives of the wealthy ', '2024-03-26 14:39:37', 0, 0),
('bijoy123', 'To Kill a Mockingbird', 'A timeless story of racial injustice and moral growth in the American South, told through the eyes o', '2024-03-26 14:39:58', 0, 0),
('bijoy123', 'The Road Not Taken', 'A reflective poem about decision-making and the choices we face in life, symbolized by a diverging p', '2024-03-26 14:43:25', 0, 0),
('bijoy123', 'Stopping by Woods on a Snowy Evening', 'A contemplative poem that captures the beauty of nature and the allure of a tranquil snowy landscape', '2024-03-26 14:43:41', 0, 0),
('bijoy123', 'Atomic Habits', 'If you find yourself struggling to build a good habit or break a bad one, it is not because you have scientific research, Clear explains how tiny changes in behavior can lead to remarkable results over time. What sets this book apart is its emphasis on identity-based habits, which focus on becoming the type of person you want to be rather than just achieving specific outcomes.', '2024-03-29 06:36:07', 1, 0),
('bijoy123', 'Atomic Habits', '“When nothing seems to help, I go and look at a stonecutter hammering away at his rock, perhaps a hu', '2024-03-29 06:36:38', 1, 0),
('bijoy123', 'Atomic Habits', 'To form good habits, make them a part of your identity\r\nOur habits should be a part of our identity ', '2024-03-29 06:36:52', 0, 0),
('bijoy123', 'Quiet', 'As a bookish, introverted child, I would have loved to have found this on a ‘books for introverts’ s', '2024-04-01 13:11:04', 1, -1),
('bijoy123', 'Atomic Habits', 'James Clear presents a comprehensive guide to building good habits, breaking bad ones, and mastering the tiny behaviors that lead to remarkable results. With practical strategies backed by scientific research, this book provides actionable steps to create lasting change in any area of life', '2024-04-06 12:11:38', 1, 0),
('bijoy123', 'To Kill a Mockingbird', 'Harper Lee\'s Pulitzer Prize-winning novel explores themes of racial injustice, moral growth, and empathy in the American South during the 1930s. Through the eyes of young Scout Finch, the book offers profound insights into the complexities of human nature and the importance of standing up for what is right', '2024-04-06 12:13:57', 1, 0),
('bijoy123', 'Pride and Prejudice', 'Jane Austen\'s beloved novel follows the lives of the Bennet sisters as they navigate the social conventions and romantic entanglements of early 19th-century England. With its witty dialogue, sharp social commentary, and memorable characters, the book remains a timeless classic of English literature', '2024-04-06 12:14:21', 1, 0),
('munna', 'Brave New World', 'Aldous Huxley\'s novel presents a futuristic society where technology, genetic engineering, and conditioning are used to control every aspect of human life. Through its exploration of themes such as conformity, consumerism, and the loss of individuality, the book offers a thought-provoking critique of utopian ideals', '2024-04-06 12:14:21', 1, 0),
('musfiqur', 'UIU present ', 'ALTER TABLE label\r\nADD PRIMARY KEY (labelName,userHandle)ALTER TABLE label\r\nADD PRIMARY KEY (labelNa', '2024-03-26 15:23:28', 0, 0),
('musfiqur', 'Atomic Habits', 'Over the long run, however, the real reason you fail to stick with habits is that your self-image ge', '2024-03-29 06:37:07', 0, 0),
('musfiqur', 'Atomic Habits', 'If you’re still having trouble determining how to rate a particular habit, here is a question I like scientific research, Clear explains how tiny changes in behavior can lead to remarkable results over time. What sets this book apart is its emphasis on identity-based habits, which focus on becoming the type of person you want to be rather than just. ', '2024-03-29 06:37:22', 1, 0),
('noman123', 'Eat That Frog!', 'Since being founded in 2011, we have steadily become the South Wests’ No.1 alternative education cen', '2024-03-29 06:38:14', 1, 0),
('rifatibn', 'Eat That Frog!', 'Set the table”. This is your goal setting step, where you decide what you want to achieve and you wr', '2024-03-29 06:39:13', 1, 0),
('rifatibn', '1984', 'George Orwell\'s dystopian masterpiece paints a chilling portrait of a totalitarian society where individuality and freedom are suppressed. Through its exploration of surveillance, propaganda, and thought control, the novel serves as a cautionary tale about the dangers of authoritarianism and the importance of preserving liberty', '2024-04-06 12:13:57', 1, 0),
('rrumon71', 'Eat That Frog!', 'This month’s book review is of a book that was recommended to me by Coach Cati and instead of readin', '2024-03-29 06:38:56', 1, -1),
('rrumon71', 'Atomic Habits', 'Atomic Habits\" by James Clear is a transformative guide to understanding and optimizing the power of habits in our lives. Clear\'s insights are practical, actionable, and backed by scientific research, making them accessible to readers of all backgrounds. Through compelling anecdotes and relatable examples, Clear illustrates how small changes in behavior can lead to remarkable outcomes over time. What sets this book apart is its focus on the underlying mechanisms of habit formation and the strategies for effectively implementing change. Whether you\'re looking to break bad habits, build new ones, or simply optimize your daily routines, \"Atomic Habits\" provides a comprehensive blueprint for personal transformation', '2024-04-02 17:56:01', 1, 1),
('tashin19', 'Atomic Habits', 'Atomic Habits\" by James Clear is a game-changer for anyone looking to make positive changes in their life. Clear\'s approach to habit formation is refreshingly practical and actionable, making it easy for readers to implement his strategies into their daily lives. Through engaging storytelling and scientific research, Clear explains how tiny changes in behavior can lead to remarkable results over time. What sets this book apart is its emphasis on identity-based habits, which focus on becoming the type of person you want to be rather than just achieving specific outcomes. Overall, \"Atomic Habits\" is a must-read for anyone seeking to cultivate lasting habits and achieve their goals.', '2024-04-01 14:05:49', 1, 0),
('tashin19', 'The Power of Habit', 'Through compelling narratives and insightful research, Duhigg explores how habits shape our lives and offers practical strategies for harnessing their power. From personal anecdotes to organizational case studies, the book provides valuable insights into the neurological processes behind habit formation and the role of cues, routines, and rewards. Duhigg\'s engaging storytelling and actionable advice make this book a must-read for anyone seeking to understand and change their habits for the better. ', '2024-04-02 17:19:59', 1, 1),
('tashin19', 'Think and Grow Rich', 'Think and Grow Rich is a book written by Napoleon Hill and Rosa Lee Beeland released in 1937 and promoted as a personal development and self-improvement book. He claimed to be inspired by a suggestion from business magnate and later-philanthropist Andrew Carnegie. However, there is no evidence that the two ever met', '2024-04-06 11:42:11', 1, 0),
('tashin19', 'The Alchemist', 'This iconic novel follows Santiago, a shepherd boy who embarks on a journey to discover his Personal Legend, encountering spiritual wisdom and life-changing lessons along the way. Through his travels, Santiago learns the importance of following one\'s dreams and the transformative power of perseverance', '2024-04-06 12:07:29', 1, 0),
('tashin19', 'The Alchemist', 'This iconic novel follows Santiago, a shepherd boy who embarks on a journey to discover his Personal Legend, encountering spiritual wisdom and life-changing lessons along the way. Through his travels, Santiago learns the importance of following one\'s dreams and the transformative power of perseverance', '2024-04-06 12:11:38', 1, 0),
('tashin19', 'The Seven Habits of Highly Effective People', 'Stephen Covey shares timeless principles for personal and professional effectiveness, focusing on character development, communication skills, and synergy. Through anecdotes and insights, Covey offers a holistic approach to success based on timeless principles', '2024-04-06 12:13:05', 1, 0),
('tashin19', 'Man\'s Search for Meaning', 'Viktor Frankl reflects on his experiences as a Holocaust survivor and psychiatrist to explore the importance of finding meaning in life, even in the most challenging circumstances. This profound book offers insights into the human psyche and the power of hope and resilience', '2024-04-06 12:13:35', 1, 1),
('tashin19', 'The Catcher in the Rye', 'J.D. Salinger\'s classic novel follows the teenage protagonist Holden Caulfield as he navigates the challenges of adolescence and societal expectations. With its candid portrayal of teenage angst and disillusionment, this book remains a timeless coming-of-age story', '2024-04-06 12:13:57', 1, 0),
('tashin19', 'Zero to One', 'Zero to One is about how to build companies that create new things. It draws on everything I\'ve learned directly as a co-founder of PayPal and Palantir and then an investor in hundreds of startups, including Facebook and SpaceX.', '2024-04-25 15:26:21', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `page_count`
--

CREATE TABLE `page_count` (
  `userHandle` varchar(20) DEFAULT NULL,
  `dailyCount` int(11) DEFAULT NULL,
  `todaysDate` date NOT NULL,
  `totalCount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_journal`
--

CREATE TABLE `personal_journal` (
  `userHandle` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `details` varchar(5000) DEFAULT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `saved` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_journal`
--

INSERT INTO `personal_journal` (`userHandle`, `title`, `created_at`, `details`, `lastUpdate`, `saved`) VALUES
('tashin19', 'last day of ramadan', '2024-04-10 13:58:52', 'The last day of Ramadan is known as Eid al-Fitr, which marks the end of the month-long fasting period for Muslims worldwide. It\'s a joyous occasion celebrated with prayers, feasting, and giving of gifts and charity to those in need. Muslims gather early in the morning for special prayers called Salat al-Eid, often held in large congregations at mosques or in open spaces. Families come together to enjoy delicious meals and sweets, exchange greetings and blessings, and express gratitude for the spiritual growth and blessings received during Ramadan. It\'s a time of unity, reflection, and thanksgiving, as well as an opportunity to seek forgiveness and renew one\'s commitment to faith and righteousness.\r\n\r\n\r\n\r\n\r\n\r\n', '2024-04-10 07:59:11', b'1'),
('tashin19', 'Kairos-Personal Journal', '2024-04-10 13:59:20', 'A personal journal is a private space where individuals can express their thoughts, feelings, and experiences in writing. It\'s a tool for self-reflection, introspection, and personal growth. People use personal journals for various purposes, such as recording daily events, expressing emotions, setting goals, exploring ideas, and documenting memories. Keeping a journal can help individuals gain clarity, process emotions, track progress, and cultivate self-awareness. It\'s a therapeutic practice that offers a sense of catharsis, empowerment, and control over one\'s life. Whether it\'s a traditional handwritten journal or a digital platform, the act of journaling provides a safe and non-judgmental space for individuals to explore themselves and their lives more deeply.', '2024-04-10 08:00:20', b'1'),
('tashin19', 'Ramadan 2024', '2024-04-10 14:00:26', 'Ramadan in 2024 is expected to begin on the evening of Thursday, March 21, 2024, and end on the evening of Saturday, April 20, 2024, based on the Islamic lunar calendar. It is the ninth month of the Islamic lunar calendar and is observed by Muslims worldwide as a month of fasting (Sawm), prayer, reflection, and community. During Ramadan, Muslims fast from dawn until sunset, abstaining from food, drink, smoking, and other physical needs as a form of spiritual discipline and self-control. It is also a time for increased prayer, reading the Quran, performing acts of charity (Zakat), and seeking forgiveness. The end of Ramadan is marked by the celebration of Eid al-Fitr, a festive holiday that begins with communal prayers, followed by feasting, gift-giving, and acts of kindness.', '2024-04-10 08:01:30', b'1'),
('tashin19', 'Chaand Raat', '2024-04-10 21:07:05', 'Chaand Raat is a South Asian Cultural observance on the eve of the festival of Eid al-Fitr; it can also mean a night with a new moon for the new Islamic month Shawwal.', '2024-04-10 15:07:05', b'1'),
('tashin19', 'How To Style HR', '2024-04-10 22:39:57', '<style>\r\n/* Red border */\r\nhr.new1 {\r\n  border-top: 1px solid red;\r\n}\r\n\r\n/* Dashed red border */\r\nhr.new2 {\r\n  border-top: 1px dashed red;\r\n}\r\n\r\n/* Dotted red border */\r\nhr.new3 {\r\n  border-top: 1px dotted red;\r\n}\r\n\r\n/* Thick red border */\r\nhr.new4 {\r\n  border: 1px solid red;\r\n}\r\n\r\n/* Large rounded green border */\r\nhr.new5 {\r\n  border: 10px solid green;\r\n  border-radius: 5px;\r\n}\r\n</style>', '2024-04-10 16:39:57', b'1'),
('tashin19', 'About Today', '2024-04-03 22:41:03', 'April 10, 2024 - Today is Good Friday, National Hug Your Dog Day, National Siblings Day, Day of Silence, National Farm Animals Day, National Foster Care Day', '2024-04-10 16:42:06', b'1');

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

--
-- Dumping data for table `puja_c`
--

INSERT INTO `puja_c` (`userHandle`, `date`, `categoryID`, `morningPrayer`, `eveningPrayer`) VALUES
('antarsah', '2024-04-28', NULL, b'1', b'0'),
('antarsah', '2024-04-28', NULL, b'1', b'0');

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
  `about` varchar(500) NOT NULL,
  `interestSet` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`firstName`, `lastName`, `nationality`, `userHandle`, `password`, `mail`, `religion`, `joinDate`, `about`, `interestSet`) VALUES
('Abtahi', 'Arifeen', 'Bangladeshi', 'aarifeen', 'P@ssw0rd', 'aarifeen212044@bscse', 'ISLAM', '2024-03-26 18:35:33', '', 0),
('Antar', 'Saha', 'Bangladeshi', 'antarsah', 'P@ssw0rd', 'antarsahaopeth@gmail', 'HINDU', '2024-03-26 18:35:33', '', 0),
('Ashraful', 'Islam', 'Bangladeshi', 'ashrafu1', 'P@ssw0rd', 'ni7339849@gmail.com', 'ISLAM', '2024-03-26 18:35:33', '', 0),
('Bijoy', 'Das Gupta', 'Bangladeshi', 'bijoy123', 'bijoy123', 'bgupta2330355@bscse.uiu.ac.bd', 'HINDU', '2024-03-26 18:35:33', '', 0),
('Saira Binte', 'Salek', 'Bangladeshi', 'bintesai', 'P@ssw0rd', 'bintesaira@gmail.com', 'ISLAM', '2002-01-01 18:35:33', '', 0),
('Munna', NULL, 'Bangladeshi', 'munna', 'P@ssw0rd', 'mohaiminul010@gmail.', 'ISLAM', '2024-03-26 18:35:33', '', 0),
('Musfiqur', NULL, 'Bangladeshi', 'musfiqur', 'P@ssw0rd', 'musfiqurm669@gmail.c', 'ISLAM', '2024-03-26 18:35:33', '', 0),
('MD', 'Noman', 'B', 'noman123', 'noman123', 'noman@gmail.com', 'I', '2024-03-26 18:35:33', '', 0),
('Rifat', 'Ibne Yousuf', 'Bangladeshi', 'rifatibn', 'P@ssw0rd', 'rifatibneyousuf@gmai', 'ISLAM', '2024-03-26 18:35:33', '', 0),
('Readwanur', 'Rahman', 'Bangladeshi', 'rrumon71', 'rumon710', 'rrumon710@gmail.com', 'ISLAM', '2024-03-26 18:35:33', '', 0),
('Sharmin Sultana', 'Liza', 'Bangladeshi', 'sliza221', 'P@ssw0rd', 'sliza221331@bscse.ui', 'ISLAM', '2024-03-26 18:35:33', '', 0),
('Tashin', 'Parvez', 'Bangladeshi', 'tashin19', '123456789', 'tashin@gmail.com', 'Islam', '2024-04-01 14:04:19', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_interest`
--

CREATE TABLE `user_interest` (
  `userHandle` varchar(20) NOT NULL,
  `interestNO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_interest`
--

INSERT INTO `user_interest` (`userHandle`, `interestNO`) VALUES
('sliza221', 7),
('bijoy123', 2),
('bijoy123', 7);

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
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`No`);

--
-- Indexes for table `interest`
--
ALTER TABLE `interest`
  ADD PRIMARY KEY (`NO`);

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
  ADD UNIQUE KEY `bookNo` (`bookNo`);

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
-- Indexes for table `user_interest`
--
ALTER TABLE `user_interest`
  ADD KEY `uifk1` (`userHandle`),
  ADD KEY `uifk2` (`interestNO`);

--
-- Indexes for table `user_post`
--
ALTER TABLE `user_post`
  ADD KEY `upfk` (`userHandle`),
  ADD KEY `upfk2` (`categoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `interest`
--
ALTER TABLE `interest`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `life_library`
--
ALTER TABLE `life_library`
  MODIFY `bookNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
-- Constraints for table `user_interest`
--
ALTER TABLE `user_interest`
  ADD CONSTRAINT `uifk1` FOREIGN KEY (`userHandle`) REFERENCES `user_info` (`userHandle`),
  ADD CONSTRAINT `uifk2` FOREIGN KEY (`interestNO`) REFERENCES `interest` (`NO`);

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
