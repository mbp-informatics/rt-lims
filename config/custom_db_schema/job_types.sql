CREATE TABLE `job_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `job_type_name_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `scheduled_date1` date DEFAULT NULL,
  `scheduled_date2` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `job_id` (`job_id`) USING BTREE,
  KEY `job_type_name_id` (`job_type_name_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19690 DEFAULT CHARSET=utf8;

