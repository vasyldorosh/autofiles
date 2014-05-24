<?php
class Tags implements ICacheDependency {
	
	const TAG_SERVICE = 'TAG_SERVICE';
	const TAG_SERVICE_RELATED = 'TAG_SERVICE_RELATED';
	const TAG_SERVICE_CATEGORY = 'TAG_SERVICE_CATEGORY';
	const TAG_TARIFF_REGION = 'TAG_TARIFF_REGION';
	const TAG_TENDER = 'TAG_TENDER';
	const TAG_TENDER_CATEGORY = 'TAG_TENDER_CATEGORY';
	const TAG_TENDER_NOTICE = 'TAG_TENDER_NOTICE';
	const TAG_CONNECTION_REGION = 'TAG_CONNECTION_REGION';
	const TAG_CONNECTION_CITY = 'TAG_CONNECTION_CITY';
	const TAG_CONNECTION_DISTRICT = 'TAG_CONNECTION_DISTRICT';
	const TAG_CONNECTION_STREET = 'TAG_CONNECTION_STREET';
	const TAG_VACANCY_FUNCTIONAL_DIRECTION = 'TAG_VACANCY_FUNCTIONAL_DIRECTION';
	const TAG_VACANCY_SPECIALIZATION = 'TAG_VACANCY_SPECIALIZATION';
	
	protected $timestamp;
	protected $tags;
	 
	/**
	 * В качестве параметров передается список тегов
	 *
	 * @params tag1, tag2, ..., tagN
	 */
	 function __construct() {
		$this->tags = func_get_args();
	 }
	 
	/**
	 * Evaluates the dependency by generating and saving the data related with dependency.
	 * This method is invoked by cache before writing data into it.
	 */
	 public function evaluateDependency() {
		$this->timestamp = time();
	 }
	 
	/**
	 * @return boolean whether the dependency has changed.
	 */
	 public function getHasChanged() {
		 $tags = array_map(function($i) { return TaggingBehavior::PREFIX.$i; }, $this->tags);
		 $values = Yii::app()->cache->mget($tags);
		 
		 foreach ($values as $value) {
		 if ((integer)$value > $this->timestamp) { return true; }
		 }
		 
		 return false;
	 }
}