CREATE TABLE `mdl_tool_brickfield_process` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `courseid` bigint(10) NOT NULL,
  `item` varchar(64) DEFAULT NULL,
  `contextid` bigint(10) DEFAULT NULL,
  `innercontextid` bigint(10) DEFAULT NULL,
  `timecreated` bigint(16) DEFAULT NULL,
  `timecompleted` bigint(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_toolbricproc_tim_ix` (`timecompleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Queued records to initiate new processing of specific target'