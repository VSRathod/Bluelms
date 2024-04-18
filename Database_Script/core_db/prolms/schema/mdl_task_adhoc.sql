CREATE TABLE `mdl_task_adhoc` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `component` varchar(255) NOT NULL DEFAULT '',
  `classname` varchar(255) NOT NULL DEFAULT '',
  `nextruntime` bigint(10) NOT NULL,
  `faildelay` bigint(10) DEFAULT NULL,
  `customdata` longtext DEFAULT NULL,
  `userid` bigint(10) DEFAULT NULL,
  `blocking` tinyint(2) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timestarted` bigint(10) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `pid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_taskadho_nex_ix` (`nextruntime`),
  KEY `mdl_taskadho_tim_ix` (`timestarted`),
  KEY `mdl_taskadho_use_ix` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='List of adhoc tasks waiting to run.'