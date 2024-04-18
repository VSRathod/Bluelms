CREATE TABLE `mdl_lesson_pages` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `lessonid` bigint(10) NOT NULL DEFAULT 0,
  `prevpageid` bigint(10) NOT NULL DEFAULT 0,
  `nextpageid` bigint(10) NOT NULL DEFAULT 0,
  `qtype` smallint(3) NOT NULL DEFAULT 0,
  `qoption` smallint(3) NOT NULL DEFAULT 0,
  `layout` smallint(3) NOT NULL DEFAULT 1,
  `display` smallint(3) NOT NULL DEFAULT 1,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL DEFAULT '',
  `contents` longtext NOT NULL,
  `contentsformat` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_lesspage_les_ix` (`lessonid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Defines lesson_pages'