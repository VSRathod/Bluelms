CREATE TABLE `mdl_paygw_paypal` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `paymentid` bigint(10) NOT NULL,
  `pp_orderid` varchar(255) NOT NULL DEFAULT 'The ID of the order in PayPal',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdl_paygpayp_pay_uix` (`paymentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED COMMENT='Stores PayPal related information'