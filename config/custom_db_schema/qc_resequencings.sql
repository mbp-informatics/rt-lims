CREATE TABLE `qc_resequencings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_vial_id` int(11) DEFAULT NULL,
  `started` date DEFAULT NULL,
  `finished` date DEFAULT NULL,
  `started_by` varchar(50) DEFAULT NULL,
  `finished_by` varchar(50) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `comment` text,
  `MGAL_sequence` text,
  `blast_result` text,
  `MGAL_id_location` text,
  `MGAL_expected` text,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `kompvialid` int(11) DEFAULT NULL,
  `quality_control_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=278 DEFAULT CHARSET=latin1;

