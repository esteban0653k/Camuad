-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2026 a las 23:16:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `camuad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Pinturas y acabados'),
(2, 'Tornillería y fijaciones'),
(3, 'Materiales de construcción'),
(4, 'Herramientas manuales'),
(5, 'Herramientas eléctricas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `numero_documento` int(11) NOT NULL,
  `nombre_cliente` varchar(100) DEFAULT NULL,
  `tipo_documento` varchar(50) DEFAULT NULL,
  `correo_cliente` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`numero_documento`, `nombre_cliente`, `tipo_documento`, `correo_cliente`, `fecha_registro`) VALUES
(221122322, 'Pepito perez', 'Cedula ciudadania', 'pepitoperez@gmail.com', '2026-05-14 14:43:41'),
(233332432, 'Paco gerte', 'Nit', 'pacoger@gmail.com', '2026-05-14 14:43:41'),
(434343555, 'Juan paez', 'Cedula ciudadania', 'juanpaez@gmail.com', '2026-05-14 14:43:41'),
(877895554, 'Esteban Rivera', 'Cedula extrajeria', 'estebanriv@gmail.com', '2026-05-14 14:43:41'),
(896440555, 'Diego bohorquez', 'DNI', 'dieguito@gmail.com', '2026-05-14 14:43:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detalle_venta` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` float(10,2) DEFAULT NULL,
  `subtotal` float(10,2) DEFAULT NULL,
  `estado_venta` tinyint(1) DEFAULT NULL,
  `producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id_detalle_venta`, `cantidad`, `precio_unitario`, `subtotal`, `estado_venta`, `producto`) VALUES
(1, 4, 5000.00, 20000.00, 1, 1),
(2, 2, 15000.00, 30000.00, 1, 4),
(3, 1, 80000.00, 80000.00, 0, 5),
(4, 6, 2500.00, 15000.00, 1, 5),
(5, 3, 12000.00, 36000.00, 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadisticas`
--

