CREATE TABLE `crispr_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crispr_design_id` int(12) DEFAULT NULL,
  `sequence` varchar(40) DEFAULT NULL,
  `chromosome` varchar(40) DEFAULT NULL,
  `chr_start` int(12) DEFAULT NULL,
  `chr_end` int(12) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `crispr_design_id` (`crispr_design_id`)
) ENGINE=InnoDB AUTO_INCREMENT=411 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


