<?php
namespace pay\models\forms;

use application\components\form\EventItemCreateUpdateForm;
use application\helpers\Flash;
use event\models\Event;
use pay\models\Order;
use pay\models\OrderJuridical;
use pay\models\OrderType;
use pay\models\Product;
use user\models\User;

/**
 * Class Juridical
 * @package pay\models\forms
 *
 * @property Order $model
 *
 * @method OrderJuridical getActiveRecord()
 *
 */
class Juridical extends EventItemCreateUpdateForm
{
    public $Name;

    public $Address;

    public $INN;

    public $KPP;

    public $Phone;

    public $PostAddress;

    /** @var User */
    private $user;

    /** @var Order */
    private $order;

    /**
     * @param Event $event
     * @param User $user
     * @param Order|null $model
     */
    public function __construct(Event $event, User $user, Order $model = null)
    {
        $this->user = $user;
        $this->order = $model;
        parent::__construct($event, $model !== null ? $model->OrderJuridical : null);
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return null|Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function rules()
    {
        return [
            ['Name, Address, INN, KPP, Phone, PostAddress', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Name, Address, INN, KPP, Phone', 'required'],
            ['PostAddress', 'safe']
        ];
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if (empty($values['PostAddress'])) {
            $values['PostAddress'] = isset($values['Address']) ? $values['Address'] : '';
        }
        parent::setAttributes($values, $safeOnly);
    }

    public function attributeLabels()
    {
        return [
            'Name' => \Yii::t('app', 'Название компании'),
            'Address' => \Yii::t('app', 'Юридический адрес (с индексом)'),
            'INN' => \Yii::t('app', 'ИНН'),
            'KPP' => \Yii::t('app', 'КПП'),
            'Phone' => \Yii::t('app', 'Телефон'),
            'PostAddress' => \Yii::t('app', 'Почтовый адрес (с индексом)'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHelpMessages()
    {
        return [
            'Name' => \Yii::t('app', 'Полное наименование организации, включая организационно-правовую форму предприятия'),
            'Address' => \Yii::t('app', 'Например: 123317, г. Москва, Пресненская набережная, дом 6, строение 2, этаж 27, помещение I'),
            'INN' => \Yii::t('app', '10 или 12 цифр, зависит от организационной формы'),
            'KPP' => \Yii::t('app', '9 цифр, если имеется'),
            'Phone' => \Yii::t('app', 'Формат: +7 (xxx) xxx-xx-xx'),
            'PostAddress' => \Yii::t('app', 'Например: 123317, г. Москва, Пресненская набережная, дом 6, строение 2, этаж 27, помещение I'),
        ];
    }

    /**
     * @return Order|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->fillActiveRecord();
        $this->model->save();
        return $this->model;
    }

    /**
     * Создает счет
     * @return null|OrderJuridical
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        /** @var \CDbTransaction $transaction */
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $order = new Order();
            $order->create($this->user, $this->event, OrderType::Juridical, $this->getAttributes());
            $this->order = $order;
            $this->model = $order->OrderJuridical;
            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            Flash::setError($e->getMessage());
            return null;
        }
    }

    /**
     * @return array
     */
    public function getProductData()
    {
        $products = Product::model()->byEventId($this->event->Id)->byDeleted(false)->excludeRoomManager()->findAll();
        return \CHtml::listData($products, 'Id', 'Title');
    }
}
