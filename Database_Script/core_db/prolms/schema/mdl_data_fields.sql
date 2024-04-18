CREATE TABLE `mdl_data_fields` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `dataid` bigint(10) NOT NULL DEFAULT 0,
  `type` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `param1` longtext DEFAULT NULL,
  `param2` longtext DEFAULT NULL,
  `param3` longtext DEFAULT NULL,
  `param4` longtext DEFAULT NULL,
  `param5` longtext DEFAULT NULL,
  `param6` longtext DEFAULT NULL,
  `param7` longtext DEFAULT NULL,
  `param8` longtext DEFAULT NULL,
  `param9` longtext DEFAULT NULL,
  `param10` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_datafiel_typdat_ix` (`type`,`dataid`),
  KEY `mdl_datafiel_dat_ix` (`dataid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='every field available'