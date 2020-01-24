-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-01-2020 a las 04:14:42
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `operatorias`
--
CREATE DATABASE IF NOT EXISTS `operatorias` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `operatorias`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `pje_gastos_adm` float UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`pje_gastos_adm`) VALUES
(3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotitulares`
--

CREATE TABLE `cotitulares` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_titular` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cotitulares`
--

INSERT INTO `cotitulares` (`id`, `id_persona`, `id_titular`) VALUES
(6, 42, 13);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `cotitulares_full`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `cotitulares_full` (
`id` int(11)
,`id_persona` int(11)
,`id_titular` int(11)
,`apellido` varchar(100)
,`nombre` varchar(100)
,`nro_docu` varchar(10)
,`domicilio` varchar(250)
,`id_localidad` int(10) unsigned
,`tel_fijo` varchar(20)
,`tel_laboral` varchar(20)
,`tel_celular` varchar(20)
,`observaciones` varchar(100)
,`legajo` varchar(20)
,`ingresos` float
,`localidad` varchar(30)
,`id_dpto` int(11)
,`dpto` varchar(30)
,`titular` varchar(202)
,`id_organismo` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos`
--

CREATE TABLE `creditos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nro_plan` int(10) UNSIGNED DEFAULT NULL COMMENT 'Es el numero del plan de pago (Puede haber mas de uno por movimiento)',
  `monto_total` float NOT NULL,
  `vencimiento1` date DEFAULT NULL COMMENT 'Fecha del primer vencimiento',
  `nro_cuota` tinyint(4) UNSIGNED DEFAULT NULL COMMENT 'Numero de cuota en la que comienza el plan de pago. Para un nuevo plan sera la siguiente a la ultima cuota cancelada del plan anterior',
  `id_titular` int(10) UNSIGNED NOT NULL,
  `id_organismo` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `id_operatoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `creditos`
--

INSERT INTO `creditos` (`id`, `nro_plan`, `monto_total`, `vencimiento1`, `nro_cuota`, `id_titular`, `id_organismo`, `id_operatoria`) VALUES
(20, NULL, 700000, NULL, NULL, 20, 0, 4),
(21, NULL, 350000, NULL, NULL, 21, 0, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `creditos_full`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `creditos_full` (
`id` int(11) unsigned
,`monto_total` float
,`apellido` varchar(100)
,`nombre` varchar(100)
,`fullname` varchar(202)
,`nro_docu` varchar(10)
,`id_titular` int(10) unsigned
,`id_operatoria` int(11)
,`saldo` double
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_plan_de_pago` int(10) UNSIGNED NOT NULL,
  `fecha_venc` date NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto` float UNSIGNED NOT NULL,
  `gastos_adm` float UNSIGNED NOT NULL,
  `seguro` float UNSIGNED NOT NULL DEFAULT 0,
  `interes_punitorio` float UNSIGNED NOT NULL DEFAULT 0,
  `nro_orden` int(11) NOT NULL DEFAULT 0 COMMENT 'Nro de orden de la cuota dentro del plan (consecutivo)',
  `id_forma_de_pago` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`) VALUES
