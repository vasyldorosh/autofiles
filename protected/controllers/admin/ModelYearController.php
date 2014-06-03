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
			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Model by Year successfully added'));
				$this->redirect('/admin/modelYear');
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

			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Model by Year successfully edited'));
				$this->redirect('/admin/modelYear');
			}
        }

        $this->render('update', array(
            'model' => $model,
        ));
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

    public function actionDelete($id) {
		$model = $this->loadModelYear($id);
		$model->delete();
		Yii::app()->admin->setFlash('success', Yii::t('admin', 'Model by Year successfully deleted'));
		$this->redirect('/admin/modelYear');
	}
    
	public function actionGetByModel() {
		$id = (int)Yii::app()->getRequest()->getParam('id', 0);
		
		$items = AutoModelYear::getAllByModel($id);
		echo json_encode(array('items'=>$items));
	}
}