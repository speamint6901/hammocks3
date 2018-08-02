-- MySQL dump 10.13  Distrib 5.6.31, for Linux (x86_64)
--
-- Host: 192.168.33.10    Database: hammocks
-- ------------------------------------------------------
-- Server version	5.6.31-log

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
INSERT INTO `brands` VALUES (1,'株式会社 佐藤','http://tanabe.jp/consequatur-est-perspiciatis-in-repudiandae','DarkSalmon','Lavender','LightCyan','Coral','','','1997-06-11 06:35:44','2010-07-24 15:51:43',NULL),(2,'株式会社 高橋','https://tanabe.com/et-vero-ducimus-culpa-omnis-magni-ullam.html','Cornsilk','GoldenRod','LimeGreen','SandyBrown','','','1994-03-17 00:44:19','1973-07-30 05:30:13',NULL),(3,'有限会社 松本','http://www.suzuki.jp/voluptatem-hic-velit-ut-impedit','Azure','SlateGray','MediumVioletRed','Pink','','','1980-10-21 05:02:59','1986-06-02 16:37:22',NULL),(4,'有限会社 杉山','http://hirokawa.com/','AntiqueWhite','SteelBlue','Thistle','DarkKhaki','','','1984-09-30 06:31:34','1991-10-26 18:05:16',NULL),(5,'有限会社 高橋','http://www.hirokawa.org/','Olive','Aquamarine','SeaGreen','Brown','','','1997-02-24 14:59:25','2014-08-04 15:41:01',NULL),(6,'有限会社 佐藤','http://www.kudo.org/sequi-aliquam-rerum-sed-similique-voluptas-cumque.html','Yellow','MediumBlue','Olive','PaleVioletRed','','','2007-08-11 16:49:27','1993-09-05 07:05:22',NULL),(7,'有限会社 浜田','http://hirokawa.com/numquam-error-aut-ut','Snow','LimeGreen','PaleGreen','DarkRed','','','1990-03-26 16:21:52','1993-08-18 17:42:16',NULL),(8,'有限会社 中島','http://www.kudo.com/labore-reprehenderit-rerum-veniam-cupiditate-aliquid-a-mollitia','LightCoral','Green','DarkBlue','Turquoise','','','1979-12-18 15:13:26','1996-12-18 15:34:48',NULL),(9,'有限会社 山本','http://uno.info/saepe-non-dolores-velit-ex-sunt-enim-cum.html','GhostWhite','FireBrick','MediumPurple','SpringGreen','','','2004-11-14 03:20:10','1996-08-08 08:52:56',NULL),(10,'有限会社 井上','http://www.suzuki.jp/sed-similique-dolorem-totam-optio-modi-consequatur-natus','LavenderBlush','CadetBlue','MediumTurquoise','DarkBlue','','','1995-07-13 09:44:11','1984-10-24 03:28:22',NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `brands_has_count`
--

LOCK TABLES `brands_has_count` WRITE;
/*!40000 ALTER TABLE `brands_has_count` DISABLE KEYS */;
/*!40000 ALTER TABLE `brands_has_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,1,'vel','2001-12-13 22:03:56','1977-10-12 02:08:34',NULL),(2,3,'voluptas','1973-03-29 22:56:31','2001-10-06 20:50:03',NULL),(3,2,'aspernatur','1983-04-08 16:06:54','1990-06-24 07:38:57',NULL),(4,4,'magnam','1976-08-29 22:46:59','1985-01-09 03:20:16',NULL),(5,4,'illo','1990-07-11 18:19:09','2016-08-20 14:19:46',NULL),(6,2,'id','2003-01-29 09:19:13','2008-03-06 15:42:57',NULL),(7,2,'exercitationem','1981-08-20 13:42:12','2001-01-16 21:43:30',NULL),(8,1,'impedit','1980-10-30 04:10:50','1989-05-24 12:21:32',NULL),(9,2,'sit','1981-01-11 09:34:52','2013-11-28 22:14:55',NULL),(10,4,'ipsam','2011-04-25 16:37:09','2009-11-30 16:36:09',NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `category_count`
--

LOCK TABLES `category_count` WRITE;
/*!40000 ALTER TABLE `category_count` DISABLE KEYS */;
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
INSERT INTO `genre` VALUES (1,1,'株式会社 木村','1970-10-05 19:55:26','1987-03-12 19:36:40',NULL),(2,9,'株式会社 中村','1999-04-07 10:08:31','1975-05-07 19:29:29',NULL),(3,9,'株式会社 井上','2000-10-04 08:39:45','1998-08-21 12:15:17',NULL),(4,4,'株式会社 山田','2015-11-30 23:01:58','1990-08-01 20:33:10',NULL),(5,5,'有限会社 中村','1989-03-16 18:05:03','1994-01-23 02:21:18',NULL),(6,7,'株式会社 渡辺','2003-09-03 09:36:50','2016-06-03 02:47:10',NULL),(7,6,'有限会社 村山','1977-08-16 04:31:18','1985-11-25 18:22:43',NULL),(8,2,'株式会社 井上','2013-03-17 07:51:02','2006-09-22 10:51:09',NULL),(9,4,'株式会社 坂本','1980-12-18 20:48:48','2003-09-08 01:55:22',NULL),(10,7,'株式会社 津田','2009-12-04 18:25:36','1995-10-12 16:04:10',NULL);
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genre_count`
--

LOCK TABLES `genre_count` WRITE;
/*!40000 ALTER TABLE `genre_count` DISABLE KEYS */;
/*!40000 ALTER TABLE `genre_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genre_second`
--

LOCK TABLES `genre_second` WRITE;
/*!40000 ALTER TABLE `genre_second` DISABLE KEYS */;
INSERT INTO `genre_second` VALUES (1,2,8,'株式会社 佐藤','1982-11-25 09:33:18','1985-02-09 21:32:46',NULL),(2,4,9,'有限会社 小林','1975-07-21 19:40:40','2003-06-01 00:01:07',NULL),(3,4,9,'株式会社 佐々木','1986-09-13 19:24:47','2003-04-24 10:27:04',NULL),(4,7,10,'有限会社 佐々木','1980-06-30 12:23:56','1974-04-30 21:57:38',NULL),(5,9,3,'有限会社 渡辺','1976-09-22 11:47:28','2009-03-18 14:39:10',NULL),(6,7,6,'有限会社 近藤','2011-06-26 15:41:22','1977-01-08 23:09:01',NULL),(7,9,2,'株式会社 宮沢','1994-05-26 07:42:52','2007-12-17 05:17:52',NULL),(8,1,1,'有限会社 山口','1984-12-23 11:26:51','2010-07-30 20:57:56',NULL),(9,2,8,'有限会社 小泉','2000-03-04 18:42:53','1992-05-29 21:02:17',NULL),(10,4,9,'有限会社 井上','1989-07-06 17:18:23','1989-10-29 09:28:01',NULL);
/*!40000 ALTER TABLE `genre_second` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `genre_second_count`
--

LOCK TABLES `genre_second_count` WRITE;
/*!40000 ALTER TABLE `genre_second_count` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `item_evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `item_evaluation_users`
--

LOCK TABLES `item_evaluation_users` WRITE;
/*!40000 ALTER TABLE `item_evaluation_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_evaluation_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,3,0,0,3,1,'Davy ブルゾン','/public_items/c6f057b86584942e415435ffb1fa93d4/1.jpg','http://www.apcjp.com/jpn/shop/apc/Davy+ブルゾン/item/view/shop_product_id/50718/category_id/985/color_id/1085/category_list_id/408',0,0,1,'フェルトウール地. 抗ピリング素材の混紡. 弱撥水加工素材. ストレート、ショートカット. ボタンで取り外し可能なシープスキンのクラシックカラー. 三日月台衿. ボタン留め比翼ファスナー. シームポケット2つ. 後身ウエスト脇にプレッションボタン2つ','2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(2,6,1,0,2,1,'Luc 手袋','/public_items/c6f057b86584942e415435ffb1fa93d4/2.jpg','http://www.apcjp.com/jpn/shop/apc/Luc+手袋/item/view/shop_product_id/50818/category_id/991/color_id/1076/category_list_id/408',0,0,1,'ウールとスムースレザー. 手の甲側と親指にスムースレザー. 手のひら側にニットウール. レザーパーツにステッチ. 手首外側にスリット.','2016-11-22 03:51:48','2016-11-22 03:51:51',NULL),(3,7,1,1,8,1,'Calvi バッグ','/public_items/c6f057b86584942e415435ffb1fa93d4/3.jpg','http://www.apcjp.com/jpn/shop/apc/Calvi+バッグ/item/view/shop_product_id/50808/category_id/450/color_id/1076/category_list_id/408',0,0,1,'ナイロンとイタリア製スムースレザー. 円筒形の型. ファスナー開閉. 2本のスムースレザーの持ち手. メタルバックルで調節可能、補強されたコットンリボンの取り外し可能なショルダーストラップ. スムースレザーのショルダーパッド. ','2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(4,5,1,0,7,1,'Hiver スウェット','/public_items/c6f057b86584942e415435ffb1fa93d4/4.jpg','http://www.apcjp.com/jpn/shop/apc/Hiver+スウェット/item/view/shop_product_id/50766/category_id/988/color_id/1117/category_list_id/408',0,0,1,'スポーツコットンモルトン. 抗ピリング素材の混紡. とてもソフトな内側. ストレートカット. 縫い付けたバイアストリミングのクルーネック. 同色ツイルのネックテープ. 胸に\'HIVER\'刺繍. 長袖. 袖口と裾に縫い付けた太いバイアストリミング.','2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(5,6,1,0,3,1,'Jérôme ジャケット','/public_items/c6f057b86584942e415435ffb1fa93d4/5.jpg','http://www.apcjp.com/jpn/shop/apc/Jérôme+ジャケット/item/view/shop_product_id/50840/category_id/408/color_id/1085/category_list_id/408',0,0,1,'ウールギャバジン. テーラーカラー. 衿裏に薄手同色フェルト. 2つボタン. 胸に玉縁ポケット1つ. パッチポケット2つ. 胸にダーツ. サイドパネル. 袖口にボタン3つとスリット. センターベント. 内側に玉縁ポケット1つ. コットン/ナイロンの裏地付. ','2016-11-22 04:17:31','2016-11-22 04:17:34',NULL),(6,3,0,0,9,1,'Time コート','/public_items/c6f057b86584942e415435ffb1fa93d4/6.jpg','http://www.apcjp.com/jpn/shop/apc/Time+コート/item/view/shop_product_id/50829/category_id/408/color_id/1080/category_list_id/408',0,1,0,'コットン/ウールブレンド. 弱撥水加工素材. ストレートカット. ステッチ入りクラシックカラー. 三日月台衿. ダブル仕立て. 6つボタン(3つは飾りボタン). ステイボタンと内側にドレープを美しく出すためのボタン. 右衿下にボタン1つ. ','2016-11-22 04:21:22','2016-11-22 04:21:46',NULL),(7,1,1,1,8,1,'Alexandre リュックサック','/public_items/c6f057b86584942e415435ffb1fa93d4/7.jpg','http://www.apcjp.com/jpn/shop/apc/Alexandre+リュックサック/item/view/shop_product_id/50904/category_id/450/color_id/1079/category_list_id/408',0,1,1,'ボンデッド加工のイタリア製ジャージとラバー. 弱撥水加工. 玉縁ファスナー開閉. 下部横全体にファスナー付玉縁ポケット. ステッチ入り2本のレザー紐でバッグ底を四角に成型. トップにキャリーハンドルとA.P.C.刻印入りレザーラベル. ','2016-11-22 04:24:49','2016-11-23 05:02:24',NULL),(8,6,1,0,10,1,'Jérémie スウェットシャツ','/public_items/c6f057b86584942e415435ffb1fa93d4/8.jpg','http://www.apcjp.com/jpn/shop/apc/Jérémie+スウェットシャツ/item/view/shop_product_id/50869/category_id/408/color_id/1087/category_list_id/408',0,0,1,'細マリンボーダーのジャージ. 心地よい流れるような素材. ストレートカット. バイアストリミングの縫い留められたクルーネック. ツイルのネックテープ','2016-11-22 04:28:04','2016-11-22 04:28:27',NULL),(9,6,1,0,4,1,'Jude チノ','/public_items/c6f057b86584942e415435ffb1fa93d4/9.jpg','http://www.apcjp.com/jpn/shop/apc/Jude+チノ/item/view/shop_product_id/50834/category_id/408/color_id/1087/category_list_id/408',0,1,0,'ウール/コットンブレンドのヘリンボーン. ストレートカット、裾は軽いテーパード. ファスナー開き. ウエストバンドに切り替え. ベルトループ. ウエストボタン2つ(1つは隠しボタン). シームポケット2つ. フォブポケット1つ. 後身にダーツ. 後身に玉縁ポケット1つ. 角ボタン. ','2016-11-22 04:31:06','2016-11-22 04:31:29',NULL),(10,8,0,0,4,1,'Wales コート','/public_items/c6f057b86584942e415435ffb1fa93d4/10.jpg','http://www.apcjp.com/jpn/shop/apc/Wales+コート/item/view/shop_product_id/50831/category_id/408/color_id/1079/category_list_id/408',0,1,0,'ボンディング加工されたジャージとラバー. 弱撥水加工素材. ストレートカット. ボタン留めスタンドカラー. メタルチップとフラットレザーのストッパー付同色メッシュコットンのドローストリングで調節可能な大きなフード. ボタン留め比翼仕立て. 4つボタン. ラグランスリーブ. ','2016-11-22 04:35:01','2016-11-22 04:35:26',NULL),(11,6,1,0,6,1,'Mecano ジャケット','/public_items/c6f057b86584942e415435ffb1fa93d4/11.jpg','http://www.apcjp.com/jpn/shop/apc/Mecano+ジャケット/item/view/shop_product_id/50837/category_id/408/color_id/1085/category_list_id/408',0,0,1,'ウールギャバジン. ファンシーリブのスタンドテディカラー. 着心地を良くするために前開き下にフラップ. 玉縁のラグランポケット2つ. セットインスリーブ. 左袖にガセット入りフラップポケット1つ. 内側に玉縁の縦ポケット1つ. 肘にダーツ. 袖口、裾にリブ.','2016-11-22 04:40:27','2016-11-22 04:40:34',NULL),(12,6,1,0,10,1,'Trevor オーバーシャツ','/public_items/c6f057b86584942e415435ffb1fa93d4/12.jpg','http://www.apcjp.com/jpn/shop/apc/Trevor+オーバーシャツ/item/view/shop_product_id/50844/category_id/408/color_id/1179/category_list_id/408',0,1,1,'タータンチェックウール. 抗ピリング素材. 織り柄. 前立てボタン6つ. 衿にステッチ. 後身にヨーク. 胸にステッチ入りパッチポケット1つ. 袖口にプリーツとスリット. ステッチ入りボタン留めカフス. シャツテール. フェルドシーム. ','2016-11-22 04:53:48','2016-11-22 08:29:38',NULL),(13,6,1,0,3,1,'コンパクトウォレット','/public_items/c6f057b86584942e415435ffb1fa93d4/13.jpg','http://www.apcjp.com/jpn/shop/apc/コンパクトウォレット/item/view/shop_product_id/50906/category_id/1000/color_id/1116/category_list_id/408',0,2,0,'エンボス加工のべジタブルタンニングのスペイン製レザー. 自然な古色を帯びる. イレギュラーな格子モチーフ. 二つ折リ財布. マルチファンクションポケット4つ、カード入れ3つ、紙幣入れ1つが付いたプレッションボタン留めメインポケット. ','2016-11-22 05:04:29','2016-11-22 08:26:59',NULL),(14,6,1,0,2,1,'Paris ベルト','/public_items/c6f057b86584942e415435ffb1fa93d4/14.jpg','http://www.apcjp.com/jpn/shop/apc/Paris+ベルト/item/view/shop_product_id/50909/category_id/408/color_id/1116/category_list_id/408',0,0,1,'べジタルタンニングのスペイン製レザー. 自然な古色を帯びる. イレギュラーな格子モチーフ. フランス製. 四角いシルバーの真鍮製ローラーバックル. レザーのキーパー2つ. 尖ったチップ. 内側にシルバーのA.P.C.ロゴのプリントと取扱説明のプリント','2016-11-22 05:07:16','2016-11-22 05:07:17',NULL),(16,1,1,0,6,1,'Skipton Mac','/public_items/c6f057b86584942e415435ffb1fa93d4/16.jpg','http://www.apcjp.com/jpn/shop/apc/Skipton+Mac/item/view/shop_product_id/50827/category_id/408/color_id/1085/category_list_id/408',0,0,1,'コットン/ウールブレンドのプリンス・オブ・ウェールズチェック. 織り柄. 弱撥水加工素材. ストレートカット. ステッチ入りクラシックカラー. 三日月台衿. ボタン留め比翼仕立て. 4つボタン(トップボタンは表付け). ステイボタン. ラグランフラップポケット2つ. ','2016-11-22 05:12:12','2016-11-22 06:17:46',NULL),(17,7,1,0,2,1,'Ringo セーター','/public_items/c6f057b86584942e415435ffb1fa93d4/17.jpg','http://www.apcjp.com/jpn/shop/apc/Ringo+セーター/item/view/shop_product_id/50884/category_id/408/color_id/1156/category_list_id/408',0,1,0,' \r\nRingo セーター\r\nムリネメリノウール/カシミヤブレンド. とてもソフトで暖かくフワフワした素材. ジャージ編み. ストレートシルエット. リブのクルーネック. 衿ぐり、アームホールシームに飾り編み. 長袖. 袖口、裾','2016-11-22 05:16:02','2016-11-22 05:16:03',NULL),(18,6,1,0,4,1,'  La Rose Tシャツ','/public_items/c6f057b86584942e415435ffb1fa93d4/18.jpg','http://www.apcjp.com/jpn/shop/apc/La+Rose+Tシャツ/item/view/shop_product_id/50877/category_id/408/color_id/1077/category_list_id/408',0,1,0,'ドライコットンジャージ. ストレートカット. バイアストリミングの縫い留められたクルーネック. ネックテープ. 胸にルミナスチューブでプリントしたバラの写真. 半袖. ストレートテール. 後身左下にA.P.C.ロゴの刺繍. 袖口、裾にステッチ.','2016-11-22 05:24:14','2016-11-22 05:24:15',NULL),(19,6,1,0,7,1,'Milan オーバーシャツ','/public_items/c6f057b86584942e415435ffb1fa93d4/19.jpg','http://www.apcjp.com/jpn/shop/apc/Milan+オーバーシャツ/item/view/shop_product_id/50865/category_id/408/color_id/1077/category_list_id/408',0,1,1,'リネン/コットンピケ. ストレートカット. 前開きボタン6つ. 胸にパッチポケット1つ. 袖口にプリーツとボタン留めスリット. カフスボタン留め. 後身にヨーク. 軽いシャツテール. 内側シームにフェルドシーム. 貝ボタン. ','2016-11-22 05:28:43','2016-11-22 08:26:53',NULL),(20,6,1,0,4,1,'Oh L\'amour Tシャツ','/public_items/c6f057b86584942e415435ffb1fa93d4/20.jpg','http://www.apcjp.com/jpn/shop/apc/Oh+L%27amour+Tシャツ/item/view/shop_product_id/50876/category_id/408/color_id/1077/category_list_id/408',0,0,1,'ドライコットンジャージ. ストレートカット. バイアストリミングの縫い留められたクルーネック. ネックテープ. 胸にタイポグラフィー\'\'OH L\'AMOUR\'\'のプリント. 長袖. 後身左下A.P.C.ロゴの刺繍. 袖口、裾にステッチ.','2016-11-22 05:30:49','2016-11-22 08:26:48',NULL),(21,6,1,0,8,1,'  Lagon Tシャツ','/public_items/c6f057b86584942e415435ffb1fa93d4/21.jpg','http://www.apcjp.com/jpn/shop/apc/Lagon+Tシャツ/item/view/shop_product_id/50878/category_id/988/color_id/1087/category_list_id/408',0,0,1,'ドライコットンジャージ. ストレートカット. バイアストリミングの縫い留められたクルーネック. 胸にステッチ留めの杢コットンオックスフォードのバンド. 半袖. ストレートテール. 後身左下にA.P.C.ロゴの刺繍. 袖口、裾にステッチ','2016-11-22 06:14:56','2016-11-22 06:14:57',NULL),(22,6,1,0,7,1,'Nick セーター','/public_items/c6f057b86584942e415435ffb1fa93d4/22.jpg','http://www.apcjp.com/jpn/shop/apc/Nick+セーター/item/view/shop_product_id/50880/category_id/989/color_id/1087/category_list_id/408',0,1,1,'コットン/ウールブレンドのハニカムニット. 柔軟でコンパクトな素材. ストレートシルエット. リブのクルーネック. 衿ぐり、アームホールシームに飾り編み. 袖口、裾にリブ. ','2016-11-22 06:16:54','2016-11-22 08:24:30',NULL),(23,6,1,0,3,1,'A.P.C. Japan Tシャツ','/public_items/c6f057b86584942e415435ffb1fa93d4/23.jpg','http://www.apcjp.com/jpn/shop/apc/A.P.C.+Japan+Tシャツ/item/view/shop_product_id/50510/category_id/988/color_id/1077/category_list_id/408',0,1,0,'ベーシックコットンジャージ. ストレートカット. バイアストリミングのクルーネック. ネックテープ. 胸に\'アペセ\'のプリント. 裾左にA.P.C.ロゴの刺繍. 半袖. 袖口、裾にステッチ.','2016-11-23 06:11:19','2016-11-23 06:11:20',NULL),(24,3,0,0,10,1,'L.A. Tシャツ','/public_items/c6f057b86584942e415435ffb1fa93d4/24.jpg','http://www.apcjp.com/jpn/shop/apc/L.A.+Tシャツ/item/view/shop_product_id/50504/category_id/988/color_id/1077/category_list_id/408',0,0,1,'http://www.apcjp.com/jpn/shop/apc/L.A.+Tシャツ/item/view/shop_product_id/50504/category_id/988/color_id/1077/category_list_id/408','2016-11-23 06:13:41','2016-11-23 06:13:42',NULL);
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
INSERT INTO `tags` VALUES (1,'test','2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(2,'abc','2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(3,'バッグ','2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(4,'カバン','2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(5,'てすと','2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(6,'服','2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(7,'ジャケット','2016-11-22 04:17:34','2016-11-22 04:17:34',NULL),(8,'ymo','2016-11-22 04:21:46','2016-11-22 04:21:46',NULL),(9,'ufo','2016-11-22 04:21:46','2016-11-22 04:21:46',NULL),(10,'tesu','2016-11-22 04:25:05','2016-11-22 04:25:05',NULL),(11,'リュック','2016-11-22 04:25:05','2016-11-22 04:25:05',NULL),(12,'aaa','2016-11-22 04:28:27','2016-11-22 04:28:27',NULL),(13,'bbb','2016-11-22 04:28:27','2016-11-22 04:28:27',NULL),(14,'かっぱ','2016-11-22 04:35:26','2016-11-22 04:35:26',NULL),(15,'財布','2016-11-22 05:04:31','2016-11-22 05:04:31',NULL),(16,'Tシャツ','2016-11-22 05:24:15','2016-11-22 05:24:15',NULL),(17,'夏','2016-11-22 05:28:44','2016-11-22 05:28:44',NULL),(18,'ggg','2016-11-22 06:14:57','2016-11-22 06:14:57',NULL),(19,'cccc','2016-11-22 06:16:55','2016-11-22 06:16:55',NULL),(20,'アイウエオ','2016-11-22 08:29:38','2016-11-22 08:29:38',NULL),(21,'vvvv','2016-11-23 05:02:24','2016-11-23 05:02:24',NULL),(22,'wwww','2016-11-23 06:13:42','2016-11-23 06:13:42',NULL);
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
/*!40000 ALTER TABLE `user_follow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_followers`
--

LOCK TABLES `user_followers` WRITE;
/*!40000 ALTER TABLE `user_followers` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_info_count`
--

LOCK TABLES `user_info_count` WRITE;
/*!40000 ALTER TABLE `user_info_count` DISABLE KEYS */;
INSERT INTO `user_info_count` VALUES (1,1,0,0,0,0,0,0,0,'2016-11-22 03:34:30','2016-11-22 03:34:30',NULL),(2,2,0,0,0,0,0,0,0,'2016-11-22 08:21:05','2016-11-22 08:21:05',NULL);
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
INSERT INTO `user_item2tags` VALUES (1,1,1,'2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(2,2,1,'2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(3,1,2,'2016-11-22 03:51:51','2016-11-22 03:51:51',NULL),(4,2,2,'2016-11-22 03:51:51','2016-11-22 03:51:51',NULL),(5,3,3,'2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(6,4,3,'2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(7,5,4,'2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(8,6,4,'2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(9,5,5,'2016-11-22 04:17:34','2016-11-22 04:17:34',NULL),(10,7,5,'2016-11-22 04:17:34','2016-11-22 04:17:34',NULL),(11,1,6,'2016-11-22 04:21:46','2016-11-22 04:21:46',NULL),(12,8,6,'2016-11-22 04:21:46','2016-11-22 04:21:46',NULL),(13,9,6,'2016-11-22 04:21:46','2016-11-22 04:21:46',NULL),(14,1,7,'2016-11-22 04:25:05','2016-11-22 04:25:05',NULL),(15,10,7,'2016-11-22 04:25:05','2016-11-22 04:25:05',NULL),(16,11,7,'2016-11-22 04:25:05','2016-11-22 04:25:05',NULL),(17,12,8,'2016-11-22 04:28:27','2016-11-22 04:28:27',NULL),(18,13,8,'2016-11-22 04:28:27','2016-11-22 04:28:27',NULL),(19,1,9,'2016-11-22 04:31:29','2016-11-22 04:31:29',NULL),(20,12,9,'2016-11-22 04:31:29','2016-11-22 04:31:29',NULL),(21,5,10,'2016-11-22 04:35:26','2016-11-22 04:35:26',NULL),(22,14,10,'2016-11-22 04:35:26','2016-11-22 04:35:26',NULL),(23,5,11,'2016-11-22 04:40:34','2016-11-22 04:40:34',NULL),(24,5,12,'2016-11-22 04:53:49','2016-11-22 04:53:49',NULL),(25,12,12,'2016-11-22 04:53:49','2016-11-22 04:53:49',NULL),(26,5,13,'2016-11-22 05:04:31','2016-11-22 05:04:31',NULL),(27,12,13,'2016-11-22 05:04:31','2016-11-22 05:04:31',NULL),(28,15,13,'2016-11-22 05:04:31','2016-11-22 05:04:31',NULL),(29,6,14,'2016-11-22 05:07:17','2016-11-22 05:07:17',NULL),(30,1,15,'2016-11-22 05:12:15','2016-11-22 05:12:15',NULL),(31,1,16,'2016-11-22 05:16:03','2016-11-22 05:16:03',NULL),(32,10,17,'2016-11-22 05:24:15','2016-11-22 05:24:15',NULL),(33,16,17,'2016-11-22 05:24:15','2016-11-22 05:24:15',NULL),(34,1,18,'2016-11-22 05:28:44','2016-11-22 05:28:44',NULL),(35,2,18,'2016-11-22 05:28:44','2016-11-22 05:28:44',NULL),(36,16,18,'2016-11-22 05:28:44','2016-11-22 05:28:44',NULL),(37,17,18,'2016-11-22 05:28:44','2016-11-22 05:28:44',NULL),(38,1,19,'2016-11-22 05:30:50','2016-11-22 05:30:50',NULL),(39,16,19,'2016-11-22 05:30:50','2016-11-22 05:30:50',NULL),(40,16,20,'2016-11-22 06:14:57','2016-11-22 06:14:57',NULL),(41,18,20,'2016-11-22 06:14:57','2016-11-22 06:14:57',NULL),(42,12,21,'2016-11-22 06:16:55','2016-11-22 06:16:55',NULL),(43,19,21,'2016-11-22 06:16:55','2016-11-22 06:16:55',NULL),(44,1,22,'2016-11-22 08:24:06','2016-11-22 08:24:06',NULL),(45,2,22,'2016-11-22 08:24:06','2016-11-22 08:24:06',NULL),(46,1,23,'2016-11-22 08:29:38','2016-11-22 08:29:38',NULL),(47,20,23,'2016-11-22 08:29:38','2016-11-22 08:29:38',NULL),(48,1,24,'2016-11-23 05:02:24','2016-11-23 05:02:24',NULL),(49,21,24,'2016-11-23 05:02:24','2016-11-23 05:02:24',NULL),(50,10,25,'2016-11-23 06:11:20','2016-11-23 06:11:20',NULL),(51,16,25,'2016-11-23 06:11:20','2016-11-23 06:11:20',NULL),(52,16,26,'2016-11-23 06:13:42','2016-11-23 06:13:42',NULL),(53,22,26,'2016-11-23 06:13:42','2016-11-23 06:13:42',NULL);
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
INSERT INTO `user_item_status` VALUES (1,1,1,1,'2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(2,1,2,1,'2016-11-22 03:51:51','2016-11-22 03:51:51',NULL),(3,1,3,1,'2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(4,1,4,1,'2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(5,1,5,1,'2016-11-22 04:17:34','2016-11-22 04:17:34',NULL),(6,1,6,2,'2016-11-22 04:21:46','2016-11-22 04:21:46',NULL),(7,1,7,2,'2016-11-22 04:25:05','2016-11-22 04:25:05',NULL),(8,1,8,1,'2016-11-22 04:28:27','2016-11-22 04:28:27',NULL),(9,1,9,2,'2016-11-22 04:31:29','2016-11-22 04:31:29',NULL),(10,1,10,2,'2016-11-22 04:35:26','2016-11-22 04:35:26',NULL),(11,1,11,1,'2016-11-22 04:40:34','2016-11-22 04:40:34',NULL),(12,1,12,1,'2016-11-22 04:53:49','2016-11-22 04:53:49',NULL),(13,1,13,2,'2016-11-22 05:04:31','2016-11-22 05:04:31',NULL),(14,1,14,1,'2016-11-22 05:07:17','2016-11-22 05:07:17',NULL),(15,1,16,1,'2016-11-22 05:12:15','2016-11-22 06:17:46',NULL),(16,1,17,2,'2016-11-22 05:16:03','2016-11-22 05:16:03',NULL),(17,1,18,2,'2016-11-22 05:24:15','2016-11-22 05:24:15',NULL),(18,1,19,1,'2016-11-22 05:28:44','2016-11-22 05:28:44',NULL),(19,1,20,1,'2016-11-22 05:30:50','2016-11-22 06:17:36',NULL),(20,1,21,1,'2016-11-22 06:14:57','2016-11-22 06:14:57',NULL),(21,1,22,1,'2016-11-22 06:16:55','2016-11-22 06:16:55',NULL),(22,2,22,2,'2016-11-22 08:22:42','2016-11-22 08:24:30',NULL),(23,2,20,0,'2016-11-22 08:26:42','2016-11-22 08:26:48',NULL),(24,2,19,2,'2016-11-22 08:26:53','2016-11-22 08:26:53',NULL),(25,2,13,2,'2016-11-22 08:26:59','2016-11-22 08:26:59',NULL),(26,2,12,2,'2016-11-22 08:29:38','2016-11-22 08:29:38',NULL),(27,2,7,1,'2016-11-23 05:02:24','2016-11-23 05:02:24',NULL),(28,1,23,2,'2016-11-23 06:11:20','2016-11-23 06:11:20',NULL),(29,1,24,1,'2016-11-23 06:13:42','2016-11-23 06:13:42',NULL);
/*!40000 ALTER TABLE `user_item_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_items`
--

LOCK TABLES `user_items` WRITE;
/*!40000 ALTER TABLE `user_items` DISABLE KEYS */;
INSERT INTO `user_items` (id, users_id, items_id, user_container_id, store_id, status, price, clip_count, img_url, img_site_url, item_condition, description, is_store, open_flag, created_at, updated_at, deleted_at) VALUES (1,1,1,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/1.jpg','http://www.apcjp.com/jpn/shop/apc/Davy+ブルゾン/item/view/shop_product_id/50718/category_id/985/color_id',0,'フェルトウール地. 抗ピリング素材の混紡. 弱撥水加工素材. ストレート、ショートカット. ボタンで取り外し可能なシープスキンのクラシックカラー. 三日月台衿. ボタン留め比翼ファスナー. シームポケット2つ. 後身ウエスト脇にプレッションボタン2つ',0,0,'2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(2,1,2,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/2.jpg','http://www.apcjp.com/jpn/shop/apc/Luc+手袋/item/view/shop_product_id/50818/category_id/991/color_id/10',0,'ウールとスムースレザー. 手の甲側と親指にスムースレザー. 手のひら側にニットウール. レザーパーツにステッチ. 手首外側にスリット.',0,0,'2016-11-22 03:51:51','2016-11-22 03:51:51',NULL),(3,1,3,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/3.jpg','http://www.apcjp.com/jpn/shop/apc/Calvi+バッグ/item/view/shop_product_id/50808/category_id/450/color_id',0,'ナイロンとイタリア製スムースレザー. 円筒形の型. ファスナー開閉. 2本のスムースレザーの持ち手. メタルバックルで調節可能、補強されたコットンリボンの取り外し可能なショルダーストラップ. スムースレザーのショルダーパッド. ',0,0,'2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(4,1,4,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/4.jpg','http://www.apcjp.com/jpn/shop/apc/Hiver+スウェット/item/view/shop_product_id/50766/category_id/988/color_',0,'スポーツコットンモルトン. 抗ピリング素材の混紡. とてもソフトな内側. ストレートカット. 縫い付けたバイアストリミングのクルーネック. 同色ツイルのネックテープ. 胸に\'HIVER\'刺繍. 長袖. 袖口と裾に縫い付けた太いバイアストリミング.',0,0,'2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(5,1,5,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/5.jpg','http://www.apcjp.com/jpn/shop/apc/Jérôme+ジャケット/item/view/shop_product_id/50840/category_id/408/color',0,'ウールギャバジン. テーラーカラー. 衿裏に薄手同色フェルト. 2つボタン. 胸に玉縁ポケット1つ. パッチポケット2つ. 胸にダーツ. サイドパネル. 袖口にボタン3つとスリット. センターベント. 内側に玉縁ポケット1つ. コットン/ナイロンの裏地付. ',0,0,'2016-11-22 04:17:33','2016-11-22 04:17:33',NULL),(6,1,6,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/6.jpg','http://www.apcjp.com/jpn/shop/apc/Time+コート/item/view/shop_product_id/50829/category_id/408/color_id/',0,'コットン/ウールブレンド. 弱撥水加工素材. ストレートカット. ステッチ入りクラシックカラー. 三日月台衿. ダブル仕立て. 6つボタン(3つは飾りボタン). ステイボタンと内側にドレープを美しく出すためのボタン. 右衿下にボタン1つ. ',0,0,'2016-11-22 04:21:44','2016-11-22 04:21:44',NULL),(7,1,7,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/7.jpg','http://www.apcjp.com/jpn/shop/apc/Alexandre+リュックサック/item/view/shop_product_id/50904/category_id/450/',0,'ボンデッド加工のイタリア製ジャージとラバー. 弱撥水加工. 玉縁ファスナー開閉. 下部横全体にファスナー付玉縁ポケット. ステッチ入り2本のレザー紐でバッグ底を四角に成型. トップにキャリーハンドルとA.P.C.刻印入りレザーラベル. ',0,0,'2016-11-22 04:24:57','2016-11-22 04:24:57',NULL),(8,1,8,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/8.jpg','http://www.apcjp.com/jpn/shop/apc/Jérémie+スウェットシャツ/item/view/shop_product_id/50869/category_id/408/c',0,'細マリンボーダーのジャージ. 心地よい流れるような素材. ストレートカット. バイアストリミングの縫い留められたクルーネック. ツイルのネックテープ',0,0,'2016-11-22 04:28:21','2016-11-22 04:28:21',NULL),(9,1,9,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/9.jpg','http://www.apcjp.com/jpn/shop/apc/Jude+チノ/item/view/shop_product_id/50834/category_id/408/color_id/1',0,'ウール/コットンブレンドのヘリンボーン. ストレートカット、裾は軽いテーパード. ファスナー開き. ウエストバンドに切り替え. ベルトループ. ウエストボタン2つ(1つは隠しボタン). シームポケット2つ. フォブポケット1つ. 後身にダーツ. 後身に玉縁ポケット1つ. 角ボタン. ',0,0,'2016-11-22 04:31:20','2016-11-22 04:31:20',NULL),(10,1,10,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/10.jpg','http://www.apcjp.com/jpn/shop/apc/Wales+コート/item/view/shop_product_id/50831/category_id/408/color_id',0,'ボンディング加工されたジャージとラバー. 弱撥水加工素材. ストレートカット. ボタン留めスタンドカラー. メタルチップとフラットレザーのストッパー付同色メッシュコットンのドローストリングで調節可能な大きなフード. ボタン留め比翼仕立て. 4つボタン. ラグランスリーブ. ',0,0,'2016-11-22 04:35:05','2016-11-22 04:35:05',NULL),(11,1,11,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/11.jpg','http://www.apcjp.com/jpn/shop/apc/Mecano+ジャケット/item/view/shop_product_id/50837/category_id/408/color',0,'ウールギャバジン. ファンシーリブのスタンドテディカラー. 着心地を良くするために前開き下にフラップ. 玉縁のラグランポケット2つ. セットインスリーブ. 左袖にガセット入りフラップポケット1つ. 内側に玉縁の縦ポケット1つ. 肘にダーツ. 袖口、裾にリブ.',0,0,'2016-11-22 04:40:33','2016-11-22 04:40:33',NULL),(12,1,12,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/12.jpg','http://www.apcjp.com/jpn/shop/apc/Trevor+オーバーシャツ/item/view/shop_product_id/50844/category_id/408/col',0,'タータンチェックウール. 抗ピリング素材. 織り柄. 前立てボタン6つ. 衿にステッチ. 後身にヨーク. 胸にステッチ入りパッチポケット1つ. 袖口にプリーツとスリット. ステッチ入りボタン留めカフス. シャツテール. フェルドシーム. ',0,0,'2016-11-22 04:53:48','2016-11-22 04:53:48',NULL),(13,1,13,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/13.jpg','http://www.apcjp.com/jpn/shop/apc/コンパクトウォレット/item/view/shop_product_id/50906/category_id/1000/color_',0,'エンボス加工のべジタブルタンニングのスペイン製レザー. 自然な古色を帯びる. イレギュラーな格子モチーフ. 二つ折リ財布. マルチファンクションポケット4つ、カード入れ3つ、紙幣入れ1つが付いたプレッションボタン留めメインポケット. ',0,0,'2016-11-22 05:04:30','2016-11-22 05:04:30',NULL),(14,1,14,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/14.jpg','http://www.apcjp.com/jpn/shop/apc/Paris+ベルト/item/view/shop_product_id/50909/category_id/408/color_id',0,'べジタルタンニングのスペイン製レザー. 自然な古色を帯びる. イレギュラーな格子モチーフ. フランス製. 四角いシルバーの真鍮製ローラーバックル. レザーのキーパー2つ. 尖ったチップ. 内側にシルバーのA.P.C.ロゴのプリントと取扱説明のプリント',0,0,'2016-11-22 05:07:16','2016-11-22 05:07:16',NULL),(15,1,16,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/15.jpg','http://www.apcjp.com/jpn/shop/apc/Skipton+Mac/item/view/shop_product_id/50827/category_id/408/color_',0,'コットン/ウールブレンドのプリンス・オブ・ウェールズチェック. 織り柄. 弱撥水加工素材. ストレートカット. ステッチ入りクラシックカラー. 三日月台衿. ボタン留め比翼仕立て. 4つボタン(トップボタンは表付け). ステイボタン. ラグランフラップポケット2つ. ',0,0,'2016-11-22 05:12:15','2016-11-22 05:12:15',NULL),(16,1,17,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/16.jpg','http://www.apcjp.com/jpn/shop/apc/Ringo+セーター/item/view/shop_product_id/50884/category_id/408/color_i',0,' \r\nRingo セーター\r\nムリネメリノウール/カシミヤブレンド. とてもソフトで暖かくフワフワした素材. ジャージ編み. ストレートシルエット. リブのクルーネック. 衿ぐり、アームホールシームに飾り編み. 長袖. 袖口、裾',0,0,'2016-11-22 05:16:03','2016-11-22 05:16:03',NULL),(17,1,18,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/17.jpg','http://www.apcjp.com/jpn/shop/apc/La+Rose+Tシャツ/item/view/shop_product_id/50877/category_id/408/color',0,'ドライコットンジャージ. ストレートカット. バイアストリミングの縫い留められたクルーネック. ネックテープ. 胸にルミナスチューブでプリントしたバラの写真. 半袖. ストレートテール. 後身左下にA.P.C.ロゴの刺繍. 袖口、裾にステッチ.',0,0,'2016-11-22 05:24:14','2016-11-22 05:24:14',NULL),(18,1,19,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/18.jpg','http://www.apcjp.com/jpn/shop/apc/Milan+オーバーシャツ/item/view/shop_product_id/50865/category_id/408/colo',0,'リネン/コットンピケ. ストレートカット. 前開きボタン6つ. 胸にパッチポケット1つ. 袖口にプリーツとボタン留めスリット. カフスボタン留め. 後身にヨーク. 軽いシャツテール. 内側シームにフェルドシーム. 貝ボタン. ',0,0,'2016-11-22 05:28:43','2016-11-22 05:28:43',NULL),(19,1,20,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/19.jpg','http://www.apcjp.com/jpn/shop/apc/Oh+L%27amour+Tシャツ/item/view/shop_product_id/50876/category_id/408/',0,'ドライコットンジャージ. ストレートカット. バイアストリミングの縫い留められたクルーネック. ネックテープ. 胸にタイポグラフィー\'\'OH L\'AMOUR\'\'のプリント. 長袖. 後身左下A.P.C.ロゴの刺繍. 袖口、裾にステッチ.',0,0,'2016-11-22 05:30:50','2016-11-22 05:30:50',NULL),(20,1,21,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/20.jpg','http://www.apcjp.com/jpn/shop/apc/Lagon+Tシャツ/item/view/shop_product_id/50878/category_id/988/color_i',0,'ドライコットンジャージ. ストレートカット. バイアストリミングの縫い留められたクルーネック. 胸にステッチ留めの杢コットンオックスフォードのバンド. 半袖. ストレートテール. 後身左下にA.P.C.ロゴの刺繍. 袖口、裾にステッチ',0,0,'2016-11-22 06:14:56','2016-11-22 06:14:56',NULL),(21,1,22,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/21.jpg','http://www.apcjp.com/jpn/shop/apc/Nick+セーター/item/view/shop_product_id/50880/category_id/989/color_id',0,'コットン/ウールブレンドのハニカムニット. 柔軟でコンパクトな素材. ストレートシルエット. リブのクルーネック. 衿ぐり、アームホールシームに飾り編み. 袖口、裾にリブ. ',0,0,'2016-11-22 06:16:55','2016-11-22 06:16:55',NULL),(22,2,22,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/22.jpg',NULL,0,'abcdesadffffffffffffffffffffffddddddd\r\n',0,0,'2016-11-22 08:24:06','2016-11-22 08:24:06',NULL),(23,2,12,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/23.jpg','http://www.apcjp.com/jpn/shop/apc/Trevor+オーバーシャツ/item/view/shop_product_id/50844/category_id/987/col',0,'Printemps16からサイズ規格を変更しています。\r\n製品寸法をご確認の上、ご注文お願いします。',0,0,'2016-11-22 08:29:38','2016-11-22 08:29:38',NULL),(24,2,7,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/24.jpg',NULL,0,'dfasdfadfdafdafafafa\r\ndfadfadfafaf',0,0,'2016-11-23 05:02:24','2016-11-23 05:02:24',NULL),(25,1,23,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/25.jpg','http://www.apcjp.com/jpn/shop/apc/A.P.C.+Japan+Tシャツ/item/view/shop_product_id/50510/category_id/988/',0,'ベーシックコットンジャージ. ストレートカット. バイアストリミングのクルーネック. ネックテープ. 胸に\'アペセ\'のプリント. 裾左にA.P.C.ロゴの刺繍. 半袖. 袖口、裾にステッチ.',0,0,'2016-11-23 06:11:19','2016-11-23 06:11:19',NULL),(26,1,24,0,NULL,1,0,0,'/user_items/c6f057b86584942e415435ffb1fa93d4/26.jpg','http://www.apcjp.com/jpn/shop/apc/L.A.+Tシャツ/item/view/shop_product_id/50504/category_id/988/color_id',0,'http://www.apcjp.com/jpn/shop/apc/L.A.+Tシャツ/item/view/shop_product_id/50504/category_id/988/color_id/1077/category_list_id/408',0,0,'2016-11-23 06:13:41','2016-11-23 06:13:41',NULL);
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
INSERT INTO `user_profile` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-22 03:34:30','2016-11-22 03:34:30',NULL),(2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-22 08:21:05','2016-11-22 08:21:05',NULL);
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_secret_profile`
--

LOCK TABLES `user_secret_profile` WRITE;
/*!40000 ALTER TABLE `user_secret_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_secret_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (id, name, avater_img_url, email, password, remember_token, created_at, updated_at, deleted_at, confirmation_token, confirmed_at, confirmation_sent_at) VALUES (1,'j-nasu',NULL,'spearmint6901@yahoo.co.jp','$2y$10$YRRgH9DfKrTtHna5rCLJtuCpeiZJjWbQN50kkRy3n1PRlemuqBDGK','3tS8u2LoALfl3AOTBpZiwewARESWLmuaVKsf5nX9u9GOvDoXi9psL5b8ZVeb','2016-11-22 03:34:30','2016-11-24 07:22:48',NULL,'399be271bdedff48e8336492c251546fd2c1f4dfe411450bc54d9720243d4000',NULL,'2016-11-22 03:34:30'),(2,'suga',NULL,'nasu@initialsite.com','$2y$10$Loj0qxzVWulb8YrkyHeqp.TCSM86IIFnbpgPmNUsVnTpCAIrMVUkO','6b7dYmgYOSJNktajBG7Mls2VJ6qv86cpag5jSUl0fSJ8b9RFi16IfGc3KwCQ','2016-11-22 08:21:05','2016-11-23 05:40:00',NULL,'17fd578823611b6cdcf02d9d778ec5ab8963dd47af7afb2c072f2ea922d693e5',NULL,'2016-11-22 08:21:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users2tags`
--

LOCK TABLES `users2tags` WRITE;
/*!40000 ALTER TABLE `users2tags` DISABLE KEYS */;
INSERT INTO `users2tags` VALUES (1,1,1,'2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(2,2,1,'2016-11-22 03:37:20','2016-11-22 03:37:20',NULL),(3,3,1,'2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(4,4,1,'2016-11-22 03:54:28','2016-11-22 03:54:28',NULL),(5,5,1,'2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(6,6,1,'2016-11-22 03:57:40','2016-11-22 03:57:40',NULL),(7,7,1,'2016-11-22 04:17:34','2016-11-22 04:17:34',NULL),(8,8,1,'2016-11-22 04:21:46','2016-11-22 04:21:46',NULL),(9,9,1,'2016-11-22 04:21:46','2016-11-22 04:21:46',NULL),(10,10,1,'2016-11-22 04:25:05','2016-11-22 04:25:05',NULL),(11,11,1,'2016-11-22 04:25:05','2016-11-22 04:25:05',NULL),(12,12,1,'2016-11-22 04:28:27','2016-11-22 04:28:27',NULL),(13,13,1,'2016-11-22 04:28:27','2016-11-22 04:28:27',NULL),(14,14,1,'2016-11-22 04:35:26','2016-11-22 04:35:26',NULL),(15,15,1,'2016-11-22 05:04:31','2016-11-22 05:04:31',NULL),(16,16,1,'2016-11-22 05:24:15','2016-11-22 05:24:15',NULL),(17,17,1,'2016-11-22 05:28:44','2016-11-22 05:28:44',NULL),(18,18,1,'2016-11-22 06:14:57','2016-11-22 06:14:57',NULL),(19,19,1,'2016-11-22 06:16:55','2016-11-22 06:16:55',NULL),(20,1,2,'2016-11-22 08:24:06','2016-11-22 08:24:06',NULL),(21,2,2,'2016-11-22 08:24:06','2016-11-22 08:24:06',NULL),(22,20,2,'2016-11-22 08:29:38','2016-11-22 08:29:38',NULL),(23,21,2,'2016-11-23 05:02:24','2016-11-23 05:02:24',NULL),(24,22,1,'2016-11-23 06:13:42','2016-11-23 06:13:42',NULL);
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

-- Dump completed on 2016-11-25  4:49:21
