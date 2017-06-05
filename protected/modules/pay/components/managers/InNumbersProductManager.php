<?php
namespace pay\components\managers;

use pay\models\OrderItem;

class InNumbersProductManager extends BaseProductManager
{
    const CallbackUrl = 'http://www.in-numbers.ru/subscribe/callback.php';
    const PrivateKey = '586f5ab0e13a03127a0dfa3af3';

    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     * @param \user\models\User $user
     * @param array $params
     * @return bool
     */
    public function checkProduct($user, $params = [])
    {
        return true;
    }

    /**
     * @param \user\models\User $user
     * @param \pay\models\OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    public function internalBuy($user, $orderItem = null, $params = [])
    {

        $external = [];
        $external['OrderItemId'] = $orderItem->Id;
        $external['RunetId'] = $user->RunetId;
        $external['Key'] = self::PrivateKey;
        $query = urldecode(http_build_query($external));
        $external['Hash'] = md5($query);
        unset($external['Key']);

        \Yii::log(http_build_query($external), \CLogger::LEVEL_ERROR);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::CallbackUrl.'?'.http_build_query($external));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result != 'OK') {
            return false;
        }
        return true;
    }

    /**
     * @param array $params
     * @param string $filter
     * @return array
     */
    public function filter($params, $filter)
    {
        return [];
    }

    /**
     * @param array $params
     * @return \pay\models\Product
     */
    public function getFilterProduct($params)
    {
        return $this->product;
    }

    /**
     * @inheritdoc
     */
    protected function internalRollback(OrderItem $orderItem)
    {
        throw new MessageException(\Yii::t('app', 'Метод отката заказа не реализован для этого типа продукта'));
    }

    /**
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    public function internalChangeOwner($fromUser, $toUser, $params = [])
    {
        return false;
    }
}
