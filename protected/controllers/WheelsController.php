<?php

class WheelsController extends Controller
{
	public function actionIndex()
	{
		$this->pageTitle = SiteConfig::getInstance()->getValue('seo_wheels_title');
		$this->meta_keywords = SiteConfig::getInstance()->getValue('seo_wheels_meta_keywords');
		$this->meta_description = SiteConfig::getInstance()->getValue('seo_wheels_meta_description');		
		
		$this->breadcrumbs = array(
			'/' => 'Home',
			'#' => 'Wheels',
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
		
		$this->pageTitle = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_wheels_make_title'));
		$this->meta_keywords = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_wheels_make_meta_keywords'));
		$this->meta_description = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_wheels_make_meta_description'));		
		$header_text_block = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('wheels_make_header_text_block'));		
		
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/wheels.html' => 'Wheels',
			'#' => $make['title'],
		);
		
		$dataModels = AutoMake::getModels($make['id']);

		$this->render('make', array(
			'header_text_block' => $header_text_block,
			'make' => $make,
			'dataModels' => $dataModels,
			'dataModelsWheels' => AutoMake::getWheelsData($make['id']),
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
		
		$this->pageTitle = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_wheels_model_title'));
		$this->meta_keywords = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_wheels_model_meta_keywords'));
		$this->meta_description = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('seo_wheels_model_meta_description'));		
		$header_text_block = str_replace(array('[make]', '[model]'), array($make['title'], $model['title']), SiteConfig::getInstance()->getValue('wheels_model_header_text_block'));		
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/wheels.html' => 'Wheels',
			'/wheels'.$make['url'] => $make['title'] . ' wheels',
			'#' => $model['title'],
		);
			
		$modelByYears = AutoModel::getYears($model['id']);
		$lastModelYear = AutoModel::getLastYear($model['id']);
				
		$wheelsDataItems = AutoModel::getWheelsDataFull($model['id']);
		foreach ($wheelsDataItems as $k => $v) {
			$wheelsDataItems[$k]['custom_rim_sizes_range'] = Project::getCustomRimSizesRangeByModelYears($v['ids']);
			$wheelsDataItems[$k]['tires_range_from'] = AutoModelYear::getTireRangeByModelYears($v['ids'], 'ASC');
			$wheelsDataItems[$k]['tires_range_to'] = AutoModelYear::getTireRangeByModelYears($v['ids'], 'DESC');
			$wheelsDataItems[$k]['custom_rim_sizes'] = Project::getCustomRimSizes($v['ids']);
		}
		
		if (isset($_GET['t']))
			d($wheelsDataItems);
		
		
		$this->render('model', array(
			'lastModelYear' => $lastModelYear,
			'make' => $make,
			'model' => $model,
			'modelByYears' => $modelByYears,
			'header_text_block' => $header_text_block,
			'wheelsDataItems' => $wheelsDataItems,
		));
	}
	
	public function actionDiametrWidth($diametr, $width)
	{	
		$diametrList =  array_flip (TireRimDiameter::getList());
		$diametr_id = null;
		if (isset($diametrList[$diametr])) {
			$diametr_id = $diametrList[$diametr];
		}

		$widthList =  array_flip(RimWidth::getAll());
		$width_id = null;
		if (isset($widthList[$width])) {
			$width_id = $widthList[$width];
		}
		
		if (empty($diametr_id) || empty($width_id)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}	

		$rim = "{$diametr}x{$width}";
				
		$this->pageTitle = str_replace(array('[diametr]', '[width]'), array($diametr, $width), SiteConfig::getInstance()->getValue('seo_wheels_diametr_width_title'));
		$this->meta_keywords = str_replace(array('[diametr]', '[width]'), array($diametr, $width), SiteConfig::getInstance()->getValue('seo_wheels_diametr_width_meta_keywords'));
		$this->meta_description = str_replace(array('[diametr]', '[width]'), array($diametr, $width), SiteConfig::getInstance()->getValue('seo_wheels_diametr_width_meta_description'));		
		$header_text_block = str_replace(array('[diametr]', '[width]'), array($diametr, $width), SiteConfig::getInstance()->getValue('wheels_model_header_text_block'));		
			
		$this->breadcrumbs = array(
			'/' => 'Home',
			'/wheels.html' => 'Wheels',
			'#' => $rim,
		);
		
		$tireRangeData = TireRimWidthRange::getData();
		$recommendedTireSizes = Project::getRecommendedTireSizes($diametr_id, $width);
		$possibleTireSizes = Project::getPossibleTireSizesByRim($diametr_id, $width_id);
		
		if (isset($_GET['t'])) {
			d($recommendedTireSizes);
			//d($possibleTireSizes);
		}	
		
		
		
		$this->render('diametr_width', array(
			'header_text_block' => $header_text_block,
			'rim' => $rim,
			'diametr' => $diametr,
			'width' => $width,
			'possibleTireSizes' => $possibleTireSizes,
			'tireRangeData' => $tireRangeData,
		));
	}
	
}