CREATE TABLE `mdl_oauth2_refresh_token` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `issuerid` bigint(10) NOT NULL,
  `token` longtext NOT NULL,
  `scopehash` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_oautrefrtoke_useisssco_uix` (`userid`,`issuerid`,`scopehash`),
  KEY `mdl_oautrefrtoke_iss_ix` (`issuerid`),
  KEY `mdl_oautrefrtoke_use_ix` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores refresh tokens which can be exchanged for access toke'