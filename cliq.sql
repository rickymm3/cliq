-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2013 at 04:58 PM
-- Server version: 5.5.30-cll
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rickym6_cliq`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('2c860f34bc966c2b2faeb76545261fcb', '66.249.75.188', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 1367415183, ''),
('52407b2fcb16797a36693f6722ca6856', '66.249.75.188', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 1367411388, 0x613a333a7b733a393a22757365725f64617461223b733a303a22223b733a31343a226163746976655f66696c74657273223b613a303a7b7d733a31303a22706167656c6f61646564223b623a313b7d),
('5c34b591ef1393cd4df039d11e314fb8', '173.15.173.113', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0', 1367412484, 0x613a333a7b733a393a22757365725f64617461223b733a303a22223b733a31343a226163746976655f66696c74657273223b613a303a7b7d733a31303a22706167656c6f61646564223b623a313b7d),
('6619765210e938d940c6ed1e97ca36f3', '66.249.75.188', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 1367412800, ''),
('f9195fcaa9c07f5c4a7a9a3354389fed', '66.249.75.188', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 1367412722, '');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `favorites_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `keywords_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`favorites_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorites_id`, `user_id`, `keywords_id`, `position`) VALUES
(1, 1, 6, 1),
(2, 1, 7, 2),
(3, 1, 8, 3),
(4, 1, 9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `keywords_id` int(9) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL,
  `parent_id` int(9) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`keywords_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `keywords`
--

