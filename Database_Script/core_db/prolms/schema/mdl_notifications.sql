CREATE TABLE `mdl_notifications` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `useridfrom` bigint(10) NOT NULL,
  `useridto` bigint(10) NOT NULL,
  `subject` longtext DEFAULT NULL,
  `fullmessage` longtext DEFAULT NULL,
  `fullmessageformat` tinyint(1) NOT NULL DEFAULT 0,
  `fullmessagehtml` longtext DEFAULT NULL,
  `smallmessage` longtext DEFAULT NULL,
  `component` varchar(100) DEFAULT NULL,
  `eventtype` varchar(100) DEFAULT NULL,
  `contexturl` longtext DEFAULT NULL,
  `contexturlname` longtext DEFAULT NULL,
  `timeread` bigint(10) DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `customdata` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_noti_use_ix` (`useridfrom`),
  KEY `mdl_noti_use2_ix` (`useridto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores all notifications'