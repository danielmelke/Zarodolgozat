-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Ápr 03. 16:12
-- Kiszolgáló verziója: 10.4.17-MariaDB
-- PHP verzió: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `mainproject`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `author_id` bigint(20) NOT NULL,
  `offer_name` varchar(255) NOT NULL,
  `offer_description` text NOT NULL,
  `offer_images` text NOT NULL,
  `offer_price` int(11) NOT NULL,
  `offer_city` varchar(50) NOT NULL,
  `offer_timestamp` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `offers`
--

INSERT INTO `offers` (`id`, `author_id`, `offer_name`, `offer_description`, `offer_images`, `offer_price`, `offer_city`, `offer_timestamp`) VALUES
(2, 3487592898399597, 'Ez egy új hírdetés', 'Keresek valamit', '', 6599, '', '2021-03-30 10:16:51'),
(4, 3487592898399597, 'Alma', '4kg', 'IMG_f9kul8pyqo3kfbvyd5pl.jpg', 1000, '', '2021-04-01 15:09:18'),
(5, 3487592898399597, 'Benzines fűnyíró', 'Nagyon jó állapotban', 'IMG_glwbmj7fzcdhjma62nbh.jpg', 50000, '', '2021-04-01 14:59:31');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `from_user` bigint(20) NOT NULL,
  `to_user` bigint(20) NOT NULL,
  `rating_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `ratings`
--

INSERT INTO `ratings` (`id`, `post_id`, `from_user`, `to_user`, `rating_value`) VALUES
(1, 1, 3487592898399597, 8664314520740530, 5);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` varchar(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `measure` varchar(10) NOT NULL,
  `content` varchar(255) NOT NULL,
  `unique_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `shopping_cart`
--

INSERT INTO `shopping_cart` (`id`, `product_id`, `amount`, `measure`, `content`, `unique_id`) VALUES
('bxuwzjq7kl2aytxto7j4', 3, 1, 'Kilogram', 'fehér', 1),
('bxuwzjq7kl2aytxto7j4', 4, 2, 'liter', '3,5%-os', 2),
('bxuwzjq7kl2aytxto7j4', 5, 6, 'Darab', 'vizes', 3),
('bxuwzjq7kl2aytxto7j4', 14, 1, 'Kilogram', 'előgőzölt', 4),
('bxuwzjq7kl2aytxto7j4', 16, 1, 'Kilogram', '', 5);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `shopping_posts`
--

CREATE TABLE `shopping_posts` (
  `cart_id` varchar(20) NOT NULL,
  `owner_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `shopping_posts`
--

INSERT INTO `shopping_posts` (`cart_id`, `owner_id`) VALUES
('bxuwzjq7kl2aytxto7j4', 3487592898399597);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `shopping_products`
--

CREATE TABLE `shopping_products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `shopping_products`
--

INSERT INTO `shopping_products` (`id`, `name`) VALUES
(3, 'Kenyér'),
(4, 'Tej'),
(5, 'Zsemle'),
(6, 'Tészta'),
(7, 'Liszt'),
(8, 'Kristálycukor'),
(9, 'Porcukor'),
(10, 'Só'),
(11, 'Hús'),
(12, 'Üditő'),
(13, 'Ásványvíz'),
(14, 'Rizs'),
(15, 'Papírzsebkendő'),
(16, 'Répa'),
(17, 'Tejföl'),
(18, 'Sajt'),
(19, 'Étolaj'),
(20, 'Hal');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `role` varchar(25) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phone_visible` tinyint(1) NOT NULL DEFAULT 0,
  `about` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `user_id`, `first_name`, `last_name`, `email`, `password_hash`, `date_of_birth`, `county`, `city`, `role`, `phone`, `phone_visible`, `about`) VALUES
