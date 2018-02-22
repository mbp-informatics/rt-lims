CREATE TABLE `komp_projects_dump` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `komp_id` int(11) DEFAULT NULL,
  `colony_name` varchar(255) DEFAULT NULL,
  `gene` varchar(255) DEFAULT NULL,
  `komp_gene_id` int(11) DEFAULT NULL,
  `clone_name` varchar(255) DEFAULT NULL,
  `clone_nickname` varchar(255) DEFAULT NULL,
  `mouse_clone_id` int(11) DEFAULT NULL,
  `mutation` varchar(255) DEFAULT NULL,
  `mutation_id_no` varchar(15) DEFAULT NULL,
  `cell_line` varchar(255) DEFAULT NULL,
  `mgi_accession_id` varchar(255) DEFAULT NULL,
  `epd` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1037 DEFAULT CHARSET=latin1;

