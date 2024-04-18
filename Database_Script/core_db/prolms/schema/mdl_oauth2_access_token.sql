CREATE TABLE `mdl_oauth2_access_token` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `usermodified` bigint(10) NOT NULL,
  `issuerid` bigint(10) NOT NULL,
  `token` longtext NOT NULL,
  `expires` bigint(10) NOT NULL,
  `scope` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_oautaccetoke_iss_uix` (`issuerid`),
  KEY `mdl_oautaccetoke_use_ix` (`usermodified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores access tokens for system accounts in order to be able'