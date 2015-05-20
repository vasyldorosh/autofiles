<?php
/**
 * Класс PlatformVsModel
 */
class PlatformVsModel extends CActiveRecord
{
	/**
	 * Получить экземпляр класса
	 * @return PlatformVsModel
	 */
	public static function model($className = __CLASS__) { return parent::model($className);}

	/**
	 * Ассоциированная таблица
	 * @return string
	 */
	public function tableName() { return 'platform_vs_model';}

	/**
	 * Составной первичный ключ
	 * @return array
	 */
	public function primaryKey() { return array('platform_id', 'model_id',);}
	
	/**
	 * Правила валидации
	 * @return array
	 */
	public function rules()
	{
		return array(
			array(
				'platform_id, model_id',
				'required',
			),
		);
	}
}