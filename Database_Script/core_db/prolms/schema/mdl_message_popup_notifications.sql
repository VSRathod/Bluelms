CREATE TABLE `mdl_message_popup_notifications` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `notificationid` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_messpopunoti_not_ix` (`notificationid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='List of notifications to display in the message output popup'