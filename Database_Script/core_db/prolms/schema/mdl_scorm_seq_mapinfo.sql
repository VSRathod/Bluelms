CREATE TABLE `mdl_scorm_seq_mapinfo` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `scoid` bigint(10) NOT NULL DEFAULT 0,
  `objectiveid` bigint(10) NOT NULL DEFAULT 0,
  `targetobjectiveid` bigint(10) NOT NULL DEFAULT 0,
  `readsatisfiedstatus` tinyint(1) NOT NULL DEFAULT 1,
  `readnormalizedmeasure` tinyint(1) NOT NULL DEFAULT 1,
  `writesatisfiedstatus` tinyint(1) NOT NULL DEFAULT 0,
  `writenormalizedmeasure` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_scorseqmapi_scoidobj_uix` (`scoid`,`id`,`objectiveid`),
  KEY `mdl_scorseqmapi_sco_ix` (`scoid`),
  KEY `mdl_scorseqmapi_obj_ix` (`objectiveid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='SCORM2004 objective mapinfo description'