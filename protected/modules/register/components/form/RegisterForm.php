<?php
namespace register\components\form;
class RegisterForm extends \CFormModel
{
  public $FirstName;
  public $LastName;
  public $SecondName;
  public $Company;
  public $Position;
  public $Email;
  public $Phone;
  public $Password;
  
  
  public function rules()
  {
    return array(
      array('FirstName, LastName, Email, Password', 'required'),
      array('Email', 'email'),
      array('Email', 'unique', 'className' => '\user\models\User', 'attributeName' => 'Email'),
      array('FirstName, LastName, SecondName, Company, Position, Email, Phone', 'filter', 'filter' => array($this, 'filterPurify'))
    );
  }
  
  public function filterPurify($value) 
  {
    $purifier = new \CHtmlPurifier();
    $purifier->options = array(
      'HTML.AllowedElements' => array()
    );
    $value = $purifier->purify($value);
    return $value;
  }
}

?>
