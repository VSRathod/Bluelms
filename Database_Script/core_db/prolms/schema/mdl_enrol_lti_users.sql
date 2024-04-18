CREATE TABLE `mdl_enrol_lti_users` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `userid` bigint(10) NOT NULL,
  `toolid` bigint(10) NOT NULL,
  `serviceurl` longtext DEFAULT NULL,
  `sourceid` longtext DEFAULT NULL,
  `ltideploymentid` bigint(10) DEFAULT NULL,
  `consumerkey` longtext DEFAULT NULL,
  `consumersecret` longtext DEFAULT NULL,
  `membershipsurl` longtext DEFAULT NULL,
  `membershipsid` longtext DEFAULT NULL,
  `lastgrade` decimal(10,5) DEFAULT NULL,
  `lastaccess` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_enroltiuser_use_ix` (`userid`),
  KEY `mdl_enroltiuser_too_ix` (`toolid`),
  KEY `mdl_enroltiuser_lti_ix` (`ltideploymentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='User access log and gradeback data'