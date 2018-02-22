CREATE TABLE `imits_dump_mi_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mi_attempt_json` mediumtext NOT NULL,
  `imits_mi_attempt_id` int(11) NOT NULL,
  `imits_mi_plan_id` int(11) DEFAULT NULL,
  `mgi_accession_id` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=688 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


