-- MySQL dump 10.13  Distrib 8.0.19, for macos10.15 (x86_64)
--
-- Host: localhost    Database: issue_tracking_sys
-- ------------------------------------------------------
-- Server version	8.0.19

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

--
-- Table structure for table `assignee`
--

DROP TABLE IF EXISTS `assignee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assignee` (
  `assignee_id` int NOT NULL AUTO_INCREMENT,
  `issue` int DEFAULT NULL,
  `user` int DEFAULT NULL,
  PRIMARY KEY (`assignee_id`),
  UNIQUE KEY `assignee_id_UNIQUE` (`assignee_id`),
  KEY `issue_id_idx` (`issue`),
  KEY `user_id_idx` (`user`),
  CONSTRAINT `issue` FOREIGN KEY (`issue`) REFERENCES `issue` (`issue_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignee`
--

LOCK TABLES `assignee` WRITE;
/*!40000 ALTER TABLE `assignee` DISABLE KEYS */;
INSERT INTO `assignee` VALUES (1,3,1),(2,4,2),(3,5,1),(15,4,1),(16,5,2),(17,40,1),(18,41,1),(19,42,2),(20,44,1),(21,44,2),(22,41,4),(23,41,3),(24,41,2),(25,42,3),(26,42,1),(27,41,6),(28,42,6),(29,42,4),(30,44,4),(31,47,1),(32,47,6),(33,44,3),(34,47,2),(35,50,2);
/*!40000 ALTER TABLE `assignee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue`
--

DROP TABLE IF EXISTS `issue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `issue` (
  `issue_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pro_id` int NOT NULL,
  `reporter` int NOT NULL,
  PRIMARY KEY (`issue_id`),
  KEY `project_idx` (`pro_id`),
  KEY `reporter_idx` (`reporter`),
  CONSTRAINT `project` FOREIGN KEY (`pro_id`) REFERENCES `project` (`pro_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reporter` FOREIGN KEY (`reporter`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue`
--

LOCK TABLES `issue` WRITE;
/*!40000 ALTER TABLE `issue` DISABLE KEYS */;
INSERT INTO `issue` VALUES (1,'game can not start','The game cannot start','0000-00-00 00:00:00',1,1),(2,'game can not start','The game cannot start','2020-04-26 00:00:00',1,1),(3,'screen broken','The screen is totally crushed.','2020-04-26 18:10:23',2,3),(4,'screen broken','The screen is totally crushed.','2020-04-26 18:11:20',1,3),(5,'Test issue','nothing','2020-05-22 18:38:59',1,1),(29,'Test issue','issue1','2020-05-23 15:38:41',1,1),(30,'new issue','new','2020-05-23 15:41:36',1,1),(31,'why','why','2020-05-23 15:43:26',1,1),(34,'new issue','new one','2020-05-23 16:05:15',1,1),(35,'not adding history','no history','2020-05-23 18:03:09',2,1),(36,'ml','ml','2020-05-23 18:12:47',2,1),(37,'still','no his','2020-05-23 18:13:53',2,1),(40,'edition failed','cannot edit the issue','2020-05-23 21:21:25',2,1),(41,'new issues','this new issue','2020-05-23 21:37:22',1,1),(42,'issue success','so you two are','2020-05-25 11:50:16',1,1),(44,'not adding history','not any more yet','2020-05-25 11:58:09',1,1),(47,'check creation','after creation','2020-05-25 12:19:35',1,1),(48,'who r u','from the wall','2020-05-25 12:27:35',1,1),(49,'Burgundy Red','This is the sign.','2020-05-25 16:57:42',1,1),(50,'kindle cannot import pdfs','User cannot open files on kindle.','2020-05-25 18:43:42',1,1);
/*!40000 ALTER TABLE `issue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issue_history`
--

DROP TABLE IF EXISTS `issue_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `issue_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `issue_id` int DEFAULT NULL,
  `to_status` int DEFAULT NULL,
  `update_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `by_uid` int DEFAULT NULL,
  PRIMARY KEY (`history_id`),
  KEY `is_idx` (`issue_id`),
  KEY `to_idx` (`to_status`),
  KEY `by_idx` (`by_uid`),
  CONSTRAINT `by` FOREIGN KEY (`by_uid`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `is` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`issue_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `to` FOREIGN KEY (`to_status`) REFERENCES `status` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issue_history`
--

LOCK TABLES `issue_history` WRITE;
/*!40000 ALTER TABLE `issue_history` DISABLE KEYS */;
INSERT INTO `issue_history` VALUES (0,4,0,'2020-04-26 18:11:20',NULL),(1,4,1,'2020-04-26 20:36:04',NULL),(2,4,2,'2020-04-26 20:41:42',NULL),(3,4,3,'2020-04-26 20:41:53',NULL),(4,4,2,'2020-04-26 21:43:11',NULL),(5,4,1,'2020-04-26 21:43:11',NULL),(6,4,0,'2020-04-26 21:43:12',NULL),(7,5,0,'2020-05-22 21:17:06',1),(10,4,0,'2020-05-22 23:23:55',1),(11,4,0,'2020-05-22 23:33:39',1),(12,4,1,'2020-05-23 13:02:58',1),(15,4,2,'2020-05-23 15:47:52',1),(16,4,3,'2020-05-23 16:01:52',1),(17,4,4,'2020-05-23 16:02:35',1),(18,4,5,'2020-05-23 16:04:53',1),(19,5,1,'2020-05-23 17:41:43',1),(20,5,0,'2020-05-23 18:10:30',1),(23,5,1,'2020-05-23 19:21:00',1),(24,5,0,'2020-05-23 19:21:05',1),(25,5,1,'2020-05-23 19:55:23',1),(26,40,0,'2020-05-23 21:21:25',1),(27,40,1,'2020-05-23 21:21:44',1),(28,41,0,'2020-05-23 21:37:22',1),(29,41,1,'2020-05-23 21:37:45',1),(30,41,0,'2020-05-23 21:38:01',1),(31,5,2,'2020-05-23 23:06:27',1),(32,42,0,'2020-05-25 11:50:16',1),(34,44,0,'2020-05-25 11:58:09',1),(37,47,0,'2020-05-25 12:19:35',1),(38,47,0,'2020-05-25 12:20:02',1),(39,47,0,'2020-05-25 12:22:02',1),(40,47,0,'2020-05-25 12:24:38',1),(41,47,0,'2020-05-25 12:26:42',1),(42,48,0,'2020-05-25 12:27:35',1),(43,41,1,'2020-05-25 15:09:34',1),(44,42,1,'2020-05-25 16:32:19',1),(45,42,2,'2020-05-25 16:32:30',1),(46,44,1,'2020-05-25 16:46:43',1),(47,49,0,'2020-05-25 16:57:42',1),(48,41,2,'2020-05-25 18:12:50',1),(49,41,3,'2020-05-25 18:13:01',1),(50,47,1,'2020-05-25 18:23:58',1),(51,50,0,'2020-05-25 18:43:42',1),(52,50,1,'2020-05-25 18:43:57',1),(53,50,2,'2020-05-25 18:44:07',1);
/*!40000 ALTER TABLE `issue_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leader`
--

DROP TABLE IF EXISTS `leader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leader` (
  `leader_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `pro_id` int DEFAULT NULL,
  PRIMARY KEY (`leader_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `pro_id_idx` (`pro_id`),
  CONSTRAINT `pro_id` FOREIGN KEY (`pro_id`) REFERENCES `project` (`pro_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leader`
--

LOCK TABLES `leader` WRITE;
/*!40000 ALTER TABLE `leader` DISABLE KEYS */;
INSERT INTO `leader` VALUES (1,1,1);
/*!40000 ALTER TABLE `leader` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participate`
--

DROP TABLE IF EXISTS `participate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participate` (
  `user_id` int NOT NULL,
  `pro_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`pro_id`),
  KEY `pro_idx` (`pro_id`),
  CONSTRAINT `member` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `pro` FOREIGN KEY (`pro_id`) REFERENCES `project` (`pro_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participate`
--

LOCK TABLES `participate` WRITE;
/*!40000 ALTER TABLE `participate` DISABLE KEYS */;
INSERT INTO `participate` VALUES (1,1),(2,1),(3,1),(4,1),(6,1),(1,2),(4,2),(7,2);
/*!40000 ALTER TABLE `participate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project` (
  `pro_Id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `workflowId` int DEFAULT NULL,
  PRIMARY KEY (`pro_Id`),
  KEY `workflow_idx` (`workflowId`),
  CONSTRAINT `workflow` FOREIGN KEY (`workflowId`) REFERENCES `workflow` (`workflowid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'Amazon Kindle','The Kindle Project',1),(2,'prime','amazon prime',1);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status` (
  `status_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (0,'OPEN'),(1,'IN PROGRESS'),(2,'UNDER REVIEW'),(3,'FINAL APPROVAL'),(4,'DONE'),(5,'CLOSED');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transition`
--

DROP TABLE IF EXISTS `transition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transition` (
  `workflowId` int NOT NULL,
  `cur_status` int NOT NULL,
  `next_status` int NOT NULL,
  PRIMARY KEY (`workflowId`,`next_status`,`cur_status`),
  KEY `cur_idx` (`cur_status`),
  KEY `next_idx` (`next_status`),
  CONSTRAINT `cur` FOREIGN KEY (`cur_status`) REFERENCES `status` (`status_id`),
  CONSTRAINT `next` FOREIGN KEY (`next_status`) REFERENCES `status` (`status_id`),
  CONSTRAINT `workflowId` FOREIGN KEY (`workflowId`) REFERENCES `workflow` (`workflowId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transition`
--

LOCK TABLES `transition` WRITE;
/*!40000 ALTER TABLE `transition` DISABLE KEYS */;
INSERT INTO `transition` VALUES (1,0,1),(1,1,0),(1,1,2),(1,2,3),(1,3,4),(1,4,5);
/*!40000 ALTER TABLE `transition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `displayname` varchar(45) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `randSalt` varchar(225) NOT NULL DEFAULT '$2y$10$iusesomecrazystrings22',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'164816086@qq.com','wyx','px','$2y$10$iusesomecrazystrings2uz/HkvnvHFd41nowL3oLCmiMEM4CLQyW','$2y$10$iusesomecrazystrings22'),(2,'Jeff@gmail.com','Jeff Bezos','Jeff','zxcvbnm',''),(3,'9274@qq.com','yx','yx','123',''),(4,'123@gmail.com','jim','jim','$1$paa9JId.$CXJeJovtT.LLELnf6UZXl1',''),(5,'123@gmail.com','jim','jim','$1$Jn0Xr/gU$JVtL6/vhUy5ADiEmrBzjo.',''),(6,'px@gmail.com','pxpx','pxpx','$1$d1hW8wNp$yxFW/1RHEiUx33lPBV/TM/','$2y$10$iusesomecrazystrings22'),(7,'995792445@qq.com','newpx','pxx','$2y$10$iusesomecrazystrings2uz/HkvnvHFd41nowL3oLCmiMEM4CLQyW','$2y$10$iusesomecrazystrings22');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow`
--

DROP TABLE IF EXISTS `workflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `workflow` (
  `workflowId` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`workflowId`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workflow`
--

LOCK TABLES `workflow` WRITE;
/*!40000 ALTER TABLE `workflow` DISABLE KEYS */;
INSERT INTO `workflow` VALUES (2,'Amazon work flow'),(1,'Porject1 work flow');
/*!40000 ALTER TABLE `workflow` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-25 18:47:10
