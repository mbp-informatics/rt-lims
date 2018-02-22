CREATE TABLE `change_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_alias` varchar(255) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `changes` longtext,
  `user_info` longtext,
  `old_entity` longtext,
  `addition` tinyint(1) DEFAULT NULL,
  `deletion` tinyint(1) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `table_alias` (`table_alias`),
  KEY `old_entity` (`old_entity`(255)),
  KEY `entity_id` (`entity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=325090 DEFAULT CHARSET=utf8;


