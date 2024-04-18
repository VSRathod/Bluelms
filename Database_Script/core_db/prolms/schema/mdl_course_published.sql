CREATE TABLE `mdl_course_published` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `huburl` varchar(255) DEFAULT NULL,
  `courseid` bigint(10) NOT NULL,
  `timepublished` bigint(10) NOT NULL,
  `enrollable` tinyint(1) NOT NULL DEFAULT 1,
  `hubcourseid` bigint(10) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `timechecked` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_courpubl_hub_ix` (`hubcourseid`),
  KEY `mdl_courpubl_cou_ix` (`courseid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Information about how and when an local courses were publish'