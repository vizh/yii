<?php
namespace pay\components\systems;

/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 18.01.12
 * Time: 19:43
 * To change this template use File | Settings | File Templates.
 */
class TestSystem extends Base
{

    /**
     * @return array
     */
    public function RequiredParams()
    {
        return [];
    }

    protected function initRequiredParams($orderId)
    {
        return;
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
        $ttt = $request->getParam('ttt', false);
        return $ttt == 'rocid';
    }

    /**
     * Заполняет общие параметры всех платежных систем, для единой обработки платежей
     * @return void
     */
    public function FillParams()
    {
        $request = \Yii::app()->getRequest();
        $this->OrderId = intval($request->getParam('orderid'));
        $this->Total = intval($request->getParam('total'));
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
        $params = [];

        $params['ttt'] = 'rocid';
        $params['orderid'] = $orderId;
        $params['total'] = $total;

        $url = RouteRegistry::GetUrl('callback', '', 'index').'?'.http_build_query($params);

        echo '<a target="_blank" href="'.$url.'">Провести оплату</a>';
    }

    /**
     * @return void
     */
    public function EndParseSystem()
    {
        header('Status: 200');
        echo 'OK';
        print_r($this);
    }
}
