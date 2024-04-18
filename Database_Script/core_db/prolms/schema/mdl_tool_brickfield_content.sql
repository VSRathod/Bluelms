CREATE TABLE `mdl_tool_brickfield_content` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `areaid` bigint(10) NOT NULL,
  `contenthash` varchar(40) NOT NULL DEFAULT '',
  `iscurrent` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `timecreated` bigint(10) NOT NULL,
  `timechecked` bigint(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_toolbriccont_sta_ix` (`status`),
  KEY `mdl_toolbriccont_iscare_ix` (`iscurrent`,`areaid`),
  KEY `mdl_toolbriccont_are_ix` (`areaid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Content of an area at a particular time (recognised by a has'