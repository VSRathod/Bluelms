CREATE TABLE `mdl_h5p_libraries_cachedassets` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `libraryid` bigint(10) NOT NULL,
  `hash` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_h5plibrcach_lib_ix` (`libraryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='H5P cached library assets'