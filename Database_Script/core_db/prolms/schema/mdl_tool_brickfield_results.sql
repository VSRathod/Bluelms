CREATE TABLE `mdl_tool_brickfield_results` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `contentid` bigint(10) DEFAULT NULL,
  `checkid` bigint(10) NOT NULL,
  `errorcount` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_toolbricresu_conche_ix` (`contentid`,`checkid`),
  KEY `mdl_toolbricresu_con_ix` (`contentid`),
  KEY `mdl_toolbricresu_che_ix` (`checkid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Results of the accessibility checks'