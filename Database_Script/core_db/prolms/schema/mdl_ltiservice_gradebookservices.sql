CREATE TABLE `mdl_ltiservice_gradebookservices` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `gradeitemid` bigint(10) NOT NULL,
  `courseid` bigint(10) NOT NULL,
  `toolproxyid` bigint(10) DEFAULT NULL,
  `typeid` bigint(10) DEFAULT NULL,
  `baseurl` longtext DEFAULT NULL,
  `ltilinkid` bigint(10) DEFAULT NULL,
  `resourceid` varchar(512) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `subreviewurl` longtext DEFAULT NULL,
  `subreviewparams` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_ltisgrad_lti_ix` (`ltilinkid`),
  KEY `mdl_ltisgrad_gracou_ix` (`gradeitemid`,`courseid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='This file records the grade items created by the LTI Gradebo'