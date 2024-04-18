CREATE TABLE `mdl_badge_backpack_oauth2` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usermodified` bigint(10) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  `userid` bigint(10) NOT NULL,
  `issuerid` bigint(10) NOT NULL,
  `externalbackpackid` bigint(10) NOT NULL,
  `token` longtext NOT NULL,
  `refreshtoken` longtext NOT NULL,
  `expires` bigint(10) DEFAULT NULL,
  `scope` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_badgbackoaut_use_ix` (`usermodified`),
  KEY `mdl_badgbackoaut_use2_ix` (`userid`),
  KEY `mdl_badgbackoaut_iss_ix` (`issuerid`),
  KEY `mdl_badgbackoaut_ext_ix` (`externalbackpackid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Default comment for the table, please edit me'