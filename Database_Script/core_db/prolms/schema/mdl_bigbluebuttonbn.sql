CREATE TABLE `mdl_bigbluebuttonbn` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) NOT NULL DEFAULT 0,
  `course` bigint(10) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `intro` longtext DEFAULT NULL,
  `introformat` smallint(4) NOT NULL DEFAULT 1,
  `meetingid` varchar(255) NOT NULL DEFAULT '',
  `moderatorpass` varchar(255) NOT NULL DEFAULT '',
  `viewerpass` varchar(255) NOT NULL DEFAULT '',
  `wait` tinyint(1) NOT NULL DEFAULT 0,
  `record` tinyint(1) NOT NULL DEFAULT 0,
  `recordallfromstart` tinyint(1) NOT NULL DEFAULT 0,
  `recordhidebutton` tinyint(1) NOT NULL DEFAULT 0,
  `welcome` longtext DEFAULT NULL,
  `voicebridge` mediumint(5) NOT NULL DEFAULT 0,
  `openingtime` bigint(10) NOT NULL DEFAULT 0,
  `closingtime` bigint(10) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  `presentation` longtext DEFAULT NULL,
  `participants` longtext DEFAULT NULL,
  `userlimit` smallint(3) NOT NULL DEFAULT 0,
  `recordings_html` tinyint(1) NOT NULL DEFAULT 0,
  `recordings_deleted` tinyint(1) NOT NULL DEFAULT 1,
  `recordings_imported` tinyint(1) NOT NULL DEFAULT 0,
  `recordings_preview` tinyint(1) NOT NULL DEFAULT 0,
  `clienttype` tinyint(1) NOT NULL DEFAULT 0,
  `muteonstart` tinyint(1) NOT NULL DEFAULT 0,
  `disablecam` tinyint(1) NOT NULL DEFAULT 0,
  `disablemic` tinyint(1) NOT NULL DEFAULT 0,
  `disableprivatechat` tinyint(1) NOT NULL DEFAULT 0,
  `disablepublicchat` tinyint(1) NOT NULL DEFAULT 0,
  `disablenote` tinyint(1) NOT NULL DEFAULT 0,
  `hideuserlist` tinyint(1) NOT NULL DEFAULT 0,
  `lockedlayout` tinyint(1) NOT NULL DEFAULT 0,
  `completionattendance` int(9) NOT NULL DEFAULT 0,
  `completionengagementchats` int(9) NOT NULL DEFAULT 0,
  `completionengagementtalks` int(9) NOT NULL DEFAULT 0,
  `completionengagementraisehand` int(9) NOT NULL DEFAULT 0,
  `completionengagementpollvotes` int(9) NOT NULL DEFAULT 0,
  `completionengagementemojis` int(9) NOT NULL DEFAULT 0,
  `guestallowed` tinyint(2) DEFAULT 0,
  `mustapproveuser` tinyint(2) DEFAULT 1,
  `guestlinkuid` varchar(1024) DEFAULT NULL,
  `guestpassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='The bigbluebuttonbn table to store information about a meeti'