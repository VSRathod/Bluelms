CREATE TABLE `mdl_h5p` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `jsoncontent` longtext NOT NULL,
  `mainlibraryid` bigint(10) NOT NULL,
  `displayoptions` smallint(4) DEFAULT NULL,
  `pathnamehash` varchar(40) NOT NULL DEFAULT '',
  `contenthash` varchar(40) NOT NULL DEFAULT '',
  `filtered` longtext DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_h5p_pat_ix` (`pathnamehash`),
  KEY `mdl_h5p_mai_ix` (`mainlibraryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores H5P content information'