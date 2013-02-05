<?php

return array(
  'params' => array(
    'CookieDomain' => '.'.RUNETID_HOST,

    'EventDir' => '/files/event/', // файловая директория мероприятий

    'EventViewUserPerPage' => 8,

    'CompanyPerPage' => 20, // Количество результатов компаний на страницу
    'CompanyLogoDir' => '/files/logo/', //
      
    'SearchResultPerPage' => 20, 
      
    'UserPerPage' => 20, // Количество результатов пользователей на страницу
    'UserPhotoDir' => '/files/photo/', //
      
    'NewsPhotoDir' => '/files/news/',
      
    'MaxImageSize' => 4194304, //Максимально допустимый размер загружаемых изображений



    'CatalogCompanyDir' => '/files/catalog/company/', // файловая директория для хранения каталога логотипов компаний
  )
);