CREATE TABLE `embryo_resus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `embryo_cryo_id` int(11) DEFAULT NULL,
  `cryo_date` date DEFAULT NULL,
  `investigator` varchar(255) DEFAULT NULL,
  `membership` varchar(255) DEFAULT NULL,
  `strain` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `freezing_medium_lot` varchar(100) DEFAULT NULL,
  `thawing_date` date DEFAULT NULL,
  `thawing_time` time DEFAULT NULL,
  `tank` varchar(255) DEFAULT NULL,
  `rack` varchar(255) DEFAULT NULL,
  `box` varchar(255) DEFAULT NULL,
  `space` varchar(255) DEFAULT NULL,
  `thawed_by` varchar(255) DEFAULT NULL,
  `embryo_stage` varchar(255) DEFAULT NULL,
  `straw_no` varchar(25) DEFAULT NULL,
  `embryos_no` varchar(50) DEFAULT NULL,
  `recovered_no` varchar(50) DEFAULT NULL,
  `intact_no` varchar(50) DEFAULT NULL,
  `bad_lysed_no` varchar(50) DEFAULT NULL,
  `cultured_no` varchar(50) DEFAULT NULL,
  `morulae_no` varchar(50) DEFAULT NULL,
  `blastocysts_no` varchar(50) DEFAULT NULL,
  `blastocyst_rate` float(10,2) DEFAULT NULL,
  `comments` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fmp_id_no` int(11) DEFAULT NULL,
  `fmp_job_id_no` int(11) DEFAULT NULL,
  `fmp_ec_id_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `job_id` (`job_id`) USING BTREE,
  KEY `embryo_cryo_id` (`embryo_cryo_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5040 DEFAULT CHARSET=utf8;


