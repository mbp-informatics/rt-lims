CREATE TABLE `es_cells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_vial_id` int(11) DEFAULT NULL,
  `dna` int(11) DEFAULT NULL,
  `frozen_date` date DEFAULT NULL,
  `frozen_by` varchar(50) DEFAULT NULL,
  `passage` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `disposal_date` date DEFAULT NULL,
  `disposal_by` varchar(50) DEFAULT NULL,
  `item_id_no` int(11) DEFAULT NULL,
  `content` tinyint(2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `mra_treated` tinyint(2) DEFAULT NULL,
  `myco_pos` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kompvialid` int(11) DEFAULT NULL,
  `komp_clones_dump_id` int(11) DEFAULT NULL,
  `location` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `kompvial` (`kompvialid`) USING BTREE,
  KEY `inventory_vial_id` (`inventory_vial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1017359 DEFAULT CHARSET=latin1;


