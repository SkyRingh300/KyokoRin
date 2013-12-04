-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 11 月 29 日 10:30
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `moe123`
--

-- --------------------------------------------------------

--
-- 表的结构 `moe_account`
--

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

--
-- 转存表中的数据 `moe_account`
--

INSERT INTO `moe_account` (`account_id`, `account_name`, `account_se3ret`, `account_email`, `account_status`, `account_created`, `account_last_login`, `account_last_ip_address`, `account_salt`, `account_root`) VALUES
(1, 'wangze500', '44046e474aa4749de1079f735c6579d0', 'wangze500@gmail.com', '', '1367756472000', '1385694009', '127.0.0.1', '8248d1', 1),
(2, 'flflash', '44f0b41cf3c6c59634e0e8e0c0db7404', 'admin@pixvi.net', '', '1374995171000', '58.48.211.244', '', '3b61de', 0),
(3, 'test', 'b4d194d115bc70ddeceab6961502625e', 'test@test.com', '', '1385280747', '', '', 'b44025', 0),
(4, 'test2', '51a4e52a69242f022f8981557265ef1d', '123@123.com', '', '1385280983', '', '', '715869', 0);

-- --------------------------------------------------------

--
-- 表的结构 `moe_captcha`
--

CREATE TABLE IF NOT EXISTS `moe_captcha` (
  `captcha_id` int(11) NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) NOT NULL,
  `captcha_ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `captcha_word` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `captcha_ip` (`captcha_ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1326 ;

--
-- 转存表中的数据 `moe_captcha`
--

INSERT INTO `moe_captcha` (`captcha_id`, `captcha_time`, `captcha_ip`, `captcha_word`) VALUES
(1325, 1385694005, '127.0.0.1', '3c3oc');

-- --------------------------------------------------------

--
-- 表的结构 `moe_option`
--

