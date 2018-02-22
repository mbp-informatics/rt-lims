CREATE TABLE `mgi_genes_dump` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mgi_accession_id` varchar(255) DEFAULT NULL,
  `chr` varchar(255) DEFAULT NULL,
  `cm_position` varchar(255) DEFAULT NULL,
  `genome_coord_start` int(11) DEFAULT NULL,
  `genome_coord_end` int(11) DEFAULT NULL,
  `strand` varchar(255) DEFAULT NULL,
  `marker_symbol` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `marker_name` varchar(255) DEFAULT NULL,
  `marker_type` varchar(255) DEFAULT NULL,
  `feature_type` varchar(255) DEFAULT NULL,
  `marker_synonyms` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mgi_id_index` (`mgi_accession_id`)
) ENGINE=InnoDB AUTO_INCREMENT=299493 DEFAULT CHARSET=utf8;

