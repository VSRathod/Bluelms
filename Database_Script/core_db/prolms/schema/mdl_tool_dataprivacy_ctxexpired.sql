CREATE TABLE `mdl_tool_dataprivacy_ctxexpired` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `contextid` bigint(10) NOT NULL,
  `unexpiredroles` longtext DEFAULT NULL,
  `expiredroles` longtext DEFAULT NULL,
  `defaultexpired` tinyint(1) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `usermodified` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_tooldatactxe_con_uix` (`contextid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Default comment for the table, please edit me'