-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 22, 2012 at 04:14 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `a_ypages`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_error`
--

CREATE TABLE IF NOT EXISTS `db_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `error_str` mediumtext,
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='数据库错误记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yp_address`
--

CREATE TABLE IF NOT EXISTS `yp_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `pguid` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '每个POI方案的唯一标示',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `x` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '经度',
  `y` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '纬度',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_read` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_fix_address` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0用户添加的，1被修正的',
  `is_approval` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `help_sum` int(10) unsigned NOT NULL DEFAULT '0',
  `wrong_sum` int(10) unsigned NOT NULL DEFAULT '0',
  `is_custom` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source_data` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `yp_address`
--

INSERT INTO `yp_address` (`id`, `cid`, `pguid`, `title`, `address`, `tel`, `x`, `y`, `uid`, `username`, `is_read`, `is_fix_address`, `is_approval`, `help_sum`, `wrong_sum`, `is_custom`, `remark`, `source_data`, `create_time`) VALUES
(1, 1, '0', 'This_is_2012-06-22 10:21:58', '中山路241号', '13800138000', '114.091125', '22.538183', 1, 'itotem', 0, 0, 0, 1, 1, 0, '备注信息', '', 1340334094),
(2, 1, 'B02F37UR05', 'This_is_2012-06-22 11:11:05', '中山路241号', '13800138000', '114.091125', '22.538183', 1, 'itotem', 0, 0, 0, 0, 0, 0, '备注信息', '', 1340334667),
(3, 1, '', 'This_is_2012-06-22 13:33:35', '中山路241号', '13800138000', '114.091125', '22.538183', 0, '', 0, 0, 0, 0, 0, 0, '备注信息', '', 1340346297),
(4, 1, '', 'This_is_2012-06-22 13:33:35', '中山路241号', '13800138000', '114.091125', '22.538183', 0, '', 0, 0, 0, 0, 0, 0, '备注信息', '', 1340346439);

-- --------------------------------------------------------

--
-- Table structure for table `yp_address_categories`
--

CREATE TABLE IF NOT EXISTS `yp_address_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `search_code` varchar(255) NOT NULL,
  `ranking` smallint(6) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `yp_address_categories`
--

INSERT INTO `yp_address_categories` (`id`, `pid`, `title`, `search_code`, `ranking`) VALUES
(1, 0, '公司企业', '17', 0),
(2, 0, '科教文化服务', '14', 0),
(3, 0, '交通设施服务', '15', 0),
(4, 0, '餐饮服务', '05', 0),
(5, 0, '公共设施', '20', 0),
(6, 0, '政府机构及社会团体', '13', 0),
(7, 0, '生活服务', '07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `yp_admins`
--

CREATE TABLE IF NOT EXISTS `yp_admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `grade` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1 normal, 9 super administrator',
  `is_disable` tinyint(3) unsigned NOT NULL COMMENT '0 enable, 1 disable',
  `last_login_ip` int(10) unsigned NOT NULL COMMENT '上次登录ip',
  `last_login_time` int(10) unsigned NOT NULL COMMENT '上次登录时间',
  `edit_time` int(10) unsigned NOT NULL COMMENT '修改时间',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='administrator users' AUTO_INCREMENT=9 ;

--
-- Dumping data for table `yp_admins`
--

INSERT INTO `yp_admins` (`id`, `username`, `password`, `grade`, `is_disable`, `last_login_ip`, `last_login_time`, `edit_time`, `create_time`) VALUES
(1, 'owen', 'a70e57adb0c7a5119012d72b26855b4a', 9, 0, 1270, 1340331441, 0, 0),
(5, 'aaaaaa', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 9, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `yp_cache`
--

CREATE TABLE IF NOT EXISTS `yp_cache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'cache type',
  `is_string` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='cache the serialize string' AUTO_INCREMENT=30 ;

--
-- Dumping data for table `yp_cache`
--

INSERT INTO `yp_cache` (`id`, `type`, `is_string`, `content`) VALUES
(1, 'manage_user_type', 0, 'a:1:{s:16:"manage_user_type";s:76:"正式编辑\r\n实习编辑\r\n产品经理\r\n总编辑\r\n工程师\r\n超级权限";}'),
(2, 'default_images', 0, 'a:1:{s:14:"default_images";a:3:{i:0;s:42:"http://www.baidu.com/img/baidu_sylogo1.gif";i:1;s:0:"";i:2;s:0:"";}}'),
(28, 'index_page', 0, 'a:2:{s:2:"id";a:2:{i:0;s:3:"617";i:1;s:1:"1";}s:8:"row_type";a:2:{i:0;s:1:"1";i:1;s:1:"2";}}'),
(13, 'transition_page', 0, 'a:1:{s:15:"transition_page";a:2:{i:0;s:63:"http://farm3.static.flickr.com/2034/5820984954_4177f8fc1f_m.jpg";i:1;s:45:"http://img.caixin.cn/2010-04-19/100136643.jpg";}}'),
(29, 'soft_version', 0, 'a:1:{s:12:"soft_version";a:2:{i:0;a:2:{i:0;s:3:"3.0";i:1;s:53:"http://itunes.apple.com/cn/app//id356023612?l=en&mt=8";}i:1;a:2:{i:0;s:4:"2.00";i:1;s:2:"2u";}}}');

-- --------------------------------------------------------

--
-- Table structure for table `yp_feedbacks`
--

CREATE TABLE IF NOT EXISTS `yp_feedbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='意见反馈' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `yp_feedbacks`
--

INSERT INTO `yp_feedbacks` (`id`, `content`, `contact`, `uid`, `username`, `create_time`) VALUES
(1, 'I_Love_It 2012-06-21 23:55:18', '13800138000', 1, 'itotem', 1340294720);

-- --------------------------------------------------------

--
-- Table structure for table `yp_helps`
--

CREATE TABLE IF NOT EXISTS `yp_helps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reply_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='互助' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `yp_helps`
--

INSERT INTO `yp_helps` (`id`, `pid`, `title`, `reply_content`, `uid`, `username`, `create_time`) VALUES
(1, 0, 'I_Need_Help 2012-06-22 00:36:01', '', 1, 'itotem', 1340296939);

-- --------------------------------------------------------

--
-- Table structure for table `_yp_address_custom`
--

CREATE TABLE IF NOT EXISTS `_yp_address_custom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` tinyint(4) NOT NULL DEFAULT '0',
  `source_id` int(10) unsigned NOT NULL COMMENT '和某个地址关联',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `x` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '经度',
  `y` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '纬度',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_read` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_fix_address` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0用户添加的，1被修正的',
  `is_approval` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