CREATE TABLE `estadisticas` (
  `id_estadisticas` int(11) NOT NULL,
  `tipo_estadistica` varchar(100) DEFAULT NULL,
  `fecha_generacion` datetime DEFAULT current_timestamp(),
  `id_reporte` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadisticas`
--

INSERT INTO `estadisticas` (`id_estadisticas`, `tipo_estadistica`, `fecha_generacion`, `id_reporte`, `stock`) VALUES
(1, 'Ventas diarias', '2026-05-14 14:43:41', 5, 5),
(2, 'Productos más vendidos', '2026-05-14 14:43:41', 2, 3),
(3, 'Inventario disponible', '2026-05-14 14:43:41', 3, 2),
(4, 'Clientes frecuentes', '2026-05-14 14:43:41', 4, 4),
(5, 'Ganancias mensuales', '2026-05-14 14:43:41', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `metodo_pago` varchar(100) DEFAULT NULL,
  `monto_recibido` float(10,2) DEFAULT NULL,
  `cambio` float(10,2) DEFAULT NULL,
  `fecha_factura` datetime DEFAULT current_timestamp(),
  `descuento` float(10,2) DEFAULT NULL,
  `IVA` float(10,2) DEFAULT NULL,
  `total` float(10,2) DEFAULT NULL,
  `detalle_venta` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `metodo_pago`, `monto_recibido`, `cambio`, `fecha_factura`, `descuento`, `IVA`, `total`, `detalle_venta`, `id_cliente`) VALUES
(1, 'Efectivo', 100000.00, 5000.00, '2026-05-14 14:43:41', 0.00, 19000.00, 95000.00, 1, 896440555),
(2, 'Tarjeta', 250000.00, 0.00, '2026-05-14 14:43:41', 10000.00, 45600.00, 240000.00, 2, 434343555),
(3, 'Transferencia', 180000.00, 0.00, '2026-05-14 14:43:41', 5000.00, 33250.00, 175000.00, 3, 896440555),
(4, 'Efectivo', 50000.00, 2000.00, '2026-05-14 14:43:41', 0.00, 9120.00, 48000.00, 4, 434343555),
(5, 'Nequi', 120000.00, 0.00, '2026-05-14 14:43:41', 3000.00, 22230.00, 117000.00, 5, 221122322);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES
(1, 'Bosch'),
(2, 'Stanley'),
(3, 'Makita'),
(4, 'DeWalt'),
(5, 'Truper');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) DEFAULT NULL,
  `imagen_producto` varchar(110) NOT NULL,
  `descripcion_producto` varchar(255) DEFAULT NULL,
  `precio_compra` float(10,2) DEFAULT NULL,
  `precio_venta` float(10,2) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `marca` int(11) DEFAULT NULL,
  `proveedor` varchar(12) DEFAULT NULL,
  `unidad_medida` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `imagen_producto`, `descripcion_producto`, `precio_compra`, `precio_venta`, `id_categoria`, `marca`, `proveedor`, `unidad_medida`) VALUES
(1, 'Martillo', 'https://www.ejemplo.com/producto/1', 'Martillo de acero con mango de goma', 12000.00, 18000.00, 4, 2, '904567890', '3/8'),
(2, 'Taladro', 'https://www.tiendaonline.com/articulo/abc123', 'Taladro eléctrico de 500W', 150000.00, 210000.00, 5, 5, '900123456', '200 g'),
(3, 'Destornillador', 'https://catalogo.demo.net/items/98765', 'Destornillador estrella tamaño mediano', 5000.00, 8500.00, 4, 4, '903456789', '3,5mm'),
(4, 'Sierra Manual', 'https://shop.test.org/productos/camiseta-azul', 'Sierra para corte de madera', 18000.00, 26000.00, 4, 1, '900123456', '12 pulgada'),
(5, 'Caja de Tornillos', 'https://marketplace.fake.co/item/ZX-4567', 'Caja surtida de tornillos metálicos', 22000.00, 35000.00, 2, 3, '903456789', '6 mm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `nit_proveedor` varchar(12) NOT NULL,
  `nombre_proveedor` varchar(100) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `correo_proveedor` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`nit_proveedor`, `nombre_proveedor`, `telefono`, `correo_proveedor`, `direccion`) VALUES
('900123456', 'Ferreaceros SAS', 2147483647, 'contacto@ferreaceros.com', 'Calle 10 #15-20'),
('901234567', 'Herramientas Industriales Ltda', 2147483647, 'ventas@herramientasind.com', 'Carrera 25 #40-15'),
('902345678', 'Distribuciones El Tornillo', 2147483647, 'info@eltornillo.com', 'Avenida 30 #18-50'),
('903456789', 'Materiales y Construcción SA', 2147483647, 'servicio@matconstruccion.com', 'Calle 45 #22-10'),
('904567890', 'Importadora Ferretera Global', 2147483647, 'soporte@ferreglobal.com', 'Carrera 12 #8-35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` int(11) NOT NULL,
  `tipo_reporte` varchar(100) DEFAULT NULL,
  `total_ingresos` float(10,2) DEFAULT NULL,
  `total_egresos` float(10,2) DEFAULT NULL,
  `ganancias` float(10,2) DEFAULT NULL,
  `producto_vendido` varchar(100) DEFAULT NULL,
  `cantidad_vendida` int(11) DEFAULT NULL,
  `factura` int(11) DEFAULT NULL,
  `solicitud_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reporte`
--

INSERT INTO `reporte` (`id_reporte`, `tipo_reporte`, `total_ingresos`, `total_egresos`, `ganancias`, `producto_vendido`, `cantidad_vendida`, `factura`, `solicitud_stock`) VALUES
(1, 'Reporte Diario', 500000.00, 320000.00, 180000.00, 'Productos de ferretería', 45, 4, 4),
(2, 'Reporte Semanal', 3200000.00, 2100000.00, 1100000.00, 'Herramientas manuales', 120, 3, 5),
(3, 'Reporte Mensual', 12500000.00, 8300000.00, 4200000.00, 'Materiales de construcción', 350, 5, 2),
(4, 'Reporte Diario', 450000.00, 280000.00, 170000.00, 'Tornillería y fijaciones', 80, 2, 3),
(5, 'Reporte Semanal', 2800000.00, 1900000.00, 900000.00, 'Pinturas y acabados', 60, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Vendedor'),
(3, 'Cajero'),
(4, 'Bodeguero'),
(5, 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_stock`
--

CREATE TABLE `solicitud_stock` (
  `id_solicitud_reposicion` int(11) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `prioridad` varchar(100) DEFAULT NULL,
  `costo_unitario` float(10,2) DEFAULT NULL,
  `total_compra` float(10,2) DEFAULT NULL,
  `cantidad_comprar` int(11) DEFAULT NULL,
  `nit_proveedor` varchar(12) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_stock`
--

INSERT INTO `solicitud_stock` (`id_solicitud_reposicion`, `fecha_solicitud`, `prioridad`, `costo_unitario`, `total_compra`, `cantidad_comprar`, `nit_proveedor`, `stock`) VALUES
(1, '2026-05-14 14:43:42', 'Alta', 15000.00, 300000.00, 20, '900123456', 2),
(2, '2026-05-14 14:43:42', 'Media', 8000.00, 160000.00, 20, '903456789', 1),
(3, '2026-05-14 14:43:42', 'Baja', 50000.00, 250000.00, 5, '904567890', 4),
(4, '2026-05-14 14:43:42', 'Alta', 12000.00, 360000.00, 30, '902345678', 5),
(5, '2026-05-14 14:43:42', 'Media', 20000.00, 400000.00, 20, '901234567', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id_compra` int(11) NOT NULL,
  `fecha_compra` datetime DEFAULT current_timestamp(),
  `cantidad` int(11) DEFAULT NULL,
  `cantidad_min_stock` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id_compra`, `fecha_compra`, `cantidad`, `cantidad_min_stock`, `estado`, `producto`) VALUES
(1, '2026-01-05 00:00:00', 50, 10, 1, 3),
(2, '2026-01-10 00:00:00', 20, 5, 1, 1),
(3, '2026-02-01 00:00:00', 100, 20, 1, 2),
(4, '2026-02-15 00:00:00', 15, 5, 0, 5),
(5, '2026-03-01 00:00:00', 60, 15, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `cedula_ciudadania` int(11) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `contraseña` varchar(15) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cedula_ciudadania`, `nombre_completo`, `contraseña`, `correo_electronico`, `fecha_registro`, `rol`) VALUES
(1001234567, 'Juan Pérez', 'clave123', 'juan.perez@gmail.com', '2026-05-14 14:43:42', 2),
(1002345678, 'María Gómez', 'clave456', 'maria.gomez@gmail.com', '2026-05-14 14:43:42', 4),
(1003456789, 'Carlos Rodríguez', 'clave789', 'carlos.rodriguez@gmail.com', '2026-05-14 14:43:42', 5),
(1004567890, 'Laura Martínez', 'clave321', 'laura.martinez@gmail.com', '2026-05-14 14:43:42', 3),
(1005678901, 'Andrés López', 'clave654', 'andres.lopez@gmail.com', '2026-05-14 14:43:42', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`numero_documento`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detalle_venta`),
  ADD KEY `fk_detproducto` (`producto`);

--
-- Indices de la tabla `estadisticas`
--
ALTER TABLE `estadisticas`
  ADD PRIMARY KEY (`id_estadisticas`),
  ADD KEY `id_reporte` (`id_reporte`),
  ADD KEY `fk_stock` (`stock`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `detalle_venta` (`detalle_venta`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_categorias` (`id_categoria`),
  ADD KEY `fk_marca` (`marca`),
  ADD KEY `fk_proveedor` (`proveedor`),
  ADD KEY `fk_unidad_medida` (`unidad_medida`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`nit_proveedor`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `factura` (`factura`),
  ADD KEY `solicitud_stock` (`solicitud_stock`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `solicitud_stock`
--
ALTER TABLE `solicitud_stock`
  ADD PRIMARY KEY (`id_solicitud_reposicion`),
  ADD KEY `fk_nit_proveedor` (`nit_proveedor`),
  ADD KEY `stock` (`stock`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_producto` (`producto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cedula_ciudadania`),
  ADD KEY `fk_rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estadisticas`
--
ALTER TABLE `estadisticas`
  MODIFY `id_estadisticas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitud_stock`
--
ALTER TABLE `solicitud_stock`
  MODIFY `id_solicitud_reposicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detproducto` FOREIGN KEY (`producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `estadisticas`
--
ALTER TABLE `estadisticas`
  ADD CONSTRAINT `fk_stock` FOREIGN KEY (`stock`) REFERENCES `stock` (`id_compra`),
  ADD CONSTRAINT `id_reporte` FOREIGN KEY (`id_reporte`) REFERENCES `reporte` (`id_reporte`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `detalle_venta` FOREIGN KEY (`detalle_venta`) REFERENCES `detalle_venta` (`id_detalle_venta`),
  ADD CONSTRAINT `id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`numero_documento`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categorias` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `fk_marca` FOREIGN KEY (`marca`) REFERENCES `marca` (`id_marca`),
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`nit_proveedor`);

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `factura` FOREIGN KEY (`factura`) REFERENCES `factura` (`id_factura`),
  ADD CONSTRAINT `solicitud_stock` FOREIGN KEY (`solicitud_stock`) REFERENCES `solicitud_stock` (`id_solicitud_reposicion`);

--
-- Filtros para la tabla `solicitud_stock`
--
ALTER TABLE `solicitud_stock`
  ADD CONSTRAINT `fk_nit_proveedor` FOREIGN KEY (`nit_proveedor`) REFERENCES `proveedor` (`nit_proveedor`),
  ADD CONSTRAINT `stock` FOREIGN KEY (`stock`) REFERENCES `stock` (`id_compra`);

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
