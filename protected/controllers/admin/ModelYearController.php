<?php

class ModelYearController extends BackendController
{
    public function actionIndex()
    {
		Access::is('modelYear', 403);
	
        $model = new AutoModelYear();
        if (isset($_GET['AutoModelYear'])) {
            $model->attributes = $_GET['AutoModelYear'];
        }

        $this->render("index", array(
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