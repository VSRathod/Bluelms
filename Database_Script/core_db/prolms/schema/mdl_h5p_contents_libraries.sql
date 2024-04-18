CREATE TABLE `mdl_h5p_contents_libraries` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `h5pid` bigint(10) NOT NULL,
  `libraryid` bigint(10) NOT NULL,
  `dependencytype` varchar(10) NOT NULL DEFAULT '',
  `dropcss` tinyint(1) NOT NULL,
  `weight` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_h5pcontlibr_h5p_ix` (`h5pid`),
  KEY `mdl_h5pcontlibr_lib_ix` (`libraryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Store which library is used in which content.'