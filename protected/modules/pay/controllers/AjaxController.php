<?php
class AjaxController extends \pay\components\Controller
{
  public function actions()
  {
    return array(
      'couponactivate' => '\pay\controllers\ajax\CouponActivateAction',
    );
  }
}
