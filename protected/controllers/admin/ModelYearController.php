<?php

class ModelYearController extends BackendController
{

	public function actions()
	{
		return array(
			'toggle' => array(
				'class'=>'bootstrap.actions.TbToggleAction',
				'modelName' => 'AutoModelYear',
			),
			'active' => array(
				'class'=>'application.actions.MultipleCheckboxAction',
				'modelName' => 'AutoModelYear',
				'attributeName' => 'is_active',
				'accessAlias' => 'modelYear.update',
			),
			'trash' => array(
				'class'=>'application.actions.MultipleCheckboxAction',
				'modelName' => 'AutoModelYear',
				'attributeName' => 'is_deleted',
				'accessAlias' => 'modelYear.delete',
			),
			'delete' => array(
				'class'=>'application.actions.MultipleDeleteAction',
				'modelName' => 'AutoModelYear',
				'accessAlias' => 'modelYear.delete',
			),
		);
	}

    public function actionIndex()
    {
		Access::is('modelYear', 403);
		
		$model = new AutoModelYear();
		$model->unsetAttributes();
		$model->is_deleted = 0;		
	
        if (isset($_GET['AutoModelYear'])) {
            $model->attributes = $_GET['AutoModelYear'];
        }

        $this->render("index", array(
            'model' => $model,
			'pageSize' => Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
        ));
    }
	
    public function actionEmptyCompetitors()
    {
		Access::is('modelYear', 403);
		
		$model = new AutoModelYear();
		$model->unsetAttributes();
		$model->is_deleted = 0;		
	
        if (isset($_GET['AutoModelYear'])) {
            $model->attributes = $_GET['AutoModelYear'];
        }
		
		
		AutoModelYear::getIdsIsCompetitors();

        $this->render("empty_competitors", array(
            'model' => $model,
			'pageSize' => Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
        ));
    }
	
    public function actionEmptyPhotos()
    {
		Access::is('modelYear', 403);
		
		$model = new AutoModelYear();
		$model->unsetAttributes();
		$model->is_deleted = 0;		
	
        if (isset($_GET['AutoModelYear'])) {
            $model->attributes = $_GET['AutoModelYear'];
        }
		
		
		AutoModelYear::getIdsIsCompetitors();

        $this->render("empty_photos", array(
            'model' => $model,
			'pageSize' => Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
        ));
    }
	
    public function actionBasket()
    {
		Access::is('modelYear.basket', 403);
	
        $model = new AutoModelYear();
		$model->unsetAttributes();
		$model->is_deleted = 1;
        
		if (isset($_GET['AutoModelYear'])) {
            $model->attributes = $_GET['AutoModelYear'];
        }

        $this->render("basket", array(
            'model' => $model,
			'pageSize' => Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
        ));
    }	

	public function actionCreate() {
		Access::is('modelYear.create', 403);
	
        $model = new AutoModelYear();

        if (isset($_POST['AutoModelYear'])) {
			$model->attributes = $_POST['AutoModelYear'];
			$model->file = CUploadedFile::getInstance($model, 'file');
			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Model by Year successfully added'));
				$this->afterSaveRedirect($model);
			}
        }		

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
		Access::is('modelYear.update', 403);
	
        $model = $this->loadModelYear($id);
        $model->scenario = 'updateAdmin';

        if (isset($_POST['AutoModelYear'])) {
			$model->attributes = $_POST['AutoModelYear'];
			$model->file = CUploadedFile::getInstance($model, 'file');

			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Model by Year successfully edited'));
				$this->afterSaveRedirect($model);
			}
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionCopy() {
		if (Yii::app()->getRequest()->isPostRequest && Yii::app()->getRequest()->isAjaxRequest) {			
			$response = array();	
			if (Access::is('modelYear.update')) {
		
				$model_id = (int)Yii::app()->request->getParam('model_id');	
				if ($model_id) {				
					$models = AutoModelYear::model()->findAllByPk(Yii::app()->request->getParam('ids'));
					foreach ($models as $model) {
						$clone = new AutoModelYear;
						$clone->attributes = $model->attributes;
						$clone->model_id = $model_id;
						$clone->id = null;
						$clone->save();
					}
					$response['status'] = 1;
				} else {
					$response['status'] = 0;
					$response['error'] = Yii::t('admin', 'Error - Select Model!');					
				}
			} else {
				$response['status'] = 0;
				$response['error'] = Yii::t('admin', 'Have No Rights');			
			}
			
			echo json_encode($response);
				
		} else
			throw new CHttpException(Yii::t('admin', 'Invalid request'));
    }	

    public function actionMove() {
		if (Yii::app()->getRequest()->isPostRequest && Yii::app()->getRequest()->isAjaxRequest) {			
			$response = array();	
			if (Access::is('modelYear.update')) {
					
				$model_id = (int)Yii::app()->request->getParam('model_id');	
				if ($model_id) {
					$models = AutoModelYear::model()->findAllByPk(Yii::app()->request->getParam('ids'));
					foreach ($models as $model) {
						$model->model_id = $model_id;
						$model->save();
					}
					$response['status'] = 1;
				} else {
					$response['status'] = 0;
					$response['error'] = Yii::t('admin', 'Error - Select Model!');					
				}
			} else {
				$response['status'] = 0;
				$response['error'] = Yii::t('admin', 'Have No Rights');			
			}
			
			echo json_encode($response);
				
		} else
			throw new CHttpException(Yii::t('admin', 'Invalid request'));
    }	
	
	

    /**
     * @param $id integer
     * @return Page
     */
    private function loadModelYear($id)
	{
		$model = AutoModelYear::model()->findByPk($id);
        
		if (!empty($model))
			return $model;
		else 
			throw new CHttpException(404, 'Page not found');
    }
    
	public function actionGetByModel() {
		$id = (int)Yii::app()->getRequest()->getParam('id', 0);
		
		$items = AutoModelYear::getAllByModel($id);
		echo json_encode(array('items'=>$items));
	}
}