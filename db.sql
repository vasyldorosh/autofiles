ALTER TABLE  `auto_completion` ADD  `url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `auto_specs` CHANGE  `group_id`  `group_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;