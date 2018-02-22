CREATE TABLE `ivf_dishes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ivf_id` int(11) DEFAULT NULL,
  `dish_no` int(11) DEFAULT NULL,
  `clutches_no` decimal(11,2) DEFAULT NULL,
  `cocs_in_dish_time` time DEFAULT NULL,
  `insemination_time` time DEFAULT NULL,
  `sperm_ul` varchar(25) DEFAULT NULL,
  `one_cell_no` int(11) DEFAULT NULL,
  `two_cell_no` int(11) DEFAULT NULL,
  `fert_rate` decimal(11,2) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `ivf_id` (`ivf_id`) USING BTREE,
  KEY `dish_no` (`dish_no`)
) ENGINE=InnoDB AUTO_INCREMENT=24925 DEFAULT CHARSET=utf8;

