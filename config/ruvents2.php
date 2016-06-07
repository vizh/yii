<?php

define('RUVENTS_API_HOST', 'http://ruvents2.'.RUNETID_HOST);

return [
    'modules' => ['ruvents2'],
    'components' => [
        'ruvents2AuthManager' => [
            'class' => '\ruvents2\components\PhpAuthManager',
            'defaultRoles' => ['guest'],
        ],
        'urlManager' => [
            'rules' => [
                ['ruvents2/event/index', 'pattern' => RUVENTS_API_HOST.'/event', 'verb' => 'GET'],
                ['ruvents2/event/<action>', 'pattern' => RUVENTS_API_HOST.'/event/<action:\w+>', 'verb' => 'GET'],
                ['ruvents2/participants/fields', 'pattern' => RUVENTS_API_HOST.'/participants/fields', 'verb' => 'GET'],
                ['ruvents2/participants/list', 'pattern' => RUVENTS_API_HOST.'/participants', 'verb' => 'GET'],
                ['ruvents2/participants/register', 'pattern' => RUVENTS_API_HOST.'/participants', 'verb' => 'PUT'],
                ['ruvents2/participants/create', 'pattern' => RUVENTS_API_HOST.'/participants', 'verb' => 'POST'],
                ['ruvents2/participants/edit', 'pattern' => RUVENTS_API_HOST.'/participants/<runetId:\d+>',
                    'verb' => 'PUT'],
                ['ruvents2/participants/delete', 'pattern' => RUVENTS_API_HOST.'/participants/<id:\d+>',
                    'verb' => 'DELETE'],
                ['ruvents2/users/list', 'pattern' => RUVENTS_API_HOST.'/users', 'verb' => 'GET'],
                ['ruvents2/badges/list', 'pattern' => RUVENTS_API_HOST.'/badges', 'verb' => 'GET'],
                ['ruvents2/badges/create', 'pattern' => RUVENTS_API_HOST.'/badges', 'verb' => 'POST'],
                ['ruvents2/positions/list', 'pattern' => RUVENTS_API_HOST.'/positions', 'verb' => 'GET'],
                ['ruvents2/products/checks', 'pattern' => RUVENTS_API_HOST.'/products/<id:\d+>/checks',
                    'verb' => 'GET'],
                ['ruvents2/products/check', 'pattern' => RUVENTS_API_HOST.'/products/<id:\d+>/checks',
                    'verb' => 'POST'],
                ['ruvents2/halls/checks', 'pattern' => RUVENTS_API_HOST.'/halls/<id:\d+>/checks', 'verb' => 'GET'],
                ['ruvents2/halls/check', 'pattern' => RUVENTS_API_HOST.'/halls/<id:\d+>/checks', 'verb' => 'POST'],
                ['ruvents2/utility/ping', 'pattern' => RUVENTS_API_HOST.'/utility/ping', 'verb' => 'GET'],

                /* Хак, для большого удобства работы клиента */
                RUVENTS_API_HOST.'/<controller:\w+>/' => 'ruvents2/not/found',
                RUVENTS_API_HOST.'/<controller:\w+>/<action:\w+>' => 'ruvents2/not/found',
            ],
        ],
    ],
];
