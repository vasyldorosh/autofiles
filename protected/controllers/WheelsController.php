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
		$listDiameter 	= TireRimDiameter::getList();
		$listWidth 		= RimWidth::getAll();
		$allRims 		= Project::getAllRims();
		
		$diametrList =  array_flip ($listDiameter);
		$diametr_id = null;
		if (isset($diametrList[$diametr])) {
			$diametr_id = $diametrList[$diametr];
		}
	
		$widthList =  array_flip(RimWidth::getAll());
		$width_id = null;
		if (isset($widthList[$width])) {
			$width_id = $widthList[$width];
		}
		
		$rim = "{$diametr}x{$width}";
		
		if (empty($diametr_id) || empty($width_id) || !in_array($rim, $allRims)) {
			throw new CHttpException(404,'Page cannot be found.');
		}	

		
			
		if (Yii::app()->request->isAjaxrequest) {
			$projects = Project::getModifiedCarsByRim($diametr_id, $width_id, Yii::app()->request->getParam('offset'));
			$this->renderPartial('_projects', array(
				'rim' => $rim,
				'diametr' => $diametr,
				'projects' => $projects,
			));
			Yii::app()->end();
		}
			
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
		$recommendedTireSizesItems = array();
		foreach (array(1=>'P', 2=>'LT') as $k=>$v) {
			$recommendedTireSizesItems[$k]['title'] = $v;	
			$recommendedTireSizesItems[$k]['items'] = Project::getRecommendedTireSizes($diametr_id, $width, $k);	
		}
		
		$possibleTireSizes = Project::getPossibleTireSizesByRim($diametr_id, $width_id);
		$projects = Project::getModifiedCarsByRim($diametr_id, $width_id, 0);
		
		//rims navifations
		$dataDiametr = array();
		foreach ($listDiameter as $k=>$v) {
			$dataDiametr[] = $v;
		}

		$dataWidth = array();
		foreach ($listWidth as $k=>$v) {
			$dataWidth[] = $v;
		}
		
		$key_d = array_search($diametr, $dataDiametr);
		$key_w = array_search($width, $dataWidth);
		
		/*
		d($listWidth,0);
		d($dataWidth,0);
		d($key_w);
		*/
		
		$rimsNavigation = array();		
		//-1 position width
		if (isset($dataWidth[$key_w-1])) {
			$rimItem = $diametr . 'x'. $dataWidth[$key_w-1];
			if (in_array($rimItem, $allRims)) {
				$rimsNavigation[$rimItem] = 'Narrower rim';
			}
		}
		//+1 position width
		if (isset($dataWidth[$key_w+1])) {
			$rimItem = $diametr . 'x'. $dataWidth[$key_w+1];
			if (in_array($rimItem, $allRims)) {
				$rimsNavigation[$rimItem] = 'Wider rim';
			}
		}
		//-1 position diametr
		if (isset($dataDiametr[$key_d-1])) {
			$rimItem = $dataDiametr[$key_d-1] . 'x'. $width;
			if (in_array($rimItem, $allRims)) {
				$rimsNavigation[$rimItem] = 'Smaller rim';
			}
		}
		//+1 position diametr
		if (isset($dataDiametr[$key_d+1])) {
			$rimItem = $dataDiametr[$key_d+1] . 'x'. $width;
			if (in_array($rimItem, $allRims)) {
				$rimsNavigation[$rimItem] = 'Larger rim';
			}
		}
		
		
		if (isset($_GET['t'])) {
			d($allRims, 0);
			d($listDiameter, 0);
			d($listWidth, 0);
		}			

		$this->render('diametr_width', array(
			'header_text_block' => $header_text_block,
			'rim' => $rim,
			'diametr' => $diametr,
			'width' => $width,
			'possibleTireSizes' => $possibleTireSizes,
			'recommendedTireSizesItems' => $recommendedTireSizesItems,
			'rimsNavigation' => $rimsNavigation,
			'projects' => $projects,
			'count' => Project::getCountModifiedCarsByRim($diametr_id, $width_id),
		));
	}
	
}