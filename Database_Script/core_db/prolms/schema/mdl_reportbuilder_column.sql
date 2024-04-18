CREATE TABLE `mdl_reportbuilder_column` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `reportid` bigint(10) NOT NULL DEFAULT 0,
  `uniqueidentifier` varchar(255) NOT NULL DEFAULT '',
  `aggregation` varchar(32) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `columnorder` bigint(10) NOT NULL,
  `sortenabled` tinyint(1) NOT NULL DEFAULT 0,
  `sortdirection` tinyint(1) NOT NULL,
  `sortorder` bigint(10) DEFAULT NULL,
  `usercreated` bigint(10) NOT NULL DEFAULT 0,
  `usermodified` bigint(10) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_repocolu_rep_ix` (`reportid`),
  KEY `mdl_repocolu_use_ix` (`usercreated`),
  KEY `mdl_repocolu_use2_ix` (`usermodified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Table to represent a report column'