CREATE TABLE `imits_dump_mi_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marker_symbol` varchar(255) DEFAULT NULL,
  `imits_mi_plan_id` int(11) NOT NULL,
  `mi_plan_json` mediumtext NOT NULL,
  `mgi_accession_id` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1096 DEFAULT CHARSET=utf8;


