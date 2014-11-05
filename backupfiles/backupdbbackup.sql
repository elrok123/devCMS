-- MySQL dump 10.13  Distrib 5.5.30, for Linux (x86_64)
--
-- Host: localhost    Database: backupdb
-- ------------------------------------------------------
-- Server version	5.5.30-cll

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postedby` int(11) NOT NULL,
  `filetype` varchar(256) COLLATE utf8_bin NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filename` varchar(256) COLLATE utf8_bin NOT NULL,
  `filesize` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (7,4,'jpg','2013-02-28 16:26:58','327999.jpg',0.540285),(6,4,'psd','2013-02-28 16:26:32','MikeGiant-Krooked.psd',2.4487),(5,4,'png','2013-02-28 16:25:37','connor.png',0.814816),(8,4,'jpg','2013-02-28 16:27:04','channels3_background.jpg',0.200562),(9,4,'png','2013-02-28 16:27:14','dlconner.png',0.558923),(10,4,'html','2013-03-05 00:45:29','DataProtectionActDPAPenalties.html',0.0605335),(11,4,'svg','2013-03-05 00:45:50','logo.svg',0.0159903),(12,4,'jpg','2013-03-05 01:07:59','1362445584460.jpg',2.66245),(13,4,'exe','2013-03-05 20:13:20','TeamViewer_Setup_en.exe',4.63155),(14,4,'docx','2013-03-14 12:17:21','assessmentquestions.docx',0.0164194),(15,4,'html','2013-03-20 14:35:27','convertUnit.html.html',0.00592041),(16,4,'htm','2013-03-20 14:35:45','Calculator.htm',0.00514126),(17,4,'html','2013-03-20 14:35:51','area.html.html',0.00225067),(18,4,'jpg','2013-03-20 14:35:55','GoldenPiggy.jpg',0.0330477),(19,4,'html','2013-03-20 14:35:59','runAway.html.html',0.00658798);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8_bin NOT NULL,
  `emailverified` tinyint(2) NOT NULL,
  `password` varchar(150) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(100) COLLATE utf8_bin NOT NULL,
  `surname` varchar(100) COLLATE utf8_bin NOT NULL,
  `dob` date NOT NULL,
  `nationality` varchar(10) COLLATE utf8_bin NOT NULL,
  `friends` varchar(1000) COLLATE utf8_bin NOT NULL,
  `aboutme` mediumtext COLLATE utf8_bin NOT NULL,
  `imagename` varchar(100) COLLATE utf8_bin NOT NULL,
  `registrationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `balance` float(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'mccabec@hotmail.co.uk',1,'$biuendpPhqv.','Conner','McCabe','1991-07-19','GB','','','','2013-02-28 15:44:55',0.00),(5,'deadcroweater@hotmail.com',1,'$bIWdraYI8RCU','pope','benedict','1980-02-01','IT','','','','2013-03-14 12:32:33',0.00),(6,'ajspingarn@gmail.com',0,'$bI8BhCE8jgK6','Austin','Spingarn','1997-07-14','US','','','','2013-04-07 02:59:39',0.00);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishes`
--

DROP TABLE IF EXISTS `wishes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `wishdesc` mediumtext COLLATE utf8_bin NOT NULL,
  `target` float(6,2) NOT NULL DEFAULT '0.00',
  `postedby` int(11) NOT NULL,
  `wishtitle` varchar(100) COLLATE utf8_bin NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imagename` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `donations` float(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishes`
--

LOCK TABLES `wishes` WRITE;
/*!40000 ALTER TABLE `wishes` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-09  6:38:14
