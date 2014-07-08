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
		
		$this->render('make', array(
			'make' => $make,
			'dataModels' => AutoMake::getModels($make['id']),
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
		$completionsTime = AutoCompletion::getItemsByYearOrderTime($lastModelYear['id']);
		
		//d($completionsTime);		
				
		$this->render('model', array(
			'make' => $make,
			'model' => $model,
			'lastModelYear' => $lastModelYear,
			'completion' => AutoModel::getLastCompletion($model['id']),
			'modelByYears' => $modelByYears,
			'models' => $models,
			'completionsTime' => $completionsTime,
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
		$models = AutoModel::model()->findAll();
		foreach ($models as $model) {
			$model->title = trim($model->title);
			$model->save(false);
		}
	}	
	
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
	
}