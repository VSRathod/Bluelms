CREATE TABLE `mdl_reportbuilder_filter` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `reportid` bigint(10) NOT NULL DEFAULT 0,
  `uniqueidentifier` varchar(255) NOT NULL DEFAULT '',
  `heading` varchar(255) DEFAULT NULL,
  `iscondition` tinyint(1) NOT NULL DEFAULT 0,
  `filterorder` bigint(10) NOT NULL,
  `usercreated` bigint(10) NOT NULL DEFAULT 0,
  `usermodified` bigint(10) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_repofilt_rep_ix` (`reportid`),
  KEY `mdl_repofilt_use_ix` (`usercreated`),
  KEY `mdl_repofilt_use2_ix` (`usermodified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Table to represent a report filter/condition'