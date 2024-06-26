CREATE TABLE `mdl_enrol_lti_lti2_consumer` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `consumerkey256` varchar(255) NOT NULL DEFAULT '',
  `consumerkey` longtext DEFAULT NULL,
  `secret` varchar(1024) NOT NULL DEFAULT '',
  `ltiversion` varchar(10) DEFAULT NULL,
  `consumername` varchar(255) DEFAULT NULL,
  `consumerversion` varchar(255) DEFAULT NULL,
  `consumerguid` varchar(1024) DEFAULT NULL,
  `profile` longtext DEFAULT NULL,
  `toolproxy` longtext DEFAULT NULL,
  `settings` longtext DEFAULT NULL,
  `protected` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `enablefrom` bigint(10) DEFAULT NULL,
  `enableuntil` bigint(10) DEFAULT NULL,
  `lastaccess` bigint(10) DEFAULT NULL,
  `created` bigint(10) NOT NULL,
  `updated` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_enroltilti2cons_con_uix` (`consumerkey256`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='LTI consumers interacting with moodle'