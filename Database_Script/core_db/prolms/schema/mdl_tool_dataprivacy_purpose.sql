CREATE TABLE `mdl_tool_dataprivacy_purpose` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` longtext DEFAULT NULL,
  `descriptionformat` tinyint(1) DEFAULT NULL,
  `lawfulbases` longtext NOT NULL,
  `sensitivedatareasons` longtext DEFAULT NULL,
  `retentionperiod` varchar(255) NOT NULL DEFAULT '',
  `protected` tinyint(1) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Data purposes'