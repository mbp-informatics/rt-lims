CREATE TABLE `project_types_genes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_type_id` int(11) DEFAULT NULL,
  `mgi_accession_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1689 DEFAULT CHARSET=utf8;

