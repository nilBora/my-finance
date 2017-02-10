-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 10 2017 г., 14:34
-- Версия сервера: 5.5.44-MariaDB
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `devs_nil_sandbox`
--

-- --------------------------------------------------------

--
-- Структура таблицы `finances`
--

CREATE TABLE IF NOT EXISTS `finances` (
  `id` int(11) NOT NULL,
  `cash` float NOT NULL,
  `cdate` date NOT NULL,
  `ctime` time NOT NULL,
  `category` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `finances`
--

INSERT INTO `finances` (`id`, `cash`, `cdate`, `ctime`, `category`) VALUES
(1, 35, '2017-02-08', '13:51:55', 'lunch'),
(2, 18, '2017-02-08', '17:53:22', 'coffe'),
(3, 40, '2017-02-09', '10:21:00', 'lunch'),
(4, 11, '2017-02-09', '15:44:39', 'lunch'),
(5, 18, '2017-02-09', '15:45:31', 'coffe'),
(6, 30, '2017-02-10', '14:34:03', 'lunch');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `role` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password`) VALUES
(1, 'admin', 'brdnlsrg@gmail.com', 'brdnlsrg@gmail.com', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'user', 'User', 'User@user.com', '21232f297a57a5a743894a0e4a801fc3');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `finances`
--
ALTER TABLE `finances`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `finances`
--
ALTER TABLE `finances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
