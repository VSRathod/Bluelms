CREATE TABLE `mdl_adminpresets_it` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `adminpresetid` bigint(10) NOT NULL,
  `plugin` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_admiit_adm_ix` (`adminpresetid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Table to store settings'