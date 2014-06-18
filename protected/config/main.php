<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'AutoFiles',

	// preloading 'log' component
	'preload'=>array(
        'log',
        'bootstrap',
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.admin.*',
        'application.extensions.*'
	),

	// application components
	'components'=>array(
		'assetManager' => array(
			'class' => 'CAssetManager',
			'forceCopy' => YII_DEBUG,
		),	
	
        /*'ckeditor' => array(
            'class' => 'application.extensions.ckeditor.TheCKEditorWidget',
        ),*/
        'iwi' => array(
            'class' => 'application.extensions.iwi.IwiComponent',
            // GD or ImageMagick
            'driver' => 'GD',
            // ImageMagick setup path
            //'params'=>array('directory'=>'C:/ImageMagick'),
        ),
        // uncomment the following to enable URLs in path-format
	
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(	
				
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				
				'<makeAlias:[a-z-]{1,255}>/<modelAlias:[a-z-]{1,255}>' => 'site/model',
				'<alias:[a-z-]{1,255}>' => 'site/make',
			),
		),
	
		
		'db'=> require(dirname(__FILE__).'/db.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		
        'cache' => array(
            //'class' => 'application.components.MemCacheI',
			'class'=>'system.caching.CMemCache',
            'servers' => array(
                array(
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 60,
                ),
            ),
			'behaviors' => array(
                'clear' => array(
                    'class' => 'application.components.TaggingBehavior',
                ),
            ),
        ),		
		
		/*
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class' => 'CWebLogRoute',
                    'enabled' =>YII_DEBUG_SHOW_PROFILER,
                    'categories' => 'system.db.*',
				),
			),
		),
		*/
		
		 'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(      
			  array(
				'class'=>'CProfileLogRoute',
				'report'=>'summary',
			  ),			  
			),
		  ),		
				
        'file' => array(
            'class'=>'application.extensions.file.CFile',
        ),		
	),

    'language' => 'en',

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'defaultPerPage'=>50,
		'perPages'=>array(10=>10,20=>20,50=>50,100=>100,250=>250),
	), 
	'defaultController' => 'site/index'
);