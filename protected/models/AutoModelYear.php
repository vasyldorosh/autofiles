<?php

class AutoModelYear extends CActiveRecord
{
	const PHOTO_DIR = '/photos/model_year_item/';
	const CACHE_KEY_PHOTOS = 'AUTO_MODEL_YEAR_PHOTOS_';
	
    public $file;
    public $file_url;
    public $is_delete_photo;
	
	public $image_ext = 'jpg';	
	
	public $post_competitors = array();

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
		return 'auto_model_year';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('year, model_id', 'required'),
            array('id, year', 'numerical', 'integerOnly' => true,),		
			array('is_active, is_deleted, is_delete_photo', 'numerical', 'integerOnly' => true),
            array('post_competitors', 'safe',),					
            array('description', 'safe',),		
            array('file', 'length', 'max' => 128),
			array(
				'file', 
				'file', 
				'types'=>'jpg,png,gif,jpeg',
				'allowEmpty'=>true
			),				
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'Model' => array(self::BELONGS_TO, 'AutoModel', 'model_id', 'together'=>true,),
			'galleryPhotos' => array(self::HAS_MANY, 'AutoModelYearPhoto', 'year_id', 'order' => '`rank` ASC',),
	    );
	}	
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'year' => Yii::t('admin', 'Year'),
			'image_preview' => Yii::t('admin', 'Image'),
			'model_id' => Yii::t('admin', 'Model'),
			'post_competitors' => Yii::t('admin', 'Competitors'),
			'image_preview' => Yii::t('admin', 'Image'),
			'is_active' => Yii::t('admin', 'Published'),
			'is_deleted' => Yii::t('admin', 'Deleted'),	
			'is_delete_photo' => Yii::t('admin', 'Delete Photo'),	
			'description' => Yii::t('admin', 'Description'),
			'file' => 'File Name',			
		);
	}

		
	protected function beforeSave()	
	{
		if ($this->is_delete_photo) {
			$this->_deleteImage();
			$this->file_name = '';
		}
		
		return parent::beforeSave()	;
	}
	
	/**
	 * Выполняем ряд обязательных действий после сохранения модели
	 * @return boolean -- результат выполнения действия
	 */
	protected function afterSave()
	{
		$deletedCompetitors = array();
	
		if ($this->scenario == 'updateAdmin') {
			$this->post_competitors = (array)$this->post_competitors;
		
			$sqlParts[] = "model_year_id=$this->id";
			$sqlParts[] = "competitor_id=$this->id";
			
			$competitors = $this->getCompetitors();
			foreach ($competitors as $id) {
				if (!in_array($id, $this->post_competitors)) {
					$deletedCompetitors[] = $id;
				}
			}
						
			foreach ($this->post_competitors as $competitor_id) {
				$competitor_id = (int) $competitor_id;
				if (!$competitor_id) continue;
				foreach ($deletedCompetitors as $deleted_id) {
					$sqlParts[] = "((model_year_id=$deleted_id AND competitor_id=$competitor_id) OR (model_year_id=$competitor_id AND competitor_id=$deleted_id))";
				}
			}
			
			$sql = 'DELETE FROM auto_model_year_competitor WHERE ' . implode(' OR ', $sqlParts);
			Yii::app()->db->createCommand($sql)->execute();
		}
		
		foreach ($this->post_competitors as $competitor_id) {
			if ($this->id == $competitor_id)
				continue;
				
			$item = new AutoModelYearCompetitor;
			$item->model_year_id = $this->id;
			$item->competitor_id = $competitor_id;
			$item->save();
		}	
			
		if (!empty($this->file)) {
			if (!$this->isNewRecord) {
				$this->_deleteImage();
			}		
		
			$this->file_name = "{$this->Model->Make->alias}-{$this->Model->alias}-{$this->year}.jpg";
			$this->file->saveAs($this->getImage_directory(true) . $this->file_name);
			$this->updateByPk($this->id, array('file_name'=>$this->file_name));
		}
		
		if (!empty($this->file_url)) {
			if (!$this->isNewRecord) {
				$this->_deleteImage();
			}
			
			$imageContent = CUrlHelper::getPage($this->file_url, '', '');	

			if (!empty($imageContent)) {
				file_put_contents($this->getImage_directory(true) . $this->file_name, $imageContent);
				$this->updateByPk($this->id, array('file_name'=>$this->file_name));
			}
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

	private function _deleteImage()
    {
        if (!empty($this->file_name)) {
			$files = $this->bfglob(Yii::getPathOfAlias('webroot') . self::PHOTO_DIR, "*{$this->file_name}", 0, 10);			
			foreach ($files as $file) {
				@unlink($file);
			}
		}
    }	
	
	function bfglob($path, $pattern = '*', $flags = 0, $depth = 0) {
        $matches = array();
        $folders = array(rtrim($path, DIRECTORY_SEPARATOR));
 
        while($folder = array_shift($folders)) {
            $matches = array_merge($matches, glob($folder.DIRECTORY_SEPARATOR.$pattern, $flags));
            if($depth != 0) {
                $moreFolders = glob($folder.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR);
                $depth   = ($depth < -1) ? -1: $depth + count($moreFolders) - 2;
                $folders = array_merge($folders, $moreFolders);
            }
        }
        return $matches;
    }	
	
	
    public function getImage_directory($mkdir=false) {
		return Yii::app()->basePath . '/..'. self::PHOTO_DIR;
    }

    public function getPreview()
    {
        return $this->getThumb(150, null, 'resize');
    }	
	
	public function getThumb($width=null, $height=null, $mode='origin')
	{
		$dir = $this->getImage_directory();
		$originFile = $dir . $this->file_name;

		if (!is_file($originFile)) {
			return "http://www.placehold.it/{$width}x{$height}/EFEFEF/AAAAAA";
		}
		
		if ($mode == 'origin') {
			return self::PHOTO_DIR . $this->file_name;
		}
		
		$subdir = $width;
		$subdirPath = $dir . $subdir;
		$subdirPathFile =$subdirPath . '/' . $this->file_name;

		if (file_exists($subdirPath) == false) {
			mkdir($subdirPath);
			chmod($subdirPath, 0777);
		}		
		
		if ($mode == 'resize') {
			Yii::app()->iwi->load($originFile)
							   ->resize($width, $height)
							   ->save($subdirPathFile);
		} else {
			Yii::app()->iwi->load($originFile)
							   ->crop($width, $height)
							   ->save($subdirPathFile);
		}
		
		return self::PHOTO_DIR .$subdir.'/'. $this->file_name;
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
		$criteria->compare('t.year',$this->year, true);
		$criteria->compare('t.model_id',$this->model_id);
		$criteria->compare('t.is_deleted',$this->is_deleted);
		$criteria->compare('t.is_active',$this->is_active);			
		
		$criteria->with = array('Model' => array('together'=>true));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
			),			
		));
	}
	
	
	public function getPhotos()
	{
		$key = self::CACHE_KEY_PHOTOS . $this->id;
		$cache = Yii::app()->cache->get($key);
		if ($cache == false && !is_array($cache)) {
			$cache = $this->galleryPhotos;
			Yii::app()->cache->set($key, $cache, 60*60*24);
		}
		
		return $cache;
	}	
	
	public static function getAllByModel($model_id) 
	{
		$criteria=new CDbCriteria;
		$criteria->compare('model_id',$model_id);	
	
		return CHtml::listData(self::model()->findAll($criteria), 'id', 'year');		
	}
	
	public static function getAll() 
	{
		$key = 'MODEL_YEAR_ALL';
		$data = Yii::app()->cache->get($key);
		if (empty($data)) {
			$data=array();
			$criteria=new CDbCriteria;
			$criteria->with = array('Model');
			$items = self::model()->findAll($criteria);
			foreach ($items as $item) {
				$data[$item->id] = $item->Model->title . ' ' . $item->year;
			} 
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR));
		}
		
		return $data;
	}
	
	public static function getAllByYear($year) 
	{
		$year = (int)$year;
		
		$years[] = $year-1;
		$years[] = $year+1;
		$years[] = $year;
		
		$data = array();
		$criteria=new CDbCriteria;
		$criteria->addInCondition('t.year', $years);
		$criteria->order = 'Make.title, Model.title, t.year DESC';
		$criteria->with = array('Model', 'Model.Make');
		$items = self::model()->findAll($criteria);
		foreach ($items as $item) {
			$data[$item->id] = $item->Model->Make->title . ' ' . $item->Model->title . ' ' . $item->year;
		}

		return $data;
	}
	
	public function getCompetitors()
	{
		$criteria=new CDbCriteria;
		$criteria->condition = "model_year_id = $this->id OR competitor_id = $this->id";	
		$items = AutoModelYearCompetitor::model()->findAll($criteria);
		$data = array();
		foreach ($items as $item) {
			$data[] = ($item->model_year_id == $this->id) ? $item->competitor_id : $item->model_year_id;
		}
	
		return $data;
	}

	public function getDataCompetitors()
	{
		if (Yii::app()->request->isPostRequest) {
			return $this->post_competitors;
		} else {
			if ($this->isNewRecord) {
				return array();
			} else {
				return $this->getCompetitors();
			}
		}
	}
	
	public function getTitle()
	{
		return $this->Model->Make->title . " " . $this->Model->title;
	}
	
	private function _clearCache()
	{
		Yii::app()->cache->clear(Tags::TAG_MODEL_YEAR);
	}	

	public static function getYearByMakeAndModelAndAlias($make_id, $model_id, $year)
	{
		$key = Tags::TAG_MODEL_YEAR . '_ITEM_'.$make_id . '_' . $model_id . '_' . $year;
		$modelYear = Yii::app()->cache->get($key);
		if ($modelYear == false) {
			$modelYear = array();

			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('t.model_id', $model_id);
			$criteria->compare('t.year', $year);
			
			$item = AutoModelYear::model()->find($criteria);			
			
			if (!empty($item)) {
				$modelYear = array(
					'id' => $item->id,
					'year' => $item->year,
					'description' => $item->description,
					'photo' => $item->getThumb(270, null, 'resize'),
				);
			}
			
			Yii::app()->cache->set($key, $modelYear, 60*60*24*31, new Tags(Tags::TAG_MODEL_YEAR));
		}	
		
		return $modelYear;
	}	
	
	public static function getModelsByMakeAndYear($make_id, $year)
	{
		$key = Tags::TAG_MODEL_YEAR . '__LIST_BY_MAKE_YEAR___'.$make_id . '_' . $year;
		$data = Yii::app()->cache->get($key);
		if ($data == false) {
			$data = array();

			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('t.year', $year);
			$criteria->compare('Model.is_active', 1);
			$criteria->compare('Model.is_deleted', 0);			
			$criteria->compare('Model.make_id', $make_id);
			$criteria->with = array('Model');
			
			$items = AutoModelYear::model()->findAll($criteria);			
			
			foreach ($items as $item) {

				$price = self::getMinMaxSpecs('msrp', $item->id);
				//$lastCompletion = self::getLastCompletion($item->id);
			
				$row = array(
					'id' => $item->id,
					'year' => $item->year,
					'model' => $item->Model->title,
					'model_alias' => $item->Model->alias,
					'photo' => $item->getThumb(150, null, 'resize'),
					'price' => array(
						'min' => $price['mmin'],
						'max' => $price['mmax'],
					),
					/*
					'completion' => array(
						'engine' => AutoSpecsOption::getV('engine', $lastCompletion['specs_engine']),
						'fuel_economy_city' => AutoSpecsOption::getV('fuel_economy__city', $lastCompletion['specs_fuel_economy__city']),
						'fuel_economy_highway' => AutoSpecsOption::getV('fuel_economy__highway', $lastCompletion['specs_fuel_economy__highway']),
						'standard_seating' => AutoSpecsOption::getV('standard_seating', $lastCompletion['specs_standard_seating']),
					),
					*/
				);

				$data[$item['id']] = $row;						
			}
			
			Yii::app()->cache->set($key, $data, 60*60*24*31, new Tags(Tags::TAG_MODEL, Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}	
		
		return $data;
	}	
	
	public static function getOtherMakeYear($models, $model_year_id)
	{
		$model_year_id = (int) $model_year_id;
		$indexes = array();
		foreach ($models as $item) {
			$indexes[] =  $item['id'];
		}		
		$size = sizeof($indexes);
		
		$data = array();
		$dataIds = array();
		
		//d($indexes, 0);
		
		foreach ($indexes as $key=>$id) {
			if ($model_year_id == $id) {
				
				if (isset($indexes[$key-1])) {
					$data[$indexes[$key-1]] = $models[$indexes[$key-1]];					
					$dataIds[$indexes[$key-1]] = $indexes[$key-1];					
				} else if (isset($indexes[$size-1])) {
					$data[$indexes[$size-1]] = $models[$indexes[$size-1]];
					$dataIds[$indexes[$size-1]] = $indexes[$size-1];
				}
			
				if (isset($indexes[$key-2])) {
					$data[$indexes[$key-2]] = $models[$indexes[$key-2]];
					$dataIds[$indexes[$key-2]] = $indexes[$key-2];
				} else if (isset($indexes[$size-2])) {
					$data[$indexes[$size-2]] = $models[$indexes[$size-2]];
					$dataIds[$indexes[$size-2]] = $indexes[$size-2];
				}
				
				if (isset($indexes[$key+1])) {
					$data[$indexes[$key+1]] = $models[$indexes[$key+1]];
					$dataIds[$indexes[$key+1]] = $indexes[$key+1];
				} else if (isset($indexes[$key-1])) {
					$data[$indexes[$key-1]] = $models[$indexes[$key-1]];					
					$dataIds[$indexes[$key-1]] = $indexes[$key-1];					
				}
				
				if (isset($indexes[$key+2])) {
					$data[$indexes[$key+2]] = $models[$indexes[$key+2]];
					$dataIds[$indexes[$key+2]] = $indexes[$key+2];
				} else if (isset($indexes[$key-2])) {
					$data[$indexes[$key-2]] = $models[$indexes[$key-2]];					
					$dataIds[$indexes[$key-2]] = $indexes[$key-2];					
				}
				
				if (isset($indexes[$key+3])) {
					$data[$indexes[$key+3]] = $models[$indexes[$key+3]];
					$dataIds[$indexes[$key+3]] = $indexes[$key+3];
				} else if (isset($indexes[$key-3])) {
					$data[$indexes[$key-3]] = $models[$indexes[$key-3]];					
					$dataIds[$indexes[$key-3]] = $indexes[$key-3];					
				}
				
				if (sizeof($dataIds) < 5) {
					if (isset($indexes[$key-4])) {
						$data[$indexes[$key-4]] = $models[$indexes[$key-4]];					
						$dataIds[$indexes[$key-4]] = $indexes[$key-4];					
					}					
				}
				
			}
		}
		
		return $data;
	}
	
	public static function getMinMaxSpecs($specs, $model_year_id)
	{
		$model_year_id = (int) $model_year_id;
	
		$key = Tags::TAG_COMPLETION . '_SPECS_MIN_MAX_' . $specs . '_' . $model_year_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
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
						c.model_year_id = {$model_year_id}
					";
					
			$data = Yii::app()->db->createCommand($sql)->queryRow();	
			$data['mmax'] = (float) $data['mmax'];
			$data['mmin'] = (float) $data['mmin'];			
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;
	}	
	
	public static function getMinSpecs($specs, $model_year_id)
	{
		$model_year_id = (int) $model_year_id;
	
		$key = Tags::TAG_COMPLETION . '_SPECS_MIN_' . $specs . '_' . $model_year_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$sql = "SELECT 
						MIN(c.specs_{$specs}) AS mmin 
					FROM auto_completion AS c
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					WHERE 
						c.is_active = 1 AND 
						c.is_deleted = 0 AND
						y.is_active = 1 AND
						y.is_deleted = 0 AND
						c.model_year_id = {$model_year_id}
					";
					
			$data = Yii::app()->db->createCommand($sql)->queryRow();	
			$data = (float) $data['mmin'];			
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;
	}	
	
	public static function getMaxSpecs($specs, $model_year_id)
	{
		$model_year_id = (int) $model_year_id;
	
		$key = Tags::TAG_COMPLETION . '_SPECS_MAX_' . $specs . '_' . $model_year_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$sql = "SELECT 
						MAX(c.specs_{$specs}) AS mmax
					FROM auto_completion AS c
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					WHERE 
						c.is_active = 1 AND 
						c.is_deleted = 0 AND
						y.is_active = 1 AND
						y.is_deleted = 0 AND
						c.model_year_id = {$model_year_id}
					";
					
			$data = Yii::app()->db->createCommand($sql)->queryRow();	
			$data = (float) $data['mmax'];			
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;
	}	
	
	public static function getLastCompletion($model_year_id)
	{
		$model_year_id = (int) $model_year_id;
		
		$key = Tags::TAG_COMPLETION . 'YEAR_LAST_'.$model_year_id;
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
						c.model_year_id = {$model_year_id}
					ORDER BY year DESC
					";
					
			$data = Yii::app()->db->createCommand($sql)->queryRow();
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_COMPLETION));
		}
		
		return $data;
	}	
	
	public static function getFrontCompetitors($model_year_id)
	{
		$model_year_id = (int) $model_year_id;
		
		$key = Tags::TAG_MODEL_YEAR . '_COMPETITORS_'.$model_year_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false && !is_array($data) || true) {
			$data = array();
			$sql = "SELECT 
						*
					FROM auto_model_year_competitor AS c
					WHERE 
						c.model_year_id	 = {$model_year_id} OR 
						c.competitor_id = {$model_year_id}
					";
			$rows = Yii::app()->db->createCommand($sql)->queryAll();		
			$ids = array();
			foreach ($rows as $row) {
				$ids[] = ($model_year_id==$row['model_year_id']) ? $row['competitor_id'] : $row['model_year_id'];
			}

			if (!empty($ids)) {
				$criteria = new CDbCriteria();
				$criteria->compare('t.is_active', 1);
				$criteria->compare('t.is_deleted', 0);
				$criteria->addInCondition('t.id', $ids);
				$criteria->compare('Model.is_active', 1);
				$criteria->compare('Model.is_deleted', 0);	
				$criteria->compare('Make.is_active', 1);
				$criteria->compare('Make.is_deleted', 0);					
				$criteria->with = array('Model', 'Model.Make');
				
				$items = AutoModelYear::model()->findAll($criteria);	
					
				foreach ($items as $item) {
					$price = self::getMinMaxSpecs('msrp', $item->id);
					$lastCompletion = self::getLastCompletion($item->id);
				
					$row = array(
						'id' => $item->id,
						'photo' => $item->getThumb(150, null, 'resize'),
						'year' => $item->year,
						'model' => $item->Model->title,
						'model_alias' => $item->Model->alias,
						'make' => $item->Model->Make->title,
						'make_alias' => $item->Model->Make->alias,
						'price' => array(
							'min' => $price['mmin'],
							'max' => $price['mmax'],
						),	
						'completion' => array(
							'engine' => AutoSpecsOption::getV('engine', $lastCompletion['specs_engine']),
							'fuel_economy_city' => AutoSpecsOption::getV('fuel_economy__city', $lastCompletion['specs_fuel_economy__city']),
							'fuel_economy_highway' => AutoSpecsOption::getV('fuel_economy__highway', $lastCompletion['specs_fuel_economy__highway']),
							'standard_seating' => AutoSpecsOption::getV('standard_seating', $lastCompletion['specs_standard_seating']),
						),						
					);
					
					$data[] = $row;
				}	
			}

			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MAKE, Tags::TAG_MODEL, Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;
	}	
	
	public static function getCarSpecsAndDimensions($model_year_id)
	{
		$model_year_id = (int) $model_year_id;
		
		$key = Tags::TAG_MODEL_YEAR . '_CAR_SPECS_AND_DIMENSIONS_'.$model_year_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$lastCompletion = self::getLastCompletion($model_year_id);
			$data['0_60_times'] = self::getMinMaxSpecs('0_60mph__0_100kmh_s_', $model_year_id);
			$data['engine'] = AutoSpecsOption::getV('engine', $lastCompletion['specs_engine']);
			$data['horsepower'] = AutoSpecsOption::getV('engine', $lastCompletion['specs_horsepower']);
			$data['wheelbase'] = self::getMinMaxSpecs('wheelbase', $model_year_id);
			$data['towing_capacity'] = self::getMinMaxSpecs('maximum_trailer_weight', $model_year_id);
			$data['length'] = self::getMinMaxSpecs('exterior_length', $model_year_id);
			$data['clearance'] = self::getMinMaxSpecs('ground_clearance', $model_year_id);
			$data['cargo_space'] = self::getMinMaxSpecs('luggage_volume', $model_year_id);
			$data['curb_weight'] = self::getMinMaxSpecs('curb_weight', $model_year_id);
			
			$v1 = AutoSpecsOption::getV('fuel_economy__city', $lastCompletion['specs_fuel_economy__city']);
			$v2 = AutoSpecsOption::getV('fuel_economy__highway', $lastCompletion['specs_fuel_economy__highway']);
			if (!empty($v1) && !empty($v2)) {
				$data['gas_mileage'] = $v1 . '/' . $v2;
			}
		
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_COMPLETION));
		}
		
		return $data;
	}	
	
}