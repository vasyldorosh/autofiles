<?php

class Platform extends CActiveRecord
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
		return 'platform';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, alias, category_id, year_from, year_to, model_id', 'required'),
			array('alias', 'unique'),
			array('year_from, year_to', 'numerical', 'integerOnly' => true),
			array('id', 'safe',),	
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

	protected function afterValidate()
	{
		if (is_numeric($this->year_to) && is_numeric($this->year_from) && $this->year_to < $this->year_from) {
			$this->addError('year_to', '"Year to" should be more "Year from"');
		}
		
		return parent::afterValidate();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'Model' => array(self::BELONGS_TO, 'AutoModel', 'model_id', 'together'=>true,),
            'Category' => array(self::BELONGS_TO, 'PlatformCategory', 'category_id', 'together'=>true,),
        );
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
	
	public function afterSave()
	{		
		// set platforms modelYear
		if ($this->isNewRecord) {
			$criteria=new CDbCriteria;
			$criteria->compare('model_id',$this->model_id);			
			$criteria->addCondition("year <= {$this->year_to} AND year >= {$this->year_from} AND platform_id IS NULL");
			$items = AutoModelYear::model()->findAll($criteria);
			foreach ($items as $item) {
				$item->platform_id = $this->id;
				$item->save(false);
			}
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('admin', 'Title'),
			'alias' => Yii::t('admin', 'Alias'),
			'category_id' => Yii::t('admin', 'Category'),
			'model_id' => Yii::t('admin', 'Model'),
			'year_from' => Yii::t('admin', 'Year from'),
			'year_to' => Yii::t('admin', 'Year to'),
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
		$criteria->compare('title',$this->title, true);
		$criteria->compare('alias',$this->alias, true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('year_from',$this->year_from);
		$criteria->compare('year_to',$this->year_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
			),			
		));
	}
	
	private function _clearCache()
	{
		Yii::app()->cache->clear(Tags::TAG_AUTO_PLATFORM);
	}
		
	public function getModelTitle()
	{
		return $this->Model->Make->title . " " . $this->Model->title;
	}	
	
	public function getTitleRange()
	{
		return "{$this->year_from}-{$this->year_to} {$this->title}";
	}
	
	public static function getListByModel($model_id)
	{
		$model_id = (int)$model_id;
		
		$criteria=new CDbCriteria;
		$criteria->compare('model_id',$model_id);
		$items = self::model()->findAll($criteria);
		$data = array();
		
		foreach ($items as $item) {
			$data[$item->id] = $item->getTitleRange();
		}
		
		return $data;
	}
	
}