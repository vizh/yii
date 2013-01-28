<?php

return array(
  'modules' => array(
    'partner'
  ),

  'components' => array(

    'partner' => array(
      'class' => '\partner\components\WebUser',
      'stateKeyPrefix'=>'partner',
      'loginUrl' => array('/partner/auth/index'),
      'identityCookie' => array('domain' => '.'.RUNETID_HOST),
      'authTimeout' => 12*60*60,
    ),

    'partnerAuthManager'=>array(
      'class' => '\partner\components\PhpAuthManager',
      'defaultRoles' => array('guest')
    ),

  ),
);