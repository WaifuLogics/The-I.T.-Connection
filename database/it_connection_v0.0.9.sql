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

-- Dumping data for table it_connection.accounts: ~7 rows (approximately)
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`account_id`, `account_name`, `user_id`, `user_password`) VALUES
	('account_-1000', 'admin', 'user_-580', '$2y$10$TZTF91HfEASb2jElgpLIDOAcO3unfcpLgchkeWMwt2KNwtHhxFwEG'),
	('account_-199', 'GroteBitch', 'user_-945', '$2y$10$JjXNzLTAwowuNXCuMu.P..ZM018vrAo70rpYM3JwFy0nesGe8eGCm'),
	('account_-262', 'OxygenDaemon', 'user_281', '$2y$10$Jc/MzouLJc3NXL2zqX8RuuF..50VqEqPJ.bMq86hr4ryUvktRDl6K'),
	('account_-402', '11', 'user_758', '$2y$10$NFxIMko3sP1OPzfBFrkS1uxPjnDi9T210iCsEdEWuihsPI8TYuEPm'),
	('account_-847', 'kankerwolf', 'user_-112', '$2y$10$ExmelLrfzkSoZYueL7/OuOG75b3HSA54jQyU/obqFiffYqSSkf5Fi'),
	('account_270', '12', 'user_404', '$2y$10$1vvrQMVV0f17wc916zKhoe6xJOvIVpmwXkNtq43eoIjjdivikb/NS'),
	('account_953', 'The Big Gay', 'user_-145', '$2y$10$FcP5dqu/QD2fAEnry47Mve36ERQR/N1SasjUDr7ZcnmSlIfNQ3JUe');
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

-- Dumping structure for table it_connection.authorization
CREATE TABLE IF NOT EXISTS `authorization` (
  `auth_code` longtext,
  `auth_user` varchar(200) DEFAULT NULL,
  `auth_username` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `auth_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.authorization: ~0 rows (approximately)
/*!40000 ALTER TABLE `authorization` DISABLE KEYS */;
/*!40000 ALTER TABLE `authorization` ENABLE KEYS */;

-- Dumping structure for table it_connection.chat_participants
CREATE TABLE IF NOT EXISTS `chat_participants` (
  `account_id` varchar(255) DEFAULT NULL,
  `chat_room_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.chat_participants: ~0 rows (approximately)
/*!40000 ALTER TABLE `chat_participants` DISABLE KEYS */;
INSERT INTO `chat_participants` (`account_id`, `chat_room_id`) VALUES
	('account_270', 'chat_69'),
	('accoun_-1000', 'chat_69');
/*!40000 ALTER TABLE `chat_participants` ENABLE KEYS */;

-- Dumping structure for table it_connection.chat_room_messages
CREATE TABLE IF NOT EXISTS `chat_room_messages` (
  `chat_message_id` varchar(255) NOT NULL,
  `chat_room_id` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `chat_message` longtext NOT NULL,
  `chat_date` varchar(50) NOT NULL,
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
  `account_id` varchar(255) DEFAULT NULL,
  `account_friended` varchar(255) DEFAULT NULL,
  `friends_since` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.friends: ~0 rows (approximately)
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;

-- Dumping structure for table it_connection.friend_request
CREATE TABLE IF NOT EXISTS `friend_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `current_user_id` varchar(255) DEFAULT NULL,
  `other_user_id` varchar(255) DEFAULT NULL,
  `friend_requester` varchar(255) DEFAULT NULL,
  `request_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.friend_request: ~0 rows (approximately)
/*!40000 ALTER TABLE `friend_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `friend_request` ENABLE KEYS */;

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

-- Dumping structure for table it_connection.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` varchar(255) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `project_link` varchar(255) DEFAULT NULL,
  `project_creator` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.projects: ~7 rows (approximately)
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`project_id`, `project_name`, `project_link`, `project_creator`) VALUES
	('1528718017', '12', 'adm', 'account_270'),
	('1528718021', '123', '312', 'account_270'),
	('1528718023', '543345', '345345', 'account_270'),
	('1528718051', '12', '12', 'account_270'),
	('1528718145', '12', '12', 'account_270'),
	('1528718191', '12', '12', 'account_270'),
	('1528720191', '21', '12', 'account_270');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Dumping structure for table it_connection.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.users: ~8 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`) VALUES
	('user_-112', 'unset', 'unset', 'jemoeder@gmail.com'),
	('user_-145', 'unset', 'unset', 'TheBigGay@Yahoo.com'),
	('user_-580', 'unset', 'unset', 'guylianwashier@gmail.com'),
	('user_-878', 'unset', 'unset', 'kankerhoer@fuckyou.nl'),
	('user_-945', 'unset', 'unset', 'kankerslet@fuckyou.nl'),
	('user_281', 'unset', 'unset', 'pcvl.janssen@gmail.com'),
	('user_404', 'unset', 'unset', '12@12.com'),
	('user_758', 'unset', 'unset', '11@11.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
