<?php

class Tire extends CActiveRecord
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
		return 'tire';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_class_id', 'required'),
			array('is_rear, rear_section_width_id, rear_aspect_ratio_id, rear_rim_diameter_id, is_runflat, vehicle_class_id, section_width_id, aspect_ratio_id, rim_diameter_id, load_index_id', 'numerical', 'integerOnly' => true),
			array('id', 'safe', 'on' => 'search'),
		);
	}		

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'SectionWidth' => array(self::BELONGS_TO, 'TireSectionWidth', 'section_width_id', 'together'=>true,), //value
            'AspectRatio' => array(self::BELONGS_TO, 'TireAspectRatio', 'aspect_ratio_id', 'together'=>true,), //value
            'RimDiameter' => array(self::BELONGS_TO, 'TireRimDiameter', 'rim_diameter_id', 'together'=>true,), //value        
            'LoadIndex' => array(self::BELONGS_TO, 'TireLoadIndex', 'load_index_id', 'together'=>true,), //index
            'Type' => array(self::BELONGS_TO, 'TireType', 'type_id', 'together'=>true,), //value
			'VehicleClass' => array(self::BELONGS_TO, 'TireVehicleClass', 'vehicle_class_id', 'together'=>true,), //title
            'RearSectionWidth' => array(self::BELONGS_TO, 'TireSectionWidth', 'rear_section_width_id', 'together'=>true,), //value
            'RearAspectRatio' => array(self::BELONGS_TO, 'TireAspectRatio', 'rear_aspect_ratio_id', 'together'=>true,), //value
            'RearRimDiameter' => array(self::BELONGS_TO, 'TireRimDiameter', 'rear_rim_diameter_id', 'together'=>true,), //value        

		);
	}	
	
	public function beforeSave()
	{
		foreach (array('section_width_id', 'aspect_ratio_id', 'rim_diameter_id', 'load_index_id') as $attribute) {
			if (empty($this->$attribute)) {
				$this->$attribute = null;
			}
		}
		
		if (!$this->is_rear) {
			$this->rear_section_width_id = null;
			$this->rear_aspect_ratio_id = null;
			$this->rear_rim_diameter_id = null;
		}
		
		return parent::beforeSave();
	}	
	
	public function afterSave()
	{
		$this->clearCache();
		
		return parent::afterSave();
	}	
	
	public function afterDelete()
	{
		return parent::afterDelete();
	}	
	
	private function clearCache()
	{
		Yii::app()->cache->clear(Tags::TAG_TIRE);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vehicle_class_id' => 'Vehicle Class',
			'section_width_id' => 'Section Width',
			'aspect_ratio_id' => 'Aspect Ratio',
			'rim_diameter_id' => 'Rim Diameter',
			'load_index_id' => 'Load Index',
			'is_runflat' => 'Runflat',
			'is_rear' => 'Is rear',
			'rear_section_width_id' => 'Rear Section Width',
			'rear_aspect_ratio_id' => 'Rear Aspect Ratio',
			'rear_rim_diameter_id' => 'Rear Rim Diameter',			
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
		$criteria->compare('t.vehicle_class_id',$this->vehicle_class_id);
		$criteria->compare('t.section_width_id',$this->section_width_id);
		$criteria->compare('t.aspect_ratio_id',$this->aspect_ratio_id);
		$criteria->compare('t.rim_diameter_id',$this->rim_diameter_id);
		$criteria->compare('t.load_index_id',$this->load_index_id);
		$criteria->compare('t.is_runflat',$this->is_runflat);	
		$criteria->compare('t.is_rear',$this->is_rear);	
		$criteria->compare('t.rear_section_width_id',$this->rear_section_width_id);
		$criteria->compare('t.rear_aspect_ratio_id',$this->rear_aspect_ratio_id);
		$criteria->compare('t.rear_rim_diameter_id',$this->rear_rim_diameter_id);
		
		$criteria->with = array(
			'VehicleClass', 
			'SectionWidth', 
			'AspectRatio', 
			'RimDiameter', 
			'LoadIndex',
			'RearRimDiameter',
			'RearAspectRatio',
			'RearSectionWidth',
		);	
		
		$sort = array(
			'vehicle_class_id' => 'VehicleClass.code',
			'vehicle_class_id.desc' => 'VehicleClass.code DESC',
			'section_width_id' => 'SectionWidth.value',
			'section_width_id.desc' => 'SectionWidth.value DESC',
			'aspect_ratio_id' => 'AspectRatio.value',
			'aspect_ratio_id.desc' => 'AspectRatio.value DESC',
			'rim_diameter_id' => 'RimDiameter.value',
			'rim_diameter_id.desc' => 'RimDiameter.value DESC',
			'load_index_id' => 'LoadIndex.index',
			'load_index_id.desc' => 'LoadIndex.index DESC',
			'rear_section_width_id' => 'RearSectionWidth.value',
			'rear_section_width_id.desc' => 'RearSectionWidth.value DESC',
			'rear_aspect_ratio_id' => 'RearAspectRatio.value',
			'rear_aspect_ratio_id.desc' => 'RearAspectRatio.value DESC',			
			'rear_rim_diameter_id' => 'RearRimDiameter.value',
			'rear_rim_diameter_id.desc' => 'RearRimDiameter.value DESC',		
		);
		
		if (isset($_GET['Tire_sort']) && isset($sort[$_GET['Tire_sort']])) {
			$criteria->order = $sort[$_GET['Tire_sort']];	
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
			),			
		));
	}
	
	public function getList()
	{
		$key = Tags::TAG_TIRE . '_getList';
		$data = Yii::app()->cache->get($key);
		if ($data === false) {
			$data = array();
			
			$criteria=new CDbCriteria;
			$criteria->with = array('SectionWidth', 'AspectRatio', 'RimDiameter', 'RearSectionWidth', 'RearAspectRatio', 'RearRimDiameter');			
			$criteria->order = 'SectionWidth.value, AspectRatio.value, RimDiameter.value';			
			$items = Tire::model()->findAll($criteria);
			foreach ($items as $item) {
				if (!empty($item->SectionWidth) && !empty($item->AspectRatio) && !empty($item->RimDiameter)) {
					$value = $item->SectionWidth->value . '/' . $item->AspectRatio->value . ' R' . $item->RimDiameter->value;
					if ($item->is_rear) {
						$value .= ' ' .$item->RearSectionWidth->value . '/' . $item->RearAspectRatio->value . ' R' . $item->RearRimDiameter->value;
					}
					
					$data[$item->id] = $value;
				}
			}
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_TIRE, Tags::TAG_TIRE_SECTION_WIDTH, Tags::TAG_TIRE_ASPECT_RATIO, Tags::TAG_TIRE_RIM_DIAMETER));
		}
		
		return $data;
	}
	
}