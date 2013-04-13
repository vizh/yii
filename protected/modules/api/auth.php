<?php

return array(
  'guest' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Без авторизации в рамках api',
    'bizRule' => null,
    'data' => null
  ),

  'base' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Базовый набор прав доступа',
    'children' => array(
      'guest',
    ),
    'bizRule' => null,
    'data' => null
  ),

  'mobile' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Авторизация в качестве мобильного приложения',
    'children' => array(
      'base',
    ),
    'bizRule' => null,
    'data' => null
  ),
  'partner' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Авторизация с партнерским доступом к api',
    'children' => array(
      'base',
    ),
    'bizRule' => null,
    'data' => null
  ),

  'own' => array(
      'type' => CAuthItem::TYPE_ROLE,
      'description' => 'Авторизация с максимальным доступом к api',
      'children' => array(
        'partner',
      ),
      'bizRule' => null,
      'data' => null
    ),



  'sberbank' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Авторизация для сбербанка',
    'bizRule' => null,
    'data' => null
  ),
);