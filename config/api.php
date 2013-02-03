<?php

return array(
  'modules' => array(
    'api'
  ),

  'components' => array(

    'apiAuthManager'=>array(
      'class' => '\api\components\PhpAuthManager',
      'defaultRoles' => array('guest')
    )

  ),
);