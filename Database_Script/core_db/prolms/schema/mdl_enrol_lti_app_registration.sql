CREATE TABLE `mdl_enrol_lti_app_registration` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `platformid` longtext DEFAULT NULL,
  `clientid` varchar(1333) DEFAULT NULL,
  `uniqueid` varchar(255) NOT NULL DEFAULT '',
  `platformclienthash` varchar(64) DEFAULT NULL,
  `platformuniqueidhash` varchar(64) DEFAULT NULL,
  `authenticationrequesturl` longtext DEFAULT NULL,
  `jwksurl` longtext DEFAULT NULL,
  `accesstokenurl` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_enroltiappregi_uni_uix` (`uniqueid`),
  UNIQUE KEY `mdl_enroltiappregi_pla_uix` (`platformclienthash`),
  UNIQUE KEY `mdl_enroltiappregi_pla2_uix` (`platformuniqueidhash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Details of each application that has been registered with th'