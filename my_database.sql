-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 31-12-2022 a las 20:05:53
-- Versión del servidor: 10.8.3-MariaDB-1:10.8.3+maria~jammy
-- Versión de PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `my_database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_roles` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_roles`, `role`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `user_name`, `password`, `email`, `id_role`) VALUES
(1, 'Luís', '$2y$10$zNSjJmWjAg2Rn4vyKB/y4.wHEKWxhkhdVqPRotjK6DQO5fil5YbDG', 'fpoulton0@trellian.com', 2),
(2, 'pnusche1', 'kn4dZSZy', 'oalten1@timesonline.co.uk', 2),
(3, 'rjob2', '$2y$10$urz15Zw2iYSm84HKXJbSdu6FF2jUo3B7TyfOZ1wUa9/UDLLJ5aLAO', 'hkoschke2@columbia.edu', 2),
(4, 'gbeckhurst3', 'hli11TCLLy5W', 'cmcelory3@desdev.cn', 2),
(5, 'cvain4', 'kmSK2dW1x', 'pmcmillan4@skype.com', 2),
(6, 'csteddall5', 'rRaBKnY14Ke', 'afussen5@t.co', 2),
(7, 'isopper6', 'cjphThcO', 'mhaylett6@symantec.com', 2),
(8, 'bmoore7', 'iVE8hSSvOaKw', 'bwoolforde7@joomla.org', 2),
(9, 'lpostgate8', 's7hUPoCRjkiI', 'wallbut8@infoseek.co.jp', 2),
(10, 'fhansed9', 'saV7FmEJq', 'bbartke9@gnu.org', 2),
(11, 'admin', '$2y$10$UmlPg2q.E8FyQ/y8/zkcgu/OXaar1erO8gEldBqGI5BtB3vElwReq', 'admin@admin.com', 1),
(12, 'pepe', '$2y$10$o6boSNPz0e2bd53A5fK8Ruff9C3n9hUkOIINtwuEh4t06eGSEcpEK', 'pepe@pepe.com', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`id_role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_roles`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
