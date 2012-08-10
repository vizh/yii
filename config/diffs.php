<?php

return array(


  'components' => array(
    'user' => array(
      'class' => '\application\components\auth\WebUser',
    ),


    'partnerAuthManager'=>array(
      'class' => '\partner\components\PhpAuthManager',
      'defaultRoles' => array('guest')
    ),

    'ruventsAuthManager'=>array(
      'class' => '\ruvents\components\PhpAuthManager',
      'defaultRoles' => array('guest')
    )
  ),

  'params' => array(
    '' => '',

    'EventDir' => '/files/event/', // файловая директория мероприятий


    'CompanyPerPage' => 20, // Количество результатов компаний на страницу
    'CompanyLogoDir' => '/files/logo/', //


    'UserPerPage' => 20, // Количество результатов пользователей на страницу
    'UserPhotoDir' => '/files/photo/', //



    'MaxImageSize' => 4194304, //Максимально допустимый размер загружаемых изображений

  )
);