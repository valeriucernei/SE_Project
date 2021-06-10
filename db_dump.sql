CREATE DATABASE  IF NOT EXISTS "carmarket" /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `carmarket`;
-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: carmarket-db-do-user-9042934-0.b.db.ondigitalocean.com    Database: carmarket
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '462fc9f8-9948-11eb-bb0b-1e43c575ebeb:1-210';

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `model` (`model`),
  CONSTRAINT `ads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `ads_ibfk_2` FOREIGN KEY (`model`) REFERENCES `cars` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
INSERT INTO `ads` VALUES (1,94,' ',' ',11,'2021-06-01 18:40:27','2021-06-01 18:40:27'),(195,94,'Audi A1','Smile spoke total few great had never their too. Amongst moments do in arrived at my replied. \r\n\r\nFat weddings servants but man believed prospect. Companions understood is as especially pianoforte connection introduced. \r\n\r\nNay newspaper can sportsman are admitting gentleman belonging his. Is oppose no he summer lovers twenty in. Not his difficulty boisterous surrounded bed. Seems folly if in given scale. \r\nSex contented dependent conveying advantage can use. \r\n',6,'2021-06-01 18:41:28','2021-06-01 16:44:40'),(196,94,'Audi A1','Boy desirous families prepared gay reserved add ecstatic say. Replied joy age visitor nothing cottage. Mrs door paid led loud sure easy read. Hastily at perhaps as neither or ye fertile tedious visitor. Use fine bed none call busy dull when. Quiet ought match my right by table means. Principles up do in me favourable affronting. Twenty mother denied effect we to do on.  Boy desirous families prepared gay reserved add ecstatic say. Replied joy age visitor nothing cottage. Mrs door paid led loud sure easy read. Hastily at perhaps as neither or ye fertile tedious visitor. Use fine bed none call busy dull when. Quiet ought match my right by table means. Principles up do in me favourable affronting. Twenty mother denied effect we to do on. ',6,'2021-06-01 18:48:54','2021-06-01 18:48:54'),(197,94,'Audi A2','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. ',7,'2021-06-01 18:54:27','2021-06-01 18:54:27'),(199,94,'Audi A6 LOVE','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. ',8,'2021-06-01 19:05:01','2021-06-01 19:05:01'),(200,94,'Audi A6 GooD','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible.',8,'2021-06-01 19:07:44','2021-06-01 19:07:44'),(201,94,'Audi A6','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. ',8,'2021-06-01 19:11:06','2021-06-01 19:11:06'),(202,94,'Audi A7 YOHOO','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. ',9,'2021-06-01 19:15:27','2021-06-01 19:15:27'),(203,94,'Audi A7 PRESTIGE','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. ',9,'2021-06-01 19:21:49','2021-06-01 19:21:49'),(204,94,'Audi A777','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible bu',9,'2021-06-01 19:25:26','2021-06-01 19:25:26'),(205,94,'Audi A888','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible bu',10,'2021-06-01 19:30:12','2021-06-01 19:30:12'),(206,94,'Audi QQQQQ55555','Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. Now led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible bu',11,'2021-06-01 19:34:00','2021-06-01 19:34:00'),(207,94,'Audi AAA','May musical arrival beloved luckily adapted him. Shyness mention married son she his started now. Rose if as past near were. To graceful he elegance oh moderate attended entrance pleasure. Vulgar saw fat sudden edward way played either. Thoughts smallest at or peculiar relation breeding produced an. At depart spirit on stairs. She the either are wisdom praise things she before. Be mother itself vanity favour do me of. Begin sex was power joy after had walls miles. May musical arrival beloved luckily adapted him. Shyness mention married son she his started now. Rose if as past near were. To graceful he elegance oh moderate attended entrance pleasure. Vulgar saw fat sudden edward way played either. Thoughts smallest at or peculiar relation breeding produced an. At depart spirit on stairs. She the either are wisdom praise things she before. Be mother itself vanity favour do me of. Begin sex was power joy after had walls miles. ',7,'2021-06-01 19:36:23','2021-06-01 19:36:23'),(208,94,'Audi Q5Q','May musical arrival beloved luckily adapted him. Shyness mention married son she his started now. Rose if as past near were. To graceful he elegance oh moderate attended entrance pleasure. Vulgar saw fat sudden edward way played either. Thoughts smallest at or peculiar relation breeding produced an. At depart spirit on stairs. She the either are wisdom praise things she before. Be mother itself vanity favour do me of. Begin sex was power joy after had walls miles. May musical arrival beloved luckily adapted him. Shyness mention married son she his started now. Rose if as past near were. To graceful he elegance oh moderate attended entrance pleasure. Vulgar saw fat sudden edward way played either. Thoughts smallest at or peculiar relation breeding produced an. At depart spirit on stairs. She the either are wisdom praise things she before. Be mother itself vanity favour do me of. Begin sex was power joy after had walls miles. ',11,'2021-06-01 19:43:34','2021-06-01 19:43:34'),(209,94,'Audi Q777','May musical arrival beloved luckily adapted him. Shyness mention married son she his started now. Rose if as past near were. To graceful he elegance oh moderate attended entrance pleasure. Vulgar saw fat sudden edward way played either. Thoughts smallest at or peculiar relation breeding produced an. At depart spirit on stairs. She the either are wisdom praise things she before. Be mother itself vanity favour do me of. Begin sex was power joy after had walls miles. May musical arrival beloved luckily adapted him. Shyness mention married son she his started now. Rose if as past near were. To graceful he elegance oh moderate attended entrance pleasure. Vulgar saw fat sudden edward way played either. Thoughts smallest at or peculiar relation breeding produced an. At depart spirit on stairs. She the either are wisdom praise things she before. Be mother itself vanity favour do me of. Begin sex was power joy after had walls miles. ',12,'2021-06-01 19:46:31','2021-06-03 12:10:34'),(214,94,'S Class SUper',NULL,34,'2021-06-10 12:04:13','2021-06-10 12:04:13');
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `ads_list`
--

DROP TABLE IF EXISTS `ads_list`;
/*!50001 DROP VIEW IF EXISTS `ads_list`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `ads_list` AS SELECT 
 1 AS `id`,
 1 AS `user_id`,
 1 AS `title`,
 1 AS `description`,
 1 AS `brand`,
 1 AS `brand_name`,
 1 AS `model`,
 1 AS `model_name`,
 1 AS `date`,
 1 AS `updated`,
 1 AS `car_body`,
 1 AS `fabricated`,
 1 AS `km`,
 1 AS `price`,
 1 AS `gearbox`,
 1 AS `fuel_type`,
 1 AS `motor_size`,
 1 AS `photo`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `atributes`
--

DROP TABLE IF EXISTS `atributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ad_id` int NOT NULL,
  `car_body` int NOT NULL,
  `fabricated` int NOT NULL,
  `km` int DEFAULT NULL,
  `price` int DEFAULT NULL,
  `gearbox` int DEFAULT NULL,
  `fuel_type` int DEFAULT NULL,
  `motor_size` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`),
  CONSTRAINT `atributes_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atributes`
