<?php

class AutoModelYear extends CActiveRecord
{
	const CACHE_KEY_PHOTOS = 'AUTO_MODEL_YEAR_PHOTOS_';

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
		$criteria->compare('year',$this->year, true);
		$criteria->compare('model_id',$this->model_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50,
			),			
		));
	}
	
	
	public function getPhotos()
	{
		$key = self::CACHE_KEY_PHOTOS . $this->id;
		$cache = Yii::app()->cache->get($key);
		if (empty($cache)) {
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
}