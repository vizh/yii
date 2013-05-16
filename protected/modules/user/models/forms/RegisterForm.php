<?php
namespace user\models\forms;

class RegisterForm extends \CFormModel
{
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

  
  public function rules()
  {
    return array(
      array('LastName, FirstName, FatherName, Email, Phone, Company, Position', 'filter', 'filter' => array(new \application\components\utility\Texts(), 'filterPurify')),
      array('LastName,FirstName,Email,Company', 'required'),
      array('Email', 'email'),
      array('Email', 'uniqueUser'),
      array('FatherName, Phone, Position, CompanyId, City, CityId', 'safe')
    );
  }

  public function uniqueUser($attribute, $params)
  {
    $model = \user\models\User::model()->byEmail($this->Email)->byVisible(true);
    if ($model->exists())
    {
      $this->addError('Email', \Yii::t('app', 'Пользователь с таким email уже существует'));
    }
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
    $user->register();

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
    //todo: Добавить данные по городам
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
