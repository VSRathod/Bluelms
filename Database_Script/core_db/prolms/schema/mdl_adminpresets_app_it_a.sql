CREATE TABLE `mdl_adminpresets_app_it_a` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `adminpresetapplyid` bigint(10) NOT NULL,
  `configlogid` bigint(10) NOT NULL,
  `itemname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_admiappita_con_ix` (`configlogid`),
  KEY `mdl_admiappita_adm_ix` (`adminpresetapplyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Attributes of the applied items'