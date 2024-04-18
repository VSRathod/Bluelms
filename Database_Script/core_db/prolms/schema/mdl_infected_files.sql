CREATE TABLE `mdl_infected_files` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `filename` longtext NOT NULL,
  `quarantinedfile` longtext DEFAULT NULL,
  `userid` bigint(10) NOT NULL,
  `reason` longtext NOT NULL,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_infefile_use_ix` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Table to store infected file details.'