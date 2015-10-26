-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2015 at 01:37 AM
-- Server version: 5.5.41-log
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------
--
-- Table structure for table `quiz_game`
--
CREATE TABLE IF NOT EXISTS `quiz_game` (
`id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `solution_1` varchar(50) NOT NULL,
  `solution_2` varchar(50) NOT NULL,
  `solution_3` varchar(50) NOT NULL,
  `correct_solution_index` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='questions for quiz game' AUTO_INCREMENT=21 ;

--
-- Dumping data for table `quiz_game`
--
INSERT INTO `quiz_game` (`id`, `question`, `solution_1`, `solution_2`, `solution_3`, `correct_solution_index`) VALUES
(1, 'Peace cannot be kept by force; it can only be achieved by understanding.', 'Albert Einstein', 'Winston Churchill', 'Abraham Lincoln', 0),
(2, 'Do not dwell in the past, do not dream of the future, concentrate the mind on the present moment.', 'Buddha', 'Steve Jobs', 'Walt Disney', 0),
(3, 'People won''t have time for you if you are always angry or complaining.', 'Stephen Hawking', 'Steve Jobs', 'Muhammad Ali', 0),
(4, 'Love all, trust a few, do wrong to none.', 'William Shakespeare', 'Aristotle', 'Confucius', 0),
(5, 'The way to get started is to quit talking and begin doing.', 'Walt Disney', 'Winston Churchill', 'Albert Einstein', 0),
(6, 'Start by doing what''s necessary; then do what''s possible; and suddenly you are doing the impossible.', 'Francis of Assisi', 'Helen Keller', 'Jimmy Dean', 0),
(7, 'The best and most beautiful things in the world cannot be seen or even touched - they must be felt with the heart.', 'Helen Keller', 'Francis of Assisi', 'Jimmy Dean', 0),
(8, 'Perfection is not attainable, but if we chase perfection we can catch excellence.', 'Jimmy Dean', 'Francis of Assisi', 'Helen Keller', 0),
(9, 'Try to be a rainbow in someone''s cloud.', 'Maya Angelou', 'Audrey Hepburn', 'Aristotle Onassis', 0),
(10, 'Nothing is impossible, the word itself says ''I''m possible''!', 'Audrey Hepburn', 'Aristotle Onassis', 'Maya Angelou', 0),
(11, 'It is during our darkest moments that we must focus to see the light.', 'Aristotle Onassis', 'Audrey Hepburn', 'Maya Angelou', 0),
(12, 'The true sign of intelligence is not knowledge but imagination.', 'Albert Einstein', 'Martin Luther King, Jr', 'Stephen Hawking', 0),
(13, 'We are all now connected by the Internet, like neurons in a giant brain.', 'Stephen Hawking', 'Dr. Seuss', 'Gabe Newell', 0),
(14, 'Intelligence is the ability to adapt to change.', 'Stephen Hawking', 'Alber Einstein', 'Nelson Mandela', 0),
(15, 'Education is the most powerful weapon which you can use to change the world.', 'Nelson Mandela', 'John Dewey', 'Aristotle', 0),
(16, 'Education is not preparation for life; education is life itself.', 'John Dewey', 'Martin Luther King, Jr.', 'Abraham Lincoln', 0),
(17, 'Education is the movement from darkness to light.', 'Allan Bloom', 'Joseph Brodsky', 'Herbert Spencer', 0),
(18, 'Love isn''t something you find. Love is something that finds you.', ' Loretta Young', 'Mother Theresa', 'Audrey Hepburn', 0),
(19, 'Let us always meet each other with smile, for the smile is the beginning of love.', 'Mother Teresa', 'Loretta Young', 'Audrey Hepburn', 0),
(20, 'Always remember that you are absolutely unique. Just like everyone else.', 'Margaret Mead', 'Albert Einsten', 'Audrey Hepburn', 0);

--
-- Indexes for table `quiz_game`
--
ALTER TABLE `quiz_game`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `question` (`question`);

--
-- AUTO_INCREMENT for table `quiz_game`
--
ALTER TABLE `quiz_game`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;