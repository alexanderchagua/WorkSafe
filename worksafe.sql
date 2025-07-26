-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-07-2025 a las 06:03:23
-- Versión del servidor: 10.6.17-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `worksafe`
--

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `datos_año_actual`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `datos_año_actual` (
`id` int(11)
,`mes` varchar(10)
,`año` int(11)
,`total_trabajadores` int(11)
,`trabajadores_admin` int(11)
,`trabajadores_oper` int(11)
,`dias_sin_accidentes` int(11)
,`porcentaje_accidentes` decimal(5,2)
,`incidentes` int(11)
,`indice_gravedad` decimal(5,2)
,`indice_frecuencia` decimal(5,2)
,`capacitados` int(11)
,`fecha_registro` timestamp
,`fecha_actualizacion` timestamp
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_mensuales`
--

CREATE TABLE `datos_mensuales` (
  `id` int(11) NOT NULL,
  `mes` varchar(10) NOT NULL,
  `año` int(11) NOT NULL,
  `total_trabajadores` int(11) DEFAULT 0,
  `trabajadores_admin` int(11) DEFAULT 0,
  `trabajadores_oper` int(11) DEFAULT 0,
  `dias_sin_accidentes` int(11) DEFAULT 0,
  `porcentaje_accidentes` decimal(5,2) DEFAULT 0.00,
  `incidentes` int(11) DEFAULT 0,
  `indice_gravedad` decimal(5,2) DEFAULT 0.00,
  `indice_frecuencia` decimal(5,2) DEFAULT 0.00,
  `capacitados` int(11) DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `datos_mensuales`
--

INSERT INTO `datos_mensuales` (`id`, `mes`, `año`, `total_trabajadores`, `trabajadores_admin`, `trabajadores_oper`, `dias_sin_accidentes`, `porcentaje_accidentes`, `incidentes`, `indice_gravedad`, `indice_frecuencia`, `capacitados`, `fecha_registro`, `fecha_actualizacion`) VALUES
(1, 'Ene', 2024, 89, 27, 62, 45, 12.50, 3, 1.20, 1.50, 45, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(2, 'Feb', 2024, 89, 27, 62, 120, 10.00, 0, 0.80, 2.10, 54, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(3, 'Mar', 2024, 92, 28, 64, 85, 15.20, 4, 1.00, 1.80, 58, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(4, 'Abr', 2024, 95, 30, 65, 90, 18.75, 5, 1.50, 2.30, 62, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(5, 'May', 2024, 98, 32, 66, 150, 8.50, 0, 0.00, 1.90, 68, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(6, 'Jun', 2024, 100, 33, 67, 180, 5.00, 0, 0.00, 2.50, 75, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(7, 'Jul', 2024, 102, 35, 67, 200, 3.50, 0, 0.50, 2.00, 82, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(8, 'Ago', 2024, 105, 36, 69, 220, 2.80, 0, 0.00, 1.70, 88, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(9, 'Set', 2024, 108, 38, 70, 240, 2.20, 0, 0.30, 1.60, 95, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(10, 'Oct', 2024, 110, 40, 70, 160, 8.90, 0, 0.60, 2.40, 98, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(11, 'Nov', 2024, 112, 42, 70, 140, 12.30, 0, 0.00, 2.20, 105, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(12, 'Dic', 2024, 115, 45, 70, 125, 14.50, 3, 1.00, 2.30, 110, '2025-07-26 03:25:26', '2025-07-26 03:25:26'),
(25, 'Enero', 2023, 150, 30, 120, 45, 2.50, 3, 1.20, 2.00, 140, '2025-07-26 03:38:37', '2025-07-26 03:38:37'),
(26, 'Febrero', 2023, 155, 32, 123, 75, 1.80, 2, 0.80, 1.50, 148, '2025-07-26 03:38:37', '2025-07-26 03:38:37'),
(27, 'Marzo', 2023, 160, 35, 125, 105, 1.20, 1, 0.50, 0.80, 155, '2025-07-26 03:38:37', '2025-07-26 03:38:37'),
(28, 'Abril', 2023, 158, 34, 124, 135, 0.90, 1, 0.30, 0.60, 152, '2025-07-26 03:38:37', '2025-07-26 03:38:37'),
(29, 'Mayo', 2023, 162, 36, 126, 165, 0.60, 1, 0.20, 0.50, 160, '2025-07-26 03:38:37', '2025-07-26 03:38:37'),
(30, 'Junio', 2023, 165, 38, 127, 195, 0.40, 0, 0.00, 0.00, 163, '2025-07-26 03:38:37', '2025-07-26 03:38:37'),
(31, 'Enero', 2024, 120, 25, 95, 30, 1.25, 2, 0.75, 1.67, 110, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(32, 'Febrero', 2024, 125, 28, 97, 60, 0.80, 1, 0.40, 0.80, 120, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(33, 'Marzo', 2024, 130, 30, 100, 90, 0.50, 1, 0.25, 0.50, 125, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(34, 'Abril', 2024, 132, 32, 100, 120, 0.30, 0, 0.00, 0.00, 130, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(35, 'Mayo', 2024, 135, 35, 100, 150, 0.20, 0, 0.00, 0.00, 132, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(36, 'Junio', 2024, 140, 38, 102, 180, 0.10, 0, 0.00, 0.00, 138, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(37, 'Julio', 2024, 145, 40, 105, 210, 0.00, 0, 0.00, 0.00, 142, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(38, 'Agosto', 2024, 150, 42, 108, 240, 0.00, 0, 0.00, 0.00, 148, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(39, 'Septiembre', 2024, 155, 45, 110, 270, 0.00, 0, 0.00, 0.00, 152, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(40, 'Octubre', 2024, 160, 48, 112, 300, 0.00, 0, 0.00, 0.00, 158, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(41, 'Noviembre', 2024, 165, 50, 115, 330, 0.00, 0, 0.00, 0.00, 162, '2025-07-26 03:42:55', '2025-07-26 03:42:55'),
(42, 'Diciembre', 2024, 170, 52, 118, 365, 0.00, 0, 0.00, 0.00, 168, '2025-07-26 03:42:55', '2025-07-26 03:42:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_cambios`
--

CREATE TABLE `historial_cambios` (
  `id` int(11) NOT NULL,
  `mes` varchar(10) NOT NULL,
  `año` int(11) NOT NULL,
  `campo_modificado` varchar(50) DEFAULT NULL,
  `valor_anterior` text DEFAULT NULL,
  `valor_nuevo` text DEFAULT NULL,
  `usuario` varchar(50) DEFAULT 'admin',
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nav`
--

CREATE TABLE `nav` (
  `navId` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nav`
--

INSERT INTO `nav` (`navId`, `name`) VALUES
(1, 'Home'),
(2, 'Add Personal'),
(3, 'Search'),
(4, 'Statistics'),
(5, 'Login');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_epp`
--

CREATE TABLE `personal_epp` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `edad` int(11) NOT NULL,
  `ocupacion` varchar(255) NOT NULL,
  `area_trabajo` varchar(255) NOT NULL,
  `fecha_cumple` date NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `estado` enum('activo','retirado') NOT NULL,
  `sede` enum('LIMA','CHICLAYO','AREQUIPA','TARAPOTO','PUCALLPA','MOYOBAMBA','IQUITOS') NOT NULL,
  `foto` varchar(255) NOT NULL,
  `estado_epp` enum('Activo','Devuelto') DEFAULT NULL,
  `observaciones` varchar(255) NOT NULL,
  `casco_seguridad` tinyint(1) NOT NULL,
  `fecha_entrega_cs` date DEFAULT NULL,
  `cambio_cs` date DEFAULT NULL,
  `orejeras_casco` tinyint(1) NOT NULL,
  `fecha_entrega_oc` date DEFAULT NULL,
  `cambio_oc` date DEFAULT NULL,
  `firmar` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto_captura` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `datos_año_actual`
--
DROP TABLE IF EXISTS `datos_año_actual`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datos_año_actual`  AS SELECT `datos_mensuales`.`id` AS `id`, `datos_mensuales`.`mes` AS `mes`, `datos_mensuales`.`año` AS `año`, `datos_mensuales`.`total_trabajadores` AS `total_trabajadores`, `datos_mensuales`.`trabajadores_admin` AS `trabajadores_admin`, `datos_mensuales`.`trabajadores_oper` AS `trabajadores_oper`, `datos_mensuales`.`dias_sin_accidentes` AS `dias_sin_accidentes`, `datos_mensuales`.`porcentaje_accidentes` AS `porcentaje_accidentes`, `datos_mensuales`.`incidentes` AS `incidentes`, `datos_mensuales`.`indice_gravedad` AS `indice_gravedad`, `datos_mensuales`.`indice_frecuencia` AS `indice_frecuencia`, `datos_mensuales`.`capacitados` AS `capacitados`, `datos_mensuales`.`fecha_registro` AS `fecha_registro`, `datos_mensuales`.`fecha_actualizacion` AS `fecha_actualizacion` FROM `datos_mensuales` WHERE `datos_mensuales`.`año` = year(curdate()) ORDER BY field(`datos_mensuales`.`mes`,'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Set','Oct','Nov','Dic') ASC ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datos_mensuales`
--
ALTER TABLE `datos_mensuales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_mes_año` (`mes`,`año`);

--
-- Indices de la tabla `historial_cambios`
--
ALTER TABLE `historial_cambios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nav`
--
ALTER TABLE `nav`
  ADD PRIMARY KEY (`navId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datos_mensuales`
--
ALTER TABLE `datos_mensuales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `historial_cambios`
--
ALTER TABLE `historial_cambios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nav`
--
ALTER TABLE `nav`
  MODIFY `navId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
