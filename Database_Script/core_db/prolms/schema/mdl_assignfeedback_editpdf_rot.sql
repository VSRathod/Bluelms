CREATE TABLE `mdl_assignfeedback_editpdf_rot` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `gradeid` bigint(10) NOT NULL DEFAULT 0,
  `pageno` bigint(10) NOT NULL DEFAULT 0,
  `pathnamehash` longtext NOT NULL,
  `isrotated` tinyint(1) NOT NULL DEFAULT 0,
  `degree` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_assieditrot_grapag_uix` (`gradeid`,`pageno`),
  KEY `mdl_assieditrot_gra_ix` (`gradeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores rotation information of a page.'