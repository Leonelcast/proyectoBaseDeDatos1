-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-09-2020 a las 14:39:31
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambiosestados`
--

CREATE TABLE `cambiosestados` (
  `IdCambioEstado` int(11) NOT NULL AUTO_INCREMENT,
  `IdPedido` int(11) NOT NULL,
  `IdEstadoPedido` int(11) NOT NULL,
  `Comentario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `IdCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`IdCategoria`, `Tipo`) VALUES
(1, 'Navideno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadopedidos`
--

CREATE TABLE `estadopedidos` (
  `IdEstadoPedido` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `IdIngrediente` int(11) NOT NULL AUTO_INCREMENT,
  `Inventario` int(11) NOT NULL,
  `Ingrediente` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`IdIngrediente`, `Inventario`, `Ingrediente`) VALUES
(1, 100, 'Quesos'),
(3, 500, 'Carne'),
(4, 50, 'Queso'),
(6, 60, 'Salsa'),
(7, 100, 'Piña'),
(8, 100, 'Tomate'),
(9, 100, 'Champiñones'),
(10, 1000, 'Chile pimiento'),
(18, 5, 'Lechuga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `IdMenu` int(11) NOT NULL AUTO_INCREMENT,
  `IdCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`IdMenu`, `IdCategoria`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `IdPedido` int(11) NOT NULL AUTO_INCREMENT,
  `IdEstadoPedido` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Descricpion` varchar(255) NOT NULL,
  `Confirmado` bit(1) NOT NULL,
  `IdUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidosplatillos`
--

CREATE TABLE `pedidosplatillos` (
  `IdPedidoPlatillo` int(11) NOT NULL AUTO_INCREMENT,
  `IdPedido` int(11) NOT NULL,
  `IdPlatillo` int(11) NOT NULL,
  `Observacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillos`
--

CREATE TABLE `platillos` (
  `IdPlatillos` int(11) NOT NULL AUTO_INCREMENT,
  `precio` decimal(19,2) NOT NULL,
  `IdMenu` int(11) NOT NULL,
  `destacado` bit(1) NOT NULL,
  `habilitado` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `platillos`
--

INSERT INTO `platillos` (`IdPlatillos`, `precio`, `IdMenu`, `destacado`, `habilitado`) VALUES
(1, '100.00', 1, b'1', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillosingredientes`
--

CREATE TABLE `platillosingredientes` (
  `IdPlatillosIngredientes` int(11) NOT NULL AUTO_INCREMENT,
  `IdIngrediente` int(11) NOT NULL,
  `IdPlatillo` int(11) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `platillosingredientes`
--

INSERT INTO `platillosingredientes` (`IdPlatillosIngredientes`, `IdIngrediente`, `IdPlatillo`, `Descripcion`, `Cantidad`) VALUES
(1, 1, 1, 'Jamon', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `IdRol` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

CREATE TABLE `tarjetas` (
  `IdTarjeta` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Direccion` varchar(255) NOT NULL,
  `NumeroTarjeta` varchar(255) NOT NULL,
  `FechaExpiracion` date NOT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuario` int(11) NOT NULL ,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `IdRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cambiosestados`
--
ALTER TABLE `cambiosestados`
  ADD PRIMARY KEY (`IdCambioEstado`),
  ADD KEY `IdEstadoPedido` (`IdEstadoPedido`),
  ADD KEY `IdPedido` (`IdPedido`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indices de la tabla `estadopedidos`
--
ALTER TABLE `estadopedidos`
  ADD PRIMARY KEY (`IdEstadoPedido`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`IdIngrediente`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`IdMenu`),
  ADD KEY `IdCategoria` (`IdCategoria`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`IdPedido`),
  ADD KEY `IdEstadoPedido` (`IdEstadoPedido`),
  ADD KEY `IdUsuarios` (`IdUsuarios`);

--
-- Indices de la tabla `pedidosplatillos`
--
ALTER TABLE `pedidosplatillos`
  ADD PRIMARY KEY (`IdPedidoPlatillo`),
  ADD KEY `IdPlatillo` (`IdPlatillo`),
  ADD KEY `IdPedido` (`IdPedido`);

--
-- Indices de la tabla `platillos`
--
ALTER TABLE `platillos`
  ADD PRIMARY KEY (`IdPlatillos`),
  ADD KEY `IdMenu` (`IdMenu`);

--
-- Indices de la tabla `platillosingredientes`
--
ALTER TABLE `platillosingredientes`
  ADD PRIMARY KEY (`IdPlatillosIngredientes`),
  ADD KEY `IdPlatillo` (`IdPlatillo`),
  ADD KEY `IdIngrediente` (`IdIngrediente`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD PRIMARY KEY (`IdTarjeta`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD KEY `IdRol` (`IdRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `IdIngrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `platillosingredientes`
--
ALTER TABLE `platillosingredientes`
  MODIFY `IdPlatillosIngredientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cambiosestados`
--
ALTER TABLE `cambiosestados`
  ADD CONSTRAINT `cambiosestados_ibfk_1` FOREIGN KEY (`IdEstadoPedido`) REFERENCES `estadopedidos` (`IdEstadoPedido`),
  ADD CONSTRAINT `cambiosestados_ibfk_2` FOREIGN KEY (`IdPedido`) REFERENCES `pedidos` (`IdPedido`);

--
-- Filtros para la tabla `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`IdCategoria`) REFERENCES `categorias` (`IdCategoria`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`IdEstadoPedido`) REFERENCES `estadopedidos` (`IdEstadoPedido`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`IdUsuarios`) REFERENCES `usuarios` (`IdUsuario`);

--
-- Filtros para la tabla `pedidosplatillos`
--
ALTER TABLE `pedidosplatillos`
  ADD CONSTRAINT `pedidosplatillos_ibfk_1` FOREIGN KEY (`IdPlatillo`) REFERENCES `platillos` (`IdPlatillos`),
  ADD CONSTRAINT `pedidosplatillos_ibfk_2` FOREIGN KEY (`IdPedido`) REFERENCES `pedidos` (`IdPedido`);

--
-- Filtros para la tabla `platillos`
--
ALTER TABLE `platillos`
  ADD CONSTRAINT `platillos_ibfk_1` FOREIGN KEY (`IdMenu`) REFERENCES `menus` (`IdMenu`);

--
-- Filtros para la tabla `platillosingredientes`
--
ALTER TABLE `platillosingredientes`
  ADD CONSTRAINT `platillosingredientes_ibfk_1` FOREIGN KEY (`IdPlatillo`) REFERENCES `platillos` (`IdPlatillos`),
  ADD CONSTRAINT `platillosingredientes_ibfk_2` FOREIGN KEY (`IdIngrediente`) REFERENCES `ingredientes` (`IdIngrediente`);

--
-- Filtros para la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD CONSTRAINT `tarjetas_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`IdRol`) REFERENCES `roles` (`IdRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
