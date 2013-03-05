<?php

return array(
  'params' => array(
    'CookieDomain' => '.'.RUNETID_HOST,

    'EventDir' => '/files/event/', // файловая директория мероприятий
    
    'EventWidgets' => array(
      'event\widgets\About',
      'event\widgets\Adv',
      'event\widgets\Comments',
      'event\widgets\Contacts',
      'event\widgets\Header',
      'event\widgets\Location',
      'event\widgets\Partners',
      'event\widgets\PhotoSlider',
      'event\widgets\ProfessionalInterests',
      'event\widgets\Program',
      'event\widgets\Registration',
      'event\widgets\Users'
    ),
      
    'EventViewUserPerPage' => 8,

    'CompanyPerPage' => 20, // Количество результатов компаний на страницу
    'CompanyLogoDir' => '/files/logo/', //
      
    'SearchResultPerPage' => 20, 
    
    'JobPerPage' => 1,
    'JobPreviewLength' => 200,
      
    'UserPerPage' => 20, // Количество результатов пользователей на страницу
    'UserPhotoDir' => '/files/photo/', //
      
    'NewsPhotoDir' => '/files/news/',
      
    'MaxImageSize' => 4194304, //Максимально допустимый размер загружаемых изображений


    'ApiMaxResults' => 200, //Максимальное количество результатов поиска в api



    'CatalogCompanyDir' => '/files/catalog/company/', // файловая директория для хранения каталога логотипов компаний
  )
);