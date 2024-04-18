CREATE TABLE `mdl_message_conversations` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `type` bigint(10) NOT NULL DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `convhash` varchar(40) DEFAULT NULL,
  `component` varchar(100) DEFAULT NULL,
  `itemtype` varchar(100) DEFAULT NULL,
  `itemid` bigint(10) DEFAULT NULL,
  `contextid` bigint(10) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_messconv_typ_ix` (`type`),
  KEY `mdl_messconv_con_ix` (`convhash`),
  KEY `mdl_messconv_comiteitecon_ix` (`component`,`itemtype`,`itemid`,`contextid`),
  KEY `mdl_messconv_con2_ix` (`contextid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores all message conversations'