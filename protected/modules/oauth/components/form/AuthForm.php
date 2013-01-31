<?php
namespace oauth\components\form;

class AuthForm extends \CFormModel
{
  public $RocIdOrEmail;
  public $Password;
  
  public function rules()
  {
    return array(
      array('RocIdOrEmail', 'rocIdOrEmailValidate'),
      array('Password', 'required')
    );
  }
  
  public function rocIdOrEmailValidate($attribute, $params)
  {
    if (intval($this->$attribute) > 0)
    {
      return true;
    }
    else if (filter_var($this->$attribute, FILTER_VALIDATE_EMAIL))
    {
      return true;
    }
    $this->addError($attribute, 'Неверно заполнено поле rocId / Email');
    return false;
  }
  
  public function attributeLabels()
  {
    return array(
      'RocIdOrEmail' => 'E-mail / rocID',
      'Password' => 'Пароль'
    );
  }
}

?>
