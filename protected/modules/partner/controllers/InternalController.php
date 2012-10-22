<?php

class InternalController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'hl12badgefix' => '\partner\controllers\internal\Hl12badgefixAction'
    );
  }
}
