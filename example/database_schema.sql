-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.5.20-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2012-05-03 18:35:41
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for jream_test
CREATE DATABASE IF NOT EXISTS `jream_test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `jream_test`;


-- Dumping structure for table jream_test.user
CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10006 DEFAULT CHARSET=utf8;

-- Dumping data for table jream_test.user: ~0 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`userid`, `name`, `data`, `date_added`, `date_modified`) VALUES
	(10000, 'Jesse', '', '2012-05-03 18:34:42', '0000-00-00 00:00:00'),
	(10001, 'Joey', '', '2012-05-03 18:34:42', '0000-00-00 00:00:00'),
	(10002, 'Jenny', '', '2012-05-03 18:34:42', '0000-00-00 00:00:00'),
	(10003, 'Justine', '', '2012-05-03 18:34:42', '0000-00-00 00:00:00'),
	(10004, 'Bob', '', '2012-05-03 18:34:42', '0000-00-00 00:00:00'),
	(10005, 'Becky', '', '2012-05-03 18:34:42', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
