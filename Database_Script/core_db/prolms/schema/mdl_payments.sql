CREATE TABLE `mdl_payments` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `component` varchar(100) NOT NULL DEFAULT '',
  `paymentarea` varchar(50) NOT NULL DEFAULT '',
  `itemid` bigint(10) NOT NULL,
  `userid` bigint(10) NOT NULL,
  `amount` varchar(20) NOT NULL DEFAULT '',
  `currency` varchar(3) NOT NULL DEFAULT '',
  `accountid` bigint(10) NOT NULL,
  `gateway` varchar(100) NOT NULL DEFAULT '',
  `timecreated` bigint(10) NOT NULL DEFAULT 0,
  `timemodified` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `mdl_paym_gat_ix` (`gateway`),
  KEY `mdl_paym_compayite_ix` (`component`,`paymentarea`,`itemid`),
  KEY `mdl_paym_use_ix` (`userid`),
  KEY `mdl_paym_acc_ix` (`accountid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores information about payments'