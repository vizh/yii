<?php
namespace pay\models\forms\admin;

use application\components\form\CreateUpdateForm;
use application\helpers\Flash;
use pay\models\RoomPartnerBooking;
use pay\models\RoomPartnerOrder;

/**
 * Форма редактировния заказа брони партнера
 * Class PartnerOrder
 * @package pay\models\forms\admin
 */
class PartnerOrder extends CreateUpdateForm
{
    public $Name;
    public $Address;
    public $INN;
    public $KPP;
    public $BankName;
    public $Account;
    public $CorrespondentAccount;
    public $BIK;
    public $ChiefName;
    public $ChiefPosition;
    public $ChiefNameP;
    public $ChiefPositionP;
    public $BookingIdList = [];

    public $StatuteTitle = 'Устава';
    public $RealAddress;

    private $owner;

    /**
     * @param string $owner
     * @param \CActiveRecord $model
     */
    public function __construct($owner, \CActiveRecord $model = null)
    {
        parent::__construct($model);
        $this->owner = $owner;
    }


    public function rules()
    {
        return [
            ['Name, Address, INN, KPP, BankName, Account, CorrespondentAccount, BIK, ChiefName, ChiefPosition, ChiefNameP, ChiefPositionP,StatuteTitle', 'required'],
            ['BookingIdList', 'bookingValidate'],
            ['RealAddress', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Name' => \Yii::t('app', 'Название организации'),
            'Address' => \Yii::t('app', 'Юридический адрес'),
            'INN' => \Yii::t('app', 'ИНН'),
            'KPP' => \Yii::t('app', 'KПП'),
            'BankName' => \Yii::t('app', 'Банк'),
            'Account' => \Yii::t('app', 'Расчетный счет'),
            'CorrespondentAccount' => \Yii::t('app', 'Кор. счет'),
            'BIK' => \Yii::t('app', 'БИК'),
            'ChiefName' => \Yii::t('app', 'Имя руководителя'),
            'ChiefPosition' => \Yii::t('app', 'Должность руководителя'),
            'ChiefNameP' => \Yii::t('app', 'Имя руководителя (в род. падеже)'),
            'ChiefPositionP' => \Yii::t('app', 'Должность руководителя(в род. падеже)'),
            'RealAddress' => \Yii::t('app', 'Фактический адрес'),
            'StatuteTitle' => \Yii::t('app', 'Действующего на основании (в род. падаже, с большой буквы)'),
        ];
    }

    /**
     * @return \CActiveRecord|null
     * @throws \application\components\Exception
     */
    public function createActiveRecord()
    {
        $eventId = \Yii::app()->params['AdminBookingEventId'];
        $number = RoomPartnerOrder::model()->byEventId($eventId)->count() + 1;

        $order = new RoomPartnerOrder();
        $order->Number  = ('RIF15/' . str_pad($number, 3, '0', STR_PAD_LEFT));
        $order->EventId = $eventId;
        $this->model = $order;
        return $this->updateActiveRecord();
    }


    /**
     * @return CActiveRecord|null
     * @throws \CDbException
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();
            $this->model->save();
            foreach ($this->BookingIdList as $id) {
                $booking = RoomPartnerBooking::model()->findByPk($id);
                $booking->OrderId = $this->model->Id;
                $booking->save();
            }
            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
        return null;
    }

    public function bookingValidate($attribute)
    {
        $value = $this->$attribute;
        $valid = true;
        if (!is_array($value)) {
            $valid = false;
        }
        else {
            foreach ($value as $id) {
                $booking = RoomPartnerBooking::model()->byOwner($this->owner)->byDeleted(false)->findByPk($id);
                if ($booking == null) {
                    $valid = false;
                }
            }
        }

        if (!$valid) {
            $this->addError($attribute, \Yii::t('app', 'Ошибка при добавление брони в счет'));
            return false;
        }
        return true;
    }

    public function getOwner()
    {
        return $this->owner;
    }
} 