CREATE TABLE `pseudopregnant_recipient_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocol` int(11) DEFAULT NULL,
  `protocol_expiration` date DEFAULT NULL,
  `protocol_Investigator` varchar(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` text,
  `time_period_start` date DEFAULT NULL,
  `time_period_end` date DEFAULT NULL,
  `total_plugs` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `finalize_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

