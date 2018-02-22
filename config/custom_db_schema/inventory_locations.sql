CREATE TABLE `inventory_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cell` int(11) NOT NULL,
  `inventory_box_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `Location_Box` (`inventory_box_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1142633 DEFAULT CHARSET=latin1;

