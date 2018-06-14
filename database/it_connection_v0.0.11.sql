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

-- Dumping data for table it_connection.accounts: ~9 rows (approximately)
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`account_id`, `account_name`, `user_id`, `user_password`) VALUES
	('account_-1000', 'admin', 'user_-580', '$2y$10$TZTF91HfEASb2jElgpLIDOAcO3unfcpLgchkeWMwt2KNwtHhxFwEG'),
	('account_-262', 'OxygenDaemon', 'user_281', '$2y$10$Jc/MzouLJc3NXL2zqX8RuuF..50VqEqPJ.bMq86hr4ryUvktRDl6K'),
	('account_-396', 'JeOma', 'user_-183', '$2y$10$3TyHdY.cEchRpQHvG3pq6ePOFibAocl9g0AJeNgjMPkavB9LG3KSG'),
	('account_-402', '11', 'user_758', '$2y$10$NFxIMko3sP1OPzfBFrkS1uxPjnDi9T210iCsEdEWuihsPI8TYuEPm'),
	('account_-614', 'duncte123', 'user_184', '$2y$10$6hcowsn2tsIX4.ONgbXFoeTQDGtLrs/C/jUdvC.CQHnuyWTr6smv.'),
	('account_-847', 'kankerwolf', 'user_-112', '$2y$10$ExmelLrfzkSoZYueL7/OuOG75b3HSA54jQyU/obqFiffYqSSkf5Fi'),
	('account_270', '12', 'user_404', '$2y$10$1vvrQMVV0f17wc916zKhoe6xJOvIVpmwXkNtq43eoIjjdivikb/NS'),
	('account_617', 'ikneukjekutsletindrkont', 'user_507', '$2y$10$IkPSirRB7iBVWsyMAx.Gsen9pH2BtrVghnmwX7UiUG.P/IBRZAXsO'),
	('account_805', 'Jeremey', 'user_314', '$2y$10$JhEbQ5c9lFxzUBFRMxUwmeRKvwRch7bMn7eKQCR2ITAaXD8Q4F7ri');
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
INSERT INTO `authorization` (`auth_code`, `auth_user`, `auth_username`, `user_password`, `auth_time`) VALUES
	('642', 'user_-615', 'ikpakje', '$2y$10$fyXdz9xzpmDepmAPigvfCeCI9XreI8jWF3Gn8JdXZuAsU2SvRCGIy', 1528960551);
/*!40000 ALTER TABLE `authorization` ENABLE KEYS */;

