CREATE DATABASE  IF NOT EXISTS `bdsis`;
USE `bdsis`;
--
-- Table structure for table `almacenes`
--

DROP TABLE IF EXISTS `almacenes`;
CREATE TABLE `almacenes` (
  `alma_id_almacen` int NOT NULL AUTO_INCREMENT,
  `alma_nombre_almacen` varchar(100) NOT NULL,
  `alma_localizacion` varchar(120) DEFAULT NULL,
  `alma_responsable` varchar(45) DEFAULT NULL,
  `alma_tipo` char(1) NOT NULL COMMENT '(V) Virtual | (F) Fisico',
  PRIMARY KEY (`alma_id_almacen`),
  UNIQUE KEY `alma_id_almacen_UNIQUE` (`alma_id_almacen`),
  CONSTRAINT `chk_tipo_almacen` CHECK (((`alma_tipo` = _utf8mb3'V') or (`alma_tipo` = _utf8mb3'F')))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
--
-- Dumping data for table `almacenes`
--

LOCK TABLES `almacenes` WRITE;
INSERT INTO `almacenes` VALUES (1,'Almacen 1','Direccion de almacen 1','Juan','F'),(2,'Almacen 2','Direccion de almacen 2','Pedro','V'),(3,'Almacen 3','Direccion de almacen 3','Jesus','F'),(4,'Almacen 4','Direccion de almacen 4','Gael','V');
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `prod_id_producto` int NOT NULL AUTO_INCREMENT,
  `prod_sku` varchar(45) NOT NULL,
  `prod_descripcion` varchar(100) NOT NULL,
  `prod_marca` varchar(45) NOT NULL,
  `prod_color` varchar(45) DEFAULT NULL,
  `prod_precio` float NOT NULL,
  PRIMARY KEY (`prod_id_producto`),
  UNIQUE KEY `prod_sku_UNIQUE` (`prod_sku`),
  UNIQUE KEY `prod_id_producto_UNIQUE` (`prod_id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
INSERT INTO `productos` VALUES (1,'75002343','Producto 1','Marca 1','Rojo',10),(2,'75005443','Producto 2','Marca 2','Amarillo',11),(3,'7502223772250','Producto 3','Marca 3','Verde',12),(4,'7501491062032','Producto 4','Marca 4','Azul',13),(5,'75007973','Producto 5','Marca 5','Rojo',15),(6,'7501039121610','Producto 6','Marca 6','Rojo',16),(7,'7503009924092','Producto 7','Marca 7','Amarillo',17),(8,'7501071302275','Producto 8','Marca 8','Verde',18),(9,'7503017898002','Producto 9','Marca 9','Rojo',19),(10,'7501372810325','Producto 10','Marca 10','Verde',20),(11,'7501761810394','Producto 11','Marca 11','Amarillo',21),(12,'7501041415592','Producto 12','Marca 12','Rojo',22),(13,'7501045403915','Producto 13','Marca 13','Verde',23),(14,'7501045403908','Producto 14','Marca 14','Amarillo',24),(15,'7501005106979','Producto 15','Marca 15','Rojo',25);
UNLOCK TABLES;

--
-- Table structure for table `existencias`
--

DROP TABLE IF EXISTS `existencias`;
CREATE TABLE `existencias` (
  `exis_id_existencia` int NOT NULL AUTO_INCREMENT,
  `exis_id_producto` int NOT NULL,
  `exis_id_almacen` int NOT NULL,
  `exis_existencias` int NOT NULL,
  PRIMARY KEY (`exis_id_existencia`),
  UNIQUE KEY `exis_id_existencia_UNIQUE` (`exis_id_existencia`),
  KEY `fk_existencias_productos_idx` (`exis_id_producto`),
  KEY `fk_existencias_almacenes1_idx` (`exis_id_almacen`),
  CONSTRAINT `fk_existencias_almacenes1` FOREIGN KEY (`exis_id_almacen`) REFERENCES `almacenes` (`alma_id_almacen`),
  CONSTRAINT `fk_existencias_productos` FOREIGN KEY (`exis_id_producto`) REFERENCES `productos` (`prod_id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `existencias`
--

LOCK TABLES `existencias` WRITE;
INSERT INTO `existencias` VALUES (1,1,1,5),(2,2,2,5),(3,3,3,7),(4,4,4,32),(5,5,1,7),(6,6,2,2),(7,7,3,6),(8,8,4,8),(9,9,1,23),(10,10,2,7),(11,11,3,23),(12,12,4,6),(13,13,1,24),(14,14,2,23),(15,15,3,32),(16,1,1,10),(17,2,2,78),(18,3,3,24),(19,4,4,10),(20,5,1,24);
UNLOCK TABLES;