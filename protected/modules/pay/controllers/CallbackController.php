<?php

class CallbackController extends CController
{
  public function actionIndex()
  {
    try
    {
      \pay\components\SystemRouter::Instance()->parseSystemCallback();
    }
    catch (\pay\components\Exception $e)
    {
      \pay\components\SystemRouter::logError($e->getMessage(), $e->getCode());
      header('Status: 500');
      exit();
    }
  }

  public function actionMailru()
  {
    $system = new \pay\components\systems\MailRu();
    $system->fillParams();

    $request = \Yii::app()->getRequest();
    $itemNumber = $request->getParam('item_number');

    $sign = MailRu_Money_Utils::signData($_REQUEST, \pay\components\systems\MailRu::ApiKey, MailRu_Money::SIGN_TYPE_SHA1);
    if ($sign != $request->getParam('signature'))
    {
      $this->sendMailRuResponse($itemNumber, MailRu_Money::STATUS_CODE_ERR_INVALID_SIGNATURE);
      \pay\components\SystemRouter::logError(MailRu_Money::STATUS_CODE_ERR_INVALID_SIGNATURE . ": Ошибка проверки цифровой подписи - " . $sign, 6001);
      Yii::app()->end();
    }

    $type = $request->getParam('type');

    if ($type == 'INVOICE')
    {
      $status = $request->getParam('status');
      $order = \pay\models\Order::model()->findByPk($system->getOrderId());
      if ($order == null)
      {
        $this->sendMailRuResponse($itemNumber, MailRu_Money::STATUS_CODE_ERR_WRONG_STRUCT);
        \pay\components\SystemRouter::logError(MailRu_Money::STATUS_CODE_ERR_WRONG_STRUCT . ': Не найден счет № ' . $system->getOrderId(), 6002);
        Yii::app()->end();
      }

      switch ($status) {
        case 'DELIVERED':
          $urlPay = $request->getParam('url_pay');
          if (!empty($urlPay))
          {
            $order->OrderJuridical->UrlPay = $urlPay;
            $order->OrderJuridical->save();
            $this->sendMailRuResponse($itemNumber);
          }
          else
          {
            $this->sendMailRuResponse($itemNumber, MailRu_Money::STATUS_CODE_ERR_WRONG_STRUCT);
            \pay\components\SystemRouter::logError(MailRu_Money::STATUS_CODE_ERR_WRONG_STRUCT . ': Не задана ссылка для перехода к оплате для счета № ' . $system->getOrderId(), 6003);
          }
          break;
        case 'PAID':
          try {
            $system->parseSystem();
            \pay\components\SystemRouter::LogSuccessWithParams($system->info(), get_class($system), $system->getOrderId(), $system->getTotal());
          }
          catch (\pay\components\Exception $e) {
            \pay\components\SystemRouter::logError($e->getMessage(), $e->getCode());
          }
          $this->sendMailRuResponse($itemNumber);
          break;
        case 'REJECTED':
          $order->delete();
          $this->sendMailRuResponse($itemNumber);
          break;
        default:
          $this->sendMailRuResponse($itemNumber, MailRu_Money::STATUS_CODE_ERR_WRONG_STRUCT);
          \pay\components\SystemRouter::logError(MailRu_Money::STATUS_CODE_ERR_WRONG_STRUCT . ': Передан неизвестный статус для счета ' . $system->getOrderId(), 6004);
      }
    }
    elseif ($type == 'PAYMENT')
    {
      $this->sendMailRuResponse($itemNumber);
      \pay\components\SystemRouter::logError('Log success payment response', 6009);
    }
  }

  private function sendMailRuResponse($itemNumber, $error = false)
  {
    echo "item_number=" . $itemNumber . "\r\n";
    if (!$error)
    {
      echo "status=ACCEPTED\r\n";
    }
    else
    {
      echo "status=REJECTED\r\n";
      echo "code=" . $error . "\r\n";
    }
  }
}
