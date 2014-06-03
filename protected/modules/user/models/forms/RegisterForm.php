<?php
namespace user\models\forms;

class RegisterForm extends \CFormModel
{
  public $EventId;
  public $LastName;
  public $FirstName;
  public $FatherName = '';
  public $Email;
  public $Phone = '';
  public $CompanyId;
  public $Company;
  public $Position = '';
  public $City;
  public $CityId;
  public $Visible = true;

  
  public function rules()
  {
    return [
      ['LastName, FirstName, FatherName, Email, Phone, Company, Position,', 'filter', 'filter' => [new \application\components\utility\Texts(), 'filterPurify']],
      ['LastName,FirstName,Email,Company', 'required'],
      ['Email', 'email'],
      ['Email', 'uniqueUser'],
      ['Position', 'checkPosition'],
      ['Phone', 'checkPhone'],
      ['FatherName, Phone, Position, CompanyId, City, CityId, EventId', 'safe']
    ];
  }

  public function uniqueUser($attribute, $params)
  {
    if (!empty($this->Email))
    {
      $model = \user\models\User::model()->byEmail($this->Email)->byVisible(true);
      if ($this->Visible && $model->exists())
      {
        $this->addError('Email', \Yii::t('app', 'Пользователь с таким Email уже существует.'));
      }
    }
  }

  public function checkPosition($attribute, $params)
  {
    $event = $this->getEvent();
    if ($event !== null && isset($event->PositionRequired) && $event->PositionRequired && empty($this->Position))
    {
      $this->addError('Position', \Yii::t('app', 'Необходимо заполнить поле Должность.'));
    }
  }

  public function checkPhone($attribute, $params)
  {
    $event = $this->getEvent();
    if ($event !== null && isset($event->PhoneRequired) && $event->PhoneRequired && empty($this->Phone))
    {
      $this->addError('Phone', \Yii::t('app', 'Необходимо заполнить поле Телефон.'));
    }
  }

  private $event = null;

  /**
   * @return \event\models\Event|null
   */
  private function getEvent()
  {
    if ($this->event == null)
    {
      $this->event = \event\models\Event::model()->findByPk($this->EventId);
    }
    return $this->event;
  }

  /**
   * @return \user\models\User
   */
  public function register()
  {
    $user = new \user\models\User();
    $user->LastName = $this->LastName;
    $user->FirstName = $this->FirstName;
    $user->FatherName = $this->FatherName;
    $user->Email = strtolower($this->Email);
    $user->Visible = $this->Visible;
    $user->register($this->Visible);

    if (!$this->Visible)
    {
      $user->Settings->UnsubscribeAll = true;
      $user->Settings->save();
    }

    $this->setEmployment($user);
    $this->setCity($user);
    $this->setPhone($user);

    return $user;
  }

  /**
   * @param \user\models\User $user
   */
  private function setEmployment($user)
  {
    if (!empty($this->Company))
    {
      $user->setEmployment($this->Company, $this->Position);
    }
  }

  /**
   * @param \user\models\User $user
   */
  private function setCity($user)
  {
    //todo: Добавить данные по городам и реализовать метод
//    $cityId = Registry::GetRequestVar('City', 0);
//    $city = GeoCity::GetById($cityId);
//    if ($city !== null)
//    {
//      $address = new ContactAddress();
//      $address->CityId = $city->CityId;
//      $address->Primary = 1;
//      $address->save();
//      $user->AddAddress($address);
//    }
  }

  /**
   * @param \user\models\User $user
   */
  private function setPhone($user)
  {
    if (!empty($this->Phone))
    {
      $user->setContactPhone($this->Phone);
    }
  }
  
  public function attributeLabels()
  {
    return array(
      'LastName' => \Yii::t('app', 'Фамилия'),
      'FirstName' => \Yii::t('app', 'Имя'),
      'FatherName' => \Yii::t('app', 'Отчество'),
      'Phone' => \Yii::t('app', 'Телефон'),
      'Company' => \Yii::t('app', 'Компания'),
      'Position' => \Yii::t('app', 'Должность')
    );
  }
}
