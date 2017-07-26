<?php

$params = [
    'CookieDomain' => '.'.RUNETID_HOST,
    'PublicTmp' => '/files/tmp',
    'Languages' => ['ru', 'en'],
    'EventDir' => '/files/event/%s/', // директория файлов мероприятий
    'EventPreviewLength' => 200,
    'EventViewUserPerPage' => 16,
    'EventWidgetBannerMaxHeight' => 800,
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
    'ApiEventlessMethods' => [
        'event/list',
        'event/types',
        'user/auth',
        'user/login',
        'user/settings',
        'user/editPassword',
        'user/restPassword',
        'user/passwordChange',
        'user/passwordRestore'
    ],

    'AdminEventPerPage' => 50,
    'AdminCatalogCompanyPerPage' => 20,
    'AdminPayAccountPerPage' => 50,
    'AdminMailPerPage' => 50,
    'AdminOrderJuridicalTemplatePerPage' => 50,
    'AdminBookingEventId' => 3016,

    'EmailEventCalendar' => 'calendar@internetmediaholding.com',
    'UserPasswordMinLenght' => 6,
    'CatalogCompanyDir' => '/files/catalog/company/%s/', // файловая директория для хранения каталога логотипов компаний

    /** Partner Params */
    'PartnerOrderPerPage' => 20,
    'PartnerOrderItemPerPage' => 20,
    'PartnerCouponPerPage' => 20,
    'PartnerUserPerPage' => 20,
    'PartnerInviteRequestPerPage' => 20,
    'PartnerCompetenceResultPerPage' => 20,

    /** Ruvents Params */
    'RuventsFountLifetime' => 3660,
    'RuventsMaxResults' => 500,

    /** Взаимодействие с БудуГуру.org */
    'BuduGuru.jobsExportUrl' => 'http://buduguru.org/vacancies/export',
    'BuduGuru.coursesExportUrl' => 'http://buduguru.org/courses/export',

    /** Настройки безопасности */
    'SecureLoginCheckDelay' => 3
];

if (YII_DEBUG) {
    $params['BuduGuru.jobsExportUrl'] = 'http://edu.dev/vacancies/export';
    $params['BuduGuru.coursesExportUrl'] = 'http://edu.dev/courses/export';
}

return $params;
