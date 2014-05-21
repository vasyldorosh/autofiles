<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public function __construct($id,$module=null) {
        parent::__construct($id, $module);
        // set global cookie
        if (isset(Yii::app()->request->cookies['referer'])) {
            ;
        } else {           
            $cookie = new CHttpCookie('referer', Yii::app()->request->urlReferrer);
            $cookie->expire = time() + (60*60*24*30); // 30 days
            Yii::app()->request->cookies['referer'] = $cookie;
        }

        
        $user = Yii::app()->user;
        if ($user->isGuest) {
            $this->layout = '//layouts/guest';
        } else {
            if($user->role)
                $this->layout = '//layouts/'.$user->role;
            else
                $this->layout = '//layouts/' . ROLE::CLIENT;
        }
    }

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/site';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
}