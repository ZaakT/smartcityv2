-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 07 sep. 2020 à 14:21
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_capex` (IN `capex_name` VARCHAR(255), IN `capex_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `origine` VARCHAR(255))  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO capex_item (name,description, origine)
                                    VALUES (capex_name,capex_desc, origine);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO capex_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO capex_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
                            END$$

DROP PROCEDURE IF EXISTS `add_cashreleasing`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_cashreleasing` (IN `cashreleasing_name` VARCHAR(255), IN `cashreleasing_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO cashreleasing_item (name,description)
                                    VALUES (cashreleasing_name,cashreleasing_desc);
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_implem` (IN `implem_name` VARCHAR(255), IN `implem_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `origine` VARCHAR(255))  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO implem_item (name,description, origine)
                                    VALUES (implem_name,implem_desc, origine);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO implem_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO implem_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_opex` (IN `opex_name` VARCHAR(255), IN `opex_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT, IN `origine` VARCHAR(255))  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO opex_item (name,description, origine)
                                    VALUES (opex_name,opex_desc, origine);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO opex_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO opex_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_revenues` (IN `revenues_name` VARCHAR(255), IN `revenues_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO revenues_item (name,description)
                                    VALUES (revenues_name,revenues_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO revenues_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO revenues_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
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

DROP PROCEDURE IF EXISTS `add_widercash`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_widercash` (IN `widercash_name` VARCHAR(255), IN `widercash_desc` VARCHAR(255), IN `idUC` INT, IN `idProj` INT)  BEGIN
                                DECLARE itemID INT;
                                INSERT INTO widercash_item (name,description)
                                    VALUES (widercash_name,widercash_desc);
                                SET itemID = LAST_INSERT_ID();
                                INSERT INTO widercash_uc (id_item,id_uc)
                                    VALUES (itemID,idUC);
                                INSERT INTO widercash_item_user (id,id_proj)
                                    VALUES (itemID,idProj);
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bankability_input_nogo_target`
--

INSERT INTO `bankability_input_nogo_target` (`id`, `npv_nogo`, `npv_target`, `roi_nogo`, `roi_target`, `payback_nogo`, `payback_target`, `risks_rating_nogo`, `risks_rating_target`, `noncash_rating_nogo`, `noncash_rating_target`) VALUES
(4, 3, 10000, 32, 43, 89, 2, 8, 3, 2, 2),
(6, 10, 10, 20, 20, 5, 5, 5, 5, 3, 3);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `business_model`
--

INSERT INTO `business_model` (`id_investcap`, `id_payconst`, `id_bmpref`, `id_proj`) VALUES
(3, 3, 1, 4);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
  `origine` enum('from_ntt','from_outside_ntt') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'from_ntt' COMMENT 'Used in supplier part',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_item`
--

INSERT INTO `capex_item` (`id`, `name`, `description`, `origine`) VALUES
(4, 'Capex name delibererement long 1', '', 'from_ntt'),
(2, 'capexitem1', '', 'from_ntt'),
(3, 'capexitem2', '', 'from_ntt'),
(5, 'Capex name delibererement long 2', '', 'from_ntt'),
(13, 'custom capex item', 'descr', 'from_ntt'),
(17, '_-fghçjiopk', '', 'from_ntt'),
(15, '5G capex item', '', 'from_ntt'),
(25, 'a', '', 'from_ntt'),
(26, 'a', '', 'from_ntt'),
(27, 'Diego Mejia', '', 'from_ntt'),
(28, 'test outside', '', 'from_outside_ntt'),
(29, 'test internal', '', ''),
(30, 'test ntt', '', 'from_ntt'),
(31, 'capexitem2', '', 'from_ntt'),
(32, 'a', '', ''),
(35, 'b', '', 'from_ntt'),
(39, 'orange', '', 'from_outside_ntt'),
(38, 'internal', '', 'from_ntt');

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_item_advice`
--

INSERT INTO `capex_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`) VALUES
(2, 'percapexitem1', NULL, 0, 100),
(3, 'per capexitem2', NULL, 0, 100),
(4, 'per example', NULL, 5, 10),
(5, 'per example', NULL, 7, 100),
(14, 'ver', 'vr', 3, 43),
(12, '', '', 1, 56),
(16, '', '', 54, 54);

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
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_item_user`
--

INSERT INTO `capex_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(13, 4),
(15, 4),
(17, 6),
(18, 8),
(19, 8),
(20, 8),
(21, 8),
(22, 8),
(23, 4),
(24, 4),
(25, 4),
(26, 3),
(27, 3),
(28, 8),
(29, 8),
(30, 8),
(31, 6),
(32, 6),
(33, 8),
(34, 8),
(35, 3),
(36, 4),
(37, 4),
(38, 4),
(39, 8),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `capex_uc`
--

