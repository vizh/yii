<?php

return array(
  'components' => array(
    'payUser' => array(
      'class' => '\application\components\auth\WebUser',
      'stateKeyPrefix'=>'payUser',
      'loginUrl' => null,
      'identityCookie' => array('domain' => '.'.RUNETID_HOST)
    ),
  )
);