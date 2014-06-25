<?php
/**
 * Created by PhpStorm.
 * User: Orfey
 * Date: 09.06.2014
 * Time: 16:42
 */
class BannerWidget extends CWidget{


    /**
     * Путь к шаблонам
     */
    const TEMPLATE_PATH = 'application.widgets.banner';

    /**
     * Действие по-умолчанию
     * @var string
     */
    public $action;
 
	/**
     * Роутер
     */
    public function run()
    {
        $this->{sprintf('action%s', $this->action)}();
    }

    public function actionHome() 
	{
		$this->render(self::TEMPLATE_PATH . '.home', array(
		
		));
    }
}