CREATE TABLE `mdl_tool_dataprivacy_ctxlevel` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `contextlevel` smallint(3) NOT NULL,
  `purposeid` bigint(10) DEFAULT NULL,
  `categoryid` bigint(10) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_tooldatactxl_con_uix` (`contextlevel`),
  KEY `mdl_tooldatactxl_cat_ix` (`categoryid`),
  KEY `mdl_tooldatactxl_pur_ix` (`purposeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Default comment for the table, please edit me'