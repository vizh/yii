<?php
namespace pay\components\managers;
use pay\models\OrderItem;
use string;

/**
 * Class Callback
 * @package pay\components\managers
 *
 * @property string $CallbackUrl
 */
class Callback extends BaseProductManager
{
    public $isUniqueOrderItem = false;

    /**
     * @inheritdoc
     */
    public function getProductAttributeNames()
    {
        return array_merge(['CallbackUrl'], parent::getProductAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredProductAttributeNames()
    {
        return ['CallbackUrl'];
    }

    /**
     * @inheritdoc
     */
    public function getOrderItemAttributeNames()
    {
        return array_merge(['Price', 'Data', 'Title'], parent::getOrderItemAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredOrderItemAttributeNames()
    {
        return ['Price', 'Data', 'Title'];
    }


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
     * Оформляет покупку продукта на пользователя
     *
     * @param \user\models\User $user
     * @param \pay\models\OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    protected function internalBuy($user, $orderItem = null, $params = array())
    {
        $params = [
            'Price' => $orderItem->getItemAttribute('Price'),
            'Data' => $orderItem->getItemAttribute('Data')
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->CallbackUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        $result = curl_exec($curl);

        $errno = curl_errno($curl);
        curl_close($curl);
        if ($errno != 0) {
            \Yii::log(sprintf('Не корректное обращение к CallbackUrl (OrderItem: %s). Ошибка номер: %s', $orderItem->Id, $errno), \CLogger::LEVEL_ERROR);
            return false;
        }
        $resultObject = json_decode($result);

        if (!isset($resultObject->Success) || !$resultObject->Success) {
            \Yii::log(sprintf("Не корректное обращение к CallbackUrl (OrderItem: %s). Ответ сервера: %s \r\n \r\n Параметры: %s", $orderItem->Id, $result, var_export($params, true)), \CLogger::LEVEL_ERROR);
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function internalRollback(OrderItem $orderItem)
    {

    }

    /**
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    protected function internalChangeOwner($fromUser, $toUser, $params = array())
    {
        return false;
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

    public function getPrice($orderItem)
    {
        return $orderItem->getItemAttribute('Price');
    }

    public function getTitle($orderItem)
    {
        return $orderItem->getItemAttribute('Title');
    }


}