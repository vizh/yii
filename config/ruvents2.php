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
                ['ruvents2/event/index', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/event', 'verb' => 'GET'],
                ['ruvents2/event/<action>', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/event/<action:\w+>', 'verb' => 'GET'],

                ['ruvents2/participants/fields', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/participants/fields', 'verb' => 'GET'],
                ['ruvents2/participants/list', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/participants', 'verb' => 'GET'],
                ['ruvents2/participants/create', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/participants', 'verb' => 'POST'],
                ['ruvents2/participants/edit', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/participants/<runetId:\d+>', 'verb' => 'PUT'],
                ['ruvents2/participants/delete', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/participants/<runetId:\d+>', 'verb' => 'DELETE'],

                ['ruvents2/users/list', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/users', 'verb' => 'GET'],

                ['ruvents2/badges/list', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/badges', 'verb' => 'GET'],
                ['ruvents2/badges/create', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/badges', 'verb' => 'POST'],

                ['ruvents2/positions/list', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/positions', 'verb' => 'GET'],


                ['ruvents2/products/checks', 'pattern' => 'http://ruvents2.' . RUNETID_HOST . '/products/<id:\d+>/checks', 'verb' => 'GET'],
                ['ruvents2/products/check', 'pattern' => 'http://ruvents2.' . RUNETID_HOST . '/products/<id:\d+>/checks', 'verb' => 'POST'],

                ['ruvents2/utility/ping', 'pattern' => 'http://ruvents2.'. RUNETID_HOST.'/utility/ping', 'verb' => 'GET'],
                'http://ruvents2.'. RUNETID_HOST.'/<controller:\w+>/' => 'ruvents2/not/found',
                'http://ruvents2.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents2/not/found',
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




    'http://ruvents2.'. RUNETID_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents2/<controller>/<action>',
 *
 */