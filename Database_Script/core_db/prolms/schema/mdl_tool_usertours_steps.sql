CREATE TABLE `mdl_tool_usertours_steps` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `tourid` bigint(10) NOT NULL,
  `title` longtext DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `contentformat` smallint(4) NOT NULL DEFAULT 0,
  `targettype` tinyint(2) NOT NULL,
  `targetvalue` longtext NOT NULL,
  `sortorder` bigint(10) NOT NULL DEFAULT 0,
  `configdata` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_tooluserstep_tousor_ix` (`tourid`,`sortorder`),
  KEY `mdl_tooluserstep_tou_ix` (`tourid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Steps in an tour'