CREATE TABLE `mdl_bigbluebuttonbn_logs` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `courseid` bigint(10) NOT NULL,
  `bigbluebuttonbnid` bigint(10) NOT NULL,
  `userid` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `meetingid` varchar(256) NOT NULL DEFAULT '',
  `log` varchar(32) NOT NULL DEFAULT '',
  `meta` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_bigblogs_cou_ix` (`courseid`),
  KEY `mdl_bigblogs_log_ix` (`log`),
  KEY `mdl_bigblogs_coubiguselog_ix` (`courseid`,`bigbluebuttonbnid`,`userid`,`log`),
  KEY `mdl_bigblogs_uselog_ix` (`userid`,`log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='The bigbluebuttonbn table to store meeting activity events'