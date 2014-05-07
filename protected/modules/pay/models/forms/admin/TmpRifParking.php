<?php
namespace pay\models\forms\admin;

class TmpRifParking extends \CFormModel
{
  public $Brand;
  public $Model;
  public $Number;
  public $Hotel;
  public $DateIn;
  public $DateOut;
  public $Status;

  public function rules()
  {
    return[
      ['Number,Hotel,Status', 'required'],
      ['Brand,Model', 'safe'],
      ['Hotel', 'in', 'range' => $this->getHotelData()],
      ['DateIn', 'default', 'setOnEmpty' => true, 'value' => '23.04.2014'],
      ['DateOut', 'default', 'setOnEmpty' => true, 'value' => '25.04.2014'],
      ['DateIn, DateOut', 'date', 'format' => 'dd.MM.yyyy'],
      ['Status', 'in', 'range' => array_keys(\pay\controllers\admin\booking\ParkingItem::getStatusTitleList())]
    ];
  }

  public function attributeLabels()
  {
    return [
      'Brand'   => \Yii::t('app', 'Марка'),
      'Model'   => \Yii::t('app', 'Модель'),
      'Number'  => \Yii::t('app', 'Номер'),
      'Hotel'   => \Yii::t('app', 'Отель'),
      'DateIn'  => \Yii::t('app', 'Дата въезда'),
      'DateOut' => \Yii::t('app', 'Дата отъезда'),
      'Status'  => \Yii::t('app', 'Статус')
    ];
  }


  /**
   * @return string[]
   */
  public function getHotelData()
  {
    return [
      \pay\components\admin\Rif::HOTEL_P  => \pay\components\admin\Rif::HOTEL_P,
      \pay\components\admin\Rif::HOTEL_LD => \pay\components\admin\Rif::HOTEL_LD,
      \pay\components\admin\Rif::HOTEL_N  => \pay\components\admin\Rif::HOTEL_N,
      \pay\components\admin\Rif::HOTEL_S  => \pay\components\admin\Rif::HOTEL_S
    ];
  }

  public function getStatusData()
  {
    $data = \pay\controllers\admin\booking\ParkingItem::getStatusTitleList();
    unset($data[\pay\controllers\admin\booking\ParkingItem::STATUS_PARTNER]);
    return $data;
  }
} 