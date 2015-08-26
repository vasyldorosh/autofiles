<?php

class AutoModel extends CActiveRecord
{
	public $file; 

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
		return 'auto_model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, make_id', 'required'),
			array('is_active, is_deleted', 'numerical', 'integerOnly' => true),
			array(
				'file', 
				'file', 
				'types'=>'jpg,png,gif,jpeg',
				'allowEmpty'=>true
			),
			array('description', 'safe',),					
		);
	}
	
	/**
	 * Выполняем ряд действий перед валидацией модели
	 * @return boolean -- результат выполнения операции
	 */
	protected function beforeValidate()
	{
		//создаем алиас к тайтлу
		$this->buildAlias();
		return parent::beforeValidate();
	}
	
	/**
	 * Создаем алиас к тайтлу
	 */
	private function buildAlias()
	{
		if (empty($this->alias) && !empty($this->title)) { 
			$this->alias = $this->title;
		}
		
		$this->alias = TextHelper::urlSafe($this->alias);
	}	
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'Make' => array(self::BELONGS_TO, 'AutoMake', 'make_id', 'together'=>true,),
        );
	}	
	
   protected function beforeSave() {

		if (!empty($this->file)) {
			if (!$this->isNewRecord)
				$this->_deleteImage();
			
			$this->image_ext = $this->file->getExtensionName();
		}				
			
		return parent::beforeSave();
    }	
	
	
	public function afterSave()
	{	
		if (!empty($this->file)) {
			$this->file->saveAs($this->getImage_directory(true) . 'origin.'.$this->image_ext);
		}	
		
		$this->_clearCache();
		
		return parent::afterSave();
	}

    public function afterDelete() 
	{
		$this->_deleteImage();
		$this->_clearCache();
		
        return parent::afterDelete();
    }	
	
	private function _clearCache()
	{
		Yii::app()->cache->clear(Tags::TAG_MAKE);
	}	
	
    private function _deleteImage() 
	{
        if (!empty($this->image_ext)) {
            Yii::app()->file->set($this->image_directory)->delete();
            $this->image_ext = '';
        }
    }	
	
	public function getThumb($width=null, $height=null, $mode='origin')
	{
		$dir = $this->getImage_directory();
		$originFile = $dir . 'origin.' . $this->image_ext;
		
		if (empty($this->image_ext) || !is_file($originFile)) {
			return "http://www.placehold.it/{$width}x{$height}/EFEFEF/AAAAAA";
		}
	
		if ($mode == 'origin') {
			return '/photos/model/'.$this->id.'/origin.'. $this->image_ext;
		}
	
		$fileName = $mode . '_w' . $width . '_h' . $height . '.' . $this->image_ext;
		$filePath = $dir . $fileName;
		if (!is_file($filePath)) {
			if ($mode == 'resize') {
				Yii::app()->iwi->load($originFile)
							   ->resize($width, $height)
							   ->save($filePath);
			} else {
				Yii::app()->iwi->load($originFile)
							   ->crop($width, $height)
							   ->save($filePath);
			}
		}
		
		return '/photos/model/'. $this->id . '/'. $fileName;
	}	

    public function getImage_directory($mkdir=false) {
		$directory = Yii::app()->basePath . '/../photos/model/' . $this->id . '/';
        if (!$mkdir) {
			return $directory;
		
		} else {

			if (file_exists($directory) == false) {
				mkdir($directory);
				chmod($directory, 0777);
			}	

			return $directory;
		}
    }

	
	public function getImage_preview()
	{
		return $this->getThumb(100,60, 'crop') . '?'.time();
	}	
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('admin', 'Title'),
			'make_id' => Yii::t('admin', 'Make'),
			'file' => Yii::t('admin', 'Image'),
			'alias' => Yii::t('admin', 'Alias'),
			'image_preview' => Yii::t('admin', 'Image'),
			'is_active' => Yii::t('admin', 'Published'),
			'is_deleted' => Yii::t('admin', 'Deleted'),	
			'description' => Yii::t('admin', 'Description'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.title',$this->title, true);
		$criteria->compare('t.make_id',$this->make_id);
		$criteria->compare('t.is_deleted',$this->is_deleted);
		$criteria->compare('t.is_active',$this->is_active);		
		
		$criteria->with = array('Make' => array('together'=>true));		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
			),			
		));
	}

	
	public static function getAllWithMake()
	{
		return CHtml::listData(self::model()->with(array('Make'))->findAll(), 'id', 'title', 'Make.title');
	}

	public static function getAllByMake($make_id)
	{
		$make_id = (int) $make_id;
		
		return CHtml::listData(self::model()->findAllByAttributes(array('make_id'=>$make_id)), 'id', 'title');
	}

	public function getUrlFront()
	{
		return $this->Make->urlFront . $this->alias . '/';
	}	
	

	public function getMinMaxMsrp()
	{
		$key = Tags::TAG_COMPLETION . 'MINMAXMSRP_'.$this->id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$sql = "SELECT 
						MAX(c.specs_msrp) AS mmax,  
						MIN(c.specs_msrp) AS mmin 
					FROM auto_completion AS c
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					WHERE 
						c.is_active = 1 AND 
						c.is_deleted = 0 AND
						y.is_active = 1 AND
						y.is_deleted = 0 AND
						y.model_id = {$this->id}
					";
					
			$data = Yii::app()->db->createCommand($sql)->queryRow();	
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;
	}	
	
	public static function getLastCompletion($model_id)
	{
		$key = Tags::TAG_COMPLETION . 'LAST_'.$model_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$sql = "SELECT 
						c.*,
						y.year AS year
					FROM auto_completion AS c
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					WHERE 
						c.is_active = 1 AND 
						c.is_deleted = 0 AND
						y.is_active = 1 AND
						y.is_deleted = 0 AND
						y.model_id = {$model_id}
					ORDER BY year DESC
					";
					
			$data = Yii::app()->db->createCommand($sql)->queryRow();
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_COMPLETION, Tags::TAG_MODEL_YEAR));
		}
		
		return $data;
	}
	
	public static function getLastYear($model_id)
	{
		$model_id = (int) $model_id;
	
		$key = Tags::TAG_MODEL_YEAR . '_LAST_YEAR_'.$model_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$data = array();
			$criteria=new CDbCriteria;
			$criteria->compare('model_id', $model_id);
			$criteria->compare('is_active', 1);
			$criteria->compare('is_deleted', 0);
			$criteria->order = 'year DESC';					
			$item = AutoModelYear::model()->find($criteria);					
			
			if ($item)
				$data = array(
					'id' => $item->id,
					'year' => $item->year,
					'photo' => $item->getThumb(150, null, 'resize'),
					'photo_270' => $item->getThumb(270, null, 'resize'),
				);
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR));
		}

		return $data;	
	}	

	public static function getYears($model_id, $onlyIds=false)
	{
		$key = Tags::TAG_MODEL_YEAR . '_getYears_'.$model_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$data = array();

			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('t.model_id', $model_id);
			$criteria->order = 't.year DESC';
			
			$modelByYears = AutoModelYear::model()->findAll($criteria);			
			foreach ($modelByYears as $item) {
				$data[$item->id] = array(
					'id' => $item->id,
					'year' => $item->year,
					'photo' => $item->getThumb(150, null, 'resize'),
				);			
			}
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR));
		}
		
		if ($onlyIds) {
			$ids = array();
			foreach ($data as $item) {
				$ids[] = $item['id'];
			}
			return $ids;
		}
		
		return $data;	
	}	
	
	public static function getModelByMakeAndAlias($make_id, $alias)
	{
		$key = Tags::TAG_MODEL . '__ITEM__'.$make_id . '__' . $alias;
		$model = Yii::app()->cache->get($key);
		if ($model == false) {
			$model = array();

			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('t.alias', $alias);
			$criteria->compare('Make.id', $make_id);
			$criteria->compare('Make.is_active', 1);
			$criteria->compare('Make.is_deleted', 0);
			$criteria->with = array('Make');
			
			$item = AutoModel::model()->find($criteria);			
			
			if (!empty($item)) {
				$model = array(
					'id' => $item->id,
					'url' => $item->urlFront,
					'title' => $item->title,
					'alias' => $item->alias,
					'description' => $item->description,
					'photo' => $item->getThumb(150, null, 'resize'),
				);
			}
			
			Yii::app()->cache->set($key, $model, 0, new Tags(Tags::TAG_MAKE, Tags::TAG_MODEL));
		}	
		
		return $model;
	}	
	
	public static function getMinMaxSpecs($specs, $model_id)
	{
		$model_id = (int) $model_id;
	
		$key = Tags::TAG_MODEL . '_getMinMaxSpecs_' . $specs . '_' . $model_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data === false) {
			$sql = "SELECT 
						MAX(c.specs_{$specs}) AS mmax,  
						MIN(c.specs_{$specs}) AS mmin 
					FROM auto_completion AS c
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					WHERE 
						c.is_active = 1 AND 
						c.is_deleted = 0 AND
						y.is_active = 1 AND
						y.is_deleted = 0 AND
						y.model_id = {$model_id}
					";

			$data = Yii::app()->db->createCommand($sql)->queryRow();	
			$data['mmax'] = (float) $data['mmax'];
			$data['mmin'] = (float) $data['mmin'];
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;
	}		

	public static function getMaxSpecs($specs, $model_id, $model_year_id=0)
	{
		$model_id = (int) $model_id;
	
		$key = Tags::TAG_COMPLETION . '_MODEL_SPECS_MAX_' . $specs . '_' . $model_id . '_' . $model_year_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$whereYear = $model_year_id ? "AND y.id={$model_year_id}":"";
			$sql = "SELECT 
						MAX(c.specs_{$specs}) AS mmax
					FROM auto_completion AS c
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					WHERE 
						c.is_active = 1 AND 
						c.is_deleted = 0 AND
						y.is_active = 1 AND
						y.is_deleted = 0 AND
						y.model_id = {$model_id}
						{$whereYear}
					";
					
			$data = Yii::app()->db->createCommand($sql)->queryRow();	
			$data = (float) $data['mmax'];
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;
	}		

	public static function getMinSpecs($specs, $model_id, $model_year_id=0)
	{
		$model_id = (int) $model_id;
	
		$key = Tags::TAG_COMPLETION . '_MODEL_SPECS_MIN_' . $specs . '_' . $model_id . '_' . $model_year_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$whereYear = $model_year_id ? "AND y.id={$model_year_id}":"";
			$sql = "SELECT 
						MIN(c.specs_{$specs}) AS mmin 
					FROM auto_completion AS c
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					WHERE 
						c.is_active = 1 AND 
						c.is_deleted = 0 AND
						y.is_active = 1 AND
						y.is_deleted = 0 AND
						y.model_id = {$model_id}
						{$whereYear}
					";
					
			$data = Yii::app()->db->createCommand($sql)->queryRow();	
			$data = (float) $data['mmin'];

			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;
	}		
	
	public static function getModelsByMake($make_id, $year)
	{
		$make_id = (int) $make_id;
		$year = (int) $year;
		$key = Tags::TAG_MODEL . '_MODELS_BY_MAKE_'.$make_id . '_' . $year;
		$data = Yii::app()->cache->get($key);
		if ($data == false) {
			$data = array();
			
			$sql = "SELECT 
						m.title AS title,
						m.alias AS alias
					FROM auto_model_year AS y
					LEFT JOIN auto_model AS m ON y.model_id = m.id
					WHERE 
						m.is_active = 1 AND 
						m.is_deleted = 0 AND
						m.make_id = {$make_id} AND 
						y.year = {$year} AND 
						y.is_active = 1 AND 
						y.is_deleted = 0
					GROUP BY y.model_id
					ORDER BY title ASC
					";
					
			$items = Yii::app()->db->createCommand($sql)->queryAll();	
			foreach ($items as $item) {
				$data[$item['alias']] = $item['title'];
			}			

			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL));
		}	
		
		return $data;
	}	

	public static function getModelsMake($make_id)
	{
		$make_id = (int) $make_id;
		$key = Tags::TAG_MODEL . '__getModelsMake__'.$make_id;
		$data = Yii::app()->cache->get($key);
		if ($data == false) {
			$data = array();
			
			$sql = "SELECT 
						m.title AS title,
						m.alias AS alias
					FROM auto_model AS m
					WHERE 
						m.make_id = {$make_id} AND 
						m.is_active = 1 AND 
						m.is_deleted = 0
					ORDER BY m.title ASC
					";
					
			$items = Yii::app()->db->createCommand($sql)->queryAll();	
			foreach ($items as $item) {
				$data[$item['alias']] = $item['title'];
			}			

			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL));
		}	
		
		return $data;
	}	

	public static function getMinMaxTireSize($model_id)
	{
		$model_id = (int) $model_id;
		$key = Tags::TAG_MODEL . '_getMinMaxTireSize__'.$model_id;
		$data = Yii::app()->cache->get($key);
		if ($data === false) {
			$data = array();
			$ids = self::getYears($model_id, true);
			$tireIds = array();
			if (!empty($ids)) {
				$sql = "SELECT DISTINCT tire_id FROM auto_model_year_tire WHERE model_year_id IN(".implode(',', $ids).")";
				$items = Yii::app()->db->createCommand($sql)->queryAll();
				foreach ($items as $item) {
					$tireIds[] = $item['tire_id'];
				}
			}
			
			if (!empty($tireIds)) {
				$data['min'] = self::_getTireRange($tireIds, 'ASC');
				$data['max'] = self::_getTireRange($tireIds, 'DESC');
			}
				
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_TIRE, Tags::TAG_TIRE_ASPECT_RATIO, Tags::TAG_TIRE_RIM_DIAMETER, Tags::TAG_TIRE_SECTION_WIDTH));
		}	
		
		return $data;
	}
	
	private static function _getTireRange($tireIds, $dir)
	{
		$sql = "SELECT 
							vc.code AS vehicle_class, 
							rd.value AS rim_diameter, 
							sw.value AS section_width, 
							ar.value AS aspect_ratio
						FROM tire AS t
						LEFT JOIN tire_vehicle_class AS vc ON t.vehicle_class_id = vc.id
						LEFT JOIN tire_rim_diameter AS rd ON t.rim_diameter_id = rd.id
						LEFT JOIN tire_section_width AS sw ON t.section_width_id = sw.id
						LEFT JOIN tire_aspect_ratio AS ar ON t.aspect_ratio_id = ar.id
						WHERE t.id IN (".implode(',', $tireIds).")
						ORDER BY rim_diameter {$dir}, section_width {$dir}, aspect_ratio {$dir} 
		";
		
		$row = Yii::app()->db->createCommand($sql)->queryRow();	
		if (!empty($row)) {
			return Tire::format($row, false);
		}
	}
	
	public static function getMinMaxTireSizeYear($model_year_id)
	{
		$model_year_id = (int) $model_year_id;
		$key = Tags::TAG_MODEL_YEAR . '__getMinMaxTireSizeYear__'.$model_year_id;
		$data = Yii::app()->cache->get($key);
		if ($data === false) {
			$data = array();
			
			$tireIds = array();
			$sql = "SELECT tire_id FROM auto_model_year_tire WHERE model_year_id = {$model_year_id}";
			$items = Yii::app()->db->createCommand($sql)->queryAll();
			foreach ($items as $item) {
				$tireIds[] = $item['tire_id'];
			}
			
			if (!empty($tireIds)) {
				$data['min'] = self::_getTireRange($tireIds, 'ASC');
				$data['max'] = self::_getTireRange($tireIds, 'DESC');
			}
				
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_TIRE, Tags::TAG_TIRE_ASPECT_RATIO, Tags::TAG_TIRE_RIM_DIAMETER, Tags::TAG_TIRE_SECTION_WIDTH));
		}	
		
		return $data;
	}	
	
	public static function getMinMaxHorsepower($model_id)
	{
		$model_id = (int) $model_id;
		$key = Tags::TAG_MODEL . '__getMinMaxHorsepower__'.$model_id;
		$data = Yii::app()->cache->get($key);
		if ($data === false) {
			$data = array();

			$sql = "
					SELECT 
						MAX(CONVERT(SUBSTRING_INDEX(c.specs_horsepower, '@', 1), SIGNED INTEGER)) AS `max`,
						MIN(CONVERT(SUBSTRING_INDEX(c.specs_horsepower, '@', 1), SIGNED INTEGER)) AS `min`
					FROM `auto_completion` AS c 
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					LEFT JOIN auto_model AS model ON y.model_id = model.id
					LEFT JOIN auto_make AS make ON model.make_id = make.id
					WHERE 
						y.is_active=1 AND 
						y.is_deleted=0 AND 
						model.is_active=1 AND 
						model.is_deleted=0 AND 
						make.is_active=1 AND 
						make.is_deleted=0 AND 
						model.id={$model_id}			
			";
			$data = Yii::app()->db->createCommand($sql)->queryRow();	
				
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL, Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}	
		
		return $data;
	}

	public static function getWheelsData($model_id)
	{
		$model_id = (int) $model_id;
		$key = Tags::TAG_MODEL_YEAR . '__getWheelsData__'.$model_id;
		$data = Yii::app()->cache->get($key);
		if ($data === false || true) {
			$data = array();

			$sql = "SELECT  
						CAST( GROUP_CONCAT(DISTINCT y.year ORDER BY y.year DESC) AS CHAR(10000) CHARACTER SET utf8) AS `years`, 
						CAST( GROUP_CONCAT(DISTINCT y.id ORDER BY y.id DESC) AS CHAR(10000) CHARACTER SET utf8) AS `ids`, 
						y.tire_rim_diameter_from_id AS tire_rim_diameter_from_id, 
						y.rim_width_from_id AS rim_width_from_id, 
						y.tire_rim_diameter_to_id AS tire_rim_diameter_to_id, 
						y.rim_width_to_id AS rim_width_to_id, 
						y.offset_range_from_id AS offset_range_from_id, 
						y.offset_range_to_id AS offset_range_to_id, 
						y.bolt_pattern_id AS bolt_pattern_id, 
						y.thread_size_id AS thread_size_id, 
						y.center_bore_id AS center_bore_id,
						(SELECT MAX(ror.value)
							FROM auto_model_year AS yy
							LEFT JOIN rim_offset_range AS ror ON yy.rim_offset_range_id = ror.id
							WHERE FIND_IN_SET(yy.id, CAST( GROUP_CONCAT(DISTINCT y.id ORDER BY y.id DESC) AS CHAR(10000) CHARACTER SET utf8))
						) AS y_ror_max,						
						(SELECT MIN(ror.value)
							FROM auto_model_year AS yy
							LEFT JOIN rim_offset_range AS ror ON yy.rim_offset_range_id = ror.id
							WHERE FIND_IN_SET(yy.id, CAST( GROUP_CONCAT(DISTINCT y.id ORDER BY y.id DESC) AS CHAR(10000) CHARACTER SET utf8))
						) AS y_ror_min				
					FROM auto_model_year AS y
					WHERE y.model_id={$model_id} AND y.is_active=1 AND y.is_deleted=0
					GROUP BY 	y.tire_rim_diameter_from_id, 
								y.rim_width_from_id, 
								y.tire_rim_diameter_to_id, 
								y.rim_width_to_id, 
								y.offset_range_from_id, 
								y.offset_range_to_id, 
								y.bolt_pattern_id, 
								y.thread_size_id, 
								y.center_bore_id
					ORDER BY years DESC
			";
			
			$data = Yii::app()->db->createCommand($sql)->queryAll();	
				
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR));
		}	
		
		return $data;
	}
		
	public static function getWheelsDataFull($model_id) 
	{
		$model_id = (int) $model_id;
		$items = self::getWheelsData($model_id);
		$data = array();
		
		$listRimDiameter = TireRimDiameter::getList();
		$listRimWidth = RimWidth::getAll();
		$listOffsetRange = RimOffsetRange::getAll();
		$listBoltPattern = RimBoltPattern::getAll();
		$listCenterBore = RimCenterBore::getAll();
		$listThreadSize = RimThreadSize::getAll();
		
		$data = $items;
		foreach ($items as $key=>$item) {
			$data[$key]['ids'] = explode(',', $item['ids']);
			$data[$key]['years'] = explode(',', $item['years']);
			$data[$key]['tire_rim_diameter_from'] = isset($listRimDiameter[$item['tire_rim_diameter_from_id']])?$listRimDiameter[$item['tire_rim_diameter_from_id']]:'';
			$data[$key]['rim_width_from'] = isset($listRimWidth[$item['rim_width_from_id']])?$listRimWidth[$item['rim_width_from_id']]:'';
			$data[$key]['tire_rim_diameter_to'] = isset($listRimDiameter[$item['tire_rim_diameter_to_id']])?$listRimDiameter[$item['tire_rim_diameter_to_id']]:'';
			$data[$key]['rim_width_to'] = isset($listRimWidth[$item['rim_width_to_id']])?$listRimWidth[$item['rim_width_to_id']]:'';
			$data[$key]['offset_range_from'] = isset($listOffsetRange[$item['offset_range_from_id']])?$listOffsetRange[$item['offset_range_from_id']]:'';
			$data[$key]['offset_range_to'] = isset($listOffsetRange[$item['offset_range_to_id']])?$listOffsetRange[$item['offset_range_to_id']]:'';
			$data[$key]['bolt_pattern'] = isset($listBoltPattern[$item['bolt_pattern_id']])?$listBoltPattern[$item['bolt_pattern_id']]:'';
			$data[$key]['center_bore'] = isset($listCenterBore[$item['center_bore_id']])?$listCenterBore[$item['center_bore_id']]:'';
			$data[$key]['thread_size'] = isset($listThreadSize[$item['thread_size_id']])?$listThreadSize[$item['thread_size_id']]:'';	
		}
		
		return $data;
	}	
	
	public static function getTireRange($tireIds, $dir)
	{
		$sql = "SELECT 
							vc.code AS vehicle_class, 
							rd.value AS rim_diameter, 
							sw.value AS section_width, 
							ar.value AS aspect_ratio
						FROM tire AS t
						LEFT JOIN tire_vehicle_class AS vc ON t.vehicle_class_id = vc.id
						LEFT JOIN tire_rim_diameter AS rd ON t.rim_diameter_id = rd.id
						LEFT JOIN tire_section_width AS sw ON t.section_width_id = sw.id
						LEFT JOIN tire_aspect_ratio AS ar ON t.aspect_ratio_id = ar.id
						WHERE t.id IN (".implode(',', $tireIds).")
						ORDER BY rim_diameter {$dir}, section_width {$dir}, aspect_ratio {$dir} 
		";
		
		$row = Yii::app()->db->createCommand($sql)->queryRow();	
		if (!empty($row)) {
			return Tire::format($row, false);
		}
	}	
	
}