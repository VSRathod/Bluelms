CREATE TABLE `mdl_message_email_messages` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `useridto` bigint(10) NOT NULL,
  `conversationid` bigint(10) NOT NULL,
  `messageid` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_messemaimess_use_ix` (`useridto`),
  KEY `mdl_messemaimess_con_ix` (`conversationid`),
  KEY `mdl_messemaimess_mes_ix` (`messageid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Keeps track of what emails to send in an email digest'