CREATE TABLE `mdl_qtype_essay_options` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `questionid` bigint(10) NOT NULL,
  `responseformat` varchar(16) NOT NULL DEFAULT 'editor',
  `responserequired` tinyint(2) NOT NULL DEFAULT 1,
  `responsefieldlines` smallint(4) NOT NULL DEFAULT 15,
  `minwordlimit` bigint(10) DEFAULT NULL,
  `maxwordlimit` bigint(10) DEFAULT NULL,
  `attachments` smallint(4) NOT NULL DEFAULT 0,
  `attachmentsrequired` smallint(4) NOT NULL DEFAULT 0,
  `graderinfo` longtext DEFAULT NULL,
  `graderinfoformat` smallint(4) NOT NULL DEFAULT 0,
  `responsetemplate` longtext DEFAULT NULL,
  `responsetemplateformat` smallint(4) NOT NULL DEFAULT 0,
  `maxbytes` bigint(10) NOT NULL DEFAULT 0,
  `filetypeslist` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_qtypessaopti_que_uix` (`questionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Extra options for essay questions.'