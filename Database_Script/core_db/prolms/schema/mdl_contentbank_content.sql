CREATE TABLE `mdl_contentbank_content` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contenttype` varchar(100) NOT NULL DEFAULT '',
  `contextid` bigint(10) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 1,
  `instanceid` bigint(10) DEFAULT NULL,
  `configdata` longtext DEFAULT NULL,
  `usercreated` bigint(10) NOT NULL,
  `usermodified` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_contcont_nam_ix` (`name`),
  KEY `mdl_contcont_conconins_ix` (`contextid`,`contenttype`,`instanceid`),
  KEY `mdl_contcont_con_ix` (`contextid`),
  KEY `mdl_contcont_use_ix` (`usermodified`),
  KEY `mdl_contcont_use2_ix` (`usercreated`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='This table stores content data in the content bank.'