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
			array('alias', 'unique'),
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
	
		$key = Tags::TAG_MODEL_YEAR . '__LAST_YEAR__'.$model_id;
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
				);
			
			Yii::app()->cache->set($key, $data, 60*60*24*31, new Tags(Tags::TAG_MODEL_YEAR));
		}

		return $data;	
	}	

	public static function getYears($model_id)
	{
		$key = Tags::TAG_MODEL_YEAR . '__YEARS__'.$model_id;
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
				$data[] = array(
					'id' => $item->id,
					'year' => $item->year,
					'photo' => $item->getThumb(150, null, 'resize'),
				);			
			}
			
			Yii::app()->cache->set($key, $data, 60*60*24*31, new Tags(Tags::TAG_MODEL_YEAR));
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
			
			Yii::app()->cache->set($key, $model, 60*60*24*31, new Tags(Tags::TAG_MAKE, Tags::TAG_MODEL));
		}	
		
		return $model;
	}	
	
	public static function getMinMaxSpecs($specs, $model_id)
	{
		$model_id = (int) $model_id;
	
		$key = Tags::TAG_COMPLETION . '_MODEL_SPECS_MIN_MAX_' . $specs . '_' . $model_id;
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
}