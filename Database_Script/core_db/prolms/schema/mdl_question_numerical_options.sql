CREATE TABLE `mdl_question_numerical_options` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `question` bigint(10) NOT NULL DEFAULT 0,
  `showunits` smallint(4) NOT NULL DEFAULT 0,
  `unitsleft` smallint(4) NOT NULL DEFAULT 0,
  `unitgradingtype` smallint(4) NOT NULL DEFAULT 0,
  `unitpenalty` decimal(12,7) NOT NULL DEFAULT 0.1000000,
  PRIMARY KEY (`id`),
  KEY `mdl_quesnumeopti_que_ix` (`question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Options for questions of type numerical This table is also u'