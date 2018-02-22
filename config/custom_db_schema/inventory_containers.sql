CREATE TABLE `inventory_containers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `Container_Container` (`parent_id`) USING BTREE,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1079 DEFAULT CHARSET=latin1;

