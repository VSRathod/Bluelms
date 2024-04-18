CREATE TABLE `mdl_question_set_references` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `usingcontextid` bigint(10) NOT NULL DEFAULT 0,
  `component` varchar(100) DEFAULT NULL,
  `questionarea` varchar(50) DEFAULT NULL,
  `itemid` bigint(10) DEFAULT NULL,
  `questionscontextid` bigint(10) NOT NULL DEFAULT 0,
  `filtercondition` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_quessetrefe_usicomquei_uix` (`usingcontextid`,`component`,`questionarea`,`itemid`),
  KEY `mdl_quessetrefe_usi_ix` (`usingcontextid`),
  KEY `mdl_quessetrefe_que_ix` (`questionscontextid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Records where groups of questions are used.'