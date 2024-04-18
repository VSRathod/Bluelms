CREATE TABLE `mdl_message_contact_requests` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `userid` bigint(10) NOT NULL,
  `requesteduserid` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_messcontrequ_usereq_uix` (`userid`,`requesteduserid`),
  KEY `mdl_messcontrequ_use_ix` (`userid`),
  KEY `mdl_messcontrequ_req_ix` (`requesteduserid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Maintains list of contact requests between users'