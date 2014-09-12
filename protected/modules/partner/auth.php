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
    'description' => 'Partner',
    'children' => array(
      'guest',
    ),
    'bizRule' => null,
    'data' => null
  ),
    'PartnerVerified' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Partner',
        'children' => array(
            'Partner',
        ),
        'bizRule' => null,
        'data' => null
    ),
  'PartnerExtended' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'PartnerExtended - account for multi-event access',
    'children' => array(
      'Partner',
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

  'AdminExtended' => array(
    'type' => CAuthItem::TYPE_ROLE,
    'description' => 'AdministratorExtended - account for multi-event access',
    'children' => array(
      'Admin',
    ),
    'bizRule' => null,
    'data' => null
  ),
);