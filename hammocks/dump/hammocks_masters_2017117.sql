# ************************************************************
# Sequel Pro SQL dump
# バージョン 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# ホスト: 192.168.33.10 (MySQL 5.6.31-log)
# データベース: hammocks
# 作成時刻: 2017-01-17 11:16:21 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# テーブルのダンプ mst_delivery_company
# ------------------------------------------------------------

LOCK TABLES `mst_delivery_company` WRITE;
/*!40000 ALTER TABLE `mst_delivery_company` DISABLE KEYS */;

INSERT INTO `mst_delivery_company` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'クロネコヤマト',NULL,NULL,NULL),
	(2,'ゆうパック',NULL,NULL,NULL),
	(3,'ゆうメール',NULL,NULL,NULL),
	(4,'ポスバケット',NULL,NULL,NULL);

/*!40000 ALTER TABLE `mst_delivery_company` ENABLE KEYS */;
UNLOCK TABLES;


# テーブルのダンプ mst_item_conditions
# ------------------------------------------------------------

LOCK TABLES `mst_item_conditions` WRITE;
/*!40000 ALTER TABLE `mst_item_conditions` DISABLE KEYS */;

INSERT INTO `mst_item_conditions` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,'新品、未使用',NULL,NULL,NULL),
	(2,'未使用に近い',NULL,NULL,NULL),
	(3,'目立った傷や汚れなし',NULL,NULL,NULL),
	(4,'やや傷や汚れあり',NULL,NULL,NULL),
	(5,'傷や汚れあり',NULL,NULL,NULL),
	(6,'全体的に状態が悪い',NULL,NULL,NULL);

/*!40000 ALTER TABLE `mst_item_conditions` ENABLE KEYS */;
UNLOCK TABLES;


# テーブルのダンプ mst_payment_conditons
# ------------------------------------------------------------




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
