-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.6.7-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sis_inventario
DROP DATABASE IF EXISTS `sis_inventario`;
CREATE DATABASE IF NOT EXISTS `sis_inventario` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sis_inventario`;

-- Volcando estructura para tabla sis_inventario.categorias
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.categorias: ~4 rows (aproximadamente)
DELETE FROM `categorias`;
INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
	(1, 'Equipos de Cómputo', '2022-05-09 17:52:08'),
	(2, 'Útiles de Aseo', '2022-05-09 17:52:28'),
	(3, 'Útiles de Papelería', '2022-05-09 17:52:40'),
	(7, 'SERVICIOS', '2022-08-06 12:43:36'),
	(8, 'Móviles ', '2022-08-13 13:20:24');

-- Volcando estructura para tabla sis_inventario.instructores
DROP TABLE IF EXISTS `instructores`;
CREATE TABLE IF NOT EXISTS `instructores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `documento` bigint(20) NOT NULL,
  `email` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `entradas` int(11) DEFAULT NULL,
  `ultima_entrada` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.instructores: ~2 rows (aproximadamente)
DELETE FROM `instructores`;
INSERT INTO `instructores` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `entradas`, `ultima_entrada`, `fecha`) VALUES
	(1, 'Jhon Fabio  card', 1093537019, 'programasjhonfa@gmai.com', '(310) 566-7418', 'CR 5 # 5-55', '1994-05-09', 6, '2022-05-09 23:08:04', '2022-08-12 03:30:07'),
	(3, 'Juan Villegas', 2147483647, 'juan@hotmail.com', '(300) 341-2345', 'Calle 23 # 45 - 56', '1980-11-02', 7, '2022-02-06 17:47:02', '2022-02-06 22:47:02'),
	(13, 'Juan fernando Urrego', 238923489, 'juqn@gmai.com', '(122) 312-1231', 'medellin colombia', '2000-02-20', NULL, NULL, '2022-08-13 13:39:38');

-- Volcando estructura para tabla sis_inventario.inventario
DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `idInventario` int(11) NOT NULL AUTO_INCREMENT,
  `tipoMovimiento` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fechaMovimiento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `codProducto` int(11) NOT NULL,
  `observacion` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idInventario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla sis_inventario.inventario: ~6 rows (aproximadamente)
DELETE FROM `inventario`;
INSERT INTO `inventario` (`idInventario`, `tipoMovimiento`, `cantidad`, `fechaMovimiento`, `codProducto`, `observacion`) VALUES
	(3, 1, 100, '2022-05-10 18:38:56', 2, ''),
	(4, 1, 100, '2022-05-10 18:44:08', 2, ''),
	(5, 1, 10, '2022-05-10 18:53:32', 2, ''),
	(6, 2, 15, '2022-05-10 18:53:47', 2, ''),
	(7, 2, 2001, '2022-05-10 18:54:02', 2, ''),
	(8, 2, 200, '2022-05-10 18:54:17', 2, '');

-- Volcando estructura para tabla sis_inventario.prestamos
DROP TABLE IF EXISTS `prestamos`;
CREATE TABLE IF NOT EXISTS `prestamos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_instructor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'ID DEL USUARIO',
  `tipo_prestamo` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_devolucion` timestamp NULL DEFAULT NULL,
  `ficha` varchar(255) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `observaciones` varchar(1000) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_prestamo_id_usuario` (`id_usuario`),
  KEY `FK_prestamo_id_instructor` (`id_instructor`),
  CONSTRAINT `FK_prestamo_id_instructor` FOREIGN KEY (`id_instructor`) REFERENCES `instructores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_prestamo_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.prestamos: ~14 rows (aproximadamente)
DELETE FROM `prestamos`;
INSERT INTO `prestamos` (`id`, `id_instructor`, `id_usuario`, `tipo_prestamo`, `fecha`, `fecha_devolucion`, `ficha`, `observaciones`) VALUES
	(40, 1, 1, 'Consumible', '2022-05-11 04:28:40', NULL, NULL, NULL),
	(41, 3, 1, 'Consumible', '2022-05-11 04:28:40', NULL, NULL, NULL),
	(42, 3, 1, 'Consumible', '2022-05-11 04:28:40', NULL, NULL, NULL),
	(43, 1, 1, 'Consumible', '2022-05-11 04:28:40', NULL, NULL, NULL),
	(44, 3, 1, 'Consumible', '2022-05-11 04:28:40', NULL, NULL, NULL),
	(45, 1, 1, 'Devolutivo', '2022-05-11 04:22:28', '2022-05-08 05:00:00', NULL, NULL),
	(46, 3, 1, 'Devolutivo', '2022-08-03 04:23:35', '2022-05-09 05:00:00', NULL, NULL),
	(47, 3, 1, 'Devolutivo', '2022-08-04 04:27:26', '2022-05-10 05:00:00', NULL, NULL),
	(48, 3, 1, 'Consumible', '2022-08-04 04:29:48', NULL, NULL, NULL),
	(49, 1, 1, 'Devolutivo', '2022-08-05 04:35:42', '2022-05-10 05:00:00', NULL, NULL),
	(50, 1, 1, 'Devolutivo', '2022-08-04 12:47:00', NULL, NULL, NULL),
	(51, 1, 1, 'Devolutivo', '2022-08-06 14:26:00', NULL, '62', '1'),
	(52, 1, 1, 'Devolutivo', '2022-08-06 15:08:00', NULL, '452564685', 'Se REGRESE X FECHA'),
	(53, 1, 1, 'Consumible', '2022-08-06 15:09:00', NULL, '867333', 'SIN NOVEDADES');

