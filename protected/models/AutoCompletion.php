<?php

class AutoCompletion extends CActiveRecord
{
	public $model_id;
	public $year;

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
		return 'auto_completion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules = array(
			array('title, model_year_id', 'required'),
			array('model_id, code', 'safe'),
			array('year', 'numerical', 'integerOnly' => true),
		);
		
		$specs = AutoSpecs::getAll();
		foreach ($specs as $spec) {
			$rules[] = array('specs_'.$spec['alias'], 'safe');
		
			if ($spec['is_required'])		
				$rules[] = array('specs_'.$spec['alias'], 'required');
				
			if (in_array($spec['type'], array(AutoSpecs::TYPE_INT, AutoSpecs::TYPE_CHECKBOX, AutoSpecs::TYPE_SELECT)))
				$rules[] = array('specs_'.$spec['alias'], 'numerical', 'integerOnly' => true);
			
			if ($spec['type'] == AutoSpecs::TYPE_FLOAT)
				$rules[] = array('specs_'.$spec['alias'], 'numerical');		
		}	

		return $rules;
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'ModelYear' => array(self::BELONGS_TO, 'AutoModelYear', 'model_year_id', 'together'=>true,),
        );
	}	

	public function afterFind()
	{
		if (!empty($this->ModelYear) ) { 
			$this->model_id = $this->ModelYear->model_id;		
		}		
		
		return parent::afterFind();
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'id' => 'ID',
			'title' => Yii::t('admin', 'Title'),
			'rank' => Yii::t('admin', 'Rank'),
			'model_id' => Yii::t('admin', 'Model'),
			'model_year_id' => Yii::t('admin', 'Model'),
			'year' => Yii::t('admin', 'Year'),
		);
		
		$specs = AutoSpecs::getAll();
		foreach ($specs as $spec) {
			$labels['specs_'.$spec['alias']] = $spec['title'];
		}
		
		return $labels;
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
		$criteria->select = "t.id, t.title, ModelYear.*, Model.*";

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.title',$this->title, true);
		$criteria->compare('Model.id',$this->model_year_id);
		
		$criteria->with = array(
			'ModelYear',
			'ModelYear.Model',
		);
	
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
}