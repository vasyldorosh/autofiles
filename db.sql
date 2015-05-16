INSERT INTO `access` (`id`, `parent_id`, `level`, `alias`, `title`) VALUES
(99, 21, 1, 'modelYear.platform', 'Platform'),
(100, 99, 2, 'modelYear.platform.create', 'Create'),
(101, 99, 2, 'modelYear.platform.delete', 'Delete'),
(102, 99, 2, 'modelYear.platform.update', 'Update'),
(103, 21, 1, 'modelYear.platformCategory', 'Platform Category'),
(104, 103, 2, 'modelYear.platformCategory.create', 'Create'),
(105, 103, 2, 'modelYear.platformCategory.delete', 'Delete'),
(106, 103, 2, 'modelYear.platformCategory.update', 'Update');

ALTER TABLE `auto_model_year`  ADD `platform_id` INT(11) UNSIGNED NULL DEFAULT NULL;
CREATE TABLE IF NOT EXISTS `platform` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `model_id` int(11) unsigned NOT NULL,
  `year_from` smallint(4) unsigned NOT NULL,
  `year_to` smallint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Структура таблиці `platform_category`
--

CREATE TABLE IF NOT EXISTS `platform_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