-- Dumping structure for table it_connection.chat_participants
CREATE TABLE IF NOT EXISTS `chat_participants` (
  `account_id` varchar(255) DEFAULT NULL,
  `chat_room_id` varchar(255) DEFAULT NULL,
  `chat_room_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.chat_participants: ~2 rows (approximately)
/*!40000 ALTER TABLE `chat_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_participants` ENABLE KEYS */;

-- Dumping structure for table it_connection.chat_room_messages
CREATE TABLE IF NOT EXISTS `chat_room_messages` (
  `chat_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_room_id` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `chat_message` text NOT NULL,
  `chat_date` varchar(50) NOT NULL,
  PRIMARY KEY (`chat_message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.chat_room_messages: ~15 rows (approximately)
/*!40000 ALTER TABLE `chat_room_messages` DISABLE KEYS */;
INSERT INTO `chat_room_messages` (`chat_message_id`, `chat_room_id`, `account_name`, `chat_message`, `chat_date`) VALUES
	(16, 'chat_666', 'duncte123', '![](https://catalogs.seacommerce.nl/versop/images/vers-van-het-mes-oud-zk.png)', '1528960480096'),
	(23, 'chat_666', 'Jeremey', '![alt](https://static2.fjcdn.com/thumbnails/comments/Quotyarhar+fiddle+with+me+quot+_5ac2652ed7026dea5f7c6338df2734e1.png)', '1528960770068'),
	(25, 'chat_666', 'Jeremey', '![alt](http://www.roc-teraa.nl/wp-content/uploads/2015/06/ROC-logo-roc-ter-aa-helmond-RGB.jpg)', '1528960858270'),
	(26, 'chat_666', 'Jeremey', '![alt](https://smhttp-ssl-15863.nexcesscdn.net/images/product/TrainingModels/ft%20Automated%20High%20Bay%20Warehouse%2024V_18.jpg)', '1528961078709'),
	(31, 'chat_666', 'Jeremey', '![alt](https://smhttp-ssl-15863.nexcesscdn.net/images/product/TrainingModels/ft%20Automated%20High%20Bay%20Warehouse%2024V_18.jpg)', '1528961136884'),
	(34, 'chat_666', 'Jeremey', '![alt](https://smhttp-ssl-15863.nexcesscdn.net/images/product/TrainingModels/ft%20Automated%20High%20Bay%20Warehouse%2024V_18.jpg)', '1528961156653'),
	(35, 'chat_666', 'JeOma', '![alt](https://i.imgur.com/nXBM8CM.png)', '1528961186425'),
	(38, 'chat_666', 'JeOma', '![alt](https://i.pinimg.com/originals/f0/87/4c/f0874c4ba69ec80fb0f2b5fe33ef9b7c.jpg)', '1528961311025'),
	(39, 'chat_666', 'Jeremey', '![alt](data:image/jpeg;base64,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)', '1528961329262'),
	(41, 'chat_666', 'JeOma', '![alt](https://cdn.shopify.com/s/files/1/1570/6523/products/Guylian_Milk_large.jpg?v=1479796013)', '1528961353032'),
	(43, 'chat_666', 'JeOma', '![alt](https://lh5.googleusercontent.com/-MVHvS0C0DZU/AAAAAAAAAAI/AAAAAAAADss/BP38sPL54BE/il/photo.jpg)', '1528961375872'),
	(44, 'chat_666', 'Jeremey', '![alt](https://cdn.discordapp.com/emojis/402425232998268928.png?v=1)', '1528961417402'),
	(45, 'chat_666', 'JeOma', '![alt](https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQS9zos68VDSKFtg1xS4ihslJ7O1If1b19WdlQCXYPz0zNmvLJv0w)', '1528961417426'),
	(46, 'chat_666', 'JeOma', '![alt](data:image/jpeg;base64,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)', '1528961728802'),
	(52, 'chat_666', 'JeOma', '![alt](https://www.youtube.com/watch?v=VmCRARcZNvY)', '1528961792314');
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

-- Dumping data for table it_connection.friends: ~4 rows (approximately)
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` (`account_id`, `account_friended`, `friends_since`) VALUES
	('account_-402', 'account_270', '2018-06-12 08:18:36'),
	('account_-1000', 'account_270', '2018-06-12 08:45:57'),
	('account_-614', 'account_-1000', '2018-06-12 13:24:48'),
	('account_-1000', 'account_-262', '2018-06-12 13:25:30');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;

-- Dumping structure for table it_connection.friend_request
CREATE TABLE IF NOT EXISTS `friend_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `current_user_id` varchar(255) DEFAULT NULL,
  `other_user_id` varchar(255) DEFAULT NULL,
  `friend_requester` varchar(255) DEFAULT NULL,
  `request_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.friend_request: ~2 rows (approximately)
/*!40000 ALTER TABLE `friend_request` DISABLE KEYS */;
INSERT INTO `friend_request` (`id`, `current_user_id`, `other_user_id`, `friend_requester`, `request_time`) VALUES
	(3, 'account_-262', 'account_953', 'OxygenDaemon', '2018-06-12 13:15:55'),
	(6, 'account_-614', 'account_270', 'duncte123', '2018-06-14 09:07:28');
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
	('1528718017', '12', 'adm', 'account_270');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Dumping structure for table it_connection.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table it_connection.users: ~9 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`) VALUES
	('user_-112', 'unset', 'unset', 'jemoeder@gmail.com'),
	('user_-183', 'unset', 'unset', 'kankerhoer@kutneger.nl'),
	('user_-580', 'unset', 'unset', 'guylianwashier@gmail.com'),
	('user_184', 'unset', 'unset', 'contact@duncte123.me'),
	('user_281', 'unset', 'unset', 'pcvl.janssen@gmail.com'),
	('user_314', 'unset', 'unset', 'jeomaa@gmail.com'),
	('user_404', 'unset', 'unset', '12@12.com'),
	('user_507', 'unset', 'unset', 'ikneukjekutsletindrkont@gmail.com'),
	('user_758', 'unset', 'unset', '11@11.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
