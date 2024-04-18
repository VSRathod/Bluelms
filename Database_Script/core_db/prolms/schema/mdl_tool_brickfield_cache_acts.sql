CREATE TABLE `mdl_tool_brickfield_cache_acts` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `courseid` bigint(10) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `component` varchar(64) DEFAULT NULL,
  `totalactivities` bigint(10) DEFAULT NULL,
  `failedactivities` bigint(10) DEFAULT NULL,
  `passedactivities` bigint(10) DEFAULT NULL,
  `errorcount` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_toolbriccachacts_sta_ix` (`status`),
  KEY `mdl_toolbriccachacts_cou_ix` (`courseid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Contains accessibility summary information per activity.'