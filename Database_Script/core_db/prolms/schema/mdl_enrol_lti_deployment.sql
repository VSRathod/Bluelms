CREATE TABLE `mdl_enrol_lti_deployment` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `deploymentid` varchar(255) NOT NULL DEFAULT '',
  `platformid` bigint(10) NOT NULL,
  `legacyconsumerkey` varchar(255) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_enroltidepl_pladep_uix` (`platformid`,`deploymentid`),
  KEY `mdl_enroltidepl_pla_ix` (`platformid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Each row represents a deployment of a tool within a platform'