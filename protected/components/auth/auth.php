<?php

return array(
  'guest' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Без авторизации',
    'bizRule' => null,
    'data' => null
  ),

  'admin' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Админский доступ',
    'children' => array(
      'guest',
    ),
    'bizRule' => null,
    'data' => null
  ),

  'booker' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Бухгалтерский доступ',
    'children' => array(
      'guest',
    ),
    'bizRule' => null,
    'data' => null
  ),
);