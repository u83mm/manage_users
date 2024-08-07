-- MariaDB dump 10.19  Distrib 10.11.2-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: my_database
-- ------------------------------------------------------
-- Server version	10.11.2-MariaDB-1:10.11.2+maria~ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `limit_access`
--

DROP TABLE IF EXISTS `limit_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limit_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `restriction_time` int(11) NOT NULL,
  `failed_tries` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limit_access`
--

LOCK TABLES `limit_access` WRITE;
/*!40000 ALTER TABLE `limit_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `limit_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES
(1,'ROLE_ADMIN'),
(2,'ROLE_USER');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT 2,
  `terms` varchar(25) NOT NULL,
  `create_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_user_role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES
(1,'Luís','$2y$10$zNSjJmWjAg2Rn4vyKB/y4.wHEKWxhkhdVqPRotjK6DQO5fil5YbDG','fpoulton0@trellian.com',2,'checked','2024-04-14 18:25:17'),
(2,'pnusche1','kn4dZSZy','oalten1@timesonline.co.uk',2,'checked','2024-04-14 18:25:17'),
(3,'rjob2','$2y$10$urz15Zw2iYSm84HKXJbSdu6FF2jUo3B7TyfOZ1wUa9/UDLLJ5aLAO','hkoschke2@columbia.edu',2,'checked','2024-04-14 18:25:17'),
(4,'gbeckhurst3','hli11TCLLy5W','cmcelory3@desdev.cn',2,'checked','2024-04-14 18:25:17'),
(5,'cvain4','$2y$10$Mh6IJtbcfbQ.TtJBMbAgXuEX3EzNMb5hk9TShYh/zqNJUsap1dUoG','pmcmillan4@skype.com',2,'checked','2024-04-14 18:25:17'),
(6,'csteddall5','rRaBKnY14Ke','afussen5@t.co',2,'checked','2024-04-14 18:25:17'),
(7,'isopper6','cjphThcO','mhaylett6@symantec.com',2,'checked','2024-04-14 18:25:17'),
(8,'bmoore7','iVE8hSSvOaKw','bwoolforde7@joomla.org',2,'checked','2024-04-14 18:25:17'),
(9,'lpostgate8','$2y$10$nB17vsUwK7ua/.7/.7S0Ru7z6MASf4U/107/btA./gehPcjYnF.Se','wallbut8@infoseek.co.jp',2,'checked','2024-04-14 18:25:17'),
(10,'fhansed9','saV7FmEJq','bbartke9@gnu.org',2,'checked','2024-04-14 18:25:17'),
(11,'admin','$2y$10$UmlPg2q.E8FyQ/y8/zkcgu/OXaar1erO8gEldBqGI5BtB3vElwReq','admin@admin.com',1,'checked','2024-04-14 18:25:17'),
(12,'pepe','$2y$10$pguzOr3F5.CcyuAWY3RoBeHm1CdAarDfA6/gIxNhe1T2/YimQSmJW','pepe@pepe.com',2,'checked','2024-04-14 18:25:17');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-17 12:37:12
