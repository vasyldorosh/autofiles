ALTER TABLE  `tire` ADD  `rear_section_width_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `rear_aspect_ratio_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `rear_rim_diameter_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE  `tire` ADD  `is_rear` TINYINT( 1 ) UNSIGNED NOT NULL AFTER  `is_runflat`;

--
-- Структура таблицы `tire_rim_width`
--

CREATE TABLE IF NOT EXISTS `tire_rim_width` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rim_width` decimal(3,1) unsigned NOT NULL,
  `min_width` tinyint(3) unsigned NOT NULL,
  `opt_width` tinyint(3) unsigned NOT NULL,
  `max_width` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17;

--
-- Дамп данных таблицы `tire_rim_width`
--

INSERT INTO `tire_rim_width` (`id`, `rim_width`, `min_width`, `opt_width`, `max_width`) VALUES
(1, '5.0', 165, 175, 185),
(2, '5.5', 175, 185, 195),
(3, '6.0', 185, 195, 205),
(4, '6.5', 195, 205, 215),
(5, '7.0', 205, 215, 225),
(6, '7.5', 215, 225, 235),
(7, '8.0', 225, 235, 245),
(8, '8.5', 235, 245, 255),
(9, '9.0', 245, 255, 255),
(10, '9.5', 255, 255, 255),
(11, '10.0', 255, 255, 255),
(12, '10.5', 255, 255, 255),
(13, '11.0', 255, 255, 255),
(14, '11.5', 255, 255, 255),
(15, '12.0', 255, 255, 255),
(16, '12.5', 255, 255, 255);
