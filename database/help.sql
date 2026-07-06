-- MySQL dump 10.13  Distrib 8.0.24, for Linux (x86_64)
--
-- Host: localhost    Database: help
-- ------------------------------------------------------
-- Server version	8.0.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_message`
--

DROP TABLE IF EXISTS `admin_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_message` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `subject` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `to_user` char(255) NOT NULL DEFAULT '' COMMENT 'FK(app_user,id,title)',
  `from_user` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `last_replied` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'radio(N=New,R=Read,D=Deleted)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_message`
--

LOCK TABLES `admin_message` WRITE;
/*!40000 ALTER TABLE `admin_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_message_reply`
--

DROP TABLE IF EXISTS `admin_message_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_message_reply` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `msg_id` int NOT NULL DEFAULT '0',
  `reply_text` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `replied_by` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'radio(N=New,R=Read,D=Deleted)',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `msg_id` (`msg_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_message_reply`
--

LOCK TABLES `admin_message_reply` WRITE;
/*!40000 ALTER TABLE `admin_message_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_message_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_note`
--

DROP TABLE IF EXISTS `admin_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_note` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ref_id` int unsigned NOT NULL DEFAULT '0',
  `ref_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'T' COMMENT 'radio(T=On TIcket, U=On Client)',
  `user_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `note` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_note`
--

LOCK TABLES `admin_note` WRITE;
/*!40000 ALTER TABLE `admin_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_log`
--

DROP TABLE IF EXISTS `app_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_log` (
  `user_id` char(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `user_type` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_role` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'C' COMMENT 'E=User, A=Admin,C=Company',
  `changed_page` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `changed_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'U' COMMENT 'U=Update, A=ADD, D=Delete,O=Others',
  `changed_value` char(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `msg_code` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `msg_param` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `ip` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `member_id` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `agent_id` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  KEY `pv_id` (`user_id`) USING BTREE,
  KEY `agent_id` (`agent_id`) USING BTREE,
  KEY `member_id` (`member_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_log`
--

LOCK TABLES `app_log` WRITE;
/*!40000 ALTER TABLE `app_log` DISABLE KEYS */;
INSERT INTO `app_log` VALUES ('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','159.192.42.60','2024-01-18 04:43:24','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/logout.html','A','','l001','Logout','159.192.42.191','2024-01-18 13:02:00','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html','A','','l001','Login','159.192.42.191','2024-01-18 13:02:32','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','36.82.88.240','2024-01-18 13:02:37','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=General, parent_category=0, show_on=B, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 13:13:17','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/add.html','A','name=General, status=A','l001','','159.192.42.191','2024-01-18 13:15:14','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Installation, parent_category=0, show_on=B, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 13:15:43','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Bug, parent_category=0, show_on=T, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 13:17:39','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html','A','','l001','Login','159.192.42.191','2024-01-18 15:13:41','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Global Setting, parent_category=0, show_on=K, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 15:15:09','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Dashboard, parent_category=0, show_on=K, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 15:15:20','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Products, parent_category=0, show_on=K, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 15:15:31','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Orders, parent_category=0, show_on=K, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 15:15:41','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Subscription, parent_category=0, show_on=K, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 15:15:53','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/add.html','A','name=Installation, status=A','l001','','159.192.42.191','2024-01-18 15:19:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/add.html','A','name=Products, status=I','l001','','159.192.42.191','2024-01-18 15:22:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/edit/3.html','U','status=A','l002','','159.192.42.191','2024-01-18 15:22:34','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/add.html','A','name=Order, status=A','l001','','159.192.42.191','2024-01-18 15:22:43','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/edit/3.html','U','name=Product','l002','','159.192.42.191','2024-01-18 15:22:49','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/add.html','A','name=Setting, status=A','l001','','159.192.42.191','2024-01-18 15:23:24','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/7.html','U','title=Order, show_on=K','l002','','159.192.42.191','2024-01-18 15:28:17','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/6.html','U','title=Product, show_on=K','l002','','159.192.42.191','2024-01-18 15:28:25','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Font, parent_category=4, show_on=K, status=A, parent_category_path=4','l001','','159.192.42.191','2024-01-18 15:30:23','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/5.html','U','title=Color, parent_category=4, show_on=K, parent_category_path=4','l002','','159.192.42.191','2024-01-18 15:30:40','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Clipart, parent_category=4, show_on=B, status=A, parent_category_path=4','l001','','159.192.42.191','2024-01-18 15:30:58','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/10.html','U','show_on=K','l002','','159.192.42.191','2024-01-18 15:31:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Templates, parent_category=4, show_on=B, status=A, parent_category_path=4','l001','','159.192.42.191','2024-01-18 15:31:19','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Translation, parent_category=4, show_on=K, status=A, parent_category_path=4','l001','','159.192.42.191','2024-01-18 15:31:31','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/11.html','U','show_on=K','l002','','159.192.42.191','2024-01-18 15:31:39','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category-confirm/status-change/9.html','U','status=I','l002','Category','159.192.42.191','2024-01-18 15:32:11','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category-confirm/status-change/10.html','U','status=I','l002','Category','159.192.42.191','2024-01-18 15:32:15','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category-confirm/status-change/11.html','U','status=I','l002','Category','159.192.42.191','2024-01-18 15:32:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category-confirm/status-change/12.html','U','status=I','l002','Category','159.192.42.191','2024-01-18 15:32:23','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=App Enhancement, parent_category=0, show_on=B, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 15:33:14','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/13.html','U','show_on=T','l002','','159.192.42.191','2024-01-18 15:33:22','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Req Template, parent_category=0, show_on=T, status=A, parent_category_path=0','l001','','159.192.42.191','2024-01-18 15:34:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fticket.html','A','','l001','Login','159.192.43.113','2024-01-20 14:48:16','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/custom-field/add.html','A','title=Shop ID, help_text=, cat_id=R, type=T, is_required=Y, status=A, is_on_grid=Y, is_api_based=N, id=AA, fld_order=1','l001','','159.192.43.113','2024-01-20 14:50:53','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/custom-field/add.html','A','title=Store Url, help_text=, cat_id=R, type=U, is_required=Y, status=A, is_on_grid=N, is_api_based=N, id=AB, fld_order=2','l001','','159.192.43.113','2024-01-20 14:51:50','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/custom-field/add.html','A','title=Plan, help_text=, cat_id=R, type=T, is_required=Y, status=A, is_on_grid=Y, is_api_based=N, id=AC, fld_order=3','l001','','159.192.43.113','2024-01-20 14:52:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/custom-field/add.html','A','title=Country, help_text=, cat_id=R, type=T, is_required=Y, status=A, is_on_grid=Y, is_api_based=N, id=AD, fld_order=4','l001','','159.192.43.113','2024-01-20 14:52:50','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/custom-field/add.html','A','title=Phone, help_text=, cat_id=R, type=T, is_required=N, status=A, is_on_grid=Y, is_api_based=N, id=AE, fld_order=5','l001','','159.192.43.113','2024-01-20 14:53:15','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=FAQ, parent_category=0, show_on=K, status=A, parent_category_path=0','l001','','159.192.43.113','2024-01-20 15:05:16','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','159.192.42.203','2024-01-22 02:19:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/logout.html','A','','l001','Logout','159.192.42.203','2024-01-22 02:19:28','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html','A','','l001','Login','159.192.42.203','2024-01-22 02:20:06','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','103.126.30.114','2024-01-22 02:22:46','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','180.254.78.72','2024-01-22 13:59:59','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','159.192.42.64','2024-01-22 14:27:09','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','103.126.30.114','2024-01-23 05:06:53','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','159.192.42.64','2024-01-23 13:22:00','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/logout.html','A','','l001','Logout','159.192.42.64','2024-01-23 13:26:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','159.192.42.13','2024-01-24 13:07:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fcategory.html','A','','l001','Login','159.192.42.248','2024-02-02 00:54:02','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/notice/add','A','added_by=AA, title=Test Announcement, msg=<p>App Open</p>\n, start_date=2024-02-02, end_date=2024-02-09, msg_for=B, status=A','l001','','159.192.42.138','2024-02-02 12:41:01','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/1','D','id=1','l003','Knowledge_confirm','159.192.42.138','2024-02-02 12:41:16','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=How To Install IMCST App., is_stickey=N, status=U, cat_id=2, k_body=<p>To install the app it\'s very easy just follow this step<br></p>\n, featured_video_link=https://youtu.be/ccu6JuC21rk?si=WfJJXL3m-ZGjwZ3-, k_tag=How To Install,...','l001','','159.192.42.138','2024-02-02 12:43:36','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/2','U','title=How To Install IMCST App., is_stickey=N, status=P, cat_id=2, k_body=<p>To install the app it\'s very easy just follow this step<br></p>\n, featured_video_link=https://youtu.be/ccu6JuC21rk?si=WfJJXL3m-ZGjwZ3-, k_tag=How To Install,Installation,...','l002','','159.192.42.138','2024-02-02 12:44:04','','',''),('admin','AD','R1','https://help.imakecustom.com//admin/knowledge/edit/2','U','title=How To Install IMCST App, is_stickey=N, status=P, cat_id=2, k_body=<p>To install the app it\'s very easy just follow this step<br></p>\n, featured_video_link=https://youtu.be/ccu6JuC21rk?si=WfJJXL3m-ZGjwZ3-, k_tag=How To Install,Installation,I...','l002','','159.192.42.138','2024-02-02 13:31:25','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=How To Uninstall, is_stickey=N, status=P, cat_id=2, k_body=<p>How To Uninstall or remove the app<br></p>\n, featured_video_link=, k_tag=Uninstall,Remove App,Unsubcribe, entry_time=2024-02-02 20:32:41, last_update_time=2024-02-02 ...','l001','','159.192.42.138','2024-02-02 13:32:41','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/4','U','title=Setting, show_on=K','l002','','159.192.42.138','2024-02-02 13:37:23','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=How To Upgrade or Downgrade Plan / Package, is_stickey=N, status=U, cat_id=2, k_body=<p>How To Upgrade or Downgrade Plan / Package<br></p>\n, featured_video_link=, k_tag=Upgrade Plan,Downgrade Plan,Upgrade Package,Downgrade Packa...','l001','','159.192.42.138','2024-02-02 13:38:45','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category-confirm/faq_category-delete/2','D','id=2','l003','Faq_category_confirm','159.192.42.138','2024-02-02 13:39:09','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/6','U','title=How To, show_on=K','l002','','159.192.42.138','2024-02-02 13:41:35','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/2','U','title=Install IMCST App, is_stickey=N, status=P, cat_id=2, k_body=<p>To install the app it\'s very easy just follow this step<br></p>\n, featured_video_link=https://youtu.be/ccu6JuC21rk?si=WfJJXL3m-ZGjwZ3-, k_tag=How To Install,Installation,IMCST AP...','l002','','159.192.42.138','2024-02-02 13:42:01','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/3','U','title=Uninstallation, is_stickey=N, status=P, cat_id=2, k_body=<p>How To Uninstall or remove the app<br></p>\n, featured_video_link=, k_tag=Uninstall,Remove App,Unsubcribe, slug_id=uninstallation, last_update_time=2024-02-02 20:42:18','l002','','159.192.42.138','2024-02-02 13:42:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/4','U','title=Upgrade or Downgrade Plan / Package, is_stickey=N, status=U, cat_id=2, k_body=<p>How To Upgrade or Downgrade Plan / Package<br></p>\n, featured_video_link=, k_tag=Upgrade Plan,Downgrade Plan,Upgrade Package,Downgrade Package, slug_id=upgrade-...','l002','','159.192.42.138','2024-02-02 13:42:33','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/4','U','title=Upgrade or Downgrade Plan / Package, is_stickey=N, status=P, cat_id=2, k_body=<p>How To Upgrade or Downgrade Plan / Package<br></p>\n, featured_video_link=, k_tag=Upgrade Plan,Downgrade Plan,Upgrade Package,Downgrade Package, slug_id=upgrade-...','l002','','159.192.42.138','2024-02-02 13:43:44','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=How to customize the product, is_stickey=N, status=P, cat_id=0, k_body=<p>How to customize the product<br></p>\n, featured_video_link=, k_tag=adding the product,customizing the product,product customize,import product, entry_time...','l001','','159.192.42.138','2024-02-02 13:44:23','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=How to remove the product from customize, is_stickey=N, status=P, cat_id=0, k_body=<p>How to remove the product from customize<br></p>\n, featured_video_link=, k_tag=Uncustomize the product,remove the product, entry_time=2024-02-...','l001','','159.192.42.138','2024-02-02 13:45:28','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/5','U','title=How to customize the product, is_stickey=N, status=P, cat_id=6, k_body=<p>How to customize the product<br></p>\n, featured_video_link=, k_tag=adding the product,customizing the product,product customize,import product, slug_id=how-to-customiz...','l002','','159.192.42.138','2024-02-02 16:24:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/6','U','title=How to remove the product from customize, is_stickey=N, status=P, cat_id=2, k_body=<p>How to remove the product from customize<br></p>\n, featured_video_link=, k_tag=Uncustomize the product,remove the product, slug_id=how-to-remove-the-produc...','l002','','159.192.42.138','2024-02-02 16:24:35','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=How to use dtfg printing, is_stickey=N, status=P, cat_id=6, k_body=<p>How to use dtfg printing<br></p>\n, featured_video_link=, k_tag=dtfg printing,quantity price,printing, entry_time=2024-02-02 23:33:03, last_update_time=2024-02...','l001','','159.192.42.138','2024-02-02 16:33:03','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=How to add option, is_stickey=N, status=P, cat_id=6, k_body=<p>How to add option<br></p>\n, featured_video_link=, k_tag=Add option,additional option,custom product,imcst, entry_time=2024-02-02 23:33:54, last_update_time=2024-02-0...','l001','','159.192.42.138','2024-02-02 16:33:54','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General Setting<br></p>\n, featured_video_link=, k_tag=Setting,General Setting,Global Setting,Default Setting, entry_time=2024-02-02 23:34:39, last_update_time=2024-02-...','l001','','159.192.42.138','2024-02-02 16:34:39','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=Option Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>Option Setting<br></p>\n, featured_video_link=, k_tag=Setting,General Option Setting,Option Setting,Default Setting, entry_time=2024-02-02 23:35:53, last_update_time=202...','l001','','159.192.42.138','2024-02-02 16:35:53','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=Design Output Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>Design Output Setting<br></p>\n, featured_video_link=, k_tag=Final output,Design Output,Final Design,Final Custom,Design Custom, entry_time=2024-02-03 09:55:42, l...','l001','','159.192.42.138','2024-02-03 02:55:42','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/7','U','title=DTFG printing, is_stickey=N, status=P, cat_id=6, k_body=<p>How to use dtfg printing<br></p>\n, featured_video_link=, k_tag=dtfg printing,quantity price,printing, slug_id=dtfg-printing, last_update_time=2024-02-03 18:41:04','l002','','159.192.42.138','2024-02-03 11:41:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fknowledge%2Fadd','A','','l001','Login','159.192.42.138','2024-02-03 15:24:57','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fknowledge%2Fadd','A','','l001','Login','159.192.42.138','2024-02-03 15:27:13','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=Font Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>How to add the font</p>\n, featured_video_link=, k_tag=add font, entry_time=2024-02-03 22:39:58, last_update_time=2024-02-03 22:39:58, slug_id=font-setting, k_soundex=F532...','l001','','159.192.42.138','2024-02-03 15:39:58','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=Gallery Images, is_stickey=N, status=P, cat_id=4, k_body=<p>How to add images gallery</p>\n, featured_video_link=, k_tag=Gallery Images,Clipart,Add New Images Gallery, entry_time=2024-02-03 22:41:18, last_update_time=2024-02-03 2...','l001','','159.192.42.138','2024-02-03 15:41:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=Translation, is_stickey=N, status=P, cat_id=4, k_body=<p>How to add translation</p>\n, featured_video_link=, k_tag=App Translation, entry_time=2024-02-03 22:41:44, last_update_time=2024-02-03 22:41:44, slug_id=translation, k_soun...','l001','','159.192.42.138','2024-02-03 15:41:44','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/11','U','title=Design Output, is_stickey=N, status=P, cat_id=4, k_body=<p>Design Output Setting<br></p>\n, featured_video_link=, k_tag=Final output,Design Output,Final Design,Final Custom,Design Custom, slug_id=design-output, last_update_time=2024-02-03 23:...','l002','','159.192.42.138','2024-02-03 16:15:32','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/12','U','title=Font, is_stickey=N, status=P, cat_id=4, k_body=<p>How to add the font</p>\n, featured_video_link=, k_tag=add font, slug_id=font, last_update_time=2024-02-04 11:33:57','l002','','159.192.42.153','2024-02-04 04:33:57','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/10','U','title=Option, is_stickey=N, status=P, cat_id=4, k_body=<p>Option Setting<br></p>\n, featured_video_link=, k_tag=Setting,General Option Setting,Option Setting,Default Setting, slug_id=option, last_update_time=2024-02-04 11:34:19','l002','','159.192.42.153','2024-02-04 04:34:19','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=Template, is_stickey=N, status=P, cat_id=4, k_body=<p>IMCST Template</p>\n, featured_video_link=, k_tag=Template,Template Setting,Template area, entry_time=2024-02-04 11:36:05, last_update_time=2024-02-04 11:36:05, slug_id=templa...','l001','','159.192.42.153','2024-02-04 04:36:05','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin','A','','l001','Login','45.79.211.244','2024-02-07 08:06:09','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/logout','A','','l001','Logout','45.79.211.244','2024-02-10 02:29:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin','A','','l001','Login','45.79.211.244','2024-02-21 11:23:15','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/changelog/add','A','status=fixed, title=Launching App, tanggal=2024-02-21','l001','','45.79.211.244','2024-02-21 11:28:16','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin','A','','l001','Login','45.79.211.244','2024-03-08 13:15:29','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fknowledge%2Fedit%2F2','A','','l001','Login','45.79.211.244','2024-03-09 09:21:13','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fknowledge%2Fedit%2F2','A','','l001','Login','45.79.211.244','2024-03-11 22:15:39','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/edit/4','U','canned_msg=<span xss=removed>Hi <font color=\"#333333\" face=\"system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen-Sans, Ubuntu, Cantarell, Helvetica Neue, Arial, sans-serif\">{{ticket_user}},</font><br xss=removed><br xss=removed>...','l002','Canned Message','45.79.211.244','2024-03-11 22:22:10','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/edit/3','U','canned_msg=<p xss=removed>Hi {{{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>Thank you for your confirm.</p><p xss=removed>Unfortunately, we have not received the email containing the access.</p><p xss=removed><br xss=removed></...','l002','Canned Message','45.79.211.244','2024-03-11 22:24:09','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p xss=removed>Hello,<p xss=removed><br xss=removed></p><p xss=removed>We have created your special Shopify store:</p><p xss=removed><br xss=removed></p><p xss=removed><span xss=removed><a href=\"https://leashly-site.mysho...','l001','','45.79.211.244','2024-03-11 22:25:34','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p xss=removed>Hi {{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>We would be happy to finish the installation for you!</p><p xss=removed><br xss=removed>Please send the staff access login or create a ne...','l001','','45.79.211.244','2024-03-11 22:26:56','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p xss=removed>Hi {{reply_user}},<p xss=removed><br xss=removed></p><p xss=removed>We have fixed the issue you reported.</p><p xss=removed>Please let me know if you need anything else.</p><p xss=removed><br xss=removed></...','l001','','45.79.211.244','2024-03-11 22:28:10','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/edit/5','U','canned_msg=<p xss=\"removed\">Hello,<p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">We have created your special Shopify store:</p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">{{site_url}}</p><p xss=\"removed\"><br></p><p xss=\"remov...','l002','Canned Message','45.79.211.244','2024-03-11 22:28:49','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p xss=removed>Hi {{ticket_user}},<br xss=removed><br xss=removed>We have completed the installation.<br xss=removed>You can now start adding your products to IMCST App.<p xss=removed>Please check following the tutorial o...','l001','','45.79.211.244','2024-03-11 22:30:38','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p>Hi {{ticket_user}},<p xss=removed>Thank you for reaching out.</p><p xss=removed><br xss=removed></p><p xss=removed>We would love to check this for you. To help you further, we sent a collaborator request. Kindly let us...','l001','','45.79.211.244','2024-03-11 22:31:31','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p xss=removed>HI {{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>Thank you for using our app, Customify.<br xss=removed></p><p xss=removed><br xss=removed></p><p xss=removed>Your honest feedback helps e...','l001','','45.79.211.244','2024-03-11 22:32:28','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p xss=removed>Hi {{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>We are sorry to see you are going to uninstall the app.</p><p xss=removed>Please kindly check our tutorial to see how to uninstall the ap...','l001','','45.79.211.244','2024-03-11 22:33:20','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p xss=removed>Hi {{ticket_user}},<p xss=removed><br xss=removed>It\'s a pleasure to help you :).</p><p xss=removed>Please feel free to contact us if you need anything else.</p><p xss=removed><br xss=removed></p><p xss=rem...','l001','','45.79.211.244','2024-03-11 22:47:03','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p><span xss=removed>Hi </span>{{ticket_user}},<br xss=removed><br xss=removed><span xss=removed>Thank you for the access!</span><br xss=removed><span xss=removed>We have started on the app installation.</span><br xss=re...','l001','','45.79.211.244','2024-03-11 22:47:52','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/canned-msg/add','A','canned_type=T, canned_msg=<p xss=removed>Hi {{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>It seems we haven\'t heard back from you recently, so we\'re planning to close this ticket to keep things tidy. But remember, our door is a...','l001','','45.79.211.244','2024-03-11 22:48:28','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add','A','cat_id=1, question=Do you offer free installation?, ans=Yes, we offering free installation with free charges., status=A','l001','','45.79.211.244','2024-03-11 22:58:27','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add','A','cat_id=3, question=How many products I can add?, ans=The number of products you can add to the product customizer is based to your subscription plan.\r\n\r\nYou can see the details in the product customizer pricing plan page., status=I','l001','','45.79.211.244','2024-03-11 23:00:07','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Ffaq-list','A','','l001','Login','45.79.211.244','2024-03-12 21:21:43','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add','A','cat_id=3, question=What kind of products can be customized?\r\n, ans=All products can be customized by our app you can use it for t-shirt, phone case, box and etc., status=I','l001','','45.79.211.244','2024-03-12 21:24:27','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add','A','cat_id=1, question=Do you offer a money back guarantee?\r\n, ans=We dont offer a money back guarantee in case you found the app is not fit with you. However, you can avoid any charge by uninstalling the app before the trial period ended., status=I','l001','','45.79.211.244','2024-03-12 21:26:25','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/4','U','question=Do you offer a money-back guarantee?, ans=We dont offer a money back guarantee in case you found the app is not fit with you. However, you can avoid any charge by uninstalling the app before the trial period ends., status=A','l002','','45.79.211.244','2024-03-12 21:27:03','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/2','U','status=A','l002','','45.79.211.244','2024-03-12 21:27:11','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/3','U','status=A','l002','','45.79.211.244','2024-03-12 21:27:17','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add','A','cat_id=5, question=What kind of fonts did you support?, ans=Our app supports any kind of font, custom font the font you uploaded by yourself, google font, and also standard font. with any type of font ttf, tof, and many more., status=A','l001','','45.79.211.244','2024-03-12 21:31:29','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add','A','cat_id=1, question=Additional charge pricing?, ans=We support additional charge pricing.\r\nif you have additional pricing you need to charge for your customer we have a flexible option to charge based on text, images, or global charge also we suppo...','l001','','45.79.211.244','2024-03-12 21:34:44','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add','A','cat_id=1, question=Supported Image, ans=Our app can customize every image with extensions jpeg, jpg, png, tiff, and anymore.\r\nFor vector, we also support it, including a pdf file., status=A','l001','','45.79.211.244','2024-03-12 21:35:56','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add','A','cat_id=1, question=What is the output file generated by the app?, ans=For the owner store our app will generate a final image, a ready file. also you can enable the option original file to get the original image uploaded by the customer, and also ...','l001','','45.79.211.244','2024-03-12 21:38:22','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list-confirm/status-change/8','U','status=A','l002','Faq_list','45.79.211.244','2024-03-12 21:38:31','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/menu/edit/2','U','href_type=L, href=http://imakecustom.com, text_icon=fa-external-link','l002','','45.79.211.244','2024-03-12 21:46:22','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin','A','','l001','Login','45.79.211.244','2024-03-18 09:44:22','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/client/edit/5','U','first_name=quickstart-044cdd31, last_name=quickstart-044cdd31, gender=male, country=ID, status=A','l002','','45.79.211.244','2024-03-18 11:07:07','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/4','D','id=4','l003','Ticket_confirm','45.79.211.244','2024-03-20 10:45:53','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/6','D','id=6','l003','Ticket_confirm','45.79.211.244','2024-03-20 10:53:26','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/5','D','id=5','l003','Ticket_confirm','45.79.211.244','2024-03-20 10:53:31','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/3','D','id=3','l003','Ticket_confirm','45.79.211.244','2024-03-20 10:53:36','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin','A','','l001','Login','45.79.211.244','2024-03-20 15:04:13','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/logout','A','','l001','Logout','45.79.211.244','2024-03-20 15:04:44','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin','A','','l001','Login','45.79.211.244','2024-03-20 15:50:26','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/2','D','id=2','l003','Ticket_confirm','45.79.211.244','2024-03-21 09:14:47','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fnotification%2Fshow%2F8.html','A','','l001','Login','45.79.211.244','2024-03-22 02:09:11','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/9.html','D','id=9','l003','Ticket_confirm','45.79.211.244','2024-03-22 04:58:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/8.html','D','id=8','l003','Ticket_confirm','45.79.211.244','2024-03-22 05:00:48','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/10.html','D','id=10','l003','Ticket_confirm','45.79.211.244','2024-03-22 05:00:53','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/11.html','D','id=11','l003','Ticket_confirm','45.79.211.244','2024-03-22 05:02:24','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/ticket-confirm/ticket-delete/12.html','D','id=12','l003','Ticket_confirm','45.79.211.244','2024-03-22 05:02:29','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/2.html','U','title=Install IMCST App, is_stickey=N, status=P, cat_id=2, k_body=<p>To install the app it\'s very easy just follow this step<br><p><img src=\"https://help.imakecustom.com/data/knowledge/feature.png\" style=\"width: 438px;\"></p><p><br></p></p>\n, featu...','l002','','45.79.211.244','2024-03-22 10:54:34','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/2.html','U','title=Install IMCST App, is_stickey=N, status=P, cat_id=2, k_body=<p>To install the app it\'s very easy just follow this step<br><p><img src=\"https://help.imakecustom.com/data/knowledge/feature.png\" style=\"width: 438px;\"></p><p><br></p></p>\n, featu...','l002','','45.79.211.244','2024-03-22 10:54:41','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','45.79.211.244','2024-03-22 11:14:33','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/client/edit/13.html','U','first_name=imakecustom-dev-test, last_name=imakecustom-dev-test, email=imakecustom-dev-test@email.com, gender=male, country=ID, status=A','l002','','45.79.211.244','2024-03-27 08:20:10','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/client/edit/5.html','U','first_name=quickstart-044cdd31-test, last_name=quickstart-044cdd31-test, email=quickstart-044cdd31-test@email.com, status=A','l002','','45.79.211.244','2024-03-27 08:29:06','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/client/edit/5.html','U','','l002','','45.79.211.244','2024-03-27 08:43:20','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/client/edit/5.html','U','first_name=quickstart-044cdd31-test, last_name=quickstart-044cdd31-test, email=kemzoft85@gmail.com, status=A','l002','','45.79.211.244','2024-03-27 08:45:53','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/client-confirm/is-verified-email-change/5.html','U','is_verified_email=Y','l002','Client','45.79.211.244','2024-03-27 08:46:00','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fclient.html','A','','l001','Login','45.79.211.244','2024-03-28 07:22:29','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin%2Fclient.html','A','','l001','Login','45.79.211.244','2024-03-29 09:56:12','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','45.79.211.244','2024-03-30 14:13:14','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','180.246.56.13','2024-04-02 21:46:46','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/system-msg-confirm/system-msg-dismiss/60.html','D','id=60','l003','System_msg_confirm','180.246.56.13','2024-04-02 21:46:56','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','36.79.67.84','2024-04-04 20:47:53','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','159.192.43.241','2024-04-29 13:57:30','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/changelog/add.html','A','status=fixed, title=Bug Add Text, tanggal=2024-04-29','l001','','159.192.43.241','2024-04-29 13:59:09','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/notice/add.html','A','added_by=AA, title=Libur Hari Raya, msg=<p>Kami akan libur dua hari selama idul fitri</p>\n, start_date=2024-04-30, end_date=2024-05-01, msg_for=B, status=A','l001','','159.192.43.241','2024-04-30 12:23:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/user/login.html?_ru=https%3A%2F%2Fhelp.imakecustom.com%2Fadmin.html','A','','l001','Login','159.192.43.239','2024-05-14 23:31:14','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/system-msg-confirm/system-msg-dismiss/61.html','D','id=61','l003','System_msg_confirm','159.192.43.239','2024-05-14 23:32:02','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/custom-field/add.html','A','title=App Name, help_text=App name that used by the customer, cat_id=0, type=D, opt_json_base=Uploadfly,Amazonify,IMCST, is_required=Y, status=A, is_on_grid=Y, is_api_based=N, id=AK, fld_order=11','l001','','159.192.42.132','2024-05-16 15:51:17','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Uploadfly, parent_category=0, show_on=B, status=A, parent_category_path=0','l001','','159.192.42.132','2024-05-16 15:53:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=General, parent_category=16, show_on=B, status=A, parent_category_path=16','l001','','159.192.42.132','2024-05-16 15:53:36','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/system-msg-confirm/system-msg-dismiss/62.html','D','id=62','l003','System_msg_confirm','159.192.42.224','2024-05-18 13:27:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=IMCST, parent_category=0, show_on=B, status=A, parent_category_path=0','l001','','159.192.42.224','2024-05-18 13:27:35','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=Amazonify, parent_category=0, show_on=B, status=A, parent_category_path=0','l001','','159.192.42.224','2024-05-18 13:27:47','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/1.html','U','parent_category=17, show_on=B, parent_category_path=16-17','l002','','159.192.42.224','2024-05-18 13:28:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/8.html','U','parent_category=16, show_on=K, parent_category_path=16','l002','','159.192.42.224','2024-05-18 13:29:03','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/1.html','U','parent_category=16, show_on=B, parent_category_path=16','l002','','159.192.42.224','2024-05-18 13:29:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/4.html','U','parent_category=16, show_on=K, parent_category_path=16','l002','','159.192.42.224','2024-05-18 13:29:36','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/7.html','U','parent_category=16, show_on=K, parent_category_path=16','l002','','159.192.42.224','2024-05-18 13:29:42','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/2.html','U','parent_category=16, show_on=B, parent_category_path=16','l002','','159.192.42.224','2024-05-18 13:29:52','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/3.html','U','parent_category=16, show_on=T, parent_category_path=16','l002','','159.192.42.224','2024-05-18 13:30:01','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/13.html','U','parent_category=16, show_on=T, parent_category_path=16','l002','','159.192.42.224','2024-05-18 13:30:14','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/15.html','U','parent_category=16, show_on=K, parent_category_path=16','l002','','159.192.42.224','2024-05-18 13:30:24','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/17.html','U','parent_category=18, show_on=B, parent_category_path=18','l002','','159.192.42.224','2024-05-18 13:30:51','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/14.html','U','parent_category=18, show_on=T, parent_category_path=18','l002','','159.192.42.224','2024-05-18 13:31:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/6.html','U','parent_category=18, show_on=K, parent_category_path=18','l002','','159.192.42.224','2024-05-18 13:31:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=FAQ, parent_category=16, show_on=B, status=A, parent_category_path=16','l001','','159.192.42.224','2024-05-18 13:33:11','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/add.html','A','title=News, parent_category=16, show_on=B, status=A, parent_category_path=16','l001','','159.192.42.224','2024-05-18 13:33:22','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/2.html','U','title=Install Uploadfly, is_stickey=N, status=P, cat_id=2, k_body=<p>To install the app it\'s very easy just follow this step<br><p><img src=\"https://help.imakecustom.com/data/knowledge/feature.png\" style=\"width: 438px;\"></p><p><br></p></p>\n, featu...','l002','','159.192.42.224','2024-05-18 13:38:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/5.html','U','title=What is uploadfly, is_stickey=N, status=P, cat_id=6, k_body=<p>What is uploadfly<br></p>\n, featured_video_link=, k_tag=adding the product,customizing the product,product customize,import product, slug_id=what-is-uploadfly, last_update_time=2...','l002','','159.192.42.224','2024-05-18 13:48:37','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add.html','A','added_by=AA, title=FAQ Uploadfly, is_stickey=N, status=P, cat_id=20, k_body=<div class=\"col-sm-6\">\r\n                                                                <div class=\"faq-item\">\r\n                                        <a class=\"faq-qus\" ...','l001','','159.192.42.224','2024-05-18 14:51:56','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/edit/5.html','U','name=Uploadfly','l002','','159.192.42.224','2024-05-18 14:54:48','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/edit/4.html','U','name=Amazonify','l002','','159.192.42.224','2024-05-18 14:54:57','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category/edit/3.html','U','name=IMCST','l002','','159.192.42.224','2024-05-18 14:55:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/1.html','U','cat_id=5','l002','','159.192.42.224','2024-05-18 14:55:16','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/2.html','U','cat_id=5','l002','','159.192.42.224','2024-05-18 14:55:26','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/3.html','U','cat_id=5','l002','','159.192.42.224','2024-05-18 14:55:45','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/4.html','U','cat_id=5','l002','','159.192.42.224','2024-05-18 14:55:52','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/6.html','U','cat_id=5','l002','','159.192.42.224','2024-05-18 14:56:01','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/7.html','U','cat_id=5','l002','','159.192.42.224','2024-05-18 14:56:07','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/8.html','U','cat_id=5','l002','','159.192.42.224','2024-05-18 14:56:13','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-category-confirm/faq_category-delete/1.html','D','id=1','l003','Faq_category_confirm','159.192.42.224','2024-05-18 14:56:22','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/1.html','U','ans=Yes, we are offering free installation.','l002','','159.192.42.224','2024-05-18 14:56:46','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/2.html','U','ans=The number of products you can add to the app is based on your subscription plan.\r\n\r\nYou can see the details on the product customizer pricing plan page.','l002','','159.192.42.224','2024-05-18 15:19:05','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/3.html','U','question=What kind of products can be used for this app?, ans=All products can use this app.','l002','','159.192.42.224','2024-05-18 15:19:36','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/4.html','U','ans=We dont offer a money-back guarantee in case you find the app is not fit with you. However, you can avoid any charge by uninstalling the app before the trial period ends.','l002','','159.192.42.224','2024-05-18 15:20:01','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/5.html','U','question=What kind of file that can be uploaded?, ans=Uploadfly support any file extension','l002','','159.192.42.224','2024-05-18 15:21:25','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/2.html','U','ans=The number of products you can add to the app is based on your subscription plan.\r\n\r\nYou can see the details on the pricing plan page.','l002','','159.192.42.224','2024-05-18 15:26:30','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add.html','A','cat_id=5, question=Do you have an image editor when uploading images?, ans=Yes, we have an image editor when someone upload the image you can also disable the image editor., status=I','l001','','159.192.42.224','2024-05-18 15:27:42','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/8.html','U','question=What file will be received by the store owner?, ans=The owner store uploadfly will send you the original file you can download it from the the files area.','l002','','159.192.42.224','2024-05-18 15:31:52','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add.html','A','cat_id=5, question=What platform uploadfly available?, ans=At the moment uploadfly is only available on Shopify but we will consider expanding the app support for Big Commerce and etsy., status=I','l001','','159.192.42.224','2024-05-18 15:35:38','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/3.html','U','ans=All kinds of products can use this app.','l002','','159.192.42.224','2024-05-18 15:36:05','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/9.html','U','ans=Yes, we have an image editor when someone uploads the image, you can also disable the image editor.','l002','','159.192.42.224','2024-05-18 15:36:43','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/6.html','U','ans=We support additional charge pricing.\r\nif you have additional pricing you need to charge for your customer we have a flexible option to charge based on the global pricing or custom pricing.','l002','','159.192.42.224','2024-05-18 15:37:45','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add.html','A','cat_id=5, question=What features does Uploadfly offer?, ans=Uploadfly has a flexible upload form, pricing, conditional logic, an image editor, and many more., status=I','l001','','159.192.42.224','2024-05-18 15:39:02','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/7.html','U','question=Supported file for uploadfly, ans=Uploadfly supports any type of file, you can also add the type of file by yourself.','l002','','159.192.42.224','2024-05-18 15:40:27','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/edit/10.html','U','status=A','l002','','159.192.42.224','2024-05-18 15:41:20','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list-confirm/status-change/9.html','U','status=A','l002','Faq_list','159.192.42.224','2024-05-18 15:41:24','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list-confirm/status-change/11.html','U','status=A','l002','Faq_list','159.192.42.224','2024-05-18 15:44:10','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add.html','A','cat_id=5, question=Does uploadfly support bulk upload and multiple file upload., ans=Yes, uploadfly supports bulk upload, single upload, multiple file upload you can setting the upload from setting area., status=I','l001','','159.192.42.224','2024-05-18 15:47:39','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add.html','A','cat_id=5, question=Does uploadfly work with the buy button?, ans=Yes, uploadfly is working without any issue with the buy button., status=I','l001','','159.192.42.224','2024-05-18 15:49:21','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list-confirm/status-change/13.html','U','status=A','l002','Faq_list','159.192.42.224','2024-05-18 15:49:29','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add.html','A','cat_id=5, question=Does uploadfly support image preview?, ans=Yes, uploadfly supports image preview in the product and cart, without adding any code you can activate that option from the setting., status=I','l001','','159.192.42.224','2024-05-18 15:51:34','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list/add.html','A','cat_id=5, question=Can we reorder the upload field?, ans=Yes, you can reorder the upload field by drag and drop, status=I','l001','','159.192.42.224','2024-05-18 15:54:31','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list-confirm/status-change/14.html','U','status=A','l002','Faq_list','159.192.42.224','2024-05-18 15:54:35','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list-confirm/status-change/12.html','U','status=A','l002','Faq_list','159.192.42.224','2024-05-18 15:54:41','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/faq-list-confirm/status-change/15.html','U','status=A','l002','Faq_list','159.192.42.224','2024-05-18 15:54:44','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category-confirm/status-change/20.html','U','status=I','l002','Category','159.192.42.224','2024-05-18 15:56:29','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category-confirm/status-change/15.html','U','status=I','l002','Category','159.192.42.224','2024-05-18 15:56:34','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/16.html','D','id=16','l003','Knowledge_confirm','159.192.42.224','2024-05-18 15:57:20','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/5.html','U','title=What is uploadfly, is_stickey=N, status=P, cat_id=1, k_body=<p>What is uploadfly<br></p>\n, featured_video_link=, k_tag=adding the product,customizing the product,product customize,import product, slug_id=what-is-uploadfly, last_update_time=2...','l002','','159.192.42.224','2024-05-18 15:57:40','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/3','U','title=Uninstallation, is_stickey=N, status=P, cat_id=2, k_body=<p><b>How To Uninstall or remove the app?</b><p>To remove the app it\'s very simple, please go to the app and select uploadlfy and see a pinned icon on the right top side and click it<b...','l002','','159.192.42.224','2024-05-19 02:34:18','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/5','U','title=What is uploadfly, is_stickey=N, status=P, cat_id=1, k_body=<p>Uploadfly is an app that is available for Shopify only at the moment, we will expand this in the future to other platforms such as Etsy, Big Commerce, etc.<br>Uploadfly is the na...','l002','','159.192.42.224','2024-05-19 02:39:27','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/2','U','title=Install Uploadfly, is_stickey=N, status=P, cat_id=2, k_body=<p>To install the app it\'s very easy just follow this step<ol><li>Get the app from the Shopify app store here :</li><li>Click install and follow the step</li><li>Select your plan su...','l002','','159.192.42.224','2024-05-19 02:42:52','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/4','U','title=Upgrade or Downgrade Plan / Package, is_stickey=N, status=P, cat_id=2, k_body=<p>How To Upgrade or Downgrade Plan / Package:<ol><li>Please go to the dashboard and select your plan upgrade or downgrade</li><li>Select the plan you want to choo...','l002','','159.192.42.224','2024-05-19 02:45:11','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/7','D','id=7','l003','Knowledge_confirm','159.192.42.224','2024-05-19 03:45:58','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/8','D','id=8','l003','Knowledge_confirm','159.192.42.224','2024-05-19 03:46:01','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/10','D','id=10','l003','Knowledge_confirm','159.192.42.224','2024-05-19 07:06:36','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/11','D','id=11','l003','Knowledge_confirm','159.192.42.224','2024-05-19 07:06:39','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/12','D','id=12','l003','Knowledge_confirm','159.192.42.224','2024-05-19 07:06:43','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/13','D','id=13','l003','Knowledge_confirm','159.192.42.224','2024-05-19 07:06:52','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/14','D','id=14','l003','Knowledge_confirm','159.192.42.224','2024-05-19 07:06:56','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/knowledge-delete/15','D','id=15','l003','Knowledge_confirm','159.192.42.224','2024-05-19 07:07:00','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/4','U','title=Upgrade or Downgrade Plan / Package, is_stickey=N, status=P, cat_id=2, k_body=<p>How To Upgrade or Downgrade Plan / Package:<ol><li>Select the dashboard menu and select your plan upgrade or downgrade</li><li>Select the plan you want to choos...','l002','','159.192.42.224','2024-05-19 09:52:03','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/system-msg-confirm/system-msg-dismiss/63','D','id=63','l003','System_msg_confirm','159.192.43.50','2024-05-19 10:42:28','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 10:50:04','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:07:25','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:07:59','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:08:35','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:18:25','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:23:08','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:34:38','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:44:36','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:54:25','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/9','U','title=General Setting, is_stickey=N, status=P, cat_id=4, k_body=<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img...','l002','','159.192.43.50','2024-05-19 11:57:11','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/17','U','title=Product, parent_category=16, show_on=B, parent_category_path=16','l002','','159.192.43.50','2024-05-19 11:58:34','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/6','U','title=How to enable the upload button, is_stickey=N, status=P, cat_id=2, k_body=<p>How to enable the upload button<br></p>\n, featured_video_link=, k_tag=Uncustomize the product,remove the product, slug_id=how-to-enable-the-upload-button, last_upda...','l002','','159.192.43.50','2024-05-19 11:59:37','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/6','U','title=How to enable the upload button, is_stickey=N, status=P, cat_id=17, k_body=<p>How to enable the upload button<br></p>\n, featured_video_link=, k_tag=Uncustomize the product,remove the product, slug_id=how-to-enable-the-upload-button, last_upd...','l002','','159.192.43.50','2024-05-19 11:59:42','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/6','U','title=How to enable the upload button, is_stickey=N, status=P, cat_id=17, k_body=<p>To enable the upload button for your product there are 3 ways for that: Import from Shopify products, bulk import, and inside the Uploadfly app.<br><br><b>1. Impor...','l002','','159.192.43.50','2024-05-19 12:12:49','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=Files Order, is_stickey=N, status=U, cat_id=7, k_body=<p>Files Order<br></p>\n, featured_video_link=, k_tag=Files,Order Files,Order,Uploadfly, entry_time=2024-05-19 19:21:03, last_update_time=2024-05-19 19:21:03, slug_id=files-or...','l001','','159.192.43.50','2024-05-19 12:21:03','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/17','U','title=Files Order, is_stickey=N, status=U, cat_id=7, k_body=<p>To get the file uploaded by the customer you can go to the Uploadfly app and select files menus. in the files area, we can see all files that have been uploaded by the customer, you ca...','l002','','159.192.43.50','2024-05-19 13:09:15','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge-confirm/status-change/17','U','status=P','l002','Knowledge','159.192.43.50','2024-05-19 13:09:42','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=How to get support, is_stickey=N, status=P, cat_id=0, k_body=<p>If you have any questions or need help you can go to the support menu inside the app, you can find knowledgebase, articles, news, or FAQ, including the ticket.<p><b...','l001','','159.192.43.50','2024-05-19 13:12:49','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/edit/18','U','title=How to get support, is_stickey=N, status=P, cat_id=1, k_body=<p>If you have any questions or need help you can go to the support menu inside the app, you can find knowledgebase, articles, news, or FAQ, including the ticket.<p><br></p><p><br>...','l002','','159.192.43.50','2024-05-19 13:13:10','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/knowledge/add','A','added_by=AA, title=Dashboard Overview, is_stickey=N, status=P, cat_id=1, k_body=<p>In the dashboard area, you can get information about whether the app is already installed or not, including all details about how many products were added to Upload...','l001','','159.192.43.50','2024-05-19 15:03:55','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/category/edit/6','U','parent_category=16, show_on=K, parent_category_path=16','l002','','159.192.43.50','2024-05-19 15:04:27','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/menu-confirm/status-change/2','U','status=A','l002','Menu','159.192.43.50','2024-05-19 15:12:25','','',''),('admin','AD','R1','https://help.imakecustom.com/admin/menu-confirm/status-change/2','U','status=I','l002','Menu','159.192.43.50','2024-05-19 15:12:44','','','');
/*!40000 ALTER TABLE `app_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_notificaiton`
--

DROP TABLE IF EXISTS `app_notificaiton`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_notificaiton` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `msg` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `entry_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'radio(N=Notification,M=message)',
  `entry_link` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `n_counter` decimal(2,0) unsigned NOT NULL DEFAULT '1',
  `is_popup_link` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `view_time` timestamp NULL DEFAULT NULL,
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_type` char(2) NOT NULL DEFAULT '',
  `extra_param` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'radio(A=Active,V=Viewed,D=Deleted)',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_type` (`user_id`) USING BTREE,
  KEY `user_id_item` (`user_id`,`item_type`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED COMMENT='notification';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_notificaiton`
--

LOCK TABLES `app_notificaiton` WRITE;
/*!40000 ALTER TABLE `app_notificaiton` DISABLE KEYS */;
INSERT INTO `app_notificaiton` VALUES (1,'AA','New ticket received','A new ticket has been received, please assign','N','https://help.imakecustom.com/admin/ticket/details/1.html',1,'N','2024-01-18 03:19:52','2024-01-18 15:19:50','TO','eyJpZCI6MSwidGl0bGUiOiJ0ZXN0In0=','V'),(2,'AA','New ticket assigned by you','You have assigned self to a ticket','N','https://help.imakecustom.com/admin/ticket/details/1.html',1,'N',NULL,'2024-01-18 15:20:00','TA','eyJpZCI6IjEiLCJ0aXRsZSI6InRlc3QifQ==','V'),(3,'AA','New ticket assigned by you','You have assigned self to a ticket','N','https://help.imakecustom.com/admin/ticket/details/2',1,'N',NULL,'2024-03-19 10:45:49','TA','eyJpZCI6IjIiLCJ0aXRsZSI6Ikp1ZHVsIn0=','V'),(4,'AA','You replied a ticket','You have been replied a ticket','N','https://help.imakecustom.com/admin/ticket/details/2',1,'N','2024-03-19 22:57:41','2024-03-19 10:46:26','TA','eyJpZCI6IjIiLCJ0aXRsZSI6Ikp1ZHVsIn0=','V'),(5,'AA','New ticket assigned by you','You have assigned self to a ticket','N','https://help.imakecustom.com/admin/ticket/details/3',1,'N',NULL,'2024-03-20 10:27:12','TA','eyJpZCI6IjMiLCJ0aXRsZSI6IlRlc3RpbmcifQ==','V'),(6,'AA','You replied a ticket','You have been replied a ticket','N','https://help.imakecustom.com/admin/ticket/details/3',1,'N','2024-03-19 22:28:46','2024-03-20 10:27:36','TA','eyJpZCI6IjMiLCJ0aXRsZSI6IlRlc3RpbmcifQ==','V'),(7,'AA','New ticket assigned by you','You have assigned self to a ticket','N','https://help.imakecustom.com/admin/ticket/details/7',1,'N',NULL,'2024-03-21 09:59:20','TA','eyJpZCI6IjciLCJ0aXRsZSI6IlRlc3RpbmcifQ==','V'),(8,'AA','You replied a ticket','You have been replied a ticket','N','https://help.imakecustom.com/admin/ticket/details/7.html',1,'N','2024-03-21 00:44:34','2024-03-21 10:25:33','TA','eyJpZCI6IjciLCJ0aXRsZSI6IlRlc3RpbmcifQ==','V'),(9,'AA','You replied a ticket','You have been replied a ticket','N','https://help.imakecustom.com/admin/ticket/details/7.html',1,'N','2024-03-21 19:53:19','2024-03-22 04:56:02','TA','eyJpZCI6IjciLCJ0aXRsZSI6IlRlc3RpbmcifQ==','V'),(10,'AA','New ticket assigned by you','You have assigned self to a ticket','N','https://help.imakecustom.com/admin/ticket/details/13.html',1,'N',NULL,'2024-03-22 05:05:43','TA','eyJpZCI6IjEzIiwidGl0bGUiOiJNZW5naXNvbGFzaSBFa3Nla3VzaSBNaWdyYXNpIn0=','V'),(11,'AA','You replied a ticket','You have been replied a ticket','N','https://help.imakecustom.com/admin/ticket/details/13.html',1,'N','2024-03-21 21:09:36','2024-03-22 05:05:55','TA','eyJpZCI6IjEzIiwidGl0bGUiOiJNZW5naXNvbGFzaSBFa3Nla3VzaSBNaWdyYXNpIn0=','V'),(12,'AA','You replied a ticket','You have been replied a ticket','N','https://help.imakecustom.com/admin/ticket/details/1.html',1,'N',NULL,'2024-03-22 05:27:25','TA','eyJpZCI6IjEiLCJ0aXRsZSI6InRlc3QifQ==','A'),(13,'AA','New ticket assigned by you','You have assigned self to a ticket','N','https://help.imakecustom.com/admin/ticket/details/16.html',1,'N',NULL,'2024-03-22 19:18:53','TA','eyJpZCI6IjE2IiwidGl0bGUiOiJUZXN0aW5nIHRpa2V0IGJhcnUifQ==','V'),(14,'AA','You replied a ticket','You have been replied a ticket','N','https://help.imakecustom.com/admin/ticket/details/16.html',1,'N',NULL,'2024-03-22 19:19:06','TA','eyJpZCI6IjE2IiwidGl0bGUiOiJUZXN0aW5nIHRpa2V0IGJhcnUifQ==','A');
/*!40000 ALTER TABLE `app_notificaiton` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_setting`
--

DROP TABLE IF EXISTS `app_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_setting` (
  `s_key` char(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `s_title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `s_val` char(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `s_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'T' COMMENT 'drop(T=Textbox,A=Textarea,B=Boolean,D=Dropdown,R=Radio,Z=Timezone)',
  `s_option` char(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `s_auto_load` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  PRIMARY KEY (`s_key`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_setting`
--

LOCK TABLES `app_setting` WRITE;
/*!40000 ALTER TABLE `app_setting` DISABLE KEYS */;
INSERT INTO `app_setting` VALUES ('app_email','App Email','admin@imakecustom.com','T','','Y'),('app_title','App Title','I Make Custom App','T','','Y'),('app_theme','APP Theme','bss2020','T','','Y'),('app_hmp','APP Homepage','1','T','','Y'),('isonly_logo','Show Only Logo','Y','B','','Y'),('app_date_format','Date Format','d-M-Y','T','','Y'),('app_time_format','Time Format','H:i','T','','Y'),('regi_enable','Registration','Y','T','','Y'),('app_captcha','Captcha Settings','D','R','eyJEIjoiRGVmYXVsdCIsIkciOiJHb29nbGUgUmUtY2FwdGNoYSJ9','Y'),('ap_dc_length','Captcha length','6','T','','Y'),('ap_dc_str_type','Captcha String Type','AN','T','','Y'),('app_gc_secret','Re-Captcha Secret Key','','T','','Y'),('app_gc_site_key','Re-Captcha Site Key','','T','','Y'),('app_main_color','Main Color','#0B8EC2','T','','Y'),('app_text_color','Link and Heading Color','','T','','Y'),('app_welcome_bg','Welcome Background','','T','','Y'),('app_welcome_text','Welcome Text','#ffffff','T','','Y'),('app_header_bg','Header background Color','','T','','Y'),('app_c_auto','Auto Others Color','Y','B','eyJZIjoiWWVzIiwiTiI6Ik5vIn0=','Y'),('app_navbar_bg','Menu Background','','T','','Y'),('app_nav_acive_text','Menu Active Text color','','T','','Y'),('footer_bg_color','Footer Background','','T','','Y'),('footer_text_color','Footer Text Color','','T','','Y'),('app_header_isg','Header Gradient','N','B','eyJZIjoiWWVzIiwiTiI6Ik5vIn0=','Y'),('is_cptcha_client_login','Client Captcha Login','N','B','eyJZIjoiWWVzIiwiTiI6Ik5vIn0=','Y'),('is_cptcha_guest_ticket','On Guest Ticket','Y','B','eyJZIjoiWWVzIiwiTiI6Ik5vIn0=','Y'),('is_cptcha_client_regi','Client Registration Captcha','Y','B','eyJZIjoiWWVzIiwiTiI6Ik5vIn0=','Y'),('is_cptcha_admin_login','Admin Login Captcha','N','B','eyJZIjoiWWVzIiwiTiI6Ik5vIn0=','Y'),('max_file_upload_size','Max Upload File Size','10','N','','Y'),('allowed_file_type','Allowed file type','jpg|png|zip','T','','Y'),('allow_profile_upload','Profile Upload','Y','B','','Y'),('allow_ticket_file_upload','Allow Ticket File Upload','Y','B','','Y'),('is_guest_ticket','Enable Guest Ticket','N','B','','Y'),('is_public_ticket','Enable Guest Ticket','N','B','','Y'),('ticket_htmleditor','Ticket HTML Editor','Y','B','','Y'),('app_html_editor','Choose HTML Editor','S','R','eyJTIjoiU3VtbWVybm90ZSIsIkMiOiJDSyBFZGl0b3IifQ==','Y'),('app_layout','Application Layout','B','R','eyJGIjoiRnVsbCBXaWR0aCIsIkIiOiJCb3ggU2l6ZSJ9','Y'),('is_check_online','User Online Status Check','Y','B','','Y'),('ticket_email_str','Ticket Email String','##Ticket ID:','T','','Y'),('ticket_email_rp_str','Ticket Email Reply Line','##- Please type your reply above this line -##','T','','Y'),('any_can_assign','Is any staff can reply','Y','B','','Y'),('is_imap_ticket','Email to Ticket','Y','B','','Y'),('imap_host','IMAP Host','','T','','Y'),('imap_port','IMAP Host','','T','','Y'),('imap_is_secure','IMAP Secure Protocol','','B','','Y'),('imap_user','IMAP User','','T','','Y'),('imap_pass','IMAP Password','','T','','Y'),('out_email_name','From Name','Support Imakecustom','T','','Y'),('out_email_from','From Email','support@imakecustomf.com','T','','Y'),('out_email_protocol','Email Protocol','sendmail','R','eyJzZW5kbWFpbCI6IlNlbmRtYWlsIiwic210cCI6IlNNVFAifQ==','Y'),('mailpath','Sendmail Path','/usr/sbin/sendmail','T','','Y'),('smtp_host','SMTP Host','','T','','Y'),('smtp_port','SMTP Host','','T','','Y'),('smtp_is_secure','SMTP Secure Protocol','','B','','Y'),('smtp_user','SMTP User','','T','','Y'),('smtp_pass','SMTP Password','','T','','Y'),('app_dos_atk','Enable DoS Attack','Y','B','','Y'),('app_dos_req','DoS Attack Request Count','30','T','','Y'),('app_dos_sec','DoS Attack Request Seconds','10','T','','Y'),('app_dos_action','DoS Attack Action','C','T','','Y'),('app_user_scq','Enable Admin User Security','Y','B','','Y'),('appuser_sec_tried','Loing Miss Attempts','5','N','','Y'),('appuser_sec_min','Miss Attempts Interval','30','N','','Y'),('fb_enable','Feedback Enable','Y','B','','Y'),('fb_e_msg','Feedback message email title','How do you rate the support you received?','T','','Y'),('fb_n_msg','Nagative Feedback Message','We are very sorry, we will try our best in future','B','','Y'),('fb_p_msg','Positive Feedback Message','We are very happy that we were able to satisfy you.','B','','Y'),('msg_last_tried','_mt','1531905713','T','','Y'),('is_app_forcessl','Enable Force SSL','Y','B','','Y'),('licstr','-','239c5129-c749-41dd-9fb1-75d00475d68d','T','','Y'),('_uprcs','UProcs','4.1.2','T','','Y'),('dlogin_enable','Default Login','N','T','','Y'),('dgustpopup','Disable Guest Popup','Y','T','','Y'),('is_alpguest_ticket','Show All Priroty','N','T','','Y'),('app_lang','App Language','en_US','Y','','Y'),('app_clang','App Site Language','','Y','','Y'),('app_noti_email','Notification Email','','T','','Y'),('is_netkt_open','On Ticket Open','Y','B','','Y'),('is_netktu_reply','On ticket User Notification','Y','B','','Y'),('is_netkta_reply','On Admin User Reply Notification','Y','B','','Y'),('is_aetkt_open','Email On ticket User Assign','Y','B','','Y'),('is_astkt_open','icket User Assign Notification','Y','B','','Y'),('is_nstkt_open','On Ticket Open','N','B','','Y'),('is_nstktu_reply','On ticket User Notification','Y','B','','Y'),('is_nstkta_reply','On Admin User Reply Notification','Y','B','','Y'),('is_nstone','Is Admin Notification Tone','Y','B','','Y'),('enable_aclose','Enable Ticket Auto close','N','B','','Y'),('aclosing_rule','Auto closing rule','N','N','','Y'),('aclosing_msg','Auto closing message','As the ticket has been inactive for a long time, we are considering the issue to be resolved. Our support system is closing this ticket automatically.','T','','Y'),('up_last_tried','_tt','1716111286','T','','Y'),('is_state_kn','Disable Knowledge Stat In Homepage','N','B','','Y'),('is_first_run','','N','T','','N'),('imap_secure_type','IMAP Protocol Type','ssl','T','','Y'),('out_reply_to_email','Reply To Email','','T','','Y'),('app_ctry_block','Is Country block Status','N','B','','Y'),('app_ctry_brule','Country Block Rule','B','T','','Y'),('app_ctry_list','Country List','','T','','Y'),('is_kn_like_dlike','knowledge Like Dislike','Y','T','','Y'),('is_kn_l_upd','last update show','N','T','','Y'),('is_kn_iconc','Counter Icon','N','T','','Y'),('smtp_secure_type','Counter Icon','ssl','R','eyJzc2wiOiJTU0wiLCJ0bHMiOiJUTFMifQ==','Y'),('is_rtl_client','RTL Client','N','B','','Y'),('is_rtl_admin','RTL Admin','N','B','','Y'),('app_spam_emails','SPAM Email','','T','','Y'),('is_del_spam_email','DeleteSPAMEmail','N','B','','Y'),('is_dis_googlefont','Disable Google Font','N','B','','Y'),('is_hide_knowledge','Hide Knowledge Menu','N','B','','Y'),('is_priority_hide','Priority Hide','N','B','','Y'),('is_priority_ad_hide','Admin Priority Hide','N','B','','Y'),('is_user_can_reopen','Is User Can ReOpen','Y','B','','Y'),('per_user_max_ticket','Per max user ticket','0','T','','Y'),('reopen_time','reopen time','0','T','','Y'),('is_show_app_ttl','Show Title','Y','B','','Y'),('is_powered_by','Enable Powered By','N','B','','Y'),('use_direct_file','Direct file','N','B','','Y'),('_css_cpl_req','CSS Compile Require','N','B','','Y'),('up_css_tried','_tt','1716111286','T','','Y'),('admin_color','','cyan','T','','N'),('sysupp_user','-','AA','T','','N'),('sysupp_time','-','1705549418','T','','N'),('admin_color_type','','D','T','','N'),('_rate_status','','a','T','','N');
/*!40000 ALTER TABLE `app_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_setting_api`
--

DROP TABLE IF EXISTS `app_setting_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_setting_api` (
  `s_api_name` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `s_key` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `s_title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `s_val` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `s_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'T' COMMENT 'drop(T=Textbox,A=Textarea,B=Boolean,D=Dropdown,R=Radio,Z=Timezone)',
  `s_option` char(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `s_auto_load` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y' COMMENT 'bool(Y=Yes,N=No)',
  UNIQUE KEY `api_name` (`s_api_name`,`s_key`) USING BTREE,
  KEY `s_api_name` (`s_api_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_setting_api`
--

LOCK TABLES `app_setting_api` WRITE;
/*!40000 ALTER TABLE `app_setting_api` DISABLE KEYS */;
INSERT INTO `app_setting_api` VALUES ('Envato','api_type','API Type','P','R','eyJQIjoiUGVyc29uYWwiLCJPIjoiT2xkIFRva2VuIn0=','N'),('Envato','api_username','Envato Username','','T','','N'),('Envato','api_token','API Token','','T','','N'),('paypal','is_enable_paypal','is_enable_paypal','N','B','','Y'),('paypal','is_test_mode','is_test_mode','Y','B','','Y'),('paypal','client_id','client_id','','T','','Y'),('paypal','secret','secret','','T','','Y'),('social','is_enable_g_login','is_enable_g_login','N','B','','Y'),('social','login_g_client_id','login_g_client_id','','T','','Y'),('social','login_g_secret','login_g_secret','','T','','Y'),('social','is_enable_f_login','is_enable_f_login','N','B','','Y'),('social','is_enable_t_login','is_enable_t_login','N','B','','Y'),('social','is_enable_l_login','is_enable_l_login','N','B','','Y'),('social','is_enable_gh_login','is_enable_gh_login','N','B','','Y'),('social','is_enable_y_login','is_enable_y_login','N','B','','Y'),('system','footer_text','footer_text','<p>Contact us anytime we will help you</p>','T','','Y'),('system','welcome_msg','welcome_msg','<h2 id=\"page-header-title\" align=\"center\">I Make Custom App Support<h3 id=\"page-header-tagline\" align=\"center\">Its a support application for our product. We normally response within 24 hours<br></h3></h2>','T','','Y'),('gdpr','gdpr_is_active','gdpr_is_active','N','T','','Y'),('gdpr','gdpr_ua_active','gdpr_ua_active','Y','T','','Y'),('gdpr','gdpr_cnb','gdpr_cnb','Y','T','','Y'),('gdpr','gdpr_cnb_bg','gdpr_cnb_bg','#38c0b1','T','','Y'),('gdpr','gdpr_cnb_tc','gdpr_cnb_tc','#000000','T','','Y'),('gdpr','gdpr_cookie_msg','gdpr_cookie_msg','<p>This website uses \r\ncookies. Continued use of this website indicates you have read and \r\nunderstood our Privacy & Cookies policy and agree to its terms. <span style=\"color: rgb(206, 0, 0);\"><span style=\"font-weight: bold;\">{{PolicyLink}}</span></span><br></p>','T','','Y'),('gdpr','gdpr_is_popsh','gdpr_is_popsh','Y','T','','Y'),('gdpr','gpbr_bg_op','gpbr_bg_op','95','T','','Y'),('gdpr','gdpr_bar_ani','gdpr_bar_ani','slideInUp','T','','Y'),('gdpr','gdpr_bar_cani','gdpr_bar_cani','slideOutDown','T','','Y'),('gdpr','gpbr_dis_event','gpbr_dis_event','S','T','','Y'),('gdpr','gdpr_ud_active','gdpr_ud_active','Y','T','','Y'),('paypal','_settings','paypal-settings','YTo2OntzOjE0OiJpc191cF9wcmV2aW91cyI7czoxOiJZIjtzOjk6ImNsaWVudF9pZCI7czowOiIiO3M6Njoic2VjcmV0IjtzOjA6IiI7czoxNjoiaXNfZW5hYmxlX3BheXBhbCI7czoxOiJOIjtzOjEyOiJpc190ZXN0X21vZGUiO3M6MToiWSI7czoxMDoicF9jdXJyZW5jeSI7Tjt9','T','','N'),('webchat','wc_is_active','wc_is_active','Y','T','','Y'),('webchat','app_chat_type','app_chat_type','B','T','','Y'),('webchat','app_chat_title','app_chat_title','Help Desk I Make Custom App','T','','Y'),('webchat','app_chat_tagline','app_chat_tagline','Help Desk I Make Custom App','T','','Y'),('webchat','chat_header_color','chat_header_color','#000000','T','','Y'),('webchat','chat_main_color','chat_main_color','#0b8ec2','T','','Y'),('webchat','chat_bg_pattern','chat_bg_pattern','chat-bg5.png','T','','Y'),('webchat','chat_btn_icon','chat_btn_icon','ap ap-chat2','T','','Y'),('webchat','max_chat_per_user','max_chat_per_user','5','T','','Y'),('webchat','open_text','open_text','Welcome to our chat system.if you want to start chat with our agent then please click the button bellow.','T','','Y'),('webchat','offline_text','offline_text','We are offline now.','T','','Y'),('Envato','ischeck_expiry_date','Check Support Expiry','N','O','','N'),('EliteLicenser','api_server','Server End Point','','T','','N'),('EliteLicenser','api_key','API Key','','T','','N'),('EliteLicenser','ischeck_expiry_date','Check Support Expiry','N','O','','N'),('MailChimp','is_mailchimp','Enable MailChimp','N','O','','N'),('MailChimp','api_key','API Key','','T','','N'),('Yq3Ylg==','ZJmuoPdKm5s=','','VK3Ylu5vbdiKOSrC+vsCZMTrhlppchZGuiDy9tzloob6kDZQsjwu1iKcn4k=','T','','Y'),('Yq3Ylg==','TdDXYe6CiY5+Oi2U','','U9OygfiFnM2RFh2K9A30KsQebHJmTPxQuQ39rt3VqY76aEIvrzkN1xOFgVKhAnCdFv01OqUcIV5JDn4+AcXix9roPNxDNxCygsmqs9JfiPCjJlgrtliPchuoffcK9g7lUeeM4Hvfrt502KzHh1ZA/jJOdF8T7EKKNdsU13PO4s1j0LoXMma+5XFlhrSvhT1OMhAMLUzbEAGUgmX0PKu6PNWkxddpSZo0NasqAUEvqnN5qfvQrj7mXyKvxjd9QgKNZFXbz6zpHhNBK2vXmpLj4NbeaIEareJWRKcRdlV10psL1hMjQ24gjL57rgoCVq2GAWuqnt4ySpEup/4xhxTe9GSl0PDqQKodGilkp+Fox3qXp5BvNLc48QZO1v9axXJWJU3ASDK1svzTcfq/SjS8MhbAVJGKYZ3oZ7s7uDYygjFiZDodpSQG4fmvxhUHzWKGArCwwX0E6ExpGZxgczvAH5M52+6mKPHq8dqgJWbbiqOUImrJigWDbJf+GkWBLAQQTpw4EeLOuObexojElkMuWq3dTkvCd56XXi8QNQTcRuPX2dRwXfA5iZ0/ANjpw0J50zoaq0YiIDmvaYyoxtfV/OM8MnGrXW1OCpcqSvP4lsoz6ih3XQd5zLTN4a5GYQ1fw7Fcvit+CJURwvYaHP9SvRZCxoay8RVdv34sYNGu/DlZpC+hN3GQIf/HZq+9vOqDoegyRDzLGy/KqYl3i2UghVPk7mHspETZeTUKaZIYXti6/8Qg5uw6N7JxAcF3q1GR1adD+zTPXGltIoaxKwTOHuPoAqrFW83MlEXmvLuEfjnjOYApdS2WV6dDzEH1Rab1BSu9p7cbe5yzinAqhZucEVU72BAda5nw/DxZnCoVwrPWyMb6nYqWXUJNov9CXwCRmn6CFBeFIOZT7LnvAlROAoFqjG7zofQFL0HyQgWUauAhfrpMfPu7uA4qujxdaXrBlT4cyh9cRPN/yXDZGYpi4qXhlt06yEJRRG+2tj6gQMsjRlzL/uIq7y7lFme5y20DY57MqylMuNT18jSEFFNed3lAGq84yOjK6a+c/IEoHs0WF9YAsX55bO2ZhgL6ICuMUSZ9cByofCeWxbjQ/j+nO2UetJTzkJqhZF0Hvl5GPOYyXHQ4w5s89OcK2Cz9WsZj4omyTN2pvYFdPskWWVVoRdYnkifd++R2uvf2XMaY1jxardxiY26cj4YWQQf2DxZNuugCbGOFHiyxtCOw2+aVknaNIUavFiIsD5qkZZzE98Eh1jIsodMmokb7oHZ5xd1/2gw4Py1xILyK2xWYv15iJJOmXD23Jn5mjOa4OPvRH3Vk+V21b8cy9XT8fvqU2EnTOl5lY54FQpcltxBbes3Uy1rQHCIdZLbKdPmGlbl1SQ2p6hALTLQHSKKAgPRMzgYB','T','','Y'),('system','nvcl','','<p>Click the link to view change log<br /><a href=\"https://appsbd.com/bsschangelog\" target=\"_blank\" rel=\"noopener\">https://appsbd.com/bsschangelog</a></p>','T','','N'),('webchat','agent_welcome_text','agent_welcome_text','Welcome to our chat session.\r\nI am {{agent_name}},  how may I help you sir?','T','','Y'),('webchat','queue_text','queue_text','You are currently number {{your_position}} in the queue.\r\nThank you for your patience!','T','','Y'),('webchat','chat_closing_text','chat_closing_text','The chat has been closed by our agent ({{agent_name}})\r\nThanks','T','','Y'),('webchat','chat_closing_int','chat_closing_int','30','T','','Y'),('webchat','chat_allowed_domains','chat_allowed_domains','dev.imakecustom.com,rumahcyber.com,imakecustom.com,uploadfly.imakecustom.com','T','','Y'),('system','email_footer','email_footer','<p>This email is a service from I Make Custom App.</p>','T','','Y'),('SYSTEM','update_json','ut','{\"IsStoppedUpdate\":null,\"version\":null,\"slug\":\"ABSS\",\"plugin_name\":\"Support System\",\"name\":\"Support System\",\"new_version\":\"4.1.4\",\"requires\":\"2.0\",\"tested\":\"8\",\"downloaded\":1,\"last_updated\":\"2.0\",\"url\":\"https:\\/\\/appsbd.com\\/products\\/best-support-system\\/\",\"download_link\":\"https:\\/\\/appsbd.com\\/etc\\/product-update\\/support-system\\/4.x\\/update-v4.1.4.zip?v=4.1.4\",\"sections\":{\"description\":\"<p>Click the link to view change log<br \\/><a href=\\\"https:\\/\\/appsbd.com\\/bsschangelog\\\" target=\\\"_blank\\\" rel=\\\"noopener\\\">https:\\/\\/appsbd.com\\/bsschangelog<\\/a><\\/p>\",\"changelog\":\"<p>Click the link to view change log<br \\/><a href=\\\"https:\\/\\/appsbd.com\\/bsschangelog\\\" target=\\\"_blank\\\" rel=\\\"noopener\\\">https:\\/\\/appsbd.com\\/bsschangelog<\\/a><\\/p>\"},\"icons\":{\"high\":\"\"},\"banners\":{\"high\":\"\"},\"banners_rtl\":[],\"update_denied_type\":\"\",\"is_downloadable\":true,\"renew_link\":\"\"}','T','','Y'),('system','site_copyw','site_copyw','<p>&copy; Copyright imakecustom 2024</p>','T','','Y'),('bss2020','_src_hr_img','','N','T','','N'),('bss2020','_src_rdy_msg','','','T','','N'),('bss2020','_src_placeholder','','','T','','N'),('bss2020','_src_home_subtitle','','','T','','N'),('bss2020','_src_home_title','','Do you need help','T','','N'),('bss2020','_src_text_color','','','T','','N'),('bss2020','_src_style','','bss2020_head_20','T','','N'),('bss2020','_fbox_is_hide','','Y','T','','N'),('bss2020','_fbox_icon_1','','empty','T','','N'),('bss2020','_fbox_icon_2','','empty','T','','N'),('bss2020','_fbox_icon_3','','empty','T','','N'),('bss2020','_fbox_title_1','','','T','','N'),('bss2020','_fbox_title_2','','','T','','N'),('bss2020','_fbox_title_3','','','T','','N'),('bss2020','_fbox_dtls_1','','','T','','N'),('bss2020','_fbox_dtls_2','','','T','','N'),('bss2020','_fbox_dtls_3','','','T','','N'),('bss2020','_fbox_link_1','','','T','','N'),('bss2020','_fbox_link_2','','','T','','N'),('bss2020','_fbox_link_3','','','T','','N');
/*!40000 ALTER TABLE `app_setting_api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_user`
--

DROP TABLE IF EXISTS `app_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_user` (
  `pvid` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `user` char(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `title` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `email` char(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `pass` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `role` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'FK(role_list,role_id,title)',
  `panel` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'A=Active, I=Inactive',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contact_number` char(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `img_url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tzone` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'drop(Asia/Dhaka=Dhaka Bangladesh)',
  `gender` char(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'radio(M=Male,F=Female)',
  `address` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `region` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `city` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `zip` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `country` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'drop(US=United States)',
  `dob` char(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0000-00-00' COMMENT 'date of birth',
  `is_enable_chat` char(1) NOT NULL DEFAULT 'Y' COMMENT 'bool(Y=Yes,N=No)',
  PRIMARY KEY (`user`) USING BTREE,
  UNIQUE KEY `user` (`pvid`,`user`) USING BTREE,
  UNIQUE KEY `email` (`pvid`,`email`) USING BTREE,
  KEY `user_status` (`pvid`,`user`,`status`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_user`
--

LOCK TABLES `app_user` WRITE;
/*!40000 ALTER TABLE `app_user` DISABLE KEYS */;
INSERT INTO `app_user` VALUES ('AA','AA','admin','I Make Custom','support@imakecustom.com','3b36ef94fc4280de06b6e06f20c7eff9','R1','A','A','2024-01-18 04:43:03','','','Asia/Bangkok','M','test','','Dhaka','1217','BD','0000-00-00','Y');
/*!40000 ALTER TABLE `app_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `canned_msg`
--

DROP TABLE IF EXISTS `canned_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `canned_msg` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `title` char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `canned_msg` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'textarea',
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `canned_type` char(1) NOT NULL DEFAULT 'T' COMMENT 'drop(T=Ticket,C=Chat)',
  `status` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `canned_msg`
--

LOCK TABLES `canned_msg` WRITE;
/*!40000 ALTER TABLE `canned_msg` DISABLE KEYS */;
INSERT INTO `canned_msg` VALUES (3,'','To Confirm Access has not been received','<p xss=removed>Hi {{{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>Thank you for your confirm.</p><p xss=removed>Unfortunately, we have not received the email containing the access.</p><p xss=removed><br xss=removed></p><p xss=removed>Please kindly resend the staff access using the following email address instead:</p><p xss=removed><a href=\"http://support@imakecustom.com\" target=\"_blank\">support@imakecustom.com</a></p><p xss=removed><br xss=removed></p><p xss=removed>Looking forward to hearing from you.</p><p xss=removed><br xss=removed></p></p>','2017-12-21 11:56:05','AA','T','A'),(4,'','Access received confirm - installation on process','<span xss=removed>Hi <font color=\"#333333\" face=\"system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen-Sans, Ubuntu, Cantarell, Helvetica Neue, Arial, sans-serif\">{{ticket_user}},</font><br xss=removed><br xss=removed><span xss=removed>Thank you for the access!</span><br xss=removed><span xss=removed>We have started on the app installation.</span><br xss=removed><span xss=removed>I will be right back to you for the update soon.</span></span>','2017-12-21 12:14:18','AA','T','A'),(5,'','Special shopify account creation done','<p xss=\"removed\">Hello,<p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">We have created your special Shopify store:</p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">{{site_url}}</p><p xss=\"removed\"><br></p><p xss=\"removed\">please check your email, you will need to click a verification email link.</p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">The password is:</p><p xss=\"removed\"><span xss=\"removed\"><a href=\"https://leashly-site.myshopify.com/admin/\" target=\"_blank\" rel=\"noreferrer\" xss=\"removed\">{</a>{ change_this_password you created }}</span></p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">Please let me know which app plan you want to subscribe to, we will give you 3 months month-free trial.</p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">Thanks</p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\"><br xss=\"removed\"></p><p></p></p>','2024-03-11 21:25:34','AA','T','A'),(8,'','Installation Completed','<p xss=removed>Hi {{ticket_user}},<br xss=removed><br xss=removed>We have completed the installation.<br xss=removed>You can now start adding your products to IMCST App.<p xss=removed>Please check following the tutorial on how to add your products to IMCST App:</p><p xss=removed><br>Url to add the product</p><p xss=removed><br xss=removed>Should you have any questions?<br xss=removed>Please feel free to contact us.</p><p xss=removed><br xss=removed></p></p>','2024-03-11 21:30:38','AA','T','A'),(6,'','Response installation request','<p xss=removed>Hi {{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>We would be happy to finish the installation for you!</p><p xss=removed><br xss=removed>Please send the staff access login or create a new one for this email address:</p><p xss=removed><a href=\"http://support@imakecustom.com\" target=\"_blank\">support@imakecustom.com</a><br xss=removed><br xss=removed></p><p xss=removed>Please see the reference of how to create staff login :</p><p xss=removed><a href=\"https://help.shopify.com/en/manual/your-account/staff-accounts/create-staff-accounts#create-a-new-staff-account\" target=\"_blank\" rel=\"noreferrer\" xss=removed>https://help.shopify.com/en/manual/your-account/staff-accounts/create-staff-accounts#create-a-new-staff-account</a><br xss=removed></p><p xss=removed><br xss=removed></p><p xss=removed>Please find the following permission that I need to complete the installation:</p><p xss=removed><span xss=removed>1. Products<br xss=removed></span></p><p xss=removed><span xss=removed>2. Apps<br xss=removed></span></p><p xss=removed><span xss=removed>3. Themes</span>​</p><p xss=removed><br xss=removed></p><p xss=removed>Please let us know once you have completed the above and we will get started right away.<br xss=removed>We will make sure the product customization app works properly on your website.<br xss=removed><br xss=removed></p><p xss=removed>We look forward to working with you!</p><p xss=removed><br xss=removed></p></p>','2024-03-11 21:26:56','AA','T','A'),(7,'','Issue fixed notice','<p xss=removed>Hi {{reply_user}},<p xss=removed><br xss=removed></p><p xss=removed>We have fixed the issue you reported.</p><p xss=removed>Please let me know if you need anything else.</p><p xss=removed><br xss=removed></p><p xss=removed>Thank you for using IMCST App.</p><p xss=removed><br xss=removed></p></p>','2024-03-11 21:28:10','AA','T','A'),(9,'','Collaborator request','<p>Hi {{ticket_user}},<p xss=removed>Thank you for reaching out.</p><p xss=removed><br xss=removed></p><p xss=removed>We would love to check this for you. To help you further, we sent a collaborator request. Kindly let us know once approved, so we can check what\'s causing this issue.<br xss=removed><br xss=removed></p><p xss=removed>Awaiting your response.<br xss=removed><br xss=removed></p><p xss=removed>Regards,</p><p xss=removed><br xss=removed></p></p>','2024-03-11 21:31:31','AA','T','A'),(10,'','Asking for a Review','<p xss=removed>HI {{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>Thank you for using our app, Customify.<br xss=removed></p><p xss=removed><br xss=removed></p><p xss=removed>Your honest feedback helps encourage us and make improvements to our app. Please take a minute and leave a review on the Shopify App Store:<br xss=removed><br xss=removed><a href=\"https://apps.shopify.com/customify#modal-show=WriteReviewModal\" target=\"_blank\" rel=\"noreferrer\" xss=removed>https://apps.shopify.com/imcst#modal-show=WriteReviewModal</a><br xss=removed></p><p xss=removed><br xss=removed></p><p xss=removed>Thank you in advance and please reach out to us anytime, we are happy to help in any way we can.<br xss=removed></p><p xss=removed><br xss=removed></p><p xss=removed>Best Regards,<br xss=removed></p><p xss=removed><br></p></p>','2024-03-11 21:32:28','AA','T','A'),(11,'','Answer Uninstallation Request','<p xss=removed>Hi {{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>We are sorry to see you are going to uninstall the app.</p><p xss=removed>Please kindly check our tutorial to see how to uninstall the app from your website.</p><p xss=removed><a href=\"https://kb.customify.co/hc/en-us/articles/360000327882-How-to-uninstall-Product-Customizer\" target=\"_blank\" rel=\"noreferrer\" xss=removed></a>#</p><p xss=removed><br xss=removed></p><p xss=removed>Should you need further assistance,</p><p xss=removed>Please feel free to contact us.</p><p xss=removed><br xss=removed></p><p xss=removed>Thank You!</p><p xss=removed><br xss=removed></p></p>','2024-03-11 21:33:20','AA','T','A'),(12,'','Answer Thank You','<p xss=removed>Hi {{ticket_user}},<p xss=removed><br xss=removed>It\'s a pleasure to help you :).</p><p xss=removed>Please feel free to contact us if you need anything else.</p><p xss=removed><br xss=removed></p><p xss=removed>Have a nice day!</p><p xss=removed><br xss=removed></p><p xss=removed><br xss=removed></p></p>','2024-03-11 21:47:03','AA','T','A'),(13,'','Access received confirm - installation on process','<p><span xss=removed>Hi </span>{{ticket_user}},<br xss=removed><br xss=removed><span xss=removed>Thank you for the access!</span><br xss=removed><span xss=removed>We have started on the app installation.</span><br xss=removed><span xss=removed>I will be right back to you for the update soon.</span><br></p>','2024-03-11 21:47:52','AA','T','A'),(14,'','Closing Ticket After No Response from the User After 5 Days (the issue is resolved or question answered)','<p xss=removed>Hi {{ticket_user}},<p xss=removed><br xss=removed></p><p xss=removed>It seems we haven\'t heard back from you recently, so we\'re planning to close this ticket to keep things tidy. But remember, our door is always open! Feel free to reach out anytime if you have more questions or need assistance.</p><p xss=removed><br xss=removed></p><p xss=removed>Best Regards,</p></p>','2024-03-11 21:48:28','AA','T','A');
/*!40000 ALTER TABLE `canned_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `parent_category` int unsigned NOT NULL DEFAULT '0' COMMENT 'FK(category,id,title)',
  `parent_category_path` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `show_on` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'B' COMMENT 'radio(B=Both,K=Only Knowledge,T=Only on Ticket)',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'General',16,'16','B','A'),(2,'Installation',16,'16','B','A'),(3,'Bug',16,'16','T','A'),(4,'Setting',16,'16','K','A'),(16,'Uploadfly',0,'0','B','A'),(6,'How To',16,'16','K','A'),(7,'Order',16,'16','K','A'),(8,'Subscription',16,'16','K','A'),(17,'Product',16,'16','B','A'),(18,'IMCST',0,'0','B','A'),(19,'Amazonify',0,'0','B','A'),(20,'FAQ',16,'16','B','I'),(13,'App Enhancement',16,'16','T','A'),(14,'Req Template',18,'18','T','A'),(15,'FAQ',16,'16','K','I'),(21,'News',16,'16','B','A');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `changelog`
--

DROP TABLE IF EXISTS `changelog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `changelog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status` enum('fixed','edit') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `changelog`
--

LOCK TABLES `changelog` WRITE;
/*!40000 ALTER TABLE `changelog` DISABLE KEYS */;
INSERT INTO `changelog` VALUES (5,'Launching App','2024-02-21','fixed'),(6,'Bug Add Text','2024-04-29','fixed');
/*!40000 ALTER TABLE `changelog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `open_user_id` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_remote_typing` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `is_user_typing` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `end_by_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'radio(A=Staff,C=Client)',
  `end_by` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `current_admin_user` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bw_name` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'Browser Idea',
  `country` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `last_msg_time` timestamp NULL DEFAULT NULL,
  `last_msg_by` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'radio(A=Admin,U=User)',
  `last_page_list` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `ip` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `header_msg` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'radio(N=Not Started, S=Started,E=End)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` VALUES (1,'','N','N','','','AA','2024-04-29 15:29:51','2024-04-29 16:01:41','Chrome 124.0','TH','2024-05-15 02:02:57','A','','159.192.43.241','The chat has been closed by our agent (I Make Custom)\r\nThanks','C'),(2,'','N','N','','','','2024-04-29 16:01:53','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.241','<i class=\"apc-msg-icon fa fa-spin fa-spinner pull-left\"></i>You are currently number 1 in the queue.\r\nThank you for your patience!','Q'),(3,'','N','N','','','','2024-04-29 16:08:20','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.241','We are offline now.','O'),(4,'','N','N','','','','2024-04-29 16:09:24','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.241','We are offline now.','O'),(5,'','N','N','','','','2024-04-29 16:14:09','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.241','We are offline now.','O'),(6,'','N','N','','','','2024-04-30 12:21:59','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.241','We are offline now.','O'),(7,'','N','','','','','2024-05-01 14:52:06','0000-00-00 00:00:00','Chrome 124.0','TH','2024-05-01 14:52:10','U','','159.192.43.216','We are offline now.','O'),(8,'','N','N','','','','2024-05-01 14:52:12','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.216','We are offline now.','O'),(9,'','N','N','','','','2024-05-01 15:20:26','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.216','We are offline now.','O'),(10,'','N','N','','','','2024-05-02 14:58:43','0000-00-00 00:00:00','Chrome 124.0','ID',NULL,'','','61.5.53.41','We are offline now.','O'),(11,'','N','','','','','2024-05-02 14:58:43','0000-00-00 00:00:00','Chrome 124.0','ID','2024-05-02 14:58:49','U','','61.5.53.41','We are offline now.','O'),(12,'','N','N','','','','2024-05-02 14:58:51','0000-00-00 00:00:00','Chrome 124.0','ID',NULL,'','','61.5.53.41','We are offline now.','O'),(13,'','N','','','','','2024-05-02 14:59:05','0000-00-00 00:00:00','Chrome 124.0','ID','2024-05-02 14:59:10','U','','61.5.53.41','We are offline now.','O'),(14,'','N','N','','','','2024-05-08 17:41:21','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.42.43','We are offline now.','O'),(15,'','N','N','','','','2024-05-14 23:32:47','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.239','We are offline now.','O'),(16,'','N','N','','','','2024-05-14 23:39:03','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.239','<i class=\"apc-msg-icon fa fa-spin fa-spinner pull-left\"></i>You are currently number 3 in the queue.\r\nThank you for your patience!','Q'),(17,'','N','N','','','','2024-05-14 23:40:20','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.239','We are offline now.','O'),(18,'','N','Y','','','','2024-05-15 01:55:02','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.239','We are offline now.','O'),(19,'','N','N','','','','2024-05-15 01:55:10','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.43.239','We are offline now.','O'),(20,'','N','N','','','AA','2024-05-15 02:02:07','0000-00-00 00:00:00','Chrome 124.0','TH','2024-05-15 02:03:21','A','','159.192.43.239','','A'),(21,'','N','N','','','','2024-05-16 15:45:14','0000-00-00 00:00:00','Chrome 124.0','TH',NULL,'','','159.192.42.132','We are offline now.','O');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_denied`
--

DROP TABLE IF EXISTS `chat_denied`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_denied` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chat_id` int NOT NULL DEFAULT '0',
  `app_user_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `chat_id` (`chat_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_denied`
--

LOCK TABLES `chat_denied` WRITE;
/*!40000 ALTER TABLE `chat_denied` DISABLE KEYS */;
INSERT INTO `chat_denied` VALUES (1,2,'AA','2024-04-29 15:02:09'),(2,3,'AA','2024-04-29 15:08:30'),(3,4,'AA','2024-04-29 15:09:53'),(4,5,'AA','2024-04-29 15:14:34'),(5,17,'AA','2024-05-14 22:40:35'),(6,16,'AA','2024-05-14 22:40:35'),(7,15,'AA','2024-05-14 22:40:36');
/*!40000 ALTER TABLE `chat_denied` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_msg`
--

DROP TABLE IF EXISTS `chat_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_msg` (
  `chat_id` int unsigned NOT NULL,
  `msg_id` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `temp_id` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `reply_user_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'radio(S=System,U=User,A=Admin,N=No User)',
  `reply_user_id` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `msg` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `form_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `chat_id_msg_id` (`chat_id`,`msg_id`) USING BTREE,
  KEY `chat_id` (`chat_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_msg`
--

LOCK TABLES `chat_msg` WRITE;
/*!40000 ALTER TABLE `chat_msg` DISABLE KEYS */;
INSERT INTO `chat_msg` VALUES (1,'AAAA','AA1714401006','A','AA','Welcome to our chat session.\r\nI am I Make Custom,  how may I help you sir?','','2024-04-29 15:30:06'),(1,'AAAB','AA1714401019046','A','AA','hello how i can help you','','2024-04-29 15:30:19'),(1,'AAAC','ac50987b_1714401027686','C','','test','','2024-04-29 15:30:27'),(7,'AAAA','ac50987b_1714571530001','C','','kklk','','2024-05-01 14:52:10'),(11,'AAAA','ac50987b_1714658329274','C','','test','','2024-05-02 14:58:49'),(13,'AAAA','ac50987b_1714658350191','C','','hi','','2024-05-02 14:59:10'),(20,'AAAA','AA1715734933','A','AA','Welcome to our chat session.\r\nI am I Make Custom,  how may I help you sir?','','2024-05-15 02:02:13'),(20,'AAAB','AA1715734957733','A','AA','helo','','2024-05-15 02:02:37'),(1,'AAAD','AA1715734977283','A','AA','Template                                            https://help.imakecustom.com/knowledge/details/15.html','','2024-05-15 02:02:57'),(20,'AAAC','ac50987b_1715734994231','C','','test','','2024-05-15 02:03:14'),(20,'AAAD','AA1715735001686','A','AA','ya ada apa','','2024-05-15 02:03:21');
/*!40000 ALTER TABLE `chat_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_field`
--

DROP TABLE IF EXISTS `custom_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_field` (
  `id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cat_id` char(255) NOT NULL DEFAULT '0',
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `help_text` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'T' COMMENT 'radio(T=Textbox,N=Numeric,D=Dropdown,A=Date,R=Radio)',
  `opt_json_base` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_required` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `default_value` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `is_api_based` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `is_private` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `is_on_grid` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `api_name` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'like: EnvatoAPI',
  `on_submit_api_check` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y' COMMENT 'bool(Y=Yes,N=No)',
  `fld_order` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_field`
--

LOCK TABLES `custom_field` WRITE;
/*!40000 ALTER TABLE `custom_field` DISABLE KEYS */;
INSERT INTO `custom_field` VALUES ('AA','R','Shop ID','','T','','Y','','N','N','Y','','N','A',1),('AB','R','Store Url','','U','','Y','','N','N','N','','N','A',2),('AC','R','Plan','','T','','Y','','N','N','Y','','N','A',3),('AD','R','Country','','T','','Y','','N','N','Y','','N','A',4),('AE','R','Phone','','T','','N','','N','N','Y','','N','A',5),('AF','R','AE','','T','','N','','N','N','N','','N','I',6),('AG','R','AD','','T','','N','','N','N','N','','N','I',7),('AH','R','AB','','T','','N','','N','N','N','','N','I',8),('AI','R','AC','','T','','N','','N','N','N','','N','I',9),('AJ','R','AA','','T','','N','','N','N','N','','N','I',10),('AK','0','App Name','App name that used by the customer','D','Uploadfly,Amazonify,IMCST','Y','','N','N','Y','','N','A',11);
/*!40000 ALTER TABLE `custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_page`
--

DROP TABLE IF EXISTS `custom_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_page` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slag_title` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `title` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `page_body` longtext CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'textarea',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active, I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='page';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_page`
--

LOCK TABLES `custom_page` WRITE;
/*!40000 ALTER TABLE `custom_page` DISABLE KEYS */;
INSERT INTO `custom_page` VALUES (1,'privacy-terms-condition-conditions','Privacy & terms condition conditions','Update your privacy policy in Page menu ( Admin Settings> Pages> select Page Edit)','2018-09-19 16:27:34','A');
/*!40000 ALTER TABLE `custom_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debug_log`
--

DROP TABLE IF EXISTS `debug_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `debug_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entry_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' COMMENT 'radio(E=Error,S=Success)',
  `log_type` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'GEN' COMMENT 'drop(GEN=General,EML=Email,OTH=Others)',
  `title` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_data` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' COMMENT 'drop(F=Failed,S=Success)',
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `entry_type` (`entry_type`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debug_log`
--

LOCK TABLES `debug_log` WRITE;
/*!40000 ALTER TABLE `debug_log` DISABLE KEYS */;
INSERT INTO `debug_log` VALUES (1,'E','EML','Email Send failed, subject:Welcome to [I Make Custom App]','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 18 Jan 2024 22:19:50 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;Support&gt;\r\nReturn-Path: &lt;Support&gt;\r\nTo: emhaku@gmail.com\r\nSubject: =?UTF-8?Q?Welcome=20to=20[I=20Make=20Custom=20App]?=\r\nReply-To: &lt;Support&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: Support\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65a933864b417&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-01-18 14:19:50'),(2,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket received# T83DCEFB7-001-LJG','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 18 Jan 2024 22:19:50 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;Support&gt;\r\nReturn-Path: &lt;Support&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20received#=20T83DCEF?= =?UTF-8?Q?B7-001-LJG?=\r\nReply-To: &lt;Support&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: Support\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65a9338654176&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-01-18 14:19:50'),(3,'E','EML','Email Send failed, subject:[I Make Custom App] Guest Ticket opend # T83DCEFB7-001-LJG','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 18 Jan 2024 22:19:50 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;Support&gt;\r\nReturn-Path: &lt;Support&gt;\r\nTo: emhaku@gmail.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Guest=20Ticket=20opend=20#=20T83DC?= =?UTF-8?Q?EFB7-001-LJG?=\r\nReply-To: &lt;Support&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: Support\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65a9338655258&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-01-18 14:19:50'),(4,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket has been assigned to you # T83DCEFB7-001-LJG','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 18 Jan 2024 22:20:00 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;Support&gt;\r\nReturn-Path: &lt;Support&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20has=20been=20assign?= =?UTF-8?Q?ed=20to=20you=20#=20T83DCEFB7-001-LJG?=\r\nReply-To: &lt;Support&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: Support\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65a9339019c38&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-01-18 14:20:00'),(5,'E','EML','Email Send failed, subject:[I Make Custom App] Ticket Replied # T83DCEFB7-001-LJG','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 18 Jan 2024 22:20:52 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;Support&gt;\r\nReturn-Path: &lt;Support&gt;\r\nTo: emhaku@gmail.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Ticket=20Replied=20#=20T83DCEFB7-0?= =?UTF-8?Q?01-LJG?=\r\nReply-To: &lt;Support&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: Support\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65a933c4f069f&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-01-18 14:20:52'),(6,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket reply received # T83DCEFB7-001-LJG','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 18 Jan 2024 22:20:52 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;Support&gt;\r\nReturn-Path: &lt;Support&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20reply=20received=20?= =?UTF-8?Q?#=20T83DCEFB7-001-LJG?=\r\nReply-To: &lt;Support&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: Support\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65a933c4f2740&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-01-18 14:20:52'),(7,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket has been assigned to you # 1c72368506cdf20d59','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Tue, 19 Mar 2024 17:45:49 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20has=20been=20assign?= =?UTF-8?Q?ed=20to=20you=20#=201c72368506cdf20d59?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65f95ecd6add4@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-19 09:45:49'),(8,'E','EML','Email Send failed, subject:[I Make Custom App] Ticket Replied # 1c72368506cdf20d59','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Tue, 19 Mar 2024 17:46:26 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Ticket=20Replied=20#=201c72368506c?= =?UTF-8?Q?df20d59?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65f95ef28ed26@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-19 09:46:26'),(9,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket reply received # 1c72368506cdf20d59','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Tue, 19 Mar 2024 17:46:26 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20reply=20received=20?= =?UTF-8?Q?#=201c72368506cdf20d59?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65f95ef29d731@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-19 09:46:26'),(10,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket has been assigned to you # 7e2680075c2b699fe0','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Wed, 20 Mar 2024 17:27:12 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20has=20been=20assign?= =?UTF-8?Q?ed=20to=20you=20#=207e2680075c2b699fe0?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65faabf0cbd1b@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-20 09:27:12'),(11,'E','EML','Email Send failed, subject:[I Make Custom App] Ticket Replied # 7e2680075c2b699fe0','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Wed, 20 Mar 2024 17:27:36 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Ticket=20Replied=20#=207e2680075c2?= =?UTF-8?Q?b699fe0?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65faac086cd39@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-20 09:27:36'),(12,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket reply received # 7e2680075c2b699fe0','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Wed, 20 Mar 2024 17:27:36 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20reply=20received=20?= =?UTF-8?Q?#=207e2680075c2b699fe0?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65faac087128a@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-20 09:27:36'),(13,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'7e2680075c2b699fe0\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'sdasdasdas\', \'assdasdasdasdsad asdasdas\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'7e2680075c2b699fe07af0d8e240c06b\')\nFilename: models/ApiModelTicket.php\nLine Number: 54','F','2024-03-20 09:44:06'),(14,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'7e2680075c2b699fe0\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Testsadada\', \'asdsadas asdsadasd asdasdas\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'7e2680075c2b699fe07af0d8e240c06b\')\nFilename: models/ApiModelTicket.php\nLine Number: 54','F','2024-03-20 09:44:49'),(15,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'7e2680075c2b699fe0\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'Testsadada\', \'asdsadas asdsadasd asdasdas\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'7e2680075c2b699fe07af0d8e240c06b\')\nFilename: models/ApiModelTicket.php\nLine Number: 54','F','2024-03-20 09:48:23'),(16,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'7e2680075c2b699fe0\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'sdfdsf\', \'sadasdasd\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'7e2680075c2b699fe07af0d8e240c06b\')\nFilename: models/ApiModelTicket.php\nLine Number: 54','F','2024-03-20 09:50:18'),(17,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'7e2680075c2b699fe0\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'AAASasa\', \'asdsad\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'7e2680075c2b699fe07af0d8e240c06b\')\nFilename: models/ApiModelTicket.php\nLine Number: 54','F','2024-03-20 09:51:11'),(18,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'7e2680075c2b699fe0\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'AAASasa\', \'asdsad\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'7e2680075c2b699fe07af0d8e240c06b\')\nFilename: models/ApiModelTicket.php\nLine Number: 54','F','2024-03-20 09:51:37'),(19,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'7e2680075c2b699fe0\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'AAASasa\', \'asdsad asdasdas\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'7e2680075c2b699fe07af0d8e240c06b\')\nFilename: models/ApiModelTicket.php\nLine Number: 54','F','2024-03-20 09:51:41'),(20,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'Testing 2\', \'Please check this ticket 2!\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 08:59:00'),(21,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket has been assigned to you # 20d5e32aade2ed55a2','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 21 Mar 2024 16:59:20 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20has=20been=20assign?= =?UTF-8?Q?ed=20to=20you=20#=2020d5e32aade2ed55a2?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fbf6e845ce7@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-21 08:59:20'),(22,'E','EML','Email Send failed, subject:[I Make Custom App] Ticket Replied # 20d5e32aade2ed55a2','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 21 Mar 2024 17:25:33 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: quickstart-044cdd31@email.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Ticket=20Replied=20#=2020d5e32aade?= =?UTF-8?Q?2ed55a2?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fbfd0d25a62@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-21 09:25:33'),(23,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket reply received # 20d5e32aade2ed55a2','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Thu, 21 Mar 2024 17:25:33 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20reply=20received=20?= =?UTF-8?Q?#=2020d5e32aade2ed55a2?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fbfd0d29004@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-21 09:25:33'),(24,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Tes tiket lagi\', \'Tes tiket lagi\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 09:28:11'),(25,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1064\nYou have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'.`id`)\n LIMIT 10\' at line 3\nSELECT `app_user`.`title` as `assign_on_name`, `ticket`.*\nFROM `ticket`\nJOIN `app_user` USING (`app_user`.`id`)\n LIMIT 10\nFilename: models/ApiModelTicket.php\nLine Number: 22','F','2024-03-21 09:38:29'),(26,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Tes tiket lagi\', \'Tes tiket lagi\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 09:58:46'),(27,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 10:03:01'),(28,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 10:04:07'),(29,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'1\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 10:05:11'),(30,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 10:05:32'),(31,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 10:05:36'),(32,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'1\', \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 10:05:44'),(33,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'20d5e32aade2ed55a2\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', 1, \'20d5e32aade2ed55a2f8339d8dee38a8\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-21 10:05:48'),(34,'E','EML','Email Send failed, subject:[I Make Custom App] Ticket Replied # 20d5e32aade2ed55a2','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Fri, 22 Mar 2024 11:56:02 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: quickstart-044cdd31@email.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Ticket=20Replied=20#=2020d5e32aade?= =?UTF-8?Q?2ed55a2?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fd0152e34e5@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 03:56:02'),(35,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket reply received # 20d5e32aade2ed55a2','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Fri, 22 Mar 2024 11:56:02 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20reply=20received=20?= =?UTF-8?Q?#=2020d5e32aade2ed55a2?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fd0152e74e4@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 03:56:02'),(36,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'bf1d6b7919888d5d13\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'Mengisolasi Eksekusi Migrasi\', \'Jika Anda menerapkan aplikasi di beberapa server dan menjalankan migrasi sebagai bagian dari proses penerapan, Anda mungkin tidak ingin dua server mencoba memigrasikan database secara bersamaan. Untuk menghindari hal ini, Anda dapat menggunakan isolatedopsi saat menjalankan migrateperintah.\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'bf1d6b7919888d5d13c694303b5b0517\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:00:35'),(37,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'bf1d6b7919888d5d13\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'14\', \'Mengisolasi Eksekusi Migrasi\', \'Jika Anda menerapkan aplikasi di beberapa server dan menjalankan migrasi sebagai bagian dari proses penerapan, Anda mungkin tidak ingin dua server mencoba memigrasikan database secara bersamaan. Untuk menghindari hal ini, Anda dapat menggunakan isolatedopsi saat menjalankan migrateperintah.\', \'G\', \'N\', \'L\', \'quickstart-044cdd31\', \'quickstart-044cdd31\', \'bf1d6b7919888d5d13c694303b5b0517\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:01:25'),(38,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'14\', \'Mengisolasi Eksekusi Migrasi 2\', \'Jika Anda menerapkan aplikasi di beberapa server dan menjalankan migrasi sebagai bagian dari proses penerapan, Anda mungkin tidak ingin dua server mencoba memigrasikan database secara bersamaan. Untuk menghindari hal ini, Anda dapat menggunakan isolatedopsi saat menjalankan migrateperintah.\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:03:45'),(39,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Mengisolasi Eksekusi Migrasi 2\', \'Jika Anda menerapkan aplikasi di beberapa server dan menjalankan migrasi sebagai bagian dari proses penerapan, Anda mungkin tidak ingin dua server mencoba memigrasikan database secara bersamaan. Untuk menghindari hal ini, Anda dapat menggunakan isolatedopsi saat menjalankan migrateperintah.\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:04:20'),(40,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:04:30'),(41,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:04:33'),(42,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:05:10'),(43,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'14\', \'sdasd\', \'sadasd\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:05:31'),(44,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket has been assigned to you # 8067e52dea296c8500','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Fri, 22 Mar 2024 12:05:43 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20has=20been=20assign?= =?UTF-8?Q?ed=20to=20you=20#=208067e52dea296c8500?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fd03977ab02@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 04:05:43'),(45,'E','EML','Email Send failed, subject:[I Make Custom App] Ticket Replied # 8067e52dea296c8500','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Fri, 22 Mar 2024 12:05:55 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: quickstart-044cdd31@email.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Ticket=20Replied=20#=208067e52dea2?= =?UTF-8?Q?96c8500?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fd03a3afce3@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 04:05:55'),(46,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket reply received # 8067e52dea296c8500','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Fri, 22 Mar 2024 12:05:55 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20reply=20received=20?= =?UTF-8?Q?#=208067e52dea296c8500?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fd03a3b2a5e@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 04:05:55'),(47,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'14\', \'asdsa\', \'asdsadsa\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:06:15'),(48,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:06:28'),(49,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:06:35'),(50,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'3\', \'asd\', \'asdasdas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 04:26:33'),(51,'E','EML','Email Send failed, subject:[I Make Custom App]  Ticket has been closed # T83DCEFB7-001-LJG','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Fri, 22 Mar 2024 12:27:25 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: emhaku@gmail.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20=20Ticket=20has=20been=20closed=20?= =?UTF-8?Q?#=20T83DCEFB7-001-LJG?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fd08ad6f817@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 04:27:25'),(52,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket reply received # T83DCEFB7-001-LJG','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Fri, 22 Mar 2024 12:27:25 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20reply=20received=20?= =?UTF-8?Q?#=20T83DCEFB7-001-LJG?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fd08ad76a67@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 04:27:25'),(53,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test\', \'adada asdasdafdfgs\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 09:32:58'),(54,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 09:33:47'),(55,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'8067e52dea296c8500\' for key \'ticket.ticket_track_id\'\nINSERT INTO `ticket` (`cat_id`, `title`, `ticket_body`, `user_type`, `status`, `priroty`, `ticket_user`, `shop_id`, `ticket_track_id`) VALUES (\'13\', \'Test lagi\', \'Test lagi asdsadas\', \'G\', \'N\', \'L\', \'5\', \'quickstart-044cdd31\', \'8067e52dea296c85002a89c199dcbf35\')\nFilename: models/ApiModelTicket.php\nLine Number: 64','F','2024-03-22 09:34:23'),(56,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket has been assigned to you # 7969daa5c8fa76a50f','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Sat, 23 Mar 2024 02:18:53 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20has=20been=20assign?= =?UTF-8?Q?ed=20to=20you=20#=207969daa5c8fa76a50f?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fdcb8d7c1cc@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 18:18:53'),(57,'E','EML','Email Send failed, subject:[I Make Custom App] Ticket Replied # 7969daa5c8fa76a50f','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Sat, 23 Mar 2024 02:19:06 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: quickstart-044cdd31@email.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Ticket=20Replied=20#=207969daa5c8f?= =?UTF-8?Q?a76a50f?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fdcb9a35a32@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 18:19:06'),(58,'E','EML','Email Send failed, subject:[I Make Custom App] New ticket reply received # 7969daa5c8fa76a50f','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Sat, 23 Mar 2024 02:19:06 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: support@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20New=20ticket=20reply=20received=20?= =?UTF-8?Q?#=207969daa5c8fa76a50f?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fdcb9a3b3ed@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 18:19:06'),(59,'E','EML','Email Send failed, subject:[I Make Custom App]  Ticket Re-Opened # 8067e52dea296c8500','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Sat, 23 Mar 2024 02:21:46 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: quickstart-044cdd31@email.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20=20Ticket=20Re-Opened=20#=208067e5?= =?UTF-8?Q?2dea296c8500?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;65fdcc3a4bcc2@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-22 18:21:46'),(60,'E','EML','Email Send failed, subject:[I Make Custom App] Password Recovery','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Wed, 27 Mar 2024 15:46:20 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: kemzoft85@gmail.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Password=20Recovery?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;6603cecce51d7@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-27 07:46:20'),(61,'E','EML','Email Send failed, subject:[I Make Custom App] Password Recovery','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Wed, 27 Mar 2024 15:47:22 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: kemzoft85@gmail.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Password=20Recovery?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;6603cf0aa24eb@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-03-27 07:47:22'),(62,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'johan26gmail.com\' for key \'site_user.email\'\nINSERT INTO `site_user` (`first_name`, `last_name`, `username`, `email`, `status`, `phone`, `region`, `store_url`, `plan`, `date_subscribe`, `shop_id`) VALUES (\'johan 5\', \'johan\', \'johan 57\', \'johan26gmail.com\', \'A\', \'123\', \'Indonesia\', \'https://tes.com\', \'monthly\', \'1-8-2023\', \'jhony_shop\')\nFilename: models/User_model.php\nLine Number: 50','F','2024-03-30 13:31:01'),(63,'E','EML','Email Send failed, subject:[I Make Custom App] Ticket Replied # 259ce6ec3275d85b83','Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.&lt;br /&gt;&lt;pre&gt;Date: Wed, 3 Apr 2024 04:47:44 +0800\r\nFrom: &quot;Support Imakecustom&quot; &lt;support@imakecustomf.com&gt;\r\nReturn-Path: &lt;support@imakecustomf.com&gt;\r\nTo: imakecustom-dev_1711529167@imakecustom.com\r\nSubject: =?UTF-8?Q?[I=20Make=20Custom=20App]=20Ticket=20Replied=20#=20259ce6ec327?= =?UTF-8?Q?5d85b83?=\r\nReply-To: &lt;support@imakecustomf.com&gt;\r\nUser-Agent: CodeIgniter\r\nX-Sender: support@imakecustomf.com\r\nX-Mailer: CodeIgniter\r\nX-Priority: 3 (Normal)\r\nMessage-ID: &lt;660c6ef08c30c@imakecustomf.com&gt;\r\nMime-Version: 1.0\r\n\n&lt;/pre&gt;','F','2024-04-02 20:47:44'),(64,'E','GEN','Database Query Error','A Database Error Occurred\n\nError Number: 1062\nDuplicate entry \'91.215.85.43\' for key \'iplist.PRIMARY\'\nINSERT INTO `iplist` (`ip`, `start_count_time`, `req_counter`, `entry_type`, `status`, `added_on`, `country_code`) VALUES (\'91.215.85.43\', \'2024-04-09 12:18:04\', \'1\', \'A\', \'N\', \'2024-04-09 12:18:04\', \'RU\')\nFilename: core/main/CORE_Model.php\nLine Number: 937','F','2024-04-09 04:18:04');
/*!40000 ALTER TABLE `debug_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_templates` (
  `k_word` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `grp` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  `subject` char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`k_word`) USING BTREE,
  UNIQUE KEY `email_keyword` (`k_word`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_templates`
--

LOCK TABLES `email_templates` WRITE;
/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` VALUES ('AFP','Admin','Admin or Staff  Forget Password','A','[{{site_name}}] Password Recovery','<p>Hi {{user_name}},<br><br>We receive a request to reset your password. To do so, <br>Please click the button below:<br><br>{{recover_button}}<br><br>If you did not request a password reset, please ignore this email<br>or reply to let us know. <br><br>Thanks<br>{{site_name}}<br><br><br></p>'),('AWE','Admin','Admin or Staff  Welcome message-New User','A','Welcome to [{{site_name}}]','<h1>Welcome to {{site_name}},</h1><h3>Dear {{full_name}},</h3><p>Your Login information are given bellow:</p><p>{{login_info}}<br></p><p>Thanks<br>{{site_name}}<br></p><p><br></p>'),('APC','Admin','Admin Password Changed Successfully','A','[{{site_name}}] Password Changed Successfully','<p>Hi {{user_name}},<br><br>Your password has been change successfully<br><br>If you did not change the password,&nbsp; please contact with {{site_name}} admin as early as possible<br><br>Thanks<br>{{site_name}}<br><br><br></p>'),('UOT','Ticket','Ticket Open By User','A','[{{site_name}}]Ticket opend # {{ticket_track_id}}','<p>Dear {{ticket_user}},<br><br>Thanks for creating a ticket on {{site_name}}<br>Your ticket track id :<b> {{ticket_track_id}}</b><b><br></b>Your ticket link :<b> {{ticket_link}}</b><b><br></b><b><br></b></p><p><b>Ticket Title: </b>{{ticket_title}}<br><b>Ticket Body :<br></b>----------------Start---------------------<b><br></b></p><p>{{ticket_body}}<br>----------------End-----------------------</p><p>We\'ll be in touch shortly.<br></p><p><br>Thanks,<br>{{site_name}}<br></p><p><br></p>'),('GOT','Ticket','Ticket Open By Guest','A','[{{site_name}}] Guest Ticket opend # {{ticket_track_id}}','<p>Dear [Guest User]<br><br>Thanks for creating a ticket on {{site_name}}<br>Your ticket track id :<b> {{ticket_track_id}}<br></b>Your ticket link :<b> {{ticket_link}}</b><b><br></b></p><p><b>Ticket Title: </b>{{ticket_title}}<br><b>Ticket Body :<br></b></p><p>{{ticket_body}}</p><p><br></p>We\'ll be in touch shortly.<p><br>Thanks,</p><p>{{site_name}}<br></p>'),('UWE','Site','Site User Welcome Email after opening account','A','Welcome to [{{site_name}}]','<h1>Welcome to {{site_name}},</h1><h3>Dear {{full_name}},</h3><p>Your Login information are given bellow:</p><p>{{login_info}}<br></p><p>Thanks<br>{{site_name}}<br></p><p><br></p>'),('TRO','Ticket','Ticket Reopen','A','[{{site_name}}]  Ticket Re-Opened # {{ticket_track_id}}','<p>Dear&nbsp; {{ticket_user}},<br>Your ticket has been re-opened.<br></p><p>Ticket details are given bellow:<br><b>Ticket Title: </b>{{ticket_title}}<br><b>Your ticket track id :</b> {{ticket_track_id}}<b><br>Your ticket link :</b> {{ticket_link}}</p><p><b><br></b>Thanks,<br>{{site_name}}<br></p>'),('UFP','Site','Site User Forget Password','A','[{{site_name}}] Password Recovery','Hi {{user_name}},<br><br>We receive a request to reset your password. To do so, <br>Please click the button below:<br><br>{{recover_button}}<br><br>If you did not request a password reset, please ignore this email<br>or reply to let us know. <br><br>Thanks<br>{{site_name}}<br><br>'),('UPC','Site','Site User Password Changed Successfully','A','[{{site_name}}] Password Changed Successfully','<p>Hi {{user_name}},<br><br>Your password has been change successfully<br><br>If you did not change the password , please contact with {{site_name}} admin as early as possible<br><br>Thanks<br>{{site_name}}<br><br><br></p>'),('TRR','Ticket','Ticket Reply Received','A','[{{site_name}}] Ticket Replied # {{ticket_track_id}}','<p>Dear {{ticket_user}},<br>Our staff ( {{ticket_replied_user}} ) has replied on your ticket. Ticket details are given bellow:</p><p><b>Ticket Title: </b>{{ticket_title}}<br><b>Your ticket track id :</b> {{ticket_track_id}}<b><br>Your ticket link :</b> {{ticket_link}}<b><br></b></p><p>Thanks,<br>{{site_name}}</p>'),('TCL','Ticket','Ticket Closed or Feedback email','A','[{{site_name}}]  Ticket has been closed # {{ticket_track_id}}','<p>Dear {{ticket_user}},<br>Your ticket has been closed .Ticket details are given bellow:</p><p><b>Ticket Title: </b>{{ticket_title}}<br><b>Your ticket track id :</b> {{ticket_track_id}}<b><br>Your ticket link :</b> {{ticket_link}}</p><p>{{ticket_feedback_button}}<b><br></b></p><p><b><br></b>Thanks,<br>{{site_name}}<br></p>'),('ANT','Admin','Admin new ticket notification email','A','[{{site_name}}] New ticket received# {{ticket_track_id}}','<h5>Dear Admin,</h5><h5>New ticket has been received. Ticket information is given below:<br></h5><p>Ticket User&nbsp; :&nbsp; <b>{{ticket_user}}</b><br>Ticket track id&nbsp; :<b>&nbsp; {{ticket_track_id}}</b><b><br></b>Ticket title :<b>&nbsp; </b><b>{{ticket_title}}<br></b>Ticket link&nbsp; :<b>&nbsp; {{ticket_link}}</b><b><br></b></p><p><b><br></b></p><p><span style=\"font-size: 14px;\">Thanks</span><b><br></b><span style=\"font-size: 14px;\">{{site_name}}</span><b><br></b></p><p><br></p>'),('ANR','Admin','Admin new ticket reply notification email','A','[{{site_name}}] New ticket reply received # {{ticket_track_id}}','<h5>Dear Admin,</h5><h5>New ticket reply has been received. Ticket information is given below:<br></h5><p>Ticket User&nbsp; :&nbsp; <b>{{ticket_user}}<br></b>Replied User&nbsp; :&nbsp; <b>{{ticket_replied_user}}</b><br>Ticket track id&nbsp; :<b>&nbsp; {{ticket_track_id}}</b><b><br></b>Ticket title :<b>&nbsp; </b><b>{{ticket_title}}<br></b>Ticket link&nbsp; :<b>&nbsp; {{ticket_link}}<br><br>Reply Text<br>-------------------------------------<br></b>{{replied_text}}<br>---------------------------------------<br><span style=\"font-size: 14px;\">Thanks</span><b><br></b><span style=\"font-size: 14px;\">{{site_name}}</span><b><br></b></p><p><br></p>'),('TAC','Ticket','Ticket Auto Closing message','A','[{{site_name}}]  Ticket has been auto closed # {{ticket_track_id}}','<p>Dear {{ticket_user}},</p><p>{{ticket_closing_msg}}<br></p><p>If the issue is still exist then you can reopen the ticket anytime. </p><p>The ticket information are  given bellow:<br></p><p><b>Ticket Title: </b>{{ticket_title}}<br><b>Your ticket track id :</b> {{ticket_track_id}}<b><br>Your ticket link :</b> {{ticket_link}}</p><p><b><br></b></p><p><b><br></b>Thanks,<br>{{site_name}}<br></p>'),('AAT','Admin','Admin Ticket Assign notification email','A','[{{site_name}}] New ticket has been assigned to you # {{ticket_track_id}}','<h5>Dear {{ticket_assigned_user}},</h5><h5>New ticket has been assigned to you. Ticket information is given below:<br></h5><p>Ticket User&nbsp; :&nbsp; <b>{{ticket_user}}</b><br>Ticket track id&nbsp; :<b>&nbsp; {{ticket_track_id}}</b><b><br></b>Ticket title :<b>&nbsp; </b><b>{{ticket_title}}<br></b>Ticket link&nbsp; :<b>&nbsp; {{ticket_link}}</b><b><br></b></p><p><b><br></b></p><p><span style=\"font-size: 14px;\">Thanks</span><b><br></b><span style=\"font-size: 14px;\">{{site_name}}</span><b><br></b></p><p><br></p>');
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expired_info`
--

DROP TABLE IF EXISTS `expired_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expired_info` (
  `key` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expired_info`
--

LOCK TABLES `expired_info` WRITE;
/*!40000 ALTER TABLE `expired_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `expired_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_category`
--

DROP TABLE IF EXISTS `faq_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_category`
--

LOCK TABLES `faq_category` WRITE;
/*!40000 ALTER TABLE `faq_category` DISABLE KEYS */;
INSERT INTO `faq_category` VALUES (3,'IMCST','2024-01-18 14:22:18','A'),(4,'Amazonify','2024-01-18 14:22:43','A'),(5,'Uploadfly','2024-01-18 14:23:24','A');
/*!40000 ALTER TABLE `faq_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_list`
--

DROP TABLE IF EXISTS `faq_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_list` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int unsigned NOT NULL COMMENT 'FK(faq_category,id,name)',
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `ans` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ord` int unsigned NOT NULL DEFAULT '0',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_list`
--

LOCK TABLES `faq_list` WRITE;
/*!40000 ALTER TABLE `faq_list` DISABLE KEYS */;
INSERT INTO `faq_list` VALUES (1,5,'Do you offer free installation?','Yes, we are offering free installation.','2024-03-11 21:58:27',0,'A'),(2,5,'How many products I can add?','The number of products you can add to the app is based on your subscription plan.\r\n\r\nYou can see the details on the pricing plan page.','2024-03-11 22:00:07',0,'A'),(3,5,'What kind of products can be used for this app?','All kinds of products can use this app.','2024-03-12 20:24:27',0,'A'),(4,5,'Do you offer a money-back guarantee?','We dont offer a money-back guarantee in case you find the app is not fit with you. However, you can avoid any charge by uninstalling the app before the trial period ends.','2024-03-12 20:26:25',0,'A'),(5,5,'What kind of file that can be uploaded?','Uploadfly support any file extension','2024-03-12 20:31:29',0,'A'),(9,5,'Do you have an image editor when uploading images?','Yes, we have an image editor when someone uploads the image, you can also disable the image editor.','2024-05-18 14:27:42',0,'A'),(6,5,'Additional charge pricing?','We support additional charge pricing.\r\nif you have additional pricing you need to charge for your customer we have a flexible option to charge based on the global pricing or custom pricing.','2024-03-12 20:34:44',0,'A'),(7,5,'Supported file for uploadfly','Uploadfly supports any type of file, you can also add the type of file by yourself.','2024-03-12 20:35:56',0,'A'),(12,5,'Does uploadfly support bulk upload and multiple file upload.','Yes, uploadfly supports bulk upload, single upload, multiple file upload you can setting the upload from setting area.','2024-05-18 14:47:39',0,'A'),(8,5,'What file will be received by the store owner?','The owner store uploadfly will send you the original file you can download it from the the files area.','2024-03-12 20:38:22',0,'A'),(10,5,'What platform uploadfly available?','At the moment uploadfly is only available on Shopify but we will consider expanding the app support for Big Commerce and etsy.','2024-05-18 14:35:38',0,'A'),(11,5,'What features does Uploadfly offer?','Uploadfly has a flexible upload form, pricing, conditional logic, an image editor, and many more.','2024-05-18 14:39:02',0,'A'),(13,5,'Does uploadfly work with the buy button?','Yes, uploadfly is working without any issue with the buy button.','2024-05-18 14:49:21',0,'A'),(14,5,'Does uploadfly support image preview?','Yes, uploadfly supports image preview in the product and cart, without adding any code you can activate that option from the setting.','2024-05-18 14:51:34',0,'A'),(15,5,'Can we reorder the upload field?','Yes, you can reorder the upload field by drag and drop','2024-05-18 14:54:31',0,'A');
/*!40000 ALTER TABLE `faq_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guest_user`
--

DROP TABLE IF EXISTS `guest_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guest_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_name` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `username` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email` char(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `pass` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_verified_email` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `gender` char(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `phone` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `address` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `region` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `city` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `zip` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `country` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `dob` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'date of birth',
  `profile_url` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `photo_url` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `age` decimal(2,0) NOT NULL DEFAULT '0',
  `login_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'radio(N=Normal,F=Facebook,T=Twitter,G=Google,L=Linked In)',
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tzone` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_login_time` timestamp NULL DEFAULT NULL,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'drop(A=Active,I=Inactive,L=Locked)',
  `user_social_session_data` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='client';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guest_user`
--

LOCK TABLES `guest_user` WRITE;
/*!40000 ALTER TABLE `guest_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `guest_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_misslogin`
--

DROP TABLE IF EXISTS `history_misslogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history_misslogin` (
  `user_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `hit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED COMMENT='locked_user';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_misslogin`
--

LOCK TABLES `history_misslogin` WRITE;
/*!40000 ALTER TABLE `history_misslogin` DISABLE KEYS */;
/*!40000 ALTER TABLE `history_misslogin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iplist`
--

DROP TABLE IF EXISTS `iplist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `iplist` (
  `ip` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `added_on` timestamp NULL DEFAULT NULL,
  `start_count_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `req_counter` decimal(3,0) NOT NULL,
  `entry_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'radio(A=Auto, M=Manually',
  `country_code` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'radio(N=Normal,L=Locked,C=Captcha)',
  `h_at_count` decimal(3,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ip`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iplist`
--

LOCK TABLES `iplist` WRITE;
/*!40000 ALTER TABLE `iplist` DISABLE KEYS */;
INSERT INTO `iplist` VALUES ('159.192.42.60','2024-01-18 04:43:04','2024-01-18 06:30:04',2,'A','TH','N',0),('205.169.39.223','2024-01-18 06:11:42','2024-01-18 06:11:55',2,'A','US','N',0),('133.242.174.119','2024-01-18 07:40:29','2024-04-02 09:30:56',1,'A','JP','N',0),('199.45.155.34','2024-01-18 10:33:39','2024-05-19 10:35:18',1,'A','HK','N',0),('159.192.42.191','2024-01-18 11:18:01','2024-05-05 00:07:11',3,'A','TH','N',0),('171.244.43.14','2024-01-18 12:07:51','2024-01-18 12:07:51',2,'A','VN','N',0),('36.82.88.240','2024-01-18 13:00:43','2024-01-18 13:03:24',4,'A','ID','N',0),('182.253.87.129','2024-01-18 13:02:26','2024-01-19 13:52:05',1,'A','ID','N',0),('199.45.154.48','2024-01-18 13:49:01','2024-01-18 13:49:34',1,'A','HK','N',0),('47.89.193.162','2024-01-18 16:42:12','2024-01-18 16:42:12',1,'A','US','N',0),('154.28.229.242','2024-01-18 17:16:10','2024-01-18 17:16:10',1,'A','US','N',0),('154.28.229.171','2024-01-18 17:16:13','2024-01-18 17:16:13',13,'A','US','N',0),('195.211.77.140','2024-01-18 19:57:11','2024-04-02 19:06:44',1,'A','RU','N',0),('195.211.77.142','2024-01-18 20:03:43','2024-04-02 19:07:08',1,'A','RU','N',0),('205.210.31.222','2024-01-19 00:09:57','2024-01-19 00:09:57',1,'A','US','N',0),('159.192.42.22','2024-01-19 02:20:17','2024-01-19 05:56:48',2,'A','TH','N',0),('202.67.40.14','2024-01-19 02:43:57','2024-01-19 02:43:57',1,'A','ID','N',0),('182.253.124.83','2024-01-19 04:02:35','2024-01-19 08:46:06',1,'A','ID','N',0),('182.253.124.80','2024-01-19 09:09:13','2024-01-19 10:51:17',1,'A','ID','N',0),('159.192.43.101','2024-01-19 09:19:50','2024-01-19 09:19:50',4,'A','TH','N',0),('159.192.43.113','2024-01-19 12:28:32','2024-01-21 10:56:49',2,'A','TH','N',0),('34.83.203.92','2024-01-19 12:43:49','2024-05-17 15:25:45',3,'A','US','N',0),('167.88.63.96','2024-01-19 18:37:03','2024-01-19 18:37:03',2,'A','US','N',0),('205.210.31.24','2024-01-20 02:19:54','2024-01-20 02:19:54',1,'A','US','N',0),('198.235.24.6','2024-01-20 04:36:01','2024-01-20 04:36:01',1,'A','US','N',0),('174.138.7.201','2024-01-20 09:58:58','2024-01-20 09:58:58',1,'A','NL','N',0),('193.32.162.180','2024-01-20 11:15:55','2024-04-05 02:46:50',1,'A','NL','N',0),('51.81.46.212','2024-01-21 02:33:42','2024-01-21 03:03:41',1,'A','US','N',0),('135.148.100.196','2024-01-21 03:17:31','2024-01-21 03:17:31',1,'A','US','N',0),('35.86.80.133','2024-01-21 08:15:59','2024-01-21 08:15:59',1,'A','US','N',0),('13.201.172.202','2024-01-21 16:42:56','2024-01-21 16:42:56',1,'A','IN','N',0),('171.67.70.233','2024-01-22 00:17:47','2024-01-22 00:17:47',1,'A','US','N',0),('159.192.42.203','2024-01-22 02:18:51','2024-01-22 06:39:25',1,'A','TH','N',0),('103.126.30.114','2024-01-22 02:22:09','2024-01-24 09:41:22',4,'A','ID','N',0),('159.192.42.64','2024-01-22 06:41:25','2024-01-23 23:28:16',2,'A','TH','N',0),('182.253.54.193','2024-01-22 10:15:17','2024-01-23 10:06:50',1,'A','ID','N',0),('182.253.57.138','2024-01-22 11:24:56','2024-01-23 18:09:58',2,'A','ID','N',0),('180.254.78.72','2024-01-22 13:59:51','2024-01-23 13:01:38',4,'A','ID','N',0),('103.175.82.68','2024-01-22 14:51:29','2024-01-22 14:51:29',2,'A','ID','N',0),('198.235.24.204','2024-01-22 20:57:05','2024-01-22 20:57:05',1,'A','US','N',0),('198.235.24.155','2024-01-23 01:11:49','2024-01-23 01:11:49',1,'A','US','N',0),('104.234.204.32','2024-01-23 14:46:03','2024-01-23 14:46:03',1,'A','CA','N',0),('159.192.42.13','2024-01-24 10:58:32','2024-01-26 05:45:28',1,'A','TH','N',0),('180.254.68.205','2024-01-24 23:50:19','2024-01-24 23:50:19',2,'A','ID','N',0),('159.192.42.199','2024-01-26 15:30:08','2024-01-26 15:53:12',2,'A','TH','N',0),('205.210.31.2','2024-01-27 00:02:05','2024-01-27 00:02:05',1,'A','US','N',0),('198.235.24.167','2024-01-27 15:48:34','2024-01-27 15:48:34',1,'A','US','N',0),('165.227.137.52','2024-01-27 17:06:52','2024-01-27 17:06:52',1,'A','DE','N',0),('205.210.31.164','2024-01-28 15:49:51','2024-01-28 15:49:51',1,'A','US','N',0),('159.192.43.138','2024-01-29 03:04:56','2024-01-29 03:09:12',2,'A','TH','N',0),('159.192.43.253','2024-01-29 07:59:30','2024-01-29 07:59:30',2,'A','TH','N',0),('15.236.41.241','2024-01-30 02:07:05','2024-01-30 02:07:05',1,'A','FR','N',0),('54.216.7.214','2024-01-31 23:02:40','2024-01-31 23:02:40',1,'A','IE','N',0),('159.192.42.248','2024-02-01 13:18:14','2024-02-02 01:13:34',2,'A','TH','N',0),('159.192.42.138','2024-02-02 03:46:48','2024-02-03 22:36:56',2,'A','TH','N',0),('198.235.24.213','2024-02-02 16:49:36','2024-02-02 16:49:36',1,'A','US','N',0),('205.210.31.9','2024-02-03 02:24:58','2024-02-03 02:24:58',1,'A','US','N',0),('205.210.31.175','2024-02-03 12:13:48','2024-02-03 12:13:48',1,'A','US','N',0),('159.192.42.153','2024-02-04 04:33:17','2024-02-05 02:00:19',2,'A','TH','N',0),('144.91.106.14','2024-02-04 20:04:44','2024-02-04 20:04:44',2,'A','DE','N',0),('45.79.211.244','2024-02-05 02:28:44','2024-04-01 23:45:08',3,'A','US','N',0),('34.245.51.109','2024-02-05 06:23:17','2024-02-05 06:23:17',1,'A','IE','N',0),('198.235.24.42','2024-02-07 12:37:25','2024-02-07 12:37:25',1,'A','US','N',0),('205.210.31.144','2024-02-11 11:24:59','2024-02-11 11:24:59',1,'A','US','N',0),('103.26.211.5','2024-04-02 06:28:21','2024-04-02 06:28:21',2,'A','ID','N',0),('182.253.54.199','2024-04-02 06:28:36','2024-05-08 06:30:58',3,'A','ID','N',0),('103.148.151.156','2024-04-02 06:29:58','2024-04-02 06:29:58',1,'A','HK','N',0),('104.164.173.183','2024-04-02 06:30:13','2024-04-02 06:30:13',1,'A','US','N',0),('154.28.229.68','2024-04-02 06:30:18','2024-04-02 06:30:18',2,'A','US','N',0),('51.81.245.138','2024-04-02 06:31:12','2024-04-02 06:31:12',2,'A','US','N',0),('172.105.197.17','2024-04-02 06:31:12','2024-04-02 06:31:12',1,'A','JP','N',0),('154.28.229.30','2024-04-02 06:31:14','2024-04-02 06:31:14',1,'A','US','N',0),('65.154.226.167','2024-04-02 06:31:36','2024-04-13 20:31:33',1,'A','US','N',0),('104.164.173.84','2024-04-02 06:31:48','2024-04-02 06:31:48',1,'A','US','N',0),('154.28.229.211','2024-04-02 06:31:50','2024-04-02 06:31:50',1,'A','US','N',0),('154.28.229.89','2024-04-02 06:31:51','2024-04-02 06:31:51',2,'A','US','N',0),('154.28.229.7','2024-04-02 06:31:52','2024-04-02 06:31:52',2,'A','US','N',0),('44.202.78.0','2024-04-02 06:35:52','2024-04-02 06:35:52',3,'A','US','N',0),('65.154.226.166','2024-04-02 06:52:07','2024-04-02 06:52:07',2,'A','US','N',0),('15.204.248.55','2024-04-02 07:12:35','2024-04-02 07:12:35',1,'A','US','N',0),('192.46.186.183','2024-04-02 07:12:38','2024-04-02 07:12:38',2,'A','US','N',0),('104.164.173.35','2024-04-02 07:14:55','2024-04-02 07:15:06',1,'A','US','N',0),('182.253.57.57','2024-04-02 10:38:18','2024-04-02 10:40:41',3,'A','ID','N',0),('182.253.57.1','2024-04-02 11:27:17','2024-04-02 11:28:12',3,'A','ID','N',0),('182.253.57.203','2024-04-02 12:01:24','2024-04-04 11:00:40',3,'A','ID','N',0),('146.70.211.160','2024-04-02 12:22:22','2024-04-02 12:22:22',2,'A','US','N',0),('104.164.173.242','2024-04-02 19:08:36','2024-04-02 19:08:36',1,'A','US','N',0),('104.164.173.164','2024-04-02 19:08:41','2024-04-02 19:08:41',2,'A','US','N',0),('180.246.56.13','2024-04-02 21:44:56','2024-04-03 10:43:11',2,'A','ID','N',0),('139.144.22.158','2024-04-02 21:45:23','2024-05-14 22:54:01',2,'A','US','N',0),('103.189.123.5','2024-04-02 21:46:34','2024-04-02 21:46:34',2,'A','ID','N',0),('47.254.25.10','2024-04-03 00:54:54','2024-04-03 00:54:54',1,'A','US','N',0),('47.88.87.97','2024-04-03 00:55:23','2024-04-03 00:55:23',1,'A','US','N',0),('205.169.39.196','2024-04-03 04:48:02','2024-04-03 04:48:19',2,'A','US','N',0),('137.184.130.232','2024-04-03 07:38:03','2024-04-03 07:38:03',1,'A','US','N',0),('54.218.78.139','2024-04-03 08:17:48','2024-04-03 08:17:48',1,'A','US','N',0),('129.213.21.210','2024-04-04 03:55:40','2024-04-04 03:55:40',2,'A','US','N',0),('36.72.97.100','2024-04-04 05:27:55','2024-04-04 05:31:15',1,'A','ID','N',0),('83.147.52.37','2024-04-04 06:45:03','2024-04-05 12:06:58',1,'A','US','N',0),('36.79.67.84','2024-04-04 10:44:48','2024-04-04 21:18:31',1,'A','ID','N',0),('142.93.193.248','2024-04-05 08:49:19','2024-04-05 08:49:19',1,'A','US','N',0),('182.253.57.227','2024-04-05 10:35:46','2024-04-07 03:32:04',3,'A','ID','N',0),('36.80.151.217','2024-04-05 10:45:30','2024-04-06 21:11:32',3,'A','ID','N',0),('66.249.66.35','2024-04-05 17:01:54','2024-05-15 13:41:34',1,'A','US','N',0),('66.249.66.37','2024-04-05 17:01:55','2024-05-13 10:01:44',1,'A','US','N',0),('66.249.71.64','2024-04-05 17:04:25','2024-04-28 22:33:38',1,'A','US','N',0),('66.249.66.36','2024-04-05 17:04:27','2024-05-15 13:41:33',1,'A','US','N',0),('205.169.39.76','2024-04-05 22:40:17','2024-04-05 22:40:31',1,'A','US','N',0),('167.71.55.218','2024-04-06 06:42:52','2024-04-06 06:42:52',1,'A','DE','N',0),('206.168.34.190','2024-04-06 07:55:13','2024-04-06 07:55:13',2,'A','US','N',0),('54.88.179.33','2024-04-06 09:47:07','2024-04-24 17:18:51',2,'A','US','N',0),('52.91.231.7','2024-04-06 17:31:26','2024-04-06 17:31:26',1,'A','US','N',0),('54.83.177.192','2024-04-08 06:01:45','2024-04-08 06:01:45',1,'A','US','N',0),('66.249.71.65','2024-04-08 22:46:35','2024-05-19 00:29:29',1,'A','US','N',0),('91.215.85.43','2024-04-09 05:18:04','2024-04-09 05:18:04',5,'A','RU','N',0),('205.210.31.219','2024-04-09 10:50:22','2024-04-09 10:50:22',1,'A','US','N',0),('17.241.219.227','2024-04-09 23:26:42','2024-04-09 23:26:42',2,'A','US','N',0),('66.249.68.8','2024-04-10 00:50:07','2024-05-19 00:29:31',1,'A','US','N',0),('180.254.28.173','2024-04-11 00:25:05','2024-04-12 22:49:53',3,'A','ID','N',0),('66.249.71.71','2024-04-11 05:52:11','2024-05-17 22:12:15',1,'A','US','N',0),('87.236.176.174','2024-04-11 07:15:35','2024-04-11 07:15:35',1,'A','GB','N',0),('52.11.7.141','2024-04-11 13:25:12','2024-05-02 04:44:53',2,'A','US','N',0),('35.84.241.246','2024-04-11 13:25:21','2024-04-11 13:25:21',3,'A','US','N',0),('87.236.176.31','2024-04-11 15:48:33','2024-04-11 15:48:33',1,'A','GB','N',0),('87.236.176.24','2024-04-11 15:48:35','2024-04-11 15:48:35',1,'A','GB','N',0),('209.97.152.248','2024-04-11 15:48:37','2024-04-11 15:48:37',1,'A','US','N',0),('192.42.116.187','2024-04-11 15:48:39','2024-04-11 15:48:39',1,'A','NL','N',0),('66.249.66.41','2024-04-12 11:06:13','2024-04-12 11:06:13',2,'A','US','N',0),('35.171.144.152','2024-04-12 18:28:16','2024-04-12 18:28:16',2,'A','US','N',0),('198.235.24.194','2024-04-12 21:37:50','2024-04-12 21:37:50',1,'A','US','N',0),('95.217.18.177','2024-04-13 01:41:55','2024-04-13 01:41:55',1,'A','FI','N',0),('205.210.31.17','2024-04-13 07:09:06','2024-04-13 07:09:06',1,'A','US','N',0),('34.72.176.129','2024-04-13 20:31:24','2024-04-13 20:31:24',2,'A','US','N',0),('65.154.226.170','2024-04-13 20:31:25','2024-04-29 16:29:02',3,'A','US','N',0),('104.197.69.115','2024-04-13 20:31:26','2024-04-13 20:31:26',1,'A','US','N',0),('205.169.39.184','2024-04-13 20:31:32','2024-04-13 20:31:32',4,'A','US','N',0),('66.249.65.7','2024-04-14 06:26:50','2024-05-09 05:48:33',2,'A','US','N',0),('94.228.122.109','2024-04-14 07:52:08','2024-04-14 07:52:08',3,'A','PL','N',0),('66.249.68.1','2024-04-14 10:17:46','2024-04-27 05:40:11',1,'A','US','N',0),('36.79.80.125','2024-04-15 22:55:11','2024-04-19 07:08:08',1,'A','ID','N',0),('182.253.54.205','2024-04-16 05:29:00','2024-04-18 09:08:59',3,'A','ID','N',0),('205.210.31.167','2024-04-16 07:03:45','2024-04-16 07:03:45',1,'A','US','N',0),('206.168.34.185','2024-04-16 11:54:13','2024-04-16 11:54:13',2,'A','US','N',0),('182.253.57.190','2024-04-16 12:22:48','2024-04-16 23:09:25',3,'A','ID','N',0),('167.94.138.50','2024-04-16 13:30:28','2024-04-16 13:30:28',2,'A','US','N',0),('125.164.82.131','2024-04-16 13:42:56','2024-04-16 13:53:43',3,'A','ID','N',0),('179.43.152.68','2024-04-16 17:21:01','2024-04-16 17:21:01',1,'A','CH','N',0),('189.203.103.46','2024-04-16 19:59:27','2024-04-16 19:59:27',3,'A','MX','N',0),('195.154.122.71','2024-04-17 04:34:29','2024-04-17 04:34:29',3,'A','FR','N',0),('54.36.148.95','2024-04-17 04:34:39','2024-04-17 04:34:39',1,'A','FR','N',0),('54.36.148.75','2024-04-17 04:34:40','2024-04-17 04:34:40',1,'A','FR','N',0),('54.36.148.28','2024-04-17 04:34:42','2024-04-17 04:34:42',1,'A','FR','N',0),('3.110.163.3','2024-04-17 06:03:34','2024-04-17 06:03:34',1,'A','IN','N',0),('66.249.77.197','2024-04-17 15:08:05','2024-05-05 14:08:14',2,'A','US','N',0),('182.253.54.207','2024-04-18 10:02:14','2024-04-19 10:23:32',3,'A','ID','N',0),('125.164.6.147','2024-04-18 12:04:28','2024-04-19 11:10:18',2,'A','ID','N',0),('182.253.57.130','2024-04-18 12:46:16','2024-04-19 12:07:00',3,'A','ID','N',0),('66.249.77.198','2024-04-18 22:46:25','2024-05-05 19:12:51',1,'A','US','N',0),('66.249.79.163','2024-04-19 13:09:58','2024-04-19 13:09:58',2,'A','US','N',0),('69.160.160.51','2024-04-20 02:16:54','2024-04-20 02:16:54',2,'A','US','N',0),('40.77.167.203','2024-04-20 07:55:13','2024-05-10 00:58:29',1,'A','US','N',0),('207.46.13.14','2024-04-20 07:55:22','2024-04-20 07:55:22',1,'A','US','N',0),('167.172.240.163','2024-04-20 08:42:32','2024-04-20 08:42:32',1,'A','US','N',0),('198.235.24.185','2024-04-20 12:26:40','2024-04-20 12:26:40',1,'A','US','N',0),('35.211.10.21','2024-04-21 05:16:32','2024-04-21 05:16:32',2,'A','US','N',0),('54.215.191.51','2024-04-21 11:17:17','2024-04-21 11:17:17',1,'A','US','N',0),('205.210.31.165','2024-04-21 13:03:26','2024-04-21 13:03:26',1,'A','US','N',0),('52.11.101.75','2024-04-22 05:10:27','2024-04-22 05:10:27',1,'A','US','N',0),('35.88.163.20','2024-04-22 09:48:48','2024-04-22 09:48:48',1,'A','US','N',0),('198.235.24.177','2024-04-22 10:30:38','2024-04-22 10:30:38',1,'A','US','N',0),('182.253.57.187','2024-04-22 11:44:42','2024-04-22 11:44:54',2,'A','ID','N',0),('182.253.57.39','2024-04-22 11:52:22','2024-04-30 22:24:21',3,'A','ID','N',0),('169.150.198.73','2024-04-22 23:01:01','2024-04-22 23:01:01',1,'A','BR','N',0),('35.158.93.215','2024-04-23 01:07:38','2024-04-23 01:07:38',1,'A','DE','N',0),('3.224.220.101','2024-04-23 04:27:36','2024-04-23 04:28:25',1,'A','US','N',0),('23.22.35.162','2024-04-23 04:27:44','2024-04-23 04:28:29',2,'A','US','N',0),('182.253.57.132','2024-04-23 11:47:34','2024-04-24 11:49:49',3,'A','ID','N',0),('66.249.79.165','2024-04-23 13:58:46','2024-04-23 13:58:46',2,'A','US','N',0),('65.155.30.101','2024-04-23 19:46:17','2024-04-23 19:46:17',2,'A','US','N',0),('52.167.144.19','2024-04-24 01:18:23','2024-04-24 01:18:23',1,'A','US','N',0),('40.77.167.43','2024-04-24 01:18:30','2024-04-24 01:18:30',1,'A','US','N',0),('40.77.167.255','2024-04-24 01:37:34','2024-04-24 01:37:34',1,'A','US','N',0),('52.167.144.212','2024-04-24 01:52:06','2024-04-24 01:52:06',1,'A','US','N',0),('157.55.39.52','2024-04-24 03:36:44','2024-04-24 03:36:44',1,'A','US','N',0),('157.55.39.13','2024-04-24 03:55:06','2024-04-24 03:55:06',1,'A','US','N',0),('159.192.42.254','2024-04-24 08:29:49','2024-04-26 00:53:31',2,'A','TH','N',0),('182.253.57.169','2024-04-24 13:16:43','2024-04-25 13:21:25',2,'A','ID','N',0),('52.167.144.16','2024-04-24 20:59:43','2024-05-10 00:58:35',1,'A','US','N',0),('52.167.144.163','2024-04-24 20:59:56','2024-04-24 20:59:56',1,'A','US','N',0),('40.77.167.76','2024-04-24 21:23:48','2024-05-02 22:21:15',1,'A','US','N',0),('40.77.167.24','2024-04-24 21:34:26','2024-04-24 23:21:43',1,'A','US','N',0),('40.77.167.33','2024-04-24 23:47:16','2024-04-24 23:47:16',1,'A','US','N',0),('180.247.32.6','2024-04-25 12:57:56','2024-04-25 13:30:10',4,'A','ID','N',0),('193.34.74.239','2024-04-25 14:27:47','2024-04-25 14:27:47',2,'A','US','N',0),('40.77.167.30','2024-04-25 15:34:52','2024-04-25 15:34:52',1,'A','US','N',0),('40.77.167.235','2024-04-25 15:46:13','2024-04-25 15:46:13',1,'A','US','N',0),('40.77.167.32','2024-04-25 15:54:30','2024-04-25 15:54:30',1,'A','US','N',0),('165.154.18.108','2024-04-25 16:30:01','2024-04-25 16:30:15',2,'A','JP','N',0),('52.167.144.235','2024-04-25 17:08:28','2024-04-25 17:08:28',1,'A','US','N',0),('40.77.167.44','2024-04-25 17:25:28','2024-04-25 17:25:28',1,'A','US','N',0),('40.77.167.23','2024-04-26 11:16:53','2024-04-26 11:16:53',1,'A','US','N',0),('182.253.57.44','2024-04-26 11:47:25','2024-04-26 11:47:37',2,'A','ID','N',0),('182.253.57.219','2024-04-26 12:42:06','2024-04-26 17:21:32',3,'A','ID','N',0),('66.249.68.2','2024-04-26 13:55:25','2024-04-27 05:40:13',1,'A','US','N',0),('159.192.42.91','2024-04-26 14:11:55','2024-04-28 00:52:07',3,'A','TH','N',0),('40.77.167.136','2024-04-27 06:46:54','2024-04-27 06:46:54',1,'A','US','N',0),('180.252.172.149','2024-04-27 08:53:58','2024-04-27 08:53:58',3,'A','ID','N',0),('182.253.57.210','2024-04-27 11:58:27','2024-04-27 14:14:51',3,'A','ID','N',0),('52.167.144.140','2024-04-28 04:26:57','2024-04-28 04:26:57',1,'A','US','N',0),('18.215.245.134','2024-04-28 07:01:10','2024-04-28 07:01:10',1,'A','US','N',0),('159.192.42.61','2024-04-28 10:36:38','2024-04-29 01:26:03',5,'A','TH','N',0),('17.22.253.132','2024-04-28 14:18:35','2024-04-28 14:18:35',3,'A','US','N',0),('3.90.104.218','2024-04-28 17:22:01','2024-04-29 07:43:36',1,'A','US','N',0),('52.167.144.230','2024-04-29 03:12:32','2024-04-29 03:12:32',1,'A','US','N',0),('66.249.77.199','2024-04-29 03:23:00','2024-05-05 19:12:49',1,'A','US','N',0),('159.192.43.249','2024-04-29 05:24:19','2024-04-29 05:24:19',6,'A','TH','N',0),('159.192.43.241','2024-04-29 07:12:24','2024-05-01 05:40:54',2,'A','TH','N',0),('182.253.57.248','2024-04-29 11:22:10','2024-04-29 13:04:55',3,'A','ID','N',0),('47.128.38.32','2024-04-29 12:21:52','2024-04-29 12:21:52',1,'A','SG','N',0),('223.27.237.4','2024-04-29 13:57:33','2024-04-29 13:57:33',2,'A','TH','N',0),('205.169.39.135','2024-04-29 19:26:32','2024-04-29 19:26:48',3,'A','US','N',0),('185.117.225.171','2024-04-29 21:22:39','2024-04-29 21:22:39',3,'A','US','N',0),('3.145.97.20','2024-04-30 08:10:36','2024-04-30 08:10:36',1,'A','US','N',0),('17.241.219.24','2024-04-30 12:35:13','2024-04-30 12:35:13',1,'A','US','N',0),('182.253.57.197','2024-04-30 12:54:57','2024-04-30 12:55:09',2,'A','ID','N',0),('92.118.39.244','2024-05-01 02:37:02','2024-05-01 02:37:02',1,'A','US','N',0),('159.192.43.216','2024-05-01 06:02:33','2024-05-03 04:35:47',1,'A','TH','N',0),('182.253.57.236','2024-05-02 12:28:21','2024-05-05 23:46:28',5,'A','ID','N',0),('61.5.53.41','2024-05-02 14:22:17','2024-05-02 16:37:01',2,'A','ID','N',0),('47.128.56.226','2024-05-03 03:30:44','2024-05-03 03:30:44',1,'A','SG','N',0),('5.81.65.201','2024-05-03 03:34:49','2024-05-03 03:34:49',1,'A','GB','N',0),('47.128.50.23','2024-05-03 03:38:40','2024-05-03 03:38:40',1,'A','SG','N',0),('77.98.143.165','2024-05-03 03:42:44','2024-05-03 03:42:44',1,'A','GB','N',0),('162.142.125.223','2024-05-03 07:27:19','2024-05-03 07:27:19',2,'A','US','N',0),('199.45.155.51','2024-05-03 08:45:04','2024-05-03 08:45:04',2,'A','HK','N',0),('107.166.12.246','2024-05-03 17:53:06','2024-05-03 17:53:06',1,'A','US','N',0),('159.89.24.61','2024-05-04 08:54:03','2024-05-04 08:54:03',1,'A','DE','N',0),('3.236.106.99','2024-05-04 15:43:40','2024-05-04 15:43:40',3,'A','US','N',0),('159.192.43.188','2024-05-05 06:06:24','2024-05-06 09:47:33',4,'A','TH','N',0),('123.6.49.18','2024-05-05 21:52:56','2024-05-05 21:52:56',1,'A','CN','N',0),('123.6.49.41','2024-05-05 21:53:01','2024-05-05 21:53:01',2,'A','CN','N',0),('27.115.124.70','2024-05-05 21:53:07','2024-05-05 21:53:07',1,'A','CN','N',0),('18.201.248.247','2024-05-06 08:18:32','2024-05-06 08:18:32',1,'A','IE','N',0),('182.253.57.27','2024-05-06 11:40:04','2024-05-09 23:45:07',4,'A','ID','N',0),('159.192.43.218','2024-05-06 12:02:53','2024-05-08 08:37:19',4,'A','TH','N',0),('108.35.231.202','2024-05-06 18:34:54','2024-05-06 18:34:54',1,'A','US','N',0),('47.128.38.114','2024-05-06 18:35:02','2024-05-06 18:35:02',1,'A','SG','N',0),('69.159.119.10','2024-05-06 18:39:44','2024-05-06 18:39:44',1,'A','CA','N',0),('47.128.57.32','2024-05-06 18:43:01','2024-05-06 18:43:01',1,'A','SG','N',0),('24.189.36.47','2024-05-06 18:47:07','2024-05-06 18:47:07',1,'A','US','N',0),('182.253.235.170','2024-05-07 11:11:48','2024-05-14 07:10:49',3,'A','ID','N',0),('182.253.54.195','2024-05-08 07:00:26','2024-05-13 11:01:34',4,'A','ID','N',0),('159.192.42.43','2024-05-08 13:24:43','2024-05-10 00:58:02',3,'A','TH','N',0),('47.128.55.146','2024-05-08 18:48:54','2024-05-08 18:48:54',1,'A','SG','N',0),('86.139.116.210','2024-05-08 18:52:56','2024-05-08 18:52:56',1,'A','GB','N',0),('47.128.16.36','2024-05-08 18:56:53','2024-05-08 18:56:53',1,'A','SG','N',0),('199.45.155.44','2024-05-09 03:28:05','2024-05-09 03:28:05',1,'A','HK','N',0),('182.0.204.236','2024-05-09 09:03:20','2024-05-09 09:03:20',3,'A','ID','N',0),('44.236.207.248','2024-05-09 10:13:14','2024-05-09 10:13:14',3,'A','US','N',0),('103.130.18.2','2024-05-09 11:10:34','2024-05-15 16:22:41',3,'A','ID','N',0),('174.229.130.204','2024-05-09 15:57:15','2024-05-09 17:13:42',3,'A','US','N',0),('37.187.89.104','2024-05-09 19:14:56','2024-05-09 19:15:08',1,'A','FR','N',0),('36.78.140.35','2024-05-09 21:29:36','2024-05-10 05:20:55',3,'A','ID','N',0),('217.76.60.63','2024-05-10 00:06:05','2024-05-10 00:07:21',2,'A','DE','N',0),('194.163.181.247','2024-05-10 04:51:53','2024-05-10 04:53:48',1,'A','DE','N',0),('182.3.47.255','2024-05-10 10:06:17','2024-05-10 10:06:17',4,'A','ID','N',0),('116.197.128.255','2024-05-10 10:35:48','2024-05-11 02:41:13',3,'A','ID','N',0),('159.192.42.147','2024-05-10 12:01:55','2024-05-12 04:25:43',3,'A','TH','N',0),('158.220.123.224','2024-05-10 12:06:30','2024-05-10 12:06:43',1,'A','DE','N',0),('101.128.112.4','2024-05-10 14:14:29','2024-05-10 14:14:29',4,'A','ID','N',0),('49.229.234.133','2024-05-10 15:14:44','2024-05-10 15:18:21',3,'A','TH','N',0),('47.128.115.197','2024-05-10 18:58:02','2024-05-10 18:58:02',1,'A','SG','N',0),('145.224.65.251','2024-05-10 19:02:07','2024-05-10 19:02:07',1,'A','GB','N',0),('47.128.27.72','2024-05-10 19:06:04','2024-05-10 19:06:04',1,'A','SG','N',0),('87.236.176.13','2024-05-11 07:51:16','2024-05-11 07:51:16',1,'A','GB','N',0),('87.236.176.207','2024-05-11 07:51:22','2024-05-11 07:51:22',1,'A','GB','N',0),('104.248.203.191','2024-05-11 07:51:25','2024-05-11 07:51:25',1,'A','NL','N',0),('171.25.193.235','2024-05-11 07:51:27','2024-05-11 07:51:27',1,'A','SE','N',0),('172.225.72.69','2024-05-11 10:45:24','2024-05-11 10:45:24',3,'A','ID','N',0),('198.235.24.90','2024-05-11 13:42:22','2024-05-11 13:42:22',1,'A','US','N',0),('17.241.75.238','2024-05-11 14:27:15','2024-05-11 14:27:15',3,'A','US','N',0),('114.124.205.223','2024-05-11 14:34:32','2024-05-11 15:30:52',3,'A','ID','N',0),('182.3.47.3','2024-05-11 15:14:36','2024-05-11 15:14:36',4,'A','ID','N',0),('114.124.236.126','2024-05-11 16:39:29','2024-05-11 16:39:29',2,'A','ID','N',0),('87.236.176.205','2024-05-11 23:05:11','2024-05-11 23:05:11',1,'A','GB','N',0),('120.89.91.53','2024-05-11 23:26:33','2024-05-12 07:58:41',1,'A','ID','N',0),('103.43.213.66','2024-05-12 01:50:44','2024-05-12 01:50:44',3,'A','PH','N',0),('103.130.18.14','2024-05-12 15:06:49','2024-05-12 15:06:49',3,'A','ID','N',0),('47.128.110.198','2024-05-12 19:14:17','2024-05-12 19:14:17',1,'A','SG','N',0),('86.47.58.184','2024-05-12 19:18:21','2024-05-16 20:12:01',1,'A','IE','N',0),('47.128.113.27','2024-05-12 19:22:19','2024-05-12 19:22:19',1,'A','SG','N',0),('182.253.57.244','2024-05-12 19:44:08','2024-05-14 11:43:06',2,'A','ID','N',0),('159.192.42.152','2024-05-12 22:34:34','2024-05-13 22:56:39',3,'A','TH','N',0),('182.3.50.45','2024-05-13 03:27:25','2024-05-13 03:27:25',2,'A','ID','N',0),('182.3.50.57','2024-05-13 03:27:27','2024-05-13 03:27:27',1,'A','ID','N',0),('118.99.80.140','2024-05-13 03:58:14','2024-05-13 03:58:14',3,'A','ID','N',0),('182.3.51.161','2024-05-13 04:02:51','2024-05-13 04:02:51',2,'A','ID','N',0),('182.3.36.45','2024-05-13 04:02:52','2024-05-13 04:02:52',1,'A','ID','N',0),('116.206.8.19','2024-05-13 04:06:11','2024-05-13 04:06:11',3,'A','ID','N',0),('180.243.2.187','2024-05-13 04:12:11','2024-05-13 04:12:11',3,'A','ID','N',0),('74.82.60.27','2024-05-13 04:21:14','2024-05-13 04:21:30',3,'A','US','N',0),('223.255.229.74','2024-05-13 04:23:16','2024-05-13 04:23:16',3,'A','ID','N',0),('103.149.54.244','2024-05-13 04:25:58','2024-05-13 04:25:58',3,'A','ID','N',0),('114.4.213.241','2024-05-13 04:27:04','2024-05-13 04:28:51',3,'A','ID','N',0),('180.244.166.88','2024-05-13 04:27:08','2024-05-13 04:27:08',3,'A','ID','N',0),('114.79.1.152','2024-05-13 04:29:48','2024-05-13 04:29:48',3,'A','ID','N',0),('104.248.75.7','2024-05-13 04:29:53','2024-05-13 04:29:53',1,'A','US','N',0),('110.137.192.79','2024-05-13 04:42:11','2024-05-16 07:18:43',3,'A','ID','N',0),('103.124.136.76','2024-05-13 05:00:25','2024-05-13 05:00:25',3,'A','ID','N',0),('103.224.124.50','2024-05-13 05:02:03','2024-05-13 05:02:44',3,'A','ID','N',0),('180.252.83.116','2024-05-13 05:02:36','2024-05-13 05:02:36',3,'A','ID','N',0),('182.2.167.67','2024-05-13 05:07:59','2024-05-13 05:08:12',1,'A','ID','N',0),('140.213.5.239','2024-05-13 05:39:35','2024-05-13 05:39:35',3,'A','ID','N',0),('182.0.135.250','2024-05-13 05:40:41','2024-05-13 05:40:41',3,'A','ID','N',0),('202.147.201.77','2024-05-13 05:47:59','2024-05-13 05:47:59',3,'A','ID','N',0),('36.77.171.61','2024-05-13 05:49:12','2024-05-13 05:49:12',3,'A','ID','N',0),('103.217.219.197','2024-05-13 05:51:13','2024-05-13 05:51:13',3,'A','ID','N',0),('103.130.18.23','2024-05-13 06:10:30','2024-05-13 06:18:29',1,'A','ID','N',0),('103.130.18.11','2024-05-13 06:10:32','2024-05-13 06:18:28',2,'A','ID','N',0),('125.160.19.74','2024-05-13 14:20:33','2024-05-13 15:50:28',2,'A','ID','N',0),('51.222.253.14','2024-05-13 16:08:38','2024-05-13 16:08:38',1,'A','SG','N',0),('54.36.149.53','2024-05-13 16:08:41','2024-05-13 16:08:41',1,'A','FR','N',0),('54.36.149.102','2024-05-13 16:09:53','2024-05-13 16:09:53',1,'A','FR','N',0),('54.36.148.170','2024-05-13 20:43:28','2024-05-13 20:43:28',1,'A','FR','N',0),('54.36.149.93','2024-05-13 21:04:08','2024-05-13 21:04:08',1,'A','FR','N',0),('54.36.148.123','2024-05-13 21:14:20','2024-05-13 21:14:20',1,'A','FR','N',0),('54.36.149.39','2024-05-13 21:21:59','2024-05-13 21:21:59',1,'A','FR','N',0),('54.36.148.9','2024-05-13 21:30:11','2024-05-13 21:30:11',1,'A','FR','N',0),('54.36.148.51','2024-05-13 21:38:54','2024-05-13 21:38:54',1,'A','FR','N',0),('54.36.148.184','2024-05-13 21:47:51','2024-05-13 21:47:51',1,'A','FR','N',0),('54.36.148.82','2024-05-13 21:57:22','2024-05-13 21:57:22',1,'A','FR','N',0),('54.36.149.31','2024-05-13 22:03:41','2024-05-13 22:03:41',1,'A','FR','N',0),('54.36.149.60','2024-05-13 22:07:36','2024-05-13 22:07:36',1,'A','FR','N',0),('54.36.149.103','2024-05-13 22:11:08','2024-05-13 22:11:08',1,'A','FR','N',0),('54.36.148.204','2024-05-13 22:15:57','2024-05-13 22:15:57',1,'A','FR','N',0),('54.36.148.5','2024-05-13 22:20:51','2024-05-13 22:20:51',1,'A','FR','N',0),('54.36.148.214','2024-05-13 22:25:42','2024-05-13 22:25:42',1,'A','FR','N',0),('54.36.149.29','2024-05-13 22:29:43','2024-05-13 22:29:43',1,'A','FR','N',0),('54.36.148.146','2024-05-13 22:33:46','2024-05-13 22:33:46',1,'A','FR','N',0),('54.36.148.101','2024-05-13 22:37:35','2024-05-13 22:37:35',1,'A','FR','N',0),('54.36.148.25','2024-05-14 00:10:54','2024-05-14 00:10:54',1,'A','FR','N',0),('54.36.148.224','2024-05-14 00:45:08','2024-05-14 00:45:08',1,'A','FR','N',0),('54.36.149.78','2024-05-14 01:19:55','2024-05-14 01:19:55',1,'A','FR','N',0),('54.36.149.13','2024-05-14 01:58:26','2024-05-14 01:58:26',1,'A','FR','N',0),('47.128.41.156','2024-05-14 02:23:20','2024-05-14 02:23:20',2,'A','SG','N',0),('47.128.124.218','2024-05-14 02:23:43','2024-05-14 02:23:43',1,'A','SG','N',0),('80.249.245.2','2024-05-14 02:27:45','2024-05-14 02:27:45',1,'A','IE','N',0),('47.128.122.16','2024-05-14 02:31:46','2024-05-14 02:31:46',1,'A','SG','N',0),('187.188.197.49','2024-05-14 02:35:42','2024-05-14 02:35:42',1,'A','MX','N',0),('54.36.149.6','2024-05-14 02:37:57','2024-05-14 02:37:57',1,'A','FR','N',0),('54.36.148.52','2024-05-14 03:16:47','2024-05-14 03:16:47',1,'A','FR','N',0),('54.36.148.247','2024-05-14 04:04:43','2024-05-14 04:04:43',1,'A','FR','N',0),('54.36.148.85','2024-05-14 04:55:10','2024-05-14 04:55:10',1,'A','FR','N',0),('54.36.148.98','2024-05-14 04:55:12','2024-05-14 04:55:12',1,'A','FR','N',0),('54.36.148.254','2024-05-14 05:46:15','2024-05-14 05:46:15',1,'A','FR','N',0),('54.36.148.111','2024-05-14 06:40:00','2024-05-14 06:40:00',1,'A','FR','N',0),('54.36.148.55','2024-05-14 07:27:04','2024-05-14 07:27:04',1,'A','FR','N',0),('182.253.54.192','2024-05-14 08:15:37','2024-05-14 10:58:21',3,'A','ID','N',0),('182.253.57.199','2024-05-14 11:56:39','2024-05-15 01:53:05',3,'A','ID','N',0),('159.192.43.239','2024-05-14 16:04:29','2024-05-16 06:02:20',3,'A','TH','N',0),('51.222.253.2','2024-05-14 18:53:28','2024-05-14 18:53:28',1,'A','SG','N',0),('51.222.253.5','2024-05-14 18:53:31','2024-05-14 18:53:31',1,'A','SG','N',0),('47.128.58.62','2024-05-14 19:37:03','2024-05-14 19:37:03',1,'A','SG','N',0),('186.207.42.44','2024-05-14 19:41:02','2024-05-14 19:41:02',1,'A','BR','N',0),('47.128.113.21','2024-05-14 19:44:59','2024-05-14 19:44:59',1,'A','SG','N',0),('118.175.45.5','2024-05-14 23:31:09','2024-05-14 23:31:09',2,'A','TH','N',0),('180.241.240.21','2024-05-14 23:39:25','2024-05-14 23:39:25',2,'A','ID','N',0),('180.241.243.186','2024-05-14 23:39:26','2024-05-14 23:39:26',1,'A','ID','N',0),('180.251.231.168','2024-05-15 00:33:28','2024-05-15 09:54:53',3,'A','ID','N',0),('103.101.231.3','2024-05-15 03:47:50','2024-05-15 03:47:50',3,'A','ID','N',0),('182.253.54.202','2024-05-15 05:40:00','2024-05-15 10:44:27',4,'A','ID','N',0),('182.253.57.217','2024-05-15 11:28:49','2024-05-15 23:52:06',3,'A','ID','N',0),('103.130.18.19','2024-05-15 12:35:08','2024-05-15 12:35:08',1,'A','ID','N',0),('180.94.8.67','2024-05-15 12:36:41','2024-05-15 12:36:41',3,'A','ID','N',0),('202.80.216.4','2024-05-15 14:14:35','2024-05-15 14:14:35',3,'A','ID','N',0),('182.2.4.24','2024-05-15 15:05:47','2024-05-15 15:05:47',2,'A','ID','N',0),('182.2.4.96','2024-05-15 15:05:52','2024-05-15 15:05:52',1,'A','ID','N',0),('103.148.197.82','2024-05-15 19:00:20','2024-05-15 19:00:20',3,'A','ID','N',0),('47.128.40.130','2024-05-16 02:40:42','2024-05-16 02:40:42',2,'A','SG','N',0),('47.128.16.166','2024-05-16 02:40:51','2024-05-16 02:40:51',1,'A','SG','N',0),('68.194.16.210','2024-05-16 02:45:02','2024-05-16 02:45:02',1,'A','US','N',0),('47.128.48.128','2024-05-16 02:48:52','2024-05-16 02:48:52',1,'A','SG','N',0),('182.253.230.77','2024-05-16 04:54:16','2024-05-16 04:54:16',3,'A','ID','N',0),('182.4.71.193','2024-05-16 04:54:19','2024-05-16 04:54:42',1,'A','ID','N',0),('203.78.119.25','2024-05-16 04:55:17','2024-05-16 04:55:17',3,'A','ID','N',0),('202.180.25.13','2024-05-16 06:23:46','2024-05-16 06:23:46',3,'A','ID','N',0),('114.124.215.172','2024-05-16 07:14:36','2024-05-16 07:14:36',3,'A','ID','N',0),('182.0.238.78','2024-05-16 07:27:05','2024-05-16 07:27:05',3,'A','ID','N',0),('182.2.144.72','2024-05-16 07:45:43','2024-05-16 07:45:43',3,'A','ID','N',0),('180.242.192.213','2024-05-16 08:25:53','2024-05-16 08:25:53',3,'A','ID','N',0),('182.253.54.201','2024-05-16 08:43:28','2024-05-17 08:47:48',1,'A','ID','N',0),('192.42.116.214','2024-05-16 09:40:07','2024-05-16 09:40:07',1,'A','NL','N',0),('185.220.101.169','2024-05-16 09:40:22','2024-05-16 09:40:22',1,'A','DE','N',0),('112.215.175.154','2024-05-16 09:48:41','2024-05-16 09:51:04',3,'A','ID','N',0),('182.253.57.139','2024-05-16 11:19:06','2024-05-16 19:45:47',3,'A','ID','N',0),('180.252.81.86','2024-05-16 14:58:21','2024-05-16 14:58:21',3,'A','ID','N',0),('159.192.42.132','2024-05-16 15:45:03','2024-05-17 13:10:24',4,'A','TH','N',0),('47.128.17.34','2024-05-16 19:59:59','2024-05-16 19:59:59',1,'A','SG','N',0),('86.7.150.204','2024-05-16 20:04:00','2024-05-16 20:04:00',1,'A','GB','N',0),('47.128.60.148','2024-05-16 20:07:58','2024-05-16 20:07:58',1,'A','SG','N',0),('20.245.180.120','2024-05-16 20:09:57','2024-05-16 20:09:57',3,'A','US','N',0),('47.128.47.5','2024-05-17 03:06:40','2024-05-17 03:06:40',2,'A','SG','N',0),('34.0.194.143','2024-05-17 04:58:28','2024-05-17 04:58:39',1,'A','ES','N',0),('182.253.59.104','2024-05-17 06:38:52','2024-05-18 01:53:15',3,'A','ID','N',0),('182.3.38.154','2024-05-17 06:54:40','2024-05-17 06:54:40',3,'A','ID','N',0),('199.45.154.17','2024-05-17 08:32:13','2024-05-17 08:32:49',1,'A','US','N',0),('199.45.155.16','2024-05-17 09:29:49','2024-05-17 09:29:49',2,'A','HK','N',0),('101.128.94.197','2024-05-17 09:36:47','2024-05-18 02:51:26',3,'A','ID','N',0),('125.160.114.106','2024-05-17 09:37:51','2024-05-17 09:37:51',3,'A','ID','N',0),('182.2.134.220','2024-05-17 12:43:33','2024-05-17 12:58:49',3,'A','ID','N',0),('182.253.57.223','2024-05-17 13:03:06','2024-05-18 00:08:33',4,'A','ID','N',0),('20.38.15.165','2024-05-17 20:35:44','2024-05-17 20:35:44',3,'A','US','N',0),('66.249.65.6','2024-05-17 22:12:17','2024-05-17 22:12:17',1,'A','US','N',0),('205.210.31.139','2024-05-17 23:43:20','2024-05-17 23:43:20',1,'A','US','N',0),('47.128.126.146','2024-05-18 03:08:32','2024-05-18 03:08:32',1,'A','SG','N',0),('198.235.24.151','2024-05-18 05:35:06','2024-05-18 05:35:06',1,'A','US','N',0),('182.253.54.134','2024-05-18 10:10:06','2024-05-18 10:10:06',3,'A','ID','N',0),('44.222.104.206','2024-05-18 11:30:50','2024-05-18 12:05:59',1,'A','US','N',0),('182.253.57.50','2024-05-18 11:46:07','2024-05-18 20:29:25',3,'A','ID','N',0),('159.203.43.58','2024-05-18 12:20:27','2024-05-18 12:20:27',1,'A','CA','N',0),('159.192.42.224','2024-05-18 12:51:25','2024-05-19 09:52:49',2,'A','TH','N',0),('31.13.115.116','2024-05-18 14:54:53','2024-05-18 14:54:53',2,'A','SE','N',0),('31.13.115.117','2024-05-18 14:54:56','2024-05-18 14:54:56',1,'A','SE','N',0),('31.13.115.3','2024-05-18 14:55:20','2024-05-18 14:55:20',2,'A','SE','N',0),('31.13.115.6','2024-05-18 14:55:23','2024-05-18 14:55:23',1,'A','SE','N',0),('198.235.24.214','2024-05-18 15:40:46','2024-05-18 15:40:46',1,'A','US','N',0),('47.128.42.112','2024-05-18 20:21:10','2024-05-18 20:21:10',1,'A','SG','N',0),('82.64.131.184','2024-05-19 04:04:41','2024-05-19 04:04:41',2,'A','FR','N',0),('159.192.43.50','2024-05-19 10:35:17','2024-05-19 15:16:47',2,'A','TH','N',0);
/*!40000 ALTER TABLE `iplist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knowledge`
--

DROP TABLE IF EXISTS `knowledge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `knowledge` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug_id` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `cat_id` int unsigned NOT NULL DEFAULT '0',
  `title` char(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `k_body` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'textarea',
  `v_count` int unsigned NOT NULL DEFAULT '0' COMMENT 'View Count',
  `l_count` int NOT NULL DEFAULT '0' COMMENT 'like count',
  `d_count` int NOT NULL DEFAULT '0' COMMENT 'dislike count',
  `is_stickey` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `added_by` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'FK(app_user,id,title)',
  `k_tag` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `k_soundex` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `entry_time` timestamp NULL DEFAULT NULL,
  `featured_video_link` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `last_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'U' COMMENT 'bool(P=Publish,U=Unpublish)',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `is_stickey_status` (`is_stickey`,`status`) USING BTREE,
  KEY `slug_id` (`slug_id`) USING BTREE,
  FULLTEXT KEY `src_key` (`title`,`k_body`,`k_tag`,`k_soundex`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knowledge`
--

LOCK TABLES `knowledge` WRITE;
/*!40000 ALTER TABLE `knowledge` DISABLE KEYS */;
INSERT INTO `knowledge` VALUES (2,'install-uploadfly',2,'Install Uploadfly','<p>To install the app it\'s very easy just follow this step<ol><li>Get the app from the Shopify app store here :</li><li>Click install and follow the step</li><li>Select your plan subscription that suits your need</li><li>it will bring you to the global setting and you can save the setting as default when adding the product.</li><li>now enable the upload button by going to the product list.</li><li>installation is complete if you have any questions let us know it we will be happy to help you.</li></ol><p></p></p>',8,0,0,'N','AA','How To Install,Installation,Uploadfly','I523 U143 H352','2024-02-02 12:43:36','https://youtu.be/ccu6JuC21rk?si=WfJJXL3m-ZGjwZ3-','2024-05-19 02:42:52','P'),(5,'what-is-uploadfly',1,'What is uploadfly','<p>Uploadfly is an app that is available for Shopify only at the moment, we will expand this in the future to other platforms such as Etsy, Big Commerce, etc.<br>Uploadfly is the name of the app used to upload any file for the Shopify store, with easy configuration, you can upload multiple files at the same time, or have additional price charges and also conditional logic.<p><br></p></p>',3,0,0,'N','AA','uploadfly,shopify upload file','W321 W300 I200 U143 S111 G564','2024-02-02 13:44:23','','2024-05-19 02:39:27','P'),(3,'uninstallation',2,'Uninstallation','<p><b>How To Uninstall or remove the app?</b><p>To remove the app it\'s very simple, please go to the app and select uploadlfy and see a pinned icon on the right top side and click it<br><br><img src=\"https://help.imakecustom.com/data/knowledge/uninstall1.png\" style=\"width: 1654.25px;\"><br></p><p><br>next select uninstall it will remove the app and cancel your subscription<br><br><img src=\"https://help.imakecustom.com/data/knowledge/uninstall2.png\" style=\"width: 1654.25px;\"><br></p><p><br>Uninstallation complete.<br><br><b>or you can go to the settings and select apps<br></b><br><img src=\"https://help.imakecustom.com/data/knowledge/uninstall3.png\" style=\"width: 694.25px;\"><br></p><p><br></p><p><b>Next, select the Apps and Sales Channels menu<br></b><br><img src=\"https://help.imakecustom.com/data/knowledge/uninstall4.png\" style=\"width: 694.25px;\"><br></p><p><br><b>after selecting the menu it will bring you to the app list and click 3 dots icon&nbsp;<br></b><br><img src=\"https://help.imakecustom.com/data/knowledge/uninstall5.png\" style=\"width: 694.25px;\"><br>&nbsp;<br><b>and select uninstall, it will remove the app from your store including your subscription<br></b><br><img src=\"https://help.imakecustom.com/data/knowledge/uninstall6.png\" style=\"width: 694.25px;\"><br></p></p>',3,0,0,'N','AA','Uninstall,Remove App,Unsubcribe,Uploadfly','U552 R511 U521 U143 I523','2024-02-02 13:32:41','','2024-05-19 02:34:18','P'),(4,'upgrade-or-downgrade-plan-/-package',2,'Upgrade or Downgrade Plan / Package','<p>How To Upgrade or Downgrade Plan / Package:<ol><li>Select the dashboard menu and select your plan upgrade or downgrade</li><li>Select the plan you want to choose</li><li>next, approve it</li><li>all step is done if still does not reflect what you need let us know.</li></ol><p></p></p>',4,0,0,'N','AA','Upgrade Plan,Downgrade Plan,Upgrade Package,Downgrade Package,Uploadfly','U126 O600 D526 P450 0000 P220 U143 I523','2024-02-02 13:38:45','','2024-05-19 09:52:03','P'),(6,'how-to-enable-the-upload-button',17,'How to enable the upload button','<p>To enable the upload button for your product there are 3 ways for that: Import from Shopify products, bulk import, and inside the Uploadfly app.<br><br><b>1. Import from Shopify products:&nbsp;</b>Select your product from your Shopify list inside that product select the more action button and choose Uploadfly, it will automatically enable the upload button for your product, and bring you to the inside of the app to set the upload field.<br><br><img src=\"https://help.imakecustom.com/data/knowledge/import.png\" style=\"width: 599px;\"><br><br><br><b>2. Bulk import:</b> For bulk import go to your Shopify product menu and inside the product, we can see all products now select the product that you want to have an upload field. after you select the product now click the 3 dots icon on the right near the set as draft and select Uploadfly, it will automatically enable the upload field.<br>&nbsp;<img src=\"https://help.imakecustom.com/data/knowledge/import1.png\" style=\"width: 599px;\"><p><br></p><p><b>3.&nbsp;inside the Uploadfly app: </b>click the Apps menu select Uploadfly and choose products, after clicking the products menu we can see a list of our products, to enable the upload field just click the plus icon.</p><p><br></p><p><img src=\"https://help.imakecustom.com/data/knowledge/import2.png\" style=\"width: 599px;\"><br><br>To check the option that we have for the upload field you only need to click the product name it will bring you to the product upload option area.</p><p><br></p><p><br></p></p>',7,0,0,'N','AA','Enabling Upload Button,Setting Product Upload,Uploadfly','H351 H000 T000 E514 U143 B350 S352 P632','2024-02-02 13:45:28','','2024-05-19 12:12:49','P'),(9,'general-setting',4,'General Setting','<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.&nbsp;<p><img src=\"https://help.imakecustom.com/data/knowledge/general%20setting.png\" style=\"width: 693.5px;\"></p><p><br></p><p>in the general setting, there are 2 areas left side and right side</p><p><br></p><p><img src=\"https://help.imakecustom.com/data/knowledge/left%20and%20right.png\" style=\"width: 693.5px;\"><br></p><p><br></p><p><b>1. left side&nbsp;</b></p><p><b>Label button:&nbsp;</b>for the upload field, you can disable or enable if you disable this label button it will not be visible in the front end but if you enable it, it will be visible in the front area.<br>The default label, after installation, is Upload file you can change it to any word you want.<br><br><img src=\"https://help.imakecustom.com/data/knowledge/upload1.png\" style=\"width: 492px;\"></p><p><b>Upload option: </b>this area used has a few settings that affect the upload button file that is: A list of allowed files to be uploaded, the size of the file, the field required, preview, and image dimension.<br>&nbsp;</p><p><img src=\"https://help.imakecustom.com/data/knowledge/upload%20option.png\" style=\"width: 479px;\"><br><br><b>- Allowed file: </b>this area is used to limit or unlimited what kind of file can be uploaded by the customer, by default we allow all files without any expectation. but you can change it by yourself.<br><br><b>- Required: </b>if we enable this option that means the customer must upload their file, by default this button is disabled, which means the customer can upload or not their file.<br><br>- <b>Preview Upload: </b>by default of the app there is no preview of the file after the customer uploads the file, but you can enable it if you need your customer can preview the file that has been uploaded, this feature is currently only limited to the image file, but no worry soon we will add preview for document and video also audio.<br></p><p><b>- Max File Limit: </b>by default the max file should be 100 MB, you can increase it to the max file of the plan you subscribe or you can reduce the max file to any size you need.</p><p><b>- Image dimension: </b>this feature is only available for image files. you can limit the file based on the width, height, or DPI you need, if you are unsure just put 0.<br><br><b>Add more upload button: </b>this button is used if you need more upload fields just click it and the setting will be the same as before, you can create the button unlimited.<br><br><img src=\"https://help.imakecustom.com/data/knowledge/add%20more.png\" style=\"width: 484px;\"><br><br><br><span style=\"font-weight: 700;\">2. Right side</span></p><p>In the right side area general setting, there are 3 menus: Button theme, Custom CSS, and Advanced setting.<br><br><b>Button Theme: </b>we prepared 5 styles of buttons you can use for your store, to activate the button just need to select the option button 1, button 2 or any button then save.<br><br><img src=\"https://help.imakecustom.com/data/knowledge/button%20style.png\" style=\"width: 405px;\"><br><br><b>Custom CSS: </b>a<b>&nbsp;</b>custom CSS area used for someone who understands CSS styling language they can customize the button by inputting the CSS syntax inside that area and saving it.<br><br><img src=\"https://help.imakecustom.com/data/knowledge/custom%20css.png\" style=\"width: 413px;\"><br><br><b>Advanced setting: </b>inside the advanced setting there are allowed file types to upload and Warning messages.<br><b>-&nbsp;</b><span style=\"white-space-collapse: preserve;\"><b>Allowed file extension: </b>you check what kind of type is allowed to be uploaded by your customer but if there is some list not in there you can add the type of file by inputting the type of file name inside the box.</span></p><p><span style=\"white-space-collapse: preserve;\">\r\n</span><img src=\"https://help.imakecustom.com/data/knowledge/input%20file.png\" style=\"width: 399px;\"><span style=\"white-space-collapse: preserve;\"><br></span></p><p><span style=\"white-space-collapse: preserve;\">Typing the file name extension for sample font.ttf just put ttf without. inside the box and press the space on your keyboard. you can categorize the file by the name that we prepared.\r\n</span></p><p><span style=\"white-space-collapse: preserve;\"><b>- Message Warning: </b>if you need a custom message warning you can change it here, you can change it to any language you need.\r\n\r\n</span><img src=\"https://help.imakecustom.com/data/knowledge/warning.png\" style=\"width: 440px;\"><span style=\"white-space-collapse: preserve;\"><b>\r\n</b>\r\n\r\n<b>Note: </b>all settings in the general setting menu will be applied to the new product that is added after the setting, for the old product will use the old setting, if you need to apply all settings to the old or newest product please press the apply for all button.</span></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p></p>',4,0,0,'N','AA','Setting,General Setting,Global Setting,Default Setting,Uploadfly','G564 S352 G414 D143 U143','2024-02-02 16:34:39','','2024-05-19 11:57:11','P'),(17,'files-order',7,'Files Order','<p>To get the file uploaded by the customer you can go to the Uploadfly app and select files menus. in the files area, we can see all files that have been uploaded by the customer, you can easily download the file by clicking the download icon.<p><img src=\"https://help.imakecustom.com/data/knowledge/file%20order.png\" style=\"width: 599px;\"><br></p><p>Inside the menu, there is a search menu, date, list of file orders, and download and delete icon.</p><p><b>- Search: </b>you can search by an order number, name of the customer, and product name.<br><b>- Date: </b>you can filter the order by selecting the date the first date will be your starter date and the second date is the last date you want to sort.<br><b>- List of file orders: </b>this area shows all your orders from your customers after they check out the order.<br><b>- Download: </b>the file can be downloaded from the download icon.<br><b>- Delete: </b>you can click the recycle bin icon to delete the files from your order files area.<br><br><br></p><p><br></p></p>',0,0,0,'N','AA','Files,Order Files,Order,Uploadfly','F426 F420 O636 U143','2024-05-19 12:21:03','','2024-05-19 13:09:15','P'),(18,'how-to-get-support',1,'How to get support','<p>If you have any questions or need help you can go to the support menu inside the app, you can find knowledgebase, articles, news, or FAQ, including the ticket.<p><br></p><p><br></p></p>',0,0,0,'N','AA','FAQ,KB,Knowlegebase,Support,Ticket','H323 H000 T000 G300 S163 F200 K100 K542 T230 U143 G564','2024-05-19 13:12:49','','2024-05-19 13:13:10','P'),(19,'dashboard-overview',1,'Dashboard Overview','<p>In the dashboard area, you can get information about whether the app is already installed or not, including all details about how many products were added to Uploadfly, the total orders you get, your current plan, and support<p>At the bottom, you will see our latest news, knowledge base, and tutorials.</p><p><img src=\"https://help.imakecustom.com/data/knowledge/dashboard.png\" style=\"width: 599px;\"><br></p></p>',0,0,0,'N','AA','Dashboard,Subscribe plan,Support','D216 O161 S126 S163 U143 G564','2024-05-19 15:03:54','','2024-05-19 15:03:54','P');
/*!40000 ALTER TABLE `knowledge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int unsigned NOT NULL DEFAULT '0',
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `href_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'L' COMMENT 'radio(L=Link, P=Page)',
  `href` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'textarea',
  `text_icon` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `view_counter` int unsigned NOT NULL DEFAULT '0',
  `is_new_window` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (2,0,'Our App','L','http://imakecustom.com','fa-external-link',0,'Y','I');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notice` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `msg` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT 'textarea',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `msg_for` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'B' COMMENT 'radio(B=Both, S=Site,A=Admin Panel)',
  `added_by` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` VALUES (1,'Test Announcement','<p>App Open</p>','2024-02-02','2024-02-09','B','AA','2024-02-02 11:41:01','A'),(2,'Libur Hari Raya','<p>Kami akan libur dua hari selama idul fitri</p>','2024-04-30','2024-05-01','B','AA','2024-04-30 11:23:18','A');
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_list`
--

DROP TABLE IF EXISTS `page_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_list` (
  `res_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `controller_title` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `directory` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `controller` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `method` char(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `panel` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'DROP(A=Admin,C=Customer)',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'A=Active, I=Inactive',
  PRIMARY KEY (`res_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_list`
--

LOCK TABLES `page_list` WRITE;
/*!40000 ALTER TABLE `page_list` DISABLE KEYS */;
INSERT INTO `page_list` VALUES ('AA','Role  List','05. User Settings','admin','app-permission','role-list','A','A'),('AB','Role Access','05. User Settings','admin','app-permission','role-access','A','A'),('AC','New Role','05. User Settings','admin','app-permission','role-add','A','A'),('AD','Edit Role','05. User Settings','admin','app-permission','role-edit','A','A'),('AE','Change Role Access','05. User Settings','admin','app-permission-confirm','change-role-access','A','A'),('AF','Resource','05. User Settings','admin','app-permission','change-page-title','A','H'),('AG','Setting List','App Setting','admin','app-setting','index','A','H'),('AH','New Setting','App Setting','admin','app-setting','add','A','H'),('AI','User List','05. User Settings','admin','app-permission','user-list','A','A'),('AJ','Dashboard','08. My Dashboard','admin','dashboard','index','A','S'),('AK','Update User','05. User Settings','admin','app-permission','add-edit-appuser','A','A'),('AL','Category List','12. Category','admin','category','index','A','A'),('AM','New Category','12. Category','admin','category','add','A','A'),('AN','Edit Category','12. Category','admin','category','edit','A','A'),('AO','Status Change','12. Category','admin','category-confirm','status-change','A','A'),('AP','Knowledge List','11. Knowledge','admin','knowledge','index','A','A'),('AQ','New Knowledge','11. Knowledge','admin','knowledge','add','A','A'),('AR','Ticket List','10. Ticket','admin','ticket','index','A','A'),('AS','New Ticket','10. Ticket','admin','ticket','add','A','H'),('AT','Role Delete','05. User Settings','admin','app-permission-confirm','role-delete','A','A'),('AU','Edit Knowledge','11. Knowledge','admin','knowledge','edit','A','A'),('AV','Status Change','11. Knowledge','admin','knowledge-confirm','status-change','A','A'),('AW','Index','Site','','site','index','C','A'),('AX','Not Found','Site','','site','knowledge','C','A'),('AY','About Support System','Knowledge','','knowledge','details','C','A'),('AZ','Counter','Knowledge','','knowledge','counter','C','A'),('BA','Index','Hauth','','hauth','index','C','A'),('BB','Window','Hauth','','hauth','window','C','A'),('BC','Endpoint','Hauth','','hauth','endpoint','C','A'),('BD','Index','Social','','social','index','C','A'),('BE','Login','Social','','social','login','C','A'),('BF','Endpoint','Social','','social','endpoint','C','A'),('BG','Social Login Error','Social','','social','login-error','C','A'),('BH','Client List','14. Client','admin','client','index','A','A'),('BI','New Client','14. Client','admin','client','add','A','A'),('BJ','Index','Test','','test','index','C','A'),('BK','General Settings','02. Admin Setting','admin','admin-setting','general','A','A'),('BL','General','02. Admin Setting','admin','admin-setting-confirm','general','A','A'),('BM','S Auto Load Change','App Setting','admin','app-setting-confirm','s-auto-load-change','A','S'),('BN','Edit Setting','App Setting','admin','app-setting','edit','A','H'),('BO','Modify','02. Admin Setting','admin','admin-setting-confirm','modify','A','A'),('BP','New Ticket','Ticket','','ticket','open','C','A'),('BQ','New Ticket','Ticket','','ticket','open','C','A'),('BR','Other API Settings','03. API Setting','admin','api-setting','api','A','A'),('BS','Custom Field List','02. Admin Setting','admin','custom-field','index','A','A'),('BT','New Custom Field','02. Admin Setting','admin','custom-field','add','A','A'),('BU','Edit Custom Field','02. Admin Setting','admin','custom-field','edit','A','A'),('BV','Modify','03. API Setting','admin','api-setting-confirm','modify','A','S'),('BW','Envato Setting','03. API Setting','admin','api-setting','process-api','A','S'),('BX','Status Change','02. Admin Setting','admin','custom-field-confirm','status-change','A','A'),('BY','Api Check','Ticket','','ticket','api-check','C','A'),('BZ','Custom Field Delete','02. Admin Setting','admin','custom-field-confirm','custom-field-delete','A','A'),('CA','Category Delete','12. Category','admin','category-confirm','category-delete','A','A'),('CB','Index','Test','','test','index','C','A'),('CC','Ticket Open By Guest','Ticket','','ticket','opened','C','A'),('CD','My Tickets','Panel','client','panel','dashboard','C','A'),('CE','Ticket Tmp Img','Ticket','','ticket','ticket-tmp-img','C','A'),('CF','My Tickets','Panel','client','panel','profile','C','A'),('CG','Active Ticket','Ticket','','ticket','active-tickets','C','A'),('CH','Close Ticket','Ticket','','ticket','closed-tickets','C','A'),('CI','Ticket Details','Ticket','','ticket','details','C','A'),('CJ','Ticket Img','Ticket','','ticket','ticket-img','C','A'),('CK','Field Deatils','Ticket','','ticket','field-deatils','C','A'),('CL','Field Details','Ticket','','ticket','field-details','C','A'),('CM','Ticket Reply','Ticket','','ticket-confirm','ticket-reply','C','A'),('CN','Re Open','Ticket','','ticket','re-open','C','A'),('CO','Ticket Replied File','Ticket','','ticket','ticket-replied-file','C','A'),('CP','Edit Ticket','10. Ticket','admin','ticket','edit','A','H'),('CQ','Ticket Delete','10. Ticket','admin','ticket-confirm','ticket-delete','A','A'),('CR','Closed Ticket List','10. Ticket','admin','ticket','closed-ticket','A','A'),('CS','Assign Ticket','10. Ticket','admin','ticket','set-assign','A','A'),('CT','Assign Me','10. Ticket','admin','ticket-confirm','assign-me','A','A'),('CU','Paypal Settings','03. API Setting','admin','api-setting','paypal-setting','A','A'),('CV','Update Paypal','03. API Setting','admin','api-setting-confirm','update-paypal','A','S'),('CW','Social Settings','03. API Setting','admin','api-setting','social-setting','A','A'),('CX','Update Social','03. API Setting','admin','api-setting-confirm','update-social','A','S'),('CY','Email To Ticket Settings','02. Admin Setting','admin','admin-setting','imap','A','A'),('CZ','Email To Ticket','Cron','autoscript','cron','email-to-ticket','C','A'),('DA','Email Templates List','02. Admin Setting','admin','email-templates','index','A','A'),('DB','Update Email Template','02. Admin Setting','admin','email-templates','edit','A','A'),('DC','Status Change','02. Admin Setting','admin','email-templates-confirm','status-change','A','A'),('DD','User Ticket','Ticket','','ticket','user-ticket','C','A'),('DE','Guest Ticket','Ticket','','ticket','guest-ticket','C','A'),('DF','Email Outgoing Settings','02. Admin Setting','admin','admin-setting','email-out-settings','A','A'),('DG','Debug Log List','07. App Information','admin','debug-log','index','A','A'),('DH','Details Debug Log','07. App Information','admin','debug-log','view-dtls','A','A'),('DI','Process','Cron','autoscript','cron','process','C','A'),('DJ','Edit Client','14. Client','admin','client','edit','A','A'),('DK','Ticket Payment','Ticket','','ticket','ticket-payment','C','A'),('DL','Paypal Payment Process','Ticket','','ticket','paypal-payment-process','C','A'),('DM','System Update Process','07. App Information','admin','system-update','update','A','H'),('DN','Application Update Info','07. App Information','admin','system-update','index','A','A'),('DO','License Details','07. App Information','admin','License','index','A','A'),('DP','Enter License Info','07. App Information','admin','license','update','A','S'),('DQ','Remove License Button','07. App Information','admin','license','remove','A','A'),('DR','Ticket Details','10. Ticket','admin','ticket','details','A','S'),('DS','Ticket Reply','10. Ticket','admin','ticket-confirm','ticket-reply','A','A'),('DT','Knowledge List','Knowledge','','knowledge','index','C','A'),('DU','Change Category','10. Ticket','admin','ticket','change-category','A','S'),('DV','Menu List','02. Admin Setting','admin','menu','index','A','A'),('DW','New Menu','02. Admin Setting','admin','menu','add','A','A'),('DX','Menu Status Change','02. Admin Setting','admin','menu-confirm','status-change','A','A'),('DY','Edit Menu','02. Admin Setting','admin','menu','edit','A','A'),('DZ','Menu Delete','02. Admin Setting','admin','menu-confirm','menu-delete','A','A'),('EA','New Window Status Change','02. Admin Setting','admin','menu-confirm','is-new-window-change','A','A'),('EB','Topbar Icon List','02. Admin Setting','admin','topbar-icon','index','A','A'),('EC','New Topbar Icon','02. Admin Setting','admin','topbar-icon','add','A','A'),('ED','Topbar Icon Delete','02. Admin Setting','admin','topbar-icon-confirm','topbar-icon-delete','A','A'),('EE','Topbar Icon Status Change','02. Admin Setting','admin','topbar-icon-confirm','status-change','A','A'),('EF','Edit Topbar Icon','02. Admin Setting','admin','topbar-icon','edit','A','A'),('EG','Search','Site','','site','search','C','A'),('EH','Search Result','Knowledge','','knowledge','search-result','C','A'),('EI','IP List','02. Admin Setting','admin','iplist','index','A','A'),('EJ','New IP Entry','02. Admin Setting','admin','iplist','add','A','A'),('EK','Ipblock','App Secuity','','App-secuity','ipblock','C','A'),('EL','Support System','App Security','','App-security','ipblock','C','A'),('EM','Ipblock','Site Security','','site-security','ipblock','C','A'),('EN','My Ticket List','10. Ticket','admin','ticket','my-ticket','A','S'),('EO','My Closed Ticket','10. Ticket','admin','ticket','my-closed','A','S'),('EP','Security Settings','02. Admin Setting','admin','admin-setting','security','A','A'),('EQ','Modify Security','02. Admin Setting','admin','admin-setting-confirm','modify-security','A','A'),('ER','Locked User List','02. Admin Setting','admin','locked-user','index','A','A'),('ES','Unlock Admin User','02. Admin Setting','admin','locked-user-confirm','locked-user-delete','A','A'),('ET','Edit IP','02. Admin Setting','admin','iplist','edit','A','A'),('EU','Block IP Reset','02. Admin Setting','admin','iplist-confirm','iplist-reset','A','A'),('EV','System Message Dismiss','16.  System Message','admin','system-msg-confirm','system-msg-dismiss','A','A'),('EW','Viewed','Notification','admin','notification','viewed','A','S'),('EX','Announcements List','09. Announcements','admin','notice','index','A','A'),('EY','New Announcements','09. Announcements','admin','notice','add','A','A'),('EZ','Edit Announcements','09. Announcements','admin','notice','edit','A','A'),('FA','Admin Message List','15. Message','admin','admin-message','index','A','S'),('FB','New Admin Message','15. Message','admin','admin-message','add','A','S'),('FC','Sent Message By Me','15. Message','admin','admin-message','sent','A','S'),('FD','Edit Admin Message','15. Message','admin','admin-message','edit','A','A'),('FE','Announcements Status Change','09. Announcements','admin','notice-confirm','status-change','A','A'),('FF','New Email Templates','02. Admin Setting','admin','email-templates','add','A','H'),('FG','Details','15. Message','admin','admin-message','details','A','S'),('FH','Reply','15. Message','admin','admin-message-confirm','reply','A','S'),('FI','Show','Notification','admin','notification','show','A','S'),('FJ','Notification List','Notification','admin','notification','show-list','A','S'),('FK','Change User Status','05. User Settings','admin','app-permission-confirm','change-user-status','A','A'),('FL','Reset User Pass','05. User Settings','admin','app-permission-confirm','reset-user-pass','A','A'),('FM','Application Update Process','07. App Information','admin','system-update','process-update','A','A'),('FN','System Updating','07. App Information','admin','system-update','updating','A','S'),('FO','Test','07. App Information','admin','system-update','test','A','H'),('FP','Feedback','Ticket','','ticket','feedback','C','A'),('FQ','Re Open','10. Ticket','admin','ticket','re-open','A','A'),('FR','Knowledge List','Category','','category','index','C','A'),('FS','Not Found','Category','','category','details','C','A'),('FT','Theme Settings','02. Admin Setting','admin','admin-setting','theme','A','A'),('FU','Modify Theme','02. Admin Setting','admin','admin-setting-confirm','modify-theme','A','A'),('FV','Upload','Image Upload','admin','image-upload','upload','A','S'),('FW','Manager','Image Upload','admin','image-upload','manager','A','S'),('FX','Delete','Image Upload','admin','image-upload','delete','A','S'),('FY','Delete Feature','11. Knowledge','admin','knowledge-confirm','delete-feature','A','S'),('FZ','My Paid Ticket','10. Ticket','admin','ticket','my-paid-ticket','A','S'),('GA','All Paid Ticket','10. Ticket','admin','ticket','all-paid-ticket','A','A'),('GB','My Assigned All Tickets','10. Ticket','admin','ticket','my-assigned-ticket','A','A'),('GC','Server Requirment Failed','Server Requiment','','server-requiment','index','C','A'),('GD','Resource Missmatch','Server Requiment','','server-requiment','resource-missmatch','C','A'),('GE','Change Timezone','08. My Dashboard','admin','dashboard','set-timezone','A','S'),('GF','Macros Msg List','13. Canned Msg','admin','canned-msg','index','A','A'),('GG','New Macros Msg','13. Canned Msg','admin','canned-msg','add','A','A'),('GH','Edit Macros Message','13. Canned Msg','admin','canned-msg','edit','A','A'),('GI','Macros Msg Delete','13. Canned Msg','admin','canned-msg-confirm','canned-msg-delete','A','A'),('GJ','Admin Dashboard','01. Admin Report','admin','admin-report','index','A','A'),('GK','All Unassigned All Tickets','10. Ticket','admin','ticket','unassigned-ticket','A','A'),('GL','Ticket Payment List','04. Payment List','admin','ticket-payment','index','A','A'),('GM','Ticket Payment Details','04. Payment List','admin','ticket-payment','details','A','A'),('GN','Ticket Feedback List','06. Ticket Feedback','admin','ticket-feedback','index','A','A'),('GO','Details Info Of IP','02. Admin Setting','admin','iplist','detials','A','S'),('GP','Sort Menu','05. User Settings','admin','app-permission','sort-controller-title','A','H'),('GQ','Copy Role Access','05. User Settings','admin','app-permission','copy-access','A','A'),('GR','Reset Role Access','05. User Settings','admin','app-permission','reset-access','A','A'),('GS','Ticket Replied File','Ticket','admin','ticket','ticket-replied-file','A','S'),('GT','Is Stickey/Pinned Status Change','11. Knowledge','admin','knowledge-confirm','is-stickey-change','A','A'),('GU','Re Check','System Update','admin','system-update','re-check','A','S'),('GV','Status Change','13. Canned Msg','admin','canned-msg-confirm','status-change','A','A'),('GW','Admin Notification Settings','02. Admin Setting','admin','admin-setting','notification','A','A'),('GX','Modify Notification','Admin Setting Confirm','admin','admin-setting-confirm','modify-notification','A','S'),('GY','Notification','Dashboard','admin','dashboard','notification','A','S'),('HF','Client Profile','Client','admin','client','profile','A','S'),('HG','Ticket Img','Ticket','admin','ticket','ticket-img','A','S'),('HN','Set User Password','05. User Settings','admin','app-permission','set-user-pass','A','S'),('HO','WebChat Panel','17. Web Chat','admin','admin-chat','index','A','A'),('HP','Chat Response','17. Web Chat','admin','admin-chat','chat-response','A','S'),('HQ','User Chat Close','17. Web Chat','admin','admin-chat-confirm','user-chat-close','A','S'),('HR','User Answer','17. Web Chat','admin','admin-chat-confirm','user-answer','A','S'),('HS','Edit Chat Macros Message','17. Web Chat','admin','chat-canned-msg','edit','A','A'),('HT','New Chat Macros Msg','17. Web Chat','admin','chat-canned-msg','add','A','A'),('HU','Chat Macros Msg List','17. Web Chat','admin','chat-canned-msg','index','A','A'),('HV','New Admin Note','Admin Note','admin','admin-note','add','A','S'),('HW','Get Notes','Admin Note','admin','admin-note','get-notes','A','S'),('HX','Chat Settings','02. Admin Setting','admin','admin-setting','webchat-settings','A','A'),('HY','Reset User Pass','14. Client','admin','client-confirm','reset-user-pass','A','A'),('HZ','Update Chat Status','Dashboard','admin','dashboard','update-chat-status','A','S'),('IA','Update Notification Trey','Dashboard','admin','dashboard','update-notification-trey','A','S'),('IB','Delete Attach File','11. Knowledge','admin','knowledge-confirm','del-attach-file','A','A'),('IC','Edit Ticket Reply','10. Ticket','admin','ticket','edit-reply','A','S'),('ID','Load Ticket Reply','10. Ticket','admin','ticket','load-ticket-reply','A','S'),('IE','Ticket Open By Admin','10. Ticket','admin','ticket','opened','A','S'),('IF','Admin Ticket Creation','10. Ticket','admin','ticket','open','A','A'),('IG','Ticket Assign Rule List','17. Ticket Assign Rule','admin','ticket-assign-rule','index','A','A'),('IH','Edit Ticket Assign Rule','17. Ticket Assign Rule','admin','ticket-assign-rule','edit','A','A'),('II','New Ticket Assign Rule','17. Ticket Assign Rule','admin','ticket-assign-rule','add','A','A'),('IJ','17. Ticket Assign Rule','17. Ticket Assign Rule','admin','ticket-assign-rule-confirm','ticket-assign-rule-delete','A','A'),('IK','Status Change','17. Ticket Assign Rule','admin','ticket-assign-rule-confirm','status-change','A','A'),('IL','Rate It','System Update','admin','system-update','rate-it','A','S'),('IM','Rate Status','System Update','admin','system-update','rate-status','A','S'),('IN','Please Rate It !!','System Update','admin','system-update','thank-you','A','S'),('IO','Remote Login List','03. API Setting','admin','remote-server','index','A','A'),('IP','New Remote Login','03. API Setting','admin','remote-server','add','A','A'),('IQ','Edit Remote Login','03. API Setting','admin','remote-server','edit','A','A'),('IR','Delete Remote Login','03. API Setting','admin','remote-server-confirm','remote-server-delete','A','A'),('IS','Remote Login Status Change','03. API Setting','admin','remote-server-confirm','status-change','A','A'),('JE','New Work Log','10. Ticket','admin','work-log','add','A','S'),('JF','Get Notes','10. Ticket','admin','work-log','get-notes','A','S'),('JG','FAQ List','18. FAQ','admin','faq-lis','index','A','A'),('JH','FAQ Add','18. FAQ','admin','faq-lis','add','A','A'),('JI','FAQ edit','18. FAQ','admin','faq-lis','edit','A','A'),('JJ','FAQ Category List','18. FAQ','admin','faq-category','index','A','A'),('JK','FAQ Category Add','18. FAQ','admin','faq-category','add','A','A'),('JL','FAQ Category Edit','18. FAQ','admin','faq-category','edit','A','A'),('JM','FAQ Category Status Change','18. FAQ','admin','faq-category-confirm','status-change','A','A'),('JN','Testimonial List','19. Testimonial','admin','testimonial','index','A','A'),('JO','Testimonial Add','19. Testimonial','admin','testimonial','add','A','A'),('JP','Testimonial Edit','19. Testimonial','admin','testimonial','edit','A','A'),('JQ','Testimonial Status Change','19. Testimonial','admin','testimonial-confirm','status-change','A','A'),('JR','Admin Addons page','19. Admin Addons page','admin','addons','admin-page','A','S'),('JS','Update Payment Basic','3. payment Settings','admin','api-setting-confirm','update-payment-basic','A','S'),('JT','Basic Settings','03. Payment Setting','admin','api-setting','payment-basic','A','A'),('JU','Change Priority','10. Ticket','admin','ticket','change-priority','A','S'),('JV','Close Ticket Without Reply','10. Ticket','admin','ticket-confirm','close-ticket','A','S');
/*!40000 ALTER TABLE `page_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_log`
--

DROP TABLE IF EXISTS `payment_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_log` (
  `payment_id` char(14) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `ticket_payment_id` int NOT NULL DEFAULT '0',
  `amount_cr` decimal(5,2) NOT NULL DEFAULT '0.00',
  `amount_dr` decimal(5,2) NOT NULL DEFAULT '0.00',
  `first_2_digit` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `last_4_digit` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `transaction_id` char(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `process_time` datetime NOT NULL,
  `transaction_time` char(22) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `update_time` datetime NOT NULL,
  `result` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `result_msg` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `note` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `response_reason` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `transation_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'A=Auth Capture, O=Auth Only, C= Refund Credit, V= Refund Void',
  `paid_by` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'PP' COMMENT 'radio(PP=Paypal, AU=Authorize,ST=Stripe)',
  `pp_payer_email` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'Paypal payer email',
  `name_on_card` char(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `country` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `approval_code` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'Sale Id for PayPal',
  `ref_transaction_id` char(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'For refund Transaction',
  KEY `merchant_id_customer_id` (`ticket_payment_id`) USING BTREE,
  KEY `merchant_id_payment_id` (`payment_id`,`transaction_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_log`
--

LOCK TABLES `payment_log` WRITE;
/*!40000 ALTER TABLE `payment_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `remote_server`
--

DROP TABLE IF EXISTS `remote_server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `remote_server` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `private_key` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `login_url` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'textarea',
  `valid_url` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'textarea',
  `button_text_color` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `button_color` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `button_txt` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `server_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'L' COMMENT 'radio(L=Login Server,F=Field Validation)',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remote_server`
--

LOCK TABLES `remote_server` WRITE;
/*!40000 ALTER TABLE `remote_server` DISABLE KEYS */;
/*!40000 ALTER TABLE `remote_server` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_access`
--

DROP TABLE IF EXISTS `role_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_access` (
  `pvid` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `res_id` char(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'A=Allow, D=Deny',
  UNIQUE KEY `pvid` (`pvid`,`role_id`,`res_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_access`
--

LOCK TABLES `role_access` WRITE;
/*!40000 ALTER TABLE `role_access` DISABLE KEYS */;
INSERT INTO `role_access` VALUES ('AA','R3','AO','Y'),('AA','R3','AN','Y'),('AA','R3','AM','Y'),('AA','R3','AL','Y'),('AA','R3','AV','Y'),('AA','R3','AU','Y'),('AA','R3','AQ','Y'),('AA','R3','AP','Y'),('AA','R3','GA','Y'),('AA','R3','FQ','Y'),('AA','R3','DS','Y'),('AA','R3','BX','Y'),('AA','R3','DB','Y'),('AA','R3','DA','Y'),('AA','R3','CT','Y'),('AA','R3','CS','Y'),('AA','R3','CR','Y'),('AA','R3','AR','Y'),('AA','R3','FE','Y'),('AA','R3','EZ','Y'),('AA','R3','EY','Y'),('AA','R3','EX','Y'),('AA','R3','FM','Y'),('AA','R3','GN','Y'),('AA','R3','AB','Y'),('AA','R4','AK','Y'),('AA','R3','GM','Y'),('AA','R4','AD','Y'),('AA','R3','GL','Y'),('AA','R3','EU','Y'),('AA','R3','ET','Y'),('AA','R3','ES','Y'),('AA','R4','AC','Y'),('AA','R4','AI','Y'),('AA','R4','AB','Y'),('AA','R3','GJ','Y'),('AA','R3','ER','Y'),('AA','R3','EQ','Y'),('AA','R3','EP','Y'),('AA','R3','EV','Y'),('AA','R4','AR','Y'),('AA','R4','CR','Y'),('AA','R4','CS','Y'),('AA','R4','CT','Y'),('AA','R4','DS','Y'),('AA','R4','FQ','Y'),('AA','R4','GA','Y'),('AA','R4','GN','Y'),('AA','R4','GF','Y'),('AA','R4','GG','Y'),('AA','R4','GH','Y'),('AA','R4','GM','N'),('AA','R4','GL','N'),('AA','R3','DJ','Y'),('AA','R3','BI','Y'),('AA','R3','BH','Y'),('AA','R3','GI','Y'),('AA','R3','GH','Y'),('AA','R3','GG','Y'),('AA','R3','GF','Y'),('AA','R3','CA','Y'),('AA','R3','EJ','Y'),('AA','R3','EI','Y'),('AA','R3','EA','Y'),('AA','R3','DX','Y'),('AA','R3','DZ','Y'),('AA','R3','DY','Y'),('AA','R3','DW','Y'),('AA','R3','DV','Y'),('AA','R4','HO','Y'),('AA','R3','HO','Y'),('AA','R4','GB','Y'),('AA','R3','GB','Y'),('AA','R4','GJ','N');
/*!40000 ALTER TABLE `role_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_list`
--

DROP TABLE IF EXISTS `role_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_list` (
  `pv_id` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `display_as` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `grade` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '3' COMMENT '0=supper power, 1>2>3>4....',
  UNIQUE KEY `pv_id` (`pv_id`,`role_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED COMMENT='app_permission,role';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_list`
--

LOCK TABLES `role_list` WRITE;
/*!40000 ALTER TABLE `role_list` DISABLE KEYS */;
INSERT INTO `role_list` VALUES ('AA','R1','Super Admin','','0'),('AA','R3','Supervisor','','5'),('AA','R4','Agent','','5');
/*!40000 ALTER TABLE `role_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_file`
--

DROP TABLE IF EXISTS `sale_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_file` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `key_rand` char(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `extn` char(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `file_name` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_paid` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `amount` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  `total_sold` int unsigned NOT NULL DEFAULT '0',
  `hour_of_avaiable` int unsigned NOT NULL DEFAULT '0',
  `has_expiry` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'Y' COMMENT 'bool(Y=Yes,N=No)',
  `expiry_date` timestamp NULL DEFAULT NULL,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_file`
--

LOCK TABLES `sale_file` WRITE;
/*!40000 ALTER TABLE `sale_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_file_payment_log`
--

DROP TABLE IF EXISTS `sale_file_payment_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_file_payment_log` (
  `payment_id` char(14) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `file_id` int NOT NULL DEFAULT '0',
  `amount_cr` decimal(5,2) NOT NULL DEFAULT '0.00',
  `amount_dr` decimal(5,2) NOT NULL DEFAULT '0.00',
  `first_2_digit` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `last_4_digit` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `transaction_id` char(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `process_time` datetime NOT NULL,
  `transaction_time` char(22) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `update_time` datetime NOT NULL,
  `result` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `result_msg` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `note` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `response_reason` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `transation_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'A=Auth Capture, O=Auth Only, C= Refund Credit, V= Refund Void',
  `paid_by` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'PP' COMMENT 'radio(PP=Paypal, AU=Authorize,ST=Stripe)',
  `pp_payer_email` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'Paypal payer email',
  `name_on_card` char(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `country` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `approval_code` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'Sale Id for PayPal',
  `ref_transaction_id` char(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'For refund Transaction',
  KEY `merchant_id_customer_id` (`file_id`) USING BTREE,
  KEY `merchant_id_payment_id` (`payment_id`,`transaction_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_file_payment_log`
--

LOCK TABLES `sale_file_payment_log` WRITE;
/*!40000 ALTER TABLE `sale_file_payment_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale_file_payment_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_user_file`
--

DROP TABLE IF EXISTS `sale_user_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sale_user_file` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `dl_key` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `payment_id` char(14) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `file_id` int unsigned NOT NULL DEFAULT '0',
  `rand_key` char(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `valid_until` timestamp NULL DEFAULT NULL,
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_user_file`
--

LOCK TABLES `sale_user_file` WRITE;
/*!40000 ALTER TABLE `sale_user_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `sale_user_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_user`
--

DROP TABLE IF EXISTS `site_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `first_name` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_name` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `username` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email` char(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `pass` char(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_verified_email` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `gender` char(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `phone` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `address` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `region` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `city` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `zip` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `country` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `dob` char(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'date of birth',
  `profile_url` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `photo_url` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `age` decimal(2,0) NOT NULL DEFAULT '0',
  `login_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'radio(N=Normal,F=Facebook,T=Twitter,G=Google,L=Linked In)',
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tzone` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_login_time` timestamp NULL DEFAULT NULL,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'drop(A=Active,I=Inactive,L=Locked)',
  `user_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'U' COMMENT 'radio(G=Guest,U=User)',
  `user_social_session_data` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `store_url` varchar(150) DEFAULT NULL,
  `plan` varchar(150) DEFAULT NULL,
  `date_subscribe` date DEFAULT NULL,
  `shop_id` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `email` (`email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC COMMENT='client';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_user`
--

LOCK TABLES `site_user` WRITE;
/*!40000 ALTER TABLE `site_user` DISABLE KEYS */;
INSERT INTO `site_user` VALUES (1,'-','','','emhaku@gmail.com','6046a0a0728f1474ed8771aa45962b7a','N','','','','Bangkok','Bangkok','10200','TH','','','',0,'N','2024-01-18 15:19:50','Asia/Bangkok','2024-01-18 15:19:50','A','G','',NULL,NULL,NULL,NULL),(2,'joni 2','jonis 2','joni','joni@gmail.com','c81e728d9d4c2f636f067f89cc14862c','N','','','','','','','','','','',0,'N','2024-02-06 14:09:43','',NULL,'A','U','',NULL,NULL,NULL,NULL),(3,'joni 2','jonis 2','joni2','joni2@gmail.com','eccbc87e4b5ce2fe28308fd9f2a7baf3','N','','','','','','','','','','',0,'N','2024-02-09 03:53:55','',NULL,'A','U','',NULL,NULL,NULL,NULL),(4,'joni 3','jonis 3','joni3','joni3@gmail.com','a87ff679a2f3e71d9181a67b7542122c','N','','123','','Indonesia','','','','','','',0,'N','2024-03-18 08:59:29','',NULL,'A','U','','https://tes.com','monthly','0000-00-00',1),(5,'quickstart-044cdd31-test','quickstart-044cdd31-test','quickstart-044cdd31','kemzoft85@gmail.com','e4da3b7fbbce2345d7772b0674a318d5','Y','male','-','','Indonesia','','','ID','','','',0,'N','2024-03-18 10:02:48','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(6,'test 3','test 3','test3','test@gmail.com','1679091c5a880faf6fb5e6087eb1b2dc','N','','123','','Indonesia','','','','','','',0,'N','2024-03-18 10:04:51','',NULL,'A','U','','https://tes.com','monthly','0000-00-00',0),(13,'imakecustom-dev-test','imakecustom-dev-test','imakecustom-dev','imakecustom-dev-test@email.com','','N','male','-','','Indonesia','','','ID','','','',0,'N','2024-03-25 11:39:22','',NULL,'A','U','','imakecustom-dev.myshopify.com','monthly','0000-00-00',0),(12,'johan 5','johan','johan 56','johan26gmail.com','','N','','123','','Indonesia','','','','','','',0,'N','2024-03-21 09:29:01','',NULL,'A','U','','https://tes.com','monthly','0000-00-00',0),(11,'johan 4','johan','johan 55','johan25gmail.com','','N','','123','','Indonesia','','','','','','',0,'N','2024-03-21 03:49:46','',NULL,'A','U','','https://tes.com','monthly','0000-00-00',0),(10,'johan 4','johan','johan 44','johan24gmail.com','','N','','123','','Indonesia','','','','','','',0,'N','2024-03-21 03:20:48','',NULL,'A','U','','https://tes.com','monthly','0000-00-00',0),(14,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31_1711526469','quickstart-044cdd31@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:01:09','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(15,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31_1711526599','quickstart-044cdd31_1711526599@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:03:18','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(16,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31_1711526601','quickstart-044cdd31_1711526601@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:03:21','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(17,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31_1711526603','quickstart-044cdd31_1711526603@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:03:23','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(18,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31_1711526606','quickstart-044cdd31_1711526606@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:03:25','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(19,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31_1711526624','quickstart-044cdd31_1711526624@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:03:43','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(20,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31_1711526628','quickstart-044cdd31_1711526628@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:03:47','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(21,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31-aaa','quickstart-044cdd31-aaa@gmail.com','','N','','-','','ID','','','','','','',0,'N','2024-03-27 08:04:15','',NULL,'A','U','','https://quickstart-044cdd31.com','monthly','0000-00-00',0),(22,'quickstart-044cdd31','quickstart-044cdd31','quickstart-044cdd31_1711527167','quickstart-044cdd31_1711527167@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:12:47','',NULL,'A','U','','quickstart-044cdd31.myshopify.com','monthly','0000-00-00',0),(23,'imakecustom-dev','imakecustom-dev','imakecustom-dev_1711529167','imakecustom-dev_1711529167@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-03-27 08:46:07','',NULL,'A','U','','imakecustom-dev.myshopify.com','monthly','0000-00-00',0),(24,'johan 5','johan','johan 57','johan26edgmail.com','','N','','123ed','','Indonesia','','','','','','',0,'N','2024-03-30 13:33:06','',NULL,'A','U','','https://tes-ed.com','platinum','0000-00-00',0),(25,'icustom-template','icustom-template','icustom-template_1712217866','icustom-template_1712217866@imakecustom.com','','N','','-','','Indonesia','','','','','','',0,'N','2024-04-04 08:04:27','',NULL,'A','U','','icustom-template.myshopify.com','monthly','2023-08-01',0);
/*!40000 ALTER TABLE `site_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_user_custom_field`
--

DROP TABLE IF EXISTS `site_user_custom_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_user_custom_field` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `custom_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `fld_title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fld_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'T' COMMENT 'radio(T=Textbox,N=Numeric,D=Dropdown,A=Date,R=Radio)',
  `fld_value` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fld_value_text` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_api_based` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `api_name` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `api_data` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_user_custom_field`
--

LOCK TABLES `site_user_custom_field` WRITE;
/*!40000 ALTER TABLE `site_user_custom_field` DISABLE KEYS */;
INSERT INTO `site_user_custom_field` VALUES (1,5,'AA','Shop ID','T','quickstart-044cdd31-test','quickstart-044cdd31-test','N','',''),(2,5,'AB','Store Url','T','https://quickstart-044cdd31-test.myshopify.com/','https://quickstart-044cdd31-test.myshopify.com/','N','',''),(3,5,'AC','Plan','T','monthly','monthly','N','',''),(4,5,'AD','Country','T','Indonesia','Indonesia','N','',''),(5,5,'AE','Phone','T','-','-','N','',''),(6,9,'AF','AE','T','123','123','N','',''),(7,9,'AG','AD','T','Indonesia','Indonesia','N','',''),(8,9,'AH','AB','T','https://tes.com','https://tes.com','N','',''),(9,9,'AI','AC','T','monthly','monthly','N','',''),(10,9,'AJ','AA','T','jhony_shop','jhony_shop','N','',''),(11,10,'AE','Phone','T','123','123','N','',''),(12,10,'AD','Country','T','Indonesia','Indonesia','N','',''),(13,10,'AB','Store Url','U','https://tes.com','https://tes.com','N','',''),(14,10,'AC','Plan','T','monthly','monthly','N','',''),(15,10,'AA','Shop ID','T','jhony_shop','jhony_shop','N','',''),(16,11,'AE','Phone','T','123','123','N','',''),(17,11,'AD','Country','T','Indonesia','Indonesia','N','',''),(18,11,'AB','Store Url','U','https://tes.com','https://tes.com','N','',''),(19,11,'AC','Plan','T','monthly','monthly','N','',''),(20,11,'AA','Shop ID','T','jhony_shop','jhony_shop','N','',''),(21,12,'AE','Phone','T','123','123','N','',''),(22,12,'AD','Country','T','Indonesia','Indonesia','N','',''),(23,12,'AB','Store Url','U','https://tes.com','https://tes.com','N','',''),(24,12,'AC','Plan','T','monthly','monthly','N','',''),(25,12,'AA','Shop ID','T','jhony_shop','jhony_shop','N','',''),(26,13,'AE','Phone','T','-','-','N','',''),(27,13,'AD','Country','T','Indonesia','Indonesia','N','',''),(28,13,'AB','Store Url','U','https://imakecustom-dev-test.myshopify.com','https://imakecustom-dev-test.myshopify.com','N','',''),(29,13,'AC','Plan','T','monthly','monthly','N','',''),(30,13,'AA','Shop ID','T','imakecustom-dev-test','imakecustom-dev-test','N','',''),(31,14,'AE','Phone','T','-','-','N','',''),(32,14,'AD','Country','T','Indonesia','Indonesia','N','',''),(33,14,'AB','Store Url','U','quickstart-044cdd31.myshopify.com','quickstart-044cdd31.myshopify.com','N','',''),(34,14,'AC','Plan','T','monthly','monthly','N','',''),(35,14,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(36,15,'AE','Phone','T','-','-','N','',''),(37,15,'AD','Country','T','Indonesia','Indonesia','N','',''),(38,15,'AB','Store Url','U','quickstart-044cdd31.myshopify.com','quickstart-044cdd31.myshopify.com','N','',''),(39,15,'AC','Plan','T','monthly','monthly','N','',''),(40,15,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(41,16,'AE','Phone','T','-','-','N','',''),(42,16,'AD','Country','T','Indonesia','Indonesia','N','',''),(43,16,'AB','Store Url','U','quickstart-044cdd31.myshopify.com','quickstart-044cdd31.myshopify.com','N','',''),(44,16,'AC','Plan','T','monthly','monthly','N','',''),(45,16,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(46,17,'AE','Phone','T','-','-','N','',''),(47,17,'AD','Country','T','Indonesia','Indonesia','N','',''),(48,17,'AB','Store Url','U','quickstart-044cdd31.myshopify.com','quickstart-044cdd31.myshopify.com','N','',''),(49,17,'AC','Plan','T','monthly','monthly','N','',''),(50,17,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(51,18,'AE','Phone','T','-','-','N','',''),(52,18,'AD','Country','T','Indonesia','Indonesia','N','',''),(53,18,'AB','Store Url','U','quickstart-044cdd31.myshopify.com','quickstart-044cdd31.myshopify.com','N','',''),(54,18,'AC','Plan','T','monthly','monthly','N','',''),(55,18,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(56,19,'AE','Phone','T','-','-','N','',''),(57,19,'AD','Country','T','Indonesia','Indonesia','N','',''),(58,19,'AB','Store Url','U','quickstart-044cdd31.myshopify.com','quickstart-044cdd31.myshopify.com','N','',''),(59,19,'AC','Plan','T','monthly','monthly','N','',''),(60,19,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(61,20,'AE','Phone','T','-','-','N','',''),(62,20,'AD','Country','T','Indonesia','Indonesia','N','',''),(63,20,'AB','Store Url','U','quickstart-044cdd31.myshopify.com','quickstart-044cdd31.myshopify.com','N','',''),(64,20,'AC','Plan','T','monthly','monthly','N','',''),(65,20,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(66,21,'AE','Phone','T','-','-','N','',''),(67,21,'AD','Country','T','ID','ID','N','',''),(68,21,'AB','Store Url','U','https://quickstart-044cdd31.com','https://quickstart-044cdd31.com','N','',''),(69,21,'AC','Plan','T','monthly','monthly','N','',''),(70,21,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(71,22,'AE','Phone','T','-','-','N','',''),(72,22,'AD','Country','T','Indonesia','Indonesia','N','',''),(73,22,'AB','Store Url','U','quickstart-044cdd31.myshopify.com','quickstart-044cdd31.myshopify.com','N','',''),(74,22,'AC','Plan','T','monthly','monthly','N','',''),(75,22,'AA','Shop ID','T','quickstart-044cdd31','quickstart-044cdd31','N','',''),(76,23,'AE','Phone','T','-','-','N','',''),(77,23,'AD','Country','T','Indonesia','Indonesia','N','',''),(78,23,'AB','Store Url','U','imakecustom-dev.myshopify.com','imakecustom-dev.myshopify.com','N','',''),(79,23,'AC','Plan','T','monthly','monthly','N','',''),(80,23,'AA','Shop ID','T','imakecustom-dev','imakecustom-dev','N','',''),(81,24,'AE','Phone','T','123ed','123ed','N','',''),(82,24,'AD','Country','T','Indonesia','Indonesia','N','',''),(83,24,'AB','Store Url','U','https://tes-ed.com','https://tes-ed.com','N','',''),(84,24,'AC','Plan','T','platinum','platinum','N','',''),(85,24,'AA','Shop ID','T','jhony_shop_ed','jhony_shop_ed','N','',''),(86,25,'AE','Phone','T','-','-','N','',''),(87,25,'AD','Country','T','Indonesia','Indonesia','N','',''),(88,25,'AB','Store Url','U','icustom-template.myshopify.com','icustom-template.myshopify.com','N','',''),(89,25,'AC','Plan','T','monthly','monthly','N','',''),(90,25,'AA','Shop ID','T','icustom-template','icustom-template','N','','');
/*!40000 ALTER TABLE `site_user_custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_msg`
--

DROP TABLE IF EXISTS `system_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_msg` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tag` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `msg` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `is_sup` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No);',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` char(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `msg_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S' COMMENT 'radio(D=Danger,W=Warning,S=Success)',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'radio(A=Active,D=Dissmised)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_msg`
--

LOCK TABLES `system_msg` WRITE;
/*!40000 ALTER TABLE `system_msg` DISABLE KEYS */;
INSERT INTO `system_msg` VALUES (11,'SERVER','This is title','This Is test','N','2017-12-07 03:56:30','','W','D'),(12,'SERVER','This is title','This Is test','N','2017-12-07 03:58:05','','S','D'),(13,'SERVER','This is title','This Is test','O','2017-12-07 04:00:45','','S','D'),(55,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-10 02:48:37','AA','S','D'),(32,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-10 02:47:38','AA','S','D'),(33,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 15:39:23','AA','S','D'),(34,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 15:44:21','AA','S','D'),(35,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 16:00:22','AA','S','D'),(36,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 16:26:26','AA','S','D'),(37,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 16:28:11','AA','S','D'),(38,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 16:30:01','AA','S','D'),(39,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 16:30:50','AA','S','D'),(40,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 16:32:06','AA','S','D'),(41,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 16:35:56','AA','S','D'),(42,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 16:36:43','AA','S','D'),(43,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-08 17:40:28','AA','S','D'),(49,'SSM7','New Feature Release','Hosd kfjad fldkjfa ksdal ldkjf kjdlfjalsdjf ldjf jdfdsk fjdkjf ldjlf jsadf','O','2017-12-09 11:11:23','AA','S','D'),(47,'SSM8','New Feature Release','this is a test Anal, thsiis si a adult. kjdsjflasd jlkum dslfjlsdfjldsf sd','O','2017-12-09 11:07:22','AA','S','D'),(51,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-10 02:38:25','AA','S','D'),(52,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-10 02:41:22','AA','S','D'),(53,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-10 02:44:23','AA','S','D'),(54,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-10 02:46:14','AA','S','D'),(56,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-10 02:48:49','AA','S','D'),(57,'UPDATE','App Update','New app update available, version :1.2, Please update this app. <a href=\"http://192.168.10.71/Projects/support-system/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2017-12-13 03:05:55','AA','S','D'),(58,'imapc','Cron Job','Did you added this command (<b>wget --quiet -O /dev/null http://192.168.10.71/Projects/support-system/autoscript/cron/email-to-ticket.html</b>) into your server cron job list in a short interval?','Y','2017-12-13 14:08:16','AA','W','D'),(59,'UPDATE','App Update','New app update available, version :4.1.2, Please update this app. <a href=\"https://help.imakecustom.com/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2024-01-18 04:43:05','','S','D'),(60,'UPDATE','App Update','New app update available, version :4.1.4, Please update this app. <a href=\"https://help.imakecustom.com/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2024-04-02 07:48:37','AA','S','D'),(61,'UPDATE','App Update','New app update available, version :4.1.4, Please update this app. <a href=\"https://help.imakecustom.com/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2024-05-14 08:15:38','AA','S','D'),(62,'UPDATE','App Update','New app update available, version :4.1.4, Please update this app. <a href=\"https://help.imakecustom.com/admin/system-update.html\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2024-05-18 10:10:07','AA','S','D'),(63,'UPDATE','App Update','New app update available, version :4.1.4, Please update this app. <a href=\"https://help.imakecustom.com/admin/system-update\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> View Update Details</a>','O','2024-05-19 10:34:47','','S','D');
/*!40000 ALTER TABLE `system_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonial`
--

DROP TABLE IF EXISTS `testimonial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonial` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `designation` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `testimonial` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,B=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonial`
--

LOCK TABLES `testimonial` WRITE;
/*!40000 ALTER TABLE `testimonial` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ticket_track_id` char(18) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cat_id` char(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `title` char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `ticket_body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'textarea',
  `ticket_user` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `opened_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `re_open_time` timestamp NULL DEFAULT NULL,
  `re_open_by` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `re_open_by_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'radio(A=Staff,U=Ticket User,G=Guest Ticke User)',
  `user_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'U' COMMENT 'radio(G=Guest,U=User,A=Staff)',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'drop(N=New,C=Closed,P=In Progress,R=Re-Open)',
  `assigned_on` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'FK(app_user,id,title)',
  `assigned_date` timestamp NULL DEFAULT NULL,
  `last_replied_by` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'FK(app_user,id,title)',
  `last_replied_by_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'radio(G=Guest,U=User,A=Staff)',
  `last_reply_time` timestamp NULL DEFAULT NULL,
  `ticket_rating` decimal(1,0) unsigned NOT NULL DEFAULT '0',
  `priroty` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'L' COMMENT 'drop(L=Low,M=Medium,H=High,U=Urgent)',
  `is_public` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `is_open_using_email` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `is_paid_ticket` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `reply_counter` int unsigned NOT NULL DEFAULT '0',
  `is_user_seen_last_reply` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `shop_id` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `ticket_track_id` (`ticket_track_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (1,'T83DCEFB7-001-LJG','3','test','<p>test</p>','1','2024-01-18 15:19:50','2024-01-18 15:19:50','','','G','C','AA','2024-01-18 15:20:00','AA','A','2024-03-22 05:27:25',0,'L','N','N','N',2,'N',NULL),(7,'20d5e32aade2ed55a2','3','Testing','Please check this ticket!','5','2024-03-21 08:58:16',NULL,'','','G','A','AA','2024-03-21 09:59:20','AA','A','2024-03-22 04:56:02',0,'L','N','N','N',2,'N',0),(14,'faca1fe407760415e5','13','Test lagi','Test lagi asdsadas','1','2024-03-22 09:33:31',NULL,'','','G','N','',NULL,'','',NULL,0,'L','N','N','N',0,'N',0),(15,'e866a3f77f906323ed','13','Test lagi','Test lagi asdsadas','5','2024-03-22 09:38:06',NULL,'','','G','N','',NULL,'','',NULL,0,'L','N','N','N',0,'N',0),(16,'7969daa5c8fa76a50f','14','Testing tiket baru','baru','5','2024-03-22 09:38:39',NULL,'','','G','P','AA','2024-03-22 19:18:53','AA','A','2024-03-22 19:19:06',0,'L','N','N','N',1,'N',0),(17,'0b4b3c9efa99df5f50','3','Testing','Testing','23','2024-03-27 08:46:51',NULL,'','','G','N','',NULL,'','',NULL,0,'L','N','N','N',0,'N',0),(13,'8067e52dea296c8500','3','Mengisolasi Eksekusi Migrasi','Jika Anda menerapkan aplikasi di beberapa server dan menjalankan migrasi sebagai bagian dari proses penerapan, Anda mungkin tidak ingin dua server mencoba memigrasikan database secara bersamaan. Untuk menghindari hal ini, Anda dapat menggunakan isolatedopsi saat menjalankan migrateperintah.','5','2024-03-22 04:03:13','2024-03-22 19:21:46','AA','A','G','R','AA','2024-03-22 05:05:43','AA','A','2024-03-22 19:21:46',0,'L','N','N','N',2,'N',0),(18,'259ce6ec3275d85b83','2','Test Install it for me','Hello i just want to test the ticket','23','2024-04-02 20:45:49',NULL,'','','G','C','',NULL,'AA','A','2024-04-02 21:47:44',0,'L','N','N','N',1,'N',0),(19,'8d100f0f30e1216c94','1','Test','Testing','22','2024-04-16 07:04:30',NULL,'','','G','N','',NULL,'','',NULL,0,'L','N','N','N',0,'N',0),(20,'137d6e80260ad1dbd5','1','test','test','23','2024-04-25 12:21:43',NULL,'','','G','N','',NULL,'','',NULL,0,'L','N','N','N',0,'N',0);
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_assign_rule`
--

DROP TABLE IF EXISTS `ticket_assign_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_assign_rule` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cat_ids` char(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `rule_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'radio(A=Assign,N=Notifiy)',
  `rule_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'bool(A=Active,I=Inactive)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_assign_rule`
--

LOCK TABLES `ticket_assign_rule` WRITE;
/*!40000 ALTER TABLE `ticket_assign_rule` DISABLE KEYS */;
INSERT INTO `ticket_assign_rule` VALUES (1,'*','N','AA','A');
/*!40000 ALTER TABLE `ticket_assign_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_custom_field`
--

DROP TABLE IF EXISTS `ticket_custom_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_custom_field` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int unsigned NOT NULL DEFAULT '0',
  `custom_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `fld_title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fld_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'T' COMMENT 'radio(T=Textbox,N=Numeric,D=Dropdown,A=Date,R=Radio)',
  `fld_value` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fld_value_text` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_api_based` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `api_name` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `api_data` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_custom_field`
--

LOCK TABLES `ticket_custom_field` WRITE;
/*!40000 ALTER TABLE `ticket_custom_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_custom_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_feedback`
--

DROP TABLE IF EXISTS `ticket_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_feedback` (
  `ticket_id` int NOT NULL,
  `f_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'P' COMMENT 'radio(P=Positive, N=Nagative)',
  `f_msg` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'textarea',
  PRIMARY KEY (`ticket_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_feedback`
--

LOCK TABLES `ticket_feedback` WRITE;
/*!40000 ALTER TABLE `ticket_feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_log`
--

DROP TABLE IF EXISTS `ticket_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_log` (
  `ticket_id` int NOT NULL DEFAULT '0',
  `log_id` int NOT NULL DEFAULT '0',
  `log_by` char(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `log_by_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'radio(A=Staff,U=Ticket User,G=Guest Ticke User)',
  `log_msg` char(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `ticket_status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'P' COMMENT 'drop(N=New,C=Closed,P=In Progress,R=Re-Open,W=Waiting For User)',
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `ticket_id` (`ticket_id`,`log_id`) USING BTREE,
  KEY `ticket_id_2` (`ticket_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_log`
--

LOCK TABLES `ticket_log` WRITE;
/*!40000 ALTER TABLE `ticket_log` DISABLE KEYS */;
INSERT INTO `ticket_log` VALUES (1,1,'1','G','Ticket Opened','N','2024-01-18 14:19:50'),(1,2,'AA','A','Assign self','N','2024-01-18 14:20:00'),(1,3,'AA','A','Replied','P','2024-01-18 14:20:52'),(7,2,'AA','A','Replied','P','2024-03-21 09:25:33'),(7,1,'AA','A','Assign self','N','2024-03-21 08:59:20'),(13,1,'AA','A','Assign self','N','2024-03-22 04:05:43'),(7,3,'AA','A','Replied','A','2024-03-22 03:56:02'),(13,2,'AA','A','Replied','P','2024-03-22 04:05:55'),(1,4,'AA','A','Replied','C','2024-03-22 04:27:25'),(13,3,'AA','A','Closed','C','2024-03-22 18:15:30'),(16,1,'AA','A','Assign self','N','2024-03-22 18:18:53'),(16,2,'AA','A','Replied','P','2024-03-22 18:19:06'),(13,4,'AA','A','Ticket Re-Open','R','2024-03-22 18:21:46'),(18,1,'AA','A','Replied','P','2024-04-02 20:47:44'),(18,2,'AA','A','Closed','C','2024-04-02 20:50:13');
/*!40000 ALTER TABLE `ticket_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_payment`
--

DROP TABLE IF EXISTS `ticket_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_payment` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int unsigned NOT NULL DEFAULT '0',
  `reply_id` int unsigned NOT NULL DEFAULT '0',
  `amount` decimal(7,2) unsigned NOT NULL DEFAULT '0.00',
  `payment_currency` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'USD' COMMENT 'USD,EUR,GBP',
  `payment_des` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `payment_id` char(14) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_by` char(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `refund_msg` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `payment_method` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'P' COMMENT 'radio(P=PayPal,S=Stripe,A=Authorize)',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `process_date` timestamp NULL DEFAULT NULL,
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'P' COMMENT 'drop(P=Pending,A=Paid,F=Failed,R=Refunded)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_payment`
--

LOCK TABLES `ticket_payment` WRITE;
/*!40000 ALTER TABLE `ticket_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_reply`
--

DROP TABLE IF EXISTS `ticket_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket_reply` (
  `ticket_id` int NOT NULL DEFAULT '0',
  `reply_id` int NOT NULL DEFAULT '0',
  `asigned_by` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'Ticket current asigned by',
  `replied_by` char(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'FK(app_user,id,name)',
  `replied_by_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'radio(A=Staff,U=Ticket User,G=Guest Ticke User)',
  `reply_text` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'textarea',
  `reply_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ticket_status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'P' COMMENT 'drop(N=New,C=Closed,P=In Progress,R=Re-Open)',
  `is_private` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y' COMMENT 'boot(Y=Yes,N=No)',
  `payment_id` int unsigned NOT NULL DEFAULT '0',
  `is_user_seen` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N' COMMENT 'bool(Y=Yes,N=No)',
  `seen_time` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `ticket_id` (`ticket_id`,`reply_id`) USING BTREE,
  KEY `ticket_id_2` (`ticket_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_reply`
--

LOCK TABLES `ticket_reply` WRITE;
/*!40000 ALTER TABLE `ticket_reply` DISABLE KEYS */;
INSERT INTO `ticket_reply` VALUES (1,1,'AA','AA','A','<p>sadfasdfsdfsdf</p>','2024-01-18 14:20:52','P','Y',0,'N',NULL),(7,1,'AA','AA','A','<p>Yes reply</p>','2024-03-21 09:25:33','P','Y',0,'N',NULL),(7,2,'AA','AA','A','<p>testing adasdas</p>','2024-03-22 03:56:02','A','Y',0,'N',NULL),(13,1,'AA','AA','A','<p>asdasdasda</p>','2024-03-22 04:05:55','P','Y',0,'N',NULL),(1,2,'AA','AA','A','<p>udah closed</p>','2024-03-22 04:27:25','C','Y',0,'N',NULL),(7,3,'','5','U','The ticket body field.','2024-03-22 08:09:28','N','Y',0,'N',NULL),(13,4,'','5','U','Ketika isolatedopsi ini disediakan, Laravel akan memperoleh kunci atom menggunakan driver cache aplikasi Anda sebelum mencoba menjalankan migrasi Anda. Semua upaya lain untuk menjalankan migrateperintah saat kunci ditahan tidak akan dijalankan; namun, perintah akan tetap keluar dengan kode status keluar yang berhasil:','2024-03-22 08:55:31','N','Y',0,'N',NULL),(7,5,'','5','U','Beberapa operasi migrasi bersifat merusak, yang berarti dapat menyebabkan Anda kehilangan data. Untuk melindungi Anda dari menjalankan perintah ini terhadap database produksi Anda, Anda akan dimintai konfirmasi sebelum perintah dijalankan. Untuk memaksa perintah dijalankan tanpa prompt','2024-03-22 08:59:12','N','Y',0,'N',NULL),(13,6,'','5','U','Test','2024-03-22 09:32:17','N','Y',0,'N',NULL),(13,7,'','5','U','teasfasdasdasd','2024-03-22 14:42:58','N','Y',0,'N',NULL),(16,1,'AA','AA','A','<p>assadsadas</p>','2024-03-22 18:19:06','P','Y',0,'N',NULL),(13,8,'AA','AA','A','Ticket re opened','2024-03-22 18:21:46','R','Y',0,'N',NULL),(18,1,'','AA','A','<p xss=\"removed\">Hi imakecustom-dev imakecustom-dev,</p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">We would be happy to finish the installation for you!</p><p xss=\"removed\"><br xss=\"removed\">Please send the staff access login or create a new one for this email address:</p><p xss=\"removed\"><a href=\"http://support@imakecustom.com\" target=\"_blank\">support@imakecustom.com</a><br xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">Please see the reference of how to create staff login :</p><p xss=\"removed\"><a href=\"https://help.shopify.com/en/manual/your-account/staff-accounts/create-staff-accounts#create-a-new-staff-account\" target=\"_blank\" rel=\"noreferrer\" xss=\"removed\">https://help.shopify.com/en/manual/your-account/staff-accounts/create-staff-accounts#create-a-new-staff-account</a><br xss=\"removed\"></p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">Please find the following permission that I need to complete the installation:</p><p xss=\"removed\">1. Products<br xss=\"removed\"></p><p xss=\"removed\">2. Apps<br xss=\"removed\"></p><p xss=\"removed\">3. Themes​</p><p xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">Please let us know once you have completed the above and we will get started right away.<br xss=\"removed\">We will make sure the product customization app works properly on your website.<br xss=\"removed\"><br xss=\"removed\"></p><p xss=\"removed\">We look forward to working with you!</p><p xss=\"removed\"><br xss=\"removed\"></p><p></p>','2024-04-02 20:47:44','P','Y',0,'N',NULL),(18,9,'','23','U','sudah dikirim','2024-04-02 20:48:37','N','Y',0,'N',NULL),(17,10,'','23','U','yeee','2024-05-02 14:04:27','N','Y',0,'N',NULL);
/*!40000 ALTER TABLE `ticket_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topbar_icon`
--

DROP TABLE IF EXISTS `topbar_icon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `topbar_icon` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `sub_title` char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `icon_class` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `icon_order` int unsigned NOT NULL DEFAULT '0',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y' COMMENT 'bool(Y=Yes,N=No)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topbar_icon`
--

LOCK TABLES `topbar_icon` WRITE;
/*!40000 ALTER TABLE `topbar_icon` DISABLE KEYS */;
INSERT INTO `topbar_icon` VALUES (1,'24/7 Support','Call (347) XXX-XXXX','fa-phone',1,'Y'),(2,'Best Support','We are always best','fa-star-o',2,'Y');
/*!40000 ALTER TABLE `topbar_icon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_online_log`
--

DROP TABLE IF EXISTS `user_online_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_online_log` (
  `user_id` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `u_type` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A',
  `last_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `user_id` (`user_id`,`u_type`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_online_log`
--

LOCK TABLES `user_online_log` WRITE;
/*!40000 ALTER TABLE `user_online_log` DISABLE KEYS */;
INSERT INTO `user_online_log` VALUES ('AA','A','2024-05-19 15:17:32');
/*!40000 ALTER TABLE `user_online_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_role` (
  `pvid` char(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role_id` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title` char(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT 'A=Active, I=Inactive',
  UNIQUE KEY `pvid` (`pvid`,`role_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_log`
--

DROP TABLE IF EXISTS `work_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int unsigned NOT NULL DEFAULT '0',
  `user_id` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `note` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `w_time` decimal(4,0) unsigned NOT NULL DEFAULT '0',
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_log`
--

LOCK TABLES `work_log` WRITE;
/*!40000 ALTER TABLE `work_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'help'
--

--
-- Dumping routines for database 'help'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-19 21:17:33
