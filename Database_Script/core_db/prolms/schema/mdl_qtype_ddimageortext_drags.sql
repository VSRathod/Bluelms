CREATE TABLE `mdl_qtype_ddimageortext_drags` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `questionid` bigint(10) NOT NULL DEFAULT 0,
  `no` bigint(10) NOT NULL DEFAULT 0,
  `draggroup` bigint(10) NOT NULL DEFAULT 0,
  `infinite` smallint(4) NOT NULL DEFAULT 0,
  `label` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_qtypddimdrag_que_ix` (`questionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Images to drag. Actual file names are not stored here we use'