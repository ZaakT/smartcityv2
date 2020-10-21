-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 21 oct. 2020 à 08:11
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

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `add_capex`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_capex` (IN `capex_name` VARCHAR(255), IN `capex_desc` VARCHAR(255), IN `idUC` INT, IN `unit` VARCHAR(255), IN `source` VARCHAR(255), IN `range_min` INT, IN `range_max` INT)  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO capex_item (name,description)
                                            VALUES (capex_name,capex_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO capex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO capex_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END$$

DROP PROCEDURE IF EXISTS `add_cashreleasing`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_cashreleasing` (IN `cashreleasing_name` VARCHAR(255), IN `cashreleasing_desc` VARCHAR(255), IN `unit` VARCHAR(255), IN `source` VARCHAR(255), IN `unit_cost` INT, IN `min_red_nb` INT, IN `max_red_nb` INT, IN `min_red_cost` INT, IN `max_red_cost` INT, IN `idUC` INT)  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO cashreleasing_item (name,description)
                                            VALUES (cashreleasing_name,cashreleasing_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO cashreleasing_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO cashreleasing_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost)
                                            VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost);
                                    END$$

DROP PROCEDURE IF EXISTS `add_entity`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_entity` (IN `entity_name` VARCHAR(255), IN `entity_desc` VARCHAR(255), IN `idSource` INT, IN `idScen` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO entity (name,description,id_source,id_finScen)
                                    VALUES (entity_name,entity_desc,idSource,idScen);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO others (id)
                                    VALUES (itemID);
                            END$$

DROP PROCEDURE IF EXISTS `add_implem`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_implem` (IN `implem_name` VARCHAR(255), IN `implem_desc` VARCHAR(255), IN `idUC` INT, IN `unit` VARCHAR(255), IN `source` VARCHAR(255), IN `range_min` INT, IN `range_max` INT)  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO implem_item (name,description)
                                            VALUES (implem_name,implem_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO implem_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO implem_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END$$

DROP PROCEDURE IF EXISTS `add_noncash`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_noncash` (IN `noncash_name` VARCHAR(255), IN `noncash_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO noncash_item (name,description)
                                    VALUES (noncash_name,noncash_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO noncash_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO noncash_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_opex`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_opex` (IN `opex_name` VARCHAR(255), IN `opex_desc` VARCHAR(255), IN `idUC` INT, IN `unit` VARCHAR(255), IN `source` VARCHAR(255), IN `range_min` INT, IN `range_max` INT)  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO opex_item (name,description)
                                            VALUES (opex_name,opex_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO opex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO opex_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END$$

DROP PROCEDURE IF EXISTS `add_quantifiable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_quantifiable` (IN `quantifiable_name` VARCHAR(255), IN `quantifiable_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO quantifiable_item (name,description)
                                    VALUES (quantifiable_name,quantifiable_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO quantifiable_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO quantifiable_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_revenues`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_revenues` (IN `revenues_name` VARCHAR(255), IN `revenues_desc` VARCHAR(255), IN `idUC` INT, IN `unit` VARCHAR(255), IN `source` VARCHAR(255), IN `range_min` INT, IN `range_max` INT)  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO revenues_item (name,description)
                                            VALUES (revenues_name,revenues_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO revenues_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO revenues_item_advice (id,unit,source,range_min,range_max)
                                            VALUES (itemID,unit,source,range_min,range_max);
                                    END$$

DROP PROCEDURE IF EXISTS `add_risk`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_risk` (IN `risk_name` VARCHAR(255), IN `risk_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO risk_item (name,description)
                                    VALUES (risk_name,risk_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO risk_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO risk_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_risks`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_risks` (IN `risks_name` VARCHAR(255), IN `risks_desc` VARCHAR(255), IN `idUC` INT)  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO risk_item (name,description) 
                                                VALUES (risks_name,risks_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO risk_uc (id_item,id_uc) VALUES (itemID,idUC);
                                    END$$

DROP PROCEDURE IF EXISTS `add_supplier_revenue`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_supplier_revenue` (IN `revenue_name` VARCHAR(255), IN `revenue_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `type_value` VARCHAR(255))  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO supplier_revenues_item (name,description, type, advice_user)
                                    VALUES (revenue_name,revenue_desc, type_value, "user");
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO supplier_revenues_uc (id_revenue,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO supplier_revenues_user (id_revenue,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_widercash`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_widercash` (IN `widercash_name` VARCHAR(255), IN `widercash_desc` VARCHAR(255), IN `unit` VARCHAR(255), IN `source` VARCHAR(255), IN `unit_cost` INT, IN `min_red_nb` INT, IN `max_red_nb` INT, IN `min_red_cost` INT, IN `max_red_cost` INT, IN `idUC` INT)  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO widercash_item (name,description)
                                            VALUES (widercash_name,widercash_desc);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO widercash_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO widercash_item_advice (id,unit,source,unit_cost,range_min_red_nb,range_max_red_nb,range_min_red_cost,range_max_red_cost)
                                            VALUES (itemID,unit,source,unit_cost,min_red_nb,max_red_nb,min_red_cost,max_red_cost);
                                    END$$

DROP PROCEDURE IF EXISTS `insert_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user` (IN `username` VARCHAR(255), IN `salt` VARCHAR(255), IN `password` VARCHAR(255), IN `nameMeasure` VARCHAR(255), IN `description` VARCHAR(255), IN `is_admin` INT, IN `profile` ENUM("d","s"))  BEGIN
                                DECLARE userID INT;
                                INSERT INTO user (username,salt,password,is_admin,profile)
                                    VALUES (username,salt,password,is_admin,profile);
                                SET userID = LAST_INSERT_ID();
                                INSERT INTO measure (name,description,user)
                                    VALUES (nameMeasure,description,userID);
                            END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `bankability_input_nogo_target`
--

DROP TABLE IF EXISTS `bankability_input_nogo_target`;
CREATE TABLE IF NOT EXISTS `bankability_input_nogo_target` (
  `id` int(11) NOT NULL COMMENT '= id_proj',
  `npv_nogo` int(11) DEFAULT NULL,
  `npv_target` int(11) DEFAULT NULL,
  `roi_nogo` int(11) DEFAULT NULL,
  `roi_target` int(11) DEFAULT NULL,
  `payback_nogo` int(11) DEFAULT NULL,
  `payback_target` int(11) DEFAULT NULL,
  `risks_rating_nogo` int(11) DEFAULT NULL,
  `risks_rating_target` int(11) DEFAULT NULL,
  `noncash_rating_nogo` int(11) DEFAULT NULL,
  `noncash_rating_target` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bankability_input_nogo_target`
--

INSERT INTO `bankability_input_nogo_target` (`id`, `npv_nogo`, `npv_target`, `roi_nogo`, `roi_target`, `payback_nogo`, `payback_target`, `risks_rating_nogo`, `risks_rating_target`, `noncash_rating_nogo`, `noncash_rating_target`) VALUES
(4, 3, 10000, 32, 43, 89, 2, 8, 3, 2, 2),
(6, 10, 200000, 5, 200, 12, 1, 9, 5, 2, 5);

-- --------------------------------------------------------

--
-- Structure de la table `beneficiary`
--

DROP TABLE IF EXISTS `beneficiary`;
CREATE TABLE IF NOT EXISTS `beneficiary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_finScen` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `share` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_finScen` (`id_finScen`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `beneficiary`
--

INSERT INTO `beneficiary` (`id`, `id_finScen`, `name`, `description`, `share`) VALUES
(1, 3, 'CAMILLE', NULL, 50),
(2, 3, 'LEPRINCE', NULL, 50),
(3, 4, 'CAMILLE', NULL, 40),
(4, 4, 'LEPRINCE', NULL, 60);

-- --------------------------------------------------------

--
-- Structure de la table `bm_bankability`
--

DROP TABLE IF EXISTS `bm_bankability`;
CREATE TABLE IF NOT EXISTS `bm_bankability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bm_bankability`
--

INSERT INTO `bm_bankability` (`id`, `name`, `description`) VALUES
(1, '<=3', 'not bankable'),
(2, '4 - 6', 'bankable'),
(3, '>= 7', 'highly bankable');

-- --------------------------------------------------------

--
-- Structure de la table `bm_funding_opt_perc`
--

DROP TABLE IF EXISTS `bm_funding_opt_perc`;
CREATE TABLE IF NOT EXISTS `bm_funding_opt_perc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bm_soc_bankability`
--

DROP TABLE IF EXISTS `bm_soc_bankability`;
CREATE TABLE IF NOT EXISTS `bm_soc_bankability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bm_soc_bankability`
--

INSERT INTO `bm_soc_bankability` (`id`, `name`, `description`) VALUES
(1, '<= 3', 'low societal value'),
(2, '4 - 6', 'medium societal value'),
(3, '>= 7', 'high societal value');

-- --------------------------------------------------------

--
-- Structure de la table `business_model`
--

DROP TABLE IF EXISTS `business_model`;
CREATE TABLE IF NOT EXISTS `business_model` (
  `id_investcap` int(11) DEFAULT NULL,
  `id_payconst` int(11) DEFAULT NULL,
  `id_bmpref` int(11) DEFAULT NULL,
  `id_proj` int(11) NOT NULL,
  PRIMARY KEY (`id_proj`),
  KEY `id_investcap` (`id_investcap`),
  KEY `id_bmpref` (`id_bmpref`),
  KEY `id_payconst` (`id_payconst`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `business_model`
--

INSERT INTO `business_model` (`id_investcap`, `id_payconst`, `id_bmpref`, `id_proj`) VALUES
(3, 3, 1, 4),
(1, 2, 3, 6);

-- --------------------------------------------------------

--
-- Structure de la table `business_model_pref`
--

DROP TABLE IF EXISTS `business_model_pref`;
CREATE TABLE IF NOT EXISTS `business_model_pref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `business_model_pref`
--

INSERT INTO `business_model_pref` (`id`, `name`, `description`) VALUES
(1, 'In House', 'internal'),
(2, 'Public Private Partnership', 'mixed internal / external'),
(3, 'Outsourced', 'supplier(s) based'),
(4, 'indifferent', 'indifferent');

-- --------------------------------------------------------

--
-- Structure de la table `business_model_reco`
--

DROP TABLE IF EXISTS `business_model_reco`;
CREATE TABLE IF NOT EXISTS `business_model_reco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `business_model_reco`
--

INSERT INTO `business_model_reco` (`id`, `name`) VALUES
(1, 'In House/PDU'),
(2, 'PPP(DBO/BOT)'),
(3, 'Outsourced/Esco');

-- --------------------------------------------------------

--
-- Structure de la table `capex_item`
--

DROP TABLE IF EXISTS `capex_item`;
CREATE TABLE IF NOT EXISTS `capex_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `origine` enum('from_ntt','from_outside_ntt','internal') NOT NULL DEFAULT 'from_ntt' COMMENT 'Used in supplier part',
  `side` enum('customer','supplier','projDev') NOT NULL DEFAULT 'projDev',
  `unit` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_item`
--

INSERT INTO `capex_item` (`id`, `name`, `description`, `origine`, `side`, `unit`) VALUES
(2, 'capexitem1', '', 'from_ntt', 'projDev', NULL),
(3, 'capexitem2', '', 'from_ntt', 'projDev', NULL),
(4, 'Capex name delibererement long 1', '', 'from_ntt', 'projDev', NULL),
(5, 'Capex name delibererement long 2', '', 'from_ntt', 'projDev', NULL),
(13, 'custom capex item', 'descr', 'from_ntt', 'projDev', NULL),
(15, '5G capex item', '', 'from_ntt', 'projDev', NULL),
(17, '_-fghçjiopk', '', 'from_ntt', 'projDev', NULL),
(19, 'test', '', 'from_ntt', 'projDev', NULL),
(21, 'Custom', '', 'from_ntt', 'projDev', NULL),
(22, 'cap', '', 'from_ntt', 'projDev', NULL),
(25, 'euh', '', 'from_ntt', 'projDev', NULL),
(26, 'Water Sensor', '', 'from_ntt', 'projDev', NULL),
(27, 'Strange Sensor', '', 'from_outside_ntt', 'projDev', NULL),
(28, 'LED type 2', '', 'from_outside_ntt', 'projDev', NULL),
(29, 'capex general test', '', 'from_ntt', 'projDev', NULL),
(30, 'capex common test ', '', 'from_ntt', 'projDev', NULL),
(31, 'Capex 1', 'description', 'from_ntt', 'projDev', NULL),
(32, 'Capex Common', '', 'from_ntt', 'projDev', NULL),
(33, 'test', '', 'from_ntt', 'projDev', NULL),
(34, 'capex test', '', 'from_ntt', 'projDev', NULL),
(36, 'capex test 2', '', 'from_ntt', 'projDev', NULL),
(37, 'Capex 1 supp', '', 'from_ntt', 'supplier', 'test2'),
(38, 'capex 2', '', 'from_ntt', 'supplier', 'test'),
(39, 'Cables', '', 'from_outside_ntt', 'customer', NULL),
(40, 'A', 'B', 'from_ntt', 'customer', NULL),
(41, 'capex test 1', '', 'from_ntt', 'customer', NULL),
(42, 'hjhjhj', '', 'from_ntt', 'projDev', NULL),
(44, 'myCap 2', '', 'from_ntt', 'customer', NULL),
(45, 'my 1st cap', '', 'from_ntt', 'supplier', 'unit'),
(46, 'cap', '', 'from_ntt', 'supplier', ''),
(47, 'Remote control Software', 'A web hosted control system which provides monitoring, switching and dimming control. ', 'from_ntt', 'projDev', NULL),
(48, 'Pole', 'Upgrade / replacement of the pole to enable use cases deployment', 'from_ntt', 'projDev', NULL),
(49, 'Smart Lampost', 'Implementaion of multi applications smart lamppost', 'from_ntt', 'projDev', NULL),
(50, 'LED street light', 'Light-emitting diode is an electronic device that gives off light when it receives an electrical current (90W-100W).\n', 'from_ntt', 'projDev', NULL),
(51, 'Electrical systems', 'Service cabinets, covering energy supply and metering facilities.', 'from_ntt', 'projDev', NULL),
(52, 'Remote control Software', 'A web hosted control system which provides monitoring, switching and dimming control. ', 'from_ntt', 'projDev', NULL),
(53, 'Street lighting control boxes', 'which can be mounted on electric lamp post\n', 'from_ntt', 'projDev', NULL),
(54, 'Box Gateway', 'It is used to receive information from wireless parking lot sensor and transmit this information to user system', 'from_ntt', 'projDev', NULL),
(55, 'EVSE charger ', 'Hardware and electrical integrations to the power grid.', 'from_ntt', 'projDev', NULL),
(56, 'Charging Connector ', 'Connectors and plug in for cars', 'from_ntt', 'projDev', NULL),
(57, 'Photovoltaic Solar Panel', 'A photovoltaic (PV) cell, commonly called a solar cell, is a non-mechanical device that converts sunlight directly into electricity.', 'from_ntt', 'projDev', NULL),
(58, 'Intelligent remote control', 'Smart Devices solutions allows to do a remote control', 'from_ntt', 'projDev', NULL),
(59, 'Battery', 'The device stores energy for supplying to electrical appliances when there is a demand. ', 'from_ntt', 'projDev', NULL),
(60, 'Battery', 'The device stores energy for supplying to electrical appliances when there is a demand. ', 'from_ntt', 'projDev', NULL),
(61, 'Remote telemetry system', 'An automated communications process by which measurements and other data are collected at remote or inaccessible points and transmitted to receiving equipment for monitoring.\n', 'from_ntt', 'projDev', NULL),
(62, 'Remote CCTV', 'A low-light camera with Wi-Fi connectivity, 3G/4G connectivity', 'from_ntt', 'projDev', NULL),
(63, 'DVR (Digital Video Recorder)', 'Network Video Recorder (NVR) - NVRs are responsible for video monitoring, event management, and storage.  ', 'from_ntt', 'projDev', NULL),
(64, 'Monitor/screens', 'Accessories, options include screens. ', 'from_ntt', 'projDev', NULL),
(65, 'Code Blue IP', 'IP 1500 VoIp / 2500 VoIp / 5000 VoIp speakerphones ', 'from_ntt', 'projDev', NULL),
(66, 'Wireless Concealed Placement Speaker ', 'Public Alerts posts and Info Concealed placement speaker (CPS).', 'from_ntt', 'projDev', NULL),
(67, 'Air Quality Sensor ', 'It measures and find dust particles in the air.\n', 'from_ntt', 'projDev', NULL),
(68, 'Software tool', 'Shows the measures and collects data. Data is accessible in real time and measurements can be consulted remotely.', 'from_ntt', 'projDev', NULL),
(69, 'Noise level sensor', 'The microphone is based on the LM386 amplifier and an electret microphone', 'from_ntt', 'projDev', NULL),
(70, 'Software tool', 'Shows the measures and collects data. Data is accessible in real time and measurements can be consulted remotely.', 'from_ntt', 'projDev', NULL),
(71, 'Water level sensor ', 'Measures water table levels in the base of a typical lamp post.', 'from_ntt', 'projDev', NULL),
(72, 'Software tool', 'Shows the measures and collects data. Data is accessible in real time and measurements can be consulted remotely.', 'from_ntt', 'projDev', NULL),
(73, 'Lamp post advertising light box', 'Scrolling light boxes, double sided, or rectangular, LED', 'from_ntt', 'projDev', NULL),
(74, 'PIR (passive infrared) Sensor', 'Passive sensors do not transmit energy; rather, they detect the energy that is emitted or reflected from vehicles, road surfaces, and humans and other objects in the field of view and from the atmosphere', 'from_ntt', 'projDev', NULL),
(75, 'Software tool', 'A web hosted control system which provides monitoring, switching and dimming control. ', 'from_ntt', 'projDev', NULL),
(76, 'Surface-mounted Smart Parking Sensor', 'A wireless Smart Parking Sigfox sensor that enables you to monitor parking spots or any reserved areas occupancy.', 'from_ntt', 'projDev', NULL),
(77, 'Wireless Data Collector/Gateway', 'It is used to receive information from wireless parking lot sensor and transmit this information to user system', 'from_ntt', 'projDev', NULL),
(78, 'Local parking guidance system ', 'Outdoor parking guidance monitors ', 'from_ntt', 'projDev', NULL),
(79, 'Wifi antenna', 'Wifi antenna attached to a street light box', 'from_ntt', 'projDev', NULL),
(80, 'Antennas (Distributed Antenna System)', 'Wireless communication system ', 'from_ntt', 'projDev', NULL),
(81, '5G antenna', 'Cells to efficiently deliver high speed mobile broadband and other low latency applications.', 'from_ntt', 'projDev', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `capex_item_advice`
--

DROP TABLE IF EXISTS `capex_item_advice`;
CREATE TABLE IF NOT EXISTS `capex_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min` int(11) DEFAULT NULL,
  `range_max` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_item_advice`
--

INSERT INTO `capex_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`) VALUES
(2, 'percapexitem1', NULL, 0, 100),
(3, 'per capexitem2', NULL, 0, 100),
(4, 'per example', NULL, 5, 10),
(5, 'per example', NULL, 7, 100),
(12, '', '', 1, 56),
(14, 'ver', 'vr', 3, 43),
(16, '', '', 54, 54),
(48, 'Per Steel Pole', 'https://www.alibaba.com/product-detail/XINTONG-6m-8-meter-height-street_60763795461.html?spm=a2700.7724857.normalList.20.1d3914e72DnSRo&s=p', 140, 530),
(49, 'Per Smart Lampost', 'https://www.euractiv.com/section/digital/news/european-cities-want-10-million-smart-streetlamps/', 2, 6),
(50, 'Per LED bulb', 'https://i-solar-street-light.en.made-in-china.com/product/djxmEvMVXIWL/China-Isolar-60W-8m-Battery-Hanging-Outdoor-Lighting-Solar-LED-Street-Light.html', 50, 150),
(51, 'Per streetlight cable system', 'https://www.made-in-china.com/productdirectory.do?word=led+street+light+transformer&subaction=hunt&style=b&mode=and&code=0&comProvince=nolimit&order=0&isOpenCorrection=1', 10, 30),
(52, 'Per remote control device', 'https://www.telensa.com/applications#street_lighting\n', 10, 15),
(53, 'Per sensor', 'https://www.meterboxesdirect.co.uk/electric-meter-pole-top-box-360-252-140-mm.html\n', 40, 100),
(54, 'Per Data collector', 'https://buy.advantech.eu/Buy-Online/bymodel-UTX-3117.htm', 280, 400),
(55, 'Per charger', ' https://www.amazon.com/dp/B01NCEIG1F/ref=sspa_dk_detail_3?psc=1&pd_rd_i=B01NCEIG1F\n', 465, 600),
(56, 'Per connector', 'https://www.amazon.fr/dp/B00YT75GWW/ref=dp_cerb_1\n', 150, 200),
(57, 'Per PV panel', 'https://www.alibaba.com/product-detail/Cheap-price-direct-from-factory-all_60603459369.html?spm=a2700.7724857.normalList.113.21262cd34L6WIS', 70, 150),
(58, 'Per remote control', 'https://www.amazon.co.uk/TOP-MAX-Wireless-Compatible-Control-Anywhere/dp/B077YF8LV6/ref=pd_day0_hl_107_23?_encoding=UTF8&pd_rd_i=B077YF8LV6&pd_rd_r=0fac8156-1a50-11e9-bd3a-1b03e59c87b4&pd_rd_w=aAYT7&pd_rd_wg=ep0A4&pf_rd_p=b082d07b-aaea-4f40-9ff3-d27463f74', 190, 210),
(59, 'Per battery', 'https://www.alibaba.com/product-detail/1kw-2kw-3kw-4kw-5kw-10kw_919057641.html?spm=a2700.7724838.2017005.6.6c254b77FmCO3R\n', 100, 400),
(60, 'Per battery', 'https://www.alibaba.com/product-detail/1kw-2kw-3kw-4kw-5kw-10kw_919057641.html?spm=a2700.7724838.2017005.6.6c254b77FmCO3R\n', 100, 400),
(61, 'Per telemetry system', 'https://www.amazon.co.uk/TOP-MAX-Wireless-Compatible-Control-Anywhere/dp/B077YF8LV6/ref=pd_day0_hl_107_23?_encoding=UTF8&pd_rd_i=B077YF8LV6&pd_rd_r=0fac8156-1a50-11e9-bd3a-1b03e59c87b4&pd_rd_w=aAYT7&pd_rd_wg=ep0A4&pf_rd_p=b082d07b-aaea-4f40-9ff3-d27463f74', 190, 210),
(62, 'Per CCTV', 'https://wardmay-cctv.en.made-in-china.com/product/vCRJeUoPnLhy/China-1080P-4X-10X-Optical-Zoom-Outdoor-Bullet-Waterproof-IP-PTZ-Security-Camera.html', 90, 350),
(63, 'Per recorder', 'https://www.security-camera-warehouse.com/the-admiral-4-channel-nvr-adm4p4.php', 150, 380),
(64, 'Per monitor', 'https://www.ebay.co.uk/itm/Hanns-G-18-5-inch-Flat-Screen-Professional-Monitor-LED-LCD-PC-CCTV-Display-UK/291391010247?epid=1188645162&hash=item43d841f5c7:g:tTIAAOSwpDdU7O0K', 100, 140),
(65, 'Per VoIP speakerphone ', 'https://www.commgear.com/security-systems/emergency-telephones/code-blue-ip5000-voip-speakerphone-upgrade-from-one-button-to-two-button-with-keypad.html', 300, 2),
(66, 'Per concealed loudspeakers', 'https://www.amazon.com/Acoustic-Research-Outdoor-Wireless-AW826/dp/B003EV6OTS', 80, 230),
(67, 'Per sensor', 'https://www.wunderground.com/cat6/purple-airs-250-air-pollution-monitor-gives-government-equipment-run-money\n', 200, 310),
(68, 'Per software', 'https://www.fr.paessler.com/prtg?utm_source=google&utm_medium=cpc&utm_campaign=ROW_FR_Search-nonBrand_broad_2&utm_adgroup=networking-softwares&utm_adnum=171032094950&utm_keyword=%2Bnetworking%20%2Bsoftwares&utm_device=c&utm_position=1t1&utm_campaignid=367', 10, 25),
(69, 'Per sensor', 'https://www.reichelt.com/fr/fr/arduino-capteur-sonore-grove-grv-sound-sens-p191177.html?PROVID=2788&gclid=EAIaIQobChMI2vqCw_q14AIVE_hRCh1aiQaBEAQYBiABEgJu5fD_BwE&&r=1', 5, 10),
(70, 'Per software', 'https://www.fr.paessler.com/prtg?utm_source=google&utm_medium=cpc&utm_campaign=ROW_FR_Search-nonBrand_broad_2&utm_adgroup=networking-softwares&utm_adnum=171032094950&utm_keyword=%2Bnetworking%20%2Bsoftwares&utm_device=c&utm_position=1t1&utm_campaignid=367', 10, 25),
(71, 'Per sensor', 'https://www.alibaba.com/product-detail/IP68-water-level-sensor_60701581079.html?spm=a2700.7724857.normalList.21.40be13e4NmLJJf&s=p', 30, 80),
(72, 'Per software', 'https://www.fr.paessler.com/prtg?utm_source=google&utm_medium=cpc&utm_campaign=ROW_FR_Search-nonBrand_broad_2&utm_adgroup=networking-softwares&utm_adnum=171032094950&utm_keyword=%2Bnetworking%20%2Bsoftwares&utm_device=c&utm_position=1t1&utm_campaignid=367', 10, 25),
(73, 'Per light box', 'https://www.alibaba.com/product-detail/Outdoor-street-LED-middle-lamp-post_60549918471.html?spm=a2700.7724857.normalList.138.45f7f5c74p8TiE', 350, 620),
(74, 'Per sensor', 'https://www.englishlampposts.co.uk/garden-lamp-posts-pir', 15, 25),
(75, 'Per software', 'http://qulon.pro\n', 25, 85),
(76, 'Per sensor', 'https://www.alibaba.com/product-detail/IoT-Smart-Parking-sensor-SGM-201_50041290513.html?spm=a2700.7724838.2017115.338.2b876201jEvMqY', 60, 115),
(77, 'Per gateway', 'https://buy.advantech.eu/Buy-Online/bymodel-UTX-3117.htm', 280, 400),
(78, 'Per monitor', 'https://www.alibaba.com/product-detail/customized-7-segment-elevator-display-variable_1318854093.html?spm=a2700.7724838.2017115.151.ea412e94Sw6kMk', 20, 60),
(79, 'Per antenna', 'https://www.alibaba.com/product-detail/All-in-one-body-led-street_60858254472.html?spm=a2700.galleryofferlist.normalList.187.77646241mK7Kzj', 15, 50),
(80, 'Per antenna', 'http://www.l-com.com/wireless-antenna-24-ghz-6-dbi-omnidirectional-antenna-n-female-connector', 45, 140),
(81, 'Per antenna', 'https://www.alibaba.com/product-detail/Antenna-Manufacturer-5G-5-8GHz-2x15_60625518394.html?spm=a2700.7724838.2017115.353.7c277109fTWItv', 30, 60);

-- --------------------------------------------------------

--
-- Structure de la table `capex_item_user`
--

DROP TABLE IF EXISTS `capex_item_user`;
CREATE TABLE IF NOT EXISTS `capex_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_item_user`
--

INSERT INTO `capex_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(25, 3),
(31, 3),
(13, 4),
(15, 4),
(23, 4),
(24, 4),
(30, 4),
(42, 4),
(17, 6),
(18, 8),
(19, 8),
(20, 8),
(21, 8),
(22, 8),
(26, 8),
(27, 8),
(28, 8),
(29, 8),
(32, 11),
(33, 21),
(34, 21),
(35, 21),
(36, 21),
(37, 21),
(38, 21),
(41, 21),
(43, 21),
(44, 21),
(46, 21),
(39, 23),
(40, 23),
(45, 24),
(47, 27);

-- --------------------------------------------------------

--
-- Structure de la table `capex_uc`
--

DROP TABLE IF EXISTS `capex_uc`;
CREATE TABLE IF NOT EXISTS `capex_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_uc`
--

INSERT INTO `capex_uc` (`id_item`, `id_uc`) VALUES
(29, -1),
(30, -1),
(31, -1),
(32, -1),
(34, -1),
(35, -1),
(36, -1),
(37, -1),
(38, -1),
(39, -1),
(43, -1),
(44, -1),
(45, -1),
(3, 1),
(4, 1),
(5, 1),
(13, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(2, 2),
(3, 2),
(12, 3),
(17, 3),
(25, 3),
(40, 3),
(28, 5),
(14, 6),
(16, 6),
(15, 7),
(23, 7),
(24, 7),
(33, 7),
(41, 9),
(26, 11),
(27, 11),
(42, 11),
(46, 11),
(48, 12),
(49, 13),
(50, 14),
(51, 14),
(52, 15),
(53, 15),
(54, 15),
(47, 16),
(55, 16),
(56, 16),
(57, 17),
(58, 17),
(59, 17),
(60, 18),
(61, 18),
(62, 19),
(63, 19),
(64, 19),
(65, 20),
(66, 21),
(67, 22),
(68, 22),
(69, 23),
(70, 23),
(71, 24),
(72, 24),
(73, 25),
(74, 26),
(75, 26),
(76, 27),
(77, 27),
(78, 27),
(79, 28),
(80, 29),
(81, 30);

-- --------------------------------------------------------

--
-- Structure de la table `cashreleasing_item`
--

DROP TABLE IF EXISTS `cashreleasing_item`;
CREATE TABLE IF NOT EXISTS `cashreleasing_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cashreleasing_item`
--

INSERT INTO `cashreleasing_item` (`id`, `name`, `description`) VALUES
(1, 'crb1', ''),
(2, 'crb2', ''),
(3, 'cash releasing benefit item 1', ''),
(4, 'CRB', ''),
(5, 'CASHRELEASING', ''),
(6, 'htbg', ''),
(7, 'cash releasingb', ''),
(8, 'CRB 1', ''),
(9, 'CRB 2', ''),
(10, 'CRB 3', ''),
(11, 'CRB 4', ''),
(12, 'cash item', ''),
(13, 'save 1', ''),
(14, 'crb', ''),
(15, 'Reduction of Electricity costs', ''),
(16, 'Reduction of Electricity costs', ''),
(17, 'Reduction of light Maintenance costs ', ''),
(18, 'Reduction of Electricity costs', ''),
(19, 'Reduction of light Maintenance costs ', ''),
(20, 'Reduction of Electricity costs', ''),
(21, 'Reduction of Electricity costs', '');

-- --------------------------------------------------------

--
-- Structure de la table `cashreleasing_item_advice`
--

DROP TABLE IF EXISTS `cashreleasing_item_advice`;
CREATE TABLE IF NOT EXISTS `cashreleasing_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `unit_cost` double DEFAULT NULL,
  `range_min_red_nb` double DEFAULT NULL,
  `range_max_red_nb` double DEFAULT NULL,
  `range_min_red_cost` double DEFAULT NULL,
  `range_max_red_cost` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cashreleasing_item_advice`
--

INSERT INTO `cashreleasing_item_advice` (`id`, `unit`, `source`, `unit_cost`, `range_min_red_nb`, `range_max_red_nb`, `range_min_red_cost`, `range_max_red_cost`) VALUES
(1, 'per example', NULL, 15, 1.2, 1.8, 10, 11),
(2, 'per example', NULL, 1, 2, 3, 4, 5),
(3, 'per example', NULL, 2, 3, 4, 5, 6),
(16, 'Kwh', 'http://www.eclairageprofessionnel.fr/relamping-led-transition-energetique/', 0, 50, 70, 0, 0),
(17, 'Per Light bulb', 'http://www.eclairageprofessionnel.fr/relamping-led-transition-energetique/\n', 30, 0, 0, 50, 80),
(18, 'Per Kwh', 'https://www.lumenia.com/solutions/lumenia-cms-lum-central-management-system\n', 0, 15, 50, 0, 0),
(19, 'Per light bulb', ' https://www.lumenia.com/solutions/lumenia-cms-lum-central-management-system\n', 30, 45, 60, 0, 0),
(20, 'Per Kwh', 'https://mysolarhome.us/solar-lamp-post/', 0, 40, 60, 0, 0),
(21, 'Per Kwh', 'https://ledcorporations.com/led-lighting-news/the-cost-of-electricity-how-utility-companies-are-charging-consumers/\n', 0, 40, 60, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `cashreleasing_item_user`
--

DROP TABLE IF EXISTS `cashreleasing_item_user`;
CREATE TABLE IF NOT EXISTS `cashreleasing_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cashreleasing_item_user`
--

INSERT INTO `cashreleasing_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 4),
(5, 4),
(7, 4),
(8, 8),
(9, 8),
(10, 8),
(11, 8),
(12, 21),
(14, 21),
(13, 23),
(15, 27);

-- --------------------------------------------------------

--
-- Structure de la table `cashreleasing_uc`
--

DROP TABLE IF EXISTS `cashreleasing_uc`;
CREATE TABLE IF NOT EXISTS `cashreleasing_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cashreleasing_uc`
--

INSERT INTO `cashreleasing_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(7, 2),
(5, 3),
(13, 3),
(6, 5),
(12, 9),
(8, 11),
(9, 11),
(10, 11),
(11, 11),
(14, 11),
(16, 14),
(17, 14),
(18, 15),
(19, 15),
(15, 16),
(20, 17),
(21, 18);

-- --------------------------------------------------------

--
-- Structure de la table `component`
--

DROP TABLE IF EXISTS `component`;
CREATE TABLE IF NOT EXISTS `component` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `id_meas` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_meas` (`id_meas`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `component`
--

INSERT INTO `component` (`id`, `name`, `id_meas`) VALUES
(1, 'comp1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comp_per_zone`
--

DROP TABLE IF EXISTS `comp_per_zone`;
CREATE TABLE IF NOT EXISTS `comp_per_zone` (
  `id_zone` int(11) NOT NULL,
  `id_compo` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_zone`,`id_compo`),
  KEY `id_compo` (`id_compo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comp_per_zone`
--

INSERT INTO `comp_per_zone` (`id_zone`, `id_compo`, `number`) VALUES
(3, 1, 100),
(4, 1, 543),
(5, 1, 23),
(6, 1, 5768),
(7, 1, 987);

-- --------------------------------------------------------

--
-- Structure de la table `crit`
--

DROP TABLE IF EXISTS `crit`;
CREATE TABLE IF NOT EXISTS `crit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `scoring_guidance` text,
  `id_cat` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cat` (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `crit`
--

INSERT INTO `crit` (`id`, `name`, `description`, `scoring_guidance`, `id_cat`) VALUES
(1, 'crit_11', '', '1. Not at All <br />2.Poor', 1),
(2, 'crit_12', '', 'biugtrvnf\r\nvirdcnklvnf\r\nvribiornobg\r\n3. vuifeibiovnrfnv juvbirbvng', 1),
(3, 'crit_21', '', NULL, 2),
(4, 'crit_22', '', NULL, 2),
(5, 'crit_13', '', 'Likert scale:\r\nNo improvement - 1 - 2 - 3 - 4 - 5 - Very high improvement.\r\n\r\n    1. Not at all: the access to basic health care services was not imporved.\r\n    2. Poor: there was little improvement in the accessibility of basic health care services.\r\n    3. Somewhat: access to basic health care services was imroved, including a few important amenities such as a general practitioner or a pharmaacy.\r\n    4. Good: access to a sufficien number of health care service are widely available offline an donline (i.e. repeat prescriptions) was improved.\r\n    5. Excellent: access to a wide variety of basic health care services are widely available offline and online (i.e. first aid apps) was improved.\r\n', 1),
(6, 'crit123', '', NULL, 2),
(9, 'ighorvf', 'gtrfed', 'biugtrvnf\r\nvirdcnklvnf\r\nvribiornobg\r\n3. vuifeibiovnrfnv juvbirbvng', 1),
(10, 'Criterion 1', 'bvgfd', 'Likert scale:\r\nNo improvement - 1 - 2 - 3 - 4 - 5 - Very high improvement.\r\n\r\n    1. Not at all: the access to basic health care services was not imporved.\r\n    2. Poor: there was little improvement in the accessibility of basic health care services.\r\n    3. Somewhat: access to basic health care services was imroved, including a few important amenities such as a general practitioner or a pharmaacy.\r\n    4. Good: access to a sufficien number of health care service are widely available offline an donline (i.e. repeat prescriptions) was improved.\r\n    5. Excellent: access to a wide variety of basic health care services are widely available offline and online (i.e. first aid apps) was improved.\r\n', 2);

-- --------------------------------------------------------

--
-- Structure de la table `critcat`
--

DROP TABLE IF EXISTS `critcat`;
CREATE TABLE IF NOT EXISTS `critcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `critcat`
--

INSERT INTO `critcat` (`id`, `name`) VALUES
(1, 'criteria_cat_1'),
(2, 'criteria_cat_2');

-- --------------------------------------------------------

--
-- Structure de la table `deal_criteria_input_nogo_target`
--

DROP TABLE IF EXISTS `deal_criteria_input_nogo_target`;
CREATE TABLE IF NOT EXISTS `deal_criteria_input_nogo_target` (
  `id` int(11) NOT NULL,
  `societal_npv_nogo` int(11) DEFAULT NULL,
  `societal_npv_target` int(11) DEFAULT NULL,
  `societal_roi_nogo` int(11) DEFAULT NULL,
  `societal_roi_target` int(11) DEFAULT NULL,
  `societal_payback_nogo` int(11) DEFAULT NULL,
  `societal_payback_target` int(11) DEFAULT NULL,
  `npv_nogo` int(11) DEFAULT NULL,
  `npv_target` int(11) DEFAULT NULL,
  `roi_nogo` int(11) DEFAULT NULL,
  `roi_target` int(11) DEFAULT NULL,
  `payback_nogo` int(11) DEFAULT NULL,
  `payback_target` int(11) DEFAULT NULL,
  `risks_rating_nogo` int(11) DEFAULT NULL,
  `risks_rating_target` int(11) DEFAULT NULL,
  `nqbr_nogo` int(11) DEFAULT NULL,
  `nqbr_target` int(11) DEFAULT NULL,
  `operating_margin_nogo` int(11) DEFAULT NULL,
  `operating_margin_target` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `deal_criteria_input_nogo_target`
--

INSERT INTO `deal_criteria_input_nogo_target` (`id`, `societal_npv_nogo`, `societal_npv_target`, `societal_roi_nogo`, `societal_roi_target`, `societal_payback_nogo`, `societal_payback_target`, `npv_nogo`, `npv_target`, `roi_nogo`, `roi_target`, `payback_nogo`, `payback_target`, `risks_rating_nogo`, `risks_rating_target`, `nqbr_nogo`, `nqbr_target`, `operating_margin_nogo`, `operating_margin_target`) VALUES
(3, NULL, NULL, NULL, NULL, NULL, NULL, 15, 15, 15, 15, 5, 5, NULL, NULL, NULL, NULL, 5, 5),
(6, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0, 0),
(8, 0, 30000, 0, 20, 40, 12, 50000, 100000, 10, 30, 36, 12, 5, 1, 3, 9, 0, 0),
(21, NULL, NULL, NULL, NULL, NULL, NULL, 5000, 150000, 5, 50, 26, 5, NULL, NULL, NULL, NULL, 0, 30),
(23, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 20, 24, 2, NULL, NULL, NULL, NULL, 5, 20);

-- --------------------------------------------------------

--
-- Structure de la table `devise`
--

DROP TABLE IF EXISTS `devise`;
CREATE TABLE IF NOT EXISTS `devise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `rateToGBP` double DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `devise`
--

INSERT INTO `devise` (`id`, `name`, `symbol`, `rateToGBP`) VALUES
(1, 'GBP', '£', 1),
(2, 'USD', 'US$', 0.85105),
(3, 'EUR', '€', 0.76642);

-- --------------------------------------------------------

--
-- Structure de la table `dlt`
--

DROP TABLE IF EXISTS `dlt`;
CREATE TABLE IF NOT EXISTS `dlt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dlt`
--

INSERT INTO `dlt` (`id`, `name`, `description`) VALUES
(1, 'city', ''),
(2, 'subzone', ''),
(3, 'Montreal', '');

-- --------------------------------------------------------

--
-- Structure de la table `entity`
--

DROP TABLE IF EXISTS `entity`;
CREATE TABLE IF NOT EXISTS `entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_source` int(11) NOT NULL,
  `id_finScen` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `share` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_source` (`id_source`),
  KEY `id_finScen` (`id_finScen`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entity`
--

INSERT INTO `entity` (`id`, `id_source`, `id_finScen`, `name`, `description`, `start_date`, `share`) VALUES
(1, 1, 3, 'feçhvof', '', '2020-02-01', 90),
(2, 1, 3, 'entity 2', '', '2020-01-01', 10),
(3, 1, 4, 'ENT', '', '2013-06-01', 30);

-- --------------------------------------------------------

--
-- Structure de la table `equipment_revenues`
--

DROP TABLE IF EXISTS `equipment_revenues`;
CREATE TABLE IF NOT EXISTS `equipment_revenues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price_per_unit` int(11) NOT NULL,
  `nb_units` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipment_revenues`
--

INSERT INTO `equipment_revenues` (`id`, `name`, `price_per_unit`, `nb_units`) VALUES
(1, 'Equipement 1', 10, 50),
(2, 'Equipement 2', 100, 1),
(3, 'Equipement 3', 1, 25),
(4, 'Equipement 4', 50, 50),
(5, 'Equipment 5', 22, 35);

-- --------------------------------------------------------

--
-- Structure de la table `financing_scenario`
--

DROP TABLE IF EXISTS `financing_scenario`;
CREATE TABLE IF NOT EXISTS `financing_scenario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `input_invest` double DEFAULT '-1',
  `input_op` double DEFAULT '-1',
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modif_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_proj` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `financing_scenario`
--

INSERT INTO `financing_scenario` (`id`, `name`, `description`, `input_invest`, `input_op`, `creation_date`, `modif_date`, `id_proj`) VALUES
(1, 'scenar1', '', -1, -1, '2020-02-11 14:55:35', NULL, 0),
(2, 'scnear', '', -1, -1, '2020-02-11 14:55:41', NULL, 0),
(3, 'scenar1', 'scenar test du 2 mars', 136632.5, 345, '2020-03-02 14:01:30', '2020-10-16 14:25:50', 4),
(4, 'scenario test', 'test', 136632.5, 3456, '2020-04-28 12:04:44', '2020-05-29 10:03:29', 4);

-- --------------------------------------------------------

--
-- Structure de la table `funding_source`
--

DROP TABLE IF EXISTS `funding_source`;
CREATE TABLE IF NOT EXISTS `funding_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `description` text,
  `id_cat` int(11) NOT NULL,
  `hasEntities` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_cat` (`id_cat`),
  KEY `id_type` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `funding_source`
--

INSERT INTO `funding_source` (`id`, `id_type`, `name`, `description`, `id_cat`, `hasEntities`) VALUES
(1, 1, 'City', '', 1, 1),
(2, 1, 'Other Public Authorities', '', 1, 1),
(3, 1, 'Private', '', 2, 1),
(4, 1, 'Public', '', 2, 1),
(5, 2, 'Term Loans', '', 3, 1),
(6, 2, 'Revolving Loans', '', 3, 1),
(7, 2, 'Amortizing Bonds', '', 4, 1),
(8, 2, 'Bullet Bonds', '', 4, 1),
(9, 1, 'European Structural Funds', '', 5, 1),
(10, 1, 'National Grants', '', 5, 1),
(11, 1, 'Crowdfunding', '', 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `funding_sources_category`
--

DROP TABLE IF EXISTS `funding_sources_category`;
CREATE TABLE IF NOT EXISTS `funding_sources_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `funding_sources_category`
--

INSERT INTO `funding_sources_category` (`id`, `name`, `description`) VALUES
(1, 'Budgetary Funding', ''),
(2, 'Equity Funding', ''),
(3, 'Bank Credit Facility', ''),
(4, 'Bonds & Green Bonds', ''),
(5, 'Grant & subsidies', ''),
(6, 'Crowdfunding', '');

-- --------------------------------------------------------

--
-- Structure de la table `funding_sources_type`
--

DROP TABLE IF EXISTS `funding_sources_type`;
CREATE TABLE IF NOT EXISTS `funding_sources_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `funding_sources_type`
--

INSERT INTO `funding_sources_type` (`id`, `name`, `description`) VALUES
(1, 'Others', NULL),
(2, 'Loans & Bonds', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `implem_item`
--

DROP TABLE IF EXISTS `implem_item`;
CREATE TABLE IF NOT EXISTS `implem_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `origine` enum('from_ntt','from_outside_ntt','internal') NOT NULL DEFAULT 'from_ntt',
  `side` enum('customer','supplier','projDev') NOT NULL DEFAULT 'projDev',
  `unit` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_item`
--

INSERT INTO `implem_item` (`id`, `name`, `description`, `origine`, `side`, `unit`) VALUES
(1, 'impitem1', '', 'from_ntt', 'projDev', NULL),
(3, 'implementation item 2', 'description', 'from_ntt', 'projDev', NULL),
(4, 'implementation item 2', '', 'from_ntt', 'projDev', NULL),
(5, 'test imp item', '10/03 10:28', 'from_ntt', 'projDev', NULL),
(6, 'IMPLEM', '', 'from_ntt', 'projDev', NULL),
(8, '5G IMPLEM ITEM', '', 'from_ntt', 'projDev', NULL),
(11, 'aaaa', '', 'from_ntt', 'projDev', NULL),
(12, 'setup', '', 'from_outside_ntt', 'projDev', NULL),
(13, 'Construction', '', 'internal', 'projDev', NULL),
(14, 'Verification', '', 'from_outside_ntt', 'projDev', NULL),
(15, 'Construction ', '', 'from_ntt', 'projDev', NULL),
(16, 'Deployment', 'ffffffffffffffffff', 'from_outside_ntt', 'projDev', NULL),
(17, 'Deployment Common test', '', 'from_outside_ntt', 'projDev', NULL),
(18, 'dep test', '', 'from_outside_ntt', 'projDev', NULL),
(24, 'dep 2', '', 'from_ntt', 'projDev', NULL),
(25, 'dep tests', '', 'from_ntt', 'projDev', NULL),
(26, 'dep 01', '', 'from_ntt', 'supplier', ''),
(27, 'fgh', '', 'from_ntt', 'customer', NULL),
(28, 'a', '', 'from_ntt', 'customer', NULL),
(29, 'xc', '', 'from_ntt', 'customer', NULL),
(30, 'xcv', '', 'from_outside_ntt', 'customer', NULL),
(31, 'xcvw', '', 'internal', 'customer', NULL),
(32, 'Engineering', 'Engineering ars', 'from_ntt', 'supplier', NULL),
(33, 'DIg a hole', '', 'from_outside_ntt', 'customer', NULL),
(34, 'internal', '', 'internal', 'customer', NULL),
(35, 'B', '', 'internal', 'customer', NULL),
(36, 'my dep', '', 'from_ntt', 'supplier', NULL),
(37, 'dep', '', 'from_ntt', 'supplier', ''),
(38, 'depdep', '', 'from_outside_ntt', 'customer', NULL),
(39, 'dep 01 encore', '', 'from_ntt', 'customer', NULL),
(40, 'Installation of the Pole', '', 'from_ntt', 'projDev', NULL),
(41, 'Instllation of smart Lampost', '', 'from_ntt', 'projDev', NULL),
(42, 'Upgrading of the LED lighting system', '', 'from_ntt', 'projDev', NULL),
(43, 'Electrical systems', '', 'from_ntt', 'projDev', NULL),
(44, 'Installation of the software', '', 'from_ntt', 'projDev', NULL),
(45, 'Control boxes implementation', '', 'from_ntt', 'projDev', NULL),
(46, 'Gateway implementation', '', 'from_ntt', 'projDev', NULL),
(47, 'Installation of the charging point', '', 'from_ntt', 'projDev', NULL),
(48, 'Installation of the wall connector', '', 'from_ntt', 'projDev', NULL),
(49, 'Installation of the panel', '', 'from_ntt', 'projDev', NULL),
(50, 'Installation of the battery &remote control', '', 'from_ntt', 'projDev', NULL),
(51, 'Installation of the battery &remote control', '', 'from_ntt', 'projDev', NULL),
(52, 'Installation of the CCTV system', '', 'from_ntt', 'projDev', NULL),
(53, 'Installation of the PTT', '', 'from_ntt', 'projDev', NULL),
(54, 'Installation of the public speakers', '', 'from_ntt', 'projDev', NULL),
(55, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL),
(56, 'Software installation', '', 'from_ntt', 'projDev', NULL),
(57, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL),
(58, 'Software installation', '', 'from_ntt', 'projDev', NULL),
(59, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL),
(60, 'Software installation', '', 'from_ntt', 'projDev', NULL),
(61, 'Installation of the banner', '', 'from_ntt', 'projDev', NULL),
(62, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL),
(63, 'Software installation', '', 'from_ntt', 'projDev', NULL),
(64, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL),
(65, 'Installation of the software', '', 'from_ntt', 'projDev', NULL),
(66, 'Installation of the local parking guidance system ', '', 'from_ntt', 'projDev', NULL),
(67, 'Installation of the antenna', '', 'from_ntt', 'projDev', NULL),
(68, 'Installation of the antenna', '', 'from_ntt', 'projDev', NULL),
(69, 'Installation of the antenna', '', 'from_ntt', 'projDev', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `implem_item_advice`
--

DROP TABLE IF EXISTS `implem_item_advice`;
CREATE TABLE IF NOT EXISTS `implem_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min` int(11) DEFAULT NULL,
  `range_max` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_item_advice`
--

INSERT INTO `implem_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`) VALUES
(1, 'per blabla', NULL, 50, 102),
(3, 'per truc', NULL, 10, 20),
(5, '', '', 13, 14),
(7, 'vfg', '', 2, 21),
(40, 'Per streetlight pole', 'https://www.ledsmaster.com/channel/How-Much-Do-Street-Lights-Cost-Replacing-and-Running-the-Street-Lamp--77.html', 1200, 2300),
(41, 'Per smart lamppost', 'Internal research', 26, 87),
(42, 'Per LED light', 'https://www.myledlightingguide.com/blog-the-cost-of-street-lights', 160, 240),
(43, 'Per cabling system', 'https://blog.lightinus.com/comparing-traditional-street-lights-and-solar-energy-lights', 38, 90),
(44, 'Per software', 'http://qulon.pro\n', 25, 85),
(45, 'Per sensor', 'https://www.homeadvisor.com/cost/electrical/upgrade-an-electrical-panel/', 80, 170),
(46, 'Per gateway', 'http://democracy.cityoflondon.gov.uk/documents/s63133/Street%20Lighting%20Review%20G3-4%20Report%20-%20Final.pdf', 7100, 22000),
(47, 'Per EVSE Charging point', 'https://www.ubitricity.co.uk/unternehmen/newsroom/simple-conversion-turn-street-lamps-electric-car-chargers-daily-mail/\n', 1000, 1600),
(48, 'Per connector', 'https://www.homeadvisor.com/cost/garages/install-an-electric-vehicle-charging-station/', 380, 440),
(49, 'Per PV panel', 'https://www.streetlights-solar.com/2018/07/19/cost-comparison-between-solar-vs-traditional-lights/\n', 600, 1200),
(50, 'Per battery & remote control', 'https://www.energysage.com/solar/solar-energy-storage/what-do-solar-batteries-cost/\n', 310, 570),
(51, 'Per battery & remote control', 'https://www.energysage.com/solar/solar-energy-storage/what-do-solar-batteries-cost/\n', 310, 570),
(52, 'Per CCTV system', 'https://www.fixr.com/costs/install-video-surveillance-cameras', 280, 400),
(53, 'Per PTT', 'http://www.groundcontrol.com/Iridium_PTT_Push-To-Talk.htm', 1700, 3900),
(54, 'Per Public speakers', 'https://porch.com/project-cost/cost-to-install-outdoor-speakers', 150, 280),
(55, 'Per sensor', 'https://www.london.gov.uk/what-we-do/environment/pollution-and-air-quality/monitoring-and-predicting-air-pollution\n', 310, 750),
(56, 'Per software', 'Internal research', 1000, 1120),
(57, 'Per sensor', 'Internal research', 155, 375),
(58, 'Per software', 'Internal research', 1000, 1120),
(59, 'Per sensor', 'https://reliabilityweb.com/articles/entry/wireless_sensors_work_provide_a_cost-effective_alternative_to_traditio', 500, 1500),
(60, 'Per software', 'Internal research', 1000, 1120),
(61, 'Per Advertising Panel', 'https://just-print.co.uk/155-lamp-post-advertising-boards-24-x-16-50-pack.html', 170, 200),
(62, 'Per traffic monitoring sensor', 'https://www.itscosts.its.dot.gov/ITS/benecost.nsf/ID/5A53F0D1919AA5EE8525798300819B6E?OpenDocument&Query=CApp', 260, 1300),
(63, 'Per software', 'https://www.researchgate.net/publication/280078500_Intelligent_Traffic_Monitoring_System', 640, 1900),
(64, 'Per sensor', 'https://www.itscosts.its.dot.gov/its/benecost.nsf/0/E4717C6F075BAAA38525789B00610ECC?OpenDocument&Query=Home', 310, 625),
(65, 'Per gateway', 'https://www.itscosts.its.dot.gov/ITS/benecost.nsf/ID/F1112FA098133F3C85256DB100458923?OpenDocument&Query=CApp', 210, 835),
(66, 'Per guidance system', 'Internal research', 64, 385),
(67, 'Per Wifi antenna', 'https://its.umich.edu/projects/wifi-upgrade/project-funding', 300, 380),
(68, 'Per antenna', 'https://www.repeaterstore.com/pages/custom-solutions', 400, 800),
(69, 'Per 5G antenna', 'https://www.ctia.org/news/what-is-a-small-cell', 400, 800);

-- --------------------------------------------------------

--
-- Structure de la table `implem_item_user`
--

DROP TABLE IF EXISTS `implem_item_user`;
CREATE TABLE IF NOT EXISTS `implem_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_item_user`
--

INSERT INTO `implem_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(3, 1),
(12, 3),
(16, 3),
(4, 4),
(6, 4),
(8, 4),
(9, 8),
(10, 8),
(11, 8),
(13, 8),
(14, 8),
(15, 8),
(17, 11),
(18, 21),
(19, 21),
(20, 21),
(21, 21),
(22, 21),
(23, 21),
(24, 21),
(25, 21),
(26, 21),
(27, 21),
(28, 21),
(29, 21),
(30, 21),
(31, 21),
(36, 21),
(37, 21),
(38, 21),
(39, 21),
(32, 23),
(33, 23),
(34, 23),
(35, 23);

-- --------------------------------------------------------

--
-- Structure de la table `implem_schedule`
--

DROP TABLE IF EXISTS `implem_schedule`;
CREATE TABLE IF NOT EXISTS `implem_schedule` (
  `id_uc` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `25_completion` date DEFAULT NULL,
  `50_completion` date DEFAULT NULL,
  `75_completion` date DEFAULT NULL,
  `100_completion` date DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_proj`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_schedule`
--

INSERT INTO `implem_schedule` (`id_uc`, `id_proj`, `start_date`, `25_completion`, `50_completion`, `75_completion`, `100_completion`) VALUES
(-1, 8, '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(1, 3, '2020-01-01', '2020-02-01', '2020-03-01', '2020-04-01', '2021-04-01'),
(1, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(1, 6, '2012-02-01', '2013-03-01', '2013-08-01', '2014-08-01', '2014-12-01'),
(1, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(2, 3, '2020-01-01', '2020-02-01', '2020-03-01', '2020-04-01', '2021-04-01'),
(2, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(2, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(3, 3, '2020-01-01', '2020-02-01', '2020-03-01', '2020-04-01', '2021-04-01'),
(3, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(3, 6, '2012-02-01', '2013-03-01', '2013-08-01', '2014-08-01', '2014-12-01'),
(3, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(5, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(5, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(7, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(7, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(9, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(9, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(10, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(10, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(11, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(11, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(15, 26, '2020-01-01', '2020-03-01', '2020-05-01', '2020-06-01', '2020-09-01'),
(15, 27, '2020-01-01', '2020-03-01', '2020-04-01', '2020-06-01', '2020-10-01'),
(16, 26, '2020-01-01', '2020-03-01', '2020-05-01', '2020-06-01', '2020-09-01'),
(16, 27, '2020-01-01', '2020-03-01', '2020-04-01', '2020-06-01', '2020-10-01');

-- --------------------------------------------------------

--
-- Structure de la table `implem_uc`
--

DROP TABLE IF EXISTS `implem_uc`;
CREATE TABLE IF NOT EXISTS `implem_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_uc`
--

INSERT INTO `implem_uc` (`id_item`, `id_uc`) VALUES
(16, -1),
(17, -1),
(19, -1),
(20, -1),
(21, -1),
(22, -1),
(23, -1),
(24, -1),
(25, -1),
(26, -1),
(32, -1),
(33, -1),
(34, -1),
(38, -1),
(39, -1),
(1, 1),
(3, 1),
(9, 1),
(10, 1),
(11, 1),
(14, 1),
(4, 2),
(12, 2),
(18, 2),
(6, 3),
(13, 3),
(35, 3),
(5, 5),
(7, 6),
(8, 7),
(15, 9),
(27, 9),
(28, 9),
(29, 9),
(30, 9),
(31, 9),
(36, 9),
(37, 11),
(40, 12),
(41, 13),
(42, 14),
(43, 14),
(44, 15),
(45, 15),
(46, 15),
(47, 16),
(48, 16),
(49, 17),
(50, 17),
(51, 18),
(52, 19),
(53, 20),
(54, 21),
(55, 22),
(56, 22),
(57, 23),
(58, 23),
(59, 24),
(60, 24),
(61, 25),
(62, 26),
(63, 26),
(64, 27),
(65, 27),
(66, 27),
(67, 28),
(68, 29),
(69, 30);

-- --------------------------------------------------------

--
-- Structure de la table `input_capex`
--

DROP TABLE IF EXISTS `input_capex`;
CREATE TABLE IF NOT EXISTS `input_capex` (
  `id_item` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_capex`
--

INSERT INTO `input_capex` (`id_item`, `id_proj`, `id_uc`, `volume`, `unit_cost`, `period`) VALUES
(1, 1, 1, 0, 0, 3),
(2, 1, 2, NULL, NULL, NULL),
(2, 3, 2, 0, 0, 1),
(2, 4, 2, 19, 50, 1),
(2, 8, 2, 12, 150, 5),
(3, 1, 2, NULL, NULL, NULL),
(3, 4, 2, 543, 50, 1),
(3, 6, 1, 1000, 500, 1),
(3, 8, 1, 237, 200, 3),
(3, 8, 2, 1000, 50, 3),
(4, 1, 1, 0, 0, 4),
(4, 3, 1, 0, 0, 1),
(4, 4, 1, 357156, 7.5, 5),
(4, 6, 1, 200, 20, 1),
(4, 8, 1, 132, 5500, 5),
(5, 1, 1, 0, 0, 5),
(5, 4, 1, 6614, 53.5, 5),
(5, 8, 1, 660, 2500, 2),
(12, 4, 3, 43, 28.5, 5),
(15, 4, 7, 1568, 54, 54),
(17, 6, 3, NULL, NULL, NULL),
(18, 8, 1, 400, 1500, 5),
(19, 8, 1, 197, 100, 2),
(21, 8, 1, 5, 1500, 3),
(22, 8, 1, 200, 50, 1),
(25, 3, 3, 0, 0, 1),
(26, 8, 11, 100, 10, 3),
(27, 8, 11, 300, 10, 3),
(28, 8, 5, 275, 5, 1),
(30, 4, -1, 1500, 15, 3),
(31, 3, -1, 0, 0, 1),
(32, 11, -1, 1255, 15, 1),
(33, 21, 7, NULL, NULL, NULL),
(34, 21, -1, 10, 10, 1),
(37, 21, -1, 10, 15, 5),
(38, 21, -1, 5, 10, 3),
(39, 23, -1, 10, 200, 10),
(40, 23, 3, 10, 100, 5),
(41, 21, 9, NULL, NULL, NULL),
(42, 4, 11, NULL, NULL, NULL),
(43, 21, -1, NULL, NULL, NULL),
(44, 21, -1, NULL, NULL, NULL),
(45, 24, -1, 0, 0, 5),
(46, 21, 11, 0, 0, 1),
(47, 27, 16, 1, 12500, 3);

-- --------------------------------------------------------

--
-- Structure de la table `input_cashreleasing`
--

DROP TABLE IF EXISTS `input_cashreleasing`;
CREATE TABLE IF NOT EXISTS `input_cashreleasing` (
  `id_item` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `unit_indicator` varchar(255) DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  `ratio` int(11) DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `volume_reduc` double DEFAULT NULL,
  `unit_cost_reduc` double DEFAULT NULL,
  `annual_var_volume` double DEFAULT NULL,
  `annual_var_unit_cost` double DEFAULT NULL,
  `revenue_start_date` date NOT NULL,
  `ramp_up_duration` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_cashreleasing`
--

INSERT INTO `input_cashreleasing` (`id_item`, `id_proj`, `id_uc`, `unit_indicator`, `volume`, `ratio`, `unit_cost`, `volume_reduc`, `unit_cost_reduc`, `annual_var_volume`, `annual_var_unit_cost`, `revenue_start_date`, `ramp_up_duration`) VALUES
(1, 1, 1, 'per example', 0, NULL, 0, 0, 0, 0, 0, '0000-00-00', 0),
(1, 4, 1, 'per example', 864, 54, 0, 0, 0, 0, 0, '0000-00-00', 0),
(1, 6, 1, 'per example', 20, NULL, 58, 2, 5, 2, 2, '0000-00-00', 0),
(1, 8, 1, 'per example', 1500, NULL, 500, 5, 0, 5, 5, '0000-00-00', 0),
(2, 6, 1, 'per example', 30, NULL, 4, 4, 2, 5, 5, '0000-00-00', 0),
(2, 8, 1, 'per example', 5, NULL, 12000, 10, 10, 5, 5, '0000-00-00', 0),
(3, 1, 1, 'per example', 0, NULL, 0, 0, 0, 0, 0, '0000-00-00', 0),
(3, 4, 1, 'per example', 4544, 284, 0, 0, 0, 0, 0, '0000-00-00', 0),
(3, 6, 1, 'per example', 10, NULL, 10, 1, 4, 5, 5, '0000-00-00', 0),
(3, 8, 1, 'per example', 10, NULL, 10, 5, 6, 5, 5, '0000-00-00', 0),
(4, 4, 2, 'EUIHV', 54, NULL, 5, 54, 5, 5, 5, '0000-00-00', 0),
(5, 4, 3, 'VUIG', 66, NULL, 12, 5, 19, 89, 78, '0000-00-00', 0),
(7, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(8, 8, 11, 'SI', 12, NULL, 100, 3, 5, 5, 3, '0000-00-00', 0),
(9, 8, 11, 'SI', 50, NULL, 200, 0, 10, 5, 1, '0000-00-00', 0),
(10, 8, 11, 'SI', 20, NULL, 1500, 30, 13, 5, 5, '0000-00-00', 0),
(11, 8, 11, 'SI', 5, NULL, 31, 3, 1, 5, 3, '0000-00-00', 0),
(12, 21, 9, 'test', 1500, NULL, 15, 3, 5, 5, 1, '0000-00-00', 0),
(13, 23, 3, 'parking space', 5000, NULL, 100, 5, 0, 0, 0, '0000-00-00', 0),
(14, 21, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(15, 27, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `input_implem`
--

DROP TABLE IF EXISTS `input_implem`;
CREATE TABLE IF NOT EXISTS `input_implem` (
  `id_proj` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  PRIMARY KEY (`id_proj`,`id_item`,`id_uc`),
  KEY `id_item` (`id_item`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_implem`
--

INSERT INTO `input_implem` (`id_proj`, `id_item`, `id_uc`, `volume`, `unit_cost`) VALUES
(1, 1, 1, 0, 0),
(1, 3, 1, 0, 0),
(3, 12, 2, 2, 0),
(4, 1, 1, 80, 76),
(4, 3, 1, 64, 15),
(4, 4, 2, 1900, 1),
(4, 6, 3, 621, 2),
(4, 8, 7, 43545, 5),
(6, 1, 1, 200, 500),
(8, 1, 1, 396, 100),
(8, 3, 1, 132, 1200),
(8, 5, 5, 20, 15),
(8, 11, 1, 36, 26),
(8, 13, 3, 1, 150000),
(8, 14, 1, 36, 150),
(8, 15, 9, 13, 5000),
(11, 17, -1, 200, 15),
(21, 26, -1, 100, 15),
(21, 36, 9, NULL, NULL),
(21, 37, 11, 0, 0),
(21, 39, -1, NULL, NULL),
(23, 32, -1, 10, 200),
(23, 33, -1, 10, 1000),
(23, 34, -1, 10, 100),
(23, 35, 3, 300, 20);

-- --------------------------------------------------------

--
-- Structure de la table `input_noncash`
--

DROP TABLE IF EXISTS `input_noncash`;
CREATE TABLE IF NOT EXISTS `input_noncash` (
  `id_item` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `expected_impact` int(11) DEFAULT NULL,
  `probability` double DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_noncash`
--

INSERT INTO `input_noncash` (`id_item`, `id_proj`, `id_uc`, `expected_impact`, `probability`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 10, 100),
(3, 4, 1, 10, 25),
(4, 4, 3, 9, 70),
(5, 4, 2, 7, 50),
(9, 8, 1, 7, 20),
(10, 6, 1, 5, 10),
(11, 8, 11, 2, 60),
(12, 8, 11, 1, 10),
(13, 8, 11, 7, 50),
(14, 21, -1, 9, 30),
(15, 21, -1, 5, 70),
(16, 21, 7, 4, 50),
(17, 23, 3, 5, 100),
(18, 21, 9, NULL, NULL),
(19, 21, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `input_opex`
--

DROP TABLE IF EXISTS `input_opex`;
CREATE TABLE IF NOT EXISTS `input_opex` (
  `id_proj` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `ratio` int(11) DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `annual_variation_volume` double DEFAULT NULL,
  `annual_variation_unitcost` double DEFAULT NULL,
  PRIMARY KEY (`id_proj`,`id_item`,`id_uc`),
  KEY `id_item` (`id_item`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_opex`
--

INSERT INTO `input_opex` (`id_proj`, `id_item`, `id_uc`, `volume`, `ratio`, `unit_cost`, `annual_variation_volume`, `annual_variation_unitcost`) VALUES
(1, 1, 1, 0, NULL, 0, 0, 0),
(1, 2, 1, 1000, NULL, 9.965, 10, 6),
(3, 3, 2, 0, NULL, 0, 0, 0),
(3, 5, 2, 0, NULL, 0, 0, 0),
(4, 1, 1, 21, 1, 6.5, 0, 0),
(4, 2, 1, 67, 4, 2.5, 0, 0),
(4, 3, 2, 4, NULL, 5, 65, 5),
(4, 4, 3, 56, NULL, 78, 6, 6),
(4, 5, 2, 54, NULL, 5, 0, 0),
(6, 2, 1, 300, NULL, 152, 10, 5),
(8, 1, 1, 264, NULL, 25, 20, 2),
(8, 2, 1, 132, NULL, 1050, 3, 10),
(8, 3, 2, 12, NULL, 200, 3, 5),
(8, 4, 3, 300, NULL, 50, 3, 5),
(8, 5, 2, 30, NULL, 50, 1, 4),
(8, 6, 1, 1000, NULL, 15, 3, 1),
(8, 8, -1, 1, NULL, 15000, 3, 0),
(10, 7, -1, 1, NULL, 15000, 3, 0),
(11, 10, -1, 250, NULL, 15, 15, 3),
(21, 11, -1, 200, NULL, 15, 3, 5),
(21, 13, -1, 100, NULL, 15, 5, 3),
(21, 18, 9, 30, NULL, 15, 3, -5),
(21, 19, 11, NULL, NULL, NULL, NULL, NULL),
(21, 20, -1, NULL, NULL, NULL, NULL, NULL),
(23, 14, -1, 1, NULL, 3000, 5, 0),
(23, 15, -1, 3, NULL, 100, 5, 0),
(23, 16, -1, 50, NULL, 50, 5, 5),
(23, 17, 3, 40, NULL, 100, 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `input_quantifiable`
--

DROP TABLE IF EXISTS `input_quantifiable`;
CREATE TABLE IF NOT EXISTS `input_quantifiable` (
  `id_item` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `unit_indicator` varchar(255) DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  `volume_reduc` double DEFAULT NULL,
  `annual_var_volume` double DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_quantifiable`
--

INSERT INTO `input_quantifiable` (`id_item`, `id_proj`, `id_uc`, `unit_indicator`, `volume`, `volume_reduc`, `annual_var_volume`) VALUES
(1, 4, 7, 'per test', 43, 43, 54),
(1, 21, -1, 'myUnit2', 300, 5, 21),
(4, 21, -1, 'myUnit', 250, 15, 17),
(4, 21, 7, 'per unit', 20, 12, 5),
(5, 8, 1, NULL, NULL, NULL, NULL),
(6, 8, 1, 'personne', 750, 10, 5),
(7, 8, 11, 'nb', 15000, 15, 10),
(8, 3, 3, NULL, NULL, NULL, NULL),
(10, 23, 3, 'accident', 10, 30, 5),
(11, 21, 9, NULL, NULL, NULL, NULL),
(12, 21, 11, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `input_revenues`
--

DROP TABLE IF EXISTS `input_revenues`;
CREATE TABLE IF NOT EXISTS `input_revenues` (
  `id_proj` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `ratio` int(11) DEFAULT NULL,
  `revenues_per_unit` double DEFAULT NULL,
  `annual_variation_volume` double DEFAULT NULL,
  `annual_variation_unitcost` double DEFAULT NULL,
  `revenue_start_date` date NOT NULL,
  `ramp_up_duration` int(11) NOT NULL,
  PRIMARY KEY (`id_proj`,`id_item`,`id_uc`),
  KEY `id_item` (`id_item`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_revenues`
--

INSERT INTO `input_revenues` (`id_proj`, `id_item`, `id_uc`, `volume`, `ratio`, `revenues_per_unit`, `annual_variation_volume`, `annual_variation_unitcost`, `revenue_start_date`, `ramp_up_duration`) VALUES
(1, 1, 1, 5, NULL, 2, 0, 0, '0000-00-00', 0),
(4, 1, 1, 16, 1, 0, 0, 0, '0000-00-00', 0),
(4, 3, 2, 453, NULL, 54, 54, 5, '0000-00-00', 0),
(4, 4, 3, 78, NULL, 2, 45, 12, '0000-00-00', 0),
(4, 6, 2, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(4, 13, 11, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(8, 1, 1, 5, NULL, 5, 5, 6, '0000-00-00', 0),
(8, 2, 1, 50, NULL, 1500, 3, 1, '0000-00-00', 0),
(8, 8, 11, 35, NULL, 255, 0, 2, '0000-00-00', 0),
(8, 9, 11, 50, NULL, 15000, 1, 3, '0000-00-00', 0),
(8, 10, 11, 100, NULL, 300, 2, 1, '0000-00-00', 0),
(8, 11, 11, 33, NULL, 20, 5, 3, '0000-00-00', 0),
(21, 12, -1, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(21, 12, 9, 15, NULL, 300, 3, 5, '2020-09-30', 2),
(21, 15, 11, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(23, 14, 3, 100, NULL, 30, 5, 5, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `input_risk`
--

DROP TABLE IF EXISTS `input_risk`;
CREATE TABLE IF NOT EXISTS `input_risk` (
  `id_item` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `expected_impact` int(11) DEFAULT NULL,
  `probability` double DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_risk`
--

INSERT INTO `input_risk` (`id_item`, `id_proj`, `id_uc`, `expected_impact`, `probability`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 1, NULL, NULL),
(3, 4, 1, 10, 23),
(4, 4, 3, 7, 80),
(5, 4, 2, 7, 80),
(6, 8, 1, 9, 10),
(7, 6, 1, 3, 50),
(8, 8, 11, 2, 10),
(9, 8, 11, 5, 10),
(10, 8, 11, 7, 40),
(11, 23, 3, 9, 20),
(12, 21, 9, NULL, NULL),
(13, 21, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `input_supplier_revenues`
--

DROP TABLE IF EXISTS `input_supplier_revenues`;
CREATE TABLE IF NOT EXISTS `input_supplier_revenues` (
  `id_item` int(10) UNSIGNED NOT NULL,
  `id_proj` int(10) UNSIGNED NOT NULL,
  `id_uc` int(10) NOT NULL,
  `unit_cost` float NOT NULL,
  `volume` int(11) NOT NULL,
  `margin` float NOT NULL,
  `anVarVol` int(11) NOT NULL,
  `anVarCost` int(11) NOT NULL,
  `revenue_start_date` date NOT NULL,
  `ramp_up_duration` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_supplier_revenues`
--

INSERT INTO `input_supplier_revenues` (`id_item`, `id_proj`, `id_uc`, `unit_cost`, `volume`, `margin`, `anVarVol`, `anVarCost`, `revenue_start_date`, `ramp_up_duration`) VALUES
(1, 21, 9, 0, 0, 0, 0, 0, '2021-12-09', 3),
(2, 21, 9, 1500, 50, 50, 0, 0, '0000-00-00', 0),
(3, 21, 9, 15, 0, 10, 5, 3, '0000-00-00', 0),
(4, 21, 7, 1500, 300, 15, 0, 0, '0000-00-00', 0),
(5, 23, 3, 100, 100, 10, 0, 0, '0000-00-00', 0),
(6, 23, 3, 150, 10, 10, 0, 0, '0000-00-00', 0),
(7, 23, 3, 3500, 1, 10, 0, 5, '0000-00-00', 0),
(8, 21, 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(9, 21, -1, 5, 10, 0, 0, 0, '0000-00-00', 0),
(9, 21, 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(10, 21, -1, 10, 5, 0, 1, 2, '0000-00-00', 0),
(10, 21, 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(11, 21, 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(12, 21, 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(13, 21, -1, 200, 300, 0, 0, 0, '2020-10-16', 1),
(14, 21, -1, 0, 0, 0, 0, 0, '2020-10-14', 1),
(15, 24, 9, 0, 0, 0, 0, 0, '0000-00-00', 0),
(16, 24, -1, 10, 200, 0, 0, 0, '0000-00-00', 0),
(17, 24, -1, 20, 20, 0, 0, 0, '0000-00-00', 0),
(18, 24, -1, 30, 10, 0, 0, 0, '0000-00-00', 0),
(19, 21, 11, 0, 0, 0, 0, 0, '0000-00-00', 0),
(20, 21, 11, 0, 0, 0, 0, 0, '0000-00-00', 0),
(21, 21, 11, 0, 0, 0, 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `input_widercash`
--

DROP TABLE IF EXISTS `input_widercash`;
CREATE TABLE IF NOT EXISTS `input_widercash` (
  `id_item` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `unit_indicator` varchar(255) DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  `ratio` int(11) DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `volume_reduc` double DEFAULT NULL,
  `unit_cost_reduc` double DEFAULT NULL,
  `annual_var_volume` double DEFAULT NULL,
  `annual_var_unit_cost` double DEFAULT NULL,
  `revenue_start_date` date NOT NULL,
  `ramp_up_duration` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_widercash`
--

INSERT INTO `input_widercash` (`id_item`, `id_proj`, `id_uc`, `unit_indicator`, `volume`, `ratio`, `unit_cost`, `volume_reduc`, `unit_cost_reduc`, `annual_var_volume`, `annual_var_unit_cost`, `revenue_start_date`, `ramp_up_duration`) VALUES
(1, 1, 1, 'per blabla', 0, NULL, 0, 0, 0, 0, 0, '0000-00-00', 0),
(1, 4, 1, 'per example', 578, 36, 0, 0, 0, 0, 0, '0000-00-00', 0),
(1, 6, 1, 'per example', 10, NULL, 20, 4, 5, 40, 2, '0000-00-00', 0),
(1, 8, 1, 'per example', 5, NULL, 10, 1, 2, 4, 4, '0000-00-00', 0),
(2, 1, 1, 'per oiuhrf', 0, NULL, 0, 0, 0, 0, 0, '0000-00-00', 0),
(2, 4, 1, 'per example', 13, 1, 0, 0, 0, 0, 0, '0000-00-00', 0),
(2, 8, 1, 'per example', 500, NULL, 2, 2, 2, 7, 5, '0000-00-00', 0),
(3, 4, 3, 'per unit', 54, NULL, 43, 4, 32, 4, 4, '0000-00-00', 0),
(4, 4, 2, 'FTR', 54, NULL, 32, 35, 7, 65, 56, '0000-00-00', 0),
(5, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(6, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(8, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0),
(9, 8, 11, 'SI', 50, NULL, 12, 1, 2, 2, 1, '0000-00-00', 0),
(10, 8, 11, 'SI', 1200, NULL, 15, 50, 30, 4, 5, '0000-00-00', 0),
(11, 8, 11, 'SI', 15, NULL, 200, 10, 50, 0, 2, '0000-00-00', 0),
(12, 21, 9, 'test', 15, NULL, 10000, 5, 30, 6, 10, '0000-00-00', 0),
(14, 23, 3, 'CO2', 1000, NULL, 1, 30, 0, 0, 0, '0000-00-00', 0),
(15, 21, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `invest_capacity`
--

DROP TABLE IF EXISTS `invest_capacity`;
CREATE TABLE IF NOT EXISTS `invest_capacity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `invest_capacity`
--

INSERT INTO `invest_capacity` (`id`, `name`, `description`) VALUES
(1, '< = 2 M', 'small value'),
(2, '2 - 5 M', 'low-mid value'),
(3, '5 - 20 M', 'mid value'),
(4, '> = 20', 'large value');

-- --------------------------------------------------------

--
-- Structure de la table `loans_and_bonds`
--

DROP TABLE IF EXISTS `loans_and_bonds`;
CREATE TABLE IF NOT EXISTS `loans_and_bonds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maturity_date` date DEFAULT NULL,
  `interest` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `loans_and_bonds`
--

INSERT INTO `loans_and_bonds` (`id`, `maturity_date`, `interest`) VALUES
(1, NULL, NULL),
(2, NULL, NULL),
(3, '2020-01-01', 3);

-- --------------------------------------------------------

--
-- Structure de la table `magnitude`
--

DROP TABLE IF EXISTS `magnitude`;
CREATE TABLE IF NOT EXISTS `magnitude` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `range_min` double DEFAULT NULL,
  `range_max` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `magnitude`
--

INSERT INTO `magnitude` (`id`, `name`, `range_min`, `range_max`) VALUES
(2, 'Proof Of Concept', 1, 5),
(3, 'Limited Perimeter', 5, 25);

-- --------------------------------------------------------

--
-- Structure de la table `matrix_bm_1`
--

DROP TABLE IF EXISTS `matrix_bm_1`;
CREATE TABLE IF NOT EXISTS `matrix_bm_1` (
  `id_investcap` int(11) NOT NULL,
  `id_payconst` int(11) NOT NULL,
  `id_bmpref` int(11) NOT NULL,
  `in_house` int(11) NOT NULL,
  `PPP` int(11) NOT NULL,
  `outsourced` int(11) NOT NULL,
  PRIMARY KEY (`id_investcap`,`id_payconst`,`id_bmpref`),
  KEY `id_payconst` (`id_payconst`),
  KEY `id_bmpref` (`id_bmpref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `matrix_bm_1`
--

INSERT INTO `matrix_bm_1` (`id_investcap`, `id_payconst`, `id_bmpref`, `in_house`, `PPP`, `outsourced`) VALUES
(1, 1, 1, 1, 3, 2),
(1, 1, 2, 1, 3, 2),
(1, 1, 3, 1, 3, 2),
(1, 1, 4, 1, 3, 2),
(1, 2, 1, 1, 3, 2),
(1, 2, 2, 1, 3, 2),
(1, 2, 3, 1, 3, 2),
(1, 2, 4, 1, 3, 2),
(1, 3, 1, 1, 3, 2),
(1, 3, 2, 1, 3, 2),
(1, 3, 3, 1, 3, 2),
(1, 3, 4, 1, 3, 2),
(1, 4, 1, 1, 3, 2),
(1, 4, 2, 1, 3, 2),
(1, 4, 3, 1, 3, 2),
(1, 4, 4, 1, 3, 2),
(2, 1, 1, 1, 3, 2),
(2, 1, 2, 2, 3, 1),
(2, 1, 3, 2, 3, 1),
(2, 1, 4, 2, 3, 1),
(2, 2, 1, 1, 3, 2),
(2, 2, 2, 2, 3, 1),
(2, 2, 3, 2, 3, 1),
(2, 2, 4, 2, 3, 1),
(2, 3, 1, 1, 3, 2),
(2, 3, 2, 2, 3, 1),
(2, 3, 3, 2, 3, 1),
(2, 3, 4, 2, 3, 1),
(2, 4, 1, 1, 3, 2),
(2, 4, 2, 2, 3, 1),
(2, 4, 3, 2, 3, 1),
(2, 4, 4, 2, 3, 1),
(3, 1, 1, 1, 3, 2),
(3, 1, 2, 2, 3, 1),
(3, 1, 3, 2, 3, 1),
(3, 1, 4, 2, 3, 1),
(3, 2, 1, 1, 3, 2),
(3, 2, 2, 2, 3, 1),
(3, 2, 3, 2, 3, 1),
(3, 2, 4, 2, 3, 1),
(3, 3, 1, 1, 3, 2),
(3, 3, 2, 2, 3, 1),
(3, 3, 3, 2, 3, 1),
(3, 3, 4, 2, 3, 1),
(3, 4, 1, 1, 3, 2),
(3, 4, 2, 2, 3, 1),
(3, 4, 3, 2, 3, 1),
(3, 4, 4, 2, 3, 1),
(4, 1, 1, 1, 2, 3),
(4, 1, 2, 3, 1, 2),
(4, 1, 3, 3, 2, 1),
(4, 1, 4, 3, 2, 1),
(4, 2, 1, 1, 2, 3),
(4, 2, 2, 3, 1, 2),
(4, 2, 3, 3, 2, 1),
(4, 2, 4, 3, 2, 1),
(4, 3, 1, 1, 2, 3),
(4, 3, 2, 3, 1, 2),
(4, 3, 3, 3, 2, 1),
(4, 3, 4, 3, 2, 1),
(4, 4, 1, 1, 3, 2),
(4, 4, 2, 1, 3, 2),
(4, 4, 3, 1, 3, 2),
(4, 4, 4, 1, 3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `matrix_bm_2`
--

DROP TABLE IF EXISTS `matrix_bm_2`;
CREATE TABLE IF NOT EXISTS `matrix_bm_2` (
  `id_bm` int(11) NOT NULL,
  `id_investcap` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `id_socbank` int(11) NOT NULL,
  `city` int(11) DEFAULT NULL,
  `grants` int(11) DEFAULT NULL,
  `eq_investors` int(11) DEFAULT NULL,
  `impact_investors` int(11) DEFAULT NULL,
  `bank_debt` int(11) DEFAULT NULL,
  `green_debt` int(11) DEFAULT NULL,
  `suppliers` int(11) DEFAULT NULL,
  `alternative` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bm`,`id_investcap`,`id_bank`,`id_socbank`),
  KEY `id_investcap` (`id_investcap`),
  KEY `id_bank` (`id_bank`),
  KEY `id_socbank` (`id_socbank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `matrix_bm_2`
--

INSERT INTO `matrix_bm_2` (`id_bm`, `id_investcap`, `id_bank`, `id_socbank`, `city`, `grants`, `eq_investors`, `impact_investors`, `bank_debt`, `green_debt`, `suppliers`, `alternative`) VALUES
(1, 1, 1, 1, 4, 1, 0, 0, 0, 0, 0, 0),
(1, 1, 1, 2, 4, 1, 0, 0, 0, 0, 0, 0),
(1, 1, 1, 3, 2, 2, 0, 0, 0, 1, 0, 2),
(1, 1, 2, 1, 4, 0, 0, 0, 2, 2, 0, 0),
(1, 1, 2, 2, 2, 1, 0, 0, 2, 2, 0, 0),
(1, 1, 2, 3, 2, 2, 0, 0, 2, 2, 0, 2),
(1, 1, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(1, 1, 3, 2, 1, 1, 0, 0, 4, 4, 0, 0),
(1, 1, 3, 3, 1, 1, 0, 0, 4, 4, 0, 2),
(1, 2, 1, 1, 4, 1, 0, 0, 0, 0, 0, 0),
(1, 2, 1, 2, 4, 1, 0, 0, 0, 0, 0, 0),
(1, 2, 1, 3, 2, 2, 0, 0, 0, 1, 0, 1),
(1, 2, 2, 1, 4, 0, 0, 0, 2, 2, 0, 0),
(1, 2, 2, 2, 2, 1, 0, 0, 2, 2, 0, 0),
(1, 2, 2, 3, 2, 2, 0, 0, 2, 2, 0, 1),
(1, 2, 3, 1, 1, 1, 0, 0, 4, 4, 0, 0),
(1, 2, 3, 2, 1, 1, 0, 0, 4, 4, 0, 0),
(1, 2, 3, 3, 1, 1, 0, 0, 4, 4, 0, 1),
(1, 3, 1, 1, 4, 1, 0, 0, 0, 0, 0, 0),
(1, 3, 1, 2, 4, 1, 0, 0, 0, 0, 0, 0),
(1, 3, 1, 3, 2, 2, 0, 1, 0, 1, 0, 1),
(1, 3, 2, 1, 4, 0, 0, 0, 2, 2, 0, 0),
(1, 3, 2, 2, 2, 1, 0, 0, 2, 2, 0, 0),
(1, 3, 2, 3, 2, 2, 0, 1, 2, 2, 0, 1),
(1, 3, 3, 1, 1, 1, 1, 0, 4, 4, 0, 0),
(1, 3, 3, 2, 1, 1, 1, 0, 4, 4, 0, 0),
(1, 3, 3, 3, 1, 1, 1, 1, 4, 4, 0, 1),
(1, 4, 1, 1, 4, 1, 0, 0, 0, 0, 0, 0),
(1, 4, 1, 2, 4, 1, 0, 0, 0, 0, 0, 0),
(1, 4, 1, 3, 4, 1, 0, 1, 0, 1, 0, 0),
(1, 4, 2, 1, 4, 0, 0, 0, 2, 2, 0, 0),
(1, 4, 2, 2, 2, 1, 0, 0, 2, 2, 0, 0),
(1, 4, 2, 3, 2, 1, 0, 1, 2, 2, 0, 0),
(1, 4, 3, 1, 1, 1, 1, 0, 4, 4, 0, 0),
(1, 4, 3, 2, 1, 1, 1, 0, 4, 4, 0, 0),
(1, 4, 3, 3, 1, 1, 1, 1, 4, 4, 0, 0),
(2, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 3, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 4, 1, 1, 3, 0, 2, 2, 0, 0, 0, 0),
(2, 4, 1, 2, 3, 0, 2, 2, 0, 0, 0, 0),
(2, 4, 1, 3, 3, 0, 2, 2, 0, 1, 0, 0),
(2, 4, 2, 1, 2, 0, 2, 2, 2, 2, 0, 0),
(2, 4, 2, 2, 2, 0, 2, 2, 2, 2, 0, 0),
(2, 4, 2, 3, 2, 0, 2, 2, 2, 2, 0, 0),
(2, 4, 3, 1, 1, 0, 1, 1, 4, 4, 0, 0),
(2, 4, 3, 2, 1, 0, 1, 1, 4, 4, 0, 0),
(2, 4, 3, 3, 1, 0, 1, 1, 4, 4, 0, 0),
(3, 1, 1, 1, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 1, 1, 2, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 1, 1, 3, 0, 0, 0, 0, 0, 0, 4, 1),
(3, 1, 2, 1, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 1, 2, 2, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 1, 2, 3, 0, 0, 0, 0, 0, 0, 4, 2),
(3, 1, 3, 1, 0, 0, 0, 0, 1, 1, 4, 0),
(3, 1, 3, 2, 0, 0, 0, 0, 1, 1, 4, 0),
(3, 1, 3, 3, 0, 0, 0, 0, 1, 1, 4, 2),
(3, 2, 1, 1, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 2, 1, 2, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 2, 1, 3, 0, 0, 0, 0, 0, 0, 4, 1),
(3, 2, 2, 1, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 2, 2, 2, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 2, 2, 3, 0, 0, 0, 0, 0, 0, 4, 1),
(3, 2, 3, 1, 0, 0, 0, 0, 1, 1, 4, 0),
(3, 2, 3, 2, 0, 0, 0, 0, 1, 1, 4, 0),
(3, 2, 3, 3, 0, 0, 0, 0, 1, 1, 4, 1),
(3, 3, 1, 1, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 3, 1, 2, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 3, 1, 3, 0, 0, 0, 0, 0, 0, 4, 1),
(3, 3, 2, 1, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 3, 2, 2, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 3, 2, 3, 0, 0, 0, 0, 0, 0, 4, 1),
(3, 3, 3, 1, 0, 0, 0, 0, 1, 1, 4, 0),
(3, 3, 3, 2, 0, 0, 0, 0, 1, 1, 4, 0),
(3, 3, 3, 3, 0, 0, 0, 0, 1, 1, 4, 1),
(3, 4, 1, 1, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 4, 1, 2, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 4, 1, 3, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 4, 2, 1, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 4, 2, 2, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 4, 2, 3, 0, 0, 0, 0, 0, 0, 4, 0),
(3, 4, 3, 1, 0, 0, 0, 0, 1, 1, 4, 0),
(3, 4, 3, 2, 0, 0, 0, 0, 1, 1, 4, 0),
(3, 4, 3, 3, 0, 0, 0, 0, 1, 1, 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `measure`
--

DROP TABLE IF EXISTS `measure`;
CREATE TABLE IF NOT EXISTS `measure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `user` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `measure`
--

INSERT INTO `measure` (`id`, `name`, `description`, `user`) VALUES
(0, 'Project Overlay', NULL, 0),
(21, 'Smart Lighting', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `noncash_item`
--

DROP TABLE IF EXISTS `noncash_item`;
CREATE TABLE IF NOT EXISTS `noncash_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `sources` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `noncash_item`
--

INSERT INTO `noncash_item` (`id`, `name`, `description`, `sources`) VALUES
(1, 'non cash benefits 1', '', NULL),
(2, 'non cash benefits 2', '', NULL),
(3, 'custom item ncb 1', '', NULL),
(4, 'non cash', '', NULL),
(5, 'NNCASH', '', NULL),
(6, 'hivordfkjn', 'bgfkjbxn', NULL),
(7, 'bvuid', 'vfdx', NULL),
(8, 'testestest', 'vfd', NULL),
(9, 'Bonheur', '', NULL),
(10, 'non cash item', '', NULL),
(11, 'NCB 1', '', NULL),
(12, 'NCB 2', '', NULL),
(13, 'NCB 3', '', NULL),
(14, 'nan cash item 0', '', NULL),
(15, 'nan cash item 1', '', NULL),
(16, 'non cash', '', NULL),
(17, 'wellbeing', '', NULL),
(18, 'ncb', '', NULL),
(19, 'nc', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `noncash_item_advice`
--

DROP TABLE IF EXISTS `noncash_item_advice`;
CREATE TABLE IF NOT EXISTS `noncash_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `noncash_item_user`
--

DROP TABLE IF EXISTS `noncash_item_user`;
CREATE TABLE IF NOT EXISTS `noncash_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `noncash_item_user`
--

INSERT INTO `noncash_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 4),
(4, 4),
(5, 4),
(10, 6),
(9, 8),
(11, 8),
(12, 8),
(13, 8),
(14, 21),
(15, 21),
(16, 21),
(18, 21),
(19, 21),
(17, 23);

-- --------------------------------------------------------

--
-- Structure de la table `noncash_uc`
--

DROP TABLE IF EXISTS `noncash_uc`;
CREATE TABLE IF NOT EXISTS `noncash_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `noncash_uc`
--

INSERT INTO `noncash_uc` (`id_item`, `id_uc`) VALUES
(14, -1),
(15, -1),
(1, 1),
(2, 1),
(3, 1),
(9, 1),
(10, 1),
(5, 2),
(4, 3),
(8, 3),
(17, 3),
(6, 5),
(7, 5),
(16, 7),
(18, 9),
(11, 11),
(12, 11),
(13, 11),
(19, 11);

-- --------------------------------------------------------

--
-- Structure de la table `opex_item`
--

DROP TABLE IF EXISTS `opex_item`;
CREATE TABLE IF NOT EXISTS `opex_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `origine` enum('from_ntt','from_outside_ntt','internal') NOT NULL DEFAULT 'from_ntt',
  `side` enum('customer','supplier','projDev') NOT NULL DEFAULT 'projDev',
  `unit` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_item`
--

INSERT INTO `opex_item` (`id`, `name`, `description`, `origine`, `side`, `unit`) VALUES
(1, 'opexitem1', '', 'from_ntt', 'projDev', NULL),
(2, 'opex item 2', '', 'from_ntt', 'projDev', NULL),
(3, 'uc2 opex', '', 'from_ntt', 'projDev', NULL),
(4, 'TEST OPEX ITEM', '10H 10 MARS', 'from_ntt', 'projDev', NULL),
(5, 'OPEX', '', 'from_ntt', 'projDev', NULL),
(6, 'electricity', '', 'internal', 'projDev', NULL),
(7, 'Project Manager', '', 'from_ntt', 'projDev', NULL),
(8, 'Project Manager', '', 'from_ntt', 'projDev', NULL),
(9, 'Opex 1', '', 'internal', 'projDev', NULL),
(10, 'Opex common test', '', 'from_ntt', 'projDev', NULL),
(11, 'opex common', '', 'from_ntt', 'projDev', NULL),
(12, 'opex test', '', 'from_ntt', 'projDev', NULL),
(13, 'opex 01', '', 'from_ntt', 'supplier', ''),
(14, 'Data analytics', 'Analysis of traffic', 'from_ntt', 'supplier', NULL),
(15, 'Support services', 'Maintenace of equipment', 'from_outside_ntt', 'supplier', NULL),
(16, 'Maintenace', '', 'internal', 'customer', NULL),
(17, 'C', '', 'from_ntt', 'customer', NULL),
(18, 'op', '', 'from_ntt', 'supplier', 'test'),
(19, 'opex', '', 'from_ntt', 'supplier', NULL),
(20, 'opexopex', '', 'from_ntt', 'customer', NULL),
(21, 'Maintenance of the pole', '', 'from_ntt', 'projDev', NULL),
(22, 'Maintenance of smart lamppost', '', 'from_ntt', 'projDev', NULL),
(23, 'Maintenance of LED Bulb and electric system', '', 'from_ntt', 'projDev', NULL),
(24, 'Maintenance of the Electrical systems', '', 'from_ntt', 'projDev', NULL),
(25, 'Maintenance of the control boxes', '', 'from_ntt', 'projDev', NULL),
(26, 'Software maintenance', '', 'from_ntt', 'projDev', NULL),
(27, 'Maintenance of the box gateway', '', 'from_ntt', 'projDev', NULL),
(28, 'Maintenance of the EV charging point', '', 'from_ntt', 'projDev', NULL),
(29, 'Data and transactions run costs ', '', 'from_ntt', 'projDev', NULL),
(30, 'Electricity cost', '', 'from_ntt', 'projDev', NULL),
(31, 'Maintenance of the PV panel', '', 'from_ntt', 'projDev', NULL),
(32, 'Maintenance of the battery & remote control', '', 'from_ntt', 'projDev', NULL),
(33, 'Maintenance of the battery &remote control', '', 'from_ntt', 'projDev', NULL),
(34, 'Maintenance of the CCTV monitor', '', 'from_ntt', 'projDev', NULL),
(35, 'Maintenance of the CCTV camera', '', 'from_ntt', 'projDev', NULL),
(36, 'Maintenance of the DVR (Digital Video Recorder) and monitor', '', 'from_ntt', 'projDev', NULL),
(37, 'Maintenance of the PTT device', '', 'from_ntt', 'projDev', NULL),
(38, 'Maintenance of the public speakers', '', 'from_ntt', 'projDev', NULL),
(39, 'Maintenance of the Air Quality Sensor', '', 'from_ntt', 'projDev', NULL),
(40, 'Maintenance of the software', '', 'from_ntt', 'projDev', NULL),
(41, 'Maintenance of the noise sensor', '', 'from_ntt', 'projDev', NULL),
(42, 'Maintenance of the software', '', 'from_ntt', 'projDev', NULL),
(43, 'Maintenance of the water level sensor', '', 'from_ntt', 'projDev', NULL),
(44, 'Maintenance of the software', '', 'from_ntt', 'projDev', NULL),
(45, 'Maintenance of the banner', '', 'from_ntt', 'projDev', NULL),
(46, 'Maintenance of the sensor', '', 'from_ntt', 'projDev', NULL),
(47, 'Maintenance of the software', '', 'from_ntt', 'projDev', NULL),
(48, 'Maintenance of the sensor', '', 'from_ntt', 'projDev', NULL),
(49, 'Maintenance of the Data collector', '', 'from_ntt', 'projDev', NULL),
(50, 'Maintenance of local parking guidance system ', '', 'from_ntt', 'projDev', NULL),
(51, 'Maintenance of the sensor', '', 'from_ntt', 'projDev', NULL),
(52, 'Maintenance of the Antenna', '', 'from_ntt', 'projDev', NULL),
(53, 'Maintenance of the Antenna', '', 'from_ntt', 'projDev', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `opex_item_advice`
--

DROP TABLE IF EXISTS `opex_item_advice`;
CREATE TABLE IF NOT EXISTS `opex_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min` double DEFAULT NULL,
  `range_max` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_item_advice`
--

INSERT INTO `opex_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`) VALUES
(1, 'per ...', NULL, 5, 8),
(2, 'per ...', NULL, 2, 3),
(3, 'per tructruc', NULL, 5, 4),
(4, 'per blabla', '', 5, 6),
(5, 'per bla', NULL, 2, 5),
(21, 'Per Pole', 'https://www.streetlights-solar.com/2018/07/19/cost-comparison-between-solar-vs-traditional-lights/', 5, 15),
(22, 'Per smart Lampost', 'Internal research', 8, 23),
(23, 'Per LED light', 'http://www.nyc.gov/html/dot/html/infrastructure/streetlights.shtml', 3, 4),
(24, 'Per cabling system', 'Internal research', 3, 7),
(25, 'Per sensor', 'Internal research', 6, 12),
(26, 'Per software', 'Internal research', 312, 1062),
(27, 'Per gateway', 'http://democracy.cityoflondon.gov.uk/documents/s63133/Street%20Lighting%20Review%20G3-4%20Report%20-%20Final.pdf', 90, 275),
(28, 'Per charging point', 'https://www.ohmhomenow.com/electric-vehicles/ev-charging-station-cost/\n', 7, 20),
(29, 'Per charging point', 'https://www.preciseparklink.com/news/top-10-benefits-of-installing-ev-chargers-in-ontario\n', 20, 25),
(30, 'Per EV charging point', 'https://www.reminetwork.com/articles/the-benefits-of-ev-charging-stations/\n', 270, 300),
(31, 'Per PV panel', 'https://info.lightinus.com/solar-street-lights#solar_street_light_applications', 9, 11),
(32, 'Per battery', 'Internal research', 4, 8),
(33, 'Per battery', 'Internal research', 6, 11),
(34, 'Per CCTV', 'Internal research', 2, 5),
(35, 'Per CCTV camera', 'https://www.thumbtack.com/p/security-camera-installation-cost', 6, 19),
(36, 'Per DVR/NVR', 'https://householdquotes.co.uk/cctv-installation/', 30, 55),
(37, 'Per PTT device', 'Internal research', 4, 25),
(38, 'Per public speakers', 'Internal research', 1, 3),
(39, 'Per sensor', 'Internal research', 3, 4),
(40, 'Per software', 'Internal research', 14, 64),
(41, 'Per sensor', 'Internal research', 3, 4),
(42, 'Per software', 'Internal research', 14, 64),
(43, 'Per sensor', 'Internal research', 3, 4),
(44, 'Per Software', 'Internal research', 14, 64),
(45, 'Per banner', 'Internal research', 5, 8),
(46, 'Per traffic sensor', 'https://www.quora.com/What-are-typical-maintenance-fees-as-a-percentage-of-up-front-license-costs-for-enterprise-software', 90, 290),
(47, 'Per software', 'https://blog.capterra.com/how-much-does-network-monitoring-software-cost/', 8, 24),
(48, 'Per sensor', 'Internal research', 5, 8),
(49, 'Per gateway', 'Internal research', 7, 11),
(50, 'Per guidance system', 'Internal research', 2, 5),
(51, 'Per Wifi sensor', 'Internal research', 4, 5),
(52, 'Per Antennas', 'Internal research', 5, 10),
(53, 'Per 5G antenna', 'Internal research', 5, 10);

-- --------------------------------------------------------

--
-- Structure de la table `opex_item_user`
--

DROP TABLE IF EXISTS `opex_item_user`;
CREATE TABLE IF NOT EXISTS `opex_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_item_user`
--

INSERT INTO `opex_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(9, 3),
(3, 4),
(5, 4),
(6, 8),
(8, 8),
(7, 10),
(10, 11),
(11, 21),
(12, 21),
(13, 21),
(18, 21),
(19, 21),
(20, 21),
(14, 23),
(15, 23),
(16, 23),
(17, 23);

-- --------------------------------------------------------

--
-- Structure de la table `opex_schedule`
--

DROP TABLE IF EXISTS `opex_schedule`;
CREATE TABLE IF NOT EXISTS `opex_schedule` (
  `id_uc` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `25_rampup` date DEFAULT NULL,
  `50_rampup` date DEFAULT NULL,
  `75_rampup` date DEFAULT NULL,
  `100_rampup` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_proj`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_schedule`
--

INSERT INTO `opex_schedule` (`id_uc`, `id_proj`, `start_date`, `25_rampup`, `50_rampup`, `75_rampup`, `100_rampup`, `end_date`) VALUES
(-1, 8, '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01', '2017-02-01', '2020-02-01'),
(1, 1, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2020-07-01'),
(1, 3, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2022-02-01'),
(1, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(1, 6, '2012-03-01', '2012-09-01', '2013-04-01', '2013-09-01', '2014-09-01', '2015-02-01'),
(1, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(2, 1, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2020-07-01'),
(2, 3, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2022-02-01'),
(2, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(2, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(3, 3, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2022-02-01'),
(3, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(3, 6, '2012-03-01', '2012-09-01', '2013-04-01', '2013-09-01', '2014-09-01', '2015-02-01'),
(3, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(5, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(5, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(7, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(7, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(9, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(9, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(10, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(10, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(11, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(11, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(15, 26, '2021-01-01', '2021-02-01', '2021-03-01', '2021-04-01', '2021-06-01', '2023-12-01'),
(15, 27, '2020-11-01', '2021-01-01', '2021-05-01', '2021-06-01', '2021-09-01', '2023-01-01'),
(16, 26, '2021-01-01', '2021-02-01', '2021-03-01', '2021-04-01', '2021-06-01', '2023-12-01'),
(16, 27, '2020-11-01', '2021-01-01', '2021-05-01', '2021-06-01', '2021-09-01', '2023-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `opex_uc`
--

DROP TABLE IF EXISTS `opex_uc`;
CREATE TABLE IF NOT EXISTS `opex_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_uc`
--

INSERT INTO `opex_uc` (`id_item`, `id_uc`) VALUES
(7, -1),
(8, -1),
(9, -1),
(10, -1),
(11, -1),
(12, -1),
(13, -1),
(14, -1),
(15, -1),
(16, -1),
(20, -1),
(1, 1),
(2, 1),
(6, 1),
(3, 2),
(5, 2),
(4, 3),
(17, 3),
(18, 9),
(19, 11),
(21, 12),
(22, 13),
(23, 14),
(24, 14),
(25, 15),
(26, 15),
(27, 15),
(28, 16),
(29, 16),
(30, 16),
(31, 17),
(32, 17),
(33, 18),
(34, 19),
(35, 19),
(36, 19),
(37, 20),
(38, 21),
(39, 22),
(40, 22),
(41, 23),
(42, 23),
(43, 24),
(44, 24),
(45, 25),
(46, 26),
(47, 26),
(48, 27),
(49, 27),
(50, 27),
(51, 28),
(52, 29),
(53, 30);

-- --------------------------------------------------------

--
-- Structure de la table `others`
--

DROP TABLE IF EXISTS `others`;
CREATE TABLE IF NOT EXISTS `others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `others`
--

INSERT INTO `others` (`id`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Structure de la table `payback_constraints`
--

DROP TABLE IF EXISTS `payback_constraints`;
CREATE TABLE IF NOT EXISTS `payback_constraints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payback_constraints`
--

INSERT INTO `payback_constraints` (`id`, `name`, `description`) VALUES
(1, '< 33% of Project Duration', 'quick payback'),
(2, '33% to 66% of Project Duration', 'medium - long payback'),
(3, '66% to 100% of Project Duration', 'long payback'),
(4, 'Beyond Project Duration', 'no payback');

-- --------------------------------------------------------

--
-- Structure de la table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
CREATE TABLE IF NOT EXISTS `privileges` (
  `id_group` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `code` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_group`,`id_user`,`id_role`),
  KEY `id_user` (`id_user`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `discount_rate` double DEFAULT NULL,
  `weight_bank` double DEFAULT NULL,
  `weight_bank_soc` double DEFAULT NULL,
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modif_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `scoping` tinyint(4) DEFAULT '0',
  `cb` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `discount_rate`, `weight_bank`, `weight_bank_soc`, `creation_date`, `modif_date`, `id_user`, `scoping`, `cb`) VALUES
(7, 'SupplierZak', 'test', NULL, NULL, NULL, '2020-08-17 09:43:18', '2020-08-17 09:47:32', 10, 0, 0),
(21, 'Test Project', '', NULL, NULL, NULL, '2020-09-15 15:07:56', '2020-10-19 17:09:37', 15, 1, 0),
(22, 'empty', '', NULL, NULL, NULL, '2020-09-28 14:46:13', '2020-09-28 14:46:24', 15, 1, 0),
(23, 'MyProject', 'joli projet ', NULL, NULL, NULL, '2020-09-28 15:51:50', '2020-09-28 17:05:15', 15, 1, 1),
(24, 'verif dash', '', NULL, NULL, NULL, '2020-10-07 16:37:42', '2020-10-07 17:26:47', 15, 1, 1),
(26, 'Metro Area', '', 5, NULL, NULL, '2020-10-19 17:44:28', '2020-10-21 10:09:20', 1, 1, 0),
(27, 'Metro Area', '', 5, NULL, NULL, '2020-10-20 10:02:33', '2020-10-20 17:28:51', 13, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `project_dates`
--

DROP TABLE IF EXISTS `project_dates`;
CREATE TABLE IF NOT EXISTS `project_dates` (
  `id_project` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `deploy_start_date` date NOT NULL,
  `deploy_duration` int(11) NOT NULL,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `project_dates`
--

INSERT INTO `project_dates` (`id_project`, `start_date`, `duration`, `deploy_start_date`, `deploy_duration`) VALUES
(3, '2020-09-11', 12, '2020-09-23', 5),
(4, '2020-09-06', 12, '2020-09-20', 4),
(10, '2020-09-14', 36, '2020-09-14', 6),
(11, '2021-01-01', 48, '2021-05-01', 6),
(21, '2020-09-15', 48, '2021-02-01', 6),
(23, '2021-01-04', 36, '2021-01-04', 6),
(24, '2017-01-01', 52, '2017-04-01', 6);

-- --------------------------------------------------------

--
-- Structure de la table `project_group`
--

DROP TABLE IF EXISTS `project_group`;
CREATE TABLE IF NOT EXISTS `project_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `project_perimeter`
--

DROP TABLE IF EXISTS `project_perimeter`;
CREATE TABLE IF NOT EXISTS `project_perimeter` (
  `id_proj` int(11) NOT NULL,
  `id_zone` int(11) NOT NULL,
  PRIMARY KEY (`id_proj`,`id_zone`),
  KEY `id_zone` (`id_zone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project_perimeter`
--

INSERT INTO `project_perimeter` (`id_proj`, `id_zone`) VALUES
(1, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(27, 1),
(1, 2),
(3, 2),
(4, 2),
(6, 2),
(8, 2),
(27, 2),
(1, 3),
(4, 3),
(7, 3),
(8, 3),
(1, 4),
(3, 4),
(4, 4),
(6, 4),
(8, 4),
(27, 4),
(1, 5),
(4, 5),
(6, 5),
(8, 5),
(4, 6),
(7, 6),
(8, 6),
(3, 7),
(4, 7),
(5, 7),
(8, 7),
(26, 9),
(27, 9),
(26, 11),
(27, 11),
(27, 13),
(27, 15),
(26, 16),
(26, 20),
(27, 20),
(27, 22);

-- --------------------------------------------------------

--
-- Structure de la table `project_schedule`
--

DROP TABLE IF EXISTS `project_schedule`;
CREATE TABLE IF NOT EXISTS `project_schedule` (
  `id_project` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `deploy_start` date NOT NULL,
  `deployment_duration` int(11) NOT NULL,
  `uc_end` date NOT NULL,
  `pricing_start` date NOT NULL,
  `poc_duration` int(11) NOT NULL,
  PRIMARY KEY (`id_project`,`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `project_schedule`
--

INSERT INTO `project_schedule` (`id_project`, `id_uc`, `deploy_start`, `deployment_duration`, `uc_end`, `pricing_start`, `poc_duration`) VALUES
(3, 3, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0),
(21, 1, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0),
(21, 2, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0),
(21, 5, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0),
(21, 7, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0),
(21, 9, '2021-03-01', 3, '2023-06-01', '2021-05-01', 4),
(21, 11, '2021-02-01', 3, '2023-07-01', '2021-03-01', 3),
(23, 3, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0),
(24, 9, '0000-00-00', 0, '0000-00-00', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `project_size`
--

DROP TABLE IF EXISTS `project_size`;
CREATE TABLE IF NOT EXISTS `project_size` (
  `id_uc` int(11) NOT NULL,
  `id_zone` int(11) NOT NULL,
  `id_mag` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  PRIMARY KEY (`id_uc`,`id_zone`,`id_mag`,`id_proj`),
  KEY `id_zone` (`id_zone`),
  KEY `id_mag` (`id_mag`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project_size`
--

INSERT INTO `project_size` (`id_uc`, `id_zone`, `id_mag`, `id_proj`) VALUES
(1, 3, 3, 1),
(2, 3, 2, 1),
(3, 3, 3, 1),
(1, 4, 2, 1),
(1, 4, 2, 3),
(1, 4, 2, 4),
(1, 4, 2, 6),
(1, 4, 2, 8),
(2, 4, 2, 3),
(2, 4, 2, 4),
(2, 4, 2, 8),
(2, 4, 3, 1),
(3, 4, 2, 1),
(3, 4, 2, 3),
(3, 4, 2, 4),
(3, 4, 2, 6),
(3, 4, 2, 8),
(5, 4, 2, 8),
(7, 4, 2, 4),
(7, 4, 2, 8),
(9, 4, 2, 4),
(9, 4, 2, 8),
(10, 4, 2, 4),
(10, 4, 2, 8),
(11, 4, 2, 8),
(15, 4, 2, 27),
(16, 4, 2, 27),
(1, 5, 2, 1),
(1, 5, 2, 4),
(1, 5, 2, 6),
(1, 5, 3, 8),
(2, 5, 2, 1),
(2, 5, 2, 4),
(2, 5, 3, 8),
(3, 5, 2, 1),
(3, 5, 2, 4),
(3, 5, 2, 6),
(3, 5, 3, 8),
(5, 5, 3, 8),
(7, 5, 2, 4),
(7, 5, 3, 8),
(9, 5, 2, 4),
(9, 5, 3, 8),
(10, 5, 2, 4),
(10, 5, 3, 8),
(11, 5, 3, 8),
(1, 6, 2, 4),
(1, 6, 2, 8),
(2, 6, 2, 4),
(2, 6, 2, 8),
(3, 6, 2, 4),
(3, 6, 2, 8),
(5, 6, 2, 8),
(7, 6, 2, 4),
(7, 6, 2, 8),
(9, 6, 2, 4),
(9, 6, 2, 8),
(10, 6, 2, 4),
(10, 6, 2, 8),
(11, 6, 2, 8),
(1, 7, 2, 5),
(1, 7, 3, 3),
(1, 7, 3, 4),
(1, 7, 3, 8),
(2, 7, 2, 5),
(2, 7, 3, 3),
(2, 7, 3, 4),
(2, 7, 3, 8),
(3, 7, 3, 3),
(3, 7, 3, 4),
(3, 7, 3, 8),
(5, 7, 3, 8),
(7, 7, 2, 4),
(7, 7, 3, 8),
(9, 7, 2, 4),
(9, 7, 3, 8),
(10, 7, 2, 4),
(10, 7, 3, 8),
(11, 7, 3, 8),
(15, 16, 2, 26),
(16, 16, 2, 26),
(15, 20, 2, 26),
(16, 20, 2, 26);

-- --------------------------------------------------------

--
-- Structure de la table `proj_sel_measure`
--

DROP TABLE IF EXISTS `proj_sel_measure`;
CREATE TABLE IF NOT EXISTS `proj_sel_measure` (
  `id_proj` int(11) NOT NULL,
  `id_meas` int(11) NOT NULL,
  PRIMARY KEY (`id_proj`,`id_meas`),
  KEY `id_meas` (`id_meas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `proj_sel_measure`
--

INSERT INTO `proj_sel_measure` (`id_proj`, `id_meas`) VALUES
(3, 0),
(4, 0),
(6, 0),
(8, 0),
(11, 0),
(21, 0),
(22, 0),
(23, 0),
(24, 0),
(26, 0),
(27, 0),
(1, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(10, 1),
(11, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(3, 21),
(26, 21),
(27, 21);

-- --------------------------------------------------------

--
-- Structure de la table `proj_sel_usecase`
--

DROP TABLE IF EXISTS `proj_sel_usecase`;
CREATE TABLE IF NOT EXISTS `proj_sel_usecase` (
  `id_uc` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  PRIMARY KEY (`id_uc`,`id_proj`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `proj_sel_usecase`
--

INSERT INTO `proj_sel_usecase` (`id_uc`, `id_proj`) VALUES
(1, 1),
(2, 1),
(-1, 3),
(15, 3),
(16, 3),
(-1, 4),
(1, 4),
(2, 4),
(3, 4),
(5, 4),
(7, 4),
(9, 4),
(10, 4),
(11, 4),
(1, 5),
(2, 5),
(-1, 6),
(1, 6),
(3, 6),
(7, 7),
(-1, 8),
(1, 8),
(2, 8),
(3, 8),
(5, 8),
(7, 8),
(9, 8),
(10, 8),
(11, 8),
(1, 10),
(2, 10),
(3, 10),
(7, 10),
(9, 10),
(10, 10),
(11, 10),
(-1, 11),
(1, 11),
(2, 11),
(3, 11),
(5, 11),
(7, 11),
(9, 11),
(10, 11),
(11, 11),
(-1, 21),
(1, 21),
(3, 21),
(5, 21),
(9, 21),
(10, 21),
(11, 21),
(-1, 22),
(1, 22),
(2, 22),
(9, 22),
(-1, 23),
(1, 23),
(3, 23),
(5, 23),
(-1, 24),
(1, 24),
(2, 24),
(7, 24),
(9, 24),
(-1, 26),
(15, 26),
(16, 26),
(-1, 27),
(15, 27),
(16, 27);

-- --------------------------------------------------------

--
-- Structure de la table `quantifiable_item`
--

DROP TABLE IF EXISTS `quantifiable_item`;
CREATE TABLE IF NOT EXISTS `quantifiable_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_item`
--

INSERT INTO `quantifiable_item` (`id`, `name`, `description`) VALUES
(1, 'test', 'htyjh'),
(4, 'example quantifiable item', 'lorem ipsum'),
(6, 'Enfants dans les parcs', ''),
(7, 'Poissons dans l\'eau', ''),
(8, 'test', ''),
(9, 'test item', ''),
(10, 'number of accidents', ''),
(11, 'cvcv', ''),
(12, 'quant', '');

-- --------------------------------------------------------

--
-- Structure de la table `quantifiable_item_advice`
--

DROP TABLE IF EXISTS `quantifiable_item_advice`;
CREATE TABLE IF NOT EXISTS `quantifiable_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min_red_nb` double DEFAULT NULL,
  `range_max_red_nb` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_item_advice`
--

INSERT INTO `quantifiable_item_advice` (`id`, `unit`, `source`, `range_min_red_nb`, `range_max_red_nb`) VALUES
(1, 'per ...', 'www.     .fr', 5, 10),
(2, 'tgrfe', 'btgrf', 1, 2),
(3, 'htgrfe', 'tbgrfe', 4, 5),
(4, 'per unit', 'www.google.com', 3, 100);

-- --------------------------------------------------------

--
-- Structure de la table `quantifiable_item_user`
--

DROP TABLE IF EXISTS `quantifiable_item_user`;
CREATE TABLE IF NOT EXISTS `quantifiable_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_item_user`
--

INSERT INTO `quantifiable_item_user` (`id`, `id_proj`) VALUES
(8, 3),
(1, 4),
(5, 8),
(6, 8),
(7, 8),
(9, 21),
(11, 21),
(12, 21),
(10, 23);

-- --------------------------------------------------------

--
-- Structure de la table `quantifiable_uc`
--

DROP TABLE IF EXISTS `quantifiable_uc`;
CREATE TABLE IF NOT EXISTS `quantifiable_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_uc`
--

INSERT INTO `quantifiable_uc` (`id_item`, `id_uc`) VALUES
(9, -1),
(5, 1),
(6, 1),
(2, 2),
(8, 3),
(10, 3),
(3, 5),
(1, 7),
(4, 7),
(11, 9),
(7, 11),
(12, 11);

-- --------------------------------------------------------

--
-- Structure de la table `ratio_comp_capex`
--

DROP TABLE IF EXISTS `ratio_comp_capex`;
CREATE TABLE IF NOT EXISTS `ratio_comp_capex` (
  `id_compo` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ratio_comp_capex`
--

INSERT INTO `ratio_comp_capex` (`id_compo`, `id_item`, `val`) VALUES
(1, 4, 150),
(1, 5, 100),
(2, 4, 58),
(2, 5, 10);

-- --------------------------------------------------------

--
-- Structure de la table `ratio_comp_cashreleasing`
--

DROP TABLE IF EXISTS `ratio_comp_cashreleasing`;
CREATE TABLE IF NOT EXISTS `ratio_comp_cashreleasing` (
  `id_compo` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ratio_comp_implem`
--

DROP TABLE IF EXISTS `ratio_comp_implem`;
CREATE TABLE IF NOT EXISTS `ratio_comp_implem` (
  `id_compo` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ratio_comp_opex`
--

DROP TABLE IF EXISTS `ratio_comp_opex`;
CREATE TABLE IF NOT EXISTS `ratio_comp_opex` (
  `id_compo` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ratio_comp_per_uc`
--

DROP TABLE IF EXISTS `ratio_comp_per_uc`;
CREATE TABLE IF NOT EXISTS `ratio_comp_per_uc` (
  `id_uc` int(11) NOT NULL,
  `id_compo` int(11) NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_compo`),
  KEY `id_compo` (`id_compo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ratio_comp_per_uc`
--

INSERT INTO `ratio_comp_per_uc` (`id_uc`, `id_compo`, `val`) VALUES
(3, 1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `ratio_comp_revenues`
--

DROP TABLE IF EXISTS `ratio_comp_revenues`;
CREATE TABLE IF NOT EXISTS `ratio_comp_revenues` (
  `id_compo` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ratio_comp_widercash`
--

DROP TABLE IF EXISTS `ratio_comp_widercash`;
CREATE TABLE IF NOT EXISTS `ratio_comp_widercash` (
  `id_compo` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `revenues_item`
--

DROP TABLE IF EXISTS `revenues_item`;
CREATE TABLE IF NOT EXISTS `revenues_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_item`
--

INSERT INTO `revenues_item` (`id`, `name`, `description`) VALUES
(1, 'revenues item 1', ''),
(2, 'revenues item 2', ''),
(3, 'revenues item 3', ''),
(4, 'revenues item 4', ''),
(5, 'revenues item 5', ''),
(7, 'revenues from cost', 'ffff'),
(8, 'test', ''),
(9, 'rev 1', ''),
(10, 'rev 2', ''),
(11, 'rev 3', ''),
(12, 'test', ''),
(13, 'efh', ''),
(14, 'Rev1', ''),
(15, 'revenues', ''),
(16, 'User fee - Membership card', ''),
(17, 'Electricity charging fees', ''),
(18, 'Fees for parking-services', ''),
(19, 'Advertisement', ''),
(20, 'Access to Wifi point', '');

-- --------------------------------------------------------

--
-- Structure de la table `revenues_item_advice`
--

DROP TABLE IF EXISTS `revenues_item_advice`;
CREATE TABLE IF NOT EXISTS `revenues_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min` double DEFAULT NULL,
  `range_max` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_item_advice`
--

INSERT INTO `revenues_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`) VALUES
(1, 'per example', NULL, 1, 10),
(2, 'per example', NULL, 2, 20),
(5, '43GVFD', '', 54, 543),
(16, 'Per user', 'https://www.preciseparklink.com/news/top-10-benefits-of-installing-ev-chargers-in-ontario\n', 8, 10),
(17, 'Per charging point', 'https://www.justpark.com/uk/parking/london/', 525, 875),
(18, 'Per charging point', 'Internal research', 455, 470),
(19, 'Per  Banner', 'https://www.hastings.gov.uk/press_media/advertising/lamppostbanners/', 130, 300),
(20, 'Per wifi access point', 'https://nypost.com/2018/05/01/nycs-free-public-wi-fi-kiosks-arent-making-enough-money/', 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `revenues_item_user`
--

DROP TABLE IF EXISTS `revenues_item_user`;
CREATE TABLE IF NOT EXISTS `revenues_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_item_user`
--

INSERT INTO `revenues_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(7, 3),
(3, 4),
(4, 4),
(6, 4),
(13, 4),
(8, 8),
(9, 8),
(10, 8),
(11, 8),
(12, 21),
(15, 21),
(14, 23);

-- --------------------------------------------------------

--
-- Structure de la table `revenues_uc`
--

DROP TABLE IF EXISTS `revenues_uc`;
CREATE TABLE IF NOT EXISTS `revenues_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_uc`
--

INSERT INTO `revenues_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 2),
(6, 2),
(7, 2),
(4, 3),
(14, 3),
(5, 6),
(12, 9),
(8, 11),
(9, 11),
(10, 11),
(11, 11),
(13, 11),
(15, 11),
(16, 16),
(17, 16),
(18, 16),
(19, 25),
(20, 28);

-- --------------------------------------------------------

--
-- Structure de la table `revenue_schedule`
--

DROP TABLE IF EXISTS `revenue_schedule`;
CREATE TABLE IF NOT EXISTS `revenue_schedule` (
  `id_uc` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `25_rampup` date DEFAULT NULL,
  `50_rampup` date DEFAULT NULL,
  `75_rampup` date DEFAULT NULL,
  `100_rampup` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_proj`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenue_schedule`
--

INSERT INTO `revenue_schedule` (`id_uc`, `id_proj`, `start_date`, `25_rampup`, `50_rampup`, `75_rampup`, `100_rampup`, `end_date`) VALUES
(-1, 8, '2014-02-01', '2015-02-01', '2016-02-01', '2017-02-01', '2018-02-01', '2019-02-01'),
(1, 1, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2020-07-01'),
(1, 3, '2012-01-01', '2013-02-01', '2013-03-01', '2015-02-01', '2016-02-01', '2023-03-01'),
(1, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(1, 6, '2013-05-01', '2013-12-01', '2014-05-01', '2015-09-01', '2016-06-01', '2017-11-01'),
(1, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(2, 1, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2020-07-01'),
(2, 3, '2012-01-01', '2013-02-01', '2013-03-01', '2015-02-01', '2016-02-01', '2023-03-01'),
(2, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(2, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(3, 3, '2012-01-01', '2013-02-01', '2013-03-01', '2015-02-01', '2016-02-01', '2023-03-01'),
(3, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(3, 6, '2013-05-01', '2013-12-01', '2014-05-01', '2015-09-01', '2016-06-01', '2017-11-01'),
(3, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(5, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(5, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(7, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(7, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(9, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(9, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(10, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(10, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(11, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(11, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(15, 26, '2021-01-01', '2021-02-01', '2021-03-01', '2021-04-01', '2021-05-01', '2023-12-01'),
(15, 27, '2021-01-01', '2021-05-01', '2021-06-01', '2021-08-01', '2021-11-01', '2023-01-01'),
(16, 26, '2021-01-01', '2021-02-01', '2021-03-01', '2021-04-01', '2021-05-01', '2023-12-01'),
(16, 27, '2021-01-01', '2021-05-01', '2021-06-01', '2021-08-01', '2021-11-01', '2023-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `risk_item`
--

DROP TABLE IF EXISTS `risk_item`;
CREATE TABLE IF NOT EXISTS `risk_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `sources` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `risk_item`
--

INSERT INTO `risk_item` (`id`, `name`, `description`, `sources`) VALUES
(1, 'risk item 1', '', NULL),
(2, 'risk item 2', '', NULL),
(3, 'risk custom item 1', '', NULL),
(4, 'risks', '', NULL),
(5, 'risks', '', NULL),
(6, 'Maladie', '', NULL),
(7, 'Peur', '', NULL),
(8, 'risk 1', '', NULL),
(9, 'risk 2', '', NULL),
(10, 'risk 3', '', NULL),
(11, 'black', '', NULL),
(12, 'ri', '', NULL),
(13, 'risk 01', '', NULL),
(14, 'Potential Negative impact on health', '', NULL),
(15, 'Harm to animals', '', NULL),
(16, 'Lack of public acceptance', '', NULL),
(17, 'Network Hacking', '', NULL),
(18, 'Network crash', '', NULL),
(19, 'Grid reliability (instability and disruptions)', '', NULL),
(20, 'Security and safety risks (extreme weather, collisions, vandalism).', '', NULL),
(21, 'Vandalism', '', NULL),
(22, 'Bad weather (sunlight)', '', NULL),
(23, 'Safety risks', '', NULL),
(24, 'Vandalism', '', NULL),
(25, 'Cyber attack', '', NULL),
(26, 'Vandalism', '', NULL),
(27, 'Lack of public acceptance', '', NULL),
(28, 'Network and coverage Issues', '', NULL),
(29, 'Vandalism', '', NULL),
(30, 'Lack of public acceptance', '', NULL),
(31, 'Sound coverage', '', NULL),
(32, 'Lack of scalability - coverage', '', NULL),
(33, 'Lack of public acceptance', '', NULL),
(34, 'Cyber attacks(Hacking and Data leaks)', '', NULL),
(35, 'Lack of scalability - coverage', '', NULL),
(36, 'Sensitivity to high temperature', '', NULL),
(37, 'Lack of scalability - coverage', '', NULL),
(38, 'Limited visibility due to the height of advertisement', '', NULL),
(39, 'Development of Urban planning ', '', NULL),
(40, 'Data hacking', '', NULL),
(41, 'Reduction of control to parking usage ', '', NULL),
(42, 'Cyber attacks', '', NULL),
(43, 'Public acceptance', '', NULL),
(44, 'WiFi access point', '', NULL),
(45, 'Cyber attacks', '', NULL),
(46, 'Connectivity', '', NULL),
(47, 'Cyber attacks', '', NULL),
(48, 'Network interference', '', NULL),
(49, 'Potential Negative impact on health', '', NULL),
(50, 'Increase in housing prices and district attractiveness', '', NULL),
(51, 'Potential Negative impact on health', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `risk_item_advice`
--

DROP TABLE IF EXISTS `risk_item_advice`;
CREATE TABLE IF NOT EXISTS `risk_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `risk_item_user`
--

DROP TABLE IF EXISTS `risk_item_user`;
CREATE TABLE IF NOT EXISTS `risk_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `risk_item_user`
--

INSERT INTO `risk_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 4),
(4, 4),
(5, 4),
(7, 6),
(6, 8),
(8, 8),
(9, 8),
(10, 8),
(12, 21),
(13, 21),
(11, 23);

-- --------------------------------------------------------

--
-- Structure de la table `risk_uc`
--

DROP TABLE IF EXISTS `risk_uc`;
CREATE TABLE IF NOT EXISTS `risk_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `risk_uc`
--

INSERT INTO `risk_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 1),
(6, 1),
(7, 1),
(5, 2),
(4, 3),
(11, 3),
(12, 9),
(8, 11),
(9, 11),
(10, 11),
(13, 11),
(14, 14),
(15, 14),
(16, 14),
(17, 15),
(18, 15),
(19, 16),
(20, 16),
(21, 17),
(22, 17),
(23, 18),
(24, 18),
(25, 19),
(26, 19),
(27, 19),
(28, 20),
(29, 20),
(30, 21),
(31, 21),
(32, 22),
(33, 23),
(34, 23),
(35, 23),
(36, 23),
(37, 24),
(38, 25),
(39, 26),
(40, 26),
(41, 27),
(42, 27),
(43, 27),
(44, 28),
(45, 28),
(46, 28),
(47, 29),
(48, 29),
(49, 29),
(50, 30),
(51, 30);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sel_funding_source`
--

DROP TABLE IF EXISTS `sel_funding_source`;
CREATE TABLE IF NOT EXISTS `sel_funding_source` (
  `id_finScen` int(11) NOT NULL,
  `id_source` int(11) NOT NULL,
  `share` double DEFAULT '0',
  `interest` double DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `maturity_date` date DEFAULT NULL,
  PRIMARY KEY (`id_finScen`,`id_source`),
  KEY `id_source` (`id_source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sel_funding_source`
--

INSERT INTO `sel_funding_source` (`id_finScen`, `id_source`, `share`, `interest`, `start_date`, `maturity_date`) VALUES
(4, 1, 30, 0, NULL, NULL),
(4, 3, 30, 0, '2014-03-01', NULL),
(4, 7, 20, 5, '2015-01-01', '2016-01-01'),
(4, 9, 10, 0, '2013-03-01', NULL),
(4, 11, 10, 0, '2014-07-01', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `shared_financing_scen`
--

DROP TABLE IF EXISTS `shared_financing_scen`;
CREATE TABLE IF NOT EXISTS `shared_financing_scen` (
  `id_group` int(11) NOT NULL,
  `id_finScen` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_group`,`id_finScen`,`id_user`),
  KEY `id_finScen` (`id_finScen`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shared_project`
--

DROP TABLE IF EXISTS `shared_project`;
CREATE TABLE IF NOT EXISTS `shared_project` (
  `id_user` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_proj`,`id_group`),
  KEY `id_proj` (`id_proj`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `shared_ucm`
--

DROP TABLE IF EXISTS `shared_ucm`;
CREATE TABLE IF NOT EXISTS `shared_ucm` (
  `id_user` int(11) NOT NULL,
  `id_ucm` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_ucm`,`id_group`),
  KEY `id_ucm` (`id_ucm`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `supplier_perimeter`
--

DROP TABLE IF EXISTS `supplier_perimeter`;
CREATE TABLE IF NOT EXISTS `supplier_perimeter` (
  `proj_id` int(10) UNSIGNED NOT NULL,
  `country` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `department` varchar(256) NOT NULL,
  `company` varchar(256) NOT NULL,
  `team` varchar(256) NOT NULL,
  PRIMARY KEY (`proj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `supplier_perimeter`
--

INSERT INTO `supplier_perimeter` (`proj_id`, `country`, `city`, `name`, `department`, `company`, `team`) VALUES
(21, 'a', 'Compiegne', 'Diego MEJIA', '12', 'Google', 'team a'),
(22, '', '', '', '', '', ''),
(23, 'USA', 'Las Vegas', 'CIty of Las Vegas', 'Plice departement', 'Smart Solution Corp', 'team a'),
(24, '', '', '', '', 'verifDash', '');

-- --------------------------------------------------------

--
-- Structure de la table `supplier_revenues_item`
--

DROP TABLE IF EXISTS `supplier_revenues_item`;
CREATE TABLE IF NOT EXISTS `supplier_revenues_item` (
  `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('equipment','deployment','operating') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(1023) NOT NULL,
  `advice_user` enum('advice','user') NOT NULL,
  `unit` varchar(256) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `supplier_revenues_item`
--

INSERT INTO `supplier_revenues_item` (`item_id`, `name`, `type`, `description`, `advice_user`, `unit`) VALUES
(1, 'rev 1', 'equipment', 'desc', 'user', ''),
(2, 'dep 1', 'deployment', '', 'user', ''),
(3, 'op 1', 'operating', '', 'user', ''),
(4, 'My rev', 'equipment', '', 'user', ''),
(5, 'Sensor', 'equipment', '', 'user', ''),
(6, 'project management', 'deployment', 'project', 'user', ''),
(7, 'sells of data analytics', 'operating', '', 'user', ''),
(9, 'dep 001', 'deployment', '', 'user', ''),
(10, 'rec 01', 'operating', '', 'user', ''),
(13, 'rev 001', 'equipment', '', 'user', 'r'),
(14, 'rev 002', 'equipment', '', 'user', ''),
(15, 'my 1st eq', 'equipment', '', 'user', ''),
(16, 'my 2nd eq', 'equipment', '', 'user', ''),
(17, 'dep 1st', 'deployment', '', 'user', ''),
(18, '1st rec', 'operating', '', 'user', ''),
(19, 'rev 1', 'equipment', '', 'user', 'u'),
(20, 'dep', 'deployment', '', 'user', ''),
(21, 'rec', 'operating', '', 'user', '');

-- --------------------------------------------------------

--
-- Structure de la table `supplier_revenues_uc`
--

DROP TABLE IF EXISTS `supplier_revenues_uc`;
CREATE TABLE IF NOT EXISTS `supplier_revenues_uc` (
  `id_revenue` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_revenue`,`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `supplier_revenues_uc`
--

INSERT INTO `supplier_revenues_uc` (`id_revenue`, `id_uc`) VALUES
(1, 9),
(2, 9),
(3, 9),
(4, 7),
(5, 3),
(6, 3),
(7, 3),
(8, -1),
(9, -1),
(10, -1),
(11, -1),
(12, -1),
(13, -1),
(14, -1),
(15, 9),
(16, -1),
(17, -1),
(18, -1),
(19, 11),
(20, 11),
(21, 11);

-- --------------------------------------------------------

--
-- Structure de la table `supplier_revenues_user`
--

DROP TABLE IF EXISTS `supplier_revenues_user`;
CREATE TABLE IF NOT EXISTS `supplier_revenues_user` (
  `id_revenue` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  PRIMARY KEY (`id_revenue`,`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `supplier_revenues_user`
--

INSERT INTO `supplier_revenues_user` (`id_revenue`, `id_proj`) VALUES
(1, 21),
(2, 21),
(3, 21),
(4, 21),
(5, 23),
(6, 23),
(7, 23),
(8, 21),
(9, 21),
(10, 21),
(11, 21),
(12, 21),
(13, 21),
(14, 21),
(15, 24),
(16, 24),
(17, 24),
(18, 24),
(19, 21),
(20, 21),
(21, 21);

-- --------------------------------------------------------

--
-- Structure de la table `ucm_sel_crit`
--

DROP TABLE IF EXISTS `ucm_sel_crit`;
CREATE TABLE IF NOT EXISTS `ucm_sel_crit` (
  `id_crit` int(11) NOT NULL,
  `id_ucm` int(11) NOT NULL,
  PRIMARY KEY (`id_crit`,`id_ucm`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_crit`
--

INSERT INTO `ucm_sel_crit` (`id_crit`, `id_ucm`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(1, 4),
(2, 4),
(4, 4),
(5, 4),
(6, 4),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(6, 6),
(9, 6),
(10, 6),
(1, 7),
(3, 7),
(5, 7),
(6, 7),
(9, 7),
(1, 9),
(2, 9),
(3, 9),
(4, 9),
(5, 9),
(6, 9),
(9, 9),
(10, 9);

-- --------------------------------------------------------

--
-- Structure de la table `ucm_sel_critcat`
--

DROP TABLE IF EXISTS `ucm_sel_critcat`;
CREATE TABLE IF NOT EXISTS `ucm_sel_critcat` (
  `id_critCat` int(11) NOT NULL,
  `id_ucm` int(11) NOT NULL,
  `weight` double DEFAULT NULL,
  PRIMARY KEY (`id_critCat`,`id_ucm`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_critcat`
--

INSERT INTO `ucm_sel_critcat` (`id_critCat`, `id_ucm`, `weight`) VALUES
(1, 1, 50),
(1, 4, 85),
(1, 6, NULL),
(1, 7, 50),
(1, 9, 50),
(2, 1, 50),
(2, 4, 15),
(2, 6, NULL),
(2, 7, 50),
(2, 9, 50);

-- --------------------------------------------------------

--
-- Structure de la table `ucm_sel_dlt`
--

DROP TABLE IF EXISTS `ucm_sel_dlt`;
CREATE TABLE IF NOT EXISTS `ucm_sel_dlt` (
  `id_ucm` int(11) NOT NULL,
  `id_dlt` int(11) NOT NULL,
  PRIMARY KEY (`id_ucm`,`id_dlt`),
  KEY `id_dlt` (`id_dlt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_dlt`
--

INSERT INTO `ucm_sel_dlt` (`id_ucm`, `id_dlt`) VALUES
(1, 1),
(4, 1),
(6, 1),
(8, 1),
(9, 1),
(4, 2),
(7, 2),
(8, 2),
(9, 2);

-- --------------------------------------------------------

--
-- Structure de la table `ucm_sel_measure`
--

DROP TABLE IF EXISTS `ucm_sel_measure`;
CREATE TABLE IF NOT EXISTS `ucm_sel_measure` (
  `id_meas` int(11) NOT NULL,
  `id_ucm` int(11) NOT NULL,
  PRIMARY KEY (`id_meas`,`id_ucm`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_measure`
--

INSERT INTO `ucm_sel_measure` (`id_meas`, `id_ucm`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 4),
(16, 6),
(1, 7),
(15, 8),
(1, 9),
(4, 9),
(16, 9),
(21, 14),
(21, 15);

-- --------------------------------------------------------

--
-- Structure de la table `ucm_sel_uc`
--

DROP TABLE IF EXISTS `ucm_sel_uc`;
CREATE TABLE IF NOT EXISTS `ucm_sel_uc` (
  `id_uc` int(11) NOT NULL,
  `id_ucm` int(11) NOT NULL,
  PRIMARY KEY (`id_uc`,`id_ucm`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_uc`
--

INSERT INTO `ucm_sel_uc` (`id_uc`, `id_ucm`) VALUES
(1, 1),
(2, 1),
(3, 1),
(5, 1),
(2, 4),
(5, 4),
(7, 4),
(9, 4),
(10, 4),
(2, 6),
(5, 6),
(7, 6),
(9, 6),
(10, 6),
(1, 7),
(2, 7),
(3, 7),
(5, 7),
(7, 7),
(11, 7),
(1, 9),
(2, 9),
(3, 9),
(5, 9),
(7, 9),
(9, 9),
(10, 9),
(11, 9);

-- --------------------------------------------------------

--
-- Structure de la table `uc_confirmed`
--

DROP TABLE IF EXISTS `uc_confirmed`;
CREATE TABLE IF NOT EXISTS `uc_confirmed` (
  `user_id` int(11) NOT NULL,
  `proj_id` int(11) NOT NULL,
  `meas_id` int(11) NOT NULL,
  `uc_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`proj_id`,`meas_id`,`uc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `uc_confirmed`
--

INSERT INTO `uc_confirmed` (`user_id`, `proj_id`, `meas_id`, `uc_id`) VALUES
(15, 21, 0, -1),
(15, 21, 1, 1),
(15, 21, 1, 5),
(15, 21, 1, 9),
(15, 21, 1, 11),
(15, 24, 0, -1),
(15, 24, 1, 9);

-- --------------------------------------------------------

--
-- Structure de la table `uc_vs_crit`
--

DROP TABLE IF EXISTS `uc_vs_crit`;
CREATE TABLE IF NOT EXISTS `uc_vs_crit` (
  `id_uc` int(11) NOT NULL,
  `id_crit` int(11) NOT NULL,
  `pertinence` int(11) DEFAULT NULL,
  `range_min` int(11) DEFAULT NULL,
  `range_max` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_crit`),
  KEY `id_crit` (`id_crit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `uc_vs_crit_input`
--

DROP TABLE IF EXISTS `uc_vs_crit_input`;
CREATE TABLE IF NOT EXISTS `uc_vs_crit_input` (
  `id_uc` int(11) NOT NULL,
  `id_crit` int(11) NOT NULL,
  `id_ucm` int(11) NOT NULL,
  `rate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_crit`,`id_ucm`),
  KEY `id_crit` (`id_crit`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `uc_vs_crit_input`
--

INSERT INTO `uc_vs_crit_input` (`id_uc`, `id_crit`, `id_ucm`, `rate`) VALUES
(1, 1, 1, 6),
(1, 1, 7, 4),
(1, 1, 9, 4),
(1, 2, 1, 4),
(1, 2, 9, 1),
(1, 3, 1, 3),
(1, 3, 7, 5),
(1, 3, 9, 1),
(1, 4, 1, 2),
(1, 4, 9, 1),
(1, 5, 1, 3),
(1, 5, 7, 7),
(1, 5, 9, 1),
(1, 6, 7, 7),
(1, 6, 9, 1),
(1, 9, 7, 3),
(1, 9, 9, 5),
(1, 10, 9, 3),
(2, 1, 1, 2),
(2, 1, 4, 4),
(2, 1, 7, 7),
(2, 1, 9, 2),
(2, 2, 1, 2),
(2, 2, 4, 4),
(2, 2, 9, 5),
(2, 3, 1, 2),
(2, 3, 4, 4),
(2, 3, 7, 7),
(2, 3, 9, 4),
(2, 4, 1, 2),
(2, 4, 4, 4),
(2, 4, 9, 4),
(2, 5, 1, 2),
(2, 5, 7, 4),
(2, 5, 9, 5),
(2, 6, 4, 5),
(2, 6, 7, 3),
(2, 6, 9, 4),
(2, 9, 4, 4),
(2, 9, 7, 4),
(2, 9, 9, 5),
(2, 10, 4, 4),
(2, 10, 9, 1),
(3, 1, 1, 2),
(3, 1, 7, 5),
(3, 1, 9, 1),
(3, 2, 1, 10),
(3, 2, 9, 4),
(3, 3, 1, 5),
(3, 3, 7, 7),
(3, 3, 9, 4),
(3, 4, 1, 5),
(3, 4, 9, 4),
(3, 5, 1, 9),
(3, 5, 7, 6),
(3, 5, 9, 5),
(3, 6, 7, 3),
(3, 6, 9, 5),
(3, 9, 7, 4),
(3, 9, 9, 1),
(3, 10, 9, 4),
(5, 1, 1, 5),
(5, 1, 4, 4),
(5, 1, 7, 7),
(5, 1, 9, 2),
(5, 2, 1, 4),
(5, 2, 4, 4),
(5, 2, 9, 2),
(5, 3, 1, 5),
(5, 3, 4, 4),
(5, 3, 7, 1),
(5, 3, 9, 2),
(5, 4, 1, 5),
(5, 4, 4, 4),
(5, 4, 9, 2),
(5, 5, 1, 4),
(5, 5, 7, 9),
(5, 5, 9, 2),
(5, 6, 4, 5),
(5, 6, 7, 5),
(5, 6, 9, 4),
(5, 9, 4, 4),
(5, 9, 7, 5),
(5, 9, 9, 2),
(5, 10, 4, 4),
(5, 10, 9, 1),
(7, 1, 4, 5),
(7, 1, 7, 3),
(7, 1, 9, 1),
(7, 2, 4, 4),
(7, 2, 9, 8),
(7, 3, 4, 4),
(7, 3, 7, 5),
(7, 3, 9, 5),
(7, 4, 4, 4),
(7, 4, 9, 5),
(7, 5, 7, 4),
(7, 5, 9, 8),
(7, 6, 4, 4),
(7, 6, 7, 3),
(7, 6, 9, 5),
(7, 9, 4, 5),
(7, 9, 7, 6),
(7, 9, 9, 2),
(7, 10, 4, 4),
(7, 10, 9, 5),
(9, 1, 4, 5),
(9, 1, 9, 5),
(9, 2, 4, 5),
(9, 2, 9, 4),
(9, 3, 4, 5),
(9, 3, 9, 5),
(9, 4, 4, 5),
(9, 4, 9, 2),
(9, 5, 9, 4),
(9, 6, 4, 4),
(9, 6, 9, 2),
(9, 9, 4, 4),
(9, 9, 9, 4),
(9, 10, 4, 5),
(9, 10, 9, 2),
(10, 1, 4, 4),
(10, 1, 9, 4),
(10, 2, 4, 4),
(10, 2, 9, 5),
(10, 3, 4, 4),
(10, 3, 9, 5),
(10, 4, 4, 4),
(10, 4, 9, 5),
(10, 5, 9, 7),
(10, 6, 4, 4),
(10, 6, 9, 1),
(10, 9, 4, 4),
(10, 9, 9, 2),
(10, 10, 4, 4),
(10, 10, 9, 5),
(11, 1, 7, 1),
(11, 1, 9, 7),
(11, 2, 9, 7),
(11, 3, 7, 9),
(11, 3, 9, 7),
(11, 4, 9, 1),
(11, 5, 7, 7),
(11, 5, 9, 8),
(11, 6, 7, 2),
(11, 6, 9, 4),
(11, 9, 7, 1),
(11, 9, 9, 4),
(11, 10, 9, 4);

-- --------------------------------------------------------

--
-- Structure de la table `uc_vs_dlt`
--

DROP TABLE IF EXISTS `uc_vs_dlt`;
CREATE TABLE IF NOT EXISTS `uc_vs_dlt` (
  `id_uc` int(11) NOT NULL,
  `id_dlt` int(11) NOT NULL,
  `pertinence` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_dlt`),
  KEY `id_dlt` (`id_dlt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `profile` enum('d','s') NOT NULL,
  `logoName` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `lastname`, `firstname`, `email`, `password`, `salt`, `is_admin`, `is_active`, `creation_date`, `profile`, `logoName`) VALUES
(1, 'admin', NULL, NULL, NULL, '$2y$10$vZD1YOsZNMYWzqzyg.q5KOiJ5M6VrLK8sOGcyOtEB5zWrYb3P4fGq', '10661622345dce8dd31fac11.66803067', 1, 1, '2020-02-11 11:42:57', 'd', ''),
(2, 'user1', NULL, NULL, NULL, '$2y$10$wFtEEFoLQawd.KdW05QTGeituOfY8mA2kyqHBFnurWKsHu63Ke5vu', '646419995e428578913042.05825044', 0, NULL, '2020-02-11 11:44:08', 'd', ''),
(5, 'Zak', NULL, NULL, NULL, '$2y$10$8OstD4JHwDpDsUdmO2FM0Ocszp7gHS9M.7wXIb88WUm4nA8m5dC1W', '7528837005f032af7425025.62320933', 1, NULL, '2020-07-06 15:45:27', 'd', ''),
(10, 'ZakSup', NULL, NULL, NULL, '$2y$10$A5Ler5Xbj7Y6WpG/3gls6uuLRDdfv773iwOHesIKrt4rQpC/Aoz7e', '12867769935f1053d19cec80.37775064', 1, NULL, '2020-07-16 15:19:13', 's', ''),
(12, 'adminD', NULL, NULL, NULL, '$2y$10$31NeoivqFMZ4VYFgA2OBDeHo3JzyRYD64SdvRSHDAEtPxwMSVY66S', '8699085225f3a309ecca908.48687664', 0, NULL, '2020-08-17 09:24:14', 'd', ''),
(13, 'ProjDeve', NULL, NULL, NULL, '$2y$10$pzr45zxv7yM0jHFoOosweOs9ngQDAyCvdkyw.awDMwfFCZo/cgpwu', '7697641405f609379e18ed6.70056693', 1, NULL, '2020-09-15 12:12:10', 'd', ''),
(14, 'Supplier', NULL, NULL, NULL, '$2y$10$ZRmI4EdFyNa0DjXBIuVy0OEss9uyquBbrs07M4p2ABNp9NwW5y.26', '19226631715f609399dea569.52156583', 1, NULL, '2020-09-15 12:12:42', 's', ''),
(15, 'SupplierTest', NULL, NULL, NULL, '$2y$10$9f42/LpUAetvI3ucAfii7eXEuA3HSfPk.2eSi1nErlj3BcXHhhpRO', '4077705355f60bc8fcbd303.92552720', 1, NULL, '2020-09-15 15:07:27', 's', '');

-- --------------------------------------------------------

--
-- Structure de la table `user_measure`
--

DROP TABLE IF EXISTS `user_measure`;
CREATE TABLE IF NOT EXISTS `user_measure` (
  `id_meas` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_meas`,`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_zone`
--

DROP TABLE IF EXISTS `user_zone`;
CREATE TABLE IF NOT EXISTS `user_zone` (
  `id_zone` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_zone`,`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `use_case`
--

DROP TABLE IF EXISTS `use_case`;
CREATE TABLE IF NOT EXISTS `use_case` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `id_meas` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_meas` (`id_meas`),
  KEY `id_cat` (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_case`
--

INSERT INTO `use_case` (`id`, `name`, `description`, `id_meas`, `id_cat`) VALUES
(-1, 'Project Overlay', 'Represente la partie commune du projet (payer le directeur de projet, l’assurance ...)', 0, 0),
(1, 'Wi-Fi', '', 1, 1),
(2, 'Electric Vehicule Charger', '', 1, 1),
(3, 'Parking Management', '', 1, 2),
(5, 'LED Upgrade', '', 1, 2),
(6, 'Pole Replacement', 'description', 2, 3),
(7, '5G', '', 1, 1),
(9, 'Photo Voltaic', '', 1, 1),
(10, 'Public Information & advertising', '', 1, 2),
(11, 'Water Level Sensor', NULL, 1, 2),
(12, 'Pole', '', 21, 5),
(13, 'Smart Lamppost', '', 21, 5),
(15, 'LED', '', 21, 15),
(16, 'CMS', '', 21, 15),
(17, 'EVCP', '', 21, 8),
(18, 'PV', '', 21, 8),
(19, 'ES', '', 21, 8),
(20, 'CCTV', '', 21, 9),
(21, 'Push To Talk', '', 21, 9),
(22, 'Public Speakers', '', 21, 9),
(23, 'Air Quality Sensing', '', 21, 10),
(24, 'Noise Sensor', '', 21, 10),
(25, 'Water Level Sensor', '', 21, 10),
(26, 'Public Information & Advertising', '', 21, 11),
(27, 'Traffic Monitoring', '', 21, 13),
(28, 'Parking Management ', '', 21, 13),
(29, 'Wifi', '', 21, 14),
(30, 'Wireless Communication ', '', 21, 14),
(31, '5G', '', 21, 14);

-- --------------------------------------------------------

--
-- Structure de la table `use_cases_menu`
--

DROP TABLE IF EXISTS `use_cases_menu`;
CREATE TABLE IF NOT EXISTS `use_cases_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modif_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_cases_menu`
--

INSERT INTO `use_cases_menu` (`id`, `name`, `description`, `creation_date`, `id_user`) VALUES
(3, 'uc_eval', '', '2020-02-13 12:22:10', 2),
(7, 'test1', 'test', '2020-07-16 16:04:46', 5),
(8, 'test1', 'test', '2020-08-17 09:19:57', 10),
(14, 'Metro Area', '', '2020-10-19 17:16:51', 1),
(15, 'Metro Area', '', '2020-10-20 11:11:14', 13);

-- --------------------------------------------------------

--
-- Structure de la table `use_case_cat`
--

DROP TABLE IF EXISTS `use_case_cat`;
CREATE TABLE IF NOT EXISTS `use_case_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_case_cat`
--

INSERT INTO `use_case_cat` (`id`, `name`, `description`) VALUES
(0, 'Project Overlay', NULL),
(5, 'Lamppost', ''),
(8, 'Energy', ''),
(9, 'Public Safety', ''),
(10, 'Environmental Monitoring ', ''),
(11, 'Signage ', ''),
(13, 'Movment Monitoring ', ''),
(14, 'Connectivity ', ''),
(15, 'Ligthing', '');

-- --------------------------------------------------------

--
-- Structure de la table `volumes`
--

DROP TABLE IF EXISTS `volumes`;
CREATE TABLE IF NOT EXISTS `volumes` (
  `id_uc` int(11) NOT NULL,
  `id_zone` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `val` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_zone`),
  KEY `id_zone` (`id_zone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `volumes_input`
--

DROP TABLE IF EXISTS `volumes_input`;
CREATE TABLE IF NOT EXISTS `volumes_input` (
  `id_uc` int(11) NOT NULL,
  `id_zone` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `nb_compo` int(11) DEFAULT NULL,
  `nb_per_uc` int(11) DEFAULT NULL,
  `nb_tot_uc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_zone`,`id_proj`),
  KEY `id_zone` (`id_zone`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `volumes_input`
--

INSERT INTO `volumes_input` (`id_uc`, `id_zone`, `id_proj`, `nb_compo`, `nb_per_uc`, `nb_tot_uc`) VALUES
(1, 3, 1, 100, 10, 10),
(1, 4, 3, NULL, NULL, 10),
(1, 4, 4, NULL, NULL, 6),
(1, 4, 6, NULL, NULL, 10),
(1, 4, 8, NULL, NULL, 11),
(1, 5, 6, NULL, NULL, 10),
(1, 5, 8, NULL, NULL, 11),
(1, 6, 4, NULL, NULL, 6543),
(1, 6, 8, NULL, NULL, 11),
(1, 7, 3, NULL, NULL, 10),
(1, 7, 4, NULL, NULL, 65),
(1, 7, 8, NULL, NULL, 33),
(2, 3, 1, 100, 10, 10),
(2, 4, 3, NULL, NULL, 10),
(2, 4, 4, NULL, NULL, 54),
(2, 4, 8, NULL, NULL, 11),
(2, 5, 8, NULL, NULL, 11),
(2, 6, 4, NULL, NULL, 654),
(2, 6, 8, NULL, NULL, 11),
(2, 7, 3, NULL, NULL, 10),
(2, 7, 4, NULL, NULL, 76),
(2, 7, 8, NULL, NULL, 33),
(3, 4, 3, NULL, NULL, 10),
(3, 4, 4, NULL, NULL, 532),
(3, 4, 6, NULL, NULL, 10),
(3, 4, 8, NULL, NULL, 11),
(3, 5, 6, NULL, NULL, 10),
(3, 5, 8, NULL, NULL, 11),
(3, 6, 4, NULL, NULL, 2),
(3, 6, 8, NULL, NULL, 11),
(3, 7, 3, NULL, NULL, 10),
(3, 7, 4, NULL, NULL, 5),
(3, 7, 8, NULL, NULL, 33),
(5, 4, 4, NULL, NULL, 65),
(5, 4, 8, NULL, NULL, 11),
(5, 5, 8, NULL, NULL, 11),
(5, 6, 4, NULL, NULL, 49),
(5, 6, 8, NULL, NULL, 11),
(5, 7, 4, NULL, NULL, 65),
(5, 7, 8, NULL, NULL, 33),
(7, 4, 4, NULL, NULL, 65),
(7, 4, 8, NULL, NULL, 3),
(7, 5, 8, NULL, NULL, 5),
(7, 6, 4, NULL, NULL, 65),
(7, 6, 8, NULL, NULL, 2),
(7, 7, 4, NULL, NULL, 654),
(7, 7, 8, NULL, NULL, 10),
(9, 4, 4, NULL, NULL, 65),
(9, 4, 8, NULL, NULL, 11),
(9, 5, 8, NULL, NULL, 11),
(9, 6, 4, NULL, NULL, 65),
(9, 6, 8, NULL, NULL, 11),
(9, 7, 4, NULL, NULL, 65),
(9, 7, 8, NULL, NULL, 33),
(10, 4, 4, NULL, NULL, 11),
(10, 4, 8, NULL, NULL, 11),
(10, 5, 8, NULL, NULL, 11),
(10, 6, 4, NULL, NULL, 11),
(10, 6, 8, NULL, NULL, 11),
(10, 7, 4, NULL, NULL, 111),
(10, 7, 8, NULL, NULL, 33),
(11, 4, 4, NULL, NULL, 65),
(11, 4, 8, NULL, NULL, 11),
(11, 5, 8, NULL, NULL, 11),
(11, 6, 4, NULL, NULL, 65),
(11, 6, 8, NULL, NULL, 11),
(11, 7, 4, NULL, NULL, 6565),
(11, 7, 8, NULL, NULL, 33),
(15, 4, 27, NULL, NULL, 10),
(15, 16, 26, NULL, NULL, 10),
(15, 20, 26, NULL, NULL, 20),
(16, 4, 27, NULL, NULL, 10),
(16, 16, 26, NULL, NULL, 10),
(16, 20, 26, NULL, NULL, 20);

-- --------------------------------------------------------

--
-- Structure de la table `widercash_item`
--

DROP TABLE IF EXISTS `widercash_item`;
CREATE TABLE IF NOT EXISTS `widercash_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_item`
--

INSERT INTO `widercash_item` (`id`, `name`, `description`) VALUES
(1, 'wider cash benefits item 1', ''),
(2, 'wider cash benefits item 2', ''),
(3, 'wider cahs custom item', ''),
(4, 'WCB', ''),
(6, 'vfjbkdcn fbioe', ''),
(8, 'bvefhcdbkjsnl,', ''),
(9, 'WCB', ''),
(10, 'WCB 1', ''),
(11, 'WCB 2', ''),
(12, 'wcb', ''),
(14, 'Polution', ''),
(15, 'wider', ''),
(16, 'Carbon savings', ''),
(17, 'Carbon savings', ''),
(18, 'Carbon savings', ''),
(19, 'Reduction of cabling Maintenance', ''),
(20, 'Crime reduction & prevention', ''),
(21, 'Carbon savings', ''),
(22, 'Improved security surveillance system', ''),
(23, 'Reduction of flood cost', ''),
(24, 'Reduces number of traffic accidents', ''),
(25, 'Reduction in congestion time due to traffic monitoring', '');

-- --------------------------------------------------------

--
-- Structure de la table `widercash_item_advice`
--

DROP TABLE IF EXISTS `widercash_item_advice`;
CREATE TABLE IF NOT EXISTS `widercash_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `unit_cost` double DEFAULT NULL,
  `range_min_red_nb` double DEFAULT NULL,
  `range_max_red_nb` double DEFAULT NULL,
  `range_min_red_cost` double DEFAULT NULL,
  `range_max_red_cost` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_item_advice`
--

INSERT INTO `widercash_item_advice` (`id`, `unit`, `source`, `unit_cost`, `range_min_red_nb`, `range_max_red_nb`, `range_min_red_cost`, `range_max_red_cost`) VALUES
(1, 'per example', NULL, 2, 3, 4, 5, 6),
(2, 'per example', NULL, 4, 5, 6, 7, 8),
(6, 'thgfd', '', 0, 5, 45, 5, 45),
(7, 'GEFRD', '', 4, 5, 6, 7, 8),
(8, 'GRTFED', 'GTRFE', 5, 4, 3, 42, 2),
(16, 'Per Ton of carbon', 'https://www.surrey.ca/city-services/4614.aspx', 16, 20, 40, 0, 0),
(17, 'Per Ton of carbon', 'https://www.citintelly.com/intelligent-street-lighting-products/street-lighting-control-system/', 16, 20, 60, 0, 0),
(18, 'Per Ton of carbon', 'https://www.smallbizdaily.com/4-ways-ev-charging-stations-can-benefit-business/\n', 16, 85, 100, 0, 0),
(19, 'Per cabling system', 'https://reneweconomy.com.au/hidden-cost-of-rooftop-solar-who-should-pay-for-maintenance-99200/\n', 8, 10, 30, 0, 0),
(20, 'Per crime (property, persons) ', 'https://reolink.com/pros-cons-of-surveillance-cameras-in-public-places/', 4800, 10, 30, 0, 0),
(21, 'Per Ton of carbon', 'https://www.epa.gov/air-research/deliberating-performance-targets-air-quality-sensors-workshop\n', 16, 20, 40, 0, 0),
(22, 'Per safety investigation', 'https://www.oti.fi/en/oti/investigation-of-road-accidents/', 2415, 40, 60, 0, 0),
(23, 'Per claimed inhabitant', 'http://www.libelium.com/smart_water_wsn_flood_detection/', 1310, 10, 20, 0, 0),
(24, 'Per accident', 'https://www.researchgate.net/publication/12411590_Traffic_accident_reduction_by_monitoring_driver_behaviour_with_in-car_data_recorders', 14374, 10, 20, 0, 0),
(25, 'Number of hours lost', 'https://reolink.com/pros-cons-of-surveillance-cameras-in-public-places/', 8, 20, 50, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `widercash_item_user`
--

DROP TABLE IF EXISTS `widercash_item_user`;
CREATE TABLE IF NOT EXISTS `widercash_item_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proj` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_item_user`
--

INSERT INTO `widercash_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(8, 4),
(9, 8),
(10, 8),
(11, 8),
(12, 21),
(15, 21),
(13, 23),
(14, 23);

-- --------------------------------------------------------

--
-- Structure de la table `widercash_uc`
--

DROP TABLE IF EXISTS `widercash_uc`;
CREATE TABLE IF NOT EXISTS `widercash_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_uc`
--

INSERT INTO `widercash_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(4, 2),
(5, 2),
(6, 2),
(3, 3),
(13, 3),
(14, 3),
(7, 5),
(8, 7),
(12, 9),
(9, 11),
(10, 11),
(11, 11),
(15, 11),
(16, 14),
(17, 15),
(18, 17),
(19, 18),
(20, 19),
(21, 22),
(22, 23),
(23, 24),
(24, 26),
(25, 26);

-- --------------------------------------------------------

--
-- Structure de la table `zone`
--

DROP TABLE IF EXISTS `zone`;
CREATE TABLE IF NOT EXISTS `zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `id_zone` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_zone` (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `zone`
--

INSERT INTO `zone` (`id`, `name`, `type`, `id_zone`) VALUES
(9, 'Montreal ', 'City', 0),
(10, 'Ville-Marie', 'quartier', 9),
(11, 'Rosemont', 'quartier', 9),
(12, 'Villeret', 'quartier', 9),
(13, 'Montroyal', 'quartier', 9),
(15, 'Saint-Laurent', 'quartier', 9),
(16, 'Mercier', 'quartier', 9),
(17, 'Jean-Drapeau', 'Parc', 10),
(19, 'Robert Bourassa', 'Artère ', 10),
(20, 'Maisonneuve', 'Parc ', 11),
(21, 'Saint-Michel', 'Complexe environnemental ', 12),
(22, 'Cavendish-Toupin', 'Artère ', 15);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
