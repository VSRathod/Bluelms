CREATE TABLE `mdl_question_references` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usingcontextid` bigint(10) NOT NULL DEFAULT 0,
  `component` varchar(100) DEFAULT NULL,
  `questionarea` varchar(50) DEFAULT NULL,
  `itemid` bigint(10) DEFAULT NULL,
  `questionbankentryid` bigint(10) NOT NULL DEFAULT 0,
  `version` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_quesrefe_usicomqueite_uix` (`usingcontextid`,`component`,`questionarea`,`itemid`),
  KEY `mdl_quesrefe_usi_ix` (`usingcontextid`),
  KEY `mdl_quesrefe_que_ix` (`questionbankentryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Records where a specific question is used.'