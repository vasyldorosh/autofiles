<?php
function d($var,$d=true) {CVarDumper::dump($var,30,true); if($d)die;}
// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
//$yii=('C://server/OpenServer/domains/framework_1.1.14/yii.php');

$c = strpos($_SERVER['REQUEST_URI'], 'admin') ?'admin.php':'main.php';

$config=dirname(__FILE__).'/protected/config/'.$c;

defined('YII_DEBUG') or define('YII_DEBUG',true);
//defined('YII_DEBUG') or define('YII_DEBUG',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//show profiler
defined('YII_DEBUG_SHOW_PROFILER') or define('YII_DEBUG_SHOW_PROFILER',0);
//enable profiling
defined('YII_DEBUG_PROFILING') or define('YII_DEBUG_PROFILING',true);
//execution time
defined('YII_DEBUG_DISPLAY_TIME') or define('YII_DEBUG_DISPLAY_TIME',false);

require_once($yii);
$app = Yii::createWebApplication($config);

//Now you can run application
$app->run();