<?php
return array(
  'modules' => array(
    'ruvents',
  ),
  'components' => array(

    'ruventsAuthManager'=>array(
      'class' => '\ruvents\components\PhpAuthManager',
      'defaultRoles' => array('guest')
    )

  ),
);