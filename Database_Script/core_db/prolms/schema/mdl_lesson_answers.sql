CREATE TABLE `mdl_lesson_answers` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `lessonid` bigint(10) NOT NULL DEFAULT 0,
  `pageid` bigint(10) NOT NULL DEFAULT 0,
  `jumpto` bigint(11) NOT NULL DEFAULT 0,
  `grade` smallint(4) NOT NULL DEFAULT 0,
  `score` bigint(10) NOT NULL DEFAULT 0,
  `flags` smallint(3) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  `answer` longtext DEFAULT NULL,
  `answerformat` tinyint(2) NOT NULL DEFAULT 0,
  `response` longtext DEFAULT NULL,
  `responseformat` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_lessansw_les_ix` (`lessonid`),
  KEY `mdl_lessansw_pag_ix` (`pageid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Defines lesson_answers'