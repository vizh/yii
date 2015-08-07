<?php
namespace pay\models\forms;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use event\models\Event;
use pay\models\Order;
use pay\models\OrderJuridical;
use pay\models\OrderType;
use user\models\User;

class Juridical extends CreateUpdateForm
{
    public $Name;

    public $Address;

    public $INN;

    public $KPP;

    public $Phone;

    public $PostAddress;

    /** @var Order */
    private $order;

    /** @var User */
    public $user;

    /** @var Event */
    public $event;

    /**
     * @param Order|null $model
     */
    public function __construct(Order $model = null)
    {
        if ($model !== null) {
            $this->order = $model;
            parent::__construct($model->OrderJuridical);
        } else {
            parent::__construct(null);
        }
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
            'Address' => \Yii::t('app', 'Например: 123056, г. Москва, ул. Б. Грузинская, д. 42, ком. 12'),
            'INN' => \Yii::t('app', '10 или 12 цифр, зависит от организационной формы'),
            'KPP' => \Yii::t('app', '9 цифр, если имеется'),
            'Phone' => \Yii::t('app', 'Формат: +7 (xxx) xxx-xx-xx'),
            'PostAddress' => \Yii::t('app', 'Например: 123056, г. Москва, ул. Б. Грузинская, д. 42, ком. 12'),
        ];
    }

    /**
     * @return \CActiveRecord|null
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
     * @param User $user
     * @param Event $event
     * @return null
     */
    public function createActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        /** @var \CDbTransaction $transaction */
        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->order = new Order();
            $this->order->create($this->user, $this->event, OrderType::Juridical, $this->getAttributes());
            $this->model = $this->order->OrderJuridical;
            $transaction->commit();
            return $this->model;
        } catch (\Exception $e) {
            Flash::setError($e->getMessage());
            return null;
        }
    }


}
