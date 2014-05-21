<?php

class ModelController extends BackendController
{
    public function actionIndex()
    {
		Access::is('model', 403);
	
        $model = new AutoModel();
        if (isset($_GET['AutoModel'])) {
            $model->attributes = $_GET['AutoModel'];
        }

        $this->render("index", array(
            'model' => $model,
        ));
    }

	public function actionCreate() {
		Access::is('model.create', 403);
	
        $model = new AutoModel();

        if (isset($_POST['AutoModel'])) {
			$model->attributes = $_POST['AutoModel'];
			$model->file = CUploadedFile::getInstance($model, 'file');
			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Model successfully added'));
				$this->redirect('/admin/model');
			}
        }		

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
		Access::is('model.update', 403);
	
        $model = $this->loadModel($id);

        if (isset($_POST['AutoModel'])) {
			$model->attributes = $_POST['AutoModel'];
			$model->file = CUploadedFile::getInstance($model, 'file');

			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Model successfully edited'));
				$this->redirect('/admin/model');
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
		$model = AutoModel::model()->findByPk($id);
        
		if (!empty($model))
			return $model;
		else 
			throw new CHttpException(404, 'Page not found');
    }

    public function actionDelete($id) {
		$model = $this->loadModel($id);
		$model->delete();
		Yii::app()->admin->setFlash('success', Yii::t('admin', 'Model successfully deleted'));
		$this->redirect('/admin/model');
	}
}