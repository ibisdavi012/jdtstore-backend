-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2021 a las 19:51:32
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jdtstore`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eav_attributes`
--

CREATE TABLE `eav_attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `unit` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eav_products`
--

CREATE TABLE `eav_products` (
  `id` int(11) NOT NULL,
  `sku` varchar(15) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` double NOT NULL,
  `type` varchar(15) NOT NULL,
  `custom_attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `eav_products`
--

INSERT INTO `eav_products` (`id`, `sku`, `name`, `price`, `type`, `custom_attributes`) VALUES
(235, 'Hhjjkkllklkb', 'Gb ivjkb', 34, 'dvd', '{\"size\":55}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eav_products_attributes_values`
--

CREATE TABLE `eav_products_attributes_values` (
  `id` int(11) NOT NULL,
  `protuct_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eav_attributes`
--
ALTER TABLE `eav_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eav_products`
--
ALTER TABLE `eav_products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eav_products_attributes_values`
--
ALTER TABLE `eav_products_attributes_values`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eav_attributes`
--
ALTER TABLE `eav_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eav_products`
--
ALTER TABLE `eav_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT de la tabla `eav_products_attributes_values`
--
ALTER TABLE `eav_products_attributes_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
