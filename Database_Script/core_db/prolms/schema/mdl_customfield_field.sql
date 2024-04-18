CREATE TABLE `mdl_customfield_field` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `shortname` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(400) NOT NULL DEFAULT '',
  `type` varchar(100) NOT NULL DEFAULT '',
  `description` longtext DEFAULT NULL,
  `descriptionformat` bigint(10) DEFAULT NULL,
  `sortorder` bigint(10) DEFAULT NULL,
  `categoryid` bigint(10) DEFAULT NULL,
  `configdata` longtext DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_custfiel_catsor_ix` (`categoryid`,`sortorder`),
  KEY `mdl_custfiel_cat_ix` (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='core_customfield field table'