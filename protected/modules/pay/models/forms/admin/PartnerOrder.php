<?php
namespace pay\models\forms\admin;

class PartnerOrder extends \CFormModel
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

  private $owner;

  public function __construct($owner, $scenario = '')
  {
    parent::__construct($scenario);
    $this->owner = $owner;
  }


  public function rules()
  {
    return [
      ['Name, Address, INN, KPP, BankName, Account, CorrespondentAccount, BIK, ChiefName, ChiefPosition, ChiefNameP, ChiefPositionP', 'required'],
      ['BookingIdList', 'filter', 'filter' => [$this, 'filterBookingIdList']]
    ];
  }

  public function attributeLabels()
  {
    return [
      'Name' => \Yii::t('app', 'Название организации'),
      'Address' => \Yii::t('app', 'Адрес'),
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
    ];
  }


  public function filterBookingIdList($value)
  {
    $valid = true;

    if (!is_array($value))
    {
      $valid = false;
    }
    else
    {
      foreach ($value as $bookingId)
      {
        $booking = \pay\models\RoomPartnerBooking::model()->byOwner($this->owner)->byDeleted(false)->findByPk($bookingId);
        if ($booking == null)
        {
          $valid = false;
          break;
        }
      }
    }

    if (!$valid)
    {
      $this->addError('BookingIdList', \Yii::t('app', 'Ошибка при добавление брони в счет'));
    }

    return $value;
  }

  public function getOwner()
  {
    return $this->owner;
  }
} 