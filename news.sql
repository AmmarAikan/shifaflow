-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 19, 2024 at 07:29 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

DROP TABLE IF EXISTS `about_us`;
CREATE TABLE IF NOT EXISTS `about_us` (
  `about_id` int(255) NOT NULL AUTO_INCREMENT,
  `about_text` text NOT NULL,
  PRIMARY KEY (`about_id`),
  KEY `about_id` (`about_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`about_id`, `about_text`) VALUES
(1, '<h4>ddddd</h4><ul><li><i><strong>sssss</strong></i></li><li><i><strong>fffffff</strong></i></li></ul>'),
(2, '<h3>fgfgg</h3><p><i><strong>ssssss</strong></i></p><ol><li>cddddfd</li></ol>'),
(3, '<h4>dddd</h4><ul><li><i><strong>ssdfg</strong></i></li><li><i><strong>fxfghj</strong></i></li><li><i><strong>vbnm</strong></i></li></ul>'),
(4, '<p>asdfghj</p><p><i><strong>sdfghkj</strong></i></p><ol><li><i><strong>cggdfgdg</strong></i></li><li><i><strong>dfdgdgdf</strong></i></li><li><i><strong>dfsgf</strong></i></li><li><i><strong>ssfgfgdf</strong></i></li></ol>'),
(5, '<figure class=\"table\"><table><tbody><tr><td>ssssss</td><td>sssss</td></tr><tr><td>ss</td><td>ss</td></tr><tr><td>ss</td><td>ss</td></tr></tbody></table></figure>'),
(6, '<h4>safdgfhgg</h4><p>sdaafdssfd</p><p><i><strong>asfdsff</strong></i></p><ul><li><i><strong>ali</strong></i></li><li><i><strong>dsfdg</strong></i></li></ul><p><a href=\"https://www.google.com\"><i><strong>https://www.google.com</strong></i></a></p>');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `cont_id` int(255) NOT NULL AUTO_INCREMENT,
  `cont_user_name` varchar(255) NOT NULL,
  `cont_user_email` varchar(255) NOT NULL,
  `cont_user_text` text NOT NULL,
  PRIMARY KEY (`cont_id`),
  KEY `cont_id` (`cont_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`cont_id`, `cont_user_name`, `cont_user_email`, `cont_user_text`) VALUES
(2, 'ee', 'ee', 'i\'m'),
(3, 'ali', 'd@d', 'i\'m ali'),
(7, 'a', 'm@yahoo.com', 'aaaa'),
(8, 'aa', 'd@gmail.com', 'sdsd'),
(9, 'Mohammed', 'a@hotmail.com', 'eee'),
(10, 'ahmed', 'a@hotmail.com', 'ff'),
(11, 'Mohammed', 'a@hotmail.com', 'qwerty'),
(12, 'saleh', 's@gmail.com', 'asd'),
(13, 'dd', 'a@hotmail.com', 'qwertyuio;85236'),
(14, 'Mohammed', 'a@hotmail.com', 'dd'),
(15, 'ahmed ali', 'a@hotmail.com', 'fdghj'),
(16, 'dd', 'a@hotmail.com', 'zdfsgdf');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `nwes_id` int(255) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) NOT NULL,
  `news_date` datetime NOT NULL,
  `news_text` text NOT NULL,
  `news_type` varchar(10) NOT NULL,
  `news_img` varchar(255) NOT NULL DEFAULT 'test.png',
  PRIMARY KEY (`nwes_id`),
  KEY `nwes_id` (`nwes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`nwes_id`, `news_title`, `news_date`, `news_text`, `news_type`, `news_img`) VALUES
(1, 'How Gazaâ€™s hospitals became batt', '2024-01-15 03:35:00', '<p>Relentless bombardment, power outages and shortages have pushed nearly every hospital in the beleaguered northern Gaza Strip out of service, with evidence of repeated attacks on and in the vicinity of medical facilities despite the presence of doctors, patients and civilians inside, a CNN analysis has found.</p><p>At least 20 out of 22 hospitals identified by CNN in northern Gaza were damaged or destroyed in the first two months of <a href=\"https://edition.cnn.com/world/middleeast/israel\">Israel\'s war against Hamas</a>, from October 7 to December 7, according to a review of 45 satellite images and around 400 videos from the ground, as well as interviews with doctors, eyewitnesses and humanitarian organizations. Fourteen were directly hit, based on the evidence collected and verified by CNN and analyzed by experts.</p><p>Israel launched its bombardment and ground invasion of the Gaza Strip after <a href=\"https://edition.cnn.com/2023/11/15/middleeast/bodycam-video-hamas-massacre-tunnels-intl/index.html\">Hamasâ€™ October 7 terrorist attack</a>, in which at least 1,200 people were killed and more than 240 others taken hostage. In the first two months of the war, at least 17,100 Palestinians were killed in Israeli attacks on the strip, according to the <a href=\"https://edition.cnn.com/middleeast/live-news/israel-hamas-war-gaza-news-12-07-23/h_03bf4375f2b3eccf622391a8c9221a04\">Hamas-run Gaza Health Ministry</a>. At the time of publishing, that number was <a href=\"https://edition.cnn.com/middleeast/live-news/israel-hamas-war-gaza-news-01-11-24/h_739a72b3a27cbcd722b11f6029d68345\">more than 23,400</a>.</p><p><a href=\"https://edition.cnn.com/2023/11/14/middleeast/israel-alleges-hamas-armory-under-hospital-in-gaza-hnk-intl/index.html\">Israel says</a> that Hamas operates inside and underneath hospitals, and is using them for military operations, including as command centers, weapons stores and to hide hostages. The Israelis have released footage they say is evidence of those Hamas operations. The videos do not offer definitive proof, and Hamas has denied the claims.</p><p>CNN sent a list of the hospitals identified as damaged or destroyed to the Israel Defense Forces (IDF). In response, the IDF said it â€œdid not conduct any targeted attacks against hospitals in the Gaza Strip,â€ adding that â€œHamas systematically misuses hospitals and medical facilities.â€</p><p>Tracking how aerial bombardment has impacted hospitals in northern Gaza gives a sense of the scale and scope of devastation that the war has wrought on the enclaveâ€™s health system â€” and the knock-on impact to civilians who have .</p>', 'World', 'kitchen.jpg'),
(2, 'US tennis star Ben Shelton doesnâ€™t want to â€˜put a ceilingâ€™ on what he ', '2024-01-18 03:42:00', '<p>About this time last year, <a href=\"https://cnn.com/2023/01/24/tennis/ben-shelton-profile-australian-open-spt-intl/index.html\">Ben Shelton</a> was an up-and-coming <a href=\"https://cnn.com/sport/tennis\">tennis</a> player taking his first-ever trip outside the United States.</p><p>Not long out of college, Shelton was relatively unknown on the circuit having only been pro for the past six months. But armed with a lethal serve and the fearlessness of youth, things were about to change â€“ fast.</p><p>â€œI feel like it went from nobody knowing me to a lot of people knowing me kind of overnight,â€ Shelton tells <a href=\"https://www.cnn.com/sport\">CNN Sport</a>. â€œIt felt really quick.â€</p><p>&nbsp;</p><p>Skip ahead 12 months and the 21-year-old American is in Australia preparing to play in his sixth grand slam and second at Melbourne Park.</p><p>At this point in his young career, Sheltonâ€™s results have been excellent: he reached the quarterfinals of last yearâ€™s Australian Open and went a step further at the US Open, eventually losing to <a href=\"https://cnn.com/2023/09/08/tennis/novak-djokovic-ben-shelton-us-open-spt-intl/index.html\">Novak Djokovic</a> in a fiery semifinal. Several weeks after that, he won his first ATP Tour title in Japan.</p><p>It figures, then, that Shelton enters his second full season as a professional tennis player with weighty expectations.</p><p>Itâ€™s now been just over 20 years since Roddick triumphed at the US Open, and Shelton is the latest American looking to end that drought. He is currently 16th in the world rankings and has the company of compatriots Taylor Fritz, Tommy Paul and Frances Tiafoe in the top 20.</p><p>Shelton, however, is coy about his ambitions for the year ahead.</p><p>â€œI feel like no matter what you say in the press, someoneâ€™s going say: â€˜Oh, you shot too high or you shot too low,â€™â€ he says.</p><p>â€œSo Iâ€™m going to keep my result-based goals between me and my team â€¦ I donâ€™t have anything in my mind that Iâ€™m really setting out for yet. I feel like I donâ€™t want to put a ceiling on myself and what I can achieve. I just want to take things one step at a time and see where I am at the end of this year.â€</p>', 'Sport', '240110113938-01-ben-shelton-profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(255) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `user_gender` varchar(6) NOT NULL,
  `user_country` varchar(10) NOT NULL,
  `user_img` varchar(255) NOT NULL DEFAULT 'test.png',
  `user_type` varchar(6) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_email`, `phone`, `user_gender`, `user_country`, `user_img`, `user_type`) VALUES
(2, 'qq qq qq', '202cb962ac59075b964b07152d234b70', 'qq@yahoo.com', '959568542', 'Male', 'Yemen', 'Screenshot 2023-09-22 120248.jpg', 'Admin'),
(3, 'aa aa aa', 'd9b1d7db4cd6e70935368a1efb10e377', 'tttt@yahoo.com', '963852147', 'Male', 'KSA', 'test.png', 'User'),
(4, 'gh gh gh', 'd03667a26715d8cab7ec259080f1c746', '102@yahoo.com', '987456321', 'Female', 'China', 'test.png', 'User');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

---------------
