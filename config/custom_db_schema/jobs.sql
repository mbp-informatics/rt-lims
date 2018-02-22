CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `job_status` varchar(25) NOT NULL,
  `job_astatus_id` int(11) DEFAULT NULL,
  `job_bstatus_id` int(11) DEFAULT NULL,
  `mcrl_note` varchar(255) DEFAULT NULL,
  `membership` varchar(255) DEFAULT NULL,
  `komp_source` varchar(255) DEFAULT NULL,
  `mosaic_id_no` varchar(25) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `reopened_date` date DEFAULT NULL,
  `closed_date` date DEFAULT NULL,
  `strain_note` varchar(255) DEFAULT NULL,
  `strain_name` varchar(255) DEFAULT NULL,
  `mmrrc_no` varchar(25) DEFAULT NULL,
  `bl_no` int(11) DEFAULT NULL,
  `pn_cr_no` int(11) DEFAULT NULL,
  `esc_clone_id_no` varchar(255) DEFAULT NULL,
  `esc_line` varchar(255) DEFAULT NULL,
  `genotype` varchar(255) DEFAULT NULL,
  `sexlinked` varchar(25) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `previous_name` varchar(255) DEFAULT NULL,
  `method_note` varchar(255) DEFAULT NULL,
  `egg_donors` varchar(255) DEFAULT NULL,
  `housing` varchar(255) DEFAULT NULL,
  `males_no` int(11) DEFAULT NULL,
  `males_id_dob` varchar(255) DEFAULT NULL,
  `females_no` int(11) DEFAULT NULL,
  `females_id_dob` varchar(255) DEFAULT NULL,
  `chimeras` varchar(255) DEFAULT NULL,
  `chimera_fertility` varchar(255) DEFAULT NULL,
  `genotyping` tinyint(1) DEFAULT NULL,
  `by_mgal` tinyint(1) DEFAULT NULL,
  `targeting_conf` tinyint(1) DEFAULT NULL,
  `where_geno` varchar(255) DEFAULT NULL,
  `billed` tinyint(1) DEFAULT NULL,
  `billing_id_no` int(11) DEFAULT NULL,
  `order_no` varchar(25) DEFAULT NULL,
  `mcrl_recharge` varchar(255) DEFAULT NULL,
  `mvp_recharge` varchar(255) DEFAULT NULL,
  `mgel_recharge` varchar(255) DEFAULT NULL,
  `et_location` varchar(255) DEFAULT NULL,
  `recipient_no` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `donor_genotyping` tinyint(1) DEFAULT NULL,
  `muga_sample` tinyint(1) DEFAULT NULL,
  `fmp_id_no` int(11) DEFAULT NULL,
  `import_id_no` varchar(255) DEFAULT NULL,
  `egg_donor_genotyping` tinyint(1) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `inj_parental_line` varchar(255) DEFAULT NULL,
  `inj_preferred_donor` varchar(255) DEFAULT NULL,
  `inj_injection_type` varchar(255) DEFAULT NULL,
  `inj_repeat` int(1) DEFAULT NULL,
  `is_injection_request` tinyint(1) DEFAULT NULL,
  `mgi_accession_id` varchar(255) DEFAULT NULL,
  `cell_clone_line` varchar(255) DEFAULT NULL,
  `job_source` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `job_astatus_id` (`job_astatus_id`) USING BTREE,
  KEY `job_bstatus_id` (`job_bstatus_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15219 DEFAULT CHARSET=utf8;
