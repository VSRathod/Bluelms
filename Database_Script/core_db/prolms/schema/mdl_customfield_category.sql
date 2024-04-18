CREATE TABLE `mdl_customfield_category` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(400) NOT NULL DEFAULT '',
  `description` longtext DEFAULT NULL,
  `descriptionformat` bigint(10) DEFAULT NULL,
  `sortorder` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  `component` varchar(100) NOT NULL DEFAULT '',
  `area` varchar(100) NOT NULL DEFAULT '',
  `itemid` bigint(10) NOT NULL DEFAULT 0,
  `contextid` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_custcate_comareitesor_ix` (`component`,`area`,`itemid`,`sortorder`),
  KEY `mdl_custcate_con_ix` (`contextid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='core_customfield category table'