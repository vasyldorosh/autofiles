<?php

class SiteController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->pageTitle = SiteConfig::getInstance()->getValue('seo_home_title');
		$this->meta_keywords = SiteConfig::getInstance()->getValue('seo_home_meta_keywords');
		$this->meta_description = SiteConfig::getInstance()->getValue('seo_home_meta_description');
		
		$this->render('index', array(
			
		));
	}
	
	public function actionMake($alias)
	{
		$make = AutoMake::getMakeByAlias($alias);
		
		if (empty($make)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}
		
		$this->pageTitle = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_title'));
		$this->meta_keywords = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_meta_keywords'));
		$this->meta_description = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_meta_description'));		
		
		$this->breadcrumbs = array(
			'/' => 'Home',
			'#' => $make['title'],
		);
		
		SqlHelper::addView('AutoMake', $make['id']);
		
		$dataModels = AutoMake::getModels($make['id']);
		//d($dataModels);
		
		$this->render('make', array(
			'make' => $make,
			'dataModels' => $dataModels,
		));
	}
	
	public function actionModel($makeAlias, $modelAlias)
	{
		$make = AutoMake::getMakeByAlias($makeAlias);
		if (empty($make)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
	
		$model = AutoModel::getModelByMakeAndAlias($make['id'], $modelAlias);

		if (empty($model)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}
		
		$this->pageTitle = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_model_title'));
		$this->meta_keywords = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_model_meta_keywords'));
		$this->meta_description = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_model_meta_description'));		
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			$make['url'] => $make['title'],
			'#' => $model['title'],
		);
			
		$lastModelYear = AutoModel::getLastYear($model['id']);
		$modelByYears = AutoModel::getYears($model['id']);
		$models = AutoMake::getModels($make['id']);
		
		SqlHelper::addView('AutoModel', $model['id']);
		
		//d($completionsTime);		
				
		$this->render('model', array(
			'make' => $make,
			'model' => $model,
			'lastModelYear' => $lastModelYear,
			'completion' => AutoModel::getLastCompletion($model['id']),
			'modelByYears' => $modelByYears,
			'models' => $models,
		));
	}
	
	public function actionModelYear($makeAlias, $modelAlias, $year)
	{
		$make = AutoMake::getMakeByAlias($makeAlias);
		if (empty($make)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
	
		$model = AutoModel::getModelByMakeAndAlias($make['id'], $modelAlias);
		if (empty($model)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
	
		$modelYear = AutoModelYear::getYearByMakeAndModelAndAlias($make['id'], $model['id'], $year);
		if (empty($modelYear)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}		
	
		$this->pageTitle = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_model_year_title'));
		$this->meta_keywords = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_model_year_meta_keywords'));
		$this->meta_description = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_model_year_meta_description'));		
			
		SqlHelper::addView('AutoModelYear', $modelYear['id']);	
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			$make['url'] => $make['title'],
			$model['url'] => $model['title'],
			'#' => $modelYear['year'] . ' ' .$make['title'] . ' ' . $model['title'],
		);	
			
		$completions = AutoCompletion::getItemsByYear($modelYear['id']);
		$models = AutoModelYear::getModelsByMakeAndYear($make['id'], $modelYear['year']);
		
		/*
		d($modelYear['id'], 0);
		echo "===================================================================================================";
		d(AutoModelYear::getOtherMakeYear($models, $modelYear['id']), 0);
		echo "===================================================================================================";
		d($models);
		*/
		
		$models = AutoModelYear::getOtherMakeYear($models, $modelYear['id']);
		
		$competitors = AutoModelYear::getFrontCompetitors($modelYear['id']);
		//d($competitors);
		
		$carSpecsAndDimensions = AutoModelYear::getCarSpecsAndDimensions($modelYear['id']);
		$lastCompletion = AutoModelYear::getLastCompletion($modelYear['id']);
		
		//d($carSpecsAndDimensions);
		
		$this->render('model_year', array(
			'make' => $make,
			'model' => $model,
			'modelYear' => $modelYear,
			'modelYears' => AutoModel::getYears($model['id']),
			'completions' => $completions,
			'models' => $models,
			'competitors' => $competitors,
			'carSpecsAndDimensions' => $carSpecsAndDimensions,
			'lastCompletion' => $lastCompletion,
		));	
	}	
	
	public function actionModelYearPhotos($makeAlias, $modelAlias, $year)
	{
		$make = AutoMake::getMakeByAlias($makeAlias);
		if (empty($make)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
	
		$model = AutoModel::getModelByMakeAndAlias($make['id'], $modelAlias);
		if (empty($model)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
	
		$modelYear = AutoModelYear::getYearByMakeAndModelAndAlias($make['id'], $model['id'], $year);
		if (empty($modelYear)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}		
	
		$this->pageTitle = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_model_year_photos_title'));
		$this->meta_keywords = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_model_year_photos_meta_keywords'));
		$this->meta_description = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_model_year_photos_meta_description'));		
			

		$this->breadcrumbs = array(
			'/' => 'Home',
			$make['url'] => $make['title'],
			$model['url'] => $model['title'],
			$model['url'].$modelYear['year'].'/' => $modelYear['year'] . ' ' .$make['title'] . ' ' . $model['title'],
			'#' => 'Photos',
		);	
			
		$photos = AutoModelYearPhoto::getYearPhotos($modelYear['id']);	
			
		$this->render('model_year_photos', array(
			'make' => $make,
			'model' => $model,
			'modelYear' => $modelYear,
			'photos' => $photos,
			'description' => str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('model_year_photos_description')),
		));	
	}	
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}	
		
	/*	
	public function actionT()
	{
		ini_set('max_execution_time', 3600*12);
		$limit = 1000;
		for ($offset = 0; $offset <= 30000; $offset+=$limit) {
	
			$criteria=new CDbCriteria;
			$criteria->limit = $limit;		
			$criteria->offset = $offset;		
			$items = AutoCompletion::model()->findAll($criteria);
			if (empty($items)) {
				die();
			}
			
			foreach ($items as $item) {
			
				$sql = "UPDATE  auto_completion SET specs_0_60mph__0_100kmh_s_ =  '{$item->specs_0_60mph__0_100kmh_s_}', specs_1_4_mile_time =  '{$item->specs_1_4_mile_time}' WHERE  id={$item->id};<br/>";
				echo $sql;
			}
		}
	}
	*/
	
	/*
	public function actionPhoto()
	{
		$dir = Yii::getPathOfAlias('webroot') . '/photos/model_year_item/';
		$list = scandir($dir);
		foreach ($list as $file) {
			if (is_file($dir.$file)) {
				$image_info = getimagesize($dir.$file);
				if (!is_array($image_info) OR count($image_info) < 3) {
					echo $file . '<br/>';
					unlink($dir.$file);
				}
			}
		}	
	}
	*/
	
	public function actionTire()
	{
		$data = array();
		$limit = 100;
		$count = AutoCompletion::model()->count();
		
		
		for ($offset = 0; $offset <= $count; $offset+=$limit) {
			
			$sql = "SELECT specs_front_tires AS tire, id, model_year_id FROM  `auto_completion` LIMIT $offset, $limit";
			$rows = Yii::app()->db->createCommand($sql)->queryAll();
			foreach ($rows as $row) {
			
				$tireTitle = trim($row['tire']);

				if (!isset($data[$tireTitle])) {
			
					preg_match_all('/([A-Z].*?)([0-9].*?)\/([0-9].*?)([A-Z].*?)R([0-9]{1,2}.*?)/', $tireTitle, $match);
						
					$attributes = array();
						
					$noMatch = true;						
					foreach ($match as $m) {
						if (empty($m)) {
							$noMatch = false;
						}
					}
					
					if (!$noMatch) {
						preg_match_all('/([A-Z].*?)([0-9].*?)\/([A-Z].*?)R([0-9]{1,2}.*?)/', $tireTitle, $match);
						$attributes = array(
							'vehicle_class' => $match[1][0],
							'section_width' => $match[2][0],
							'speed_index' => $match[3][0],
							'rim_diameter' => $match[4][0],
							'aspect_ratio_id' => null,
						);
					} else {
						//d($match, 0);
						$attributes = array(
							'vehicle_class' => $match[1][0],
							'section_width' => $match[2][0],
							'aspect_ratio' => $match[3][0],
							'speed_index' => $match[4][0],
							'rim_diameter' => $match[5][0],
						);				
					}
							
					$tireAttr = array();
					
					if (strpos($row['tire'], 'flat')) {
						$tireAttr['is_runflat'] = 1;
					}
					
					$tireAttr['vehicle_class_id'] = $this->_getModelId('TireVehicleClass', array('code'=>$attributes['vehicle_class']));
					$tireAttr['section_width_id'] = $this->_getModelId('TireSectionWidth', array('value'=>$attributes['section_width']));
					if (isset($attributes['aspect_ratio']))
						$tireAttr['aspect_ratio_id'] = $this->_getModelId('TireAspectRatio', array('value'=>$attributes['aspect_ratio']));
					
					$tireAttr['speed_index_id'] = $this->_getModelId('TireSpeedIndex', array('code'=>$attributes['speed_index']));
					$tireAttr['rim_diameter_id'] = $this->_getModelId('TireRimDiameter', array('value'=>$attributes['rim_diameter']));
					
					$data[$tireTitle] = $this->_getModelId('Tire', $tireAttr);
				}
				
				$criteria=new CDbCriteria;
				$criteria->compare('model_year_id', $row['model_year_id']);		
				$criteria->compare('tire_id', $data[$tireTitle]);		
				$modelYearVsTire = AutoModelYearTire::model()->find($criteria);
				if (empty($modelYearVsTire)) {
					$modelYearVsTire = new AutoModelYearTire;
					$modelYearVsTire->model_year_id = $row['model_year_id'];
					$modelYearVsTire->tire_id = $data[$tireTitle];
					$modelYearVsTire->save();
				}
				
				//save model_year_tire
				
				echo $row['id'] . ' ' . $tireTitle .  '<br/>';
			}
		}
		d($data);
	}
	
	private function _getModelId($modelName, $attributes) {

		$criteria=new CDbCriteria;
		foreach ($attributes as $attribute=>$value) {
			if ($value === null) {
				$criteria->addCondition("{$attribute} IS NULL");
			} else {
				$criteria->compare($attribute, $value);
			}
		}
		
		$model = CActiveRecord::model($modelName)->find($criteria);
		if (empty($model)) {
			$attributes['rank'] = 0;
			$model = new $modelName;
			$model->attributes = $attributes;
		}
		
		return $model->id;
	}
	
}