CREATE TABLE `quality_controls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `es_cell_id` int(11) DEFAULT NULL,
  `started` date DEFAULT NULL,
  `finished` date DEFAULT NULL,
  `started_by` varchar(50) DEFAULT NULL,
  `finished_by` varchar(50) DEFAULT NULL,
  `pass` varchar(25) DEFAULT NULL,
  `assigned_qc` varchar(25) DEFAULT NULL,
  `purpose` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17766 DEFAULT CHARSET=latin1;