CREATE TABLE IF NOT EXISTS `moe_option` (
  `opt_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `opt_value` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `opt_key` (`opt_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `moe_option`
--

INSERT INTO `moe_option` (`opt_key`, `opt_value`) VALUES
('meta_author', '萌导航团队'),
('meta_description', '专注发掘高质量二次元、萌、腐、宅网站及三次元小清新网站。'),
('meta_keywords', '萌导航, moe123, 动漫, 网址导航'),
('site_footer', '&lt;script type=&quot;text/javascript&quot; src=&quot;http://tajs.qq.com/stats?sId=22988990&quot; charset=&quot;UTF-8&quot;&gt;&lt;/script&gt;\n\n&lt;script src=&quot;http://s11.cnzz.com/stat.php?id=5310971&amp;web_id=5310971&amp;show=pic&quot; language=&quot;JavaScript&quot;&gt;&lt;/script&gt;'),
('site_index_title', '萌导航 - 二次元导航站!'),
('site_register_enable', 'false');

-- --------------------------------------------------------

--
-- 表的结构 `moe_sessions`
--

CREATE TABLE IF NOT EXISTS `moe_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `moe_sessions`
--

INSERT INTO `moe_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('06587d7267223f6b274d4844e06fb4a3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1712.4 Safari/537.36', 1385557693, 'a:2:{s:9:"user_data";s:0:"";s:7:"account";a:3:{s:10:"account_id";s:1:"1";s:12:"account_name";s:9:"wangze500";s:13:"account_email";s:19:"wangze500@gmail.com";}}'),
('0b5c8ead7cbcffccc97b9936a6e1bdd6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1712.4 Safari/537.36', 1385540769, 'a:2:{s:9:"user_data";s:0:"";s:7:"account";a:3:{s:10:"account_id";s:1:"1";s:12:"account_name";s:9:"wangze500";s:13:"account_email";s:19:"wangze500@gmail.com";}}'),
('1266be629987feef67681d8c5dd843f0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385288867, 'a:2:{s:9:"user_data";s:0:"";s:7:"account";a:3:{s:10:"account_id";s:1:"1";s:12:"account_name";s:9:"wangze500";s:13:"account_email";s:19:"wangze500@gmail.com";}}'),
('2844ff6857b702dacdbb0deb06fbd87e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385649992, 'a:2:{s:9:"user_data";s:0:"";s:7:"account";a:3:{s:10:"account_id";s:1:"1";s:12:"account_name";s:9:"wangze500";s:13:"account_email";s:19:"wangze500@gmail.com";}}'),
('359dcd569a91964e6503e6b0503a5ae5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385400767, 'a:2:{s:9:"user_data";s:0:"";s:7:"account";a:3:{s:10:"account_id";s:1:"1";s:12:"account_name";s:9:"wangze500";s:13:"account_email";s:19:"wangze500@gmail.com";}}'),
('422ed1a8a07cab76bd60cc81221ef215', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385312154, 'a:2:{s:9:"user_data";s:0:"";s:7:"account";a:3:{s:10:"account_id";s:1:"1";s:12:"account_name";s:9:"wangze500";s:13:"account_email";s:19:"wangze500@gmail.com";}}'),
('4efc4bb01463a4350f15c7198994c103', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1712.4 Safari/537.36', 1385370137, 'a:1:{s:9:"user_data";s:0:"";}'),
('8fe5a993e78adfcd88c07834bc08a722', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385288923, ''),
('b06fba8e1890fe46f8dfe8e91cb8d7c2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385287782, ''),
('d5ed37a0273c8e33b3df5fed20bf4d47', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385657848, 'a:2:{s:9:"user_data";s:0:"";s:7:"account";a:3:{s:10:"account_id";s:1:"1";s:12:"account_name";s:9:"wangze500";s:13:"account_email";s:19:"wangze500@gmail.com";}}'),
('e6d9b6f5405ef8c39144e83bf48e3d51', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1712.4 Safari/537.36', 1385720699, 'a:2:{s:9:"user_data";s:0:"";s:7:"account";a:3:{s:10:"account_id";s:1:"1";s:12:"account_name";s:9:"wangze500";s:13:"account_email";s:19:"wangze500@gmail.com";}}'),
('ef999137b54e69f8b69f0d9ea3604779', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385287734, ''),
('f849525779705e28ea72c5c4da4cd1cc', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385287602, ''),
('fb3e98930d8e6ca350d27f67d8ec2123', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0', 1385532673, '');

-- --------------------------------------------------------

--
-- 表的结构 `moe_site_favorite`
--

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

--
-- 转存表中的数据 `moe_site_favorite`
--

INSERT INTO `moe_site_favorite` (`furl_id`, `furl_account_id`, `furl_name`, `furl_host`, `furl_url`, `furl_favicon`, `furl_favicon98x41`, `furl_order`, `furl_created`) VALUES
(77, 1, '萌导航', 'www.moe123.com', 'http://www.moe123.com/', 'http://www.moe123.com/favicon.ic', NULL, 0, 1385720703);

-- --------------------------------------------------------

--
-- 表的结构 `moe_site_icon`
--

CREATE TABLE IF NOT EXISTS `moe_site_icon` (
  `icon_id` int(11) NOT NULL AUTO_INCREMENT,
  `icon_host` text NOT NULL,
  `icon_size_favicon` varchar(32) DEFAULT NULL,
  `icon_size_32x32` varchar(32) DEFAULT NULL,
  `icon_size_64x64` varchar(32) DEFAULT NULL,
  `icon_size_98x41` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`icon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `moe_site_url`
--

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

--
-- 转存表中的数据 `moe_site_url`
--

INSERT INTO `moe_site_url` (`url_id`, `url_name`, `url_host`, `url_url`, `url_favicon`, `url_favicon98x41`, `url_weight`, `url_group_id`, `url_suggest`, `url_default`, `url_created`) VALUES
(1, '萌导航', 'www.moe123.com', 'http://www.moe123.com/', 'http://www.moe123.com/favicon.ic', NULL, 0, NULL, 1, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
