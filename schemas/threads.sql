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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

