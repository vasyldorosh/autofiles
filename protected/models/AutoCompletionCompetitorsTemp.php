<?php

class AutoCompletionCompetitorsTemp extends CActiveRecord
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
		return 'auto_completion_competitors_temp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('completion_id, competitor_id', 'required'),
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'Completion' => array(self::BELONGS_TO, 'AutoCompletion', 'completion_id', 'together'=>true,),
            'Competitor' => array(self::BELONGS_TO, 'AutoCompletion', 'competitor_id', 'together'=>true,),
        );
	}	

}