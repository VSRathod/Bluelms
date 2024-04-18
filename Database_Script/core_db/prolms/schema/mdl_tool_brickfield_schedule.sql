CREATE TABLE `mdl_tool_brickfield_schedule` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `contextlevel` bigint(10) NOT NULL DEFAULT 50,
  `instanceid` bigint(10) NOT NULL,
  `contextid` bigint(10) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `timeanalyzed` bigint(10) DEFAULT 0,
  `timemodified` bigint(10) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_toolbricsche_conins_uix` (`contextlevel`,`instanceid`),
  KEY `mdl_toolbricsche_sta_ix` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Keeps the per course content analysis schedule.'