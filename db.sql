INSERT INTO `access` (`id`, `parent_id`, `level`, `alias`, `title`) VALUES
(79, 43, 1, 'tire.rim.width', 'Rim Width'),
(80, 79, 2, 'tire.rim.width.create', 'Create'),
(81, 79, 2, 'tire.rim.width.delete', 'Delete'),
(82, 79, 2, 'tire.rim.width.update', 'Update'),
(83, 43, 1, 'tire.rim.bolt_pattern', 'Rim Bolt pattern'),
(84, 83, 2, 'tire.rim.bolt_pattern.create', 'Create'),
(85, 83, 2, 'tire.rim.bolt_pattern.delete', 'Delete'),
(86, 83, 2, 'tire.rim.bolt_pattern.update', 'Update'),
(87, 43, 1, 'tire.rim.thread_size', 'Rim Thread Size'),
(88, 87, 2, 'tire.rim.thread_size.create', 'Create'),
(89, 87, 2, 'tire.rim.thread_size.delete', 'Delete'),
(90, 87, 2, 'tire.rim.thread_size.update', 'Update'),
(91, 43, 1, 'tire.rim.center_bore', 'Rim Center Bore'),
(92, 91, 2, 'tire.rim.center_bore.create', 'Create'),
(93, 91, 2, 'tire.rim.center_bore.delete', 'Delete'),
(94, 91, 2, 'tire.rim.center_bore.update', 'Update'),
(95, 43, 1, 'tire.rim.offset_range', 'Rim Offset Range'),
(96, 95, 2, 'tire.rim.offset_range.create', 'Create'),
(97, 95, 2, 'tire.rim.offset_range.delete', 'Delete'),
(98, 95, 2, 'tire.rim.offset_range.update', 'Update');


--
-- Структура таблиці `rim_bolt_pattern`
--

CREATE TABLE IF NOT EXISTS `rim_bolt_pattern` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблиці `rim_center_bore`
--

CREATE TABLE IF NOT EXISTS `rim_center_bore` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` decimal(3,1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблиці `rim_offset_range`
--

CREATE TABLE IF NOT EXISTS `rim_offset_range` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблиці `rim_thread_size`
--

CREATE TABLE IF NOT EXISTS `rim_thread_size` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблиці `rim_width`
--

CREATE TABLE IF NOT EXISTS `rim_width` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `value` decimal(3,1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;



ALTER TABLE  `auto_model_year` ADD  `tire_rim_diameter_from_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `rim_width_from_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `tire_rim_diameter_to_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `rim_width_to_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `offset_range_from_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `offset_range_to_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `bolt_pattern_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `thread_size_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `center_bore_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ;

