CREATE TABLE `mdl_message_users_blocked` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `userid` bigint(10) NOT NULL,
  `blockeduserid` bigint(10) NOT NULL,
  `timecreated` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_messuserbloc_useblo_uix` (`userid`,`blockeduserid`),
  KEY `mdl_messuserbloc_use_ix` (`userid`),
  KEY `mdl_messuserbloc_blo_ix` (`blockeduserid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Maintains lists of blocked users'