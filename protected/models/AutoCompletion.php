<?php

class AutoCompletion extends CActiveRecord
{
	public $model_id;
	public $year;
	
	const PREFIX_SPECS = 'specs_';
	
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
			array('is_active, is_deleted', 'numerical', 'integerOnly' => true),
		);
		
		$specs = AutoSpecs::getAll();
		foreach ($specs as $spec) {
			$rules[] = array(self::PREFIX_SPECS.$spec['alias'], 'safe');
		
			if ($spec['is_required'])		
				$rules[] = array(self::PREFIX_SPECS.$spec['alias'], 'required');
				
			if (in_array($spec['type'], array(AutoSpecs::TYPE_INT, AutoSpecs::TYPE_CHECKBOX, AutoSpecs::TYPE_SELECT)))
				$rules[] = array(self::PREFIX_SPECS.$spec['alias'], 'numerical', 'integerOnly' => true);
			
			if ($spec['type'] == AutoSpecs::TYPE_FLOAT)
				$rules[] = array(self::PREFIX_SPECS.$spec['alias'], 'numerical');		
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
	
	protected function beforeSave()
	{
		$this->update_time = time();
		return parent::beforeSave();
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
			'is_active' => Yii::t('admin', 'Published'),
			'is_deleted' => Yii::t('admin', 'Deleted'),				
		);
		
		$specs = AutoSpecs::getAll();
		foreach ($specs as $spec) {
			$labels[self::PREFIX_SPECS.$spec['alias']] = $spec['title'];
		}
		
		return $labels;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.title',$this->title, true);
		$criteria->compare('t.is_deleted',$this->is_deleted);
		$criteria->compare('t.is_active',$this->is_active);			
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
	
	public static function deleteSpecsAttributes()
	{
		$columns = AutoCompletion::model()->getMetaData()->tableSchema->columns;
		foreach ($columns as $field=>$data) {
			if (preg_match('/^[specs_]/', $field) && $field!='code') {
				Yii::app()->db->createCommand()->dropColumn('auto_completion', $field);
			}
		}
	}
}