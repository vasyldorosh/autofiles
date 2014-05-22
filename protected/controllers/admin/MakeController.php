<?php

class MakeController extends BackendController
{
    public function actionIndex()
    {
		Access::is('make', 403);
	
        $model = new AutoMake();
        if (isset($_GET['AutoMake'])) {
            $model->attributes = $_GET['AutoMake'];
        }

        $this->render("index", array(
            'model' => $model,
			'pageSize' => Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
        ));
    }

	public function actionCreate() {
		Access::is('make.create', 403);
	
        $model = new AutoMake();

        if (isset($_POST['AutoMake'])) {
			$model->attributes = $_POST['AutoMake'];
			$model->file = CUploadedFile::getInstance($model, 'file');
			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Make successfully added'));
				$this->redirect('/admin/make');
			}
        }		

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
		Access::is('make.update', 403);
	
        $model = $this->loadModel($id);

        if (isset($_POST['AutoMake'])) {
			$model->attributes = $_POST['AutoMake'];
			$model->file = CUploadedFile::getInstance($model, 'file');

			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Make successfully edited'));
				$this->redirect('/admin/make');
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
    private function loadModel($id)
	{
		$model = AutoMake::model()->findByPk($id);
        
		if (!empty($model))
			return $model;
		else 
			throw new CHttpException(404, 'Page not found');
    }

    public function actionDelete($id) {
		$model = $this->loadModel($id);
		$model->delete();
		Yii::app()->admin->setFlash('success', Yii::t('admin', 'Make successfully deleted'));
		$this->redirect('/admin/make');
	}
}