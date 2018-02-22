CREATE TABLE `qc_karyotypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_vial_id` int(11) DEFAULT NULL,
  `started` date DEFAULT NULL,
  `finished` date DEFAULT NULL,
  `started_by` varchar(50) DEFAULT NULL,
  `finished_by` varchar(50) DEFAULT NULL,
  `pass` tinyint(2) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `euploid` tinyint(2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kompvialid` int(11) DEFAULT NULL,
  `quality_control_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8490 DEFAULT CHARSET=latin1;

