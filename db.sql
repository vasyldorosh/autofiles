ALTER TABLE  `project` ADD  `view_count` INT( 11 ) UNSIGNED NOT NULL;
ALTER TABLE  `project` ADD  `tire_vehicle_class_id` INT( 11 ) UNSIGNED NOT NULL DEFAULT  '1',
ADD  `rear_tire_vehicle_class_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL ,
ADD INDEX (  `tire_vehicle_class_id` ,  `rear_tire_vehicle_class_id` ) ;
UPDATE  `auto`.`project` SET  `rear_tire_vehicle_class_id` =  '1' WHERE 1;