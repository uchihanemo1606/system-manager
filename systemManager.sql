-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: qlht
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel_cache_route_override_permission_hardware.getAll','N;',1749722346),('laravel_cache_route_override_permission_hardware.list','s:24:\"danh sách phần cứng\";',1749722456),('laravel_cache_route_override_permission_hardwaredomain.create','s:31:\"thêm phần cứng vào domain\";',1749718943),('laravel_cache_route_override_permission_hardwaredomain.list','s:37:\"danh sách phần cứng trong domain\";',1749719150),('laravel_cache_route_override_permission_hardwarepermission.create','s:45:\"thêm người dùng quản lý phần cứng\";',1749719411),('laravel_cache_user_permissions_nemohardware','a:8:{i:0;s:19:\"thêm phần cứng\";i:1;s:19:\"sửa phần cứng\";i:2;s:18:\"xoá phần cứng\";i:3;s:24:\"danh sách phần cứng\";i:4;s:45:\"thêm người dùng quản lý phần cứng\";i:5;s:53:\"chỉnh sửa người dùng quản lý phần cứng\";i:6;s:44:\"xoá người dùng quản lý phần cứng\";i:7;s:50:\"danh sách người dùng quản lý phần cứng\";}',1749719478),('laravel_cache_user_permissions_nemohardwareroom','a:1:{i:0;s:24:\"danh sách phần cứng\";}',1749722533),('laravel_cache_user_permissions_nemosystem','a:8:{i:0;s:12:\"thêm domain\";i:1;s:12:\"sửa domain\";i:2;s:11:\"xoá domain\";i:3;s:17:\"danh sách domain\";i:4;s:31:\"thêm phần cứng vào domain\";i:5;s:32:\"xoá phần cứng khỏi domain\";i:6;s:38:\"thay đổi phần cứng trong domain\";i:7;s:37:\"danh sách phần cứng trong domain\";}',1749718943);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `domain`
--

