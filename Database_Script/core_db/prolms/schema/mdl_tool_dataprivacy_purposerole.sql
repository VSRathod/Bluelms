CREATE TABLE `mdl_tool_dataprivacy_purposerole` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `purposeid` bigint(10) NOT NULL,
  `roleid` bigint(10) NOT NULL,
  `lawfulbases` longtext DEFAULT NULL,
  `sensitivedatareasons` longtext DEFAULT NULL,
  `retentionperiod` varchar(255) NOT NULL DEFAULT '',
  `protected` tinyint(1) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_tooldatapurp_purrol_uix` (`purposeid`,`roleid`),
  KEY `mdl_tooldatapurp_pur_ix` (`purposeid`),
  KEY `mdl_tooldatapurp_rol_ix` (`roleid`),
  KEY `mdl_tooldatapurp_use_ix` (`usermodified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Data purpose overrides for a specific role'