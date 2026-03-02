-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: farmacia_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_name_unique` (`name`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Bayer','bayer',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(2,'Pfizer','pfizer',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(3,'Roche','roche',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(4,'Novartis','novartis',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(5,'Sanofi','sanofi',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(6,'Abbott','abbott',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(7,'GlaxoSmithKline','glaxosmithkline',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(8,'AstraZeneca','astrazeneca',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(9,'Johnson & Johnson','johnson-&-johnson',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(10,'Merck','merck',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(11,'Teva','teva',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(12,'Amgen','amgen',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(13,'Eli Lilly','eli-lilly',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(14,'Takeda','takeda',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(15,'Boehringer Ingelheim','boehringer-ingelheim',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(16,'Bristol Myers','bristol-myers',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(17,'Gedeon Richter','gedeon-richter',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(18,'Almirall','almirall',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(19,'Sandoz','sandoz',1,'2026-02-15 23:12:31','2026-02-15 23:12:31'),(20,'Mylan','mylan',1,'2026-02-15 23:12:31','2026-02-15 23:12:31');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Analgésicos','analgésicos',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(2,'Antibióticos','antibióticos',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(3,'Antiinflamatorios','antiinflamatorios',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(4,'Antialérgicos','antialérgicos',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(5,'Vitaminas y Suplementos','vitaminas-y-suplementos',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(6,'Jarabes','jarabes',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(7,'Cremas y Pomadas','cremas-y-pomadas',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(8,'Higiene Personal','higiene-personal',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(9,'Cuidado del Bebé','cuidado-del-bebé',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(10,'Dermatología','dermatología',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(11,'Gastrointestinal','gastrointestinal',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(12,'Respiratorio','respiratorio',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(13,'Oftálmicos','oftálmicos',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(14,'Otológicos','otológicos',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(15,'Antigripales','antigripales',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(16,'Antipiréticos','antipiréticos',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(17,'Presión Arterial','presión-arterial',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(18,'Diabetes','diabetes',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(19,'Salud Sexual','salud-sexual',1,'2026-02-15 23:07:43','2026-02-15 23:07:43'),(20,'Primeros Auxilios','primeros-auxilios',1,'2026-02-15 23:07:43','2026-02-15 23:07:43');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Juan Pérez','88881234','juan.perez@gmail.com','Cristo Rey',1,NULL,NULL),(2,'María López','88882345','maria.lopez@gmail.com','Cristo Rey',1,NULL,NULL),(3,'Carlos Rodríguez','88883456','carlos.rodriguez@gmail.com','Cristo Rey',1,NULL,NULL),(4,'Ana Martínez','88884567','ana.martinez@gmail.com','Cristo Rey',1,NULL,NULL),(5,'Luis González','88885678','luis.gonzalez@gmail.com','Cristo Rey',1,NULL,NULL),(6,'Sofía Hernández','88886789','sofia.hernandez@gmail.com','Cristo Rey',1,NULL,NULL),(7,'Miguel Castillo','88887890','miguel.castillo@gmail.com','Cristo Rey',1,NULL,NULL),(8,'Daniela Ruiz','88888901','daniela.ruiz@gmail.com','Cristo Rey',1,NULL,NULL),(9,'José Morales','88889012','jose.morales@gmail.com','Cristo Rey',1,NULL,NULL),(10,'Karla Sánchez','88890123','karla.sanchez@gmail.com','Cristo Rey',1,NULL,NULL),(11,'Ricardo Flores','88891234','ricardo.flores@gmail.com','Cristo Rey',1,NULL,NULL),(12,'Paola Rivera','88892345','paola.rivera@gmail.com','Cristo Rey',1,NULL,NULL),(13,'Fernando Reyes','88893456','fernando.reyes@gmail.com','Cristo Rey',1,NULL,NULL),(14,'Valeria Gómez','88894567','valeria.gomez@gmail.com','Cristo Rey',1,NULL,NULL),(15,'Kevin Aguilar','88895678','kevin.aguilar@gmail.com','Cristo Rey',1,NULL,NULL),(16,'Andrea Navarro','88896789','andrea.navarro@gmail.com','Cristo Rey',1,NULL,NULL),(17,'Javier Ortega','88897890','javier.ortega@gmail.com','Cristo Rey',1,NULL,NULL),(18,'Camila Torres','88898901','camila.torres@gmail.com','Cristo Rey',1,NULL,NULL),(19,'Erick Mendoza','88899012','erick.mendoza@gmail.com','Cristo Rey',1,NULL,NULL),(20,'Melissa Vargas','88900123','melissa.vargas@gmail.com','Cristo Rey',1,NULL,NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_02_15_061352_create_roles_table',2),(5,'2026_02_15_061450_create_permissions_table',2),(6,'2026_02_15_061511_create_role_user_table',2),(7,'2026_02_15_061528_create_permission_role_table',2),(8,'2026_02_15_061541_create_categories_table',2),(9,'2026_02_15_061551_create_brands_table',2),(10,'2026_02_15_061601_create_suppliers_table',2),(11,'2026_02_15_061610_create_customers_table',2),(12,'2026_02_15_061619_create_products_table',2),(13,'2026_02_15_061635_create_sales_table',2),(14,'2026_02_15_061644_create_sale_items_table',2),(15,'2026_02_15_061652_create_purchases_table',2),(16,'2026_02_15_061702_create_purchase_items_table',2),(17,'2026_02_15_061713_create_stock_movements_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_role_permission_id_role_id_unique` (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_min` int(11) NOT NULL DEFAULT 0,
  `expires_at` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_name_index` (`name`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'PRD-0002','Ibuprofeno 400 mg (Tabletas x 10)','Antiinflamatorio y analgésico. Caja con 10 tabletas.',3,6,22.00,30.00,32,10,'2027-04-30',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(2,'PRD-0003','Diclofenaco 50 mg (Tabletas x 10)','Antiinflamatorio para dolor muscular y articular.',3,4,25.00,35.00,20,8,'2027-03-31',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(3,'PRD-0004','Naproxeno 500 mg (Tabletas x 10)','Antiinflamatorio no esteroideo. Caja con 10 tabletas.',3,2,30.00,42.00,8,6,'2027-05-31',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(4,'PRD-0008','Ambroxol Jarabe 15 mg/5 ml (120 ml)','Mucolítico/expectorante. Frasco 120 ml.',6,1,40.00,55.00,0,5,'2026-12-31',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(5,'PRD-0010','Vitamina C 500 mg (Tabletas x 20)','Suplemento de vitamina C. Presentación x 20 tabletas.',5,1,35.00,48.00,24,10,'2027-10-31',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(6,'PRD-0011','Complejo B (Tabletas x 30)','Suplemento de vitaminas del complejo B. 30 tabletas.',5,10,55.00,75.00,20,8,'2027-09-30',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(7,'PRD-0012','Clotrimazol Crema 1% (20 g)','Antimicótico tópico. Tubo 20 g.',7,1,28.00,40.00,23,6,'2027-11-30',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(8,'PRD-0013','Hidrocortisona Crema 1% (15 g)','Corticoide tópico. Tubo 15 g.',7,2,32.00,45.00,0,5,'2027-06-30',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(9,'PRD-0014','Omeprazol 20 mg (Cápsulas x 14)','Inhibidor de bomba de protones. Caja x 14 cápsulas.',11,8,65.00,85.00,16,6,'2027-05-31',1,'2026-02-16 05:16:34','2026-02-16 09:42:03'),(10,'PRD-0015','Sales de Rehidratación Oral (Sobre)','Sobre para rehidratación oral.',11,5,6.00,10.00,111,20,'2027-12-31',1,'2026-02-16 05:16:34','2026-02-16 09:42:03');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_items_purchase_id_product_id_unique` (`purchase_id`,`product_id`),
  KEY `purchase_items_product_id_foreign` (`product_id`),
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_items`
--

LOCK TABLES `purchase_items` WRITE;
/*!40000 ALTER TABLE `purchase_items` DISABLE KEYS */;
INSERT INTO `purchase_items` VALUES (1,1,5,3,35.00,105.00,'2025-12-19 22:37:00','2025-12-19 22:37:00'),(2,1,2,3,25.00,75.00,'2025-12-19 22:37:00','2025-12-19 22:37:00'),(3,1,9,20,65.00,1300.00,'2025-12-19 22:37:00','2025-12-19 22:37:00'),(4,2,8,12,32.00,384.00,'2026-01-01 20:23:00','2026-01-01 20:23:00'),(5,2,6,9,55.00,495.00,'2026-01-01 20:23:00','2026-01-01 20:23:00'),(6,2,5,14,35.00,490.00,'2026-01-01 20:23:00','2026-01-01 20:23:00'),(7,3,4,3,40.00,120.00,'2025-12-03 18:26:00','2025-12-03 18:26:00'),(8,3,9,6,65.00,390.00,'2025-12-03 18:26:00','2025-12-03 18:26:00'),(9,3,3,16,30.00,480.00,'2025-12-03 18:26:00','2025-12-03 18:26:00'),(10,4,9,13,65.00,845.00,'2025-12-07 14:04:00','2025-12-07 14:04:00'),(11,4,5,14,35.00,490.00,'2025-12-07 14:04:00','2025-12-07 14:04:00'),(12,4,6,19,55.00,1045.00,'2025-12-07 14:04:00','2025-12-07 14:04:00'),(13,4,2,17,25.00,425.00,'2025-12-07 14:04:00','2025-12-07 14:04:00'),(14,4,4,10,40.00,400.00,'2025-12-07 14:04:00','2025-12-07 14:04:00'),(15,5,1,9,22.00,198.00,'2025-12-29 15:34:00','2025-12-29 15:34:00'),(16,5,3,18,30.00,540.00,'2025-12-29 15:34:00','2025-12-29 15:34:00'),(17,6,1,12,22.00,264.00,'2026-01-06 22:54:00','2026-01-06 22:54:00'),(18,6,7,18,28.00,504.00,'2026-01-06 22:54:00','2026-01-06 22:54:00'),(19,6,3,13,30.00,390.00,'2026-01-06 22:54:00','2026-01-06 22:54:00'),(20,6,9,3,65.00,195.00,'2026-01-06 22:54:00','2026-01-06 22:54:00'),(21,7,5,10,35.00,350.00,'2025-11-30 20:33:00','2025-11-30 20:33:00'),(22,7,7,15,28.00,420.00,'2025-11-30 20:33:00','2025-11-30 20:33:00'),(23,7,1,17,22.00,374.00,'2025-11-30 20:33:00','2025-11-30 20:33:00'),(24,7,4,10,40.00,400.00,'2025-11-30 20:33:00','2025-11-30 20:33:00'),(25,7,9,5,65.00,325.00,'2025-11-30 20:33:00','2025-11-30 20:33:00'),(26,8,10,7,6.00,42.00,'2025-12-15 21:39:00','2025-12-15 21:39:00'),(27,8,4,4,40.00,160.00,'2025-12-15 21:39:00','2025-12-15 21:39:00'),(28,9,10,9,6.00,54.00,'2026-02-09 14:50:00','2026-02-09 14:50:00'),(29,9,2,20,25.00,500.00,'2026-02-09 14:50:00','2026-02-09 14:50:00'),(30,9,7,7,28.00,196.00,'2026-02-09 14:50:00','2026-02-09 14:50:00'),(31,10,6,8,55.00,440.00,'2026-01-16 19:57:00','2026-01-16 19:57:00'),(32,10,2,16,25.00,400.00,'2026-01-16 19:57:00','2026-01-16 19:57:00'),(33,10,8,20,32.00,640.00,'2026-01-16 19:57:00','2026-01-16 19:57:00'),(34,10,9,4,65.00,260.00,'2026-01-16 19:57:00','2026-01-16 19:57:00'),(35,11,3,19,30.00,570.00,'2026-01-20 22:09:00','2026-01-20 22:09:00'),(36,11,2,14,25.00,350.00,'2026-01-20 22:09:00','2026-01-20 22:09:00'),(37,12,10,3,6.00,18.00,'2025-12-14 16:06:00','2025-12-14 16:06:00'),(38,12,8,4,32.00,128.00,'2025-12-14 16:06:00','2025-12-14 16:06:00'),(39,12,3,20,30.00,600.00,'2025-12-14 16:06:00','2025-12-14 16:06:00'),(40,12,2,20,25.00,500.00,'2025-12-14 16:06:00','2025-12-14 16:06:00'),(41,12,9,4,65.00,260.00,'2025-12-14 16:06:00','2025-12-14 16:06:00'),(42,13,5,13,35.00,455.00,'2026-01-23 17:38:00','2026-01-23 17:38:00'),(43,13,4,16,40.00,640.00,'2026-01-23 17:38:00','2026-01-23 17:38:00'),(44,13,2,6,25.00,150.00,'2026-01-23 17:38:00','2026-01-23 17:38:00'),(45,13,7,12,28.00,336.00,'2026-01-23 17:38:00','2026-01-23 17:38:00'),(46,14,4,7,40.00,280.00,'2025-12-23 14:24:00','2025-12-23 14:24:00'),(47,14,6,18,55.00,990.00,'2025-12-23 14:24:00','2025-12-23 14:24:00'),(48,15,5,6,35.00,210.00,'2026-02-02 20:52:00','2026-02-02 20:52:00'),(49,15,3,3,30.00,90.00,'2026-02-02 20:52:00','2026-02-02 20:52:00'),(50,15,6,17,55.00,935.00,'2026-02-02 20:52:00','2026-02-02 20:52:00'),(51,16,10,14,6.00,84.00,'2025-11-19 15:39:00','2025-11-19 15:39:00'),(52,16,5,13,35.00,455.00,'2025-11-19 15:39:00','2025-11-19 15:39:00'),(53,17,2,4,25.00,100.00,'2026-01-04 19:51:00','2026-01-04 19:51:00'),(54,17,6,8,55.00,440.00,'2026-01-04 19:51:00','2026-01-04 19:51:00'),(55,18,7,14,28.00,392.00,'2026-01-18 17:03:00','2026-01-18 17:03:00'),(56,18,9,12,65.00,780.00,'2026-01-18 17:03:00','2026-01-18 17:03:00'),(57,18,5,18,35.00,630.00,'2026-01-18 17:03:00','2026-01-18 17:03:00'),(58,18,3,9,30.00,270.00,'2026-01-18 17:03:00','2026-01-18 17:03:00'),(59,18,2,11,25.00,275.00,'2026-01-18 17:03:00','2026-01-18 17:03:00'),(60,19,3,3,30.00,90.00,'2025-11-30 17:02:00','2025-11-30 17:02:00'),(61,19,1,16,22.00,352.00,'2025-11-30 17:02:00','2025-11-30 17:02:00'),(62,19,5,11,35.00,385.00,'2025-11-30 17:02:00','2025-11-30 17:02:00'),(63,19,4,18,40.00,720.00,'2025-11-30 17:02:00','2025-11-30 17:02:00'),(64,19,7,18,28.00,504.00,'2025-11-30 17:02:00','2025-11-30 17:02:00'),(65,20,7,9,28.00,252.00,'2026-02-05 15:59:00','2026-02-05 15:59:00'),(66,20,4,17,40.00,680.00,'2026-02-05 15:59:00','2026-02-05 15:59:00'),(67,20,1,13,22.00,286.00,'2026-02-05 15:59:00','2026-02-05 15:59:00'),(68,20,10,17,6.00,102.00,'2026-02-05 15:59:00','2026-02-05 15:59:00'),(69,20,3,16,30.00,480.00,'2026-02-05 15:59:00','2026-02-05 15:59:00'),(70,21,4,12,40.00,480.00,'2026-01-26 20:32:00','2026-01-26 20:32:00'),(71,21,9,11,65.00,715.00,'2026-01-26 20:32:00','2026-01-26 20:32:00'),(72,21,10,11,6.00,66.00,'2026-01-26 20:32:00','2026-01-26 20:32:00'),(73,21,1,3,22.00,66.00,'2026-01-26 20:32:00','2026-01-26 20:32:00'),(74,22,10,10,6.00,60.00,'2025-11-23 19:25:00','2025-11-23 19:25:00'),(75,22,8,4,32.00,128.00,'2025-11-23 19:25:00','2025-11-23 19:25:00'),(76,23,4,19,40.00,760.00,'2026-01-30 14:17:00','2026-01-30 14:17:00'),(77,23,3,4,30.00,120.00,'2026-01-30 14:17:00','2026-01-30 14:17:00'),(78,23,10,6,6.00,36.00,'2026-01-30 14:17:00','2026-01-30 14:17:00'),(79,23,6,20,55.00,1100.00,'2026-01-30 14:17:00','2026-01-30 14:17:00'),(80,23,9,12,65.00,780.00,'2026-01-30 14:17:00','2026-01-30 14:17:00'),(81,24,10,11,6.00,66.00,'2026-01-10 20:39:00','2026-01-10 20:39:00'),(82,24,8,6,32.00,192.00,'2026-01-10 20:39:00','2026-01-10 20:39:00'),(83,25,7,12,28.00,336.00,'2026-01-01 18:09:00','2026-01-01 18:09:00'),(84,25,4,20,40.00,800.00,'2026-01-01 18:09:00','2026-01-01 18:09:00'),(85,25,8,13,32.00,416.00,'2026-01-01 18:09:00','2026-01-01 18:09:00');
/*!40000 ALTER TABLE `purchase_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_number` varchar(255) NOT NULL,
  `supplier_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `purchased_at` datetime NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'recibida',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchases_purchase_number_unique` (`purchase_number`),
  KEY `purchases_supplier_id_foreign` (`supplier_id`),
  KEY `purchases_user_id_foreign` (`user_id`),
  KEY `purchases_purchased_at_index` (`purchased_at`),
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,'COMP-20251219-0001',13,2,'2025-12-19 16:37:00',1480.00,222.00,74.00,1628.00,'completed','2025-12-19 22:37:00','2025-12-19 22:37:00'),(2,'COMP-20260101-0002',18,2,'2026-01-01 14:23:00',1369.00,205.35,27.38,1546.97,'completed','2026-01-01 20:23:00','2026-01-01 20:23:00'),(3,'COMP-20251203-0003',8,3,'2025-12-03 12:26:00',990.00,148.50,49.50,1089.00,'pending','2025-12-03 18:26:00','2025-12-03 18:26:00'),(4,'COMP-20251207-0004',17,1,'2025-12-07 08:04:00',3205.00,480.75,64.10,3621.65,'pending','2025-12-07 14:04:00','2025-12-07 14:04:00'),(5,'COMP-20251229-0005',6,1,'2025-12-29 09:34:00',738.00,110.70,59.04,789.66,'completed','2025-12-29 15:34:00','2025-12-29 15:34:00'),(6,'COMP-20260106-0006',10,2,'2026-01-06 16:54:00',1353.00,202.95,108.24,1447.71,'completed','2026-01-06 22:54:00','2026-01-06 22:54:00'),(7,'COMP-20251130-0007',15,3,'2025-11-30 14:33:00',1869.00,280.35,18.69,2130.66,'completed','2025-11-30 20:33:00','2025-11-30 20:33:00'),(8,'COMP-20251215-0008',12,3,'2025-12-15 15:39:00',202.00,30.30,0.00,232.30,'pending','2025-12-15 21:39:00','2025-12-15 21:39:00'),(9,'COMP-20260209-0009',16,2,'2026-02-09 08:50:00',750.00,112.50,60.00,802.50,'completed','2026-02-09 14:50:00','2026-02-09 14:50:00'),(10,'COMP-20260116-0010',16,2,'2026-01-16 13:57:00',1740.00,261.00,121.80,1879.20,'completed','2026-01-16 19:57:00','2026-01-16 19:57:00'),(11,'COMP-20260120-0011',5,3,'2026-01-20 16:09:00',920.00,138.00,9.20,1048.80,'completed','2026-01-20 22:09:00','2026-01-20 22:09:00'),(12,'COMP-20251214-0012',5,1,'2025-12-14 10:06:00',1506.00,225.90,15.06,1716.84,'completed','2025-12-14 16:06:00','2025-12-14 16:06:00'),(13,'COMP-20260123-0013',7,2,'2026-01-23 11:38:00',1581.00,237.15,79.05,1739.10,'completed','2026-01-23 17:38:00','2026-01-23 17:38:00'),(14,'COMP-20251223-0014',12,3,'2025-12-23 08:24:00',1270.00,190.50,88.90,1371.60,'completed','2025-12-23 14:24:00','2025-12-23 14:24:00'),(15,'COMP-20260202-0015',17,3,'2026-02-02 14:52:00',1235.00,185.25,74.10,1346.15,'pending','2026-02-02 20:52:00','2026-02-02 20:52:00'),(16,'COMP-20251119-0016',15,3,'2025-11-19 09:39:00',539.00,80.85,0.00,619.85,'completed','2025-11-19 15:39:00','2025-11-19 15:39:00'),(17,'COMP-20260104-0017',1,1,'2026-01-04 13:51:00',540.00,81.00,5.40,615.60,'completed','2026-01-04 19:51:00','2026-01-04 19:51:00'),(18,'COMP-20260118-0018',17,1,'2026-01-18 11:03:00',2347.00,352.05,23.47,2675.58,'completed','2026-01-18 17:03:00','2026-01-18 17:03:00'),(19,'COMP-20251130-0019',9,2,'2025-11-30 11:02:00',2051.00,307.65,61.53,2297.12,'completed','2025-11-30 17:02:00','2025-11-30 17:02:00'),(20,'COMP-20260205-0020',9,2,'2026-02-05 09:59:00',1800.00,270.00,72.00,1998.00,'completed','2026-02-05 15:59:00','2026-02-05 15:59:00'),(21,'COMP-20260126-0021',11,2,'2026-01-26 14:32:00',1327.00,199.05,53.08,1472.97,'completed','2026-01-26 20:32:00','2026-01-26 20:32:00'),(22,'COMP-20251123-0022',9,1,'2025-11-23 13:25:00',188.00,28.20,3.76,212.44,'completed','2025-11-23 19:25:00','2025-11-23 19:25:00'),(23,'COMP-20260130-0023',20,1,'2026-01-30 08:17:00',2796.00,419.40,0.00,3215.40,'completed','2026-01-30 14:17:00','2026-01-30 14:17:00'),(24,'COMP-20260110-0024',19,1,'2026-01-10 14:39:00',258.00,38.70,5.16,291.54,'completed','2026-01-10 20:39:00','2026-01-10 20:39:00'),(25,'COMP-20260101-0025',9,2,'2026-01-01 12:09:00',1552.00,232.80,124.16,1660.64,'completed','2026-01-01 18:09:00','2026-01-01 18:09:00');
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_user_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','admin',NULL,NULL),(2,'Vendedor','vendedor',NULL,NULL),(3,'Consulta','consulta',NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_items`
--

DROP TABLE IF EXISTS `sale_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sale_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sale_items_sale_id_product_id_unique` (`sale_id`,`product_id`),
  KEY `sale_items_product_id_foreign` (`product_id`),
  CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_items`
--

LOCK TABLES `sale_items` WRITE;
/*!40000 ALTER TABLE `sale_items` DISABLE KEYS */;
INSERT INTO `sale_items` VALUES (1,1,2,2,35.00,70.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(2,1,6,3,75.00,225.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(3,1,8,1,45.00,45.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(4,1,1,3,30.00,90.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(5,2,9,3,85.00,255.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(6,2,2,3,35.00,105.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(7,2,8,2,45.00,90.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(8,2,3,2,42.00,84.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(9,3,8,3,45.00,135.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(10,3,4,3,55.00,165.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(11,3,10,2,10.00,20.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(12,4,3,2,42.00,84.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(13,4,4,3,55.00,165.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(14,4,1,1,30.00,30.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(15,4,6,1,75.00,75.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(16,5,9,1,85.00,85.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(17,6,2,1,35.00,35.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(18,6,6,1,75.00,75.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(19,7,4,1,55.00,55.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(20,7,1,2,30.00,60.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(21,7,8,3,45.00,135.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(22,7,6,2,75.00,150.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(23,8,2,1,35.00,35.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(24,8,9,1,85.00,85.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(25,8,8,3,45.00,135.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(26,9,3,3,42.00,126.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(27,10,4,3,55.00,165.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(28,11,10,2,10.00,20.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(29,11,3,1,42.00,42.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(30,11,5,2,48.00,96.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(31,11,4,3,55.00,165.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(32,12,5,3,48.00,144.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(33,12,6,2,75.00,150.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(34,12,8,2,45.00,90.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(35,12,2,1,35.00,35.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(36,13,4,1,55.00,55.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(37,13,2,2,35.00,70.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(38,13,8,1,45.00,45.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(39,13,3,1,42.00,42.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(40,13,9,1,85.00,85.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(41,14,3,2,42.00,84.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(42,14,1,2,30.00,60.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(43,14,5,2,48.00,96.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(44,14,10,2,10.00,20.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(45,15,4,3,55.00,165.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(46,15,10,2,10.00,20.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(47,15,5,2,48.00,96.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(48,15,7,1,40.00,40.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(49,16,8,3,45.00,135.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(50,17,1,3,30.00,90.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(51,18,2,2,35.00,70.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(52,18,4,1,55.00,55.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(53,18,5,3,48.00,144.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(54,18,8,2,45.00,90.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(55,19,7,1,40.00,40.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(56,20,6,3,75.00,225.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(57,20,3,3,42.00,126.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(58,20,4,2,55.00,110.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(59,20,10,1,10.00,10.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(60,21,1,2,30.00,60.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(61,21,5,3,48.00,144.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(62,21,2,2,35.00,70.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(63,21,3,1,42.00,42.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(64,21,9,1,85.00,85.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(65,22,9,2,85.00,170.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(66,22,7,1,40.00,40.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(67,22,1,2,30.00,60.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(68,22,5,3,48.00,144.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(69,22,4,2,55.00,110.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(70,23,3,2,42.00,84.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(71,23,1,3,30.00,90.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(72,23,5,3,48.00,144.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(73,23,2,3,35.00,105.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(74,24,2,3,35.00,105.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(75,24,1,3,30.00,90.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(76,24,9,3,85.00,255.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(77,24,3,3,42.00,126.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(78,25,1,2,30.00,60.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(79,25,7,2,40.00,80.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(80,25,6,3,75.00,225.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(81,25,9,2,85.00,170.00,'2026-02-16 09:42:03','2026-02-16 09:42:03'),(82,25,3,2,42.00,84.00,'2026-02-16 09:42:03','2026-02-16 09:42:03');
/*!40000 ALTER TABLE `sale_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `sold_at` datetime NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) NOT NULL DEFAULT 'efectivo',
  `status` varchar(255) NOT NULL DEFAULT 'completada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  KEY `sales_customer_id_foreign` (`customer_id`),
  KEY `sales_user_id_foreign` (`user_id`),
  KEY `sales_sold_at_index` (`sold_at`),
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'VTA-9TGNMUBX',13,2,'2026-01-31 15:59:03',430.00,64.50,43.00,451.50,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(2,'VTA-HNVTRFJE',8,2,'2026-02-11 09:50:03',534.00,80.10,53.40,560.70,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(3,'VTA-PWDQGC7D',3,1,'2026-02-04 15:32:03',320.00,48.00,32.00,336.00,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(4,'VTA-ZUNSNEMA',17,2,'2026-01-17 00:51:03',354.00,53.10,35.40,371.70,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(5,'VTA-MZY6FXCI',13,3,'2026-01-26 09:54:03',85.00,12.75,0.00,97.75,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(6,'VTA-EF4XLWUP',16,3,'2026-02-01 09:14:03',110.00,16.50,0.00,126.50,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(7,'VTA-PAINT92A',13,3,'2026-02-07 20:22:03',400.00,60.00,40.00,420.00,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(8,'VTA-NBLNSI0D',2,3,'2026-02-06 05:03:03',255.00,38.25,25.50,267.75,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(9,'VTA-NBYDDBAX',14,2,'2026-01-29 08:59:03',126.00,18.90,0.00,144.90,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(10,'VTA-MZFJDMNW',20,2,'2026-02-10 22:45:03',165.00,24.75,8.25,181.50,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(11,'VTA-YKXK4YSX',16,1,'2026-01-28 08:11:03',323.00,48.45,0.00,371.45,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(12,'VTA-3YR44C2U',20,2,'2026-02-06 02:18:03',419.00,62.85,20.95,460.90,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(13,'VTA-3QB46AM9',9,2,'2026-02-13 18:02:03',297.00,44.55,29.70,311.85,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(14,'VTA-XFEDYZFZ',10,3,'2026-01-29 06:23:03',260.00,39.00,26.00,273.00,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(15,'VTA-D4BBAMCW',8,3,'2026-01-19 23:52:03',321.00,48.15,16.05,353.10,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(16,'VTA-ZPPLF330',10,2,'2026-02-13 01:02:03',135.00,20.25,0.00,155.25,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(17,'VTA-QH5CRL4L',15,2,'2026-01-31 16:49:03',90.00,13.50,9.00,94.50,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(18,'VTA-ZWLJIR9L',10,3,'2026-01-25 14:29:03',359.00,53.85,0.00,412.85,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(19,'VTA-VDTW0ZKU',16,3,'2026-01-19 22:15:03',40.00,6.00,0.00,46.00,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(20,'VTA-K33V9GZT',1,3,'2026-02-03 18:04:03',471.00,70.65,0.00,541.65,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(21,'VTA-UUFJFD5Z',10,1,'2026-02-04 05:07:03',401.00,60.15,40.10,421.05,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(22,'VTA-VDDIMLOS',1,2,'2026-02-09 02:41:03',524.00,78.60,52.40,550.20,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(23,'VTA-DXE0Y1FX',18,3,'2026-01-24 13:55:03',423.00,63.45,42.30,444.15,'tarjeta','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(24,'VTA-2BPUCMEN',2,1,'2026-01-17 15:10:03',576.00,86.40,28.80,633.60,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03'),(25,'VTA-TXRXP7IW',8,1,'2026-01-26 11:08:03',619.00,92.85,0.00,711.85,'efectivo','completada','2026-02-16 09:42:03','2026-02-16 09:42:03');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('58mzk6xhpJ4WGb3GqzhU8sFakTaXK5NoOzdNKC3Z',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUJWbjZZdXFuUlVqajllakJQOWZ2YzdLaDhmbWFKdE9lbk1Fc1F6NyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wdXJjaGFzZXMvMjAiO3M6NToicm91dGUiO3M6MTQ6InB1cmNoYXNlcy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1771441486),('6vXUbAh450pftkOCQvEsmcSMyysnIm26NDSEK4AF',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlJKeXN1Q0xWVmhveG43dUFITXlzRE94bmQ4dzZDRkljcTR1TXhuaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXBvcnRzL3NhbGVzL2V4cG9ydD9mcm9tPTIwMjYtMDEtMDEmdG89MjAyNi0xMi0zMSI7czo1OiJyb3V0ZSI7czoyMDoicmVwb3J0cy5zYWxlcy5leHBvcnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1771785993),('9AwF60IbiwobMQ0thnV7FaNhfx8RokaRZjfdyXND',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzFkY2hSQ3EyRmg3cFFUYXJPSmpaNnU4NDZMMXZScUNjNnRrYW9xdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnZvaWNlcy8xL3BkZiI7czo1OiJyb3V0ZSI7czoxMjoiaW52b2ljZXMucGRmIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1771766485),('AMXbaxPTzBMJCrq2sO2NJokJV14dlPDeZT2qdTkt',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoic3VzaVJ1U1phUXZMWWhibmpkbTlXUUNDOUR2ajg4NGZhNXpuaW9QRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9iYWNrdXAiO3M6NToicm91dGUiO3M6MTI6ImJhY2t1cC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1772167718),('BOBipdsWW3qnsBKrKoJUZauSQTcdZ0bcvFu3giZu',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2dJWVVkV1pGdktHenZNbmMwSE9QSWZzRGpxS3dRU1Y2OThxWWx1diI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnZvaWNlcy8xL3BkZiI7czo1OiJyb3V0ZSI7czoxMjoiaW52b2ljZXMucGRmIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1771561103),('lNsSPtXCeHF3cQ2JgAyYhcfL9VW0Nvee9I8MneRJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiT094THVreEFMSHRXVlR4UWNKVTlweGVNN3JKaHFSVkNpTnZ0NmRuMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9iYWNrdXAiO3M6NToicm91dGUiO3M6MTI6ImJhY2t1cC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1772087047),('p4J6N61VpQKs4xzuvI0mzNBjnVoO96U5X72hpC0N',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVFTWHZxRVBpMzhoRzJ4TlducDdGaWV5a3RPamlkcFpGekt4ZURoUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9iYWNrdXAiO3M6NToicm91dGUiO3M6MTI6ImJhY2t1cC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1772086180),('q3WoYCzJNsrfTUB4K4qSh5jz1WU6GRwXuVGHSRYA',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVW1HbnJPZ3FVdFV2MzhMRTBmMjZOTWtVUHpaWHhNWXdjdU94ZEV3ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnZvaWNlcy8xIjtzOjU6InJvdXRlIjtzOjEzOiJpbnZvaWNlcy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1771644086),('SdpVpEigpeycO7kHLtjikrApW2X0Okby4lRkzlPk',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWNXb2VDN2NYY3pvQnVIWmZNb1FuU2lMODVGUWdNZmtmWnZYQktMYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1771484917),('VDAmSHlnFYm3JZRRx7bRHxa8HU6JA4UnUla1kURq',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSDNHdjc1UWQ4U3d5dXVwQVhlTjEzcFZHeFJGOVY5Wm5udzZpMG9pTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9iYWNrdXAiO3M6NToicm91dGUiO3M6MTI6ImJhY2t1cC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1772282095);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_movements`
--

DROP TABLE IF EXISTS `stock_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_movements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `sale_id` bigint(20) unsigned DEFAULT NULL,
  `purchase_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `moved_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_movements_product_id_foreign` (`product_id`),
  KEY `stock_movements_sale_id_foreign` (`sale_id`),
  KEY `stock_movements_purchase_id_foreign` (`purchase_id`),
  KEY `stock_movements_user_id_foreign` (`user_id`),
  KEY `stock_movements_moved_at_index` (`moved_at`),
  CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `stock_movements_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_movements_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_movements`
--

LOCK TABLES `stock_movements` WRITE;
/*!40000 ALTER TABLE `stock_movements` DISABLE KEYS */;
INSERT INTO `stock_movements` VALUES (1,2,'in',3,'Compra de proveedor',NULL,1,2,'2025-12-19 16:37:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(2,5,'in',3,'Compra de proveedor',NULL,1,2,'2025-12-19 16:37:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(3,9,'in',20,'Compra de proveedor',NULL,1,2,'2025-12-19 16:37:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(4,5,'in',14,'Compra de proveedor',NULL,2,2,'2026-01-01 14:23:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(5,6,'in',9,'Compra de proveedor',NULL,2,2,'2026-01-01 14:23:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(6,8,'in',12,'Compra de proveedor',NULL,2,2,'2026-01-01 14:23:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(7,3,'in',16,'Compra de proveedor',NULL,3,3,'2025-12-03 12:26:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(8,4,'in',3,'Compra de proveedor',NULL,3,3,'2025-12-03 12:26:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(9,9,'in',6,'Compra de proveedor',NULL,3,3,'2025-12-03 12:26:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(10,2,'in',17,'Compra de proveedor',NULL,4,1,'2025-12-07 08:04:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(11,4,'in',10,'Compra de proveedor',NULL,4,1,'2025-12-07 08:04:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(12,5,'in',14,'Compra de proveedor',NULL,4,1,'2025-12-07 08:04:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(13,6,'in',19,'Compra de proveedor',NULL,4,1,'2025-12-07 08:04:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(14,9,'in',13,'Compra de proveedor',NULL,4,1,'2025-12-07 08:04:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(15,1,'in',9,'Compra de proveedor',NULL,5,1,'2025-12-29 09:34:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(16,3,'in',18,'Compra de proveedor',NULL,5,1,'2025-12-29 09:34:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(17,1,'in',12,'Compra de proveedor',NULL,6,2,'2026-01-06 16:54:00','2026-02-16 09:22:34','2026-02-16 09:22:34'),(18,3,'in',13,'Compra de proveedor',NULL,6,2,'2026-01-06 16:54:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(19,7,'in',18,'Compra de proveedor',NULL,6,2,'2026-01-06 16:54:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(20,9,'in',3,'Compra de proveedor',NULL,6,2,'2026-01-06 16:54:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(21,1,'in',17,'Compra de proveedor',NULL,7,3,'2025-11-30 14:33:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(22,4,'in',10,'Compra de proveedor',NULL,7,3,'2025-11-30 14:33:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(23,5,'in',10,'Compra de proveedor',NULL,7,3,'2025-11-30 14:33:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(24,7,'in',15,'Compra de proveedor',NULL,7,3,'2025-11-30 14:33:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(25,9,'in',5,'Compra de proveedor',NULL,7,3,'2025-11-30 14:33:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(26,4,'in',4,'Compra de proveedor',NULL,8,3,'2025-12-15 15:39:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(27,10,'in',7,'Compra de proveedor',NULL,8,3,'2025-12-15 15:39:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(28,2,'in',20,'Compra de proveedor',NULL,9,2,'2026-02-09 08:50:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(29,7,'in',7,'Compra de proveedor',NULL,9,2,'2026-02-09 08:50:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(30,10,'in',9,'Compra de proveedor',NULL,9,2,'2026-02-09 08:50:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(31,2,'in',16,'Compra de proveedor',NULL,10,2,'2026-01-16 13:57:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(32,6,'in',8,'Compra de proveedor',NULL,10,2,'2026-01-16 13:57:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(33,8,'in',20,'Compra de proveedor',NULL,10,2,'2026-01-16 13:57:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(34,9,'in',4,'Compra de proveedor',NULL,10,2,'2026-01-16 13:57:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(35,2,'in',14,'Compra de proveedor',NULL,11,3,'2026-01-20 16:09:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(36,3,'in',19,'Compra de proveedor',NULL,11,3,'2026-01-20 16:09:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(37,2,'in',20,'Compra de proveedor',NULL,12,1,'2025-12-14 10:06:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(38,3,'in',20,'Compra de proveedor',NULL,12,1,'2025-12-14 10:06:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(39,8,'in',4,'Compra de proveedor',NULL,12,1,'2025-12-14 10:06:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(40,9,'in',4,'Compra de proveedor',NULL,12,1,'2025-12-14 10:06:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(41,10,'in',3,'Compra de proveedor',NULL,12,1,'2025-12-14 10:06:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(42,2,'in',6,'Compra de proveedor',NULL,13,2,'2026-01-23 11:38:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(43,4,'in',16,'Compra de proveedor',NULL,13,2,'2026-01-23 11:38:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(44,5,'in',13,'Compra de proveedor',NULL,13,2,'2026-01-23 11:38:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(45,7,'in',12,'Compra de proveedor',NULL,13,2,'2026-01-23 11:38:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(46,4,'in',7,'Compra de proveedor',NULL,14,3,'2025-12-23 08:24:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(47,6,'in',18,'Compra de proveedor',NULL,14,3,'2025-12-23 08:24:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(48,3,'in',3,'Compra de proveedor',NULL,15,3,'2026-02-02 14:52:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(49,5,'in',6,'Compra de proveedor',NULL,15,3,'2026-02-02 14:52:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(50,6,'in',17,'Compra de proveedor',NULL,15,3,'2026-02-02 14:52:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(51,5,'in',13,'Compra de proveedor',NULL,16,3,'2025-11-19 09:39:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(52,10,'in',14,'Compra de proveedor',NULL,16,3,'2025-11-19 09:39:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(53,2,'in',4,'Compra de proveedor',NULL,17,1,'2026-01-04 13:51:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(54,6,'in',8,'Compra de proveedor',NULL,17,1,'2026-01-04 13:51:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(55,2,'in',11,'Compra de proveedor',NULL,18,1,'2026-01-18 11:03:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(56,3,'in',9,'Compra de proveedor',NULL,18,1,'2026-01-18 11:03:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(57,5,'in',18,'Compra de proveedor',NULL,18,1,'2026-01-18 11:03:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(58,7,'in',14,'Compra de proveedor',NULL,18,1,'2026-01-18 11:03:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(59,9,'in',12,'Compra de proveedor',NULL,18,1,'2026-01-18 11:03:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(60,1,'in',16,'Compra de proveedor',NULL,19,2,'2025-11-30 11:02:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(61,3,'in',3,'Compra de proveedor',NULL,19,2,'2025-11-30 11:02:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(62,4,'in',18,'Compra de proveedor',NULL,19,2,'2025-11-30 11:02:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(63,5,'in',11,'Compra de proveedor',NULL,19,2,'2025-11-30 11:02:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(64,7,'in',18,'Compra de proveedor',NULL,19,2,'2025-11-30 11:02:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(65,1,'in',13,'Compra de proveedor',NULL,20,2,'2026-02-05 09:59:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(66,3,'in',16,'Compra de proveedor',NULL,20,2,'2026-02-05 09:59:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(67,4,'in',17,'Compra de proveedor',NULL,20,2,'2026-02-05 09:59:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(68,7,'in',9,'Compra de proveedor',NULL,20,2,'2026-02-05 09:59:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(69,10,'in',17,'Compra de proveedor',NULL,20,2,'2026-02-05 09:59:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(70,1,'in',3,'Compra de proveedor',NULL,21,2,'2026-01-26 14:32:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(71,4,'in',12,'Compra de proveedor',NULL,21,2,'2026-01-26 14:32:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(72,9,'in',11,'Compra de proveedor',NULL,21,2,'2026-01-26 14:32:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(73,10,'in',11,'Compra de proveedor',NULL,21,2,'2026-01-26 14:32:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(74,8,'in',4,'Compra de proveedor',NULL,22,1,'2025-11-23 13:25:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(75,10,'in',10,'Compra de proveedor',NULL,22,1,'2025-11-23 13:25:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(76,3,'in',4,'Compra de proveedor',NULL,23,1,'2026-01-30 08:17:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(77,4,'in',19,'Compra de proveedor',NULL,23,1,'2026-01-30 08:17:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(78,6,'in',20,'Compra de proveedor',NULL,23,1,'2026-01-30 08:17:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(79,9,'in',12,'Compra de proveedor',NULL,23,1,'2026-01-30 08:17:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(80,10,'in',6,'Compra de proveedor',NULL,23,1,'2026-01-30 08:17:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(81,8,'in',6,'Compra de proveedor',NULL,24,1,'2026-01-10 14:39:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(82,10,'in',11,'Compra de proveedor',NULL,24,1,'2026-01-10 14:39:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(83,4,'in',20,'Compra de proveedor',NULL,25,2,'2026-01-01 12:09:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(84,7,'in',12,'Compra de proveedor',NULL,25,2,'2026-01-01 12:09:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(85,8,'in',13,'Compra de proveedor',NULL,25,2,'2026-01-01 12:09:00','2026-02-16 09:22:35','2026-02-16 09:22:35'),(86,2,'out',2,'Venta',1,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(87,6,'out',3,'Venta',1,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(88,8,'out',1,'Venta',1,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(89,1,'out',3,'Venta',1,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(90,9,'out',3,'Venta',2,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(91,2,'out',3,'Venta',2,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(92,8,'out',2,'Venta',2,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(93,3,'out',2,'Venta',2,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(94,8,'out',3,'Venta',3,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(95,4,'out',3,'Venta',3,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(96,10,'out',2,'Venta',3,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(97,3,'out',2,'Venta',4,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(98,4,'out',3,'Venta',4,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(99,1,'out',1,'Venta',4,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(100,6,'out',1,'Venta',4,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(101,9,'out',1,'Venta',5,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(102,2,'out',1,'Venta',6,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(103,6,'out',1,'Venta',6,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(104,4,'out',1,'Venta',7,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(105,1,'out',2,'Venta',7,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(106,8,'out',3,'Venta',7,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(107,6,'out',2,'Venta',7,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(108,2,'out',1,'Venta',8,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(109,9,'out',1,'Venta',8,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(110,8,'out',3,'Venta',8,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(111,3,'out',3,'Venta',9,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(112,4,'out',3,'Venta',10,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(113,10,'out',2,'Venta',11,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(114,3,'out',1,'Venta',11,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(115,5,'out',2,'Venta',11,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(116,4,'out',3,'Venta',11,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(117,5,'out',3,'Venta',12,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(118,6,'out',2,'Venta',12,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(119,8,'out',2,'Venta',12,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(120,2,'out',1,'Venta',12,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(121,4,'out',1,'Venta',13,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(122,2,'out',2,'Venta',13,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(123,8,'out',1,'Venta',13,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(124,3,'out',1,'Venta',13,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(125,9,'out',1,'Venta',13,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(126,3,'out',2,'Venta',14,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(127,1,'out',2,'Venta',14,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(128,5,'out',2,'Venta',14,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(129,10,'out',2,'Venta',14,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(130,4,'out',3,'Venta',15,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(131,10,'out',2,'Venta',15,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(132,5,'out',2,'Venta',15,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(133,7,'out',1,'Venta',15,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(134,8,'out',3,'Venta',16,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(135,1,'out',3,'Venta',17,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(136,2,'out',2,'Venta',18,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(137,4,'out',1,'Venta',18,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(138,5,'out',3,'Venta',18,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(139,8,'out',2,'Venta',18,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(140,7,'out',1,'Venta',19,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(141,6,'out',3,'Venta',20,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(142,3,'out',3,'Venta',20,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(143,4,'out',2,'Venta',20,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(144,10,'out',1,'Venta',20,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(145,1,'out',2,'Venta',21,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(146,5,'out',3,'Venta',21,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(147,2,'out',2,'Venta',21,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(148,3,'out',1,'Venta',21,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(149,9,'out',1,'Venta',21,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(150,9,'out',2,'Venta',22,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(151,7,'out',1,'Venta',22,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(152,1,'out',2,'Venta',22,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(153,5,'out',3,'Venta',22,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(154,4,'out',2,'Venta',22,NULL,2,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(155,3,'out',2,'Venta',23,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(156,1,'out',3,'Venta',23,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(157,5,'out',3,'Venta',23,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(158,2,'out',3,'Venta',23,NULL,3,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(159,2,'out',3,'Venta',24,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(160,1,'out',3,'Venta',24,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(161,9,'out',3,'Venta',24,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(162,3,'out',3,'Venta',24,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(163,1,'out',2,'Venta',25,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(164,7,'out',2,'Venta',25,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(165,6,'out',3,'Venta',25,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(166,9,'out',2,'Venta',25,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03'),(167,3,'out',2,'Venta',25,NULL,1,'2026-02-16 03:42:03','2026-02-16 09:42:03','2026-02-16 09:42:03');
/*!40000 ALTER TABLE `stock_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Distribuidora Farmacéutica López','88881234','lopez.distribuidora@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(2,'Suministros Médicos Hernández','88882345','hernandez.med@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(3,'Distribuidora La Salud','88883456','lasalud.nic@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(4,'Farmacéutica Martínez','88884567','martinez.farma@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(5,'Comercial Médica Gómez','88885678','gomez.med@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(6,'Importadora San José','88886789','sanjose.import@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(7,'Distribuidora El Buen Precio','88887890','buenprecio@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(8,'Farmacia Central Distribución','88888901','central.dist@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(9,'Suministros Médicos Ruiz','88889012','ruiz.med@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(10,'Comercial Farmacéutica Torres','88890123','torres.farma@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(11,'Distribuidora Médica Díaz','88891234','diaz.med@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(12,'Farmacéutica Castillo','88892345','castillo.farma@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(13,'Importadora San Rafael','88893456','sanrafael.import@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(14,'Comercial Médica Sánchez','88894567','sanchez.med@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(15,'Distribuidora Farmacia Vida','88895678','farmaciavida@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(16,'Suministros Médicos Rivera','88896789','rivera.med@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(17,'Importadora San Miguel','88897890','sanmiguel.import@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(18,'Comercial Farmacéutica Pérez','88898901','perez.farma@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(19,'Distribuidora Médica Ramírez','88899012','ramirez.med@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13'),(20,'Farmacéutica San Juan','88890145','sanjuan.farma@gmail.com','Cristo Rey',1,'2026-02-16 04:31:13','2026-02-16 04:31:13');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','admin@silva.com',NULL,'$2y$12$nGH0MKH8Tn51LyL153onXOaVbgpwB4X/dzvl89rMwJ4ss7/hJLnz6',NULL,'2026-02-16 08:47:30','2026-02-16 08:47:30'),(2,'Vendedor','vendedor@silva.com',NULL,'$2y$12$jtVH.mi70xfz3bBeWhBa7uBEGOSQNeUp0rXeW/qDKijUcAUSjcE4e',NULL,'2026-02-16 08:47:30','2026-02-16 08:47:30'),(3,'Consulta','consulta@silva.com',NULL,'$2y$12$zXd6q5ohcCdZu3ArQ1j1aOU1wW6RU94LiCB0Nm8kqz38F45E/gfLi',NULL,'2026-02-16 08:47:30','2026-02-16 08:47:30');
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

-- Dump completed on 2026-02-28  6:55:39
