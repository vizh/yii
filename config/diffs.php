<?php

return array(


  'components' => array(
    'user' => array(
      'class' => '\application\components\auth\WebUser',
    ),


    'partnerAuthManager'=>array(
      'class' => '\partner\components\PhpAuthManager',
      'defaultRoles' => array('guest')
    )
  )
);