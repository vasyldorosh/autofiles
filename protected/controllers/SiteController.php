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
	
	private function getMake($alias)
	{
		$key = Tags::TAG_MAKE . '_ITEM_'.$alias;
		$make = Yii::app()->cache->get($key);
		if ($make == false) {
			$make = array();
			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('t.alias', $alias);
			$model = AutoMake::model()->find($criteria);
			
			if (!empty($model)) {
				$make = array(
					'id' => $model->id,
					'title' => $model->title,
					'description' => $model->description,
					'photo' => $model->getThumb(150, null, 'resize'),
				);
			}
			
			Yii::app()->cache->set($key, $make, 60*60*24*31, new Tags(Tags::TAG_MAKE));
		}	
		
		return $make;
	}
	
	public function actionMake($alias)
	{
		$make = $this->getMake($alias);
		
		if (empty($make)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}
		
		$this->pageTitle = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_title'));
		$this->meta_keywords = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_meta_keywords'));
		$this->meta_description = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_meta_description'));		
		
		$key = Tags::TAG_MODEL . '_LIST_'.$make['id'];
		$dataModels = Yii::app()->cache->get($key);
		if ($dataModels == false) {
			$criteria = new CDbCriteria();
			$criteria->compare('t.is_active', 1);
			$criteria->compare('t.is_deleted', 0);
			$criteria->compare('t.make_id', $make['id']);
			$criteria->compare('Make.is_active', 1);
			$criteria->compare('Make.is_deleted', 0);
			$criteria->with = array('Make' => array('together'=>true));
			
			$models = AutoModel::model()->findAll($criteria);

			foreach ($models as $model) {
				$price = $model->getMinMaxMsrp();
				$lastCompletion = $model->getLastCompletion();
				$years = AutoModelYear::getYears($model['id']);
				$lastYear = $model->getLastYear();
				
				$row = array(
					'id' => $model->id,
					'title' => $model->title,
					'url' => $model->urlFront,
					'price' => array(
						'min' => $price['mmin'],
						'max' => $price['mmax'],
					),
					'completion' => array(
						'engine' => AutoSpecsOption::getV('engine', $lastCompletion['specs_engine']),
						'fuel_economy_city' => AutoSpecsOption::getV('fuel_economy__city', $lastCompletion['specs_fuel_economy__city']),
						'fuel_economy_highway' => AutoSpecsOption::getV('fuel_economy__highway', $lastCompletion['specs_fuel_economy__highway']),
						'standard_seating' => AutoSpecsOption::getV('standard_seating', $lastCompletion['specs_standard_seating']),
					),
					'years' => $years,
				);
				
				if (!empty($lastYear)) {
					$row['lastYear'] = $lastYear->year;
					$row['photo'] = $lastYear->getThumb(150, null, 'resize');
				}
				
				$dataModels[] = $row;
			}
			
			Yii::app()->cache->set($key, $dataModels, 60*60*24*31, new Tags(Tags::TAG_MODEL, Tags::TAG_MODEL_YEAR, Tags::TAG_COMPLETION));
		}
		
		$this->render('make', array(
			'make' => $make,
			'dataModels' => $dataModels,
		));
	}
	
	public function actionPpp()
	{
		$sql = "SELECT id, model_id, year, url FROM  auto_model_year WHERE file_name ='' ORDER BY id DESC LIMIT 500";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		$urls = array();
		foreach ($rows as $row) {
			$s = "-".$row['year'];
			$url = str_replace(array("cars-", $s), array("",""), $row['url']);
			$url = 'http://autos.aol.com'.$url;
			echo $row['id'] . '<br/>';
		}
	}
	
	
	public function actionModel($makeAlias, $modelAlias)
	{
		$make = $this->getMake($makeAlias);
	
		$criteria = new CDbCriteria();
		$criteria->compare('t.is_active', 1);
		$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.alias', $modelAlias);
		$criteria->compare('Make.alias', $makeAlias);
		$criteria->compare('Make.is_active', 1);
		$criteria->compare('Make.is_deleted', 0);
		
		$criteria->with = array('Make');
		
		$model = AutoModel::model()->find($criteria);
		if (empty($model)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}
		
		$makeTitle = $model->Make->title;
		
		$this->pageTitle = str_replace(array('[make]', '[model]'), array($model['title'], $makeTitle), SiteConfig::getInstance()->getValue('seo_model_title'));
		$this->meta_keywords = str_replace(array('[make]', '[model]'), array($model['title'], $makeTitle), SiteConfig::getInstance()->getValue('seo_model_meta_keywords'));
		$this->meta_description = str_replace(array('[make]', '[model]'), array($model['title'], $makeTitle), SiteConfig::getInstance()->getValue('seo_model_meta_description'));		
				
		
		$criteria = new CDbCriteria();
		$criteria->compare('t.is_active', 1);
		$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.model_id', $model['id']);
		
		$modelByYears = AutoModelYear::model()->findAll($criteria);
		
		$criteria = new CDbCriteria();
		$criteria->compare('t.is_active', 1);
		$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.make_id', $model['make_id']);
		$criteria->order = 'title';
		
		$models = AutoModel::model()->findAll($criteria);
		
		$this->render('model', array(
			'make' => $make,
			'models' => $models,
			'model' => $model,
			'modelByYears' => $modelByYears,
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
	
	public function actionT()
	{
		// This import is better to be included in your main
		// config file. For those newbies to the framework, 
		// please recall that this is a path alias, you should 
		// write exactly where it is
		Yii::import('application.components.yii-aws.components.*');

		$s3 = new A2S3();
		$response = $s3->listBuckets(); // we are going to list the buckets

		// just for the sake of the example
		print_r($response);
	}	
	
}