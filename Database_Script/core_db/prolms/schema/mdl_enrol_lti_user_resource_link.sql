CREATE TABLE `mdl_enrol_lti_user_resource_link` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `ltiuserid` bigint(10) NOT NULL,
  `resourcelinkid` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_enroltiuserresolink_lt_uix` (`ltiuserid`,`resourcelinkid`),
  KEY `mdl_enroltiuserresolink_lti_ix` (`ltiuserid`),
  KEY `mdl_enroltiuserresolink_res_ix` (`resourcelinkid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Join table mapping users to resource links as this is a many'