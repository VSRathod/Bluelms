CREATE TABLE `mdl_reportbuilder_audience` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `reportid` bigint(10) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `classname` varchar(255) NOT NULL DEFAULT '',
  `configdata` longtext NOT NULL,
  `usercreated` bigint(10) NOT NULL DEFAULT 0,
  `usermodified` bigint(10) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_repoaudi_rep_ix` (`reportid`),
  KEY `mdl_repoaudi_use_ix` (`usercreated`),
  KEY `mdl_repoaudi_use2_ix` (`usermodified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Defines report audience'