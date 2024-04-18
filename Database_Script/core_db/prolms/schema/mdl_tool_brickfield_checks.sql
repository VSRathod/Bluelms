CREATE TABLE `mdl_tool_brickfield_checks` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `checktype` varchar(64) DEFAULT NULL,
  `shortname` varchar(64) DEFAULT NULL,
  `checkgroup` bigint(16) DEFAULT 0,
  `status` smallint(4) NOT NULL,
  `severity` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_toolbricchec_che_ix` (`checktype`),
  KEY `mdl_toolbricchec_che2_ix` (`checkgroup`),
  KEY `mdl_toolbricchec_sta_ix` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Checks details'