INSERT INTO `capex_uc` (`id_item`, `id_uc`) VALUES
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(5, 1),
(12, 3),
(13, 1),
(14, 6),
(15, 7),
(16, 6),
(17, 3),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 7),
(24, 7),
(25, 7),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 3),
(36, 1),
(37, 1),
(38, 1),
(39, 7),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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
(8, 'cash', ''),
(9, 'test', ''),
(10, 'cash item', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cashreleasing_item_advice`
--

INSERT INTO `cashreleasing_item_advice` (`id`, `unit`, `source`, `unit_cost`, `range_min_red_nb`, `range_max_red_nb`, `range_min_red_cost`, `range_max_red_cost`) VALUES
(1, 'per example', NULL, 15, 1.2, 1.8, 10, 11),
(2, 'per example', NULL, 1, 2, 3, 4, 5),
(3, 'per example', NULL, 2, 3, 4, 5, 6);

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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
(9, 3),
(10, 3);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cashreleasing_uc`
--

INSERT INTO `cashreleasing_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 3),
(6, 5),
(7, 2),
(8, 7),
(9, 3),
(10, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `deal_criteria_input_nogo_target`
--

INSERT INTO `deal_criteria_input_nogo_target` (`id`, `societal_npv_nogo`, `societal_npv_target`, `societal_roi_nogo`, `societal_roi_target`, `societal_payback_nogo`, `societal_payback_target`, `npv_nogo`, `npv_target`, `roi_nogo`, `roi_target`, `payback_nogo`, `payback_target`, `risks_rating_nogo`, `risks_rating_target`, `nqbr_nogo`, `nqbr_target`) VALUES
(6, 3, 30000, 1, 20, 20, 10, 1500, 150000, 2, 20, 50, 10, 8, 3, 3, 7),
(3, 5000, 30000, 10, 30, 36, 12, 5000, 30000, 10, 30, 36, 12, 3, 0, 3, 7);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dlt`
--

INSERT INTO `dlt` (`id`, `name`, `description`) VALUES
(1, 'city', ''),
(2, 'subzone', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entity`
--

INSERT INTO `entity` (`id`, `id_source`, `id_finScen`, `name`, `description`, `start_date`, `share`) VALUES
(1, 1, 3, 'feçhvof', '', '2020-02-01', 90),
(2, 1, 3, 'entity 2', '', '2020-01-01', 10),
(3, 1, 4, 'ENT', '', '2013-06-01', 30);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `financing_scenario`
--

INSERT INTO `financing_scenario` (`id`, `name`, `description`, `input_invest`, `input_op`, `creation_date`, `modif_date`, `id_proj`) VALUES
(1, 'scenar1', '', -1, -1, '2020-02-11 14:55:35', NULL, 0),
(2, 'scnear', '', -1, -1, '2020-02-11 14:55:41', NULL, 0),
(3, 'scenar1', 'scenar test du 2 mars', 136632.5, 345, '2020-03-02 14:01:30', '2020-04-28 11:59:10', 4),
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_item`
--

INSERT INTO `implem_item` (`id`, `name`, `description`, `origine`) VALUES
(1, 'impitem1', '', 'from_ntt'),
(3, 'implementation item 2', 'description', 'from_ntt'),
(4, 'implementation item 2', '', 'from_ntt'),
(5, 'test imp item', '10/03 10:28', 'from_ntt'),
(6, 'IMPLEM', '', 'from_ntt'),
(8, '5G IMPLEM ITEM', '', 'from_ntt'),
(11, 'aaaa', '', 'from_ntt'),
(12, 'custom opex 1', '', 'from_ntt'),
(23, 'deployment from ntt', '', 'from_ntt'),
(25, 'dep internal ', '', 'internal'),
(26, 'ouvrier', '', 'internal'),
(24, 'deployment from outside ntt', '', 'from_outside_ntt'),
(27, 'Dep test', '', 'from_ntt');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_item_advice`
--

INSERT INTO `implem_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`) VALUES
(1, 'per blabla', NULL, 50, 102),
(3, 'per truc', NULL, 10, 20),
(5, '', '', 13, 14),
(7, 'vfg', '', 2, 21);

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
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_item_user`
--

INSERT INTO `implem_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(3, 1),
(4, 4),
(6, 4),
(8, 4),
(9, 8),
(10, 8),
(11, 8),
(12, 8),
(13, 8),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 3),
(24, 3),
(25, 3),
(26, 8),
(27, 3),
(28, 3),
(29, 3);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_schedule`
--

INSERT INTO `implem_schedule` (`id_uc`, `id_proj`, `start_date`, `25_completion`, `50_completion`, `75_completion`, `100_completion`) VALUES
(3, 3, '2020-01-01', '2020-02-01', '2020-03-01', '2020-04-01', '2021-04-01'),
(1, 3, '2020-01-01', '2020-02-01', '2020-03-01', '2020-04-01', '2021-04-01'),
(3, 6, '2012-02-01', '2013-03-01', '2013-08-01', '2014-08-01', '2014-12-01'),
(1, 6, '2012-02-01', '2013-03-01', '2013-08-01', '2014-08-01', '2014-12-01'),
(10, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(3, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(5, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(1, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(9, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(2, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(7, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(11, 4, '2012-01-01', '2012-02-01', '2013-02-01', '2014-02-01', '2015-02-01'),
(2, 3, '2020-01-01', '2020-02-01', '2020-03-01', '2020-04-01', '2021-04-01'),
(11, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(10, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(3, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(5, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(1, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(9, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(2, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01'),
(7, 8, '2014-02-01', '2014-04-01', '2014-08-01', '2014-11-01', '2015-02-01');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `implem_uc`
--

INSERT INTO `implem_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(3, 1),
(4, 2),
(5, 5),
(6, 3),
(7, 6),
(8, 7),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 7),
(27, 2),
(28, 2),
(29, 2);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_capex`
--

INSERT INTO `input_capex` (`id_item`, `id_proj`, `id_uc`, `volume`, `unit_cost`, `period`) VALUES
(1, 1, 1, 0, 0, 3),
(2, 1, 2, NULL, NULL, NULL),
(3, 1, 2, NULL, NULL, NULL),
(4, 1, 1, 0, 0, 4),
(5, 1, 1, 0, 0, 5),
(4, 4, 1, 357156, 7.5, 5),
(5, 4, 1, 6614, 53.5, 5),
(2, 4, 2, 19, 50, 1),
(3, 4, 2, 543, 50, 1),
(12, 4, 3, 43, 28.5, 5),
(4, 6, 1, 200, 20, 2),
(3, 6, 1, 1000, 500, 1),
(15, 4, 7, 1568, 54, 54),
(17, 6, 3, NULL, NULL, NULL),
(2, 3, 2, 50, 10, 3),
(35, 3, 3, 0, 0, 5),
(39, 8, 7, 200, 150, 3),
(28, 8, 1, 5, 12050, 2),
(4, 8, 1, 15200, 10, 4),
(30, 8, 1, 43, 156, 3),
(3, 8, 1, 500, 100, 1),
(5, 8, 1, 50, 1500, 2),
(3, 3, 2, 1250, 12, 5),
(40, 3, 2, 50000, 5, 3);

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
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_cashreleasing`
--

INSERT INTO `input_cashreleasing` (`id_item`, `id_proj`, `id_uc`, `unit_indicator`, `volume`, `ratio`, `unit_cost`, `volume_reduc`, `unit_cost_reduc`, `annual_var_volume`, `annual_var_unit_cost`) VALUES
(1, 1, 1, 'per example', 0, NULL, 0, 0, 0, 0, 0),
(3, 4, 1, 'per example', 4544, 284, 0, 0, 0, 0, 0),
(3, 1, 1, 'per example', 0, NULL, 0, 0, 0, 0, 0),
(1, 4, 1, 'per example', 864, 54, 0, 0, 0, 0, 0),
(5, 4, 3, 'VUIG', 66, NULL, 12, 5, 19, 89, 78),
(4, 4, 2, 'EUIHV', 54, NULL, 5, 54, 5, 5, 5),
(7, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 8, 1, 'per example', 10, NULL, 10, 5, 6, 5, 5),
(1, 8, 1, 'per example', 1500, NULL, 500, 5, 0, 5, 5),
(2, 8, 1, 'per example', 5, NULL, 12000, 10, 10, 5, 5),
(3, 6, 1, 'per example', 10, NULL, 10, 1, 4, 10, 5),
(1, 6, 1, 'per example', 20, NULL, 58, 2, 5, 1, 2),
(2, 6, 1, 'per example', 30, NULL, 4, 4, 2, 4, 5),
(8, 8, 7, 'per', 10, NULL, 50, 5, 3, 10, 50),
(9, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 3, 2, 'per', 10, NULL, 50, 3, 5, 2, 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_implem`
--

INSERT INTO `input_implem` (`id_proj`, `id_item`, `id_uc`, `volume`, `unit_cost`) VALUES
(1, 1, 1, 0, 0),
(1, 3, 1, 0, 0),
(4, 1, 1, 80, 76),
(4, 3, 1, 64, 15),
(4, 4, 2, 1900, 1),
(4, 6, 3, 621, 2),
(4, 8, 7, 43545, 5),
(8, 12, 1, 1, 13000),
(8, 3, 1, 1025, 25),
(6, 1, 1, 200, 500),
(8, 1, 1, 100, 10),
(4, 15, 1, NULL, NULL),
(8, 26, 7, 15, 100),
(3, 27, 2, 130, 50);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(11, 8, 7, 2, 50),
(12, 3, 2, 3, 50);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_opex`
--

INSERT INTO `input_opex` (`id_proj`, `id_item`, `id_uc`, `volume`, `ratio`, `unit_cost`, `annual_variation_volume`, `annual_variation_unitcost`) VALUES
(1, 1, 1, 0, NULL, 0, 0, 0),
(1, 2, 1, 1000, NULL, 9.965, 10, 6),
(4, 1, 1, 21, 1, 6, 0, 0),
(4, 3, 2, 4, NULL, 5, 65, 5),
(4, 2, 1, 67, 4, 2, 0, 0),
(4, 4, 3, 56, NULL, 78, 6, 6),
(4, 5, 2, 54, NULL, 5, 0, 0),
(8, 2, 1, 100, NULL, 10, 5, 5),
(8, 16, 7, 100, NULL, 15, 5, 2),
(6, 2, 1, 300, NULL, 152, 10, 5),
(4, 9, 1, 0, NULL, 0, 0, 0),
(4, 10, 1, 0, NULL, 0, 0, 0),
(3, 4, 3, 50, NULL, 100, 4, 4),
(3, 5, 2, 1500, NULL, 10, 3, 5),
(3, 3, 2, 300, NULL, 500, 5, 5);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_quantifiable`
--

INSERT INTO `input_quantifiable` (`id_item`, `id_proj`, `id_uc`, `unit_indicator`, `volume`, `volume_reduc`, `annual_var_volume`) VALUES
(1, 4, 7, 'per test', 43, 43, 54),
(5, 8, 1, NULL, NULL, NULL, NULL),
(6, 8, 1, 'personne', 750, 10, 5),
(4, 8, 7, 'per unit', 12, 1, 1),
(1, 8, 7, 'per ...', 15, 2, 2),
(7, 3, 2, 'per', 10, 15, 5);

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
  PRIMARY KEY (`id_proj`,`id_item`,`id_uc`),
  KEY `id_item` (`id_item`),
  KEY `id_uc` (`id_uc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_revenues`
--

INSERT INTO `input_revenues` (`id_proj`, `id_item`, `id_uc`, `volume`, `ratio`, `revenues_per_unit`, `annual_variation_volume`, `annual_variation_unitcost`) VALUES
(1, 1, 1, 5, NULL, 2, 0, 0),
(4, 1, 1, 16, 1, 0, 0, 0),
(4, 3, 2, 453, NULL, 54, 54, 5),
(4, 4, 3, 78, NULL, 2, 45, 12),
(4, 6, 2, NULL, NULL, NULL, NULL, NULL),
(8, 1, 1, 5, NULL, 5, 5, 6),
(8, 2, 1, 50, NULL, 1500, 3, 1),
(8, 7, 7, 50, NULL, 54, 12, 5),
(3, 8, 2, 15, NULL, 550, 3, 2);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(8, 8, 7, 3, 10),
(9, 3, 2, 3, 20);

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
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `input_widercash`
--

INSERT INTO `input_widercash` (`id_item`, `id_proj`, `id_uc`, `unit_indicator`, `volume`, `ratio`, `unit_cost`, `volume_reduc`, `unit_cost_reduc`, `annual_var_volume`, `annual_var_unit_cost`) VALUES
(1, 1, 1, 'per blabla', 0, NULL, 0, 0, 0, 0, 0),
(2, 1, 1, 'per oiuhrf', 0, NULL, 0, 0, 0, 0, 0),
(1, 4, 1, 'per example', 578, 36, 0, 0, 0, 0, 0),
(2, 4, 1, 'per example', 13, 1, 0, 0, 0, 0, 0),
(3, 4, 3, 'per unit', 54, NULL, 43, 4, 32, 4, 4),
(4, 4, 2, 'FTR', 54, NULL, 32, 35, 7, 65, 56),
(6, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 8, 1, 'per example', 5, NULL, 10, 1, 2, 4, 4),
(2, 8, 1, 'per example', 500, NULL, 2, 2, 2, 7, 5),
(1, 6, 1, 'per example', 10, NULL, 20, 4, 5, 40, 2),
(8, 8, 7, 'GRTFED', 50, NULL, 10, 5, 10, 2, 5),
(6, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `magnitude`
--

INSERT INTO `magnitude` (`id`, `name`, `range_min`, `range_max`) VALUES
(3, 'Limited Perimeter', 5, 25),
(2, 'Proof Of Concept', 1, 5);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `measure`
--

INSERT INTO `measure` (`id`, `name`, `description`, `user`) VALUES
(1, 'Measure1', '', 0),
(4, 'measure test admin', 'test test', 1),
(11, 'Project Management Zak', '', 4),
(12, 'Project Management test', '', 6),
(13, 'Project Management test1', '', 7),
(14, 'Project Management test2', '', 8),
(15, 'Project Management ZakSup', '', 10),
(16, 'Project Management adminD', '', 11);

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

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
(11, 'ncb', '', NULL),
(12, 'nan cash item', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `noncash_item_advice`
--

DROP TABLE IF EXISTS `noncash_item_advice`;
CREATE TABLE IF NOT EXISTS `noncash_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `noncash_item_user`
--

INSERT INTO `noncash_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 4),
(4, 4),
(5, 4),
(9, 8),
(10, 6),
(11, 8),
(12, 3);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `noncash_uc`
--

INSERT INTO `noncash_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 3),
(5, 2),
(6, 5),
(7, 5),
(8, 3),
(9, 1),
(10, 1),
(11, 7),
(12, 2);

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_item`
--

INSERT INTO `opex_item` (`id`, `name`, `description`, `origine`) VALUES
(1, 'opexitem1', '', 'from_ntt'),
(2, 'opex item 2', '', 'from_ntt'),
(3, 'uc2 opex', '', 'from_ntt'),
(4, 'TEST OPEX ITEM', '10H 10 MARS', 'from_ntt'),
(5, 'OPEX', '', 'from_ntt'),
(19, 'opex', '', 'from_ntt'),
(16, 'elec', '', 'from_ntt'),
(15, 'opex from outside ntt', '', 'from_ntt'),
(14, 'opex from ntt', '', 'from_ntt');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_item_advice`
--

INSERT INTO `opex_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`) VALUES
(1, 'per ...', NULL, 5, 8),
(2, 'per ...', NULL, 2, 3),
(4, 'per blabla', '', 5, 6),
(3, 'per tructruc', NULL, 5, 4),
(5, 'per bla', NULL, 2, 5);

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_item_user`
--

INSERT INTO `opex_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 4),
(5, 4),
(6, 8),
(7, 8),
(8, 8),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 8),
(17, 3),
(18, 3),
(19, 3);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_schedule`
--

INSERT INTO `opex_schedule` (`id_uc`, `id_proj`, `start_date`, `25_rampup`, `50_rampup`, `75_rampup`, `100_rampup`, `end_date`) VALUES
(2, 1, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2020-07-01'),
(1, 1, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2020-07-01'),
(3, 3, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2022-02-01'),
(1, 3, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2022-02-01'),
(3, 6, '2012-03-01', '2012-09-01', '2013-04-01', '2013-09-01', '2014-09-01', '2015-02-01'),
(1, 6, '2012-03-01', '2012-09-01', '2013-04-01', '2013-09-01', '2014-09-01', '2015-02-01'),
(10, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(3, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(5, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(1, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(9, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(2, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(7, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(11, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(2, 3, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2022-02-01'),
(11, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(10, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(3, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(5, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(1, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(9, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(2, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01'),
(7, 8, '2015-04-01', '2015-06-01', '2015-12-01', '2016-02-01', '2016-04-01', '2016-09-01');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `opex_uc`
--

INSERT INTO `opex_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3),
(5, 2),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 7),
(17, 2),
(18, 2),
(19, 2);

-- --------------------------------------------------------

--
-- Structure de la table `others`
--

DROP TABLE IF EXISTS `others`;
CREATE TABLE IF NOT EXISTS `others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `discount_rate`, `weight_bank`, `weight_bank_soc`, `creation_date`, `modif_date`, `id_user`, `scoping`, `cb`) VALUES
(4, 'test', '28 02', 3.5, NULL, NULL, '2020-02-28 13:06:40', '2020-09-02 14:09:19', 1, 1, 0),
(3, 'TESTV2', '', 3, NULL, NULL, '2020-02-27 13:29:51', '2020-09-07 15:21:30', 1, 1, 1),
(6, 'projet 25 mai', '', 3, NULL, NULL, '2020-05-25 16:01:23', '2020-09-02 16:03:30', 1, 1, 1),
(7, 'SupplierZak', 'test', NULL, NULL, NULL, '2020-08-17 09:43:18', '2020-08-17 09:47:32', 10, 0, 0),
(8, 'MyProject', '', 4, NULL, NULL, '2020-08-28 15:01:37', '2020-09-02 16:11:34', 1, 1, 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project_perimeter`
--

INSERT INTO `project_perimeter` (`id_proj`, `id_zone`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(3, 1),
(3, 2),
(3, 4),
(3, 7),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(5, 1),
(5, 7),
(6, 1),
(6, 2),
(6, 4),
(6, 5),
(7, 1),
(7, 3),
(7, 6),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project_size`
--

INSERT INTO `project_size` (`id_uc`, `id_zone`, `id_mag`, `id_proj`) VALUES
(1, 3, 3, 1),
(1, 4, 2, 1),
(1, 4, 2, 3),
(1, 4, 2, 4),
(1, 4, 2, 6),
(1, 4, 2, 8),
(1, 5, 2, 1),
(1, 5, 2, 4),
(1, 5, 2, 6),
(1, 5, 3, 8),
(1, 6, 2, 4),
(1, 6, 2, 8),
(1, 7, 2, 5),
(1, 7, 3, 3),
(1, 7, 3, 4),
(1, 7, 3, 8),
(2, 3, 2, 1),
(2, 4, 2, 3),
(2, 4, 2, 4),
(2, 4, 2, 8),
(2, 4, 3, 1),
(2, 5, 2, 1),
(2, 5, 2, 4),
(2, 5, 3, 8),
(2, 6, 2, 4),
(2, 6, 2, 8),
(2, 7, 2, 5),
(2, 7, 3, 3),
(2, 7, 3, 4),
(2, 7, 3, 8),
(3, 3, 3, 1),
(3, 4, 2, 1),
(3, 4, 2, 3),
(3, 4, 2, 4),
(3, 4, 2, 6),
(3, 4, 2, 8),
(3, 5, 2, 1),
(3, 5, 2, 4),
(3, 5, 2, 6),
(3, 5, 3, 8),
(3, 6, 2, 4),
(3, 6, 2, 8),
(3, 7, 3, 3),
(3, 7, 3, 4),
(3, 7, 3, 8),
(5, 4, 2, 8),
(5, 5, 3, 8),
(5, 6, 2, 8),
(5, 7, 3, 8),
(7, 4, 2, 4),
(7, 4, 2, 8),
(7, 5, 2, 4),
(7, 5, 3, 8),
(7, 6, 2, 4),
(7, 6, 2, 8),
(7, 7, 2, 4),
(7, 7, 3, 8),
(9, 4, 2, 4),
(9, 4, 2, 8),
(9, 5, 2, 4),
(9, 5, 3, 8),
(9, 6, 2, 4),
(9, 6, 2, 8),
(9, 7, 2, 4),
(9, 7, 3, 8),
(10, 4, 2, 4),
(10, 4, 2, 8),
(10, 5, 2, 4),
(10, 5, 3, 8),
(10, 6, 2, 4),
(10, 6, 2, 8),
(10, 7, 2, 4),
(10, 7, 3, 8),
(11, 4, 2, 8),
(11, 5, 3, 8),
(11, 6, 2, 8),
(11, 7, 3, 8);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `proj_sel_measure`
--

INSERT INTO `proj_sel_measure` (`id_proj`, `id_meas`) VALUES
(1, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `proj_sel_usecase`
--

INSERT INTO `proj_sel_usecase` (`id_uc`, `id_proj`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 8),
(2, 1),
(2, 3),
(2, 4),
(2, 5),
(2, 8),
(3, 3),
(3, 4),
(3, 6),
(3, 8),
(5, 4),
(5, 8),
(7, 4),
(7, 7),
(7, 8),
(9, 4),
(9, 8),
(10, 4),
(10, 8),
(11, 4),
(11, 8);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_item`
--

INSERT INTO `quantifiable_item` (`id`, `name`, `description`) VALUES
(1, 'test', 'htyjh'),
(4, 'example quantifiable item', 'lorem ipsum'),
(6, 'Enfants dans les parcs', ''),
(7, 'quant', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_item_user`
--

INSERT INTO `quantifiable_item_user` (`id`, `id_proj`) VALUES
(1, 4),
(5, 8),
(6, 8),
(7, 3);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quantifiable_uc`
--

INSERT INTO `quantifiable_uc` (`id_item`, `id_uc`) VALUES
(1, 7),
(2, 2),
(3, 5),
(4, 7),
(5, 1),
(6, 1),
(7, 2);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_item`
--

INSERT INTO `revenues_item` (`id`, `name`, `description`) VALUES
(1, 'revenues item 1', ''),
(2, 'revenues item 2', ''),
(3, 'revenues item', ''),
(4, 'revenues item', ''),
(5, 'revenues item 5', ''),
(6, 'rvenues', ''),
(7, 'rev', ''),
(8, 'test revenue', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_item_advice`
--

INSERT INTO `revenues_item_advice` (`id`, `unit`, `source`, `range_min`, `range_max`) VALUES
(1, 'per example', NULL, 1, 10),
(2, 'per example', NULL, 2, 20),
(5, '43GVFD', '', 54, 543);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_item_user`
--

INSERT INTO `revenues_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 4),
(4, 4),
(6, 4),
(7, 8),
(8, 3);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenues_uc`
--

INSERT INTO `revenues_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3),
(5, 6),
(6, 2),
(7, 7),
(8, 2);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `revenue_schedule`
--

INSERT INTO `revenue_schedule` (`id_uc`, `id_proj`, `start_date`, `25_rampup`, `50_rampup`, `75_rampup`, `100_rampup`, `end_date`) VALUES
(2, 1, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2020-07-01'),
(1, 1, '2020-02-01', '2020-03-01', '2020-04-01', '2020-05-01', '2020-06-01', '2020-07-01'),
(10, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(3, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(5, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(1, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(9, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(2, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(7, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(11, 4, '2012-02-01', '2012-03-01', '2013-02-01', '2014-02-01', '2015-02-01', '2016-02-01'),
(3, 3, '2012-01-01', '2013-02-01', '2013-03-01', '2015-02-01', '2016-02-01', '2023-03-01'),
(1, 3, '2012-01-01', '2013-02-01', '2013-03-01', '2015-02-01', '2016-02-01', '2023-03-01'),
(2, 3, '2012-01-01', '2013-02-01', '2013-03-01', '2015-02-01', '2016-02-01', '2023-03-01'),
(11, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(10, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(3, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(5, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(1, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(9, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(2, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(7, 8, '2016-04-01', '2016-09-01', '2016-12-01', '2017-01-01', '2017-06-01', '2017-12-01'),
(3, 6, '2013-05-01', '2013-12-01', '2014-05-01', '2015-09-01', '2016-06-01', '2017-11-01'),
(1, 6, '2013-05-01', '2013-12-01', '2014-05-01', '2015-09-01', '2016-06-01', '2017-11-01');

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

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
(8, 'risk', '', NULL),
(9, 'risk', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `risk_item_advice`
--

DROP TABLE IF EXISTS `risk_item_advice`;
CREATE TABLE IF NOT EXISTS `risk_item_advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `risk_item_user`
--

INSERT INTO `risk_item_user` (`id`, `id_proj`) VALUES
(1, 1),
(2, 1),
(3, 4),
(4, 4),
(5, 4),
(6, 8),
(7, 6),
(8, 8),
(9, 3);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `risk_uc`
--

INSERT INTO `risk_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 3),
(5, 2),
(6, 1),
(7, 1),
(8, 7),
(9, 2);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sel_funding_source`
--

INSERT INTO `sel_funding_source` (`id_finScen`, `id_source`, `share`, `interest`, `start_date`, `maturity_date`) VALUES
(4, 3, 30, 0, '2014-03-01', NULL),
(4, 1, 30, 0, NULL, NULL),
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_crit`
--

INSERT INTO `ucm_sel_crit` (`id_crit`, `id_ucm`) VALUES
(1, 1),
(1, 4),
(1, 6),
(1, 7),
(1, 9),
(2, 1),
(2, 4),
(2, 6),
(2, 9),
(3, 1),
(3, 6),
(3, 7),
(3, 9),
(4, 1),
(4, 4),
(4, 6),
(4, 9),
(5, 1),
(5, 4),
(5, 7),
(5, 9),
(6, 4),
(6, 6),
(6, 7),
(6, 9),
(9, 6),
(9, 7),
(9, 9),
(10, 6),
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_critcat`
--

INSERT INTO `ucm_sel_critcat` (`id_critCat`, `id_ucm`, `weight`) VALUES
(2, 1, 50),
(1, 1, 50),
(2, 4, 15),
(1, 4, 85),
(1, 6, NULL),
(2, 6, NULL),
(2, 7, 50),
(1, 7, 50),
(2, 9, 50),
(1, 9, 50);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_dlt`
--

INSERT INTO `ucm_sel_dlt` (`id_ucm`, `id_dlt`) VALUES
(1, 1),
(4, 1),
(4, 2),
(6, 1),
(7, 2),
(8, 1),
(8, 2),
(9, 1),
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_measure`
--

INSERT INTO `ucm_sel_measure` (`id_meas`, `id_ucm`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 7),
(1, 9),
(2, 4),
(4, 9),
(15, 8),
(16, 6),
(16, 9);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ucm_sel_uc`
--

INSERT INTO `ucm_sel_uc` (`id_uc`, `id_ucm`) VALUES
(1, 1),
(1, 7),
(1, 9),
(2, 1),
(2, 4),
(2, 6),
(2, 7),
(2, 9),
(3, 1),
(3, 7),
(3, 9),
(5, 1),
(5, 4),
(5, 6),
(5, 7),
(5, 9),
(7, 4),
(7, 6),
(7, 7),
(7, 9),
(9, 4),
(9, 6),
(9, 9),
(10, 4),
(10, 6),
(10, 9),
(11, 7),
(11, 9);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `uc_vs_crit_input`
--

INSERT INTO `uc_vs_crit_input` (`id_uc`, `id_crit`, `id_ucm`, `rate`) VALUES
(3, 4, 1, 5),
(3, 3, 1, 5),
(3, 5, 1, 9),
(3, 2, 1, 10),
(3, 1, 1, 2),
(5, 4, 1, 5),
(5, 3, 1, 5),
(5, 5, 1, 4),
(5, 2, 1, 4),
(5, 1, 1, 5),
(1, 4, 1, 2),
(1, 3, 1, 3),
(1, 5, 1, 3),
(1, 2, 1, 4),
(1, 1, 1, 6),
(2, 4, 1, 2),
(2, 3, 1, 2),
(2, 5, 1, 2),
(2, 2, 1, 2),
(2, 1, 1, 2),
(9, 4, 4, 5),
(9, 3, 4, 5),
(9, 2, 4, 5),
(9, 1, 4, 5),
(9, 10, 4, 5),
(9, 6, 4, 4),
(2, 9, 4, 4),
(2, 4, 4, 4),
(2, 3, 4, 4),
(2, 2, 4, 4),
(2, 1, 4, 4),
(2, 10, 4, 4),
(2, 6, 4, 5),
(7, 9, 4, 5),
(7, 4, 4, 4),
(7, 3, 4, 4),
(7, 2, 4, 4),
(7, 1, 4, 5),
(7, 10, 4, 4),
(7, 6, 4, 4),
(9, 9, 4, 4),
(5, 6, 4, 5),
(5, 10, 4, 4),
(5, 1, 4, 4),
(5, 2, 4, 4),
(5, 3, 4, 4),
(5, 4, 4, 4),
(5, 9, 4, 4),
(10, 6, 4, 4),
(10, 10, 4, 4),
(10, 1, 4, 4),
(10, 2, 4, 4),
(10, 3, 4, 4),
(10, 4, 4, 4),
(10, 9, 4, 4),
(7, 6, 7, 3),
(7, 1, 7, 3),
(7, 5, 7, 4),
(7, 3, 7, 5),
(7, 9, 7, 6),
(2, 6, 7, 3),
(2, 1, 7, 7),
(2, 5, 7, 4),
(2, 3, 7, 7),
(2, 9, 7, 4),
(1, 6, 7, 7),
(1, 1, 7, 4),
(1, 5, 7, 7),
(1, 3, 7, 5),
(1, 9, 7, 3),
(5, 6, 7, 5),
(5, 1, 7, 7),
(5, 5, 7, 9),
(5, 3, 7, 1),
(5, 9, 7, 5),
(3, 6, 7, 3),
(3, 1, 7, 5),
(3, 5, 7, 6),
(3, 3, 7, 7),
(3, 9, 7, 4),
(11, 6, 7, 2),
(11, 1, 7, 1),
(11, 5, 7, 7),
(11, 3, 7, 9),
(11, 9, 7, 1),
(7, 6, 9, 5),
(7, 10, 9, 5),
(7, 1, 9, 1),
(7, 2, 9, 8),
(7, 5, 9, 8),
(7, 3, 9, 5),
(7, 4, 9, 5),
(7, 9, 9, 2),
(2, 6, 9, 4),
(2, 10, 9, 1),
(2, 1, 9, 2),
(2, 2, 9, 5),
(2, 5, 9, 5),
(2, 3, 9, 4),
(2, 4, 9, 4),
(2, 9, 9, 5),
(9, 6, 9, 2),
(9, 10, 9, 2),
(9, 1, 9, 5),
(9, 2, 9, 4),
(9, 5, 9, 4),
(9, 3, 9, 5),
(9, 4, 9, 2),
(9, 9, 9, 4),
(1, 6, 9, 1),
(1, 10, 9, 3),
(1, 1, 9, 4),
(1, 2, 9, 1),
(1, 5, 9, 1),
(1, 3, 9, 1),
(1, 4, 9, 1),
(1, 9, 9, 5),
(5, 6, 9, 4),
(5, 10, 9, 1),
(5, 1, 9, 2),
(5, 2, 9, 2),
(5, 5, 9, 2),
(5, 3, 9, 2),
(5, 4, 9, 2),
(5, 9, 9, 2),
(3, 6, 9, 5),
(3, 10, 9, 4),
(3, 1, 9, 1),
(3, 2, 9, 4),
(3, 5, 9, 5),
(3, 3, 9, 4),
(3, 4, 9, 4),
(3, 9, 9, 1),
(10, 6, 9, 1),
(10, 10, 9, 5),
(10, 1, 9, 4),
(10, 2, 9, 5),
(10, 5, 9, 7),
(10, 3, 9, 5),
(10, 4, 9, 5),
(10, 9, 9, 2),
(11, 6, 9, 4),
(11, 10, 9, 4),
(11, 1, 9, 7),
(11, 2, 9, 7),
(11, 5, 9, 8),
(11, 3, 9, 7),
(11, 4, 9, 1),
(11, 9, 9, 4);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `lastname`, `firstname`, `email`, `password`, `salt`, `is_admin`, `is_active`, `creation_date`, `profile`) VALUES
(1, 'admin', NULL, NULL, NULL, '$2y$10$vZD1YOsZNMYWzqzyg.q5KOiJ5M6VrLK8sOGcyOtEB5zWrYb3P4fGq', '10661622345dce8dd31fac11.66803067', 1, 1, '2020-02-11 11:42:57', 's'),
(2, 'user1', NULL, NULL, NULL, '$2y$10$wFtEEFoLQawd.KdW05QTGeituOfY8mA2kyqHBFnurWKsHu63Ke5vu', '646419995e428578913042.05825044', 0, NULL, '2020-02-11 11:44:08', 'd'),
(5, 'Zak', NULL, NULL, NULL, '$2y$10$8OstD4JHwDpDsUdmO2FM0Ocszp7gHS9M.7wXIb88WUm4nA8m5dC1W', '7528837005f032af7425025.62320933', 1, NULL, '2020-07-06 15:45:27', 'd'),
(10, 'ZakSup', NULL, NULL, NULL, '$2y$10$A5Ler5Xbj7Y6WpG/3gls6uuLRDdfv773iwOHesIKrt4rQpC/Aoz7e', '12867769935f1053d19cec80.37775064', 1, NULL, '2020-07-16 15:19:13', 's'),
(12, 'adminD', NULL, NULL, NULL, '$2y$10$31NeoivqFMZ4VYFgA2OBDeHo3JzyRYD64SdvRSHDAEtPxwMSVY66S', '8699085225f3a309ecca908.48687664', 0, NULL, '2020-08-17 09:24:14', 'd');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_case`
--

INSERT INTO `use_case` (`id`, `name`, `description`, `id_meas`, `id_cat`) VALUES
(1, 'Wi-Fi', '', 1, 1),
(2, 'Electric Vehicule Charger', '', 1, 1),
(3, 'Parking Management', '', 1, 2),
(6, 'Pole Replacement', 'description', 2, 3),
(5, 'LED Upgrade', '', 1, 2),
(7, '5G', '', 1, 1),
(9, 'Photo Voltaic', '', 1, 1),
(10, 'Public Information & advertising', '', 1, 2),
(11, 'Water Level Sensor', NULL, 1, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_cases_menu`
--

INSERT INTO `use_cases_menu` (`id`, `name`, `description`, `creation_date`, `id_user`) VALUES
(1, 'projet', '', '2020-02-11 14:55:56', 1),
(4, 'projet2', '', '2020-04-17 11:09:45', 1),
(3, 'uc_eval', '', '2020-02-13 12:22:10', 2),
(6, 'test', 'testing', '2020-06-29 16:12:35', 1),
(7, 'test1', 'test', '2020-07-16 16:04:46', 5),
(8, 'test1', 'test', '2020-08-17 09:19:57', 10),
(9, 'MyProject', '', '2020-08-28 14:59:04', 1),
(10, 'Project1', '', '2020-08-31 15:11:38', 1),
(11, 'MyProject2', 'test', '2020-08-31 15:12:59', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `use_case_cat`
--

INSERT INTO `use_case_cat` (`id`, `name`, `description`) VALUES
(1, 'UC_cat_1', ''),
(2, 'UC_cat_2', ''),
(3, 'UC_cat_3', '');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `volumes_input`
--

INSERT INTO `volumes_input` (`id_uc`, `id_zone`, `id_proj`, `nb_compo`, `nb_per_uc`, `nb_tot_uc`) VALUES
(1, 3, 1, 100, 10, 10),
(2, 3, 1, 100, 10, 10),
(3, 4, 3, NULL, NULL, 10),
(1, 4, 3, NULL, NULL, 10),
(2, 4, 3, NULL, NULL, 10),
(3, 7, 3, NULL, NULL, 10),
(1, 7, 3, NULL, NULL, 10),
(2, 7, 3, NULL, NULL, 10),
(3, 5, 6, NULL, NULL, 10),
(1, 5, 6, NULL, NULL, 10),
(3, 4, 6, NULL, NULL, 10),
(1, 4, 6, NULL, NULL, 10),
(11, 6, 4, NULL, NULL, 65),
(10, 6, 4, NULL, NULL, 11),
(3, 6, 4, NULL, NULL, 2),
(5, 6, 4, NULL, NULL, 49),
(1, 6, 4, NULL, NULL, 6543),
(9, 6, 4, NULL, NULL, 65),
(2, 6, 4, NULL, NULL, 654),
(7, 6, 4, NULL, NULL, 65),
(11, 4, 4, NULL, NULL, 65),
(10, 4, 4, NULL, NULL, 11),
(3, 4, 4, NULL, NULL, 532),
(5, 4, 4, NULL, NULL, 65),
(1, 4, 4, NULL, NULL, 6),
(9, 4, 4, NULL, NULL, 65),
(2, 4, 4, NULL, NULL, 54),
(7, 4, 4, NULL, NULL, 65),
(11, 7, 4, NULL, NULL, 6565),
(10, 7, 4, NULL, NULL, 111),
(3, 7, 4, NULL, NULL, 5),
(5, 7, 4, NULL, NULL, 65),
(1, 7, 4, NULL, NULL, 65),
(9, 7, 4, NULL, NULL, 65),
(2, 7, 4, NULL, NULL, 76),
(7, 7, 4, NULL, NULL, 654),
(2, 7, 8, NULL, NULL, 33),
(7, 7, 8, NULL, NULL, 10),
(9, 7, 8, NULL, NULL, 33),
(1, 7, 8, NULL, NULL, 33),
(5, 7, 8, NULL, NULL, 33),
(3, 7, 8, NULL, NULL, 33),
(10, 7, 8, NULL, NULL, 33),
(11, 7, 8, NULL, NULL, 33),
(7, 4, 8, NULL, NULL, 3),
(2, 4, 8, NULL, NULL, 11),
(9, 4, 8, NULL, NULL, 11),
(1, 4, 8, NULL, NULL, 11),
(5, 4, 8, NULL, NULL, 11),
(3, 4, 8, NULL, NULL, 11),
(10, 4, 8, NULL, NULL, 11),
(11, 4, 8, NULL, NULL, 11),
(7, 5, 8, NULL, NULL, 5),
(2, 5, 8, NULL, NULL, 11),
(9, 5, 8, NULL, NULL, 11),
(1, 5, 8, NULL, NULL, 11),
(5, 5, 8, NULL, NULL, 11),
(3, 5, 8, NULL, NULL, 11),
(10, 5, 8, NULL, NULL, 11),
(11, 5, 8, NULL, NULL, 11),
(7, 6, 8, NULL, NULL, 2),
(2, 6, 8, NULL, NULL, 11),
(9, 6, 8, NULL, NULL, 11),
(1, 6, 8, NULL, NULL, 11),
(5, 6, 8, NULL, NULL, 11),
(3, 6, 8, NULL, NULL, 11),
(10, 6, 8, NULL, NULL, 11),
(11, 6, 8, NULL, NULL, 11);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_item`
--

INSERT INTO `widercash_item` (`id`, `name`, `description`) VALUES
(1, 'wider cash benefits item 1', ''),
(2, 'wider cash benefits item 2', ''),
(3, 'wider cahs custom item', ''),
(4, 'WCB', ''),
(8, 'bvefhcdbkjsnl,', ''),
(6, 'vfjbkdcn fbioe', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_item_advice`
--

INSERT INTO `widercash_item_advice` (`id`, `unit`, `source`, `unit_cost`, `range_min_red_nb`, `range_max_red_nb`, `range_min_red_cost`, `range_max_red_cost`) VALUES
(1, 'per example', NULL, 2, 3, 4, 5, 6),
(2, 'per example', NULL, 4, 5, 6, 7, 8),
(6, 'thgfd', '', 0, 5, 45, 5, 45),
(7, 'GEFRD', '', 4, 5, 6, 7, 8),
(8, 'GRTFED', 'GTRFE', 5, 4, 3, 42, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

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
(8, 4);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `widercash_uc`
--

INSERT INTO `widercash_uc` (`id_item`, `id_uc`) VALUES
(1, 1),
(2, 1),
(3, 3),
(4, 2),
(5, 2),
(6, 2),
(7, 5),
(8, 7);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `zone`
--

INSERT INTO `zone` (`id`, `name`, `type`, `id_zone`) VALUES
(1, 'ville1', 'ville', NULL),
(2, 'quartier1', 'quartier', 1),
(3, 'quartier2', 'quartier', 1),
(4, 'ssquartier11', 'ssquartier', 2),
(5, 'ssquartier12', 'ssquartier', 2),
(6, 'ssquartier21', 'ssquartier', 3),
(7, 'quartier3', 'quartier', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
