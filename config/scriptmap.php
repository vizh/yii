<?php

return array(
  'components'=>array(
    'clientScript'=>array(

      'packages' => array(
        'runetid.jquery' => array(
          'baseUrl' => '/javascripts/',
          'js' => array('jquery-1.8.2.min.js', 'jquery.extensions.js', 'jquery.placeholder.min.js')
        ),
        'runetid.backbone' => array(
          'baseUrl' => '/javascripts/',
          'js' => array('underscore-min.js', 'backbone-min.js')
        ),
        'runetid.bootstrap' => array(
          'baseUrl' => '/',
          'js' => array('javascripts/bootstrap.min.js'),
          'css' => array('stylesheets/bootstrap.min.css'),
          'depends' => array('runetid.jquery')
        ),
        'runetid.jquery.ui' => array(
          'baseUrl' => '/',
          'js' => array('javascripts/jquery-ui-1.9.0.custom.min.js'),
          'depends' => array('runetid.jquery')
        ),
        'runetid.jquery.ioslider' => array(
          'baseUrl' => '/',
          'js' => array('javascripts/jquery.iosslider.min.js'),
          'depends' => array('runetid.jquery')
        ),
        'runetid.application' => array(
          'baseUrl' => '/',
          'js' => array('javascripts/application.js'),
          'css' => array('stylesheets/application.css', 'stylesheets/app-changes.css'),
          'depends' => array('runetid.jquery', 'runetid.jquery.ui', 'runetid.backbone', 'runetid.bootstrap', 'runetid.jquery.ioslider')
        ),
        'runetid.charts' => array(
          'baseUrl' => '/',
          'js' => array('javascripts/charts.js')
        )
      ),

      'scriptMap' => array(),
    )
  )
);