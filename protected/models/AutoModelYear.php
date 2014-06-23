<?php

class AutoModelYear extends CActiveRecord
{
	const CACHE_KEY_PHOTOS = 'AUTO_MODEL_YEAR_PHOTOS_';
	
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
			array('is_active, is_deleted', 'numerical', 'integerOnly' => true),
            array('post_competitors', 'safe',),					
            array('description', 'safe',),					
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
			'description' => Yii::t('admin', 'Description'),
		);
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
			
		$this->_clearCache();	
			
		return parent::afterSave();
	}		
	
	public function afterDelete()
	{
		$this->_clearCache();
		
		return parent::afterDelete();
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
	
	public function getThumb($width=null, $height=null, $mode='origin')
	{
		$photos = $this->photos;
		
		if (isset($photos[0]) && $photos[0] instanceof AutoModelYearPhoto && method_exists($photos[0], 'getThumb')) {
			return $photos[0]->getThumb($width, $height, $mode);
		} else {
			return "http://www.placehold.it/{$width}x{$height}/EFEFEF/AAAAAA";
		}
	}	
	
	public function getImage_preview()
	{
		return $this->getThumb(100, 60, 'crop');
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
		$data = array();
		$criteria=new CDbCriteria;
		$criteria->compare('t.year', $year);
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
	
	public static function getYears($model_id) 
	{
		$key = Tags::TAG_MODEL_YEAR . 'YEARS_'.$model_id;	
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$criteria=new CDbCriteria;

			$criteria->compare('model_id',$model_id);
			$criteria->compare('is_deleted',0);
			$criteria->compare('is_active',1);		
			$criteria->order = 'year DESC';		
		
			$data = CHtml::listData(AutoModelYear::model()->findAll($criteria), 'id', 'year');
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MODEL_YEAR));
		}
		
		return $data;			
	}
	
}