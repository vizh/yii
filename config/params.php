<?php

return array(
  'params' => array(
    'CookieDomain' => '.'.RUNETID_HOST,

    'Languages' => array('ru', 'en'),

    'EventDir' => '/files/event/', // файловая директория мероприятий
      
    'EventViewUserPerPage' => 16,
      
    'UserViewMaxRecommendedEvents' => 4,

    'CompanyPerPage' => 20, // Количество результатов компаний на страницу
    'CompanyLogoDir' => '/files/logo/', //
      
    'SearchResultPerPage' => 20, 
    
    'JobPerPage' => 16,
    'JobPreviewLength' => 200,
    'AdminJobPerPage' => 50,
      
    'UserPerPage' => 20, // Количество результатов пользователей на страницу
    'UserPhotoDir' => '/files/photo/', //
      
    'NewsPhotoDir' => '/files/news/',
      
    'MaxImageSize' => 4194304, //Максимально допустимый размер загружаемых изображений


    'ApiMaxResults' => 200, //Максимальное количество результатов поиска в api
    'ApiMaxTop' => 100,

    'AdminEventPerPage' => 50,
    
    'CatalogCompanyDir' => '/files/catalog/company/', // файловая директория для хранения каталога логотипов компаний
      
    'EmailEventCalendar' => 'calendar@internetmediaholding.com',


    'UserPasswordMinLenght' => 6,



    /** Partner Params */
    'PartnerOrderPerPage' => 20,
    'PartnerOrderItemPerPage' => 20,
    'PartnerCouponPerPage' => 20,
    'PartnerUserPerPage' => 20,


    /** Ruvents Params */

    'RuventsMaxResults' => 500,
  )
);