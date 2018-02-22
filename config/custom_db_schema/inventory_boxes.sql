CREATE TABLE `inventory_boxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `inventory_container_id` int(11) DEFAULT NULL,
  `inventory_box_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `Box_Box_type` (`inventory_box_type_id`) USING BTREE,
  KEY `Box_Container` (`inventory_container_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13950 DEFAULT CHARSET=latin1;


