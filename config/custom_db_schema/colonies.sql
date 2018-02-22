CREATE TABLE `colonies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `colony_id` int(11) DEFAULT NULL,
  `denotation` varchar(45) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `injection_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `mgi_accession_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `injection_id` (`injection_id`) USING BTREE,
  KEY `project_id` (`project_id`),
  KEY `mgi_accession_id` (`mgi_accession_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8024 DEFAULT CHARSET=latin1;


