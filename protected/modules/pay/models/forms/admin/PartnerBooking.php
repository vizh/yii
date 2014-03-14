<?php
namespace pay\models\forms\admin;

class PartnerBooking extends \CFormModel
{
  public $Id;
  public $Owner;
  public $DateIn;
  public $DateOut;
  public $Paid;

  public function __construct(\pay\models\RoomPartnerBooking $booking = null, $scenario='')
  {
    if ($booking != null)
    {
      $this->Owner = $booking->Owner;
      $this->DateIn = $booking->DateIn;
      $this->DateOut = $booking->DateOut;
      $this->Paid = $booking->Paid;
    }
  }

  public function rules()
  {
    return [
      ['Owner, DateIn, DateOut', 'required'],
      ['DateIn, DateOut', 'date', 'allowEmpty' => false, 'format' => 'yyyy-MM-dd'],
      ['Paid', 'safe']
    ];
  }



  public function attributeLabels()
  {
    return [
      'Owner' => 'Название',
      'DateIn' => 'Дата заезда',
      'DateOut' => 'Дата выезда',
    ];
  }

} 