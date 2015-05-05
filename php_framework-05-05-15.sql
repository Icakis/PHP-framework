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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlists`
--

LOCK TABLES `playlists` WRITE;
/*!40000 ALTER TABLE `playlists` DISABLE KEYS */;
INSERT INTO `playlists` VALUES (1,1,'yes_title','2015-05-05 00:21:14',0,0,0,'ohooo description',''),(2,1,'2 title','2015-05-05 00:24:38',0,0,0,'',''),(10,1,'333','2015-05-05 02:23:06',0,0,0,'33','\0'),(12,1,'555','2015-05-05 02:23:13',0,0,0,'55','\0'),(15,1,'da123','2015-05-05 03:29:39',0,0,0,'','\0');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlists_comments`
--

LOCK TABLES `playlists_comments` WRITE;
/*!40000 ALTER TABLE `playlists_comments` DISABLE KEYS */;
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
  `artist` varchar(45) NOT NULL,
  `album` varchar(45) DEFAULT NULL,
  `duration` varchar(45) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `source` varchar(256) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `songs`
--

LOCK TABLES `songs` WRITE;
/*!40000 ALTER TABLE `songs` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `songs_comments`
--

LOCK TABLES `songs_comments` WRITE;
/*!40000 ALTER TABLE `songs_comments` DISABLE KEYS */;
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
  `like` bit(1) NOT NULL DEFAULT b'0',
  `dislike` bit(1) NOT NULL DEFAULT b'0',
  `date_ranked` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_users_playlist_rank_users_idx` (`user_id`),
  KEY `FK_users_playlist_rank_playlist_idx` (`playlist_id`),
  CONSTRAINT `FK_users_playlist_rank_playlist` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_users_playlist_rank_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_playlist_ranks`
--

LOCK TABLES `users_playlist_ranks` WRITE;
/*!40000 ALTER TABLE `users_playlist_ranks` DISABLE KEYS */;
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
  `like` bit(1) NOT NULL DEFAULT b'0',
  `dislike` bit(1) NOT NULL DEFAULT b'0',
  `date_ranked` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_users_songs_rank_user_idx` (`user_id`),
  KEY `FK_users_songs_rank_songs_idx` (`song_id`),
  CONSTRAINT `FK_users_songs_rank_songs` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_users_songs_rank_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_songs_ranks`
--

LOCK TABLES `users_songs_ranks` WRITE;
/*!40000 ALTER TABLE `users_songs_ranks` DISABLE KEYS */;
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

-- Dump completed on 2015-05-05  4:37:42
