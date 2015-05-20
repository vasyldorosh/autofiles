ALTER TABLE  `platform` DROP  `model_id`;

CREATE TABLE IF NOT EXISTS `platform_vs_model` (
  `platform_id` int(11) unsigned NOT NULL,
  `model_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`platform_id`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `platform_vs_model` ADD FOREIGN KEY (  `platform_id` ) REFERENCES  `platform` (
`id`
) ON DELETE CASCADE ON UPDATE RESTRICT ;

ALTER TABLE  `platform_vs_model` ADD FOREIGN KEY (  `model_id` ) REFERENCES  `auto_model` (
`id`
) ON DELETE CASCADE ON UPDATE RESTRICT ;