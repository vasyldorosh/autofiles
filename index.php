<?php
include('simple_html_dom.php');

function d($var,$d=true) {CVarDumper::dump($var,30,true); if($d)die;}
// change the following paths if necessary
//$yii=dirname(__FILE__).'/../yii-1.1.13.e9e4a0/framework/yii.php';
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
$app = Yii::createWebApplication($config);
//Change the UrlFormat for urlManager to get if a get request is given instead of a path format one.
if (isset($_GET['r'])) {
    Yii::app()->urlManager->setUrlFormat('get');
}   

//Now you can run application
$app->run();