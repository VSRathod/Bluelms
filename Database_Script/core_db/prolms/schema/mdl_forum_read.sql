CREATE TABLE `mdl_forum_read` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `userid` bigint(10) NOT NULL DEFAULT 0,
  `forumid` bigint(10) NOT NULL DEFAULT 0,
  `discussionid` bigint(10) NOT NULL DEFAULT 0,
  `postid` bigint(10) NOT NULL DEFAULT 0,
  `firstread` bigint(10) NOT NULL DEFAULT 0,
  `lastread` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_foruread_foruse_ix` (`forumid`,`userid`),
  KEY `mdl_foruread_disuse_ix` (`discussionid`,`userid`),
  KEY `mdl_foruread_posuse_ix` (`postid`,`userid`),
  KEY `mdl_foruread_use_ix` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Tracks each users read posts'