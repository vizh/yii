<?php

$routes = [
    [
        'class' => 'CFileLogRoute',
        'levels' => 'error, warning',
        'except' => 'exception.CHttpException.404',
    ], [
        'class' => 'CEmailLogRoute',
        'levels' => 'error',
        'except' => ['exception.CHttpException.404', 'exception.api\components\Exception'],
        'emails' => [
            'error.runetid@ruvents.com',
        ],
        'subject' => 'RUNET-ID Exception',
        'sentFrom' => 'yii@runet-id.com',
        'utf8' => true,
    ],
];

if (YII_DEBUG) {
    $routes[] = [
        'class' => 'CWebLogRoute',
        'categories' => 'application',
        'levels' => 'error, warning, info',
    ];
}

return $routes;
