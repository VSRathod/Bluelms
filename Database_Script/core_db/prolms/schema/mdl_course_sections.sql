CREATE TABLE `mdl_course_sections` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `course` bigint(10) NOT NULL DEFAULT 0,
  `section` bigint(10) NOT NULL DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `summary` longtext DEFAULT NULL,
  `summaryformat` tinyint(2) NOT NULL DEFAULT 0,
  `sequence` longtext DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `availability` longtext DEFAULT NULL,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_coursect_cousec_uix` (`course`,`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='to define the sections for each course'