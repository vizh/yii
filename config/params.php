<?php

return array(
  'params' => array(
    'CookieDomain' => '.'.RUNETID_HOST,

    'PublicTmp' => '/files/tmp',

    'Languages' => array('ru', 'en'),

    'EventDir' => '/files/event/%s/', // директория файлов мероприятий
    'EventPreviewLength' => 200,
    'EventViewUserPerPage' => 16,
    'EventWidgetBannerMaxHeight' => 400,
      
    'UserViewMaxRecommendedEvents' => 4,
      
      
    'CompanyPerPage' => 20, // Количество результатов компаний на страницу
    'CompanyDir' => '/files/company/',
      
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
    'AdminCatalogCompanyPerPage' => 20,
    'AdminPayAccountPerPage' => 50,
    'AdminMailPerPage' => 50,
    'AdminOrderJuridicalTemplatePerPage' => 50,
    
    'CatalogCompanyDir' => '/files/catalog/company/', // файловая директория для хранения каталога логотипов компаний
      
    'EmailEventCalendar' => 'calendar@internetmediaholding.com',


    'UserPasswordMinLenght' => 6,

      
    'CatalogCompanyDir' => '/files/catalog/company/%s/',


    /** Partner Params */
    'PartnerOrderPerPage' => 20,
    'PartnerOrderItemPerPage' => 20,
    'PartnerCouponPerPage' => 20,
    'PartnerUserPerPage' => 20,
    'PartnerInviteRequestPerPage' => 20,
    'PartnerCompetenceResultPerPage' => 20,


    /** Ruvents Params */

    'RuventsMaxResults' => 500,

    /** LittleSms */
    'LittleSmsUser' => 'acc-3c0a9d79',
    'LittleSmsKey'  => 'ZWyFOkv5'
  )
);