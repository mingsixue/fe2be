/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50638
 Source Host           : localhost
 Source Database       : mx

 Target Server Type    : MySQL
 Target Server Version : 50638
 File Encoding         : utf-8

 Date: 03/28/2018 17:03:51 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `my_table`
-- ----------------------------
DROP TABLE IF EXISTS `my_table`;
CREATE TABLE `my_table` (
  `id` int(7) NOT NULL /*!50606 COLUMN_FORMAT FIXED */ AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `my_table`
-- ----------------------------
BEGIN;
INSERT INTO `my_table` VALUES ('1', 'vic', 'title vic', 'vic@mx.com'), ('2', 'nlx', 'nlx\'s', 'nlx@163.com'), ('3', '111ss', '11', '22@11.cn'), ('6', 'liangxiao', 'lx', 'lx@kl.com'), ('7', 'huaxiaoshu', 'hxs', 'hxs@tjg.com'), ('8', 'liuyingyin', 'lyy', 'lyy@tsp.com'), ('9', 'huasheng', 'hs', 'hs@jgm.com'), ('10', 'huaqingyua', 'hqy', 'hqy@tjg.com'), ('11', 'huamurong', 'hmr', 'hmr@tjg.com'), ('12', 'huajingyua', 'hjy', 'hjy@tjg.com'), ('13', 'yunsu', 'ys', 'ty@ty.com'), ('14', 'chuxianliu', 'cxl', 'cxl@txsz.com'), ('15', 'yyk', 'yyk', ''), ('16', 'yyk2', 'yyk2', ''), ('17', 'hc', 'hc', '');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
