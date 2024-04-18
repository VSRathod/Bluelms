CREATE TABLE `mdl_h5p_library_dependencies` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `libraryid` bigint(10) NOT NULL,
  `requiredlibraryid` bigint(10) NOT NULL,
  `dependencytype` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `mdl_h5plibrdepe_lib_ix` (`libraryid`),
  KEY `mdl_h5plibrdepe_req_ix` (`requiredlibraryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores H5P library dependencies'