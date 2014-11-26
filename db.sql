SELECT id, specs_front_tires, specs_tires__rear FROM `auto_completion` WHERE specs_tires__rear IS NOT NULL;
SELECT DISTINCT specs_tires__rear FROM `auto_completion` WHERE specs_tires__rear IS NOT NULL;


ALTER TABLE  `tire` ADD  `rear_section_width_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `rear_aspect_ratio_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD  `rear_rim_diameter_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE  `tire` ADD  `is_rear` TINYINT( 1 ) UNSIGNED NOT NULL AFTER  `is_runflat`;