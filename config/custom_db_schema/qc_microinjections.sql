CREATE TABLE `qc_microinjections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_vial_id` int(11) DEFAULT NULL,
  `started` date DEFAULT NULL,
  `finished` date DEFAULT NULL,
  `started_by` varchar(50) DEFAULT NULL,
  `finished_by` varchar(50) DEFAULT NULL,
  `pass` tinyint(2) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `npups` int(2) DEFAULT NULL,
  `nmale` int(2) DEFAULT NULL,
  `chimerism` int(3) DEFAULT NULL,
  `max_chimerism` int(3) DEFAULT NULL,
  `number_injected` tinyint(2) DEFAULT NULL,
  `bl` varchar(10) DEFAULT NULL,
  `parent_strain` tinyint(2) DEFAULT NULL,
  `number_pups_born` tinyint(2) DEFAULT NULL,
  `injection_type` tinyint(2) DEFAULT NULL,
  `number_recipients` int(11) DEFAULT NULL,
  `number_litters` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime DEFAULT NULL,
  `kompvialid` int(11) DEFAULT NULL,
  `quality_control_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `strainID_fk` (`parent_strain`) USING BTREE,
  KEY `microinjectionStarted_fk` (`started_by`) USING BTREE,
  KEY `microinjectionFinished_fk` (`finished_by`) USING BTREE,
  KEY `microinjectionVial_fk` (`inventory_vial_id`) USING BTREE,
  KEY `qc_microinjectionPassID_fk` (`pass`) USING BTREE,
  KEY `injectionTypeID_fk` (`injection_type`) USING BTREE,
  KEY `vial` (`inventory_vial_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4096 DEFAULT CHARSET=latin1;

