-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: smartcity_v2_db
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bankability_input_nogo_target`
--

DROP TABLE IF EXISTS `bankability_input_nogo_target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bankability_input_nogo_target` (
  `id` int NOT NULL COMMENT '= id_proj',
  `npv_nogo` int DEFAULT NULL,
  `npv_target` int DEFAULT NULL,
  `roi_nogo` int DEFAULT NULL,
  `roi_target` int DEFAULT NULL,
  `payback_nogo` int DEFAULT NULL,
  `payback_target` int DEFAULT NULL,
  `risks_rating_nogo` int DEFAULT NULL,
  `risks_rating_target` int DEFAULT NULL,
  `noncash_rating_nogo` int DEFAULT NULL,
  `noncash_rating_target` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bankability_input_nogo_target`
--

LOCK TABLES `bankability_input_nogo_target` WRITE;
/*!40000 ALTER TABLE `bankability_input_nogo_target` DISABLE KEYS */;
INSERT INTO `bankability_input_nogo_target` VALUES (4,3,10000,32,43,89,2,8,3,2,2),(24,1000,50000,10,30,24,12,8,0,2,6),(25,1000,15000,10,50,24,12,7,2,0,0);
/*!40000 ALTER TABLE `bankability_input_nogo_target` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beneficiary`
--

DROP TABLE IF EXISTS `beneficiary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beneficiary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_finScen` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `share` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_finScen` (`id_finScen`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beneficiary`
--

LOCK TABLES `beneficiary` WRITE;
/*!40000 ALTER TABLE `beneficiary` DISABLE KEYS */;
INSERT INTO `beneficiary` VALUES (1,3,'CAMILLE',NULL,50),(2,3,'LEPRINCE',NULL,50),(3,4,'CAMILLE',NULL,40),(4,4,'LEPRINCE',NULL,60),(5,5,'Benef 1',NULL,20),(6,5,'Benef 2',NULL,20),(7,5,'Benef 3',NULL,60);
/*!40000 ALTER TABLE `beneficiary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bm_bankability`
--

DROP TABLE IF EXISTS `bm_bankability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bm_bankability` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bm_bankability`
--

LOCK TABLES `bm_bankability` WRITE;
/*!40000 ALTER TABLE `bm_bankability` DISABLE KEYS */;
INSERT INTO `bm_bankability` VALUES (1,'<=3','not bankable'),(2,'4 - 6','bankable'),(3,'>= 7','highly bankable');
/*!40000 ALTER TABLE `bm_bankability` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bm_funding_opt_perc`
--

DROP TABLE IF EXISTS `bm_funding_opt_perc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bm_funding_opt_perc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bm_funding_opt_perc`
--

LOCK TABLES `bm_funding_opt_perc` WRITE;
/*!40000 ALTER TABLE `bm_funding_opt_perc` DISABLE KEYS */;
/*!40000 ALTER TABLE `bm_funding_opt_perc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bm_soc_bankability`
--

DROP TABLE IF EXISTS `bm_soc_bankability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bm_soc_bankability` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bm_soc_bankability`
--

LOCK TABLES `bm_soc_bankability` WRITE;
/*!40000 ALTER TABLE `bm_soc_bankability` DISABLE KEYS */;
INSERT INTO `bm_soc_bankability` VALUES (1,'<= 3','low societal value'),(2,'4 - 6','medium societal value'),(3,'>= 7','high societal value');
/*!40000 ALTER TABLE `bm_soc_bankability` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_model`
--

DROP TABLE IF EXISTS `business_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_model` (
  `id_investcap` int DEFAULT NULL,
  `id_payconst` int DEFAULT NULL,
  `id_bmpref` int DEFAULT NULL,
  `id_proj` int NOT NULL,
  PRIMARY KEY (`id_proj`),
  KEY `id_investcap` (`id_investcap`),
  KEY `id_bmpref` (`id_bmpref`),
  KEY `id_payconst` (`id_payconst`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_model`
--

LOCK TABLES `business_model` WRITE;
/*!40000 ALTER TABLE `business_model` DISABLE KEYS */;
INSERT INTO `business_model` VALUES (3,3,1,4),(1,2,3,6),(1,3,1,24);
/*!40000 ALTER TABLE `business_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_model_pref`
--

DROP TABLE IF EXISTS `business_model_pref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_model_pref` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_model_pref`
--

LOCK TABLES `business_model_pref` WRITE;
/*!40000 ALTER TABLE `business_model_pref` DISABLE KEYS */;
INSERT INTO `business_model_pref` VALUES (1,'In House','internal'),(2,'Public Private Partnership','mixed internal / external'),(3,'Outsourced','supplier(s) based'),(4,'indifferent','indifferent');
/*!40000 ALTER TABLE `business_model_pref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_model_reco`
--

DROP TABLE IF EXISTS `business_model_reco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_model_reco` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_model_reco`
--

LOCK TABLES `business_model_reco` WRITE;
/*!40000 ALTER TABLE `business_model_reco` DISABLE KEYS */;
INSERT INTO `business_model_reco` VALUES (1,'In House/PDU'),(2,'PPP(DBO/BOT)'),(3,'Outsourced/Esco');
/*!40000 ALTER TABLE `business_model_reco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capex_item`
--

DROP TABLE IF EXISTS `capex_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capex_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `origine` enum('from_ntt','from_outside_ntt','internal') NOT NULL DEFAULT 'from_ntt' COMMENT 'Used in supplier part',
  `side` enum('customer','supplier','projDev') NOT NULL DEFAULT 'projDev',
  `unit` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capex_item`
--

LOCK TABLES `capex_item` WRITE;
/*!40000 ALTER TABLE `capex_item` DISABLE KEYS */;
INSERT INTO `capex_item` VALUES (2,'capexitem1','','from_ntt','projDev',NULL),(3,'capexitem2','','from_ntt','projDev',NULL),(4,'Capex name delibererement long 1','','from_ntt','projDev',NULL),(5,'Capex name delibererement long 2','','from_ntt','projDev',NULL),(13,'custom capex item','descr','from_ntt','projDev',NULL),(15,'5G capex item','','from_ntt','projDev',NULL),(17,'_-fghjiopk','','from_ntt','projDev',NULL),(19,'test','','from_ntt','projDev',NULL),(21,'Custom','','from_ntt','projDev',NULL),(22,'cap','','from_ntt','projDev',NULL),(25,'euh','','from_ntt','projDev',NULL),(26,'Water Sensor','','from_ntt','projDev',NULL),(27,'Strange Sensor','','from_outside_ntt','projDev',NULL),(28,'LED type 2','','from_outside_ntt','projDev',NULL),(29,'capex general test','','from_ntt','projDev',NULL),(30,'capex common test ','','from_ntt','projDev',NULL),(31,'Capex 1','description','from_ntt','projDev',NULL),(32,'Capex Common','','from_ntt','projDev',NULL),(33,'test','','from_ntt','projDev',NULL),(34,'capex test','','from_ntt','projDev',NULL),(36,'capex test 2','','from_ntt','projDev',NULL),(37,'Capex 1 supp','','from_ntt','supplier',NULL),(38,'capex 2','','from_ntt','supplier',NULL),(39,'Cables','','from_outside_ntt','customer',NULL),(40,'A','B','from_ntt','customer',NULL),(41,'capex test 1','','from_ntt','customer',NULL),(42,'hjhjhj','','from_ntt','projDev',NULL),(43,'my Capex 01','','from_ntt','supplier',NULL),(44,'power cables','','from_ntt','projDev',NULL),(45,' solar panels','','from_ntt','projDev',NULL),(46,'LEDs ','','from_ntt','projDev',NULL),(47,' advertisement signage','','from_ntt','projDev',NULL),(48,'Construction material','','from_ntt','projDev',NULL);
/*!40000 ALTER TABLE `capex_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capex_item_advice`
--

DROP TABLE IF EXISTS `capex_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capex_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min` int DEFAULT NULL,
  `range_max` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capex_item_advice`
--

LOCK TABLES `capex_item_advice` WRITE;
/*!40000 ALTER TABLE `capex_item_advice` DISABLE KEYS */;
INSERT INTO `capex_item_advice` VALUES (2,'percapexitem1',NULL,0,100),(3,'per capexitem2',NULL,0,100),(4,'per example',NULL,5,10),(5,'per example',NULL,7,100),(12,'','',1,56),(14,'ver','vr',3,43),(16,'','',54,54);
/*!40000 ALTER TABLE `capex_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capex_item_user`
--

DROP TABLE IF EXISTS `capex_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capex_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capex_item_user`
--

LOCK TABLES `capex_item_user` WRITE;
/*!40000 ALTER TABLE `capex_item_user` DISABLE KEYS */;
INSERT INTO `capex_item_user` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(25,3),(31,3),(13,4),(15,4),(23,4),(24,4),(30,4),(42,4),(17,6),(18,8),(19,8),(20,8),(21,8),(22,8),(26,8),(27,8),(28,8),(29,8),(32,11),(33,21),(34,21),(35,21),(36,21),(37,21),(38,21),(41,21),(39,23),(40,23),(43,23),(44,24),(45,24),(46,24),(47,25),(48,25);
/*!40000 ALTER TABLE `capex_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `capex_uc`
--

DROP TABLE IF EXISTS `capex_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `capex_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `capex_uc`
--

LOCK TABLES `capex_uc` WRITE;
/*!40000 ALTER TABLE `capex_uc` DISABLE KEYS */;
INSERT INTO `capex_uc` VALUES (29,-1),(30,-1),(31,-1),(32,-1),(34,-1),(35,-1),(36,-1),(37,-1),(38,-1),(39,-1),(43,-1),(3,1),(4,1),(5,1),(13,1),(18,1),(19,1),(20,1),(21,1),(22,1),(2,2),(3,2),(12,3),(17,3),(25,3),(40,3),(48,3),(28,5),(46,5),(14,6),(16,6),(15,7),(23,7),(24,7),(33,7),(41,9),(44,9),(45,9),(47,10),(26,11),(27,11),(42,11);
/*!40000 ALTER TABLE `capex_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashreleasing_item`
--

DROP TABLE IF EXISTS `cashreleasing_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cashreleasing_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashreleasing_item`
--

LOCK TABLES `cashreleasing_item` WRITE;
/*!40000 ALTER TABLE `cashreleasing_item` DISABLE KEYS */;
INSERT INTO `cashreleasing_item` VALUES (1,'crb1',''),(2,'crb2',''),(3,'cash releasing benefit item 1',''),(4,'CRB',''),(5,'CASHRELEASING',''),(6,'htbg',''),(7,'cash releasingb',''),(8,'CRB 1',''),(9,'CRB 2',''),(10,'CRB 3',''),(11,'CRB 4',''),(12,'cash item',''),(13,'save 1',''),(14,'electricity',''),(15,'electricity conso','');
/*!40000 ALTER TABLE `cashreleasing_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashreleasing_item_advice`
--

DROP TABLE IF EXISTS `cashreleasing_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cashreleasing_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `unit_cost` double DEFAULT NULL,
  `range_min_red_nb` double DEFAULT NULL,
  `range_max_red_nb` double DEFAULT NULL,
  `range_min_red_cost` double DEFAULT NULL,
  `range_max_red_cost` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashreleasing_item_advice`
--

LOCK TABLES `cashreleasing_item_advice` WRITE;
/*!40000 ALTER TABLE `cashreleasing_item_advice` DISABLE KEYS */;
INSERT INTO `cashreleasing_item_advice` VALUES (1,'per example',NULL,15,1.2,1.8,10,11),(2,'per example',NULL,1,2,3,4,5),(3,'per example',NULL,2,3,4,5,6);
/*!40000 ALTER TABLE `cashreleasing_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashreleasing_item_user`
--

DROP TABLE IF EXISTS `cashreleasing_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cashreleasing_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashreleasing_item_user`
--

LOCK TABLES `cashreleasing_item_user` WRITE;
/*!40000 ALTER TABLE `cashreleasing_item_user` DISABLE KEYS */;
INSERT INTO `cashreleasing_item_user` VALUES (1,1),(2,1),(3,1),(4,4),(5,4),(7,4),(8,8),(9,8),(10,8),(11,8),(12,21),(13,23),(14,24),(15,24);
/*!40000 ALTER TABLE `cashreleasing_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashreleasing_uc`
--

DROP TABLE IF EXISTS `cashreleasing_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cashreleasing_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashreleasing_uc`
--

LOCK TABLES `cashreleasing_uc` WRITE;
/*!40000 ALTER TABLE `cashreleasing_uc` DISABLE KEYS */;
INSERT INTO `cashreleasing_uc` VALUES (1,1),(2,1),(3,1),(4,2),(7,2),(5,3),(13,3),(6,5),(15,5),(12,9),(14,9),(8,11),(9,11),(10,11),(11,11);
/*!40000 ALTER TABLE `cashreleasing_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comp_per_zone`
--

DROP TABLE IF EXISTS `comp_per_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comp_per_zone` (
  `id_zone` int NOT NULL,
  `id_compo` int NOT NULL,
  `number` int DEFAULT NULL,
  PRIMARY KEY (`id_zone`,`id_compo`),
  KEY `id_compo` (`id_compo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comp_per_zone`
--

LOCK TABLES `comp_per_zone` WRITE;
/*!40000 ALTER TABLE `comp_per_zone` DISABLE KEYS */;
INSERT INTO `comp_per_zone` VALUES (3,1,100),(4,1,543),(5,1,23),(6,1,5768),(7,1,987);
/*!40000 ALTER TABLE `comp_per_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `component`
--

DROP TABLE IF EXISTS `component`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `component` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `id_meas` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_meas` (`id_meas`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `component`
--

LOCK TABLES `component` WRITE;
/*!40000 ALTER TABLE `component` DISABLE KEYS */;
INSERT INTO `component` VALUES (1,'comp1',1);
/*!40000 ALTER TABLE `component` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crit`
--

DROP TABLE IF EXISTS `crit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `scoring_guidance` text,
  `id_cat` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cat` (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crit`
--

LOCK TABLES `crit` WRITE;
/*!40000 ALTER TABLE `crit` DISABLE KEYS */;
INSERT INTO `crit` VALUES (1,'crit_11','','1. Not at All <br />2.Poor',1),(2,'crit_12','','biugtrvnf\r\nvirdcnklvnf\r\nvribiornobg\r\n3. vuifeibiovnrfnv juvbirbvng',1),(3,'crit_21','',NULL,2),(4,'crit_22','',NULL,2),(5,'crit_13','','Likert scale:\r\nNo improvement - 1 - 2 - 3 - 4 - 5 - Very high improvement.\r\n\r\n    1. Not at all: the access to basic health care services was not imporved.\r\n    2. Poor: there was little improvement in the accessibility of basic health care services.\r\n    3. Somewhat: access to basic health care services was imroved, including a few important amenities such as a general practitioner or a pharmaacy.\r\n    4. Good: access to a sufficien number of health care service are widely available offline an donline (i.e. repeat prescriptions) was improved.\r\n    5. Excellent: access to a wide variety of basic health care services are widely available offline and online (i.e. first aid apps) was improved.\r\n',1),(6,'crit123','',NULL,2),(9,'ighorvf','gtrfed','biugtrvnf\r\nvirdcnklvnf\r\nvribiornobg\r\n3. vuifeibiovnrfnv juvbirbvng',1),(10,'Criterion 1','bvgfd','Likert scale:\r\nNo improvement - 1 - 2 - 3 - 4 - 5 - Very high improvement.\r\n\r\n    1. Not at all: the access to basic health care services was not imporved.\r\n    2. Poor: there was little improvement in the accessibility of basic health care services.\r\n    3. Somewhat: access to basic health care services was imroved, including a few important amenities such as a general practitioner or a pharmaacy.\r\n    4. Good: access to a sufficien number of health care service are widely available offline an donline (i.e. repeat prescriptions) was improved.\r\n    5. Excellent: access to a wide variety of basic health care services are widely available offline and online (i.e. first aid apps) was improved.\r\n',2);
/*!40000 ALTER TABLE `crit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `critcat`
--

DROP TABLE IF EXISTS `critcat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `critcat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `critcat`
--

LOCK TABLES `critcat` WRITE;
/*!40000 ALTER TABLE `critcat` DISABLE KEYS */;
INSERT INTO `critcat` VALUES (1,'criteria_cat_1'),(2,'criteria_cat_2');
/*!40000 ALTER TABLE `critcat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deal_criteria_input_nogo_target`
--

DROP TABLE IF EXISTS `deal_criteria_input_nogo_target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deal_criteria_input_nogo_target` (
  `id` int NOT NULL,
  `societal_npv_nogo` int DEFAULT NULL,
  `societal_npv_target` int DEFAULT NULL,
  `societal_roi_nogo` int DEFAULT NULL,
  `societal_roi_target` int DEFAULT NULL,
  `societal_payback_nogo` int DEFAULT NULL,
  `societal_payback_target` int DEFAULT NULL,
  `npv_nogo` int DEFAULT NULL,
  `npv_target` int DEFAULT NULL,
  `roi_nogo` int DEFAULT NULL,
  `roi_target` int DEFAULT NULL,
  `payback_nogo` int DEFAULT NULL,
  `payback_target` int DEFAULT NULL,
  `risks_rating_nogo` int DEFAULT NULL,
  `risks_rating_target` int DEFAULT NULL,
  `nqbr_nogo` int DEFAULT NULL,
  `nqbr_target` int DEFAULT NULL,
  `operating_margin_nogo` int DEFAULT NULL,
  `operating_margin_target` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deal_criteria_input_nogo_target`
--

LOCK TABLES `deal_criteria_input_nogo_target` WRITE;
/*!40000 ALTER TABLE `deal_criteria_input_nogo_target` DISABLE KEYS */;
INSERT INTO `deal_criteria_input_nogo_target` VALUES (3,NULL,NULL,NULL,NULL,NULL,NULL,15,15,15,15,5,5,NULL,NULL,NULL,NULL,5,5),(6,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,0,0),(8,0,30000,0,20,40,12,50000,100000,10,30,36,12,5,1,3,9,0,0),(21,NULL,NULL,NULL,NULL,NULL,NULL,5000,150000,5,50,26,5,NULL,NULL,NULL,NULL,0,30),(23,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,20,24,2,NULL,NULL,NULL,NULL,5,20);
/*!40000 ALTER TABLE `deal_criteria_input_nogo_target` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devise`
--

DROP TABLE IF EXISTS `devise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devise` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `rateToGBP` double DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devise`
--

LOCK TABLES `devise` WRITE;
/*!40000 ALTER TABLE `devise` DISABLE KEYS */;
INSERT INTO `devise` VALUES (1,'GBP','',1),(2,'USD','US$',0.85105),(3,'EUR','',0.76642);
/*!40000 ALTER TABLE `devise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dlt`
--

DROP TABLE IF EXISTS `dlt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dlt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dlt`
--

LOCK TABLES `dlt` WRITE;
/*!40000 ALTER TABLE `dlt` DISABLE KEYS */;
INSERT INTO `dlt` VALUES (1,'city',''),(2,'subzone','');
/*!40000 ALTER TABLE `dlt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity`
--

DROP TABLE IF EXISTS `entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entity` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_source` int NOT NULL,
  `id_finScen` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `share` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_source` (`id_source`),
  KEY `id_finScen` (`id_finScen`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity`
--

LOCK TABLES `entity` WRITE;
/*!40000 ALTER TABLE `entity` DISABLE KEYS */;
INSERT INTO `entity` VALUES (1,1,3,'fehvof','','2020-02-01',90),(2,1,3,'entity 2','','2020-01-01',10),(3,1,4,'ENT','','2013-06-01',30),(4,2,5,'EDF','','2020-10-01',10);
/*!40000 ALTER TABLE `entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_revenues`
--

DROP TABLE IF EXISTS `equipment_revenues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment_revenues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price_per_unit` int NOT NULL,
  `nb_units` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_revenues`
--

LOCK TABLES `equipment_revenues` WRITE;
/*!40000 ALTER TABLE `equipment_revenues` DISABLE KEYS */;
INSERT INTO `equipment_revenues` VALUES (1,'Equipement 1',10,50),(2,'Equipement 2',100,1),(3,'Equipement 3',1,25),(4,'Equipement 4',50,50),(5,'Equipment 5',22,35);
/*!40000 ALTER TABLE `equipment_revenues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financing_scenario`
--

DROP TABLE IF EXISTS `financing_scenario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `financing_scenario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `input_invest` double DEFAULT '-1',
  `input_op` double DEFAULT '-1',
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modif_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_proj` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financing_scenario`
--

LOCK TABLES `financing_scenario` WRITE;
/*!40000 ALTER TABLE `financing_scenario` DISABLE KEYS */;
INSERT INTO `financing_scenario` VALUES (1,'scenar1','',-1,-1,'2020-02-11 14:55:35',NULL,0),(2,'scnear','',-1,-1,'2020-02-11 14:55:41',NULL,0),(3,'scenar1','scenar test du 2 mars',136632.5,345,'2020-03-02 14:01:30','2020-04-28 11:59:10',4),(4,'scenario test','test',136632.5,3456,'2020-04-28 12:04:44','2020-05-29 10:03:29',4),(5,'Scenario A','',3126750,0,'2020-10-08 08:58:04','2020-10-19 10:13:34',24);
/*!40000 ALTER TABLE `financing_scenario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funding_source`
--

DROP TABLE IF EXISTS `funding_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funding_source` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_type` int NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `description` text,
  `id_cat` int NOT NULL,
  `hasEntities` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_cat` (`id_cat`),
  KEY `id_type` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funding_source`
--

LOCK TABLES `funding_source` WRITE;
/*!40000 ALTER TABLE `funding_source` DISABLE KEYS */;
INSERT INTO `funding_source` VALUES (1,1,'City','',1,1),(2,1,'Other Public Authorities','',1,1),(3,1,'Private','',2,1),(4,1,'Public','',2,1),(5,2,'Term Loans','',3,1),(6,2,'Revolving Loans','',3,1),(7,2,'Amortizing Bonds','',4,1),(8,2,'Bullet Bonds','',4,1),(9,1,'European Structural Funds','',5,1),(10,1,'National Grants','',5,1),(11,1,'Crowdfunding','',6,1);
/*!40000 ALTER TABLE `funding_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funding_sources_category`
--

DROP TABLE IF EXISTS `funding_sources_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funding_sources_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funding_sources_category`
--

LOCK TABLES `funding_sources_category` WRITE;
/*!40000 ALTER TABLE `funding_sources_category` DISABLE KEYS */;
INSERT INTO `funding_sources_category` VALUES (1,'Budgetary Funding',''),(2,'Equity Funding',''),(3,'Bank Credit Facility',''),(4,'Bonds & Green Bonds',''),(5,'Grant & subsidies',''),(6,'Crowdfunding','');
/*!40000 ALTER TABLE `funding_sources_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funding_sources_type`
--

DROP TABLE IF EXISTS `funding_sources_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funding_sources_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funding_sources_type`
--

LOCK TABLES `funding_sources_type` WRITE;
/*!40000 ALTER TABLE `funding_sources_type` DISABLE KEYS */;
INSERT INTO `funding_sources_type` VALUES (1,'Others',NULL),(2,'Loans & Bonds',NULL);
/*!40000 ALTER TABLE `funding_sources_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `implem_item`
--

DROP TABLE IF EXISTS `implem_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `implem_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `origine` enum('from_ntt','from_outside_ntt','internal') NOT NULL DEFAULT 'from_ntt',
  `side` enum('customer','supplier','projDev') NOT NULL DEFAULT 'projDev',
  `unit` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `implem_item`
--

LOCK TABLES `implem_item` WRITE;
/*!40000 ALTER TABLE `implem_item` DISABLE KEYS */;
INSERT INTO `implem_item` VALUES (1,'impitem1','','from_ntt','projDev',NULL),(3,'implementation item 2','description','from_ntt','projDev',NULL),(4,'implementation item 2','','from_ntt','projDev',NULL),(5,'test imp item','10/03 10:28','from_ntt','projDev',NULL),(6,'IMPLEM','','from_ntt','projDev',NULL),(8,'5G IMPLEM ITEM','','from_ntt','projDev',NULL),(11,'aaaa','','from_ntt','projDev',NULL),(12,'setup','','from_outside_ntt','projDev',NULL),(13,'Construction','','internal','projDev',NULL),(14,'Verification','','from_outside_ntt','projDev',NULL),(15,'Construction ','','from_ntt','projDev',NULL),(16,'Deployment','ffffffffffffffffff','from_outside_ntt','projDev',NULL),(17,'Deployment Common test','','from_outside_ntt','projDev',NULL),(18,'dep test','','from_outside_ntt','projDev',NULL),(24,'dep 2','','from_ntt','projDev',NULL),(25,'dep tests','','from_ntt','projDev',NULL),(26,'dep 01','','from_ntt','supplier',NULL),(27,'fgh','','from_ntt','customer',NULL),(28,'a','','from_ntt','customer',NULL),(29,'xc','','from_ntt','customer',NULL),(30,'xcv','','from_outside_ntt','customer',NULL),(31,'xcvw','','internal','customer',NULL),(32,'Engineering','Engineering ars','from_ntt','supplier',NULL),(33,'DIg a hole','','from_outside_ntt','customer',NULL),(34,'internal','','internal','customer',NULL),(35,'B','','internal','customer',NULL),(36,'myImplem','','from_ntt','projDev',NULL),(38,' dig trenchs','','from_ntt','projDev',NULL),(39,'LED installation','','from_ntt','projDev',NULL),(40,'workers','','from_ntt','projDev',NULL),(41,'Construction','','from_ntt','projDev',NULL);
/*!40000 ALTER TABLE `implem_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `implem_item_advice`
--

DROP TABLE IF EXISTS `implem_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `implem_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min` int DEFAULT NULL,
  `range_max` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `implem_item_advice`
--

LOCK TABLES `implem_item_advice` WRITE;
/*!40000 ALTER TABLE `implem_item_advice` DISABLE KEYS */;
INSERT INTO `implem_item_advice` VALUES (1,'per blabla',NULL,50,102),(3,'per truc',NULL,10,20),(5,'','',13,14),(7,'vfg','',2,21);
/*!40000 ALTER TABLE `implem_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `implem_item_user`
--

DROP TABLE IF EXISTS `implem_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `implem_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `implem_item_user`
--

LOCK TABLES `implem_item_user` WRITE;
/*!40000 ALTER TABLE `implem_item_user` DISABLE KEYS */;
INSERT INTO `implem_item_user` VALUES (1,1),(3,1),(12,3),(16,3),(4,4),(6,4),(8,4),(36,4),(9,8),(10,8),(11,8),(13,8),(14,8),(15,8),(17,11),(18,21),(19,21),(20,21),(21,21),(22,21),(23,21),(24,21),(25,21),(26,21),(27,21),(28,21),(29,21),(30,21),(31,21),(32,23),(33,23),(34,23),(35,23),(37,24),(38,24),(39,24),(40,25),(41,25);
/*!40000 ALTER TABLE `implem_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `implem_schedule`
--

DROP TABLE IF EXISTS `implem_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `implem_schedule` (
  `id_uc` int NOT NULL,
  `id_proj` int NOT NULL,
  `start_date` date DEFAULT NULL,
  `25_completion` date DEFAULT NULL,
  `50_completion` date DEFAULT NULL,
  `75_completion` date DEFAULT NULL,
  `100_completion` date DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_proj`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `implem_schedule`
--

LOCK TABLES `implem_schedule` WRITE;
/*!40000 ALTER TABLE `implem_schedule` DISABLE KEYS */;
INSERT INTO `implem_schedule` VALUES (-1,8,'2012-02-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(1,3,'2020-01-01','2020-02-01','2020-03-01','2020-04-01','2021-04-01'),(1,4,'2012-01-01','2012-02-01','2013-02-01','2014-02-01','2015-02-01'),(1,6,'2012-02-01','2013-03-01','2013-08-01','2014-08-01','2014-12-01'),(1,8,'2014-02-01','2014-04-01','2014-08-01','2014-11-01','2015-02-01'),(1,24,'2019-01-01','2019-05-01','2019-07-01','2019-11-01','2020-03-01'),(2,3,'2020-01-01','2020-02-01','2020-03-01','2020-04-01','2021-04-01'),(2,4,'2012-01-01','2012-02-01','2013-02-01','2014-02-01','2015-02-01'),(2,8,'2014-02-01','2014-04-01','2014-08-01','2014-11-01','2015-02-01'),(3,3,'2020-01-01','2020-02-01','2020-03-01','2020-04-01','2021-04-01'),(3,4,'2012-01-01','2012-02-01','2013-02-01','2014-02-01','2015-02-01'),(3,6,'2012-02-01','2013-03-01','2013-08-01','2014-08-01','2014-12-01'),(3,8,'2014-02-01','2014-04-01','2014-08-01','2014-11-01','2015-02-01'),(3,25,'2019-02-01','2019-09-01','2020-03-01','2020-08-01','2021-01-01'),(5,4,'2012-01-01','2012-02-01','2013-02-01','2014-02-01','2015-02-01'),(5,8,'2014-02-01','2014-04-01','2014-08-01','2014-11-01','2015-02-01'),(5,24,'2019-01-01','2019-05-01','2019-07-01','2019-11-01','2020-03-01'),(7,4,'2012-01-01','2012-02-01','2013-02-01','2014-02-01','2015-02-01'),(7,8,'2014-02-01','2014-04-01','2014-08-01','2014-11-01','2015-02-01'),(7,24,'2019-01-01','2019-05-01','2019-07-01','2019-11-01','2020-03-01'),(9,4,'2012-01-01','2012-02-01','2013-02-01','2014-02-01','2015-02-01'),(9,8,'2014-02-01','2014-04-01','2014-08-01','2014-11-01','2015-02-01'),(9,24,'2019-01-01','2019-05-01','2019-07-01','2019-11-01','2020-03-01'),(10,4,'2012-01-01','2012-02-01','2013-02-01','2014-02-01','2015-02-01'),(10,8,'2014-02-01','2014-04-01','2014-08-01','2014-11-01','2015-02-01'),(10,25,'2019-02-01','2019-09-01','2020-03-01','2020-08-01','2021-01-01'),(11,4,'2012-01-01','2012-02-01','2013-02-01','2014-02-01','2015-02-01'),(11,8,'2014-02-01','2014-04-01','2014-08-01','2014-11-01','2015-02-01');
/*!40000 ALTER TABLE `implem_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `implem_uc`
--

DROP TABLE IF EXISTS `implem_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `implem_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `implem_uc`
--

LOCK TABLES `implem_uc` WRITE;
/*!40000 ALTER TABLE `implem_uc` DISABLE KEYS */;
INSERT INTO `implem_uc` VALUES (16,-1),(17,-1),(19,-1),(20,-1),(21,-1),(22,-1),(23,-1),(24,-1),(25,-1),(26,-1),(32,-1),(33,-1),(34,-1),(1,1),(3,1),(9,1),(10,1),(11,1),(14,1),(4,2),(12,2),(18,2),(6,3),(13,3),(35,3),(41,3),(5,5),(39,5),(7,6),(8,7),(15,9),(27,9),(28,9),(29,9),(30,9),(31,9),(37,9),(38,9),(40,10),(36,11);
/*!40000 ALTER TABLE `implem_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_capex`
--

DROP TABLE IF EXISTS `input_capex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_capex` (
  `id_item` int NOT NULL,
  `id_proj` int NOT NULL,
  `id_uc` int NOT NULL,
  `volume` int DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `period` int DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_capex`
--

LOCK TABLES `input_capex` WRITE;
/*!40000 ALTER TABLE `input_capex` DISABLE KEYS */;
INSERT INTO `input_capex` VALUES (1,1,1,0,0,3),(2,1,2,NULL,NULL,NULL),(2,3,2,0,0,1),(2,4,2,19,50,1),(2,8,2,12,150,5),(3,1,2,NULL,NULL,NULL),(3,4,2,543,50,1),(3,6,1,1000,500,1),(3,8,1,237,200,3),(3,8,2,1000,50,3),(4,1,1,0,0,4),(4,3,1,0,0,1),(4,4,1,357156,7.5,5),(4,6,1,200,20,1),(4,8,1,132,5500,5),(5,1,1,0,0,5),(5,4,1,6614,53.5,5),(5,8,1,660,2500,2),(12,4,3,43,28.5,5),(15,4,7,1568,54,54),(17,6,3,NULL,NULL,NULL),(18,8,1,400,1500,5),(19,8,1,197,100,2),(21,8,1,5,1500,3),(22,8,1,200,50,1),(25,3,3,0,0,1),(26,8,11,100,10,3),(27,8,11,300,10,3),(28,8,5,275,5,1),(30,4,-1,1500,15,3),(31,3,-1,0,0,1),(32,11,-1,1255,15,1),(33,21,7,NULL,NULL,NULL),(34,21,-1,10,10,1),(37,21,-1,NULL,NULL,NULL),(38,21,-1,0,0,5),(39,23,-1,10,200,10),(40,23,3,10,100,5),(41,21,9,NULL,NULL,NULL),(42,4,11,0,0,5),(43,23,-1,NULL,NULL,NULL),(44,24,9,300,100,1),(45,24,9,150,500,3),(46,24,5,3000,15,3),(47,25,10,200,500,1),(48,25,3,5000,300,5);
/*!40000 ALTER TABLE `input_capex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_cashreleasing`
--

DROP TABLE IF EXISTS `input_cashreleasing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_cashreleasing` (
  `id_item` int NOT NULL,
  `id_proj` int NOT NULL,
  `id_uc` int NOT NULL,
  `unit_indicator` varchar(255) DEFAULT NULL,
  `volume` int DEFAULT NULL,
  `ratio` int DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `volume_reduc` double DEFAULT NULL,
  `unit_cost_reduc` double DEFAULT NULL,
  `annual_var_volume` double DEFAULT NULL,
  `annual_var_unit_cost` double DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_cashreleasing`
--

LOCK TABLES `input_cashreleasing` WRITE;
/*!40000 ALTER TABLE `input_cashreleasing` DISABLE KEYS */;
INSERT INTO `input_cashreleasing` VALUES (1,1,1,'per example',0,NULL,0,0,0,0,0),(1,4,1,'per example',864,54,0,0,0,0,0),(1,6,1,'per example',20,NULL,58,2,5,2,2),(1,8,1,'per example',1500,NULL,500,5,0,5,5),(2,6,1,'per example',30,NULL,4,4,2,5,5),(2,8,1,'per example',5,NULL,12000,10,10,5,5),(3,1,1,'per example',0,NULL,0,0,0,0,0),(3,4,1,'per example',4544,284,0,0,0,0,0),(3,6,1,'per example',10,NULL,10,1,4,5,5),(3,8,1,'per example',10,NULL,10,5,6,5,5),(4,4,2,'EUIHV',54,NULL,5,54,5,5,5),(5,4,3,'VUIG',66,NULL,12,5,19,89,78),(7,4,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,8,11,'SI',12,NULL,100,3,5,5,3),(9,8,11,'SI',50,NULL,200,0,10,5,1),(10,8,11,'SI',20,NULL,1500,30,13,5,5),(11,8,11,'SI',5,NULL,31,3,1,5,3),(12,21,9,'test',1500,NULL,15,3,5,5,1),(13,23,3,'parking space',5000,NULL,100,5,0,0,0),(14,24,9,'kWh',30000,NULL,1,5,5,50,50),(15,24,5,'kWh',1000,NULL,1,3,5,75,0);
/*!40000 ALTER TABLE `input_cashreleasing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_implem`
--

DROP TABLE IF EXISTS `input_implem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_implem` (
  `id_proj` int NOT NULL,
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  `volume` int DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  PRIMARY KEY (`id_proj`,`id_item`,`id_uc`),
  KEY `id_item` (`id_item`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_implem`
--

LOCK TABLES `input_implem` WRITE;
/*!40000 ALTER TABLE `input_implem` DISABLE KEYS */;
INSERT INTO `input_implem` VALUES (1,1,1,0,0),(1,3,1,0,0),(3,12,2,2,0),(4,1,1,80,76),(4,3,1,64,15),(4,4,2,1900,1),(4,6,3,621,2),(4,8,7,43545,5),(4,36,11,6695,20),(6,1,1,200,500),(8,1,1,396,100),(8,3,1,132,1200),(8,5,5,20,15),(8,11,1,36,26),(8,13,3,1,150000),(8,14,1,36,150),(8,15,9,13,5000),(11,17,-1,200,15),(21,26,-1,100,15),(23,32,-1,10,200),(23,33,-1,10,1000),(23,34,-1,10,100),(23,35,3,300,20),(24,37,9,300,2),(24,38,9,150,2500),(24,39,5,300,10),(25,40,10,60,1500),(25,41,3,2,1500000);
/*!40000 ALTER TABLE `input_implem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_noncash`
--

DROP TABLE IF EXISTS `input_noncash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_noncash` (
  `id_item` int NOT NULL,
  `id_proj` int NOT NULL,
  `id_uc` int NOT NULL,
  `expected_impact` int DEFAULT NULL,
  `probability` double DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_noncash`
--

LOCK TABLES `input_noncash` WRITE;
/*!40000 ALTER TABLE `input_noncash` DISABLE KEYS */;
INSERT INTO `input_noncash` VALUES (1,1,1,1,1),(2,1,1,10,100),(3,4,1,10,25),(4,4,3,9,70),(5,4,2,7,50),(9,8,1,7,20),(10,6,1,5,10),(11,8,11,2,60),(12,8,11,1,10),(13,8,11,7,50),(14,21,-1,9,30),(15,21,-1,5,70),(16,21,7,4,50),(17,23,3,5,100),(18,24,5,6,70),(19,25,3,3,80);
/*!40000 ALTER TABLE `input_noncash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_opex`
--

DROP TABLE IF EXISTS `input_opex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_opex` (
  `id_proj` int NOT NULL,
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  `volume` int DEFAULT NULL,
  `ratio` int DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `annual_variation_volume` double DEFAULT NULL,
  `annual_variation_unitcost` double DEFAULT NULL,
  PRIMARY KEY (`id_proj`,`id_item`,`id_uc`),
  KEY `id_item` (`id_item`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_opex`
--

LOCK TABLES `input_opex` WRITE;
/*!40000 ALTER TABLE `input_opex` DISABLE KEYS */;
INSERT INTO `input_opex` VALUES (1,1,1,0,NULL,0,0,0),(1,2,1,1000,NULL,9.965,10,6),(3,3,2,0,NULL,0,0,0),(3,5,2,0,NULL,0,0,0),(4,1,1,21,1,6.5,0,0),(4,2,1,67,4,2.5,0,0),(4,3,2,4,NULL,5,65,5),(4,4,3,56,NULL,78,6,6),(4,5,2,54,NULL,5,0,0),(6,2,1,300,NULL,152,10,5),(8,1,1,264,NULL,25,20,2),(8,2,1,132,NULL,1050,3,10),(8,3,2,12,NULL,200,3,5),(8,4,3,300,NULL,50,3,5),(8,5,2,30,NULL,50,1,4),(8,6,1,1000,NULL,15,3,1),(8,8,-1,1,NULL,15000,3,0),(10,7,-1,1,NULL,15000,3,0),(11,10,-1,250,NULL,15,15,3),(21,11,-1,200,NULL,15,3,5),(21,13,-1,100,NULL,15,5,3),(23,14,-1,1,NULL,3000,5,0),(23,15,-1,3,NULL,100,5,0),(23,16,-1,50,NULL,50,5,5),(23,17,3,40,NULL,100,4,5),(24,18,9,30,NULL,500,0,5),(24,19,5,300,NULL,3,3,5),(25,20,10,400,NULL,1,3,5),(25,21,3,1000,NULL,3,0,0);
/*!40000 ALTER TABLE `input_opex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_quantifiable`
--

DROP TABLE IF EXISTS `input_quantifiable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_quantifiable` (
  `id_item` int NOT NULL,
  `id_proj` int NOT NULL,
  `id_uc` int NOT NULL,
  `unit_indicator` varchar(255) DEFAULT NULL,
  `volume` int DEFAULT NULL,
  `volume_reduc` double DEFAULT NULL,
  `annual_var_volume` double DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_quantifiable`
--

LOCK TABLES `input_quantifiable` WRITE;
/*!40000 ALTER TABLE `input_quantifiable` DISABLE KEYS */;
INSERT INTO `input_quantifiable` VALUES (1,4,7,'per test',43,43,54),(1,21,-1,'myUnit2',300,5,21),(4,21,-1,'myUnit',250,15,17),(4,21,7,'per unit',20,12,5),(5,8,1,NULL,NULL,NULL,NULL),(6,8,1,'personne',750,10,5),(7,8,11,'nb',15000,15,10),(8,3,3,NULL,NULL,NULL,NULL),(10,23,3,'accident',10,30,5),(11,24,5,'#',10000,0,30);
/*!40000 ALTER TABLE `input_quantifiable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_revenues`
--

DROP TABLE IF EXISTS `input_revenues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_revenues` (
  `id_proj` int NOT NULL,
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  `volume` int DEFAULT NULL,
  `ratio` int DEFAULT NULL,
  `revenues_per_unit` double DEFAULT NULL,
  `annual_variation_volume` double DEFAULT NULL,
  `annual_variation_unitcost` double DEFAULT NULL,
  PRIMARY KEY (`id_proj`,`id_item`,`id_uc`),
  KEY `id_item` (`id_item`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_revenues`
--

LOCK TABLES `input_revenues` WRITE;
/*!40000 ALTER TABLE `input_revenues` DISABLE KEYS */;
INSERT INTO `input_revenues` VALUES (1,1,1,5,NULL,2,0,0),(4,1,1,16,1,0,0,0),(4,3,2,453,NULL,54,54,5),(4,4,3,78,NULL,2,45,12),(4,6,2,NULL,NULL,NULL,NULL,NULL),(4,13,11,NULL,NULL,NULL,NULL,NULL),(8,1,1,5,NULL,5,5,6),(8,2,1,50,NULL,1500,3,1),(8,8,11,35,NULL,255,0,2),(8,9,11,50,NULL,15000,1,3),(8,10,11,100,NULL,300,2,1),(8,11,11,33,NULL,20,5,3),(21,12,9,15,NULL,300,3,5),(23,14,3,100,NULL,30,5,5),(24,16,5,300,NULL,1500,3,5),(25,17,10,500,NULL,10000,0,0),(25,18,3,144000,NULL,10,0,10);
/*!40000 ALTER TABLE `input_revenues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_risk`
--

DROP TABLE IF EXISTS `input_risk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_risk` (
  `id_item` int NOT NULL,
  `id_proj` int NOT NULL,
  `id_uc` int NOT NULL,
  `expected_impact` int DEFAULT NULL,
  `probability` double DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_risk`
--

LOCK TABLES `input_risk` WRITE;
/*!40000 ALTER TABLE `input_risk` DISABLE KEYS */;
INSERT INTO `input_risk` VALUES (1,1,1,NULL,NULL),(2,1,1,NULL,NULL),(3,4,1,10,23),(4,4,3,7,80),(5,4,2,7,80),(6,8,1,9,10),(7,6,1,3,50),(8,8,11,2,10),(9,8,11,5,10),(10,8,11,7,40),(11,23,3,9,20),(12,24,9,2,20),(13,25,10,7,20);
/*!40000 ALTER TABLE `input_risk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_supplier_revenues`
--

DROP TABLE IF EXISTS `input_supplier_revenues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_supplier_revenues` (
  `id_item` int unsigned NOT NULL,
  `id_proj` int unsigned NOT NULL,
  `id_uc` int unsigned NOT NULL,
  `unit_cost` float NOT NULL,
  `volume` int NOT NULL,
  `anVarVol` int NOT NULL,
  `anVarCost` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_supplier_revenues`
--

LOCK TABLES `input_supplier_revenues` WRITE;
/*!40000 ALTER TABLE `input_supplier_revenues` DISABLE KEYS */;
INSERT INTO `input_supplier_revenues` VALUES (1,21,9,1500,150,0,0),(2,21,9,1500,50,0,0),(3,21,9,15,300,5,3),(4,21,7,1500,300,0,0),(5,23,3,100,100,0,0),(6,23,3,150,10,0,0),(7,23,3,3500,1,0,5);
/*!40000 ALTER TABLE `input_supplier_revenues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `input_widercash`
--

DROP TABLE IF EXISTS `input_widercash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `input_widercash` (
  `id_item` int NOT NULL,
  `id_proj` int NOT NULL,
  `id_uc` int NOT NULL,
  `unit_indicator` varchar(255) DEFAULT NULL,
  `volume` int DEFAULT NULL,
  `ratio` int DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `volume_reduc` double DEFAULT NULL,
  `unit_cost_reduc` double DEFAULT NULL,
  `annual_var_volume` double DEFAULT NULL,
  `annual_var_unit_cost` double DEFAULT NULL,
  PRIMARY KEY (`id_item`,`id_proj`,`id_uc`),
  KEY `id_proj` (`id_proj`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `input_widercash`
--

LOCK TABLES `input_widercash` WRITE;
/*!40000 ALTER TABLE `input_widercash` DISABLE KEYS */;
INSERT INTO `input_widercash` VALUES (1,1,1,'per blabla',0,NULL,0,0,0,0,0),(1,4,1,'per example',578,36,0,0,0,0,0),(1,6,1,'per example',10,NULL,20,4,5,40,2),(1,8,1,'per example',5,NULL,10,1,2,4,4),(2,1,1,'per oiuhrf',0,NULL,0,0,0,0,0),(2,4,1,'per example',13,1,0,0,0,0,0),(2,8,1,'per example',500,NULL,2,2,2,7,5),(3,4,3,'per unit',54,NULL,43,4,32,4,4),(4,4,2,'FTR',54,NULL,32,35,7,65,56),(5,4,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,4,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,4,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,8,11,'SI',50,NULL,12,1,2,2,1),(10,8,11,'SI',1200,NULL,15,50,30,4,5),(11,8,11,'SI',15,NULL,200,10,50,0,2),(12,21,9,'test',15,NULL,10000,5,30,6,10),(14,23,3,'CO2',1000,NULL,1,30,0,0,0),(15,24,5,'# of accident',30,NULL,10000,0,0,30,0),(16,25,3,'# customers not coming',7000,NULL,500,0,0,30,0),(17,25,3,'hours',60,NULL,1000,0,0,25,0);
/*!40000 ALTER TABLE `input_widercash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invest_capacity`
--

DROP TABLE IF EXISTS `invest_capacity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invest_capacity` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invest_capacity`
--

LOCK TABLES `invest_capacity` WRITE;
/*!40000 ALTER TABLE `invest_capacity` DISABLE KEYS */;
INSERT INTO `invest_capacity` VALUES (1,'< = 2 M','small value'),(2,'2 - 5 M','low-mid value'),(3,'5 - 20 M','mid value'),(4,'> = 20','large value');
/*!40000 ALTER TABLE `invest_capacity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loans_and_bonds`
--

DROP TABLE IF EXISTS `loans_and_bonds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loans_and_bonds` (
  `id` int NOT NULL AUTO_INCREMENT,
  `maturity_date` date DEFAULT NULL,
  `interest` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loans_and_bonds`
--

LOCK TABLES `loans_and_bonds` WRITE;
/*!40000 ALTER TABLE `loans_and_bonds` DISABLE KEYS */;
INSERT INTO `loans_and_bonds` VALUES (1,NULL,NULL),(2,NULL,NULL),(3,'2020-01-01',3);
/*!40000 ALTER TABLE `loans_and_bonds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `magnitude`
--

DROP TABLE IF EXISTS `magnitude`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `magnitude` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `range_min` double DEFAULT NULL,
  `range_max` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `magnitude`
--

LOCK TABLES `magnitude` WRITE;
/*!40000 ALTER TABLE `magnitude` DISABLE KEYS */;
INSERT INTO `magnitude` VALUES (2,'Proof Of Concept',1,5),(3,'Limited Perimeter',5,25);
/*!40000 ALTER TABLE `magnitude` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matrix_bm_1`
--

DROP TABLE IF EXISTS `matrix_bm_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matrix_bm_1` (
  `id_investcap` int NOT NULL,
  `id_payconst` int NOT NULL,
  `id_bmpref` int NOT NULL,
  `in_house` int NOT NULL,
  `PPP` int NOT NULL,
  `outsourced` int NOT NULL,
  PRIMARY KEY (`id_investcap`,`id_payconst`,`id_bmpref`),
  KEY `id_payconst` (`id_payconst`),
  KEY `id_bmpref` (`id_bmpref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_bm_1`
--

LOCK TABLES `matrix_bm_1` WRITE;
/*!40000 ALTER TABLE `matrix_bm_1` DISABLE KEYS */;
INSERT INTO `matrix_bm_1` VALUES (1,1,1,1,3,2),(1,1,2,1,3,2),(1,1,3,1,3,2),(1,1,4,1,3,2),(1,2,1,1,3,2),(1,2,2,1,3,2),(1,2,3,1,3,2),(1,2,4,1,3,2),(1,3,1,1,3,2),(1,3,2,1,3,2),(1,3,3,1,3,2),(1,3,4,1,3,2),(1,4,1,1,3,2),(1,4,2,1,3,2),(1,4,3,1,3,2),(1,4,4,1,3,2),(2,1,1,1,3,2),(2,1,2,2,3,1),(2,1,3,2,3,1),(2,1,4,2,3,1),(2,2,1,1,3,2),(2,2,2,2,3,1),(2,2,3,2,3,1),(2,2,4,2,3,1),(2,3,1,1,3,2),(2,3,2,2,3,1),(2,3,3,2,3,1),(2,3,4,2,3,1),(2,4,1,1,3,2),(2,4,2,2,3,1),(2,4,3,2,3,1),(2,4,4,2,3,1),(3,1,1,1,3,2),(3,1,2,2,3,1),(3,1,3,2,3,1),(3,1,4,2,3,1),(3,2,1,1,3,2),(3,2,2,2,3,1),(3,2,3,2,3,1),(3,2,4,2,3,1),(3,3,1,1,3,2),(3,3,2,2,3,1),(3,3,3,2,3,1),(3,3,4,2,3,1),(3,4,1,1,3,2),(3,4,2,2,3,1),(3,4,3,2,3,1),(3,4,4,2,3,1),(4,1,1,1,2,3),(4,1,2,3,1,2),(4,1,3,3,2,1),(4,1,4,3,2,1),(4,2,1,1,2,3),(4,2,2,3,1,2),(4,2,3,3,2,1),(4,2,4,3,2,1),(4,3,1,1,2,3),(4,3,2,3,1,2),(4,3,3,3,2,1),(4,3,4,3,2,1),(4,4,1,1,3,2),(4,4,2,1,3,2),(4,4,3,1,3,2),(4,4,4,1,3,2);
/*!40000 ALTER TABLE `matrix_bm_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matrix_bm_2`
--

DROP TABLE IF EXISTS `matrix_bm_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matrix_bm_2` (
  `id_bm` int NOT NULL,
  `id_investcap` int NOT NULL,
  `id_bank` int NOT NULL,
  `id_socbank` int NOT NULL,
  `city` int DEFAULT NULL,
  `grants` int DEFAULT NULL,
  `eq_investors` int DEFAULT NULL,
  `impact_investors` int DEFAULT NULL,
  `bank_debt` int DEFAULT NULL,
  `green_debt` int DEFAULT NULL,
  `suppliers` int DEFAULT NULL,
  `alternative` int DEFAULT NULL,
  PRIMARY KEY (`id_bm`,`id_investcap`,`id_bank`,`id_socbank`),
  KEY `id_investcap` (`id_investcap`),
  KEY `id_bank` (`id_bank`),
  KEY `id_socbank` (`id_socbank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matrix_bm_2`
--

LOCK TABLES `matrix_bm_2` WRITE;
/*!40000 ALTER TABLE `matrix_bm_2` DISABLE KEYS */;
INSERT INTO `matrix_bm_2` VALUES (1,1,1,1,4,1,0,0,0,0,0,0),(1,1,1,2,4,1,0,0,0,0,0,0),(1,1,1,3,2,2,0,0,0,1,0,2),(1,1,2,1,4,0,0,0,2,2,0,0),(1,1,2,2,2,1,0,0,2,2,0,0),(1,1,2,3,2,2,0,0,2,2,0,2),(1,1,3,1,0,0,0,0,0,0,0,0),(1,1,3,2,1,1,0,0,4,4,0,0),(1,1,3,3,1,1,0,0,4,4,0,2),(1,2,1,1,4,1,0,0,0,0,0,0),(1,2,1,2,4,1,0,0,0,0,0,0),(1,2,1,3,2,2,0,0,0,1,0,1),(1,2,2,1,4,0,0,0,2,2,0,0),(1,2,2,2,2,1,0,0,2,2,0,0),(1,2,2,3,2,2,0,0,2,2,0,1),(1,2,3,1,1,1,0,0,4,4,0,0),(1,2,3,2,1,1,0,0,4,4,0,0),(1,2,3,3,1,1,0,0,4,4,0,1),(1,3,1,1,4,1,0,0,0,0,0,0),(1,3,1,2,4,1,0,0,0,0,0,0),(1,3,1,3,2,2,0,1,0,1,0,1),(1,3,2,1,4,0,0,0,2,2,0,0),(1,3,2,2,2,1,0,0,2,2,0,0),(1,3,2,3,2,2,0,1,2,2,0,1),(1,3,3,1,1,1,1,0,4,4,0,0),(1,3,3,2,1,1,1,0,4,4,0,0),(1,3,3,3,1,1,1,1,4,4,0,1),(1,4,1,1,4,1,0,0,0,0,0,0),(1,4,1,2,4,1,0,0,0,0,0,0),(1,4,1,3,4,1,0,1,0,1,0,0),(1,4,2,1,4,0,0,0,2,2,0,0),(1,4,2,2,2,1,0,0,2,2,0,0),(1,4,2,3,2,1,0,1,2,2,0,0),(1,4,3,1,1,1,1,0,4,4,0,0),(1,4,3,2,1,1,1,0,4,4,0,0),(1,4,3,3,1,1,1,1,4,4,0,0),(2,1,1,1,0,0,0,0,0,0,0,0),(2,1,1,2,0,0,0,0,0,0,0,0),(2,1,1,3,0,0,0,0,0,0,0,0),(2,1,2,1,0,0,0,0,0,0,0,0),(2,1,2,2,0,0,0,0,0,0,0,0),(2,1,2,3,0,0,0,0,0,0,0,0),(2,1,3,1,0,0,0,0,0,0,0,0),(2,1,3,2,0,0,0,0,0,0,0,0),(2,1,3,3,0,0,0,0,0,0,0,0),(2,2,1,1,0,0,0,0,0,0,0,0),(2,2,1,2,0,0,0,0,0,0,0,0),(2,2,1,3,0,0,0,0,0,0,0,0),(2,2,2,1,0,0,0,0,0,0,0,0),(2,2,2,2,0,0,0,0,0,0,0,0),(2,2,2,3,0,0,0,0,0,0,0,0),(2,2,3,1,0,0,0,0,0,0,0,0),(2,2,3,2,0,0,0,0,0,0,0,0),(2,2,3,3,0,0,0,0,0,0,0,0),(2,3,1,1,0,0,0,0,0,0,0,0),(2,3,1,2,0,0,0,0,0,0,0,0),(2,3,1,3,0,0,0,0,0,0,0,0),(2,3,2,1,0,0,0,0,0,0,0,0),(2,3,2,2,0,0,0,0,0,0,0,0),(2,3,2,3,0,0,0,0,0,0,0,0),(2,3,3,1,0,0,0,0,0,0,0,0),(2,3,3,2,0,0,0,0,0,0,0,0),(2,3,3,3,0,0,0,0,0,0,0,0),(2,4,1,1,3,0,2,2,0,0,0,0),(2,4,1,2,3,0,2,2,0,0,0,0),(2,4,1,3,3,0,2,2,0,1,0,0),(2,4,2,1,2,0,2,2,2,2,0,0),(2,4,2,2,2,0,2,2,2,2,0,0),(2,4,2,3,2,0,2,2,2,2,0,0),(2,4,3,1,1,0,1,1,4,4,0,0),(2,4,3,2,1,0,1,1,4,4,0,0),(2,4,3,3,1,0,1,1,4,4,0,0),(3,1,1,1,0,0,0,0,0,0,4,0),(3,1,1,2,0,0,0,0,0,0,4,0),(3,1,1,3,0,0,0,0,0,0,4,1),(3,1,2,1,0,0,0,0,0,0,4,0),(3,1,2,2,0,0,0,0,0,0,4,0),(3,1,2,3,0,0,0,0,0,0,4,2),(3,1,3,1,0,0,0,0,1,1,4,0),(3,1,3,2,0,0,0,0,1,1,4,0),(3,1,3,3,0,0,0,0,1,1,4,2),(3,2,1,1,0,0,0,0,0,0,4,0),(3,2,1,2,0,0,0,0,0,0,4,0),(3,2,1,3,0,0,0,0,0,0,4,1),(3,2,2,1,0,0,0,0,0,0,4,0),(3,2,2,2,0,0,0,0,0,0,4,0),(3,2,2,3,0,0,0,0,0,0,4,1),(3,2,3,1,0,0,0,0,1,1,4,0),(3,2,3,2,0,0,0,0,1,1,4,0),(3,2,3,3,0,0,0,0,1,1,4,1),(3,3,1,1,0,0,0,0,0,0,4,0),(3,3,1,2,0,0,0,0,0,0,4,0),(3,3,1,3,0,0,0,0,0,0,4,1),(3,3,2,1,0,0,0,0,0,0,4,0),(3,3,2,2,0,0,0,0,0,0,4,0),(3,3,2,3,0,0,0,0,0,0,4,1),(3,3,3,1,0,0,0,0,1,1,4,0),(3,3,3,2,0,0,0,0,1,1,4,0),(3,3,3,3,0,0,0,0,1,1,4,1),(3,4,1,1,0,0,0,0,0,0,4,0),(3,4,1,2,0,0,0,0,0,0,4,0),(3,4,1,3,0,0,0,0,0,0,4,0),(3,4,2,1,0,0,0,0,0,0,4,0),(3,4,2,2,0,0,0,0,0,0,4,0),(3,4,2,3,0,0,0,0,0,0,4,0),(3,4,3,1,0,0,0,0,1,1,4,0),(3,4,3,2,0,0,0,0,1,1,4,0),(3,4,3,3,0,0,0,0,1,1,4,0);
/*!40000 ALTER TABLE `matrix_bm_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `measure`
--

DROP TABLE IF EXISTS `measure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `measure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `user` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measure`
--

LOCK TABLES `measure` WRITE;
/*!40000 ALTER TABLE `measure` DISABLE KEYS */;
INSERT INTO `measure` VALUES (0,'Project Common',NULL,0),(1,'Measure1','',0),(4,'measure test admin','test test',1),(11,'Project Management Zak','',4),(12,'Project Management test','',6),(13,'Project Management test1','',7),(14,'Project Management test2','',8),(15,'Project Management ZakSup','',10),(16,'Project Management adminD','',11),(18,'Project Management ProjDeve','',13),(19,'Project Management Supplier','',14),(20,'Project Management SupplierTest','',15);
/*!40000 ALTER TABLE `measure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noncash_item`
--

DROP TABLE IF EXISTS `noncash_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noncash_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `sources` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noncash_item`
--

LOCK TABLES `noncash_item` WRITE;
/*!40000 ALTER TABLE `noncash_item` DISABLE KEYS */;
INSERT INTO `noncash_item` VALUES (1,'non cash benefits 1','',NULL),(2,'non cash benefits 2','',NULL),(3,'custom item ncb 1','',NULL),(4,'non cash','',NULL),(5,'NNCASH','',NULL),(6,'hivordfkjn','bgfkjbxn',NULL),(7,'bvuid','vfdx',NULL),(8,'testestest','vfd',NULL),(9,'Bonheur','',NULL),(10,'non cash item','',NULL),(11,'NCB 1','',NULL),(12,'NCB 2','',NULL),(13,'NCB 3','',NULL),(14,'nan cash item 0','',NULL),(15,'nan cash item 1','',NULL),(16,'non cash','',NULL),(17,'wellbeing','',NULL),(18,'Safty feeling','',NULL),(19,'satisfaction','',NULL);
/*!40000 ALTER TABLE `noncash_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noncash_item_advice`
--

DROP TABLE IF EXISTS `noncash_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noncash_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noncash_item_advice`
--

LOCK TABLES `noncash_item_advice` WRITE;
/*!40000 ALTER TABLE `noncash_item_advice` DISABLE KEYS */;
/*!40000 ALTER TABLE `noncash_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noncash_item_user`
--

DROP TABLE IF EXISTS `noncash_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noncash_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noncash_item_user`
--

LOCK TABLES `noncash_item_user` WRITE;
/*!40000 ALTER TABLE `noncash_item_user` DISABLE KEYS */;
INSERT INTO `noncash_item_user` VALUES (1,1),(2,1),(3,4),(4,4),(5,4),(10,6),(9,8),(11,8),(12,8),(13,8),(14,21),(15,21),(16,21),(17,23),(18,24),(19,25);
/*!40000 ALTER TABLE `noncash_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noncash_uc`
--

DROP TABLE IF EXISTS `noncash_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noncash_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noncash_uc`
--

LOCK TABLES `noncash_uc` WRITE;
/*!40000 ALTER TABLE `noncash_uc` DISABLE KEYS */;
INSERT INTO `noncash_uc` VALUES (14,-1),(15,-1),(1,1),(2,1),(3,1),(9,1),(10,1),(5,2),(4,3),(8,3),(17,3),(19,3),(6,5),(7,5),(18,5),(16,7),(11,11),(12,11),(13,11);
/*!40000 ALTER TABLE `noncash_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opex_item`
--

DROP TABLE IF EXISTS `opex_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opex_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `origine` enum('from_ntt','from_outside_ntt','internal') NOT NULL DEFAULT 'from_ntt',
  `side` enum('customer','supplier','projDev') NOT NULL DEFAULT 'projDev',
  `unit` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opex_item`
--

LOCK TABLES `opex_item` WRITE;
/*!40000 ALTER TABLE `opex_item` DISABLE KEYS */;
INSERT INTO `opex_item` VALUES (1,'opexitem1','','from_ntt','projDev',NULL),(2,'opex item 2','','from_ntt','projDev',NULL),(3,'uc2 opex','','from_ntt','projDev',NULL),(4,'TEST OPEX ITEM','10H 10 MARS','from_ntt','projDev',NULL),(5,'OPEX','','from_ntt','projDev',NULL),(6,'electricity','','internal','projDev',NULL),(7,'Project Manager','','from_ntt','projDev',NULL),(8,'Project Manager','','from_ntt','projDev',NULL),(9,'Opex 1','','internal','projDev',NULL),(10,'Opex common test','','from_ntt','projDev',NULL),(11,'opex common','','from_ntt','projDev',NULL),(12,'opex test','','from_ntt','projDev',NULL),(13,'opex 01','','from_ntt','supplier',NULL),(14,'Data analytics','Analysis of traffic','from_ntt','supplier',NULL),(15,'Support services','Maintenace of equipment','from_outside_ntt','supplier',NULL),(16,'Maintenace','','internal','customer',NULL),(17,'C','','from_ntt','customer',NULL),(18,'safty control','','from_ntt','projDev',NULL),(20,'electricity','','from_ntt','projDev',NULL),(21,'electricity conso','','from_ntt','projDev',NULL);
/*!40000 ALTER TABLE `opex_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opex_item_advice`
--

DROP TABLE IF EXISTS `opex_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opex_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min` double DEFAULT NULL,
  `range_max` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opex_item_advice`
--

LOCK TABLES `opex_item_advice` WRITE;
/*!40000 ALTER TABLE `opex_item_advice` DISABLE KEYS */;
INSERT INTO `opex_item_advice` VALUES (1,'per ...',NULL,5,8),(2,'per ...',NULL,2,3),(3,'per tructruc',NULL,5,4),(4,'per blabla','',5,6),(5,'per bla',NULL,2,5);
/*!40000 ALTER TABLE `opex_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opex_item_user`
--

DROP TABLE IF EXISTS `opex_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opex_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opex_item_user`
--

LOCK TABLES `opex_item_user` WRITE;
/*!40000 ALTER TABLE `opex_item_user` DISABLE KEYS */;
INSERT INTO `opex_item_user` VALUES (1,1),(2,1),(9,3),(3,4),(5,4),(6,8),(8,8),(7,10),(10,11),(11,21),(12,21),(13,21),(14,23),(15,23),(16,23),(17,23),(18,24),(19,24),(20,25),(21,25);
/*!40000 ALTER TABLE `opex_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opex_schedule`
--

DROP TABLE IF EXISTS `opex_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opex_schedule` (
  `id_uc` int NOT NULL,
  `id_proj` int NOT NULL,
  `start_date` date DEFAULT NULL,
  `25_rampup` date DEFAULT NULL,
  `50_rampup` date DEFAULT NULL,
  `75_rampup` date DEFAULT NULL,
  `100_rampup` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_proj`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opex_schedule`
--

LOCK TABLES `opex_schedule` WRITE;
/*!40000 ALTER TABLE `opex_schedule` DISABLE KEYS */;
INSERT INTO `opex_schedule` VALUES (-1,8,'2012-02-01','2013-02-01','2014-02-01','2015-02-01','2017-02-01','2020-02-01'),(1,1,'2020-02-01','2020-03-01','2020-04-01','2020-05-01','2020-06-01','2020-07-01'),(1,3,'2020-02-01','2020-03-01','2020-04-01','2020-05-01','2020-06-01','2022-02-01'),(1,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(1,6,'2012-03-01','2012-09-01','2013-04-01','2013-09-01','2014-09-01','2015-02-01'),(1,8,'2015-04-01','2015-06-01','2015-12-01','2016-02-01','2016-04-01','2016-09-01'),(1,24,'2020-06-01','2020-07-01','2020-09-01','2020-11-01','2021-01-01','2024-01-01'),(2,1,'2020-02-01','2020-03-01','2020-04-01','2020-05-01','2020-06-01','2020-07-01'),(2,3,'2020-02-01','2020-03-01','2020-04-01','2020-05-01','2020-06-01','2022-02-01'),(2,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(2,8,'2015-04-01','2015-06-01','2015-12-01','2016-02-01','2016-04-01','2016-09-01'),(3,3,'2020-02-01','2020-03-01','2020-04-01','2020-05-01','2020-06-01','2022-02-01'),(3,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(3,6,'2012-03-01','2012-09-01','2013-04-01','2013-09-01','2014-09-01','2015-02-01'),(3,8,'2015-04-01','2015-06-01','2015-12-01','2016-02-01','2016-04-01','2016-09-01'),(3,25,'2021-03-01','2021-04-01','2021-05-01','2021-06-01','2021-07-01','2025-01-01'),(5,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(5,8,'2015-04-01','2015-06-01','2015-12-01','2016-02-01','2016-04-01','2016-09-01'),(5,24,'2020-06-01','2020-07-01','2020-09-01','2020-11-01','2021-01-01','2024-01-01'),(7,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(7,8,'2015-04-01','2015-06-01','2015-12-01','2016-02-01','2016-04-01','2016-09-01'),(7,24,'2020-06-01','2020-07-01','2020-09-01','2020-11-01','2021-01-01','2024-01-01'),(9,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(9,8,'2015-04-01','2015-06-01','2015-12-01','2016-02-01','2016-04-01','2016-09-01'),(9,24,'2020-06-01','2020-07-01','2020-09-01','2020-11-01','2021-01-01','2024-01-01'),(10,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(10,8,'2015-04-01','2015-06-01','2015-12-01','2016-02-01','2016-04-01','2016-09-01'),(10,25,'2021-03-01','2021-04-01','2021-05-01','2021-06-01','2021-07-01','2025-01-01'),(11,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(11,8,'2015-04-01','2015-06-01','2015-12-01','2016-02-01','2016-04-01','2016-09-01');
/*!40000 ALTER TABLE `opex_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opex_uc`
--

DROP TABLE IF EXISTS `opex_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opex_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opex_uc`
--

LOCK TABLES `opex_uc` WRITE;
/*!40000 ALTER TABLE `opex_uc` DISABLE KEYS */;
INSERT INTO `opex_uc` VALUES (7,-1),(8,-1),(9,-1),(10,-1),(11,-1),(12,-1),(13,-1),(14,-1),(15,-1),(16,-1),(1,1),(2,1),(6,1),(3,2),(5,2),(4,3),(17,3),(21,3),(19,5),(18,9),(20,10);
/*!40000 ALTER TABLE `opex_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `others`
--

DROP TABLE IF EXISTS `others`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `others` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `others`
--

LOCK TABLES `others` WRITE;
/*!40000 ALTER TABLE `others` DISABLE KEYS */;
INSERT INTO `others` VALUES (1),(2),(3),(4);
/*!40000 ALTER TABLE `others` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payback_constraints`
--

DROP TABLE IF EXISTS `payback_constraints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payback_constraints` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payback_constraints`
--

LOCK TABLES `payback_constraints` WRITE;
/*!40000 ALTER TABLE `payback_constraints` DISABLE KEYS */;
INSERT INTO `payback_constraints` VALUES (1,'< 33% of Project Duration','quick payback'),(2,'33% to 66% of Project Duration','medium - long payback'),(3,'66% to 100% of Project Duration','long payback'),(4,'Beyond Project Duration','no payback');
/*!40000 ALTER TABLE `payback_constraints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `privileges` (
  `id_group` int NOT NULL,
  `id_user` int NOT NULL,
  `id_role` int NOT NULL,
  `code` int DEFAULT NULL,
  PRIMARY KEY (`id_group`,`id_user`,`id_role`),
  KEY `id_user` (`id_user`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privileges`
--

LOCK TABLES `privileges` WRITE;
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proj_sel_measure`
--

DROP TABLE IF EXISTS `proj_sel_measure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proj_sel_measure` (
  `id_proj` int NOT NULL,
  `id_meas` int NOT NULL,
  PRIMARY KEY (`id_proj`,`id_meas`),
  KEY `id_meas` (`id_meas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proj_sel_measure`
--

LOCK TABLES `proj_sel_measure` WRITE;
/*!40000 ALTER TABLE `proj_sel_measure` DISABLE KEYS */;
INSERT INTO `proj_sel_measure` VALUES (3,0),(4,0),(8,0),(11,0),(21,0),(22,0),(23,0),(24,0),(25,0),(1,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(10,1),(11,1),(21,1),(22,1),(23,1),(24,1),(25,1);
/*!40000 ALTER TABLE `proj_sel_measure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proj_sel_usecase`
--

DROP TABLE IF EXISTS `proj_sel_usecase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proj_sel_usecase` (
  `id_uc` int NOT NULL,
  `id_proj` int NOT NULL,
  PRIMARY KEY (`id_uc`,`id_proj`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proj_sel_usecase`
--

LOCK TABLES `proj_sel_usecase` WRITE;
/*!40000 ALTER TABLE `proj_sel_usecase` DISABLE KEYS */;
INSERT INTO `proj_sel_usecase` VALUES (1,1),(2,1),(-1,3),(1,3),(2,3),(3,3),(-1,4),(1,4),(2,4),(3,4),(5,4),(7,4),(9,4),(10,4),(11,4),(1,5),(2,5),(1,6),(3,6),(7,7),(-1,8),(1,8),(2,8),(3,8),(5,8),(7,8),(9,8),(10,8),(11,8),(1,10),(2,10),(3,10),(7,10),(9,10),(10,10),(11,10),(-1,11),(1,11),(2,11),(3,11),(5,11),(7,11),(9,11),(10,11),(11,11),(-1,21),(1,21),(2,21),(5,21),(7,21),(9,21),(-1,22),(1,22),(2,22),(9,22),(-1,23),(1,23),(3,23),(5,23),(-1,24),(1,24),(5,24),(7,24),(9,24),(-1,25),(3,25),(10,25);
/*!40000 ALTER TABLE `proj_sel_usecase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `discount_rate` double DEFAULT NULL,
  `weight_bank` double DEFAULT NULL,
  `weight_bank_soc` double DEFAULT NULL,
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modif_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  `scoping` tinyint DEFAULT '0',
  `cb` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (3,'TESTV2','Pr-rempli avec des xpex supplier',3,NULL,NULL,'2020-02-27 13:29:51','2020-09-24 10:36:31',1,0,0),(4,'Projet 2802','Pr-rempli avec des dates de projet',3.5,NULL,NULL,'2020-02-28 13:06:40','2020-10-05 09:58:16',1,1,0),(5,'Projet nif','',NULL,NULL,NULL,'2020-03-19 11:38:27','2020-09-14 11:25:01',1,0,0),(6,'Projet 25 mai','',3,NULL,NULL,'2020-05-25 16:01:23','2020-09-14 11:25:08',1,1,1),(7,'SupplierZak','test',NULL,NULL,NULL,'2020-08-17 09:43:18','2020-08-17 09:47:32',10,0,0),(8,'MyProject','',4,NULL,NULL,'2020-08-28 15:01:37','2020-09-14 15:32:05',1,1,1),(9,'Projet vide','Pas de prremplissage',NULL,NULL,NULL,'2020-09-03 15:51:19','2020-09-14 15:49:09',1,0,0),(11,'Proj suplier','Projet fait pour tester la partie Suplier',NULL,NULL,NULL,'2020-09-15 09:50:24','2020-09-15 10:40:18',1,1,0),(21,'Test Project','',NULL,NULL,NULL,'2020-09-15 15:07:56','2020-10-05 09:53:27',15,1,1),(22,'empty','',NULL,NULL,NULL,'2020-09-28 14:46:13','2020-09-28 14:46:24',15,1,0),(23,'MyProject','joli projet ',NULL,NULL,NULL,'2020-09-28 15:51:50','2020-10-05 11:35:37',15,1,1),(24,'Smart Lighting','',5,NULL,NULL,'2020-10-08 08:25:27','2020-10-19 10:13:08',13,1,1),(25,'Parkings','',3,NULL,NULL,'2020-10-08 09:05:30','2020-10-08 09:21:31',13,1,1);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_dates`
--

DROP TABLE IF EXISTS `project_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_dates` (
  `id_project` int NOT NULL,
  `start_date` date NOT NULL,
  `duration` int NOT NULL,
  `deploy_start_date` date NOT NULL,
  `deploy_duration` int NOT NULL,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_dates`
--

LOCK TABLES `project_dates` WRITE;
/*!40000 ALTER TABLE `project_dates` DISABLE KEYS */;
INSERT INTO `project_dates` VALUES (3,'2020-09-11',12,'2020-09-23',5),(4,'2020-09-06',12,'2020-09-20',4),(10,'2020-09-14',36,'2020-09-14',6),(11,'2021-01-01',48,'2021-05-01',6),(21,'2020-09-15',36,'2021-02-01',6),(23,'2021-01-04',36,'2021-01-04',6);
/*!40000 ALTER TABLE `project_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_group`
--

DROP TABLE IF EXISTS `project_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `size` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_group`
--

LOCK TABLES `project_group` WRITE;
/*!40000 ALTER TABLE `project_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_perimeter`
--

DROP TABLE IF EXISTS `project_perimeter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_perimeter` (
  `id_proj` int NOT NULL,
  `id_zone` int NOT NULL,
  PRIMARY KEY (`id_proj`,`id_zone`),
  KEY `id_zone` (`id_zone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_perimeter`
--

LOCK TABLES `project_perimeter` WRITE;
/*!40000 ALTER TABLE `project_perimeter` DISABLE KEYS */;
INSERT INTO `project_perimeter` VALUES (1,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(24,1),(25,1),(1,2),(3,2),(4,2),(6,2),(8,2),(1,3),(4,3),(7,3),(8,3),(24,3),(25,3),(1,4),(3,4),(4,4),(6,4),(8,4),(1,5),(4,5),(6,5),(8,5),(4,6),(7,6),(8,6),(24,6),(25,6),(3,7),(4,7),(5,7),(8,7);
/*!40000 ALTER TABLE `project_perimeter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_schedule`
--

DROP TABLE IF EXISTS `project_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_schedule` (
  `id_project` int NOT NULL,
  `id_uc` int NOT NULL,
  `deploy_prod` date NOT NULL,
  `poc_start` date NOT NULL,
  `poc_run` date NOT NULL,
  `lag_start` date NOT NULL,
  `lag_ramp` date NOT NULL,
  `ramp_run` date NOT NULL,
  PRIMARY KEY (`id_project`,`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_schedule`
--

LOCK TABLES `project_schedule` WRITE;
/*!40000 ALTER TABLE `project_schedule` DISABLE KEYS */;
INSERT INTO `project_schedule` VALUES (3,3,'2020-12-14','2020-09-14','2021-05-12','2020-09-21','2020-12-15','2021-05-21'),(21,1,'2021-06-08','2021-01-22','2021-08-15','2020-09-10','2020-12-24','2021-12-15'),(21,2,'2021-01-16','2021-02-16','2021-08-16','2021-12-16','2022-07-16','2023-06-16'),(21,5,'2020-12-01','2020-09-10','2021-07-15','2020-09-10','2021-12-15','2022-05-15'),(21,7,'2020-10-08','2020-12-24','2021-04-24','2021-02-24','2021-08-24','2021-10-24'),(21,9,'2020-12-27','2021-01-10','2023-06-15','2021-01-03','2021-02-15','2022-07-14'),(23,3,'2021-07-01','2021-07-01','2021-10-01','2021-10-01','2021-10-01','2022-03-01');
/*!40000 ALTER TABLE `project_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_size`
--

DROP TABLE IF EXISTS `project_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_size` (
  `id_uc` int NOT NULL,
  `id_zone` int NOT NULL,
  `id_mag` int NOT NULL,
  `id_proj` int NOT NULL,
  PRIMARY KEY (`id_uc`,`id_zone`,`id_mag`,`id_proj`),
  KEY `id_zone` (`id_zone`),
  KEY `id_mag` (`id_mag`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_size`
--

LOCK TABLES `project_size` WRITE;
/*!40000 ALTER TABLE `project_size` DISABLE KEYS */;
INSERT INTO `project_size` VALUES (1,3,3,1),(2,3,2,1),(3,3,3,1),(1,4,2,1),(1,4,2,3),(1,4,2,4),(1,4,2,6),(1,4,2,8),(2,4,2,3),(2,4,2,4),(2,4,2,8),(2,4,3,1),(3,4,2,1),(3,4,2,3),(3,4,2,4),(3,4,2,6),(3,4,2,8),(5,4,2,8),(7,4,2,4),(7,4,2,8),(9,4,2,4),(9,4,2,8),(10,4,2,4),(10,4,2,8),(11,4,2,8),(1,5,2,1),(1,5,2,4),(1,5,2,6),(1,5,3,8),(2,5,2,1),(2,5,2,4),(2,5,3,8),(3,5,2,1),(3,5,2,4),(3,5,2,6),(3,5,3,8),(5,5,3,8),(7,5,2,4),(7,5,3,8),(9,5,2,4),(9,5,3,8),(10,5,2,4),(10,5,3,8),(11,5,3,8),(1,6,2,4),(1,6,2,8),(1,6,2,24),(2,6,2,4),(2,6,2,8),(3,6,2,4),(3,6,2,8),(3,6,2,25),(5,6,2,8),(5,6,2,24),(7,6,2,4),(7,6,2,8),(7,6,2,24),(9,6,2,4),(9,6,2,8),(9,6,2,24),(10,6,2,4),(10,6,2,8),(10,6,2,25),(11,6,2,8),(1,7,2,5),(1,7,3,3),(1,7,3,4),(1,7,3,8),(2,7,2,5),(2,7,3,3),(2,7,3,4),(2,7,3,8),(3,7,3,3),(3,7,3,4),(3,7,3,8),(5,7,3,8),(7,7,2,4),(7,7,3,8),(9,7,2,4),(9,7,3,8),(10,7,2,4),(10,7,3,8),(11,7,3,8);
/*!40000 ALTER TABLE `project_size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quantifiable_item`
--

DROP TABLE IF EXISTS `quantifiable_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quantifiable_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quantifiable_item`
--

LOCK TABLES `quantifiable_item` WRITE;
/*!40000 ALTER TABLE `quantifiable_item` DISABLE KEYS */;
INSERT INTO `quantifiable_item` VALUES (1,'test','htyjh'),(4,'example quantifiable item','lorem ipsum'),(6,'Enfants dans les parcs',''),(7,'Poissons dans l\'eau',''),(8,'test',''),(9,'test item',''),(10,'number of accidents',''),(11,'people outside during nigth','');
/*!40000 ALTER TABLE `quantifiable_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quantifiable_item_advice`
--

DROP TABLE IF EXISTS `quantifiable_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quantifiable_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min_red_nb` double DEFAULT NULL,
  `range_max_red_nb` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quantifiable_item_advice`
--

LOCK TABLES `quantifiable_item_advice` WRITE;
/*!40000 ALTER TABLE `quantifiable_item_advice` DISABLE KEYS */;
INSERT INTO `quantifiable_item_advice` VALUES (1,'per ...','www.     .fr',5,10),(2,'tgrfe','btgrf',1,2),(3,'htgrfe','tbgrfe',4,5),(4,'per unit','www.google.com',3,100);
/*!40000 ALTER TABLE `quantifiable_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quantifiable_item_user`
--

DROP TABLE IF EXISTS `quantifiable_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quantifiable_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quantifiable_item_user`
--

LOCK TABLES `quantifiable_item_user` WRITE;
/*!40000 ALTER TABLE `quantifiable_item_user` DISABLE KEYS */;
INSERT INTO `quantifiable_item_user` VALUES (8,3),(1,4),(5,8),(6,8),(7,8),(9,21),(10,23),(11,24);
/*!40000 ALTER TABLE `quantifiable_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quantifiable_uc`
--

DROP TABLE IF EXISTS `quantifiable_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quantifiable_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quantifiable_uc`
--

LOCK TABLES `quantifiable_uc` WRITE;
/*!40000 ALTER TABLE `quantifiable_uc` DISABLE KEYS */;
INSERT INTO `quantifiable_uc` VALUES (9,-1),(5,1),(6,1),(2,2),(8,3),(10,3),(3,5),(11,5),(1,7),(4,7),(7,11);
/*!40000 ALTER TABLE `quantifiable_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratio_comp_capex`
--

DROP TABLE IF EXISTS `ratio_comp_capex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratio_comp_capex` (
  `id_compo` int NOT NULL,
  `id_item` int NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratio_comp_capex`
--

LOCK TABLES `ratio_comp_capex` WRITE;
/*!40000 ALTER TABLE `ratio_comp_capex` DISABLE KEYS */;
INSERT INTO `ratio_comp_capex` VALUES (1,4,150),(1,5,100),(2,4,58),(2,5,10);
/*!40000 ALTER TABLE `ratio_comp_capex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratio_comp_cashreleasing`
--

DROP TABLE IF EXISTS `ratio_comp_cashreleasing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratio_comp_cashreleasing` (
  `id_compo` int NOT NULL,
  `id_item` int NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratio_comp_cashreleasing`
--

LOCK TABLES `ratio_comp_cashreleasing` WRITE;
/*!40000 ALTER TABLE `ratio_comp_cashreleasing` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratio_comp_cashreleasing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratio_comp_implem`
--

DROP TABLE IF EXISTS `ratio_comp_implem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratio_comp_implem` (
  `id_compo` int NOT NULL,
  `id_item` int NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratio_comp_implem`
--

LOCK TABLES `ratio_comp_implem` WRITE;
/*!40000 ALTER TABLE `ratio_comp_implem` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratio_comp_implem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratio_comp_opex`
--

DROP TABLE IF EXISTS `ratio_comp_opex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratio_comp_opex` (
  `id_compo` int NOT NULL,
  `id_item` int NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratio_comp_opex`
--

LOCK TABLES `ratio_comp_opex` WRITE;
/*!40000 ALTER TABLE `ratio_comp_opex` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratio_comp_opex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratio_comp_per_uc`
--

DROP TABLE IF EXISTS `ratio_comp_per_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratio_comp_per_uc` (
  `id_uc` int NOT NULL,
  `id_compo` int NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_compo`),
  KEY `id_compo` (`id_compo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratio_comp_per_uc`
--

LOCK TABLES `ratio_comp_per_uc` WRITE;
/*!40000 ALTER TABLE `ratio_comp_per_uc` DISABLE KEYS */;
INSERT INTO `ratio_comp_per_uc` VALUES (3,1,5);
/*!40000 ALTER TABLE `ratio_comp_per_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratio_comp_revenues`
--

DROP TABLE IF EXISTS `ratio_comp_revenues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratio_comp_revenues` (
  `id_compo` int NOT NULL,
  `id_item` int NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratio_comp_revenues`
--

LOCK TABLES `ratio_comp_revenues` WRITE;
/*!40000 ALTER TABLE `ratio_comp_revenues` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratio_comp_revenues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratio_comp_widercash`
--

DROP TABLE IF EXISTS `ratio_comp_widercash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratio_comp_widercash` (
  `id_compo` int NOT NULL,
  `id_item` int NOT NULL,
  `val` double DEFAULT NULL,
  PRIMARY KEY (`id_compo`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratio_comp_widercash`
--

LOCK TABLES `ratio_comp_widercash` WRITE;
/*!40000 ALTER TABLE `ratio_comp_widercash` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratio_comp_widercash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revenue_schedule`
--

DROP TABLE IF EXISTS `revenue_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revenue_schedule` (
  `id_uc` int NOT NULL,
  `id_proj` int NOT NULL,
  `start_date` date DEFAULT NULL,
  `25_rampup` date DEFAULT NULL,
  `50_rampup` date DEFAULT NULL,
  `75_rampup` date DEFAULT NULL,
  `100_rampup` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_proj`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revenue_schedule`
--

LOCK TABLES `revenue_schedule` WRITE;
/*!40000 ALTER TABLE `revenue_schedule` DISABLE KEYS */;
INSERT INTO `revenue_schedule` VALUES (-1,8,'2014-02-01','2015-02-01','2016-02-01','2017-02-01','2018-02-01','2019-02-01'),(1,1,'2020-02-01','2020-03-01','2020-04-01','2020-05-01','2020-06-01','2020-07-01'),(1,3,'2012-01-01','2013-02-01','2013-03-01','2015-02-01','2016-02-01','2023-03-01'),(1,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(1,6,'2013-05-01','2013-12-01','2014-05-01','2015-09-01','2016-06-01','2017-11-01'),(1,8,'2016-04-01','2016-09-01','2016-12-01','2017-01-01','2017-06-01','2017-12-01'),(1,24,'2020-06-01','2020-09-01','2021-01-01','2021-08-01','2021-12-01','2024-01-01'),(2,1,'2020-02-01','2020-03-01','2020-04-01','2020-05-01','2020-06-01','2020-07-01'),(2,3,'2012-01-01','2013-02-01','2013-03-01','2015-02-01','2016-02-01','2023-03-01'),(2,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(2,8,'2016-04-01','2016-09-01','2016-12-01','2017-01-01','2017-06-01','2017-12-01'),(3,3,'2012-01-01','2013-02-01','2013-03-01','2015-02-01','2016-02-01','2023-03-01'),(3,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(3,6,'2013-05-01','2013-12-01','2014-05-01','2015-09-01','2016-06-01','2017-11-01'),(3,8,'2016-04-01','2016-09-01','2016-12-01','2017-01-01','2017-06-01','2017-12-01'),(3,25,'2021-03-01','2021-04-01','2021-05-01','2021-06-01','2021-07-01','2025-01-01'),(5,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(5,8,'2016-04-01','2016-09-01','2016-12-01','2017-01-01','2017-06-01','2017-12-01'),(5,24,'2020-06-01','2020-09-01','2021-01-01','2021-08-01','2021-12-01','2024-01-01'),(7,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(7,8,'2016-04-01','2016-09-01','2016-12-01','2017-01-01','2017-06-01','2017-12-01'),(7,24,'2020-06-01','2020-09-01','2021-01-01','2021-08-01','2021-12-01','2024-01-01'),(9,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(9,8,'2016-04-01','2016-09-01','2016-12-01','2017-01-01','2017-06-01','2017-12-01'),(9,24,'2020-06-01','2020-09-01','2021-01-01','2021-08-01','2021-12-01','2024-01-01'),(10,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(10,8,'2016-04-01','2016-09-01','2016-12-01','2017-01-01','2017-06-01','2017-12-01'),(10,25,'2021-03-01','2021-04-01','2021-05-01','2021-06-01','2021-07-01','2025-01-01'),(11,4,'2012-02-01','2012-03-01','2013-02-01','2014-02-01','2015-02-01','2016-02-01'),(11,8,'2016-04-01','2016-09-01','2016-12-01','2017-01-01','2017-06-01','2017-12-01');
/*!40000 ALTER TABLE `revenue_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revenues_item`
--

DROP TABLE IF EXISTS `revenues_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revenues_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revenues_item`
--

LOCK TABLES `revenues_item` WRITE;
/*!40000 ALTER TABLE `revenues_item` DISABLE KEYS */;
INSERT INTO `revenues_item` VALUES (1,'revenues item 1',''),(2,'revenues item 2',''),(3,'revenues item 3',''),(4,'revenues item 4',''),(5,'revenues item 5',''),(7,'revenues from cost','ffff'),(8,'test',''),(9,'rev 1',''),(10,'rev 2',''),(11,'rev 3',''),(12,'test',''),(13,'efh',''),(14,'Rev1',''),(16,'advertisement',''),(17,'advertisement',''),(18,'cars parked','');
/*!40000 ALTER TABLE `revenues_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revenues_item_advice`
--

DROP TABLE IF EXISTS `revenues_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revenues_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `range_min` double DEFAULT NULL,
  `range_max` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revenues_item_advice`
--

LOCK TABLES `revenues_item_advice` WRITE;
/*!40000 ALTER TABLE `revenues_item_advice` DISABLE KEYS */;
INSERT INTO `revenues_item_advice` VALUES (1,'per example',NULL,1,10),(2,'per example',NULL,2,20),(5,'43GVFD','',54,543);
/*!40000 ALTER TABLE `revenues_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revenues_item_user`
--

DROP TABLE IF EXISTS `revenues_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revenues_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revenues_item_user`
--

LOCK TABLES `revenues_item_user` WRITE;
/*!40000 ALTER TABLE `revenues_item_user` DISABLE KEYS */;
INSERT INTO `revenues_item_user` VALUES (1,1),(2,1),(7,3),(3,4),(4,4),(6,4),(13,4),(8,8),(9,8),(10,8),(11,8),(12,21),(14,23),(15,24),(16,24),(17,25),(18,25);
/*!40000 ALTER TABLE `revenues_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revenues_uc`
--

DROP TABLE IF EXISTS `revenues_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revenues_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revenues_uc`
--

LOCK TABLES `revenues_uc` WRITE;
/*!40000 ALTER TABLE `revenues_uc` DISABLE KEYS */;
INSERT INTO `revenues_uc` VALUES (1,1),(2,1),(3,2),(6,2),(7,2),(4,3),(14,3),(18,3),(15,5),(16,5),(5,6),(12,9),(17,10),(8,11),(9,11),(10,11),(11,11),(13,11);
/*!40000 ALTER TABLE `revenues_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `risk_item`
--

DROP TABLE IF EXISTS `risk_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `risk_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `sources` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `risk_item`
--

LOCK TABLES `risk_item` WRITE;
/*!40000 ALTER TABLE `risk_item` DISABLE KEYS */;
INSERT INTO `risk_item` VALUES (1,'risk item 1','',NULL),(2,'risk item 2','',NULL),(3,'risk custom item 1','',NULL),(4,'risks','',NULL),(5,'risks','',NULL),(6,'Maladie','',NULL),(7,'Peur','',NULL),(8,'risk 1','',NULL),(9,'risk 2','',NULL),(10,'risk 3','',NULL),(11,'black','',NULL),(12,'landscape deterioration ','',NULL),(13,'dissatisfaction','',NULL);
/*!40000 ALTER TABLE `risk_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `risk_item_advice`
--

DROP TABLE IF EXISTS `risk_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `risk_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `risk_item_advice`
--

LOCK TABLES `risk_item_advice` WRITE;
/*!40000 ALTER TABLE `risk_item_advice` DISABLE KEYS */;
/*!40000 ALTER TABLE `risk_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `risk_item_user`
--

DROP TABLE IF EXISTS `risk_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `risk_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `risk_item_user`
--

LOCK TABLES `risk_item_user` WRITE;
/*!40000 ALTER TABLE `risk_item_user` DISABLE KEYS */;
INSERT INTO `risk_item_user` VALUES (1,1),(2,1),(3,4),(4,4),(5,4),(7,6),(6,8),(8,8),(9,8),(10,8),(11,23),(12,24),(13,25);
/*!40000 ALTER TABLE `risk_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `risk_uc`
--

DROP TABLE IF EXISTS `risk_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `risk_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `risk_uc`
--

LOCK TABLES `risk_uc` WRITE;
/*!40000 ALTER TABLE `risk_uc` DISABLE KEYS */;
INSERT INTO `risk_uc` VALUES (1,1),(2,1),(3,1),(6,1),(7,1),(5,2),(4,3),(11,3),(12,9),(13,10),(8,11),(9,11),(10,11);
/*!40000 ALTER TABLE `risk_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sel_funding_source`
--

DROP TABLE IF EXISTS `sel_funding_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sel_funding_source` (
  `id_finScen` int NOT NULL,
  `id_source` int NOT NULL,
  `share` double DEFAULT '0',
  `interest` double DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `maturity_date` date DEFAULT NULL,
  PRIMARY KEY (`id_finScen`,`id_source`),
  KEY `id_source` (`id_source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sel_funding_source`
--

LOCK TABLES `sel_funding_source` WRITE;
/*!40000 ALTER TABLE `sel_funding_source` DISABLE KEYS */;
INSERT INTO `sel_funding_source` VALUES (4,1,30,0,NULL,NULL),(4,3,30,0,'2014-03-01',NULL),(4,7,20,5,'2015-01-01','2016-01-01'),(4,9,10,0,'2013-03-01',NULL),(4,11,10,0,'2014-07-01',NULL),(5,2,20,0,NULL,NULL);
/*!40000 ALTER TABLE `sel_funding_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shared_financing_scen`
--

DROP TABLE IF EXISTS `shared_financing_scen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shared_financing_scen` (
  `id_group` int NOT NULL,
  `id_finScen` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_group`,`id_finScen`,`id_user`),
  KEY `id_finScen` (`id_finScen`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shared_financing_scen`
--

LOCK TABLES `shared_financing_scen` WRITE;
/*!40000 ALTER TABLE `shared_financing_scen` DISABLE KEYS */;
/*!40000 ALTER TABLE `shared_financing_scen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shared_project`
--

DROP TABLE IF EXISTS `shared_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shared_project` (
  `id_user` int NOT NULL,
  `id_proj` int NOT NULL,
  `id_group` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_proj`,`id_group`),
  KEY `id_proj` (`id_proj`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shared_project`
--

LOCK TABLES `shared_project` WRITE;
/*!40000 ALTER TABLE `shared_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `shared_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shared_ucm`
--

DROP TABLE IF EXISTS `shared_ucm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shared_ucm` (
  `id_user` int NOT NULL,
  `id_ucm` int NOT NULL,
  `id_group` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_ucm`,`id_group`),
  KEY `id_ucm` (`id_ucm`),
  KEY `id_group` (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shared_ucm`
--

LOCK TABLES `shared_ucm` WRITE;
/*!40000 ALTER TABLE `shared_ucm` DISABLE KEYS */;
/*!40000 ALTER TABLE `shared_ucm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_perimeter`
--

DROP TABLE IF EXISTS `supplier_perimeter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_perimeter` (
  `proj_id` int unsigned NOT NULL,
  `country` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `department` varchar(256) NOT NULL,
  `company` varchar(256) NOT NULL,
  `team` varchar(256) NOT NULL,
  PRIMARY KEY (`proj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_perimeter`
--

LOCK TABLES `supplier_perimeter` WRITE;
/*!40000 ALTER TABLE `supplier_perimeter` DISABLE KEYS */;
INSERT INTO `supplier_perimeter` VALUES (21,'a','Compiegne','Diego MEJIA','z','Google','team a'),(22,'','','','','',''),(23,'USA','Las Vegas','CIty of Las Vegas','Plice departement','Smart Solution Corp','team a');
/*!40000 ALTER TABLE `supplier_perimeter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_revenues_item`
--

DROP TABLE IF EXISTS `supplier_revenues_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_revenues_item` (
  `item_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('equipment','deployment','operating') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(1023) NOT NULL,
  `advice_user` enum('advice','user') NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_revenues_item`
--

LOCK TABLES `supplier_revenues_item` WRITE;
/*!40000 ALTER TABLE `supplier_revenues_item` DISABLE KEYS */;
INSERT INTO `supplier_revenues_item` VALUES (1,'rev 1','equipment','desc','user'),(2,'dep 1','deployment','','user'),(3,'op 1','operating','','user'),(4,'My rev','equipment','','user'),(5,'Sensor','equipment','','user'),(6,'project management','deployment','project','user'),(7,'sells of data analytics','operating','','user');
/*!40000 ALTER TABLE `supplier_revenues_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_revenues_uc`
--

DROP TABLE IF EXISTS `supplier_revenues_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_revenues_uc` (
  `id_revenue` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_revenue`,`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_revenues_uc`
--

LOCK TABLES `supplier_revenues_uc` WRITE;
/*!40000 ALTER TABLE `supplier_revenues_uc` DISABLE KEYS */;
INSERT INTO `supplier_revenues_uc` VALUES (1,9),(2,9),(3,9),(4,7),(5,3),(6,3),(7,3);
/*!40000 ALTER TABLE `supplier_revenues_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_revenues_user`
--

DROP TABLE IF EXISTS `supplier_revenues_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_revenues_user` (
  `id_revenue` int NOT NULL,
  `id_proj` int NOT NULL,
  PRIMARY KEY (`id_revenue`,`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_revenues_user`
--

LOCK TABLES `supplier_revenues_user` WRITE;
/*!40000 ALTER TABLE `supplier_revenues_user` DISABLE KEYS */;
INSERT INTO `supplier_revenues_user` VALUES (1,21),(2,21),(3,21),(4,21),(5,23),(6,23),(7,23);
/*!40000 ALTER TABLE `supplier_revenues_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_vs_crit`
--

DROP TABLE IF EXISTS `uc_vs_crit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uc_vs_crit` (
  `id_uc` int NOT NULL,
  `id_crit` int NOT NULL,
  `pertinence` int DEFAULT NULL,
  `range_min` int DEFAULT NULL,
  `range_max` int DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_crit`),
  KEY `id_crit` (`id_crit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_vs_crit`
--

LOCK TABLES `uc_vs_crit` WRITE;
/*!40000 ALTER TABLE `uc_vs_crit` DISABLE KEYS */;
/*!40000 ALTER TABLE `uc_vs_crit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_vs_crit_input`
--

DROP TABLE IF EXISTS `uc_vs_crit_input`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uc_vs_crit_input` (
  `id_uc` int NOT NULL,
  `id_crit` int NOT NULL,
  `id_ucm` int NOT NULL,
  `rate` int DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_crit`,`id_ucm`),
  KEY `id_crit` (`id_crit`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_vs_crit_input`
--

LOCK TABLES `uc_vs_crit_input` WRITE;
/*!40000 ALTER TABLE `uc_vs_crit_input` DISABLE KEYS */;
INSERT INTO `uc_vs_crit_input` VALUES (-1,1,13,4),(-1,2,13,5),(-1,5,13,7),(-1,6,13,5),(-1,10,13,6),(1,1,1,6),(1,1,7,4),(1,1,9,4),(1,1,13,4),(1,2,1,4),(1,2,9,1),(1,2,13,5),(1,3,1,3),(1,3,7,5),(1,3,9,1),(1,4,1,2),(1,4,9,1),(1,5,1,3),(1,5,7,7),(1,5,9,1),(1,5,13,7),(1,6,7,7),(1,6,9,1),(1,6,13,8),(1,9,7,3),(1,9,9,5),(1,10,9,3),(1,10,13,5),(2,1,1,2),(2,1,4,4),(2,1,7,7),(2,1,9,2),(2,1,13,8),(2,2,1,2),(2,2,4,4),(2,2,9,5),(2,2,13,5),(2,3,1,2),(2,3,4,4),(2,3,7,7),(2,3,9,4),(2,4,1,2),(2,4,4,4),(2,4,9,4),(2,5,1,2),(2,5,7,4),(2,5,9,5),(2,5,13,8),(2,6,4,5),(2,6,7,3),(2,6,9,4),(2,6,13,5),(2,9,4,4),(2,9,7,4),(2,9,9,5),(2,10,4,4),(2,10,9,1),(2,10,13,7),(3,1,1,2),(3,1,7,5),(3,1,9,1),(3,1,13,7),(3,2,1,10),(3,2,9,4),(3,2,13,5),(3,3,1,5),(3,3,7,7),(3,3,9,4),(3,4,1,5),(3,4,9,4),(3,5,1,9),(3,5,7,6),(3,5,9,5),(3,5,13,9),(3,6,7,3),(3,6,9,5),(3,6,13,5),(3,9,7,4),(3,9,9,1),(3,10,9,4),(3,10,13,8),(5,1,1,5),(5,1,4,4),(5,1,7,7),(5,1,9,2),(5,1,13,4),(5,2,1,4),(5,2,4,4),(5,2,9,2),(5,2,13,4),(5,3,1,5),(5,3,4,4),(5,3,7,1),(5,3,9,2),(5,4,1,5),(5,4,4,4),(5,4,9,2),(5,5,1,4),(5,5,7,9),(5,5,9,2),(5,5,13,1),(5,6,4,5),(5,6,7,5),(5,6,9,4),(5,6,13,5),(5,9,4,4),(5,9,7,5),(5,9,9,2),(5,10,4,4),(5,10,9,1),(5,10,13,3),(7,1,4,5),(7,1,7,3),(7,1,9,1),(7,1,13,3),(7,2,4,4),(7,2,9,8),(7,2,13,2),(7,3,4,4),(7,3,7,5),(7,3,9,5),(7,4,4,4),(7,4,9,5),(7,5,7,4),(7,5,9,8),(7,5,13,5),(7,6,4,4),(7,6,7,3),(7,6,9,5),(7,6,13,1),(7,9,4,5),(7,9,7,6),(7,9,9,2),(7,10,4,4),(7,10,9,5),(7,10,13,2),(9,1,4,5),(9,1,9,5),(9,1,13,7),(9,2,4,5),(9,2,9,4),(9,2,13,8),(9,3,4,5),(9,3,9,5),(9,4,4,5),(9,4,9,2),(9,5,9,4),(9,5,13,3),(9,6,4,4),(9,6,9,2),(9,6,13,4),(9,9,4,4),(9,9,9,4),(9,10,4,5),(9,10,9,2),(9,10,13,4),(10,1,4,4),(10,1,9,4),(10,1,13,3),(10,2,4,4),(10,2,9,5),(10,2,13,4),(10,3,4,4),(10,3,9,5),(10,4,4,4),(10,4,9,5),(10,5,9,7),(10,5,13,6),(10,6,4,4),(10,6,9,1),(10,6,13,2),(10,9,4,4),(10,9,9,2),(10,10,4,4),(10,10,9,5),(10,10,13,3),(11,1,7,1),(11,1,9,7),(11,1,13,7),(11,2,9,7),(11,2,13,4),(11,3,7,9),(11,3,9,7),(11,4,9,1),(11,5,7,7),(11,5,9,8),(11,5,13,9),(11,6,7,2),(11,6,9,4),(11,6,13,7),(11,9,7,1),(11,9,9,4),(11,10,9,4),(11,10,13,5);
/*!40000 ALTER TABLE `uc_vs_crit_input` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_vs_dlt`
--

DROP TABLE IF EXISTS `uc_vs_dlt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uc_vs_dlt` (
  `id_uc` int NOT NULL,
  `id_dlt` int NOT NULL,
  `pertinence` int DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_dlt`),
  KEY `id_dlt` (`id_dlt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_vs_dlt`
--

LOCK TABLES `uc_vs_dlt` WRITE;
/*!40000 ALTER TABLE `uc_vs_dlt` DISABLE KEYS */;
/*!40000 ALTER TABLE `uc_vs_dlt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ucm_sel_crit`
--

DROP TABLE IF EXISTS `ucm_sel_crit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ucm_sel_crit` (
  `id_crit` int NOT NULL,
  `id_ucm` int NOT NULL,
  PRIMARY KEY (`id_crit`,`id_ucm`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ucm_sel_crit`
--

LOCK TABLES `ucm_sel_crit` WRITE;
/*!40000 ALTER TABLE `ucm_sel_crit` DISABLE KEYS */;
INSERT INTO `ucm_sel_crit` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(1,4),(2,4),(4,4),(5,4),(6,4),(1,6),(2,6),(3,6),(4,6),(6,6),(9,6),(10,6),(1,7),(3,7),(5,7),(6,7),(9,7),(1,9),(2,9),(3,9),(4,9),(5,9),(6,9),(9,9),(10,9),(1,13),(2,13),(5,13),(6,13),(10,13);
/*!40000 ALTER TABLE `ucm_sel_crit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ucm_sel_critcat`
--

DROP TABLE IF EXISTS `ucm_sel_critcat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ucm_sel_critcat` (
  `id_critCat` int NOT NULL,
  `id_ucm` int NOT NULL,
  `weight` double DEFAULT NULL,
  PRIMARY KEY (`id_critCat`,`id_ucm`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ucm_sel_critcat`
--

LOCK TABLES `ucm_sel_critcat` WRITE;
/*!40000 ALTER TABLE `ucm_sel_critcat` DISABLE KEYS */;
INSERT INTO `ucm_sel_critcat` VALUES (1,1,NULL),(1,4,85),(1,6,NULL),(1,7,50),(1,9,50),(1,13,NULL),(2,1,NULL),(2,4,15),(2,6,NULL),(2,7,50),(2,9,50),(2,13,NULL);
/*!40000 ALTER TABLE `ucm_sel_critcat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ucm_sel_dlt`
--

DROP TABLE IF EXISTS `ucm_sel_dlt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ucm_sel_dlt` (
  `id_ucm` int NOT NULL,
  `id_dlt` int NOT NULL,
  PRIMARY KEY (`id_ucm`,`id_dlt`),
  KEY `id_dlt` (`id_dlt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ucm_sel_dlt`
--

LOCK TABLES `ucm_sel_dlt` WRITE;
/*!40000 ALTER TABLE `ucm_sel_dlt` DISABLE KEYS */;
INSERT INTO `ucm_sel_dlt` VALUES (1,1),(4,1),(6,1),(8,1),(9,1),(13,1),(4,2),(7,2),(8,2),(9,2),(13,2);
/*!40000 ALTER TABLE `ucm_sel_dlt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ucm_sel_measure`
--

DROP TABLE IF EXISTS `ucm_sel_measure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ucm_sel_measure` (
  `id_meas` int NOT NULL,
  `id_ucm` int NOT NULL,
  PRIMARY KEY (`id_meas`,`id_ucm`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ucm_sel_measure`
--

LOCK TABLES `ucm_sel_measure` WRITE;
/*!40000 ALTER TABLE `ucm_sel_measure` DISABLE KEYS */;
INSERT INTO `ucm_sel_measure` VALUES (1,1),(1,3),(1,4),(2,4),(16,6),(1,7),(15,8),(1,9),(4,9),(16,9),(0,13),(1,13);
/*!40000 ALTER TABLE `ucm_sel_measure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ucm_sel_uc`
--

DROP TABLE IF EXISTS `ucm_sel_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ucm_sel_uc` (
  `id_uc` int NOT NULL,
  `id_ucm` int NOT NULL,
  PRIMARY KEY (`id_uc`,`id_ucm`),
  KEY `id_ucm` (`id_ucm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ucm_sel_uc`
--

LOCK TABLES `ucm_sel_uc` WRITE;
/*!40000 ALTER TABLE `ucm_sel_uc` DISABLE KEYS */;
INSERT INTO `ucm_sel_uc` VALUES (1,1),(2,1),(3,1),(5,1),(2,4),(5,4),(7,4),(9,4),(10,4),(2,6),(5,6),(7,6),(9,6),(10,6),(1,7),(2,7),(3,7),(5,7),(7,7),(11,7),(1,9),(2,9),(3,9),(5,9),(7,9),(9,9),(10,9),(11,9),(-1,13),(1,13),(2,13),(3,13),(5,13),(7,13),(9,13),(10,13),(11,13);
/*!40000 ALTER TABLE `ucm_sel_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `use_case`
--

DROP TABLE IF EXISTS `use_case`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `use_case` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `id_meas` int NOT NULL,
  `id_cat` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_meas` (`id_meas`),
  KEY `id_cat` (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `use_case`
--

LOCK TABLES `use_case` WRITE;
/*!40000 ALTER TABLE `use_case` DISABLE KEYS */;
INSERT INTO `use_case` VALUES (-1,'Project Common','Represente la partie commune du projet (payer le directeur de projet, lassurance ...)',0,0),(1,'Wi-Fi','',1,1),(2,'Electric Vehicule Charger','',1,1),(3,'Parking Management','',1,2),(5,'LED Upgrade','',1,2),(6,'Pole Replacement','description',2,3),(7,'5G','',1,1),(9,'Photo Voltaic','',1,1),(10,'Public Information & advertising','',1,2),(11,'Water Level Sensor',NULL,1,2);
/*!40000 ALTER TABLE `use_case` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `use_case_cat`
--

DROP TABLE IF EXISTS `use_case_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `use_case_cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `use_case_cat`
--

LOCK TABLES `use_case_cat` WRITE;
/*!40000 ALTER TABLE `use_case_cat` DISABLE KEYS */;
INSERT INTO `use_case_cat` VALUES (0,'Project Common',NULL),(1,'UC_cat_1',''),(2,'UC_cat_2',''),(3,'UC_cat_3','');
/*!40000 ALTER TABLE `use_case_cat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `use_cases_menu`
--

DROP TABLE IF EXISTS `use_cases_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `use_cases_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `creation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modif_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `use_cases_menu`
--

LOCK TABLES `use_cases_menu` WRITE;
/*!40000 ALTER TABLE `use_cases_menu` DISABLE KEYS */;
INSERT INTO `use_cases_menu` VALUES (1,'projet','','2020-02-11 14:55:56','2020-10-05 09:54:19',1),(3,'uc_eval','','2020-02-13 12:22:10','2020-10-05 09:53:06',2),(4,'projet2','','2020-04-17 11:09:45','2020-10-05 09:53:06',1),(6,'test','testing','2020-06-29 16:12:35','2020-10-05 09:53:06',1),(7,'test1','test','2020-07-16 16:04:46','2020-10-05 09:53:06',5),(8,'test1','test','2020-08-17 09:19:57','2020-10-05 09:53:06',10),(9,'MyProject','','2020-08-28 14:59:04','2020-10-05 09:53:06',1),(10,'Project1','','2020-08-31 15:11:38','2020-10-05 09:53:06',1),(11,'MyProject2','test','2020-08-31 15:12:59','2020-10-05 09:53:06',1),(12,'retest','','2020-09-02 11:51:40','2020-10-05 09:53:06',1),(13,'Smart Lighting','','2020-10-08 08:22:36','2020-10-19 10:15:59',13);
/*!40000 ALTER TABLE `use_cases_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin',NULL,NULL,NULL,'$2y$10$vZD1YOsZNMYWzqzyg.q5KOiJ5M6VrLK8sOGcyOtEB5zWrYb3P4fGq','10661622345dce8dd31fac11.66803067',1,1,'2020-02-11 11:42:57','d'),(2,'user1',NULL,NULL,NULL,'$2y$10$wFtEEFoLQawd.KdW05QTGeituOfY8mA2kyqHBFnurWKsHu63Ke5vu','646419995e428578913042.05825044',0,NULL,'2020-02-11 11:44:08','d'),(5,'Zak',NULL,NULL,NULL,'$2y$10$8OstD4JHwDpDsUdmO2FM0Ocszp7gHS9M.7wXIb88WUm4nA8m5dC1W','7528837005f032af7425025.62320933',1,NULL,'2020-07-06 15:45:27','d'),(10,'ZakSup',NULL,NULL,NULL,'$2y$10$A5Ler5Xbj7Y6WpG/3gls6uuLRDdfv773iwOHesIKrt4rQpC/Aoz7e','12867769935f1053d19cec80.37775064',1,NULL,'2020-07-16 15:19:13','s'),(12,'adminD',NULL,NULL,NULL,'$2y$10$31NeoivqFMZ4VYFgA2OBDeHo3JzyRYD64SdvRSHDAEtPxwMSVY66S','8699085225f3a309ecca908.48687664',0,NULL,'2020-08-17 09:24:14','d'),(13,'ProjDeve',NULL,NULL,NULL,'$2y$10$pzr45zxv7yM0jHFoOosweOs9ngQDAyCvdkyw.awDMwfFCZo/cgpwu','7697641405f609379e18ed6.70056693',1,NULL,'2020-09-15 12:12:10','d'),(14,'Supplier',NULL,NULL,NULL,'$2y$10$ZRmI4EdFyNa0DjXBIuVy0OEss9uyquBbrs07M4p2ABNp9NwW5y.26','19226631715f609399dea569.52156583',1,NULL,'2020-09-15 12:12:42','s'),(15,'SupplierTest',NULL,NULL,NULL,'$2y$10$9f42/LpUAetvI3ucAfii7eXEuA3HSfPk.2eSi1nErlj3BcXHhhpRO','4077705355f60bc8fcbd303.92552720',1,NULL,'2020-09-15 15:07:27','s');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_measure`
--

DROP TABLE IF EXISTS `user_measure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_measure` (
  `id_meas` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_meas`,`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_measure`
--

LOCK TABLES `user_measure` WRITE;
/*!40000 ALTER TABLE `user_measure` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_measure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_zone`
--

DROP TABLE IF EXISTS `user_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_zone` (
  `id_zone` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_zone`,`id_user`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_zone`
--

LOCK TABLES `user_zone` WRITE;
/*!40000 ALTER TABLE `user_zone` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volumes`
--

DROP TABLE IF EXISTS `volumes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `volumes` (
  `id_uc` int NOT NULL,
  `id_zone` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `val` int DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_zone`),
  KEY `id_zone` (`id_zone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volumes`
--

LOCK TABLES `volumes` WRITE;
/*!40000 ALTER TABLE `volumes` DISABLE KEYS */;
/*!40000 ALTER TABLE `volumes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volumes_input`
--

DROP TABLE IF EXISTS `volumes_input`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `volumes_input` (
  `id_uc` int NOT NULL,
  `id_zone` int NOT NULL,
  `id_proj` int NOT NULL,
  `nb_compo` int DEFAULT NULL,
  `nb_per_uc` int DEFAULT NULL,
  `nb_tot_uc` int DEFAULT NULL,
  PRIMARY KEY (`id_uc`,`id_zone`,`id_proj`),
  KEY `id_zone` (`id_zone`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volumes_input`
--

LOCK TABLES `volumes_input` WRITE;
/*!40000 ALTER TABLE `volumes_input` DISABLE KEYS */;
INSERT INTO `volumes_input` VALUES (1,3,1,100,10,10),(1,4,3,NULL,NULL,10),(1,4,4,NULL,NULL,6),(1,4,6,NULL,NULL,10),(1,4,8,NULL,NULL,11),(1,5,6,NULL,NULL,10),(1,5,8,NULL,NULL,11),(1,6,4,NULL,NULL,6543),(1,6,8,NULL,NULL,11),(1,6,24,NULL,NULL,15),(1,7,3,NULL,NULL,10),(1,7,4,NULL,NULL,65),(1,7,8,NULL,NULL,33),(2,3,1,100,10,10),(2,4,3,NULL,NULL,10),(2,4,4,NULL,NULL,54),(2,4,8,NULL,NULL,11),(2,5,8,NULL,NULL,11),(2,6,4,NULL,NULL,654),(2,6,8,NULL,NULL,11),(2,7,3,NULL,NULL,10),(2,7,4,NULL,NULL,76),(2,7,8,NULL,NULL,33),(3,4,3,NULL,NULL,10),(3,4,4,NULL,NULL,532),(3,4,6,NULL,NULL,10),(3,4,8,NULL,NULL,11),(3,5,6,NULL,NULL,10),(3,5,8,NULL,NULL,11),(3,6,4,NULL,NULL,2),(3,6,8,NULL,NULL,11),(3,6,25,NULL,NULL,2),(3,7,3,NULL,NULL,10),(3,7,4,NULL,NULL,5),(3,7,8,NULL,NULL,33),(5,4,4,NULL,NULL,65),(5,4,8,NULL,NULL,11),(5,5,8,NULL,NULL,11),(5,6,4,NULL,NULL,49),(5,6,8,NULL,NULL,11),(5,6,24,NULL,NULL,300),(5,7,4,NULL,NULL,65),(5,7,8,NULL,NULL,33),(7,4,4,NULL,NULL,65),(7,4,8,NULL,NULL,3),(7,5,8,NULL,NULL,5),(7,6,4,NULL,NULL,65),(7,6,8,NULL,NULL,2),(7,6,24,NULL,NULL,50),(7,7,4,NULL,NULL,654),(7,7,8,NULL,NULL,10),(9,4,4,NULL,NULL,65),(9,4,8,NULL,NULL,11),(9,5,8,NULL,NULL,11),(9,6,4,NULL,NULL,65),(9,6,8,NULL,NULL,11),(9,6,24,NULL,NULL,30),(9,7,4,NULL,NULL,65),(9,7,8,NULL,NULL,33),(10,4,4,NULL,NULL,11),(10,4,8,NULL,NULL,11),(10,5,8,NULL,NULL,11),(10,6,4,NULL,NULL,11),(10,6,8,NULL,NULL,11),(10,6,25,NULL,NULL,20),(10,7,4,NULL,NULL,111),(10,7,8,NULL,NULL,33),(11,4,4,NULL,NULL,65),(11,4,8,NULL,NULL,11),(11,5,8,NULL,NULL,11),(11,6,4,NULL,NULL,65),(11,6,8,NULL,NULL,11),(11,7,4,NULL,NULL,6565),(11,7,8,NULL,NULL,33);
/*!40000 ALTER TABLE `volumes_input` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widercash_item`
--

DROP TABLE IF EXISTS `widercash_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widercash_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widercash_item`
--

LOCK TABLES `widercash_item` WRITE;
/*!40000 ALTER TABLE `widercash_item` DISABLE KEYS */;
INSERT INTO `widercash_item` VALUES (1,'wider cash benefits item 1',''),(2,'wider cash benefits item 2',''),(3,'wider cahs custom item',''),(4,'WCB',''),(6,'vfjbkdcn fbioe',''),(8,'bvefhcdbkjsnl,',''),(9,'WCB',''),(10,'WCB 1',''),(11,'WCB 2',''),(12,'wcb',''),(14,'Polution',''),(15,'Safty',''),(16,'city attractiveness ',''),(17,'traffic jam','');
/*!40000 ALTER TABLE `widercash_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widercash_item_advice`
--

DROP TABLE IF EXISTS `widercash_item_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widercash_item_advice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) DEFAULT NULL,
  `source` text,
  `unit_cost` double DEFAULT NULL,
  `range_min_red_nb` double DEFAULT NULL,
  `range_max_red_nb` double DEFAULT NULL,
  `range_min_red_cost` double DEFAULT NULL,
  `range_max_red_cost` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widercash_item_advice`
--

LOCK TABLES `widercash_item_advice` WRITE;
/*!40000 ALTER TABLE `widercash_item_advice` DISABLE KEYS */;
INSERT INTO `widercash_item_advice` VALUES (1,'per example',NULL,2,3,4,5,6),(2,'per example',NULL,4,5,6,7,8),(6,'thgfd','',0,5,45,5,45),(7,'GEFRD','',4,5,6,7,8),(8,'GRTFED','GTRFE',5,4,3,42,2);
/*!40000 ALTER TABLE `widercash_item_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widercash_item_user`
--

DROP TABLE IF EXISTS `widercash_item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widercash_item_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_proj` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_proj` (`id_proj`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widercash_item_user`
--

LOCK TABLES `widercash_item_user` WRITE;
/*!40000 ALTER TABLE `widercash_item_user` DISABLE KEYS */;
INSERT INTO `widercash_item_user` VALUES (1,1),(2,1),(3,4),(4,4),(5,4),(6,4),(8,4),(9,8),(10,8),(11,8),(12,21),(13,23),(14,23),(15,24),(16,25),(17,25);
/*!40000 ALTER TABLE `widercash_item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widercash_uc`
--

DROP TABLE IF EXISTS `widercash_uc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widercash_uc` (
  `id_item` int NOT NULL,
  `id_uc` int NOT NULL,
  PRIMARY KEY (`id_item`,`id_uc`),
  KEY `id_uc` (`id_uc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widercash_uc`
--

LOCK TABLES `widercash_uc` WRITE;
/*!40000 ALTER TABLE `widercash_uc` DISABLE KEYS */;
INSERT INTO `widercash_uc` VALUES (1,1),(2,1),(4,2),(5,2),(6,2),(3,3),(13,3),(14,3),(16,3),(17,3),(7,5),(15,5),(8,7),(12,9),(9,11),(10,11),(11,11);
/*!40000 ALTER TABLE `widercash_uc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zone`
--

DROP TABLE IF EXISTS `zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zone` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `id_zone` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_zone` (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zone`
--

LOCK TABLES `zone` WRITE;
/*!40000 ALTER TABLE `zone` DISABLE KEYS */;
INSERT INTO `zone` VALUES (1,'ville1','ville',NULL),(2,'quartier1','quartier',1),(3,'quartier2','quartier',1),(4,'ssquartier11','ssquartier',2),(5,'ssquartier12','ssquartier',2),(6,'ssquartier21','ssquartier',3),(7,'quartier3','quartier',1);
/*!40000 ALTER TABLE `zone` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-19 10:27:56
