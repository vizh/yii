<?php

namespace partner\models;

use application\components\ActiveRecord;
use event\models\Event;
use GuzzleHttp;
use JsonSerializable;
use pay\models\Order;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;
use Yii;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $PartnerId
 * @property string $OnOrderPaid
 * @property string $OnCouponActivate
 * @property string $OnOrderItemRefund
 * @property string $OnOrderItemChangeOwner
 *
 * @property Event $Event
 * @property Account $Partner
 *
 * Описание вспомогательных методов
 * @method PartnerCallback   with($condition = '')
 * @method PartnerCallback   find($condition = '', $params = [])
 * @method PartnerCallback   findByPk($pk, $condition = '', $params = [])
 * @method PartnerCallback   findByAttributes($attributes, $condition = '', $params = [])
 * @method PartnerCallback[] findAll($condition = '', $params = [])
 * @method PartnerCallback[] findAllByAttributes($attributes, $condition = '', $params = [])
 * @method PartnerCallback byId(int $id, bool $useAnd = true)
 * @method PartnerCallback byEventId(int $id, bool $useAnd = true)
 * @method PartnerCallback byPartnerId(int $id, bool $useAnd = true)
 */
class PartnerCallback extends ActiveRecord implements JsonSerializable
{
    /** @var GuzzleHttp\Client */
    private static $client;

    /** @var GuzzleHttp\Message\Request[] */
    private static $clientQueue;

    /**
     * @param null|string $className
     *
     * @return static
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

    public function rules()
    {
        return [
            ['Id', 'numerical', 'safe' => false, 'allowEmpty' => false, 'integerOnly' => true, 'on' => 'update'],
            ['EventId,PartnerId', 'numerical', 'safe' => false, 'allowEmpty' => false, 'integerOnly' => true],
            ['EventId', 'exist', 'allowEmpty' => false, 'attributeName' => 'Id', 'className' => '\event\models\Event'],
            ['PartnerId', 'exist', 'allowEmpty' => false, 'attributeName' => 'Id', 'className' => '\partner\models\Account'],
            ['OnOrderPaid,OnCouponActivate,OnOrderItemRefund,OnOrderItemChangeOwner', 'length', 'max' => 1000],
            ['OnOrderPaid,OnCouponActivate,OnOrderItemRefund,OnOrderItemChangeOwner', 'url']
        ];
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Partner' => [self::BELONGS_TO, '\partner\models\Account', 'PartnerId', 'together' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'OnOrderPaid' => 'Оплата счёта',
            'OnCouponActivate' => 'Активация скидки',
            'OnOrderItemRefund' => 'Возврат заказа',
            'OnOrderItemChangeOwner' => 'Смена владельца заказа'
        ];
    }

    /**
     * Возвращает список обратных вызовов, доступных для данного мероприятия.
     *
     * @param Event  $event
     * @param string $callbackType
     * @param array  $data
     */
    private static function addScheduledCallback(Event $event, $callbackType, $data)
    {
        static $callbacks;

        // Кешируем список определённых для текущего мероприятия обратных вызовов
        if ($callbacks === null) {
            $callbacks = self::model()
                ->byEventId($event->Id)
                ->findAll();
        }

        // Инициализируем и кешируем GuzzleHttp клиент и планируем выполнение обратных вызовов
        if (self::$client === null) {
            self::$client = new GuzzleHttp\Client([
                'cookies' => false,
                'defaults' => [
                    'headers' => [
                        'User-Agent' => 'RUNET-ID Callback System',
                        'Content-Type' => 'application/callback; OrderPaid',
                        'Date' => date('r', time())
                    ]
                ]
            ]);
            // Планируем выполнение обратных вызовов после окончания выполнения работы по генерации ответа сервера.
            Yii::app()->attachEventHandler('onEndRequest', function () {
                if (YII_DEBUG === false) {
                    GuzzleHttp\Pool::send(self::$client, self::$clientQueue);
                }
            });
        }

        // Пополняем очередь обратных вызовов.
        foreach ($callbacks as $callback) {
            // toDo: Для php версии 5.5+ можно empty($url = $callback->$callbackType)
            $url = $callback->$callbackType;
            if (false === empty($url)) {
                self::$clientQueue[] = self::$client->createRequest('POST', $url, ['json' => array_merge(['EventId' => $event->Id], $data)]);
            }
        }
    }

    public static function onOrderPaid(Event $event, Order $order)
    {
        self::addScheduledCallback($event, 'OnOrderPaid', [
            'OrderId' => $order->Id,
            'PayerId' => $order->Payer->RunetId
        ]);
    }

    public static function onCouponActivate(Event $event, User $payer, User $owner, Product $product)
    {
        self::addScheduledCallback($event, 'OnCouponActivate', [
            'PayerId' => $payer->RunetId,
            'OwnerId' => $owner->RunetId,
            'ProductId' => $product === null ? null : $product->Id
        ]);
    }

    public static function onOrderItemRefund(Event $event, OrderItem $item)
    {
        self::addScheduledCallback($event, 'OnOrderItemRefund', [
            'OrderItemId' => $item->Id,
            'PayerId' => $item->Payer->RunetId,
            'OwnerId' => $item->Owner->RunetId
        ]);
    }

    public static function onOrderItemRedirect(Event $event, OrderItem $item, $sourceOwnerId)
    {
        self::addScheduledCallback($event, 'OnOrderItemChangeOwner', [
            'OrderItemId' => $item->Id,
            'PayerId' => $item->Payer->RunetId,
            'SourceOwnerId' => $sourceOwnerId,
            'TargetOwnerId' => $item->Owner->RunetId
        ]);
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $jsonData = $this->getAttributes();

        if ($this->hasRelated('Partner')) {
            $jsonData['Partner'] = $this->Partner->jsonSerialize();
        }

        return $jsonData;
    }
}