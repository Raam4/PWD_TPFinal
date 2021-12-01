-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2021 a las 17:33:14
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdcarritocompras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL,
  `cofecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idusuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `compra`
--
DELIMITER $$
CREATE TRIGGER `asigna_estado` AFTER INSERT ON `compra` FOR EACH ROW INSERT INTO compraestado(idcompra, idcompraestadotipo) VALUES (NEW.idcompra, 1)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraestado` (
  `idcompraestado` bigint(20) UNSIGNED NOT NULL,
  `idcompra` bigint(11) NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT current_timestamp(),
  `cefechafin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'Iniciado', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'Aceptado', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'Enviado', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'Cancelado', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL,
  `citotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT current_timestamp() COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`) VALUES
(1, 'public', 'Menú para la vista pública', NULL, '0000-00-00 00:00:00'),
(2, 'admin', 'Menú para la vista del admin', NULL, NULL),
(3, 'cliente', 'Menú para la vista del cliente', NULL, '0000-00-00 00:00:00'),
(4, 'deposito', 'Menú para la vista del depósito', NULL, '0000-00-00 00:00:00'),
(5, 'contacto', 'Sección para datos de ubicación para la vista de cliente', 3, '0000-00-00 00:00:00'),
(6, 'contacto', 'Sección para datos de ubicación para la vista pública', 1, '0000-00-00 00:00:00'),
(9, 'productos', 'Sección de productos para la vista pública y sin rol', 1, '0000-00-00 00:00:00'),
(10, 'productos', 'Sección de productos para la vista de cliente', 3, '0000-00-00 00:00:00'),
(11, 'productos', 'Sección de productos para la vista del depósito', 4, '0000-00-00 00:00:00'),
(12, 'carrito', 'Carrito de compras para la vista del cliente', 3, '0000-00-00 00:00:00'),
(13, 'pedidos', 'Sección para trabajar los pedidos para la vista del depósito', 4, '0000-00-00 00:00:00'),
(14, 'usuarios', 'Sección para administrar los usuarios para la vista del administrador', 2, '0000-00-00 00:00:00'),
(15, 'menus', 'Sección para administrar los menus para la vista del administrador', 2, '0000-00-00 00:00:00'),
(24, 'pedidos', 'pagina de pedidos para la vista de cliente', 3, NULL),
(27, 'roles', 'roles menus', 2, NULL),
(29, 'rubros', 'pagina de rubros para la vista de deposito', 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menurol`
--

INSERT INTO `menurol` (`idmenu`, `idrol`) VALUES
(1, 1),
(2, 2),
(3, 4),
(4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL,
  `pronombre` varchar(30) NOT NULL,
  `proprecio` double NOT NULL,
  `idrubro` bigint(20) NOT NULL,
  `prodetalle` varchar(512) NOT NULL,
  `procantstock` int(11) NOT NULL,
  `prodeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `pronombre`, `proprecio`, `idrubro`, `prodetalle`, `procantstock`, `prodeshabilitado`) VALUES
(1, 'Pispi', 1000, 2, 'Pispi 1000ml', 25, NULL),
(2, 'Cigarrillos', 250, 6, 'Atado x20', 100, NULL),
(3, 'Patagonia247', 190, 1, 'Lata 473 cc', 340, NULL),
(4, 'Encendedor', 100, 6, 'Por unidad', 63, NULL),
(5, 'Sprite', 300, 4, 'Botella 2.25l', 209, NULL),
(6, 'Gancia', 300, 3, 'Botella 1L', 56, NULL),
(7, 'Schweppes', 200, 4, 'Botella 1.5L', 93, NULL),
(8, 'Andes Origen roja', 160, 1, 'Lata 473cc', 120, NULL),
(9, 'Cordero con piel de lobo', 450, 2, 'Botella 1000ml', 15, NULL),
(10, 'Imperial rubia', 150, 1, 'Lata 710cc', 95, NULL),
(12, 'Ron Malibu', 1300, 5, 'Botella 1000ml', 16, NULL),
(13, 'Vodka Sernova', 500, 5, 'Botella 1000ml', 36, NULL),
(14, 'Quilmes rubia', 140, 1, 'Lata 473cc', 206, NULL),
(15, 'Benjamin Malbec', 300, 2, 'Botella 1000ml', 41, NULL),
(16, 'Chac Chac Rosado', 550, 2, 'Botella 1000ml', 20, NULL),
(17, 'Red Bull', 220, 4, 'Lata 250cc', 250, NULL),
(18, 'Dadá', 350, 2, 'Botella 1000ml', 17, NULL),
(19, 'Otro loco más', 350, 2, 'Botella 1000ml', 8, NULL),
(20, 'Fernet Branca', 750, 3, 'Botella 750ml', 203, NULL),
(21, 'Cachaca Pitu', 1100, 5, 'Botella 1000ml', 43, NULL),
(22, 'Whisky J&B', 1900, 5, 'Botella 1000ml', 5, NULL),
(23, 'Campari', 600, 3, 'Botella 1000ml', 108, NULL),
(24, 'Coca Cola', 300, 4, 'Botella 2.25L', 326, NULL),
(25, 'Andes Origen rubia', 150, 1, 'Lata 473cc', 103, NULL),
(26, 'Gin Gordons', 1100, 5, 'Botella 1000ml', 25, NULL),
(27, 'Vino Toro', 200, 2, 'Tetra 1000ml', 49, NULL),
(28, 'Heineken 710', 250, 1, 'Lata 710cc', 87, NULL),
(29, 'Perservativos Prime', 250, 6, 'Caja x3', 21, NULL),
(30, 'Papelillo OCB', 150, 6, 'Caja x3', 15, NULL),
(32, 'Stella Artois', 160, 1, 'Lata 473cc', 74, NULL),
(33, 'Temple Wolf IPA', 190, 1, 'Lata 473cc', 99, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `rodescripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rodescripcion`) VALUES
(1, 'Sin asignar'),
(2, 'Admin'),
(3, 'Deposito'),
(4, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubro`
--

CREATE TABLE `rubro` (
  `idrubro` bigint(20) NOT NULL,
  `runombre` varchar(20) NOT NULL,
  `rudeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rubro`
--

INSERT INTO `rubro` (`idrubro`, `runombre`, `rudeshabilitado`) VALUES
(1, 'Cerveza', NULL),
(2, 'Vino', NULL),
(3, 'Aperitivo', NULL),
(4, 'Sin alcohol', NULL),
(5, 'Bebidas blancas', NULL),
(6, 'Kiosco', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL,
  `usnombre` varchar(50) NOT NULL,
  `uspass` varchar(50) NOT NULL,
  `ustelefono` bigint(15) NOT NULL,
  `usmail` varchar(50) NOT NULL,
  `usfecnac` date DEFAULT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `ustelefono`, `usmail`, `usfecnac`, `usdeshabilitado`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 2995863776, 'mail@correo.com', '1997-04-02', NULL);

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `asigna_rol` AFTER INSERT ON `usuario` FOR EACH ROW INSERT INTO `usuariorol`(`idusuario`, `idrol`) VALUES (NEW.idusuario, 1)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idusuario`, `idrol`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD UNIQUE KEY `idcompra` (`idcompra`),
  ADD KEY `fkcompra_1` (`idusuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idcompraestado`),
  ADD UNIQUE KEY `idcompraestado` (`idcompraestado`),
  ADD KEY `fkcompraestado_1` (`idcompra`),
  ADD KEY `fkcompraestado_2` (`idcompraestadotipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idcompraestadotipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idcompraitem`),
  ADD UNIQUE KEY `idcompraitem` (`idcompraitem`),
  ADD KEY `fkcompraitem_1` (`idcompra`),
  ADD KEY `fkcompraitem_2` (`idproducto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD UNIQUE KEY `idmenu` (`idmenu`),
  ADD KEY `fkmenu_1` (`idpadre`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idrol`),
  ADD KEY `fkmenurol_2` (`idrol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `idproducto` (`idproducto`),
  ADD KEY `fkproducto_1` (`idrubro`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `idrol` (`idrol`);

--
-- Indices de la tabla `rubro`
--
ALTER TABLE `rubro`
  ADD PRIMARY KEY (`idrubro`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  MODIFY `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  MODIFY `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rubro`
--
ALTER TABLE `rubro`
  MODIFY `idrubro` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD CONSTRAINT `fkmenurol_1` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmenurol_2` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fkproducto_1` FOREIGN KEY (`idrubro`) REFERENCES `rubro` (`idrubro`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