(1, 'Ambato'),
(2, 'Ancasti'),
(3, 'Andalgala'),
(4, 'A. De La Sierra'),
(5, 'Belen'),
(6, 'Capayan'),
(7, 'Capital'),
(8, 'El Alto'),
(9, 'Fray M. Esquiu'),
(10, 'La Paz'),
(11, 'Paclin'),
(12, 'Poman'),
(13, 'Santa Maria'),
(14, 'Santa Rosa'),
(15, 'Tinogasta'),
(16, 'Valle Viejo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formas_de_pago`
--

CREATE TABLE `formas_de_pago` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0;

--
-- Volcado de datos para la tabla `formas_de_pago`
--

INSERT INTO `formas_de_pago` (`id`, `descripcion`) VALUES
(1, 'Debito'),
(2, 'Chequera'),
(3, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `garantes`
--

CREATE TABLE `garantes` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_titular` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `garantes_full`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `garantes_full` (
`id` int(11)
,`id_persona` int(11)
,`id_titular` int(11)
,`apellido` varchar(100)
,`nombre` varchar(100)
,`nro_docu` varchar(10)
,`domicilio` varchar(250)
,`id_localidad` int(10) unsigned
,`tel_fijo` varchar(20)
,`tel_laboral` varchar(20)
,`tel_celular` varchar(20)
,`observaciones` varchar(100)
,`legajo` varchar(20)
,`ingresos` float
,`localidad` varchar(30)
,`id_dpto` int(11)
,`dpto` varchar(30)
,`titular` varchar(202)
,`id_organismo` int(11)
,`nom_organismo` varchar(150)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidades`
--

CREATE TABLE `localidades` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_dpto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `localidades`
--

INSERT INTO `localidades` (`id`, `nombre`, `id_dpto`) VALUES
(1, 'Santa Rosa', 16),
(2, 'Capital', 7),
(3, 'Villa Dolores', 16),
(4, 'Polcos', 16),
(5, 'Puerta de San José', 5),
(6, 'Londres', 5),
(7, 'El Eje', 5),
(8, 'San Fernando', 5),
(9, 'Puerta de Corral Quemado', 5),
(10, 'Hualfin', 5),
(12, 'El Portezuelo', 16),
(13, 'Huaycama', 16),
(14, 'Santa Cruz', 16),
(15, 'Las Tejas', 16),
(16, 'Pozo del Mistol', 16),
(17, 'El Rodeo', 1),
(18, 'Las Juntas', 1),
(19, 'Las Piedras Blancas', 1),
(20, 'Sijan', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operatorias`
--

CREATE TABLE `operatorias` (
  `id` tinyint(4) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pje_interes_punitorio` float UNSIGNED DEFAULT NULL,
  `seguro` float(9,3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0;

--
-- Volcado de datos para la tabla `operatorias`
--

INSERT INTO `operatorias` (`id`, `nombre`, `pje_interes_punitorio`, `seguro`) VALUES
(1, 'Mi Hogar', 1, 0.000),
(2, 'Creditos Individuales', 3, 30.000),
(3, 'Parque America', 1, 0.000),
(4, 'Vivir Mejor', 1, 0.000),
(5, 'Planta Bloquera', 1, 0.000),
(6, 'Municipios', 1, 0.000),
(7, 'Hogar sin Barreras', 1, 0.000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organismos`
--

CREATE TABLE `organismos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0;

--
-- Volcado de datos para la tabla `organismos`
--

INSERT INTO `organismos` (`id`, `nombre`) VALUES
(1, 'U.N.Ca.'),
(2, 'Ministerio de Educación'),
(3, 'Otro'),
(6, 'Municipalidad de la Capital'),
(7, 'I.P.V.'),
(8, 'Ministerios de Educación'),
(9, 'Secretaria de Mineria'),
(10, 'Municipalidad de Fiambala');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_plan` int(10) UNSIGNED NOT NULL,
  `vencimiento` datetime NOT NULL,
  `monto` float UNSIGNED NOT NULL,
  `fecha_pago` date DEFAULT NULL COMMENT 'Fecha en que se realizo el pago'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(10) UNSIGNED NOT NULL,
  `apellido` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nro_docu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `domicilio` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `id_localidad` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `tel_fijo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_laboral` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel_celular` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `legajo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ingresos` float DEFAULT NULL,
  `id_organismo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `apellido`, `nombre`, `nro_docu`, `domicilio`, `id_localidad`, `tel_fijo`, `tel_laboral`, `tel_celular`, `observaciones`, `legajo`, `ingresos`, `id_organismo`) VALUES
(42, 'Saravia', 'Pedro', '24951951', 'BÃ‚Â° Los Ceibos NÃ‚Â° 132', 12, '', '', '', '', '', 26000, 6),
(46, 'Carrizo', 'Hernan', '33194188', 'Av. Juan Pablo Vera 316', 2, '4467710', '', '', '', '5412', 15000, 10),
(47, 'Palomeque', 'Ana Maria', '30612973', 'BÂ° Los Ceibos Casa 91', 2, '', '', '154961123', '', '3012', 10611, 6),
(48, 'Guevara', 'Ernesto', '18111111', 'klsaklaslk', 1, '', '', '', '', '', 16000, 0),
(49, 'Gomez', 'Roberto', '16132111', 'Pje. Rodriguez 36', 1, '', '', '', '', '', 23001, 7),
(51, 'Soto', 'Pablo', '8888', 'B° La antena 146', 16, '', '', '', '', '', 16000, 1),
(53, 'Perez', 'Juan', '5555', 'Avenida', 3, '', '', '', '', '', 30000, 1),
(54, 'Barrionuevo', 'Maria Laura', '4444', 'Cualquiera', 2, '', '', '', '', '', 26000, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_de_pago`
--

CREATE TABLE `planes_de_pago` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_credito` int(10) UNSIGNED NOT NULL,
  `nro_plan` smallint(5) UNSIGNED NOT NULL COMMENT 'Orden del plan con respecto al plan anterior del mismo credito',
  `gastos_adm` float NOT NULL DEFAULT 0 COMMENT 'Interes aplicado al monto de este plan (Lo tomo de la conf. gral.)',
  `pje_interes_punitorio` float DEFAULT NULL COMMENT '% Interes punitorio (lo tomo de la conf gral)',
  `monto` float UNSIGNED NOT NULL COMMENT 'Monto abonado en este plan',
  `cantidad_cuotas` smallint(5) UNSIGNED NOT NULL COMMENT 'Cantidad de cuotas que corresponden a este plan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulares`
--

CREATE TABLE `titulares` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_persona` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `titulares`
--

INSERT INTO `titulares` (`id`, `id_persona`) VALUES
(14, 46),
(15, 47),
(16, 48),
(17, 49),
(19, 51),
(20, 53),
(21, 54);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `titulares_full`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `titulares_full` (
`id` int(10) unsigned
,`id_persona` int(10) unsigned
,`apellido` varchar(100)
,`nro_docu` varchar(10)
,`domicilio` varchar(250)
,`id_localidad` int(10) unsigned
,`tel_fijo` varchar(20)
,`tel_celular` varchar(20)
,`observaciones` varchar(100)
,`id_organismo` int(11)
,`nom_organismo` varchar(150)
,`tel_laboral` varchar(20)
,`legajo` varchar(20)
,`ingresos` float
,`nombre` varchar(100)
,`localidad` varchar(30)
,`id_dpto` int(11)
,`dpto` varchar(30)
,`fullname` varchar(202)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `rol`) VALUES
(1, 'admin', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 0),
(2, 'hernan', 'a7238a421d1c164772f9bea7ba60a5b55b3b29ff', 0);

-- --------------------------------------------------------

--
-- Estructura para la vista `cotitulares_full`
--
DROP TABLE IF EXISTS `cotitulares_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cotitulares_full`  AS  select `cotitulares`.`id` AS `id`,`cotitulares`.`id_persona` AS `id_persona`,`cotitulares`.`id_titular` AS `id_titular`,`personas`.`apellido` AS `apellido`,`personas`.`nombre` AS `nombre`,`personas`.`nro_docu` AS `nro_docu`,`personas`.`domicilio` AS `domicilio`,`personas`.`id_localidad` AS `id_localidad`,`personas`.`tel_fijo` AS `tel_fijo`,`personas`.`tel_laboral` AS `tel_laboral`,`personas`.`tel_celular` AS `tel_celular`,`personas`.`observaciones` AS `observaciones`,`personas`.`legajo` AS `legajo`,`personas`.`ingresos` AS `ingresos`,`localidades`.`nombre` AS `localidad`,`localidades`.`id_dpto` AS `id_dpto`,`departamentos`.`nombre` AS `dpto`,concat(`personas1`.`apellido`,', ',`personas1`.`nombre`) AS `titular`,`personas`.`id_organismo` AS `id_organismo` from (((((`cotitulares` left join `personas` on(`cotitulares`.`id_persona` = `personas`.`id`)) left join `localidades` on(`personas`.`id_localidad` = `localidades`.`id`)) left join `departamentos` on(`localidades`.`id_dpto` = `departamentos`.`id`)) left join `titulares` on(`cotitulares`.`id_titular` = `titulares`.`id`)) left join `personas` `personas1` on(`titulares`.`id_persona` = `personas1`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `creditos_full`
--
DROP TABLE IF EXISTS `creditos_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `creditos_full`  AS  select `creditos`.`id` AS `id`,`creditos`.`monto_total` AS `monto_total`,`personas`.`apellido` AS `apellido`,`personas`.`nombre` AS `nombre`,concat(`personas`.`apellido`,', ',`personas`.`nombre`) AS `fullname`,`personas`.`nro_docu` AS `nro_docu`,`creditos`.`id_titular` AS `id_titular`,`creditos`.`id_operatoria` AS `id_operatoria`,`creditos`.`monto_total` - (select sum(`cuotas`.`monto`) from (`cuotas` join `planes_de_pago` on(`cuotas`.`id_plan_de_pago` = `planes_de_pago`.`id`)) where `planes_de_pago`.`id_credito` = `creditos`.`id` and `cuotas`.`fecha_pago` <> '') AS `saldo` from ((`creditos` join `titulares` on(`creditos`.`id_titular` = `titulares`.`id`)) join `personas` on(`titulares`.`id_persona` = `personas`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `garantes_full`
--
DROP TABLE IF EXISTS `garantes_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `garantes_full`  AS  select `garantes`.`id` AS `id`,`garantes`.`id_persona` AS `id_persona`,`garantes`.`id_titular` AS `id_titular`,`personas`.`apellido` AS `apellido`,`personas`.`nombre` AS `nombre`,`personas`.`nro_docu` AS `nro_docu`,`personas`.`domicilio` AS `domicilio`,`personas`.`id_localidad` AS `id_localidad`,`personas`.`tel_fijo` AS `tel_fijo`,`personas`.`tel_laboral` AS `tel_laboral`,`personas`.`tel_celular` AS `tel_celular`,`personas`.`observaciones` AS `observaciones`,`personas`.`legajo` AS `legajo`,`personas`.`ingresos` AS `ingresos`,`localidades`.`nombre` AS `localidad`,`localidades`.`id_dpto` AS `id_dpto`,`departamentos`.`nombre` AS `dpto`,concat(`personas1`.`apellido`,', ',`personas1`.`nombre`) AS `titular`,`personas`.`id_organismo` AS `id_organismo`,`organismos`.`nombre` AS `nom_organismo` from ((((((`garantes` join `personas` on(`garantes`.`id_persona` = `personas`.`id`)) join `localidades` on(`personas`.`id_localidad` = `localidades`.`id`)) join `departamentos` on(`localidades`.`id_dpto` = `departamentos`.`id`)) join `titulares` on(`garantes`.`id_titular` = `titulares`.`id`)) join `personas` `personas1` on(`titulares`.`id_persona` = `personas1`.`id`)) left join `organismos` on(`organismos`.`id` = `personas`.`id_organismo`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `titulares_full`
--
DROP TABLE IF EXISTS `titulares_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `titulares_full`  AS  select `titulares`.`id` AS `id`,`titulares`.`id_persona` AS `id_persona`,`personas`.`apellido` AS `apellido`,`personas`.`nro_docu` AS `nro_docu`,`personas`.`domicilio` AS `domicilio`,`personas`.`id_localidad` AS `id_localidad`,`personas`.`tel_fijo` AS `tel_fijo`,`personas`.`tel_celular` AS `tel_celular`,`personas`.`observaciones` AS `observaciones`,`personas`.`id_organismo` AS `id_organismo`,`organismos`.`nombre` AS `nom_organismo`,`personas`.`tel_laboral` AS `tel_laboral`,`personas`.`legajo` AS `legajo`,`personas`.`ingresos` AS `ingresos`,`personas`.`nombre` AS `nombre`,`localidades`.`nombre` AS `localidad`,`localidades`.`id_dpto` AS `id_dpto`,`departamentos`.`nombre` AS `dpto`,concat(`personas`.`apellido`,', ',`personas`.`nombre`) AS `fullname` from ((((`titulares` left join `personas` on(`titulares`.`id_persona` = `personas`.`id`)) left join `localidades` on(`personas`.`id_localidad` = `localidades`.`id`)) left join `departamentos` on(`localidades`.`id_dpto` = `departamentos`.`id`)) left join `organismos` on(`organismos`.`id` = `personas`.`id_organismo`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cotitulares`
--
ALTER TABLE `cotitulares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indice01` (`id_plan_de_pago`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `formas_de_pago`
--
ALTER TABLE `formas_de_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `garantes`
--
ALTER TABLE `garantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operatorias`
--
ALTER TABLE `operatorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `organismos`
--
ALTER TABLE `organismos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nro_docu` (`nro_docu`);

--
-- Indices de la tabla `planes_de_pago`
--
ALTER TABLE `planes_de_pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restriccion_creditos` (`id_credito`);

--
-- Indices de la tabla `titulares`
--
ALTER TABLE `titulares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cotitulares`
--
ALTER TABLE `cotitulares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=714;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `garantes`
--
ALTER TABLE `garantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `operatorias`
--
ALTER TABLE `operatorias`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `organismos`
--
ALTER TABLE `organismos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `planes_de_pago`
--
ALTER TABLE `planes_de_pago`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `titulares`
--
ALTER TABLE `titulares`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD CONSTRAINT `indice01` FOREIGN KEY (`id_plan_de_pago`) REFERENCES `planes_de_pago` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `planes_de_pago`
--
ALTER TABLE `planes_de_pago`
  ADD CONSTRAINT `restriccion_creditos` FOREIGN KEY (`id_credito`) REFERENCES `creditos` (`id`);

--
-- Filtros para la tabla `titulares`
--
ALTER TABLE `titulares`
  ADD CONSTRAINT `pipi` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
