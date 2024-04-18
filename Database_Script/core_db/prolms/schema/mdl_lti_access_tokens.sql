CREATE TABLE `mdl_lti_access_tokens` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `typeid` bigint(10) NOT NULL,
  `scope` longtext NOT NULL,
  `token` varchar(128) NOT NULL DEFAULT '',
  `validuntil` bigint(10) NOT NULL,
  `timecreated` bigint(10) NOT NULL,
  `lastaccess` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_ltiaccetoke_tok_uix` (`token`),
  KEY `mdl_ltiaccetoke_typ_ix` (`typeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Security tokens for accessing of LTI services'