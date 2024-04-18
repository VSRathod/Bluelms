CREATE TABLE `mdl_badge_external_backpack` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `backpackapiurl` varchar(255) NOT NULL DEFAULT '',
  `backpackweburl` varchar(255) NOT NULL DEFAULT '',
  `apiversion` varchar(12) NOT NULL DEFAULT '1.0',
  `sortorder` bigint(10) NOT NULL DEFAULT 0,
  `oauth2_issuerid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_badgexteback_bac_uix` (`backpackapiurl`),
  UNIQUE KEY `mdl_badgexteback_bac2_uix` (`backpackweburl`),
  KEY `mdl_badgexteback_oau_ix` (`oauth2_issuerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Defines settings for site level backpacks that a user can co'