INSERT INTO `keywords` (`keywords_id`, `keyword`, `parent_id`, `count`) VALUES
(1, 'News', 0, 5),
(2, 'Entertainment', 0, 0),
(3, 'Sci/Tech', 0, 0),
(4, 'Viral', 0, 0),
(5, 'Sports', 0, 0),
(6, 'Baseball', 5, 0),
(7, 'football', 5, 0),
(8, 'Curling', 5, 0),
(9, 'Pitchers', 6, 0),
(10, 'Catchers', 6, 0),
(11, 'Fitness', 0, 0),
(12, 'Marathons', 11, 0),
(13, 'Boston', 12, 0),
(14, 'Philadelphia', 12, 0),
(15, 'Rock and Roll', 14, 0),
(16, 'CES 2013', 3, 0),
(17, 'Web Apps', 3, 0),
(18, 'youtube', 4, 0),
(19, 'Anime', 0, 0),
(20, 'Star Wars', 0, 0),
(21, 'episode 1', 20, 0),
(22, 'steak recipes', 0, 0),
(23, 'paris', 12, 0),
(24, 'Hockey', 5, 0),
(25, 'Work', 0, 0),
(0, '!null', 0, 0),
(27, 'Omnia', 0, 0),
(28, 'interviews', 0, 0),
(29, 'globalfit', 28, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ktbridge`
--

CREATE TABLE IF NOT EXISTS `ktbridge` (
  `ktbridge_id` int(11) NOT NULL AUTO_INCREMENT,
  `threads_id` int(11) NOT NULL,
  `keywords_id` int(11) NOT NULL,
  PRIMARY KEY (`ktbridge_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `ktbridge`
--

INSERT INTO `ktbridge` (`ktbridge_id`, `threads_id`, `keywords_id`) VALUES
(1, 1, 9),
(2, 1, 6),
(3, 1, 5),
(4, 2, 11),
(5, 2, 12),
(6, 3, 3),
(7, 3, 16),
(8, 4, 1),
(9, 5, 6),
(10, 5, 5),
(11, 6, 11),
(12, 8, 4),
(13, 9, 4),
(14, 9, 18),
(15, 10, 19),
(16, 11, 20),
(17, 12, 20),
(18, 12, 21),
(19, 14, 22),
(20, 15, 11),
(21, 15, 12),
(22, 15, 23),
(23, 16, 2),
(24, 17, 5),
(25, 17, 24),
(26, 18, 5),
(27, 18, 7),
(28, 19, 5),
(29, 20, 5),
(30, 20, 8),
(31, 21, 25),
(32, 13, 0),
(33, 22, 27),
(34, 23, 28),
(35, 23, 29);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `threads_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(50) NOT NULL,
  `body` varchar(12000) NOT NULL,
  `users_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `replystamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastposter_id` int(11) NOT NULL,
  `slug` varchar(25) NOT NULL,
  `numreplies` int(11) NOT NULL,
  `numviews` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`threads_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`threads_id`, `subject`, `body`, `users_id`, `timestamp`, `replystamp`, `lastposter_id`, `slug`, `numreplies`, `numviews`, `parent_id`) VALUES
(1, 'Subject-Sports Baseball Pitchers', 'Sports - Baseball - Pitchers - Body', 1, '2013-01-09 14:09:40', '0000-00-00 00:00:00', 1, '1-subject-sports-baseball', 0, 0, 9),
(2, 'Boston Marathon', 'Boston Marathon', 1, '2013-01-09 19:46:34', '0000-00-00 00:00:00', 1, '2-boston-marathon', 0, 0, 13),
(3, 'CES show Samsung wins', 'go apple', 1, '2013-01-09 19:51:33', '0000-00-00 00:00:00', 1, '3-ces-show-samsung-wins', 0, 0, 16),
(4, 'General News Post', 'This is a general news post', 1, '2013-01-14 19:01:11', '0000-00-00 00:00:00', 1, '4-this-is-a-general-news-', 0, 0, 1),
(5, 'Baseball is fun', 'General baseball post', 1, '2013-01-14 19:03:24', '0000-00-00 00:00:00', 1, '5-baseball-is-fun', 0, 0, 6),
(6, 'try searching for fitness', 'body--try searching for fitness', 1, '2013-01-14 19:05:42', '0000-00-00 00:00:00', 1, '6-try-searching-for-fitne', 0, 0, 11),
(8, 'starting a viral post', '<p>And here is the body of the viral post</p>', 1, '2013-01-15 16:01:15', '2013-01-15 16:01:15', 1, '8-starting-a-viral-post', 0, 0, 4),
(9, 'funny youtubes', '<p>Can you think of any funny youtube videos?</p>', 1, '2013-01-15 16:02:35', '2013-01-15 16:02:35', 1, '9-funny-youtubes', 0, 0, 18),
(10, 'Manga is better than Anime', '<p>Because you can use your imagination, and the budget constraints don''t ruin the experience.</p>', 1, '2013-01-15 16:19:56', '2013-01-15 16:19:56', 1, '10-manga-is-better-than-a', 0, 0, 19),
(11, 'Lets discuss StarWars', '<p>Those lil'' jabbas</p>', 1, '2013-01-15 16:23:39', '2013-01-15 16:23:39', 1, '11-lets-discuss-starwars', 0, 0, 20),
(12, 'Lets discuss Episode1', '<p>In comparison to the rest...it was TERRIBLE</p>', 1, '2013-01-15 16:24:40', '2013-01-15 16:24:40', 1, '12-lets-discuss-episode1', 0, 0, 21),
(13, 'creating in general', '<p>No keywords selected.</p>\n<p>And<strong> bolded text</strong></p>', 1, '2013-01-15 20:43:54', '2013-01-15 20:43:54', 1, '13-creating-in-general', 0, 0, 0),
(14, 'sirloin steak recipe', '<p>I am looking for a steak recipe with tomato sauce and wine</p>\n<p>&nbsp;</p>', 1, '2013-01-15 22:23:35', '2013-01-15 22:23:35', 1, '14-sirloin-steak-recipe', 0, 0, 22),
(15, 'Runnin In Paree', '<p>I was going to run this marathon, but then I got HI! Off LIFE!</p>', 1, '2013-01-16 19:54:29', '2013-01-16 19:54:29', 1, '15-runnin-in-paree', 0, 0, 23),
(16, 'How Bout Dat Kim Kardashian baby', '<p>who really cares?</p>', 1, '2013-01-16 20:23:46', '2013-01-16 20:23:47', 1, '16-how-bout-dat-kim-karda', 0, 0, 2),
(17, 'Creating hockey with new routes', '<p>Changed routes, not attempting to ensure its still working...Hockey!!!</p>', 1, '2013-01-16 20:30:14', '2013-01-16 20:30:14', 1, '17-creating-hockey-with-n', 0, 0, 24),
(18, 'Creating Football', '<p>And heres a thread on football - server seesm to be running a lil faster again today...</p>', 1, '2013-01-17 15:13:26', '2013-01-17 15:13:26', 1, '18-creating-football', 0, 0, 7),
(19, 'generic sports', '<p>with last id here</p>', 1, '2013-01-22 15:47:10', '2013-01-22 15:47:10', 1, '19-generic-sports', 0, 0, 5),
(20, 'time for a curling post', '<p>And here it isss...!</p>', 1, '2013-01-22 15:48:33', '2013-01-22 15:48:33', 1, '20-time-for-a-curling-pos', 0, 0, 8),
(21, 'Ohhh Work', '<p>A hard work ethic yeilds good work</p>', 1, '2013-01-22 17:12:31', '2013-01-22 17:12:31', 1, '21-ohhh-work', 0, 0, 25),
(22, 'Server Transfer Imminent', '<p>Webhosting hub is going extremely slow due to some sort of , ''problem page.'' Hopefully i can get out of this server cluster and into a faster one.</p>', 1, '2013-01-25 18:30:26', '2013-01-25 18:30:26', 1, '22-server-transfer-immine', 0, 0, 0),
(23, 'Testing Subject', '<p>This should have to do with a job interview from Global Fit</p>', 1, '2013-04-25 16:14:11', '2013-04-25 16:14:11', 1, '23-testing-subject', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`) VALUES
(1, 'rickymm3', '$P$B5qOVIAV.yJ3UP46US8QsmuC5MYFwy1', 'rickymm3@gmail.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '173.15.173.113', '2013-05-06 16:12:39', '2012-12-14 11:03:38', '2013-05-06 20:12:39'),
(2, 'bob23', '$P$BVrNUhjFxJBRh8oy0VDfrIVSUkL6aJ1', 'bob23@mailinator.com', 1, 0, NULL, NULL, NULL, NULL, NULL, '71.162.148.210', '0000-00-00 00:00:00', '2013-01-24 11:35:49', '2013-01-24 16:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_autologin`
--

INSERT INTO `user_autologin` (`key_id`, `user_id`, `user_agent`, `last_ip`, `last_login`) VALUES
('dfe69980c4688f23b85fcd87672b88ec', 1, 'Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0', '12.236.43.222', '2013-01-14 16:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `avatar_loc` varchar(99) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`, `avatar_loc`) VALUES
(1, 1, NULL, NULL, 'img/page/avatar.png'),
(2, 2, NULL, NULL, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