--

LOCK TABLES `atributes` WRITE;
/*!40000 ALTER TABLE `atributes` DISABLE KEYS */;
INSERT INTO `atributes` VALUES (157,195,1,2011,157483,10300,1,1,1400),(158,196,1,2015,43900,14650,2,2,1400),(159,197,1,2005,120000,950,1,1,1420),(161,199,1,2014,170000,11600,2,2,1400),(162,200,1,2015,120000,19500,2,2,1986),(163,201,1,2018,101000,26000,2,1,2000),(164,202,1,2011,222000,20500,2,2,2800),(165,203,1,2018,4000,39500,2,2,3000),(166,204,1,2012,199000,14000,2,1,3000),(167,205,1,2013,207599,24500,2,4,1984),(168,206,1,2009,156000,13500,2,2,2000),(169,207,1,2014,123000,13000,2,3,2200),(170,208,1,2009,156000,14000,2,2,2000),(171,209,1,2018,155000,43000,2,1,3000),(176,214,1,2006,265000,14000,2,2,3500);
/*!40000 ALTER TABLE `atributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cars` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES (2,'Audi',0),(3,'BMW',0),(4,'Mercedes-Benz',0),(5,'Volkswagen',0),(6,'A1',2),(7,'A2',2),(8,'A6',2),(9,'A7',2),(10,'A8',2),(11,'Q5',2),(12,'Q7',2),(13,'e-tron',2),(14,'1 Series',3),(15,'2 Series',3),(16,'5 Series',3),(17,'6 Series',3),(18,'7 Series',3),(19,'X1',3),(20,'X2',3),(21,'X3',3),(22,'X4',3),(23,'X5',3),(24,'X6',3),(25,'X7',3),(26,'Z Series',3),(27,'C Class',4),(28,'CLA Class',4),(29,'CLC Class',4),(30,'CLK Class',4),(31,'E Class',4),(32,'G Class',4),(33,'GL Class',4),(34,'S Class',4),(35,'SL Class',4),(36,'Amarok',5),(37,'Beetle',5),(38,'Caddy',5),(39,'Golf',5),(40,'Jetta',5),(41,'Passat',5),(42,'Passat CC',5),(43,'Phaeton',5),(44,'Scirocco',5),(45,'Tiguan',5),(46,'Touareg',5),(47,'Transporter',5);
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ad_id` int NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`),
  CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
INSERT INTO `photos` VALUES (68,195,'PFw4Dapx6Isq9MuR.png'),(69,195,'nMozvZuFQSqN684P.png'),(70,195,'6mFv1aWJdXnzt780.png'),(71,195,'gDJuzQSnIVtWNUfq.png'),(72,195,'T9uEio8GAYHenjDL.png'),(73,196,'tma9V2bZo1Nlkq5p.png'),(74,196,'QWiXKxuNgB2msn8v.png'),(75,196,'XSWR3EYQ7tTB2e4g.png'),(76,196,'vcV6OgqJd5Nwk0lY.png'),(77,196,'yurxJ2F6HaSPM5B4.png'),(78,196,'u60kTFAWDyIR4mxO.png'),(79,196,'X4bwQ9c8HdYSZuU6.png'),(80,196,'iZLltky8FIj0WB26.png'),(81,196,'u46bs5nHQfiDNKWZ.png'),(82,196,'m0qXZScofzbgTrlU.png'),(83,197,'9cIUKgul7YzABJe0.png'),(84,197,'IQBARXtyg9ODLb3f.png'),(85,197,'h5xdDQB4GqfL8b7P.png'),(96,199,'RsaD0nYygkmxlETW.png'),(97,199,'g2JCEmStHRU97nT6.png'),(98,199,'fl6eRcAuCbx1jTrK.png'),(99,199,'oOgPbRI2CKqsSJ8c.png'),(100,200,'vWNVMA6fF8YLCeBS.png'),(101,200,'sSnQrYfhNWMGOlEt.png'),(102,200,'a8cz4fXgsJbRCQd9.png'),(103,200,'0Tl8yOraYtE4uCWb.png'),(104,201,'TdHNwVxWmjQ348SF.png'),(105,201,'qdOTtfl7oE1cMgvJ.png'),(106,201,'DKmJXMFiWeBvapt7.png'),(107,201,'VpDZz50gfCLeMPXG.png'),(108,202,'4TYfDCehUzn7r93P.png'),(109,202,'pXFEGWChZ6e4sfI5.png'),(110,202,'dwulbqBPUanRrxTH.png'),(111,202,'UqeWobt5HAO9CrQY.png'),(112,202,'F5m0IujUlah2Xnwv.png'),(113,203,'oYZQBnXPKu2bfCG5.png'),(114,203,'XJtsmWGjpP2kHq6F.png'),(115,203,'VNfSrLd7BAPuxlHz.png'),(116,203,'MIRfLZgp0Kwa43hT.png'),(117,204,'DJduYTm1sB9q2VEa.png'),(118,204,'ez4IGCWNFvtxMbkX.png'),(119,204,'PDCM09NH2UrJEmuc.png'),(120,205,'IafQ9nJMdoRylVmA.png'),(121,205,'nLUI6ifeV7OGqo2C.png'),(122,205,'uSDlxmX5gfNiHMAU.png'),(123,205,'8jSefElBFh42VawD.png'),(124,208,'0uMC42Thnlgq5cA3.png'),(125,208,'KV5EtDys6Zzw02fA.png'),(126,208,'p8QNskUFZ2Eri5aS.png'),(127,208,'OTGzDwqWhF3Z6JLa.png'),(128,209,'eRTqVt3JXYul40ps.png'),(129,209,'v3jNfm5lVyHI6CKP.png'),(130,209,'7NKesdnioXwjL1J3.png'),(131,209,'xIPfHAkKBOyC4Qi2.png'),(132,209,'hBzIojMs9qdVNRSx.png'),(141,214,'N3aQCmKvX4SkRHTY.png'),(142,214,'ZIc2iAG4o5OMYteC.png'),(143,214,'8XwYaLmjnWf7hq9s.png'),(144,214,'J4dKlhejfDHEc0TZ.png');
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(320) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` tinyint DEFAULT NULL,
  `token` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_created_at` timestamp NULL DEFAULT NULL,
  `status` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`(255))
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (94,'valera','Valeriu','Cernei','c8837b23ff8aaa8a2dde915473ce0991','valerastar4ik@gmail.com','1234567890','2021-05-15 18:53:07',3,NULL,'2021-06-10 12:18:25','ACTIVE');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'carmarket'
--

--
-- Final view structure for view `ads_list`
--

/*!50001 DROP VIEW IF EXISTS `ads_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`doadmin`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `ads_list` AS select `ads`.`id` AS `id`,`ads`.`user_id` AS `user_id`,`ads`.`title` AS `title`,`ads`.`description` AS `description`,`t2`.`id` AS `brand`,`t2`.`name` AS `brand_name`,`ads`.`model` AS `model`,`t1`.`name` AS `model_name`,`ads`.`date` AS `date`,`ads`.`updated` AS `updated`,`atributes`.`car_body` AS `car_body`,`atributes`.`fabricated` AS `fabricated`,`atributes`.`km` AS `km`,`atributes`.`price` AS `price`,`atributes`.`gearbox` AS `gearbox`,`atributes`.`fuel_type` AS `fuel_type`,`atributes`.`motor_size` AS `motor_size`,coalesce(`photos`.`name`,'default.png') AS `photo` from ((((`ads` join `atributes` on((`ads`.`id` = `atributes`.`ad_id`))) left join `photos` on((`ads`.`id` = `photos`.`ad_id`))) join `cars` `t1` on((`ads`.`model` = `t1`.`id`))) join `cars` `t2` on((`t1`.`father_id` = `t2`.`id`))) where ((`photos`.`id` is null) or (`photos`.`id` = (select min(`photos`.`id`) from `photos` where (`photos`.`ad_id` = `ads`.`id`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-10 14:46:19
