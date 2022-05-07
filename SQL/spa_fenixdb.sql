-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: spa_fenixdb
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `Id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=1023 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1000,'jabones'),(1001,'cremas'),(1002,'salud'),(1003,'perfumes'),(1004,'belleza'),(1020,'masajes');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizaciones`
--

DROP TABLE IF EXISTS `cotizaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cotizaciones` (
  `Id_cotizacion` int NOT NULL AUTO_INCREMENT,
  `Id_producto` int NOT NULL,
  `cedulaCliente` int NOT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `nombreProducto` varchar(50) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precioPublico` int DEFAULT NULL,
  `precioCosto` int DEFAULT NULL,
  `fecha_cotizacion` date DEFAULT NULL,
  PRIMARY KEY (`Id_cotizacion`,`Id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizaciones`
--

LOCK TABLES `cotizaciones` WRITE;
/*!40000 ALTER TABLE `cotizaciones` DISABLE KEYS */;
INSERT INTO `cotizaciones` VALUES (33,113,1122143111,'juan diego guarin rozo','perfume',1,90000,50000,'2021-12-11'),(34,119,1122143111,'juan diego guarin rozo','masaje',2,36754,10000,'2021-12-11'),(35,119,1122143111,'juan diego guarin rozo','masaje',2,36754,10000,'2021-12-11'),(36,118,40428780,'Magda miriam rozo ','rodillo',5,7000,6500,'2021-12-11'),(37,119,40428780,'Magda miriam rozo ','masaje',1,36754,10000,'2021-12-11'),(38,112,40428780,'Magda miriam rozo ','jabon para hongos',5,8999,5000,'2021-12-11');
/*!40000 ALTER TABLE `cotizaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `Id_producto` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL,
  `nit_proveedor` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `precio_costo` int DEFAULT NULL,
  `precio_publico` int DEFAULT NULL,
  `iva` int DEFAULT NULL,
  `fecha_entrada` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`Id_producto`,`categoria`,`nit_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (112,'Jabon',875638900,'jabon para hongos',3999,7000,19,'2021-08-24','2022-06-12',NULL),(113,'1004',3,'perfume',50000,90000,19,'2021-06-12','2022-06-12',NULL),(118,'1002',1,'rodillo',6500,7000,19,'2021-06-12','2022-06-12',NULL),(119,'1003',2,'masaje',10000,36754,19,'2021-06-12','2022-06-12',NULL),(120,'1002',1,'baño espuma',30000,75000,19,'2021-06-12','2022-06-12',NULL),(121,'envellecimiento',10056813,'crema para la cara',12999,20000,19,'2021-06-12','2022-06-12',NULL);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `Id_proveedor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `nit` int DEFAULT NULL,
  PRIMARY KEY (`Id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'perfumeria ajax',98000065),(2,'distrisalones',11102065),(3,'exfosurdelllano',11102065),(4,'cremsadex',80065923);
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typeuser`
--

DROP TABLE IF EXISTS `typeuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `typeuser` (
  `Id_type_user` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_type_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeuser`
--

LOCK TABLES `typeuser` WRITE;
/*!40000 ALTER TABLE `typeuser` DISABLE KEYS */;
INSERT INTO `typeuser` VALUES (1,'Administrador'),(2,'empleado'),(3,'cliente'),(4,'cajero');
/*!40000 ALTER TABLE `typeuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `Id_user` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (102,NULL,'david perez','david@perezmail.com','25d55ad283aa400af464c76d713c07ad'),(103,NULL,'Diego rozo','Diego@perezmail.com','25d55ad283aa400af464c76d713c07ad'),(105,NULL,'Misgel Gomez','Mishe@gmail.com','e10adc3949ba59abbe56e057f20f883e'),(106,NULL,'Misgel Gomez','Mishe@gmail.com','e10adc3949ba59abbe56e057f20f883e'),(107,NULL,'Misgel Gomez','Mishe@gmail.com','e10adc3949ba59abbe56e057f20f883e'),(109,'cliente','ñoño gay','ñoñoEsGay@gmail.com','e10adc3949ba59abbe56e057f20f883e'),(110,'cliente','chanchito feliz','chanchito@gmail.com','e10adc3949ba59abbe56e057f20f883e');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ventas`
--

DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ventas` (
  `Id_venta` int NOT NULL AUTO_INCREMENT,
  `total` int DEFAULT NULL,
  `inversion` int DEFAULT NULL,
  `ganancia` int DEFAULT NULL,
  `fecha_hora_venta` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ventas`
--

LOCK TABLES `ventas` WRITE;
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` VALUES (1,70000,50000,20000,'2021-05-12 12:05:24');
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-07 15:33:16
