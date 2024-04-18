CREATE TABLE `mdl_message_conversation_actions` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `userid` bigint(10) NOT NULL,
  `conversationid` bigint(10) NOT NULL,
  `action` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_messconvacti_use_ix` (`userid`),
  KEY `mdl_messconvacti_con_ix` (`conversationid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores all per-user actions on individual conversations'