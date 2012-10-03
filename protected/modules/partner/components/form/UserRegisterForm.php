<?php
namespace partner\components\form;

class UserRegisterForm extends \CFormModel
{
  public $FirstName;
  public $LastName;
  public $FatherName;
  public $Password;
  public $Email;
  public $Company;
  public $Position;
  public $Phone;
  public $City;


  public function rules() 
  {
    return array(
      array('FirstName, LastName, Email, Password', 'required'),
      array('FatherName, Company, Position, Phone, City, CityId', 'safe'),
      array('Email', 'email'),
      array('Email', 'unique', 'className' => '\user\models\User'),
      array('City', 'exist', 'allowEmpty' => true, 'attributeName' => 'Name', 'className' => '\geo\models\City'),
      array('Position', 'employmentValidator')
    );
  }
  
  public function employmentValidator($attribute, $params)
  {
    if (!empty($this->Position))
    {
      if (empty($this->Company))
      {
        $this->addError('Position', 'Поле "'. $this->getAttributeLabel('Position') .'" не может быть заполнено без поля "'. $this->getAttributeLabel('Company') .'"');
        return false;
      }
    }
    return true;
  }
  
  public function attributeLabels()
  {
    return array(
      'FirstName'  => 'Имя',
      'LastName'   => 'Фамилия',
      'FatherName' => 'Отчество',
      'Password'   => 'Пароль',
      'Email'      => 'E-mail',
      'Company'    => 'Компания',
      'Position'   => 'Должность',
      'Phone'      => 'Телефон',
      'City'       => 'Город'
    );
  }


  protected function beforeValidate()
  {
    $this->Password = substr(md5(microtime()), 0, 7);
    return parent::beforeValidate();
  }
}

?>
