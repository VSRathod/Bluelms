CREATE TABLE `mdl_bigbluebuttonbn_recordings` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `courseid` bigint(10) NOT NULL,
  `bigbluebuttonbnid` bigint(10) NOT NULL,
  `groupid` bigint(10) DEFAULT NULL,
  `recordingid` varchar(64) NOT NULL DEFAULT '',
  `headless` tinyint(1) NOT NULL DEFAULT 0,
  `imported` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `importeddata` longtext DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `usermodified` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_bigbreco_cou_ix` (`courseid`),
  KEY `mdl_bigbreco_rec_ix` (`recordingid`),
  KEY `mdl_bigbreco_big_ix` (`bigbluebuttonbnid`),
  KEY `mdl_bigbreco_use_ix` (`usermodified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='The bigbluebuttonbn table to store references to recordings'