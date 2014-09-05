<?php
class AjaxController extends \pay\components\Controller
{
  public function actions()
  {
    return array(
      'couponactivate' => '\pay\controllers\ajax\CouponActivateAction',
      'couponinfo' => '\pay\controllers\ajax\CouponInfoAction',
        'userdata' => '\pay\controllers\ajax\UserDataAction',
        'edituserdata' => '\pay\controllers\ajax\EditUserDataAction',
    );
  }
}
