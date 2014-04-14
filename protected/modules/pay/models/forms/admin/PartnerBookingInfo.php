<?php
namespace pay\models\forms\admin;

class PartnerBookingInfo extends \CFormModel
{
  private $booking;

  public $Car = [];
  public $People = [];

  /**
   * @param \pay\models\RoomPartnerBooking $booking
   * @param string $scenario
   */
  public function __construct($booking, $scenario = '')
  {
    parent::__construct($scenario);
    $this->booking = $booking;
  }

  public function rules()
  {
    return [
      ['Car', 'filter', 'filter' => [$this,'filterCar']],
      ['People,Car','safe']
    ];
  }

  public function filterCar($value)
  {
    $count = 0;
    foreach($value as $val)
    {
      $val = trim($val);
      if (!empty($val))
      {
        $count++;
      }
    }

    if ($count != 0 && $count != 3)
    {
      $this->addError('Car', \Yii::t('app', 'Необходимо заполнить все данные по автомобилю'));
    }
    return $value;
  }

  public function attributeLabels()
  {
    return [
      'Car' => \Yii::t('app', 'Данные по автомобилю'),
      'CarBrand' => \Yii::t('app', 'Марка авто'),
      'CarModel' => \Yii::t('app', 'Модель авто'),
      'CarNumber' => \Yii::t('app', 'Гос. номер авто'),
      'People' => \Yii::t('app', 'Проживающие')
    ];
  }

  public function getPeopleCount()
  {
    $count = $this->booking->AdditionalCount;
    $manager = $this->booking->Product->getManager();
    $count += $manager->PlaceBasic;
    return $count;
  }
} 