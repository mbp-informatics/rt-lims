CREATE TABLE `genes_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mgi_accession_id` varchar(255) NOT NULL,
  `gene_status_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `mgi_accession_id` (`mgi_accession_id`)
) ENGINE=InnoDB AUTO_INCREMENT=842 DEFAULT CHARSET=utf8;


