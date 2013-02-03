<?php

return array(
  'guest' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Без авторизации в рамках api',
    'bizRule' => null,
    'data' => null
  ),
  'Mobile' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Авторизация в качестве мобильного приложения',
    'children' => array(
      'guest',
    ),
    'bizRule' => null,
    'data' => null
  ),
  'Partner' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Авторизация с партнерским доступом к api',
    'children' => array(
      'Mobile',
    ),
    'bizRule' => null,
    'data' => null
  ),
  'Own' => array(
      'type' => CAuthItem::TYPE_ROLE,
      'description' => 'Авторизация с максимальным доступом к api',
      'children' => array(
        'Partner',
      ),
      'bizRule' => null,
      'data' => null
    ),
);