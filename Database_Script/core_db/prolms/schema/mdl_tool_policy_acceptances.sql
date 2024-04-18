CREATE TABLE `mdl_tool_policy_acceptances` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `policyversionid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `lang` varchar(30) NOT NULL DEFAULT '',
  `usermodified` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `note` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_toolpoliacce_poluse_uix` (`policyversionid`,`userid`),
  KEY `mdl_toolpoliacce_pol_ix` (`policyversionid`),
  KEY `mdl_toolpoliacce_use_ix` (`userid`),
  KEY `mdl_toolpoliacce_use2_ix` (`usermodified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Tracks users accepting the policy versions'