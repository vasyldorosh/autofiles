<?php

class AjaxController extends Controller
{
	public function actionGetMakesByYear()
	{
		$year = Yii::app()->request->getParam('year');
		$data = AutoMake::getMakesByYear($year);
		$response['items'] = $data;
		echo json_encode($response);
	}
	
	public function actionGetModelsByMake()
	{
		$alias = Yii::app()->request->getParam('alias');
		$year = Yii::app()->request->getParam('year');
		$make = AutoMake::getMakeByAlias($alias);
		
		$data = AutoModel::getModelsByMake($make['id'], $year);
		$response['items'] = $data;
		echo json_encode($response);
	}
	
}