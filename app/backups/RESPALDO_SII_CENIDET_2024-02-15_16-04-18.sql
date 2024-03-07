-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: sii_del_cenidet
-- ------------------------------------------------------
-- Server version	8.1.0

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
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ApellidoP` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ApellidoM` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FechaNac` date NOT NULL,
  `noControl` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `curp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Direccion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Genero` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Telefono` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idCarrera` bigint unsigned DEFAULT NULL,
  `idGrupo` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alumnos_nocontrol_unique` (`noControl`),
  KEY `alumnos_idgrupo_foreign` (`idGrupo`),
  KEY `alumnos_idcarrera_foreign` (`idCarrera`),
  CONSTRAINT `alumnos_idcarrera_foreign` FOREIGN KEY (`idCarrera`) REFERENCES `carreras` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `alumnos_idgrupo_foreign` FOREIGN KEY (`idGrupo`) REFERENCES `grupos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (11,'Martin','Torrez','Gomez','2002-02-01','66662','RDBQ011710UTIXC2','Col.Lomas Cortes #6','Masculino','7778920041',6,5),(12,'Ana','Roman','Palacios','2001-07-12','66663','RDBQ011710UTIXC2','Avenida cuauhtémoc #52','Femenino','7775636713',7,5);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aplicacion_periodos`
--

DROP TABLE IF EXISTS `aplicacion_periodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aplicacion_periodos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idPeriodo` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aplicacion_periodos_idperiodo_foreign` (`idPeriodo`),
  CONSTRAINT `aplicacion_periodos_idperiodo_foreign` FOREIGN KEY (`idPeriodo`) REFERENCES `periodos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aplicacion_periodos`
--

LOCK TABLES `aplicacion_periodos` WRITE;
/*!40000 ALTER TABLE `aplicacion_periodos` DISABLE KEYS */;
INSERT INTO `aplicacion_periodos` VALUES (1,'PROCESO DE ASPIRANTES',1),(3,'CIERRE DE PERIODOS ESCOLARES',1),(4,'CALIFICACIONES PARCIALES, GESTION DE CURSO',1),(5,'CAPTURA DE EXAMENES ESPECIALES',1),(6,'PROCESO DE REINSCRIPCION',1),(7,'AUTORIZACION DE RESIDENCIAS DEP',1),(8,'Captura de calificaciones',1);
/*!40000 ALTER TABLE `aplicacion_periodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aulas`
--

DROP TABLE IF EXISTS `aulas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aulas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `NombreAula` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Capacidad` int NOT NULL,
  `Ubicacion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aulas`
--

LOCK TABLES `aulas` WRITE;
/*!40000 ALTER TABLE `aulas` DISABLE KEYS */;
INSERT INTO `aulas` VALUES (3,'Aula B-230',50,'Prueba','2024-01-31 02:11:51','2024-01-31 02:11:51'),(4,'Aula A-120',50,'Prueba','2024-01-31 02:12:19','2024-01-31 02:12:19');
/*!40000 ALTER TABLE `aulas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avisos`
--

DROP TABLE IF EXISTS `avisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avisos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FechaPublicacion` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avisos`
--

