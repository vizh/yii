<?php
namespace pay\models\forms\admin;

class UserBooking extends \CFormModel
{

  public $RunetId;
  public $DateIn;
  public $DateOut;
  public $Booked;

  private $user;

  /**
   * @return \user\models\User
   */
  public function getUser()
  {
    return $this->user;
  }

  public function rules()
  {
    return [
      ['RunetId, DateIn, DateOut, Booked', 'required'],
      ['DateIn, DateOut, Booked', 'date', 'allowEmpty' => false, 'format' => 'yyyy-MM-dd'],
      ['RunetId', 'existUser'],
    ];
  }

  public function existUser($attribute, $params)
  {
    if (!empty($this->RunetId))
    {
      $this->user = \user\models\User::model()->byRunetId($this->RunetId)->byVisible(true)->find();
      if ($this->user == null)
      {
        $this->addError('RunetId', \Yii::t('app', 'Пользователь с таким RunetId не найден в системе.'));
      }
    }
  }

  public function attributeLabels()
  {
    return [
      'Owner' => 'Название',
      'DateIn' => 'Дата заезда',
      'DateOut' => 'Дата выезда',
      'Booked' => 'Бронь до'
    ];
  }

}