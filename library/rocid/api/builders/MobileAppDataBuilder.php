<?php

class MobileAppDataBuilder extends BaseDataBuilder
{
  public function GetDeny()
  {
    return array(
      'pay' => null,
      'event' => array(
        '' => array('changerole', 'register'),
      ),
      'user' => array(
        '' => array('create')
      )
    );
  }
}
