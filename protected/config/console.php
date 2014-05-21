<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'LadyBonus',
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.cs.*',
        'application.components.validators.*',
        'application.modules.files.components.*',
        'application.extensions.*'
	),
	// application components
	'components'=>array(
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
        'iwi' => array(
            'class' => 'application.extensions.iwi.IwiComponent',
            // GD or ImageMagick
            'driver' => 'GD',
            // ImageMagick setup path
            //'params'=>array('directory'=>'C:/ImageMagick'),
        ),
		'db'=> require(dirname(__FILE__).'/db.php'),
		
		'cache'=>array(
            'class'=>'system.caching.CFileCache', // используем кэш на файлах
        ),
		
        'file' => array(
            'class'=>'application.extensions.file.CFile',
        ),		
	),
);