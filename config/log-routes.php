<?php
$routes = [
    [
        'class' => 'CFileLogRoute',
        'levels' => 'error, warning, info',
        'except' => 'exception.CHttpException.404'
    ]
];

if (YII_DEBUG) {
    $routes[] = [
        'class' => 'CWebLogRoute',
        'categories' => 'application',
        'levels' => 'error, warning, info'
    ];
    $routes[] = [
        'class' => 'CFileLogRoute',
        'categories' => ['mail'],
        'levels' => 'error, warning, info',
        'logFile' => 'mail.log',
        'maxFileSize' => 1024,
        'maxLogFiles' => 10
    ];
} else {
    $routes[] = [
        'class' => 'CEmailLogRoute',
        'levels' => 'error',
        'except' => ['exception.CHttpException.404', 'exception.api\components\Exception'],
        'emails' => ['error.runetid@ruvents.com'],
        'subject' => 'RUNET-ID Exception',
        'sentFrom' => 'yii@runet-id.com',
        'utf8' => true
    ];
}

$routes[] = [
    'class' => 'CFileLogRoute',
    'categories' => ['user.*'],
    'logFile' => 'user.log',
    'maxFileSize' => 1024,
    'maxLogFiles' => 10
];

$routes[] = [
    'class' => '\application\components\logging\TelegramLogRoute',
    'categories' => ['paperless.*']
];

return $routes;
