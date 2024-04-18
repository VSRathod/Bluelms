CREATE TABLE `mdl_enrol_lti_context` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `contextid` varchar(255) NOT NULL DEFAULT '',
  `ltideploymentid` bigint(10) NOT NULL,
  `type` longtext DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_enrolticont_lticon_uix` (`ltideploymentid`,`contextid`),
  KEY `mdl_enrolticont_lti_ix` (`ltideploymentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Each row represents a context in the platform, where resourc'