CREATE TABLE `mdl_quizaccess_seb_quizsettings` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `quizid` bigint(10) NOT NULL,
  `cmid` bigint(10) NOT NULL,
  `templateid` bigint(10) NOT NULL,
  `requiresafeexambrowser` tinyint(1) NOT NULL,
  `showsebtaskbar` tinyint(1) DEFAULT NULL,
  `showwificontrol` tinyint(1) DEFAULT NULL,
  `showreloadbutton` tinyint(1) DEFAULT NULL,
  `showtime` tinyint(1) DEFAULT NULL,
  `showkeyboardlayout` tinyint(1) DEFAULT NULL,
  `allowuserquitseb` tinyint(1) DEFAULT NULL,
  `quitpassword` longtext DEFAULT NULL,
  `linkquitseb` longtext DEFAULT NULL,
  `userconfirmquit` tinyint(1) DEFAULT NULL,
  `enableaudiocontrol` tinyint(1) DEFAULT NULL,
  `muteonstartup` tinyint(1) DEFAULT NULL,
  `allowspellchecking` tinyint(1) DEFAULT NULL,
  `allowreloadinexam` tinyint(1) DEFAULT NULL,
  `activateurlfiltering` tinyint(1) DEFAULT NULL,
  `filterembeddedcontent` tinyint(1) DEFAULT NULL,
  `expressionsallowed` longtext DEFAULT NULL,
  `regexallowed` longtext DEFAULT NULL,
  `expressionsblocked` longtext DEFAULT NULL,
  `regexblocked` longtext DEFAULT NULL,
  `allowedbrowserexamkeys` longtext DEFAULT NULL,
  `showsebdownloadlink` tinyint(1) DEFAULT NULL,
  `usermodified` bigint(10) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_quizsebquiz_qui_uix` (`quizid`),
  UNIQUE KEY `mdl_quizsebquiz_cmi_uix` (`cmid`),
  KEY `mdl_quizsebquiz_tem_ix` (`templateid`),
  KEY `mdl_quizsebquiz_use_ix` (`usermodified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores the quiz level Safe Exam Browser configuration.'