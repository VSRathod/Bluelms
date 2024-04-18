CREATE TABLE `mdl_h5pactivity` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `course` bigint(10) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `intro` longtext DEFAULT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT 0,
  `grade` bigint(10) DEFAULT 0,
  `displayoptions` smallint(4) NOT NULL DEFAULT 0,
  `enabletracking` tinyint(1) NOT NULL DEFAULT 1,
  `grademethod` smallint(4) NOT NULL DEFAULT 1,
  `reviewmode` smallint(4) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `mdl_h5pa_cou_ix` (`course`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores the h5pactivity activity module instances.'