CREATE TABLE `mdl_search_index_requests` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `contextid` bigint(10) NOT NULL,
  `searcharea` varchar(255) NOT NULL DEFAULT '',
  `timerequested` bigint(10) NOT NULL,
  `partialarea` varchar(255) NOT NULL DEFAULT '',
  `partialtime` bigint(10) NOT NULL,
  `indexpriority` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_searinderequ_indtim_ix` (`indexpriority`,`timerequested`),
  KEY `mdl_searinderequ_con_ix` (`contextid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Records requests for (re)indexing of specific contexts. Entr'