<?php

return array(
    'components'=>array(
        'clientScript'=>array(

            'packages' => array(
                'runetid.jquery' => array(
                    'baseUrl' => '/javascripts/',
                    'js' => array('jquery-1.9.1.min.js', 'jquery.extensions.js', 'jquery.placeholder.min.js', 'jquery.cookie.js')
                ),
                'runetid.backbone' => array(
                    'baseUrl' => '/javascripts/',
                    'js' => array('underscore-min-1.4.4.js', 'backbone-min-0.9.10.js')
                ),
                'runetid.bootstrap' => array(
                    'baseUrl' => '/',
                    'js' => array('javascripts/bootstrap.min.js'),
                    'css' => array('stylesheets/bootstrap.min.css'),
                    'depends' => array('runetid.jquery')
                ),
                'runetid.bootstrap.admin' => array(
                    'baseUrl' => '/',
                    'js' => array('javascripts/bootstrap.admin.min.js'),
                    'css' => array('stylesheets/bootstrap.admin.min.css'),
                    'depends' => array('runetid.jquery')
                ),
                'runetid.jquery.ui' => [
                    'baseUrl' => '/javascripts/',
                    'js' => ['jquery-ui-1.9.0.custom.min.js', 'jquery.ui.autocomplete.html.js', '/jquery.ui/jquery-ui-autocomplete-bootstrap-style.js'],
                    'css' => ['/jquery.ui/jquery-ui-autocomplete-bootstrap-style.css'],
                    'depends' => ['runetid.jquery']
                ],
                'runetid.admin.jquery.ui' => array(
                    'baseUrl' => '/javascripts/',
                    'js' => array('jquery-ui-1.10.2.custom.min.js', 'jquery.ui/jquery-ui-datepicker-ru.js'),
                    'css' => array('jquery.ui/themes/smoothness/jquery-ui-1.10.2.custom.min.css'),
                    'depends' => array('runetid.jquery')
                ),
                'runetid.jquery.ioslider' => array(
                    'baseUrl' => '/',
                    'js' => array('javascripts/jquery.iosslider.min.js'),
                    'depends' => array('runetid.jquery')
                ),
                'runetid.auth' => array(
                    'baseUrl' => '/',
                    'js' => array('javascripts/auth.js'),
                ),
                'runetid.application' => array(
                    'baseUrl' => '/',
                    'js' => array('javascripts/application.js'),
                    'css' => array('stylesheets/application.css'),
                    'depends' => array('runetid.jquery', 'runetid.jquery.ui', 'runetid.backbone', 'runetid.bootstrap', 'runetid.jquery.ioslider', 'runetid.auth')
                ),
                'runetid.event-calculate-price' => array(
                    'baseUrl' => '/',
                    'js' => array('javascripts/money-format.js', 'javascripts/event-calculate-price.js'),
                    'depends' => array('runetid.application')
                ),
                'runetid.admin' => array(
                    'baseUrl' => '/',
                    'js' => array(),
                    'css' => array('stylesheets/admin.css'),
                    'depends' => array('runetid.jquery', 'runetid.admin.jquery.ui', 'runetid.bootstrap.admin')
                ),
                'runetid.charts' => array(
                    'baseUrl' => '/',
                    'js' => array('javascripts/charts.js')
                ),
                'runetid.partner' => array(
                    'baseUrl' => '/',
                    'js' => array(),
                    'css' => array('stylesheets/partner.css'),
                    'depends' => array('runetid.jquery', 'runetid.admin.jquery.ui', 'runetid.bootstrap')
                ),
                'runetid.ckeditor' => array(
                    'baseUrl' => '/javascripts/ckeditor',
                    'js' => array('ckeditor.js'),
                    'css' => array()
                ),
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
                'runetid.widget' => array(
                    'baseUrl' => '/',
                    'js' => array(),
                    'css' => array('stylesheets/application.css'),
                    'depends' => array('runetid.jquery', 'runetid.jquery.ui', 'runetid.backbone', 'runetid.bootstrap', 'runetid.auth')
                ),
                'runetid.jquery.colpick' => [
                    'baseUrl' => '/javascripts/jquery.colpick',
                    'js' => [
                        'colpick.js'
                    ],
                    'css' => [
                        'colpick.css'
                    ]
                ]
            ),

            'scriptMap' => array(),
        )
    )
);