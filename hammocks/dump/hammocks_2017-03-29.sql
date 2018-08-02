# ************************************************************
# Sequel Pro SQL dump
# バージョン 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# ホスト: 192.168.33.10 (MySQL 5.6.34)
# データベース: hammocks
# 作成時刻: 2017-03-29 09:10:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# テーブルのダンプ category
# ------------------------------------------------------------

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id`, `big_category_id`, `name`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,1,'テント/タープ','2010-09-17 06:24:23','1995-08-02 18:59:02',NULL),
	(2,1,'シュラフ・寝具','1975-09-08 16:08:34','1996-10-08 15:43:57',NULL),
	(3,1,'ファニチャー','2013-08-07 16:44:35','2008-01-21 09:28:27',NULL),
	(4,1,'ランタン/ライト','1977-03-01 05:49:57','1995-06-30 01:00:17',NULL),
	(5,1,'ストーブ/コンロ','1997-02-17 12:51:19','1992-08-25 15:34:27',NULL),
	(6,1,'調理器具・食事用具','1972-01-30 06:37:34','1986-10-11 16:04:02',NULL),
	(7,1,'マルチツール・ナイフ','1970-12-18 03:41:37','2016-01-27 00:15:54',NULL),
	(8,1,'燃料','1973-09-26 03:53:01','2004-04-16 12:36:37',NULL),
	(9,1,'フィールドギア','1970-10-08 07:42:32','1977-08-28 05:49:30',NULL),
	(10,2,'アウター','1976-03-27 15:40:39','1981-04-23 14:10:05',NULL),
	(11,2,'トップス',NULL,NULL,NULL),
	(12,2,'ボトムス',NULL,NULL,NULL),
	(13,2,'アンダーウェア',NULL,NULL,NULL),
	(14,2,'ウェアアクセサリー',NULL,NULL,NULL),
	(15,2,'レインウェア',NULL,NULL,NULL),
	(16,2,'フットウェア',NULL,NULL,NULL),
	(17,2,'バッグ',NULL,NULL,NULL),
	(18,2,'ウェアアクセサリー',NULL,NULL,NULL),
	(19,3,'トレッキング',NULL,NULL,NULL),
	(20,3,'クライミング',NULL,NULL,NULL),
	(21,3,'サイクル',NULL,NULL,NULL),
	(22,3,'カヌー・カヤック',NULL,NULL,NULL),
	(24,3,'フィッシング',NULL,NULL,NULL),
	(25,3,'ウインタースポーツ',NULL,NULL,NULL),
	(26,3,'トラベル',NULL,NULL,NULL),
	(27,3,'その他アクティビティ',NULL,NULL,NULL),
	(28,1,'その他アウトドアギア',NULL,NULL,NULL),
	(29,2,'その他アパレル',NULL,NULL,NULL),
	(30,4,'リメイク/カスタム',NULL,NULL,NULL),
	(31,4,'オリジナル',NULL,NULL,NULL),
	(32,4,'その他DIY・リメイク',NULL,NULL,NULL);

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# テーブルのダンプ genre
# ------------------------------------------------------------

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;

INSERT INTO `genre` (`id`, `category_id`, `name`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,1,'テント/ツェルト','2003-08-03 08:55:29','2011-03-01 22:50:08',NULL),
	(2,1,'シェルター','1979-05-18 19:43:16','1977-04-04 13:17:25',NULL),
	(3,1,'タープ','1980-06-29 12:45:30','2015-07-21 13:35:57',NULL),
	(4,2,'シュラフ','2003-11-19 13:00:59','2002-10-14 00:08:28',NULL),
	(5,2,'マット','1981-08-06 15:03:07','1981-09-02 03:52:53',NULL),
	(6,2,'コット','1996-06-16 00:17:26','2012-05-12 03:10:13',NULL),
	(7,2,'ハンモック','1988-03-16 12:25:57','1970-06-22 15:48:58',NULL),
	(8,3,'チェア','1995-10-25 15:55:43','2005-04-27 21:44:20',NULL),
	(9,3,'テーブル','1991-06-18 17:32:58','1982-10-08 15:17:20',NULL),
	(11,4,'燃料式ランタン',NULL,NULL,NULL),
	(12,4,'電池式ランタン/ライト',NULL,NULL,NULL),
	(13,5,'ツーバーナー',NULL,NULL,NULL),
	(14,5,'シングルバーナー',NULL,NULL,NULL),
	(15,5,'グリル/焚き火台',NULL,NULL,NULL),
	(16,5,'ヒーター/トーチ',NULL,NULL,NULL),
	(17,6,'テーブルウェア',NULL,NULL,NULL),
	(18,6,'クッカー',NULL,NULL,NULL),
	(19,6,'キッチンツール',NULL,NULL,NULL),
	(20,6,'ケトル/パーコレーター',NULL,NULL,NULL),
	(21,6,'ウォーターキャリー',NULL,NULL,NULL),
	(22,6,'クーラー',NULL,NULL,NULL),
	(23,6,'水筒・ボトル',NULL,NULL,NULL),
	(24,7,'マルチツール',NULL,NULL,NULL),
	(25,7,'ナイフ',NULL,NULL,NULL),
	(26,7,'手斧・ノコギリ',NULL,NULL,NULL),
	(27,8,'ガスタイプ',NULL,NULL,NULL),
	(28,8,'液体燃料',NULL,NULL,NULL),
	(29,8,'固体燃料',NULL,NULL,NULL),
	(30,8,'薪・炭',NULL,NULL,NULL),
	(31,8,'アクセサリー',NULL,NULL,NULL),
	(32,9,'キャリー・カート',NULL,NULL,NULL),
	(33,9,'カラビナ・ロープ',NULL,NULL,NULL),
	(34,9,'防虫・殺虫用品',NULL,NULL,NULL),
	(35,9,'時計・高度計・コンパス',NULL,NULL,NULL),
	(36,9,'防水・撥水スプレー',NULL,NULL,NULL),
	(38,10,'メンズ',NULL,NULL,NULL),
	(39,10,'レディース',NULL,NULL,NULL),
	(40,10,'ユニセックス',NULL,NULL,NULL),
	(41,10,'キッズ',NULL,NULL,NULL),
	(42,11,'メンズ',NULL,NULL,NULL),
	(43,11,'レディース',NULL,NULL,NULL),
	(44,11,'ユニセックス',NULL,NULL,NULL),
	(45,11,'キッズ',NULL,NULL,NULL),
	(46,12,'メンズ',NULL,NULL,NULL),
	(47,12,'レディース',NULL,NULL,NULL),
	(48,12,'ユニセックス',NULL,NULL,NULL),
	(49,12,'キッズ',NULL,NULL,NULL),
	(50,13,'メンズ',NULL,NULL,NULL),
	(51,13,'レディース',NULL,NULL,NULL),
	(52,13,'ユニセックス',NULL,NULL,NULL),
	(53,13,'キッズ',NULL,NULL,NULL),
	(54,14,'帽子',NULL,NULL,NULL),
	(55,14,'手袋・グローブ',NULL,NULL,NULL),
	(56,14,'レッグウエア',NULL,NULL,NULL),
	(57,14,'マフラー・ネックウォーマー',NULL,NULL,NULL),
	(58,14,'アイウェア',NULL,NULL,NULL),
	(59,14,'エプロン',NULL,NULL,NULL),
	(61,15,'メンズ',NULL,NULL,NULL),
	(62,15,'レディース',NULL,NULL,NULL),
	(63,15,'ユニセックス',NULL,NULL,NULL),
	(64,15,'キッズ',NULL,NULL,NULL),
	(65,16,'スニーカー',NULL,NULL,NULL),
	(66,16,'サンダル',NULL,NULL,NULL),
	(67,16,'ブーツ',NULL,NULL,NULL),
	(69,17,'バックパック・デイパック',NULL,NULL,NULL),
	(70,17,'メッセンジャーバッグ',NULL,NULL,NULL),
	(71,17,'トートバッグ',NULL,NULL,NULL),
	(72,17,'ショルダーバッグ',NULL,NULL,NULL),
	(73,17,'トラベルバッグ・ポーチ',NULL,NULL,NULL),
	(75,18,'メンテナンス用品',NULL,NULL,NULL),
	(76,24,'海釣り',NULL,NULL,NULL),
	(77,24,'ルアー',NULL,NULL,NULL),
	(78,24,'フライ',NULL,NULL,NULL),
	(79,24,'テンカラ',NULL,NULL,NULL),
	(80,24,'渓流',NULL,NULL,NULL),
	(81,24,'ウェア',NULL,NULL,NULL),
	(83,25,'スキー',NULL,NULL,NULL),
	(84,25,'スノーボード',NULL,NULL,NULL),
	(85,25,'スノートレッキング',NULL,NULL,NULL),
	(87,1,'\nテントアクセサリー',NULL,NULL,NULL),
	(99,30,'テント/タープ',NULL,NULL,NULL),
	(100,30,'シュラフ・寝具',NULL,NULL,NULL),
	(101,30,'ファニチャー',NULL,NULL,NULL),
	(102,30,'ランタン/ライト',NULL,NULL,NULL),
	(103,30,'ストーブ/コンロ',NULL,NULL,NULL),
	(104,30,'調理器具・食事用具',NULL,NULL,NULL),
	(105,30,'フィールドギア',NULL,NULL,NULL),
	(107,31,'テント/タープ',NULL,NULL,NULL),
	(108,31,'ファニチャー',NULL,NULL,NULL),
	(109,31,'ランタン/ライト',NULL,NULL,NULL),
	(110,31,'ストーブ/コンロ',NULL,NULL,NULL),
	(111,31,'調理器具・食事用具',NULL,NULL,NULL),
	(112,31,'フィールドギア',NULL,NULL,NULL),
	(100999,1,'その他',NULL,NULL,NULL),
	(200999,2,'その他',NULL,NULL,NULL),
	(300999,3,'その他','2005-07-14 20:07:07','1987-01-11 08:43:09',NULL),
	(400999,4,'その他',NULL,NULL,NULL),
	(500999,5,'その他',NULL,NULL,NULL),
	(600999,6,'その他',NULL,NULL,NULL),
	(700999,7,'その他',NULL,NULL,NULL),
	(800999,8,'その他',NULL,NULL,NULL),
	(900999,9,'その他',NULL,NULL,NULL),
	(1000999,10,'その他',NULL,NULL,NULL),
	(1100999,11,'その他',NULL,NULL,NULL),
	(1200999,12,'その他',NULL,NULL,NULL),
	(1300999,13,'その他',NULL,NULL,NULL),
	(1400999,14,'その他・小物',NULL,NULL,NULL),
	(1500999,15,'その他',NULL,NULL,NULL),
	(1600999,16,'その他',NULL,NULL,NULL),
	(1700999,17,'その他',NULL,NULL,NULL),
	(1800999,18,'その他',NULL,NULL,NULL),
	(2400999,24,'その他',NULL,NULL,NULL),
	(2500999,25,'その他',NULL,NULL,NULL),
	(3000999,30,'その他',NULL,NULL,NULL),
	(3100999,31,'その他',NULL,NULL,NULL);

/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;


# テーブルのダンプ genre_second
# ------------------------------------------------------------

LOCK TABLES `genre_second` WRITE;
/*!40000 ALTER TABLE `genre_second` DISABLE KEYS */;

INSERT INTO `genre_second` (`id`, `category_id`, `genre_id`, `name`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,4,11,'ガソリンランタン','1993-09-01 17:44:58','1973-01-03 14:26:18',NULL),
	(2,4,11,'ガスランタン','1998-08-19 12:45:15','1996-01-16 11:34:27',NULL),
	(3,4,11,'灯油ランタン','1994-05-05 12:24:36','1978-05-08 02:33:29',NULL),
	(4,4,11,'キャンドルランタン','2014-08-17 18:58:48','1971-04-26 23:22:48',NULL),
	(5,4,12,'電池式ランタン','1996-10-20 06:45:31','1970-09-28 05:25:37',NULL),
	(6,4,12,'ヘッドライト','1970-06-07 19:00:45','1980-06-18 02:14:07',NULL),
	(7,4,12,'ハンディーライト','1986-03-11 00:14:59','1992-08-18 23:42:37',NULL),
	(8,14,54,'キッズ',NULL,NULL,NULL),
	(9,14,55,'キッズ',NULL,NULL,NULL),
	(10,14,56,'キッズ',NULL,NULL,NULL),
	(11,14,57,'キッズ',NULL,NULL,NULL),
	(12,14,58,'キッズ',NULL,NULL,NULL),
	(13,16,65,'メンズ',NULL,NULL,NULL),
	(14,16,65,'レディース',NULL,NULL,NULL),
	(15,16,65,'ユニセックス',NULL,NULL,NULL),
	(16,16,65,'キッズ',NULL,NULL,NULL),
	(19,16,66,'メンズ',NULL,NULL,NULL),
	(20,16,66,'レディース',NULL,NULL,NULL),
	(21,16,66,'ユニセックス',NULL,NULL,NULL),
	(22,16,66,'キッズ',NULL,NULL,NULL),
	(23,16,67,'メンズ',NULL,NULL,NULL),
	(24,16,67,'レディース',NULL,NULL,NULL),
	(25,16,67,'ユニセックス',NULL,NULL,NULL),
	(26,16,67,'キッズ',NULL,NULL,NULL);

/*!40000 ALTER TABLE `genre_second` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
