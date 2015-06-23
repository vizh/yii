<?php

return [
    /***  DENY BLOCK  ***/
    [
        'deny',
        'roles' => ['mobile'],
        'controllers' => ['event'],
        'actions' => ['register']
    ],
    [
        'deny',
        'roles' => ['mobile'],
        'controllers' => ['user'],
        'actions' => ['create']
    ],
    [
        'deny',
        'roles' => ['mobile'],
        'controllers' => ['pay']
    ],
    /*** END DENY BLOCK ***/


    [
        'allow',
        'users' => ['?'],
        'controllers' => ['raec']
    ],
    [
        'allow',
        'roles' => ['base'],
        'controllers' => ['user'],
        'actions' => ['auth', 'search', 'create', 'get', 'login', 'purposes', 'professionalinterests', 'edit', 'setdata']
    ],
    [
        'allow',
        'roles' => ['base'],
        'controllers' => ['section']
    ],
    [
        'allow',
        'roles' => ['base'],
        'controllers' => ['company']
    ],
    [
        'allow',
        'roles' => ['base'],
        'controllers' => ['event'],
        'actions' => ['roles', 'register', 'list', 'info', 'companies', 'statistics', 'users', 'purposes', 'halls']
    ],
    [
        'allow',
        'roles' => ['base'],
        'controllers' => ['pay']
    ],
    [
        'allow',
        'roles' => ['base'],
        'controllers' => ['invite']
    ],
    [
        'allow',
        'roles' => ['base'],
        'controllers' => ['purpose']
    ],
    [
        'allow',
        'roles' => ['base'],
        'controllers' => ['professionalinterest']
    ],


    /*** MBLT ***/
    [
        'allow',
        'roles' => ['mblt'],
        'controllers' => ['event'],
        'actions' => ['users', 'companies']
    ],
    [
        'allow',
        'roles' => ['mblt'],
        'controllers' => ['company'],
        'actions' => ['get']
    ],

    /** MicroSoft **/
    [
        'allow',
        'roles' => ['microsoft'],
        'controllers' => ['ms', 'pay']
    ],

    /** MicroSoft **/
    [
        'allow',
        'roles' => ['iri'],
        'controllers' => ['iri']
    ],



    /***  ЗАПРЕЩЕНО ВСЕ ЧТО НЕ РАЗРЕШЕНО   ***/
    [
        'deny',
        'users' => ['*']
    ],
];