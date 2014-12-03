<?php

return [
    'runetid.jquery' => [
        'baseUrl' => '/javascripts/',
        'js' => ['jquery-1.9.1.min.js', 'jquery.extensions.js', 'jquery.placeholder.min.js', 'jquery.cookie.js']
    ],
    'runetid.backbone' => [
        'baseUrl' => '/javascripts/',
        'js' => ['underscore-min-1.4.4.js', 'backbone-min-0.9.10.js']
    ],
    'runetid.bootstrap' => [
        'baseUrl' => '/',
        'js' => ['javascripts/bootstrap.min.js'],
        'css' => ['stylesheets/bootstrap.min.css'],
        'depends' => ['runetid.jquery']
    ],
    'runetid.bootstrap.admin' => [
        'baseUrl' => '/',
        'js' => ['javascripts/bootstrap.admin.min.js'],
        'css' => ['stylesheets/bootstrap.admin.min.css'],
        'depends' => ['runetid.jquery']
    ],
    'runetid.jquery.ui' => [
        'baseUrl' => '/javascripts/',
        'js' => ['jquery-ui-1.9.0.custom.min.js', 'jquery.ui.autocomplete.html.js', '/jquery.ui/jquery-ui-autocomplete-bootstrap-style.js'],
        'css' => ['/jquery.ui/jquery-ui-autocomplete-bootstrap-style.css'],
        'depends' => ['runetid.jquery']
    ],
    'runetid.admin.jquery.ui' => [
        'baseUrl' => '/javascripts/',
        'js' => ['jquery-ui-1.10.2.custom.min.js', 'jquery.ui/jquery-ui-datepicker-ru.js'],
        'css' => ['jquery.ui/themes/smoothness/jquery-ui-1.10.2.custom.min.css'],
        'depends' => ['runetid.jquery']
    ],
    'runetid.jquery.ioslider' => [
        'baseUrl' => '/',
        'js' => ['javascripts/jquery.iosslider.min.js'],
        'depends' => ['runetid.jquery']
    ],
    'runetid.auth' => [
        'baseUrl' => '/',
        'js' => ['javascripts/auth.js']
    ],
    'runetid.application' => [
        'baseUrl' => '/',
        'js' => ['javascripts/application.js'],
        'css' => ['stylesheets/application.css'],
        'depends' => ['runetid.jquery', 'runetid.jquery.ui', 'runetid.backbone', 'runetid.bootstrap', 'runetid.jquery.ioslider', 'runetid.auth']
    ],
    'runetid.event-calculate-price' => [
        'baseUrl' => '/',
        'js' => ['javascripts/money-format.js', 'javascripts/event-calculate-price.js'],
        'depends' => ['runetid.application']
    ],
    'runetid.admin' => [
        'baseUrl' => '/',
        'css' => ['stylesheets/admin.css'],
        'depends' => ['runetid.jquery', 'runetid.admin.jquery.ui', 'runetid.bootstrap.admin']
    ],
    'runetid.charts' => [
        'baseUrl' => '/',
        'js' => ['javascripts/charts.js']
    ],
    'runetid.partner' => [
        'baseUrl' => '/',
        'css' => ['stylesheets/partner.css'],
        'depends' => ['runetid.jquery', 'runetid.admin.jquery.ui', 'runetid.bootstrap']
    ],
    'runetid.ckeditor' => [
        'baseUrl' => '/javascripts/ckeditor',
        'js' => ['ckeditor.js']
    ],
    'runetid.bootstrap-datepicker' => [
        'baseUrl' => '/javascripts/bootstrap-datepicker/',
        'css' => ['css/datepicker.css'],
        'js'  => ['js/bootstrap-datepicker.js', 'js/locales/bootstrap-datepicker.ru.js']
    ],
    'runetid.jquery.inputmask' => [
        'baseUrl' => '/javascripts/jquery.inputmask/',
        'js' => ['jquery.inputmask.js'],
        'depends' => ['runetid.jquery']
    ],
    'runetid.easyXDM' => [
        'baseUrl' => '/javascripts/',
        'js' => ['easyXDM.min.js'],
    ],
    'runetid.jquery.inputmask-multi' => [
        'baseUrl' => '/javascripts/jquery.inputmask-multi/',
        'js' => ['jquery.inputmask-multi.js', 'jquery.bind-first-0.1.min.js', 'jquery.initphoneinputmask.js'],
        'depends' => ['runetid.jquery.inputmask']
    ],
    'runetid.widget' => [
        'baseUrl' => '/',
        'css' => ['stylesheets/application.css'],
        'depends' => ['runetid.jquery', 'runetid.jquery.ui', 'runetid.backbone', 'runetid.bootstrap', 'runetid.auth']
    ],
    'runetid.jquery.colpick' => [
        'baseUrl' => '/javascripts/jquery.colpick',
        'js' => ['colpick.js'],
        'css' => ['colpick.css']
    ]
];