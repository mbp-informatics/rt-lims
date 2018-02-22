CREATE TABLE `errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id_no` int(11) DEFAULT NULL,
  `error_type` varchar(255) DEFAULT NULL,
  `error` varchar(255) DEFAULT NULL,
  `this_object_dump_json` longtext,
  `user_id` int(11) DEFAULT NULL,
  `created` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


