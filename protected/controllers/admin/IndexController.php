<?php

class IndexController extends CController
{
    public function actionIndex() {
		
		if (Yii::app()->admin->isGuest) {
			$this->redirect('/admin/login');
		} else {
			$this->redirect('/admin/admin/index');
		}
	}
	
    public function actionLogin() {
		$this->layout='//admin/layouts/empty';
		
		$model = new AdminLoginForm;
		
		if (Yii::app()->request->isPostRequest) {
			$model->attributes = Yii::app()->request->getParam('AdminLoginForm');
			if ($model->validate() && $model->login()) {
				$this->redirect('/admin');
			}
		}
		
		$this->render('login', array(
			'model' => $model,
		));
	}
	
}