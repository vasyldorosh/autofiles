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
			
		$years = AutoModelYear::getYears(1);
			
			
		$this->render('index', array(
		));
	}
	
	public function actionMake($alias)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('t.is_active', 1);
		$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.alias', $alias);
		
		$make = AutoMake::model()->find($criteria);
		if (empty($make)) {
			 throw new CHttpException(404,'Page cannot be found.');
		}
		
		$this->pageTitle = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_title'));
		$this->meta_keywords = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_meta_keywords'));
		$this->meta_description = str_replace('[make]', $make['title'], SiteConfig::getInstance()->getValue('seo_make_meta_description'));		
		
		$criteria = new CDbCriteria();
		$criteria->compare('t.is_active', 1);
		$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.make_id', $make['id']);
		$criteria->compare('Make.is_active', 1);
		$criteria->compare('Make.is_deleted', 0);
		$criteria->with = array('Make' => array('together'=>true));
		
		$models = AutoModel::model()->findAll($criteria);
		
		$this->render('make', array(
			'make' => $make,
			'models' => $models,
		));
	}
	
	public function actionModel($makeAlias, $modelAlias)
	{
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
		
		$models = AutoModel::model()->findAll($criteria);
		
		$this->render('model', array(
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