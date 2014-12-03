<?php

$routes = [
    [
        'class' => 'CFileLogRoute',
        'levels' => 'error, warning',
        'except' => 'exception.CHttpException.404'
    ], [
        'class' => 'CEmailLogRoute',
        'levels' => 'error',
        'except' => ['exception.CHttpException.404', 'exception.api\components\Exception'],
        'emails' => 'nikitin@internetmediaholding.com',
        'subject' => 'RUNET-ID Exception',
        'sentFrom' => 'yii@runet-id.com',
        'utf8' => true
    ]
];

if (RUNETID_DEV) {
    $routes[] = [
        'class' => 'CWebLogRoute',
        'categories' => 'application',
        'levels' => 'error, warning, info'
    ];
}

return $routes;