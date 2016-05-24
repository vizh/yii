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
        'depends' => ['runetid.jquery', 'runetid.admin.jquery.ui', 'runetid.bootstrap.admin', 'font-awesome']
    ],
    'runetid.charts' => [
        'baseUrl' => '/',
        'js' => ['javascripts/charts.js']
    ],
    'partner' => [
        'baseUrl' => '/',
        'css' => ['stylesheets/partner.css'],
        'depends' => ['runetid.jquery', 'runetid.jquery.ui', 'pixel-admin']
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
    ],
    'runetid.jquery.migrate' => [
        'baseUrl' => '/javascripts/',
        'js' => ['jquery-migrate-1.1.1.min.js'],
        'depends' => ['runetid.jquery']
    ],
    'pixel-admin' => [
        'baseUrl' => '/',
        'js' => [
            'javascripts/pixel-admin/bootstrap.min.js',
            'javascripts/pixel-admin/ie.js',
            'javascripts/pixel-admin/jquery-ui-extras.min.js',
            'javascripts/pixel-admin/pixel-admin.js',
            'javascripts/pixel-admin/init.js'
        ],
        'css' => [
            'stylesheets/pixel-admin/bootstrap.css',
            'stylesheets/pixel-admin/pixel-admin.css',
            'stylesheets/pixel-admin/custom.css',
            'stylesheets/pixel-admin/themes.css',
            'stylesheets/pixel-admin/pages.css',
        ]
    ],
    'bootstrap3' => [
        'baseUrl' => '/javascripts/bootstrap-3/',
        'js' => ['js/bootstrap.min.js'],
        'css' => ['css/bootstrap.min.css', 'css/custom.css'],
        'depends' => ['runetid.jquery']
    ],
    'jquery' => [
        'depends' => ['runetid.jquery']
    ],
    'jquery.pin' => [
        'baseUrl' => '/javascripts/jquery.pin',
        'js' => ['jquery.pin.min.js']
    ],
    'jquery.fotorama' => [
        'baseUrl' => '/javascripts/jquery.fotorama',
        'js' => ['fotorama.js'],
        'css' => ['fotorama.css']
    ],
    'angular' => [
        'baseUrl' => '/javascripts/angular',
        'js' => ['angular.min.js','angular-sanitize.min.js']
    ],
    'runetid.widget.b3' => [
        'baseUrl' => '/',
        'depends' => ['runetid.jquery', 'runetid.jquery.ui', 'bootstrap3']
    ],
    'font-awesome' => [
        'baseUrl' => '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/',
        'css' => ['font-awesome.min.css']
    ]
];
