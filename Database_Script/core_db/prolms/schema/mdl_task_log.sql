CREATE TABLE `mdl_task_log` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `type` smallint(4) NOT NULL,
  `component` varchar(255) NOT NULL DEFAULT '',
  `classname` varchar(255) NOT NULL DEFAULT '',
  `userid` bigint(10) NOT NULL,
  `timestart` decimal(20,10) NOT NULL,
  `timeend` decimal(20,10) NOT NULL,
  `dbreads` bigint(10) NOT NULL,
  `dbwrites` bigint(10) NOT NULL,
  `result` tinyint(2) NOT NULL,
  `output` longtext NOT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `pid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_tasklog_cla_ix` (`classname`),
  KEY `mdl_tasklog_tim_ix` (`timestart`),
  KEY `mdl_tasklog_use_ix` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='The log table for all tasks'