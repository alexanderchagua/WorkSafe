-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-08-2025 a las 18:25:04
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
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `clientId` int(11) NOT NULL,
  `clientFirstname` varchar(15) NOT NULL,
  `clientLastname` varchar(25) NOT NULL,
  `clientEmail` varchar(40) NOT NULL,
  `clientPassword` varchar(255) NOT NULL,
  `clientLevel` enum('1','2','3','4') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_ssoma`
--

CREATE TABLE `datos_ssoma` (
  `id` int(11) NOT NULL,
  `mes` varchar(20) NOT NULL,
  `anio` int(11) NOT NULL DEFAULT 2024,
  `trabajadores_total` int(11) NOT NULL DEFAULT 89,
  `trabajadores_admin` int(11) NOT NULL DEFAULT 0,
  `trabajadores_oper` int(11) NOT NULL DEFAULT 0,
  `dias_sin_accidentes` int(11) NOT NULL DEFAULT 0,
  `porcentaje_accidentes` decimal(5,2) NOT NULL DEFAULT 0.00,
  `incidentes` int(11) NOT NULL DEFAULT 0,
  `indice_gravedad` decimal(5,2) NOT NULL DEFAULT 0.00,
  `indice_frecuencia` decimal(5,2) NOT NULL DEFAULT 0.00,
  `capacitados` int(11) NOT NULL DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `datos_ssoma`
--

INSERT INTO `datos_ssoma` (`id`, `mes`, `anio`, `trabajadores_total`, `trabajadores_admin`, `trabajadores_oper`, `dias_sin_accidentes`, `porcentaje_accidentes`, `incidentes`, `indice_gravedad`, `indice_frecuencia`, `capacitados`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Enero', 2024, 500, 50, 450, 150, 5.00, 12, 5.00, 0.99, 450, '2025-07-27 00:46:11', '2025-07-27 02:05:30'),
(2, 'Febrero', 2024, 89, 52, 37, 150, 5.00, 5, 6.00, 4.00, 54, '2025-07-27 00:46:11', '2025-07-27 02:25:34'),
(3, 'Marzo', 2024, 89, 20, 69, 65, 5.00, 4, 5.00, 5.00, 22, '2025-07-27 00:46:11', '2025-07-27 02:37:30'),
(4, 'Abril', 2024, 89, 27, 62, 95, 15.20, 5, 1.50, 2.30, 65, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(5, 'Mayo', 2024, 89, 27, 62, 150, 5.30, 0, 0.00, 1.90, 68, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(6, 'Junio', 2024, 89, 27, 62, 180, 3.20, 0, 0.00, 2.50, 72, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(7, 'Julio', 2024, 89, 27, 62, 200, 2.10, 0, 0.50, 2.00, 75, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(8, 'Agosto', 2024, 89, 27, 62, 220, 1.80, 0, 0.00, 1.70, 78, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(9, 'Septiembre', 2024, 89, 27, 62, 240, 1.50, 0, 0.30, 1.60, 81, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(10, 'Octubre', 2024, 89, 27, 62, 260, 1.20, 0, 0.60, 2.40, 84, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(11, 'Noviembre', 2024, 89, 27, 62, 280, 1.00, 0, 0.00, 2.20, 87, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(12, 'Diciembre', 2024, 89, 27, 62, 300, 0.80, 3, 1.00, 2.30, 89, '2025-07-27 00:46:11', '2025-07-27 00:46:11'),
(27, 'enero', 2023, 100, 20, 80, 35, 3.00, 3, 1.45, 2.25, 70, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(28, 'febrero', 2023, 105, 22, 83, 28, 1.90, 2, 0.95, 1.65, 75, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(29, 'marzo', 2023, 108, 23, 85, 55, 0.93, 1, 0.48, 0.82, 80, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(30, 'abril', 2023, 110, 24, 86, 60, 0.00, 0, 0.00, 0.00, 85, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(31, 'mayo', 2023, 112, 25, 87, 25, 2.68, 3, 1.65, 2.45, 82, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(32, 'junio', 2023, 115, 26, 89, 75, 0.87, 1, 0.38, 0.72, 90, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(33, 'julio', 2023, 118, 27, 91, 82, 0.00, 0, 0.00, 0.00, 95, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(34, 'agosto', 2023, 120, 28, 92, 45, 1.67, 2, 0.85, 1.42, 88, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(35, 'septiembre', 2023, 122, 29, 93, 38, 2.46, 3, 1.32, 2.18, 85, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(36, 'octubre', 2023, 125, 30, 95, 52, 0.80, 1, 0.41, 0.78, 98, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(37, 'noviembre', 2023, 127, 31, 96, 63, 0.00, 0, 0.00, 0.00, 102, '2025-07-28 22:33:50', '2025-07-28 22:33:50'),
(38, 'diciembre', 2023, 130, 32, 98, 71, 0.77, 1, 0.36, 0.68, 105, '2025-07-28 22:33:50', '2025-07-28 22:33:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invetory`
--

CREATE TABLE `invetory` (
  `id` int(11) NOT NULL,
  `Codigo` varchar(255) NOT NULL,
  `Descripcion` varchar(255) CHARACTER SET utf32 COLLATE utf32_swedish_ci NOT NULL,
  `Stock` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(5, 'Login'),
(6, 'Inventory');

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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datos_ssoma`
--
ALTER TABLE `datos_ssoma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_mes_anio` (`mes`,`anio`);

--
-- Indices de la tabla `nav`
--
ALTER TABLE `nav`
  ADD PRIMARY KEY (`navId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datos_ssoma`
--
ALTER TABLE `datos_ssoma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `nav`
--
ALTER TABLE `nav`
  MODIFY `navId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