LOCK TABLES `domain` WRITE;
/*!40000 ALTER TABLE `domain` DISABLE KEYS */;
INSERT INTO `domain` VALUES (1,2,'hệ thống quản lý phần mềm uchihanemo','https://softwaremangaer/uchihanemo.vn','nemosystem','2025-06-11 01:14:20','2025-06-11 01:14:20'),(3,2,'quản lý chũi nhà hàng nemo','https://resnemo/uchihanemo.vn','nemosystem','2025-06-11 01:16:14','2025-06-11 01:16:14');
/*!40000 ALTER TABLE `domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `hardware`
--

LOCK TABLES `hardware` WRITE;
/*!40000 ALTER TABLE `hardware` DISABLE KEYS */;
INSERT INTO `hardware` VALUES ('192.168.13.14','Cassandra','Cassandra 5.0',1,'MacBook(MacOS)','Mac OS X 10.1','16TB','256GB',0,'\"this is service\"',1,'nemohardware','2025-06-12 00:53:47','2025-06-12 00:53:47'),('192.168.17.24','PostgresSQL','8.21.3',1,'MacBook(MacOS)','Mac OS X 10.4','16TB','256GB',0,'\"this is service\"',1,'nemohardware','2025-06-12 00:51:20','2025-06-12 00:51:20'),('192.168.6.6','scyllaDB','4.21.3',0,'linux(ubuntu)','22.04','4TB','512GB',0,'\"this is service\"',1,'nemohardware','2025-06-12 00:48:27','2025-06-12 00:48:27'),('192.168.6.8','Mongodb','4.21.3',0,'linux(ubuntu)','22.04','4TB','512GB',0,'\"this is service\"',1,'nemohardware','2025-06-12 00:48:43','2025-06-12 00:48:43');
/*!40000 ALTER TABLE `hardware` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `hardware_access_domain`
--

LOCK TABLES `hardware_access_domain` WRITE;
/*!40000 ALTER TABLE `hardware_access_domain` DISABLE KEYS */;
INSERT INTO `hardware_access_domain` VALUES (3,'192.168.6.8',1,'2025-06-12 01:02:23','2025-06-12 01:02:23'),(4,'192.168.17.24',1,'2025-06-12 01:02:52','2025-06-12 01:02:52'),(5,'192.168.17.24',3,'2025-06-12 01:03:57','2025-06-12 01:03:57'),(6,'192.168.13.14',3,'2025-06-12 01:04:10','2025-06-12 01:04:10'),(7,'192.168.6.6',3,'2025-06-12 01:04:37','2025-06-12 01:04:37');
/*!40000 ALTER TABLE `hardware_access_domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `hardware_permissions`
--

LOCK TABLES `hardware_permissions` WRITE;
/*!40000 ALTER TABLE `hardware_permissions` DISABLE KEYS */;
INSERT INTO `hardware_permissions` VALUES ('192.168.17.24','xem phần cứng','nemohardwareroom','nemohardware','2025-06-12 02:02:59','2025-06-12 02:02:59','2025-06-12 02:02:59'),('192.168.6.6','xem phần cứng','nemohardwareroom','nemohardware','2025-06-12 01:16:37','2025-06-12 01:16:37','2025-06-12 01:16:37');
/*!40000 ALTER TABLE `hardware_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xoá người dùng',NULL,NULL,NULL,NULL,'xoá người dùng',NULL,0,'2025-06-09 20:29:30','2025-06-09 20:29:30'),(2,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thêm người dùng',NULL,NULL,NULL,NULL,'thêm người dùng',NULL,0,'2025-06-09 20:29:35','2025-06-09 20:29:35'),(3,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . sửa người dùng',NULL,NULL,NULL,NULL,'sửa người dùng',NULL,0,'2025-06-09 20:29:46','2025-06-09 20:29:46'),(4,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . danh sách người dùng',NULL,NULL,NULL,NULL,'danh sách người dùng',NULL,0,'2025-06-09 20:29:50','2025-06-09 20:29:50'),(5,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'Quản trị viên\' with permission \'thêm người dùng\'.',NULL,NULL,NULL,NULL,'thêm người dùng',NULL,0,'2025-06-09 20:34:09','2025-06-09 20:34:09'),(6,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-09 23:53:54','2025-06-09 23:53:54'),(7,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 00:45:33','2025-06-10 00:45:33'),(8,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 00:58:27','2025-06-10 00:58:27'),(9,'uchihanemo',NULL,NULL,NULL,'uchihanemo đã tạo tài khoản có username là \'tiếng\'',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 01:12:31','2025-06-10 01:12:31'),(10,'uchihanemo',NULL,NULL,NULL,'uchihanemo đã tạo tài khoản có username là \'nemohardware\'',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 01:12:59','2025-06-10 01:12:59'),(11,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thêm vai trò',NULL,NULL,NULL,NULL,'thêm vai trò',NULL,0,'2025-06-10 01:16:04','2025-06-10 01:16:04'),(12,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . sửa vai trò',NULL,NULL,NULL,NULL,'sửa vai trò',NULL,0,'2025-06-10 01:16:15','2025-06-10 01:16:15'),(13,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xoá vai trò',NULL,NULL,NULL,NULL,'xoá vai trò',NULL,0,'2025-06-10 01:16:18','2025-06-10 01:16:18'),(14,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . danh sách vai trò',NULL,NULL,NULL,NULL,'danh sách vai trò',NULL,0,'2025-06-10 01:16:21','2025-06-10 01:16:21'),(15,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 01:17:58','2025-06-10 01:17:58'),(16,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'Quản trị viên\' with permission \'thêm vai trò\'.',NULL,NULL,NULL,NULL,'thêm vai trò',NULL,0,'2025-06-10 01:18:15','2025-06-10 01:18:15'),(17,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'Quản trị viên\' with permission \'sửa vai trò\'.',NULL,NULL,NULL,NULL,'sửa vai trò',NULL,0,'2025-06-10 01:18:25','2025-06-10 01:18:25'),(18,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'Quản trị viên\' with permission \'xoá vai trò\'.',NULL,NULL,NULL,NULL,'xoá vai trò',NULL,0,'2025-06-10 01:18:29','2025-06-10 01:18:29'),(19,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'Quản trị viên\' with permission \'danh sách vai trò\'.',NULL,NULL,NULL,NULL,'danh sách vai trò',NULL,0,'2025-06-10 01:18:32','2025-06-10 01:18:32'),(20,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 02:15:49','2025-06-10 02:15:49'),(21,'uchihanemo',NULL,NULL,NULL,' user uchihanemo created role \'quản lý phần cứng\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 02:16:02','2025-06-10 02:16:02'),(22,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 23:38:33','2025-06-10 23:38:33'),(23,'uchihanemo',NULL,NULL,NULL,' user uchihanemo created role \'quản lý phần mềm\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 23:39:16','2025-06-10 23:39:16'),(24,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thêm phần mềm',NULL,NULL,NULL,NULL,'thêm phần mềm',NULL,0,'2025-06-10 23:40:03','2025-06-10 23:40:03'),(25,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . sửa phần mềm',NULL,NULL,NULL,NULL,'sửa phần mềm',NULL,0,'2025-06-10 23:40:10','2025-06-10 23:40:10'),(26,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xoá phần mềm',NULL,NULL,NULL,NULL,'xoá phần mềm',NULL,0,'2025-06-10 23:40:13','2025-06-10 23:40:13'),(27,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . danh sách phần mềm',NULL,NULL,NULL,NULL,'danh sách phần mềm',NULL,0,'2025-06-10 23:40:16','2025-06-10 23:40:16'),(28,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thêm phần cứng',NULL,NULL,NULL,NULL,'thêm phần cứng',NULL,0,'2025-06-10 23:40:24','2025-06-10 23:40:24'),(29,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . sửa phần cứng',NULL,NULL,NULL,NULL,'sửa phần cứng',NULL,0,'2025-06-10 23:40:30','2025-06-10 23:40:30'),(30,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xoá phần cứng',NULL,NULL,NULL,NULL,'xoá phần cứng',NULL,0,'2025-06-10 23:40:46','2025-06-10 23:40:46'),(31,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . danh sách phần cứng',NULL,NULL,NULL,NULL,'danh sách phần cứng',NULL,0,'2025-06-10 23:40:52','2025-06-10 23:40:52'),(32,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần mềm\' with permission \'thêm phần mềm\'.',NULL,NULL,NULL,NULL,'thêm phần mềm',NULL,0,'2025-06-10 23:42:26','2025-06-10 23:42:26'),(33,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần mềm\' with permission \'sửa phần mềm\'.',NULL,NULL,NULL,NULL,'sửa phần mềm',NULL,0,'2025-06-10 23:42:33','2025-06-10 23:42:33'),(34,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần mềm\' with permission \'xoá phần mềm\'.',NULL,NULL,NULL,NULL,'xoá phần mềm',NULL,0,'2025-06-10 23:42:35','2025-06-10 23:42:35'),(35,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần mềm\' with permission \'danh sách phần mềm\'.',NULL,NULL,NULL,NULL,'danh sách phần mềm',NULL,0,'2025-06-10 23:42:42','2025-06-10 23:42:42'),(36,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần cứng\' with permission \'thêm phần cứng\'.',NULL,NULL,NULL,NULL,'thêm phần cứng',NULL,0,'2025-06-10 23:43:00','2025-06-10 23:43:00'),(37,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần cứng\' with permission \'sửa phần cứng\'.',NULL,NULL,NULL,NULL,'sửa phần cứng',NULL,0,'2025-06-10 23:43:03','2025-06-10 23:43:03'),(38,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần cứng\' with permission \'xoá phần cứng\'.',NULL,NULL,NULL,NULL,'xoá phần cứng',NULL,0,'2025-06-10 23:43:06','2025-06-10 23:43:06'),(39,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần cứng\' with permission \'danh sách phần cứng\'.',NULL,NULL,NULL,NULL,'danh sách phần cứng',NULL,0,'2025-06-10 23:43:09','2025-06-10 23:43:09'),(40,'uchihanemo',NULL,NULL,NULL,'uchihanemo đã tạo tài khoản có username là \'nemoshoftware\'',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 23:43:44','2025-06-10 23:43:44'),(41,'uchihanemo',NULL,NULL,NULL,'uchihanemo đã tạo tài khoản có username là \'nemosoftware\'',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 23:43:53','2025-06-10 23:43:53'),(42,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: quản lý phần mềm.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 23:45:01','2025-06-10 23:45:01'),(43,'nemosoftware',NULL,NULL,NULL,'nemosoftware has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 23:46:59','2025-06-10 23:46:59'),(44,'nemosoftware',1,NULL,NULL,' user nemosoftware created software \'phần mềm dịch tựu động\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 23:56:41','2025-06-10 23:56:41'),(45,'nemosoftware',2,NULL,NULL,' user nemosoftware created software \'phần mềm quản lý quán ăn\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-10 23:57:33','2025-06-10 23:57:33'),(46,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: quản lý phần cứng.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 00:00:03','2025-06-11 00:00:03'),(47,'uchihanemo',NULL,NULL,NULL,'uchihanemo đã tạo tài khoản có username là \'nemosystem\'',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 00:00:52','2025-06-11 00:00:52'),(48,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thêm domain',NULL,NULL,NULL,NULL,'thêm domain',NULL,0,'2025-06-11 00:08:52','2025-06-11 00:08:52'),(49,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . sửa domain',NULL,NULL,NULL,NULL,'sửa domain',NULL,0,'2025-06-11 00:09:00','2025-06-11 00:09:00'),(50,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xoá domain',NULL,NULL,NULL,NULL,'xoá domain',NULL,0,'2025-06-11 00:09:04','2025-06-11 00:09:04'),(51,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . danh sách domain',NULL,NULL,NULL,NULL,'danh sách domain',NULL,0,'2025-06-11 00:09:18','2025-06-11 00:09:18'),(52,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thêm phần cứng vào domain',NULL,NULL,NULL,NULL,'thêm phần cứng vào domain',NULL,0,'2025-06-11 00:09:43','2025-06-11 00:09:43'),(53,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xoá phần cứng khỏi domain',NULL,NULL,NULL,NULL,'xoá phần cứng khỏi domain',NULL,0,'2025-06-11 00:10:07','2025-06-11 00:10:07'),(54,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thay đổi phần cứng trong domain',NULL,NULL,NULL,NULL,'thay đổi phần cứng trong domain',NULL,0,'2025-06-11 00:11:07','2025-06-11 00:11:07'),(55,'uchihanemo',NULL,NULL,NULL,' user uchihanemo created role \'quản lý hệ thống\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 00:11:59','2025-06-11 00:11:59'),(56,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý hệ thống\' with permission \'thêm domain\'.',NULL,NULL,NULL,NULL,'thêm domain',NULL,0,'2025-06-11 00:34:22','2025-06-11 00:34:22'),(57,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý hệ thống\' with permission \'sửa domain\'.',NULL,NULL,NULL,NULL,'sửa domain',NULL,0,'2025-06-11 00:34:33','2025-06-11 00:34:33'),(58,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý hệ thống\' with permission \'xoá domain\'.',NULL,NULL,NULL,NULL,'xoá domain',NULL,0,'2025-06-11 00:34:35','2025-06-11 00:34:35'),(59,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý hệ thống\' with permission \'danh sách domain\'.',NULL,NULL,NULL,NULL,'danh sách domain',NULL,0,'2025-06-11 00:34:43','2025-06-11 00:34:43'),(60,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý hệ thống\' with permission \'thêm phần cứng vào domain\'.',NULL,NULL,NULL,NULL,'thêm phần cứng vào domain',NULL,0,'2025-06-11 00:34:59','2025-06-11 00:34:59'),(61,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý hệ thống\' with permission \'xoá phần cứng khỏi domain\'.',NULL,NULL,NULL,NULL,'xoá phần cứng khỏi domain',NULL,0,'2025-06-11 00:35:57','2025-06-11 00:35:57'),(62,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý hệ thống\' with permission \'thay đổi phần cứng trong domain\'.',NULL,NULL,NULL,NULL,'thay đổi phần cứng trong domain',NULL,0,'2025-06-11 00:36:33','2025-06-11 00:36:33'),(64,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 00:50:09','2025-06-11 00:50:09'),(65,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: quản lý phần cứng.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 00:50:54','2025-06-11 00:50:54'),(69,'nemosystem',NULL,NULL,NULL,'nemosystem has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 01:00:15','2025-06-11 01:00:15'),(70,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: quản lý hệ thống.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 01:11:24','2025-06-11 01:11:24'),(71,'nemosystem',NULL,NULL,NULL,' user nemosystem created domain \'\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 01:14:20','2025-06-11 01:14:20'),(72,'nemosystem',NULL,NULL,NULL,' user nemosystem created domain \'\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 01:16:14','2025-06-11 01:16:14'),(73,'nemosystem',NULL,NULL,NULL,'nemosystem has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 02:50:35','2025-06-11 02:50:35'),(74,'nemosystem',NULL,NULL,NULL,'nemosystem has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 17:45:00','2025-06-11 17:45:00'),(76,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 18:34:00','2025-06-11 18:34:00'),(77,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . danh sách phần cứng trong domain',NULL,NULL,NULL,NULL,'danh sách phần cứng trong domain',NULL,0,'2025-06-11 18:35:27','2025-06-11 18:35:27'),(78,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý hệ thống\' with permission \'danh sách phần cứng trong domain\'.',NULL,NULL,NULL,NULL,'danh sách phần cứng trong domain',NULL,0,'2025-06-11 18:36:03','2025-06-11 18:36:03'),(79,'nemosystem',NULL,NULL,NULL,'nemosystem has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 18:47:19','2025-06-11 18:47:19'),(80,'nemosystem',NULL,NULL,NULL,'nemosystem has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 19:23:21','2025-06-11 19:23:21'),(81,'nemosystem',NULL,NULL,NULL,'nemosystem has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 23:40:37','2025-06-11 23:40:37'),(83,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-11 23:46:50','2025-06-11 23:46:50'),(84,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thêm người dùng quản lý phần cứng',NULL,NULL,NULL,NULL,'thêm người dùng quản lý phần cứng',NULL,0,'2025-06-11 23:49:31','2025-06-11 23:49:31'),(85,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xoá người dùng quản lý phần cứng',NULL,NULL,NULL,NULL,'xoá người dùng quản lý phần cứng',NULL,0,'2025-06-11 23:49:46','2025-06-11 23:49:46'),(86,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . chỉnh sửa người dùng quản lý phần cứng',NULL,NULL,NULL,NULL,'chỉnh sửa người dùng quản lý phần cứng',NULL,0,'2025-06-11 23:49:51','2025-06-11 23:49:51'),(87,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . danh sách người dùng quản lý phần cứng',NULL,NULL,NULL,NULL,'danh sách người dùng quản lý phần cứng',NULL,0,'2025-06-11 23:49:56','2025-06-11 23:49:56'),(88,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . thêm người dùng quản lý phần mềm',NULL,NULL,NULL,NULL,'thêm người dùng quản lý phần mềm',NULL,0,'2025-06-11 23:53:09','2025-06-11 23:53:09'),(89,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . sửa người dùng quản lý phần mềm',NULL,NULL,NULL,NULL,'sửa người dùng quản lý phần mềm',NULL,0,'2025-06-11 23:53:24','2025-06-11 23:53:24'),(90,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xoá người dùng quản lý phần mềm',NULL,NULL,NULL,NULL,'xoá người dùng quản lý phần mềm',NULL,0,'2025-06-11 23:53:27','2025-06-11 23:53:27'),(91,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . danh sách người dùng quản lý phần mềm',NULL,NULL,NULL,NULL,'danh sách người dùng quản lý phần mềm',NULL,0,'2025-06-11 23:53:34','2025-06-11 23:53:34'),(92,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần cứng\' with permission \'thêm người dùng quản lý phần cứng\'.',NULL,NULL,NULL,NULL,'thêm người dùng quản lý phần cứng',NULL,0,'2025-06-11 23:58:49','2025-06-11 23:58:49'),(93,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần cứng\' with permission \'chỉnh sửa người dùng quản lý phần cứng\'.',NULL,NULL,NULL,NULL,'chỉnh sửa người dùng quản lý phần cứng',NULL,0,'2025-06-11 23:59:06','2025-06-11 23:59:06'),(94,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần cứng\' with permission \'xoá người dùng quản lý phần cứng\'.',NULL,NULL,NULL,NULL,'xoá người dùng quản lý phần cứng',NULL,0,'2025-06-11 23:59:18','2025-06-11 23:59:18'),(95,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'quản lý phần cứng\' with permission \'danh sách người dùng quản lý phần cứng\'.',NULL,NULL,NULL,NULL,'danh sách người dùng quản lý phần cứng',NULL,0,'2025-06-11 23:59:27','2025-06-11 23:59:27'),(97,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:02:16','2025-06-12 00:02:16'),(98,'uchihanemo',NULL,NULL,NULL,'uchihanemo đã tạo tài khoản có username là \'nemhardwareroom\'',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:04:23','2025-06-12 00:04:23'),(99,'uchihanemo',NULL,NULL,NULL,' user uchihanemo created role \'phòng ban phần cứng\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:05:59','2025-06-12 00:05:59'),(100,'uchihanemo',NULL,NULL,NULL,' user uchihanemo created role \'phòng ban phần mềm\'.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:06:14','2025-06-12 00:06:14'),(101,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'phòng ban phần cứng\' with permission \'danh sách phần cứng\'.',NULL,NULL,NULL,NULL,'danh sách phần cứng',NULL,0,'2025-06-12 00:10:55','2025-06-12 00:10:55'),(102,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created role permission \'phòng ban phần mềm\' with permission \'danh sách phần mềm\'.',NULL,NULL,NULL,NULL,'danh sách phần mềm',NULL,0,'2025-06-12 00:11:08','2025-06-12 00:11:08'),(103,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: phòng ban phần cứng.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:13:12','2025-06-12 00:13:12'),(104,'uchihanemo',NULL,NULL,NULL,'uchihanemo đã tạo tài khoản có username là \'nemohardwareroom\'',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:21:53','2025-06-12 00:21:53'),(105,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: phòng ban phần cứng.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:22:11','2025-06-12 00:22:11'),(106,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xem phần cứng',NULL,NULL,NULL,NULL,'xem phần cứng',NULL,0,'2025-06-12 00:27:11','2025-06-12 00:27:11'),(107,'uchihanemo',NULL,NULL,NULL,'user uchihanemo has been create new permission: \' . xem phần mềm',NULL,NULL,NULL,NULL,'xem phần mềm',NULL,0,'2025-06-12 00:27:21','2025-06-12 00:27:21'),(108,'uchihanemo',NULL,NULL,NULL,'uchihanemo đã tạo tài khoản có username là \'nemohardware\'',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:30:10','2025-06-12 00:30:10'),(109,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: quản lý phần cứng.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:30:44','2025-06-12 00:30:44'),(110,'nemohardware',NULL,NULL,NULL,'nemohardware has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:30:57','2025-06-12 00:30:57'),(111,'nemohardware',NULL,NULL,NULL,'nemohardware has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:48:04','2025-06-12 00:48:04'),(112,'nemohardware',NULL,'192.168.6.6',NULL,'User nemohardware Created new hardware with IP 192.168.6.6',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:48:27','2025-06-12 00:48:27'),(113,'nemohardware',NULL,'192.168.6.8',NULL,'User nemohardware Created new hardware with IP 192.168.6.8',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:48:43','2025-06-12 00:48:43'),(114,'nemohardware',NULL,'192.168.17.24',NULL,'User nemohardware Created new hardware with IP 192.168.17.24',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:51:20','2025-06-12 00:51:20'),(115,'nemohardware',NULL,'192.168.13.14',NULL,'User nemohardware Created new hardware with IP 192.168.13.14',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:53:47','2025-06-12 00:53:47'),(116,'nemosystem',NULL,NULL,NULL,'nemosystem has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:55:24','2025-06-12 00:55:24'),(117,'uchihanemo',NULL,NULL,NULL,'uchihanemo has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:56:26','2025-06-12 00:56:26'),(118,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: quản lý hệ thóng.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 00:58:01','2025-06-12 00:58:01'),(119,'uchihanemo',NULL,NULL,NULL,'User uchihanemo created a new user role: quản lý hệ thống.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:00:43','2025-06-12 01:00:43'),(120,'nemosystem',NULL,NULL,NULL,'nemosystem has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:01:09','2025-06-12 01:01:09'),(121,'nemosystem',NULL,'192.168.6.8',NULL,'User nemosystem added domain with ID 1 to hardware with IP 192.168.6.8',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:02:23','2025-06-12 01:02:23'),(122,'nemosystem',NULL,'192.168.17.24',NULL,'User nemosystem added domain with ID 1 to hardware with IP 192.168.17.24',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:02:52','2025-06-12 01:02:52'),(123,'nemosystem',NULL,'192.168.17.24',NULL,'User nemosystem added domain with ID 3 to hardware with IP 192.168.17.24',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:03:57','2025-06-12 01:03:57'),(124,'nemosystem',NULL,'192.168.13.14',NULL,'User nemosystem added domain with ID 3 to hardware with IP 192.168.13.14',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:04:10','2025-06-12 01:04:10'),(125,'nemosystem',NULL,'192.168.6.6',NULL,'User nemosystem added domain with ID 3 to hardware with IP 192.168.6.6',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:04:37','2025-06-12 01:04:37'),(126,'nemohardware',NULL,NULL,NULL,'nemohardware has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:10:57','2025-06-12 01:10:57'),(127,'nemohardware',NULL,NULL,NULL,'nemohardware has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 01:58:02','2025-06-12 01:58:02'),(128,'nemohardwareroom',NULL,NULL,NULL,'nemohardwareroom has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-12 02:01:48','2025-06-12 02:01:48'),(129,'nemohardware',NULL,NULL,NULL,'nemohardware has logged in system.',NULL,NULL,NULL,NULL,NULL,NULL,0,'2025-06-13 01:01:40','2025-06-13 01:01:40');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_05_27_065543_users',1),(4,'2025_05_27_07000_create_software_table',1),(5,'2025_05_27_070853_create_domain_table',1),(6,'2025_05_27_074128_create_hardware_table',1),(7,'2025_05_27_074218_create_category_rule',1),(8,'2025_05_27_074308_create_rules_table',1),(9,'2025_05_27_074437_create_roles_table',1),(10,'2025_05_27_074801_create_software_file_table',1),(11,'2025_05_27_075315_create_permissions_table',1),(12,'2025_05_27_075336_create_user_role_table',1),(13,'2025_05_27_075402_create_role_permissions_table',1),(14,'2025_05_27_075418_create_hardware_permissions_table',1),(15,'2025_05_27_075437_create_software_permissions_table',1),(16,'2025_05_27_085339_create_software_rule',1),(17,'2025_05_28_021131_create_personal_access_tokens_table',1),(18,'2025_05_29_023313_create_hardware_access_domain',1),(19,'2025_06_01_035653_create_route_permission',1),(20,'2025_06_27_074919_create_log_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES ('uchihanemo','cấp quyền người dùng','userrole','2025-06-09 20:29:17','2025-06-09 20:29:17'),('uchihanemo','chỉnh sửa người dùng quản lý phần cứng','hardwarepermission','2025-06-11 23:49:51','2025-06-11 23:49:51'),('uchihanemo','danh sách domain','domain','2025-06-11 00:09:18','2025-06-11 00:09:18'),('uchihanemo','danh sách người dùng','user','2025-06-09 20:29:50','2025-06-09 20:29:50'),('uchihanemo','danh sách người dùng quản lý phần cứng','hardwarepermission','2025-06-11 23:49:56','2025-06-11 23:49:56'),('uchihanemo','danh sách người dùng quản lý phần mềm','softwarepermission','2025-06-11 23:53:34','2025-06-11 23:53:34'),('uchihanemo','danh sách phần cứng','hardware','2025-06-10 23:40:52','2025-06-10 23:40:52'),('uchihanemo','danh sách phần cứng trong domain','hardwaredomain','2025-06-11 18:35:27','2025-06-11 18:35:27'),('uchihanemo','danh sách phần mềm','software','2025-06-10 23:40:16','2025-06-10 23:40:16'),('uchihanemo','danh sách quyền hạn','permission','2025-06-09 20:29:17','2025-06-09 20:29:17'),('uchihanemo','danh sách quyền người dùng','userrole','2025-06-09 20:29:17','2025-06-09 20:29:17'),('uchihanemo','danh sách vai trò','role','2025-06-10 01:16:21','2025-06-10 01:16:21'),('uchihanemo','sửa domain','domain','2025-06-11 00:09:00','2025-06-11 00:09:00'),('uchihanemo','sửa người dùng','user','2025-06-09 20:29:46','2025-06-09 20:29:46'),('uchihanemo','sửa người dùng quản lý phần mềm','softwarepermission','2025-06-11 23:53:24','2025-06-11 23:53:24'),('uchihanemo','sửa phần cứng','hardware','2025-06-10 23:40:30','2025-06-10 23:40:30'),('uchihanemo','sửa phần mềm','software','2025-06-10 23:40:10','2025-06-10 23:40:10'),('uchihanemo','sửa quyền hạn','permission','2025-06-09 20:29:17','2025-06-09 20:29:17'),('uchihanemo','sửa quyền người dùng','userrole','2025-06-09 20:29:17','2025-06-09 20:29:17'),('uchihanemo','sửa vai trò','role','2025-06-10 01:16:15','2025-06-10 01:16:15'),('uchihanemo','thay đổi phần cứng trong domain','hardwaredomain','2025-06-11 00:11:07','2025-06-11 00:11:07'),('uchihanemo','thêm domain','domain','2025-06-11 00:08:52','2025-06-11 00:08:52'),('uchihanemo','thêm người dùng','user','2025-06-09 20:29:35','2025-06-09 20:29:35'),('uchihanemo','thêm người dùng quản lý phần cứng','hardwarepermission','2025-06-11 23:49:31','2025-06-11 23:49:31'),('uchihanemo','thêm người dùng quản lý phần mềm','softwarepermission','2025-06-11 23:53:09','2025-06-11 23:53:09'),('uchihanemo','thêm phần cứng','hardware','2025-06-10 23:40:24','2025-06-10 23:40:24'),('uchihanemo','thêm phần cứng vào domain','hardwaredomain','2025-06-11 00:09:43','2025-06-11 00:09:43'),('uchihanemo','thêm phần mềm','software','2025-06-10 23:40:03','2025-06-10 23:40:03'),('uchihanemo','thêm quyền hạn','permission','2025-06-09 20:29:17','2025-06-09 20:29:17'),('uchihanemo','thêm vai trò','role','2025-06-10 01:16:04','2025-06-10 01:16:04'),('uchihanemo','xem phần cứng','hardware','2025-06-12 00:27:11','2025-06-12 00:27:11'),('uchihanemo','xem phần mềm','software','2025-06-12 00:27:21','2025-06-12 00:27:21'),('uchihanemo','xoá domain','domain','2025-06-11 00:09:04','2025-06-11 00:09:04'),('uchihanemo','xoá người dùng','user','2025-06-09 20:29:30','2025-06-09 20:29:30'),('uchihanemo','xoá người dùng quản lý phần cứng','hardwarepermission','2025-06-11 23:49:46','2025-06-11 23:49:46'),('uchihanemo','xoá người dùng quản lý phần mềm','softwarepermission','2025-06-11 23:53:27','2025-06-11 23:53:27'),('uchihanemo','xoá phần cứng','hardware','2025-06-10 23:40:46','2025-06-10 23:40:46'),('uchihanemo','xoá phần cứng khỏi domain','hardwaredomain','2025-06-11 00:10:07','2025-06-11 00:10:07'),('uchihanemo','xoá phần mềm','software','2025-06-10 23:40:13','2025-06-10 23:40:13'),('uchihanemo','xoá quyền hạn','permission','2025-06-09 20:29:17','2025-06-09 20:29:17'),('uchihanemo','xoá quyền người dùng','userrole','2025-06-09 20:29:17','2025-06-09 20:29:17'),('uchihanemo','xoá vai trò','role','2025-06-10 01:16:18','2025-06-10 01:16:18');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
INSERT INTO `role_permissions` VALUES (1,'Quản trị viên','thêm quyền hạn','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(2,'Quản trị viên','sửa quyền hạn','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(3,'Quản trị viên','xoá quyền hạn','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(4,'Quản trị viên','danh sách quyền hạn','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(5,'Quản trị viên','cấp quyền người dùng','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(6,'Quản trị viên','sửa quyền người dùng','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(7,'Quản trị viên','xoá quyền người dùng','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(8,'Quản trị viên','danh sách quyền người dùng','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(9,'Quản trị viên','thêm người dùng','2025-06-09 20:34:09','2025-06-09 20:34:09','2025-06-09 20:34:09'),(10,'Quản trị viên','thêm vai trò','2025-06-10 01:18:15','2025-06-10 01:18:15','2025-06-10 01:18:15'),(11,'Quản trị viên','sửa vai trò','2025-06-10 01:18:25','2025-06-10 01:18:25','2025-06-10 01:18:25'),(12,'Quản trị viên','xoá vai trò','2025-06-10 01:18:29','2025-06-10 01:18:29','2025-06-10 01:18:29'),(13,'Quản trị viên','danh sách vai trò','2025-06-10 01:18:32','2025-06-10 01:18:32','2025-06-10 01:18:32'),(14,'quản lý phần mềm','thêm phần mềm','2025-06-10 23:42:26','2025-06-10 23:42:26','2025-06-10 23:42:26'),(15,'quản lý phần mềm','sửa phần mềm','2025-06-10 23:42:33','2025-06-10 23:42:33','2025-06-10 23:42:33'),(16,'quản lý phần mềm','xoá phần mềm','2025-06-10 23:42:35','2025-06-10 23:42:35','2025-06-10 23:42:35'),(17,'quản lý phần mềm','danh sách phần mềm','2025-06-10 23:42:42','2025-06-10 23:42:42','2025-06-10 23:42:42'),(18,'quản lý phần cứng','thêm phần cứng','2025-06-10 23:43:00','2025-06-10 23:43:00','2025-06-10 23:43:00'),(19,'quản lý phần cứng','sửa phần cứng','2025-06-10 23:43:03','2025-06-10 23:43:03','2025-06-10 23:43:03'),(20,'quản lý phần cứng','xoá phần cứng','2025-06-10 23:43:06','2025-06-10 23:43:06','2025-06-10 23:43:06'),(21,'quản lý phần cứng','danh sách phần cứng','2025-06-10 23:43:09','2025-06-10 23:43:09','2025-06-10 23:43:09'),(22,'quản lý hệ thống','thêm domain','2025-06-11 00:34:22','2025-06-11 00:34:22','2025-06-11 00:34:22'),(23,'quản lý hệ thống','sửa domain','2025-06-11 00:34:33','2025-06-11 00:34:33','2025-06-11 00:34:33'),(24,'quản lý hệ thống','xoá domain','2025-06-11 00:34:35','2025-06-11 00:34:35','2025-06-11 00:34:35'),(25,'quản lý hệ thống','danh sách domain','2025-06-11 00:34:43','2025-06-11 00:34:43','2025-06-11 00:34:43'),(26,'quản lý hệ thống','thêm phần cứng vào domain','2025-06-11 00:34:59','2025-06-11 00:34:59','2025-06-11 00:34:59'),(27,'quản lý hệ thống','xoá phần cứng khỏi domain','2025-06-11 00:35:57','2025-06-11 00:35:57','2025-06-11 00:35:57'),(28,'quản lý hệ thống','thay đổi phần cứng trong domain','2025-06-11 00:36:33','2025-06-11 00:36:33','2025-06-11 00:36:33'),(29,'quản lý hệ thống','danh sách phần cứng trong domain','2025-06-11 18:36:03','2025-06-11 18:36:03','2025-06-11 18:36:03'),(30,'quản lý phần cứng','thêm người dùng quản lý phần cứng','2025-06-11 23:58:49','2025-06-11 23:58:49','2025-06-11 23:58:49'),(31,'quản lý phần cứng','chỉnh sửa người dùng quản lý phần cứng','2025-06-11 23:59:06','2025-06-11 23:59:06','2025-06-11 23:59:06'),(32,'quản lý phần cứng','xoá người dùng quản lý phần cứng','2025-06-11 23:59:18','2025-06-11 23:59:18','2025-06-11 23:59:18'),(33,'quản lý phần cứng','danh sách người dùng quản lý phần cứng','2025-06-11 23:59:27','2025-06-11 23:59:27','2025-06-11 23:59:27'),(34,'phòng ban phần cứng','danh sách phần cứng','2025-06-12 00:10:55','2025-06-12 00:10:55','2025-06-12 00:10:55'),(35,'phòng ban phần mềm','danh sách phần mềm','2025-06-12 00:11:08','2025-06-12 00:11:08','2025-06-12 00:11:08');
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Quản trị viên','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(2,'quản lý phần cứng','2025-06-10 02:16:02','2025-06-10 02:16:02','2025-06-10 02:16:02'),(3,'quản lý phần mềm','2025-06-10 23:39:16','2025-06-10 23:39:16','2025-06-10 23:39:16'),(4,'quản lý hệ thống','2025-06-11 00:11:59','2025-06-11 00:11:59','2025-06-11 00:11:59'),(5,'phòng ban phần cứng','2025-06-12 00:05:59','2025-06-12 00:05:59','2025-06-12 00:05:59'),(6,'phòng ban phần mềm','2025-06-12 00:06:14','2025-06-12 00:06:14','2025-06-12 00:06:14');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `route_permission`
--

LOCK TABLES `route_permission` WRITE;
/*!40000 ALTER TABLE `route_permission` DISABLE KEYS */;
INSERT INTO `route_permission` VALUES (1,'permission.create','thêm quyền hạn','2025-06-09 20:29:17','2025-06-09 20:29:17'),(2,'permission.edit','sửa quyền hạn','2025-06-09 20:29:17','2025-06-09 20:29:17'),(3,'permission.delete','xoá quyền hạn','2025-06-09 20:29:17','2025-06-09 20:29:17'),(4,'permission.list','danh sách quyền hạn','2025-06-09 20:29:17','2025-06-09 20:29:17'),(5,'userrole.create','cấp quyền người dùng','2025-06-09 20:29:17','2025-06-09 20:29:17'),(6,'userrole.edit','sửa quyền người dùng','2025-06-09 20:29:17','2025-06-09 20:29:17'),(7,'userrole.delete','xoá quyền người dùng','2025-06-09 20:29:17','2025-06-09 20:29:17'),(8,'userrole.list','danh sách quyền người dùng','2025-06-09 20:29:17','2025-06-09 20:29:17'),(9,'user.delete','xoá người dùng','2025-06-09 20:29:30','2025-06-09 20:29:30'),(10,'user.create','thêm người dùng','2025-06-09 20:29:35','2025-06-09 20:29:35'),(11,'user.edit','sửa người dùng','2025-06-09 20:29:46','2025-06-09 20:29:46'),(12,'user.other','danh sách người dùng','2025-06-09 20:29:50','2025-06-09 20:29:50'),(13,'role.create','thêm vai trò','2025-06-10 01:16:04','2025-06-10 01:16:04'),(14,'role.edit','sửa vai trò','2025-06-10 01:16:15','2025-06-10 01:16:15'),(15,'role.delete','xoá vai trò','2025-06-10 01:16:18','2025-06-10 01:16:18'),(16,'role.list','danh sách vai trò','2025-06-10 01:16:21','2025-06-10 01:16:21'),(17,'software.create','thêm phần mềm','2025-06-10 23:40:03','2025-06-10 23:40:03'),(18,'software.edit','sửa phần mềm','2025-06-10 23:40:10','2025-06-10 23:40:10'),(19,'software.delete','xoá phần mềm','2025-06-10 23:40:13','2025-06-10 23:40:13'),(20,'software.list','danh sách phần mềm','2025-06-10 23:40:16','2025-06-10 23:40:16'),(21,'hardware.create','thêm phần cứng','2025-06-10 23:40:24','2025-06-10 23:40:24'),(22,'hardware.edit','sửa phần cứng','2025-06-10 23:40:30','2025-06-10 23:40:30'),(23,'hardware.delete','xoá phần cứng','2025-06-10 23:40:46','2025-06-10 23:40:46'),(24,'hardware.list','danh sách phần cứng','2025-06-10 23:40:52','2025-06-10 23:40:52'),(25,'domain.create','thêm domain','2025-06-11 00:08:52','2025-06-11 00:08:52'),(26,'domain.edit','sửa domain','2025-06-11 00:09:00','2025-06-11 00:09:00'),(27,'domain.delete','xoá domain','2025-06-11 00:09:04','2025-06-11 00:09:04'),(28,'domain.list','danh sách domain','2025-06-11 00:09:18','2025-06-11 00:09:18'),(29,'hardwaredomain.create','thêm phần cứng vào domain','2025-06-11 00:09:43','2025-06-11 00:09:43'),(30,'hardwaredomain.delete','xoá phần cứng khỏi domain','2025-06-11 00:10:07','2025-06-11 00:10:07'),(31,'hardwaredomain.edit','thay đổi phần cứng trong domain','2025-06-11 00:11:07','2025-06-11 00:11:07'),(32,'hardwaredomain.list','danh sách phần cứng trong domain','2025-06-11 18:35:27','2025-06-11 18:35:27'),(33,'hardwarepermission.create','thêm người dùng quản lý phần cứng','2025-06-11 23:49:31','2025-06-11 23:49:31'),(34,'hardwarepermission.delete','xoá người dùng quản lý phần cứng','2025-06-11 23:49:46','2025-06-11 23:49:46'),(35,'hardwarepermission.edit','chỉnh sửa người dùng quản lý phần cứng','2025-06-11 23:49:51','2025-06-11 23:49:51'),(36,'hardwarepermission.list','danh sách người dùng quản lý phần cứng','2025-06-11 23:49:56','2025-06-11 23:49:56'),(37,'softwarepermission.create','thêm người dùng quản lý phần mềm','2025-06-11 23:53:09','2025-06-11 23:53:09'),(38,'softwarepermission.edit','sửa người dùng quản lý phần mềm','2025-06-11 23:53:24','2025-06-11 23:53:24'),(39,'softwarepermission.delete','xoá người dùng quản lý phần mềm','2025-06-11 23:53:27','2025-06-11 23:53:27'),(40,'softwarepermission.list','danh sách người dùng quản lý phần mềm','2025-06-11 23:53:34','2025-06-11 23:53:34'),(41,'hardware.get','xem phần cứng','2025-06-12 00:27:11','2025-06-12 00:27:11'),(42,'software.get','xem phần mềm','2025-06-12 00:27:21','2025-06-12 00:27:21');
/*!40000 ALTER TABLE `route_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('BkPr0HeAQxsayVpvBTh6VwgP2ZRgg4oOE3FQkh3s',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVZhNkxuTExhMjQwWVQ3RmtQUkMwdUxzVDczNExIcDFrTXFrZGFXMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1749717341);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `software`
--

LOCK TABLES `software` WRITE;
/*!40000 ALTER TABLE `software` DISABLE KEYS */;
INSERT INTO `software` VALUES (1,'phần mềm dịch tựu động','typeScript','5.6.1','nemosoftware',0,'đây là decription','2025-06-10 23:56:41','2025-06-10 23:56:41'),(2,'phần mềm quản lý quán ăn','typeScript','5.6.1','nemosoftware',0,'đây là decription','2025-06-10 23:57:33','2025-06-10 23:57:33');
/*!40000 ALTER TABLE `software` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `software_file`
--

LOCK TABLES `software_file` WRITE;
/*!40000 ALTER TABLE `software_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `software_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `software_permissions`
--

LOCK TABLES `software_permissions` WRITE;
/*!40000 ALTER TABLE `software_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `software_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'uchihanemo','Quản trị viên','2025-06-09 20:29:17','2025-06-09 20:29:17','2025-06-09 20:29:17'),(2,'nemosoftware','quản lý phần mềm','2025-06-10 23:45:01','2025-06-10 23:45:01','2025-06-10 23:45:01'),(8,'nemohardwareroom','phòng ban phần cứng','2025-06-12 00:22:11','2025-06-12 00:22:11','2025-06-12 00:22:11'),(9,'nemohardware','quản lý phần cứng','2025-06-12 00:30:44','2025-06-12 00:30:44','2025-06-12 00:30:44'),(12,'nemosystem','quản lý hệ thống','2025-06-12 01:00:43','2025-06-12 01:00:43','2025-06-12 01:00:43');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('nemohardware','$2y$12$SUJUygT1fOWMQDVriV2cPOuBnraDLHdr6i27GchV8A4Z4Cv/mfRRS',NULL,NULL,NULL,0,0,'2025-06-12 00:30:10','2025-06-12 00:30:10'),('nemohardwareroom','$2y$12$HfBkGQDGQ6TkZChgu1Dt0eNE1..YOOeXVDdmKJ3uAQ9qQoJ3OEiMq',NULL,NULL,NULL,0,0,'2025-06-12 00:21:53','2025-06-12 00:21:53'),('nemosoftware','$2y$12$xp1p./JNJdEQDpTg5BmYLuLFNhCAgqXFC9zBJzCpOvd74947KprZ6',NULL,NULL,NULL,0,0,'2025-06-10 23:43:53','2025-06-10 23:43:53'),('nemosystem','$2y$12$5ic2ak9YFlf4aXp3wVARSuHyQz8b0Wpl9MmmlISKkLM5wp2lwqh.y',NULL,NULL,NULL,0,0,'2025-06-11 00:00:52','2025-06-11 00:00:52'),('tiếng','$2y$12$fl/gr6noLNShICjqukFTyum2fB99JR/QB6dhloohLvYaJCXGa9O7C',NULL,NULL,NULL,0,0,'2025-06-10 01:12:31','2025-06-10 01:12:31'),('uchihanemo','$2y$12$Gvu7teGWGcS.HWmBmagjBOpkdfryCLQTHD9Zp5p164aXSDv7sJMa6',NULL,NULL,NULL,0,0,'2025-06-09 20:29:17','2025-06-09 20:29:17');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-14 13:27:57
