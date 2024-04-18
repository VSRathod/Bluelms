CREATE TABLE `mdl_message_conversation_members` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `conversationid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_messconvmemb_con_ix` (`conversationid`),
  KEY `mdl_messconvmemb_use_ix` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores all members in a conversations'