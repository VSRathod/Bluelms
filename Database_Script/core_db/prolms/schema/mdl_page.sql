CREATE TABLE `mdl_page` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `course` bigint(10) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `intro` longtext DEFAULT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT 0,
  `content` longtext DEFAULT NULL,
  `contentformat` smallint(4) NOT NULL DEFAULT 0,
  `legacyfiles` smallint(4) NOT NULL DEFAULT 0,
  `legacyfileslast` bigint(10) DEFAULT NULL,
  `display` smallint(4) NOT NULL DEFAULT 0,
  `displayoptions` longtext DEFAULT NULL,
  `revision` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_page_cou_ix` (`course`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Each record is one page and its config data'