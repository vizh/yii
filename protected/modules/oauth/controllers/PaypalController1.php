<?php
class PaypalController extends \application\components\controllers\BaseController
{
  public function actionRedirect()
  {
    $code = \Yii::app()->getRequest()->getParam('code', null);
    $redirectUrl = \Yii::app()->getSession()->get(\oauth\components\social\PayPal::SessionNameRedirectUrl, null);
    if ($code == null || $redirectUrl == null)
      throw new \CHttpException(404);

    $redirectUrl .= '&code='.$code;
    $this->redirect($redirectUrl);
  }
} 