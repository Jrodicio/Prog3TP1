CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaBaja` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;