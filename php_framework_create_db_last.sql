CREATE DATABASE  IF NOT EXISTS `php_framework` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `php_framework`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: php_framework
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres`
--

LOCK TABLES `genres` WRITE;
/*!40000 ALTER TABLE `genres` DISABLE KEYS */;
INSERT INTO `genres` VALUES (1,'Alternative'),(2,'Anime'),(3,'Blues'),(4,'Children’s Music'),(5,'Classical'),(6,'Comedy'),(7,'Commercial'),(8,'Country'),(9,'Dance '),(10,'Disney'),(12,'Easy Listening'),(11,'Electronic'),(13,'Enka'),(17,'Fitness & Workout'),(14,'French Pop'),(15,'German Folk'),(16,'German Pop'),(18,'Hip-Hop/Rap'),(19,'Holiday'),(20,'Indie Pop'),(21,'Industrial'),(22,'Inspirational – Christian & Gospel'),(23,'Instrumental'),(24,'J-Pop'),(25,'Jazz'),(26,'K-Pop'),(27,'Karaoke'),(28,'Kayokyoku'),(29,'Latin'),(30,'New Age'),(31,'Opera'),(32,'Pop'),(33,'R&B/Soul'),(34,'Reggae'),(35,'Rock'),(36,'Singer/Songwriter'),(37,'Soundtrack'),(38,'Spoken Word'),(39,'Tex-Mex / Tejano '),(40,'Vocal'),(41,'World');
/*!40000 ALTER TABLE `genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genres_types`
--

DROP TABLE IF EXISTS `genres_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genres_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `FK_genre_type_genres_idx` (`genre_id`),
  CONSTRAINT `FK_genre_type_genres` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genres_types`
--

LOCK TABLES `genres_types` WRITE;
/*!40000 ALTER TABLE `genres_types` DISABLE KEYS */;
INSERT INTO `genres_types` VALUES (1,1,'Art Punk'),(2,1,'Alternative Rock'),(3,1,'College Rock'),(4,1,'Experimental Rock'),(5,1,'Goth / Gothic Rock'),(6,1,'Grunge'),(7,1,'Hardcore Punk'),(8,1,'Hard Rock'),(9,1,'Indie Rock'),(10,1,'Lo-fi'),(11,1,'New Wave'),(12,1,'Progressive Rock'),(13,1,'Punk'),(14,1,'Shoegaze'),(15,1,'Steampunk '),(16,3,'Acoustic Blues'),(17,3,'Chicago Blues'),(18,3,'Classic Blues'),(19,3,'Contemporary Blues'),(20,3,'Country Blues'),(21,3,'Delta Blues'),(22,3,'Electric Blues'),(23,4,'Lullabies'),(24,4,'Sing-Along'),(25,4,'Stories'),(26,5,'Avant-Garde'),(27,5,'Baroque'),(28,5,'Chamber Music'),(29,5,'Chant'),(30,5,'Choral'),(31,5,'Classical Crossover'),(32,5,'Early Music'),(33,5,'High Classical'),(34,5,'Impressionist'),(35,5,'Medieval'),(36,5,'Minimalism'),(37,5,'Modern Composition'),(38,5,'Opera'),(39,5,'Orchestral'),(40,5,'Renaissance'),(41,5,'Romantic'),(42,5,'Wedding Music'),(43,6,'Novelty'),(44,6,'Standup Comedy'),(45,6,'Vaudeville '),(46,7,'Jingles'),(47,7,'TV Themes'),(48,8,'Alternative Country'),(49,8,'Americana'),(50,8,'Bluegrass'),(51,8,'Contemporary Bluegrass'),(52,8,'Contemporary Country'),(53,8,'Country Gospel'),(54,8,'Country Pop'),(55,8,'Honky Tonk'),(56,8,'Outlaw Country'),(57,8,'Traditional Bluegrass'),(58,8,'Traditional Country'),(59,8,'Urban Cowboy'),(60,12,'Bop'),(61,12,'Lounge'),(62,12,'Swing'),(63,11,'Club / Club Dance'),(64,11,'Breakbeat'),(65,11,'Brostep '),(66,11,'Deep House'),(67,11,'Dubstep'),(68,11,'Electro House '),(69,11,'Exercise'),(70,11,'Garage'),(71,11,'Glitch Hop'),(72,11,'Hardcore'),(73,11,'Hard Dance'),(74,11,'Hi-NRG / Eurodance'),(75,11,'House'),(76,11,'Jackin House'),(77,11,'Jungle / Drum’n’bass'),(78,11,'Regstep '),(79,11,'Techno'),(80,11,'Trance'),(81,11,'Trap '),(82,11,'8bit – aka 8-bit, Bitpop and Chiptune '),(83,11,'Ambient'),(84,11,'Bassline '),(85,11,'Chiptune '),(86,11,'Crunk '),(87,11,'Downtempo'),(88,11,'Drum & Bass '),(89,11,'Electro'),(90,11,'Electro-swing'),(91,11,'Electronica'),(92,11,'Electronic Rock'),(93,11,'Hardstyle '),(94,11,'IDM/Experimental'),(95,11,'Industrial'),(96,11,'Trip Hop');
/*!40000 ALTER TABLE `genres_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `date_created` datetime NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `dislikes` int(11) NOT NULL DEFAULT '0',
  `songs_count` int(11) NOT NULL DEFAULT '0',
  `description` varchar(200) DEFAULT NULL,
  `is_private` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_playlist_users_idx` (`user_id`),
  CONSTRAINT `FK_playlist_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlists`
--

LOCK TABLES `playlists` WRITE;
/*!40000 ALTER TABLE `playlists` DISABLE KEYS */;
INSERT INTO `playlists` VALUES (1,1,'yes_title','2015-05-05 00:21:14',0,0,0,'ohooo description','\0'),(2,1,'2 title','2015-05-05 00:24:38',0,0,0,'',''),(10,1,'333','2015-05-05 02:23:06',0,0,0,'33','\0'),(12,1,'555','2015-05-05 02:23:13',0,0,0,'55','\0'),(44,1,'das','2015-05-06 16:56:54',0,0,0,'','\0'),(45,2,'1st','2015-05-06 17:15:59',0,0,0,'descr 1','\0'),(46,1,'DD_Private-palylist','2015-05-06 18:59:22',0,0,0,'dsa',''),(48,1,'3v','2015-05-07 16:05:15',0,0,0,'','\0'),(49,1,'да да №','2015-05-07 16:13:47',0,0,0,'','\0'),(50,1,'3d','2015-05-07 16:32:18',0,0,0,'','\0'),(51,2,'gg Private playlist','2015-05-07 23:55:11',0,0,0,'bla-bla',''),(52,1,'songggggggg','2015-05-08 19:03:53',0,0,0,NULL,'\0');
/*!40000 ALTER TABLE `playlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlists_comments`
--

DROP TABLE IF EXISTS `playlists_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlists_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_playlist_comments_users_idx` (`user_id`),
  KEY `FK_playlist_comments_playlists_idx` (`playlist_id`),
  CONSTRAINT `FK_playlist_comments_playlists` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_playlist_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlists_comments`
