<?php
namespace pay\components\systems;

class Uniteller extends Base
{
  const Url = 'https://wpay.uniteller.ru/pay/';

  private $shopId;
  private $password;

    function __construct($addition = null, $shopId = null)
    {
        parent::__construct($addition);
        $this->shopId = $shopId;
    }

  /**
   * @return array
   */
  public function getRequiredParams()
  {
    return array('Shop_IDP', 'Password');
  }

    protected function initRequiredParams($orderId)
    {
        if ($this->addition === 'ruvents') {
            $this->password = '1T6IFhrMvLxPEUzLhRBKIE4tX14CrT2aWUHke0yyLd6PT46ztWsr8pnUlHG5nnB4djSM9nFZnYE2k3Kt';
            if ($this->shopId == null) {
                $this->shopId = '00003770';
            }
        } else {
            $this->password = 'Ip4Ft2bcCCGezOni6S9aihhAZ2I0MPlUJgw9G1SNflmZMkJ7UIIQVheXtZG29cGUsSSxko9stQWHXdqK';
            if ($this->shopId == null) {
                $this->shopId = '00001681';
            }
        }
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
    $request = \Yii::app()->getRequest();
    $orderId = $request->getParam('Order_ID', false);
    $signature = $request->getParam('Signature', false);
    return $orderId !== false && $signature !== false;
  }

    /**
     * Заполняет общие параметры всех платежных систем, для единой обработки платежей
     * @throws \pay\components\Exception
     * @return void
     */
  public function fillParams()
  {
    $request = \Yii::app()->getRequest();
    $orderId = $request->getParam('Order_ID');
    $this->initRequiredParams($orderId);
    $status = $request->getParam('Status');
    $hash = strtoupper(md5($orderId . $status . $this->password));

    if ($status != 'paid' && $status != 'authorized')
    {
      throw new \pay\components\Exception('Не корректный статус платежа: ' . $status .'!', 221);
    }

    if ($hash === $request->getParam('Signature'))
    {
      $this->orderId = $orderId;
      $this->total = null;
    }
    else
    {
      throw new \pay\components\Exception('Ошибка при вычислении хеша! Hash='.$hash, 211);
    }
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
    $this->initRequiredParams($orderId);
    $total = number_format($total, 2, '.', '');

    $params = array();
    $params['Shop_IDP'] = $this->shopId;
    $params['Order_IDP'] = $orderId;
    $params['Subtotal_P'] = $total;

    $signature = strtoupper(md5(md5($this->shopId) . '&'
        . md5($orderId) . '&'
        . md5($total) . '&'
        . md5('') . '&'
        . md5('') . '&'
        . md5('') . '&'
        . md5('') . '&'
        . md5('') . '&'
        . md5('') . '&'
        . md5('') . '&'
        . md5($this->password)));


    $params['Signature'] = $signature;
    $params['Language'] = \Yii::app()->getLanguage() == 'en' ? 'en' : 'ru';
    $params['URL_RETURN'] = \Yii::app()->createAbsoluteUrl('/pay/cabinet/return', array('eventIdName' => \event\models\Event::model()->findByPk($eventId)->IdName));

    \Yii::app()->getController()->redirect(self::Url . '?' . http_build_query($params));
  }

  /**
   * @return void
   */
  public function endParseSystem()
  {
    header('Status: 200');
    echo 'OK';
    exit();
  }

}
