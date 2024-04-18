CREATE TABLE `mdl_question_versions` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `questionbankentryid` bigint(10) NOT NULL DEFAULT 0,
  `version` bigint(10) NOT NULL DEFAULT 1,
  `questionid` bigint(10) NOT NULL DEFAULT 0,
  `status` varchar(10) NOT NULL DEFAULT 'ready',
  PRIMARY KEY (`id`),
  KEY `mdl_quesvers_que_ix` (`questionbankentryid`),
  KEY `mdl_quesvers_que2_ix` (`questionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='A join table linking the different question version definiti'