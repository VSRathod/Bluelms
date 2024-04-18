CREATE TABLE `mdl_tool_brickfield_cache_check` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `courseid` bigint(10) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `checkid` bigint(10) DEFAULT NULL,
  `checkcount` bigint(10) DEFAULT NULL,
  `errorcount` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_toolbriccachchec_sta_ix` (`status`),
  KEY `mdl_toolbriccachchec_err_ix` (`errorcount`),
  KEY `mdl_toolbriccachchec_cou_ix` (`courseid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Contains accessibility summary information per check.'