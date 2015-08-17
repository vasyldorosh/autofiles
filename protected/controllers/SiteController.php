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
		
		$models = AutoModelYear::getOtherMakeYear($models, $modelYear['id']);
		
		$competitors = AutoModelYear::getFrontCompetitors($modelYear['id']);
		$carSpecsAndDimensions = AutoModelYear::getCarSpecsAndDimensions($modelYear['id']);
		$lastCompletion = AutoModelYear::getLastCompletion($modelYear['id']);
			
		$this->render('model_year', array(
			'make' => $make,
			'model' => $model,
			'modelYear' => $modelYear,
			'modelYears' => AutoModel::getYears($model['id']),
			'completions' => $completions,
			'models' => $models,
			'competitors' => $competitors,
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
			$model->save();
		}
		
		return $model->id;
	}

	public function actionPage($alias)
	{
		$title = SiteConfig::getInstance()->getValue('static_'.$alias.'_title');
		$this->pageTitle = $title;
		$this->meta_keywords = SiteConfig::getInstance()->getValue('static_'.$alias.'_meta_keywords');
		$this->meta_description = SiteConfig::getInstance()->getValue('static_'.$alias.'_meta_description');
		$content = SiteConfig::getInstance()->getValue('static_'.$alias.'_content');
		
		$this->breadcrumbs = array(
			'/' => 'Home',
			'#' => $title,
		);		
		
		$this->render('page', array(
			'title' => $title,
			'content' => $content,
		));
	}	
	
	public function actionFlush()
	{
		Yii::app()->cache->flush();
	}	
	
	public function actionConfigFlush()
	{
		Yii::app()->cache->delete(SiteConfig::CACHE_KEY);
	}	
	
	public function actionTest()
	{
		$items = Yii::app()->db->createCommand("SELECT vehicle_class_id, section_width_id, aspect_ratio_id, rim_diameter_id, load_index_id, is_rear, rear_section_width_id, rear_aspect_ratio_id, rear_rim_diameter_id, count(*) AS c FROM `tire` 
WHERE is_runflat=0
GROUP BY vehicle_class_id, section_width_id, aspect_ratio_id, rim_diameter_id, load_index_id, is_rear, rear_section_width_id, rear_aspect_ratio_id, rear_rim_diameter_id
HAVING c > 1
ORDER BY c DESC")->queryAll();
		
		$dataCompare = array();
		
		foreach ($items as $item) {
			$c = new CDbCriteria;
			$c->compare('vehicle_class_id', $item['vehicle_class_id']);
			$c->compare('section_width_id', $item['section_width_id']);
			$c->compare('aspect_ratio_id', $item['aspect_ratio_id']);
			$c->compare('rim_diameter_id', $item['rim_diameter_id']);
			$c->compare('load_index_id', $item['load_index_id']);
			$c->compare('is_rear', $item['is_rear']);
			$c->compare('rear_section_width_id', $item['rear_section_width_id']);
			$c->compare('rear_aspect_ratio_id', $item['rear_aspect_ratio_id']);
			$c->compare('rear_rim_diameter_id', $item['rear_rim_diameter_id']);
			$c->compare('is_runflat', 0);	
			$c->order = 'id';	

			$rows = Tire::model()->findAll($c);
			echo '- ' . $item['c'] . '<br/>';
			$compareId = 0;
			foreach ($rows as $key=>$row) {
				if ($key==0) {
					$compareId = $row->id;
					continue;
				}
				
				echo ' -- ' . $row->id . '<br/>';	
				
				$dataCompare[$row->id] = $compareId;				
			}			
		}
		
		foreach($dataCompare as $tire_id => $replace_id) {
			$c = new CDbCriteria;
			$c->compare('tire_id', $tire_id);
			$items = AutoModelYearTire::model()->findAll($c);
			$count = AutoModelYearTire::model()->count($c);
			echo "$tire_id: $count <br/>";

			foreach ($items as $item) {
				$c = new CDbCriteria;
				$c->compare('tire_id', $tire_id);				
				$c->compare('model_year_id', $item->model_year_id);		
				
				if (AutoModelYearTire::model()->count($c) == 0) {
					echo "not <br/>";
					$m = new AutoModelYearTire;
					$m->tire_id = $tire_id;
					$m->model_year_id = $item->model_year_id;
					$m->save();		
					echo 'AutoModelYearTire saved <br/>';					
				} 
			}
			
			
			$c = new CDbCriteria;
			$c->compare('tire_id', $tire_id);
			$range = TireRimWidthRange::model()->find($c);
				
			if (!empty($range)) {
				$attributes = array(
					'tire_id' => $replace_id,
				);
				$compare = TireRimWidthRange::model()->findByAttributes($attributes);
				
				if (empty($compare)) {
					$attributes = array(
						'tire_id' => $replace_id,
						'from' => $range->from,
						'to' => $range->to,
						'rear_from' => $range->rear_from,
						'rear_to' => $range->rear_to,						
					);					
					
					$compare = new TireRimWidthRange;
					$compare->attributes = $attributes;
					if(!$compare->save()) {
						d($compare->errors);
					}
					echo 'TireRimWidthRange saved <br/>';
				}
			}
			
			echo "range - $count <br/>";	
				
			Tire::model()->deleteByPk($tire_id);	
		}
	}
	
	public function actionTestRun()
	{
		ini_set('max_execution_time', 1000);
		
		$criteria = new CDbCriteria;		
		$criteria->with = array('Model', 'Model.Make');
		$modelYears = AutoModelYear::model()->findAll($criteria);
		foreach ($modelYears as $modelYear) {
			$tires = AutoModelYear::getTires($modelYear['id']);
			$sizes = array();
			foreach ($tires as $tire) {
				$d = Tire::diameter($tire);
				if ($d < 22)
				$sizes[]  = $d;
			}
			
			if (!empty($sizes)) {
			
				$min = min($sizes);
				$max = max($sizes);
					
				$percent = 0;	
				if ($min && $max && $min!=$max) {
					$percent = ($max - $min)/$min*100;
			
				}
				
				if ($percent >= 2) {
					echo $modelYear->Model->Make->title . ' ' . $modelYear->Model->title . ' ' . $modelYear->year . ' ' . round($percent, 2);
					echo "<br/>";
				}
			}
		}
	}
	
	public function actionT()
	{
		ini_set('max_execution_time', 1000);
		
		$criteria = new CDbCriteria;		
		$criteria->with = array('Model', 'Model.Make');
		$criteria->index = 'id';
		$modelYears = AutoModelYear::model()->findAll($criteria);
		$data = array();
		$dataModeYear = array();
		foreach ($modelYears as $modelYear) {
			$sql = "SELECT tire_id FROM  auto_model_year_tire WHERE model_year_id = {$modelYear->id} ORDER BY tire_id";
			$rows = Yii::app()->db->createCommand($sql)->queryAll();
			$key = $modelYear->model_id . '_';
			$key = '';
			foreach ($rows as $row) {
				$key .= '_' . $row['tire_id'];
			}
			if ($key!= '')
				$data[$modelYear->model_id][$key][] = (int)$modelYear->year;
			
			$dataModeYear[$modelYear->model_id][$modelYear->year] = $modelYear;
		}
		
		foreach ($data as $model_id=>$tires) {
			foreach ($tires as $tire_key=>$years) {
				sort($years);
				$data[$model_id][$tire_key] = $years;
			}			
		}
		//d($data);	
			
		$searchData = array();
		foreach ($data as $model_id=>$tires) {
			foreach ($tires as $tire_key=>$years) {
				
				if (count($years) == 1) {
					$searchData[$model_id][] = $years[0];
					continue;
				}
				
				foreach ($years as $k=>$year) {
					if (isset($years[$k+1])) {
						if (($years[$k+1]-$years[$k]) > 1) {
							for ($i=($year+1);$i<$years[$k+1];$i++) {
								$searchData[$model_id][] = $i;							
							}
						}
					} 
				}
			}			
		}
		
		//d($searchData);
		
		foreach ($searchData as $model_id=>$years) {
			foreach ($years as $year) {
				if (isset($dataModeYear[$model_id][$year])) {
					$modelYear = $dataModeYear[$model_id][$year];
					echo $modelYear->Model->Make->title . ' ' . $modelYear->Model->title . ' ' . $modelYear->year;
					echo "<br/>";
				}
			}
		}
	}
	
	public function actionR()
	{
		ini_set('max_execution_time', 1000);
		
		$criteria = new CDbCriteria;		
		$criteria->with = array('Model', 'Model.Make');
		$criteria->index = 'id';
		$modelYears = AutoModelYear::model()->findAll($criteria);
		$data = array();
		$dataModeYear = array();
		foreach ($modelYears as $modelYear) {
			
			$k = array();
			$k[] = (int) $modelYear->tire_rim_diameter_from_id;
			$k[] = (int) $modelYear->rim_width_from_id;
			$k[] = (int) $modelYear->tire_rim_diameter_to_id;
			$k[] = (int) $modelYear->rim_width_to_id;
			$k[] = (int) $modelYear->offset_range_from_id;
			$k[] = (int) $modelYear->offset_range_to_id;
			$k[] = (int) $modelYear->bolt_pattern_id;
			$k[] = (int) $modelYear->thread_size_id;
			$k[] = (int) $modelYear->center_bore_id;
			
			$k = implode('_', $k);
			
			$data[$modelYear->model_id][$k][] = (int)$modelYear->year;
			$dataModeYear[$modelYear->model_id][$modelYear->year] = $modelYear;
		}
		
		foreach ($data as $model_id=>$tires) {
			foreach ($tires as $tire_key=>$years) {
				sort($years);
				$data[$model_id][$tire_key] = $years;
			}			
		}
		//d($data);	
			
		$searchData = array();
		foreach ($data as $model_id=>$tires) {
			foreach ($tires as $tire_key=>$years) {
				
				if (count($years) == 1) {
					$searchData[$model_id][] = $years[0];
					continue;
				}
				
				foreach ($years as $k=>$year) {
					if (isset($years[$k+1])) {
						if (($years[$k+1]-$years[$k]) > 1) {
							for ($i=($year+1);$i<$years[$k+1];$i++) {
								$searchData[$model_id][] = $i;							
							}
						}
					} 
				}
			}			
		}
		
		//d($searchData);
		
		foreach ($searchData as $model_id=>$years) {
			foreach ($years as $year) {
				if (isset($dataModeYear[$model_id][$year])) {
					$modelYear = $dataModeYear[$model_id][$year];
					echo $modelYear->Model->Make->title . ' ' . $modelYear->Model->title . ' ' . $modelYear->year;
					echo "<br/>";
				}
			}
		}
	}
}