CREATE TABLE `mdl_adminpresets_app_plug` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `adminpresetapplyid` bigint(10) NOT NULL,
  `plugin` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` smallint(4) NOT NULL DEFAULT 0,
  `oldvalue` smallint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_admiappplug_adm_ix` (`adminpresetapplyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Admin presets plugins applied'