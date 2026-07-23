-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: manadas
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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id_admin` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `uq_admin_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Augusto','Barbieri','barbieriaugusto@gmail.com','123456789','11354689','activo','2025-10-29 19:04:12',NULL);
INSERT INTO `admin` VALUES (2,'Maria','Lopez','marialopez@gmail.com','123456789','11354689','activo','2025-10-29 19:04:12',NULL);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mascota`
--

DROP TABLE IF EXISTS `mascota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mascota` (
  `id_mascota` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_dueno` int(10) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `raza` varchar(100) NOT NULL,
  `tamano` enum('chico','mediano','grande') NOT NULL,
  `observaciones` text DEFAULT NULL,
  `creada_en` datetime NOT NULL DEFAULT current_timestamp(),
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mascota`),
  KEY `idx_mascota_dueno` (`id_dueno`),
  CONSTRAINT `fk_mascota_dueno` FOREIGN KEY (`id_dueno`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mascota`
--

LOCK TABLES `mascota` WRITE;
/*!40000 ALTER TABLE `mascota` DISABLE KEYS */;
INSERT INTO `mascota` VALUES (1,8,'Felix','Coquer','mediano','','2025-11-02 13:02:48','mascota_6907896ca36ff_ChatGPT Image Jun 24, 2025, 01_52_29 PM.png'),(2,8,'Justi','Perro','grande','Es medio malo','2025-11-02 15:26:08','mascota_6907a240c1a9e_ChatGPT Image Jun 24, 2025, 01_52_29 PM.png'),(3,8,'Kyla','','mediano','','2025-11-02 17:39:37',''),(4,8,'Mani','Coquer','chico','chico','2026-05-25 00:00:00','');
/*!40000 ALTER TABLE `mascota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pago`
--

DROP TABLE IF EXISTS `pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pago` (
  `id_pago` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_paseo` int(10) unsigned DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo` enum('efectivo','tarjeta','transferencia') DEFAULT NULL,
  `estado_pago` enum('pendiente','confirmado','rechazado') NOT NULL DEFAULT 'pendiente',
  `habilitado_por_admin` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_pago` datetime DEFAULT NULL,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pago`),
  KEY `idx_pago_paseo` (`id_paseo`),
  CONSTRAINT `fk_pago_paseo` FOREIGN KEY (`id_paseo`) REFERENCES `paseo` (`id_paseo`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pago`
--

LOCK TABLES `pago` WRITE;
/*!40000 ALTER TABLE `pago` DISABLE KEYS */;
INSERT INTO `pago` VALUES (1,1,0.00,NULL,'confirmado',0,'2026-05-25 00:00:00','2026-05-25 13:00:07');
/*!40000 ALTER TABLE `pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paseador`
--

DROP TABLE IF EXISTS `paseador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paseador` (
  `id_paseador` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `zona` varchar(120) DEFAULT NULL,
  `disponibilidad` enum('manana','tarde','noche') DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `bio` text DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `fecha_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_paseador`),
  UNIQUE KEY `uq_paseador_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paseador`
--

LOCK TABLES `paseador` WRITE;
/*!40000 ALTER TABLE `paseador` DISABLE KEYS */;
INSERT INTO `paseador` VALUES (1,'Carlos','Medina','carlos.medina@manadas.com','123456','','Quilmes','','activo','Soy muy muy copado',NULL,'2025-10-29 19:08:29',NULL),(2,'Mani','Jove','manu@manadas.com','1234','178178732','','','activo','',NULL,'2025-11-01 23:22:59',NULL),(3,'Fer','Perez','fer@manadas.com','','112354785',NULL,NULL,'activo',NULL,NULL,'2025-11-02 12:15:14',NULL);
/*!40000 ALTER TABLE `paseador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paseo`
--

DROP TABLE IF EXISTS `paseo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paseo` (
  `id_paseo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_paseador` int(10) unsigned DEFAULT NULL,
  `id_mascota` int(10) unsigned DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `zona` varchar(120) DEFAULT NULL,
  `punto_encuentro` varchar(255) DEFAULT NULL,
  `estado_paseo` enum('no_iniciado','en_curso','finalizado') NOT NULL DEFAULT 'no_iniciado',
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo_paseo` enum('individual','grupal') NOT NULL DEFAULT 'individual',
  `estado_habilitacion` enum('pendiente_pago','habilitado_admin') NOT NULL DEFAULT 'pendiente_pago',
  PRIMARY KEY (`id_paseo`),
  KEY `idx_paseo_paseador` (`id_paseador`),
  KEY `idx_paseo_mascota` (`id_mascota`),
  CONSTRAINT `fk_paseo_mascota` FOREIGN KEY (`id_mascota`) REFERENCES `mascota` (`id_mascota`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_paseo_paseador` FOREIGN KEY (`id_paseador`) REFERENCES `paseador` (`id_paseador`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paseo`
--

LOCK TABLES `paseo` WRITE;
/*!40000 ALTER TABLE `paseo` DISABLE KEYS */;
INSERT INTO `paseo` VALUES (1,2,1,'2027-05-31','14:50:00','15:50:00','Por definir',NULL,'finalizado',0.00,'2026-05-25 13:00:07','individual','habilitado_admin');
/*!40000 ALTER TABLE `paseo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `uq_usuarios_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Juan','Kavulakian','jpkavulakian@gmail.com','1234','1234567890','Calle Falsa 123','2025-10-29 13:44:02','https://example.com/image.jpg'),(4,'Luli','Nine','luli@gmail.com','$2y$10$roC.HmGRV35/TyL.g0shS.ghe8zVLGWsxkrNYxXD3L5tNEkSS3j1S','0113597546','Juncal 015','2025-10-29 17:05:54','uploads/perfiles/default.png'),(5,'Augusto Esteban','Barbieri','barbieriaugusto62@gmail.com','$2y$10$H0NKM95W/FWNBJS0ZJ.dW.sZr5D/GDIylYs1O3duWLqTFOpP4PkE2','01135975802','Av. Olazabal 4885','2025-10-29 17:10:39','uploads/perfiles/default.png'),(6,'Manu','Jove','manujove@gmail.com','$2y$10$3xwvsy02mTUtXmacnwtfVuOoor0pXvZE1bOGgrwMrg54bPzQAf4fe','12546258','Juncal','2025-10-29 18:45:50','uploads/perfiles/default.png'),(7,'Hernan','Feijo','Hernan@gmail.com','$2y$10$XQ37oNHwafssxS2W2xWnE.75wxayqR8addADApPCP7PuA76HGkfMu','1540263589','juncal 5457','2025-10-29 19:02:38','uploads/perfiles/default.png'),(8,'Emilio','Barbieri','emilio@gmail.com','1234','1135497580','Juncal 2020','2025-10-30 09:04:53','Assets/img/usuarios/69077343b8f12-yo.jpeg'),(9,'Juan','Eljuan','juan@gmail.com','$2y$10$zC9vdq7Hrr/TbMrwgK6fUe7UaqiLR.r8wyyjbDEuNB3tWZiu2f2vu','123456789','','2025-10-31 10:15:06','archivos/perfiles/default.png'),(10,'Bernardo','Cantisano','bcanti@gmail.com','$2y$10$TlJqpKnptHhUwXmOEdY4hOuuR8WYuMOTBmfGYOBbz/GA47V1ltVCS','1235468','Nuno 0123','2025-10-31 15:09:38','archivos/perfiles/default.png');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-19 20:14:08
