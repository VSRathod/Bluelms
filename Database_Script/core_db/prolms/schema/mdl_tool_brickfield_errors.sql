CREATE TABLE `mdl_tool_brickfield_errors` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `resultid` bigint(10) NOT NULL,
  `linenumber` bigint(10) NOT NULL DEFAULT 0,
  `errordata` longtext DEFAULT NULL,
  `htmlcode` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_toolbricerro_res_ix` (`resultid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Errors during the accessibility checks'