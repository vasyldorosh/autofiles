ALTER TABLE `project`  ADD `user_id` INT(11) UNSIGNED NULL DEFAULT NULL;
CREATE TABLE IF NOT EXISTS `project_stat_user` (
  `date` date NOT NULL,
  `total` int(11) unsigned NOT NULL,
  `total_day` int(11) unsigned NOT NULL,
  `total_month` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`date`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
