CREATE TABLE `genotypings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(255) DEFAULT NULL,
  `ivf_id` int(11) DEFAULT NULL,
  `sperm_cryo_id` int(11) DEFAULT NULL,
  `embryo_cryo_id` int(11) DEFAULT NULL,
  `genotype_request_id` int(11) DEFAULT NULL,
  `male_id_no` varchar(50) DEFAULT NULL,
  `genotype` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `embryo_count` int(11) DEFAULT NULL,
  `inventory_location_id` int(11) DEFAULT NULL,
  `vial_label` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `genotype_request_id` (`genotype_request_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3501 DEFAULT CHARSET=latin1;


