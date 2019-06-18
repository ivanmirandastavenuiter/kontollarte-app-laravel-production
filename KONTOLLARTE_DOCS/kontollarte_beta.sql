-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2019 a las 00:39:47
-- Versión del servidor: 10.1.39-MariaDB
-- Versión de PHP: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kontollarte_beta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galleries`
--

CREATE TABLE `galleries` (
  `galleryId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `galleryName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `galleryAddress` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `galleryEmail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `galleryWeb` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `galleries`
--

INSERT INTO `galleries` (`galleryId`, `galleryName`, `galleryAddress`, `galleryEmail`, `galleryWeb`, `created_at`, `updated_at`) VALUES
('4eb17001b1976400010115f5', 'Marlborough Gallery Fair Partner', 'North America', 'mny@marlboroughgallery.com', 'http://www.marlboroughgallery.com', '2019-06-13 18:52:37', '2019-06-13 18:52:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galleries_users`
--

CREATE TABLE `galleries_users` (
  `galleriesUsersId` int(10) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `galleryId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallerySignup` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `galleries_users`
--

INSERT INTO `galleries_users` (`galleriesUsersId`, `userId`, `galleryId`, `gallerySignup`, `created_at`, `updated_at`) VALUES
(2, 1, '4eb17001b1976400010115f5', '2019-06-13', '2019-06-13 18:52:37', '2019-06-13 18:52:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE `images` (
  `imageId` bigint(20) UNSIGNED NOT NULL,
  `imageUrl` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageHeight` smallint(6) NOT NULL,
  `imageWidth` smallint(6) NOT NULL,
  `showId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `messageId` bigint(20) UNSIGNED NOT NULL,
  `messageBody` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageDate` date NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`messageId`, `messageBody`, `messageDate`, `userId`, `created_at`, `updated_at`) VALUES
(1, '\"dsa\"', '2019-06-13', 1, '2019-06-13 18:52:59', '2019-06-13 18:52:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages_receivers`
--

CREATE TABLE `messages_receivers` (
  `messagesReceiversId` bigint(20) UNSIGNED NOT NULL,
  `messageId` bigint(20) UNSIGNED NOT NULL,
  `receiverId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `messages_receivers`
--

INSERT INTO `messages_receivers` (`messagesReceiversId`, `messageId`, `receiverId`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_04_03_144956_create_galleries_table', 1),
(4, '2019_04_03_145109_create_shows_table', 1),
(5, '2019_04_03_145110_create_images_table', 1),
(6, '2019_04_03_145142_create_paints_table', 1),
(7, '2019_04_03_145156_create_messages_table', 1),
(8, '2019_04_03_145210_create_receivers_table', 1),
(9, '2019_04_06_161436_create_galleries_users_table', 1),
(10, '2019_04_06_164049_create_messages_receivers_table', 1),
(11, '2019_06_03_131740_create_sales_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paints`
--

CREATE TABLE `paints` (
  `paintId` bigint(20) UNSIGNED NOT NULL,
  `paintName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paintDate` date DEFAULT NULL,
  `paintDescription` text COLLATE utf8mb4_unicode_ci,
  `paintImage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sold` tinyint(1) NOT NULL DEFAULT '0',
  `userId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paints`
--

INSERT INTO `paints` (`paintId`, `paintName`, `paintDate`, `paintDescription`, `paintImage`, `sold`, `userId`, `created_at`, `updated_at`) VALUES
(2, 'Obra 1', '2019-01-01', 'Obra 1', 'images/paintings/uploads/799296943584AgüeroSpain1920x1080.jpg', 0, 1, '2019-06-13 18:51:00', '2019-06-13 18:51:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receivers`
--

CREATE TABLE `receivers` (
  `receiverId` bigint(20) UNSIGNED NOT NULL,
  `receiverEmail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiverName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `receivers`
--

INSERT INTO `receivers` (`receiverId`, `receiverEmail`, `receiverName`, `created_at`, `updated_at`) VALUES
(1, 'mny@marlboroughgallery.com', 'Marlborough Gallery Fair Partner', '2019-06-13 18:52:59', '2019-06-13 18:52:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `saleId` bigint(20) UNSIGNED NOT NULL,
  `saleUrl` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paintId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shows`
--

CREATE TABLE `shows` (
  `showId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `showStartingDate` date DEFAULT NULL,
  `showEndingDate` date DEFAULT NULL,
  `showName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `showDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `showOrder` tinyint(4) NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `userId` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`userId`, `username`, `name`, `surname`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Iván', 'Iván', 'Miranda', 'ivanmist90@gmail.com', 600600600, NULL, '$2y$10$Sp2Bc3Z4j0jdiFL9YxHMjeWiOXMEhukj4N8xEj.mlQQwIu4QVP912', NULL, '2019-06-13 18:35:53', '2019-06-13 18:35:53');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`galleryId`),
  ADD UNIQUE KEY `galleries_galleryemail_unique` (`galleryEmail`);

--
-- Indices de la tabla `galleries_users`
--
ALTER TABLE `galleries_users`
  ADD PRIMARY KEY (`galleriesUsersId`),
  ADD KEY `galleries_users_userid_foreign` (`userId`),
  ADD KEY `galleries_users_galleryid_foreign` (`galleryId`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageId`),
  ADD KEY `images_showid_foreign` (`showId`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `messages_userid_foreign` (`userId`);

--
-- Indices de la tabla `messages_receivers`
--
ALTER TABLE `messages_receivers`
  ADD PRIMARY KEY (`messagesReceiversId`),
  ADD KEY `messages_receivers_messageid_foreign` (`messageId`),
  ADD KEY `messages_receivers_receiverid_foreign` (`receiverId`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paints`
--
ALTER TABLE `paints`
  ADD PRIMARY KEY (`paintId`),
  ADD KEY `paints_userid_foreign` (`userId`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `receivers`
--
ALTER TABLE `receivers`
  ADD PRIMARY KEY (`receiverId`),
  ADD UNIQUE KEY `receivers_receiveremail_unique` (`receiverEmail`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`saleId`),
  ADD KEY `sales_paintid_foreign` (`paintId`);

--
-- Indices de la tabla `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`showId`),
  ADD KEY `shows_userid_foreign` (`userId`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `galleries_users`
--
ALTER TABLE `galleries_users`
  MODIFY `galleriesUsersId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `imageId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `messageId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `messages_receivers`
--
ALTER TABLE `messages_receivers`
  MODIFY `messagesReceiversId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `paints`
--
ALTER TABLE `paints`
  MODIFY `paintId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `receivers`
--
ALTER TABLE `receivers`
  MODIFY `receiverId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `saleId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `userId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `galleries_users`
--
ALTER TABLE `galleries_users`
  ADD CONSTRAINT `galleries_users_galleryid_foreign` FOREIGN KEY (`galleryId`) REFERENCES `galleries` (`galleryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `galleries_users_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_showid_foreign` FOREIGN KEY (`showId`) REFERENCES `shows` (`showId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `messages_receivers`
--
ALTER TABLE `messages_receivers`
  ADD CONSTRAINT `messages_receivers_messageid_foreign` FOREIGN KEY (`messageId`) REFERENCES `messages` (`messageId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_receivers_receiverid_foreign` FOREIGN KEY (`receiverId`) REFERENCES `receivers` (`receiverId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `paints`
--
ALTER TABLE `paints`
  ADD CONSTRAINT `paints_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_paintid_foreign` FOREIGN KEY (`paintId`) REFERENCES `paints` (`paintId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `shows_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
