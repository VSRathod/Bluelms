CREATE TABLE `mdl_tool_policy` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `sortorder` mediumint(5) NOT NULL DEFAULT 999,
  `currentversionid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_toolpoli_cur_ix` (`currentversionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Contains the list of policy documents defined on the site.'