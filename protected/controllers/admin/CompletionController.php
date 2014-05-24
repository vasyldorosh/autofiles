<?php

class CompletionController extends BackendController
{
    public function actionIndex()
    {
		Access::is('completion', 403);
	
        $model = new AutoCompletion();
        if (isset($_GET['AutoCompletion'])) {
            $model->attributes = $_GET['AutoCompletion'];
        }

        $this->render("index", array(
            'model' => $model,
			'pageSize' => Yii::app()->request->getParam('pageSize', Yii::app()->params->defaultPerPage),
        ));
    }

	public function actionCreate() {
		Access::is('completion.create', 403);
	
        $model = new AutoCompletion();

        if (isset($_POST['AutoCompletion'])) {
			$model->attributes = $_POST['AutoCompletion'];
			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Completion successfully added'));
				$this->redirect('/admin/completion');
			}
        }		

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
		Access::is('completion.update', 403);
	
        $model = $this->loadModelYear($id);

        if (isset($_POST['AutoCompletion'])) {
			$model->attributes = $_POST['AutoCompletion'];

			if ($model->validate() && $model->save()) {
				Yii::app()->admin->setFlash('success', Yii::t('admin', 'Completion successfully edited'));
				$this->redirect('/admin/completion');
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
		$model = AutoCompletion::model()->findByPk($id);
        
		if (!empty($model))
			return $model;
		else 
			throw new CHttpException(404, 'Page not found');
    }

    public function actionDelete($id) {
		$model = $this->loadModelYear($id);
		$model->delete();
		Yii::app()->admin->setFlash('success', Yii::t('admin', 'Completion successfully deleted'));
		$this->redirect('/admin/completion');
	}
}