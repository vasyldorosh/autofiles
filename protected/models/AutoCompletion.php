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
		Yii::app()->cache->clear(Tags::TAG_COMPLETION);
	}
	
	
	public static function getItemsByYear($model_year_id) 
	{
		$model_year_id = (int) $model_year_id;
		
		$key = Tags::TAG_COMPLETION . '_MODEL_BY_YEAR_'.$model_year_id;	
		$data = Yii::app()->cache->get($key);

		if ($data == false) {
			$data = array();
			$criteria=new CDbCriteria;

			$criteria->compare('model_year_id',$model_year_id);
			$criteria->compare('is_deleted',0);
			$criteria->compare('is_active',1);			
		
		
			$items = self::model()->findAll($criteria);
			foreach ($items as $item) {
				$data[] = $item->attributes;
			}
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_COMPLETION));
		}
		
		return $data;			
	}	
	
	public static function getFastest($limit=6)
	{
		$key = Tags::TAG_COMPLETION . '_FASTEST_' . $limit;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false) {
			$sql = "SELECT 
						MAX(specs_0_60mph__0_100kmh_s_) AS speed,
						c.id AS id,
						c.specs_1_4_mile_time AS mile_time,
						c.specs_1_4_mile_speed AS mile_speed,
						c.specs_horsepower AS horsepower,
						c.specs_torque AS torque,
						c.specs_engine AS engine,
						y.year AS year,
						y.id AS year_id,
						m.title AS model_title,
						m.alias AS model_alias,
						k.title AS make_title,
						k.alias AS make_alias
					FROM auto_completion AS c
					LEFT JOIN auto_model_year AS y ON c.model_year_id = y.id
					LEFT JOIN auto_model AS m ON y.model_id = m.id
					LEFT JOIN auto_make AS k ON m.make_id = k.id
					WHERE 
						c.is_active = 1 AND 
						c.is_deleted = 0 AND
						c.specs_0_60mph__0_100kmh_s_ IS NOT NULL AND
						y.is_active = 1 AND
						y.is_deleted = 0 AND
						m.is_active = 1 AND
						m.is_deleted = 0 AND
						k.is_active = 1 AND
						k.is_deleted = 0
					GROUP BY c.model_year_id
					ORDER BY speed ASC
					LIMIT {$limit}
					";
					
			$rows = Yii::app()->db->createCommand($sql)->queryAll();	
			$data = array();
			
			$ids = array();
			foreach ($rows as $row) {
				$ids[] = $row['year_id'];
			}
			
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$ids);			
			$criteria->index = 'id';			
			$modelYears = AutoModelYear::model()->findAll($criteria);

			foreach ($rows as $row) {

				$expl = explode('@', $row['horsepower']);
				$row['horsepower'] = $expl[0];
				
				$expl = explode('@', $row['torque']);
				$row['torque'] = $expl[0];
				$row['photo'] = $modelYears[$row['year_id']]->getThumb(150, null, 'resize');
				$row['engine'] = AutoSpecsOption::getV('engine', $row['engine']);
				
				$data[] = $row;
			}
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MAKE, Tags::TAG_MODEL, Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;		
	}
	
	
	public static function getMakeTimes($make_id)
	{
		$key = Tags::TAG_COMPLETION . '_MAKE_TIMES_' . $make_id;
		$data = Yii::app()->cache->get($key);
		
		if ($data == false || true) {
			$data = array();
			$models = AutoMake::getModels($make_id);
			foreach ($models as $model) {
				$data[$model['id']]['title'] = $model['title'];
				$data[$model['id']]['0_60_times'] = AutoModel::getMinMaxSpecs('0_60mph__0_100kmh_s_', $model['id']);
				$data[$model['id']]['mile_time']['max'] = AutoModel::getMaxSpecs('1_4_mile_time', $model['id']);				
				$data[$model['id']]['mile_speed']['max'] = AutoModel::getMaxSpecs('1_4_mile_speed', $model['id']);
				$data[$model['id']]['mile_time']['min'] = AutoModel::getMinSpecs('1_4_mile_time', $model['id']);				
				$data[$model['id']]['mile_speed']['min'] = AutoModel::getMinSpecs('1_4_mile_speed', $model['id']);
			}
				
			usort ($data, "cmp");	
				
			//d($data);
			
			Yii::app()->cache->set($key, $data, 0, new Tags(Tags::TAG_MAKE, Tags::TAG_MODEL, Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		return $data;		
	}
	
}


	function cmp ($a, $b)
	{
		if ($a['0_60_times']['mmin'] == $b['0_60_times']['mmin']) return 0;
		return ($a['0_60_times']['mmin'] < $b['0_60_times']['mmin']) ? -1 : 1;
	}	