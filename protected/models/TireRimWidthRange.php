<?php

class TireRimWidthRange extends CActiveRecord
{		
	public $storage = array();

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
		return 'tire_rim_width_range';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tire_id, from, to', 'required'),
			array('tire_id', 'unique', 'message'=>'{attribute} has already been taken.'),
			array('tire_id', 'numerical', 'integerOnly' => true),
			array('from, to', 'numerical'),
			array('id', 'safe', 'on' => 'search'),
		);
	}		
		
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' 		=> 'ID',
			'tire_id' 	=> Yii::t('admin', 'Tire'),
			'from'		=> Yii::t('admin', 'From'),
			'to'		=> Yii::t('admin', 'To'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'Tire' => array(self::BELONGS_TO, 'Tire', 'tire_id', 'together'=>true,), //value
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.tire_id',$this->tire_id);
		$criteria->compare('t.from',$this->from);
		$criteria->compare('t.to',$this->to);
		$criteria->with = array('Tire'=>array('together'=>true));
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
			),			
		));
	}
	
	public function import()
	{
		$filename = Yii::getPathOfAlias('webroot') . '/import/Tire_replacement_pressure.xls';
		Yii::import('ext.phpexcelreader.JPhpExcelReader');
		$excelReader = new JPhpExcelReader($filename);		
		$tireRange = array();
		
		//d($excelReader->sheets[1]['cells']);
		
		//pessenger
		foreach ($excelReader->sheets[0]['cells'] as $data) {
			$tire = false;
			
			if (isset($data[1])) {
				$tire = $this->_importGetTire($data[1]);
				if ($tire !== false) {
					$tires[] = $tire;
				}
			} else if (isset($data[2])) {
				$tire = $this->_importGetTire($data[2]);
				if ($tire !== false) {
					$tires[] = $tire;
				}
			}
			
			if ($tire !== false) {
				$tire['vehicle_class_id'] = 1;
				$rangeAttributes = array(
					'tire_id' => $this->_importGetTireId($tire),
				);
				
				if (isset($data[5])) {
					$expl = explode('-', $data[5]);
					if (count($expl) == 2) {
						$rangeAttributes['from'] = (float)$expl[0];
						$rangeAttributes['to'] = (float)$expl[1];
					}
 				}
				
				
				$tireRange[] = $rangeAttributes;
			}
		}	
		
		//LT
		foreach ($excelReader->sheets[1]['cells'] as $data) {
			$tire = false;
			
			if (isset($data[1])) {
				$tire = $this->_importGetTire($data[1]);
				if ($tire !== false) {
					$tires[] = $tire;
				}
			} 
			
			if ($tire !== false) {
				$tire['vehicle_class_id'] = 2;
				$rangeAttributes = array(
					'tire_id' => $this->_importGetTireId($tire),
				);
				
				if (isset($data[3])) {
					$expl = explode('-', $data[3]);
					if (count($expl) == 2) {
						$rangeAttributes['from'] = (float)$expl[0];
						$rangeAttributes['to'] = (float)$expl[1];
					}
 				}
				
				
				$tireRange[] = $rangeAttributes;
			}
		}		
		

		foreach ($tireRange as $attr) {
			$model = TireRimWidthRange::model()->findByAttributes(array('tire_id'=>$attr['tire_id']));
			if (empty($model)) {
				$model = new TireRimWidthRange();
			}
			$model->attributes = $attr;
			$model->save();
		}
	}
	
	private function _importGetTire($string) {
		$tire = array();
		if (preg_match('/([0-9]{1,3}(.*?))\/([0-9]{1,3}(.*?))R([0-9]{1,3}(.*?))/', $string, $match)) {
			if (!empty($match[1]) && !empty($match[3]) && !empty($match[5])) {
				$tire = array (
					'section_width_id'	=> $this->_importGetModelByValue('TireSectionWidth', $match[1]),
					'aspect_ratio_id' 	=> $this->_importGetModelByValue('TireAspectRatio', $match[3]),
					'rim_diameter_id' 	=> $this->_importGetModelByValue('TireRimDiameter', $match[5]),
				);
				
				return $tire;
			}
		}

		return false;
	}
	
	private function _importGetModelByValue($modelName, $value) {
		$value = (float) $value;
		
		if (!isset($this->storage[$modelName][$value])) {		
			$model = CActiveRecord::model($modelName)->findByAttributes(array('value'=>$value));
			if (empty($model)) {
				$model = new $modelName;
				$model->value = $value;
				$model->rank = 0;
				$model->save();
			}
			
			$this->storage[$modelName][$value] = $model->id;
		} 
		
		return $this->storage[$modelName][$value];
	}
			
	private function _importGetTireId($attributes) {
		
		$tire = Tire::model()->findByAttributes($attributes);
		if (empty($tire)) {
			$tire = new Tire;
			$tire->attributes = $attributes;
			$tire->save();
		}
		
		if (!empty($tire))
			return $tire->id;
	}
			
}