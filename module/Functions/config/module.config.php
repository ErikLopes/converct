<?phpnamespace Functions;return array(	'controllers' => array(		'invokables' => array(			'Functions\Controller\Functions' => 'Functions\Controller\FunctionsController',		),	),        // Doctrine config        'doctrine' => array(            'driver' => array(                __NAMESPACE__ . '_driver' => array(                    'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',                    'cache' => 'array',                    'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')                ),                'orm_default' => array(                    'drivers' => array(                        __NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver'                    )                )            )        ));