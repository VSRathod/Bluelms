CREATE TABLE `mdl_role_allow_view` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `roleid` bigint(10) NOT NULL,
  `allowview` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_rolealloview_rolall_uix` (`roleid`,`allowview`),
  KEY `mdl_rolealloview_rol_ix` (`roleid`),
  KEY `mdl_rolealloview_all_ix` (`allowview`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='This table stores which which other roles a user is allowed '