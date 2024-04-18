CREATE TABLE `mdl_question_answers` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `question` bigint(10) NOT NULL DEFAULT 0,
  `answer` longtext NOT NULL,
  `answerformat` tinyint(2) NOT NULL DEFAULT 0,
  `fraction` decimal(12,7) NOT NULL DEFAULT 0.0000000,
  `feedback` longtext NOT NULL,
  `feedbackformat` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_quesansw_que_ix` (`question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Answers, with a fractional grade (0-1) and feedback'