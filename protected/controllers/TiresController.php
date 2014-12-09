<?php

class TiresController extends Controller
{
	public function actionIndex()
	{
		$this->pageTitle = SiteConfig::getInstance()->getValue('seo_tires_title');
		$this->meta_keywords = SiteConfig::getInstance()->getValue('seo_tires_meta_keywords');
		$this->meta_description = SiteConfig::getInstance()->getValue('seo_tires_meta_description');		
		
		$this->breadcrumbs = array(
			'/' => 'Home',
			'#' => 'Tires',
		);		
		
		$this->render('index', array(
			
		));
	}
	
	public function actionMake($alias)
	{
		$make = AutoMake::getMakeByAlias($alias);
		
		if (empty($make)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}
		
		$this->pageTitle = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_tires_make_title'));
		$this->meta_keywords = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_tires_make_meta_keywords'));
		$this->meta_description = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_tires_make_meta_description'));		
		$header_text_block = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('tires_make_header_text_block'));		
		
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/tires.html' => 'Tires',
			'#' => $make['title'],
		);
		
		//SqlHelper::addView('AutoMake', $make['id']);
		
		$dataModels = AutoMake::getModels($make['id']);

		$this->render('make', array(
			'header_text_block' => $header_text_block,
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
		
		$this->pageTitle = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_tires_model__title'));
		$this->meta_keywords = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_tires_model__meta_keywords'));
		$this->meta_description = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_tires_model__meta_description'));		
		$header_text_block = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('tires_model_header_text_block'));		
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/tires.html' => 'Tires',
			'/tires'.$make['url'] => $make['title'],
			'#' => $model['title'],
		);
			
		$modelByYears = AutoModel::getYears($model['id']);
		
		//SqlHelper::addView('AutoModel', $model['id']);

		$this->render('model', array(
			'make' => $make,
			'model' => $model,
			'modelByYears' => $modelByYears,
			'header_text_block' => $header_text_block,
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
	
		$this->pageTitle = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_tires_model_year_title'));
		$this->meta_keywords = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_tires_model_year_meta_keywords'));
		$this->meta_description = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('seo_tires_model_year_meta_description'));		
		$header_text_block = str_replace(array('[make]', '[model]', '[year]'), array($make['title'], $model['title'], $modelYear['year']), SiteConfig::getInstance()->getValue('tires_model_year_header_text_block'));		
			
		//SqlHelper::addView('AutoModelYear', $modelYear['id']);	
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/tires.html' => 'Tires',
			'/tires'.$make['url'] => $make['title'],
			'/tires'.$model['url'] => $model['title'],
			'#' => $modelYear['year'] . ' ' .$make['title'] . ' ' . $model['title'],
		);	
			
		$models = AutoModelYear::getModelsByMakeAndYear($make['id'], $modelYear['year']);

		$carSpecsAndDimensions = AutoModelYear::getCarSpecsAndDimensions($modelYear['id']);
			
		$this->render('model_year', array(
			'make' => $make,
			'model' => $model,
			'modelYear' => $modelYear,
			'modelYears' => AutoModel::getYears($model['id']),
			'competitors' => AutoModelYear::getFrontCompetitors($modelYear['id']),
			'otherModels' => AutoModelYear::getOtherMakeYear($models, $modelYear['id']),
			'carSpecsAndDimensions' => $carSpecsAndDimensions,
			'header_text_block' => $header_text_block,
			'tires' => AutoModelYear::getTires($modelYear['id']),
		));	
	}	
	
	public function actionDiameter($value)
	{
		$model = TireRimDiameter::getItemByValue($value);

		if (empty($model)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
			
		$this->pageTitle = str_replace(array('[diameter]'), array($value), SiteConfig::getInstance()->getValue('seo_tires_diameter_title'));
		$this->meta_keywords = str_replace(array('[diameter]'), array($value), SiteConfig::getInstance()->getValue('seo_tires_diameter_meta_keywords'));
		$this->meta_description = str_replace(array('[diameter]'), array($value), SiteConfig::getInstance()->getValue('seo_tires_diameter_meta_description'));		
		$header_text_block = str_replace(array('[diameter]'), array($value), SiteConfig::getInstance()->getValue('tires_diameter_header_text_block'));		
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/tires.html' => 'Tires',
			'#' => 'R'.$value,
		);	
					
		$this->render('diameter', array(
			'tires' => Tire::getItemsByRimDiameterNonRunflat($model['id']),
			'model' => $model,
			'header_text_block' => $header_text_block,
		));	
	}	
	
	public function actionSize($vehicle_class, $section_width, $aspect_ratio, $rim_diameter)
	{
		$attributes = array(
			'vc.code' => $vehicle_class,
			'sw.value' => $section_width,
			'ar.value' => $aspect_ratio,
			'rd.value' => $rim_diameter,
		);

		$tires = Tire::getItemsByAttributes($attributes);

		if (empty($tires)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
		$tire = $tires[0];
		
		$ids = array();
		foreach ($tires as $item) {
			$ids[] = $item['id'];
		}
		
		$makeModels = Tire::getMakeModelsByTireIds($ids);
		
		$replaceFrom = array('[vehicle_class]', '[section_width]', '[aspect_ratio]', '[rim_diameter]');
		$replaceTo = array($vehicle_class, $section_width, $aspect_ratio, $rim_diameter);
		
		$this->pageTitle = str_replace($replaceFrom, $replaceTo, SiteConfig::getInstance()->getValue('seo_tires_size_title'));
		$this->meta_keywords = str_replace($replaceFrom, $replaceTo, SiteConfig::getInstance()->getValue('seo_tires_size_meta_keywords'));
		$this->meta_description = str_replace($replaceFrom, $replaceTo, SiteConfig::getInstance()->getValue('seo_tires_size_meta_description'));		
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/tires.html' => 'Tires',
			'#' => Tire::format($tire),
		);	
			
		$similarSizes = Tire::getSimilarSizes($tire);
			
		$this->render('size', array(
			'tire' => $tire,
			'makeModels' => $makeModels,
			'similarSizes' => $similarSizes,
		));	
	}	
	
	public function actionSizeMake($makeAlias, $vehicle_class, $section_width, $aspect_ratio, $rim_diameter)
	{
		$make = AutoMake::getMakeByAlias($makeAlias);
		
		if (empty($make)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
		
		$attributes = array(
			'vc.code' => $vehicle_class,
			'sw.value' => $section_width,
			'ar.value' => $aspect_ratio,
			'rd.value' => $rim_diameter,
		);

		$tires = Tire::getItemsByAttributes($attributes);

		if (empty($tires)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	
		$tire = $tires[0];
		
		$ids = array();
		foreach ($tires as $item) {
			$ids[] = $item['id'];
		}
		
		$modelYears = Tire::getModelYearsByMakeTireIds($make['id'], $ids);
		
		$replaceFrom = array('[make]', '[vehicle_class]', '[section_width]', '[aspect_ratio]', '[rim_diameter]');
		$replaceTo = array($make['title'], $vehicle_class, $section_width, $aspect_ratio, $rim_diameter);

		$this->pageTitle = str_replace($replaceFrom, $replaceTo, SiteConfig::getInstance()->getValue('seo_tires_size_make_title'));
		$this->meta_keywords = str_replace($replaceFrom, $replaceTo, SiteConfig::getInstance()->getValue('seo_tires_size_make_meta_keywords'));
		$this->meta_description = str_replace($replaceFrom, $replaceTo, SiteConfig::getInstance()->getValue('seo_tires_size_make_meta_description'));		
		$header_text_block = str_replace($replaceFrom, $replaceTo, SiteConfig::getInstance()->getValue('tires_size_make_header_text_block'));		
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/tires.html' => 'Tires',
			Tire::url($tire) => Tire::format($tire),
			'#' => $make['title'],
		);	
			
		$this->render('size_make', array(
			'make' => $make,
			'tire' => $tire,
			'modelYears' => $modelYears,
			'header_text_block' => $header_text_block,
		));	
	}	
	

	
}