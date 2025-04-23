-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2025 a las 00:14:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bolsa_empleo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aplicaciones`
--

CREATE TABLE `aplicaciones` (
  `id` int(11) NOT NULL,
  `id_candidato` int(11) DEFAULT NULL,
  `id_oferta` int(11) DEFAULT NULL,
  `fecha_aplicacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aplicaciones`
--

INSERT INTO `aplicaciones` (`id`, `id_candidato`, `id_oferta`, `fecha_aplicacion`) VALUES
(19, 2, 4, '2025-04-23 16:21:18'),
(21, 3, 5, '2025-04-23 17:56:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

CREATE TABLE `candidatos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `ciudad_provincia` varchar(100) DEFAULT NULL,
  `formacion_academica` text DEFAULT NULL,
  `experiencia_laboral` text DEFAULT NULL,
  `habilidades_clave` text DEFAULT NULL,
  `idiomas` text DEFAULT NULL,
  `objetivo_profesional` text DEFAULT NULL,
  `logros_proyectos` text DEFAULT NULL,
  `disponibilidad` varchar(50) DEFAULT NULL,
  `redes_profesionales` text DEFAULT NULL,
  `referencias` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cv_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `candidatos`
--

INSERT INTO `candidatos` (`id`, `usuario_id`, `nombre`, `apellido`, `telefono`, `direccion`, `ciudad_provincia`, `formacion_academica`, `experiencia_laboral`, `habilidades_clave`, `idiomas`, `objetivo_profesional`, `logros_proyectos`, `disponibilidad`, `redes_profesionales`, `referencias`, `foto`, `cv_pdf`) VALUES
(1, 2, 'Bruno', 'Diaz', '849 111 0247', 'NI idea', 'Santiago', 'Instituto ITLA.', 'Ninguna', 'Trabajo en Equipo.', 'Español e Ingles intermedio', 'Aportar valor', 'Proyectos Personales en java y python.', 'Medio Tiempo', 'Instagram.', 'El chamaco del San.', '68066d415029d_images.jpg', '680914e95c0fe_Tarea-9.pdf'),
(2, 3, 'Maria', 'Cortez', '809-342-3424', '', 'La Romana', 'Universidad Autonoma de Santo Domingo (UASD)', 'Ninguna', 'Compresion Eficiente.\r\nTrabajo en equipo', 'Español', 'Ser buen profesional en mi Area.', 'Proyectos complejos con arquitecturas abstractas.', 'Tiempo Completo', 'Linkedin, instagram', '', '680912c50aa4a_Maria.jpg', '680915b1385b0_Tarea 1.pdf'),
(3, 6, 'Lucas', 'Montero', '809-234-0912', 'Ensanche la Fe', 'Santo Domingo/ Distrito Nacional', 'Instituto Tecnologico de las Americas (ITLA-SDN)', 'Ningura.', 'Trabajo equipo.\r\nHabilidades de comunicacion efectiva. ', 'Español / Ingles intermedio', 'Aportar valor a la compañia.', 'Varios proyectos desarrollados en con arquitecturas complejas en lengujes como PHP, JAVA, PYTHON.', 'Tiempo Completo', 'Linkedin, instagram, Telegram', '', '680928fbe45e3_myPhoto.PNG', '680928fbe45ea_CV REYNALDO.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre_empresa` varchar(150) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `usuario_id`, `nombre_empresa`, `direccion`, `telefono`) VALUES
(1, 1, 'Empresa1', 'Santo Domingo', '809-449-4320'),
(2, 4, 'Empresa2', 'Santiago de Los caballeros.', '849-222-4322'),
(3, 5, 'Empresa3', 'Santo Domingo/ Distrito Nacional', '849-024-4341');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `titulo_puesto` varchar(150) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `requisitos` text DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`id`, `id_empresa`, `titulo_puesto`, `descripcion`, `requisitos`, `fecha_publicacion`) VALUES
(1, 1, 'Desarrollador/a de Aplicaciones Móviles (Android/iOS)', 'Descripción: Estamos buscando un/a Desarrollador/a de Aplicaciones Móviles con experiencia en el desarrollo de aplicaciones nativas para plataformas Android o iOS. Participarás en el diseño, desarrollo, pruebas y despliegue de aplicaciones móviles de alta calidad que brinden una excelente experiencia de usuario.\r\n', 'Experiencia demostrable en el desarrollo de aplicaciones móviles nativas (Android con Kotlin/Java o iOS con Swift/Objective-C).\r\nSólidos conocimientos de los SDKs y frameworks correspondientes (Android SDK, UIKit, SwiftUI).\r\nComprensión de los principios de diseño de interfaces de usuario (UI) y experiencia de usuario (UX) para móviles.\r\nExperiencia trabajando con APIs RESTful y servicios web.\r\nFamiliaridad con herramientas de control de versiones (Git).\r\nConocimientos de testing de aplicaciones móviles (Unit, UI).', '2025-04-12 17:47:10'),
(3, 2, 'Desarrollador/a Web Full-Stack (React/Node.js)', 'Buscamos un/a Desarrollador/a Web Full-Stack apasionado/a por construir aplicaciones web innovadoras y escalables. Serás responsable del ciclo de vida completo del desarrollo, desde la concepción y diseño hasta la implementación y el mantenimiento. Trabajarás en un equipo ágil y colaborativo, contribuyendo al crecimiento de nuestra plataforma principal.', 'Experiencia demostrable de al menos 3 años en desarrollo web Full-Stack.\r\nSólidos conocimientos en JavaScript (ES6+).\r\nExperiencia avanzada con el framework React.js y su ecosistema (Redux, Context API, etc.).\r\nExperiencia con Node.js y frameworks como Express.js o NestJS.\r\nConocimientos de bases de datos relacionales (PostgreSQL, MySQL) y no relacionales (MongoDB).\r\nFamiliaridad con herramientas de control de versiones (Git).', '2025-04-23 16:02:33'),
(4, 2, 'Ingeniero/a de Datos', 'Estamos buscando un/a Ingeniero/a de Datos con experiencia en la construcción y optimización de pipelines de datos robustos y escalables. Serás fundamental para transformar grandes volúmenes de datos en información valiosa para la toma de decisiones. Trabajarás en estrecha colaboración con científicos de datos y analistas.', 'Dominio de lenguajes de programación como Python o Scala.\r\nExperiencia con herramientas de procesamiento de datos a gran escala (Spark, Hadoop, etc.).\r\nConocimiento profundo de bases de datos (SQL y NoSQL).\r\nExperiencia en la construcción y mantenimiento de ETL/ELT pipelines.\r\nFamiliaridad con plataformas cloud (AWS, Azure, GCP).', '2025-04-23 16:05:12'),
(5, 3, 'Desarrollador/a Backend Python.', 'Estamos buscando un/a Desarrollador/a Backend Python entusiasta para unirse a nuestro equipo. Serás responsable de desarrollar y mantener las APIs y la lógica del lado del servidor para nuestras aplicaciones web y servicios. Trabajarás en un entorno colaborativo y tendrás la oportunidad de impactar directamente en la arquitectura y el rendimiento de nuestros sistemas.', 'Experiencia demostrable de al menos 2 años en desarrollo Backend con Python.\r\nProfundo conocimiento de al menos un framework web de Python (Django, Flask).\r\nExperiencia en el diseño e implementación de APIs RESTful.\r\nConocimientos en bases de datos relacionales (PostgreSQL, MySQL) y no relacionales (MongoDB).\r\nFamiliaridad con ORMs (SQLAlchemy, Django ORM).', '2025-04-23 17:41:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('candidato','empresa') NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `contrasena`, `rol`, `fecha_registro`) VALUES
(1, 'empresa1@gmail.com', '$2y$10$KU6SS2HkwAMdN94Ehb52guroYYUksJsq27VWKx8eKygG3sJU5kRLK', 'empresa', '2025-04-12 13:35:47'),
(2, 'Bruno@gmail.com', '$2y$10$9NET7.ngarhHLJAwyox5iuS7QtfsgUBqzCOqiIUzb0bBw65EG/tRS', 'candidato', '2025-04-12 20:41:24'),
(3, 'Maria@gmail.com', '$2y$10$MhUeAPiopehoLUASIpX6c.dXMXt3ThOb4.d3IL94PHZADvQC.pZGK', 'candidato', '2025-04-22 15:50:17'),
(4, 'empresa2@gmail.com', '$2y$10$tc37LBYlIq9Knw9VSldgnOEPeBGGHn6L6Zq1CAat9usPLoinHJJ1O', 'empresa', '2025-04-23 15:57:52'),
(5, 'empresa3@gmail.com', '$2y$10$wv6I1Nt1yK7kcpmu0Fm6xOfEqVQyUek86eteCnzgi5l2.z.x3m3nq', 'empresa', '2025-04-23 17:36:49'),
(6, 'Lucas@gmail.com', '$2y$10$Mq8GQlqKkdEsQbtXZVWYt.LWkjI.ulIAr5ZlGLdIwabsm7RVOJbN6', 'candidato', '2025-04-23 17:44:29');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aplicaciones`
--
ALTER TABLE `aplicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_candidato` (`id_candidato`),
  ADD KEY `id_oferta` (`id_oferta`);

--
-- Indices de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aplicaciones`
--
ALTER TABLE `aplicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aplicaciones`
--
ALTER TABLE `aplicaciones`
  ADD CONSTRAINT `aplicaciones_ibfk_1` FOREIGN KEY (`id_candidato`) REFERENCES `candidatos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aplicaciones_ibfk_2` FOREIGN KEY (`id_oferta`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD CONSTRAINT `candidatos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
