<?php

class AutoMake extends CActiveRecord
{
	const CACHE_KEY_LIST_FRONT = 'MAKES_LIST_FRONT_1';
	
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
		return 'auto_make';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
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
			return '/photos/make/'.$this->id.'/origin.'. $this->image_ext;
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
		
		return '/photos/make/'. $this->id . '/'. $fileName;
	}	

    public function getImage_directory($mkdir=false) {
		$directory = Yii::app()->basePath . '/../photos/make/' . $this->id . '/';
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
			'file' => Yii::t('admin', 'Image'),
			'alias' => Yii::t('admin', 'Alias'),
			'image_preview' => Yii::t('admin', 'Image'),
			'is_active' => Yii::t('admin', 'Published'),
			'is_deleted' => Yii::t('admin', 'Deleted'),
			'description' => Yii::t('admin', 'Description'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('title',$this->title, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
			),			
		));
	}
	
	public static function getAll()
	{
		return CHtml::listData(self::model()->findAll(), 'id', 'title');
	}

	public static function getAllFront()
	{
		$data = Yii::app()->cache->get(self::CACHE_KEY_LIST_FRONT);
			
		if ($data == false) {
			$criteria=new CDbCriteria;
			$criteria->compare('is_active', 1);	
			$criteria->compare('is_deleted', 0);	
			$criteria->order = 'title';	
			$data = CHtml::listData(self::model()->findAll($criteria), 'urlFront', 'title');
			Yii::app()->cache->set(self::CACHE_KEY_LIST_FRONT, $data, 0, new Tags(Tags::TAG_MAKE));
		}
		
		return $data;
	}

	private function _clearCache()
	{
		Yii::app()->cache->clear(Tags::TAG_MAKE);
	}
	
	public function getUrlFront()
	{
		return '/'.$this->alias . '/';
	}
	
	public static function getModels($make_id)
	{
		$key = Tags::TAG_MODEL . '_LIST_MODELS_'.$make_id;
		$dataModels = Yii::app()->cache->get($key);
		if ($dataModels == false) {
			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('t.make_id', $make_id);
			$criteria->compare('Make.is_active', 1);
			$criteria->compare('Make.is_deleted', 0);
			$criteria->with = array('Make' => array('together'=>true));
			
			$models = AutoModel::model()->findAll($criteria);

			foreach ($models as $model) {
				$price = $model->getMinMaxMsrp();
				$lastCompletion = AutoModel::getLastCompletion($model['id']);
				$years = AutoModel::getYears($model['id']);
				$lastYear = AutoModel::getLastYear($model['id']);
				
				$row = array(
					'id' => $model->id,
					'title' => $model->title,
					'alias' => $model->alias,
					'url' => $model->urlFront,
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
					'years' => $years,
				);
				
				if (!empty($lastYear)) {
					$row['lastYear'] = $lastYear['year'];
					$row['photo'] = $lastYear['photo'];
				}
				
				$dataModels[] = $row;
			}
			
			Yii::app()->cache->set($key, $dataModels, 60*60*24*31, new Tags(Tags::TAG_MODEL, Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $dataModels;
	}	
	
	public static function getMakeByAlias($alias)
	{
		$key = Tags::TAG_MAKE . '__ITEM__'.$alias;
		$make = Yii::app()->cache->get($key);
		if ($make == false) {
			$make = array();
			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('t.alias', $alias);
			$model = AutoMake::model()->find($criteria);
			
			if (!empty($model)) {
				$make = array(
					'id' => $model->id,
					'url' => $model->urlFront,
					'alias' => $model->alias,
					'title' => $model->title,
					'description' => $model->description,
					'photo' => $model->getThumb(150, null, 'resize'),
				);
			}
			
			Yii::app()->cache->set($key, $make, 60*60*24*31, new Tags(Tags::TAG_MAKE));
		}	
		
		return $make;
	}	

}