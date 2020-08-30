-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2020 at 05:37 AM
-- Server version: 10.4.12-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--
DROP SCHEMA IF EXISTS cms;
CREATE SCHEMA IF NOT EXISTS cms;
USE cms;

CREATE TABLE `Admins` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headline` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`id`, `username`, `password`, `name`, `added_by`, `date`, `image`, `headline`, `description`) VALUES
(1, 'webins', 'Webins.123.', 'Kleiver', 'admin', '2020-04-17', '1header.png', 'Developer', 'Hello, my name is kleiver. Im a software developer and one of my favorite things is programming.'),
(3, 'juanpedro', 'Juan.123.', 'Juan', 'webins', '2020-04-30', '3profile1.jpg', 'Community manager', 'Hi, im juan. I\'m a community manager. i like to shared very nice posts!'),
(4, 'maria44', 'Maria.44.', '', 'webins', '2020-04-30', '4profile3.jpg', '', 'I like to workout. be fitness is my pasion!'),
(5, 'camilo23', 'Camilo.123.', '', 'webins', '2020-04-30', '5profile2.jpg', 'Developer', 'I like to know everything about computers. Programming is one of my favorite things to do in life.');

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE `Categories` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`id`, `title`, `author`, `date`) VALUES
(1, 'Technology', 'admin', '2020-04-11'),
(2, 'Fitness', 'admin', '2020-04-11'),
(3, 'News', 'admin', '2020-04-11'),
(8, 'Sports', 'Webins', '2020-04-19');

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`id`, `post_id`, `name`, `email`, `comment`, `approved_by`, `status`, `date`) VALUES
(21, 28, 'Beek', 'beek@gmail.com', 'Ethical hackers may use the same methods and tools used by the malicious hackers but with the permission of the authorized person for the purpose of improving the security and defending the systems from attacks by malicious users. ethical hackers are expected to report all the vulnerabilities and weakness found during the process to the management.', 'juanpedro', 1, '2020-04-30'),
(22, 28, 'Reik', 'andres_guzc@gmail.com', 'Ethical hackers are expected to report all the vulnerabilities and weakness found during the process to the management.', 'juanpedro', 1, '2020-04-30'),
(23, 28, 'Kelly', 'kleivermarcano4@gmail.com', 'Is posible to be hacked if i used the network?', 'nobody', 0, '2020-04-30'),
(24, 30, 'Maria', 'maria_j21@gmail.com', ' when you are fit, you have: energy to do what\'s important to you and to be more productive stamina and a positive outlook to handle the mental challenges and emotional ups and downs of everyday life and to deal with stress reduced risk for many health problems, such as heart disease, cancer, diabetes and osteoporosis the chance to look and feel your best physical strength and endurance to accomplish physical challenges a better chance for a higher quality of life and perhaps a longer life, too', 'juanpedro', 1, '2020-04-30'),
(25, 30, 'Juancarlos', 'juanpablo@gmail.com', '\"fitness\" is a broad term that means something different to each person, but it refers to your own optimal health and overall well-being. being fit not only means physical health, but emotional and mental health, too. it defines every aspect of your health. smart eating and active living are fundamental to fitness.', 'juanpedro', 1, '2020-04-30'),
(26, 31, 'Miguel', 'maria_j21@gmail.com', 'I\'ve never had a sexy ab.', 'juanpedro', 1, '2020-04-30'),
(27, 29, 'Carlos', 'carlosG_13@hotmail.com', 'Big data is used everytime', 'juanpedro', 1, '2020-04-30'),
(28, 27, 'Louis', 'assaas@gmail.com', 'I prefer use c++, it\'s my favorite', 'juanpedro', 1, '2020-04-30'),
(29, 25, 'Pedro', 'assaas@gmail.com', 'Very interesting post.!', 'nobody', 0, '2020-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `Posts`
--

CREATE TABLE `Posts` (
  `id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Posts`
--

INSERT INTO `Posts` (`id`, `title`, `category`, `author`, `image`, `post`, `date`) VALUES
(25, 'The science of social media social media algorithms: how they work and how to use them in your favor', 'Technology', 'Juanpedro', '2020-04-30 11:37:25Social-Media-Algorithm-1024x599.jpg', 'Social media algorithms are a lot like “dog years.”\r\n\r\nthey seems to progress and change at a rate of seven years for every one year on the human calendar.\r\n\r\nwe’ve seen first-hand the dramatic declines in traffic and organic reach over the last two years as so many businesses have.\r\n\r\nbut despite the challenges that marketers face with social media algorithms, there is still a way to overcome them and share your content with the world.\r\n\r\nmichael stelzner, ceo and found of social media examiner, has been in the business of social media since 2009 (when organic reach and traffic numbers were going strong). we had the pleasure of chatting with michael all about how social media algorithms work and how marketers and businesses can implement strategies to use algorithms in their favor to get great content seen.', '2020-04-30'),
(26, 'How to communicate to fans in social medias', 'Technology', 'Juanpedro', '2020-04-30 11:39:43Social-media-app-icons-stock-1920.jpg', 'When you are on facebook, twitter, instagram, youtube and tiktok, maybe even more social medias. how often should you update each channel, for it to be just about enough, not too much, but not too little?\r\n\r\nthere is no correct answer but here are some of the findings that other successful artists use to follow.\r\n\r\ninstagram – post only one picture per day, but stories can be posted more frequently throughout the day. posting stories also makes your profile easy to notice every time your followers enter instagram, and constantly keeps your name in their mind.\r\n\r\nfacebook – no right or wrong here, but ideally once a day. 3-4 times per week is also acceptable. remember to post constantly, not only right before an event or release day. if you post constantly facebooks algorithm pushes your content higher up on your followers profiles and in front of more people (without having to market the post). if you suddenly go from not writing anything to writing a lot, then facebooks algorithms will show your posts to less people.\r\n\r\ntwitter – you are allowed to be active here. we recommend commenting on others you like, repost the ones you like and generally like others posts. use 5-10 minutes every day on twitter. if you are about to release a new single or album, tweet it to your favorite journalists.\r\n\r\nwe also recommend artists to be active in other social medias such as youtube and tiktok. read our blogposts about youtube and tiktok for more info about those channels.', '2020-04-30'),
(27, 'Python: 7 important reasons why you should use python', 'Technology', 'Camilo23', '2020-04-30 11:45:07pythonpost.jpeg', 'According to the latest tiobe programming community index, python is one of the top 10 popular programming languages of 2017. python is a general purpose and high level programming language. you can use python for developing desktop gui applications, websites and web applications. also, python, as a high level programming language, allows you to focus on core functionality of the application by taking care of common programming tasks. the simple syntax rules of the programming language further makes it easier for you to keep the code base readable and application maintainable. there are also a number of reasons why you should prefer python to other programming languages.\r\n\r\n7 reasons why you must consider writing software applications in python\r\n\r\n1) readable and maintainable code\r\n2) multiple programming paradigms\r\n3) compatible with major platforms and systems\r\n4) robust standard library\r\n5) many open source frameworks and tools\r\n6) simplify complex software development\r\n7) adopt test driven development\r\n\r\n\r\nhowever, python, like other programming languages, has its own shortcomings. it lacks some of the built-in features provided by other modern programming language. hence, you have to use python libraries, modules, and frameworks to accelerate custom software development. also, several studies have shown that python is slower than several widely used programming languages including java and c++. you have to speed up the python application by making changes to the application code or using custom runtime. but you can always use python to speed up software development and simplify software maintenance.', '2020-04-30'),
(28, 'What is ethical hacking?', 'Technology', 'Camilo23', '2020-04-30 11:47:03Ethical-Hacking.jpg', 'Ethical hacking sometimes called as penetration testing is an act of intruding/penetrating into system or networks to find out threats, vulnerabilities in those systems which a malicious attacker may find and exploit causing loss of data, financial loss or other major damages.  the purpose of ethical hacking is to improve the security of the network or systems by fixing the vulnerabilities found during testing. ethical hackers may use the same methods and tools used by the malicious hackers but with the permission of the authorized person for the purpose of improving the security and defending the systems from attacks by malicious users.\r\nethical hackers are expected to report all the vulnerabilities and weakness found during the process to the management.', '2020-04-30'),
(29, 'Big data', 'Technology', 'Camilo23', '2020-04-30 11:48:41bigdata.jpeg', 'Big data is also data but with a huge size. big data is a term used to describe a collection of data that is huge in volume and yet growing exponentially with time. in short such data is so large and complex that none of the traditional data management tools are able to store it or process it efficiently. \r\n\r\nbigdata\' could be found in three forms:\r\n\r\n    structured\r\n    unstructured\r\n    semi-structured\r\n', '2020-04-30'),
(30, 'What is fitness?', 'Fitness', 'Maria44', '2020-04-30 11:53:12fitness.jpg', '\"fitness\" is a broad term that means something different to each person, but it refers to your own optimal health and overall well-being. being fit not only means physical health, but emotional and mental health, too. it defines every aspect of your health. smart eating and active living are fundamental to fitness.\r\n\r\naccording to the academy of nutrition and dietetics\' complete food and nutrition guide (3rd ed.), when you are fit, you have:\r\n\r\n    energy to do what\'s important to you and to be more productive\r\n    stamina and a positive outlook to handle the mental challenges and emotional ups and downs of everyday life and to deal with stress\r\n    reduced risk for many health problems, such as heart disease, cancer, diabetes and osteoporosis\r\n    the chance to look and feel your best\r\n    physical strength and endurance to accomplish physical challenges\r\n    a better chance for a higher quality of life and perhaps a longer life, too', '2020-04-30'),
(31, 'The 8 best ways to get 6-pack abs fast', 'Fitness', 'Maria44', '2020-04-30 11:57:18woman-doing-ab-exercises-thumb.jpg', 'Whether you’re aiming to achieve your fitness goals or simply want to look good in a swimsuit, acquiring a sculpted set of six-pack abs is a goal shared by many.\r\n\r\ngetting a six-pack requires dedication and hard work, but you don’t have to hit the gym seven days a week or become a professional bodybuilder to do so.\r\n\r\ninstead, a few modifications to your diet and lifestyle can be enough to produce serious, long-lasting results.\r\n\r\nhere are 8 simple ways to achieve six-pack abs quickly and safely.\r\n\r\n1. do more cardio\r\n2. exercise your abdominal muscles\r\n3. increase your protein intake\r\n4. try high-intensity interval training\r\n5. stay hydrated\r\n6. stop eating processed food\r\n7. cut back on refined carbs\r\n8. fill up on fiber\r\n\r\nthere’s much more to getting six-pack abs than simply doing a few crunches or planks each day.\r\n\r\ninstead, it requires following a healthy diet and maintaining an active lifestyle to help achieve your goals.\r\n\r\nmaking a few simple switches in your daily routine can get you a set of six-pack abs and improve your health at the same time.', '2020-04-30'),
(32, 'Luis suarez injury: barcelona star striker out for four months with knee issue', 'Sports', 'Juanpedro', '2020-04-30 23:33:34suarez.jpg', 'Barcelona announced sunday that star striker luis suarez will be out for four months due to a knee injury. it\'s a massive blow to the team\'s title hopes both in spain and in europe. suarez injured his external meniscus in his right knee against atletico madrid in the spanish super cup semifinals on thursday and will be sidelined at least until may.\r\nsuarez has 14 goals in 23 games so far this season, and he\'s a player that barca just can\'t afford to lose. he\'s their only real pure striker. without suarez the club will likely be forced into making a significant move in the winter transfer window to patch up the no. 9 position. part of barca\'s struggles in recent seasons in the champions league has been to a lack of depth at that position behind the uruguayan. \r\n\r\nthe injury will also force him to miss the start of world cup qualifying in march with the uruguay national team. \r\n\r\nwhile barca still obviously has lionel messi and antoine griezmann, the lack of a strong presence in the box may force ernesto valverde to tinker with his formation and go with messi and griezmann as the strikers, giving bigger roles to younger players in the middle until a replacement is found. \r\n\r\nbarca is currently in the last 16 of the champions league where the squad will face napoli for a spot in the quarterfinals. the first leg of their matchup is feb. 25. the catalan club is also in first place in la liga.', '2020-04-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `Posts`
--
ALTER TABLE `Posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `Posts`
--
ALTER TABLE `Posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `Posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
