CREATE TABLE `mdl_badge_external_identifier` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `sitebackpackid` bigint(10) NOT NULL,
  `internalid` varchar(128) NOT NULL DEFAULT '',
  `externalid` varchar(128) NOT NULL DEFAULT '',
  `type` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_badgexteiden_sitintext_uix` (`sitebackpackid`,`internalid`,`externalid`,`type`),
  KEY `mdl_badgexteiden_sit_ix` (`sitebackpackid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Setting for external badges mappings'