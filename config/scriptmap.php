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
        'runetid.jquery.ui' => array(
          'baseUrl' => '/javascripts/',
          'js' => array('jquery-ui-1.9.0.custom.min.js', 'jquery.ui.autocomplete.html.js'),
          'depends' => array('runetid.jquery')
        ),
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
        'runetid.application' => array(
          'baseUrl' => '/',
          'js' => array('javascripts/application.js', 'javascripts/auth.js'),
          'css' => array('stylesheets/application.css', 'stylesheets/app-changes.css'),
          'depends' => array('runetid.jquery', 'runetid.jquery.ui', 'runetid.backbone', 'runetid.bootstrap', 'runetid.jquery.ioslider')
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
      ),

      'scriptMap' => array(),
    )
  )
);