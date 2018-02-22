CREATE TABLE `qc_tmks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_vial_id` int(11) DEFAULT NULL,
  `started` date DEFAULT NULL,
  `finished` date DEFAULT NULL,
  `started_by` varchar(50) DEFAULT NULL,
  `finished_by` varchar(50) DEFAULT NULL,
  `pass` varchar(25) DEFAULT NULL,
  `comment` text,
  `euploid` varchar(25) DEFAULT NULL,
  `ch1` varchar(25) DEFAULT NULL,
  `ch2` varchar(25) DEFAULT NULL,
  `ch3` varchar(25) DEFAULT NULL,
  `ch4` varchar(25) DEFAULT NULL,
  `ch5` varchar(25) DEFAULT NULL,
  `ch6` varchar(25) DEFAULT NULL,
  `ch7` varchar(25) DEFAULT NULL,
  `ch8` varchar(25) DEFAULT NULL,
  `ch9` varchar(25) DEFAULT NULL,
  `ch10` varchar(25) DEFAULT NULL,
  `ch11` varchar(25) DEFAULT NULL,
  `ch12` varchar(25) DEFAULT NULL,
  `ch13` varchar(25) DEFAULT NULL,
  `ch14` varchar(25) DEFAULT NULL,
  `ch15` varchar(25) DEFAULT NULL,
  `ch16` varchar(25) DEFAULT NULL,
  `ch17` varchar(25) DEFAULT NULL,
  `ch18` varchar(25) DEFAULT NULL,
  `ch19` varchar(25) DEFAULT NULL,
  `chX` varchar(25) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `kompvialid` int(11) DEFAULT NULL,
  `quality_control_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=572 DEFAULT CHARSET=latin1;
