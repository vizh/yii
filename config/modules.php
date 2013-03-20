<?php
return array(
  'modules' => array(
    'gii' => array(
      'class' => 'system.gii.GiiModule',
      'password' => 'vBFwhV06yZ',

      //'ipFilters'=>array('127.0.0.1','::1'),
      'generatorPaths'=>array(
        'application.gii',   // псевдоним пути
      ),
    ),


    /**
     * Список модулей, используемых основным приложением
     * Модулт отдельных приложений объявляются в своих файлах (api, partner, ruvents)
     */
    'catalog',
    'commission',
    'company',
    'contact',
    'event',
    'geo',
    'main',
    'news',
    'oauth',
    'pay',
    'rbac',
    'tag',
    'user',
    'search',
    'job',
    'page',  
      
    /** Технические модули */
    'convert',
    'mytest'
  ),
);
