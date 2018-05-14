-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for it_connection
CREATE DATABASE IF NOT EXISTS `it_connection` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `it_connection`;

-- Dumping structure for table it_connection.accounts
CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_password` longtext NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.accounts: ~0 rows (approximately)
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

-- Dumping structure for table it_connection.account_permissions
CREATE TABLE IF NOT EXISTS `account_permissions` (
  `account_name` varchar(255) NOT NULL,
  `permission_name` varchar(120) NOT NULL,
  PRIMARY KEY (`account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.account_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `account_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_permissions` ENABLE KEYS */;

-- Dumping structure for table it_connection.chat_participants
CREATE TABLE IF NOT EXISTS `chat_participants` (
  `account_name` varchar(255) DEFAULT NULL,
  `chat_room_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.chat_participants: ~0 rows (approximately)
/*!40000 ALTER TABLE `chat_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_participants` ENABLE KEYS */;

-- Dumping structure for table it_connection.chat_rooms
CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `chat_room_id` varchar(255) NOT NULL,
  PRIMARY KEY (`chat_room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.chat_rooms: ~0 rows (approximately)
/*!40000 ALTER TABLE `chat_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_rooms` ENABLE KEYS */;

-- Dumping structure for table it_connection.chat_room_attachments
CREATE TABLE IF NOT EXISTS `chat_room_attachments` (
  `attachment_id` varchar(255) NOT NULL,
  `chat_room_id` varchar(255) NOT NULL,
  `chat_message_id` varchar(255) NOT NULL,
  `attachment_path` longtext NOT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.chat_room_attachments: ~0 rows (approximately)
/*!40000 ALTER TABLE `chat_room_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_room_attachments` ENABLE KEYS */;

-- Dumping structure for table it_connection.chat_room_messages
CREATE TABLE IF NOT EXISTS `chat_room_messages` (
  `chat_message_id` varchar(255) NOT NULL,
  `chat_room_id` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `chat_message` longtext NOT NULL,
  `chat_date` datetime NOT NULL,
  PRIMARY KEY (`chat_message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.chat_room_messages: ~0 rows (approximately)
/*!40000 ALTER TABLE `chat_room_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_room_messages` ENABLE KEYS */;

-- Dumping structure for table it_connection.forum_post
CREATE TABLE IF NOT EXISTS `forum_post` (
  `post_id` varchar(255) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.forum_post: ~0 rows (approximately)
/*!40000 ALTER TABLE `forum_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_post` ENABLE KEYS */;

-- Dumping structure for table it_connection.friends
CREATE TABLE IF NOT EXISTS `friends` (
  `account_name` varchar(255) DEFAULT NULL,
  `account_friended` varchar(255) DEFAULT NULL,
  `friends_since` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.friends: ~0 rows (approximately)
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;

-- Dumping structure for table it_connection.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_name` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table it_connection.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` varchar(255) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `post_text` longtext NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.posts: ~0 rows (approximately)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Dumping structure for table it_connection.posts_attachments
CREATE TABLE IF NOT EXISTS `posts_attachments` (
  `post_id` varchar(255) DEFAULT NULL,
  `attachment_id` varchar(255) DEFAULT NULL,
  `attachment_path` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.posts_attachments: ~0 rows (approximately)
/*!40000 ALTER TABLE `posts_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_attachments` ENABLE KEYS */;

-- Dumping structure for table it_connection.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
