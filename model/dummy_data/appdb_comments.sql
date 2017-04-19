-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: appdb
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.21-MariaDB

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `event` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `dateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_events1_idx` (`event`),
  KEY `fk_comments_users1_idx` (`user`),
  KEY `fk_comments_comments1_idx` (`parent`),
  CONSTRAINT `fk_comments_comments1` FOREIGN KEY (`parent`) REFERENCES `comments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_events1` FOREIGN KEY (`event`) REFERENCES `events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_users1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Περιγραφή event!! Κάτι πρέπει να προσθέσω για να φανεί κάτι!!',1,1,NULL,'2016-03-27 15:45:00'),(2,'Υποσχόλιο event για δοκιμή 2. Κάτι θα προστεθεί. Τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ',1,1,1,'2016-03-28 12:30:00'),(3,'Προσθήκη νέου σχολίου ρίζα. Κάτι έπρεπε να βάλω για δοκιμή event',1,2,NULL,'2016-03-27 17:20:00'),(4,'ΤΕΛΟΣ event!!',1,1,NULL,'2016-03-27 17:20:00'),(5,'Υποσχόλιο για δοκιμή. Κάτι θα προστεθεί. Τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ τεστ!',1,2,1,'2016-03-27 15:53:00');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-15 16:33:08
