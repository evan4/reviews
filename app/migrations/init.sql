CREATE TABLE `imy_migration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` DATE default '1990-01-01',
  `num` INT NOT NULL default 1,
  `cdate` DATETIME default '1990-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
