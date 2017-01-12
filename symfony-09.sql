-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 12 2017 г., 04:44
-- Версия сервера: 5.7.13-log
-- Версия PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `symfony-09`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `sale_id`, `item_id`, `amount`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 3),
(3, 2, 1, 2),
(4, 3, 1, 1),
(5, 4, 1, 4),
(6, 5, 1, 1),
(7, 5, 3, 2),
(8, 5, 4, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(5, 'Desctop'),
(3, 'Laptop'),
(1, 'Phone');

-- --------------------------------------------------------

--
-- Структура таблицы `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `item`
--

INSERT INTO `item` (`id`, `name`, `price`, `content`, `category_id`) VALUES
(1, 'First item name edited 3 times', '100.22', 'Some <b>text</b>', 3),
(2, 'vivamus vestibulum sagittis sapien cum', '29.00', 'scelerisque mauris sit amet eros suspendisse accumsan tortor quis turpis sed ante vivamus tortor duis mattis egestas metus aenean', 3),
(3, 'vestibulum sed', '45.47', 'ipsum aliquam non mauris morbi non', NULL),
(4, 'nullam molestie nibh', '47.00', 'erat quisque erat eros viverra eget congue eget semper', NULL),
(5, 'vulputate', '15.00', 'congue etiam justo etiam pretium', NULL),
(6, 'rutrum ac lobortis', '46.00', 'placerat ante nulla justo aliquam quis', NULL),
(7, 'arcu libero rutrum ac lobortis', '7.00', 'dolor vel est donec odio justo sollicitudin ut suscipit a', NULL),
(8, 'eu felis fusce posuere felis', '10.00', 'sollicitudin ut suscipit a feugiat et eros vestibulum ac est', NULL),
(9, 'congue elementum', '14.00', 'metus sapien ut nunc vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae mauris viverra', NULL),
(10, 'eros viverra eget', '53.00', 'faucibus cursus urna ut tellus nulla ut erat id mauris vulputate elementum nullam varius nulla facilisi cras non velit', NULL),
(11, 'accumsan tellus nisi eu', '19.00', 'accumsan odio curabitur convallis duis consequat dui nec nisi volutpat', NULL),
(12, 'mi sit amet lobortis sapien', '91.00', 'praesent id massa id nisl venenatis lacinia aenean sit amet justo morbi ut odio cras mi pede malesuada in imperdiet', NULL),
(13, 'ut massa volutpat convallis morbi', '12.00', 'ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium nisl ut', NULL),
(14, 'nulla', '60.00', 'sapien dignissim vestibulum vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae', NULL),
(15, 'maecenas ut massa', '20.00', 'posuere cubilia curae duis faucibus accumsan odio curabitur convallis duis', NULL),
(16, 'mauris enim', '78.00', 'maecenas rhoncus aliquam lacus morbi quis tortor id nulla ultrices aliquet maecenas leo odio', NULL),
(17, 'felis', '5.00', 'id ligula suspendisse ornare consequat lectus in est risus auctor sed tristique in tempus sit amet sem', NULL),
(18, 'rhoncus aliquam lacus morbi', '54.00', 'semper porta volutpat quam pede lobortis ligula sit amet', NULL),
(19, 'lorem ipsum dolor sit amet', '84.00', 'vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare', NULL),
(20, 'ac consequat metus sapien', '6.00', 'quis turpis eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan tortor quis turpis sed', NULL),
(21, 'mattis', '92.00', 'ut tellus nulla ut erat id mauris vulputate elementum nullam varius', NULL),
(22, 'nibh ligula nec sem', '10.00', 'fermentum justo nec condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque', NULL),
(23, 'aenean fermentum donec ut', '78.00', 'vitae nisl aenean lectus pellentesque', NULL),
(24, 'tellus', '95.00', 'donec posuere metus vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet', NULL),
(25, 'rhoncus aliquam lacus morbi', '60.00', 'vulputate vitae nisl aenean lectus pellentesque eget nunc donec quis orci eget orci vehicula condimentum', NULL),
(26, 'aliquam sit amet diam', '56.00', 'habitasse platea dictumst aliquam augue quam sollicitudin vitae consectetuer eget rutrum at lorem integer tincidunt ante vel ipsum', NULL),
(27, 'libero convallis eget eleifend', '75.00', 'luctus et ultrices posuere cubilia curae duis faucibus', NULL),
(28, 'non mi integer ac neque', '52.00', 'pellentesque quisque porta volutpat erat quisque erat eros viverra eget congue eget semper rutrum nulla nunc purus', NULL),
(29, 'convallis duis consequat', '64.00', 'donec odio justo sollicitudin ut suscipit a feugiat et', NULL),
(30, 'sem mauris laoreet ut', '45.00', 'felis ut at dolor quis odio consequat varius integer ac leo pellentesque ultrices mattis odio donec', NULL),
(31, 'iaculis justo in hac habitasse', '7.00', 'augue luctus tincidunt nulla mollis molestie lorem quisque ut erat curabitur gravida nisi at', NULL),
(32, 'quam', '54.00', 'ut suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien', NULL),
(33, 'malesuada in imperdiet', '86.00', 'porttitor lacus at turpis donec posuere metus vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet diam in', NULL),
(34, 'varius', '53.00', 'tempor turpis nec euismod scelerisque quam turpis adipiscing lorem vitae mattis nibh', NULL),
(35, 'erat tortor sollicitudin mi sit', '33.00', 'sit amet consectetuer adipiscing elit proin risus praesent lectus', NULL),
(36, 'nulla nisl nunc nisl duis', '91.00', 'curabitur convallis duis consequat dui nec nisi volutpat eleifend donec ut dolor morbi vel lectus in quam fringilla rhoncus mauris', NULL),
(37, 'sed nisl nunc', '70.00', 'interdum mauris non ligula pellentesque ultrices phasellus id', NULL),
(38, 'sagittis sapien cum sociis', '58.00', 'nulla facilisi cras non velit nec nisi vulputate nonummy maecenas tincidunt lacus at velit vivamus vel nulla eget eros elementum', NULL),
(39, 'vestibulum ac est lacinia', '32.00', 'nec sem duis aliquam convallis nunc proin', NULL),
(40, 'a ipsum integer a nibh', '20.00', 'montes nascetur ridiculus mus etiam vel augue vestibulum rutrum rutrum neque aenean auctor gravida sem praesent id', NULL),
(41, 'libero convallis', '63.00', 'consectetuer adipiscing elit proin interdum mauris non ligula pellentesque ultrices phasellus', NULL),
(42, 'malesuada in imperdiet', '80.00', 'est risus auctor sed tristique in tempus sit amet sem fusce consequat nulla', NULL),
(43, 'convallis', '79.00', 'ut nunc vestibulum ante ipsum primis in faucibus orci luctus et', NULL),
(44, 'vitae quam suspendisse', '90.00', 'cursus vestibulum proin eu mi nulla ac enim', NULL),
(45, 'risus semper porta volutpat quam', '34.00', 'vel augue vestibulum rutrum rutrum neque aenean auctor gravida sem praesent id massa id nisl venenatis lacinia aenean sit', NULL),
(46, 'leo rhoncus sed vestibulum sit', '11.00', 'vel nulla eget eros elementum pellentesque quisque porta volutpat erat quisque erat eros viverra eget', NULL),
(47, 'quam pede lobortis ligula', '98.00', 'dapibus dolor vel est donec', NULL),
(48, 'praesent lectus', '91.00', 'nunc nisl duis bibendum felis sed interdum venenatis turpis enim blandit mi', NULL),
(49, 'non lectus aliquam sit amet', '83.00', 'faucibus orci luctus et ultrices posuere cubilia', NULL),
(50, 'eu magna', '27.00', 'justo morbi ut odio cras mi pede malesuada in imperdiet et commodo vulputate justo in blandit ultrices', NULL),
(51, 'neque vestibulum eget vulputate', '24.00', 'lobortis est phasellus sit amet erat nulla tempus vivamus in felis', NULL),
(52, 'nisi', '74.00', 'eu sapien cursus vestibulum proin eu mi nulla ac enim in tempor turpis nec euismod scelerisque quam turpis adipiscing lorem', NULL),
(53, 'nunc', '60.00', 'ac est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet', NULL),
(54, 'dolor sit', '12.00', 'quis orci nullam molestie nibh in lectus pellentesque at nulla suspendisse potenti cras in', NULL),
(55, 'in hac', '73.00', 'eleifend donec ut dolor morbi vel lectus', NULL),
(56, 'vel est donec odio', '43.00', 'imperdiet nullam orci pede venenatis non sodales sed tincidunt eu felis fusce', NULL),
(57, 'sit', '73.00', 'massa tempor convallis nulla neque libero convallis eget', NULL),
(58, 'aliquet at feugiat', '63.00', 'lacus morbi sem mauris laoreet ut rhoncus aliquet pulvinar sed nisl nunc rhoncus dui vel sem', NULL),
(59, 'maecenas ut massa', '74.00', 'varius integer ac leo pellentesque ultrices mattis odio donec vitae nisi nam ultrices', NULL),
(60, 'volutpat dui maecenas tristique est', '4.00', 'at turpis donec posuere metus vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet', NULL),
(61, 'sit amet nulla', '64.00', 'congue vivamus metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc', NULL),
(62, 'mauris enim leo rhoncus sed', '83.00', 'sapien varius ut blandit non interdum in ante vestibulum ante ipsum primis in', NULL),
(63, 'aliquam erat volutpat', '4.00', 'etiam pretium iaculis justo in hac habitasse platea', NULL),
(64, 'volutpat', '93.00', 'cursus id turpis integer aliquet', NULL),
(65, 'in felis eu sapien cursus', '89.00', 'nibh in lectus pellentesque at nulla suspendisse potenti cras in purus eu magna vulputate luctus', NULL),
(66, 'elit', '35.00', 'posuere cubilia curae mauris viverra diam vitae quam suspendisse potenti nullam porttitor lacus at turpis donec', NULL),
(67, 'cubilia curae donec pharetra magna', '76.00', 'lacus morbi quis tortor id nulla ultrices aliquet maecenas leo odio condimentum', NULL),
(68, 'odio justo', '32.00', 'integer ac leo pellentesque ultrices mattis odio donec vitae nisi nam ultrices libero', NULL),
(69, 'semper interdum mauris ullamcorper purus', '7.00', 'nec nisi volutpat eleifend donec ut dolor morbi vel lectus', NULL),
(70, 'vitae nisl aenean', '13.00', 'aliquam quis turpis eget elit sodales scelerisque mauris', NULL),
(71, 'ridiculus mus etiam vel augue', '4.00', 'condimentum neque sapien placerat ante nulla justo aliquam quis turpis eget elit', NULL),
(72, 'orci vehicula', '8.00', 'sapien dignissim vestibulum vestibulum ante ipsum primis in', NULL),
(73, 'eu magna vulputate luctus', '3.00', 'orci mauris lacinia sapien quis libero nullam', NULL),
(74, 'cubilia curae mauris viverra diam', '86.00', 'tincidunt lacus at velit vivamus vel nulla eget eros elementum pellentesque quisque', NULL),
(75, 'magna', '42.00', 'vestibulum quam sapien varius ut blandit non interdum in ante vestibulum ante', NULL),
(76, 'et', '73.00', 'a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue', NULL),
(77, 'nunc', '31.00', 'convallis nulla neque libero convallis eget eleifend luctus ultricies eu nibh quisque id justo sit amet sapien dignissim vestibulum', NULL),
(78, 'erat nulla tempus vivamus in', '56.00', 'convallis nunc proin at turpis a pede posuere nonummy integer non velit donec diam neque', NULL),
(79, 'volutpat convallis morbi odio odio', '88.00', 'neque aenean auctor gravida sem praesent id massa id nisl venenatis lacinia aenean', NULL),
(80, 'augue vestibulum rutrum rutrum neque', '3.00', 'consectetuer eget rutrum at lorem integer tincidunt ante vel ipsum praesent blandit lacinia erat vestibulum sed', NULL),
(81, 'sapien', '81.00', 'posuere cubilia curae nulla dapibus dolor vel est donec odio justo sollicitudin ut suscipit', NULL),
(82, 'lorem integer tincidunt ante', '63.00', 'diam neque vestibulum eget vulputate ut ultrices vel augue', NULL),
(83, 'ligula', '61.00', 'vulputate justo in blandit ultrices enim lorem ipsum dolor', NULL),
(84, 'felis sed', '56.00', 'in est risus auctor sed tristique in tempus sit amet sem', NULL),
(85, 'at velit eu', '36.00', 'posuere metus vitae ipsum aliquam non mauris morbi non lectus', NULL),
(86, 'morbi porttitor', '8.00', 'ornare consequat lectus in est risus auctor sed tristique in tempus sit amet sem fusce consequat nulla nisl', NULL),
(87, 'nulla sed accumsan felis', '72.00', 'ultrices posuere cubilia curae nulla dapibus dolor vel est donec odio justo', NULL),
(88, 'nulla', '23.00', 'tellus nulla ut erat id mauris vulputate', NULL),
(89, 'nulla suscipit', '70.00', 'eu interdum eu tincidunt in leo maecenas pulvinar lobortis est phasellus sit amet erat nulla tempus vivamus in felis eu', NULL),
(90, 'blandit ultrices', '45.00', 'integer pede justo lacinia eget tincidunt eget tempus vel pede', NULL),
(91, 'consequat metus', '55.00', 'metus sapien ut nunc vestibulum ante ipsum primis in', NULL),
(92, 'porttitor', '51.00', 'vestibulum sit amet cursus id turpis integer aliquet massa id lobortis convallis tortor risus dapibus', NULL),
(93, 'quam pharetra magna ac', '79.00', 'diam neque vestibulum eget vulputate', NULL),
(94, 'cursus urna ut tellus', '57.00', 'dapibus duis at velit eu est congue elementum in hac habitasse platea dictumst morbi', NULL),
(95, 'erat tortor sollicitudin mi sit', '91.00', 'massa donec dapibus duis at velit eu est congue elementum in hac habitasse platea dictumst', NULL),
(96, 'auctor', '14.00', 'et tempus semper est quam pharetra magna ac consequat metus sapien ut nunc vestibulum ante ipsum primis', NULL),
(97, 'dapibus nulla suscipit ligula', '31.00', 'sit amet sapien dignissim vestibulum vestibulum ante ipsum primis in faucibus orci luctus et ultrices', NULL),
(98, 'ac', '26.00', 'in felis eu sapien cursus vestibulum proin eu mi nulla ac enim', NULL),
(99, 'faucibus orci luctus et ultrices', '48.00', 'in congue etiam justo etiam pretium iaculis', NULL),
(100, 'non', '80.00', 'id consequat in consequat ut nulla sed accumsan felis ut at dolor quis odio consequat varius integer ac', NULL),
(101, 'non mattis pulvinar nulla', '83.00', 'eleifend pede libero quis orci nullam', NULL),
(102, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(103, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(104, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(105, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(106, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(107, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(108, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(109, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(110, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(111, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(112, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(113, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(114, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(115, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(116, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(117, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(118, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(119, 'First item name', '100.00', 'Some <b>text</b> ', NULL),
(120, 'Ogogo', '132.24', 'Ogogo go how much of content', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `sale`
--

CREATE TABLE IF NOT EXISTS `sale` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `sale`
--

INSERT INTO `sale` (`id`, `name`, `email`, `phone`, `address`, `message`, `user_id`) VALUES
(1, 'Andrii', 'andrii@index.com', '+380661234567', 'Ukraine', 'Message from andrii', NULL),
(2, 'Olga', 'olga@item.ua', '+30679999999', 'Ukraine', 'Message from Olga', NULL),
(3, 'andrii', 'andrii@item.com', '+38054675486458', 'Ukraine', 'Second message from Andrii', 9),
(4, 'Anton', 'anton@item.com', '+704347837', 'Kiev', 'From Anton with love', NULL),
(5, 'Andrii', 'andrii@index.com', '+241421414', 'Ukraine', 'Third cart', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `password`, `roles`) VALUES
(3, 'admin', 'admin@item.com', '$2y$13$tQBKzQQepAU42nkeKTy9MO.sBMa76GI50e/tI7AH27B0ZvsW7ehrq', '["ROLE_ADMIN","ROLE_MANAGER"]'),
(4, 'manager', 'manager@item.com', '$2y$13$T/dB6TmpzDdxuQdp0N5vXOdlDl0I/qQkxkkA7YLch2PTEj3iBVY9K', '["ROLE_MANAGER"]'),
(9, 'andrii', 'andrii@item.com', '$2y$13$09dw3xBY0hW0j1mc84nWjOLHAsS1P0jHmtQOkmXY9SvKnTOKYmoEW', '["ROLE_USER"]');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BA388B74A7E4868` (`sale_id`),
  ADD KEY `IDX_BA388B7126F525E` (`item_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`);

--
-- Индексы таблицы `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F1B251E12469DE2` (`category_id`);

--
-- Индексы таблицы `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E54BC005A76ED395` (`user_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649AA08CB10` (`login`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT для таблицы `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_BA388B74A7E4868` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`);

--
-- Ограничения внешнего ключа таблицы `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_1F1B251E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Ограничения внешнего ключа таблицы `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `FK_E54BC005A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
