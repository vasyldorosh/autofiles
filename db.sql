ALTER TABLE  `auto_model_year` ADD  `chassis_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL , ADD INDEX (  `chassis_id` );
--ALTER TABLE  `auto_model_year` ADD FOREIGN KEY (  `chassis_id` ) REFERENCES  `auto_model_year_chassis` (`id`) ON DELETE SET NULL ;



-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 20 2014 г., 16:21
-- Версия сервера: 5.1.68
-- Версия PHP: 5.4.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `auto`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auto_model_year_chassis`
--

CREATE TABLE IF NOT EXISTS `auto_model_year_chassis` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tire`
--

CREATE TABLE IF NOT EXISTS `tire` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_class_id` int(11) unsigned NOT NULL,
  `section_width_id` int(11) unsigned DEFAULT NULL,
  `aspect_ratio_id` int(11) unsigned DEFAULT NULL,
  `rim_diameter_id` int(11) unsigned DEFAULT NULL,
  `load_index_id` int(11) unsigned DEFAULT NULL,
  `speed_index_id` int(11) unsigned DEFAULT NULL,
  `is_runflat` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_class_id` (`vehicle_class_id`),
  KEY `section_width_id` (`section_width_id`),
  KEY `aspect_ratio_id` (`aspect_ratio_id`),
  KEY `rim_diameter_id` (`rim_diameter_id`),
  KEY `load_index_id` (`load_index_id`),
  KEY `speed_index_id` (`speed_index_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=638 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tire_aspect_ratio`
--

CREATE TABLE IF NOT EXISTS `tire_aspect_ratio` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` smallint(3) unsigned NOT NULL,
  `rank` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tire_load_index`
--

CREATE TABLE IF NOT EXISTS `tire_load_index` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `index` int(11) unsigned NOT NULL,
  `pounds` int(11) unsigned NOT NULL,
  `kilograms` int(11) unsigned NOT NULL,
  `rank` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tire_rim_diameter`
--

CREATE TABLE IF NOT EXISTS `tire_rim_diameter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` smallint(3) unsigned NOT NULL,
  `rank` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tire_section_width`
--

CREATE TABLE IF NOT EXISTS `tire_section_width` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` smallint(3) unsigned NOT NULL,
  `rank` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tire_speed_index`
--

CREATE TABLE IF NOT EXISTS `tire_speed_index` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `mph` varchar(255) NOT NULL,
  `kmh` varchar(255) NOT NULL,
  `rank` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tire_type`
--

CREATE TABLE IF NOT EXISTS `tire_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  `rank` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tire_vehicle_class`
--

CREATE TABLE IF NOT EXISTS `tire_vehicle_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `rank` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tire`
--

ALTER TABLE `tire`
  ADD CONSTRAINT `tire_ibfk_2` FOREIGN KEY (`section_width_id`) REFERENCES `tire_section_width` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tire_ibfk_3` FOREIGN KEY (`aspect_ratio_id`) REFERENCES `tire_aspect_ratio` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tire_ibfk_4` FOREIGN KEY (`rim_diameter_id`) REFERENCES `tire_rim_diameter` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tire_ibfk_5` FOREIGN KEY (`load_index_id`) REFERENCES `tire_load_index` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tire_ibfk_6` FOREIGN KEY (`speed_index_id`) REFERENCES `tire_speed_index` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tire_ibfk_7` FOREIGN KEY (`vehicle_class_id`) REFERENCES `tire_vehicle_class` (`id`) ON DELETE CASCADE;
  
  
--
-- Дамп данных таблицы `access`
--

INSERT INTO `access` (`id`, `parent_id`, `level`, `alias`, `title`) VALUES
(43, NULL, 0, 'tire', 'Tire'),
(44, 43, 1, 'tire.create', 'Create'),
(45, 43, 1, 'tire.delete', 'Delete'),
(46, 43, 1, 'tire.update', 'Update'),
(47, 43, 1, 'tire.aspect_ratio', 'Aspect Ratio'),
(48, 47, 2, 'tire.aspect_ratio.create', 'Create'),
(49, 47, 2, 'tire.aspect_ratio.delete', 'Delete'),
(50, 47, 2, 'tire.aspect_ratio.update', 'Update'),
(51, 43, 1, 'tire.load_index', 'Load Index'),
(52, 51, 2, 'tire.load_index.create', 'Create'),
(53, 51, 2, 'tire.load_index.delete', 'Delete'),
(54, 51, 2, 'tire.load_index.update', 'Update'),
(55, 43, 1, 'tire.rim_diameter', 'Rim Diameter'),
(56, 55, 2, 'tire.rim_diameter.create', 'Create'),
(57, 55, 2, 'tire.rim_diameter.delete', 'Delete'),
(58, 55, 2, 'tire.rim_diameter.update', 'Update'),
(59, 43, 1, 'tire.section_width', 'Section Width'),
(60, 59, 2, 'tire.section_width.create', 'Create'),
(61, 59, 2, 'tire.section_width.delete', 'Delete'),
(62, 59, 2, 'tire.section_width.update', 'Update'),
(63, 43, 1, 'tire.speed_index', 'Speed Index'),
(64, 63, 2, 'tire.speed_index.create', 'Create'),
(65, 63, 2, 'tire.speed_index.delete', 'Delete'),
(66, 63, 2, 'tire.speed_index.update', 'Update'),
(67, 43, 1, 'tire.type', 'Type'),
(68, 67, 2, 'tire.type.create', 'Create'),
(69, 67, 2, 'tire.type.delete', 'Delete'),
(70, 67, 2, 'tire.type.update', 'Update'),
(71, 43, 1, 'tire.vehicle_class', 'Vehicle Class'),
(72, 71, 2, 'tire.vehicle_class.create', 'Create'),
(73, 71, 2, 'tire.vehicle_class.delete', 'Delete'),
(74, 71, 2, 'tire.vehicle_class.update', 'Update'),
(75, 21, 1, 'modelYear.chassis', 'Chassis'),
(76, 75, 2, 'modelYear.chassis.create', 'Create'),
(77, 75, 2, 'modelYear.chassis.delete', 'Delete'),
(78, 75, 2, 'modelYear.chassis.update', 'Update');


--
-- Дамп данных таблицы `tire_vehicle_class`
--

INSERT INTO `tire_vehicle_class` (`id`, `code`, `title`, `rank`) VALUES
(1, 'P', 'Passenger Vehicle', 0),
(2, 'LT', 'Light Truck', 0),
(3, 'C', 'Commercial Vehicle', 0);
  
