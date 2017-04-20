-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-11-2013 a las 05:22:22
-- Versión del servidor: 5.5.34
-- Versión de PHP: 5.4.6-1ubuntu1.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `huellacarbono`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ayudas`
--

CREATE TABLE IF NOT EXISTS `ayudas` (
  `codayu_ayu` smallint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código de ayuda',
  `titulo_ayu` varchar(80) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Título de la ayuda',
  `codcri_ayu` smallint(3) unsigned NOT NULL COMMENT 'Código de criterio',
  `conayu_ayu` longtext COLLATE utf8_spanish_ci NOT NULL COMMENT 'Contenido de la ayuda',
  PRIMARY KEY (`codayu_ayu`),
  KEY `codcri_ayu` (`codcri_ayu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ayudas`
--

INSERT INTO `ayudas` (`codayu_ayu`, `titulo_ayu`, `codcri_ayu`, `conayu_ayu`) VALUES
(2, 'Donde obtener los datos', 6, '<p>El consumo de gas natural viene dado por el número de aparatos que lo consumen, y su respectivo consumo.</p>\r\n<p>La recomendación es utilizar una fuente de datos lo más exacta posible.</p>\r\n<ol>\r\n<li>La primera opción debe ser un recibo de consumo. (Recibo de gas).</li>\r\n<li>La segunda opción será calcularlo con base a nuestros aparatos (que sin embargo será más inexacta).</li>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `codcon_con` varchar(16) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código de parámetro de configuración',
  `concon_con` varchar(120) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Contenido del parámetro de configuración',
  PRIMARY KEY (`codcon_con`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`codcon_con`, `concon_con`) VALUES
('etiqueta_title', 'Calculadora de la Huella de Carbono - Universidad de Cundinamarca'),
('tema', 'naturaleza'),
('titulo_principal', 'Calculadora de la Huella de Carbono');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterios`
--

