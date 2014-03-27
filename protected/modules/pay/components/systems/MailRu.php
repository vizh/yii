<?php
namespace pay\components\systems;
\Yii::import('ext.MailRuMoney.mailru-money', true);

class MailRu extends Base
{
  const ApiKey = 'U2FsdGVkX1+JQ/oIK0qR+D90UV09C1XF5a4xTRDwex79fzCmVhju7Tl9zC4+u3D99lbZR2DNbtJdSfbhVt/gJVWXjZH7cKLN2+mkfxNc2Jx+ARpUabHtybmAbfPupDVx';


  /**
   * @return array
   */
  public function getRequiredParams()
  {
    return [];
  }

  protected function initRequiredParams($orderId)
  {

  }

  protected function getClass()
  {
    return __CLASS__;
  }

  /**
   * Проверяет, может ли данный объект обработать callback платежной системы
   * @return bool
   */
  public function check()
  {
    return false;
  }

  /**
   * Заполняет общие параметры всех платежных систем, для единой обработки платежей
   * @return void
   */
  public function fillParams()
  {
    $request = \Yii::app()->getRequest();
    $this->orderId = \MailRu_Money_Utils::base64Decode($request->getParam('issuer_id'));
    $this->total = intval($request->getParam('amount'));
  }

  /**
   * Выполняет отправку пользователя на оплату в соответствующую платежную систему
   * @param int $eventId
   * @param string $orderId
   * @param int $total
   * @return void
   */
  public function processPayment($eventId, $orderId, $total)
  {

  }

  /**
   * @return void
   */
  public function endParseSystem()
  {

  }
}