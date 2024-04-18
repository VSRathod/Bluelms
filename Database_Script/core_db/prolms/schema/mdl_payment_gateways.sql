CREATE TABLE `mdl_payment_gateways` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `accountid` bigint(10) NOT NULL,
  `gateway` varchar(100) NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `config` longtext DEFAULT NULL,
  `timecreated` bigint(10) NOT NULL,
  `timemodified` bigint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mdl_paymgate_acc_ix` (`accountid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Configuration for one gateway for one payment account'