CREATE TABLE `komp_vials_dump` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gene` varchar(255) DEFAULT NULL,
  `komp_gene_id` int(11) DEFAULT NULL,
  `komp_vial_id` int(11) DEFAULT NULL,
  `komp_order_id` int(11) DEFAULT NULL,
  `clone_name` varchar(255) DEFAULT NULL,
  `clone_nickname` varchar(255) DEFAULT NULL,
  `mouse_clone_id` int(11) DEFAULT NULL,
  `mutation` varchar(255) DEFAULT NULL,
  `mutation_id_no` varchar(255) DEFAULT NULL,
  `cell_line` varchar(255) DEFAULT NULL,
  `mgi_accession_id` varchar(255) DEFAULT NULL,
  `epd` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `clone_name` (`clone_name`),
  KEY `gene` (`gene`),
  KEY `komp_vial_id` (`komp_vial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=961108 DEFAULT CHARSET=utf8;

