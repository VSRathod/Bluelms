CREATE TABLE `mdl_h5pactivity_attempts_results` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `attemptid` bigint(10) NOT NULL,
  `subcontent` varchar(128) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `interactiontype` varchar(128) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `correctpattern` longtext DEFAULT NULL,
  `response` longtext NOT NULL,
  `additionals` longtext DEFAULT NULL,
  `rawscore` bigint(10) NOT NULL DEFAULT 0,
  `maxscore` bigint(10) NOT NULL DEFAULT 0,
  `duration` bigint(10) DEFAULT 0,
  `completion` tinyint(1) DEFAULT NULL,
  `success` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_h5paatteresu_atttim_ix` (`attemptid`,`timecreated`),
  KEY `mdl_h5paatteresu_att_ix` (`attemptid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='H5Pactivities_attempts tracking info'