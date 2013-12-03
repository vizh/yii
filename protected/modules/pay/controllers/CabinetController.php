<?php

class CabinetController extends \pay\components\Controller
{
  /**
   * @return array Фильтры
   */
  public function filters()
  {
    return array_merge(parent::filters(), array(
      'postOnly + deleteitem'
    ));
  }

  public function actions()
  {
    return array(
      'register' => 'pay\controllers\cabinet\RegisterAction',
      'index' => 'pay\controllers\cabinet\IndexAction',
      'deleteitem' => 'pay\controllers\cabinet\DeleteItemAction',
      'pay' => 'pay\controllers\cabinet\PayAction',
      'return' => 'pay\controllers\cabinet\ReturnAction',
      'offer' => 'pay\controllers\cabinet\OfferAction',
      'auth' => 'pay\controllers\cabinet\AuthAction'
    );
  }
}
