CREATE TABLE `mdl_adminpresets_plug` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `adminpresetid` bigint(10) NOT NULL,
  `plugin` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `enabled` smallint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_admiplug_adm_ix` (`adminpresetid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Admin presets plugins status, to store information about whe'