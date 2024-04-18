CREATE TABLE `mdl_messages` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `useridfrom` bigint(10) NOT NULL,
  `conversationid` bigint(10) NOT NULL,
  `subject` longtext DEFAULT NULL,
  `fullmessage` longtext DEFAULT NULL,
  `fullmessageformat` tinyint(1) NOT NULL DEFAULT 0,
  `fullmessagehtml` longtext DEFAULT NULL,
  `smallmessage` longtext DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `fullmessagetrust` tinyint(2) NOT NULL DEFAULT 0,
  `customdata` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_mess_contim_ix` (`conversationid`,`timecreated`),
  KEY `mdl_mess_use_ix` (`useridfrom`),
  KEY `mdl_mess_con_ix` (`conversationid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores all messages'