CREATE TABLE `mdl_adminpresets_app` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `adminpresetid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `time` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_admiapp_adm_ix` (`adminpresetid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Applied presets'