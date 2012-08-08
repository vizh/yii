<?php

return array(
  'guest' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Guest',
    'bizRule' => null,
    'data' => null
  ),
  'Partner' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Administrator',
    'children' => array(
      'guest',
    ),
    'bizRule' => null,
    'data' => null
  ),

  'Admin' => array(
      'type' => CAuthItem::TYPE_ROLE,
      'description' => 'Administrator',
      'children' => array(
        'Partner',
      ),
      'bizRule' => null,
      'data' => null
    ),
);