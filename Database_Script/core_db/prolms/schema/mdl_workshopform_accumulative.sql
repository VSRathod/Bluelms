CREATE TABLE `mdl_workshopform_accumulative` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `workshopid` bigint(10) NOT NULL,
  `sort` bigint(10) DEFAULT 0,
  `description` longtext DEFAULT NULL,
  `descriptionformat` smallint(3) DEFAULT 0,
  `grade` bigint(10) NOT NULL,
  `weight` mediumint(5) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `mdl_workaccu_wor_ix` (`workshopid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='The assessment dimensions definitions of Accumulative gradin'