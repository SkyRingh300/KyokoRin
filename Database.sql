CREATE TABLE IF NOT EXISTS `moe_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `account_se3ret` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `account_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `account_status` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `account_created` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `account_last_login` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `account_last_ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `account_salt` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `account_root` tinyint(1) NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `user_1` (`account_name`,`account_email`),
  KEY `user_2` (`account_name`,`account_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `moe_captcha` (
  `captcha_id` int(11) NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) NOT NULL,
  `captcha_ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `captcha_word` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `captcha_ip` (`captcha_ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1326 ;

CREATE TABLE IF NOT EXISTS `moe_option` (
  `opt_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `opt_value` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `opt_key` (`opt_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `moe_option` (`opt_key`, `opt_value`) VALUES
('meta_author', '萌导航团队'),
('meta_description', '专注发掘高质量二次元、萌、腐、宅网站及三次元小清新网站。'),
('meta_keywords', '萌导航, moe123, 动漫, 网址导航'),
('site_footer', ''),
('site_index_title', '萌导航 - 二次元导航站!'),
('site_register_enable', 'false');

CREATE TABLE IF NOT EXISTS `moe_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `moe_site_favorite` (
  `furl_id` int(11) NOT NULL AUTO_INCREMENT,
  `furl_account_id` int(11) NOT NULL,
  `furl_name` varchar(32) NOT NULL,
  `furl_host` text NOT NULL,
  `furl_url` text NOT NULL,
  `furl_favicon` varchar(32) DEFAULT NULL,
  `furl_favicon98x41` varchar(32) DEFAULT NULL,
  `furl_order` int(8) NOT NULL,
  `furl_created` int(11) NOT NULL,
  PRIMARY KEY (`furl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

CREATE TABLE IF NOT EXISTS `moe_site_icon` (
  `icon_id` int(11) NOT NULL AUTO_INCREMENT,
  `icon_host` text NOT NULL,
  `icon_size_favicon` varchar(32) DEFAULT NULL,
  `icon_size_32x32` varchar(32) DEFAULT NULL,
  `icon_size_64x64` varchar(32) DEFAULT NULL,
  `icon_size_98x41` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`icon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `moe_site_url` (
  `url_id` int(11) NOT NULL AUTO_INCREMENT,
  `url_name` varchar(32) NOT NULL,
  `url_host` text NOT NULL,
  `url_url` text NOT NULL,
  `url_favicon` varchar(32) DEFAULT NULL,
  `url_favicon98x41` varchar(32) DEFAULT NULL,
  `url_weight` int(8) NOT NULL,
  `url_group_id` int(11) DEFAULT NULL,
  `url_suggest` tinyint(1) NOT NULL,
  `url_default` tinyint(1) NOT NULL,
  `url_created` int(11) NOT NULL,
  PRIMARY KEY (`url_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

