<?php

class SettingsController extends BackendController
{
    public function actionIndex()
    {
		Access::is('settings', 403);
		
		$config = Yii::app()->getRequest()->getParam('Config', null);
		
		if (!empty($config)) {
            foreach ($config as $key => $value) {
                SiteConfig::getInstance()->setValue($key, $value);
            }
            SiteConfig::getInstance()->save();
			Yii::app()->admin->setFlash('success', Yii::t('admin', 'Successfully saved'));
        }

        $this->render("index", array(
            'values' => SiteConfig::getInstance()->getData(),
	    ));
    }

}