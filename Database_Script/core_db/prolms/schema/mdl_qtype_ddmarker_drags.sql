CREATE TABLE `mdl_qtype_ddmarker_drags` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `questionid` bigint(10) NOT NULL DEFAULT 0,
  `no` bigint(10) NOT NULL DEFAULT 0,
  `label` longtext NOT NULL,
  `infinite` smallint(4) NOT NULL DEFAULT 0,
  `noofdrags` bigint(10) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `mdl_qtypddmadrag_que_ix` (`questionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Labels for markers to drag.'