CREATE TABLE `mdl_auth_lti_linked_login` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `userid` bigint(10) NOT NULL,
  `issuer` longtext NOT NULL,
  `issuer256` varchar(64) NOT NULL DEFAULT '',
  `sub` varchar(255) NOT NULL DEFAULT '',
  `sub256` varchar(64) NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_authltilinklogi_useiss_uix` (`userid`,`issuer256`,`sub256`),
  KEY `mdl_authltilinklogi_use_ix` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Accounts linked to a users Moodle account.'