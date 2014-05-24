<?php
include('simple_html_dom.php');

function d($var,$d=true) {CVarDumper::dump($var,30,true); if($d)die;}
// change the following paths if necessary
//$yii=dirname(__FILE__).'/../yii-1.1.13.e9e4a0/framework/yii.php';
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);
//defined('YII_DEBUG') or define('YII_DEBUG',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//show profiler
defined('YII_DEBUG_SHOW_PROFILER') or define('YII_DEBUG_SHOW_PROFILER',false);
//enable profiling
defined('YII_DEBUG_PROFILING') or define('YII_DEBUG_PROFILING',true);
//execution time
defined('YII_DEBUG_DISPLAY_TIME') or define('YII_DEBUG_DISPLAY_TIME',false);

require_once($yii);
$app = Yii::createWebApplication($config);
//Change the UrlFormat for urlManager to get if a get request is given instead of a path format one.
if (isset($_GET['r'])) {
    Yii::app()->urlManager->setUrlFormat('get');
}   

//Now you can run application
$app->run();