LOCK TABLES `avisos` WRITE;
/*!40000 ALTER TABLE `avisos` DISABLE KEYS */;
INSERT INTO `avisos` VALUES (3,'Aviso restaurado','hfhfh``','2024-02-15');
/*!40000 ALTER TABLE `avisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avisos_usuarios`
--

DROP TABLE IF EXISTS `avisos_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avisos_usuarios` (
  `idAviso` bigint unsigned DEFAULT NULL,
  `idUsuario` bigint unsigned DEFAULT NULL,
  `Leido` tinyint(1) NOT NULL,
  KEY `avisos_usuarios_idaviso_foreign` (`idAviso`),
  KEY `avisos_usuarios_idusuario_foreign` (`idUsuario`),
  CONSTRAINT `avisos_usuarios_idaviso_foreign` FOREIGN KEY (`idAviso`) REFERENCES `avisos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `avisos_usuarios_idusuario_foreign` FOREIGN KEY (`idUsuario`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avisos_usuarios`
--

LOCK TABLES `avisos_usuarios` WRITE;
/*!40000 ALTER TABLE `avisos_usuarios` DISABLE KEYS */;
INSERT INTO `avisos_usuarios` VALUES (3,1,0);
/*!40000 ALTER TABLE `avisos_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bajaspersonal`
--

DROP TABLE IF EXISTS `bajaspersonal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bajaspersonal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idPersonal` bigint unsigned NOT NULL,
  `idEstatus` bigint unsigned NOT NULL,
  `FechaBaja` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bajaspersonal_idpersonal_foreign` (`idPersonal`),
  KEY `bajaspersonal_idestatus_foreign` (`idEstatus`),
  CONSTRAINT `bajaspersonal_idestatus_foreign` FOREIGN KEY (`idEstatus`) REFERENCES `estatus empleado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bajaspersonal_idpersonal_foreign` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bajaspersonal`
--

LOCK TABLES `bajaspersonal` WRITE;
/*!40000 ALTER TABLE `bajaspersonal` DISABLE KEYS */;
INSERT INTO `bajaspersonal` VALUES (1,1,2,'2024-02-10'),(2,2,3,'2023-02-07'),(3,4,15,'2023-02-06'),(4,5,6,'2024-02-06'),(5,3,4,'2024-02-15'),(6,7,2,'2024-02-15');
/*!40000 ALTER TABLE `bajaspersonal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificaciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idAlumno` bigint unsigned DEFAULT NULL,
  `idMateria` bigint unsigned DEFAULT NULL,
  `Calificacion` double(8,2) NOT NULL,
  `NumSemestre` double(8,2) NOT NULL,
  `FechaRegistro` date NOT NULL,
  `idProfesor` bigint unsigned DEFAULT NULL,
  `idGrupo` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calificaciones_idalumno_foreign` (`idAlumno`),
  KEY `calificaciones_idmateria_foreign` (`idMateria`),
  KEY `calificaciones_idprofesor_foreign` (`idProfesor`),
  KEY `calificaciones_idgrupo_foreign` (`idGrupo`),
  CONSTRAINT `calificaciones_idalumno_foreign` FOREIGN KEY (`idAlumno`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `calificaciones_idgrupo_foreign` FOREIGN KEY (`idGrupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `calificaciones_idmateria_foreign` FOREIGN KEY (`idMateria`) REFERENCES `materias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `calificaciones_idprofesor_foreign` FOREIGN KEY (`idProfesor`) REFERENCES `personal` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificaciones`
--

LOCK TABLES `calificaciones` WRITE;
/*!40000 ALTER TABLE `calificaciones` DISABLE KEYS */;
INSERT INTO `calificaciones` VALUES (23,11,5,9.00,1.00,'2024-02-13',NULL,1),(24,12,5,8.00,1.00,'2024-02-13',NULL,1),(25,11,6,8.10,1.00,'2024-02-13',NULL,1),(26,12,6,6.40,1.00,'2024-02-13',NULL,1),(27,11,7,7.30,1.00,'2024-02-13',NULL,1),(28,12,7,9.20,1.00,'2024-02-13',NULL,1),(29,11,9,8.20,1.00,'2024-02-13',NULL,1),(30,12,9,9.10,1.00,'2024-02-13',NULL,1),(31,11,5,7.10,2.00,'2024-02-13',NULL,2),(32,12,5,8.40,2.00,'2024-02-13',NULL,2),(33,11,6,6.00,2.00,'2024-02-13',NULL,2),(34,12,6,4.50,2.00,'2024-02-13',NULL,2),(35,11,7,8.70,2.00,'2024-02-13',NULL,2),(36,12,7,9.30,2.00,'2024-02-13',NULL,2),(37,11,9,10.00,2.00,'2024-02-13',NULL,2),(38,12,9,9.30,2.00,'2024-02-13',NULL,2),(39,11,5,8.40,3.00,'2024-02-13',NULL,3),(40,12,5,8.10,3.00,'2024-02-13',NULL,3),(41,11,6,7.20,3.00,'2024-02-13',NULL,3),(42,12,6,8.90,3.00,'2024-02-13',NULL,3),(43,11,7,8.50,3.00,'2024-02-13',NULL,3),(44,12,7,7.30,3.00,'2024-02-13',NULL,3),(45,11,9,9.30,3.00,'2024-02-13',NULL,3),(46,12,9,9.50,3.00,'2024-02-13',NULL,3),(47,11,5,9.30,4.00,'2024-02-13',NULL,5),(48,12,5,8.10,4.00,'2024-02-13',NULL,5),(49,11,6,7.30,4.00,'2024-02-13',NULL,5),(50,12,6,8.20,4.00,'2024-02-13',NULL,5),(51,11,7,6.50,4.00,'2024-02-13',NULL,5),(52,12,7,7.40,4.00,'2024-02-13',NULL,5),(53,11,9,8.20,4.00,'2024-02-13',NULL,5),(54,12,9,9.40,4.00,'2024-02-13',NULL,5);
/*!40000 ALTER TABLE `calificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carreras`
--

DROP TABLE IF EXISTS `carreras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carreras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Descripcion` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Duracion_Años` int NOT NULL,
  `Nivel` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carreras`
--

LOCK TABLES `carreras` WRITE;
/*!40000 ALTER TABLE `carreras` DISABLE KEYS */;
INSERT INTO `carreras` VALUES (1,'Ciencias de la computacion','',2,'Doctorado'),(2,'Ciencias en ingenieria electronica','',2,'Doctorado'),(3,'Ciencias de la ingenieria','',2,'Doctorado'),(4,'Ciencias en ingenieria mecatronica','',2,'Doctorado'),(5,'Semiconductores','',2,'Especialidad'),(6,'Ciencias en ingenieria electronica','',2,'Doctorado'),(7,'Electromecanica','',2,'Ingenieria'),(8,'Ciencias de la computacion','',2,'Maestria'),(9,'Ciencias en ingenieria electronica','',2,'Maestria'),(10,'Ciencias en ingenieria mecanica','',2,'Maestria'),(11,'Ciencias de la ingenieria','',2,'Maestria'),(12,'Ciencias en ingenieria mecatronica','',2,'Maestria');
/*!40000 ALTER TABLE `carreras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Clave` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Horas` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categorias_clave_unique` (`Clave`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Jefe de Mesa','A01004',36),(2,'Jefe de Proyecto','A01009',36),(3,'Analista de sistemas administrativos','A04003',36),(4,'Secretario Bilingue','A08003',36),(5,'Secretario de director del plantel','A08016',36),(6,'Secretario de jefe de departamento','A08029',36),(7,'Tecnico docente asignatura B','E3507',36),(8,'Profesor de asignatura A E.S','E3519',36),(9,'Profesor de asignatura B E.S','E3521',36),(10,'Profesor de asignatura C E.S','E3525',36),(11,'Profesor asociado B E.S','E3809',36),(12,'Profesor asociado C E.S','E3811',36),(13,'Profesor titular A E.S','E3813',36),(14,'Profesor titular B E.S','E3815',36),(15,'Profesor titular C E.S','E3817',36),(16,'Tecnico Docente Asociado A E.S','E3837',36),(17,'Tecnico Docente Asociado B E.S','E3839',36);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clases`
--

DROP TABLE IF EXISTS `clases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `HInicio` time NOT NULL,
  `HFin` time NOT NULL,
  `dia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idMateria` bigint unsigned DEFAULT NULL,
  `idAula` bigint unsigned DEFAULT NULL,
  `idGrupo` bigint unsigned DEFAULT NULL,
  `idHorario` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clases_idmateria_foreign` (`idMateria`),
  KEY `clases_idaula_foreign` (`idAula`),
  KEY `clases_idgrupo_foreign` (`idGrupo`),
  KEY `clases_idhorario_foreign` (`idHorario`),
  CONSTRAINT `clases_idaula_foreign` FOREIGN KEY (`idAula`) REFERENCES `aulas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `clases_idgrupo_foreign` FOREIGN KEY (`idGrupo`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clases_idhorario_foreign` FOREIGN KEY (`idHorario`) REFERENCES `horarios_docentes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clases_idmateria_foreign` FOREIGN KEY (`idMateria`) REFERENCES `materias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clases`
--

LOCK TABLES `clases` WRITE;
/*!40000 ALTER TABLE `clases` DISABLE KEYS */;
INSERT INTO `clases` VALUES (17,'08:00:00','09:00:00','Lunes','#ac512a',6,3,2,2),(18,'10:00:00','11:00:00','Lunes','#538197',5,NULL,3,2),(19,'14:00:00','17:00:00','Jueves','#871fad',7,4,1,2),(24,'11:00:00','12:00:00','Lunes','#653434',6,3,2,3),(25,'08:00:00','09:00:00','Lunes','#4f5aab',6,3,3,4),(26,'10:00:00','11:00:00','Lunes','#AE1f20',5,4,2,4);
/*!40000 ALTER TABLE `clases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departamentos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Descripcion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idEncargado` bigint unsigned DEFAULT NULL,
  `idSubdireccion` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departamentos_idencargado_foreign` (`idEncargado`),
  KEY `departamentos_idsubdireccion_foreign` (`idSubdireccion`),
  CONSTRAINT `departamentos_idencargado_foreign` FOREIGN KEY (`idEncargado`) REFERENCES `personal` (`id`) ON DELETE SET NULL,
  CONSTRAINT `departamentos_idsubdireccion_foreign` FOREIGN KEY (`idSubdireccion`) REFERENCES `subdireccion` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES (1,'Direccion','Prueba',NULL,NULL),(2,'Departamento de ingenieria mecanica','Prueba',NULL,NULL),(3,'Coordinacion de mecatronica','Prueba',NULL,NULL),(4,'Coordinacion de ciencias de la ingenieria','Prueba',NULL,NULL),(5,'Departamento de ingenieria electronica','Prueba',NULL,NULL),(6,'Departamento de ciencias computacionales','Prueba',NULL,NULL),(7,'Departamento de Organizacion y seguimiento de estudios','Prueba',NULL,NULL),(8,'Departamento de desarrollo academico e idiomas','Prueba',NULL,NULL),(9,'Departamento de planeacion, programacion y presupuestacion ','Prueba',NULL,NULL),(10,'Departamento de gestion tecnologica y vinculacion','Prueba',NULL,NULL),(11,'Departamento de comunicacion y eventos','Prueba',NULL,NULL),(12,'Centro de informacion','Prueba',NULL,NULL),(13,'Centro de computo','Prueba',3,1),(14,'Departamento de Servicios escolares','Prueba',NULL,NULL),(15,'Departamento de recursos materiales y servicios','Prueba',NULL,NULL),(16,'Departamento de recursos humanos','Prueba',NULL,NULL);
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diashorario`
--

DROP TABLE IF EXISTS `diashorario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diashorario` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `HInicio` time NOT NULL,
  `HFin` time NOT NULL,
  `dia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idHorario` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `diashorario_idhorario_foreign` (`idHorario`),
  CONSTRAINT `diashorario_idhorario_foreign` FOREIGN KEY (`idHorario`) REFERENCES `horarios_docentes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diashorario`
--

LOCK TABLES `diashorario` WRITE;
/*!40000 ALTER TABLE `diashorario` DISABLE KEYS */;
INSERT INTO `diashorario` VALUES (1,'12:00:00','14:00:00','Lunes',4);
/*!40000 ALTER TABLE `diashorario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estatus empleado`
--

DROP TABLE IF EXISTS `estatus empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estatus empleado` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatus empleado`
--

LOCK TABLES `estatus empleado` WRITE;
/*!40000 ALTER TABLE `estatus empleado` DISABLE KEYS */;
INSERT INTO `estatus empleado` VALUES (1,'Activo'),(2,'Baja por abandono de Empleo'),(3,'Baja por cambio de adscripcion'),(4,'Baja por defuncion'),(5,'Baja por incapacidad I.S.S.S.T.E'),(6,'Baja por insubsistencia de nombramiento'),(7,'Baja por jubilacion'),(8,'Baja por renuncia'),(9,'Baja por resolucion del tribunal de concilacion y arbitraje'),(10,'Baja por sentencia Judicial'),(11,'Baja por termino de nombramiento'),(12,'Licencia por asuntos particulares'),(13,'Licencia por beca'),(14,'Licencia por comision sindical o eleccion popular'),(15,'Licencia por gravidez'),(16,'Licencia pre pensionada'),(17,'Sabatico');
/*!40000 ALTER TABLE `estatus empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Semestre` int NOT NULL,
  `Especialidad` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Letra` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idPeriodo` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grupos_idperiodo_foreign` (`idPeriodo`),
  CONSTRAINT `grupos_idperiodo_foreign` FOREIGN KEY (`idPeriodo`) REFERENCES `periodos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos`
--

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES (1,1,'Mecatronica','C',1),(2,2,'Mecatronica','C',1),(3,3,'Mecatronica','C',1),(5,4,'Mecatronica','C',2);
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horarios_docentes`
--

DROP TABLE IF EXISTS `horarios_docentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios_docentes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idProfesor` bigint unsigned DEFAULT NULL,
  `idPeriodo` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `horarios_docentes_idprofesor_foreign` (`idProfesor`),
  KEY `horarios_docentes_idperiodo_foreign` (`idPeriodo`),
  CONSTRAINT `horarios_docentes_idperiodo_foreign` FOREIGN KEY (`idPeriodo`) REFERENCES `periodos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `horarios_docentes_idprofesor_foreign` FOREIGN KEY (`idProfesor`) REFERENCES `personal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios_docentes`
--

LOCK TABLES `horarios_docentes` WRITE;
/*!40000 ALTER TABLE `horarios_docentes` DISABLE KEYS */;
INSERT INTO `horarios_docentes` VALUES (2,1,1),(3,2,1),(4,3,1);
/*!40000 ALTER TABLE `horarios_docentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias`
--

DROP TABLE IF EXISTS `materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Descripcion` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Codigo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (5,'Matematicas Avanzadas','Prueba','575760'),(6,'Teorías de la computación','Prueba','575761'),(7,'Lenguajes web','Prueba','575762'),(9,'Sistemas III','Hola','657201');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2023_07_20_182922_create_sessions_table',1),(7,'2023_07_20_215233_create__aula_table',1),(8,'2023_08_19_191953_create_permission_tables',1),(9,'2023_09_06_184833_historial_alumno',1),(10,'2023_09_06_190939_periodo',1),(11,'2023_09_06_191432_historial_alumno',1),(12,'2023_09_09_225802_aplicacion_periodos',1),(13,'2023_09_13_000624_estatus_empleado',1),(14,'2023_09_13_164018_categoria',1),(15,'2023_09_13_184947_plazas',1),(16,'2023_09_14_192017_personal',1),(17,'2023_09_15_235519_subdireccion',1),(18,'2023_09_20_163346_departamento',1),(19,'2023_09_21_084904_update_table_personal',1),(20,'2023_09_25_173710_horarios_profesores',1),(21,'2023_09_30_014559_materias',1),(22,'2023_09_30_213632_grupos',1),(23,'2023_10_01_012120_clases',1),(24,'2023_10_03_233219_carrera',1),(25,'2023_10_22_194550_alumnos',1),(26,'2023_10_30_172539_dias_horario',1),(27,'2023_11_04_002222_vigencias_personal',1),(28,'2023_11_19_225510_calificaciones',1),(29,'2023_11_26_000711_permisos_carreras',1),(30,'2023_11_27_044925_avisos',1),(31,'2023_11_27_180449_usuarios__avisos',1),(32,'2023_12_02_035237_bajas_personal',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (7,'App\\Models\\User',81),(11,'App\\Models\\User',82),(2,'App\\Models\\User',86),(7,'App\\Models\\User',92);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `periodos`
--

DROP TABLE IF EXISTS `periodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periodos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mesInicio` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AñoInicio` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mesTermino` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AñoTermino` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodos`
--

LOCK TABLES `periodos` WRITE;
/*!40000 ALTER TABLE `periodos` DISABLE KEYS */;
INSERT INTO `periodos` VALUES (1,'Agosto','2023','Febrero','2024'),(2,'Febrero','2023','Julio','2023'),(3,'Agosto','2022','Febrero','2023'),(4,'Febrero','2022','Julio','2022'),(5,'Agosto','2021','Febrero','2022'),(6,'Febrero','2021','Julio','2021'),(7,'Agosto','2020','Febrero','2021'),(8,'Febrero','2020','Julio','2020'),(9,'Agosto','2019','Enero','2020'),(10,'Febrero','2019','Julio','2019'),(11,'Agosto','2018','Enero','2019'),(12,'Febrero','2018','Julio','2018'),(13,'Agosto','2017','Enero','2018'),(14,'Febrero','2017','Julio','2017'),(15,'Agosto','2016','Enero','2017'),(16,'Febrero','2016','Julio','2016'),(17,'Agosto','2015','Enero','2016'),(18,'Febrero','2015','Julio','2015'),(19,'Agosto','2014','Enero','2015'),(20,'Febrero','2014','Julio','2014'),(21,'Agosto','2013','Enero','2014'),(22,'Enero','2013','Junio','2013'),(23,'Agosto','2012','Enero','2013'),(24,'Enero','2012','Junio','2012'),(25,'Agosto','2011','Enero','2012'),(26,'Enero','2011','Junio','2011'),(27,'Agosto','2010','Enero','2011'),(28,'Enero','2010','Junio','2010'),(29,'Agosto','2009','Enero','2010'),(30,'Enero','2009','Junio','2009'),(31,'Agosto','2008','Enero','2009'),(32,'Enero','2008','Junio','2008'),(33,'Agosto','2007','Enero','2008'),(34,'Enero','2007','Junio','2007'),(35,'Agosto','2006','Enero','2007'),(36,'Enero','2006','Junio','2006'),(37,'Agosto','2005','Enero','2006'),(38,'Enero','2005','Junio','2005'),(39,'Agosto','2004','Enero','2005'),(40,'Enero','2004','Junio','2004'),(41,'Agosto','2003','Enero','2004'),(42,'Enero','2003','Junio','2003'),(43,'Agosto','2002','Enero','2003'),(44,'Enero','2002','Junio','2002'),(45,'Agosto','2001','Enero','2002'),(46,'Enero','2001','Junio','2001'),(47,'Agosto','2000','Enero','2001'),(48,'Enero','2000','Junio','2000');
/*!40000 ALTER TABLE `periodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisoscarreras`
--

DROP TABLE IF EXISTS `permisoscarreras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisoscarreras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idCarrera` bigint unsigned DEFAULT NULL,
  `idUsuario` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permisoscarreras_idcarrera_foreign` (`idCarrera`),
  KEY `permisoscarreras_idusuario_foreign` (`idUsuario`),
  CONSTRAINT `permisoscarreras_idcarrera_foreign` FOREIGN KEY (`idCarrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permisoscarreras_idusuario_foreign` FOREIGN KEY (`idUsuario`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisoscarreras`
--

LOCK TABLES `permisoscarreras` WRITE;
/*!40000 ALTER TABLE `permisoscarreras` DISABLE KEYS */;
/*!40000 ALTER TABLE `permisoscarreras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Modificación de Actas de Calificaciones','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(2,'Modificación de Actas de Ex. Globales o Especiales','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(3,'Generación de Folios','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(4,'Alta de Alumnos','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(5,'Modificación de datos de Alumnos','web','2024-01-12 03:37:22','2024-01-12 03:37:22'),(6,'Eliminación de Alumnos','web','2024-01-12 03:37:22','2024-01-12 03:37:22'),(7,'Modificación de Kardex','web','2024-01-12 03:37:22','2024-01-12 03:37:22'),(8,'Calcular promedios de Alumnos','web','2024-01-12 03:37:22','2024-01-12 03:37:22'),(9,'Solicitud de Ex. Globales o Especiales','web','2024-01-12 03:37:22','2024-01-12 03:37:22');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal`
--

DROP TABLE IF EXISTS `personal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ApellidoP` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ApellidoM` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RFC` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `LugarNacimiento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `Sexo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `EstadoCivil` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Direccion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Colonia` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CodigoPostal` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Ciudad` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `EntFederativa` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CURP` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CorreoPers` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NivEst1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NivEst2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NivEst3` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `GradoMax1` int DEFAULT NULL,
  `GradoMax2` int DEFAULT NULL,
  `GradoMax3` int DEFAULT NULL,
  `Estudio1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Estudio2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Estudio3` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Titulo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Nombramiento` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numEmpleado` int NOT NULL,
  `Estatus` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IngAñoSNEST` int DEFAULT NULL,
  `IngQuinSNEST` int DEFAULT NULL,
  `IngAñoGob` int DEFAULT NULL,
  `IngQuinGob` int DEFAULT NULL,
  `IngAñoSEP` int DEFAULT NULL,
  `IngQuinSEP` int DEFAULT NULL,
  `IngAñoPlan` int DEFAULT NULL,
  `IngQuinPlan` int DEFAULT NULL,
  `TipoAct` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `FechaRegistro` date NOT NULL,
  `idPlaza` bigint unsigned DEFAULT NULL,
  `idUsuario` bigint unsigned DEFAULT NULL,
  `EstatusEmpleado` bigint unsigned DEFAULT NULL,
  `idDepAdscripcion` bigint unsigned DEFAULT NULL,
  `idDepAcademico` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personal_idplaza_foreign` (`idPlaza`),
  KEY `personal_idusuario_foreign` (`idUsuario`),
  KEY `personal_estatusempleado_foreign` (`EstatusEmpleado`),
  KEY `personal_iddepadscripcion_foreign` (`idDepAdscripcion`),
  KEY `personal_iddepacademico_foreign` (`idDepAcademico`),
  CONSTRAINT `personal_estatusempleado_foreign` FOREIGN KEY (`EstatusEmpleado`) REFERENCES `estatus empleado` (`id`) ON DELETE SET NULL,
  CONSTRAINT `personal_iddepacademico_foreign` FOREIGN KEY (`idDepAcademico`) REFERENCES `departamentos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `personal_iddepadscripcion_foreign` FOREIGN KEY (`idDepAdscripcion`) REFERENCES `departamentos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `personal_idplaza_foreign` FOREIGN KEY (`idPlaza`) REFERENCES `plazas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `personal_idusuario_foreign` FOREIGN KEY (`idUsuario`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal`
--

LOCK TABLES `personal` WRITE;
/*!40000 ALTER TABLE `personal` DISABLE KEYS */;
INSERT INTO `personal` VALUES (1,'Lopez','Garcia','Erick','RXBE021120587','Morelos, Jiutepec','2002-11-20','Masculino','Soltero','Calle Prolongación Lauro Ortega #6','Otilio Montaño','62543','Cuernavaca','Morelos','7776010220','RXBE021120HMSMRRA3','erick@gmail.com','Profesional',NULL,NULL,9,0,0,'Tecnologías de la Información',NULL,NULL,'Ing','Docente',8712,'B',2021,2,2021,6,2022,10,2022,6,'Docentes','2023-01-25',NULL,NULL,2,13,13),(2,'Rodriguez','Perez','Maria','HEHFY27673674','Morelos','2024-01-12','Femenino','Divorciado','JDJFU','JCDHVRU','67838','SDNVNFU','JIWCIVHJRHhschueuh','3495858586','IIITUYTYYEUEY36746','mariaj8@gmail.com','Maestria',NULL,NULL,8,0,0,'Empresas',NULL,NULL,'Dr.','Docente',8904,'B',2001,2,2001,2,2001,3,2001,3,'Administrativas','2023-01-30',NULL,NULL,3,7,7),(3,'Roblez','Nava','Damian','EURUT8T77T7T7','Morelos','2000-02-08','Masculino','Casado','jvrjrvjj','jwcjevjvejj','82342','dfjvrrvjrvjjrvj','Morelos','7678686899','7575888DUFUVJUVUVU','Dami21TRoblez@gmail.com','Maestria','Doctorado',NULL,3,6,0,'Administracion','Contabilidad',NULL,'Lic','Administrativo',6979,'B',2019,2,2020,2,2021,1,2020,2,'Administrativas','2024-01-31',NULL,92,4,10,10),(4,'Aldama','Torrez','Israel','IDIF8R894G9VR','DKFGJGJ','1997-03-13','Masculino','Divorciado','DFJFJJ','IDUF','99896','IDEJFFUU','IUDUJDUDUU','7677828289','IIGITBIBTKBTKBTKKB','DKKKK@gmail.com','Maestria',NULL,NULL,7,0,0,'Computacion',NULL,NULL,'Mtro','Docente',6872,'A',2014,12,2014,5,2013,3,2014,2,'Docentes','2013-01-31',NULL,NULL,1,8,8),(5,'Roman','Perez','Erick','RXBE021120312','Morelos','2024-02-02','Masculino','Casado','KFJGJIGI','JUDUDUUF','62557','Morelos','NVNUBTUH','7779023','RXBE021120HMSMRRA3','erick67@gmail.com','Primaria',NULL,NULL,6,0,0,'IFJG',NULL,NULL,'Ing','Docente',5721,'A',2001,2,2002,8,2004,5,2003,10,'Administrativas','2024-02-04',NULL,NULL,1,3,2),(6,'Roman','Barrera','Erick','GVGYEYGEGCEGC','Morelos','2024-02-09','Masculino','Casado','FHHHG','HFHFHH','62345','mo','djfj','7776800231','RXBE021120HMSMRRA3','erick@gmail.com','Maestria',NULL,NULL,9,0,0,'Tecnogias de la informacion',NULL,NULL,'Mr','Docente',7653,'A',2001,2,NULL,NULL,NULL,NULL,NULL,NULL,'Administrativas','2024-02-15',NULL,81,1,6,6),(7,'Roman','Barrera','Erick Eduardo','GVGYEYGEGCEGC','Morelos','2024-02-09','Masculino','Casado','FHHHG','HFHFHH','62345','mo','djfj','7776800231','RXBE021120HMSMRRA3','erick@gmail.com','Maestria',NULL,NULL,9,0,0,'Tecnogias de la informacion',NULL,NULL,'Mr','Docente',7653,'B',2001,2,NULL,NULL,NULL,NULL,NULL,NULL,'Administrativas','2024-02-15',NULL,NULL,2,6,6);
/*!40000 ALTER TABLE `personal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plazas`
--

DROP TABLE IF EXISTS `plazas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plazas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `diagonal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unidad` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subunidad` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `horas` int NOT NULL,
  `TipoMovimiento` int NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `idCategoria` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plazas_idcategoria_foreign` (`idCategoria`),
  CONSTRAINT `plazas_idcategoria_foreign` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plazas`
--

LOCK TABLES `plazas` WRITE;
/*!40000 ALTER TABLE `plazas` DISABLE KEYS */;
INSERT INTO `plazas` VALUES (4,'64782','18','2',36,20,0,3,'2024-02-16 03:35:33','2024-02-16 03:35:33');
/*!40000 ALTER TABLE `plazas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (4,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Comite de Calidad','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(2,'Academicos','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(3,'Departamento de desarrollo academico','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(4,'Division de estudios Profesionales','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(5,'Direccion','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(6,'Docentes','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(7,'Recursos Humanos','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(8,'Escolares','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(9,'Gestion tecnologica y vinculacion','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(10,'Departamento de planeacion','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(11,'Administrador','web','2024-01-12 03:37:21','2024-01-12 03:37:21'),(12,'Secretarias CENIDET','web','2024-01-12 03:37:21','2024-01-12 03:37:21');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
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
INSERT INTO `sessions` VALUES ('ed4MR7y56MrYrdBRqdNIkZI1V2HTJbfnJ3pCgWl7',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoiNGlVYVFPbll5NWdMTkFNTzFjZnJPZ1A2TWF5QURlQXhsRTg3Q2w3cSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1708034596),('rtWDBNJLadvInGVbQ4dF4lZ43czIpj1xoAhSdmX5',82,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 OPR/106.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUENDS2RxaUxPQ3N0cUVMSFhZWmpsVVhFM1JHaFJlMjRUUEVHZk5oWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkS2ZKUDFqYW1JbXJoQ3YvZ0cvQm1zdUM1QXlaVklXWXFZRlVJdmxIMzVwQXFtSFp1a2QyelciO30=',1708034657);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subdireccion`
--

DROP TABLE IF EXISTS `subdireccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subdireccion` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subdireccion`
--

LOCK TABLES `subdireccion` WRITE;
/*!40000 ALTER TABLE `subdireccion` DISABLE KEYS */;
INSERT INTO `subdireccion` VALUES (1,'Subdireccion academica'),(2,'Subdireccion de Planeacion y vinculacion'),(3,'Subdireccion de Servicios administrativos'),(4,'Direccion');
/*!40000 ALTER TABLE `subdireccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `Estatus` tinyint(1) NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Bertram Williamson V','walter.lamar@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'4f7lgJfckG',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(2,'Abraham Renner','tmoore@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'gVXe7AdyXu',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(3,'Prof. Lula Bogisich IV','bradly56@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'j2KDmgidvl',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(4,'Eldred Bosco','myrtle79@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'ncbClAjFtZ',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(5,'Keyshawn Reilly MD','qkirlin@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'6d25LmR0rQ',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(6,'Camron Cummerata','hills.flavie@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'wV6AEHPpJm',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(7,'Jo Crooks','hollie99@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'gUicdZGQ6b',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(8,'Delmer Sporer','mason.schamberger@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'4fjdKRxDrx',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(9,'Lavonne Buckridge','yhermann@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'kaI7hXjrqh',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(10,'Prof. Theodora Bartoletti','hammes.jackie@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'hhmMV18tLN',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(11,'Della Gleason','noel01@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'Yz2RzHWCAu',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(12,'Dr. Jesus Pacocha DVM','jakubowski.vincenza@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'l5cHvUfXs7',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(13,'Prof. Gwen Dooley','mcglynn.aimee@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'UmWCIcQAL3',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(14,'Marlen Franecki','trevion74@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'Q3jLxTW7xR',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(15,'Dr. Raegan Corwin DDS','andreanne84@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'XgjWCmGUsR',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(16,'Mr. Ed Collins PhD','carroll.madisen@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'3FSNHDttEf',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(17,'Leopold Von','connelly.rhiannon@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'RCrt64ShNy',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(18,'Ernestine Hermiston','schaefer.jaiden@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'EQlAKih2gY',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(19,'Dr. Russell Waelchi DVM','hermann.daphnee@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'uGsOSOqFKJ',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(20,'Prof. Winston Blanda','citlalli20@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'p87fbBTYF4',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(21,'Mr. Nils Ziemann DVM','grohan@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'onzNF5P4yp',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(22,'Dr. Ottilie Padberg','wkonopelski@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'Nl9OSRMmeu',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(23,'Rafaela Kozey DDS','anita92@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'P12qljHWEb',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(24,'Prof. Edgardo Weber DDS','lheidenreich@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'kRMYtoIHNu',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(25,'Magnus Morar','ucasper@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'q2S2ks0FU1',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(26,'Kareem Dickens','maggio.cullen@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'DgDFjxhMaz',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(27,'Ryder Howell','celestino82@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'1Z58XdalOW',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(28,'Lula Williamson','tdouglas@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'1kqYwUrLSd',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(29,'Prof. Myles Goodwin I','vleuschke@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'VjHy9V5ncm',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(30,'Dangelo Hodkiewicz','lincoln.satterfield@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'m1DaHnxUpm',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(31,'Marshall Farrell','jkeebler@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'9GOQIfSaoJ',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(32,'Marlen Conn','estell14@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'KGRDtvW4ww',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(33,'Sammie Marks','agustin51@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'MHtUZOc497',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(34,'Shane Kilback','dare.abbie@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'IA97Tf2wPb',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(35,'Mr. Santino Gottlieb','onie.cremin@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'lxou1S6xFH',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(36,'Nigel Toy','lucius.anderson@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'jZhL0xryLh',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(37,'Trever Smith','kuvalis.jeanne@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'Rz5XkLKmVo',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(38,'Mr. Judge Miller','wyatt18@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'DYwl7MWteo',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(39,'Bridie Krajcik','glenda.rice@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'uSid37MP4M',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(40,'Tito Walker','yasmeen.thiel@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'g1dhDPuU73',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(41,'Mr. Robbie Bergstrom MD','reynold94@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'vqgfK46qvL',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(42,'Mr. Gregory McKenzie DVM','vivien.rohan@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'Dxq04eqczu',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(43,'Margarette Crooks','pwindler@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'nbLBMVk44a',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(44,'Miss Madie Hettinger MD','paige.beatty@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'bXZLFyNj4x',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(45,'Prof. Jaunita Lakin','bschaden@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'hwCgWTfAMi',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(46,'Jedediah Wilkinson','jennie28@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'czjwSwPmgZ',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(47,'Ruthe Mraz DDS','goldner.frances@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'cQq8KQ0jYn',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(48,'Miss Elisha Reinger Sr.','cleo33@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'JPahXmlavc',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(49,'Nina Pagac','graciela14@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'6DEtaQLSNE',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(50,'Felipe Hoeger','claude66@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'fcims7m0uB',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(51,'Gregory Lubowitz MD','greenholt.estel@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'afvX2wqvhl',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(52,'Claude O\'Kon','kamren20@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'24DTFj96A8',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(53,'Mckayla O\'Conner','egraham@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'ispYwCw7Qe',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(54,'Lizeth Kemmer','ykuhlman@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'Twsy9tpGSU',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(55,'Ms. Lauren Haag II','helen.wisoky@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'ugkZQ8KuNk',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(56,'Luis McClure','wolf.tito@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'hi2TSDaHV8',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(57,'Della Hartmann I','hegmann.garnet@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'l6CPl4qtrw',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(58,'Dock Zemlak','marcella.bauch@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'3RW3NuHoCk',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(59,'Mr. Clair Hilpert','labadie.sydnie@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'I5OXXbbCkW',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(60,'Antonetta Fisher','schroeder.nola@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'esNreCIBcx',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(61,'Prof. Abe Considine','clint50@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'73SfbA5tz5',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(62,'Dina Reinger','mohammed21@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'zjJdwcJZSR',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(63,'Stephen Prosacco','gillian06@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'GNQX7CpwFY',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(64,'Prof. Suzanne Feeney','diego61@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'U1Jvmoyc23',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(65,'Prof. May Schmidt','langosh.lucile@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'1AJMB4D1vn',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(66,'Bertram Rath','eldora.roberts@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'xDSygEvK2b',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(67,'Dr. Flavio Daugherty II','gunnar.upton@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'QnVIp9XvPI',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(68,'Jamarcus West','rpacocha@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'xukjPTydAw',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(69,'Mr. Alvah Fadel Sr.','ilangosh@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'lmGk0nMImV',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(70,'Dr. Caesar Waelchi MD','charlotte61@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'U738unckNi',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(71,'Pearlie Corkery DDS','bessie.wisoky@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'sHcmISj97e',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(72,'Dina Stark','katelynn01@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'PTX6p1Crcr',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(73,'Nico Dibbert','vincenza.oconner@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'pmgyHTJg7e',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(74,'Rey D\'Amore IV','betsy45@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'82QIQ40vjp',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(75,'Dr. Jerad Zboncak Jr.','windler.kaden@example.org',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'VZSAO7o8U2',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(76,'Lolita Schinner Sr.','liliana84@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'6zKPsSFHOP',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(77,'Maye Marks','coy.krajcik@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'UxxNNtePJ4',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(78,'Korey Lebsack','providenci.gislason@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'jGrzyDKBLz',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(79,'Mrs. Cecelia Spinka','karlie16@example.com',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'7T8TOI9CjF',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(80,'Dr. Oleta Nolan PhD','kerluke.golden@example.net',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,0,'gtST4ujsx1',NULL,NULL,'2024-01-12 03:37:22','2024-01-12 03:37:22'),(81,'Jorge','rbeo201569@upemor.edu.mx','2024-01-12 03:37:22','$2y$10$gFz/M/A8yIxILGKt6o/TUOJDaLiAQB5xXyuwLJZNIVFD5hqFO75Dq',NULL,NULL,NULL,0,'wublJegu66ijBw0DoSXtlUaWNLvFl2uajOflfyhFU10hcexp4aG41433mgDb',NULL,NULL,'2024-01-12 03:37:22','2024-02-16 04:01:47'),(82,'Erick120','erickrra11@gmail.com','2024-01-12 03:37:23','$2y$10$KfJP1jamImrhCv/gG/BmsuC5AyZVIWYqYFUIvlH35pAqmHZukd2zW',NULL,NULL,NULL,0,'PMP6KgfSHxdnTmqPoQVG19Cq9efSWQDV0hYcWg1V9qkHNZFpPzjySgnmbEbU',NULL,NULL,'2024-01-12 03:37:23','2024-02-16 03:47:47'),(86,'Maria','Maria@gmail.com',NULL,'$2y$10$MM.dG/dpxHECcxC0IDN5Ne6ccro/nhfgLhuhIIXV7AykQZ1nouzTi',NULL,NULL,NULL,0,NULL,NULL,NULL,'2024-02-06 03:35:54','2024-02-06 03:35:54'),(92,'Erick50','erick86@gmail.com',NULL,'$2y$10$K4F42B1TZPCmTYXxsQavwO.Aj7M2oJxinZqyUIIy15d9ctXuEwtDW',NULL,NULL,NULL,0,NULL,NULL,NULL,'2024-02-16 03:46:25','2024-02-16 03:46:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vigenciapersonal`
--

DROP TABLE IF EXISTS `vigenciapersonal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vigenciapersonal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `idPersonal` bigint unsigned DEFAULT NULL,
  `idPeriodo` bigint unsigned DEFAULT NULL,
  `InicioVigencia` date NOT NULL,
  `FinVigencia` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vigenciapersonal_idpersonal_foreign` (`idPersonal`),
  KEY `vigenciapersonal_idperiodo_foreign` (`idPeriodo`),
  CONSTRAINT `vigenciapersonal_idperiodo_foreign` FOREIGN KEY (`idPeriodo`) REFERENCES `periodos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `vigenciapersonal_idpersonal_foreign` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vigenciapersonal`
--

LOCK TABLES `vigenciapersonal` WRITE;
/*!40000 ALTER TABLE `vigenciapersonal` DISABLE KEYS */;
/*!40000 ALTER TABLE `vigenciapersonal` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-15 16:04:19
