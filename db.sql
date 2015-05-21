DROP TABLE  `platform_vs_model`;

CREATE TABLE IF NOT EXISTS `platform_model` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `platform_id` int(11) unsigned NOT NULL,
  `model_id` int(11) unsigned NOT NULL,
  `year_from` mediumint(4) unsigned NOT NULL,
  `year_to` mediumint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


ALTER TABLE  `auto_model_year` CHANGE  `platform_id`  `platform_model_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ;
