<?php
return array(
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
);
