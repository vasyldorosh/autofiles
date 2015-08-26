<?php

class Project extends CActiveRecord
{
	public $is_active = 1;
	
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
			array('is_active', 'numerical', 'integerOnly' => true),
			array('tire_vehicle_class_id, rear_tire_vehicle_class_id, description, model_year_id, id, model_year_id, wheel_manufacturer, wheel_model, rim_diameter_id, rim_width_id, rim_offset_range_id, is_staggered_wheels, rear_rim_diameter_id, rear_rim_width_id, rear_rim_offset_range_id, tire_manufacturer, tire_model, tire_section_width_id, tire_aspect_ratio_id, is_staggered_tires, rear_tire_section_width_id, rear_tire_aspect_ratio_id, description, source, view_count', 'safe',),	
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
			'view_count' 				=> 'View count',				
			'tire_vehicle_class_id' 	=> 'Tire Vehicle Class',				
			'rear_tire_vehicle_class_id'=> 'Rear Tire Vehicle Class',
			'is_active' 				=> Yii::t('admin', 'Published'),
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
            'TireVehicleClass' 		=> array(self::BELONGS_TO, 'TireVehicleClass', 'tire_vehicle_class_id', 'together'=>true,),
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
		$criteria->compare('t.view_count',$this->view_count);
		$criteria->compare('t.tire_vehicle_class_id',$this->tire_vehicle_class_id);
		$criteria->compare('t.is_active',$this->is_active);

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
			'sort' => array('defaultOrder' => 't.id DESC',),
		));
	}
	
	public static function getFastest($limit=10)
	{
		$key = Tags::TAG_PROJECT . '__FASTEST__' . $limit;
		$data = Yii::app()->cache->get($key);
		
		if ($data === false) {
			$sql = "SELECT 
						p.id AS id,
						p.view_count AS view_count,
						p.wheel_manufacturer AS wheel_manufacturer,
						p.wheel_model AS wheel_model,
						rd.value AS rim_diameter,
						rw.value AS rim_width,
						ror.value AS rim_offset_range,
						p.is_staggered_wheels AS is_staggered_wheels,
						r_rd.value AS rear_rim_diameter,
						r_rw.value AS rear_rim_width,
						r_ror.value AS rear_rim_offset_range,						
						tsw.value AS tire_section_width,						
						tar.value AS tire_aspect_ratio,						
						p.is_staggered_tires AS is_staggered_tires,
						r_tsw.value AS rear_tire_section_width,						
						r_tar.value AS rear_tire_aspect_ratio,						
						tvc.code AS tire_vehicle_class,						
						r_tvc.code AS rear_tire_vehicle_class,						
						y.year AS year,
						y.id AS year_id,
						m.title AS model_title,
						m.alias AS model_alias,
						k.title AS make_title,
						k.alias AS make_alias
					FROM project AS p
					LEFT JOIN auto_model_year AS y ON p.model_year_id = y.id
					LEFT JOIN auto_model AS m ON y.model_id = m.id
					LEFT JOIN auto_make AS k ON m.make_id = k.id
					LEFT JOIN tire_rim_diameter AS rd ON p.rim_diameter_id = rd.id
					LEFT JOIN rim_width AS rw ON p.rim_width_id = rw.id
					LEFT JOIN rim_offset_range AS ror ON p.rim_offset_range_id = ror.id
					LEFT JOIN tire_rim_diameter AS r_rd ON p.rear_rim_diameter_id = r_rd.id
					LEFT JOIN rim_width AS r_rw ON p.rear_rim_width_id = r_rw.id
					LEFT JOIN rim_offset_range AS r_ror ON p.rear_rim_offset_range_id = r_ror.id
					LEFT JOIN tire_section_width AS tsw ON p.tire_section_width_id = tsw.id
					LEFT JOIN tire_aspect_ratio AS tar ON p.tire_aspect_ratio_id = tar.id
					LEFT JOIN tire_section_width AS r_tsw ON p.rear_tire_section_width_id = r_tsw.id
					LEFT JOIN tire_aspect_ratio AS r_tar ON p.rear_tire_aspect_ratio_id = r_tar.id
					LEFT JOIN tire_vehicle_class AS r_tvc ON p.rear_tire_vehicle_class_id = r_tvc.id
					LEFT JOIN tire_vehicle_class AS tvc ON p.tire_vehicle_class_id = tvc.id
					WHERE 
						m.is_active = 1 AND
						m.is_deleted = 0 AND
						k.is_active = 1 AND
						k.is_deleted = 0 AND p.is_active = 1									
					ORDER BY p.view_count DESC
					LIMIT {$limit}";
	
			$rows = Yii::app()->db->createCommand($sql)->queryAll();
			
			$data = array();

			foreach ($rows as $row) {
				$row['photo'] = Project::thumb($row['id'], 120, null, 'resize');
				$data[] = $row;
			}
			
			Yii::app()->cache->set($key, $data, 60*15, new Tags(Tags::TAG_PROJECT, Tags::TAG_MAKE, Tags::TAG_MODEL));
		}
		
		return $data;		
	}	
	
	public static function getNew($limit=30)
	{
		$key = Tags::TAG_PROJECT . '_getNew_' . $limit;
		$data = Yii::app()->cache->get($key);
		
		if ($data === false) {
			$sql = "SELECT 
						p.id AS id,
						p.view_count AS view_count,
						p.wheel_manufacturer AS wheel_manufacturer,
						p.wheel_model AS wheel_model,
						rd.value AS rim_diameter,
						rw.value AS rim_width,
						ror.value AS rim_offset_range,
						p.is_staggered_wheels AS is_staggered_wheels,
						r_rd.value AS rear_rim_diameter,
						r_rw.value AS rear_rim_width,
						r_ror.value AS rear_rim_offset_range,						
						tsw.value AS tire_section_width,						
						tar.value AS tire_aspect_ratio,						
						p.is_staggered_tires AS is_staggered_tires,
						r_tsw.value AS rear_tire_section_width,						
						r_tar.value AS rear_tire_aspect_ratio,						
						tvc.code AS tire_vehicle_class,						
						r_tvc.code AS rear_tire_vehicle_class,						
						y.year AS year,
						y.id AS year_id,
						m.title AS model_title,
						m.alias AS model_alias,
						k.title AS make_title,
						k.alias AS make_alias
					FROM project AS p
					LEFT JOIN auto_model_year AS y ON p.model_year_id = y.id
					LEFT JOIN auto_model AS m ON y.model_id = m.id
					LEFT JOIN auto_make AS k ON m.make_id = k.id
					LEFT JOIN tire_rim_diameter AS rd ON p.rim_diameter_id = rd.id
					LEFT JOIN rim_width AS rw ON p.rim_width_id = rw.id
					LEFT JOIN rim_offset_range AS ror ON p.rim_offset_range_id = ror.id
					LEFT JOIN tire_rim_diameter AS r_rd ON p.rear_rim_diameter_id = r_rd.id
					LEFT JOIN rim_width AS r_rw ON p.rear_rim_width_id = r_rw.id
					LEFT JOIN rim_offset_range AS r_ror ON p.rear_rim_offset_range_id = r_ror.id
					LEFT JOIN tire_section_width AS tsw ON p.tire_section_width_id = tsw.id
					LEFT JOIN tire_aspect_ratio AS tar ON p.tire_aspect_ratio_id = tar.id
					LEFT JOIN tire_section_width AS r_tsw ON p.rear_tire_section_width_id = r_tsw.id
					LEFT JOIN tire_aspect_ratio AS r_tar ON p.rear_tire_aspect_ratio_id = r_tar.id
					LEFT JOIN tire_vehicle_class AS r_tvc ON p.rear_tire_vehicle_class_id = r_tvc.id
					LEFT JOIN tire_vehicle_class AS tvc ON p.tire_vehicle_class_id = tvc.id
					WHERE 
						m.is_active = 1 AND
						m.is_deleted = 0 AND
						k.is_active = 1 AND
						k.is_deleted = 0 AND p.is_active = 1									
					ORDER BY p.id DESC
					LIMIT {$limit}";
	
			$rows = Yii::app()->db->createCommand($sql)->queryAll();
			
			$data = array();

			foreach ($rows as $row) {
				$row['photo'] = Project::thumb($row['id'], 120, null, 'resize');
				$data[] = $row;
			}
			
			Yii::app()->cache->set($key, $data, 60*15, new Tags(Tags::TAG_PROJECT, Tags::TAG_MAKE, Tags::TAG_MODEL));
		}
		
		return $data;		
	}	
	
	public static function getById($make_id, $model_id, $id)
	{
		$id		= (int) $id;
		$make_id= (int) $make_id;
		$model_id= (int) $model_id;
		$key 	= Tags::TAG_PROJECT . '_getById_' . $make_id . '__' . $model_id . '_'. $id;
		$data 	= Yii::app()->cache->get($key);
		
		if ($data === false) {
			$sql = "SELECT 
						p.id AS id,
						p.source AS source,
						p.view_count AS view_count,
						p.description AS description,
						p.tire_model AS tire_model,
						p.tire_manufacturer AS tire_manufacturer,
						p.wheel_manufacturer AS wheel_manufacturer,
						p.wheel_model AS wheel_model,
						rd.value AS rim_diameter,
						rw.value AS rim_width,
						ror.value AS rim_offset_range,
						p.is_staggered_wheels AS is_staggered_wheels,
						r_rd.value AS rear_rim_diameter,
						r_rw.value AS rear_rim_width,
						r_ror.value AS rear_rim_offset_range,						
						tsw.value AS tire_section_width,						
						tar.value AS tire_aspect_ratio,	
						tvc.code AS tire_vehicle_class,						
						r_tvc.code AS rear_tire_vehicle_class,							
						p.is_staggered_tires AS is_staggered_tires,
						r_tsw.value AS rear_tire_section_width,						
						r_tar.value AS rear_tire_aspect_ratio,						
						y.year AS year,
						y.id AS year_id,
						m.title AS model_title,
						m.alias AS model_alias,
						k.title AS make_title,
						k.alias AS make_alias
					FROM project AS p
					LEFT JOIN auto_model_year AS y ON p.model_year_id = y.id
					LEFT JOIN auto_model AS m ON p.model_id = m.id
					LEFT JOIN auto_make AS k ON m.make_id = k.id
					LEFT JOIN tire_rim_diameter AS rd ON p.rim_diameter_id = rd.id
					LEFT JOIN rim_width AS rw ON p.rim_width_id = rw.id
					LEFT JOIN rim_offset_range AS ror ON p.rim_offset_range_id = ror.id
					LEFT JOIN tire_rim_diameter AS r_rd ON p.rear_rim_diameter_id = r_rd.id
					LEFT JOIN rim_width AS r_rw ON p.rear_rim_width_id = r_rw.id
					LEFT JOIN rim_offset_range AS r_ror ON p.rear_rim_offset_range_id = r_ror.id
					LEFT JOIN tire_section_width AS tsw ON p.tire_section_width_id = tsw.id
					LEFT JOIN tire_aspect_ratio AS tar ON p.tire_aspect_ratio_id = tar.id
					LEFT JOIN tire_section_width AS r_tsw ON p.rear_tire_section_width_id = r_tsw.id
					LEFT JOIN tire_aspect_ratio AS r_tar ON p.rear_tire_aspect_ratio_id = r_tar.id
					LEFT JOIN tire_vehicle_class AS r_tvc ON p.rear_tire_vehicle_class_id = r_tvc.id
					LEFT JOIN tire_vehicle_class AS tvc ON p.tire_vehicle_class_id = tvc.id					
					WHERE p.id = {$id} AND m.id={$model_id} AND k.id={$make_id} AND p.is_active = 1";
	
			$data = Yii::app()->db->createCommand($sql)->queryRow();

			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_PROJECT));
		}
		
		return $data;		
	}	
	
	public static function thumb($id, $width, $height, $mode)
	{
		$id     = (int) $id;
		$key 	= $id . '_' . $width . '_' . $height . '_' . $mode;
		$image 	= Yii::app()->cache->get($key);
		
		if ($image === false) {
			$image = '';
			
			$criteria = new CDbCriteria;
			$criteria->compare('project_id', $id);
			$criteria->order = 'rank';
			$photo = ProjectPhoto::model()->find($criteria);
			
			if (!empty($photo)) {
				$image = $photo->getThumb($width, $height, $mode);
				Yii::app()->cache->get($key, $image, 0, new Tags(Tags::TAG_PROJECT_PHOTO . $id));
			}
		}
		
		return $image;
	}
	
	public function beforeSave()
	{	
		if ($this->isNewRecord) {
			$this->create_time = time();
		}
		
		return parent::beforeSave();
	}

	public function afterSave()
	{	
		$this->_clearCache();
		
		return parent::afterSave();
	}

    public function afterDelete() 
	{
		$this->_clearCache();	
			
        return parent::afterDelete();
    }		
	

	private function _clearCache()
	{
		Yii::app()->cache->clear(Tags::TAG_PROJECT);
	}	
	
	public static function getCountByMake($make_id)
	{
		$make_id	= (int) $make_id;
		$key 		= Tags::TAG_PROJECT . '_getCountByMake__' . $make_id;
		$count     	= Yii::app()->cache->get($key);
		
		if ($count === false) {
			$criteria = new CDbCriteria;
			$criteria->compare('t.make_id', $make_id);
			$criteria->compare('Model.is_active', 1);
			$criteria->compare('Model.is_deleted', 0);
			$criteria->compare('t.is_active', 1);
			$criteria->with = array('Model'=>array('together'=>true));
			
			$count = self::model()->count($criteria); 
			
			Yii::app()->cache->get($key, $count, 0, new Tags(Tags::TAG_PROJECT));
		}
		
		return $count;
	}
	
	public static function getCountByModel($model_id)
	{
		$model_id	= (int) $model_id;
		$key 		= Tags::TAG_PROJECT . '_getCountByModel_' . $model_id;
		$count     	= Yii::app()->cache->get($key);
		
		if ($count === false) {
			$criteria = new CDbCriteria;
			$criteria->compare('model_id', $model_id);
			$criteria->compare('is_active', 1);
			$count = self::model()->count($criteria);
			
			Yii::app()->cache->get($key, $count, 0, new Tags(Tags::TAG_PROJECT));
		}
		
		return $count;
	}
	
	public static function getCountByModelYear($model_year_id)
	{
		$model_year_id	= (int) $model_year_id;
		$key 		= Tags::TAG_PROJECT . '_getCountByModelYear_' . $model_year_id;
		$count     	= Yii::app()->cache->get($key);
		
		if ($count === false) {
			$criteria = new CDbCriteria;
			$criteria->compare('model_year_id', $model_year_id);
			$criteria->compare('is_active', 1);
			$count = self::model()->count($criteria);
			
			Yii::app()->cache->get($key, $count, 0, new Tags(Tags::TAG_PROJECT));
		}
		
		return $count;
	}
	
	public static function getMostPopularRimSizesModel($model_id)
	{
		$model_id = (int) $model_id;
		$key	  = Tags::TAG_PROJECT . '_getMostPopularRimSizesModel_' . $model_id;
		$data	  = Yii::app()->cache->get($key);
		
		if ($data === false) {
			$sql = "SELECT 
						p.rim_diameter_id, 
						p.rim_width_id, 
						p.rear_rim_diameter_id, 
						p.rear_rim_width_id, 
						p.is_staggered_wheels AS is_staggered_wheels,
						rd.value AS rim_diameter,
						rw.value AS rim_width,
						r_rd.value AS rear_rim_diameter,
						r_rw.value AS rear_rim_width,
						count(*) AS c 
					FROM `project` AS p
					LEFT JOIN tire_rim_diameter AS rd ON p.rim_diameter_id = rd.id
					LEFT JOIN rim_width AS rw ON p.rim_width_id = rw.id					
					LEFT JOIN tire_rim_diameter AS r_rd ON p.rear_rim_diameter_id = r_rd.id
					LEFT JOIN rim_width AS r_rw ON p.rear_rim_width_id = r_rw.id					
					WHERE p.model_id = {$model_id} AND p.is_active = 1
					GROUP BY p.rim_diameter_id, p.rim_width_id, p.rear_rim_diameter_id, p.rear_rim_width_id 
					ORDER BY c DESC
					LIMIT 3";
				
			$data = Yii::app()->db->createCommand($sql)->queryAll();	
			Yii::app()->cache->get($key, $data, 0, new Tags(Tags::TAG_PROJECT));				
		}
		
		return $data;
	}
	
	public static function getMostPopularTireSizesModel($model_id)
	{
		$model_id = (int) $model_id;
		$key	  = Tags::TAG_PROJECT . '_getMostPopularTireSizesModel_' . $model_id;
		$data	  = Yii::app()->cache->get($key);
		
		if ($data === false) {
			$sql = "SELECT 
						p.rim_diameter_id, 
						p.rear_rim_diameter_id, 
						p.tire_section_width_id, 
						p.rear_tire_section_width_id, 
						p.tire_aspect_ratio_id, 
						p.rear_tire_aspect_ratio_id, 
						p.is_staggered_tires AS is_staggered_tires,
						rd.value AS rim_diameter,
						r_rd.value AS rear_rim_diameter,
						tsw.value AS tire_section_width,	
						tvc.code AS tire_vehicle_class,						
						r_tvc.code AS rear_tire_vehicle_class,							
						r_tsw.value AS rear_tire_section_width,						
						tar.value AS tire_aspect_ratio,						
						r_tar.value AS rear_tire_aspect_ratio,						
						count(*) AS c 
					FROM `project` AS p
					LEFT JOIN tire_rim_diameter AS rd ON p.rim_diameter_id = rd.id
					LEFT JOIN tire_rim_diameter AS r_rd ON p.rear_rim_diameter_id = r_rd.id
					LEFT JOIN tire_section_width AS tsw ON p.tire_section_width_id = tsw.id
					LEFT JOIN tire_aspect_ratio AS tar ON p.tire_aspect_ratio_id = tar.id
					LEFT JOIN tire_section_width AS r_tsw ON p.rear_tire_section_width_id = r_tsw.id
					LEFT JOIN tire_aspect_ratio AS r_tar ON p.rear_tire_aspect_ratio_id = r_tar.id	
					LEFT JOIN tire_vehicle_class AS r_tvc ON p.rear_tire_vehicle_class_id = r_tvc.id
					LEFT JOIN tire_vehicle_class AS tvc ON p.tire_vehicle_class_id = tvc.id					
					WHERE p.model_id = {$model_id} AND p.is_active = 1 AND p.tire_section_width_id IS NOT NULL AND p.tire_aspect_ratio_id IS NOT NULL
					AND p.tire_section_width_id <> 0 AND p.tire_aspect_ratio_id <> 0
					GROUP BY p.tire_vehicle_class_id, p.rear_tire_vehicle_class_id, p.rim_diameter_id, p.rear_rim_diameter_id, tire_section_width_id, rear_tire_section_width_id, tire_aspect_ratio_id, rear_tire_aspect_ratio_id
					ORDER BY c DESC
					LIMIT 3";
			
			$data = Yii::app()->db->createCommand($sql)->queryAll();	
			Yii::app()->cache->get($key, $data, 0, new Tags(Tags::TAG_PROJECT));				
		}
		
		return $data;
	}
	
	public function getUrl()
	{
		if (isset($this->Make) && isset($this->Model)) {
			return "/tuning/{$this->Make->alias}/{$this->Model->alias}/{$this->id}/";
		}
	}
	
	public function getPhotoMostPopularModel($model_id)
	{
		$model_id = (int) $model_id;
		$key	  = Tags::TAG_PROJECT . '__getPhotoMostPopularModel_' . $model_id;
		$photo	  = Yii::app()->cache->get($key);
		
		if ($photo === false) {
			$photo = '';
			
			$criteria = new CDbCriteria;
			$criteria->compare('model_id', $model_id);
			$criteria->order = 'view_count DESC';
			$model = $this->find($criteria);
			
			if (!empty($model)) {
				$photo = self::thumb($model->id, 300, 200, 'resize');
			}
			
			Yii::app()->cache->get($key, $photo, 60*60*24, new Tags(Tags::TAG_PROJECT));				
		}
		
		return $photo;		
	}
	
	public static function getCustomRimSizesRangeByModelYears($model_year_ids)
	{
		$key	  = Tags::TAG_PROJECT . '_getCustomRimSizesRangeByModelYears_' . implode('_', $model_year_ids);
		$data	  = Yii::app()->cache->get($key);
		
		if ($data === false) {
			$data = '';
			
			$sql = "SELECT 
						MIN(rd.value) AS rd_min,
						MAX(rd.value) AS rd_max
					FROM  project AS p
					LEFT JOIN tire_rim_diameter AS rd ON p.rim_diameter_id = rd.id
					WHERE 
						p.is_active = 1 AND 
						p.model_year_id IN (".implode(',', $model_year_ids).") AND
						p.rim_diameter_id IS NOT NULL						 
				";
				
			$row = Yii::app()->db->createCommand($sql)->queryRow();	
			$rd = array();
			if (!empty($row['rd_min'])) {
				$rd[] = $row['rd_min'];
			}
			if (!empty($row['rd_max'])) {
				$rd[] = $row['rd_max'];
			}
			
			$sql = "SELECT 
						MIN(rw.value) AS rw_min,
						MAX(rw.value) AS rw_max
					FROM  project AS p
					LEFT JOIN rim_width AS rw ON p.rim_width_id = rw.id
					WHERE 
						p.is_active = 1 AND 
						p.model_year_id IN (".implode(',', $model_year_ids).") AND
						p.rim_diameter_id IS NOT NULL						 
				";
				
			$row = Yii::app()->db->createCommand($sql)->queryRow();	
			$rw = array();
			if (!empty($row['rw_min'])) {
				$rw[] = $row['rw_min'];
			}
			if (!empty($row['rw_max'])) {
				$rw[] = $row['rw_max'];
			}			
			
			$_arr = array();
			if (!empty($rd)) {
				$_arr[] = implode('x', $rd);
			}
			if (!empty($rw)) {
				$_arr[] = implode('x', $rw);
			}
			
			$data = implode(' &ndash; ', $_arr);
			
			Yii::app()->cache->get($key, $data, 0, new Tags(Tags::TAG_PROJECT));				
		}
		
		return $data;		
	}
	
	public static function getCustomRimSizes($model_year_ids)
	{
		$key	  = Tags::TAG_PROJECT . '_getCustomRimSizes_' . implode('_', $model_year_ids);
		$data	  = Yii::app()->cache->get($key);
		
		if ($data === false || true) {
			$data = '';
			$sql = "SELECT
						count(*) AS c,
						CAST( GROUP_CONCAT(p.id) AS CHAR(10000) CHARACTER SET utf8),
						(SELECT SUM(ror.value)  
							FROM project AS pp
							LEFT JOIN rim_offset_range AS ror ON pp.rim_offset_range_id = ror.id
							WHERE pp.id LIKE CONCAT('%', CAST( GROUP_CONCAT(p.id) AS CHAR(10000) CHARACTER SET utf8), '%') AND pp.rim_offset_range_id IS NOT NULL
						) AS ror_min,			 
						(SELECT MAX(ror.value)  
							FROM project AS pp
							LEFT JOIN rim_offset_range AS ror ON pp.rim_offset_range_id = ror.id
							WHERE pp.id LIKE CONCAT('%', CAST( GROUP_CONCAT(p.id) AS CHAR(10000) CHARACTER SET utf8), '%') AND pp.rim_offset_range_id IS NOT NULL
						) AS ror_max,						
						(SELECT MIN(rear_ror.value)  
							FROM project AS pp
							LEFT JOIN rim_offset_range AS rear_ror ON pp.rear_rim_offset_range_id = rear_ror.id
							WHERE pp.id LIKE CONCAT('%', CAST( GROUP_CONCAT(p.id) AS CHAR(10000) CHARACTER SET utf8), '%')
						) AS rear_ror_min,			 
						(SELECT MAX(rear_ror.value)  
							FROM project AS pp
							LEFT JOIN rim_offset_range AS rear_ror ON pp.rear_rim_offset_range_id = rear_ror.id
							WHERE pp.id LIKE CONCAT('%', CAST( GROUP_CONCAT(p.id) AS CHAR(10000) CHARACTER SET utf8), '%')
						) AS rear_ror_max,						
						p.is_staggered_wheels AS is_staggered,
						rd.value AS rim_diameter, 
						rear_rd.value AS rear_rim_diameter, 
						CAST(rw.value AS DECIMAL(5,2)) AS rim_width,
						CAST(rear_rw.value AS DECIMAL(5,2)) AS rear_rim_width
					FROM project AS p
					LEFT JOIN tire_rim_diameter AS rd ON p.rim_diameter_id = rd.id
					LEFT JOIN rim_width AS rw ON p.rim_width_id = rw.id
					LEFT JOIN tire_rim_diameter AS rear_rd ON p.rear_rim_diameter_id = rear_rd.id
					LEFT JOIN rim_width AS rear_rw ON p.rim_width_id = rear_rw.id
					WHERE rd.value IS NOT NULL AND rw.value IS NOT NULL AND p.model_year_id IN(".implode(',', $model_year_ids).") AND p.id<>3755
					GROUP BY rim_diameter, rim_width, p.is_staggered_wheels
					ORDER BY rd.value, CAST(rw.value AS DECIMAL(5,2))";
			
			$data = Yii::app()->db->createCommand($sql)->queryAll();				
			
			Yii::app()->cache->get($key, $data, 0, new Tags(Tags::TAG_PROJECT));				
		}
		
		return $data;		
	}
	
}