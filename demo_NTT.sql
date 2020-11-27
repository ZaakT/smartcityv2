-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 27 nov. 2020 à 16:20
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_capex` (IN `capex_name` VARCHAR(255), IN `capex_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `origine` VARCHAR(255), IN `side` VARCHAR(255), IN `cat` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO capex_item (name,description, origine, side, cat)
                                    VALUES (capex_name,capex_desc, origine, side, cat);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO capex_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO capex_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_cashreleasing`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_cashreleasing` (IN `cashreleasing_name` VARCHAR(255), IN `cashreleasing_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `cat` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO cashreleasing_item (name,description, cat)
                                    VALUES (cashreleasing_name,cashreleasing_desc, cat);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO cashreleasing_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO cashreleasing_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_implem` (IN `implem_name` VARCHAR(255), IN `implem_desc` VARCHAR(255), IN `idUC` INT, IN `unit` VARCHAR(255), IN `source` VARCHAR(255), IN `range_min` INT, IN `range_max` INT, IN `cat` INT, IN `default_cost` VARCHAR(255))  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO implem_item (name,description,cat)
                                            VALUES (implem_name,implem_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO implem_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO implem_item_advice (id,unit,source,range_min,range_max, default_cost)
                                            VALUES (itemID,unit,source,range_min,range_max, default_cost);
                                    END$$

DROP PROCEDURE IF EXISTS `add_noncash`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_noncash` (IN `noncash_name` VARCHAR(255), IN `noncash_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `cat` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO noncash_item (name,description, cat)
                                    VALUES (noncash_name,noncash_desc, cat);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO noncash_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO noncash_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_opex`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_opex` (IN `opex_name` VARCHAR(255), IN `opex_desc` VARCHAR(255), IN `idUC` INT, IN `unit` VARCHAR(255), IN `source` VARCHAR(255), IN `range_min` INT, IN `range_max` INT, IN `cat` INT, IN `default_cost` VARCHAR(255))  BEGIN
                                        DECLARE itemID INT;
                                        INSERT INTO opex_item (name,description,cat)
                                            VALUES (opex_name,opex_desc,cat);
                                        SET itemID = LAST_INSERT_ID();
                                        INSERT INTO opex_uc (id_item,id_uc)
                                            VALUES (itemID,idUC);
                                        INSERT INTO opex_item_advice (id,unit,source,range_min,range_max, default_cost)
                                            VALUES (itemID,unit,source,range_min,range_max, default_cost);
                                    END$$

DROP PROCEDURE IF EXISTS `add_quantifiable`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_quantifiable` (IN `quantifiable_name` VARCHAR(255), IN `quantifiable_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `cat` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO quantifiable_item (name,description, cat)
                                    VALUES (quantifiable_name,quantifiable_desc, cat);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO quantifiable_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO quantifiable_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_revenues`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_revenues` (IN `revenues_name` VARCHAR(255), IN `revenues_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `cat` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO revenues_item (name,description, cat)
                                    VALUES (revenues_name,revenues_desc, cat);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO revenues_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO revenues_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_revenuesprotection`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_revenuesprotection` (IN `revenuesprotection_name` VARCHAR(255), IN `revenuesprotection_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `cat` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO revenuesprotection_item (name,description, cat)
                                    VALUES (revenuesprotection_name,revenuesprotection_desc, cat);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO revenuesprotection_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO revenuesprotection_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_risk`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_risk` (IN `risk_name` VARCHAR(255), IN `risk_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `cat` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO risk_item (name,description, cat)
                                    VALUES (risk_name,risk_desc, cat);
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_supplier_revenue` (IN `revenue_name` VARCHAR(255), IN `revenue_desc` VARCHAR(255), IN `idUC` INT, IN `type_value` VARCHAR(255), IN `cat` INT, IN `default_rev` FLOAT)  BEGIN
                                    DECLARE itemID INT;
                                    INSERT INTO supplier_revenues_item (name,description, type, advice_user,cat,default_rev)
                                        VALUES (revenue_name,revenue_desc, type_value, "advice",cat,default_rev);
                                    SET itemID = LAST_INSERT_ID();
                                    INSERT INTO supplier_revenues_uc (id_revenue,id_uc)
                                        VALUES (itemID,idUC);
                                END$$

DROP PROCEDURE IF EXISTS `add_widercash`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_widercash` (IN `widercash_name` VARCHAR(255), IN `widercash_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `cat` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO widercash_item (name,description, cat)
                                    VALUES (widercash_name,widercash_desc, cat);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO widercash_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO widercash_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `copy_xpex_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `copy_xpex_user` (IN `name` VARCHAR(255), IN `description` VARCHAR(255), IN `cat` VARCHAR(255), IN `id_proj` VARCHAR(255), IN `id_uc` VARCHAR(255), IN `unit_indicator` VARCHAR(255), IN `volume` VARCHAR(255), IN `volume_reduc` VARCHAR(255), IN `annual_var_volume` VARCHAR(255))  BEGIN
            DECLARE itemID INT;
            INSERT INTO quantifiable_item (name,description,cat)
                VALUES (name,description,cat);
            SET itemID = LAST_INSERT_ID();
            INSERT INTO quantifiable_item_user (id,id_proj)
                VALUES (itemID,id_proj);
            INSERT INTO input_quantifiable (id_item,id_proj,id_uc,unit_indicator,volume,volume_reduc,annual_var_volume)
                VALUES (itemID,id_proj,id_uc,unit_indicator,volume,volume_reduc,annual_var_volume);  
            INSERT INTO quantifiable_uc (id_item,id_uc)
                VALUES (itemID,id_uc);
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
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_item`
--

INSERT INTO `capex_item` (`id`, `name`, `description`, `origine`, `side`, `unit`, `cat`) VALUES
(2, 'capexitem1', '', 'from_ntt', 'projDev', NULL, 0),
(3, 'capexitem2', '', 'from_ntt', 'projDev', NULL, 0),
(4, 'Capex name delibererement long 1', '', 'from_ntt', 'projDev', NULL, 0),
(5, 'Capex name delibererement long 2', '', 'from_ntt', 'projDev', NULL, 0),
(13, 'custom capex item', 'descr', 'from_ntt', 'projDev', NULL, 0),
(15, '5G capex item', '', 'from_ntt', 'projDev', NULL, 0),
(17, '_-fghçjiopk', '', 'from_ntt', 'projDev', NULL, 0),
(19, 'test', '', 'from_ntt', 'projDev', NULL, 0),
(21, 'Custom', '', 'from_ntt', 'projDev', NULL, 0),
(22, 'cap', '', 'from_ntt', 'projDev', NULL, 0),
(25, 'euh', '', 'from_ntt', 'projDev', NULL, 0),
(26, 'Water Sensor', '', 'from_ntt', 'projDev', NULL, 0),
(27, 'Strange Sensor', '', 'from_outside_ntt', 'projDev', NULL, 0),
(28, 'LED type 2', '', 'from_outside_ntt', 'projDev', NULL, 0),
(29, 'capex general test', '', 'from_ntt', 'projDev', NULL, 0),
(30, 'capex common test ', '', 'from_ntt', 'projDev', NULL, 0),
(31, 'Capex 1', 'description', 'from_ntt', 'projDev', NULL, 0),
(32, 'Capex Common', '', 'from_ntt', 'projDev', NULL, 0),
(33, 'test', '', 'from_ntt', 'projDev', NULL, 0),
(34, 'capex test', '', 'from_ntt', 'projDev', NULL, 0),
(36, 'capex test 2', '', 'from_ntt', 'projDev', NULL, 0),
(37, 'Capex 1 supp', '', 'from_ntt', 'supplier', 'test2', 0),
(38, 'capex 2', '', 'from_ntt', 'supplier', 'test', 0),
(39, 'Cables', '', 'from_outside_ntt', 'customer', NULL, 0),
(40, 'A', 'B', 'from_ntt', 'customer', NULL, 0),
(41, 'capex test 1', '', 'from_ntt', 'customer', NULL, 0),
(42, 'hjhjhj', '', 'from_ntt', 'projDev', NULL, 0),
(44, 'myCap 2', '', 'from_ntt', 'customer', NULL, 0),
(45, 'my 1st cap', '', 'from_ntt', 'supplier', 'unit', 0),
(46, 'cap', '', 'from_ntt', 'supplier', '', 0),
(47, 'Remote control Software', 'A web hosted control system which provides monitoring, switching and dimming control. ', 'from_ntt', 'projDev', '', 0),
(48, 'Pole', 'Upgrade / replacement of the pole to enable use cases deployment', 'from_ntt', 'projDev', NULL, 0),
(49, 'Smart Lampost', 'Implementaion of multi applications smart lamppost', 'from_ntt', 'projDev', NULL, 0),
(50, 'LED street light', 'Light-emitting diode is an electronic device that gives off light when it receives an electrical current (90W-100W).\n', 'from_ntt', 'projDev', NULL, 0),
(51, 'Electrical systems', 'Service cabinets, covering energy supply and metering facilities.', 'from_ntt', 'projDev', NULL, 0),
(52, 'Remote control Software', 'A web hosted control system which provides monitoring, switching and dimming control. ', 'from_ntt', 'projDev', NULL, 0),
(53, 'Street lighting control boxes', 'which can be mounted on electric lamp post\n', 'from_ntt', 'projDev', NULL, 0),
(54, 'Box Gateway', 'It is used to receive information from wireless parking lot sensor and transmit this information to user system', 'from_ntt', 'projDev', NULL, 0),
(55, 'EVSE charger ', 'Hardware and electrical integrations to the power grid.', 'from_ntt', 'projDev', NULL, 0),
(56, 'Charging Connector ', 'Connectors and plug in for cars', 'from_ntt', 'projDev', 'my Unit', 0),
(57, 'Photovoltaic Solar Panel', 'A photovoltaic (PV) cell, commonly called a solar cell, is a non-mechanical device that converts sunlight directly into electricity.', 'from_ntt', 'projDev', NULL, 0),
(58, 'Intelligent remote control', 'Smart Devices solutions allows to do a remote control', 'from_ntt', 'projDev', NULL, 0),
(59, 'Battery', 'The device stores energy for supplying to electrical appliances when there is a demand. ', 'from_ntt', 'projDev', NULL, 0),
(60, 'Battery', 'The device stores energy for supplying to electrical appliances when there is a demand. ', 'from_ntt', 'projDev', NULL, 0),
(61, 'Remote telemetry system', 'An automated communications process by which measurements and other data are collected at remote or inaccessible points and transmitted to receiving equipment for monitoring.\n', 'from_ntt', 'projDev', NULL, 0),
(62, 'Remote CCTV', 'A low-light camera with Wi-Fi connectivity, 3G/4G connectivity', 'from_ntt', 'projDev', NULL, 0),
(63, 'DVR (Digital Video Recorder)', 'Network Video Recorder (NVR) - NVRs are responsible for video monitoring, event management, and storage.  ', 'from_ntt', 'projDev', NULL, 0),
(64, 'Monitor/screens', 'Accessories, options include screens. ', 'from_ntt', 'projDev', NULL, 0),
(65, 'Code Blue IP', 'IP 1500 VoIp / 2500 VoIp / 5000 VoIp speakerphones ', 'from_ntt', 'projDev', NULL, 0),
(66, 'Wireless Concealed Placement Speaker ', 'Public Alerts posts and Info Concealed placement speaker (CPS).', 'from_ntt', 'projDev', NULL, 0),
(67, 'Air Quality Sensor ', 'It measures and find dust particles in the air.\n', 'from_ntt', 'projDev', 'my unit', 0),
(68, 'Software tool', 'Shows the measures and collects data. Data is accessible in real time and measurements can be consulted remotely.', 'from_ntt', 'projDev', NULL, 0),
(69, 'Noise level sensor', 'The microphone is based on the LM386 amplifier and an electret microphone', 'from_ntt', 'projDev', NULL, 0),
(70, 'Software tool', 'Shows the measures and collects data. Data is accessible in real time and measurements can be consulted remotely.', 'from_ntt', 'projDev', NULL, 0),
(71, 'Water level sensor ', 'Measures water table levels in the base of a typical lamp post.', 'from_ntt', 'projDev', NULL, 0),
(72, 'Software tool', 'Shows the measures and collects data. Data is accessible in real time and measurements can be consulted remotely.', 'from_ntt', 'projDev', NULL, 0),
(73, 'Lamp post advertising light box', 'Scrolling light boxes, double sided, or rectangular, LED', 'from_ntt', 'projDev', NULL, 0),
(74, 'PIR (passive infrared) Sensor', 'Passive sensors do not transmit energy; rather, they detect the energy that is emitted or reflected from vehicles, road surfaces, and humans and other objects in the field of view and from the atmosphere', 'from_ntt', 'projDev', NULL, 0),
(75, 'Software tool', 'A web hosted control system which provides monitoring, switching and dimming control. ', 'from_ntt', 'projDev', NULL, 0),
(76, 'Surface-mounted Smart Parking Sensor', 'A wireless Smart Parking Sigfox sensor that enables you to monitor parking spots or any reserved areas occupancy.', 'from_ntt', 'projDev', NULL, 0),
(77, 'Wireless Data Collector/Gateway', 'It is used to receive information from wireless parking lot sensor and transmit this information to user system', 'from_ntt', 'projDev', NULL, 0),
(78, 'Local parking guidance system ', 'Outdoor parking guidance monitors ', 'from_ntt', 'projDev', NULL, 0),
(79, 'Wifi antenna', 'Wifi antenna attached to a street light box', 'from_ntt', 'projDev', NULL, 0),
(80, 'Antennas (Distributed Antenna System)', 'Wireless communication system ', 'from_ntt', 'projDev', NULL, 0),
(81, '5G antenna', 'Cells to efficiently deliver high speed mobile broadband and other low latency applications.', 'from_ntt', 'projDev', NULL, 0),
(83, 'cap', '', 'from_ntt', 'supplier', 'ha', 0),
(84, 'tsq', '', 'from_ntt', 'customer', '', 0),
(85, 'myCap02', '', 'from_ntt', 'customer', 'bonjour', 0),
(86, 'My Cap in Cat 2', '', 'from_ntt', 'customer', NULL, 0),
(88, 'cap cat1', '', 'from_ntt', 'customer', NULL, 5),
(89, 'cap cat 1 pour de vrai', '', 'from_ntt', 'customer', NULL, 4),
(90, '011', '', 'from_ntt', 'customer', NULL, 7),
(91, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(92, 'test 3', '', 'from_ntt', 'customer', NULL, 8),
(93, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(94, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(97, 'tsq', '', 'from_ntt', 'customer', '', 0),
(98, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(99, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(100, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(101, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(103, 'tsq', '', 'from_ntt', 'customer', '', 0),
(104, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(105, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(106, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(107, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(109, 'tsq', '', 'from_ntt', 'customer', '', 0),
(110, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(111, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(112, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(113, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(115, 'tsq', '', 'from_ntt', 'customer', '', 0),
(116, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(117, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(118, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(120, 'tsq', '', 'from_ntt', 'customer', '', 0),
(121, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(122, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(123, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(125, 'tsq', '', 'from_ntt', 'customer', '', 0),
(126, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(127, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(128, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(130, 'tsq', '', 'from_ntt', 'customer', '', 0),
(131, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(132, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(133, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(135, 'tsq', '', 'from_ntt', 'customer', '', 0),
(136, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(137, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(138, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(140, 'tsq', '', 'from_ntt', 'customer', '', 0),
(141, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(142, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(143, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(145, 'tsq', '', 'from_ntt', 'customer', '', 0),
(146, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(147, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(148, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(150, 'tsq', '', 'from_ntt', 'customer', '', 0),
(151, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(152, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(153, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(156, 'tsq', '', 'from_ntt', 'customer', '', 0),
(157, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(158, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(159, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(161, 'Admin Capex', '', 'from_ntt', 'projDev', 'test', 39),
(163, 'Sensor 1', '', 'from_outside_ntt', 'supplier', '#', 49),
(164, 'test admin', '', 'from_ntt', 'projDev', 'test', 52),
(165, 'Router A', '', 'from_outside_ntt', 'supplier', '#', 0),
(166, 'Sensor 1', '', 'from_outside_ntt', 'supplier', '#', 0),
(167, 'Router A', '', 'from_outside_ntt', 'supplier', '#', 0),
(168, 'Sensor 1', '', 'from_outside_ntt', 'supplier', '#', 0),
(169, 'Router A', '', 'from_outside_ntt', 'supplier', '#', 0),
(170, 'Sensor 1', '', 'from_outside_ntt', 'supplier', '#', 0),
(171, 'Router A', '', 'from_outside_ntt', 'supplier', '#', 0),
(172, 'Sensor 1', '', 'from_outside_ntt', 'supplier', '#', 0),
(174, 'Sensor 1', '', 'from_outside_ntt', 'supplier', '#', 49),
(176, 'Sensor 1', '', 'from_outside_ntt', 'supplier', '#', 49),
(177, 'tsq', '', 'from_ntt', 'customer', '', 0),
(178, 'test 2', '', 'from_ntt', 'customer', 'my Unit', 8),
(179, 'my cap', '', 'from_ntt', 'supplier', 'number', 6),
(180, 'new item', '', 'from_outside_ntt', 'supplier', 'number', 6),
(183, 'test default cost', '', 'from_ntt', 'projDev', NULL, 39),
(184, 'test admin default cost', '', 'from_ntt', 'projDev', NULL, 7),
(185, 'admin test 2', '', 'from_ntt', 'projDev', '', 2);

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
  `default_cost` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_item_advice`
--

INSERT INTO `capex_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`, `default_cost`) VALUES
(2, 'percapexitem1', NULL, 0, 100, 0),
(3, 'per capexitem2', NULL, 0, 100, 0),
(4, 'per example', NULL, 5, 10, 0),
(5, 'per example', NULL, 7, 100, 0),
(12, '', '', 1, 56, 0),
(14, 'ver', 'vr', 3, 43, 0),
(16, '', '', 54, 54, 0),
(48, 'Per Steel Pole', 'https://www.alibaba.com/product-detail/XINTONG-6m-8-meter-height-street_60763795461.html?spm=a2700.7724857.normalList.20.1d3914e72DnSRo&s=p', 140, 530, 0),
(49, 'Per Smart Lampost', 'https://www.euractiv.com/section/digital/news/european-cities-want-10-million-smart-streetlamps/', 2, 6, 0),
(50, 'Per LED bulb', 'https://i-solar-street-light.en.made-in-china.com/product/djxmEvMVXIWL/China-Isolar-60W-8m-Battery-Hanging-Outdoor-Lighting-Solar-LED-Street-Light.html', 50, 150, 0),
(51, 'Per streetlight cable system', 'https://www.made-in-china.com/productdirectory.do?word=led+street+light+transformer&subaction=hunt&style=b&mode=and&code=0&comProvince=nolimit&order=0&isOpenCorrection=1', 10, 30, 0),
(52, 'Per remote control device', 'https://www.telensa.com/applications#street_lighting\n', 10, 15, 0),
(53, 'Per sensor', 'https://www.meterboxesdirect.co.uk/electric-meter-pole-top-box-360-252-140-mm.html\n', 40, 100, 0),
(54, 'Per Data collector', 'https://buy.advantech.eu/Buy-Online/bymodel-UTX-3117.htm', 280, 400, 0),
(55, 'Per charger', ' https://www.amazon.com/dp/B01NCEIG1F/ref=sspa_dk_detail_3?psc=1&pd_rd_i=B01NCEIG1F\n', 465, 600, 0),
(56, 'Per connector', 'https://www.amazon.fr/dp/B00YT75GWW/ref=dp_cerb_1\n', 150, 200, 0),
(57, 'Per PV panel', 'https://www.alibaba.com/product-detail/Cheap-price-direct-from-factory-all_60603459369.html?spm=a2700.7724857.normalList.113.21262cd34L6WIS', 70, 150, 0),
(58, 'Per remote control', 'https://www.amazon.co.uk/TOP-MAX-Wireless-Compatible-Control-Anywhere/dp/B077YF8LV6/ref=pd_day0_hl_107_23?_encoding=UTF8&pd_rd_i=B077YF8LV6&pd_rd_r=0fac8156-1a50-11e9-bd3a-1b03e59c87b4&pd_rd_w=aAYT7&pd_rd_wg=ep0A4&pf_rd_p=b082d07b-aaea-4f40-9ff3-d27463f74', 190, 210, 0),
(59, 'Per battery', 'https://www.alibaba.com/product-detail/1kw-2kw-3kw-4kw-5kw-10kw_919057641.html?spm=a2700.7724838.2017005.6.6c254b77FmCO3R\n', 100, 400, 0),
(60, 'Per battery', 'https://www.alibaba.com/product-detail/1kw-2kw-3kw-4kw-5kw-10kw_919057641.html?spm=a2700.7724838.2017005.6.6c254b77FmCO3R\n', 100, 400, 0),
(61, 'Per telemetry system', 'https://www.amazon.co.uk/TOP-MAX-Wireless-Compatible-Control-Anywhere/dp/B077YF8LV6/ref=pd_day0_hl_107_23?_encoding=UTF8&pd_rd_i=B077YF8LV6&pd_rd_r=0fac8156-1a50-11e9-bd3a-1b03e59c87b4&pd_rd_w=aAYT7&pd_rd_wg=ep0A4&pf_rd_p=b082d07b-aaea-4f40-9ff3-d27463f74', 190, 210, 0),
(62, 'Per CCTV', 'https://wardmay-cctv.en.made-in-china.com/product/vCRJeUoPnLhy/China-1080P-4X-10X-Optical-Zoom-Outdoor-Bullet-Waterproof-IP-PTZ-Security-Camera.html', 90, 350, 0),
(63, 'Per recorder', 'https://www.security-camera-warehouse.com/the-admiral-4-channel-nvr-adm4p4.php', 150, 380, 0),
(64, 'Per monitor', 'https://www.ebay.co.uk/itm/Hanns-G-18-5-inch-Flat-Screen-Professional-Monitor-LED-LCD-PC-CCTV-Display-UK/291391010247?epid=1188645162&hash=item43d841f5c7:g:tTIAAOSwpDdU7O0K', 100, 140, 0),
(65, 'Per VoIP speakerphone ', 'https://www.commgear.com/security-systems/emergency-telephones/code-blue-ip5000-voip-speakerphone-upgrade-from-one-button-to-two-button-with-keypad.html', 300, 2, 0),
(66, 'Per concealed loudspeakers', 'https://www.amazon.com/Acoustic-Research-Outdoor-Wireless-AW826/dp/B003EV6OTS', 80, 230, 0),
(67, 'Per sensor', 'https://www.wunderground.com/cat6/purple-airs-250-air-pollution-monitor-gives-government-equipment-run-money\n', 200, 310, 0),
(68, 'Per software', 'https://www.fr.paessler.com/prtg?utm_source=google&utm_medium=cpc&utm_campaign=ROW_FR_Search-nonBrand_broad_2&utm_adgroup=networking-softwares&utm_adnum=171032094950&utm_keyword=%2Bnetworking%20%2Bsoftwares&utm_device=c&utm_position=1t1&utm_campaignid=367', 10, 25, 0),
(69, 'Per sensor', 'https://www.reichelt.com/fr/fr/arduino-capteur-sonore-grove-grv-sound-sens-p191177.html?PROVID=2788&gclid=EAIaIQobChMI2vqCw_q14AIVE_hRCh1aiQaBEAQYBiABEgJu5fD_BwE&&r=1', 5, 10, 0),
(70, 'Per software', 'https://www.fr.paessler.com/prtg?utm_source=google&utm_medium=cpc&utm_campaign=ROW_FR_Search-nonBrand_broad_2&utm_adgroup=networking-softwares&utm_adnum=171032094950&utm_keyword=%2Bnetworking%20%2Bsoftwares&utm_device=c&utm_position=1t1&utm_campaignid=367', 10, 25, 0),
(71, 'Per sensor', 'https://www.alibaba.com/product-detail/IP68-water-level-sensor_60701581079.html?spm=a2700.7724857.normalList.21.40be13e4NmLJJf&s=p', 30, 80, 0),
(72, 'Per software', 'https://www.fr.paessler.com/prtg?utm_source=google&utm_medium=cpc&utm_campaign=ROW_FR_Search-nonBrand_broad_2&utm_adgroup=networking-softwares&utm_adnum=171032094950&utm_keyword=%2Bnetworking%20%2Bsoftwares&utm_device=c&utm_position=1t1&utm_campaignid=367', 10, 25, 0),
(73, 'Per light box', 'https://www.alibaba.com/product-detail/Outdoor-street-LED-middle-lamp-post_60549918471.html?spm=a2700.7724857.normalList.138.45f7f5c74p8TiE', 350, 620, 0),
(74, 'Per sensor', 'https://www.englishlampposts.co.uk/garden-lamp-posts-pir', 15, 25, 0),
(75, 'Per software', 'http://qulon.pro\n', 25, 85, 0),
(76, 'Per sensor', 'https://www.alibaba.com/product-detail/IoT-Smart-Parking-sensor-SGM-201_50041290513.html?spm=a2700.7724838.2017115.338.2b876201jEvMqY', 60, 115, 0),
(77, 'Per gateway', 'https://buy.advantech.eu/Buy-Online/bymodel-UTX-3117.htm', 280, 400, 0),
(78, 'Per monitor', 'https://www.alibaba.com/product-detail/customized-7-segment-elevator-display-variable_1318854093.html?spm=a2700.7724838.2017115.151.ea412e94Sw6kMk', 20, 60, 0),
(79, 'Per antenna', 'https://www.alibaba.com/product-detail/All-in-one-body-led-street_60858254472.html?spm=a2700.galleryofferlist.normalList.187.77646241mK7Kzj', 15, 50, 0),
(80, 'Per antenna', 'http://www.l-com.com/wireless-antenna-24-ghz-6-dbi-omnidirectional-antenna-n-female-connector', 45, 140, 0),
(81, 'Per antenna', 'https://www.alibaba.com/product-detail/Antenna-Manufacturer-5G-5-8GHz-2x15_60625518394.html?spm=a2700.7724838.2017115.353.7c277109fTWItv', 30, 60, 0),
(82, 'unnniiittt', '', 0, 10, 0),
(161, '', '', 0, 0, 0),
(164, '', '', 0, 0, 0),
(183, '', '', 0, 0, 13),
(184, '', '', 0, 0, 15),
(185, '', '', 0, 0, 156);

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
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;

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
(47, 27),
(83, 29),
(84, 30),
(85, 30),
(86, 30),
(87, 30),
(88, 30),
(89, 30),
(90, 30),
(91, 30),
(92, 30),
(93, 30),
(94, 30),
(95, 30),
(96, 30),
(182, 30),
(97, 33),
(98, 33),
(99, 33),
(100, 33),
(101, 33),
(102, 33),
(103, 34),
(104, 34),
(105, 34),
(106, 34),
(107, 34),
(108, 34),
(109, 35),
(110, 35),
(111, 35),
(112, 35),
(113, 35),
(114, 35),
(115, 36),
(116, 36),
(117, 36),
(118, 36),
(119, 36),
(120, 37),
(121, 37),
(122, 37),
(123, 37),
(124, 37),
(125, 38),
(126, 38),
(127, 38),
(128, 38),
(129, 38),
(130, 39),
(131, 39),
(132, 39),
(133, 39),
(134, 39),
(135, 40),
(136, 40),
(137, 40),
(138, 40),
(139, 40),
(155, 40),
(140, 41),
(141, 41),
(142, 41),
(143, 41),
(144, 41),
(145, 42),
(146, 42),
(147, 42),
(148, 42),
(149, 42),
(150, 43),
(151, 43),
(152, 43),
(153, 43),
(154, 43),
(156, 44),
(157, 44),
(158, 44),
(159, 44),
(160, 44),
(162, 46),
(163, 46),
(165, 48),
(166, 48),
(167, 49),
(168, 49),
(169, 50),
(170, 50),
(171, 51),
(172, 51),
(173, 52),
(174, 52),
(175, 53),
(176, 53),
(177, 54),
(178, 54),
(179, 54),
(180, 54),
(181, 54),
(186, 56);

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
(82, -1),
(83, -1),
(95, -1),
(96, -1),
(102, -1),
(108, -1),
(114, -1),
(119, -1),
(124, -1),
(129, -1),
(134, -1),
(139, -1),
(144, -1),
(149, -1),
(154, -1),
(155, -1),
(160, -1),
(162, -1),
(165, -1),
(167, -1),
(169, -1),
(171, -1),
(173, -1),
(175, -1),
(181, -1),
(182, -1),
(186, -1),
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
(81, 30),
(84, 33),
(97, 33),
(103, 33),
(109, 33),
(115, 33),
(120, 33),
(125, 33),
(130, 33),
(135, 33),
(140, 33),
(145, 33),
(150, 33),
(156, 33),
(177, 33),
(163, 41),
(164, 41),
(166, 41),
(168, 41),
(170, 41),
(172, 41),
(174, 41),
(176, 41),
(161, 48),
(183, 48),
(88, 66),
(89, 66),
(99, 66),
(105, 66),
(111, 66),
(117, 66),
(122, 66),
(127, 66),
(132, 66),
(137, 66),
(142, 66),
(147, 66),
(152, 66),
(158, 66),
(179, 66),
(85, 67),
(86, 67),
(87, 67),
(90, 67),
(91, 67),
(92, 67),
(93, 67),
(94, 67),
(98, 67),
(100, 67),
(101, 67),
(104, 67),
(106, 67),
(107, 67),
(110, 67),
(112, 67),
(113, 67),
(116, 67),
(118, 67),
(121, 67),
(123, 67),
(126, 67),
(128, 67),
(131, 67),
(133, 67),
(136, 67),
(138, 67),
(141, 67),
(143, 67),
(146, 67),
(148, 67),
(151, 67),
(153, 67),
(157, 67),
(159, 67),
(178, 67),
(180, 67),
(184, 67),
(185, 67);

-- --------------------------------------------------------

--
-- Structure de la table `cashreleasing_item`
--

DROP TABLE IF EXISTS `cashreleasing_item`;
CREATE TABLE IF NOT EXISTS `cashreleasing_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cashreleasing_item`
--

INSERT INTO `cashreleasing_item` (`id`, `name`, `description`, `cat`) VALUES
(1, 'crb1', '', 0),
(2, 'crb2', '', 0),
(3, 'cash releasing benefit item 1', '', 0),
(4, 'CRB', '', 0),
(5, 'CASHRELEASING', '', 0),
(6, 'htbg', '', 0),
(7, 'cash releasingb', '', 0),
(8, 'CRB 1', '', 0),
(9, 'CRB 2', '', 0),
(10, 'CRB 3', '', 0),
(11, 'CRB 4', '', 0),
(12, 'cash item', '', 0),
(13, 'save 1', '', 0),
(14, 'crb', '', 0),
(15, 'Reduction of Electricity costs', '', 0),
(16, 'Reduction of Electricity costs', '', 0),
(17, 'Reduction of light Maintenance costs ', '', 0),
(18, 'Reduction of Electricity costs', '', 0),
(19, 'Reduction of light Maintenance costs ', '', 0),
(20, 'Reduction of Electricity costs', '', 0),
(21, 'Reduction of Electricity costs', '', 0),
(23, 'CRB 12', '', 0),
(24, 'CRB 12', '', 0),
(25, 'CRB 12', '', 0),
(26, 'CRB 12', '', 0),
(27, 'CRB 12', '', 0),
(28, 'CRB 12', '', 0),
(29, 'CRB 12', '', 0),
(30, 'CRB 12', '', 0),
(31, 'CRB 12', '', 0),
(32, 'CRB 12', '', 0),
(33, 'CRB 12', '', 0),
(34, 'CRB 12', '', 0),
(35, 'CRB 12', '', 0),
(36, 'CRB 12', '', 0),
(37, 'itzem ', '', 55),
(38, 'fire', '', 63);

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
  `default_cost` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cashreleasing_item_advice`
--

INSERT INTO `cashreleasing_item_advice` (`id`, `unit`, `source`, `unit_cost`, `range_min_red_nb`, `range_max_red_nb`, `range_min_red_cost`, `range_max_red_cost`, `default_cost`) VALUES
(1, 'per example', NULL, 15, 1.2, 1.8, 10, 11, 0),
(2, 'per example', NULL, 1, 2, 3, 4, 5, 0),
(3, 'per example', NULL, 2, 3, 4, 5, 6, 0),
(16, 'Kwh', 'http://www.eclairageprofessionnel.fr/relamping-led-transition-energetique/', 0, 50, 70, 0, 0, 0),
(17, 'Per Light bulb', 'http://www.eclairageprofessionnel.fr/relamping-led-transition-energetique/\n', 30, 0, 0, 50, 80, 0),
(18, 'Per Kwh', 'https://www.lumenia.com/solutions/lumenia-cms-lum-central-management-system\n', 0, 15, 50, 0, 0, 0),
(19, 'Per light bulb', ' https://www.lumenia.com/solutions/lumenia-cms-lum-central-management-system\n', 30, 45, 60, 0, 0, 0),
(20, 'Per Kwh', 'https://mysolarhome.us/solar-lamp-post/', 0, 40, 60, 0, 0, 0),
(21, 'Per Kwh', 'https://ledcorporations.com/led-lighting-news/the-cost-of-electricity-how-utility-companies-are-charging-consumers/\n', 0, 40, 60, 0, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

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
(15, 27),
(22, 27),
(23, 30),
(37, 30),
(24, 33),
(25, 34),
(26, 35),
(27, 36),
(28, 37),
(29, 38),
(30, 39),
(31, 40),
(32, 41),
(33, 42),
(34, 43),
(35, 44),
(36, 54),
(38, 56);

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
(22, 16),
(20, 17),
(21, 18),
(38, 48),
(23, 67),
(24, 67),
(25, 67),
(26, 67),
(27, 67),
(28, 67),
(29, 67),
(30, 67),
(31, 67),
(32, 67),
(33, 67),
(34, 67),
(35, 67),
(36, 67),
(37, 67);

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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

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
(10, 'Criterion 1', 'bvgfd', 'Likert scale:\r\nNo improvement - 1 - 2 - 3 - 4 - 5 - Very high improvement.\r\n\r\n    1. Not at all: the access to basic health care services was not imporved.\r\n    2. Poor: there was little improvement in the accessibility of basic health care services.\r\n    3. Somewhat: access to basic health care services was imroved, including a few important amenities such as a general practitioner or a pharmaacy.\r\n    4. Good: access to a sufficien number of health care service are widely available offline an donline (i.e. repeat prescriptions) was improved.\r\n    5. Excellent: access to a wide variety of basic health care services are widely available offline and online (i.e. first aid apps) was improved.\r\n', 2),
(11, 'Improved access to basic health care services', 'The extent to which the project has increased accessibility to basic health care', '', 4),
(12, 'Encouraging a healthy lifestyle', 'The extent to which the project encourages a healthy lifestyle', '', 4),
(13, 'Waiting time', 'Percentage reduction in waiting time due to project', '', 4),
(14, 'Reduction of traffic accidents', 'Percentage reduction of transportation fatalities due to the project', '', 4),
(15, 'Reduction in crime rate', 'Percentage reduction in number of violences, annoyances and crimes due to the project', '', 4),
(16, 'Improved cybersecurity', 'The extent to which the project ensures cybersecurity', '', 4),
(17, 'Improved data privacy', 'The extent to which data collected by the project is protected', '', 4),
(18, 'Access to public transport', 'The extent to which public transport stops are available within 500m', '', 4),
(19, 'Reduction in annual final energy consumption', 'Percentage change in annual final energy consumption due to the project for all uses and forms of energy', '', 5),
(20, 'Reduction in lifcycle energy use', 'Reduction in life cycle energy use achieved by the project (%)', '', 5),
(21, 'Reduction of embodied energy of products and services used in the project', 'The extent to which measures have been taken to reduce the embodied energy of products used in the project', '', 5),
(22, 'Increase in local renewable energy production', 'Percentage increase in the share of local renewable energy due to the project', '', 5),
(23, 'Carbon dioxide emission reduction', 'Percentage reduction in direct (operational) CO2 emissions achieved by the project', '', 5),
(24, 'Increased use of local workforce', 'Share in the total project costs that has been spent on local suppliers, contractors and service providers', '', 7),
(25, 'Local job creation', 'Number of jobs created by the project', '', 7),
(26, 'Fuel poverty', 'Change in percentage points of (gross) household income spent on energy bills', '', 7),
(27, 'Costs of housing', 'The percentage of gross household income spent on housing', '', 7),
(28, 'Certified companies involved in the project', 'Share of the companies involved in the project holding an ISO 14001 certificate', '', 7),
(29, 'Leadership', 'The extent to which the leadership of the project is successful in creating support for the project', '', 8),
(30, 'Balanced project team\'', 'The extent to which the project team included all relevant experts and stakeholders from the start\'), (73, 4, \'Involvement of the city administration\', \'The extent to which the local authority is involved in the development of the project, other than financial, and how many departments are contributing', '', 8),
(31, 'Involvement of the city administration', 'The extent to which the local authority is involved in the development of the project, other than financial, and how many departments are contributing', '', 8),
(32, 'Clear division of responsibility', 'Has the responsibility for achieving the social and sustainability targets been clearly assigned to (a) specific actor(s) in the project?', '', 8),
(33, 'Social compatibility', 'The extent to which the project\\\'s solution fits with people\\\'s frame of mind and does not negatively challenge people\\\'s values or the ways they are used to do things', '', 6),
(34, 'Technical compatibility', 'The extent to which the smart city solution fits with the current existing technological standards/infrastructures', '', 6),
(35, 'Ease of use for end users of the solution', 'The extent to which the solution is perceived as difficult to understand and use for potential end-users', '', 6),
(36, 'Ease of use for professional stakeholders', 'The extent to which the innovation is perceived as difficult to understand, implement and use for professional users of the solution', '', 6),
(37, 'Trialability', 'The extent to which the solution can be experimented with on a limited basis in the local context before full implementation', '', 6),
(38, 'Advantages for end users', 'The extent to which the project offers clear advantages for end users', '', 8),
(39, 'Advantages for stakeholders', 'The extent to which the project offers clear advantages for stakeholders', '', 8),
(40, 'Visibility of Results', 'The extent to which the results of the project are visible to external actors', '', 6),
(41, 'Solution(s) to development issues', 'The extent to which the project offers a solution to problems which are common to European cities', '', 6),
(42, 'Market demand', 'The extent to which there is a general market demand for the solution', '', 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `critcat`
--

INSERT INTO `critcat` (`id`, `name`) VALUES
(8, 'Governance'),
(4, 'People'),
(5, 'Planet'),
(6, 'Propagation'),
(7, 'Prosperity');

-- --------------------------------------------------------

--
-- Structure de la table `deal_criteria_input_nogo_target`
--

DROP TABLE IF EXISTS `deal_criteria_input_nogo_target`;
CREATE TABLE IF NOT EXISTS `deal_criteria_input_nogo_target` (
  `id` int(11) NOT NULL,
  `societal_npv_nogo` int(11) DEFAULT '0',
  `societal_npv_target` int(11) DEFAULT '0',
  `societal_roi_nogo` int(11) DEFAULT '0',
  `societal_roi_target` int(11) DEFAULT '0',
  `societal_payback_nogo` int(11) DEFAULT '0',
  `societal_payback_target` int(11) DEFAULT '0',
  `npv_nogo` int(11) DEFAULT '0',
  `npv_target` int(11) DEFAULT '0',
  `roi_nogo` int(11) DEFAULT '0',
  `roi_target` int(11) DEFAULT '0',
  `payback_nogo` int(11) DEFAULT '0',
  `payback_target` int(11) DEFAULT '0',
  `risks_rating_nogo` int(11) DEFAULT '0',
  `risks_rating_target` int(11) DEFAULT '0',
  `nqbr_nogo` int(11) DEFAULT '0',
  `nqbr_target` int(11) DEFAULT '0',
  `operating_margin_nogo` int(11) DEFAULT '0',
  `operating_margin_target` int(11) DEFAULT '0',
  `checked` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `deal_criteria_input_nogo_target`
--

INSERT INTO `deal_criteria_input_nogo_target` (`id`, `societal_npv_nogo`, `societal_npv_target`, `societal_roi_nogo`, `societal_roi_target`, `societal_payback_nogo`, `societal_payback_target`, `npv_nogo`, `npv_target`, `roi_nogo`, `roi_target`, `payback_nogo`, `payback_target`, `risks_rating_nogo`, `risks_rating_target`, `nqbr_nogo`, `nqbr_target`, `operating_margin_nogo`, `operating_margin_target`, `checked`) VALUES
(3, NULL, NULL, NULL, NULL, NULL, NULL, 15, 15, 15, 15, 5, 5, NULL, NULL, NULL, NULL, 5, 5, ''),
(6, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0, 0, ''),
(8, 0, 30000, 0, 20, 40, 12, 50000, 100000, 10, 30, 36, 12, 5, 1, 3, 9, 0, 0, ''),
(21, NULL, NULL, NULL, NULL, NULL, NULL, 5000, 150000, 5, 50, 26, 5, NULL, NULL, NULL, NULL, 0, 30, ''),
(23, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 20, 24, 2, NULL, NULL, NULL, NULL, 5, 20, ''),
(30, 0, 0, 0, 0, 0, 0, 3000, 10000, 10, 70, 24, 12, 0, 0, 0, 0, 50, 80, 'npv_check-roi_check-operating_margin_check-payback_check-'),
(38, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 18, 12, NULL, NULL, NULL, NULL, 5, 25, ''),
(39, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 18, 12, NULL, NULL, NULL, NULL, 5, 25, ''),
(40, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 18, 12, NULL, NULL, NULL, NULL, 5, 25, ''),
(41, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 18, 12, NULL, NULL, NULL, NULL, 5, 25, ''),
(42, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 18, 12, NULL, NULL, NULL, NULL, 5, 25, ''),
(43, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 18, 12, NULL, NULL, NULL, NULL, 5, 25, ''),
(44, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 18, 12, NULL, NULL, NULL, NULL, 5, 25, ''),
(45, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, 2, 2, 2, 2, NULL, NULL, NULL, NULL, 2, 2, ''),
(46, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 24, 12, NULL, NULL, NULL, NULL, 0, 0, 'payback_check-'),
(50, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 24, 18, NULL, NULL, NULL, NULL, 10, 30, ''),
(51, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 24, 18, NULL, NULL, NULL, NULL, 10, 30, ''),
(52, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 24, 18, NULL, NULL, NULL, NULL, 10, 30, ''),
(53, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 24, 18, NULL, NULL, NULL, NULL, 10, 30, ''),
(54, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 18, 12, NULL, NULL, NULL, NULL, 5, 25, ''),
(56, 0, 0, 0, 0, 0, 0, 500, 1000, 5, 20, 20, 12, 0, 0, 0, 0, 10, 40, 'npv_check-roi_check-operating_margin_check-payback_check-');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `devise`
--

INSERT INTO `devise` (`id`, `name`, `symbol`, `rateToGBP`) VALUES
(1, 'GBP', '£', 1),
(2, 'USD', 'US$', 0.85105),
(3, 'EUR', '€', 0.76642),
(4, 'CAD', '$CAD', 1.73);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dlt`
--

INSERT INTO `dlt` (`id`, `name`, `description`) VALUES
(3, 'Montreal', ''),
(4, 'Greater London Authority', ''),
(5, 'Caen', '');

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
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=547 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_item`
--

INSERT INTO `implem_item` (`id`, `name`, `description`, `origine`, `side`, `unit`, `cat`) VALUES
(1, 'impitem1', '', 'from_ntt', 'projDev', NULL, 0),
(3, 'implementation item 2', 'description', 'from_ntt', 'projDev', NULL, 0),
(4, 'implementation item 2', '', 'from_ntt', 'projDev', NULL, 0),
(5, 'test imp item', '10/03 10:28', 'from_ntt', 'projDev', NULL, 0),
(6, 'IMPLEM', '', 'from_ntt', 'projDev', NULL, 0),
(8, '5G IMPLEM ITEM', '', 'from_ntt', 'projDev', NULL, 0),
(11, 'aaaa', '', 'from_ntt', 'projDev', NULL, 0),
(12, 'setup', '', 'from_outside_ntt', 'projDev', NULL, 0),
(13, 'Construction', '', 'internal', 'projDev', NULL, 0),
(14, 'Verification', '', 'from_outside_ntt', 'projDev', NULL, 0),
(15, 'Construction ', '', 'from_ntt', 'projDev', NULL, 0),
(16, 'Deployment', 'ffffffffffffffffff', 'from_outside_ntt', 'projDev', NULL, 0),
(17, 'Deployment Common test', '', 'from_outside_ntt', 'projDev', NULL, 0),
(18, 'dep test', '', 'from_outside_ntt', 'projDev', NULL, 0),
(24, 'dep 2', '', 'from_ntt', 'projDev', NULL, 0),
(25, 'dep tests', '', 'from_ntt', 'projDev', NULL, 0),
(26, 'dep 01', '', 'from_ntt', 'supplier', '', 0),
(27, 'fgh', '', 'from_ntt', 'customer', NULL, 0),
(28, 'a', '', 'from_ntt', 'customer', NULL, 0),
(29, 'xc', '', 'from_ntt', 'customer', NULL, 0),
(30, 'xcv', '', 'from_outside_ntt', 'customer', NULL, 0),
(31, 'xcvw', '', 'internal', 'customer', NULL, 0),
(32, 'Engineering', 'Engineering ars', 'from_ntt', 'supplier', NULL, 0),
(33, 'DIg a hole', '', 'from_outside_ntt', 'customer', NULL, 0),
(34, 'internal', '', 'internal', 'customer', NULL, 0),
(35, 'B', '', 'internal', 'customer', NULL, 0),
(36, 'my dep', '', 'from_ntt', 'supplier', NULL, 0),
(37, 'dep', '', 'from_ntt', 'supplier', '', 0),
(38, 'depdep', '', 'from_outside_ntt', 'customer', NULL, 0),
(39, 'dep 01 encore', '', 'from_ntt', 'customer', NULL, 0),
(40, 'Installation of the Pole', '', 'from_ntt', 'projDev', NULL, 0),
(41, 'Instllation of smart Lampost', '', 'from_ntt', 'projDev', NULL, 0),
(42, 'Upgrading of the LED lighting system', '', 'from_ntt', 'projDev', NULL, 0),
(43, 'Electrical systems', '', 'from_ntt', 'projDev', NULL, 0),
(44, 'Installation of the software', '', 'from_ntt', 'projDev', NULL, 0),
(45, 'Control boxes implementation', '', 'from_ntt', 'projDev', NULL, 0),
(46, 'Gateway implementation', '', 'from_ntt', 'projDev', NULL, 0),
(47, 'Installation of the charging point', '', 'from_ntt', 'projDev', 'my Unit', 0),
(48, 'Installation of the wall connector', '', 'from_ntt', 'projDev', NULL, 0),
(49, 'Installation of the panel', '', 'from_ntt', 'projDev', NULL, 0),
(50, 'Installation of the battery &remote control', '', 'from_ntt', 'projDev', NULL, 0),
(51, 'Installation of the battery &remote control', '', 'from_ntt', 'projDev', NULL, 0),
(52, 'Installation of the CCTV system', '', 'from_ntt', 'projDev', NULL, 0),
(53, 'Installation of the PTT', '', 'from_ntt', 'projDev', NULL, 0),
(54, 'Installation of the public speakers', '', 'from_ntt', 'projDev', NULL, 0),
(55, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL, 0),
(56, 'Software installation', '', 'from_ntt', 'projDev', NULL, 0),
(57, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL, 0),
(58, 'Software installation', '', 'from_ntt', 'projDev', NULL, 0),
(59, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL, 0),
(60, 'Software installation', '', 'from_ntt', 'projDev', NULL, 0),
(61, 'Installation of the banner', '', 'from_ntt', 'projDev', NULL, 0),
(62, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL, 0),
(63, 'Software installation', '', 'from_ntt', 'projDev', NULL, 0),
(64, 'Installation of the sensor', '', 'from_ntt', 'projDev', NULL, 0),
(65, 'Installation of the software', '', 'from_ntt', 'projDev', NULL, 0),
(66, 'Installation of the local parking guidance system ', '', 'from_ntt', 'projDev', NULL, 0),
(67, 'Installation of the antenna', '', 'from_ntt', 'projDev', NULL, 0),
(68, 'Installation of the antenna', '', 'from_ntt', 'projDev', NULL, 0),
(69, 'Installation of the antenna', '', 'from_ntt', 'projDev', NULL, 0),
(70, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(72, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(74, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(76, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(78, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(80, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(82, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(84, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(86, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(88, 'item 01', '', 'from_ntt', 'customer', NULL, 28),
(91, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(94, 'Sensor 1 installation', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 50),
(95, 'Installation Router', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(96, 'Sensor 1 installation', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(97, 'Installation Router', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(98, 'Sensor 1 installation', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(99, 'Installation Router', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(100, 'Sensor 1 installation', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(101, 'Installation Router', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(102, 'Sensor 1 installation', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(104, 'Sensor 1 installation', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 50),
(106, 'Sensor 1 installation', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 50),
(107, 'e', '', 'from_ntt', 'supplier', 'INstalation', 18),
(109, 'test dc', '', 'from_ntt', 'projDev', NULL, 28),
(110, 'test 2', '', 'from_ntt', 'projDev', '', 20),
(111, 'O&N - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(112, 'O&N - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(113, 'O&N - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(114, 'O&N - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(115, 'O&N - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(116, 'O&N - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(117, 'O&N - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(118, 'O&N - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(119, 'O&N - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(120, 'O&N - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(121, 'O&N - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(122, 'O&N - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(123, 'O&N - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(124, 'O&N - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(125, 'O&N - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(126, 'O&N - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(127, 'O&N - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(128, 'O&N - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(129, 'O&N - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(130, 'O&N - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(131, 'O&N - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(132, 'O&N - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(133, 'O&N - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(134, 'O&N - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(135, 'O&N - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(136, 'O&N - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(137, 'O&N - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(138, 'O&N - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(139, 'O&N - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(140, 'O&N - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(141, 'O&N - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(142, 'O&N - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(143, 'O&N - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(144, 'O&N - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(145, 'O&N - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(146, 'O&N - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(147, 'O&N - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(148, 'O&N - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(149, 'O&N - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(150, 'O&N - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(151, 'O&N - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(152, 'O&N - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(153, 'O&N - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(154, 'O&N - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(155, 'O&N - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(156, 'O&N - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(157, 'O&N - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(158, 'O&N - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(159, 'O&N - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(160, 'O&N - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(161, 'O&N - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(162, 'O&N - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(163, 'O&N - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(164, 'O&N - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(165, 'O&N - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(166, 'O&N - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(167, 'O&N - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(168, 'O&N - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(169, 'O&N - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(170, 'O&N - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(171, 'O&N - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(172, 'O&N - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(173, 'O&N - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(174, 'O&N - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(175, 'O&N - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(176, 'O&N - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(177, 'O&N - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(178, 'O&N - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(179, 'O&N - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(180, 'O&N - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(181, 'O&N - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(182, 'O&N - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(183, 'O&N - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(184, 'O&N - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(185, 'O&N - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(186, 'O&N - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(187, 'O&N - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(188, 'O&N - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(189, 'O&N - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(190, 'O&N - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(191, 'O&N - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(192, 'O&N - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(193, 'O&N - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(194, 'O&N - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(195, 'O&N - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(196, 'O&N - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(197, 'O&N - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(198, 'O&N - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(199, 'O&N - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(200, 'O&N - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(201, 'O&N - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(202, 'O&N - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(203, 'O&N - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(204, 'O&N - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(205, 'O&N - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(206, 'O&N - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(207, 'O&N - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(208, 'O&N - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(209, 'O&N - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(210, 'O&N - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(211, 'O&N - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(212, 'O&N - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(213, 'O&N - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(214, 'O&N - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(215, 'O&N - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(216, 'O&N - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(217, 'O&N - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(218, 'O&N - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(219, 'O&N - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(220, 'O&N - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(221, 'O&N - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(222, 'O&N - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(223, 'O&N - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(224, 'O&N - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(225, 'O&N - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(226, 'O&N - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(227, 'O&N - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(228, 'O&N - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(229, 'O&N - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(230, 'O&N - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(231, 'O&N - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(232, 'O&N - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(233, 'O&N - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(234, 'O&N - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(235, 'O&N - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(236, 'O&N - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(237, 'O&N - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(238, 'O&N - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(239, 'O&N - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(240, 'O&N - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(241, 'O&N - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(242, 'O&N - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(243, 'O&N - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(244, 'O&N - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(245, 'O&N - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(246, 'O&N - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(247, 'O&N - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(248, 'O&N - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(249, 'O&N - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(250, 'O&N - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(251, 'O&N - ASU Range 2001 - 2100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 171),
(252, 'O&N - ASU Range 2001 - 2100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 161),
(253, 'O&N - ASU Range 2001 - 2100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 191),
(254, 'O&N - ASU Range 2001 - 2100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 151),
(255, 'O&N - ASU Range 2001 - 2100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 201),
(256, 'O&N - ASU Range 2001 - 2100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 136),
(257, 'O&N - ASU Range 2001 - 2100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 181),
(258, 'MP - ASU Range 1 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(259, 'MP - ASU Range 1 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(260, 'MP - ASU Range 1 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(261, 'MP - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(262, 'MP - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(263, 'MP - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(264, 'MP - ASU Range 101 - 150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(265, 'MP - ASU Range 101 - 150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(266, 'MP - ASU Range 101 - 150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(267, 'MP - ASU Range 151 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(268, 'MP - ASU Range 151 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(269, 'MP - ASU Range 151 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(270, 'MP - ASU Range 201 - 250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(271, 'MP - ASU Range 201 - 250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(272, 'MP - ASU Range 201 - 250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(273, 'MP - ASU Range 251 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(274, 'MP - ASU Range 251 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(275, 'MP - ASU Range 251 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(276, 'MP - ASU Range 301 - 350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(277, 'MP - ASU Range 301 - 350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(278, 'MP - ASU Range 301 - 350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(279, 'MP - ASU Range 351 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(280, 'MP - ASU Range 351 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(281, 'MP - ASU Range 351 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(282, 'MP - ASU Range 401 - 450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(283, 'MP - ASU Range 401 - 450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(284, 'MP - ASU Range 401 - 450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(285, 'MP - ASU Range 451 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(286, 'MP - ASU Range 451 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(287, 'MP - ASU Range 451 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(288, 'MP - ASU Range 501 - 550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(289, 'MP - ASU Range 501 - 550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(290, 'MP - ASU Range 501 - 550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(291, 'MP - ASU Range 551 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(292, 'MP - ASU Range 551 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(293, 'MP - ASU Range 551 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(294, 'MP - ASU Range 601 - 650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(295, 'MP - ASU Range 601 - 650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(296, 'MP - ASU Range 601 - 650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(297, 'MP - ASU Range 651 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(298, 'MP - ASU Range 651 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(299, 'MP - ASU Range 651 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(300, 'MP - ASU Range 701 - 750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(301, 'MP - ASU Range 701 - 750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(302, 'MP - ASU Range 701 - 750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(303, 'MP - ASU Range 751 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(304, 'MP - ASU Range 751 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(305, 'MP - ASU Range 751 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(306, 'MP - ASU Range 801 - 850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(307, 'MP - ASU Range 801 - 850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(308, 'MP - ASU Range 801 - 850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(309, 'MP - ASU Range 851 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(310, 'MP - ASU Range 851 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(311, 'MP - ASU Range 851 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(312, 'MP - ASU Range 901 - 950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(313, 'MP - ASU Range 901 - 950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(314, 'MP - ASU Range 901 - 950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(315, 'MP - ASU Range 951 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(316, 'MP - ASU Range 951 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(317, 'MP - ASU Range 951 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(318, 'MP - ASU Range 1001 - 1050 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(319, 'MP - ASU Range 1001 - 1050 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(320, 'MP - ASU Range 1001 - 1050 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(321, 'MP - ASU Range 1051 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(322, 'MP - ASU Range 1051 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(323, 'MP - ASU Range 1051 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(324, 'MP - ASU Range 1101 - 1150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(325, 'MP - ASU Range 1101 - 1150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(326, 'MP - ASU Range 1101 - 1150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(327, 'MP - ASU Range 1151 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(328, 'MP - ASU Range 1151 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(329, 'MP - ASU Range 1151 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(330, 'MP - ASU Range 1201 - 1250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(331, 'MP - ASU Range 1201 - 1250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(332, 'MP - ASU Range 1201 - 1250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(333, 'MP - ASU Range 1251 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(334, 'MP - ASU Range 1251 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(335, 'MP - ASU Range 1251 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(336, 'MP - ASU Range 1301 - 1350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(337, 'MP - ASU Range 1301 - 1350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(338, 'MP - ASU Range 1301 - 1350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(339, 'MP - ASU Range 1351 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(340, 'MP - ASU Range 1351 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(341, 'MP - ASU Range 1351 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(342, 'MP - ASU Range 1401 - 1450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(343, 'MP - ASU Range 1401 - 1450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(344, 'MP - ASU Range 1401 - 1450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(345, 'MP - ASU Range 1451 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(346, 'MP - ASU Range 1451 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(347, 'MP - ASU Range 1451 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(348, 'MP - ASU Range 1501 - 1550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(349, 'MP - ASU Range 1501 - 1550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(350, 'MP - ASU Range 1501 - 1550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(351, 'MP - ASU Range 1551 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(352, 'MP - ASU Range 1551 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(353, 'MP - ASU Range 1551 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(354, 'MP - ASU Range 1601 - 1650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(355, 'MP - ASU Range 1601 - 1650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(356, 'MP - ASU Range 1601 - 1650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(357, 'MP - ASU Range 1651 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(358, 'MP - ASU Range 1651 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(359, 'MP - ASU Range 1651 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(360, 'MP - ASU Range 1701 - 1750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(361, 'MP - ASU Range 1701 - 1750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(362, 'MP - ASU Range 1701 - 1750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(363, 'MP - ASU Range 1751 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(364, 'MP - ASU Range 1751 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(365, 'MP - ASU Range 1751 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(366, 'MP - ASU Range 1801 - 1850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(367, 'MP - ASU Range 1801 - 1850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(368, 'MP - ASU Range 1801 - 1850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(369, 'MP - ASU Range 1851 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(370, 'MP - ASU Range 1851 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(371, 'MP - ASU Range 1851 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(372, 'MP - ASU Range 1901 - 1950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(373, 'MP - ASU Range 1901 - 1950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(374, 'MP - ASU Range 1901 - 1950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(375, 'MP - ASU Range 1951 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 89),
(376, 'MP - ASU Range 1951 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 99),
(377, 'MP - ASU Range 1951 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 74),
(378, 'WWD - ASU Range 3 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(379, 'WWD - ASU Range 3 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(380, 'WWD - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(381, 'WWD - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(382, 'WWD - ASU Range 101 - 150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(383, 'WWD - ASU Range 101 - 150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(384, 'WWD - ASU Range 151 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(385, 'WWD - ASU Range 151 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(386, 'WWD - ASU Range 201 - 250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(387, 'WWD - ASU Range 201 - 250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(388, 'WWD - ASU Range 251 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(389, 'WWD - ASU Range 251 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(390, 'WWD - ASU Range 301 - 350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(391, 'WWD - ASU Range 301 - 350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(392, 'WWD - ASU Range 351 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(393, 'WWD - ASU Range 351 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(394, 'WWD - ASU Range 401 - 450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(395, 'WWD - ASU Range 401 - 450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(396, 'WWD - ASU Range 451 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(397, 'WWD - ASU Range 451 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(398, 'WWD - ASU Range 501 - 550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(399, 'WWD - ASU Range 501 - 550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(400, 'WWD - ASU Range 551 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(401, 'WWD - ASU Range 551 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(402, 'WWD - ASU Range 601 - 650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(403, 'WWD - ASU Range 601 - 650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(404, 'WWD - ASU Range 651 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(405, 'WWD - ASU Range 651 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(406, 'WWD - ASU Range 701 - 750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(407, 'WWD - ASU Range 701 - 750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(408, 'WWD - ASU Range 751 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(409, 'WWD - ASU Range 751 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(410, 'WWD - ASU Range 801 - 850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(411, 'WWD - ASU Range 801 - 850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(412, 'WWD - ASU Range 851 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(413, 'WWD - ASU Range 851 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(414, 'WWD - ASU Range 901 - 950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(415, 'WWD - ASU Range 901 - 950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(416, 'WWD - ASU Range 951 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(417, 'WWD - ASU Range 951 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(418, 'WWD - ASU Range 1001 - 1050 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(419, 'WWD - ASU Range 1001 - 1050 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(420, 'WWD - ASU Range 1051 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(421, 'WWD - ASU Range 1051 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(422, 'WWD - ASU Range 1101 - 1150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(423, 'WWD - ASU Range 1101 - 1150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(424, 'WWD - ASU Range 1151 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(425, 'WWD - ASU Range 1151 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(426, 'WWD - ASU Range 1201 - 1250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(427, 'WWD - ASU Range 1201 - 1250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(428, 'WWD - ASU Range 1251 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(429, 'WWD - ASU Range 1251 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(430, 'WWD - ASU Range 1301 - 1350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(431, 'WWD - ASU Range 1301 - 1350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(432, 'WWD - ASU Range 1351 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(433, 'WWD - ASU Range 1351 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(434, 'WWD - ASU Range 1401 - 1450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(435, 'WWD - ASU Range 1401 - 1450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(436, 'WWD - ASU Range 1451 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(437, 'WWD - ASU Range 1451 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(438, 'WWD - ASU Range 1501 - 1550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(439, 'WWD - ASU Range 1501 - 1550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(440, 'WWD - ASU Range 1551 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(441, 'WWD - ASU Range 1551 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(442, 'WWD - ASU Range 1601 - 1650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(443, 'WWD - ASU Range 1601 - 1650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(444, 'WWD - ASU Range 1651 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(445, 'WWD - ASU Range 1651 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(446, 'WWD - ASU Range 1701 - 1750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(447, 'WWD - ASU Range 1701 - 1750 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(448, 'WWD - ASU Range 1751 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(449, 'WWD - ASU Range 1751 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(450, 'WWD - ASU Range 1801 - 1850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(451, 'WWD - ASU Range 1801 - 1850 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(452, 'WWD - ASU Range 1851 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(453, 'WWD - ASU Range 1851 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(454, 'WWD - ASU Range 1901 - 1950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(455, 'WWD - ASU Range 1901 - 1950 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(456, 'WWD - ASU Range 1951 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 289),
(457, 'WWD - ASU Range 1951 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 274),
(458, 'TVC - ASU Range 1 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(459, 'TVC - ASU Range 1 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(460, 'TVC - ASU Range 1 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(461, 'TVC - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(462, 'TVC - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(463, 'TVC - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(464, 'TVC - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(465, 'TVC - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(466, 'TVC - ASU Range 101 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(467, 'TVC - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(468, 'TVC - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(469, 'TVC - ASU Range 201 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(470, 'TVC - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(471, 'TVC - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(472, 'TVC - ASU Range 301 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(473, 'TVC - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(474, 'TVC - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(475, 'TVC - ASU Range 401 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(476, 'TVC - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(477, 'TVC - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(478, 'TVC - ASU Range 501 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(479, 'TVC - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(480, 'TVC - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(481, 'TVC - ASU Range 601 - 700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(482, 'TVC - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(483, 'TVC - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(484, 'TVC - ASU Range 701 - 800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(485, 'TVC - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(486, 'TVC - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(487, 'TVC - ASU Range 801 - 900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(488, 'TVC - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(489, 'TVC - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(490, 'TVC - ASU Range 901 - 1000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(491, 'TVC - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(492, 'TVC - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(493, 'TVC - ASU Range 1001 - 1100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(494, 'TVC - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(495, 'TVC - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(496, 'TVC - ASU Range 1101 - 1200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(497, 'TVC - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(498, 'TVC - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(499, 'TVC - ASU Range 1201 - 1300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(500, 'TVC - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(501, 'TVC - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(502, 'TVC - ASU Range 1301 - 1400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(503, 'TVC - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(504, 'TVC - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(505, 'TVC - ASU Range 1401 - 1500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(506, 'TVC - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(507, 'TVC - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(508, 'TVC - ASU Range 1501 - 1600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(509, 'TVC - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(510, 'TVC - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(511, 'TVC - ASU Range 1601 - 1700 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(512, 'TVC - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(513, 'TVC - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(514, 'TVC - ASU Range 1701 - 1800 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(515, 'TVC - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(516, 'TVC - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(517, 'TVC - ASU Range 1801 - 1900 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(518, 'TVC - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 237),
(519, 'TVC - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 227),
(520, 'TVC - ASU Range 1901 - 2000 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 212),
(521, 'O - ASU Range 1 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(522, 'O - ASU Range 1 - 50 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(523, 'O - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(524, 'O - ASU Range 51 - 100 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(525, 'O - ASU Range 101 - 150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(526, 'O - ASU Range 101 - 150 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(527, 'O - ASU Range 151 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(528, 'O - ASU Range 151 - 200 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(529, 'O - ASU Range 201 - 250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(530, 'O - ASU Range 201 - 250 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(531, 'O - ASU Range 251 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(532, 'O - ASU Range 251 - 300 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(533, 'O - ASU Range 301 - 350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(534, 'O - ASU Range 301 - 350 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(535, 'O - ASU Range 351 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(536, 'O - ASU Range 351 - 400 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(537, 'O - ASU Range 401 - 450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(538, 'O - ASU Range 401 - 450 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(539, 'O - ASU Range 451 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(540, 'O - ASU Range 451 - 500 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(541, 'O - ASU Range 501 - 550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(542, 'O - ASU Range 501 - 550 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(543, 'O - ASU Range 551 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(544, 'O - ASU Range 551 - 600 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248),
(545, 'O - ASU Range 601 - 650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 263),
(546, 'O - ASU Range 601 - 650 - Deployment & set-up', '', 'from_ntt', 'projDev', NULL, 248);

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
  `default_cost` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=547 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_item_advice`
--

INSERT INTO `implem_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`, `default_cost`) VALUES
(1, 'per blabla', NULL, 50, 102, 0),
(3, 'per truc', NULL, 10, 20, 0),
(5, '', '', 13, 14, 0),
(7, 'vfg', '', 2, 21, 0),
(40, 'Per streetlight pole', 'https://www.ledsmaster.com/channel/How-Much-Do-Street-Lights-Cost-Replacing-and-Running-the-Street-Lamp--77.html', 1200, 2300, 0),
(41, 'Per smart lamppost', 'Internal research', 26, 87, 0),
(42, 'Per LED light', 'https://www.myledlightingguide.com/blog-the-cost-of-street-lights', 160, 240, 0),
(43, 'Per cabling system', 'https://blog.lightinus.com/comparing-traditional-street-lights-and-solar-energy-lights', 38, 90, 0),
(44, 'Per software', 'http://qulon.pro\n', 25, 85, 0),
(45, 'Per sensor', 'https://www.homeadvisor.com/cost/electrical/upgrade-an-electrical-panel/', 80, 170, 0),
(46, 'Per gateway', 'http://democracy.cityoflondon.gov.uk/documents/s63133/Street%20Lighting%20Review%20G3-4%20Report%20-%20Final.pdf', 7100, 22000, 0),
(47, 'Per EVSE Charging point', 'https://www.ubitricity.co.uk/unternehmen/newsroom/simple-conversion-turn-street-lamps-electric-car-chargers-daily-mail/\n', 1000, 1600, 0),
(48, 'Per connector', 'https://www.homeadvisor.com/cost/garages/install-an-electric-vehicle-charging-station/', 380, 440, 0),
(49, 'Per PV panel', 'https://www.streetlights-solar.com/2018/07/19/cost-comparison-between-solar-vs-traditional-lights/\n', 600, 1200, 0),
(50, 'Per battery & remote control', 'https://www.energysage.com/solar/solar-energy-storage/what-do-solar-batteries-cost/\n', 310, 570, 0),
(51, 'Per battery & remote control', 'https://www.energysage.com/solar/solar-energy-storage/what-do-solar-batteries-cost/\n', 310, 570, 0),
(52, 'Per CCTV system', 'https://www.fixr.com/costs/install-video-surveillance-cameras', 280, 400, 0),
(53, 'Per PTT', 'http://www.groundcontrol.com/Iridium_PTT_Push-To-Talk.htm', 1700, 3900, 0),
(54, 'Per Public speakers', 'https://porch.com/project-cost/cost-to-install-outdoor-speakers', 150, 280, 0),
(55, 'Per sensor', 'https://www.london.gov.uk/what-we-do/environment/pollution-and-air-quality/monitoring-and-predicting-air-pollution\n', 310, 750, 0),
(56, 'Per software', 'Internal research', 1000, 1120, 0),
(57, 'Per sensor', 'Internal research', 155, 375, 0),
(58, 'Per software', 'Internal research', 1000, 1120, 0),
(59, 'Per sensor', 'https://reliabilityweb.com/articles/entry/wireless_sensors_work_provide_a_cost-effective_alternative_to_traditio', 500, 1500, 0),
(60, 'Per software', 'Internal research', 1000, 1120, 0),
(61, 'Per Advertising Panel', 'https://just-print.co.uk/155-lamp-post-advertising-boards-24-x-16-50-pack.html', 170, 200, 0),
(62, 'Per traffic monitoring sensor', 'https://www.itscosts.its.dot.gov/ITS/benecost.nsf/ID/5A53F0D1919AA5EE8525798300819B6E?OpenDocument&Query=CApp', 260, 1300, 0),
(63, 'Per software', 'https://www.researchgate.net/publication/280078500_Intelligent_Traffic_Monitoring_System', 640, 1900, 0),
(64, 'Per sensor', 'https://www.itscosts.its.dot.gov/its/benecost.nsf/0/E4717C6F075BAAA38525789B00610ECC?OpenDocument&Query=Home', 310, 625, 0),
(65, 'Per gateway', 'https://www.itscosts.its.dot.gov/ITS/benecost.nsf/ID/F1112FA098133F3C85256DB100458923?OpenDocument&Query=CApp', 210, 835, 0),
(66, 'Per guidance system', 'Internal research', 64, 385, 0),
(67, 'Per Wifi antenna', 'https://its.umich.edu/projects/wifi-upgrade/project-funding', 300, 380, 0),
(68, 'Per antenna', 'https://www.repeaterstore.com/pages/custom-solutions', 400, 800, 0),
(69, 'Per 5G antenna', 'https://www.ctia.org/news/what-is-a-small-cell', 400, 800, 0),
(109, '', '', 0, 0, 123),
(110, '', '', 0, 0, 124),
(111, '#', '', 191500, 231190, 211345),
(112, '#', '', 191500, 231190, 211345),
(113, '#', '', 191500, 231190, 211345),
(114, '#', '', 191500, 231190, 211345),
(115, '#', '', 191500, 231190, 211345),
(116, '#', '', 191500, 231190, 211345),
(117, '#', '', 191500, 231190, 211345),
(118, '#', '', 251035, 330415, 290725),
(119, '#', '', 251035, 330415, 290725),
(120, '#', '', 251035, 330415, 290725),
(121, '#', '', 251035, 330415, 290725),
(122, '#', '', 251035, 330415, 290725),
(123, '#', '', 251035, 330415, 290725),
(124, '#', '', 251035, 330415, 290725),
(125, '#', '', 350260, 429640, 389950),
(126, '#', '', 350260, 429640, 389950),
(127, '#', '', 350260, 429640, 389950),
(128, '#', '', 350260, 429640, 389950),
(129, '#', '', 350260, 429640, 389950),
(130, '#', '', 350260, 429640, 389950),
(131, '#', '', 350260, 429640, 389950),
(132, '#', '', 449485, 528865, 489175),
(133, '#', '', 449485, 528865, 489175),
(134, '#', '', 449485, 528865, 489175),
(135, '#', '', 449485, 528865, 489175),
(136, '#', '', 449485, 528865, 489175),
(137, '#', '', 449485, 528865, 489175),
(138, '#', '', 449485, 528865, 489175),
(139, '#', '', 591510, 670890, 631200),
(140, '#', '', 591510, 670890, 631200),
(141, '#', '', 591510, 670890, 631200),
(142, '#', '', 591510, 670890, 631200),
(143, '#', '', 591510, 670890, 631200),
(144, '#', '', 591510, 670890, 631200),
(145, '#', '', 591510, 670890, 631200),
(146, '#', '', 690735, 770115, 730425),
(147, '#', '', 690735, 770115, 730425),
(148, '#', '', 690735, 770115, 730425),
(149, '#', '', 690735, 770115, 730425),
(150, '#', '', 690735, 770115, 730425),
(151, '#', '', 690735, 770115, 730425),
(152, '#', '', 690735, 770115, 730425),
(153, '#', '', 789960, 869340, 829650),
(154, '#', '', 789960, 869340, 829650),
(155, '#', '', 789960, 869340, 829650),
(156, '#', '', 789960, 869340, 829650),
(157, '#', '', 789960, 869340, 829650),
(158, '#', '', 789960, 869340, 829650),
(159, '#', '', 789960, 869340, 829650),
(160, '#', '', 889185, 968565, 928875),
(161, '#', '', 889185, 968565, 928875),
(162, '#', '', 889185, 968565, 928875),
(163, '#', '', 889185, 968565, 928875),
(164, '#', '', 889185, 968565, 928875),
(165, '#', '', 889185, 968565, 928875),
(166, '#', '', 889185, 968565, 928875),
(167, '#', '', 988410, 1067790, 1028100),
(168, '#', '', 988410, 1067790, 1028100),
(169, '#', '', 988410, 1067790, 1028100),
(170, '#', '', 988410, 1067790, 1028100),
(171, '#', '', 988410, 1067790, 1028100),
(172, '#', '', 988410, 1067790, 1028100),
(173, '#', '', 988410, 1067790, 1028100),
(174, '#', '', 1087635, 1167015, 1127320),
(175, '#', '', 1087635, 1167015, 1127320),
(176, '#', '', 1087635, 1167015, 1127320),
(177, '#', '', 1087635, 1167015, 1127320),
(178, '#', '', 1087635, 1167015, 1127320),
(179, '#', '', 1087635, 1167015, 1127320),
(180, '#', '', 1087635, 1167015, 1127320),
(181, '#', '', 1186860, 1266240, 1226550),
(182, '#', '', 1186860, 1266240, 1226550),
(183, '#', '', 1186860, 1266240, 1226550),
(184, '#', '', 1186860, 1266240, 1226550),
(185, '#', '', 1186860, 1266240, 1226550),
(186, '#', '', 1186860, 1266240, 1226550),
(187, '#', '', 1186860, 1266240, 1226550),
(188, '#', '', 1328885, 1408265, 1368580),
(189, '#', '', 1328885, 1408265, 1368580),
(190, '#', '', 1328885, 1408265, 1368580),
(191, '#', '', 1328885, 1408265, 1368580),
(192, '#', '', 1328885, 1408265, 1368580),
(193, '#', '', 1328885, 1408265, 1368580),
(194, '#', '', 1328885, 1408265, 1368580),
(195, '#', '', 1428110, 1507490, 1467800),
(196, '#', '', 1428110, 1507490, 1467800),
(197, '#', '', 1428110, 1507490, 1467800),
(198, '#', '', 1428110, 1507490, 1467800),
(199, '#', '', 1428110, 1507490, 1467800),
(200, '#', '', 1428110, 1507490, 1467800),
(201, '#', '', 1428110, 1507490, 1467800),
(202, '#', '', 1527335, 1606715, 1567020),
(203, '#', '', 1527335, 1606715, 1567020),
(204, '#', '', 1527335, 1606715, 1567020),
(205, '#', '', 1527335, 1606715, 1567020),
(206, '#', '', 1527335, 1606715, 1567020),
(207, '#', '', 1527335, 1606715, 1567020),
(208, '#', '', 1527335, 1606715, 1567020),
(209, '#', '', 1626560, 1705940, 1666250),
(210, '#', '', 1626560, 1705940, 1666250),
(211, '#', '', 1626560, 1705940, 1666250),
(212, '#', '', 1626560, 1705940, 1666250),
(213, '#', '', 1626560, 1705940, 1666250),
(214, '#', '', 1626560, 1705940, 1666250),
(215, '#', '', 1626560, 1705940, 1666250),
(216, '#', '', 1725785, 1805165, 1765480),
(217, '#', '', 1725785, 1805165, 1765480),
(218, '#', '', 1725785, 1805165, 1765480),
(219, '#', '', 1725785, 1805165, 1765480),
(220, '#', '', 1725785, 1805165, 1765480),
(221, '#', '', 1725785, 1805165, 1765480),
(222, '#', '', 1725785, 1805165, 1765480),
(223, '#', '', 1825010, 1904390, 1864700),
(224, '#', '', 1825010, 1904390, 1864700),
(225, '#', '', 1825010, 1904390, 1864700),
(226, '#', '', 1825010, 1904390, 1864700),
(227, '#', '', 1825010, 1904390, 1864700),
(228, '#', '', 1825010, 1904390, 1864700),
(229, '#', '', 1825010, 1904390, 1864700),
(230, '#', '', 1924235, 2003615, 1963920),
(231, '#', '', 1924235, 2003615, 1963920),
(232, '#', '', 1924235, 2003615, 1963920),
(233, '#', '', 1924235, 2003615, 1963920),
(234, '#', '', 1924235, 2003615, 1963920),
(235, '#', '', 1924235, 2003615, 1963920),
(236, '#', '', 1924235, 2003615, 1963920),
(237, '#', '', 2023460, 2102840, 2063150),
(238, '#', '', 2023460, 2102840, 2063150),
(239, '#', '', 2023460, 2102840, 2063150),
(240, '#', '', 2023460, 2102840, 2063150),
(241, '#', '', 2023460, 2102840, 2063150),
(242, '#', '', 2023460, 2102840, 2063150),
(243, '#', '', 2023460, 2102840, 2063150),
(244, '#', '', 2122685, 2202065, 2162380),
(245, '#', '', 2122685, 2202065, 2162380),
(246, '#', '', 2122685, 2202065, 2162380),
(247, '#', '', 2122685, 2202065, 2162380),
(248, '#', '', 2122685, 2202065, 2162380),
(249, '#', '', 2122685, 2202065, 2162380),
(250, '#', '', 2122685, 2202065, 2162380),
(251, '#', '', 2221910, 2301290, 2261600),
(252, '#', '', 2221910, 2301290, 2261600),
(253, '#', '', 2221910, 2301290, 2261600),
(254, '#', '', 2221910, 2301290, 2261600),
(255, '#', '', 2221910, 2301290, 2261600),
(256, '#', '', 2221910, 2301290, 2261600),
(257, '#', '', 2221910, 2301290, 2261600),
(258, '#', '', 55890, 89910, 72900),
(259, '#', '', 55890, 89910, 72900),
(260, '#', '', 55890, 89910, 72900),
(261, '#', '', 119815, 153835, 136825),
(262, '#', '', 119815, 153835, 136825),
(263, '#', '', 119815, 153835, 136825),
(264, '#', '', 162340, 196360, 179350),
(265, '#', '', 162340, 196360, 179350),
(266, '#', '', 162340, 196360, 179350),
(267, '#', '', 204865, 238885, 221875),
(268, '#', '', 204865, 238885, 221875),
(269, '#', '', 204865, 238885, 221875),
(270, '#', '', 247390, 281410, 264400),
(271, '#', '', 247390, 281410, 264400),
(272, '#', '', 247390, 281410, 264400),
(273, '#', '', 289915, 323935, 306925),
(274, '#', '', 289915, 323935, 306925),
(275, '#', '', 289915, 323935, 306925),
(276, '#', '', 332440, 366460, 349450),
(277, '#', '', 332440, 366460, 349450),
(278, '#', '', 332440, 366460, 349450),
(279, '#', '', 374965, 408985, 391975),
(280, '#', '', 374965, 408985, 391975),
(281, '#', '', 374965, 408985, 391975),
(282, '#', '', 460290, 494310, 477300),
(283, '#', '', 460290, 494310, 477300),
(284, '#', '', 460290, 494310, 477300),
(285, '#', '', 502815, 536835, 519825),
(286, '#', '', 502815, 536835, 519825),
(287, '#', '', 502815, 536835, 519825),
(288, '#', '', 545340, 579360, 562350),
(289, '#', '', 545340, 579360, 562350),
(290, '#', '', 545340, 579360, 562350),
(291, '#', '', 587865, 621885, 604875),
(292, '#', '', 587865, 621885, 604875),
(293, '#', '', 587865, 621885, 604875),
(294, '#', '', 630390, 664410, 647400),
(295, '#', '', 630390, 664410, 647400),
(296, '#', '', 630390, 664410, 647400),
(297, '#', '', 672915, 706935, 689925),
(298, '#', '', 672915, 706935, 689925),
(299, '#', '', 672915, 706935, 689925),
(300, '#', '', 715440, 749460, 732450),
(301, '#', '', 715440, 749460, 732450),
(302, '#', '', 715440, 749460, 732450),
(303, '#', '', 757965, 791985, 774975),
(304, '#', '', 757965, 791985, 774975),
(305, '#', '', 757965, 791985, 774975),
(306, '#', '', 800490, 834510, 817500),
(307, '#', '', 800490, 834510, 817500),
(308, '#', '', 800490, 834510, 817500),
(309, '#', '', 843015, 877035, 860025),
(310, '#', '', 843015, 877035, 860025),
(311, '#', '', 843015, 877035, 860025),
(312, '#', '', 885540, 919560, 902550),
(313, '#', '', 885540, 919560, 902550),
(314, '#', '', 885540, 919560, 902550),
(315, '#', '', 928065, 962085, 945075),
(316, '#', '', 928065, 962085, 945075),
(317, '#', '', 928065, 962085, 945075),
(318, '#', '', 970590, 1004610, 987600),
(319, '#', '', 970590, 1004610, 987600),
(320, '#', '', 970590, 1004610, 987600),
(321, '#', '', 1013115, 1047135, 1030120),
(322, '#', '', 1013115, 1047135, 1030120),
(323, '#', '', 1013115, 1047135, 1030120),
(324, '#', '', 1098440, 1132460, 1115450),
(325, '#', '', 1098440, 1132460, 1115450),
(326, '#', '', 1098440, 1132460, 1115450),
(327, '#', '', 1140965, 1174985, 1157980),
(328, '#', '', 1140965, 1174985, 1157980),
(329, '#', '', 1140965, 1174985, 1157980),
(330, '#', '', 1183490, 1217510, 1200500),
(331, '#', '', 1183490, 1217510, 1200500),
(332, '#', '', 1183490, 1217510, 1200500),
(333, '#', '', 1226015, 1260035, 1243020),
(334, '#', '', 1226015, 1260035, 1243020),
(335, '#', '', 1226015, 1260035, 1243020),
(336, '#', '', 1268540, 1302560, 1285550),
(337, '#', '', 1268540, 1302560, 1285550),
(338, '#', '', 1268540, 1302560, 1285550),
(339, '#', '', 1311065, 1345085, 1328080),
(340, '#', '', 1311065, 1345085, 1328080),
(341, '#', '', 1311065, 1345085, 1328080),
(342, '#', '', 1353590, 1387610, 1370600),
(343, '#', '', 1353590, 1387610, 1370600),
(344, '#', '', 1353590, 1387610, 1370600),
(345, '#', '', 1396115, 1430135, 1413120),
(346, '#', '', 1396115, 1430135, 1413120),
(347, '#', '', 1396115, 1430135, 1413120),
(348, '#', '', 1438640, 1472660, 1455650),
(349, '#', '', 1438640, 1472660, 1455650),
(350, '#', '', 1438640, 1472660, 1455650),
(351, '#', '', 1481165, 1515185, 1498180),
(352, '#', '', 1481165, 1515185, 1498180),
(353, '#', '', 1481165, 1515185, 1498180),
(354, '#', '', 1523690, 1557710, 1540700),
(355, '#', '', 1523690, 1557710, 1540700),
(356, '#', '', 1523690, 1557710, 1540700),
(357, '#', '', 1566215, 1600235, 1583220),
(358, '#', '', 1566215, 1600235, 1583220),
(359, '#', '', 1566215, 1600235, 1583220),
(360, '#', '', 1608740, 1642760, 1625750),
(361, '#', '', 1608740, 1642760, 1625750),
(362, '#', '', 1608740, 1642760, 1625750),
(363, '#', '', 1651265, 1685285, 1668280),
(364, '#', '', 1651265, 1685285, 1668280),
(365, '#', '', 1651265, 1685285, 1668280),
(366, '#', '', 1693790, 1727810, 1710800),
(367, '#', '', 1693790, 1727810, 1710800),
(368, '#', '', 1693790, 1727810, 1710800),
(369, '#', '', 1736315, 1770335, 1753320),
(370, '#', '', 1736315, 1770335, 1753320),
(371, '#', '', 1736315, 1770335, 1753320),
(372, '#', '', 1778840, 1812860, 1795850),
(373, '#', '', 1778840, 1812860, 1795850),
(374, '#', '', 1778840, 1812860, 1795850),
(375, '#', '', 1821365, 1855385, 1838380),
(376, '#', '', 1821365, 1855385, 1838380),
(377, '#', '', 1821365, 1855385, 1838380),
(378, '#', '', 37260, 59940, 48600),
(379, '#', '', 37260, 59940, 48600),
(380, '#', '', 87010, 109690, 98350),
(381, '#', '', 87010, 109690, 98350),
(382, '#', '', 115360, 138040, 126700),
(383, '#', '', 115360, 138040, 126700),
(384, '#', '', 143710, 166390, 155050),
(385, '#', '', 143710, 166390, 155050),
(386, '#', '', 172060, 194740, 183400),
(387, '#', '', 172060, 194740, 183400),
(388, '#', '', 200410, 223090, 211750),
(389, '#', '', 200410, 223090, 211750),
(390, '#', '', 228760, 251440, 240100),
(391, '#', '', 228760, 251440, 240100),
(392, '#', '', 257110, 279790, 268450),
(393, '#', '', 257110, 279790, 268450),
(394, '#', '', 328260, 350940, 339600),
(395, '#', '', 328260, 350940, 339600),
(396, '#', '', 356610, 379290, 367950),
(397, '#', '', 356610, 379290, 367950),
(398, '#', '', 384960, 407640, 396300),
(399, '#', '', 384960, 407640, 396300),
(400, '#', '', 413310, 435990, 424650),
(401, '#', '', 413310, 435990, 424650),
(402, '#', '', 441660, 464340, 453000),
(403, '#', '', 441660, 464340, 453000),
(404, '#', '', 470010, 492690, 481350),
(405, '#', '', 470010, 492690, 481350),
(406, '#', '', 498360, 521040, 509700),
(407, '#', '', 498360, 521040, 509700),
(408, '#', '', 526710, 549390, 538050),
(409, '#', '', 526710, 549390, 538050),
(410, '#', '', 555060, 577740, 566400),
(411, '#', '', 555060, 577740, 566400),
(412, '#', '', 583410, 606090, 594750),
(413, '#', '', 583410, 606090, 594750),
(414, '#', '', 611760, 634440, 623100),
(415, '#', '', 611760, 634440, 623100),
(416, '#', '', 640110, 662790, 651450),
(417, '#', '', 640110, 662790, 651450),
(418, '#', '', 668460, 691140, 679800),
(419, '#', '', 668460, 691140, 679800),
(420, '#', '', 696810, 719490, 708150),
(421, '#', '', 696810, 719490, 708150),
(422, '#', '', 767960, 790640, 779300),
(423, '#', '', 767960, 790640, 779300),
(424, '#', '', 796310, 818990, 807650),
(425, '#', '', 796310, 818990, 807650),
(426, '#', '', 824660, 847340, 836000),
(427, '#', '', 824660, 847340, 836000),
(428, '#', '', 853010, 875690, 864350),
(429, '#', '', 853010, 875690, 864350),
(430, '#', '', 881360, 904040, 892700),
(431, '#', '', 881360, 904040, 892700),
(432, '#', '', 909710, 932390, 921050),
(433, '#', '', 909710, 932390, 921050),
(434, '#', '', 938060, 960740, 949400),
(435, '#', '', 938060, 960740, 949400),
(436, '#', '', 966410, 989090, 977750),
(437, '#', '', 966410, 989090, 977750),
(438, '#', '', 994760, 1017440, 1006100),
(439, '#', '', 994760, 1017440, 1006100),
(440, '#', '', 1023110, 1045790, 1034450),
(441, '#', '', 1023110, 1045790, 1034450),
(442, '#', '', 1051460, 1074140, 1062800),
(443, '#', '', 1051460, 1074140, 1062800),
(444, '#', '', 1079810, 1102490, 1091150),
(445, '#', '', 1079810, 1102490, 1091150),
(446, '#', '', 1108160, 1130840, 1119500),
(447, '#', '', 1108160, 1130840, 1119500),
(448, '#', '', 1136510, 1159190, 1147850),
(449, '#', '', 1136510, 1159190, 1147850),
(450, '#', '', 1164860, 1187540, 1176200),
(451, '#', '', 1164860, 1187540, 1176200),
(452, '#', '', 1193210, 1215890, 1204550),
(453, '#', '', 1193210, 1215890, 1204550),
(454, '#', '', 1221560, 1244240, 1232900),
(455, '#', '', 1221560, 1244240, 1232900),
(456, '#', '', 1249910, 1272590, 1261250),
(457, '#', '', 1249910, 1272590, 1261250),
(458, '#', '', 55890, 89910, 72900),
(459, '#', '', 55890, 89910, 72900),
(460, '#', '', 55890, 89910, 72900),
(461, '#', '', 119815, 153835, 136825),
(462, '#', '', 119815, 153835, 136825),
(463, '#', '', 119815, 153835, 136825),
(464, '#', '', 162340, 238885, 200612),
(465, '#', '', 162340, 238885, 200612),
(466, '#', '', 162340, 238885, 200612),
(467, '#', '', 247390, 323935, 285662),
(468, '#', '', 247390, 323935, 285662),
(469, '#', '', 247390, 323935, 285662),
(470, '#', '', 332440, 408985, 370712),
(471, '#', '', 332440, 408985, 370712),
(472, '#', '', 332440, 408985, 370712),
(473, '#', '', 460290, 536835, 498563),
(474, '#', '', 460290, 536835, 498563),
(475, '#', '', 460290, 536835, 498563),
(476, '#', '', 545340, 621885, 583613),
(477, '#', '', 545340, 621885, 583613),
(478, '#', '', 545340, 621885, 583613),
(479, '#', '', 630390, 706935, 668663),
(480, '#', '', 630390, 706935, 668663),
(481, '#', '', 630390, 706935, 668663),
(482, '#', '', 715440, 791985, 753713),
(483, '#', '', 715440, 791985, 753713),
(484, '#', '', 715440, 791985, 753713),
(485, '#', '', 800490, 877035, 838763),
(486, '#', '', 800490, 877035, 838763),
(487, '#', '', 800490, 877035, 838763),
(488, '#', '', 885540, 962085, 923813),
(489, '#', '', 885540, 962085, 923813),
(490, '#', '', 885540, 962085, 923813),
(491, '#', '', 970590, 1047135, 1008860),
(492, '#', '', 970590, 1047135, 1008860),
(493, '#', '', 970590, 1047135, 1008860),
(494, '#', '', 1098440, 1174985, 1136710),
(495, '#', '', 1098440, 1174985, 1136710),
(496, '#', '', 1098440, 1174985, 1136710),
(497, '#', '', 1183490, 1260035, 1221760),
(498, '#', '', 1183490, 1260035, 1221760),
(499, '#', '', 1183490, 1260035, 1221760),
(500, '#', '', 1268540, 1345085, 1306810),
(501, '#', '', 1268540, 1345085, 1306810),
(502, '#', '', 1268540, 1345085, 1306810),
(503, '#', '', 1353590, 1430135, 1391860),
(504, '#', '', 1353590, 1430135, 1391860),
(505, '#', '', 1353590, 1430135, 1391860),
(506, '#', '', 1438640, 1515185, 1476910),
(507, '#', '', 1438640, 1515185, 1476910),
(508, '#', '', 1438640, 1515185, 1476910),
(509, '#', '', 1523690, 1600235, 1561960),
(510, '#', '', 1523690, 1600235, 1561960),
(511, '#', '', 1523690, 1600235, 1561960),
(512, '#', '', 1608740, 1685285, 1647010),
(513, '#', '', 1608740, 1685285, 1647010),
(514, '#', '', 1608740, 1685285, 1647010),
(515, '#', '', 1693790, 1770335, 1732060),
(516, '#', '', 1693790, 1770335, 1732060),
(517, '#', '', 1693790, 1770335, 1732060),
(518, '#', '', 1778840, 1855385, 1817110),
(519, '#', '', 1778840, 1855385, 1817110),
(520, '#', '', 1778840, 1855385, 1817110),
(521, '#', '', 55890, 89910, 72900),
(522, '#', '', 55890, 89910, 72900),
(523, '#', '', 119815, 153835, 136825),
(524, '#', '', 119815, 153835, 136825),
(525, '#', '', 162340, 196360, 179350),
(526, '#', '', 162340, 196360, 179350),
(527, '#', '', 204865, 238885, 221875),
(528, '#', '', 204865, 238885, 221875),
(529, '#', '', 247390, 281410, 264400),
(530, '#', '', 247390, 281410, 264400),
(531, '#', '', 289915, 323935, 306925),
(532, '#', '', 289915, 323935, 306925),
(533, '#', '', 332440, 366460, 349450),
(534, '#', '', 332440, 366460, 349450),
(535, '#', '', 374965, 408985, 391975),
(536, '#', '', 374965, 408985, 391975),
(537, '#', '', 460290, 494310, 477300),
(538, '#', '', 460290, 494310, 477300),
(539, '#', '', 502815, 536835, 519825),
(540, '#', '', 502815, 536835, 519825),
(541, '#', '', 545340, 579360, 562350),
(542, '#', '', 545340, 579360, 562350),
(543, '#', '', 587865, 621885, 604875),
(544, '#', '', 587865, 621885, 604875),
(545, '#', '', 630390, 664410, 647400),
(546, '#', '', 630390, 664410, 647400);

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
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

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
(35, 23),
(70, 30),
(71, 30),
(72, 33),
(73, 33),
(74, 34),
(75, 34),
(76, 35),
(77, 35),
(78, 36),
(79, 36),
(80, 37),
(81, 37),
(82, 38),
(83, 38),
(84, 39),
(85, 39),
(86, 40),
(87, 40),
(88, 40),
(89, 40),
(90, 40),
(91, 44),
(92, 44),
(93, 46),
(94, 46),
(95, 48),
(96, 48),
(97, 49),
(98, 49),
(99, 50),
(100, 50),
(101, 51),
(102, 51),
(103, 52),
(104, 52),
(105, 53),
(106, 53),
(107, 54),
(108, 54);

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
(15, 28, '2012-02-01', '2012-03-01', '2012-04-01', '2012-05-01', '2012-07-01'),
(16, 26, '2020-01-01', '2020-03-01', '2020-05-01', '2020-06-01', '2020-09-01'),
(16, 27, '2020-01-01', '2020-03-01', '2020-04-01', '2020-06-01', '2020-10-01'),
(17, 28, '2012-02-01', '2012-03-01', '2012-04-01', '2012-05-01', '2012-07-01');

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
(71, -1),
(73, -1),
(75, -1),
(77, -1),
(79, -1),
(81, -1),
(83, -1),
(85, -1),
(87, -1),
(89, -1),
(90, -1),
(92, -1),
(93, -1),
(95, -1),
(97, -1),
(99, -1),
(101, -1),
(103, -1),
(105, -1),
(108, -1),
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
(69, 30),
(94, 41),
(96, 41),
(98, 41),
(100, 41),
(102, 41),
(104, 41),
(106, 41),
(70, 66),
(72, 67),
(74, 67),
(76, 67),
(78, 67),
(80, 67),
(82, 67),
(84, 67),
(86, 67),
(88, 67),
(91, 67),
(107, 67),
(109, 67),
(110, 67),
(258, 68),
(261, 68),
(264, 68),
(267, 68),
(270, 68),
(273, 68),
(276, 68),
(279, 68),
(282, 68),
(285, 68),
(288, 68),
(291, 68),
(294, 68),
(297, 68),
(300, 68),
(303, 68),
(306, 68),
(309, 68),
(312, 68),
(315, 68),
(318, 68),
(321, 68),
(324, 68),
(327, 68),
(330, 68),
(333, 68),
(336, 68),
(339, 68),
(342, 68),
(345, 68),
(348, 68),
(351, 68),
(354, 68),
(357, 68),
(360, 68),
(363, 68),
(366, 68),
(369, 68),
(372, 68),
(375, 68),
(259, 69),
(262, 69),
(265, 69),
(268, 69),
(271, 69),
(274, 69),
(277, 69),
(280, 69),
(283, 69),
(286, 69),
(289, 69),
(292, 69),
(295, 69),
(298, 69),
(301, 69),
(304, 69),
(307, 69),
(310, 69),
(313, 69),
(316, 69),
(319, 69),
(322, 69),
(325, 69),
(328, 69),
(331, 69),
(334, 69),
(337, 69),
(340, 69),
(343, 69),
(346, 69),
(349, 69),
(352, 69),
(355, 69),
(358, 69),
(361, 69),
(364, 69),
(367, 69),
(370, 69),
(373, 69),
(376, 69),
(260, 70),
(263, 70),
(266, 70),
(269, 70),
(272, 70),
(275, 70),
(278, 70),
(281, 70),
(284, 70),
(287, 70),
(290, 70),
(293, 70),
(296, 70),
(299, 70),
(302, 70),
(305, 70),
(308, 70),
(311, 70),
(314, 70),
(317, 70),
(320, 70),
(323, 70),
(326, 70),
(329, 70),
(332, 70),
(335, 70),
(338, 70),
(341, 70),
(344, 70),
(347, 70),
(350, 70),
(353, 70),
(356, 70),
(359, 70),
(362, 70),
(365, 70),
(368, 70),
(371, 70),
(374, 70),
(377, 70),
(111, 73),
(118, 73),
(125, 73),
(132, 73),
(139, 73),
(146, 73),
(153, 73),
(160, 73),
(167, 73),
(174, 73),
(181, 73),
(188, 73),
(195, 73),
(202, 73),
(209, 73),
(216, 73),
(223, 73),
(230, 73),
(237, 73),
(244, 73),
(251, 73),
(112, 74),
(119, 74),
(126, 74),
(133, 74),
(140, 74),
(147, 74),
(154, 74),
(161, 74),
(168, 74),
(175, 74),
(182, 74),
(189, 74),
(196, 74),
(203, 74),
(210, 74),
(217, 74),
(224, 74),
(231, 74),
(238, 74),
(245, 74),
(252, 74),
(113, 75),
(120, 75),
(127, 75),
(134, 75),
(141, 75),
(148, 75),
(155, 75),
(162, 75),
(169, 75),
(176, 75),
(183, 75),
(190, 75),
(197, 75),
(204, 75),
(211, 75),
(218, 75),
(225, 75),
(232, 75),
(239, 75),
(246, 75),
(253, 75),
(114, 76),
(121, 76),
(128, 76),
(135, 76),
(142, 76),
(149, 76),
(156, 76),
(163, 76),
(170, 76),
(177, 76),
(184, 76),
(191, 76),
(198, 76),
(205, 76),
(212, 76),
(219, 76),
(226, 76),
(233, 76),
(240, 76),
(247, 76),
(254, 76),
(115, 77),
(122, 77),
(129, 77),
(136, 77),
(143, 77),
(150, 77),
(157, 77),
(164, 77),
(171, 77),
(178, 77),
(185, 77),
(192, 77),
(199, 77),
(206, 77),
(213, 77),
(220, 77),
(227, 77),
(234, 77),
(241, 77),
(248, 77),
(255, 77),
(116, 78),
(123, 78),
(130, 78),
(137, 78),
(144, 78),
(151, 78),
(158, 78),
(165, 78),
(172, 78),
(179, 78),
(186, 78),
(193, 78),
(200, 78),
(207, 78),
(214, 78),
(221, 78),
(228, 78),
(235, 78),
(242, 78),
(249, 78),
(256, 78),
(117, 79),
(124, 79),
(131, 79),
(138, 79),
(145, 79),
(152, 79),
(159, 79),
(166, 79),
(173, 79),
(180, 79),
(187, 79),
(194, 79),
(201, 79),
(208, 79),
(215, 79),
(222, 79),
(229, 79),
(236, 79),
(243, 79),
(250, 79),
(257, 79),
(458, 80),
(461, 80),
(464, 80),
(467, 80),
(470, 80),
(473, 80),
(476, 80),
(479, 80),
(482, 80),
(485, 80),
(488, 80),
(491, 80),
(494, 80),
(497, 80),
(500, 80),
(503, 80),
(506, 80),
(509, 80),
(512, 80),
(515, 80),
(518, 80),
(459, 81),
(462, 81),
(465, 81),
(468, 81),
(471, 81),
(474, 81),
(477, 81),
(480, 81),
(483, 81),
(486, 81),
(489, 81),
(492, 81),
(495, 81),
(498, 81),
(501, 81),
(504, 81),
(507, 81),
(510, 81),
(513, 81),
(516, 81),
(519, 81),
(460, 82),
(463, 82),
(466, 82),
(469, 82),
(472, 82),
(475, 82),
(478, 82),
(481, 82),
(484, 82),
(487, 82),
(490, 82),
(493, 82),
(496, 82),
(499, 82),
(502, 82),
(505, 82),
(508, 82),
(511, 82),
(514, 82),
(517, 82),
(520, 82),
(521, 83),
(523, 83),
(525, 83),
(527, 83),
(529, 83),
(531, 83),
(533, 83),
(535, 83),
(537, 83),
(539, 83),
(541, 83),
(543, 83),
(545, 83),
(522, 84),
(524, 84),
(526, 84),
(528, 84),
(530, 84),
(532, 84),
(534, 84),
(536, 84),
(538, 84),
(540, 84),
(542, 84),
(544, 84),
(546, 84),
(378, 85),
(380, 85),
(382, 85),
(384, 85),
(386, 85),
(388, 85),
(390, 85),
(392, 85),
(394, 85),
(396, 85),
(398, 85),
(400, 85),
(402, 85),
(404, 85),
(406, 85),
(408, 85),
(410, 85),
(412, 85),
(414, 85),
(416, 85),
(418, 85),
(420, 85),
(422, 85),
(424, 85),
(426, 85),
(428, 85),
(430, 85),
(432, 85),
(434, 85),
(436, 85),
(438, 85),
(440, 85),
(442, 85),
(444, 85),
(446, 85),
(448, 85),
(450, 85),
(452, 85),
(454, 85),
(456, 85),
(379, 86),
(381, 86),
(383, 86),
(385, 86),
(387, 86),
(389, 86),
(391, 86),
(393, 86),
(395, 86),
(397, 86),
(399, 86),
(401, 86),
(403, 86),
(405, 86),
(407, 86),
(409, 86),
(411, 86),
(413, 86),
(415, 86),
(417, 86),
(419, 86),
(421, 86),
(423, 86),
(425, 86),
(427, 86),
(429, 86),
(431, 86),
(433, 86),
(435, 86),
(437, 86),
(439, 86),
(441, 86),
(443, 86),
(445, 86),
(447, 86),
(449, 86),
(451, 86),
(453, 86),
(455, 86),
(457, 86);

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
(47, 27, 16, 5, 12499.99, 3),
(52, 27, 15, 5, 8650, 3),
(53, 27, 15, 500, 605.5, 3),
(56, 26, 16, NULL, NULL, NULL),
(56, 27, 16, 50, 86.5, 3),
(59, 28, 17, 5, 17.3, 5),
(67, 29, 22, 2, 1, 3),
(83, 29, -1, 30, 20, 1),
(84, 30, 33, 0, 1, 1),
(91, 30, 67, 11, 10, 12),
(93, 30, 66, NULL, NULL, NULL),
(93, 30, 67, 10, 10, 5),
(94, 30, 67, 30, 20, 3),
(97, 33, 33, 0, 1, 1),
(98, 33, 67, 11, 10, 12),
(99, 33, 66, NULL, NULL, NULL),
(100, 33, 67, 10, 10, 5),
(101, 33, 67, 30, 20, 3),
(103, 34, 33, 0, 1, 1),
(104, 34, 67, 11, 10, 12),
(105, 34, 66, NULL, NULL, NULL),
(105, 34, 67, NULL, NULL, NULL),
(106, 34, 67, 10, 10, 5),
(107, 34, 67, 30, 20, 3),
(109, 35, 33, 0, 1, 1),
(110, 35, 67, 11, 10, 12),
(111, 35, 66, NULL, NULL, NULL),
(112, 35, 67, 10, 10, 5),
(113, 35, 67, 30, 20, 3),
(115, 36, 33, 0, 1, 1),
(116, 36, 67, 11, 10, 12),
(117, 36, 66, NULL, NULL, NULL),
(117, 36, 67, NULL, NULL, NULL),
(118, 36, 67, 30, 20, 3),
(120, 37, 33, 0, 1, 1),
(121, 37, 67, 11, 10, 12),
(122, 37, 66, NULL, NULL, NULL),
(123, 37, 67, 30, 20, 3),
(125, 38, 33, 0, 1, 1),
(126, 38, 67, 11, 10, 12),
(127, 38, 66, NULL, NULL, NULL),
(128, 38, 67, 30, 20, 3),
(130, 39, 33, 0, 1, 1),
(131, 39, 67, 11, 10, 12),
(132, 39, 66, NULL, NULL, NULL),
(133, 39, 67, 30, 20, 3),
(135, 40, 33, 0, 1, 1),
(136, 40, 67, 11, 10, 12),
(137, 40, 66, NULL, NULL, NULL),
(138, 40, 67, 30, 20, 3),
(140, 41, 33, 0, 1, 1),
(141, 41, 67, 11, 10, 12),
(142, 41, 66, NULL, NULL, NULL),
(143, 41, 67, 30, 20, 3),
(145, 42, 33, 0, 1, 1),
(146, 42, 67, 11, 10, 12),
(147, 42, 66, NULL, NULL, NULL),
(148, 42, 67, 30, 20, 3),
(150, 43, 33, 0, 1, 1),
(151, 43, 67, 11, 10, 12),
(152, 43, 66, NULL, NULL, NULL),
(153, 43, 67, 30, 20, 3),
(156, 44, 33, 0, 1, 1),
(157, 44, 67, 11, 10, 12),
(158, 44, 66, NULL, NULL, NULL),
(159, 44, 67, 30, 20, 3),
(161, 45, 48, 5, 10, 5),
(161, 56, 48, 20, 120, 2),
(163, 46, 41, 10, 255.32, 3),
(164, 46, 41, 2, 1, 50),
(165, 48, -1, 20, 17.02, 3),
(166, 48, 41, 10, 255.32, 3),
(167, 49, -1, 20, 17.02, 3),
(168, 49, 41, 10, 255.32, 3),
(169, 50, -1, 20, 17.02, 3),
(170, 50, 41, 10, 255.32, 3),
(171, 51, -1, 20, 17.02, 3),
(172, 51, 41, 10, 255.32, 3),
(174, 52, 41, 10, 255.32, 3),
(176, 53, 41, 10, 255.32, 3),
(177, 54, 33, 0, 1, 1),
(178, 54, 67, 11, 10, 12),
(179, 54, 66, NULL, NULL, NULL),
(180, 54, 67, 30, 20, 3),
(185, 30, 67, 0, 200, 0);

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
  `revenue_start_date` date NOT NULL DEFAULT '0001-01-01',
  `ramp_up_duration` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_cashreleasing`
--

INSERT INTO `input_cashreleasing` (`id_item`, `id_proj`, `id_uc`, `unit_indicator`, `volume`, `ratio`, `unit_cost`, `volume_reduc`, `unit_cost_reduc`, `annual_var_volume`, `annual_var_unit_cost`, `revenue_start_date`, `ramp_up_duration`) VALUES
(0, 44, 67, 'test', 2, NULL, 1, 5, 10, 4, 35, '2020-09-30', 0),
(1, 1, 1, 'per example', 0, NULL, 0, 0, 0, 0, 0, '0001-01-01', 0),
(1, 4, 1, 'per example', 864, 54, 0, 0, 0, 0, 0, '0001-01-01', 0),
(1, 6, 1, 'per example', 20, NULL, 58, 2, 5, 2, 2, '0001-01-01', 0),
(1, 8, 1, 'per example', 1500, NULL, 500, 5, 0, 5, 5, '0001-01-01', 0),
(2, 6, 1, 'per example', 30, NULL, 4, 4, 2, 5, 5, '0001-01-01', 0),
(2, 8, 1, 'per example', 5, NULL, 12000, 10, 10, 5, 5, '0001-01-01', 0),
(3, 1, 1, 'per example', 0, NULL, 0, 0, 0, 0, 0, '0001-01-01', 0),
(3, 4, 1, 'per example', 4544, 284, 0, 0, 0, 0, 0, '0001-01-01', 0),
(3, 6, 1, 'per example', 10, NULL, 10, 1, 4, 5, 5, '0001-01-01', 0),
(3, 8, 1, 'per example', 10, NULL, 10, 5, 6, 5, 5, '0001-01-01', 0),
(4, 4, 2, 'EUIHV', 54, NULL, 5, 54, 5, 5, 5, '0001-01-01', 0),
(5, 4, 3, 'VUIG', 66, NULL, 12, 5, 19, 89, 78, '0001-01-01', 0),
(7, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(8, 8, 11, 'SI', 12, NULL, 100, 3, 5, 5, 3, '0001-01-01', 0),
(9, 8, 11, 'SI', 50, NULL, 200, 0, 10, 5, 1, '0001-01-01', 0),
(10, 8, 11, 'SI', 20, NULL, 1500, 30, 13, 5, 5, '0001-01-01', 0),
(11, 8, 11, 'SI', 5, NULL, 31, 3, 1, 5, 3, '0001-01-01', 0),
(12, 21, 9, 'test', 1500, NULL, 15, 3, 5, 5, 1, '0001-01-01', 0),
(13, 23, 3, 'parking space', 5000, NULL, 100, 5, 0, 0, 0, '0001-01-01', 0),
(14, 21, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(15, 27, 16, '', 3, NULL, 2, 45, 46, 2, 15, '2020-09-30', 0),
(18, 26, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(18, 27, 15, 'Per Kwh', 600, NULL, 0.35, 0, 1, 30, 0, '0001-01-01', 0),
(18, 29, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(19, 27, 15, 'Per light bulb', 30, NULL, 86.5, 0, 5, 30, 50, '0001-01-01', 0),
(20, 28, 17, 'Per Kwh', 15, NULL, 89.96, 1, 2, 1, 2, '2020-09-30', 0),
(24, 33, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(25, 34, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(26, 35, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(27, 36, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(28, 37, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(29, 38, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(30, 39, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(31, 40, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(32, 41, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(33, 42, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(34, 43, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(36, 54, 67, 'test', 2, NULL, 1, 5, 10, 4, 3, '2020-09-30', 0),
(37, 30, 67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(38, 56, 48, '#', 30, NULL, 10000, 50, 30, 0, 0, '2020-09-30', 0);

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
(23, 35, 3, 300, 20),
(26, 47, 16, NULL, NULL),
(27, 44, 15, 5, 20760),
(27, 47, 16, 10, 70),
(28, 50, 17, 5, 17.3),
(30, 70, 67, 100, 10),
(30, 110, 67, 0, 200),
(40, 86, 67, NULL, NULL),
(40, 88, 67, NULL, NULL),
(44, 91, 67, 100, 10),
(46, 94, 41, 10, 212.76),
(48, 95, -1, 0, 851.05),
(48, 96, 41, 10, 212.76),
(49, 97, -1, 0, 851.05),
(49, 98, 41, 10, 212.76),
(50, 99, -1, 0, 851.05),
(50, 100, 41, 10, 212.76),
(51, 101, -1, 0, 851.05),
(51, 102, 41, 10, 212.76),
(52, 104, 41, 10, 212.76),
(53, 106, 41, 10, 212.76),
(54, 107, 67, 100, 10),
(72, 0, 67, 100, 10),
(73, 0, -1, NULL, NULL),
(74, 0, 67, 100, 10),
(75, 0, -1, NULL, NULL),
(76, 0, 67, 100, 10),
(77, 0, -1, NULL, NULL),
(78, 0, 67, 100, 10),
(79, 0, -1, NULL, NULL),
(80, 0, 67, 100, 10),
(81, 0, -1, NULL, NULL),
(82, 0, 67, 100, 10),
(83, 0, -1, NULL, NULL),
(84, 0, 67, 100, 10),
(85, 0, -1, NULL, NULL),
(86, 0, 67, 100, 10),
(87, 0, -1, NULL, NULL);

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
(19, 21, 11, NULL, NULL),
(20, 28, 17, 1, 10),
(88, 27, 16, 3, 10),
(90, 30, 67, 3, 20);

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
(23, 17, 3, 40, NULL, 100, 4, 5),
(26, 29, 16, NULL, NULL, NULL, NULL, NULL),
(27, 26, 15, 5, NULL, 1730, 5, 0),
(27, 29, 16, 5, NULL, 10, 3, 0),
(27, 30, 16, 150, NULL, 0, 1, 0),
(28, 32, 17, 15, NULL, 3.46, 1, 2),
(29, 54, 15, 20, NULL, 10, 2, 5),
(30, 55, 66, NULL, NULL, NULL, NULL, NULL),
(30, 55, 67, 5, NULL, 5, 5, 5),
(30, 56, -1, NULL, NULL, NULL, NULL, NULL),
(30, 100, 67, NULL, NULL, NULL, NULL, NULL),
(30, 101, 67, NULL, NULL, NULL, NULL, NULL),
(40, 75, -1, NULL, NULL, NULL, NULL, NULL),
(40, 76, 67, NULL, NULL, NULL, NULL, NULL),
(44, 0, 66, NULL, NULL, NULL, NULL, 82),
(46, 84, 41, 10, NULL, 8.51, 0, 0),
(48, 85, -1, 15, NULL, 8.51, 5, 5),
(48, 86, 41, 10, NULL, 8.51, 0, 0),
(49, 87, -1, 15, NULL, 8.51, 5, 5),
(49, 88, 41, 10, NULL, 8.51, 0, 0),
(50, 89, -1, 15, NULL, 8.51, 5, 5),
(50, 90, 41, 10, NULL, 8.51, 0, 0),
(51, 91, -1, 15, NULL, 8.51, 5, 5),
(51, 92, 41, 10, NULL, 8.51, 0, 0),
(52, 94, 41, 10, NULL, 8.51, 0, 0),
(53, 96, 41, 10, NULL, 8.51, 0, 0),
(54, 97, 66, NULL, NULL, NULL, NULL, NULL),
(57, 0, 66, NULL, NULL, NULL, NULL, NULL),
(58, 0, 67, 5, NULL, 5, 5, 5),
(59, 0, -1, NULL, NULL, NULL, NULL, NULL),
(60, 0, 66, NULL, NULL, NULL, NULL, NULL),
(61, 0, 67, 5, NULL, 5, 5, 5),
(62, 0, -1, NULL, NULL, NULL, NULL, NULL),
(63, 0, 66, NULL, NULL, NULL, NULL, NULL),
(64, 0, 67, 5, NULL, 5, 5, 5),
(65, 0, -1, NULL, NULL, NULL, NULL, NULL),
(66, 0, 66, NULL, NULL, NULL, NULL, NULL),
(67, 0, -1, NULL, NULL, NULL, NULL, NULL),
(68, 0, 66, NULL, NULL, NULL, NULL, NULL),
(69, 0, -1, NULL, NULL, NULL, NULL, NULL),
(70, 0, 66, NULL, NULL, NULL, NULL, NULL),
(71, 0, -1, NULL, NULL, NULL, NULL, NULL),
(72, 0, 66, NULL, NULL, NULL, NULL, NULL),
(73, 0, -1, NULL, NULL, NULL, NULL, NULL),
(74, 0, 66, NULL, NULL, NULL, NULL, NULL),
(75, 0, -1, NULL, NULL, NULL, NULL, NULL);

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
(12, 21, 11, NULL, NULL, NULL, NULL),
(13, 28, 17, 'y', 1, 2, 5),
(20, 27, 16, '1', 2, 5, 3),
(22, 30, 67, NULL, NULL, NULL, NULL);

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
  `revenue_start_date` date NOT NULL DEFAULT '0001-01-01',
  `ramp_up_duration` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_proj`,`id_item`,`id_uc`),
  KEY `id_item` (`id_item`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_revenues`
--

INSERT INTO `input_revenues` (`id_proj`, `id_item`, `id_uc`, `volume`, `ratio`, `revenues_per_unit`, `annual_variation_volume`, `annual_variation_unitcost`, `revenue_start_date`, `ramp_up_duration`) VALUES
(1, 1, 1, 5, NULL, 2, 0, 0, '0001-01-01', 0),
(4, 1, 1, 16, 1, 0, 0, 0, '0001-01-01', 0),
(4, 3, 2, 453, NULL, 54, 54, 5, '0001-01-01', 0),
(4, 4, 3, 78, NULL, 2, 45, 12, '0001-01-01', 0),
(4, 6, 2, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(4, 13, 11, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(8, 1, 1, 5, NULL, 5, 5, 6, '0001-01-01', 0),
(8, 2, 1, 50, NULL, 1500, 3, 1, '0001-01-01', 0),
(8, 8, 11, 35, NULL, 255, 0, 2, '0001-01-01', 0),
(8, 9, 11, 50, NULL, 15000, 1, 3, '0001-01-01', 0),
(8, 10, 11, 100, NULL, 300, 2, 1, '0001-01-01', 0),
(8, 11, 11, 33, NULL, 20, 5, 3, '0001-01-01', 0),
(21, 12, -1, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(21, 12, 9, 15, NULL, 300, 3, 5, '2020-09-30', 2),
(21, 15, 11, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(23, 14, 3, 100, NULL, 30, 5, 5, '0001-01-01', 0),
(26, 17, 16, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(27, 17, 16, 2, NULL, 1, 4, 3, '2020-10-16', 4),
(28, 22, 17, 5, NULL, 20.76, 1, 5, '2020-09-30', 0),
(29, 23, 22, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(30, 27, 33, 0, NULL, 0, 0, 0, '2020-10-01', 2),
(30, 61, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(44, 0, 67, NULL, NULL, NULL, NULL, 59, '0001-01-01', 0),
(51, 0, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(52, 0, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(53, 0, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(54, 0, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(54, 60, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(55, 0, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(56, 0, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(57, 0, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(58, 0, 67, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0);

-- --------------------------------------------------------

--
-- Structure de la table `input_revenuesprotection`
--

DROP TABLE IF EXISTS `input_revenuesprotection`;
CREATE TABLE IF NOT EXISTS `input_revenuesprotection` (
  `id_item` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  `current_revenues` float DEFAULT '0',
  `impact` int(11) DEFAULT '0',
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_revenuesprotection`
--

INSERT INTO `input_revenuesprotection` (`id_item`, `id_proj`, `id_uc`, `current_revenues`, `impact`) VALUES
(15, 30, 67, 10, 20),
(2, 33, 67, 10, 15),
(3, 34, 67, 10, 15),
(4, 35, 67, 10, 15),
(5, 36, 67, 10, 15),
(6, 37, 67, 10, 15),
(7, 38, 67, 10, 15),
(8, 39, 67, 10, 15),
(9, 40, 67, 10, 15),
(10, 41, 67, 10, 15),
(11, 42, 67, 10, 15),
(12, 43, 67, 10, 15),
(0, 44, 67, 13, 15),
(14, 54, 67, 10, 15);

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
(13, 21, 11, NULL, NULL),
(54, 28, 17, 2, 50),
(55, 27, 16, 3, 20),
(57, 30, 67, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `input_supplier_revenues`
--

DROP TABLE IF EXISTS `input_supplier_revenues`;
CREATE TABLE IF NOT EXISTS `input_supplier_revenues` (
  `id_item` int(10) UNSIGNED NOT NULL,
  `id_proj` int(10) UNSIGNED NOT NULL,
  `id_uc` int(10) NOT NULL,
  `unit_cost` float DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  `margin` float DEFAULT NULL,
  `anVarVol` int(11) DEFAULT NULL,
  `anVarCost` int(11) DEFAULT NULL,
  `revenue_start_date` date DEFAULT NULL,
  `ramp_up_duration` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_supplier_revenues`
--

INSERT INTO `input_supplier_revenues` (`id_item`, `id_proj`, `id_uc`, `unit_cost`, `volume`, `margin`, `anVarVol`, `anVarCost`, `revenue_start_date`, `ramp_up_duration`) VALUES
(1, 21, 9, 0, 0, 0, 0, 0, '2021-12-09', 3),
(2, 21, 9, 1500, 50, 50, 0, 0, '0001-01-01', 0),
(3, 21, 9, 15, 0, 10, 5, 3, '0001-01-01', 0),
(4, 21, 7, 1500, 300, 15, 0, 0, '0001-01-01', 0),
(5, 23, 3, 100, 100, 10, 0, 0, '0001-01-01', 0),
(6, 23, 3, 150, 10, 10, 0, 0, '0001-01-01', 0),
(7, 23, 3, 3500, 1, 10, 0, 5, '0001-01-01', 0),
(8, 21, 0, 0, 0, 0, 0, 0, '0001-01-01', 0),
(9, 21, -1, 5, 10, 0, 0, 0, '0001-01-01', 0),
(9, 21, 0, 0, 0, 0, 0, 0, '0001-01-01', 0),
(10, 21, -1, 10, 5, 0, 1, 2, '0001-01-01', 0),
(10, 21, 0, 0, 0, 0, 0, 0, '0001-01-01', 0),
(11, 21, 0, 0, 0, 0, 0, 0, '0001-01-01', 0),
(12, 21, 0, 0, 0, 0, 0, 0, '0001-01-01', 0),
(13, 21, -1, 200, 300, 0, 0, 0, '2020-10-16', 1),
(14, 21, -1, 0, 0, 0, 0, 0, '2020-10-14', 1),
(15, 24, 9, 0, 0, 0, 0, 0, '0001-01-01', 0),
(16, 24, -1, 10, 200, 0, 0, 0, '0001-01-01', 0),
(17, 24, -1, 20, 20, 0, 0, 0, '0001-01-01', 0),
(18, 24, -1, 30, 10, 0, 0, 0, '0001-01-01', 0),
(19, 21, 11, 0, 0, 0, 0, 0, '0001-01-01', 0),
(20, 21, 11, 0, 0, 0, 0, 0, '0001-01-01', 0),
(21, 21, 11, 0, 0, 0, 0, 0, '0001-01-01', 0),
(22, 29, -1, 100, 20, 0, 0, 0, '0001-01-01', 0),
(23, 29, -1, 20, 30, 0, 1, 2, '0001-01-01', 0),
(24, 29, 22, 300, 10, 0, 0, 0, '0001-01-01', 0),
(30, 30, 67, 10, 10, 0, 0, 0, '0001-01-01', 0),
(31, 30, 67, 15, 15, 0, 0, 0, '0001-01-01', 0),
(32, 30, 67, 5, 50, 0, 0, 0, '0001-01-01', 0),
(33, 30, 67, 10, 10, 0, 0, 0, '0001-01-01', 0),
(34, 30, 66, 1200, 3000, 0, 0, 0, '0001-01-01', 0),
(35, 30, 67, 5, 10, 0, 0, 5, '0001-01-01', 0),
(42, 46, 41, 1702.1, 10, 0, 0, 0, '0001-01-01', 0),
(43, 46, 41, 212.76, 10, 0, 0, 0, '0001-01-01', 0),
(44, 46, 41, 851.05, 0, 0, 0, 0, '0001-01-01', 0),
(45, 46, 41, 1702.1, 0, 0, 0, 0, '0001-01-01', 0),
(47, 49, -1, 851.05, 0, 0, 0, 0, '0001-01-01', 0),
(48, 49, -1, 1702.1, 1, 0, 0, 0, '0001-01-01', 0),
(49, 49, -1, 2553.15, 1, 0, 0, 0, '0001-01-01', 0),
(50, 49, 41, 1702.1, 10, 0, 0, 0, '0001-01-01', 0),
(51, 49, 41, 212.76, 10, 0, 0, 0, '0001-01-01', 0),
(52, 49, 41, 851.05, 0, 0, 0, 0, '0001-01-01', 0),
(53, 49, 41, 1702.1, 0, 0, 0, 0, '0001-01-01', 0),
(54, 50, -1, 851.05, 0, 0, 0, 0, '0001-01-01', 0),
(55, 50, -1, 1702.1, 1, 0, 0, 0, '0001-01-01', 0),
(56, 50, -1, 2553.15, 1, 0, 0, 0, '0001-01-01', 0),
(57, 50, 41, 1702.1, 10, 0, 0, 0, '0001-01-01', 0),
(58, 50, 41, 212.76, 10, 0, 0, 0, '0001-01-01', 0),
(59, 50, 41, 851.05, 0, 0, 0, 0, '0001-01-01', 0),
(60, 50, 41, 1702.1, 0, 0, 0, 0, '0001-01-01', 0),
(64, 46, 41, 0, 0, 0, 0, 0, '0001-01-01', 0),
(64, 51, 41, 1702.1, 10, 0, 0, 0, '0001-01-01', 0),
(65, 51, 41, 212.76, 10, 0, 0, 0, '0001-01-01', 0),
(66, 51, 41, 851.05, 0, 0, 0, 0, '0001-01-01', 0),
(67, 51, 41, 1702.1, 0, 0, 0, 0, '0001-01-01', 0),
(71, 52, 41, 1702.1, 10, 0, 0, 0, '0001-01-01', 0),
(72, 52, 41, 212.76, 10, 0, 0, 0, '0001-01-01', 0),
(73, 52, 41, 851.05, 0, 0, 0, 0, '0001-01-01', 0),
(74, 52, 41, 1702.1, 0, 0, 0, 0, '0001-01-01', 0),
(78, 53, 41, 1702.1, 10, 0, 0, 0, '0001-01-01', 0),
(79, 53, 41, 212.76, 10, 0, 0, 0, '0001-01-01', 0),
(80, 53, 41, 851.05, 0, 0, 0, 0, '0001-01-01', 0),
(81, 53, 41, 1702.1, 0, 0, 0, 0, '0001-01-01', 0),
(82, 54, -1, 10, 0, 0, 0, 0, '0001-01-01', 0),
(83, 54, 67, 10, 10, 0, 0, 0, '0001-01-01', 0),
(84, 54, 67, 15, 15, 0, 0, 0, '0001-01-01', 0),
(85, 54, 67, 5, 50, 0, 0, 0, '0001-01-01', 0),
(86, 54, 67, 10, 10, 0, 0, 0, '0001-01-01', 0),
(87, 54, 67, 5, 10, 0, 0, 5, '0001-01-01', 0),
(92, 30, 62, 10, 1200, NULL, 0, 0, NULL, NULL);

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
  `revenue_start_date` date NOT NULL DEFAULT '0001-01-01',
  `ramp_up_duration` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_widercash`
--

INSERT INTO `input_widercash` (`id_item`, `id_proj`, `id_uc`, `unit_indicator`, `volume`, `ratio`, `unit_cost`, `volume_reduc`, `unit_cost_reduc`, `annual_var_volume`, `annual_var_unit_cost`, `revenue_start_date`, `ramp_up_duration`) VALUES
(1, 1, 1, 'per blabla', 0, NULL, 0, 0, 0, 0, 0, '0001-01-01', 0),
(1, 4, 1, 'per example', 578, 36, 0, 0, 0, 0, 0, '0001-01-01', 0),
(1, 6, 1, 'per example', 10, NULL, 20, 4, 5, 40, 2, '0001-01-01', 0),
(1, 8, 1, 'per example', 5, NULL, 10, 1, 2, 4, 4, '0001-01-01', 0),
(2, 1, 1, 'per oiuhrf', 0, NULL, 0, 0, 0, 0, 0, '0001-01-01', 0),
(2, 4, 1, 'per example', 13, 1, 0, 0, 0, 0, 0, '0001-01-01', 0),
(2, 8, 1, 'per example', 500, NULL, 2, 2, 2, 7, 5, '0001-01-01', 0),
(3, 4, 3, 'per unit', 54, NULL, 43, 4, 32, 4, 4, '0001-01-01', 0),
(4, 4, 2, 'FTR', 54, NULL, 32, 35, 7, 65, 56, '0001-01-01', 0),
(5, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(6, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(8, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(9, 8, 11, 'SI', 50, NULL, 12, 1, 2, 2, 1, '0001-01-01', 0),
(10, 8, 11, 'SI', 1200, NULL, 15, 50, 30, 4, 5, '0001-01-01', 0),
(11, 8, 11, 'SI', 15, NULL, 200, 10, 50, 0, 2, '0001-01-01', 0),
(12, 21, 9, 'test', 15, NULL, 10000, 5, 30, 6, 10, '0001-01-01', 0),
(14, 23, 3, 'CO2', 1000, NULL, 1, 30, 0, 0, 0, '0001-01-01', 0),
(15, 21, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(17, 26, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(17, 27, 15, 'Per Ton of carbon', 30, NULL, 86.5, 2, 10, 30, 0, '0001-01-01', 0),
(18, 28, 17, 'Per Ton of carbon', 1, NULL, 3.46, 5, 6, 1, 2, '2020-09-30', 0),
(26, 27, 16, '1', 3, NULL, 2, 2, 3, 5, 4, '2020-09-30', 0),
(28, 30, 67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001-01-01', 0),
(29, 30, 62, 'test', 1200, NULL, 30, 30, 40, 13, 2, '2020-09-30', 0);

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
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `measure`
--

INSERT INTO `measure` (`id`, `name`, `description`, `user`, `group_id`) VALUES
(0, 'Project Overlay', NULL, 0, 0),
(21, 'Smart Lighting', '', 0, 0),
(22, 'Building retrofit', '', 0, 0),
(25, 'NTT Accelerate Smart Solutions', '', 16, 0),
(31, 'Intelligente Workplace', '', 16, 1);

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
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `noncash_item`
--

INSERT INTO `noncash_item` (`id`, `name`, `description`, `sources`, `cat`) VALUES
(1, 'non cash benefits 1', '', NULL, 0),
(2, 'non cash benefits 2', '', NULL, 0),
(3, 'custom item ncb 1', '', NULL, 0),
(4, 'non cash', '', NULL, 0),
(5, 'NNCASH', '', NULL, 0),
(6, 'hivordfkjn', 'bgfkjbxn', NULL, 0),
(7, 'bvuid', 'vfdx', NULL, 0),
(8, 'testestest', 'vfd', NULL, 0),
(9, 'Bonheur', '', NULL, 0),
(10, 'non cash item', '', NULL, 0),
(11, 'NCB 1', '', NULL, 0),
(12, 'NCB 2', '', NULL, 0),
(13, 'NCB 3', '', NULL, 0),
(14, 'nan cash item 0', '', NULL, 0),
(15, 'nan cash item 1', '', NULL, 0),
(16, 'non cash', '', NULL, 0),
(17, 'wellbeing', '', NULL, 0),
(18, 'ncb', '', NULL, 0),
(19, 'nc', '', NULL, 0),
(20, 'non cashj', '', NULL, 0),
(21, 'Parks', '', NULL, 0),
(22, 'Parks', '', NULL, 0),
(23, 'Parks', '', NULL, 0),
(24, 'Parks', '', NULL, 0),
(25, 'Parks', '', NULL, 0),
(26, 'Parks', '', NULL, 0),
(27, 'Offices', '', NULL, 0),
(28, 'Offices', '', NULL, 0),
(29, 'Offices', '', NULL, 0),
(30, 'Factory/Manufact.', '', NULL, 0),
(31, 'Factory/Manufact.', '', NULL, 0),
(32, 'Factory/Manufact.', '', NULL, 0),
(33, 'Retail / Malls / Small shops', '', NULL, 0),
(34, 'Public Areas/Plazas', '', NULL, 0),
(35, 'Public Areas/Plazas', '', NULL, 0),
(36, 'Public Areas/Plazas', '', NULL, 0),
(37, 'Public Areas/Plazas', '', NULL, 0),
(38, 'Public Areas/Plazas', '', NULL, 0),
(39, 'Event, Cultural & Sports Facilities', '', NULL, 0),
(40, 'Event, Cultural & Sports Facilities', '', NULL, 0),
(41, 'Retail / Malls / Small shops', '', NULL, 0),
(42, 'Public Roads', '', NULL, 0),
(43, 'Private Roads', '', NULL, 0),
(44, 'Public Roads', '', NULL, 0),
(45, 'Public Roads', '', NULL, 0),
(46, 'Public Roads', '', NULL, 0),
(47, 'Private Roads', '', NULL, 0),
(48, 'Private Roads', '', NULL, 0),
(49, 'Private Roads', '', NULL, 0),
(50, 'Public Roads', '', NULL, 0),
(51, 'Public Roads', '', NULL, 0),
(52, 'Public Areas/Plazas', '', NULL, 0),
(53, 'Public Areas/Plazas', '', NULL, 0),
(54, 'Airports', '', NULL, 0),
(55, 'Airports', '', NULL, 0),
(56, 'Parks', '', NULL, 0),
(57, 'Parks', '', NULL, 0),
(58, 'Retail / Malls / Small shops', '', NULL, 0),
(59, 'Retail / Malls / Small shops', '', NULL, 0),
(60, 'Event, Cultural & Sports Facilities', '', NULL, 0),
(61, 'Event, Cultural & Sports Facilities', '', NULL, 0),
(62, 'Offices', '', NULL, 0),
(63, 'Offices', '', NULL, 0),
(64, 'Airports', '', NULL, 0),
(65, 'Airports', '', NULL, 0),
(66, 'Parks', '', NULL, 0),
(67, 'Parks', '', NULL, 0),
(68, 'Retail / Malls / Small shops', '', NULL, 0),
(69, 'Retail / Malls / Small shops', '', NULL, 0),
(70, 'Event, Cultural & Sports Facilities', '', NULL, 0),
(71, 'Event, Cultural & Sports Facilities', '', NULL, 0),
(72, 'Factory/Manufact.', '', NULL, 0),
(73, 'Factory/Manufact.', '', NULL, 0),
(74, 'Offices', '', NULL, 0),
(75, 'Offices', '', NULL, 0),
(76, 'Offices', '', NULL, 0),
(77, 'Offices', '', NULL, 0),
(78, 'Factory/Manufact.', '', NULL, 0),
(79, 'Factory/Manufact.', '', NULL, 0),
(80, 'Factory/Manufact.', '', NULL, 0),
(81, 'Factory/Manufact.', '', NULL, 0),
(82, 'Retail / Malls / Small shops', '', NULL, 0),
(83, 'Retail / Malls / Small shops', '', NULL, 0),
(84, 'Event, Cultural & Sports Facilities', '', NULL, 0),
(85, 'Event, Cultural & Sports Facilities', '', NULL, 0),
(86, 'Offices', '', NULL, 0),
(87, 'Offices', '', NULL, 0),
(88, 'gg', '', NULL, 0),
(90, 'NCI 01', '', NULL, 58);

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
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

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
(17, 23),
(88, 27),
(89, 27),
(20, 28),
(90, 30);

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
(19, 11),
(88, 16),
(89, 16),
(20, 17),
(21, 32),
(22, 32),
(23, 32),
(24, 32),
(25, 32),
(26, 32),
(27, 33),
(28, 33),
(29, 33),
(30, 34),
(31, 34),
(32, 34),
(33, 35),
(34, 36),
(35, 36),
(36, 36),
(37, 36),
(38, 36),
(39, 38),
(40, 38),
(41, 39),
(42, 42),
(43, 43),
(44, 44),
(45, 44),
(46, 44),
(47, 45),
(48, 45),
(49, 45),
(50, 49),
(51, 49),
(52, 50),
(53, 50),
(54, 51),
(55, 51),
(56, 52),
(57, 52),
(58, 53),
(59, 53),
(60, 54),
(61, 54),
(62, 55),
(63, 55),
(64, 56),
(65, 56),
(66, 57),
(67, 57),
(68, 58),
(69, 58),
(70, 59),
(71, 59),
(72, 60),
(73, 60),
(74, 61),
(75, 61),
(76, 62),
(77, 62),
(78, 63),
(79, 63),
(80, 64),
(81, 64),
(82, 65),
(83, 65),
(84, 66),
(85, 66),
(86, 67),
(87, 67),
(90, 67);

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
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=519 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_item`
--

INSERT INTO `opex_item` (`id`, `name`, `description`, `origine`, `side`, `unit`, `cat`) VALUES
(1, 'opexitem1', '', 'from_ntt', 'projDev', NULL, 0),
(2, 'opex item 2', '', 'from_ntt', 'projDev', NULL, 0),
(3, 'uc2 opex', '', 'from_ntt', 'projDev', NULL, 0),
(4, 'TEST OPEX ITEM', '10H 10 MARS', 'from_ntt', 'projDev', NULL, 0),
(5, 'OPEX', '', 'from_ntt', 'projDev', NULL, 0),
(6, 'electricity', '', 'internal', 'projDev', NULL, 0),
(7, 'Project Manager', '', 'from_ntt', 'projDev', NULL, 0),
(8, 'Project Manager', '', 'from_ntt', 'projDev', NULL, 0),
(9, 'Opex 1', '', 'internal', 'projDev', NULL, 0),
(10, 'Opex common test', '', 'from_ntt', 'projDev', NULL, 0),
(11, 'opex common', '', 'from_ntt', 'projDev', NULL, 0),
(12, 'opex test', '', 'from_ntt', 'projDev', NULL, 0),
(13, 'opex 01', '', 'from_ntt', 'supplier', '', 0),
(14, 'Data analytics', 'Analysis of traffic', 'from_ntt', 'supplier', NULL, 0),
(15, 'Support services', 'Maintenace of equipment', 'from_outside_ntt', 'supplier', NULL, 0),
(16, 'Maintenace', '', 'internal', 'customer', NULL, 0),
(17, 'C', '', 'from_ntt', 'customer', NULL, 0),
(18, 'op', '', 'from_ntt', 'supplier', 'test', 0),
(19, 'opex', '', 'from_ntt', 'supplier', NULL, 0),
(20, 'opexopex', '', 'from_ntt', 'customer', NULL, 0),
(21, 'Maintenance of the pole', '', 'from_ntt', 'projDev', NULL, 0),
(22, 'Maintenance of smart lamppost', '', 'from_ntt', 'projDev', NULL, 0),
(23, 'Maintenance of LED Bulb and electric system', '', 'from_ntt', 'projDev', NULL, 0),
(24, 'Maintenance of the Electrical systems', '', 'from_ntt', 'projDev', NULL, 0),
(25, 'Maintenance of the control boxes', '', 'from_ntt', 'projDev', NULL, 0),
(26, 'Software maintenance', '', 'from_ntt', 'projDev', NULL, 0),
(27, 'Maintenance of the box gateway', '', 'from_ntt', 'projDev', NULL, 0),
(28, 'Maintenance of the EV charging point', '', 'from_ntt', 'projDev', NULL, 0),
(29, 'Data and transactions run costs ', '', 'from_ntt', 'projDev', '', 0),
(30, 'Electricity cost', '', 'from_ntt', 'projDev', '', 0),
(31, 'Maintenance of the PV panel', '', 'from_ntt', 'projDev', NULL, 0),
(32, 'Maintenance of the battery & remote control', '', 'from_ntt', 'projDev', NULL, 0),
(33, 'Maintenance of the battery &remote control', '', 'from_ntt', 'projDev', NULL, 0),
(34, 'Maintenance of the CCTV monitor', '', 'from_ntt', 'projDev', NULL, 0),
(35, 'Maintenance of the CCTV camera', '', 'from_ntt', 'projDev', NULL, 0),
(36, 'Maintenance of the DVR (Digital Video Recorder) and monitor', '', 'from_ntt', 'projDev', NULL, 0),
(37, 'Maintenance of the PTT device', '', 'from_ntt', 'projDev', NULL, 0),
(38, 'Maintenance of the public speakers', '', 'from_ntt', 'projDev', NULL, 0),
(39, 'Maintenance of the Air Quality Sensor', '', 'from_ntt', 'projDev', NULL, 0),
(40, 'Maintenance of the software', '', 'from_ntt', 'projDev', NULL, 0),
(41, 'Maintenance of the noise sensor', '', 'from_ntt', 'projDev', NULL, 0),
(42, 'Maintenance of the software', '', 'from_ntt', 'projDev', NULL, 0),
(43, 'Maintenance of the water level sensor', '', 'from_ntt', 'projDev', NULL, 0),
(44, 'Maintenance of the software', '', 'from_ntt', 'projDev', NULL, 0),
(45, 'Maintenance of the banner', '', 'from_ntt', 'projDev', NULL, 0),
(46, 'Maintenance of the sensor', '', 'from_ntt', 'projDev', NULL, 0),
(47, 'Maintenance of the software', '', 'from_ntt', 'projDev', NULL, 0),
(48, 'Maintenance of the sensor', '', 'from_ntt', 'projDev', NULL, 0),
(49, 'Maintenance of the Data collector', '', 'from_ntt', 'projDev', NULL, 0),
(50, 'Maintenance of local parking guidance system ', '', 'from_ntt', 'projDev', NULL, 0),
(51, 'Maintenance of the sensor', '', 'from_ntt', 'projDev', NULL, 0),
(52, 'Maintenance of the Antenna', '', 'from_ntt', 'projDev', NULL, 0),
(53, 'Maintenance of the Antenna', '', 'from_ntt', 'projDev', NULL, 0),
(54, 'op', '', 'from_ntt', 'supplier', '', 0),
(55, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(57, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(58, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(59, 'Sensor maintenance', '', 'internal', 'supplier', NULL, 25),
(60, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(61, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(62, 'Sensor maintenance', '', 'internal', 'supplier', NULL, 25),
(63, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(64, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(65, 'Sensor maintenance', '', 'internal', 'supplier', NULL, 25),
(66, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(67, 'Sensor maintenance', '', 'internal', 'supplier', NULL, 25),
(68, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(69, 'Sensor maintenance', '', 'internal', 'supplier', NULL, 25),
(70, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(71, 'Sensor maintenance', '', 'internal', 'supplier', NULL, 25),
(72, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(73, 'Sensor maintenance', '', 'internal', 'supplier', NULL, 25),
(74, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(75, 'Sensor maintenance', '', 'internal', 'supplier', NULL, 25),
(76, 'item 03', '', 'from_ntt', 'customer', NULL, 29),
(79, 'iyem', '', 'from_outside_ntt', 'supplier', NULL, 35),
(80, 'itaze', '', 'from_outside_ntt', 'supplier', NULL, 36),
(82, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(84, 'Maintenance Sensor 1', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 51),
(85, 'Maintenance Sensor A', '', 'from_outside_ntt', 'supplier', 'per sensor', 0),
(86, 'Maintenance Sensor 1', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(87, 'Maintenance Sensor A', '', 'from_outside_ntt', 'supplier', 'per sensor', 0),
(88, 'Maintenance Sensor 1', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(89, 'Maintenance Sensor A', '', 'from_outside_ntt', 'supplier', 'per sensor', 0),
(90, 'Maintenance Sensor 1', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(91, 'Maintenance Sensor A', '', 'from_outside_ntt', 'supplier', 'per sensor', 0),
(92, 'Maintenance Sensor 1', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 0),
(94, 'Maintenance Sensor 1', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 51),
(96, 'Maintenance Sensor 1', '', 'from_outside_ntt', 'supplier', '#FTEs-days', 51),
(97, 'op', '', 'from_ntt', 'supplier', 'Number', 19),
(99, 'test dc 2', '', 'from_ntt', 'projDev', NULL, 29),
(100, 'test 3', '', 'from_ntt', 'projDev', NULL, 60),
(101, 'test 126', '', 'from_ntt', 'projDev', NULL, 60),
(102, 'O&N - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(103, 'O&N - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(104, 'O&N - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(105, 'O&N - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(106, 'O&N - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(107, 'O&N - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(108, 'O&N - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(109, 'O&N - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(110, 'O&N - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(111, 'O&N - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(112, 'O&N - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(113, 'O&N - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(114, 'O&N - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(115, 'O&N - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(116, 'O&N - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(117, 'O&N - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(118, 'O&N - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(119, 'O&N - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(120, 'O&N - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(121, 'O&N - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(122, 'O&N - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(123, 'O&N - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(124, 'O&N - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(125, 'O&N - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(126, 'O&N - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(127, 'O&N - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(128, 'O&N - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(129, 'O&N - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(130, 'O&N - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(131, 'O&N - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(132, 'O&N - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(133, 'O&N - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(134, 'O&N - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(135, 'O&N - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(136, 'O&N - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(137, 'O&N - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(138, 'O&N - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(139, 'O&N - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(140, 'O&N - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(141, 'O&N - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(142, 'O&N - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(143, 'O&N - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(144, 'O&N - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(145, 'O&N - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(146, 'O&N - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(147, 'O&N - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(148, 'O&N - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(149, 'O&N - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(150, 'O&N - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(151, 'O&N - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(152, 'O&N - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(153, 'O&N - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(154, 'O&N - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(155, 'O&N - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(156, 'O&N - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(157, 'O&N - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(158, 'O&N - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(159, 'O&N - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(160, 'O&N - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(161, 'O&N - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(162, 'O&N - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(163, 'O&N - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(164, 'O&N - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(165, 'O&N - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(166, 'O&N - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(167, 'O&N - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(168, 'O&N - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(169, 'O&N - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(170, 'O&N - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(171, 'O&N - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(172, 'O&N - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(173, 'O&N - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(174, 'O&N - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(175, 'O&N - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(176, 'O&N - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(177, 'O&N - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(178, 'O&N - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(179, 'O&N - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(180, 'O&N - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(181, 'O&N - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(182, 'O&N - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(183, 'O&N - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(184, 'O&N - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(185, 'O&N - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(186, 'O&N - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(187, 'O&N - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(188, 'O&N - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(189, 'O&N - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(190, 'O&N - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(191, 'O&N - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(192, 'O&N - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(193, 'O&N - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(194, 'O&N - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(195, 'O&N - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(196, 'O&N - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(197, 'O&N - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(198, 'O&N - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(199, 'O&N - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(200, 'O&N - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(201, 'O&N - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(202, 'O&N - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(203, 'O&N - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(204, 'O&N - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(205, 'O&N - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(206, 'O&N - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(207, 'O&N - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(208, 'O&N - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(209, 'O&N - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(210, 'O&N - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(211, 'O&N - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(212, 'O&N - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(213, 'O&N - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(214, 'O&N - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(215, 'O&N - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(216, 'O&N - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(217, 'O&N - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(218, 'O&N - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(219, 'O&N - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(220, 'O&N - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(221, 'O&N - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(222, 'O&N - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(223, 'O&N - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(224, 'O&N - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(225, 'O&N - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(226, 'O&N - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(227, 'O&N - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(228, 'O&N - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(229, 'O&N - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(230, 'O&N - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(231, 'O&N - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(232, 'O&N - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(233, 'O&N - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(234, 'O&N - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(235, 'O&N - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(236, 'O&N - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(237, 'O&N - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(238, 'O&N - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(239, 'O&N - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(240, 'O&N - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(241, 'O&N - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(242, 'O&N - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(243, 'O&N - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(244, 'O&N - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(245, 'O&N - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(246, 'O&N - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(247, 'O&N - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(248, 'O&N - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(249, 'O&N - ASU Range 2001 - 2100 - PaaS', '', 'from_ntt', 'projDev', NULL, 163),
(250, 'O&N - ASU Range 2001 - 2100 - PaaS', '', 'from_ntt', 'projDev', NULL, 153),
(251, 'O&N - ASU Range 2001 - 2100 - PaaS', '', 'from_ntt', 'projDev', NULL, 183),
(252, 'O&N - ASU Range 2001 - 2100 - PaaS', '', 'from_ntt', 'projDev', NULL, 143),
(253, 'O&N - ASU Range 2001 - 2100 - PaaS', '', 'from_ntt', 'projDev', NULL, 193),
(254, 'O&N - ASU Range 2001 - 2100 - PaaS', '', 'from_ntt', 'projDev', NULL, 137),
(255, 'O&N - ASU Range 2001 - 2100 - PaaS', '', 'from_ntt', 'projDev', NULL, 173),
(256, 'MP - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(257, 'MP - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(258, 'MP - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(259, 'MP - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(260, 'MP - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(261, 'MP - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(262, 'MP - ASU Range 101 - 150 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(263, 'MP - ASU Range 101 - 150 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(264, 'MP - ASU Range 101 - 150 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(265, 'MP - ASU Range 151 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(266, 'MP - ASU Range 151 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(267, 'MP - ASU Range 151 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(268, 'MP - ASU Range 201 - 250 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(269, 'MP - ASU Range 201 - 250 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(270, 'MP - ASU Range 201 - 250 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(271, 'MP - ASU Range 251 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(272, 'MP - ASU Range 251 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(273, 'MP - ASU Range 251 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(274, 'MP - ASU Range 301 - 350 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(275, 'MP - ASU Range 301 - 350 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(276, 'MP - ASU Range 301 - 350 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(277, 'MP - ASU Range 351 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(278, 'MP - ASU Range 351 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(279, 'MP - ASU Range 351 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(280, 'MP - ASU Range 401 - 450 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(281, 'MP - ASU Range 401 - 450 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(282, 'MP - ASU Range 401 - 450 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(283, 'MP - ASU Range 451 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(284, 'MP - ASU Range 451 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(285, 'MP - ASU Range 451 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(286, 'MP - ASU Range 501 - 550 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(287, 'MP - ASU Range 501 - 550 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(288, 'MP - ASU Range 501 - 550 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(289, 'MP - ASU Range 551 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(290, 'MP - ASU Range 551 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(291, 'MP - ASU Range 551 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(292, 'MP - ASU Range 601 - 650 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(293, 'MP - ASU Range 601 - 650 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(294, 'MP - ASU Range 601 - 650 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(295, 'MP - ASU Range 651 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(296, 'MP - ASU Range 651 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(297, 'MP - ASU Range 651 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(298, 'MP - ASU Range 701 - 750 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(299, 'MP - ASU Range 701 - 750 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(300, 'MP - ASU Range 701 - 750 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(301, 'MP - ASU Range 751 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(302, 'MP - ASU Range 751 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(303, 'MP - ASU Range 751 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(304, 'MP - ASU Range 801 - 850 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(305, 'MP - ASU Range 801 - 850 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(306, 'MP - ASU Range 801 - 850 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(307, 'MP - ASU Range 851 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(308, 'MP - ASU Range 851 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(309, 'MP - ASU Range 851 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(310, 'MP - ASU Range 901 - 950 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(311, 'MP - ASU Range 901 - 950 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(312, 'MP - ASU Range 901 - 950 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(313, 'MP - ASU Range 951 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(314, 'MP - ASU Range 951 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(315, 'MP - ASU Range 951 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(316, 'MP - ASU Range 1001 - 1050 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(317, 'MP - ASU Range 1001 - 1050 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(318, 'MP - ASU Range 1001 - 1050 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(319, 'MP - ASU Range 1051 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(320, 'MP - ASU Range 1051 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(321, 'MP - ASU Range 1051 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(322, 'MP - ASU Range 1101 - 1150 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(323, 'MP - ASU Range 1101 - 1150 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(324, 'MP - ASU Range 1101 - 1150 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(325, 'MP - ASU Range 1151 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(326, 'MP - ASU Range 1151 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(327, 'MP - ASU Range 1151 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(328, 'MP - ASU Range 1201 - 1250 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(329, 'MP - ASU Range 1201 - 1250 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(330, 'MP - ASU Range 1201 - 1250 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(331, 'MP - ASU Range 1251 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(332, 'MP - ASU Range 1251 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(333, 'MP - ASU Range 1251 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(334, 'MP - ASU Range 1301 - 1350 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(335, 'MP - ASU Range 1301 - 1350 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(336, 'MP - ASU Range 1301 - 1350 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(337, 'MP - ASU Range 1351 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(338, 'MP - ASU Range 1351 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(339, 'MP - ASU Range 1351 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(340, 'MP - ASU Range 1401 - 1450 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(341, 'MP - ASU Range 1401 - 1450 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(342, 'MP - ASU Range 1401 - 1450 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(343, 'MP - ASU Range 1451 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(344, 'MP - ASU Range 1451 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(345, 'MP - ASU Range 1451 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(346, 'MP - ASU Range 1501 - 1550 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(347, 'MP - ASU Range 1501 - 1550 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(348, 'MP - ASU Range 1501 - 1550 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(349, 'MP - ASU Range 1551 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(350, 'MP - ASU Range 1551 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(351, 'MP - ASU Range 1551 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(352, 'MP - ASU Range 1601 - 1650 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(353, 'MP - ASU Range 1601 - 1650 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(354, 'MP - ASU Range 1601 - 1650 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(355, 'MP - ASU Range 1651 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(356, 'MP - ASU Range 1651 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(357, 'MP - ASU Range 1651 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(358, 'MP - ASU Range 1701 - 1750 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(359, 'MP - ASU Range 1701 - 1750 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(360, 'MP - ASU Range 1701 - 1750 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(361, 'MP - ASU Range 1751 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(362, 'MP - ASU Range 1751 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(363, 'MP - ASU Range 1751 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(364, 'MP - ASU Range 1801 - 1850 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(365, 'MP - ASU Range 1801 - 1850 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(366, 'MP - ASU Range 1801 - 1850 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(367, 'MP - ASU Range 1851 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(368, 'MP - ASU Range 1851 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(369, 'MP - ASU Range 1851 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(370, 'MP - ASU Range 1901 - 1950 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(371, 'MP - ASU Range 1901 - 1950 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(372, 'MP - ASU Range 1901 - 1950 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(373, 'MP - ASU Range 1951 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 81),
(374, 'MP - ASU Range 1951 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 91),
(375, 'MP - ASU Range 1951 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 75),
(376, 'WWD - ASU Range 3 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(377, 'WWD - ASU Range 3 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(378, 'WWD - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(379, 'WWD - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(380, 'WWD - ASU Range 101 - 150 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(381, 'WWD - ASU Range 101 - 150 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(382, 'WWD - ASU Range 151 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(383, 'WWD - ASU Range 151 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(384, 'WWD - ASU Range 201 - 250 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(385, 'WWD - ASU Range 201 - 250 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(386, 'WWD - ASU Range 251 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(387, 'WWD - ASU Range 251 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(388, 'WWD - ASU Range 301 - 350 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(389, 'WWD - ASU Range 301 - 350 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(390, 'WWD - ASU Range 351 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(391, 'WWD - ASU Range 351 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(392, 'WWD - ASU Range 401 - 450 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(393, 'WWD - ASU Range 401 - 450 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(394, 'WWD - ASU Range 451 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(395, 'WWD - ASU Range 451 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(396, 'WWD - ASU Range 501 - 550 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(397, 'WWD - ASU Range 501 - 550 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(398, 'WWD - ASU Range 551 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(399, 'WWD - ASU Range 551 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(400, 'WWD - ASU Range 601 - 650 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(401, 'WWD - ASU Range 601 - 650 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(402, 'WWD - ASU Range 651 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(403, 'WWD - ASU Range 651 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(404, 'WWD - ASU Range 701 - 750 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(405, 'WWD - ASU Range 701 - 750 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(406, 'WWD - ASU Range 751 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(407, 'WWD - ASU Range 751 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(408, 'WWD - ASU Range 801 - 850 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(409, 'WWD - ASU Range 801 - 850 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(410, 'WWD - ASU Range 851 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(411, 'WWD - ASU Range 851 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(412, 'WWD - ASU Range 901 - 950 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(413, 'WWD - ASU Range 901 - 950 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(414, 'WWD - ASU Range 951 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(415, 'WWD - ASU Range 951 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(416, 'WWD - ASU Range 1001 - 1050 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(417, 'WWD - ASU Range 1001 - 1050 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(418, 'WWD - ASU Range 1051 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(419, 'WWD - ASU Range 1051 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(420, 'WWD - ASU Range 1101 - 1150 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(421, 'WWD - ASU Range 1101 - 1150 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(422, 'WWD - ASU Range 1151 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(423, 'WWD - ASU Range 1151 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(424, 'WWD - ASU Range 1201 - 1250 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(425, 'WWD - ASU Range 1201 - 1250 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(426, 'WWD - ASU Range 1251 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(427, 'WWD - ASU Range 1251 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(428, 'WWD - ASU Range 1301 - 1350 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(429, 'WWD - ASU Range 1301 - 1350 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(430, 'WWD - ASU Range 1351 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(431, 'WWD - ASU Range 1351 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(432, 'WWD - ASU Range 1401 - 1450 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(433, 'WWD - ASU Range 1401 - 1450 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(434, 'WWD - ASU Range 1451 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(435, 'WWD - ASU Range 1451 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(436, 'WWD - ASU Range 1501 - 1550 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(437, 'WWD - ASU Range 1501 - 1550 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(438, 'WWD - ASU Range 1551 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(439, 'WWD - ASU Range 1551 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(440, 'WWD - ASU Range 1601 - 1650 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(441, 'WWD - ASU Range 1601 - 1650 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(442, 'WWD - ASU Range 1651 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(443, 'WWD - ASU Range 1651 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(444, 'WWD - ASU Range 1701 - 1750 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(445, 'WWD - ASU Range 1701 - 1750 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(446, 'WWD - ASU Range 1751 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(447, 'WWD - ASU Range 1751 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(448, 'WWD - ASU Range 1801 - 1850 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(449, 'WWD - ASU Range 1801 - 1850 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(450, 'WWD - ASU Range 1851 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(451, 'WWD - ASU Range 1851 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(452, 'WWD - ASU Range 1901 - 1950 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(453, 'WWD - ASU Range 1901 - 1950 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(454, 'WWD - ASU Range 1951 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 281),
(455, 'WWD - ASU Range 1951 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 275),
(456, 'TVC - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(457, 'TVC - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(458, 'TVC - ASU Range 1 - 50 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(459, 'TVC - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(460, 'TVC - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(461, 'TVC - ASU Range 51 - 100 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(462, 'TVC - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(463, 'TVC - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(464, 'TVC - ASU Range 101 - 200 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(465, 'TVC - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(466, 'TVC - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(467, 'TVC - ASU Range 201 - 300 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(468, 'TVC - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(469, 'TVC - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(470, 'TVC - ASU Range 301 - 400 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(471, 'TVC - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(472, 'TVC - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(473, 'TVC - ASU Range 401 - 500 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(474, 'TVC - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(475, 'TVC - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(476, 'TVC - ASU Range 501 - 600 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(477, 'TVC - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(478, 'TVC - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(479, 'TVC - ASU Range 601 - 700 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(480, 'TVC - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(481, 'TVC - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(482, 'TVC - ASU Range 701 - 800 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(483, 'TVC - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(484, 'TVC - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(485, 'TVC - ASU Range 801 - 900 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(486, 'TVC - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(487, 'TVC - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(488, 'TVC - ASU Range 901 - 1000 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(489, 'TVC - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(490, 'TVC - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(491, 'TVC - ASU Range 1001 - 1100 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(492, 'TVC - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(493, 'TVC - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(494, 'TVC - ASU Range 1101 - 1200 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(495, 'TVC - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(496, 'TVC - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(497, 'TVC - ASU Range 1201 - 1300 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(498, 'TVC - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(499, 'TVC - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(500, 'TVC - ASU Range 1301 - 1400 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(501, 'TVC - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(502, 'TVC - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(503, 'TVC - ASU Range 1401 - 1500 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(504, 'TVC - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(505, 'TVC - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(506, 'TVC - ASU Range 1501 - 1600 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(507, 'TVC - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(508, 'TVC - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(509, 'TVC - ASU Range 1601 - 1700 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(510, 'TVC - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(511, 'TVC - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(512, 'TVC - ASU Range 1701 - 1800 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(513, 'TVC - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(514, 'TVC - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(515, 'TVC - ASU Range 1801 - 1900 - PaaS', '', 'from_ntt', 'projDev', NULL, 213),
(516, 'TVC - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 229),
(517, 'TVC - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 219),
(518, 'TVC - ASU Range 1901 - 2000 - PaaS', '', 'from_ntt', 'projDev', NULL, 213);

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
  `default_cost` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=519 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_item_advice`
--

INSERT INTO `opex_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`, `default_cost`) VALUES
(1, 'per ...', NULL, 5, 8, 0),
(2, 'per ...', NULL, 2, 3, 0),
(3, 'per tructruc', NULL, 5, 4, 0),
(4, 'per blabla', '', 5, 6, 0),
(5, 'per bla', NULL, 2, 5, 0),
(21, 'Per Pole', 'https://www.streetlights-solar.com/2018/07/19/cost-comparison-between-solar-vs-traditional-lights/', 5, 15, 0),
(22, 'Per smart Lampost', 'Internal research', 8, 23, 0),
(23, 'Per LED light', 'http://www.nyc.gov/html/dot/html/infrastructure/streetlights.shtml', 3, 4, 0),
(24, 'Per cabling system', 'Internal research', 3, 7, 0),
(25, 'Per sensor', 'Internal research', 6, 12, 0),
(26, 'Per software', 'Internal research', 312, 1062, 0),
(27, 'Per gateway', 'http://democracy.cityoflondon.gov.uk/documents/s63133/Street%20Lighting%20Review%20G3-4%20Report%20-%20Final.pdf', 90, 275, 0),
(28, 'Per charging point', 'https://www.ohmhomenow.com/electric-vehicles/ev-charging-station-cost/\n', 7, 20, 0),
(29, 'Per charging point', 'https://www.preciseparklink.com/news/top-10-benefits-of-installing-ev-chargers-in-ontario\n', 20, 25, 0),
(30, 'Per EV charging point', 'https://www.reminetwork.com/articles/the-benefits-of-ev-charging-stations/\n', 270, 300, 0),
(31, 'Per PV panel', 'https://info.lightinus.com/solar-street-lights#solar_street_light_applications', 9, 11, 0),
(32, 'Per battery', 'Internal research', 4, 8, 0),
(33, 'Per battery', 'Internal research', 6, 11, 0),
(34, 'Per CCTV', 'Internal research', 2, 5, 0),
(35, 'Per CCTV camera', 'https://www.thumbtack.com/p/security-camera-installation-cost', 6, 19, 0),
(36, 'Per DVR/NVR', 'https://householdquotes.co.uk/cctv-installation/', 30, 55, 0),
(37, 'Per PTT device', 'Internal research', 4, 25, 0),
(38, 'Per public speakers', 'Internal research', 1, 3, 0),
(39, 'Per sensor', 'Internal research', 3, 4, 0),
(40, 'Per software', 'Internal research', 14, 64, 0),
(41, 'Per sensor', 'Internal research', 3, 4, 0),
(42, 'Per software', 'Internal research', 14, 64, 0),
(43, 'Per sensor', 'Internal research', 3, 4, 0),
(44, 'Per Software', 'Internal research', 14, 64, 0),
(45, 'Per banner', 'Internal research', 5, 8, 0),
(46, 'Per traffic sensor', 'https://www.quora.com/What-are-typical-maintenance-fees-as-a-percentage-of-up-front-license-costs-for-enterprise-software', 90, 290, 0),
(47, 'Per software', 'https://blog.capterra.com/how-much-does-network-monitoring-software-cost/', 8, 24, 0),
(48, 'Per sensor', 'Internal research', 5, 8, 0),
(49, 'Per gateway', 'Internal research', 7, 11, 0),
(50, 'Per guidance system', 'Internal research', 2, 5, 0),
(51, 'Per Wifi sensor', 'Internal research', 4, 5, 0),
(52, 'Per Antennas', 'Internal research', 5, 10, 0),
(53, 'Per 5G antenna', 'Internal research', 5, 10, 0),
(99, '', '', 0, 0, 125),
(100, '', '', 0, 0, 0),
(101, '', '', 0, 0, 126),
(102, '#', '', 0, 0, 22042),
(103, '#', '', 0, 0, 22042),
(104, '#', '', 0, 0, 22042),
(105, '#', '', 0, 0, 22042),
(106, '#', '', 0, 0, 22042),
(107, '#', '', 0, 0, 22042),
(108, '#', '', 0, 0, 22042),
(109, '#', '', 0, 0, 34882),
(110, '#', '', 0, 0, 34882),
(111, '#', '', 0, 0, 34882),
(112, '#', '', 0, 0, 34882),
(113, '#', '', 0, 0, 34882),
(114, '#', '', 0, 0, 34882),
(115, '#', '', 0, 0, 34882),
(116, '#', '', 0, 0, 37236),
(117, '#', '', 0, 0, 37236),
(118, '#', '', 0, 0, 37236),
(119, '#', '', 0, 0, 37236),
(120, '#', '', 0, 0, 37236),
(121, '#', '', 0, 0, 37236),
(122, '#', '', 0, 0, 37236),
(123, '#', '', 0, 0, 51788),
(124, '#', '', 0, 0, 51788),
(125, '#', '', 0, 0, 51788),
(126, '#', '', 0, 0, 51788),
(127, '#', '', 0, 0, 51788),
(128, '#', '', 0, 0, 51788),
(129, '#', '', 0, 0, 51788),
(130, '#', '', 0, 0, 54142),
(131, '#', '', 0, 0, 54142),
(132, '#', '', 0, 0, 54142),
(133, '#', '', 0, 0, 54142),
(134, '#', '', 0, 0, 54142),
(135, '#', '', 0, 0, 54142),
(136, '#', '', 0, 0, 54142),
(137, '#', '', 0, 0, 106144),
(138, '#', '', 0, 0, 106144),
(139, '#', '', 0, 0, 106144),
(140, '#', '', 0, 0, 106144),
(141, '#', '', 0, 0, 106144),
(142, '#', '', 0, 0, 106144),
(143, '#', '', 0, 0, 106144),
(144, '#', '', 0, 0, 108498),
(145, '#', '', 0, 0, 108498),
(146, '#', '', 0, 0, 108498),
(147, '#', '', 0, 0, 108498),
(148, '#', '', 0, 0, 108498),
(149, '#', '', 0, 0, 108498),
(150, '#', '', 0, 0, 108498),
(151, '#', '', 0, 0, 123050),
(152, '#', '', 0, 0, 123050),
(153, '#', '', 0, 0, 123050),
(154, '#', '', 0, 0, 123050),
(155, '#', '', 0, 0, 123050),
(156, '#', '', 0, 0, 123050),
(157, '#', '', 0, 0, 123050),
(158, '#', '', 0, 0, 125404),
(159, '#', '', 0, 0, 125404),
(160, '#', '', 0, 0, 125404),
(161, '#', '', 0, 0, 125404),
(162, '#', '', 0, 0, 125404),
(163, '#', '', 0, 0, 125404),
(164, '#', '', 0, 0, 125404),
(165, '#', '', 0, 0, 147446),
(166, '#', '', 0, 0, 147446),
(167, '#', '', 0, 0, 147446),
(168, '#', '', 0, 0, 147446),
(169, '#', '', 0, 0, 147446),
(170, '#', '', 0, 0, 147446),
(171, '#', '', 0, 0, 147446),
(172, '#', '', 0, 0, 149800),
(173, '#', '', 0, 0, 149800),
(174, '#', '', 0, 0, 149800),
(175, '#', '', 0, 0, 149800),
(176, '#', '', 0, 0, 149800),
(177, '#', '', 0, 0, 149800),
(178, '#', '', 0, 0, 149800),
(179, '#', '', 0, 0, 164352),
(180, '#', '', 0, 0, 164352),
(181, '#', '', 0, 0, 164352),
(182, '#', '', 0, 0, 164352),
(183, '#', '', 0, 0, 164352),
(184, '#', '', 0, 0, 164352),
(185, '#', '', 0, 0, 164352),
(186, '#', '', 0, 0, 177406),
(187, '#', '', 0, 0, 177406),
(188, '#', '', 0, 0, 177406),
(189, '#', '', 0, 0, 177406),
(190, '#', '', 0, 0, 177406),
(191, '#', '', 0, 0, 177406),
(192, '#', '', 0, 0, 177406),
(193, '#', '', 0, 0, 199448),
(194, '#', '', 0, 0, 199448),
(195, '#', '', 0, 0, 199448),
(196, '#', '', 0, 0, 199448),
(197, '#', '', 0, 0, 199448),
(198, '#', '', 0, 0, 199448),
(199, '#', '', 0, 0, 199448),
(200, '#', '', 0, 0, 201802),
(201, '#', '', 0, 0, 201802),
(202, '#', '', 0, 0, 201802),
(203, '#', '', 0, 0, 201802),
(204, '#', '', 0, 0, 201802),
(205, '#', '', 0, 0, 201802),
(206, '#', '', 0, 0, 201802),
(207, '#', '', 0, 0, 216354),
(208, '#', '', 0, 0, 216354),
(209, '#', '', 0, 0, 216354),
(210, '#', '', 0, 0, 216354),
(211, '#', '', 0, 0, 216354),
(212, '#', '', 0, 0, 216354),
(213, '#', '', 0, 0, 216354),
(214, '#', '', 0, 0, 218708),
(215, '#', '', 0, 0, 218708),
(216, '#', '', 0, 0, 218708),
(217, '#', '', 0, 0, 218708),
(218, '#', '', 0, 0, 218708),
(219, '#', '', 0, 0, 218708),
(220, '#', '', 0, 0, 218708),
(221, '#', '', 0, 0, 240750),
(222, '#', '', 0, 0, 240750),
(223, '#', '', 0, 0, 240750),
(224, '#', '', 0, 0, 240750),
(225, '#', '', 0, 0, 240750),
(226, '#', '', 0, 0, 240750),
(227, '#', '', 0, 0, 240750),
(228, '#', '', 0, 0, 243104),
(229, '#', '', 0, 0, 243104),
(230, '#', '', 0, 0, 243104),
(231, '#', '', 0, 0, 243104),
(232, '#', '', 0, 0, 243104),
(233, '#', '', 0, 0, 243104),
(234, '#', '', 0, 0, 243104),
(235, '#', '', 0, 0, 257656),
(236, '#', '', 0, 0, 257656),
(237, '#', '', 0, 0, 257656),
(238, '#', '', 0, 0, 257656),
(239, '#', '', 0, 0, 257656),
(240, '#', '', 0, 0, 257656),
(241, '#', '', 0, 0, 257656),
(242, '#', '', 0, 0, 260010),
(243, '#', '', 0, 0, 260010),
(244, '#', '', 0, 0, 260010),
(245, '#', '', 0, 0, 260010),
(246, '#', '', 0, 0, 260010),
(247, '#', '', 0, 0, 260010),
(248, '#', '', 0, 0, 260010),
(249, '#', '', 0, 0, 282052),
(250, '#', '', 0, 0, 282052),
(251, '#', '', 0, 0, 282052),
(252, '#', '', 0, 0, 282052),
(253, '#', '', 0, 0, 282052),
(254, '#', '', 0, 0, 282052),
(255, '#', '', 0, 0, 282052),
(256, '#', '', 0, 0, 9844),
(257, '#', '', 0, 0, 9844),
(258, '#', '', 0, 0, 9844),
(259, '#', '', 0, 0, 25038),
(260, '#', '', 0, 0, 25038),
(261, '#', '', 0, 0, 25038),
(262, '#', '', 0, 0, 34882),
(263, '#', '', 0, 0, 34882),
(264, '#', '', 0, 0, 34882),
(265, '#', '', 0, 0, 37236),
(266, '#', '', 0, 0, 37236),
(267, '#', '', 0, 0, 37236),
(268, '#', '', 0, 0, 47080),
(269, '#', '', 0, 0, 47080),
(270, '#', '', 0, 0, 47080),
(271, '#', '', 0, 0, 49434),
(272, '#', '', 0, 0, 49434),
(273, '#', '', 0, 0, 49434),
(274, '#', '', 0, 0, 59278),
(275, '#', '', 0, 0, 59278),
(276, '#', '', 0, 0, 59278),
(277, '#', '', 0, 0, 61632),
(278, '#', '', 0, 0, 61632),
(279, '#', '', 0, 0, 61632),
(280, '#', '', 0, 0, 101436),
(281, '#', '', 0, 0, 101436),
(282, '#', '', 0, 0, 101436),
(283, '#', '', 0, 0, 103790),
(284, '#', '', 0, 0, 103790),
(285, '#', '', 0, 0, 103790),
(286, '#', '', 0, 0, 113634),
(287, '#', '', 0, 0, 113634),
(288, '#', '', 0, 0, 113634),
(289, '#', '', 0, 0, 115988),
(290, '#', '', 0, 0, 115988),
(291, '#', '', 0, 0, 115988),
(292, '#', '', 0, 0, 125832),
(293, '#', '', 0, 0, 125832),
(294, '#', '', 0, 0, 125832),
(295, '#', '', 0, 0, 128186),
(296, '#', '', 0, 0, 128186),
(297, '#', '', 0, 0, 128186),
(298, '#', '', 0, 0, 138030),
(299, '#', '', 0, 0, 138030),
(300, '#', '', 0, 0, 138030),
(301, '#', '', 0, 0, 140384),
(302, '#', '', 0, 0, 140384),
(303, '#', '', 0, 0, 140384),
(304, '#', '', 0, 0, 150228),
(305, '#', '', 0, 0, 150228),
(306, '#', '', 0, 0, 150228),
(307, '#', '', 0, 0, 152582),
(308, '#', '', 0, 0, 152582),
(309, '#', '', 0, 0, 152582),
(310, '#', '', 0, 0, 162426),
(311, '#', '', 0, 0, 162426),
(312, '#', '', 0, 0, 162426),
(313, '#', '', 0, 0, 164780),
(314, '#', '', 0, 0, 164780),
(315, '#', '', 0, 0, 164780),
(316, '#', '', 0, 0, 174624),
(317, '#', '', 0, 0, 174624),
(318, '#', '', 0, 0, 174624),
(319, '#', '', 0, 0, 176978),
(320, '#', '', 0, 0, 176978),
(321, '#', '', 0, 0, 176978),
(322, '#', '', 0, 0, 197522),
(323, '#', '', 0, 0, 197522),
(324, '#', '', 0, 0, 197522),
(325, '#', '', 0, 0, 199876),
(326, '#', '', 0, 0, 199876),
(327, '#', '', 0, 0, 199876),
(328, '#', '', 0, 0, 209720),
(329, '#', '', 0, 0, 209720),
(330, '#', '', 0, 0, 209720),
(331, '#', '', 0, 0, 212074),
(332, '#', '', 0, 0, 212074),
(333, '#', '', 0, 0, 212074),
(334, '#', '', 0, 0, 221918),
(335, '#', '', 0, 0, 221918),
(336, '#', '', 0, 0, 221918),
(337, '#', '', 0, 0, 224272),
(338, '#', '', 0, 0, 224272),
(339, '#', '', 0, 0, 224272),
(340, '#', '', 0, 0, 234116),
(341, '#', '', 0, 0, 234116),
(342, '#', '', 0, 0, 234116),
(343, '#', '', 0, 0, 236470),
(344, '#', '', 0, 0, 236470),
(345, '#', '', 0, 0, 236470),
(346, '#', '', 0, 0, 246314),
(347, '#', '', 0, 0, 246314),
(348, '#', '', 0, 0, 246314),
(349, '#', '', 0, 0, 248668),
(350, '#', '', 0, 0, 248668),
(351, '#', '', 0, 0, 248668),
(352, '#', '', 0, 0, 258512),
(353, '#', '', 0, 0, 258512),
(354, '#', '', 0, 0, 258512),
(355, '#', '', 0, 0, 260866),
(356, '#', '', 0, 0, 260866),
(357, '#', '', 0, 0, 260866),
(358, '#', '', 0, 0, 270710),
(359, '#', '', 0, 0, 270710),
(360, '#', '', 0, 0, 270710),
(361, '#', '', 0, 0, 273064),
(362, '#', '', 0, 0, 273064),
(363, '#', '', 0, 0, 273064),
(364, '#', '', 0, 0, 282908),
(365, '#', '', 0, 0, 282908),
(366, '#', '', 0, 0, 282908),
(367, '#', '', 0, 0, 285262),
(368, '#', '', 0, 0, 285262),
(369, '#', '', 0, 0, 285262),
(370, '#', '', 0, 0, 295106),
(371, '#', '', 0, 0, 295106),
(372, '#', '', 0, 0, 295106),
(373, '#', '', 0, 0, 297460),
(374, '#', '', 0, 0, 297460),
(375, '#', '', 0, 0, 297460),
(376, '#', '', 0, 0, 12198),
(377, '#', '', 0, 0, 12198),
(378, '#', '', 0, 0, 29746),
(379, '#', '', 0, 0, 29746),
(380, '#', '', 0, 0, 41944),
(381, '#', '', 0, 0, 41944),
(382, '#', '', 0, 0, 46652),
(383, '#', '', 0, 0, 46652),
(384, '#', '', 0, 0, 58850),
(385, '#', '', 0, 0, 58850),
(386, '#', '', 0, 0, 63558),
(387, '#', '', 0, 0, 63558),
(388, '#', '', 0, 0, 75756),
(389, '#', '', 0, 0, 75756),
(390, '#', '', 0, 0, 80464),
(391, '#', '', 0, 0, 80464),
(392, '#', '', 0, 0, 122622),
(393, '#', '', 0, 0, 122622),
(394, '#', '', 0, 0, 127330),
(395, '#', '', 0, 0, 127330),
(396, '#', '', 0, 0, 139528),
(397, '#', '', 0, 0, 139528),
(398, '#', '', 0, 0, 144236),
(399, '#', '', 0, 0, 144236),
(400, '#', '', 0, 0, 156434),
(401, '#', '', 0, 0, 156434),
(402, '#', '', 0, 0, 161142),
(403, '#', '', 0, 0, 161142),
(404, '#', '', 0, 0, 173340),
(405, '#', '', 0, 0, 173340),
(406, '#', '', 0, 0, 178048),
(407, '#', '', 0, 0, 178048),
(408, '#', '', 0, 0, 190246),
(409, '#', '', 0, 0, 190246),
(410, '#', '', 0, 0, 194954),
(411, '#', '', 0, 0, 194954),
(412, '#', '', 0, 0, 207152),
(413, '#', '', 0, 0, 207152),
(414, '#', '', 0, 0, 211860),
(415, '#', '', 0, 0, 211860),
(416, '#', '', 0, 0, 224058),
(417, '#', '', 0, 0, 224058),
(418, '#', '', 0, 0, 228766),
(419, '#', '', 0, 0, 228766),
(420, '#', '', 0, 0, 251664),
(421, '#', '', 0, 0, 251664),
(422, '#', '', 0, 0, 256372),
(423, '#', '', 0, 0, 256372),
(424, '#', '', 0, 0, 268570),
(425, '#', '', 0, 0, 268570),
(426, '#', '', 0, 0, 273278),
(427, '#', '', 0, 0, 273278),
(428, '#', '', 0, 0, 285476),
(429, '#', '', 0, 0, 285476),
(430, '#', '', 0, 0, 290184),
(431, '#', '', 0, 0, 290184),
(432, '#', '', 0, 0, 302382),
(433, '#', '', 0, 0, 302382),
(434, '#', '', 0, 0, 307090),
(435, '#', '', 0, 0, 307090),
(436, '#', '', 0, 0, 319288),
(437, '#', '', 0, 0, 319288),
(438, '#', '', 0, 0, 323996),
(439, '#', '', 0, 0, 323996),
(440, '#', '', 0, 0, 336194),
(441, '#', '', 0, 0, 336194),
(442, '#', '', 0, 0, 340902),
(443, '#', '', 0, 0, 340902),
(444, '#', '', 0, 0, 353100),
(445, '#', '', 0, 0, 353100),
(446, '#', '', 0, 0, 357808),
(447, '#', '', 0, 0, 357808),
(448, '#', '', 0, 0, 370006),
(449, '#', '', 0, 0, 370006),
(450, '#', '', 0, 0, 374714),
(451, '#', '', 0, 0, 374714),
(452, '#', '', 0, 0, 386912),
(453, '#', '', 0, 0, 386912),
(454, '#', '', 0, 0, 391620),
(455, '#', '', 0, 0, 391620),
(456, '#', '', 0, 0, 12198),
(457, '#', '', 0, 0, 12198),
(458, '#', '', 0, 0, 12198),
(459, '#', '', 0, 0, 25038),
(460, '#', '', 0, 0, 25038),
(461, '#', '', 0, 0, 25038),
(462, '#', '', 0, 0, 29746),
(463, '#', '', 0, 0, 29746),
(464, '#', '', 0, 0, 29746),
(465, '#', '', 0, 0, 41944),
(466, '#', '', 0, 0, 41944),
(467, '#', '', 0, 0, 41944),
(468, '#', '', 0, 0, 46652),
(469, '#', '', 0, 0, 46652),
(470, '#', '', 0, 0, 46652),
(471, '#', '', 0, 0, 88810),
(472, '#', '', 0, 0, 88810),
(473, '#', '', 0, 0, 88810),
(474, '#', '', 0, 0, 93518),
(475, '#', '', 0, 0, 93518),
(476, '#', '', 0, 0, 93518),
(477, '#', '', 0, 0, 105716),
(478, '#', '', 0, 0, 105716),
(479, '#', '', 0, 0, 105716),
(480, '#', '', 0, 0, 110424),
(481, '#', '', 0, 0, 110424),
(482, '#', '', 0, 0, 110424),
(483, '#', '', 0, 0, 122622),
(484, '#', '', 0, 0, 122622),
(485, '#', '', 0, 0, 122622),
(486, '#', '', 0, 0, 127330),
(487, '#', '', 0, 0, 127330),
(488, '#', '', 0, 0, 127330),
(489, '#', '', 0, 0, 139528),
(490, '#', '', 0, 0, 139528),
(491, '#', '', 0, 0, 139528),
(492, '#', '', 0, 0, 154936),
(493, '#', '', 0, 0, 154936),
(494, '#', '', 0, 0, 154936),
(495, '#', '', 0, 0, 167134),
(496, '#', '', 0, 0, 167134),
(497, '#', '', 0, 0, 167134),
(498, '#', '', 0, 0, 171842),
(499, '#', '', 0, 0, 171842),
(500, '#', '', 0, 0, 171842),
(501, '#', '', 0, 0, 184040),
(502, '#', '', 0, 0, 184040),
(503, '#', '', 0, 0, 184040),
(504, '#', '', 0, 0, 188748),
(505, '#', '', 0, 0, 188748),
(506, '#', '', 0, 0, 188748),
(507, '#', '', 0, 0, 200946),
(508, '#', '', 0, 0, 200946),
(509, '#', '', 0, 0, 200946),
(510, '#', '', 0, 0, 205654),
(511, '#', '', 0, 0, 205654),
(512, '#', '', 0, 0, 205654),
(513, '#', '', 0, 0, 217852),
(514, '#', '', 0, 0, 217852),
(515, '#', '', 0, 0, 217852),
(516, '#', '', 0, 0, 222560),
(517, '#', '', 0, 0, 222560),
(518, '#', '', 0, 0, 222560);

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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

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
(17, 23),
(54, 29),
(55, 30),
(56, 30),
(98, 30),
(57, 33),
(58, 33),
(59, 33),
(60, 34),
(61, 34),
(62, 34),
(63, 35),
(64, 35),
(65, 35),
(66, 36),
(67, 36),
(68, 37),
(69, 37),
(70, 38),
(71, 38),
(72, 39),
(73, 39),
(74, 40),
(75, 40),
(76, 40),
(77, 40),
(78, 40),
(79, 40),
(80, 40),
(81, 40),
(82, 44),
(83, 46),
(84, 46),
(85, 48),
(86, 48),
(87, 49),
(88, 49),
(89, 50),
(90, 50),
(91, 51),
(92, 51),
(93, 52),
(94, 52),
(95, 53),
(96, 53),
(97, 54);

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
(15, 28, '2012-08-01', '2012-12-01', '2013-03-01', '2013-07-01', '2013-09-01', '2019-01-01'),
(16, 26, '2021-01-01', '2021-02-01', '2021-03-01', '2021-04-01', '2021-06-01', '2023-12-01'),
(16, 27, '2020-11-01', '2021-01-01', '2021-05-01', '2021-06-01', '2021-09-01', '2023-01-01'),
(17, 28, '2012-08-01', '2012-12-01', '2013-03-01', '2013-07-01', '2013-09-01', '2019-01-01');

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
(56, -1),
(59, -1),
(62, -1),
(65, -1),
(67, -1),
(69, -1),
(71, -1),
(73, -1),
(75, -1),
(77, -1),
(78, -1),
(79, -1),
(80, -1),
(81, -1),
(83, -1),
(85, -1),
(87, -1),
(89, -1),
(91, -1),
(93, -1),
(95, -1),
(98, -1),
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
(54, 15),
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
(53, 30),
(84, 41),
(86, 41),
(88, 41),
(90, 41),
(92, 41),
(94, 41),
(96, 41),
(55, 66),
(57, 66),
(60, 66),
(63, 66),
(66, 66),
(68, 66),
(70, 66),
(72, 66),
(74, 66),
(82, 66),
(97, 66),
(58, 67),
(61, 67),
(64, 67),
(76, 67),
(99, 67),
(100, 67),
(101, 67),
(256, 68),
(259, 68),
(262, 68),
(265, 68),
(268, 68),
(271, 68),
(274, 68),
(277, 68),
(280, 68),
(283, 68),
(286, 68),
(289, 68),
(292, 68),
(295, 68),
(298, 68),
(301, 68),
(304, 68),
(307, 68),
(310, 68),
(313, 68),
(316, 68),
(319, 68),
(322, 68),
(325, 68),
(328, 68),
(331, 68),
(334, 68),
(337, 68),
(340, 68),
(343, 68),
(346, 68),
(349, 68),
(352, 68),
(355, 68),
(358, 68),
(361, 68),
(364, 68),
(367, 68),
(370, 68),
(373, 68),
(257, 69),
(260, 69),
(263, 69),
(266, 69),
(269, 69),
(272, 69),
(275, 69),
(278, 69),
(281, 69),
(284, 69),
(287, 69),
(290, 69),
(293, 69),
(296, 69),
(299, 69),
(302, 69),
(305, 69),
(308, 69),
(311, 69),
(314, 69),
(317, 69),
(320, 69),
(323, 69),
(326, 69),
(329, 69),
(332, 69),
(335, 69),
(338, 69),
(341, 69),
(344, 69),
(347, 69),
(350, 69),
(353, 69),
(356, 69),
(359, 69),
(362, 69),
(365, 69),
(368, 69),
(371, 69),
(374, 69),
(258, 70),
(261, 70),
(264, 70),
(267, 70),
(270, 70),
(273, 70),
(276, 70),
(279, 70),
(282, 70),
(285, 70),
(288, 70),
(291, 70),
(294, 70),
(297, 70),
(300, 70),
(303, 70),
(306, 70),
(309, 70),
(312, 70),
(315, 70),
(318, 70),
(321, 70),
(324, 70),
(327, 70),
(330, 70),
(333, 70),
(336, 70),
(339, 70),
(342, 70),
(345, 70),
(348, 70),
(351, 70),
(354, 70),
(357, 70),
(360, 70),
(363, 70),
(366, 70),
(369, 70),
(372, 70),
(375, 70),
(102, 73),
(109, 73),
(116, 73),
(123, 73),
(130, 73),
(137, 73),
(144, 73),
(151, 73),
(158, 73),
(165, 73),
(172, 73),
(179, 73),
(186, 73),
(193, 73),
(200, 73),
(207, 73),
(214, 73),
(221, 73),
(228, 73),
(235, 73),
(242, 73),
(249, 73),
(103, 74),
(110, 74),
(117, 74),
(124, 74),
(131, 74),
(138, 74),
(145, 74),
(152, 74),
(159, 74),
(166, 74),
(173, 74),
(180, 74),
(187, 74),
(194, 74),
(201, 74),
(208, 74),
(215, 74),
(222, 74),
(229, 74),
(236, 74),
(243, 74),
(250, 74),
(104, 75),
(111, 75),
(118, 75),
(125, 75),
(132, 75),
(139, 75),
(146, 75),
(153, 75),
(160, 75),
(167, 75),
(174, 75),
(181, 75),
(188, 75),
(195, 75),
(202, 75),
(209, 75),
(216, 75),
(223, 75),
(230, 75),
(237, 75),
(244, 75),
(251, 75),
(105, 76),
(112, 76),
(119, 76),
(126, 76),
(133, 76),
(140, 76),
(147, 76),
(154, 76),
(161, 76),
(168, 76),
(175, 76),
(182, 76),
(189, 76),
(196, 76),
(203, 76),
(210, 76),
(217, 76),
(224, 76),
(231, 76),
(238, 76),
(245, 76),
(252, 76),
(106, 77),
(113, 77),
(120, 77),
(127, 77),
(134, 77),
(141, 77),
(148, 77),
(155, 77),
(162, 77),
(169, 77),
(176, 77),
(183, 77),
(190, 77),
(197, 77),
(204, 77),
(211, 77),
(218, 77),
(225, 77),
(232, 77),
(239, 77),
(246, 77),
(253, 77),
(107, 78),
(114, 78),
(121, 78),
(128, 78),
(135, 78),
(142, 78),
(149, 78),
(156, 78),
(163, 78),
(170, 78),
(177, 78),
(184, 78),
(191, 78),
(198, 78),
(205, 78),
(212, 78),
(219, 78),
(226, 78),
(233, 78),
(240, 78),
(247, 78),
(254, 78),
(108, 79),
(115, 79),
(122, 79),
(129, 79),
(136, 79),
(143, 79),
(150, 79),
(157, 79),
(164, 79),
(171, 79),
(178, 79),
(185, 79),
(192, 79),
(199, 79),
(206, 79),
(213, 79),
(220, 79),
(227, 79),
(234, 79),
(241, 79),
(248, 79),
(255, 79),
(456, 80),
(459, 80),
(462, 80),
(465, 80),
(468, 80),
(471, 80),
(474, 80),
(477, 80),
(480, 80),
(483, 80),
(486, 80),
(489, 80),
(492, 80),
(495, 80),
(498, 80),
(501, 80),
(504, 80),
(507, 80),
(510, 80),
(513, 80),
(516, 80),
(457, 81),
(460, 81),
(463, 81),
(466, 81),
(469, 81),
(472, 81),
(475, 81),
(478, 81),
(481, 81),
(484, 81),
(487, 81),
(490, 81),
(493, 81),
(496, 81),
(499, 81),
(502, 81),
(505, 81),
(508, 81),
(511, 81),
(514, 81),
(517, 81),
(458, 82),
(461, 82),
(464, 82),
(467, 82),
(470, 82),
(473, 82),
(476, 82),
(479, 82),
(482, 82),
(485, 82),
(488, 82),
(491, 82),
(494, 82),
(497, 82),
(500, 82),
(503, 82),
(506, 82),
(509, 82),
(512, 82),
(515, 82),
(518, 82),
(376, 85),
(378, 85),
(380, 85),
(382, 85),
(384, 85),
(386, 85),
(388, 85),
(390, 85),
(392, 85),
(394, 85),
(396, 85),
(398, 85),
(400, 85),
(402, 85),
(404, 85),
(406, 85),
(408, 85),
(410, 85),
(412, 85),
(414, 85),
(416, 85),
(418, 85),
(420, 85),
(422, 85),
(424, 85),
(426, 85),
(428, 85),
(430, 85),
(432, 85),
(434, 85),
(436, 85),
(438, 85),
(440, 85),
(442, 85),
(444, 85),
(446, 85),
(448, 85),
(450, 85),
(452, 85),
(454, 85),
(377, 86),
(379, 86),
(381, 86),
(383, 86),
(385, 86),
(387, 86),
(389, 86),
(391, 86),
(393, 86),
(395, 86),
(397, 86),
(399, 86),
(401, 86),
(403, 86),
(405, 86),
(407, 86),
(409, 86),
(411, 86),
(413, 86),
(415, 86),
(417, 86),
(419, 86),
(421, 86),
(423, 86),
(425, 86),
(427, 86),
(429, 86),
(431, 86),
(433, 86),
(435, 86),
(437, 86),
(439, 86),
(441, 86),
(443, 86),
(445, 86),
(447, 86),
(449, 86),
(451, 86),
(453, 86),
(455, 86);

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
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `discount_rate`, `weight_bank`, `weight_bank_soc`, `creation_date`, `modif_date`, `id_user`, `scoping`, `cb`, `hide`) VALUES
(7, 'SupplierZak', 'test', NULL, NULL, NULL, '2020-08-17 09:43:18', '2020-08-17 09:47:32', 10, 0, 0, 0),
(26, 'Montreal Area', '', 5, NULL, NULL, '2020-10-19 17:44:28', '2020-10-21 15:08:51', 1, 1, 0, 0),
(27, 'Montreal Area', '', 5, NULL, NULL, '2020-10-20 10:02:33', '2020-11-02 11:53:51', 13, 1, 1, 0),
(28, 'test no size', '', 5, NULL, NULL, '2020-10-23 15:44:02', '2020-10-23 16:20:32', 13, 1, 0, 0),
(29, 'my Proj', '', NULL, NULL, NULL, '2020-10-23 16:34:27', '2020-10-26 15:08:25', 15, 1, 0, 0),
(30, 'Las Vegas NTT Smart', '', NULL, NULL, NULL, '2020-10-26 17:04:17', '2020-11-26 12:21:27', 16, 1, 1, 0),
(32, 'Test number 2', 'Monday 09', NULL, NULL, NULL, '2020-11-09 13:46:52', '2020-11-12 11:50:47', 16, 1, 0, 0),
(46, 'SMART Bedrock ', '', NULL, NULL, NULL, '2020-11-16 14:48:30', '2020-11-19 12:20:23', 16, 1, 1, 0),
(54, 'Las Vegas NTT Smart copy', '', NULL, NULL, NULL, '2020-11-18 16:42:27', '2020-11-26 12:20:37', 16, 1, 1, 1),
(55, 'test', '', NULL, NULL, NULL, '2020-11-19 17:36:54', '2020-11-26 11:41:57', 16, 0, 0, 1),
(56, 'new test', '', NULL, NULL, NULL, '2020-11-26 11:42:06', '2020-11-26 15:50:27', 16, 1, 1, 1),
(57, 'test 2', '', NULL, NULL, NULL, '2020-11-27 14:20:31', '2020-11-27 14:21:17', 16, 0, 0, 0);

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
(21, '2020-09-15', 48, '2021-02-01', 10),
(23, '2021-01-04', 36, '2021-01-04', 6),
(24, '2017-01-01', 52, '2017-04-01', 6),
(29, '2020-10-01', 48, '2020-10-01', 6),
(30, '2020-10-01', 48, '2020-11-01', 6),
(33, '2020-10-01', 48, '2020-11-01', 6),
(34, '2020-10-01', 48, '2020-11-01', 6),
(35, '2020-10-01', 48, '2020-11-01', 6),
(36, '2020-10-01', 48, '2020-11-01', 6),
(37, '2020-10-01', 48, '2020-11-01', 6),
(38, '2020-10-01', 48, '2020-11-01', 6),
(39, '2020-10-01', 48, '2020-11-01', 6),
(40, '2020-10-01', 48, '2020-11-01', 6),
(41, '2020-10-01', 48, '2020-11-01', 6),
(42, '2020-10-01', 48, '2020-11-01', 6),
(43, '2020-10-01', 48, '2020-11-01', 6),
(44, '2020-10-01', 48, '2020-11-01', 6),
(45, '2020-11-01', 36, '2020-12-01', 6),
(46, '2020-11-01', 36, '2020-11-01', 6),
(48, '2020-11-01', 36, '2020-11-01', 6),
(49, '2020-11-01', 36, '2020-11-01', 6),
(50, '2020-11-01', 36, '2020-11-01', 6),
(51, '2020-11-01', 36, '2020-11-01', 6),
(52, '2020-11-01', 36, '2020-11-01', 6),
(53, '2020-11-01', 36, '2020-11-01', 6),
(54, '2020-11-01', 39, '2020-11-01', 7),
(55, '2020-11-01', 36, '2020-11-01', 6),
(56, '2020-11-01', 48, '2020-11-01', 6),
(57, '2020-11-01', 36, '2020-11-01', 6);

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
(1, 2),
(3, 2),
(4, 2),
(6, 2),
(8, 2),
(1, 3),
(4, 3),
(7, 3),
(8, 3),
(1, 4),
(3, 4),
(4, 4),
(6, 4),
(8, 4),
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
(28, 9),
(27, 10),
(26, 11),
(27, 11),
(28, 11),
(27, 13),
(27, 15),
(26, 16),
(27, 16),
(27, 17),
(26, 20),
(27, 20),
(28, 20),
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
(3, 3, '0001-01-01', 0, '0001-01-01', '0001-01-01', 0),
(21, 1, '0001-01-01', 0, '0001-01-01', '0001-01-01', 0),
(21, 2, '0001-01-01', 0, '0001-01-01', '0001-01-01', 0),
(21, 5, '0001-01-01', 0, '0001-01-01', '0001-01-01', 0),
(21, 7, '0001-01-01', 0, '0001-01-01', '0001-01-01', 0),
(21, 9, '2021-03-01', 3, '2023-06-01', '2021-05-01', 4),
(21, 11, '2021-02-01', 3, '2023-07-01', '2021-03-01', 3),
(23, 3, '0001-01-01', 0, '0001-01-01', '0001-01-01', 0),
(24, 9, '0001-01-01', 0, '0001-01-01', '0001-01-01', 0),
(29, 15, '2020-10-01', 3, '2024-09-01', '2020-12-01', 2),
(29, 22, '2020-10-01', 3, '2024-04-02', '2020-12-01', 3),
(30, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(30, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(30, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(30, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(30, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(30, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(30, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(33, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(33, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(33, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(33, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(33, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(33, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(33, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(34, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(34, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(34, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(34, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(34, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(34, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(34, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(35, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(35, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(35, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(35, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(35, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(35, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(35, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(36, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(36, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(36, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(36, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(36, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(36, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(36, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(37, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(37, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(37, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(37, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(37, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(37, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(37, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(38, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(38, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(38, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(38, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(38, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(38, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(38, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(39, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(39, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(39, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(39, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(39, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(39, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(39, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(40, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(40, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(40, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(40, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(40, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(40, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(40, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(41, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(41, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(41, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(41, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(41, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(41, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(41, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(42, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(42, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(42, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(42, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(42, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(42, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(42, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(43, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(43, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(43, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(43, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(43, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(43, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(43, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(44, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(44, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(44, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(44, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(44, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(44, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(44, 67, '2020-11-01', 6, '2024-10-01', '2020-11-01', 6),
(45, 48, '2020-12-01', 3, '2023-11-01', '2020-12-01', 5),
(46, 41, '2020-11-01', 6, '2023-11-01', '2020-11-01', 6),
(48, 41, '2020-11-01', 6, '2023-11-01', '2020-11-01', 6),
(49, 41, '2020-11-01', 6, '2023-11-01', '2020-11-01', 6),
(50, 41, '2020-11-01', 6, '2023-11-01', '2020-11-01', 6),
(51, 41, '2020-11-01', 6, '2023-11-01', '2020-11-01', 6),
(52, 41, '2020-11-01', 6, '2023-11-01', '2020-11-01', 6),
(53, 41, '2020-11-01', 6, '2023-11-01', '2020-11-01', 6),
(54, 33, '2020-10-01', 6, '2024-10-01', '2020-10-01', 6),
(54, 49, '2020-11-01', 4, '2024-10-01', '2020-11-01', 5),
(54, 50, '2020-11-01', 2, '2024-07-01', '2020-11-01', 4),
(54, 62, '2020-11-01', 5, '2023-12-01', '2020-11-01', 3),
(54, 65, '2020-11-01', 2, '2024-06-01', '2020-11-01', 3),
(54, 66, '2020-11-01', 5, '2024-03-01', '2020-11-01', 5),
(54, 67, '2020-11-01', 6, '2024-02-01', '2020-11-01', 6),
(56, 48, '2020-11-01', 3, '2024-11-01', '2020-11-01', 3),
(57, 90, '2020-11-01', 6, '2023-11-01', '2020-11-01', 6);

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
(15, 13, 2, 27),
(16, 13, 2, 27),
(15, 16, 2, 26),
(15, 16, 2, 27),
(16, 16, 2, 26),
(16, 16, 2, 27),
(15, 17, 2, 27),
(16, 17, 2, 27),
(15, 20, 2, 26),
(15, 20, 2, 27),
(16, 20, 2, 26),
(16, 20, 2, 27),
(15, 22, 2, 27),
(16, 22, 2, 27);

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
(28, 0),
(29, 0),
(30, 0),
(33, 0),
(34, 0),
(35, 0),
(36, 0),
(37, 0),
(38, 0),
(39, 0),
(40, 0),
(41, 0),
(42, 0),
(43, 0),
(44, 0),
(45, 0),
(46, 0),
(47, 0),
(48, 0),
(49, 0),
(50, 0),
(51, 0),
(52, 0),
(53, 0),
(54, 0),
(55, 0),
(56, 0),
(57, 0),
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
(27, 21),
(28, 21),
(29, 21),
(30, 25),
(33, 25),
(34, 25),
(35, 25),
(36, 25),
(37, 25),
(38, 25),
(39, 25),
(40, 25),
(41, 25),
(42, 25),
(43, 25),
(44, 25),
(45, 25),
(46, 25),
(47, 25),
(48, 25),
(49, 25),
(50, 25),
(51, 25),
(52, 25),
(53, 25),
(54, 25),
(55, 25),
(56, 25),
(57, 25);

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
(16, 27),
(-1, 28),
(15, 28),
(17, 28),
(-1, 29),
(15, 29),
(20, 29),
(22, 29),
(-1, 30),
(62, 30),
(64, 30),
(65, 30),
(66, 30),
(67, 30),
(-1, 33),
(33, 33),
(49, 33),
(50, 33),
(55, 33),
(56, 33),
(57, 33),
(58, 33),
(59, 33),
(60, 33),
(61, 33),
(62, 33),
(64, 33),
(65, 33),
(66, 33),
(67, 33),
(-1, 34),
(33, 34),
(49, 34),
(50, 34),
(55, 34),
(56, 34),
(57, 34),
(58, 34),
(59, 34),
(60, 34),
(61, 34),
(62, 34),
(64, 34),
(65, 34),
(66, 34),
(67, 34),
(-1, 35),
(33, 35),
(49, 35),
(50, 35),
(55, 35),
(56, 35),
(57, 35),
(58, 35),
(59, 35),
(60, 35),
(61, 35),
(62, 35),
(64, 35),
(65, 35),
(66, 35),
(67, 35),
(-1, 36),
(33, 36),
(49, 36),
(50, 36),
(55, 36),
(56, 36),
(57, 36),
(58, 36),
(59, 36),
(60, 36),
(61, 36),
(62, 36),
(64, 36),
(65, 36),
(66, 36),
(67, 36),
(-1, 37),
(33, 37),
(49, 37),
(50, 37),
(55, 37),
(56, 37),
(57, 37),
(58, 37),
(59, 37),
(60, 37),
(61, 37),
(62, 37),
(64, 37),
(65, 37),
(66, 37),
(67, 37),
(-1, 38),
(33, 38),
(49, 38),
(50, 38),
(55, 38),
(56, 38),
(57, 38),
(58, 38),
(59, 38),
(60, 38),
(61, 38),
(62, 38),
(64, 38),
(65, 38),
(66, 38),
(67, 38),
(-1, 39),
(33, 39),
(49, 39),
(50, 39),
(55, 39),
(56, 39),
(57, 39),
(58, 39),
(59, 39),
(60, 39),
(61, 39),
(62, 39),
(64, 39),
(65, 39),
(66, 39),
(67, 39),
(-1, 40),
(33, 40),
(49, 40),
(50, 40),
(55, 40),
(56, 40),
(57, 40),
(58, 40),
(59, 40),
(60, 40),
(61, 40),
(62, 40),
(64, 40),
(65, 40),
(66, 40),
(67, 40),
(-1, 41),
(33, 41),
(49, 41),
(50, 41),
(55, 41),
(56, 41),
(57, 41),
(58, 41),
(59, 41),
(60, 41),
(61, 41),
(62, 41),
(64, 41),
(65, 41),
(66, 41),
(67, 41),
(-1, 42),
(33, 42),
(49, 42),
(50, 42),
(55, 42),
(56, 42),
(57, 42),
(58, 42),
(59, 42),
(60, 42),
(61, 42),
(62, 42),
(64, 42),
(65, 42),
(66, 42),
(67, 42),
(-1, 43),
(33, 43),
(49, 43),
(50, 43),
(55, 43),
(56, 43),
(57, 43),
(58, 43),
(59, 43),
(60, 43),
(61, 43),
(62, 43),
(64, 43),
(65, 43),
(66, 43),
(67, 43),
(-1, 44),
(33, 44),
(49, 44),
(50, 44),
(55, 44),
(56, 44),
(57, 44),
(58, 44),
(59, 44),
(60, 44),
(61, 44),
(62, 44),
(64, 44),
(65, 44),
(66, 44),
(67, 44),
(-1, 45),
(48, 45),
(-1, 46),
(40, 46),
(41, 46),
(-1, 47),
(67, 47),
(-1, 48),
(40, 48),
(41, 48),
(-1, 49),
(40, 49),
(41, 49),
(-1, 50),
(40, 50),
(41, 50),
(-1, 51),
(40, 51),
(41, 51),
(-1, 52),
(40, 52),
(41, 52),
(-1, 53),
(40, 53),
(41, 53),
(-1, 54),
(33, 54),
(49, 54),
(50, 54),
(55, 54),
(56, 54),
(57, 54),
(58, 54),
(59, 54),
(60, 54),
(61, 54),
(62, 54),
(64, 54),
(65, 54),
(66, 54),
(67, 54),
(-1, 55),
(47, 55),
(48, 55),
(-1, 56),
(47, 56),
(48, 56),
(-1, 57),
(87, 57),
(89, 57),
(90, 57);

-- --------------------------------------------------------

--
-- Structure de la table `quantifiable_item`
--

DROP TABLE IF EXISTS `quantifiable_item`;
CREATE TABLE IF NOT EXISTS `quantifiable_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_item`
--

INSERT INTO `quantifiable_item` (`id`, `name`, `description`, `cat`) VALUES
(1, 'test', 'htyjh', 0),
(4, 'example quantifiable item', 'lorem ipsum', 0),
(6, 'Enfants dans les parcs', '', 0),
(7, 'Poissons dans l\'eau', '', 0),
(8, 'test', '', 0),
(9, 'test item', '', 0),
(10, 'number of accidents', '', 0),
(11, 'cvcv', '', 0),
(12, 'quant', '', 0),
(14, 'Parks', '', 0),
(15, 'Parks', '', 0),
(16, 'Retail / Malls / Small shops', '', 0),
(17, 'Airports', '', 0),
(18, 'Public Roads', '', 0),
(19, 'Private Roads', '', 0),
(20, 'er df', '', 0),
(22, 'QNMB', '', 57);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_item_advice`
--

INSERT INTO `quantifiable_item_advice` (`id`, `unit`, `source`, `range_min_red_nb`, `range_max_red_nb`) VALUES
(1, 'per ...', 'www.     .fr', 5, 10),
(2, 'tgrfe', 'btgrf', 1, 2),
(3, 'htgrfe', 'tbgrfe', 4, 5),
(4, 'per unit', 'www.google.com', 3, 100),
(14, 'Current # of  community activities held in premises each month', '', 20, 20),
(15, 'Current # of  volunteers hours spent in premises each month', '', 20, 20),
(16, '# of purchasing hours in store by visiting clients', '', -40, -88),
(17, 'Total time spent waiting in Transit by passengers (all)', '', -40, -88),
(18, 'Total time spent waiting by passengers (all)', '', -40, -88),
(19, 'Total time spent waiting by passengers (all)', '', -40, -88);

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

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
(10, 23),
(20, 27),
(21, 27),
(13, 28),
(22, 30);

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
(12, 11),
(20, 16),
(21, 16),
(13, 17),
(14, 32),
(15, 32),
(16, 35),
(17, 37),
(18, 44),
(19, 45),
(22, 67);

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenuesprotection_item`
--

INSERT INTO `revenuesprotection_item` (`id`, `name`, `description`, `unit`, `cat`) VALUES
(1, 'prot', '', NULL, 0),
(2, 'prot', '', NULL, 0),
(3, 'prot', '', NULL, 0),
(4, 'prot', '', NULL, 0),
(5, 'prot', '', NULL, 0),
(6, 'prot', '', NULL, 0),
(7, 'prot', '', NULL, 0),
(8, 'prot', '', NULL, 0),
(9, 'prot', '', NULL, 0),
(10, 'prot', '', NULL, 0),
(11, 'prot', '', NULL, 0),
(12, 'prot', '', NULL, 0),
(13, 'prot', '', NULL, 0),
(14, 'prot', '', NULL, 0),
(15, 'item test', '', NULL, 54);

-- --------------------------------------------------------

--
-- Structure de la table `revenuesprotection_item_user`
--

DROP TABLE IF EXISTS `revenuesprotection_item_user`;
CREATE TABLE IF NOT EXISTS `revenuesprotection_item_user` (
  `id` int(11) NOT NULL,
  `id_proj` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_proj`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenuesprotection_item_user`
--

INSERT INTO `revenuesprotection_item_user` (`id`, `id_proj`) VALUES
(1, 30),
(2, 33),
(3, 34),
(4, 35),
(5, 36),
(6, 37),
(7, 38),
(8, 39),
(9, 40),
(10, 41),
(11, 42),
(12, 43),
(13, 44),
(14, 54),
(15, 30);

-- --------------------------------------------------------

--
-- Structure de la table `revenuesprotection_uc`
--

DROP TABLE IF EXISTS `revenuesprotection_uc`;
CREATE TABLE IF NOT EXISTS `revenuesprotection_uc` (
  `id_item` int(11) NOT NULL,
  `id_uc` int(11) NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenuesprotection_uc`
--

INSERT INTO `revenuesprotection_uc` (`id_item`, `id_uc`) VALUES
(1, 67),
(2, 67),
(3, 67),
(4, 67),
(5, 67),
(6, 67),
(7, 67),
(8, 67),
(9, 67),
(10, 67),
(11, 67),
(12, 67),
(13, 67),
(14, 67),
(15, 67);

-- --------------------------------------------------------

--
-- Structure de la table `revenues_item`
--

DROP TABLE IF EXISTS `revenues_item`;
CREATE TABLE IF NOT EXISTS `revenues_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_item`
--

INSERT INTO `revenues_item` (`id`, `name`, `description`, `cat`) VALUES
(1, 'revenues item 1', '', 0),
(2, 'revenues item 2', '', 0),
(3, 'revenues item 3', '', 0),
(4, 'revenues item 4', '', 0),
(5, 'revenues item 5', '', 0),
(7, 'revenues from cost', 'ffff', 0),
(8, 'test', '', 0),
(9, 'rev 1', '', 0),
(10, 'rev 2', '', 0),
(11, 'rev 3', '', 0),
(12, 'test', '', 0),
(13, 'efh', '', 0),
(14, 'Rev1', '', 0),
(15, 'revenues', '', 0),
(16, 'User fee - Membership card', '', 0),
(17, 'Electricity charging fees', '', 0),
(18, 'Fees for parking-services', '', 0),
(19, 'Advertisement', '', 0),
(20, 'Access to Wifi point', '', 0),
(22, 'refv', '', 0),
(24, 'Parks', '', 0),
(25, 'Parks', '', 0),
(26, 'Parks', '', 0),
(27, 'Offices', '', 0),
(28, 'Factory/Manufact.', '', 0),
(29, 'Retail / Malls / Small shops', '', 0),
(30, 'Public Areas/Plazas', '', 0),
(31, 'Airports', '', 0),
(32, 'Event, Cultural & Sports Facilities', '', 0),
(33, 'Retail / Malls / Small shops', '', 0),
(34, 'Public Areas/Plazas', '', 0),
(35, 'Parks', '', 0),
(36, 'Public Roads', '', 0),
(37, 'Public Roads', '', 0),
(38, 'Private Roads', '', 0),
(39, 'Private Roads', '', 0),
(40, 'Public Roads', '', 0),
(41, 'Private Roads', '', 0),
(42, 'Public Areas/Plazas', '', 0),
(43, 'Public Roads', '', 0),
(44, 'Private Roads', '', 0),
(45, 'Public Roads', '', 0),
(46, 'Public Roads', '', 0),
(47, 'Public Areas/Plazas', '', 0),
(48, 'Public Areas/Plazas', '', 0),
(50, 'rev', '', 0),
(51, 'rev', '', 0),
(52, 'rev', '', 0),
(53, 'rev', '', 0),
(54, 'rev', '', 0),
(55, 'rev', '', 0),
(56, 'rev', '', 0),
(57, 'rev', '', 0),
(58, 'rev', '', 0),
(59, 'rev', '', 0),
(60, 'rev', '', 0),
(61, 'item 1', '', 53);

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
  `default_revenue` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_item_advice`
--

INSERT INTO `revenues_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`, `default_revenue`) VALUES
(1, 'per example', NULL, 1, 10, 0),
(2, 'per example', NULL, 2, 20, 0),
(5, '43GVFD', '', 54, 543, 0),
(16, 'Per user', 'https://www.preciseparklink.com/news/top-10-benefits-of-installing-ev-chargers-in-ontario\n', 8, 10, 0),
(17, 'Per charging point', 'https://www.justpark.com/uk/parking/london/', 525, 875, 0),
(18, 'Per charging point', 'Internal research', 455, 470, 0),
(19, 'Per  Banner', 'https://www.hastings.gov.uk/press_media/advertising/lamppostbanners/', 130, 300, 0),
(20, 'Per wifi access point', 'https://nypost.com/2018/05/01/nycs-free-public-wi-fi-kiosks-arent-making-enough-money/', 5, 5, 0),
(24, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(25, '# of additional clients each month', '', 0, 0, 0),
(26, '# of additional non-local visitors in the park each month', '', 0, 0, 0),
(27, 'Current # of square foot of unused space', '', 0, 0, 0),
(28, 'Current # of square foot of unused space', '', 0, 0, 0),
(29, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(30, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(31, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(32, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(33, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(34, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(35, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(36, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(37, '# of WWD occurrences', '', 0, 0, 0),
(38, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(39, '# of WWD occurrences', '', 0, 0, 0),
(40, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(41, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(42, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(43, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(44, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(45, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(46, '# of additional clients each month', '', 0, 0, 0),
(47, '# of Giga Bites of data sold to third parties per month', '', 0, 0, 0),
(48, '# of additional clients each month', '', 0, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

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
(14, 23),
(21, 27),
(49, 27),
(22, 28),
(23, 29),
(50, 30),
(61, 30),
(51, 33),
(52, 34),
(53, 35),
(54, 36),
(55, 37),
(56, 38),
(57, 39),
(58, 40),
(59, 44),
(60, 54);

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
(21, 16),
(49, 16),
(22, 17),
(23, 22),
(19, 25),
(20, 28),
(24, 32),
(25, 32),
(26, 32),
(27, 33),
(28, 34),
(29, 35),
(30, 36),
(31, 37),
(32, 38),
(33, 39),
(34, 40),
(35, 41),
(36, 42),
(37, 42),
(38, 43),
(39, 43),
(40, 44),
(41, 45),
(42, 46),
(43, 47),
(44, 48),
(45, 49),
(46, 49),
(47, 50),
(48, 50),
(50, 67),
(51, 67),
(52, 67),
(53, 67),
(54, 67),
(55, 67),
(56, 67),
(57, 67),
(58, 67),
(59, 67),
(60, 67),
(61, 67);

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
(15, 28, '2012-08-01', '2013-01-01', '2013-03-01', '2013-04-01', '2013-06-01', '2019-01-01'),
(16, 26, '2021-01-01', '2021-02-01', '2021-03-01', '2021-04-01', '2021-05-01', '2023-12-01'),
(16, 27, '2021-01-01', '2021-05-01', '2021-06-01', '2021-08-01', '2021-11-01', '2023-01-01'),
(17, 28, '2012-08-01', '2013-01-01', '2013-03-01', '2013-04-01', '2013-06-01', '2019-01-01');

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
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `risk_item`
--

INSERT INTO `risk_item` (`id`, `name`, `description`, `sources`, `cat`) VALUES
(1, 'risk item 1', '', NULL, 0),
(2, 'risk item 2', '', NULL, 0),
(3, 'risk custom item 1', '', NULL, 0),
(4, 'risks', '', NULL, 0),
(5, 'risks', '', NULL, 0),
(6, 'Maladie', '', NULL, 0),
(7, 'Peur', '', NULL, 0),
(8, 'risk 1', '', NULL, 0),
(9, 'risk 2', '', NULL, 0),
(10, 'risk 3', '', NULL, 0),
(11, 'black', '', NULL, 0),
(12, 'ri', '', NULL, 0),
(13, 'risk 01', '', NULL, 0),
(14, 'Potential Negative impact on health', '', NULL, 0),
(15, 'Harm to animals', '', NULL, 0),
(16, 'Lack of public acceptance', '', NULL, 0),
(17, 'Network Hacking', '', NULL, 0),
(18, 'Network crash', '', NULL, 0),
(19, 'Grid reliability (instability and disruptions)', '', NULL, 0),
(20, 'Security and safety risks (extreme weather, collisions, vandalism).', '', NULL, 0),
(21, 'Vandalism', '', NULL, 0),
(22, 'Bad weather (sunlight)', '', NULL, 0),
(23, 'Safety risks', '', NULL, 0),
(24, 'Vandalism', '', NULL, 0),
(25, 'Cyber attack', '', NULL, 0),
(26, 'Vandalism', '', NULL, 0),
(27, 'Lack of public acceptance', '', NULL, 0),
(28, 'Network and coverage Issues', '', NULL, 0),
(29, 'Vandalism', '', NULL, 0),
(30, 'Lack of public acceptance', '', NULL, 0),
(31, 'Sound coverage', '', NULL, 0),
(32, 'Lack of scalability - coverage', '', NULL, 0),
(33, 'Lack of public acceptance', '', NULL, 0),
(34, 'Cyber attacks(Hacking and Data leaks)', '', NULL, 0),
(35, 'Lack of scalability - coverage', '', NULL, 0),
(36, 'Sensitivity to high temperature', '', NULL, 0),
(37, 'Lack of scalability - coverage', '', NULL, 0),
(38, 'Limited visibility due to the height of advertisement', '', NULL, 0),
(39, 'Development of Urban planning ', '', NULL, 0),
(40, 'Data hacking', '', NULL, 0),
(41, 'Reduction of control to parking usage ', '', NULL, 0),
(42, 'Cyber attacks', '', NULL, 0),
(43, 'Public acceptance', '', NULL, 0),
(44, 'WiFi access point', '', NULL, 0),
(45, 'Cyber attacks', '', NULL, 0),
(46, 'Connectivity', '', NULL, 0),
(47, 'Cyber attacks', '', NULL, 0),
(48, 'Network interference', '', NULL, 0),
(49, 'Potential Negative impact on health', '', NULL, 0),
(50, 'Increase in housing prices and district attractiveness', '', NULL, 0),
(51, 'Potential Negative impact on health', '', NULL, 0),
(54, 'risk', '', NULL, 0),
(55, 'rrrrr', '', NULL, 0),
(57, 'risk 1', '', NULL, 59);

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

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
(11, 23),
(53, 27),
(55, 27),
(56, 27),
(54, 28),
(57, 30);

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
(53, 16),
(55, 16),
(56, 16),
(21, 17),
(22, 17),
(54, 17),
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
(51, 30),
(57, 67);

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
  `country` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `city` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `area` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`proj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `supplier_perimeter`
--

INSERT INTO `supplier_perimeter` (`proj_id`, `country`, `city`, `name`, `area`) VALUES
(21, 'a', 'Compiegne', 'Diego MEJIA', ''),
(22, '', '', '', ''),
(23, 'USA', 'Las Vegas', 'CIty of Las Vegas', ''),
(24, '', '', '', ''),
(29, '', '', '', ''),
(30, 'C1', 'C2', 'name 4', 'Area 3'),
(32, 'USA', 'Vegas', 'Vegas City', ''),
(33, 'C1', 'C2', 'name 4', 'Area 3'),
(34, 'C1', 'C2', 'name 4', 'Area 3'),
(35, 'C1', 'C2', 'name 4', 'Area 3'),
(36, 'C1', 'C2', 'name 4', 'Area 3'),
(37, 'C1', 'C2', 'name 4', 'Area 3'),
(38, 'C1', 'C2', 'name 4', 'Area 3'),
(39, 'C1', 'C2', 'name 4', 'Area 3'),
(40, 'C1', 'C2', 'name 4', 'Area 3'),
(41, 'C1', 'C2', 'name 4', 'Area 3'),
(42, 'C1', 'C2', 'name 4', 'Area 3'),
(43, 'C1', 'C2', 'name 4', 'Area 3'),
(44, 'C1', 'C2', 'name 4', 'Area 3'),
(45, '', '', '', ''),
(46, '', '', '', ''),
(48, '', '', '', ''),
(49, '', '', '', ''),
(50, '', '', '', ''),
(51, '', '', '', ''),
(52, '', '', '', ''),
(53, '', '', '', ''),
(54, 'C1', 'C2', 'name 4', 'Area 3'),
(56, '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `supplier_perimeter_data`
--

DROP TABLE IF EXISTS `supplier_perimeter_data`;
CREATE TABLE IF NOT EXISTS `supplier_perimeter_data` (
  `proj_id` int(10) UNSIGNED NOT NULL,
  `data` varchar(256) NOT NULL,
  `type` enum('customerDepartment','customerTeam','supplierBusinessUnit','supplierTeam') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

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
  `cat` int(11) NOT NULL,
  `default_rev` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `supplier_revenues_item`
--

INSERT INTO `supplier_revenues_item` (`item_id`, `name`, `type`, `description`, `advice_user`, `unit`, `cat`, `default_rev`) VALUES
(1, 'rev 1', 'equipment', 'desc', 'user', '', 0, 0),
(2, 'dep 1', 'deployment', '', 'user', '', 0, 0),
(3, 'op 1', 'operating', '', 'user', '', 0, 0),
(4, 'My rev', 'equipment', '', 'user', '', 0, 0),
(5, 'Sensor', 'equipment', '', 'user', '', 0, 0),
(6, 'project management', 'deployment', 'project', 'user', '', 0, 0),
(7, 'sells of data analytics', 'operating', '', 'user', '', 0, 0),
(9, 'dep 001', 'deployment', '', 'user', '', 0, 0),
(10, 'rec 01', 'operating', '', 'user', '', 0, 0),
(13, 'rev 001', 'equipment', '', 'user', 'r', 0, 0),
(14, 'rev 002', 'equipment', '', 'user', '', 0, 0),
(15, 'my 1st eq', 'equipment', '', 'user', '', 0, 0),
(16, 'my 2nd eq', 'equipment', '', 'user', '', 0, 0),
(17, 'dep 1st', 'deployment', '', 'user', '', 0, 0),
(18, '1st rec', 'operating', '', 'user', '', 0, 0),
(19, 'rev 1', 'equipment', '', 'user', 'u', 0, 0),
(20, 'dep', 'deployment', '', 'user', '', 0, 0),
(21, 'rec', 'operating', '', 'user', '', 0, 0),
(22, 'dep 1', 'deployment', '', 'user', 'unitttt', 0, 0),
(23, 'rec', 'operating', '', 'user', '', 0, 0),
(24, 'reeev', 'equipment', '', 'user', '', 0, 0),
(25, 'eee', 'equipment', '', 'user', '', 0, 0),
(26, 'cap', 'equipment', '', 'user', '', 0, 0),
(27, 'equip rev 01', 'equipment', '', 'user', '', 9, 0),
(28, 'blabla', 'equipment', '', 'user', '', 3, 0),
(30, 'item 01', 'deployment', '', 'user', 'Number', 14, 0),
(31, 'item 02', 'deployment', '', 'user', 'Number', 14, 0),
(32, 'equ rev in 2', 'equipment', '', 'user', 'Quantity', 17, 0),
(33, 'equ rev in 1', 'equipment', '', 'user', 'number', 16, 0),
(35, 'Maintenance Sensor', 'operating', '', 'user', 'Sensors', 26, 0),
(42, 'Camera', 'equipment', '', 'user', '#', 46, 0),
(43, 'Camera hooking', 'deployment', '', 'user', '#FTEs-days', 47, 0),
(44, 'PaaS - 0 to 50 ASUs', 'operating', '', 'user', '#', 48, 0),
(45, 'PaaS - 51 to 200 ASUs', 'operating', '', 'user', '#', 48, 0),
(50, 'Camera', 'equipment', '', 'advice', '#', 46, 0),
(51, 'Camera hooking', 'deployment', '', 'advice', '#FTEs-days', 47, 0),
(57, 'Camera', 'equipment', '', 'advice', '#', 46, 0),
(64, 'Camera', 'equipment', '', 'advice', '#', 46, 0),
(66, 'PaaS - 0 to 50 ASUs', 'operating', '', 'advice', '#', 48, 0),
(67, 'PaaS - 51 to 200 ASUs', 'operating', '', 'advice', '#', 48, 0),
(71, 'Camera', 'equipment', '', 'user', '#', 46, 0),
(72, 'Camera hooking', 'deployment', '', 'user', '#FTEs-days', 47, 0),
(73, 'PaaS - 0 to 50 ASUs', 'operating', '', 'user', '#', 48, 0),
(74, 'PaaS - 51 to 200 ASUs', 'operating', '', 'user', '#', 48, 0),
(78, 'Camera', 'equipment', '', 'user', '#', 46, 0),
(79, 'Camera hooking', 'deployment', '', 'user', '#FTEs-days', 47, 0),
(80, 'PaaS - 0 to 50 ASUs', 'operating', '', 'user', '#', 48, 0),
(81, 'PaaS - 51 to 200 ASUs', 'operating', '', 'user', '#', 48, 0),
(82, 'cap', 'equipment', '', 'user', '', 0, 0),
(83, 'item 01', 'deployment', '', 'user', 'Number', 14, 0),
(84, 'item 02', 'deployment', '', 'user', 'Number', 14, 0),
(85, 'equ rev in 2', 'equipment', '', 'user', 'Quantity', 17, 0),
(86, 'equ rev in 1', 'equipment', '', 'user', 'number', 16, 0),
(87, 'Maintenance Sensor', 'operating', '', 'user', 'Sensors', 26, 0),
(92, 'test', 'equipment', '', 'user', 'bonjour', 62, 0),
(93, 'O&N - ASU Range 51 - 100 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 281089),
(94, 'O&N - ASU Range 101 - 200 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 386664),
(95, 'O&N - ASU Range 201 - 300 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 518633),
(96, 'O&N - ASU Range 301 - 400 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 650603),
(97, 'O&N - ASU Range 401 - 500 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 839496),
(98, 'O&N - ASU Range 501 - 600 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 971465),
(99, 'O&N - ASU Range 601 - 700 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 1103440),
(100, 'O&N - ASU Range 701 - 800 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 1235400),
(101, 'O&N - ASU Range 801 - 900 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 1367370),
(102, 'O&N - ASU Range 901 - 1000 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 1499340),
(103, 'O&N - ASU Range 1001 - 1100 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 1631310),
(104, 'O&N - ASU Range 1101 - 1200 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 1820200),
(105, 'O&N - ASU Range 1201 - 1300 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 1952170),
(106, 'O&N - ASU Range 1301 - 1400 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 2084140),
(107, 'O&N - ASU Range 1401 - 1500 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 2216110),
(108, 'O&N - ASU Range 1501 - 1600 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 2348080),
(109, 'O&N - ASU Range 1601 - 1700 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 2480050),
(110, 'O&N - ASU Range 1701 - 1800 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 2612020),
(111, 'O&N - ASU Range 1801 - 1900 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 2743990),
(112, 'O&N - ASU Range 1901 - 2000 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 2875960),
(113, 'O&N - ASU Range 2001 - 2100 - Deployment & set-up', 'deployment', '', 'advice', '', 138, 3007930),
(114, 'O&N - ASU Range 1 - 50 - PaaS', 'operating', '', 'advice', '', 139, 29316),
(115, 'O&N - ASU Range 51 - 100 - PaaS', 'operating', '', 'advice', '', 139, 46393),
(116, 'O&N - ASU Range 101 - 200 - PaaS', 'operating', '', 'advice', '', 139, 49524),
(117, 'O&N - ASU Range 201 - 300 - PaaS', 'operating', '', 'advice', '', 139, 68878),
(118, 'O&N - ASU Range 301 - 400 - PaaS', 'operating', '', 'advice', '', 139, 72009),
(119, 'O&N - ASU Range 401 - 500 - PaaS', 'operating', '', 'advice', '', 139, 141172),
(120, 'O&N - ASU Range 501 - 600 - PaaS', 'operating', '', 'advice', '', 139, 144302),
(121, 'O&N - ASU Range 601 - 700 - PaaS', 'operating', '', 'advice', '', 139, 163657),
(122, 'O&N - ASU Range 701 - 800 - PaaS', 'operating', '', 'advice', '', 139, 166787),
(123, 'O&N - ASU Range 801 - 900 - PaaS', 'operating', '', 'advice', '', 139, 196103),
(124, 'O&N - ASU Range 901 - 1000 - PaaS', 'operating', '', 'advice', '', 139, 199234),
(125, 'O&N - ASU Range 1001 - 1100 - PaaS', 'operating', '', 'advice', '', 139, 218588),
(126, 'O&N - ASU Range 1101 - 1200 - PaaS', 'operating', '', 'advice', '', 139, 235950),
(127, 'O&N - ASU Range 1201 - 1300 - PaaS', 'operating', '', 'advice', '', 139, 265266),
(128, 'O&N - ASU Range 1301 - 1400 - PaaS', 'operating', '', 'advice', '', 139, 268397),
(129, 'O&N - ASU Range 1401 - 1500 - PaaS', 'operating', '', 'advice', '', 139, 287751),
(130, 'O&N - ASU Range 1501 - 1600 - PaaS', 'operating', '', 'advice', '', 139, 290882),
(131, 'O&N - ASU Range 1601 - 1700 - PaaS', 'operating', '', 'advice', '', 139, 320198),
(132, 'O&N - ASU Range 1701 - 1800 - PaaS', 'operating', '', 'advice', '', 139, 323328),
(133, 'O&N - ASU Range 1801 - 1900 - PaaS', 'operating', '', 'advice', '', 139, 342682),
(134, 'O&N - ASU Range 1901 - 2000 - PaaS', 'operating', '', 'advice', '', 139, 345813),
(135, 'O&N - ASU Range 2001 - 2100 - PaaS', 'operating', '', 'advice', '', 139, 375129),
(136, 'MP - ASU Range 1 - 50 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 96957),
(137, 'MP - ASU Range 51 - 100 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 181977),
(138, 'MP - ASU Range 101 - 150 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 238535),
(139, 'MP - ASU Range 151 - 200 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 295094),
(140, 'MP - ASU Range 201 - 250 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 351652),
(141, 'MP - ASU Range 251 - 300 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 408210),
(142, 'MP - ASU Range 301 - 350 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 464768),
(143, 'MP - ASU Range 351 - 400 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 521327),
(144, 'MP - ASU Range 401 - 450 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 634809),
(145, 'MP - ASU Range 451 - 500 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 691367),
(146, 'MP - ASU Range 501 - 550 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 747926),
(147, 'MP - ASU Range 551 - 600 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 804484),
(148, 'MP - ASU Range 601 - 650 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 861042),
(149, 'MP - ASU Range 651 - 700 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 917600),
(150, 'MP - ASU Range 701 - 750 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 974159),
(151, 'MP - ASU Range 751 - 800 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1030720),
(152, 'MP - ASU Range 801 - 850 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1087280),
(153, 'MP - ASU Range 851 - 900 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1143830),
(154, 'MP - ASU Range 901 - 950 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1200390),
(155, 'MP - ASU Range 951 - 1000 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1256950),
(156, 'MP - ASU Range 1001 - 1050 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1313510),
(157, 'MP - ASU Range 1051 - 1100 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1370070),
(158, 'MP - ASU Range 1101 - 1150 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1483550),
(159, 'MP - ASU Range 1151 - 1200 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1540110),
(160, 'MP - ASU Range 1201 - 1250 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1596660),
(161, 'MP - ASU Range 1251 - 1300 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1653220),
(162, 'MP - ASU Range 1301 - 1350 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1709780),
(163, 'MP - ASU Range 1351 - 1400 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1766340),
(164, 'MP - ASU Range 1401 - 1450 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1822900),
(165, 'MP - ASU Range 1451 - 1500 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1879460),
(166, 'MP - ASU Range 1501 - 1550 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1936020),
(167, 'MP - ASU Range 1551 - 1600 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 1992570),
(168, 'MP - ASU Range 1601 - 1650 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 2049130),
(169, 'MP - ASU Range 1651 - 1700 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 2105690),
(170, 'MP - ASU Range 1701 - 1750 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 2162250),
(171, 'MP - ASU Range 1751 - 1800 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 2218810),
(172, 'MP - ASU Range 1801 - 1850 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 2275360),
(173, 'MP - ASU Range 1851 - 1900 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 2331920),
(174, 'MP - ASU Range 1901 - 1950 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 2388480),
(175, 'MP - ASU Range 1951 - 2000 - Deployment & set-up', 'deployment', '', 'advice', '', 76, 2445040),
(176, 'MP - ASU Range 1 - 50 - PaaS', 'operating', '', 'advice', '', 77, 13093),
(177, 'MP - ASU Range 51 - 100 - PaaS', 'operating', '', 'advice', '', 77, 33301),
(178, 'MP - ASU Range 101 - 150 - PaaS', 'operating', '', 'advice', '', 77, 46393),
(179, 'MP - ASU Range 151 - 200 - PaaS', 'operating', '', 'advice', '', 77, 49524),
(180, 'MP - ASU Range 201 - 250 - PaaS', 'operating', '', 'advice', '', 77, 62616),
(181, 'MP - ASU Range 251 - 300 - PaaS', 'operating', '', 'advice', '', 77, 65747),
(182, 'MP - ASU Range 301 - 350 - PaaS', 'operating', '', 'advice', '', 77, 78840),
(183, 'MP - ASU Range 351 - 400 - PaaS', 'operating', '', 'advice', '', 77, 81971),
(184, 'MP - ASU Range 401 - 450 - PaaS', 'operating', '', 'advice', '', 77, 134910),
(185, 'MP - ASU Range 451 - 500 - PaaS', 'operating', '', 'advice', '', 77, 138041),
(186, 'MP - ASU Range 501 - 550 - PaaS', 'operating', '', 'advice', '', 77, 151133),
(187, 'MP - ASU Range 551 - 600 - PaaS', 'operating', '', 'advice', '', 77, 154264),
(188, 'MP - ASU Range 601 - 650 - PaaS', 'operating', '', 'advice', '', 77, 167357),
(189, 'MP - ASU Range 651 - 700 - PaaS', 'operating', '', 'advice', '', 77, 170487),
(190, 'MP - ASU Range 701 - 750 - PaaS', 'operating', '', 'advice', '', 77, 183580),
(191, 'MP - ASU Range 751 - 800 - PaaS', 'operating', '', 'advice', '', 77, 186711),
(192, 'MP - ASU Range 801 - 850 - PaaS', 'operating', '', 'advice', '', 77, 199803),
(193, 'MP - ASU Range 851 - 900 - PaaS', 'operating', '', 'advice', '', 77, 202934),
(194, 'MP - ASU Range 901 - 950 - PaaS', 'operating', '', 'advice', '', 77, 216027),
(195, 'MP - ASU Range 951 - 1000 - PaaS', 'operating', '', 'advice', '', 77, 219157),
(196, 'MP - ASU Range 1001 - 1050 - PaaS', 'operating', '', 'advice', '', 77, 232250),
(197, 'MP - ASU Range 1051 - 1100 - PaaS', 'operating', '', 'advice', '', 77, 235381),
(198, 'MP - ASU Range 1101 - 1150 - PaaS', 'operating', '', 'advice', '', 77, 262704),
(199, 'MP - ASU Range 1151 - 1200 - PaaS', 'operating', '', 'advice', '', 77, 265835),
(200, 'MP - ASU Range 1201 - 1250 - PaaS', 'operating', '', 'advice', '', 77, 278928),
(201, 'MP - ASU Range 1251 - 1300 - PaaS', 'operating', '', 'advice', '', 77, 282058),
(202, 'MP - ASU Range 1301 - 1350 - PaaS', 'operating', '', 'advice', '', 77, 295151),
(203, 'MP - ASU Range 1351 - 1400 - PaaS', 'operating', '', 'advice', '', 77, 298282),
(204, 'MP - ASU Range 1401 - 1450 - PaaS', 'operating', '', 'advice', '', 77, 311374),
(205, 'MP - ASU Range 1451 - 1500 - PaaS', 'operating', '', 'advice', '', 77, 314505),
(206, 'MP - ASU Range 1501 - 1550 - PaaS', 'operating', '', 'advice', '', 77, 327598),
(207, 'MP - ASU Range 1551 - 1600 - PaaS', 'operating', '', 'advice', '', 77, 330728),
(208, 'MP - ASU Range 1601 - 1650 - PaaS', 'operating', '', 'advice', '', 77, 343821),
(209, 'MP - ASU Range 1651 - 1700 - PaaS', 'operating', '', 'advice', '', 77, 346952),
(210, 'MP - ASU Range 1701 - 1750 - PaaS', 'operating', '', 'advice', '', 77, 360044),
(211, 'MP - ASU Range 1751 - 1800 - PaaS', 'operating', '', 'advice', '', 77, 363175),
(212, 'MP - ASU Range 1801 - 1850 - PaaS', 'operating', '', 'advice', '', 77, 376268),
(213, 'MP - ASU Range 1851 - 1900 - PaaS', 'operating', '', 'advice', '', 77, 379398),
(214, 'MP - ASU Range 1901 - 1950 - PaaS', 'operating', '', 'advice', '', 77, 392491),
(215, 'MP - ASU Range 1951 - 2000 - PaaS', 'operating', '', 'advice', '', 77, 395622),
(216, 'WWD - ASU Range 3 - 50 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 64638),
(217, 'WWD - ASU Range 51 - 100 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 130805),
(218, 'WWD - ASU Range 101 - 150 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 168511),
(219, 'WWD - ASU Range 151 - 200 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 206216),
(220, 'WWD - ASU Range 201 - 250 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 243922),
(221, 'WWD - ASU Range 251 - 300 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 281627),
(222, 'WWD - ASU Range 301 - 350 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 319333),
(223, 'WWD - ASU Range 351 - 400 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 357038),
(224, 'WWD - ASU Range 401 - 450 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 451668),
(225, 'WWD - ASU Range 451 - 500 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 489374),
(226, 'WWD - ASU Range 501 - 550 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 527079),
(227, 'WWD - ASU Range 551 - 600 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 564785),
(228, 'WWD - ASU Range 601 - 650 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 602490),
(229, 'WWD - ASU Range 651 - 700 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 640196),
(230, 'WWD - ASU Range 701 - 750 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 677901),
(231, 'WWD - ASU Range 751 - 800 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 715607),
(232, 'WWD - ASU Range 801 - 850 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 753312),
(233, 'WWD - ASU Range 851 - 900 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 791018),
(234, 'WWD - ASU Range 901 - 950 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 828723),
(235, 'WWD - ASU Range 951 - 1000 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 866429),
(236, 'WWD - ASU Range 1001 - 1050 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 904134),
(237, 'WWD - ASU Range 1051 - 1100 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 941840),
(238, 'WWD - ASU Range 1101 - 1150 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1036470),
(239, 'WWD - ASU Range 1151 - 1200 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1074180),
(240, 'WWD - ASU Range 1201 - 1250 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1111880),
(241, 'WWD - ASU Range 1251 - 1300 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1149590),
(242, 'WWD - ASU Range 1301 - 1350 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1187290),
(243, 'WWD - ASU Range 1351 - 1400 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1225000),
(244, 'WWD - ASU Range 1401 - 1450 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1262700),
(245, 'WWD - ASU Range 1451 - 1500 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1300410),
(246, 'WWD - ASU Range 1501 - 1550 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1338110),
(247, 'WWD - ASU Range 1551 - 1600 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1375820),
(248, 'WWD - ASU Range 1601 - 1650 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1413520),
(249, 'WWD - ASU Range 1651 - 1700 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1451230),
(250, 'WWD - ASU Range 1701 - 1750 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1488940),
(251, 'WWD - ASU Range 1751 - 1800 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1526640),
(252, 'WWD - ASU Range 1801 - 1850 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1564350),
(253, 'WWD - ASU Range 1851 - 1900 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1602050),
(254, 'WWD - ASU Range 1901 - 1950 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1639760),
(255, 'WWD - ASU Range 1951 - 2000 - Deployment & set-up', 'deployment', '', 'advice', '', 276, 1677460),
(256, 'WWD - ASU Range 3 - 50 - PaaS', 'operating', '', 'advice', '', 277, 16223),
(257, 'WWD - ASU Range 51 - 100 - PaaS', 'operating', '', 'advice', '', 277, 39562),
(258, 'WWD - ASU Range 101 - 150 - PaaS', 'operating', '', 'advice', '', 277, 55786),
(259, 'WWD - ASU Range 151 - 200 - PaaS', 'operating', '', 'advice', '', 277, 62047),
(260, 'WWD - ASU Range 201 - 250 - PaaS', 'operating', '', 'advice', '', 277, 78271),
(261, 'WWD - ASU Range 251 - 300 - PaaS', 'operating', '', 'advice', '', 277, 84532),
(262, 'WWD - ASU Range 301 - 350 - PaaS', 'operating', '', 'advice', '', 277, 100755),
(263, 'WWD - ASU Range 351 - 400 - PaaS', 'operating', '', 'advice', '', 277, 107017),
(264, 'WWD - ASU Range 401 - 450 - PaaS', 'operating', '', 'advice', '', 277, 163087),
(265, 'WWD - ASU Range 451 - 500 - PaaS', 'operating', '', 'advice', '', 277, 169349),
(266, 'WWD - ASU Range 501 - 550 - PaaS', 'operating', '', 'advice', '', 277, 185572),
(267, 'WWD - ASU Range 551 - 600 - PaaS', 'operating', '', 'advice', '', 277, 191834),
(268, 'WWD - ASU Range 601 - 650 - PaaS', 'operating', '', 'advice', '', 277, 208057),
(269, 'WWD - ASU Range 651 - 700 - PaaS', 'operating', '', 'advice', '', 277, 214319),
(270, 'WWD - ASU Range 701 - 750 - PaaS', 'operating', '', 'advice', '', 277, 230542),
(271, 'WWD - ASU Range 751 - 800 - PaaS', 'operating', '', 'advice', '', 277, 236804),
(272, 'WWD - ASU Range 801 - 850 - PaaS', 'operating', '', 'advice', '', 277, 253027),
(273, 'WWD - ASU Range 851 - 900 - PaaS', 'operating', '', 'advice', '', 277, 259289),
(274, 'WWD - ASU Range 901 - 950 - PaaS', 'operating', '', 'advice', '', 277, 275512),
(275, 'WWD - ASU Range 951 - 1000 - PaaS', 'operating', '', 'advice', '', 277, 281774),
(276, 'WWD - ASU Range 1001 - 1050 - PaaS', 'operating', '', 'advice', '', 277, 297997),
(277, 'WWD - ASU Range 1051 - 1100 - PaaS', 'operating', '', 'advice', '', 277, 304259),
(278, 'WWD - ASU Range 1101 - 1150 - PaaS', 'operating', '', 'advice', '', 277, 334713),
(279, 'WWD - ASU Range 1151 - 1200 - PaaS', 'operating', '', 'advice', '', 277, 340975),
(280, 'WWD - ASU Range 1201 - 1250 - PaaS', 'operating', '', 'advice', '', 277, 357198),
(281, 'WWD - ASU Range 1251 - 1300 - PaaS', 'operating', '', 'advice', '', 277, 363460),
(282, 'WWD - ASU Range 1301 - 1350 - PaaS', 'operating', '', 'advice', '', 277, 379683),
(283, 'WWD - ASU Range 1351 - 1400 - PaaS', 'operating', '', 'advice', '', 277, 385945),
(284, 'WWD - ASU Range 1401 - 1450 - PaaS', 'operating', '', 'advice', '', 277, 402168),
(285, 'WWD - ASU Range 1451 - 1500 - PaaS', 'operating', '', 'advice', '', 277, 408430),
(286, 'WWD - ASU Range 1501 - 1550 - PaaS', 'operating', '', 'advice', '', 277, 424653),
(287, 'WWD - ASU Range 1551 - 1600 - PaaS', 'operating', '', 'advice', '', 277, 430915),
(288, 'WWD - ASU Range 1601 - 1650 - PaaS', 'operating', '', 'advice', '', 277, 447138),
(289, 'WWD - ASU Range 1651 - 1700 - PaaS', 'operating', '', 'advice', '', 277, 453400),
(290, 'WWD - ASU Range 1701 - 1750 - PaaS', 'operating', '', 'advice', '', 277, 469623),
(291, 'WWD - ASU Range 1751 - 1800 - PaaS', 'operating', '', 'advice', '', 277, 475885),
(292, 'WWD - ASU Range 1801 - 1850 - PaaS', 'operating', '', 'advice', '', 277, 492108),
(293, 'WWD - ASU Range 1851 - 1900 - PaaS', 'operating', '', 'advice', '', 277, 498370),
(294, 'WWD - ASU Range 1901 - 1950 - PaaS', 'operating', '', 'advice', '', 277, 514593),
(295, 'WWD - ASU Range 1951 - 2000 - PaaS', 'operating', '', 'advice', '', 277, 520855),
(296, 'TVC - ASU Range 1 - 50 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 96957),
(297, 'TVC - ASU Range 51 - 100 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 181977),
(298, 'TVC - ASU Range 101 - 200 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 266815),
(299, 'TVC - ASU Range 201 - 300 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 379931),
(300, 'TVC - ASU Range 301 - 400 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 493048),
(301, 'TVC - ASU Range 401 - 500 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 663088),
(302, 'TVC - ASU Range 501 - 600 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 776205),
(303, 'TVC - ASU Range 601 - 700 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 889321),
(304, 'TVC - ASU Range 701 - 800 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1002440),
(305, 'TVC - ASU Range 801 - 900 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1115550),
(306, 'TVC - ASU Range 901 - 1000 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1228670),
(307, 'TVC - ASU Range 1001 - 1100 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1341790),
(308, 'TVC - ASU Range 1101 - 1200 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1511830),
(309, 'TVC - ASU Range 1201 - 1300 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1624940),
(310, 'TVC - ASU Range 1301 - 1400 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1738060),
(311, 'TVC - ASU Range 1401 - 1500 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1851180),
(312, 'TVC - ASU Range 1501 - 1600 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 1964290),
(313, 'TVC - ASU Range 1601 - 1700 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 2077410),
(314, 'TVC - ASU Range 1701 - 1800 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 2190530),
(315, 'TVC - ASU Range 1801 - 1900 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 2303640),
(316, 'TVC - ASU Range 1901 - 2000 - Deployment & set-up', 'deployment', '', 'advice', '', 214, 2416760),
(317, 'TVC - ASU Range 1 - 50 - PaaS', 'operating', '', 'advice', '', 215, 16223),
(318, 'TVC - ASU Range 51 - 100 - PaaS', 'operating', '', 'advice', '', 215, 33301),
(319, 'TVC - ASU Range 101 - 200 - PaaS', 'operating', '', 'advice', '', 215, 39562),
(320, 'TVC - ASU Range 201 - 300 - PaaS', 'operating', '', 'advice', '', 215, 55786),
(321, 'TVC - ASU Range 301 - 400 - PaaS', 'operating', '', 'advice', '', 215, 62047),
(322, 'TVC - ASU Range 401 - 500 - PaaS', 'operating', '', 'advice', '', 215, 118117),
(323, 'TVC - ASU Range 501 - 600 - PaaS', 'operating', '', 'advice', '', 215, 124379),
(324, 'TVC - ASU Range 601 - 700 - PaaS', 'operating', '', 'advice', '', 215, 140602),
(325, 'TVC - ASU Range 701 - 800 - PaaS', 'operating', '', 'advice', '', 215, 146864),
(326, 'TVC - ASU Range 801 - 900 - PaaS', 'operating', '', 'advice', '', 215, 163087),
(327, 'TVC - ASU Range 901 - 1000 - PaaS', 'operating', '', 'advice', '', 215, 169349),
(328, 'TVC - ASU Range 1001 - 1100 - PaaS', 'operating', '', 'advice', '', 215, 185572),
(329, 'TVC - ASU Range 1101 - 1200 - PaaS', 'operating', '', 'advice', '', 215, 206065),
(330, 'TVC - ASU Range 1201 - 1300 - PaaS', 'operating', '', 'advice', '', 215, 222288),
(331, 'TVC - ASU Range 1301 - 1400 - PaaS', 'operating', '', 'advice', '', 215, 228550),
(332, 'TVC - ASU Range 1401 - 1500 - PaaS', 'operating', '', 'advice', '', 215, 244773),
(333, 'TVC - ASU Range 1501 - 1600 - PaaS', 'operating', '', 'advice', '', 215, 251035),
(334, 'TVC - ASU Range 1601 - 1700 - PaaS', 'operating', '', 'advice', '', 215, 267258),
(335, 'TVC - ASU Range 1701 - 1800 - PaaS', 'operating', '', 'advice', '', 215, 273520),
(336, 'TVC - ASU Range 1801 - 1900 - PaaS', 'operating', '', 'advice', '', 215, 289743),
(337, 'TVC - ASU Range 1901 - 2000 - PaaS', 'operating', '', 'advice', '', 215, 296005),
(338, 'O - ASU Range 1 - 50 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 96957),
(339, 'O - ASU Range 51 - 100 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 181977),
(340, 'O - ASU Range 101 - 150 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 238535),
(341, 'O - ASU Range 151 - 200 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 295094),
(342, 'O - ASU Range 201 - 250 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 351652),
(343, 'O - ASU Range 251 - 300 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 408210),
(344, 'O - ASU Range 301 - 350 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 464768),
(345, 'O - ASU Range 351 - 400 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 521327),
(346, 'O - ASU Range 401 - 450 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 634809),
(347, 'O - ASU Range 451 - 500 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 691367),
(348, 'O - ASU Range 501 - 550 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 747926),
(349, 'O - ASU Range 551 - 600 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 804484),
(350, 'O - ASU Range 601 - 650 - Deployment & set-up', 'deployment', '', 'advice', '', 250, 861042);

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
(21, 11),
(22, -1),
(23, -1),
(24, 22),
(25, 67),
(26, -1),
(27, 67),
(28, 67),
(29, 50),
(30, 67),
(31, 67),
(32, 67),
(33, 67),
(34, 66),
(35, 67),
(36, -1),
(37, -1),
(38, -1),
(39, -1),
(40, -1),
(41, -1),
(42, 41),
(43, 41),
(44, 41),
(45, 41),
(50, 41),
(51, 41),
(57, 41),
(61, -1),
(62, -1),
(63, -1),
(64, 41),
(66, 41),
(67, 41),
(68, -1),
(69, -1),
(70, -1),
(71, 41),
(72, 41),
(73, 41),
(74, 41),
(75, -1),
(76, -1),
(77, -1),
(78, 41),
(79, 41),
(80, 41),
(81, 41),
(82, -1),
(83, 67),
(84, 67),
(85, 67),
(86, 67),
(87, 67),
(88, -1),
(89, -1),
(90, -1),
(91, -1),
(92, 62),
(93, 78),
(94, 78),
(95, 78),
(96, 78),
(97, 78),
(98, 78),
(99, 78),
(100, 78),
(101, 78),
(102, 78),
(103, 78),
(104, 78),
(105, 78),
(106, 78),
(107, 78),
(108, 78),
(109, 78),
(110, 78),
(111, 78),
(112, 78),
(113, 78),
(114, 78),
(115, 78),
(116, 78),
(117, 78),
(118, 78),
(119, 78),
(120, 78),
(121, 78),
(122, 78),
(123, 78),
(124, 78),
(125, 78),
(126, 78),
(127, 78),
(128, 78),
(129, 78),
(130, 78),
(131, 78),
(132, 78),
(133, 78),
(134, 78),
(135, 78),
(136, 70),
(137, 70),
(138, 70),
(139, 70),
(140, 70),
(141, 70),
(142, 70),
(143, 70),
(144, 70),
(145, 70),
(146, 70),
(147, 70),
(148, 70),
(149, 70),
(150, 70),
(151, 70),
(152, 70),
(153, 70),
(154, 70),
(155, 70),
(156, 70),
(157, 70),
(158, 70),
(159, 70),
(160, 70),
(161, 70),
(162, 70),
(163, 70),
(164, 70),
(165, 70),
(166, 70),
(167, 70),
(168, 70),
(169, 70),
(170, 70),
(171, 70),
(172, 70),
(173, 70),
(174, 70),
(175, 70),
(176, 70),
(177, 70),
(178, 70),
(179, 70),
(180, 70),
(181, 70),
(182, 70),
(183, 70),
(184, 70),
(185, 70),
(186, 70),
(187, 70),
(188, 70),
(189, 70),
(190, 70),
(191, 70),
(192, 70),
(193, 70),
(194, 70),
(195, 70),
(196, 70),
(197, 70),
(198, 70),
(199, 70),
(200, 70),
(201, 70),
(202, 70),
(203, 70),
(204, 70),
(205, 70),
(206, 70),
(207, 70),
(208, 70),
(209, 70),
(210, 70),
(211, 70),
(212, 70),
(213, 70),
(214, 70),
(215, 70),
(216, 86),
(217, 86),
(218, 86),
(219, 86),
(220, 86),
(221, 86),
(222, 86),
(223, 86),
(224, 86),
(225, 86),
(226, 86),
(227, 86),
(228, 86),
(229, 86),
(230, 86),
(231, 86),
(232, 86),
(233, 86),
(234, 86),
(235, 86),
(236, 86),
(237, 86),
(238, 86),
(239, 86),
(240, 86),
(241, 86),
(242, 86),
(243, 86),
(244, 86),
(245, 86),
(246, 86),
(247, 86),
(248, 86),
(249, 86),
(250, 86),
(251, 86),
(252, 86),
(253, 86),
(254, 86),
(255, 86),
(256, 86),
(257, 86),
(258, 86),
(259, 86),
(260, 86),
(261, 86),
(262, 86),
(263, 86),
(264, 86),
(265, 86),
(266, 86),
(267, 86),
(268, 86),
(269, 86),
(270, 86),
(271, 86),
(272, 86),
(273, 86),
(274, 86),
(275, 86),
(276, 86),
(277, 86),
(278, 86),
(279, 86),
(280, 86),
(281, 86),
(282, 86),
(283, 86),
(284, 86),
(285, 86),
(286, 86),
(287, 86),
(288, 86),
(289, 86),
(290, 86),
(291, 86),
(292, 86),
(293, 86),
(294, 86),
(295, 86),
(296, 82),
(297, 82),
(298, 82),
(299, 82),
(300, 82),
(301, 82),
(302, 82),
(303, 82),
(304, 82),
(305, 82),
(306, 82),
(307, 82),
(308, 82),
(309, 82),
(310, 82),
(311, 82),
(312, 82),
(313, 82),
(314, 82),
(315, 82),
(316, 82),
(317, 82),
(318, 82),
(319, 82),
(320, 82),
(321, 82),
(322, 82),
(323, 82),
(324, 82),
(325, 82),
(326, 82),
(327, 82),
(328, 82),
(329, 82),
(330, 82),
(331, 82),
(332, 82),
(333, 82),
(334, 82),
(335, 82),
(336, 82),
(337, 82),
(338, 84),
(339, 84),
(340, 84),
(341, 84),
(342, 84),
(343, 84),
(344, 84),
(345, 84),
(346, 84),
(347, 84),
(348, 84),
(349, 84),
(350, 84);

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
(21, 21),
(22, 29),
(23, 29),
(24, 29),
(25, 30),
(26, 30),
(27, 30),
(28, 30),
(29, 30),
(30, 30),
(31, 30),
(32, 30),
(33, 30),
(34, 30),
(35, 30),
(36, 40),
(37, 30),
(38, 30),
(39, 46),
(39, 47),
(39, 54),
(39, 61),
(39, 68),
(39, 75),
(40, 46),
(40, 48),
(40, 55),
(40, 62),
(40, 69),
(40, 76),
(41, 46),
(41, 49),
(41, 56),
(41, 63),
(41, 70),
(41, 77),
(42, 46),
(42, 50),
(42, 57),
(42, 64),
(42, 71),
(42, 78),
(43, 46),
(43, 51),
(43, 58),
(43, 65),
(43, 72),
(43, 79),
(44, 46),
(44, 52),
(44, 59),
(44, 66),
(44, 73),
(44, 80),
(45, 46),
(45, 53),
(45, 60),
(45, 67),
(45, 74),
(45, 81),
(82, 54),
(83, 54),
(84, 54),
(85, 54),
(86, 54),
(87, 54),
(88, 54),
(89, 54),
(90, 46),
(91, 30),
(92, 30);

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
(10, 9),
(13, 15),
(34, 15),
(37, 15),
(40, 15),
(41, 15);

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
(2, 9, 50),
(4, 15, 50),
(6, 15, 50);

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
(9, 2),
(15, 3);

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
(21, 15),
(21, 16);

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
(11, 9),
(15, 15),
(16, 15),
(20, 15),
(21, 15),
(22, 15),
(26, 15),
(27, 15),
(28, 15);

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
  `selected` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`,`proj_id`,`meas_id`,`uc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `uc_confirmed`
--

INSERT INTO `uc_confirmed` (`user_id`, `proj_id`, `meas_id`, `uc_id`, `selected`) VALUES
(15, 21, 0, -1, 1),
(15, 21, 1, 1, 1),
(15, 21, 1, 5, 1),
(15, 21, 1, 9, 1),
(15, 21, 1, 11, 1),
(15, 24, 0, -1, 1),
(15, 24, 1, 9, 1),
(15, 29, 0, -1, 1),
(15, 29, 21, 22, 1),
(16, 30, 0, -1, 1),
(16, 30, 25, 33, 1),
(16, 30, 25, 64, 1),
(16, 30, 25, 65, 1),
(16, 30, 25, 66, 1),
(16, 30, 25, 67, 1),
(16, 33, 0, -1, 1),
(16, 33, 25, 33, 1),
(16, 33, 25, 65, 1),
(16, 33, 25, 66, 1),
(16, 33, 25, 67, 1),
(16, 34, 0, -1, 1),
(16, 34, 25, 33, 1),
(16, 34, 25, 65, 1),
(16, 34, 25, 66, 1),
(16, 34, 25, 67, 1),
(16, 35, 0, -1, 1),
(16, 35, 25, 33, 1),
(16, 35, 25, 65, 1),
(16, 35, 25, 66, 1),
(16, 35, 25, 67, 1),
(16, 36, 0, -1, 1),
(16, 36, 25, 33, 1),
(16, 36, 25, 65, 1),
(16, 36, 25, 66, 1),
(16, 36, 25, 67, 1),
(16, 37, 0, -1, 1),
(16, 37, 25, 33, 1),
(16, 37, 25, 65, 1),
(16, 37, 25, 66, 1),
(16, 37, 25, 67, 1),
(16, 38, 0, -1, 1),
(16, 38, 25, 33, 1),
(16, 38, 25, 65, 1),
(16, 38, 25, 66, 1),
(16, 38, 25, 67, 1),
(16, 39, 0, -1, 1),
(16, 39, 25, 33, 1),
(16, 39, 25, 65, 1),
(16, 39, 25, 66, 1),
(16, 39, 25, 67, 1),
(16, 40, 0, -1, 1),
(16, 40, 25, 33, 1),
(16, 40, 25, 65, 1),
(16, 40, 25, 66, 1),
(16, 40, 25, 67, 1),
(16, 41, 0, -1, 1),
(16, 41, 25, 33, 1),
(16, 41, 25, 65, 1),
(16, 41, 25, 66, 1),
(16, 41, 25, 67, 1),
(16, 42, 0, -1, 1),
(16, 42, 25, 33, 1),
(16, 42, 25, 65, 1),
(16, 42, 25, 66, 1),
(16, 42, 25, 67, 1),
(16, 43, 0, -1, 1),
(16, 43, 25, 33, 1),
(16, 43, 25, 65, 1),
(16, 43, 25, 66, 1),
(16, 43, 25, 67, 1),
(16, 44, 0, -1, 1),
(16, 44, 25, 33, 1),
(16, 44, 25, 65, 1),
(16, 44, 25, 66, 1),
(16, 44, 25, 67, 1),
(16, 46, 0, -1, 1),
(16, 46, 25, 41, 1),
(16, 48, 0, -1, 1),
(16, 48, 25, 41, 1),
(16, 49, 0, -1, 1),
(16, 49, 25, 41, 1),
(16, 50, 0, -1, 1),
(16, 50, 25, 41, 1),
(16, 51, 0, -1, 1),
(16, 51, 25, 41, 1),
(16, 52, 0, -1, 1),
(16, 52, 25, 41, 1),
(16, 53, 0, -1, 1),
(16, 53, 25, 41, 1),
(16, 54, 0, -1, 1),
(16, 54, 25, 33, 1),
(16, 54, 25, 65, 1),
(16, 54, 25, 66, 1),
(16, 54, 25, 67, 1),
(16, 56, 0, -1, 1),
(16, 56, 25, 47, 1),
(16, 56, 25, 48, 1);

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

--
-- Déchargement des données de la table `uc_vs_crit`
--

INSERT INTO `uc_vs_crit` (`id_uc`, `id_crit`, `pertinence`, `range_min`, `range_max`) VALUES
(-1, 11, 0, 0, 0),
(-1, 12, 0, 0, 0),
(-1, 13, 2, 0, 0),
(-1, 14, 0, 0, 0),
(-1, 15, 0, 0, 0),
(-1, 16, 0, 0, 0),
(-1, 17, 0, 0, 0),
(-1, 18, 1, 12, 0),
(-1, 19, 0, 0, 0),
(-1, 20, 0, 0, 0),
(-1, 21, 0, 0, 0),
(-1, 22, 0, 0, 0),
(-1, 23, 0, 0, 0),
(-1, 24, 0, 0, 0),
(-1, 25, 0, 0, 0),
(-1, 26, 0, 0, 0),
(-1, 27, 0, 0, 0),
(-1, 28, 0, 0, 0),
(-1, 29, 0, 0, 0),
(-1, 30, 0, 0, 0),
(-1, 31, 0, 0, 0),
(-1, 32, 0, 0, 0),
(-1, 33, 0, 0, 0),
(-1, 34, 0, 0, 0),
(-1, 35, 0, 0, 0),
(-1, 36, 0, 0, 0),
(-1, 37, 0, 0, 0),
(-1, 38, 0, 0, 0),
(-1, 39, 0, 0, 0),
(-1, 40, 0, 0, 0),
(-1, 41, 2, 0, 0),
(-1, 42, 0, 0, 0),
(12, 11, 0, 0, 0),
(12, 12, 0, 0, 0),
(12, 13, 0, 0, 0),
(12, 14, 0, 0, 0),
(12, 15, 0, 0, 0),
(12, 16, 0, 0, 0),
(12, 17, 0, 0, 0),
(12, 18, 0, 0, 0),
(12, 19, 0, 0, 0),
(12, 20, 0, 0, 0),
(12, 21, 0, 0, 0),
(12, 22, 0, 0, 0),
(12, 23, 0, 0, 0),
(12, 24, 0, 0, 0),
(12, 25, 0, 0, 0),
(12, 26, 0, 0, 0),
(12, 27, 0, 0, 0),
(12, 28, 0, 0, 0),
(12, 29, 0, 0, 0),
(12, 30, 0, 0, 0),
(12, 31, 0, 0, 0),
(12, 32, 0, 0, 0),
(12, 33, 0, 0, 0),
(12, 34, 0, 0, 0),
(12, 35, 0, 0, 0),
(12, 36, 0, 0, 0),
(12, 37, 0, 0, 0),
(12, 38, 0, 0, 0),
(12, 39, 0, 0, 0),
(12, 40, 0, 0, 0),
(12, 41, 0, 0, 0),
(12, 42, 0, 0, 0),
(13, 11, 0, 0, 0),
(13, 12, 0, 0, 0),
(13, 13, 0, 0, 0),
(13, 14, 0, 0, 0),
(13, 15, 0, 0, 0),
(13, 16, 0, 0, 0),
(13, 17, 0, 0, 0),
(13, 18, 0, 0, 0),
(13, 19, 0, 0, 0),
(13, 20, 0, 0, 0),
(13, 21, 0, 0, 0),
(13, 22, 0, 0, 0),
(13, 23, 0, 0, 0),
(13, 24, 0, 0, 0),
(13, 25, 0, 0, 0),
(13, 26, 0, 0, 0),
(13, 27, 0, 0, 0),
(13, 28, 0, 0, 0),
(13, 29, 0, 0, 0),
(13, 30, 0, 0, 0),
(13, 31, 0, 0, 0),
(13, 32, 0, 0, 0),
(13, 33, 0, 0, 0),
(13, 34, 0, 0, 0),
(13, 35, 0, 0, 0),
(13, 36, 0, 0, 0),
(13, 37, 0, 0, 0),
(13, 38, 0, 0, 0),
(13, 39, 0, 0, 0),
(13, 40, 0, 0, 0),
(13, 41, 0, 0, 0),
(13, 42, 0, 0, 0),
(15, 11, 0, 0, 0),
(15, 12, 0, 0, 0),
(15, 13, 0, 0, 0),
(15, 14, 0, 0, 0),
(15, 15, 0, 0, 0),
(15, 16, 0, 0, 0),
(15, 17, 0, 0, 0),
(15, 18, 0, 0, 0),
(15, 19, 0, 0, 0),
(15, 20, 0, 0, 0),
(15, 21, 0, 0, 0),
(15, 22, 0, 0, 0),
(15, 23, 0, 0, 0),
(15, 24, 0, 0, 0),
(15, 25, 0, 0, 0),
(15, 26, 0, 0, 0),
(15, 27, 0, 0, 0),
(15, 28, 0, 0, 0),
(15, 29, 0, 0, 0),
(15, 30, 0, 0, 0),
(15, 31, 0, 0, 0),
(15, 32, 0, 0, 0),
(15, 33, 0, 0, 0),
(15, 34, 0, 0, 0),
(15, 35, 0, 0, 0),
(15, 36, 0, 0, 0),
(15, 37, 0, 0, 0),
(15, 38, 0, 0, 0),
(15, 39, 0, 0, 0),
(15, 40, 0, 0, 0),
(15, 41, 0, 0, 0),
(15, 42, 0, 0, 0),
(16, 11, 0, 0, 0),
(16, 12, 0, 0, 0),
(16, 13, 0, 0, 0),
(16, 14, 0, 0, 0),
(16, 15, 0, 0, 0),
(16, 16, 0, 0, 0),
(16, 17, 0, 0, 0),
(16, 18, 0, 0, 0),
(16, 19, 0, 0, 0),
(16, 20, 0, 0, 0),
(16, 21, 0, 0, 0),
(16, 22, 0, 0, 0),
(16, 23, 0, 0, 0),
(16, 24, 0, 0, 0),
(16, 25, 0, 0, 0),
(16, 26, 0, 0, 0),
(16, 27, 0, 0, 0),
(16, 28, 0, 0, 0),
(16, 29, 0, 0, 0),
(16, 30, 0, 0, 0),
(16, 31, 0, 0, 0),
(16, 32, 0, 0, 0),
(16, 33, 0, 0, 0),
(16, 34, 0, 0, 0),
(16, 35, 0, 0, 0),
(16, 36, 0, 0, 0),
(16, 37, 0, 0, 0),
(16, 38, 0, 5, 0),
(16, 39, 0, 0, 0),
(16, 40, 0, 0, 0),
(16, 41, 0, 0, 0),
(16, 42, 0, 0, 0),
(17, 11, 0, 0, 0),
(17, 12, 0, 0, 0),
(17, 13, 0, 0, 0),
(17, 14, 0, 0, 0),
(17, 15, 0, 0, 0),
(17, 16, 0, 0, 0),
(17, 17, 0, 0, 0),
(17, 18, 0, 0, 0),
(17, 19, 0, 0, 0),
(17, 20, 0, 0, 0),
(17, 21, 0, 0, 0),
(17, 22, 0, 0, 0),
(17, 23, 0, 0, 0),
(17, 24, 0, 0, 0),
(17, 25, 0, 0, 0),
(17, 26, 0, 0, 0),
(17, 27, 0, 0, 0),
(17, 28, 0, 0, 0),
(17, 29, 0, 0, 0),
(17, 30, 0, 0, 0),
(17, 31, 0, 0, 0),
(17, 32, 0, 0, 0),
(17, 33, 0, 0, 0),
(17, 34, 0, 0, 0),
(17, 35, 0, 0, 0),
(17, 36, 0, 0, 0),
(17, 37, 0, 0, 0),
(17, 38, 0, 0, 0),
(17, 39, 0, 0, 0),
(17, 40, 0, 0, 0),
(17, 41, 0, 0, 0),
(17, 42, 0, 0, 0),
(18, 11, 0, 0, 0),
(18, 12, 0, 0, 0),
(18, 13, 0, 0, 0),
(18, 14, 0, 0, 0),
(18, 15, 0, 0, 0),
(18, 16, 0, 0, 0),
(18, 17, 0, 0, 0),
(18, 18, 1, 5, 0),
(18, 19, 0, 0, 0),
(18, 20, 0, 0, 0),
(18, 21, 0, 0, 0),
(18, 22, 0, 0, 0),
(18, 23, 0, 0, 0),
(18, 24, 0, 0, 0),
(18, 25, 0, 0, 0),
(18, 26, 0, 0, 0),
(18, 27, 0, 0, 0),
(18, 28, 0, 0, 0),
(18, 29, 0, 0, 0),
(18, 30, 1, 0, 0),
(18, 31, 0, 0, 0),
(18, 32, 0, 0, 0),
(18, 33, 0, 0, 0),
(18, 34, 0, 0, 0),
(18, 35, 0, 0, 0),
(18, 36, 0, 0, 0),
(18, 37, 0, 0, 0),
(18, 38, 2, 5, 0),
(18, 39, 2, 0, 0),
(18, 40, 0, 0, 0),
(18, 41, 0, 0, 0),
(18, 42, 0, 0, 0),
(19, 11, 0, 0, 0),
(19, 12, 0, 0, 0),
(19, 13, 0, 0, 0),
(19, 14, 0, 0, 0),
(19, 15, 0, 0, 0),
(19, 16, 0, 0, 0),
(19, 17, 0, 0, 0),
(19, 18, 0, 0, 0),
(19, 19, 0, 0, 0),
(19, 20, 0, 0, 0),
(19, 21, 0, 0, 0),
(19, 22, 0, 0, 0),
(19, 23, 0, 0, 0),
(19, 24, 0, 0, 0),
(19, 25, 0, 0, 0),
(19, 26, 0, 0, 0),
(19, 27, 0, 0, 0),
(19, 28, 0, 0, 0),
(19, 29, 0, 0, 0),
(19, 30, 0, 0, 0),
(19, 31, 0, 0, 0),
(19, 32, 0, 0, 0),
(19, 33, 0, 0, 0),
(19, 34, 0, 0, 0),
(19, 35, 0, 0, 0),
(19, 36, 0, 0, 0),
(19, 37, 0, 0, 0),
(19, 38, 0, 0, 0),
(19, 39, 0, 0, 0),
(19, 40, 0, 0, 0),
(19, 41, 0, 0, 0),
(19, 42, 0, 0, 0),
(20, 11, 0, 0, 0),
(20, 12, 0, 0, 0),
(20, 13, 0, 0, 0),
(20, 14, 0, 0, 0),
(20, 15, 0, 0, 0),
(20, 16, 0, 0, 0),
(20, 17, 0, 0, 0),
(20, 18, 0, 0, 0),
(20, 19, 0, 0, 0),
(20, 20, 0, 0, 0),
(20, 21, 0, 0, 0),
(20, 22, 0, 0, 0),
(20, 23, 0, 0, 0),
(20, 24, 0, 0, 0),
(20, 25, 0, 0, 0),
(20, 26, 0, 0, 0),
(20, 27, 0, 0, 0),
(20, 28, 0, 0, 0),
(20, 29, 0, 0, 0),
(20, 30, 0, 0, 0),
(20, 31, 0, 0, 0),
(20, 32, 0, 0, 0),
(20, 33, 0, 0, 0),
(20, 34, 0, 0, 0),
(20, 35, 0, 0, 0),
(20, 36, 0, 0, 0),
(20, 37, 0, 0, 0),
(20, 38, 0, 0, 0),
(20, 39, 0, 0, 0),
(20, 40, 0, 0, 0),
(20, 41, 0, 0, 0),
(20, 42, 0, 0, 0),
(21, 11, 0, 0, 0),
(21, 12, 0, 0, 0),
(21, 13, 0, 0, 0),
(21, 14, 0, 0, 0),
(21, 15, 0, 0, 0),
(21, 16, 0, 0, 0),
(21, 17, 0, 0, 0),
(21, 18, 0, 0, 0),
(21, 19, 0, 0, 0),
(21, 20, 0, 0, 0),
(21, 21, 0, 0, 0),
(21, 22, 0, 0, 0),
(21, 23, 0, 0, 0),
(21, 24, 0, 0, 0),
(21, 25, 0, 0, 0),
(21, 26, 0, 0, 0),
(21, 27, 0, 0, 0),
(21, 28, 0, 0, 0),
(21, 29, 0, 0, 0),
(21, 30, 0, 0, 0),
(21, 31, 0, 0, 0),
(21, 32, 0, 0, 0),
(21, 33, 0, 0, 0),
(21, 34, 0, 0, 0),
(21, 35, 0, 0, 0),
(21, 36, 0, 0, 0),
(21, 37, 0, 0, 0),
(21, 38, 0, 0, 0),
(21, 39, 0, 0, 0),
(21, 40, 0, 0, 0),
(21, 41, 0, 0, 0),
(21, 42, 0, 0, 0),
(22, 11, 0, 0, 0),
(22, 12, 0, 0, 0),
(22, 13, 0, 0, 0),
(22, 14, 0, 0, 0),
(22, 15, 0, 0, 0),
(22, 16, 0, 0, 0),
(22, 17, 0, 0, 0),
(22, 18, 0, 0, 0),
(22, 19, 0, 0, 0),
(22, 20, 0, 0, 0),
(22, 21, 0, 0, 0),
(22, 22, 0, 0, 0),
(22, 23, 0, 0, 0),
(22, 24, 0, 0, 0),
(22, 25, 0, 0, 0),
(22, 26, 0, 0, 0),
(22, 27, 0, 0, 0),
(22, 28, 0, 0, 0),
(22, 29, 0, 0, 0),
(22, 30, 0, 0, 0),
(22, 31, 0, 0, 0),
(22, 32, 0, 0, 0),
(22, 33, 0, 0, 0),
(22, 34, 0, 0, 0),
(22, 35, 0, 0, 0),
(22, 36, 0, 0, 0),
(22, 37, 0, 0, 0),
(22, 38, 0, 0, 0),
(22, 39, 0, 0, 0),
(22, 40, 0, 0, 0),
(22, 41, 0, 0, 0),
(22, 42, 0, 0, 0),
(23, 11, 0, 0, 0),
(23, 12, 0, 0, 0),
(23, 13, 0, 0, 0),
(23, 14, 0, 0, 0),
(23, 15, 0, 0, 0),
(23, 16, 0, 0, 0),
(23, 17, 0, 0, 0),
(23, 18, 0, 0, 0),
(23, 19, 0, 0, 0),
(23, 20, 0, 0, 0),
(23, 21, 0, 0, 0),
(23, 22, 0, 0, 0),
(23, 23, 0, 0, 0),
(23, 24, 0, 0, 0),
(23, 25, 0, 0, 0),
(23, 26, 0, 0, 0),
(23, 27, 0, 0, 0),
(23, 28, 0, 0, 0),
(23, 29, 0, 0, 0),
(23, 30, 0, 0, 0),
(23, 31, 0, 0, 0),
(23, 32, 0, 0, 0),
(23, 33, 0, 0, 0),
(23, 34, 0, 0, 0),
(23, 35, 0, 0, 0),
(23, 36, 0, 0, 0),
(23, 37, 0, 0, 0),
(23, 38, 0, 0, 0),
(23, 39, 0, 0, 0),
(23, 40, 0, 0, 0),
(23, 41, 0, 0, 0),
(23, 42, 0, 0, 0),
(24, 11, 0, 0, 0),
(24, 12, 0, 0, 0),
(24, 13, 0, 0, 0),
(24, 14, 0, 0, 0),
(24, 15, 0, 0, 0),
(24, 16, 0, 0, 0),
(24, 17, 0, 0, 0),
(24, 18, 0, 0, 0),
(24, 19, 0, 0, 0),
(24, 20, 0, 0, 0),
(24, 21, 0, 0, 0),
(24, 22, 0, 0, 0),
(24, 23, 0, 0, 0),
(24, 24, 0, 0, 0),
(24, 25, 0, 0, 0),
(24, 26, 0, 0, 0),
(24, 27, 0, 0, 0),
(24, 28, 0, 0, 0),
(24, 29, 0, 0, 0),
(24, 30, 0, 0, 0),
(24, 31, 0, 0, 0),
(24, 32, 0, 0, 0),
(24, 33, 0, 0, 0),
(24, 34, 0, 0, 0),
(24, 35, 0, 0, 0),
(24, 36, 0, 0, 0),
(24, 37, 0, 0, 0),
(24, 38, 0, 0, 0),
(24, 39, 0, 0, 0),
(24, 40, 0, 0, 0),
(24, 41, 0, 0, 0),
(24, 42, 0, 0, 0),
(25, 11, 0, 0, 0),
(25, 12, 0, 0, 0),
(25, 13, 0, 0, 0),
(25, 14, 0, 0, 0),
(25, 15, 0, 0, 0),
(25, 16, 0, 0, 0),
(25, 17, 0, 0, 0),
(25, 18, 0, 0, 0),
(25, 19, 0, 0, 0),
(25, 20, 0, 0, 0),
(25, 21, 0, 0, 0),
(25, 22, 0, 0, 0),
(25, 23, 0, 0, 0),
(25, 24, 0, 0, 0),
(25, 25, 0, 0, 0),
(25, 26, 0, 0, 0),
(25, 27, 0, 0, 0),
(25, 28, 0, 0, 0),
(25, 29, 0, 0, 0),
(25, 30, 0, 0, 0),
(25, 31, 0, 0, 0),
(25, 32, 0, 0, 0),
(25, 33, 0, 0, 0),
(25, 34, 0, 0, 0),
(25, 35, 0, 0, 0),
(25, 36, 0, 0, 0),
(25, 37, 0, 0, 0),
(25, 38, 0, 0, 0),
(25, 39, 0, 0, 0),
(25, 40, 0, 0, 0),
(25, 41, 0, 0, 0),
(25, 42, 0, 0, 0),
(26, 11, 0, 0, 0),
(26, 12, 0, 0, 0),
(26, 13, 0, 0, 0),
(26, 14, 0, 0, 0),
(26, 15, 0, 0, 0),
(26, 16, 0, 0, 0),
(26, 17, 0, 0, 0),
(26, 18, 0, 0, 0),
(26, 19, 0, 0, 0),
(26, 20, 0, 0, 0),
(26, 21, 0, 0, 0),
(26, 22, 0, 0, 0),
(26, 23, 0, 0, 0),
(26, 24, 0, 0, 0),
(26, 25, 0, 0, 0),
(26, 26, 0, 0, 0),
(26, 27, 0, 0, 0),
(26, 28, 0, 0, 0),
(26, 29, 0, 0, 0),
(26, 30, 0, 0, 0),
(26, 31, 0, 0, 0),
(26, 32, 0, 0, 0),
(26, 33, 0, 0, 0),
(26, 34, 0, 0, 0),
(26, 35, 0, 0, 0),
(26, 36, 0, 0, 0),
(26, 37, 0, 0, 0),
(26, 38, 0, 0, 0),
(26, 39, 0, 0, 0),
(26, 40, 0, 0, 0),
(26, 41, 0, 0, 0),
(26, 42, 0, 0, 0),
(27, 11, 0, 0, 0),
(27, 12, 0, 0, 0),
(27, 13, 0, 0, 0),
(27, 14, 0, 0, 0),
(27, 15, 0, 0, 0),
(27, 16, 0, 0, 0),
(27, 17, 0, 0, 0),
(27, 18, 0, 0, 0),
(27, 19, 0, 0, 0),
(27, 20, 0, 0, 0),
(27, 21, 0, 0, 0),
(27, 22, 0, 0, 0),
(27, 23, 0, 0, 0),
(27, 24, 0, 0, 0),
(27, 25, 0, 0, 0),
(27, 26, 0, 0, 0),
(27, 27, 0, 0, 0),
(27, 28, 0, 0, 0),
(27, 29, 0, 0, 0),
(27, 30, 0, 0, 0),
(27, 31, 0, 0, 0),
(27, 32, 0, 0, 0),
(27, 33, 0, 0, 0),
(27, 34, 0, 0, 0),
(27, 35, 0, 0, 0),
(27, 36, 0, 0, 0),
(27, 37, 0, 0, 0),
(27, 38, 0, 0, 0),
(27, 39, 0, 0, 0),
(27, 40, 0, 0, 0),
(27, 41, 0, 0, 0),
(27, 42, 0, 0, 0),
(28, 11, 0, 0, 0),
(28, 12, 0, 0, 0),
(28, 13, 0, 0, 0),
(28, 14, 0, 0, 0),
(28, 15, 0, 0, 0),
(28, 16, 0, 0, 0),
(28, 17, 0, 0, 0),
(28, 18, 0, 0, 0),
(28, 19, 0, 0, 0),
(28, 20, 0, 0, 0),
(28, 21, 0, 0, 0),
(28, 22, 0, 0, 0),
(28, 23, 0, 0, 0),
(28, 24, 0, 0, 0),
(28, 25, 0, 0, 0),
(28, 26, 0, 0, 0),
(28, 27, 0, 0, 0),
(28, 28, 0, 0, 0),
(28, 29, 0, 0, 0),
(28, 30, 0, 0, 0),
(28, 31, 0, 0, 0),
(28, 32, 0, 0, 0),
(28, 33, 0, 0, 0),
(28, 34, 0, 0, 0),
(28, 35, 0, 0, 0),
(28, 36, 0, 0, 0),
(28, 37, 0, 0, 0),
(28, 38, 0, 0, 0),
(28, 39, 0, 0, 0),
(28, 40, 0, 0, 0),
(28, 41, 0, 0, 0),
(28, 42, 0, 0, 0),
(29, 11, 0, 0, 0),
(29, 12, 0, 0, 0),
(29, 13, 2, 0, 0),
(29, 14, 0, 0, 0),
(29, 15, 0, 0, 0),
(29, 16, 0, 0, 0),
(29, 17, 0, 0, 0),
(29, 18, 0, 0, 0),
(29, 19, 0, 0, 0),
(29, 20, 0, 0, 0),
(29, 21, 0, 0, 0),
(29, 22, 0, 0, 0),
(29, 23, 0, 0, 0),
(29, 24, 0, 0, 0),
(29, 25, 0, 0, 0),
(29, 26, 0, 0, 0),
(29, 27, 0, 0, 0),
(29, 28, 0, 0, 0),
(29, 29, 0, 0, 0),
(29, 30, 0, 0, 0),
(29, 31, 0, 0, 0),
(29, 32, 0, 0, 0),
(29, 33, 0, 0, 0),
(29, 34, 0, 0, 0),
(29, 35, 0, 0, 0),
(29, 36, 0, 0, 0),
(29, 37, 2, 0, 0),
(29, 38, 0, 0, 0),
(29, 39, 0, 0, 0),
(29, 40, 0, 0, 0),
(29, 41, 0, 0, 0),
(29, 42, 0, 0, 0),
(30, 11, 0, 0, 0),
(30, 12, 0, 0, 0),
(30, 13, 0, 0, 0),
(30, 14, 0, 0, 0),
(30, 15, 0, 0, 0),
(30, 16, 0, 0, 0),
(30, 17, 0, 0, 0),
(30, 18, 0, 0, 0),
(30, 19, 0, 0, 0),
(30, 20, 0, 0, 0),
(30, 21, 0, 0, 0),
(30, 22, 0, 0, 0),
(30, 23, 0, 0, 0),
(30, 24, 0, 0, 0),
(30, 25, 0, 0, 0),
(30, 26, 0, 0, 0),
(30, 27, 0, 0, 0),
(30, 28, 0, 0, 0),
(30, 29, 0, 0, 0),
(30, 30, 0, 0, 0),
(30, 31, 0, 0, 0),
(30, 32, 0, 0, 0),
(30, 33, 0, 0, 0),
(30, 34, 0, 0, 0),
(30, 35, 0, 0, 0),
(30, 36, 0, 0, 0),
(30, 37, 0, 0, 0),
(30, 38, 0, 0, 0),
(30, 39, 0, 0, 0),
(30, 40, 0, 0, 0),
(30, 41, 0, 0, 0),
(30, 42, 0, 0, 0),
(31, 11, 0, 0, 0),
(31, 12, 0, 0, 0),
(31, 13, 2, 0, 0),
(31, 14, 0, 0, 0),
(31, 15, 0, 0, 0),
(31, 16, 0, 0, 0),
(31, 17, 0, 0, 0),
(31, 18, 0, 0, 0),
(31, 19, 0, 0, 0),
(31, 20, 0, 0, 0),
(31, 21, 0, 0, 0),
(31, 22, 0, 0, 0),
(31, 23, 0, 0, 0),
(31, 24, 0, 0, 0),
(31, 25, 0, 0, 0),
(31, 26, 0, 0, 0),
(31, 27, 0, 0, 0),
(31, 28, 0, 0, 0),
(31, 29, 0, 0, 0),
(31, 30, 0, 0, 0),
(31, 31, 0, 0, 0),
(31, 32, 0, 0, 0),
(31, 33, 0, 0, 0),
(31, 34, 0, 0, 0),
(31, 35, 0, 0, 0),
(31, 36, 0, 0, 0),
(31, 37, 2, 0, 0),
(31, 38, 0, 0, 0),
(31, 39, 0, 0, 0),
(31, 40, 2, 0, 0),
(31, 41, 0, 0, 0),
(31, 42, 0, 0, 0);

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
(11, 10, 9, 4),
(15, 13, 15, 5),
(15, 34, 15, 5),
(15, 37, 15, 5),
(15, 40, 15, 5),
(15, 41, 15, 5),
(16, 13, 15, 5),
(16, 34, 15, 5),
(16, 37, 15, 5),
(16, 40, 15, 5),
(16, 41, 15, 5),
(20, 13, 15, 5),
(20, 34, 15, 5),
(20, 37, 15, 5),
(20, 40, 15, 5),
(20, 41, 15, 5),
(21, 13, 15, 5),
(21, 34, 15, 5),
(21, 37, 15, 5),
(21, 40, 15, 5),
(21, 41, 15, 5),
(22, 13, 15, 5),
(22, 34, 15, 5),
(22, 37, 15, 5),
(22, 40, 15, 5),
(22, 41, 15, 5),
(26, 13, 15, 5),
(26, 34, 15, 5),
(26, 37, 15, 5),
(26, 40, 15, 5),
(26, 41, 15, 5),
(27, 13, 15, 5),
(27, 34, 15, 5),
(27, 37, 15, 5),
(27, 40, 15, 5),
(27, 41, 15, 5),
(28, 13, 15, 5),
(28, 34, 15, 5),
(28, 37, 15, 5),
(28, 40, 15, 5),
(28, 41, 15, 5);

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
  `companyName` text NOT NULL,
  `divisionName` text NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `lastname`, `firstname`, `email`, `password`, `salt`, `is_admin`, `is_active`, `creation_date`, `profile`, `logoName`, `companyName`, `divisionName`, `group_id`) VALUES
(1, 'admin', NULL, NULL, NULL, '$2y$10$vZD1YOsZNMYWzqzyg.q5KOiJ5M6VrLK8sOGcyOtEB5zWrYb3P4fGq', '10661622345dce8dd31fac11.66803067', 1, 1, '2020-02-11 11:42:57', 'd', '', '', '', 0),
(2, 'user1', NULL, NULL, NULL, '$2y$10$wFtEEFoLQawd.KdW05QTGeituOfY8mA2kyqHBFnurWKsHu63Ke5vu', '646419995e428578913042.05825044', 0, NULL, '2020-02-11 11:44:08', 'd', '', '', '', 0),
(5, 'Zak', NULL, NULL, NULL, '$2y$10$8OstD4JHwDpDsUdmO2FM0Ocszp7gHS9M.7wXIb88WUm4nA8m5dC1W', '7528837005f032af7425025.62320933', 1, NULL, '2020-07-06 15:45:27', 'd', '', '', '', 0),
(10, 'ZakSup', NULL, NULL, NULL, '$2y$10$A5Ler5Xbj7Y6WpG/3gls6uuLRDdfv773iwOHesIKrt4rQpC/Aoz7e', '12867769935f1053d19cec80.37775064', 1, NULL, '2020-07-16 15:19:13', 's', '', '', '', 0),
(12, 'adminD', NULL, NULL, NULL, '$2y$10$31NeoivqFMZ4VYFgA2OBDeHo3JzyRYD64SdvRSHDAEtPxwMSVY66S', '8699085225f3a309ecca908.48687664', 0, NULL, '2020-08-17 09:24:14', 'd', '', '', '', 0),
(13, 'hsolignac', NULL, NULL, NULL, '$2y$10$CcJhKSDio5GeUGKMpXrliOOoa/4HhGAHMuYwXqxeYKh0uoAYprjwe', '13261339555f913abbcfa8a9.99900149', 1, NULL, '2020-09-15 12:12:10', 'd', '.', '', '', 0),
(14, 'Supplier', NULL, NULL, NULL, '$2y$10$ZRmI4EdFyNa0DjXBIuVy0OEss9uyquBbrs07M4p2ABNp9NwW5y.26', '19226631715f609399dea569.52156583', 1, NULL, '2020-09-15 12:12:42', 's', '', '', '', 0),
(15, 'SupplierTest', NULL, NULL, NULL, '$2y$10$9f42/LpUAetvI3ucAfii7eXEuA3HSfPk.2eSi1nErlj3BcXHhhpRO', '4077705355f60bc8fcbd303.92552720', 1, NULL, '2020-09-15 15:07:27', 's', '', '', '', 0),
(16, 'NTT', 'Mejia', 'Diego', 'Diego@mail.fr', '$2y$10$5l/yrvBWGAX5Il.JcLQdNeKKVY5AcKTcHlaaMCj0OOiPdfYggGuye', '2121549035f96d9f18e0b16.02798293', 1, NULL, '2020-10-26 15:15:13', 's', '16.png', 'NTT', 'NTT  Accelerate SMART Solutions', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_group`
--

INSERT INTO `user_group` (`id`, `name`) VALUES
(1, 'group 1');

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
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_case`
--

INSERT INTO `use_case` (`id`, `name`, `description`, `id_meas`, `id_cat`) VALUES
(-1, 'Project Overlay', '', 0, 0),
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
(31, '5G', '', 21, 14),
(42, 'Public Roads', '', 25, 18),
(43, 'Private Roads', '', 25, 18),
(47, 'Public Roads', '', 25, 20),
(48, 'Private Roads', '', 25, 20),
(51, 'Airports', '', 25, 22),
(52, 'Parks', '', 25, 22),
(53, 'Retail / Malls / Small shops', '', 25, 22),
(54, 'Event, Cultural & Sports Facilities', '', 25, 22),
(55, 'Offices', '', 25, 22),
(56, 'Airports', '', 25, 23),
(57, 'Parks', '', 25, 23),
(58, 'Retail / Malls / Small shops', '', 25, 23),
(59, 'Event, Cultural & Sports Facilities', '', 25, 23),
(60, 'Factory/Manufact.', '', 25, 23),
(61, 'Offices', '', 25, 23),
(62, 'Offices', '', 25, 24),
(63, 'Factory/Manufact.', '', 25, 24),
(64, 'Factory/Manufact.', '', 25, 25),
(65, 'Retail / Malls / Small shops', '', 25, 25),
(66, 'Event, Cultural & Sports Facilities', '', 25, 25),
(67, 'Offices', '', 25, 25),
(68, 'Public Areas/Plazas', '', 25, 27),
(69, 'Parks', '', 25, 27),
(70, 'Retail / Malls / Small shops', '', 25, 27),
(71, 'Private Roads', '', 25, 28),
(72, 'Public Roads', '', 25, 28),
(73, 'Offices', '', 25, 29),
(74, 'Retail / Malls / Small shops', '', 25, 29),
(75, 'Event, Cultural & Sports Facilities', '', 25, 29),
(76, 'Public Areas/Plazas', '', 25, 29),
(77, 'Airports', '', 25, 29),
(78, 'Parks', '', 25, 29),
(79, 'Factory/Manufact.', '', 25, 29),
(80, 'Public Areas/Plazas', '', 25, 30),
(81, 'Private Roads', '', 25, 30),
(82, 'Public Roads', '', 25, 30),
(83, 'Public Areas/Plazas', '', 25, 31),
(84, 'Public Roads', '', 25, 31),
(85, 'Private Roads', '', 25, 32),
(86, 'Public Roads', '', 25, 32),
(87, 'Offices', '', 25, 33),
(88, 'Retail / Malls / Small shops', '', 25, 33),
(89, 'Event, Cultural & Sports Facilities', '', 25, 33),
(90, 'Airports', '', 25, 33),
(91, 'Parks', '', 25, 33),
(92, 'Offices', '', 25, 34),
(93, 'Retail / Malls / Small shops', '', 25, 34),
(94, 'Event, Cultural & Sports Facilities', '', 25, 34),
(95, 'Airports', '', 25, 34),
(96, 'Parks', '', 25, 34),
(97, 'Factory/Manufact.', '', 25, 34),
(98, 'Factory/Manufact.', '', 25, 35),
(99, 'Offices', '', 25, 35),
(100, 'Factory/Manufact.', '', 25, 36),
(101, 'Event, Cultural & Sports Facilities', '', 25, 36),
(102, 'Offices', '', 25, 36),
(103, 'Retail / Malls / Small shops', '', 25, 36);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_cases_menu`
--

INSERT INTO `use_cases_menu` (`id`, `name`, `description`, `creation_date`, `id_user`) VALUES
(3, 'uc_eval', '', '2020-02-13 12:22:10', 2),
(7, 'test1', 'test', '2020-07-16 16:04:46', 5),
(8, 'test1', 'test', '2020-08-17 09:19:57', 10),
(14, 'Montreal Area', '', '2020-10-19 17:16:51', 1),
(15, 'Montreal Area', '', '2020-10-20 11:11:14', 13);

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_case_cat`
--

INSERT INTO `use_case_cat` (`id`, `name`, `description`) VALUES
(0, 'Project Overlay', NULL),
(5, 'Lamppost', ''),
(9, 'Public Safety', ''),
(11, 'Signage ', ''),
(13, 'Movment Monitoring ', ''),
(15, 'Ligthing', ''),
(27, 'Missing Person', ''),
(28, 'Traffic – Vehicle of Interest', ''),
(29, 'Occupancy and Notification', ''),
(30, 'Traffic – Vehicle Count', ''),
(31, 'Traffic – Origination and Destination', ''),
(32, 'Wrong Direction', ''),
(33, 'Health Check – Thermal Scan', ''),
(34, 'Boundary Compliance', ''),
(35, 'Plant Safety (Manufacturing)', ''),
(36, 'Back to Work Package', '');

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
(15, 13, 27, NULL, NULL, 400),
(15, 16, 26, NULL, NULL, 10),
(15, 16, 27, NULL, NULL, 8940),
(15, 17, 27, NULL, NULL, 450),
(15, 20, 26, NULL, NULL, 20),
(15, 20, 27, NULL, NULL, 550),
(15, 20, 28, NULL, NULL, 105),
(15, 22, 27, NULL, NULL, 575),
(16, 13, 27, NULL, NULL, 1),
(16, 16, 26, NULL, NULL, 10),
(16, 16, 27, NULL, NULL, 1),
(16, 17, 27, NULL, NULL, 1),
(16, 20, 26, NULL, NULL, 20),
(16, 20, 27, NULL, NULL, 1),
(16, 22, 27, NULL, NULL, 1),
(17, 20, 28, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `widercash_item`
--

DROP TABLE IF EXISTS `widercash_item`;
CREATE TABLE IF NOT EXISTS `widercash_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_item`
--

INSERT INTO `widercash_item` (`id`, `name`, `description`, `cat`) VALUES
(1, 'wider cash benefits item 1', '', 0),
(2, 'wider cash benefits item 2', '', 0),
(3, 'wider cahs custom item', '', 0),
(4, 'WCB', '', 0),
(6, 'vfjbkdcn fbioe', '', 0),
(8, 'bvefhcdbkjsnl,', '', 0),
(9, 'WCB', '', 0),
(10, 'WCB 1', '', 0),
(11, 'WCB 2', '', 0),
(12, 'wcb', '', 0),
(14, 'Polution', '', 0),
(15, 'wider', '', 0),
(16, 'Carbon savings', '', 0),
(17, 'Carbon savings', '', 0),
(18, 'Carbon savings', '', 0),
(19, 'Reduction of cabling Maintenance', '', 0),
(20, 'Crime reduction & prevention', '', 0),
(21, 'Carbon savings', '', 0),
(22, 'Improved security surveillance system', '', 0),
(23, 'Reduction of flood cost', '', 0),
(24, 'Reduces number of traffic accidents', '', 0),
(25, 'Reduction in congestion time due to traffic monitoring', '', 0),
(26, 'ddd', '', 0),
(28, 'WCB 1', '', 56),
(29, 'wider', '', 61);

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
  `default_cost` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_item_advice`
--

INSERT INTO `widercash_item_advice` (`id`, `unit`, `source`, `unit_cost`, `range_min_red_nb`, `range_max_red_nb`, `range_min_red_cost`, `range_max_red_cost`, `default_cost`) VALUES
(1, 'per example', NULL, 2, 3, 4, 5, 6, 0),
(2, 'per example', NULL, 4, 5, 6, 7, 8, 0),
(6, 'thgfd', '', 0, 5, 45, 5, 45, 0),
(7, 'GEFRD', '', 4, 5, 6, 7, 8, 0),
(8, 'GRTFED', 'GTRFE', 5, 4, 3, 42, 2, 0),
(16, 'Per Ton of carbon', 'https://www.surrey.ca/city-services/4614.aspx', 16, 20, 40, 0, 0, 0),
(17, 'Per Ton of carbon', 'https://www.citintelly.com/intelligent-street-lighting-products/street-lighting-control-system/', 16, 20, 60, 0, 0, 0),
(18, 'Per Ton of carbon', 'https://www.smallbizdaily.com/4-ways-ev-charging-stations-can-benefit-business/\n', 16, 85, 100, 0, 0, 0),
(19, 'Per cabling system', 'https://reneweconomy.com.au/hidden-cost-of-rooftop-solar-who-should-pay-for-maintenance-99200/\n', 8, 10, 30, 0, 0, 0),
(20, 'Per crime (property, persons) ', 'https://reolink.com/pros-cons-of-surveillance-cameras-in-public-places/', 4800, 10, 30, 0, 0, 0),
(21, 'Per Ton of carbon', 'https://www.epa.gov/air-research/deliberating-performance-targets-air-quality-sensors-workshop\n', 16, 20, 40, 0, 0, 0),
(22, 'Per safety investigation', 'https://www.oti.fi/en/oti/investigation-of-road-accidents/', 2415, 40, 60, 0, 0, 0),
(23, 'Per claimed inhabitant', 'http://www.libelium.com/smart_water_wsn_flood_detection/', 1310, 10, 20, 0, 0, 0),
(24, 'Per accident', 'https://www.researchgate.net/publication/12411590_Traffic_accident_reduction_by_monitoring_driver_behaviour_with_in-car_data_recorders', 14374, 10, 20, 0, 0, 0),
(25, 'Number of hours lost', 'https://reolink.com/pros-cons-of-surveillance-cameras-in-public-places/', 8, 20, 50, 0, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

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
(14, 23),
(26, 27),
(27, 27),
(28, 30),
(29, 30);

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
(26, 16),
(27, 16),
(18, 17),
(19, 18),
(20, 19),
(21, 22),
(22, 23),
(23, 24),
(24, 26),
(25, 26),
(29, 62),
(28, 67);

-- --------------------------------------------------------

--
-- Structure de la table `xpex_cat`
--

DROP TABLE IF EXISTS `xpex_cat`;
CREATE TABLE IF NOT EXISTS `xpex_cat` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `id_uc` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `xpex_type` enum('equipment_revenues','deployment_revenues','operating_revenues','capex','opex','revenues','revenuesProtection','cashreleasing','widercash','quantifiable','noncash','risks','deployment_costs') NOT NULL,
  `side` enum('customer','supplier','projDev') NOT NULL DEFAULT 'supplier',
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=484 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `xpex_cat`
--

INSERT INTO `xpex_cat` (`id_cat`, `id_uc`, `name`, `xpex_type`, `side`) VALUES
(1, 25, 'eee', 'capex', 'supplier'),
(2, 67, 'eeeee', 'capex', 'supplier'),
(3, 67, 'cat 2', 'capex', 'supplier'),
(4, 66, '1 st cat', 'capex', 'supplier'),
(5, 66, '2nd cat', 'capex', 'supplier'),
(6, 66, 'new cat empty', 'capex', 'supplier'),
(7, 67, 'Cat 01', 'capex', 'customer'),
(8, 67, 'cat 02', 'capex', 'customer'),
(9, 67, 'Cat equip ', 'equipment_revenues', 'customer'),
(14, 67, 'cat 01', 'deployment_revenues', 'supplier'),
(16, 67, 'CAT1', 'equipment_revenues', 'supplier'),
(17, 67, 'CAT 2', 'equipment_revenues', 'supplier'),
(18, 66, 'cat1', 'deployment_costs', 'supplier'),
(19, 66, 'cat 1', 'opex', 'supplier'),
(20, 67, 'new cat', 'deployment_costs', 'supplier'),
(26, 67, 'Laintenance', 'operating_revenues', 'supplier'),
(28, 67, 'cat 01', 'deployment_costs', 'customer'),
(29, 67, 'cat 01', 'opex', 'customer'),
(38, 26, 'teeeest', 'capex', 'customer'),
(39, 48, 'Admin Cat', 'capex', 'supplier'),
(46, 41, 'CCTV', 'equipment_revenues', 'supplier'),
(47, 41, 'Installation ', 'deployment_revenues', 'supplier'),
(48, 41, 'PaaS', 'operating_revenues', 'supplier'),
(49, 41, 'Sensors', 'capex', 'supplier'),
(50, 41, 'Sensor Installation', 'deployment_costs', 'supplier'),
(51, 41, 'Maintenance ', 'opex', 'supplier'),
(52, 41, 'test admin', 'capex', 'supplier'),
(53, 67, 'cat 1', 'revenues', 'customer'),
(54, 67, 'cat 2', 'revenuesProtection', 'customer'),
(55, 67, 'my cat', 'cashreleasing', 'customer'),
(56, 67, 'cat 1', 'widercash', 'customer'),
(57, 67, 'cat 01', 'quantifiable', 'customer'),
(58, 67, 'cat 1', 'noncash', 'customer'),
(59, 67, 'cat 2', 'risks', 'customer'),
(60, 67, 'cat 2', 'opex', 'supplier'),
(61, 62, 'cat 1', 'widercash', 'customer'),
(62, 62, 'Cat 1', 'equipment_revenues', 'supplier'),
(63, 48, 'accident dim', 'cashreleasing', 'customer'),
(64, 70, 'Category', 'capex', 'customer'),
(65, 70, 'Category', 'opex', 'customer'),
(66, 70, 'Category', 'revenues', 'customer'),
(67, 70, 'Category', 'revenuesProtection', 'customer'),
(68, 70, 'Category', 'cashreleasing', 'customer'),
(69, 70, 'Category', 'widercash', 'customer'),
(70, 70, 'Category', 'quantifiable', 'customer'),
(71, 70, 'Category', 'noncash', 'customer'),
(72, 70, 'Category', 'risks', 'customer'),
(73, 70, 'Category', 'deployment_costs', 'customer'),
(74, 70, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(75, 70, 'NTT Accelerate SMART', 'opex', 'supplier'),
(76, 70, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(77, 70, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(78, 70, 'Influenced', 'capex', 'supplier'),
(79, 70, 'Influenced', 'equipment_revenues', 'supplier'),
(80, 68, 'Category', 'capex', 'customer'),
(81, 68, 'Category', 'opex', 'customer'),
(82, 68, 'Category', 'revenues', 'customer'),
(83, 68, 'Category', 'revenuesProtection', 'customer'),
(84, 68, 'Category', 'cashreleasing', 'customer'),
(85, 68, 'Category', 'widercash', 'customer'),
(86, 68, 'Category', 'quantifiable', 'customer'),
(87, 68, 'Category', 'noncash', 'customer'),
(88, 68, 'Category', 'risks', 'customer'),
(89, 68, 'Category', 'deployment_costs', 'customer'),
(90, 69, 'Category', 'capex', 'customer'),
(91, 69, 'Category', 'opex', 'customer'),
(92, 69, 'Category', 'revenues', 'customer'),
(93, 69, 'Category', 'revenuesProtection', 'customer'),
(94, 69, 'Category', 'cashreleasing', 'customer'),
(95, 69, 'Category', 'widercash', 'customer'),
(96, 69, 'Category', 'quantifiable', 'customer'),
(97, 69, 'Category', 'noncash', 'customer'),
(98, 69, 'Category', 'risks', 'customer'),
(99, 69, 'Category', 'deployment_costs', 'customer'),
(100, 72, 'Category', 'capex', 'customer'),
(101, 72, 'Category', 'opex', 'customer'),
(102, 72, 'Category', 'revenues', 'customer'),
(103, 72, 'Category', 'revenuesProtection', 'customer'),
(104, 72, 'Category', 'cashreleasing', 'customer'),
(105, 72, 'Category', 'widercash', 'customer'),
(106, 72, 'Category', 'quantifiable', 'customer'),
(107, 72, 'Category', 'noncash', 'customer'),
(108, 72, 'Category', 'risks', 'customer'),
(109, 72, 'Category', 'deployment_costs', 'customer'),
(110, 72, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(111, 72, 'NTT Accelerate SMART', 'opex', 'supplier'),
(112, 72, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(113, 72, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(114, 72, 'Influenced', 'capex', 'supplier'),
(115, 72, 'Influenced', 'equipment_revenues', 'supplier'),
(116, 71, 'Category', 'capex', 'customer'),
(117, 71, 'Category', 'opex', 'customer'),
(118, 71, 'Category', 'revenues', 'customer'),
(119, 71, 'Category', 'revenuesProtection', 'customer'),
(120, 71, 'Category', 'cashreleasing', 'customer'),
(121, 71, 'Category', 'widercash', 'customer'),
(122, 71, 'Category', 'quantifiable', 'customer'),
(123, 71, 'Category', 'noncash', 'customer'),
(124, 71, 'Category', 'risks', 'customer'),
(125, 71, 'Category', 'deployment_costs', 'customer'),
(126, 78, 'Category', 'capex', 'customer'),
(127, 78, 'Category', 'opex', 'customer'),
(128, 78, 'Category', 'revenues', 'customer'),
(129, 78, 'Category', 'revenuesProtection', 'customer'),
(130, 78, 'Category', 'cashreleasing', 'customer'),
(131, 78, 'Category', 'widercash', 'customer'),
(132, 78, 'Category', 'quantifiable', 'customer'),
(133, 78, 'Category', 'noncash', 'customer'),
(134, 78, 'Category', 'risks', 'customer'),
(135, 78, 'Category', 'deployment_costs', 'customer'),
(136, 78, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(137, 78, 'NTT Accelerate SMART', 'opex', 'supplier'),
(138, 78, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(139, 78, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(140, 78, 'Influenced', 'capex', 'supplier'),
(141, 78, 'Influenced', 'equipment_revenues', 'supplier'),
(142, 76, 'Category', 'capex', 'customer'),
(143, 76, 'Category', 'opex', 'customer'),
(144, 76, 'Category', 'revenues', 'customer'),
(145, 76, 'Category', 'revenuesProtection', 'customer'),
(146, 76, 'Category', 'cashreleasing', 'customer'),
(147, 76, 'Category', 'widercash', 'customer'),
(148, 76, 'Category', 'quantifiable', 'customer'),
(149, 76, 'Category', 'noncash', 'customer'),
(150, 76, 'Category', 'risks', 'customer'),
(151, 76, 'Category', 'deployment_costs', 'customer'),
(152, 74, 'Category', 'capex', 'customer'),
(153, 74, 'Category', 'opex', 'customer'),
(154, 74, 'Category', 'revenues', 'customer'),
(155, 74, 'Category', 'revenuesProtection', 'customer'),
(156, 74, 'Category', 'cashreleasing', 'customer'),
(157, 74, 'Category', 'widercash', 'customer'),
(158, 74, 'Category', 'quantifiable', 'customer'),
(159, 74, 'Category', 'noncash', 'customer'),
(160, 74, 'Category', 'risks', 'customer'),
(161, 74, 'Category', 'deployment_costs', 'customer'),
(162, 73, 'Category', 'capex', 'customer'),
(163, 73, 'Category', 'opex', 'customer'),
(164, 73, 'Category', 'revenues', 'customer'),
(165, 73, 'Category', 'revenuesProtection', 'customer'),
(166, 73, 'Category', 'cashreleasing', 'customer'),
(167, 73, 'Category', 'widercash', 'customer'),
(168, 73, 'Category', 'quantifiable', 'customer'),
(169, 73, 'Category', 'noncash', 'customer'),
(170, 73, 'Category', 'risks', 'customer'),
(171, 73, 'Category', 'deployment_costs', 'customer'),
(172, 79, 'Category', 'capex', 'customer'),
(173, 79, 'Category', 'opex', 'customer'),
(174, 79, 'Category', 'revenues', 'customer'),
(175, 79, 'Category', 'revenuesProtection', 'customer'),
(176, 79, 'Category', 'cashreleasing', 'customer'),
(177, 79, 'Category', 'widercash', 'customer'),
(178, 79, 'Category', 'quantifiable', 'customer'),
(179, 79, 'Category', 'noncash', 'customer'),
(180, 79, 'Category', 'risks', 'customer'),
(181, 79, 'Category', 'deployment_costs', 'customer'),
(182, 75, 'Category', 'capex', 'customer'),
(183, 75, 'Category', 'opex', 'customer'),
(184, 75, 'Category', 'revenues', 'customer'),
(185, 75, 'Category', 'revenuesProtection', 'customer'),
(186, 75, 'Category', 'cashreleasing', 'customer'),
(187, 75, 'Category', 'widercash', 'customer'),
(188, 75, 'Category', 'quantifiable', 'customer'),
(189, 75, 'Category', 'noncash', 'customer'),
(190, 75, 'Category', 'risks', 'customer'),
(191, 75, 'Category', 'deployment_costs', 'customer'),
(192, 77, 'Category', 'capex', 'customer'),
(193, 77, 'Category', 'opex', 'customer'),
(194, 77, 'Category', 'revenues', 'customer'),
(195, 77, 'Category', 'revenuesProtection', 'customer'),
(196, 77, 'Category', 'cashreleasing', 'customer'),
(197, 77, 'Category', 'widercash', 'customer'),
(198, 77, 'Category', 'quantifiable', 'customer'),
(199, 77, 'Category', 'noncash', 'customer'),
(200, 77, 'Category', 'risks', 'customer'),
(201, 77, 'Category', 'deployment_costs', 'customer'),
(202, 82, 'Category', 'capex', 'customer'),
(203, 82, 'Category', 'opex', 'customer'),
(204, 82, 'Category', 'revenues', 'customer'),
(205, 82, 'Category', 'revenuesProtection', 'customer'),
(206, 82, 'Category', 'cashreleasing', 'customer'),
(207, 82, 'Category', 'widercash', 'customer'),
(208, 82, 'Category', 'quantifiable', 'customer'),
(209, 82, 'Category', 'noncash', 'customer'),
(210, 82, 'Category', 'risks', 'customer'),
(211, 82, 'Category', 'deployment_costs', 'customer'),
(212, 82, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(213, 82, 'NTT Accelerate SMART', 'opex', 'supplier'),
(214, 82, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(215, 82, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(216, 82, 'Influenced', 'capex', 'supplier'),
(217, 82, 'Influenced', 'equipment_revenues', 'supplier'),
(218, 81, 'Category', 'capex', 'customer'),
(219, 81, 'Category', 'opex', 'customer'),
(220, 81, 'Category', 'revenues', 'customer'),
(221, 81, 'Category', 'revenuesProtection', 'customer'),
(222, 81, 'Category', 'cashreleasing', 'customer'),
(223, 81, 'Category', 'widercash', 'customer'),
(224, 81, 'Category', 'quantifiable', 'customer'),
(225, 81, 'Category', 'noncash', 'customer'),
(226, 81, 'Category', 'risks', 'customer'),
(227, 81, 'Category', 'deployment_costs', 'customer'),
(228, 80, 'Category', 'capex', 'customer'),
(229, 80, 'Category', 'opex', 'customer'),
(230, 80, 'Category', 'revenues', 'customer'),
(231, 80, 'Category', 'revenuesProtection', 'customer'),
(232, 80, 'Category', 'cashreleasing', 'customer'),
(233, 80, 'Category', 'widercash', 'customer'),
(234, 80, 'Category', 'quantifiable', 'customer'),
(235, 80, 'Category', 'noncash', 'customer'),
(236, 80, 'Category', 'risks', 'customer'),
(237, 80, 'Category', 'deployment_costs', 'customer'),
(238, 84, 'Category', 'capex', 'customer'),
(239, 84, 'Category', 'opex', 'customer'),
(240, 84, 'Category', 'revenues', 'customer'),
(241, 84, 'Category', 'revenuesProtection', 'customer'),
(242, 84, 'Category', 'cashreleasing', 'customer'),
(243, 84, 'Category', 'widercash', 'customer'),
(244, 84, 'Category', 'quantifiable', 'customer'),
(245, 84, 'Category', 'noncash', 'customer'),
(246, 84, 'Category', 'risks', 'customer'),
(247, 84, 'Category', 'deployment_costs', 'customer'),
(248, 84, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(249, 84, 'NTT Accelerate SMART', 'opex', 'supplier'),
(250, 84, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(251, 84, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(252, 84, 'Influenced', 'capex', 'supplier'),
(253, 84, 'Influenced', 'equipment_revenues', 'supplier'),
(254, 83, 'Category', 'capex', 'customer'),
(255, 83, 'Category', 'opex', 'customer'),
(256, 83, 'Category', 'revenues', 'customer'),
(257, 83, 'Category', 'revenuesProtection', 'customer'),
(258, 83, 'Category', 'cashreleasing', 'customer'),
(259, 83, 'Category', 'widercash', 'customer'),
(260, 83, 'Category', 'quantifiable', 'customer'),
(261, 83, 'Category', 'noncash', 'customer'),
(262, 83, 'Category', 'risks', 'customer'),
(263, 83, 'Category', 'deployment_costs', 'customer'),
(264, 86, 'Category', 'capex', 'customer'),
(265, 86, 'Category', 'opex', 'customer'),
(266, 86, 'Category', 'revenues', 'customer'),
(267, 86, 'Category', 'revenuesProtection', 'customer'),
(268, 86, 'Category', 'cashreleasing', 'customer'),
(269, 86, 'Category', 'widercash', 'customer'),
(270, 86, 'Category', 'quantifiable', 'customer'),
(271, 86, 'Category', 'noncash', 'customer'),
(272, 86, 'Category', 'risks', 'customer'),
(273, 86, 'Category', 'deployment_costs', 'customer'),
(274, 86, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(275, 86, 'NTT Accelerate SMART', 'opex', 'supplier'),
(276, 86, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(277, 86, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(278, 86, 'Influenced', 'capex', 'supplier'),
(279, 86, 'Influenced', 'equipment_revenues', 'supplier'),
(280, 85, 'Category', 'capex', 'customer'),
(281, 85, 'Category', 'opex', 'customer'),
(282, 85, 'Category', 'revenues', 'customer'),
(283, 85, 'Category', 'revenuesProtection', 'customer'),
(284, 85, 'Category', 'cashreleasing', 'customer'),
(285, 85, 'Category', 'widercash', 'customer'),
(286, 85, 'Category', 'quantifiable', 'customer'),
(287, 85, 'Category', 'noncash', 'customer'),
(288, 85, 'Category', 'risks', 'customer'),
(289, 85, 'Category', 'deployment_costs', 'customer'),
(290, 90, 'Category', 'capex', 'customer'),
(291, 90, 'Category', 'opex', 'customer'),
(292, 90, 'Category', 'revenues', 'customer'),
(293, 90, 'Category', 'revenuesProtection', 'customer'),
(294, 90, 'Category', 'cashreleasing', 'customer'),
(295, 90, 'Category', 'widercash', 'customer'),
(296, 90, 'Category', 'quantifiable', 'customer'),
(297, 90, 'Category', 'noncash', 'customer'),
(298, 90, 'Category', 'risks', 'customer'),
(299, 90, 'Category', 'deployment_costs', 'customer'),
(300, 90, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(301, 90, 'NTT Accelerate SMART', 'opex', 'supplier'),
(302, 90, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(303, 90, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(304, 90, 'Influenced', 'capex', 'supplier'),
(305, 90, 'Influenced', 'equipment_revenues', 'supplier'),
(306, 91, 'Category', 'capex', 'customer'),
(307, 91, 'Category', 'opex', 'customer'),
(308, 91, 'Category', 'revenues', 'customer'),
(309, 91, 'Category', 'revenuesProtection', 'customer'),
(310, 91, 'Category', 'cashreleasing', 'customer'),
(311, 91, 'Category', 'widercash', 'customer'),
(312, 91, 'Category', 'quantifiable', 'customer'),
(313, 91, 'Category', 'noncash', 'customer'),
(314, 91, 'Category', 'risks', 'customer'),
(315, 91, 'Category', 'deployment_costs', 'customer'),
(316, 88, 'Category', 'capex', 'customer'),
(317, 88, 'Category', 'opex', 'customer'),
(318, 88, 'Category', 'revenues', 'customer'),
(319, 88, 'Category', 'revenuesProtection', 'customer'),
(320, 88, 'Category', 'cashreleasing', 'customer'),
(321, 88, 'Category', 'widercash', 'customer'),
(322, 88, 'Category', 'quantifiable', 'customer'),
(323, 88, 'Category', 'noncash', 'customer'),
(324, 88, 'Category', 'risks', 'customer'),
(325, 88, 'Category', 'deployment_costs', 'customer'),
(326, 89, 'Category', 'capex', 'customer'),
(327, 89, 'Category', 'opex', 'customer'),
(328, 89, 'Category', 'revenues', 'customer'),
(329, 89, 'Category', 'revenuesProtection', 'customer'),
(330, 89, 'Category', 'cashreleasing', 'customer'),
(331, 89, 'Category', 'widercash', 'customer'),
(332, 89, 'Category', 'quantifiable', 'customer'),
(333, 89, 'Category', 'noncash', 'customer'),
(334, 89, 'Category', 'risks', 'customer'),
(335, 89, 'Category', 'deployment_costs', 'customer'),
(336, 87, 'Category', 'capex', 'customer'),
(337, 87, 'Category', 'opex', 'customer'),
(338, 87, 'Category', 'revenues', 'customer'),
(339, 87, 'Category', 'revenuesProtection', 'customer'),
(340, 87, 'Category', 'cashreleasing', 'customer'),
(341, 87, 'Category', 'widercash', 'customer'),
(342, 87, 'Category', 'quantifiable', 'customer'),
(343, 87, 'Category', 'noncash', 'customer'),
(344, 87, 'Category', 'risks', 'customer'),
(345, 87, 'Category', 'deployment_costs', 'customer'),
(346, 95, 'Category', 'capex', 'customer'),
(347, 95, 'Category', 'opex', 'customer'),
(348, 95, 'Category', 'revenues', 'customer'),
(349, 95, 'Category', 'revenuesProtection', 'customer'),
(350, 95, 'Category', 'cashreleasing', 'customer'),
(351, 95, 'Category', 'widercash', 'customer'),
(352, 95, 'Category', 'quantifiable', 'customer'),
(353, 95, 'Category', 'noncash', 'customer'),
(354, 95, 'Category', 'risks', 'customer'),
(355, 95, 'Category', 'deployment_costs', 'customer'),
(356, 95, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(357, 95, 'NTT Accelerate SMART', 'opex', 'supplier'),
(358, 95, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(359, 95, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(360, 95, 'Influenced', 'capex', 'supplier'),
(361, 95, 'Influenced', 'equipment_revenues', 'supplier'),
(362, 96, 'Category', 'capex', 'customer'),
(363, 96, 'Category', 'opex', 'customer'),
(364, 96, 'Category', 'revenues', 'customer'),
(365, 96, 'Category', 'revenuesProtection', 'customer'),
(366, 96, 'Category', 'cashreleasing', 'customer'),
(367, 96, 'Category', 'widercash', 'customer'),
(368, 96, 'Category', 'quantifiable', 'customer'),
(369, 96, 'Category', 'noncash', 'customer'),
(370, 96, 'Category', 'risks', 'customer'),
(371, 96, 'Category', 'deployment_costs', 'customer'),
(372, 93, 'Category', 'capex', 'customer'),
(373, 93, 'Category', 'opex', 'customer'),
(374, 93, 'Category', 'revenues', 'customer'),
(375, 93, 'Category', 'revenuesProtection', 'customer'),
(376, 93, 'Category', 'cashreleasing', 'customer'),
(377, 93, 'Category', 'widercash', 'customer'),
(378, 93, 'Category', 'quantifiable', 'customer'),
(379, 93, 'Category', 'noncash', 'customer'),
(380, 93, 'Category', 'risks', 'customer'),
(381, 93, 'Category', 'deployment_costs', 'customer'),
(382, 94, 'Category', 'capex', 'customer'),
(383, 94, 'Category', 'opex', 'customer'),
(384, 94, 'Category', 'revenues', 'customer'),
(385, 94, 'Category', 'revenuesProtection', 'customer'),
(386, 94, 'Category', 'cashreleasing', 'customer'),
(387, 94, 'Category', 'widercash', 'customer'),
(388, 94, 'Category', 'quantifiable', 'customer'),
(389, 94, 'Category', 'noncash', 'customer'),
(390, 94, 'Category', 'risks', 'customer'),
(391, 94, 'Category', 'deployment_costs', 'customer'),
(392, 97, 'Category', 'capex', 'customer'),
(393, 97, 'Category', 'opex', 'customer'),
(394, 97, 'Category', 'revenues', 'customer'),
(395, 97, 'Category', 'revenuesProtection', 'customer'),
(396, 97, 'Category', 'cashreleasing', 'customer'),
(397, 97, 'Category', 'widercash', 'customer'),
(398, 97, 'Category', 'quantifiable', 'customer'),
(399, 97, 'Category', 'noncash', 'customer'),
(400, 97, 'Category', 'risks', 'customer'),
(401, 97, 'Category', 'deployment_costs', 'customer'),
(402, 92, 'Category', 'capex', 'customer'),
(403, 92, 'Category', 'opex', 'customer'),
(404, 92, 'Category', 'revenues', 'customer'),
(405, 92, 'Category', 'revenuesProtection', 'customer'),
(406, 92, 'Category', 'cashreleasing', 'customer'),
(407, 92, 'Category', 'widercash', 'customer'),
(408, 92, 'Category', 'quantifiable', 'customer'),
(409, 92, 'Category', 'noncash', 'customer'),
(410, 92, 'Category', 'risks', 'customer'),
(411, 92, 'Category', 'deployment_costs', 'customer'),
(412, 99, 'Category', 'capex', 'customer'),
(413, 99, 'Category', 'opex', 'customer'),
(414, 99, 'Category', 'revenues', 'customer'),
(415, 99, 'Category', 'revenuesProtection', 'customer'),
(416, 99, 'Category', 'cashreleasing', 'customer'),
(417, 99, 'Category', 'widercash', 'customer'),
(418, 99, 'Category', 'quantifiable', 'customer'),
(419, 99, 'Category', 'noncash', 'customer'),
(420, 99, 'Category', 'risks', 'customer'),
(421, 99, 'Category', 'deployment_costs', 'customer'),
(422, 99, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(423, 99, 'NTT Accelerate SMART', 'opex', 'supplier'),
(424, 99, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(425, 99, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(426, 99, 'Influenced', 'capex', 'supplier'),
(427, 99, 'Influenced', 'equipment_revenues', 'supplier'),
(428, 98, 'Category', 'capex', 'customer'),
(429, 98, 'Category', 'opex', 'customer'),
(430, 98, 'Category', 'revenues', 'customer'),
(431, 98, 'Category', 'revenuesProtection', 'customer'),
(432, 98, 'Category', 'cashreleasing', 'customer'),
(433, 98, 'Category', 'widercash', 'customer'),
(434, 98, 'Category', 'quantifiable', 'customer'),
(435, 98, 'Category', 'noncash', 'customer'),
(436, 98, 'Category', 'risks', 'customer'),
(437, 98, 'Category', 'deployment_costs', 'customer'),
(438, 100, 'Category', 'capex', 'customer'),
(439, 100, 'Category', 'opex', 'customer'),
(440, 100, 'Category', 'revenues', 'customer'),
(441, 100, 'Category', 'revenuesProtection', 'customer'),
(442, 100, 'Category', 'cashreleasing', 'customer'),
(443, 100, 'Category', 'widercash', 'customer'),
(444, 100, 'Category', 'quantifiable', 'customer'),
(445, 100, 'Category', 'noncash', 'customer'),
(446, 100, 'Category', 'risks', 'customer'),
(447, 100, 'Category', 'deployment_costs', 'customer'),
(448, 100, 'NTT Accelerate SMART', 'deployment_costs', 'supplier'),
(449, 100, 'NTT Accelerate SMART', 'opex', 'supplier'),
(450, 100, 'NTT Accelerate SMART', 'deployment_revenues', 'supplier'),
(451, 100, 'NTT Accelerate SMART', 'operating_revenues', 'supplier'),
(452, 100, 'Influenced', 'capex', 'supplier'),
(453, 100, 'Influenced', 'equipment_revenues', 'supplier'),
(454, 103, 'Category', 'capex', 'customer'),
(455, 103, 'Category', 'opex', 'customer'),
(456, 103, 'Category', 'revenues', 'customer'),
(457, 103, 'Category', 'revenuesProtection', 'customer'),
(458, 103, 'Category', 'cashreleasing', 'customer'),
(459, 103, 'Category', 'widercash', 'customer'),
(460, 103, 'Category', 'quantifiable', 'customer'),
(461, 103, 'Category', 'noncash', 'customer'),
(462, 103, 'Category', 'risks', 'customer'),
(463, 103, 'Category', 'deployment_costs', 'customer'),
(464, 101, 'Category', 'capex', 'customer'),
(465, 101, 'Category', 'opex', 'customer'),
(466, 101, 'Category', 'revenues', 'customer'),
(467, 101, 'Category', 'revenuesProtection', 'customer'),
(468, 101, 'Category', 'cashreleasing', 'customer'),
(469, 101, 'Category', 'widercash', 'customer'),
(470, 101, 'Category', 'quantifiable', 'customer'),
(471, 101, 'Category', 'noncash', 'customer'),
(472, 101, 'Category', 'risks', 'customer'),
(473, 101, 'Category', 'deployment_costs', 'customer'),
(474, 102, 'Category', 'capex', 'customer'),
(475, 102, 'Category', 'opex', 'customer'),
(476, 102, 'Category', 'revenues', 'customer'),
(477, 102, 'Category', 'revenuesProtection', 'customer'),
(478, 102, 'Category', 'cashreleasing', 'customer'),
(479, 102, 'Category', 'widercash', 'customer'),
(480, 102, 'Category', 'quantifiable', 'customer'),
(481, 102, 'Category', 'noncash', 'customer'),
(482, 102, 'Category', 'risks', 'customer'),
(483, 102, 'Category', 'deployment_costs', 'customer');

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
