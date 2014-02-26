<?php
namespace partner\models\forms\user;

class Register extends \CFormModel
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
  public $Role;
  public $Hidden;

  private $event;

  public function __construct(\event\models\Event $event, $scenario = '')
  {
    parent::__construct($scenario);
    $this->event = $event;
  }


  public function rules()
  {
    return [
      ['FirstName, LastName, Password', 'required'],
      ['FatherName, Company, Position, Phone, City, Role, Hidden', 'safe'],
      ['Email', 'email', 'allowEmpty' => true],
      ['Position', 'employmentValidator']
    ];
  }

  protected function beforeValidate()
  {
    $this->Password = substr(md5(microtime()), 0, 7);
    if (!empty($this->Email) && empty($this->Hidden) &&
        \user\models\User::model()->byEmail($this->Email)->byVisible()->exists())
    {
      $this->addError('Email', 'Пользователь с таким Email уже существует в RUNET-ID');
    }
    return parent::beforeValidate();
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
    return [
      'FirstName' => 'Имя',
      'LastName' => 'Фамилия',
      'FatherName' => 'Отчество',
      'Password' => 'Пароль',
      'Email' => 'E-mail',
      'EmailRandom' => 'Сгенерировать случайный e-mail',
      'Company' => 'Компания',
      'Position' => 'Должность',
      'Phone' => 'Телефон',
      'City' => 'Город',
      'Role' => 'Роль',
      'Hidden' => 'Добавить, как скрытого пользователя',
    ];
  }

  /**
   * @return array
   */
  public function getRoles()
  {
    return \CHtml::listData($this->event->getRoles(), 'Id', 'Title');
  }
}