(2, 3487592898399597, 'Jakab', 'GipszUpdate', 'example@example.com', '$2y$10$DX2bmfSJgNY6ksn8fLWEnOh4.59/JwOjJ.D9nmyHDVEnSsWTJqeIW', '1970-05-20', 'Pest', 'Budapest II. kerület', 'Segítő', '06301115544', 1, 'Hello, jöttem segíteni'),
(4, 2221222813552114, 'John', 'Doe', 'johndoe@example.com', '$2y$10$lfuNI4U6XAodD65QmnfQ0epwy4QeS8856m970ltbUHJrBgN1J7EfK', '2021-03-06', 'Pest', 'Budapest XIV. kerület', 'Segítséget kér', NULL, 0, NULL),
(8, 8664314520740530, 'Péter', 'Minta', 'mintapeter@example.com', '$2y$10$hN0ug.cyEQNz4P.0T8Joq.yyJISutvYXAD7FOojWlRoe1Zb7ho06a', '1989-03-17', 'Pest', 'Budapest IX. kerület', 'Segítő és segítséget kérő', '06205556789', 1, 'rövid bemutatkozás');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_posts`
--

CREATE TABLE `user_posts` (
  `id` int(11) NOT NULL,
  `author_id` bigint(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `post_content` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `category` varchar(20) NOT NULL,
  `role` varchar(25) NOT NULL,
  `status` varchar(20) NOT NULL,
  `cart_id` varchar(20) NOT NULL,
  `helper_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `user_posts`
--

INSERT INTO `user_posts` (`id`, `author_id`, `subject`, `timestamp`, `post_content`, `city`, `category`, `role`, `status`, `cart_id`, `helper_id`) VALUES
(1, 3487592898399597, 'TEST', '2021-03-29 11:55:35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquam bibendum mauris ac commodo. Pellentesque luctus bibendum ultrices. Suspendisse sem est, finibus a nulla ut, eleifend accumsan orci. Phasellus nec elit id enim dignissim fermentum. Maecenas lobortis sagittis tincidunt. Curabitur metus sapien, iaculis sed neque vitae, imperdiet laoreet metus. Proin tortor nisl, bibendum vel velit et, molestie sollicitudin arcu. ', '', 'shopping', 'lookingForHelp', 'Befejezett', '', 8664314520740530),
(5, 3487592898399597, 'fassfafasf', '2021-03-28 19:26:26', ' fasfasfasfasfasf ez updatelt', '', '', '', 'Aktív', '', NULL),
(7, 2221222813552114, 'Ez egy új téma/cím', '2021-03-15 17:05:22', ' Egy új poszt szövege blabla\r\n\r\n\r\n\r\nfrissen szerkesztve', '', '', '', 'Aktív', '', NULL),
(8, 8664314520740530, 'Helloka', '2021-03-15 18:43:38', 'Ez egy új poszt, formázva\r\n\r\nAre you ready to explore the smart factory of the future? Recently, the first silicon wafers have passed through the fully automated fabrication process at our new semiconductor plant in Dresden, Germany – a key step toward the start of production operations. \r\n\r\nJoin Nicole Scott, co-founder of MobileGeeks and video journalist, on her visit to our new wafer factory and find out how a semiconductor is made in the clean room and why the importance of semiconductors will continue to grow in the future. Learn more about our fully automated smart factory', '', '', '', 'Folyamatban', '', 3487592898399597),
(9, 3487592898399597, 'agasgssgds', '2021-03-29 11:52:07', 'dsgsdgdsgssggdgs', 'Budapest II. kerület', 'other', 'lookingForHelp', 'Aktív', '', NULL),
(11, 3487592898399597, 'Ez egy új vásárlási poszt', '2021-04-01 11:21:17', 'Valaki menjen el a Lidlibe', 'Budapest II. kerület', 'shopping', 'lookingForHelp', 'Folyamatban', 'bxuwzjq7kl2aytxto7j4', 8664314520740530);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- A tábla indexei `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_user` (`from_user`),
  ADD KEY `to_user` (`to_user`);

--
-- A tábla indexei `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`unique_id`),
  ADD KEY `Index` (`id`),
  ADD KEY `Index2` (`product_id`);

--
-- A tábla indexei `shopping_posts`
--
ALTER TABLE `shopping_posts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `Index` (`owner_id`),
  ADD KEY `Index2` (`cart_id`);

--
-- A tábla indexei `shopping_products`
--
ALTER TABLE `shopping_products`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- A tábla indexei `user_posts`
--
ALTER TABLE `user_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id_2` (`author_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `unique_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `shopping_products`
--
ALTER TABLE `shopping_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `user_posts`
--
ALTER TABLE `user_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `FK_UserOffer` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `FK_UserRatingFrom` FOREIGN KEY (`from_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_UserRatingTo` FOREIGN KEY (`to_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `FK_CartProduct` FOREIGN KEY (`product_id`) REFERENCES `shopping_products` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `user_posts`
--
ALTER TABLE `user_posts`
  ADD CONSTRAINT `FK_UserPost` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
