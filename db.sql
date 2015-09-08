ALTER TABLE  `project` DROP  `rear_tire_vehicle_class_id` ;
ALTER TABLE  `project` 
ADD  `rear_wheel_manufacturer` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
ADD  `rear_wheel_model` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
ADD  `rear_tire_manufacturer` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
ADD  `rear_tire_model` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;