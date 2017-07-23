<?php

/**
 * Список модулей, используемых основным приложением
 * Модулт отдельных приложений объявляются в своих файлах (api, partner, ruvents)
 */
$modules = [
    'catalog',
    'company',
    'contact',
    'event',
    'education',
    'geo',
    'main',
    'news',
    'oauth' => ['csrfValidation' => true],
    'pay' => ['csrfValidation' => true],
    'tag',
    'user',
    'search',
    'job',
    'buduguru',
    'page',
    'widget',
    'link',
    'raec',
    'sms',
    'competence',
    'iri',
    'ict',
    'connect',

    /** Технические модули */
    'mail'
];

if (YII_DEBUG) {
    $modules['gii'] = [
        'class' => 'system.gii.GiiModule',
        'password' => '123456'
    ];
}
return $modules;
