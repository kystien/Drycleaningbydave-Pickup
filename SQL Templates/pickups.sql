SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `pickups` (
`id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `Name` varchar(55) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `City` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `phone` bigint(20) NOT NULL,
  `Type` varchar(55) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `request_made` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;


ALTER TABLE `pickups`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);


ALTER TABLE `pickups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
