CREATE TABLE `mdl_adminpresets_app_it` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `adminpresetapplyid` bigint(10) NOT NULL,
  `configlogid` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_admiappit_con_ix` (`configlogid`),
  KEY `mdl_admiappit_adm_ix` (`adminpresetapplyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Admin presets applied items. To maintain the relation with c'