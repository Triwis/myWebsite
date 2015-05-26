-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 26 Mai 2015 à 19:16
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `websitedb`
--

-- --------------------------------------------------------

--
-- Structure de la table `failedloging`
--

CREATE TABLE IF NOT EXISTS `failedloging` (
  `username` varchar(20) DEFAULT NULL,
  `datetried` varchar(70) DEFAULT NULL,
  `passwordtried` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `failedloging`
--

INSERT INTO `failedloging` (`username`, `datetried`, `passwordtried`) VALUES
('Triwis', '11-17-2014 13:2:44', 'aaa'),
('Triwis', '11-17-2014 13:25:23', 'try1'),
('', '11-17-2014 20:4:21', ''),
('aaa', '11-18-2014 9:26:28', 'aaa'),
('Triwisemplate', '11-20-2014 13:34:11', 'T'),
('''; DELETE FROM users', '11-20-2014 18:59:10', 'aaa'),
('aaa', '11-20-2014 18:59:38', '''; DELETE FROM users'),
('''; DROP TABLE users;', '11-20-2014 18:59:59', '''; DROP TABLE users;'),
('', '1-26-2015 18:24:45', ''),
('', '1-26-2015 21:1:50', ''),
('', '1-26-2015 21:33:3', ''),
('', '1-26-2015 21:33:23', ''),
('', '1-28-2015 12:39:18', ''),
('a', '2-5-2015 19:53:40', 'aaaaaa'),
('Triwis', '5-26-2015 12:35:4', 'Template'),
('Triwis', '5-26-2015 12:49:12', 'Template');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(75) NOT NULL DEFAULT 'EMPTY',
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `authlevel` int(10) unsigned NOT NULL,
  `isactive` bit(1) NOT NULL,
  `isnew` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `authlevel`, `isactive`, `isnew`) VALUES
(1, 'Louis-Maxime', 'Gendron', 'louismaxime.gendron@gmail.com', 'lmgendron', '$2y$10$xwbEdTL2QsMQHcR09B7n3Ok6p5AN6zjgBfi5tKdzUi59/6gTXe4D6', 1, b'1', b'0'),
(15, 'test', 'test', 'test', 'test', '$2y$10$70ZJ0aYXjMa1vOFy0r52QOaFZr5zW1EvXJ.NwNn1URi6yzDCeqotC', 3, b'1', b'0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
