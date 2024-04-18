CREATE TABLE `mdl_question_bank_entries` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `questioncategoryid` bigint(10) NOT NULL DEFAULT 0,
  `idnumber` varchar(100) DEFAULT NULL,
  `ownerid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_quesbankentr_queidn_uix` (`questioncategoryid`,`idnumber`),
  KEY `mdl_quesbankentr_que_ix` (`questioncategoryid`),
  KEY `mdl_quesbankentr_own_ix` (`ownerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Each question bank entry. This table has one row for each qu'