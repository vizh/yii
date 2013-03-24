<?php

class InternalController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'hl12badgefix' => '\partner\controllers\internal\Hl12badgefixAction',
      'hl12badgeinfo' => '\partner\controllers\internal\Hl12badgeinfoAction',
      'tc12import' => '\partner\controllers\internal\Tc12importAction',
      'tc12option' => '\partner\controllers\internal\Tc12optionAction',
      'safor13import' => '\partner\controllers\internal\Safor13importAction',
      'eaapa2013import' => '\partner\controllers\internal\Eaapa2013importAction',
      'icomf13addproduct' => '\partner\controllers\internal\Icomf13addproductAction'
    );
  }
}
