<?php

return array(
  'guest' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Guest',
    'bizRule' => null,
    'data' => null
  ),
  'Operator' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'Operator',
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
        'Operator',
      ),
      'bizRule' => null,
      'data' => null
    ),
);