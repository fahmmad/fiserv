# Create databases
CREATE DATABASE IF NOT EXISTS `fiserv`;
#CREATE DATABASE IF NOT EXISTS `fiserv_testing`;

# Create user
CREATE USER 'root'@'localhost' IDENTIFIED BY 'root';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';

# Create Tables
Use `fiserv`;

CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(10) unsigned DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `iditems_UNIQUE` (`id`),
  CONSTRAINT `parentKey` FOREIGN KEY (`parent`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COMMENT='A table that contains the files and folder items';
