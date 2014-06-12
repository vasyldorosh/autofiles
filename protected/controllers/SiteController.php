<?php

class SiteController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('index');
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