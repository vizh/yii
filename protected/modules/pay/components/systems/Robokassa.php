<?php
namespace pay\components\systems;

class RobokassaSystem extends Base
{
    private static $encoding = 'utf-8';
    const Url = 'http://test.robokassa.ru/Index.aspx';

    private $login;
    private $password1;
    private $password2;

    /**
     * @return array
     */
    public function RequiredParams()
    {
        return ['Login', 'Password1', 'Password2'];
    }

    protected function initRequiredParams($orderId)
    {
        $params = null;
        $order = \pay\models\Order::GetById($orderId);
        if (!empty($order)) {
            $account = \pay\models\PayAccount::GetByEventId($order->EventId);
            $params = !empty($account) ? $account->GetSystemParams() : null;
        }

        if (!empty($params)) {
            $this->login = $params['Login'];
            $this->password1 = $params['Password1'];
            $this->password2 = $params['Password2'];
        } else {
            throw new \pay\models\PayException('Не удалось получить параметры платежной системы RoboKassa для заказа №'.$orderId);
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
    public function Check()
    {
        $request = \Yii::app()->getRequest();
        $sig = $request->getParam('SignatureValue', false);
        return $sig !== false;
    }

    /**
     * Заполняет общие параметры всех платежных систем, для единой обработки платежей
     * @throws \pay\models\PayException
     * @return void
     */
    public function FillParams()
    {
        $request = \Yii::app()->getRequest();
        $orderId = $request->getParam('InvId');
        $total = $request->getParam('OutSum');
        $this->initRequiredParams($orderId);

        $hash = strtoupper($request->getParam('SignatureValue'));
        $myHash = strtoupper(md5("{$total}:{$orderId}:{$this->password2}"));
        if ($hash === $myHash) {
            $this->OrderId = $orderId;
            $this->Total = $total;
        } else {
            throw new \pay\models\PayException('Ошибка при вычислении хеша!', 211);
        }
    }

    /**
     * Выполняет отправку пользователя на оплату в соответствующую платежную систему
     * @param int $eventId
     * @param string $orderId
     * @param int $total
     * @return void
     */
    public function ProcessPayment($eventId, $orderId, $total)
    {
        $this->initRequiredParams($orderId);
        $total = number_format($total, 2, '.', '');

        //$total = 100;
        //$orderId = 1499;

        $params = [];
        $params['MrchLogin'] = $this->login;
        $params['OutSum'] = $total;
        $params['InvId'] = $orderId;
        $params['SignatureValue'] = md5("{$this->login}:{$total}:{$orderId}:{$this->password1}");
        $params['IncCurrLabel'] = 'PCR';
        $params['Culture'] = 'ru';

        $query = http_build_query($params);

        //echo $this->password1;
        echo self::Url.'?'.$query;
        //Lib::Redirect(self::Url . '?' . http_build_query($params));
        //echo "<html><script language=JavaScript ".
        //      "src='http://test.robokassa.ru/Index.aspx?{$query}'></script></html>";
        //exit;

    }

    /**
     * @return void
     */
    public function EndParseSystem()
    {
        header('Status: 200');
        echo 'OK'.$this->OrderId();
        exit();
    }
}