-- Volcando estructura para tabla sis_inventario.prestamo_detalle
DROP TABLE IF EXISTS `prestamo_detalle`;
CREATE TABLE IF NOT EXISTS `prestamo_detalle` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prestamo_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_prestamo_detalle_id` (`prestamo_id`),
  KEY `FK_prestamo_detalle_producto` (`producto_id`),
  CONSTRAINT `FK_prestamo_detalle_id` FOREIGN KEY (`prestamo_id`) REFERENCES `prestamos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_prestamo_detalle_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar los productos del prestamo del detalle';

-- Volcando datos para la tabla sis_inventario.prestamo_detalle: ~2 rows (aproximadamente)
DELETE FROM `prestamo_detalle`;
INSERT INTO `prestamo_detalle` (`id`, `prestamo_id`, `producto_id`, `cantidad`) VALUES
	(1, 52, 62, 1),
	(2, 52, 2, 1),
	(3, 53, 61, 10);

-- Volcando estructura para tabla sis_inventario.productos
DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `codigo` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `marca` varchar(20) COLLATE utf8mb3_spanish_ci NOT NULL,
  `serial` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `prestamos` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `FK_producto_id_categoria` (`id_categoria`),
  CONSTRAINT `FK_producto_id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.productos: ~4 rows (aproximadamente)
DELETE FROM `productos`;
INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `descripcion`, `imagen`, `stock`, `marca`, `serial`, `prestamos`, `fecha`) VALUES
	(2, 1, '102', 'Computador Hp Pavilion', 'vistas/img/productos/102/940.jpg', 10, '4500', '6300', 3, '2022-08-06 15:08:39'),
	(61, 3, '100', 'Boligrafos', NULL, 75, 'Allegro', 'zxzzzz', 0, '2022-08-06 15:09:18'),
	(62, 1, '103', 'Video Bean', 'vistas/img/productos/103/742.png', 4, 'Sony', '13145asd6f', 0, '2022-08-06 16:33:05'),
	(63, 1, 'mouse123', 'Mouse inalmbrico', 'vistas/img/productos/mouse123/651.jpg', 22, 'Lenovo', 'JLKASJDF8I', 0, '2022-08-13 13:17:05');

-- Volcando estructura para tabla sis_inventario.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `password` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `foto` text COLLATE utf8mb3_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- Volcando datos para la tabla sis_inventario.usuarios: ~4 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
	(1, 'Marta Isaza', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/admin.png', 1, '2022-08-13 10:10:15', '2022-08-13 15:10:15'),
	(58, 'Diana Rico', 'diana', '$2a$07$asxx54ahjppf45sd87a5auQhldmFjGsrgUipGlmQgDAcqevQZSAAC', 'Funcionario', 'vistas/img/usuarios/julio/100.png', 1, '2018-02-06 17:09:22', '2022-05-09 06:06:39'),
	(59, 'Estella Saleme', 'Estella', '$2a$07$asxx54ahjppf45sd87a5auLd2AxYsA/2BbmGKNk2kMChC3oj7V0Ca', 'Vendedor', 'vistas/img/usuarios/ana/260.png', 1, '2022-05-09 19:21:40', '2022-05-09 06:06:42'),
	(64, 'Delia Herazo', 'Delia', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Especial', 'vistas/img/usuarios/Ralquerque/116.jpg', 1, '2022-05-08 23:07:38', '2022-05-09 16:31:15'),
	(65, 'Jhon Fabio Cardona Martinez', 'jhonfa', '$2a$07$asxx54ahjppf45sd87a5aumUskocpQucMnvwsUt.aC6WLWGcLNcY6', 'Administrador', 'vistas/img/usuarios/jhonfa/618.jpg', 1, '2022-08-13 10:10:32', '2022-08-13 15:10:32');

-- Volcando estructura para función sis_inventario.f_lista_productos
DROP FUNCTION IF EXISTS `f_lista_productos`;
DELIMITER //
CREATE FUNCTION `f_lista_productos`(`vIdPrestamo` INT
) RETURNS text CHARSET latin1
    READS SQL DATA
    COMMENT 'Lista de productos por prestamo'
BEGIN

DECLARE producto TEXT DEFAULT '';
DECLARE result TEXT  DEFAULT '';
DECLARE terminoLeerCursor BOOL DEFAULT FALSE;


DECLARE cursorProductos CURSOR FOR

SELECT p.descripcion FROM prestamo_detalle dt 
JOIN productos p ON dt.producto_id = p.id
WHERE dt.prestamo_id = vIdPrestamo;

	-- CODIGO 02000 ES DE MYSQL QUE IDENTIFICA CUANDO LLEGA A LA ULTIMIA FILA DE LA CONSULTA
DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET terminoLeerCursor = TRUE;

	-- ABRIMOS EL CURSOR
	OPEN cursorProductos;
	
		RecorreCursor:LOOP
			FETCH cursorProductos INTO producto;
			
			IF terminoLeerCursor THEN
				LEAVE RecorreCursor;
			ELSE
				IF result = '' THEN 
					SET result = CONCAT('', producto);
				ELSE 
					SET result = CONCAT(result, ', ', producto);					
				END IF;
			END IF;		
		
		
		END LOOP;
	
	
	CLOSE cursorProductos;
	RETURN result;

END//
DELIMITER ;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
