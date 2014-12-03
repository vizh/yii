<?php

return [
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
    'oauth' => ['csrfValidation' => true],
    'pay' => ['csrfValidation' => true],
    'rbac',
    'tag',
    'user',
    'search',
    'job',
    'page',
    'widget',
    'link',
    'raec',
    'sms',
    'competence',

  /** Технические модули */
    'mytest',
    'mail'
];
