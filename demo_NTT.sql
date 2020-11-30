-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 30 nov. 2020 à 23:03
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dst_v2_db_updated`
--

-- --------------------------------------------------------

--
-- Structure de la table `revenuesprotection_item`
--

DROP TABLE IF EXISTS `revenuesprotection_item`;
CREATE TABLE IF NOT EXISTS `revenuesprotection_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` text,
  `unit` varchar(256) DEFAULT NULL,
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenuesprotection_item`
--

INSERT INTO `revenuesprotection_item` (`id`, `name`, `description`, `unit`, `cat`) VALUES
(21, 'Occupancy and Notification-Offices-7.8-Item #7', '', NULL, 293),
(20, 'Occupancy and Notification-Offices-7.8-Item #6', '', NULL, 293),
(19, 'new test', '', NULL, 155),
(18, 'test 3', '', NULL, 155),
(17, 'test 2', '', NULL, 467),
(16, 'qre', '', NULL, 155),
(15, 'item test', '', NULL, 54),
(22, 'Occupancy and Notification-Offices-7.8-Item #8', '', NULL, 309),
(23, 'Occupancy and Notification-Offices-7.8-Item #9', '', NULL, 309),
(24, 'Occupancy and Notification-Offices-7.8-Item #10', '', NULL, 319),
(25, 'Occupancy and Notification-Offices-7.9-Item #1', '', NULL, 319),
(26, 'Occupancy and Notification-Offices-7.9-Item #2', '', NULL, 329),
(27, 'Occupancy and Notification-Offices-7.9-Item #3', '', NULL, 329),
(28, 'Occupancy and Notification-Offices-7.9-Item #4', '', NULL, 339),
(29, 'Occupancy and Notification-Offices-7.9-Item #5', '', NULL, 339),
(30, 'Occupancy and Notification-Offices-7.9-Item #6', '', NULL, 349),
(31, 'Occupancy and Notification-Offices-7.9-Item #7', '', NULL, 349),
(32, 'Occupancy and Notification-Offices-7.9-Item #8', '', NULL, 365),
(33, 'Occupancy and Notification-Offices-7.9-Item #9', '', NULL, 365),
(34, 'Occupancy and Notification-Offices-7.9-Item #10', '', NULL, 375),
(35, 'Occupancy and Notification-Offices-7.9-Item #11', '', NULL, 375),
(36, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #1', '', NULL, 385),
(37, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #2', '', NULL, 385),
(38, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #3', '', NULL, 395),
(39, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #4', '', NULL, 395),
(40, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #5', '', NULL, 405),
(41, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #6', '', NULL, 405),
(42, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #7', '', NULL, 415),
(43, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #8', '', NULL, 415),
(44, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #9', '', NULL, 431),
(45, 'Occupancy and Notification-Factory/Manufact.-7.4-Item #10', '', NULL, 431),
(46, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #1', '', NULL, 441),
(47, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #2', '', NULL, 441),
(48, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #3', '', NULL, 457),
(49, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #4', '', NULL, 457),
(50, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #5', '', NULL, 467),
(51, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #6', '', NULL, 467),
(52, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #7', '', NULL, 477),
(53, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #8', '', NULL, 477),
(54, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #9', '', NULL, 195),
(55, 'Occupancy and Notification-Factory/Manufact.-7.5-Item #10', '', NULL, 67),
(56, 'qre', '', NULL, 155),
(57, 'qre', '', NULL, 155),
(58, 'qre', '', NULL, 155),
(59, 'qre', '', NULL, 155),
(60, 'qre', '', NULL, 155),
(61, 'qre', '', NULL, 155),
(62, 'qre', '', NULL, 155),
(63, 'qre', '', NULL, 155),
(64, 'qre', '', NULL, 155),
(65, 'qre', '', NULL, 155),
(66, 'qre', '', NULL, 155),
(67, 'qre', '', NULL, 155),
(68, 'qre', '', NULL, 155),
(69, 'qre', '', NULL, 155),
(70, 'qre', '', NULL, 155),
(71, 'qre', '', NULL, 155),
(72, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1133),
(73, 'Enhanced Tax revenues from growing activity', '', NULL, 1133),
(74, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1149),
(75, 'Enhanced Tax revenues from growing activity', '', NULL, 1149),
(76, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1159),
(77, 'Enhanced Tax revenues from growing activity', '', NULL, 1159),
(78, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1169),
(79, 'Enhanced Tax revenues from growing activity', '', NULL, 1169),
(80, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1179),
(81, 'Enhanced Tax revenues from growing activity', '', NULL, 1179),
(82, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1189),
(83, 'Enhanced Tax revenues from growing activity', '', NULL, 1189),
(84, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1205),
(85, 'Enhanced Tax revenues from growing activity', '', NULL, 1205),
(86, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1215),
(87, 'Enhanced Tax revenues from growing activity', '', NULL, 1215),
(88, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1225),
(89, 'Enhanced Tax revenues from growing activity', '', NULL, 1225),
(90, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1235),
(91, 'Enhanced Tax revenues from growing activity', '', NULL, 1235),
(92, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1245),
(93, 'Enhanced Tax revenues from growing activity', '', NULL, 1245),
(94, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1255),
(95, 'Enhanced Tax revenues from growing activity', '', NULL, 1255),
(96, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1271),
(97, 'Enhanced Tax revenues from growing activity', '', NULL, 1271),
(98, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1281),
(99, 'Enhanced Tax revenues from growing activity', '', NULL, 1281),
(100, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1297),
(101, 'Enhanced Tax revenues from growing activity', '', NULL, 1297),
(102, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1307),
(103, 'Enhanced Tax revenues from growing activity', '', NULL, 1307),
(104, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1317),
(105, 'Enhanced Tax revenues from growing activity', '', NULL, 1317),
(106, 'Revenues generated from additional footfall', '', NULL, 1035),
(107, 'Developing revenues thanks to customer profiling profiling / Smart CRM', '', NULL, 907),
(108, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1553),
(109, 'Enhanced Tax revenues from growing activity', '', NULL, 1553),
(110, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1569),
(111, 'Enhanced Tax revenues from growing activity', '', NULL, 1569),
(112, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1579),
(113, 'Enhanced Tax revenues from growing activity', '', NULL, 1579),
(114, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1589),
(115, 'Enhanced Tax revenues from growing activity', '', NULL, 1589),
(116, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1599),
(117, 'Enhanced Tax revenues from growing activity', '', NULL, 1599),
(118, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1609),
(119, 'Enhanced Tax revenues from growing activity', '', NULL, 1609),
(120, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1625),
(121, 'Enhanced Tax revenues from growing activity', '', NULL, 1625),
(122, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1635),
(123, 'Enhanced Tax revenues from growing activity', '', NULL, 1635),
(124, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1645),
(125, 'Enhanced Tax revenues from growing activity', '', NULL, 1645),
(126, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1655),
(127, 'Enhanced Tax revenues from growing activity', '', NULL, 1655),
(128, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1665),
(129, 'Enhanced Tax revenues from growing activity', '', NULL, 1665),
(130, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1675),
(131, 'Enhanced Tax revenues from growing activity', '', NULL, 1675),
(132, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1691),
(133, 'Enhanced Tax revenues from growing activity', '', NULL, 1691),
(134, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1701),
(135, 'Enhanced Tax revenues from growing activity', '', NULL, 1701),
(136, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1717),
(137, 'Enhanced Tax revenues from growing activity', '', NULL, 1717),
(138, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1727),
(139, 'Enhanced Tax revenues from growing activity', '', NULL, 1727),
(140, 'Restauration of Business activity and resulting Revenues ', '', NULL, 1737),
(141, 'Enhanced Tax revenues from growing activity', '', NULL, 1737),
(142, 'Revenues generated from additional footfall', '', NULL, 1455),
(143, 'Developing revenues thanks to customer profiling profiling / Smart CRM', '', NULL, 1327);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
