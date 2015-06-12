<?php

class Project extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BodyStyle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('make_id, model_id', 'required'),
			array('description, model_year_id, id, model_year_id, wheel_manufacturer, wheel_model, rim_diameter_id, rim_width_id, rim_offset_range_id, is_staggered_wheels, rear_rim_diameter_id, rear_rim_width_id, rear_rim_offset_range_id, tire_manufacturer, tire_model, tire_section_width_id, tire_aspect_ratio_id, is_staggered_tires, rear_tire_section_width_id, rear_tire_aspect_ratio_id, description, source', 'safe',),	
		);
	}
		
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'						=> 'ID',
			'make_id' 					=> 'Make',
			'model_id' 					=> 'Model',
			'model_year_id' 			=> 'Model Year',
			'wheel_manufacturer' 		=> 'Wheel Manufacturer',
			'wheel_model' 				=> 'Wheel Model',
			'rim_diameter_id' 			=> 'Rim Diameter',
			'rim_width_id' 				=> 'Rim Width',
			'rim_offset_range_id' 		=> 'Rim Offset Range',
			'is_staggered_wheels' 		=> 'Staggered Wheels',
			'rear_rim_diameter_id' 		=> 'Rear Rim Diameter',
			'rear_rim_width_id' 		=> 'Rear Rim Width',
			'rear_rim_offset_range_id' 	=> 'Rear Rim Offset Range',
			'tire_manufacturer' 		=> 'Tire Manufacturer',
			'tire_model'				=> 'Tire Model',			
			'tire_section_width_id' 	=> 'Tire Section Width',			
			'tire_aspect_ratio_id' 		=> 'Tire Aspect Ratio',			
			'is_staggered_tires' 		=> 'Staggered Tires',			
			'rear_tire_section_width_id'=> 'Rear Tire Section Width',			
			'rear_tire_aspect_ratio_id' => 'Rear Tire Aspect Ratio',				
			'description' 				=> 'Description',				
			'source' 					=> 'Source',				
		);
			
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'galleryPhotos' 		=> array(self::HAS_MANY, 'ProjectPhoto', 'project_id', 'order' => '`rank` ASC',),
            'Make' 					=> array(self::BELONGS_TO, 'AutoMake', 'make_id', 'together'=>true,),
            'Model' 				=> array(self::BELONGS_TO, 'AutoModel', 'model_id', 'together'=>true,),
            'ModelYear' 			=> array(self::BELONGS_TO, 'AutoModelYear', 'model_year_id', 'together'=>true,),
            'TireRimDiameter' 		=> array(self::BELONGS_TO, 'TireRimDiameter', 'rim_diameter_id', 'together'=>true,),
            'RimWidth' 				=> array(self::BELONGS_TO, 'RimWidth', 'rim_width_id', 'together'=>true,),
            'RimOffsetRange' 		=> array(self::BELONGS_TO, 'RimOffsetRange', 'rim_offset_range_id', 'together'=>true,),
            'RearTireRimDiameter'	=> array(self::BELONGS_TO, 'TireRimDiameter', 'rear_rim_diameter_id', 'together'=>true,),
            'RearRimWidth' 			=> array(self::BELONGS_TO, 'RimWidth', 'rear_rim_width_id', 'together'=>true,),
            'RearRimOffsetRange' 	=> array(self::BELONGS_TO, 'RimOffsetRange', 'rear_rim_offset_range_id', 'together'=>true,),
            'TireSectionWidth' 		=> array(self::BELONGS_TO, 'TireSectionWidth', 'tire_section_width_id', 'together'=>true,),
            'TireAspectRatio' 		=> array(self::BELONGS_TO, 'TireAspectRatio', 'tire_aspect_ratio_id', 'together'=>true,),
        );
	}	
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.make_id',$this->make_id);
		$criteria->compare('t.model_id',$this->model_id);
		$criteria->compare('ModelYear.year',$this->model_year_id);
		$criteria->compare('t.rim_diameter_id',$this->rim_diameter_id);
		$criteria->compare('t.rim_width_id',$this->rim_width_id);
		$criteria->compare('t.rim_offset_range_id',$this->rim_offset_range_id);
		$criteria->compare('t.is_staggered_wheels',$this->is_staggered_wheels);
		$criteria->compare('t.tire_section_width_id',$this->tire_section_width_id);
		$criteria->compare('t.tire_aspect_ratio_id',$this->tire_aspect_ratio_id);
		$criteria->compare('t.is_staggered_tires',$this->is_staggered_tires);
		$criteria->compare('t.wheel_manufacturer',$this->wheel_manufacturer, true);
		$criteria->compare('t.wheel_model',$this->wheel_model, true);
		$criteria->compare('t.tire_model',$this->tire_model, true);
		$criteria->compare('t.tire_manufacturer',$this->tire_manufacturer, true);

		$criteria->with = array(
			'Make' 					=> array('together'=>true,),
			'Model' 				=> array('together'=>true,),
			'ModelYear' 			=> array('together'=>true,),
			'TireRimDiameter' 		=> array('together'=>true,),
			'RimWidth' 				=> array('together'=>true,),
			'RimOffsetRange' 		=> array('together'=>true,),
			'TireSectionWidth' 		=> array('together'=>true,),
			'TireAspectRatio' 		=> array('together'=>true,),
		);	
	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
			),			
		));
	}
	
	
}