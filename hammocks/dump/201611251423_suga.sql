-- MySQL dump 10.13  Distrib 5.6.34, for Linux (x86_64)
--
-- Host: localhost    Database: hammocks
-- ------------------------------------------------------
-- Server version	5.6.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `admin_user_account`
--

LOCK TABLES `admin_user_account` WRITE;
/*!40000 ALTER TABLE `admin_user_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `brand_category`
--

LOCK TABLES `brand_category` WRITE;
/*!40000 ALTER TABLE `brand_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `brand_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (0,'hammocks',NULL,NULL,'ハンモックス',NULL,'hammocks','','',NULL,NULL,NULL),(1,'BlueRidgeChairWorks','https://tanabe.biz/perspiciatis-recusandae-harum-vel.html','','ブルーリッジチェアワークス','','BlueRidgeChairWorks','','','1972-02-13 06:46:53','2016-08-12 13:47:10',NULL),(2,'A＆F','http://www.nagisa.net/impedit-voluptas-cupiditate-iste-et-inventore.html','','エイアンドエフ','','A＆F','','','2003-05-01 06:28:08','1971-08-24 22:26:38',NULL),(3,'C&C.P.H.EQUIPEMENT','http://hirokawa.biz/beatae-veritatis-ut-ab-ipsum-quis-nulla.html','','シー アンド シー ピー エイチ イクイップメント','','C&C.P.H.EQUIPEMENT','','','1995-08-22 20:32:03','1970-08-05 20:21:00',NULL),(4,'DUG','https://www.hirokawa.biz/atque-aliquam-ut-necessitatibus-voluptatem','','ダグ','','DUG','','','2005-07-18 18:43:23','1988-05-06 10:27:49',NULL),(5,'Esbit','http://yoshimoto.com/expedita-qui-corporis-iste-voluptas-fugit-necessitatibus.html','','エスビット','','Esbit','','','1978-01-03 20:10:58','1987-01-04 16:05:33',NULL),(6,'gearholic','http://www.uno.com/quia-qui-porro-labore-illum-ea-sunt-aut','','ギアホリック','','gearholic','','','1985-12-13 20:32:21','1988-04-14 05:26:43',NULL),(7,'HALF TRACK PRODUCTS','http://www.nagisa.biz/','','ハーフトラックプロダクツ','','HALF TRACK PRODUCTS','','','1991-07-21 14:25:58','1983-11-29 17:40:25',NULL),(8,'LOCUS GEAR','http://yoshimoto.jp/sed-doloremque-optio-eveniet-ut-maiores-perspiciatis-corrupti','','ローカス ギア','','LOCUS GEAR','','','2011-06-13 17:43:24','2008-03-07 18:39:04',NULL),(9,'NANGA','https://www.kudo.biz/nihil-ut-ut-modi-autem-illum-placeat-ad-sed','','ナンガ','','NANGA','','','1993-04-25 22:35:31','1990-02-26 22:14:19',NULL),(10,'武井バーナー','http://www.nagisa.biz/','','タケイバーナー','','武井バーナー','','','2012-07-24 04:37:52','1990-06-02 20:07:05',NULL),(11,'myX × Nanga',NULL,NULL,'マイクス　ナンガ',NULL,'myX × Nanga','','',NULL,NULL,NULL),(12,'NORDISK',NULL,NULL,'ノルディスク',NULL,'NORDISK','','',NULL,NULL,NULL),(13,'snow peak',NULL,NULL,'スノーピーク',NULL,'snow peak','','',NULL,NULL,NULL),(14,'Coleman',NULL,NULL,'コールマン',NULL,'Coleman','','',NULL,NULL,NULL),(15,'Coleman x Monro Indigo Label ',NULL,NULL,NULL,NULL,'Coleman x Monro Indigo Label ','','',NULL,NULL,NULL),(16,'196',NULL,NULL,'イチキュウロク',NULL,'196','','',NULL,NULL,NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `brands_has_count`
--

LOCK TABLES `brands_has_count` WRITE;
/*!40000 ALTER TABLE `brands_has_count` DISABLE KEYS */;
INSERT INTO `brands_has_count` VALUES (1,1,1,'2016-11-01 09:32:24','2016-11-01 09:32:24',NULL),(2,11,1,'2016-11-02 05:25:15','2016-11-02 05:25:15',NULL),(3,12,1,'2016-11-02 09:57:42','2016-11-02 09:57:42',NULL),(4,13,3,'2016-11-02 10:11:26','2016-11-02 10:20:15',NULL),(5,15,2,'2016-11-02 10:34:21','2016-11-08 04:40:59',NULL),(6,14,1,'2016-11-02 10:36:13','2016-11-02 10:36:13',NULL),(7,9,1,'2016-11-03 03:46:43','2016-11-03 03:46:43',NULL),(8,7,1,'2016-11-03 03:51:04','2016-11-03 03:51:04',NULL),(9,10000,1,'2016-11-07 10:02:18','2016-11-07 10:02:18',NULL),(10,3,1,'2016-11-08 04:36:47','2016-11-08 04:36:47',NULL),(11,10,1,'2016-11-08 04:51:19','2016-11-08 04:51:19',NULL),(12,8,1,'2016-11-08 04:53:30','2016-11-08 04:53:30',NULL),(13,5,1,'2016-11-08 07:51:24','2016-11-08 07:51:24',NULL),(14,4,1,'2016-11-08 07:55:46','2016-11-08 07:55:46',NULL);
/*!40000 ALTER TABLE `brands_has_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,1,'テント/タープ','2010-09-17 04:24:23','1995-08-02 16:59:02',NULL),(2,1,'寝袋・シュラフ','1975-09-08 15:08:34','1996-10-08 13:43:57',NULL),(3,1,'ファニチャー','2013-08-07 14:44:35','2008-01-21 08:28:27',NULL),(4,1,'ランタン/ライト','1977-03-01 04:49:57','1995-06-29 23:00:17',NULL),(5,1,'ストーブ/コンロ','1997-02-17 11:51:19','1992-08-25 13:34:27',NULL),(6,1,'調理器具・食事用具','1972-01-30 05:37:34','1986-10-11 15:04:02',NULL),(7,2,'sed','1970-12-18 02:41:37','2016-01-26 23:15:54',NULL),(8,2,'laborum','1973-09-26 02:53:01','2004-04-16 10:36:37',NULL),(9,2,'animi','1970-10-08 06:42:32','1977-08-28 04:49:30',NULL),(10,3,'冬用','1976-03-27 14:40:39','1981-04-23 12:10:05',NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `category_count`
--

LOCK TABLES `category_count` WRITE;
/*!40000 ALTER TABLE `category_count` DISABLE KEYS */;
INSERT INTO `category_count` VALUES (1,10,9,'2016-11-01 09:32:24','2016-11-03 03:51:04',NULL),(2,2,1,'2016-11-02 10:20:15','2016-11-02 10:20:15',NULL),(3,1,2,'2016-11-07 10:02:18','2016-11-08 04:53:30',NULL),(4,3,1,'2016-11-08 04:36:47','2016-11-08 04:36:47',NULL),(5,4,1,'2016-11-08 04:40:59','2016-11-08 04:40:59',NULL),(6,5,2,'2016-11-08 04:51:19','2016-11-08 07:51:24',NULL),(7,6,1,'2016-11-08 07:55:46','2016-11-08 07:55:46',NULL);
/*!40000 ALTER TABLE `category_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `container`
--

LOCK TABLES `container` WRITE;
/*!40000 ALTER TABLE `container` DISABLE KEYS */;
/*!40000 ALTER TABLE `container` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,3,'チェア','2003-08-03 06:55:29','2011-03-01 21:50:08',NULL),(2,3,'テーブル','1979-05-18 18:43:16','1977-04-04 12:17:25',NULL),(3,4,'燃料式ランタン','1980-06-29 10:45:30','2015-07-21 11:35:57',NULL),(4,4,'電池式ランタン/ライト','2003-11-19 12:00:59','2002-10-13 22:08:28',NULL),(5,5,'ツーバーナー','1981-08-06 13:03:07','1981-09-02 01:52:53',NULL),(6,5,'シングルバーナー','1996-06-15 22:17:26','2012-05-12 01:10:13',NULL),(7,5,'グリル/焚き火台','1988-03-16 11:25:57','1970-06-22 14:48:58',NULL),(8,5,'ヒーター/トーチ','1995-10-25 14:55:43','2005-04-27 19:44:20',NULL),(9,6,'テーブルウェア','1991-06-18 15:32:58','1982-10-08 14:17:20',NULL),(10,6,'クッカー','2005-07-14 18:07:07','1987-01-11 07:43:09',NULL);
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genre_count`
--

LOCK TABLES `genre_count` WRITE;
/*!40000 ALTER TABLE `genre_count` DISABLE KEYS */;
INSERT INTO `genre_count` VALUES (1,1,14,'2016-11-01 09:32:24','2016-11-08 07:55:46',NULL),(2,0,3,'2016-11-02 10:20:15','2016-11-08 04:53:30',NULL);
/*!40000 ALTER TABLE `genre_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genre_second`
--

LOCK TABLES `genre_second` WRITE;
/*!40000 ALTER TABLE `genre_second` DISABLE KEYS */;
INSERT INTO `genre_second` VALUES (1,4,3,'ガソリンランタン','1993-09-01 15:44:58','1973-01-03 13:26:18',NULL),(2,4,3,'ガスランタン','1998-08-19 10:45:15','1996-01-16 10:34:27',NULL),(3,4,3,'灯油ランタン','1994-05-05 10:24:36','1978-05-08 01:33:29',NULL),(4,4,3,'キャンドルランタン','2014-08-17 16:58:48','1971-04-26 22:22:48',NULL),(5,4,4,'電池式ランタン','1996-10-20 04:45:31','1970-09-28 04:25:37',NULL),(6,4,4,'ヘッドライト','1970-06-07 18:00:45','1980-06-18 00:14:07',NULL),(7,4,4,'ハンディーライト','1986-03-10 23:14:59','1992-08-18 21:42:37',NULL);
/*!40000 ALTER TABLE `genre_second` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genre_second_count`
--

LOCK TABLES `genre_second_count` WRITE;
/*!40000 ALTER TABLE `genre_second_count` DISABLE KEYS */;
INSERT INTO `genre_second_count` VALUES (1,1,5,'2016-11-01 09:32:24','2016-11-08 04:40:59',NULL),(2,0,12,'2016-11-02 10:11:26','2016-11-08 07:55:46',NULL);
/*!40000 ALTER TABLE `genre_second_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `item2container`
--

LOCK TABLES `item2container` WRITE;
/*!40000 ALTER TABLE `item2container` DISABLE KEYS */;
/*!40000 ALTER TABLE `item2container` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `item_evaluation`
--

LOCK TABLES `item_evaluation` WRITE;
/*!40000 ALTER TABLE `item_evaluation` DISABLE KEYS */;
INSERT INTO `item_evaluation` VALUES (1,1,5.00,'2016-11-07 08:48:22','2016-11-07 08:48:22',NULL);
/*!40000 ALTER TABLE `item_evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `item_evaluation_users`
--

LOCK TABLES `item_evaluation_users` WRITE;
/*!40000 ALTER TABLE `item_evaluation_users` DISABLE KEYS */;
INSERT INTO `item_evaluation_users` VALUES (1,11,1,5,'2016-11-07 08:48:22','2016-11-07 08:48:22',NULL);
/*!40000 ALTER TABLE `item_evaluation_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,10,1,1,1,1,'ドクトルG','/public_items/1.jpg','http://www.vic2.jp/',0,0,1,'','2016-11-01 08:32:21','2016-11-18 05:05:16',NULL),(2,10,1,1,11,1,'Envelope600STD','/public_items/2','https://www.google.co.jp/search?q=Myx+%E3%83%8A%E3%83%B3%E3%82%AC&safe=off&biw=1429&bih=1113&source=lnms&tbm=isch&sa=X&ved=0ahUKEwiQ5-Drt4nQAhXJv7wKHbHuCkwQ_AUICSgC',0,0,1,'','2016-11-02 04:25:14','2016-11-02 09:14:15',NULL),(3,10,1,1,12,1,'Reisa 6 PU Dusty Green','/public_items/3.jpg','http://item.rakuten.co.jp/canpanera/n13002/',0,1,0,'','2016-11-02 08:57:41','2016-11-02 09:14:13',NULL),(4,10,1,0,13,1,'ソリッドステーク30','/public_items/4.jpg','https://store.snowpeak.co.jp/page/34',0,0,1,'','2016-11-02 09:11:25','2016-11-02 09:14:11',NULL),(5,10,1,0,13,1,'ソリッドステーク20','/public_items/5.jpg','https://store.snowpeak.co.jp/page/34',0,0,1,'','2016-11-02 09:16:45','2016-11-02 09:38:48',NULL),(6,2,0,0,13,1,'ソリッドステーク40','/public_items/6.jpg','https://store.snowpeak.co.jp/page/34',0,0,0,'','2016-11-02 09:20:14','2016-11-02 09:20:14',NULL),(7,10,1,0,15,1,'XPヘキサタープ/MDX','/public_items/7.jpg','https://ec.coleman.co.jp/item/IS00060N05625.html',0,1,0,'','2016-11-02 09:34:20','2016-11-02 09:39:03',NULL),(8,10,1,1,14,1,'XPヘキサタープ MDX','/public_items/8.jpg','http://ec.coleman.co.jp/item/IS00060N05010.html',0,0,0,'','2016-11-02 09:36:13','2016-11-02 09:36:13',NULL),(9,10,1,0,9,1,'AURORA light 350DX','/public_items/9.jpg','http://www.be-tackle.com/outdoor.index/sleepingbag.htm/nanga/down4tipe/aurora/aurora_light.htm',0,0,0,'','2016-11-03 02:46:40','2016-11-03 02:46:40',NULL),(10,10,1,0,7,1,'wet cover pocket　ウッドランドカモ','/public_items/10','https://halftrack.stores.jp/items/575d58c4a458c04adb00e6af',0,0,0,'','2016-11-03 02:51:02','2016-11-03 02:51:02',NULL),(11,1,0,0,10000,1,'hammocks 2017 Products','/public_items/11.png',NULL,0,0,0,'','2016-11-07 09:02:18','2016-11-07 09:02:18',NULL),(12,3,1,0,3,1,'コンパクトチェアカバー カモ×デニム','/public_items/12.jpg','http://item.rakuten.co.jp/naturum/2761281/?scid=af_pc_etc&sc2id=346218181',0,0,0,'','2016-11-08 03:36:46','2016-11-08 03:36:46',NULL),(13,4,1,1,15,1,'IP 2500 ノーススターLPガスランタン（ネイビー）','/public_items/13.jpg','http://www.goo.ne.jp/green/column/camphack-1164.html',0,0,0,'','2016-11-08 03:40:59','2016-11-08 03:40:59',NULL),(14,5,1,0,10,1,'パープルストーブ　501Aセット','/public_items/14.jpg','http://webshop.wild1.co.jp/shop/g/g2200020003083/',0,0,0,'','2016-11-08 03:51:11','2016-11-08 03:51:11',NULL),(15,1,0,0,8,1,'ソリス・シル','/public_items/15.jpg','https://locusgear.com/items/soris-sil/',0,0,0,'','2016-11-08 03:53:29','2016-11-08 03:53:29',NULL),(16,5,1,0,5,1,'ポケットストーブ  ミリタリー','/public_items/16.jpg','http://item.rakuten.co.jp/canpanera/e04005-1/',0,0,0,'','2016-11-08 06:51:20','2016-11-08 06:51:20',NULL),(17,6,1,0,4,1,'HEAT-1 DG-1100','/public_items/17.jpg','http://tsugaike.blogspot.jp/2014/01/sod-310-heat-1hg-1100.html',0,0,0,'','2016-11-08 06:55:45','2016-11-08 06:55:45',NULL);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_06_07_173100_create_user_items_table',1),('2016_06_14_074447_create_user_item_imgs',1),('2016_06_14_080149_create_tags',1),('2016_06_14_080540_create_user_payments',1),('2016_06_14_081130_create_user_profile',1),('2016_06_14_082059_create_user_secret_profile',1),('2016_06_14_090437_create_store',1),('2016_06_14_091138_create_prefecture',1),('2016_06_14_091926_create_store_container',1),('2016_06_14_092701_create_store_evaluation',1),('2016_06_14_100227_create_store_evaluation_users',1),('2016_06_14_101225_create_items',1),('2016_06_15_075150_create_brands',1),('2016_06_15_075822_create_brand_category',1),('2016_06_15_080626_create_user_follow',1),('2016_06_15_081633_create_user_followers',1),('2016_06_16_040656_create_store_follow',1),('2016_06_16_042227_create_store_followers',1),('2016_07_12_031130_create_user_item_status_table',1),('2016_07_15_053429_create_user_comments_table',1),('2016_07_20_052908_create_user_item2tags_table',1),('2016_07_21_072252_add_confirmation_token_to_users_table',1),('2016_07_26_032524_create_container_table',1),('2016_07_26_032554_create_user_item2container_table',1),('2016_08_01_090427_create_genre_table',1),('2016_08_01_093133_create_category_table',1),('2016_08_02_085519_create_item_evaluation_table',1),('2016_08_02_085551_create_item_evaluation_users_table',1),('2016_08_03_090933_create_user_container_table',1),('2016_08_03_092156_create_item_container_table',1),('2016_08_03_092245_create_item2container_table',1),('2016_08_04_074523_create_genre_second_table',1),('2016_08_09_101713_create_users2tags_table',1),('2016_08_30_071300_create_brands_has_count_table',1),('2016_09_07_052359_create_category_count_table',1),('2016_09_07_052430_create_genre_count_table',1),('2016_09_07_052455_create_genre_second_count_table',1),('2016_09_13_075345_create_admin_user_account',1),('2016_10_26_062034_create_user_info_count_table',1),('2016_11_10_105551_create_user_evaluation_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `prefecture`
--

LOCK TABLES `prefecture` WRITE;
/*!40000 ALTER TABLE `prefecture` DISABLE KEYS */;
/*!40000 ALTER TABLE `prefecture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `store`
--

LOCK TABLES `store` WRITE;
/*!40000 ALTER TABLE `store` DISABLE KEYS */;
/*!40000 ALTER TABLE `store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `store_container`
--

LOCK TABLES `store_container` WRITE;
/*!40000 ALTER TABLE `store_container` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_container` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `store_evaluation`
--

LOCK TABLES `store_evaluation` WRITE;
/*!40000 ALTER TABLE `store_evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `store_evaluation_users`
--

LOCK TABLES `store_evaluation_users` WRITE;
/*!40000 ALTER TABLE `store_evaluation_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_evaluation_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `store_follow`
--

LOCK TABLES `store_follow` WRITE;
/*!40000 ALTER TABLE `store_follow` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_follow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `store_followers`
--

LOCK TABLES `store_followers` WRITE;
/*!40000 ALTER TABLE `store_followers` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_comments`
--

LOCK TABLES `user_comments` WRITE;
/*!40000 ALTER TABLE `user_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_container`
--

LOCK TABLES `user_container` WRITE;
/*!40000 ALTER TABLE `user_container` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_container` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_evaluation`
--

LOCK TABLES `user_evaluation` WRITE;
/*!40000 ALTER TABLE `user_evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_follow`
--

LOCK TABLES `user_follow` WRITE;
/*!40000 ALTER TABLE `user_follow` DISABLE KEYS */;
INSERT INTO `user_follow` VALUES (0,0,'2016-11-07 08:28:09','2016-11-07 08:31:04',NULL),(2,1,'2016-11-07 08:37:17','2016-11-07 08:42:48',NULL),(3,1,'2016-11-07 08:29:09','2016-11-11 03:38:40',NULL);
/*!40000 ALTER TABLE `user_follow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_followers`
--

LOCK TABLES `user_followers` WRITE;
/*!40000 ALTER TABLE `user_followers` DISABLE KEYS */;
INSERT INTO `user_followers` VALUES (1,0,11,'2016-11-07 08:28:09','2016-11-07 08:28:10','2016-11-07 08:28:10'),(2,0,11,'2016-11-07 08:28:17','2016-11-07 08:31:04','2016-11-07 08:31:04'),(3,3,11,'2016-11-07 08:29:09','2016-11-07 08:29:17','2016-11-07 08:29:17'),(4,3,11,'2016-11-07 08:29:20','2016-11-07 08:29:40','2016-11-07 08:29:40'),(5,3,11,'2016-11-07 08:29:59','2016-11-07 08:30:14','2016-11-07 08:30:14'),(6,3,11,'2016-11-07 08:31:39','2016-11-11 03:26:42','2016-11-11 03:26:42'),(7,2,11,'2016-11-07 08:37:17','2016-11-07 08:38:09','2016-11-07 08:38:09'),(8,2,11,'2016-11-07 08:38:22','2016-11-07 08:38:56','2016-11-07 08:38:56'),(9,2,11,'2016-11-07 08:39:18','2016-11-07 08:41:27','2016-11-07 08:41:27'),(10,2,11,'2016-11-07 08:42:48','2016-11-07 08:42:48',NULL),(11,3,11,'2016-11-11 03:26:46','2016-11-11 03:26:54','2016-11-11 03:26:54'),(12,3,11,'2016-11-11 03:26:55','2016-11-11 03:38:30','2016-11-11 03:38:30'),(13,3,11,'2016-11-11 03:38:32','2016-11-11 03:38:35','2016-11-11 03:38:35'),(14,3,11,'2016-11-11 03:38:36','2016-11-11 03:38:38','2016-11-11 03:38:38'),(15,3,11,'2016-11-11 03:38:40','2016-11-11 03:38:40',NULL);
/*!40000 ALTER TABLE `user_followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_info_count`
--

LOCK TABLES `user_info_count` WRITE;
/*!40000 ALTER TABLE `user_info_count` DISABLE KEYS */;
INSERT INTO `user_info_count` VALUES (1,1,0,0,0,0,0,0,0,'2016-11-07 09:26:15','2016-11-07 09:26:15',NULL),(2,2,0,0,0,0,0,0,0,'2016-11-07 09:26:15','2016-11-07 09:26:15',NULL),(3,3,0,0,0,0,0,0,0,'2016-11-07 09:26:15','2016-11-11 03:38:40',NULL),(4,4,0,0,0,0,0,0,0,'2016-11-07 09:26:15','2016-11-07 09:26:15',NULL),(5,11,0,0,0,0,0,0,0,'2016-11-07 09:26:15','2016-11-11 03:38:40',NULL);
/*!40000 ALTER TABLE `user_info_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_item2container`
--

LOCK TABLES `user_item2container` WRITE;
/*!40000 ALTER TABLE `user_item2container` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_item2container` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_item2tags`
--

LOCK TABLES `user_item2tags` WRITE;
/*!40000 ALTER TABLE `user_item2tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_item2tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_item_imgs`
--

LOCK TABLES `user_item_imgs` WRITE;
/*!40000 ALTER TABLE `user_item_imgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_item_imgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_item_status`
--

LOCK TABLES `user_item_status` WRITE;
/*!40000 ALTER TABLE `user_item_status` DISABLE KEYS */;
INSERT INTO `user_item_status` VALUES (1,11,4,1,'2016-11-02 09:14:11','2016-11-02 09:14:11',NULL),(2,11,3,2,'2016-11-02 09:14:13','2016-11-02 09:14:13',NULL),(3,11,2,1,'2016-11-02 09:14:15','2016-11-02 09:14:15',NULL),(4,11,5,1,'2016-11-02 09:38:48','2016-11-02 09:38:48',NULL),(5,11,7,2,'2016-11-02 09:39:03','2016-11-02 09:39:03',NULL),(6,11,1,1,'2016-11-08 02:56:00','2016-11-18 05:05:16',NULL);
/*!40000 ALTER TABLE `user_item_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_items`
--

LOCK TABLES `user_items` WRITE;
/*!40000 ALTER TABLE `user_items` DISABLE KEYS */;
INSERT INTO `user_items` VALUES (1,11,1,0,NULL,1,0,0,'/user_items/1.jpg','http://www.vic2.jp/',0,'',0,0,'2016-11-01 08:32:22','2016-11-01 08:32:22',NULL),(2,11,2,0,NULL,1,0,0,'/user_items/2','https://www.google.co.jp/search?q=Myx+%E3%83%8A%E3%83%B3%E3%82%AC&safe=off&biw=1429&bih=1113&source=',0,'',0,0,'2016-11-02 04:25:15','2016-11-02 04:25:15',NULL),(3,11,3,0,NULL,1,0,0,'/user_items/3.jpg','http://item.rakuten.co.jp/canpanera/n13002/',0,'',0,0,'2016-11-02 08:57:41','2016-11-02 08:57:41',NULL),(4,11,4,0,NULL,1,0,0,'/user_items/4.jpg','https://store.snowpeak.co.jp/page/34',0,'',0,0,'2016-11-02 09:11:25','2016-11-02 09:11:25',NULL),(5,11,5,0,NULL,1,0,0,'/user_items/5.jpg','https://store.snowpeak.co.jp/page/34',0,'',0,0,'2016-11-02 09:16:45','2016-11-02 09:16:45',NULL),(6,11,6,0,NULL,1,0,0,'/user_items/6.jpg','https://store.snowpeak.co.jp/page/34',0,'',0,0,'2016-11-02 09:20:14','2016-11-02 09:20:14',NULL),(7,11,7,0,NULL,1,0,0,'/user_items/7.jpg','https://ec.coleman.co.jp/item/IS00060N05625.html',0,'',0,0,'2016-11-02 09:34:21','2016-11-02 09:34:21',NULL),(8,11,8,0,NULL,1,0,0,'/user_items/8.jpg','http://ec.coleman.co.jp/item/IS00060N05010.html',0,'',0,0,'2016-11-02 09:36:13','2016-11-02 09:36:13',NULL),(9,11,9,0,NULL,1,0,0,'/user_items/9.jpg','http://www.be-tackle.com/outdoor.index/sleepingbag.htm/nanga/down4tipe/aurora/aurora_light.htm',0,'',0,0,'2016-11-03 02:46:41','2016-11-03 02:46:41',NULL),(10,11,10,0,NULL,1,0,0,'/user_items/10','https://halftrack.stores.jp/items/575d58c4a458c04adb00e6af',0,'',0,0,'2016-11-03 02:51:03','2016-11-03 02:51:03',NULL),(11,11,11,0,NULL,1,0,0,'/user_items/11.png',NULL,0,'',0,0,'2016-11-07 09:02:18','2016-11-07 09:02:18',NULL),(12,11,12,0,NULL,1,0,0,'/user_items/12.jpg','http://item.rakuten.co.jp/naturum/2761281/?scid=af_pc_etc&sc2id=346218181',0,'',0,0,'2016-11-08 03:36:47','2016-11-08 03:36:47',NULL),(13,11,13,0,NULL,1,0,0,'/user_items/13.jpg','http://www.goo.ne.jp/green/column/camphack-1164.html',0,'',0,0,'2016-11-08 03:40:59','2016-11-08 03:40:59',NULL),(14,11,14,0,NULL,1,0,0,'/user_items/14.jpg','http://webshop.wild1.co.jp/shop/g/g2200020003083/',0,'',0,0,'2016-11-08 03:51:15','2016-11-08 03:51:15',NULL),(15,11,15,0,NULL,1,0,0,'/user_items/15.jpg','https://locusgear.com/items/soris-sil/',0,'',0,0,'2016-11-08 03:53:30','2016-11-08 03:53:30',NULL),(16,11,16,0,NULL,1,0,0,'/user_items/16.jpg','http://item.rakuten.co.jp/canpanera/e04005-1/',0,'',0,0,'2016-11-08 06:51:21','2016-11-08 06:51:21',NULL),(17,11,17,0,NULL,1,0,0,'/user_items/17.jpg','http://tsugaike.blogspot.jp/2014/01/sod-310-heat-1hg-1100.html',0,'',0,0,'2016-11-08 06:55:45','2016-11-08 06:55:45',NULL);
/*!40000 ALTER TABLE `user_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_payments`
--

LOCK TABLES `user_payments` WRITE;
/*!40000 ALTER TABLE `user_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (1,'http://hammocks-img/user/avater/background/1.png','http://hammocks-img/shop/avater/icon/1.png','http://hammocks-img/shop/avater/background/1.png','Qui voluptas beatae est illum. Aperiam dolores illum sit nobis aut sed cum. Necessitatibus qui et maiores quasi iste optio. Aut qui omnis dolorum in reiciendis cum quos.',1974,8,26,'2009-03-24 02:33:07','1981-07-14 15:55:56',NULL),(2,'http://hammocks-img/user/avater/background/2.png','http://hammocks-img/shop/avater/icon/2.png','http://hammocks-img/shop/avater/background/2.png','Voluptas et est deserunt excepturi quasi. Ducimus quia eligendi quis aut nihil maxime totam nostrum.',1980,7,3,'2004-12-15 15:26:09','1979-04-13 03:00:01',NULL),(3,'http://hammocks-img/user/avater/background/3.png','http://hammocks-img/shop/avater/icon/3.png','http://hammocks-img/shop/avater/background/3.png','Excepturi quod omnis omnis ea et. Quia quis et est quam autem non. Ut praesentium voluptatem enim. Iste recusandae itaque tempora molestiae iusto nemo voluptate.',1966,1,8,'1972-08-14 09:58:40','1989-08-20 00:54:25',NULL),(4,'http://hammocks-img/user/avater/background/4.png','http://hammocks-img/shop/avater/icon/4.png','http://hammocks-img/shop/avater/background/4.png','Voluptatem ducimus est sunt deserunt qui occaecati. Vel maiores soluta qui magnam error aut sint autem. Rerum sit nihil ut harum id dicta illum.',1963,10,19,'2000-09-22 02:47:44','2014-04-03 06:21:05',NULL),(5,'http://hammocks-img/user/avater/background/5.png','http://hammocks-img/shop/avater/icon/5.png','http://hammocks-img/shop/avater/background/5.png','Itaque ad omnis sit laudantium aut ex consequatur aut. Reprehenderit voluptas corrupti omnis corrupti. Earum incidunt possimus asperiores quisquam nulla debitis. Perspiciatis natus et nam alias.',1965,4,21,'2001-05-29 10:30:34','1972-11-29 04:39:51',NULL),(6,'http://hammocks-img/user/avater/background/6.png','http://hammocks-img/shop/avater/icon/6.png','http://hammocks-img/shop/avater/background/6.png','Et quia est officiis magnam est magni nisi numquam. Quia ex deleniti impedit et eum. Earum occaecati vel tempora incidunt omnis nobis cupiditate.',1987,10,10,'2009-04-03 05:11:53','1993-02-25 17:54:56',NULL),(7,'http://hammocks-img/user/avater/background/7.png','http://hammocks-img/shop/avater/icon/7.png','http://hammocks-img/shop/avater/background/7.png','Aperiam aut iure nihil repellendus voluptas et. Ratione officia debitis ducimus corrupti dolorem dolor iure. Cum vel quibusdam atque. Porro et quis dolor aliquam sunt omnis.',1988,3,28,'1975-07-15 03:36:34','2005-07-16 12:01:12',NULL),(8,'http://hammocks-img/user/avater/background/8.png','http://hammocks-img/shop/avater/icon/8.png','http://hammocks-img/shop/avater/background/8.png','Magni a sit et deleniti. Rerum quam ducimus dolores necessitatibus. Aspernatur distinctio doloremque molestias culpa et.',1988,9,11,'1988-03-05 12:16:51','1976-05-31 12:31:36',NULL),(9,'http://hammocks-img/user/avater/background/9.png','http://hammocks-img/shop/avater/icon/9.png','http://hammocks-img/shop/avater/background/9.png','Voluptas quis numquam dolorum. Perspiciatis sequi occaecati voluptatem incidunt qui. Totam in vel et et. Modi suscipit molestiae nihil aliquid tenetur expedita inventore neque.',1997,12,1,'1970-05-24 18:59:21','1972-08-17 15:26:46',NULL),(10,'http://hammocks-img/user/avater/background/10.png','http://hammocks-img/shop/avater/icon/10.png','http://hammocks-img/shop/avater/background/10.png','Quae enim enim ab in optio. Consequuntur qui nobis itaque voluptatem ea. Unde voluptatem deserunt repellat ex facere.',1963,10,10,'1983-05-17 04:26:13','2007-08-13 11:12:34',NULL),(11,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-01 08:25:29','2016-11-01 08:25:29',NULL);
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_secret_profile`
--

LOCK TABLES `user_secret_profile` WRITE;
/*!40000 ALTER TABLE `user_secret_profile` DISABLE KEYS */;
INSERT INTO `user_secret_profile` VALUES (1,'080-6660-5787',43,'井上市','9836017  埼玉県坂本市中央区中津川町中津川7-1-4','3330125','2001-09-27 16:52:22','1988-03-09 11:06:23',NULL),(2,'090-0072-8960',5,'斉藤市','9357146  静岡県杉山市南区渡辺町松本3-3-9','3330125','2009-03-22 15:16:50','1978-06-06 05:31:12',NULL),(3,'89-4662-0030',40,'三宅市','4321299  鹿児島県桐山市西区山田町杉山10-4-3','3330125','2001-04-18 03:46:02','2003-02-24 01:37:15',NULL),(4,'090-0422-1343',28,'中島市','8323880  北海道原田市西区宮沢町工藤2-9-4','3330125','1997-08-05 11:49:50','1989-10-15 03:12:53',NULL),(5,'080-1659-9869',37,'松本市','1407172  山梨県村山市北区井高町小泉9-6-5 ハイツ田中106号','3330125','1979-06-22 15:44:50','2010-11-29 03:56:57',NULL),(6,'38-4070-9503',19,'松本市','2618348  山口県宇野市北区江古田町中島6-5-10 コーポ井上110号','3330125','1985-02-13 16:01:28','2004-01-29 17:42:01',NULL),(7,'080-1868-8883',40,'宮沢市','3327273  北海道伊藤市中央区鈴木町鈴木9-10-8','3330125','1999-03-04 22:08:16','1986-03-13 14:17:59',NULL);
/*!40000 ALTER TABLE `user_secret_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'xuno','/images/user_default.png','hiroshi.hirokawa@gmail.com','$2y$10$WvPOQ.Q795dgyfYmCD7ot.JP.AcUtTPwaNwPMEq/b.PMq2zqUps96','$2y$10$DUt26J3/Sf56by03/DSI4.AIPKBwiRXotShS8q4CueA5FrE1exKim','2009-08-20 16:31:13','1994-03-08 12:15:40',NULL,NULL,NULL,NULL),(2,'funo','/images/user_default.png','iuno@tanabe.com','$2y$10$wuVKhUCJboFd8XImKI4YDey1cwXHa.rIhoSZBLk2MrJ8oAhurc1L2','$2y$10$v.oeZX5y8ZsC3bWSS9sd0eh0xs0POiOM/XfJvNgxhDKo85y1rSw02','2007-06-07 00:04:25','2005-04-20 06:08:59',NULL,NULL,NULL,NULL),(3,'nhirokawa','/images/user_default.png','rika59@suzuki.org','$2y$10$UszZqxRM.Sc9h/L83eXVq.UmgoVJHZqZXpeKkt63cMOVNRGAv25gS','$2y$10$P30F7tSXsRXqkZLRxSZMDO4PPaS8Fkr7D6DMXdJG1DxW6q8ePtByy','2013-08-27 16:02:12','1981-10-19 19:22:45',NULL,NULL,NULL,NULL),(4,'taro.uno','/images/user_default.png','cnagisa@hirokawa.net','$2y$10$DsgBtJICY.U3fQeUTB37oeamXZIKboMeLCuEgaJHn8VyX5XLN4Vxe','$2y$10$8K0CTjWtDnJesN0i4/YuqeZdvq3QmkZ7JWAQ9Igl5fTUZgTvzoNby','1987-12-19 15:43:58','2011-10-05 13:59:00',NULL,NULL,NULL,NULL),(5,'luno','/images/user_default.png','nagisa.naoko@gmail.com','$2y$10$cq2EBNxhJZe0GDlB.oL8RuPhp4TzrXfTSR9ohdszLPU3qRwgrdD/e','$2y$10$vv4bNRTMPQr/AL/1tT04EeAsRuHvQx3leozk6Gy9BNMQXx7NLQ0ly','1974-05-27 01:18:12','1970-07-09 14:21:11',NULL,NULL,NULL,NULL),(6,'akira25','/images/user_default.png','hiroshi29@gmail.com','$2y$10$JpeoZkSZ55bm9RlJBSd9IOZSjHTcJV7DB2/r.OHXgYNaLJu8UQ.5y','$2y$10$9DNl61U8MDedCJ3wocvqE.XfkC7wBQ8xzNmzlgww0EIMIPDTWDtIu','1972-07-05 16:50:26','1989-11-18 11:04:08',NULL,NULL,NULL,NULL),(7,'huno','/images/user_default.png','yoshimoto.kana@hirokawa.jp','$2y$10$0UChK/AyHHbfNAKDrZI.7u8ehk5Curkj5YPC/mYf.KYfcSfbmYaai','$2y$10$8e2rDhvffQypZnnpNzkMZu4J8rtrHCizXasNV3cJ0CpvRcZYJUisq','1989-09-16 22:58:27','1988-05-28 05:02:24',NULL,NULL,NULL,NULL),(8,'akira76','/images/user_default.png','yhirokawa@mail.goo.ne.jp','$2y$10$AyfWq6AcoplIph5dokDHAuYjtXfg5meEbZEsKLxiu7ewBJV6LxImO','$2y$10$bZsXsZIJoFcCZtX71CPRCu6T4cqLE39gxVO.lWPLYtCPF8iKACGOq','2002-11-14 01:19:06','1979-07-27 12:31:21',NULL,NULL,NULL,NULL),(9,'kudo.akira','/images/user_default.png','rika78@tanabe.jp','$2y$10$rMP6pTVCWOlBnRJDjN23E.neOfL0HLQArG7yAZGjiGJESpZTDorRe','$2y$10$dWpROHP32UlYphUsLhT.zesN5vjHG/eDHUNbsYCcHVEqsm9HlTGwy','1981-02-07 18:19:31','1999-02-12 19:35:02',NULL,NULL,NULL,NULL),(10,'ahirokawa','/images/user_default.png','xsuzuki@mail.goo.ne.jp','$2y$10$7NQ2Bc.vuiJNYQkONfMBduPY4dnLTKi5WhmW4945XgbaFbSy2J2X.','$2y$10$Rc7lnOvpjvI8ArAr1LEh6uVNICahEY1AQ4HVv8gLsXt1Nh3Qb0hX2','2015-02-06 13:01:20','2004-04-24 09:24:43',NULL,NULL,NULL,NULL),(11,'suga','/images/user_default.png','suganuma@mail.com','$2y$10$jsoi85RKkHXYLKAt2qCGPu.1I2ny35j13XGrYqFfxcuMErjJVvvFa','b41Rpzwcuhl5fUTi48Bv3Ghu04rDRhAoS2H4jD4pTFKzNkrpdxTWLNVMrcVy','2016-11-01 08:25:29','2016-11-01 08:25:41',NULL,'b510fad73dbe8f34318479159fcb52ca0d7be1b757b8e4ab92e8575fec9c32ff',NULL,'2016-11-01 08:25:29');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users2tags`
--

LOCK TABLES `users2tags` WRITE;
/*!40000 ALTER TABLE `users2tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `users2tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-25  6:24:07
