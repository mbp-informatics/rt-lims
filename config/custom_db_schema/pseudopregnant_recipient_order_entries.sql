CREATE TABLE `pseudopregnant_recipient_order_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudopregnant_recipient_order_id` int(11) NOT NULL,
  `recharge` varchar(256) NOT NULL,
  `location` varchar(256) NOT NULL,
  `date_plugged` date NOT NULL,
  `date_needed` date NOT NULL,
  `pseudo_state` varchar(256) NOT NULL,
  `quantity` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `pseudopregnant_recipient_order_id` (`pseudopregnant_recipient_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=867 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

