<?php
namespace partner\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $ExternalKey
 * @property string $RegisterCallback
 * @property string $TryPayCallback
 * @property string $PayCallback
 * @property string $OrderItemCallback
 *
 * Описание вспомогательных методов
 * @method PartnerCallback   with($condition = '')
 * @method PartnerCallback   find($condition = '', $params = [])
 * @method PartnerCallback   findByPk($pk, $condition = '', $params = [])
 * @method PartnerCallback   findByAttributes($attributes, $condition = '', $params = [])
 * @method PartnerCallback[] findAll($condition = '', $params = [])
 * @method PartnerCallback[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method PartnerCallback byId(int $id, bool $useAnd = true)
 * @method PartnerCallback byEventId(int $id, bool $useAnd = true)
 * @method PartnerCallback byExternalKey(string $key, bool $useAnd = true)
 */
class PartnerCallback extends ActiveRecord
{
    /**
     * @param string $className
     * @return PartnerCallback
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PartnerCallback';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, 'event\models\Event', 'EventId']
        ];
    }

    /**
     * @param $key
     * @param \user\models\User $user
     *
     * @return CallbackUser
     */
    protected function addUser($key, \user\models\User $user)
    {
        $callbackUser = CallbackUser::model()->byPartnerCallbackId($this->Id)->byUserId($user->Id)
            ->byCreationTimeFrom(date('Y-m-d H:i:s', time() - 24 * 60 * 60))->find();
        //$callbackUser = null;
        if ($callbackUser == null) {
            $callbackUser = new CallbackUser();
            $callbackUser->PartnerCallbackId = $this->Id;
            $callbackUser->Key = $key;
            $callbackUser->UserId = $user->Id;
            $callbackUser->save();

            $this->sendRegister($key);
        } else {
        }

        return $callbackUser;
    }

    private static $callbacks = [];

    /**
     * @param \event\models\Event $event
     *
     * @return PartnerCallback
     */
    private static function getCallback(\event\models\Event $event)
    {
        if (!isset(self::$callbacks[$event->Id])) {
            self::$callbacks[$event->Id] = PartnerCallback::model()->byEventId($event->Id)->find();
        }

        return self::$callbacks[$event->Id];
    }

    public static function start(\event\models\Event $event)
    {
        $callback = self::getCallback($event);
        if ($callback != null) {
            $key = \Yii::app()->getRequest()->getParam($callback->ExternalKey);
            if ($key != null) {
                $name = 'callbackKey'.$event->Id;
                if (\Yii::app()->user->getCurrentUser() != null) {
                    $callback->addUser($key, \Yii::app()->user->getCurrentUser());
                    if (isset(\Yii::app()->getRequest()->cookies[$name])) {
                        unset(\Yii::app()->getRequest()->cookies[$name]);
                    }
                } else {
                    \Yii::app()->getRequest()->cookies[$name] = new \CHttpCookie($name, $key, ['domain' => '.'.RUNETID_HOST]);
                }
            }
        }
    }

    public static function registration(\event\models\Event $event, \user\models\User $user)
    {
        $callback = self::getCallback($event);
        if ($callback != null) {
            $name = 'callbackKey'.$event->Id;
            $cookies = \Yii::app()->getRequest()->cookies;
            if (isset($cookies[$name]) && \Yii::app()->user->getCurrentUser() != null) {
                $callback->addUser($cookies[$name]->value, $user);
                unset(\Yii::app()->getRequest()->cookies[$name]);
            }
        }
    }

    /**
     * @param \event\models\Event $event
     * @param \user\models\User $user
     * @param int $time
     */
    public static function tryPay(\event\models\Event $event, \user\models\User $user, $time = null)
    {
        if ($time == null) {
            $time = time();
        }

        $callback = self::getCallback($event);
        if ($callback != null) {
            $callbackUser = CallbackUser::model()->byPartnerCallbackId($callback->Id)->byUserId($user->Id)
                ->byCreationTimeFrom(date('Y-m-d H:i:s', $time - 24 * 60 * 60))->find();
            if ($callbackUser != null) {
                $callback->sendTryPay($callbackUser->Key);
            }
        }
    }

    /**
     * @param \event\models\Event $event
     * @param \user\models\User $user
     * @param int $time
     */
    public static function addOrderItem(\event\models\Event $event, \user\models\User $user, $time = null)
    {
        if ($time == null) {
            $time = time();
        }

        $callback = self::getCallback($event);
        if ($callback != null) {
            $callbackUser = CallbackUser::model()->byPartnerCallbackId($callback->Id)->byUserId($user->Id)
                ->byCreationTimeFrom(date('Y-m-d H:i:s', $time - 24 * 60 * 60))->find();
            if ($callbackUser != null) {
                $callback->sendAddOrderItem($callbackUser->Key);
            }
        }
    }

    /**
     * @param \event\models\Event $event
     * @param \pay\models\Order $order
     * @param int $time
     */
    public static function pay(\event\models\Event $event, \pay\models\Order $order, $time = null)
    {
        if ($time == null) {
            $time = time();
        }

        $callback = self::getCallback($event);
        if ($callback != null) {
            $callbackUser = CallbackUser::model()->byPartnerCallbackId($callback->Id)->byUserId($order->Payer->Id)
                ->byCreationTimeFrom(date('Y-m-d H:i:s', $time - 24 * 60 * 60))
                ->byCreationTimeTo(date('Y-m-d H:i:s', $time))->find();
            if ($callbackUser != null) {
                $callback->sendPay($callbackUser->Key, $order->Total);
            }
        }
    }

    private function sendRegister($key)
    {
        if ($this->RegisterCallback != null) {
            $this->sendRequest(sprintf($this->RegisterCallback, $key), $key);
        }
    }

    private function sendTryPay($key)
    {
        if ($this->TryPayCallback != null) {
            $this->sendRequest(sprintf($this->TryPayCallback, $key), $key);
        }
    }

    private function sendAddOrderItem($key)
    {
        if ($this->OrderItemCallback != null) {
            $this->sendRequest(sprintf($this->OrderItemCallback, $key), $key);
        }
    }

    private function sendPay($key, $total)
    {
        if ($this->PayCallback != null) {
            $this->sendRequest(sprintf($this->PayCallback, $key, $total), $key);
        }
    }

    private function sendRequest($url, $key)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_exec($curl);

        $errno = curl_errno($curl);
        if ($errno != 0) {
            $errmsg = curl_error($curl);
            \Yii::log('Не корректный вызов PartnerCallback ID:'.$this->Id.'Ключ: '.$key.'  Ошибка номер: '.$errno.' - '.$errmsg, \CLogger::LEVEL_ERROR);
        } else {
            \Yii::log('Запрос отправлен успешно. URL: '.$url, \CLogger::LEVEL_ERROR);
        }
    }

}