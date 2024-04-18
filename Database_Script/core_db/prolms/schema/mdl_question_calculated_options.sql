CREATE TABLE `mdl_question_calculated_options` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `question` bigint(10) NOT NULL DEFAULT 0,
  `synchronize` tinyint(2) NOT NULL DEFAULT 0,
  `single` smallint(4) NOT NULL DEFAULT 0,
  `shuffleanswers` smallint(4) NOT NULL DEFAULT 0,
  `correctfeedback` longtext DEFAULT NULL,
  `correctfeedbackformat` tinyint(2) NOT NULL DEFAULT 0,
  `partiallycorrectfeedback` longtext DEFAULT NULL,
  `partiallycorrectfeedbackformat` tinyint(2) NOT NULL DEFAULT 0,
  `incorrectfeedback` longtext DEFAULT NULL,
  `incorrectfeedbackformat` tinyint(2) NOT NULL DEFAULT 0,
  `answernumbering` varchar(10) NOT NULL DEFAULT 'abc',
  `shownumcorrect` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_quescalcopti_que_ix` (`question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Options for questions of type calculated'