--

LOCK TABLES `playlists_comments` WRITE;
/*!40000 ALTER TABLE `playlists_comments` DISABLE KEYS */;
INSERT INTO `playlists_comments` VALUES (1,1,1,'Hello FIrst user comments','2015-05-05 00:00:00'),(2,10,2,'12dsaasdas','2015-05-08 01:13:28'),(3,10,2,'ssssssss','2015-05-08 01:15:55'),(4,10,2,'123','2015-05-08 01:18:45'),(5,1,2,'да ама не :)','2015-05-08 01:19:55'),(6,1,2,'ссссс','2015-05-08 01:20:10'),(7,45,2,'gg coments his playlist','2015-05-09 17:54:42');
/*!40000 ALTER TABLE `playlists_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `songs`
--

DROP TABLE IF EXISTS `songs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `artist` varchar(45) NOT NULL,
  `album` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `playlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `file_name` varchar(256) NOT NULL,
  `date_added` datetime NOT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `genre_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_songs_playlists_idx` (`playlist_id`),
  KEY `FK_songs_users_idx` (`user_id`),
  KEY `FK_songs_genres_idx` (`genre_id`),
  KEY `FK_songs_genre_types_idx` (`genre_type_id`),
  CONSTRAINT `FK_songs_genre_types` FOREIGN KEY (`genre_type_id`) REFERENCES `genres_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_songs_genres` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_songs_playlists` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_songs_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `songs`
--

LOCK TABLES `songs` WRITE;
/*!40000 ALTER TABLE `songs` DISABLE KEYS */;
INSERT INTO `songs` VALUES (1,'Uknow title','Uknown','Uknown album','123:32',1,1,0,0,'song1.MP3','2015-05-07 00:00:00',1,NULL),(3,'Niton (The Reason)_','Eric Prydz',NULL,'1:55',1,1,0,0,'song2.MP3','2015-03-02 12:32:15',5,NULL),(4,'yyy','dddd','123','',2,1,0,0,'song2.MP3','2015-02-01 00:00:00',1,1),(13,'dsadsa','12d','1d11','',12,1,0,0,'song2.MP3','2015-05-09 00:31:49',1,1),(14,'dasd','12d1','d12','',12,1,0,0,'song2.MP3','2015-05-09 00:35:16',1,1),(15,'eeeeeeeeeddeeee','asdas','dqq','NULL',12,1,0,0,'song2.MP3','2015-05-09 00:47:59',1,1),(16,'empty string','\"\"','','',12,1,0,0,'song2.MP3','2015-05-09 00:49:07',1,1),(17,'null','null','null','',12,1,0,0,'song2.MP3','2015-05-09 00:51:39',NULL,1),(19,'Hello ther playlist 12','Cool artist','Fucked Album','',12,1,0,0,'song2.MP3','2015-05-09 01:25:12',NULL,NULL);
/*!40000 ALTER TABLE `songs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `songs_comments`
--

DROP TABLE IF EXISTS `songs_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `songs_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `song_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_songs_comments_users_idx` (`user_id`),
  KEY `FK_songs_comments_songs_idx` (`song_id`),
  CONSTRAINT `FK_songs_comments_songs` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_songs_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `songs_comments`
--

LOCK TABLES `songs_comments` WRITE;
/*!40000 ALTER TABLE `songs_comments` DISABLE KEYS */;
INSERT INTO `songs_comments` VALUES (1,1,1,'1111111111111','2015-05-08 15:18:33'),(2,1,1,'new Comment :)))','2015-05-08 16:13:36');
/*!40000 ALTER TABLE `songs_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `passwordHash` varchar(128) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'dd','$2y$10$O3b5AoiTr01lZhrwX.83WuNxQ21sfPKrLSsTHV8RPxWYnoFuYRyr6','dodi','dd@dd',''),(2,'gg','$2y$10$BhqBrGVI4plDPuzjbU0dseZSLNlVuKn6DvWO1uixwZXYGQwWaQMCW','ggf','gg@gg','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_playlist_ranks`
--

DROP TABLE IF EXISTS `users_playlist_ranks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_playlist_ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `is_like` bit(1) NOT NULL DEFAULT b'0',
  `is_dislike` bit(1) NOT NULL DEFAULT b'0',
  `date_ranked` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_id_playlist_id_index` (`playlist_id`,`user_id`),
  KEY `FK_users_playlist_rank_users_idx` (`user_id`),
  KEY `FK_users_playlist_rank_playlist_idx` (`playlist_id`),
  CONSTRAINT `FK_users_playlist_rank_playlist` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_users_playlist_rank_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_playlist_ranks`
--

LOCK TABLES `users_playlist_ranks` WRITE;
/*!40000 ALTER TABLE `users_playlist_ranks` DISABLE KEYS */;
INSERT INTO `users_playlist_ranks` VALUES (1,1,1,'','\0','2015-05-09 17:34:47'),(2,1,2,'\0','','2015-03-12 00:00:00'),(3,1,10,'\0','','2015-01-03 00:00:00'),(4,2,1,'','\0','2015-04-04 00:00:00'),(6,2,44,'','\0','2015-05-09 17:11:10'),(8,1,44,'\0','','2015-05-09 17:34:13'),(11,2,45,'','\0','2015-05-09 17:54:55'),(12,2,51,'\0','','2015-05-09 17:55:14');
/*!40000 ALTER TABLE `users_playlist_ranks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_songs_ranks`
--

DROP TABLE IF EXISTS `users_songs_ranks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_songs_ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `is_like` bit(1) NOT NULL DEFAULT b'0',
  `is_dislike` bit(1) NOT NULL DEFAULT b'0',
  `date_ranked` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_user_id_songs_song_id` (`song_id`,`user_id`),
  KEY `FK_users_songs_rank_user_idx` (`user_id`),
  KEY `FK_users_songs_rank_songs_idx` (`song_id`),
  CONSTRAINT `FK_users_songs_rank_songs` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_users_songs_rank_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_songs_ranks`
--

LOCK TABLES `users_songs_ranks` WRITE;
/*!40000 ALTER TABLE `users_songs_ranks` DISABLE KEYS */;
INSERT INTO `users_songs_ranks` VALUES (1,1,3,'\0','','2015-05-09 19:10:10'),(4,1,1,'','\0','2015-05-09 19:09:20');
/*!40000 ALTER TABLE `users_songs_ranks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-10  2:07:39
