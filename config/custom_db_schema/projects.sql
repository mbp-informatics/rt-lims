CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_type_id` int(11) NOT NULL,
  `project_status_id` int(11) DEFAULT NULL,
  `mutation_id` char(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `phenotype_id` int(11) DEFAULT NULL,
  `pts_id_no` int(11) DEFAULT NULL,
  `komp_id_no` int(11) DEFAULT NULL,
  `komp_order_no` int(11) DEFAULT NULL,
  `mmrrc_id_no` int(11) DEFAULT NULL,
  `comments` text,
  `batch_upload_uid` varchar(256) DEFAULT NULL,
  `custom_name` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `project_type_id` (`project_type_id`),
  KEY `project_status_id` (`project_status_id`),
  KEY `mutatio_id` (`mutation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

