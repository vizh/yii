<?php
return [
    'modules' => ['ruvents2'],
    'components' => [
        'ruvents2AuthManager' => [
            'class' => '\ruvents2\components\PhpAuthManager',
            'defaultRoles' => ['guest']
        ],
        'urlManager' => [
            'rules' => [
                'http://ruvents2.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents2/<controller>/<action>',
            ]
        ]
    ]
];

/*
 * Routes example
 *

    array('api/<controller>/index', 'pattern'=>'api/<controller:\w+>', 'verb'=>'GET'),
    array('api/<controller>/create', 'pattern'=>'api/<controller:\w+>', 'verb'=>'POST'),
    array('api/<controller>/view', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'GET'),
    array('api/<controller>/update', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'PUT, POST'),
    array('api/<controller>/delete', 'pattern'=>'api/<controller:\w+>/<id:\d+>', 'verb'=>'DELETE'),

 *
 */