CREATE TABLE IF NOT EXISTS `criterios` (
  `codcri_cri` smallint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código de criterio',
  `nombre_cri` varchar(40) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de criterio',
  `imagen_cri` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Imagen de criterio',
  PRIMARY KEY (`codcri_cri`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `criterios`
--

INSERT INTO `criterios` (`codcri_cri`, `nombre_cri`, `imagen_cri`) VALUES
(1, 'Electricidad', 'imagenes/criterios/2013-10-29_12-37-39_4296_energia.svg'),
(2, 'Automovil', ''),
(3, 'Bus', ''),
(4, 'Agua', ''),
(5, 'Vuelo', ''),
(6, 'Gas natural', ''),
(7, 'Gasoleo', ''),
(8, 'Diesel', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factores`
--

CREATE TABLE IF NOT EXISTS `factores` (
  `codfac_fac` smallint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código de factor',
  `codcri_fac` smallint(3) unsigned NOT NULL COMMENT 'Código de criterio',
  `abrmed_fac` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Abreviatura de unidad de medida',
  `idefue_fac` smallint(3) unsigned NOT NULL COMMENT 'Identificador de fuente',
  `tonco2_fac` double NOT NULL COMMENT 'Toneladas de CO2',
  PRIMARY KEY (`codfac_fac`),
  KEY `codcri_fac` (`codcri_fac`),
  KEY `abrmed_fac` (`abrmed_fac`),
  KEY `idefue_fac` (`idefue_fac`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fuentes`
--

CREATE TABLE IF NOT EXISTS `fuentes` (
  `idefue_fue` smallint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de fuente',
  `titulo_fue` varchar(100) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Título de fuente',
  `ubicac_fue` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ubicación de donde se extrajeron los datos',
  `idpais_fue` smallint(3) unsigned zerofill NOT NULL COMMENT 'Identificador de país al que corresponden los datos',
  PRIMARY KEY (`idefue_fue`),
  KEY `idpais_fue` (`idpais_fue`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `huella_individual`
--

CREATE TABLE IF NOT EXISTS `huella_individual` (
  `codcri_hui` smallint(3) unsigned NOT NULL COMMENT 'Código de criterio',
  `codind_hui` int(10) unsigned NOT NULL COMMENT 'Código identificador de la persona',
  `consum_hui` double DEFAULT NULL COMMENT 'Consumo',
  `person_hui` int(10) unsigned DEFAULT NULL COMMENT 'Número de personas que comparten el consumo',
  `codfac_hui` smallint(3) unsigned DEFAULT NULL COMMENT 'Código de factor',
  PRIMARY KEY (`codcri_hui`,`codind_hui`),
  KEY `codfac_hui` (`codfac_hui`),
  KEY `codind_hui` (`codind_hui`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `huella_organizacion`
--

CREATE TABLE IF NOT EXISTS `huella_organizacion` (
  `codcri_huo` smallint(3) unsigned NOT NULL COMMENT 'Código de criterio',
  `ideorg_huo` smallint(4) unsigned NOT NULL COMMENT 'Identificador de organización',
  `consum_huo` double DEFAULT NULL COMMENT 'Consumo',
  `codfac_huo` smallint(3) unsigned DEFAULT NULL COMMENT 'Código de factor',
  PRIMARY KEY (`codcri_huo`,`ideorg_huo`),
  KEY `ideorg_huo` (`ideorg_huo`),
  KEY `codfac_huo` (`codfac_huo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `individuos`
--

CREATE TABLE IF NOT EXISTS `individuos` (
  `codind_ind` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código identificador de la persona',
  `nomusu_ind` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de usuario (nickname)',
  `contra_ind` varchar(64) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Contraseña de acceso',
  `nombre_ind` varchar(40) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de la persona',
  `apell1_ind` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer apellido',
  `apell2_ind` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Segundo apellido',
  `ideind_ind` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de indentificación de la persona',
  `correo_ind` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Correo electrónico',
  `fecnac_ind` date NOT NULL COMMENT 'Fecha de nacimiento',
  `idioma_ind` varchar(5) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Idioma',
  `fecreg_ind` date NOT NULL COMMENT 'Fecha de registro',
  `codrol_ind` smallint(3) unsigned DEFAULT NULL COMMENT 'Código de rol',
  PRIMARY KEY (`codind_ind`),
  UNIQUE KEY `nomusu_ind` (`nomusu_ind`),
  KEY `codrol_ind` (`codrol_ind`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas`
--

CREATE TABLE IF NOT EXISTS `medidas` (
  `abrmed_med` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Abreviatura de unidad de medida, sin espacio',
  `nombre_med` varchar(40) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de unidad de medida',
  PRIMARY KEY (`abrmed_med`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `medidas`
--

INSERT INTO `medidas` (`abrmed_med`, `nombre_med`) VALUES
('KwH', 'Kilovatios'),
('lt', 'Litros'),
('m3', 'Metros cúbicos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizaciones`
--

CREATE TABLE IF NOT EXISTS `organizaciones` (
  `ideorg_org` smallint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de organización',
  `nombre_org` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de la organización',
  PRIMARY KEY (`ideorg_org`),
  UNIQUE KEY `nombre_org` (`nombre_org`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizaciones_fuente`
--

CREATE TABLE IF NOT EXISTS `organizaciones_fuente` (
  `ideorf_orf` smallint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identificador de organización fuente',
  `organi_orf` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Organización que facilita datos',
  `ubicac_orf` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ubicación de la organización',
  `idpais_orf` smallint(3) unsigned zerofill NOT NULL COMMENT 'Identificador de país de origen',
  PRIMARY KEY (`ideorf_orf`),
  KEY `idpais_orf` (`idpais_orf`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
  `codpag_pag` smallint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código de página',
  `titulo_pag` varchar(64) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Título de la página',
  `conpag_pag` longtext COLLATE utf8_spanish_ci NOT NULL COMMENT 'Contenido de la página',
  `piepag_pag` tinyint(1) NOT NULL COMMENT 'Opcion de Incluir en pie de página',
  PRIMARY KEY (`codpag_pag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `paginas`
--

INSERT INTO `paginas` (`codpag_pag`, `titulo_pag`, `conpag_pag`, `piepag_pag`) VALUES
(0, 'Inicio', 'Redacción para el inicio...', 0),
(1, 'Términos y Condiciones', 'Redacción de términos y condiciones...', 1),
(2, 'Privacidad', 'Redacción de privacidad de los datos recolectados...', 1),
(3, 'Créditos', 'Redacción de los créditos respectivos... <br><br>\r\n<p><b>Autor:</b> Deiby Fabián Ordoñez Díaz</p>\r\n<p>Universidad de Cundinamarca</p>\r\n<p>2013</p>', 1),
(4, 'Licencia', 'Redacción de la licencia... <br><br>\r\n<p>GPL versión 3 o superior.</p>\r\n<p>Creative Commons: Reconocimiento 2.5.</p>', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
  `id` smallint(3) unsigned zerofill NOT NULL COMMENT 'Código ISO 1',
  `iso2` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código ISO 2',
  `iso3` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código ISO 3',
  `prefijo` smallint(5) unsigned NOT NULL COMMENT 'Prefijo de país',
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del país',
  `continente` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Contienente al que pertenece',
  `subcontinente` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Subcontienente al que pertenece',
  `iso_moneda` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Código ISO de la Moneda',
  `nombre_moneda` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nombre de la moneda',
  PRIMARY KEY (`id`),
  UNIQUE KEY `iso2` (`iso2`),
  UNIQUE KEY `iso3` (`iso3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `iso2`, `iso3`, `prefijo`, `nombre`, `continente`, `subcontinente`, `iso_moneda`, `nombre_moneda`) VALUES
(000, '00', '000', 0, 'Internacional', NULL, NULL, NULL, NULL),
(004, 'AF', 'AFG', 93, 'Afganistán', 'Asia', NULL, 'AFN', 'Afgani afgano'),
(008, 'AL', 'ALB', 355, 'Albania', 'Europa', NULL, 'ALL', 'Lek albanés'),
(010, 'AQ', 'ATA', 672, 'Antártida', 'Antártida', NULL, NULL, NULL),
(012, 'DZ', 'DZA', 213, 'Argelia', 'África', NULL, 'DZD', 'Dinar algerino'),
(016, 'AS', 'ASM', 1684, 'Samoa Americana', 'Oceanía', NULL, NULL, NULL),
(020, 'AD', 'AND', 376, 'Andorra', 'Europa', NULL, 'EUR', 'Euro'),
(024, 'AO', 'AGO', 244, 'Angola', 'África', NULL, 'AOA', 'Kwanza angoleño'),
(028, 'AG', 'ATG', 1268, 'Antigua y Barbuda', 'América', 'El Caribe', NULL, NULL),
(031, 'AZ', 'AZE', 994, 'Azerbaiyán', 'Asia', NULL, 'AZM', 'Manat azerbaiyano'),
(032, 'AR', 'ARG', 54, 'Argentina', 'América', 'América del Sur', 'ARS', 'Peso argentino'),
(036, 'AU', 'AUS', 61, 'Australia', 'Oceanía', NULL, 'AUD', 'Dólar australiano'),
(040, 'AT', 'AUT', 43, 'Austria', 'Europa', NULL, 'EUR', 'Euro'),
(044, 'BS', 'BHS', 1242, 'Bahamas', 'América', 'El Caribe', 'BSD', 'Dólar bahameño'),
(048, 'BH', 'BHR', 973, 'Bahréin', 'Asia', NULL, 'BHD', 'Dinar bahreiní'),
(050, 'BD', 'BGD', 880, 'Bangladesh', 'Asia', NULL, 'BDT', 'Taka de Bangladesh'),
(051, 'AM', 'ARM', 374, 'Armenia', 'Asia', NULL, 'AMD', 'Dram armenio'),
(052, 'BB', 'BRB', 1246, 'Barbados', 'América', 'El Caribe', 'BBD', 'Dólar de Barbados'),
(056, 'BE', 'BEL', 32, 'Bélgica', 'Europa', NULL, 'EUR', 'Euro'),
(060, 'BM', 'BMU', 1441, 'Bermudas', 'América', 'El Caribe', 'BMD', 'Dólar de Bermuda'),
(064, 'BT', 'BTN', 975, 'Bhután', 'Asia', NULL, 'BTN', 'Ngultrum de Bután'),
(068, 'BO', 'BOL', 591, 'Bolivia', 'América', 'América del Sur', 'BOB', 'Boliviano'),
(070, 'BA', 'BIH', 387, 'Bosnia y Herzegovina', 'Europa', NULL, 'BAM', 'Marco convertible de Bosnia-Herzegovina'),
(072, 'BW', 'BWA', 267, 'Botsuana', 'África', NULL, 'BWP', 'Pula de Botsuana'),
(074, 'BV', 'BVT', 0, 'Isla Bouvet', NULL, NULL, NULL, NULL),
(076, 'BR', 'BRA', 55, 'Brasil', 'América', 'América del Sur', 'BRL', 'Real brasileño'),
(084, 'BZ', 'BLZ', 501, 'Belice', 'América', 'América Central', 'BZD', 'Dólar de Belice'),
(086, 'IO', 'IOT', 0, 'Territorio Británico del Océano Índico', NULL, NULL, NULL, NULL),
(090, 'SB', 'SLB', 677, 'Islas Salomón', 'Oceanía', NULL, 'SBD', 'Dólar de las Islas Salomón'),
(092, 'VG', 'VGB', 1284, 'Islas Vírgenes Británicas', 'América', 'El Caribe', NULL, NULL),
(096, 'BN', 'BRN', 673, 'Brunéi', 'Asia', NULL, 'BND', 'Dólar de Brunéi'),
(100, 'BG', 'BGR', 359, 'Bulgaria', 'Europa', NULL, 'BGN', 'Lev búlgaro'),
(104, 'MM', 'MMR', 95, 'Myanmar', 'Asia', NULL, 'MMK', 'Kyat birmano'),
(108, 'BI', 'BDI', 257, 'Burundi', 'África', NULL, 'BIF', 'Franco burundés'),
(112, 'BY', 'BLR', 375, 'Bielorrusia', 'Europa', NULL, 'BYR', 'Rublo bielorruso'),
(116, 'KH', 'KHM', 855, 'Camboya', 'Asia', NULL, 'KHR', 'Riel camboyano'),
(120, 'CM', 'CMR', 237, 'Camerún', 'África', NULL, NULL, NULL),
(124, 'CA', 'CAN', 1, 'Canadá', 'América', 'América del Norte', 'CAD', 'Dólar canadiense'),
(132, 'CV', 'CPV', 238, 'Cabo Verde', 'África', NULL, 'CVE', 'Escudo caboverdiano'),
(136, 'KY', 'CYM', 1345, 'Islas Caimán', 'América', 'El Caribe', 'KYD', 'Dólar caimano (de Islas Caimán)'),
(140, 'CF', 'CAF', 236, 'República Centroafricana', 'África', NULL, NULL, NULL),
(144, 'LK', 'LKA', 94, 'Sri Lanka', 'Asia', NULL, 'LKR', 'Rupia de Sri Lanka'),
(148, 'TD', 'TCD', 235, 'Chad', 'África', NULL, NULL, NULL),
(152, 'CL', 'CHL', 56, 'Chile', 'América', 'América del Sur', 'CLP', 'Peso chileno'),
(156, 'CN', 'CHN', 86, 'China', 'Asia', NULL, 'CNY', 'Yuan Renminbi de China'),
(158, 'TW', 'TWN', 886, 'Taiwán', 'Asia', NULL, 'TWD', 'Dólar taiwanés'),
(162, 'CX', 'CXR', 61, 'Isla de Navidad', 'Oceanía', NULL, NULL, NULL),
(166, 'CC', 'CCK', 61, 'Islas Cocos', 'Óceanía', NULL, NULL, NULL),
(170, 'CO', 'COL', 57, 'Colombia', 'América', 'América del Sur', 'COP', 'Peso colombiano'),
(174, 'KM', 'COM', 269, 'Comoras', 'África', NULL, 'KMF', 'Franco comoriano (de Comoras)'),
(175, 'YT', 'MYT', 262, 'Mayotte', 'África', NULL, NULL, NULL),
(178, 'CG', 'COG', 242, 'Congo', 'África', NULL, NULL, NULL),
(180, 'CD', 'COD', 243, 'República Democrática del Congo', 'África', NULL, 'CDF', 'Franco congoleño'),
(184, 'CK', 'COK', 682, 'Islas Cook', 'Oceanía', NULL, NULL, NULL),
(188, 'CR', 'CRI', 506, 'Costa Rica', 'América', 'América Central', 'CRC', 'Colón costarricense'),
(191, 'HR', 'HRV', 385, 'Croacia', 'Europa', NULL, 'HRK', 'Kuna croata'),
(192, 'CU', 'CUB', 53, 'Cuba', 'América', 'El Caribe', 'CUP', 'Peso cubano'),
(196, 'CY', 'CYP', 357, 'Chipre', 'Europa', NULL, 'CYP', 'Libra chipriota'),
(203, 'CZ', 'CZE', 420, 'República Checa', 'Europa', NULL, 'CZK', 'Koruna checa'),
(204, 'BJ', 'BEN', 229, 'Benín', 'África', NULL, NULL, NULL),
(208, 'DK', 'DNK', 45, 'Dinamarca', 'Europa', NULL, 'DKK', 'Corona danesa'),
(212, 'DM', 'DMA', 1767, 'Dominica', 'América', 'El Caribe', NULL, NULL),
(214, 'DO', 'DOM', 1809, 'República Dominicana', 'América', 'El Caribe', 'DOP', 'Peso dominicano'),
(218, 'EC', 'ECU', 593, 'Ecuador', 'América', 'América del Sur', NULL, NULL),
(222, 'SV', 'SLV', 503, 'El Salvador', 'América', 'América Central', 'SVC', 'Colón salvadoreño'),
(226, 'GQ', 'GNQ', 240, 'Guinea Ecuatorial', 'África', NULL, NULL, NULL),
(231, 'ET', 'ETH', 251, 'Etiopía', 'África', NULL, 'ETB', 'Birr etíope'),
(232, 'ER', 'ERI', 291, 'Eritrea', 'África', NULL, 'ERN', 'Nakfa eritreo'),
(233, 'EE', 'EST', 372, 'Estonia', 'Europa', NULL, 'EEK', 'Corona estonia'),
(234, 'FO', 'FRO', 298, 'Islas Feroe', 'Europa', NULL, NULL, NULL),
(238, 'FK', 'FLK', 500, 'Islas Malvinas', 'América', 'América del Sur', 'FKP', 'Libra malvinense'),
(239, 'GS', 'SGS', 0, 'Islas Georgias del Sur y Sandwich del Sur', 'América', 'América del Sur', NULL, NULL),
(242, 'FJ', 'FJI', 679, 'Fiyi', 'Oceanía', NULL, 'FJD', 'Dólar fijiano'),
(246, 'FI', 'FIN', 358, 'Finlandia', 'Europa', NULL, 'EUR', 'Euro'),
(248, 'AX', 'ALA', 0, 'Islas Gland', 'Europa', NULL, NULL, NULL),
(250, 'FR', 'FRA', 33, 'Francia', 'Europa', NULL, 'EUR', 'Euro'),
(254, 'GF', 'GUF', 0, 'Guayana Francesa', 'América', 'América del Sur', NULL, NULL),
(258, 'PF', 'PYF', 689, 'Polinesia Francesa', 'Oceanía', NULL, NULL, NULL),
(260, 'TF', 'ATF', 0, 'Territorios Australes Franceses', NULL, NULL, NULL, NULL),
(262, 'DJ', 'DJI', 253, 'Yibuti', 'África', NULL, 'DJF', 'Franco yibutiano'),
(266, 'GA', 'GAB', 241, 'Gabón', 'África', NULL, NULL, NULL),
(268, 'GE', 'GEO', 995, 'Georgia', 'Europa', NULL, 'GEL', 'Lari georgiano'),
(270, 'GM', 'GMB', 220, 'Gambia', 'África', NULL, 'GMD', 'Dalasi gambiano'),
(275, 'PS', 'PSE', 0, 'Palestina', 'Asia', NULL, NULL, NULL),
(276, 'DE', 'DEU', 49, 'Alemania', 'Europa', NULL, 'EUR', 'Euro'),
(288, 'GH', 'GHA', 233, 'Ghana', 'África', NULL, 'GHC', 'Cedi ghanés'),
(292, 'GI', 'GIB', 350, 'Gibraltar', 'Europa', NULL, 'GIP', 'Libra de Gibraltar'),
(296, 'KI', 'KIR', 686, 'Kiribati', 'Oceanía', NULL, NULL, NULL),
(300, 'GR', 'GRC', 30, 'Grecia', 'Europa', NULL, 'EUR', 'Euro'),
(304, 'GL', 'GRL', 299, 'Groenlandia', 'América', 'América del Norte', NULL, NULL),
(308, 'GD', 'GRD', 1473, 'Granada', 'América', 'El Caribe', NULL, NULL),
(312, 'GP', 'GLP', 0, 'Guadalupe', 'América', 'El Caribe', NULL, NULL),
(316, 'GU', 'GUM', 1671, 'Guam', 'Oceanía', NULL, NULL, NULL),
(320, 'GT', 'GTM', 502, 'Guatemala', 'América', 'América Central', 'GTQ', 'Quetzal guatemalteco'),
(324, 'GN', 'GIN', 224, 'Guinea', 'África', NULL, 'GNF', 'Franco guineano'),
(328, 'GY', 'GUY', 592, 'Guyana', 'América', 'América del Sur', 'GYD', 'Dólar guyanés'),
(332, 'HT', 'HTI', 509, 'Haití', 'América', 'El Caribe', 'HTG', 'Gourde haitiano'),
(334, 'HM', 'HMD', 0, 'Islas Heard y McDonald', 'Oceanía', NULL, NULL, NULL),
(336, 'VA', 'VAT', 39, 'Ciudad del Vaticano', 'Europa', NULL, NULL, NULL),
(340, 'HN', 'HND', 504, 'Honduras', 'América', 'América Central', 'HNL', 'Lempira hondureño'),
(344, 'HK', 'HKG', 852, 'Hong Kong', 'Asia', NULL, 'HKD', 'Dólar de Hong Kong'),
(348, 'HU', 'HUN', 36, 'Hungría', 'Europa', NULL, 'HUF', 'Forint húngaro'),
(352, 'IS', 'ISL', 354, 'Islandia', 'Europa', NULL, 'ISK', 'Króna islandesa'),
(356, 'IN', 'IND', 91, 'India', 'Asia', NULL, 'INR', 'Rupia india'),
(360, 'ID', 'IDN', 62, 'Indonesia', 'Asia', NULL, 'IDR', 'Rupiah indonesia'),
(364, 'IR', 'IRN', 98, 'Irán', 'Asia', NULL, 'IRR', 'Rial iraní'),
(368, 'IQ', 'IRQ', 964, 'Iraq', 'Asia', NULL, 'IQD', 'Dinar iraquí'),
(372, 'IE', 'IRL', 353, 'Irlanda', 'Europa', NULL, 'EUR', 'Euro'),
(376, 'IL', 'ISR', 972, 'Israel', 'Asia', NULL, 'ILS', 'Nuevo shéquel israelí'),
(380, 'IT', 'ITA', 39, 'Italia', 'Europa', NULL, 'EUR', 'Euro'),
(384, 'CI', 'CIV', 225, 'Costa de Marfil', 'África', NULL, NULL, NULL),
(388, 'JM', 'JAM', 1876, 'Jamaica', 'América', 'El Caribe', 'JMD', 'Dólar jamaicano'),
(392, 'JP', 'JPN', 81, 'Japón', 'Asia', NULL, 'JPY', 'Yen japonés'),
(398, 'KZ', 'KAZ', 7, 'Kazajstán', 'Asia', NULL, 'KZT', 'Tenge kazajo'),
(400, 'JO', 'JOR', 962, 'Jordania', 'Asia', NULL, 'JOD', 'Dinar jordano'),
(404, 'KE', 'KEN', 254, 'Kenia', 'África', NULL, 'KES', 'Chelín keniata'),
(408, 'KP', 'PRK', 850, 'Corea del Norte', 'Asia', NULL, 'KPW', 'Won norcoreano'),
(410, 'KR', 'KOR', 82, 'Corea del Sur', 'Asia', NULL, 'KRW', 'Won surcoreano'),
(414, 'KW', 'KWT', 965, 'Kuwait', 'Asia', NULL, 'KWD', 'Dinar kuwaití'),
(417, 'KG', 'KGZ', 996, 'Kirguistán', 'Asia', NULL, 'KGS', 'Som kirguís (de Kirguistán)'),
(418, 'LA', 'LAO', 856, 'Laos', 'Asia', NULL, 'LAK', 'Kip lao'),
(422, 'LB', 'LBN', 961, 'Líbano', 'Asia', NULL, 'LBP', 'Libra libanesa'),
(426, 'LS', 'LSO', 266, 'Lesotho', 'África', NULL, 'LSL', 'Loti lesotense'),
(428, 'LV', 'LVA', 371, 'Letonia', 'Europa', NULL, 'LVL', 'Lat letón'),
(430, 'LR', 'LBR', 231, 'Liberia', 'África', NULL, 'LRD', 'Dólar liberiano'),
(434, 'LY', 'LBY', 218, 'Libia', 'África', NULL, 'LYD', 'Dinar libio'),
(438, 'LI', 'LIE', 423, 'Liechtenstein', 'Europa', NULL, NULL, NULL),
(440, 'LT', 'LTU', 370, 'Lituania', 'Europa', NULL, 'LTL', 'Litas lituano'),
(442, 'LU', 'LUX', 352, 'Luxemburgo', 'Europa', NULL, 'EUR', 'Euro'),
(446, 'MO', 'MAC', 853, 'Macao', 'Asia', NULL, 'MOP', 'Pataca de Macao'),
(450, 'MG', 'MDG', 261, 'Madagascar', 'África', NULL, 'MGA', 'Ariary malgache'),
(454, 'MW', 'MWI', 265, 'Malaui', 'África', NULL, 'MWK', 'Kwacha malauiano'),
(458, 'MY', 'MYS', 60, 'Malasia', 'Asia', NULL, 'MYR', 'Ringgit malayo'),
(462, 'MV', 'MDV', 960, 'Maldivas', 'Asia', NULL, 'MVR', 'Rufiyaa maldiva'),
(466, 'ML', 'MLI', 223, 'Malí', 'África', NULL, NULL, NULL),
(470, 'MT', 'MLT', 356, 'Malta', 'Europa', NULL, 'MTL', 'Lira maltesa'),
(474, 'MQ', 'MTQ', 0, 'Martinica', 'América', 'El Caribe', NULL, NULL),
(478, 'MR', 'MRT', 222, 'Mauritania', 'África', NULL, 'MRO', 'Ouguiya mauritana'),
(480, 'MU', 'MUS', 230, 'Mauricio', 'África', NULL, 'MUR', 'Rupia mauricia'),
(484, 'MX', 'MEX', 52, 'México', 'América', 'América del Norte', 'MXN', 'Peso mexicano'),
(492, 'MC', 'MCO', 377, 'Mónaco', 'Europa', NULL, NULL, NULL),
(496, 'MN', 'MNG', 976, 'Mongolia', 'Asia', NULL, 'MNT', 'Tughrik mongol'),
(498, 'MD', 'MDA', 373, 'Moldavia', 'Europa', NULL, 'MDL', 'Leu moldavo'),
(499, 'ME', 'MNE', 382, 'Montenegro', 'Europa', NULL, NULL, NULL),
(500, 'MS', 'MSR', 1664, 'Montserrat', 'América', 'El Caribe', NULL, NULL),
(504, 'MA', 'MAR', 212, 'Marruecos', 'África', NULL, 'MAD', 'Dirham marroquí'),
(508, 'MZ', 'MOZ', 258, 'Mozambique', 'África', NULL, 'MZM', 'Metical mozambiqueño'),
(512, 'OM', 'OMN', 968, 'Omán', 'Asia', NULL, 'OMR', 'Rial omaní'),
(516, 'NA', 'NAM', 264, 'Namibia', 'África', NULL, 'NAD', 'Dólar namibio'),
(520, 'NR', 'NRU', 674, 'Nauru', 'Oceanía', NULL, NULL, NULL),
(524, 'NP', 'NPL', 977, 'Nepal', 'Asia', NULL, 'NPR', 'Rupia nepalesa'),
(528, 'NL', 'NLD', 31, 'Países Bajos', 'Europa', NULL, 'EUR', 'Euro'),
(530, 'AN', 'ANT', 599, 'Antillas Holandesas', 'América', 'El Caribe', 'ANG', 'Florín antillano neerlandés'),
(533, 'AW', 'ABW', 297, 'Aruba', 'América', 'El Caribe', 'AWG', 'Florín arubeño'),
(540, 'NC', 'NCL', 687, 'Nueva Caledonia', 'Oceanía', NULL, NULL, NULL),
(548, 'VU', 'VUT', 678, 'Vanuatu', 'Oceanía', NULL, 'VUV', 'Vatu vanuatense'),
(554, 'NZ', 'NZL', 64, 'Nueva Zelanda', 'Oceanía', NULL, 'NZD', 'Dólar neozelandés'),
(558, 'NI', 'NIC', 505, 'Nicaragua', 'América', 'América Central', 'NIO', 'Córdoba nicaragüense'),
(562, 'NE', 'NER', 227, 'Níger', 'África', NULL, NULL, NULL),
(566, 'NG', 'NGA', 234, 'Nigeria', 'África', NULL, 'NGN', 'Naira nigeriana'),
(570, 'NU', 'NIU', 683, 'Niue', 'Oceanía', NULL, NULL, NULL),
(574, 'NF', 'NFK', 0, 'Isla Norfolk', 'Oceanía', NULL, NULL, NULL),
(578, 'NO', 'NOR', 47, 'Noruega', 'Europa', NULL, 'NOK', 'Corona noruega'),
(580, 'MP', 'MNP', 1670, 'Islas Marianas del Norte', 'Oceanía', NULL, NULL, NULL),
(581, 'UM', 'UMI', 0, 'Islas Ultramarinas de Estados Unidos', NULL, NULL, NULL, NULL),
(583, 'FM', 'FSM', 691, 'Micronesia', 'Oceanía', NULL, NULL, NULL),
(584, 'MH', 'MHL', 692, 'Islas Marshall', 'Oceanía', NULL, NULL, NULL),
(585, 'PW', 'PLW', 680, 'Palaos', 'Oceanía', NULL, NULL, NULL),
(586, 'PK', 'PAK', 92, 'Pakistán', 'Asia', NULL, 'PKR', 'Rupia pakistaní'),
(591, 'PA', 'PAN', 507, 'Panamá', 'América', 'América Central', 'PAB', 'Balboa panameña'),
(598, 'PG', 'PNG', 675, 'Papúa Nueva Guinea', 'Oceanía', NULL, 'PGK', 'Kina de Papúa Nueva Guinea'),
(600, 'PY', 'PRY', 595, 'Paraguay', 'América', 'América del Sur', 'PYG', 'Guaraní paraguayo'),
(604, 'PE', 'PER', 51, 'Perú', 'América', 'América del Sur', 'PEN', 'Nuevo sol peruano'),
(608, 'PH', 'PHL', 63, 'Filipinas', 'Asia', NULL, 'PHP', 'Peso filipino'),
(612, 'PN', 'PCN', 870, 'Islas Pitcairn', 'Oceanía', NULL, NULL, NULL),
(616, 'PL', 'POL', 48, 'Polonia', 'Europa', NULL, 'PLN', 'zloty polaco'),
(620, 'PT', 'PRT', 351, 'Portugal', 'Europa', NULL, 'EUR', 'Euro'),
(624, 'GW', 'GNB', 245, 'Guinea-Bissau', 'África', NULL, NULL, NULL),
(626, 'TL', 'TLS', 670, 'Timor Oriental', 'Asia', NULL, NULL, NULL),
(630, 'PR', 'PRI', 1, 'Puerto Rico', 'América', 'El Caribe', NULL, NULL),
(634, 'QA', 'QAT', 974, 'Qatar', 'Asia', NULL, 'QAR', 'Rial qatarí'),
(638, 'RE', 'REU', 262, 'Reunión', 'África', NULL, NULL, NULL),
(642, 'RO', 'ROU', 40, 'Rumania', 'Europa', NULL, 'RON', 'Leu rumano'),
(643, 'RU', 'RUS', 7, 'Rusia', 'Asia', NULL, 'RUB', 'Rublo ruso'),
(646, 'RW', 'RWA', 250, 'Ruanda', 'África', NULL, 'RWF', 'Franco ruandés'),
(654, 'SH', 'SHN', 290, 'Santa Helena', 'África', NULL, 'SHP', 'Libra de Santa Helena'),
(659, 'KN', 'KNA', 1869, 'San Cristóbal y Nieves', 'América', 'El Caribe', NULL, NULL),
(660, 'AI', 'AIA', 1264, 'Anguila', 'América', 'El Caribe', NULL, NULL),
(662, 'LC', 'LCA', 1758, 'Santa Lucía', 'América', 'El Caribe', NULL, NULL),
(666, 'PM', 'SPM', 508, 'San Pedro y Miquelón', 'América', 'América del Norte', NULL, NULL),
(670, 'VC', 'VCT', 1784, 'San Vicente y las Granadinas', 'América', 'El Caribe', NULL, NULL),
(674, 'SM', 'SMR', 378, 'San Marino', 'Europa', NULL, NULL, NULL),
(678, 'ST', 'STP', 239, 'Santo Tomé y Príncipe', 'África', NULL, 'STD', 'Dobra de Santo Tomé y Príncipe'),
(682, 'SA', 'SAU', 966, 'Arabia Saudí', 'Asia', NULL, 'SAR', 'Riyal saudí'),
(686, 'SN', 'SEN', 221, 'Senegal', 'África', NULL, NULL, NULL),
(688, 'RS', 'SRB', 381, 'Serbia', 'Europa', NULL, NULL, NULL),
(690, 'SC', 'SYC', 248, 'Seychelles', 'África', NULL, 'SCR', 'Rupia de Seychelles'),
(694, 'SL', 'SLE', 232, 'Sierra Leona', 'África', NULL, 'SLL', 'Leone de Sierra Leona'),
(702, 'SG', 'SGP', 65, 'Singapur', 'Asia', NULL, 'SGD', 'Dólar de Singapur'),
(703, 'SK', 'SVK', 421, 'Eslovaquia', 'Europa', NULL, 'SKK', 'Corona eslovaca'),
(704, 'VN', 'VNM', 84, 'Vietnam', 'Asia', NULL, 'VND', 'Dong vietnamita'),
(705, 'SI', 'SVN', 386, 'Eslovenia', 'Europa', NULL, NULL, NULL),
(706, 'SO', 'SOM', 252, 'Somalia', 'África', NULL, 'SOS', 'Chelín somalí'),
(710, 'ZA', 'ZAF', 27, 'Sudáfrica', 'África', NULL, 'ZAR', 'Rand sudafricano'),
(716, 'ZW', 'ZWE', 263, 'Zimbabue', 'África', NULL, 'ZWL', 'Dólar zimbabuense'),
(724, 'ES', 'ESP', 34, 'España', 'Europa', NULL, 'EUR', 'Euro'),
(732, 'EH', 'ESH', 0, 'Sahara Occidental', 'África', NULL, NULL, NULL),
(736, 'SD', 'SDN', 249, 'Sudán', 'África', NULL, 'SDD', 'Dinar sudanés'),
(740, 'SR', 'SUR', 597, 'Surinam', 'América', 'América del Sur', 'SRD', 'Dólar surinamés'),
(744, 'SJ', 'SJM', 0, 'Svalbard y Jan Mayen', 'Europa', NULL, NULL, NULL),
(748, 'SZ', 'SWZ', 268, 'Suazilandia', 'África', NULL, 'SZL', 'Lilangeni suazi'),
(752, 'SE', 'SWE', 46, 'Suecia', 'Europa', NULL, 'SEK', 'Corona sueca'),
(756, 'CH', 'CHE', 41, 'Suiza', 'Europa', NULL, 'CHF', 'Franco suizo'),
(760, 'SY', 'SYR', 963, 'Siria', 'Asia', NULL, 'SYP', 'Libra siria'),
(762, 'TJ', 'TJK', 992, 'Tayikistán', 'Asia', NULL, 'TJS', 'Somoni tayik (de Tayikistán)'),
(764, 'TH', 'THA', 66, 'Tailandia', 'Asia', NULL, 'THB', 'Baht tailandés'),
(768, 'TG', 'TGO', 228, 'Togo', 'África', NULL, NULL, NULL),
(772, 'TK', 'TKL', 690, 'Tokelau', 'Oceanía', NULL, NULL, NULL),
(776, 'TO', 'TON', 676, 'Tonga', 'Oceanía', NULL, 'TOP', 'Pa''anga tongano'),
(780, 'TT', 'TTO', 1868, 'Trinidad y Tobago', 'América', 'El Caribe', 'TTD', 'Dólar de Trinidad y Tobago'),
(784, 'AE', 'ARE', 971, 'Emiratos Árabes Unidos', 'Asia', NULL, 'AED', 'Dirham de los Emiratos Árabes Unidos'),
(788, 'TN', 'TUN', 216, 'Túnez', 'África', NULL, 'TND', 'Dinar tunecino'),
(792, 'TR', 'TUR', 90, 'Turquía', 'Asia', NULL, 'TRY', 'Lira turca'),
(795, 'TM', 'TKM', 993, 'Turkmenistán', 'Asia', NULL, 'TMM', 'Manat turcomano'),
(796, 'TC', 'TCA', 1649, 'Islas Turcas y Caicos', 'América', 'El Caribe', NULL, NULL),
(798, 'TV', 'TUV', 688, 'Tuvalu', 'Oceanía', NULL, NULL, NULL),
(800, 'UG', 'UGA', 256, 'Uganda', 'África', NULL, 'UGX', 'Chelín ugandés'),
(804, 'UA', 'UKR', 380, 'Ucrania', 'Europa', NULL, 'UAH', 'Grivna ucraniana'),
(807, 'MK', 'MKD', 389, 'Macedonia', 'Europa', NULL, 'MKD', 'Denar macedonio'),
(818, 'EG', 'EGY', 20, 'Egipto', 'África', NULL, 'EGP', 'Libra egipcia'),
(826, 'GB', 'GBR', 44, 'Reino Unido', 'Europa', NULL, 'GBP', 'Libra esterlina (libra de Gran Bretaña)'),
(834, 'TZ', 'TZA', 255, 'Tanzania', 'África', NULL, 'TZS', 'Chelín tanzano'),
(840, 'US', 'USA', 1, 'Estados Unidos', 'América', 'América del Norte', 'USD', 'Dólar estadounidense'),
(850, 'VI', 'VIR', 1340, 'Islas Vírgenes de los Estados Unidos', 'América', 'El Caribe', NULL, NULL),
(854, 'BF', 'BFA', 226, 'Burkina Faso', 'África', NULL, NULL, NULL),
(858, 'UY', 'URY', 598, 'Uruguay', 'América', 'América del Sur', 'UYU', 'Peso uruguayo'),
(860, 'UZ', 'UZB', 998, 'Uzbekistán', 'Asia', NULL, 'UZS', 'Som uzbeko'),
(862, 'VE', 'VEN', 58, 'Venezuela', 'América', 'América del Sur', 'VEB', 'Bolívar venezolano'),
(876, 'WF', 'WLF', 681, 'Wallis y Futuna', 'Oceanía', NULL, NULL, NULL),
(882, 'WS', 'WSM', 685, 'Samoa', 'Oceanía', NULL, 'WST', 'Tala samoana'),
(887, 'YE', 'YEM', 967, 'Yemen', 'Asia', NULL, 'YER', 'Rial yemení (de Yemen)'),
(894, 'ZM', 'ZMB', 260, 'Zambia', 'África', NULL, 'ZMK', 'Kwacha zambiano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `codrol_per` smallint(3) unsigned NOT NULL COMMENT 'Código de rol',
  `codprc_per` smallint(2) unsigned NOT NULL COMMENT 'Código de proceso',
  PRIMARY KEY (`codrol_per`,`codprc_per`),
  KEY `codprc_per` (`codprc_per`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`codrol_per`, `codprc_per`) VALUES
(0, 1),
(0, 2),
(0, 3),
(9, 3),
(0, 4),
(9, 4),
(0, 5),
(9, 5),
(0, 6),
(9, 6),
(0, 7),
(9, 7),
(0, 8),
(9, 8),
(0, 9),
(9, 9),
(0, 10),
(9, 10),
(0, 11),
(9, 11),
(0, 12),
(9, 12),
(0, 13),
(9, 13),
(0, 14),
(9, 14),
(0, 15),
(9, 15),
(0, 16),
(9, 16),
(0, 17),
(9, 17),
(0, 18),
(9, 18),
(0, 19),
(9, 19),
(0, 20),
(9, 20),
(0, 21),
(9, 21),
(0, 22),
(9, 22),
(0, 24),
(9, 24),
(0, 25),
(9, 25),
(0, 26),
(9, 26),
(0, 27),
(9, 27),
(0, 28),
(0, 29),
(0, 30),
(0, 31),
(0, 32),
(0, 33),
(0, 35),
(0, 36),
(0, 37),
(0, 38),
(0, 39),
(0, 40),
(0, 41),
(0, 42),
(0, 43),
(0, 45),
(0, 46),
(0, 47),
(0, 48),
(0, 49);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos`
--

CREATE TABLE IF NOT EXISTS `procesos` (
  `codprc_prc` smallint(2) unsigned NOT NULL COMMENT 'Código de proceso',
  `nombre_prc` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código de rol',
  PRIMARY KEY (`codprc_prc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `procesos`
--

INSERT INTO `procesos` (`codprc_prc`, `nombre_prc`) VALUES
(1, 'Ver organizaciones'),
(2, 'Eliminar organizaciones'),
(3, 'Ver criterios'),
(4, 'Registrar criterios'),
(5, 'Modificar criterios'),
(6, 'Eliminar criterios'),
(7, 'Ver ayudas a criterios'),
(8, 'Registrar ayudas a criterios'),
(9, 'Modificar ayudas a criterios'),
(10, 'Eliminar ayudas a criterios'),
(11, 'Ver factores de emisi&oacute;n'),
(12, 'Registrar factores de emisi&oacute;n'),
(13, 'Modificar factores de emisi&oacute;n'),
(14, 'Eliminar factores de emisi&oacute;n'),
(15, 'Ver medidas de consumo'),
(16, 'Registrar medidas de consumo'),
(17, 'Modificar medidas de consumo'),
(18, 'Eliminar medidas de consumo'),
(19, 'Ver fuentes de datos'),
(20, 'Registrar fuentes de datos'),
(21, 'Modificar fuentes de datos'),
(22, 'Eliminar fuentes de datos'),
(24, 'Ver organizaciones fuente'),
(25, 'Registrar organizaciones fuente'),
(26, 'Modificar organizaciones fuente'),
(27, 'Eliminar organizaciones fuente'),
(28, 'Ver tiempos'),
(29, 'Registrar tiempos'),
(30, 'Modificar tiempos'),
(31, 'Eliminar tiempos'),
(32, 'Ver paises'),
(33, 'Ver individuos'),
(35, 'Eliminar individuos'),
(36, 'Asignar rol a individuo'),
(37, 'Ver roles'),
(38, 'Registrar roles'),
(39, 'Modificar roles'),
(40, 'Eliminar roles'),
(41, 'Ver permisos de roles'),
(42, 'Agregar permisos a roles'),
(43, 'Eliminar permisos a roles'),
(44, 'Ver procesos'),
(45, 'Modificar configuración'),
(46, 'Ver pagina'),
(47, 'Registrar pagina'),
(48, 'Modificar pagina'),
(49, 'Eliminar pagina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_individuo_organizacion`
--

CREATE TABLE IF NOT EXISTS `rel_individuo_organizacion` (
  `codind_rio` int(10) unsigned NOT NULL COMMENT 'Código Identificador de la persona',
  `ideorg_rio` smallint(4) unsigned NOT NULL COMMENT 'Identificador de organización',
  `estado_rio` varchar(9) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Estado de vinculación, aprobado o pendiente',
  `admini_rio` tinyint(1) DEFAULT NULL COMMENT 'Aministrador de organización',
  PRIMARY KEY (`codind_rio`,`ideorg_rio`),
  KEY `ideorg_rio` (`ideorg_rio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_orgfuente_fuente`
--

CREATE TABLE IF NOT EXISTS `rel_orgfuente_fuente` (
  `ideorf_rof` smallint(3) unsigned NOT NULL COMMENT 'Identificador de fuente',
  `idefue_rof` smallint(3) unsigned NOT NULL COMMENT 'Identificador de organización fuente',
  PRIMARY KEY (`ideorf_rof`,`idefue_rof`),
  KEY `idefue_rof` (`idefue_rof`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `codrol_rol` smallint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código de rol',
  `descri_rol` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Descripción de rol',
  PRIMARY KEY (`codrol_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`codrol_rol`, `descri_rol`) VALUES
(0, 'Super administrador'),
(9, 'Gestor de criterios y factores de emisión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempos`
--

CREATE TABLE IF NOT EXISTS `tiempos` (
  `valort_tie` double unsigned NOT NULL COMMENT 'Valor basado en 1 hora',
  `nombre_tie` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de medida de tiempo',
  PRIMARY KEY (`valort_tie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tiempos`
--

INSERT INTO `tiempos` (`valort_tie`, `nombre_tie`) VALUES
(1, 'Hora'),
(24, 'Día'),
(720, 'Mes');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ayudas`
--
ALTER TABLE `ayudas`
  ADD CONSTRAINT `ayudas_ibfk_1` FOREIGN KEY (`codcri_ayu`) REFERENCES `criterios` (`codcri_cri`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `factores`
--
ALTER TABLE `factores`
  ADD CONSTRAINT `factores_ibfk_1` FOREIGN KEY (`codcri_fac`) REFERENCES `criterios` (`codcri_cri`) ON UPDATE CASCADE,
  ADD CONSTRAINT `factores_ibfk_2` FOREIGN KEY (`abrmed_fac`) REFERENCES `medidas` (`abrmed_med`) ON UPDATE CASCADE,
  ADD CONSTRAINT `factores_ibfk_3` FOREIGN KEY (`idefue_fac`) REFERENCES `fuentes` (`idefue_fue`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `fuentes`
--
ALTER TABLE `fuentes`
  ADD CONSTRAINT `fuentes_ibfk_1` FOREIGN KEY (`idpais_fue`) REFERENCES `paises` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `huella_individual`
--
ALTER TABLE `huella_individual`
  ADD CONSTRAINT `huella_individual_ibfk_3` FOREIGN KEY (`codfac_hui`) REFERENCES `factores` (`codfac_fac`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `huella_individual_ibfk_4` FOREIGN KEY (`codcri_hui`) REFERENCES `criterios` (`codcri_cri`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `huella_individual_ibfk_5` FOREIGN KEY (`codind_hui`) REFERENCES `individuos` (`codind_ind`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `huella_organizacion`
--
ALTER TABLE `huella_organizacion`
  ADD CONSTRAINT `huella_organizacion_ibfk_1` FOREIGN KEY (`codcri_huo`) REFERENCES `criterios` (`codcri_cri`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `huella_organizacion_ibfk_2` FOREIGN KEY (`ideorg_huo`) REFERENCES `organizaciones` (`ideorg_org`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `huella_organizacion_ibfk_3` FOREIGN KEY (`codfac_huo`) REFERENCES `factores` (`codfac_fac`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `individuos`
--
ALTER TABLE `individuos`
  ADD CONSTRAINT `individuos_ibfk_1` FOREIGN KEY (`codrol_ind`) REFERENCES `roles` (`codrol_rol`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `organizaciones_fuente`
--
ALTER TABLE `organizaciones_fuente`
  ADD CONSTRAINT `organizaciones_fuente_ibfk_1` FOREIGN KEY (`idpais_orf`) REFERENCES `paises` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`codprc_per`) REFERENCES `procesos` (`codprc_prc`) ON UPDATE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_3` FOREIGN KEY (`codrol_per`) REFERENCES `roles` (`codrol_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rel_individuo_organizacion`
--
ALTER TABLE `rel_individuo_organizacion`
  ADD CONSTRAINT `rel_individuo_organizacion_ibfk_1` FOREIGN KEY (`codind_rio`) REFERENCES `individuos` (`codind_ind`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_individuo_organizacion_ibfk_2` FOREIGN KEY (`ideorg_rio`) REFERENCES `organizaciones` (`ideorg_org`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rel_orgfuente_fuente`
--
ALTER TABLE `rel_orgfuente_fuente`
  ADD CONSTRAINT `rel_orgfuente_fuente_ibfk_1` FOREIGN KEY (`ideorf_rof`) REFERENCES `organizaciones_fuente` (`ideorf_orf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_orgfuente_fuente_ibfk_2` FOREIGN KEY (`idefue_rof`) REFERENCES `fuentes` (`idefue_fue`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
