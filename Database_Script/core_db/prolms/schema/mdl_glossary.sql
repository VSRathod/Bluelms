CREATE TABLE `mdl_glossary` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `course` bigint(10) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `intro` longtext NOT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT 0,
  `allowduplicatedentries` tinyint(2) NOT NULL DEFAULT 0,
  `displayformat` varchar(50) NOT NULL DEFAULT 'dictionary',
  `mainglossary` tinyint(2) NOT NULL DEFAULT 0,
  `showspecial` tinyint(2) NOT NULL DEFAULT 1,
  `showalphabet` tinyint(2) NOT NULL DEFAULT 1,
  `showall` tinyint(2) NOT NULL DEFAULT 1,
  `allowcomments` tinyint(2) NOT NULL DEFAULT 0,
  `allowprintview` tinyint(2) NOT NULL DEFAULT 1,
  `usedynalink` tinyint(2) NOT NULL DEFAULT 1,
  `defaultapproval` tinyint(2) NOT NULL DEFAULT 1,
  `approvaldisplayformat` varchar(50) NOT NULL DEFAULT 'default',
  `globalglossary` tinyint(2) NOT NULL DEFAULT 0,
  `entbypage` smallint(3) NOT NULL DEFAULT 10,
  `editalways` tinyint(2) NOT NULL DEFAULT 0,
  `rsstype` tinyint(2) NOT NULL DEFAULT 0,
  `rssarticles` tinyint(2) NOT NULL DEFAULT 0,
  `assessed` bigint(10) NOT NULL DEFAULT 0,
  `assesstimestart` bigint(10) NOT NULL DEFAULT 0,
  `assesstimefinish` bigint(10) NOT NULL DEFAULT 0,
  `scale` bigint(10) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  `completionentries` int(9) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_glos_cou_ix` (`course`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='all glossaries'