CREATE TABLE `mdl_message_user_actions` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `userid` bigint(10) NOT NULL,
  `messageid` bigint(10) NOT NULL,
  `action` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_messuseracti_usemesact_uix` (`userid`,`messageid`,`action`),
  KEY `mdl_messuseracti_use_ix` (`userid`),
  KEY `mdl_messuseracti_mes_ix` (`messageid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores all per-user actions on individual messages'