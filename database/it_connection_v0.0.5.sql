-- --------------------------------------------------------
-- Host:                         localhost
-- Server versie:                5.7.19 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Versie:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Databasestructuur van it_connection wordt geschreven
CREATE DATABASE IF NOT EXISTS `it_connection` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `it_connection`;

-- Structuur van  tabel it_connection.accounts wordt geschreven
CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_password` longtext NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.accounts: ~1 rows (ongeveer)
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`account_id`, `account_name`, `user_id`, `user_password`) VALUES
	('account_-1000', 'admin', 'user_-580', '$2y$10$TZTF91HfEASb2jElgpLIDOAcO3unfcpLgchkeWMwt2KNwtHhxFwEG'),
	('account_270', '12', 'user_404', '$2y$10$1vvrQMVV0f17wc916zKhoe6xJOvIVpmwXkNtq43eoIjjdivikb/NS');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

-- Structuur van  tabel it_connection.account_permissions wordt geschreven
CREATE TABLE IF NOT EXISTS `account_permissions` (
  `account_name` varchar(255) NOT NULL,
  `permission_name` varchar(120) NOT NULL,
  PRIMARY KEY (`account_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.account_permissions: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `account_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_permissions` ENABLE KEYS */;

-- Structuur van  tabel it_connection.authorization wordt geschreven
CREATE TABLE IF NOT EXISTS `authorization` (
  `auth_code` longtext,
  `auth_user` varchar(200) DEFAULT NULL,
  `auth_username` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `auth_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.authorization: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `authorization` DISABLE KEYS */;
/*!40000 ALTER TABLE `authorization` ENABLE KEYS */;

-- Structuur van  tabel it_connection.chat_participants wordt geschreven
CREATE TABLE IF NOT EXISTS `chat_participants` (
  `account_name` varchar(255) DEFAULT NULL,
  `chat_room_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.chat_participants: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `chat_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_participants` ENABLE KEYS */;

-- Structuur van  tabel it_connection.chat_rooms wordt geschreven
CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `chat_room_id` varchar(255) NOT NULL,
  PRIMARY KEY (`chat_room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.chat_rooms: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `chat_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_rooms` ENABLE KEYS */;

-- Structuur van  tabel it_connection.chat_room_attachments wordt geschreven
CREATE TABLE IF NOT EXISTS `chat_room_attachments` (
  `attachment_id` varchar(255) NOT NULL,
  `chat_room_id` varchar(255) NOT NULL,
  `chat_message_id` varchar(255) NOT NULL,
  `attachment_path` text NOT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.chat_room_attachments: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `chat_room_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_room_attachments` ENABLE KEYS */;

-- Structuur van  tabel it_connection.chat_room_messages wordt geschreven
CREATE TABLE IF NOT EXISTS `chat_room_messages` (
  `chat_message_id` varchar(255) NOT NULL,
  `chat_room_id` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `chat_message` longtext NOT NULL,
  `chat_date` datetime NOT NULL,
  PRIMARY KEY (`chat_message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.chat_room_messages: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `chat_room_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_room_messages` ENABLE KEYS */;

-- Structuur van  tabel it_connection.forum_post wordt geschreven
CREATE TABLE IF NOT EXISTS `forum_post` (
  `post_id` varchar(255) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.forum_post: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `forum_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_post` ENABLE KEYS */;

-- Structuur van  tabel it_connection.friends wordt geschreven
CREATE TABLE IF NOT EXISTS `friends` (
  `account_name` varchar(255) DEFAULT NULL,
  `account_friended` varchar(255) DEFAULT NULL,
  `friends_since` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.friends: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;

-- Structuur van  tabel it_connection.friend_request wordt geschreven
CREATE TABLE IF NOT EXISTS `friend_request` (
  `current_user_id` varchar(255) DEFAULT NULL,
  `other_user_id` varchar(255) DEFAULT NULL,
  `request_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.friend_request: ~1 rows (ongeveer)
/*!40000 ALTER TABLE `friend_request` DISABLE KEYS */;
INSERT INTO `friend_request` (`current_user_id`, `other_user_id`, `request_time`) VALUES
	('account_-1000', 'account_270', '2018-06-02 15:22:20');
/*!40000 ALTER TABLE `friend_request` ENABLE KEYS */;

-- Structuur van  tabel it_connection.permissions wordt geschreven
CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_name` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.permissions: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Structuur van  tabel it_connection.posts wordt geschreven
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` varchar(255) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `post_text` longtext NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.posts: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Structuur van  tabel it_connection.posts_attachments wordt geschreven
CREATE TABLE IF NOT EXISTS `posts_attachments` (
  `post_id` varchar(255) DEFAULT NULL,
  `attachment_id` varchar(255) DEFAULT NULL,
  `attachment_path` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.posts_attachments: ~0 rows (ongeveer)
/*!40000 ALTER TABLE `posts_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_attachments` ENABLE KEYS */;

-- Structuur van  tabel it_connection.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumpen data van tabel it_connection.users: ~5 rows (ongeveer)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`) VALUES
	('user_-278', 'unset', 'unset', '123@123'),
	('user_-580', 'unset', 'unset', 'guylianwashier@gmail.com'),
	('user_404', 'unset', 'unset', '12@12.com'),
	('user_417', 'unset', 'unset', 'admin@admin.nl'),
	('user_419', 'unset', 'unset', '123@321');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
