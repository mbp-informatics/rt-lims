CREATE TABLE `qc_customer_invivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `komp_clones_dump_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `starting_product` varchar(255) DEFAULT NULL,
  `injection_outcome` varchar(255) DEFAULT NULL,
  `germline_outcome` varchar(255) DEFAULT NULL,
  `notes` text,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `injection_date` date DEFAULT NULL,
  `germline_date` date DEFAULT NULL,
  `added_by` varchar(50) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quality_control_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=975 DEFAULT CHARSET=latin1;

