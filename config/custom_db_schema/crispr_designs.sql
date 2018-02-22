CREATE TABLE `crispr_designs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `comments` text,
  `vector_name` varchar(60) DEFAULT NULL,
  `nuclease` varchar(60) DEFAULT NULL,
  `batch_upload_uid` varchar(60) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


