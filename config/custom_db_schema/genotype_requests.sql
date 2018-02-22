CREATE TABLE `genotype_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `sample_type` varchar(255) DEFAULT NULL,
  `collection_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fmp_id_no` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `comments` text,
  `epi_bool` tinyint(1) DEFAULT NULL,
  `recharge` varchar(255) DEFAULT NULL,
  `mosaic_name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `job_id` (`job_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2118 DEFAULT CHARSET=latin1;


