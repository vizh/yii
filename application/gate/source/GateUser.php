<?php
AutoLoader::Import('gate.source.*');

class GateUser extends CActiveRecord
{
  public static $TableName = 'GateUser';
  
 /**
  * @param string $className
  * @return News
  */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return self::$TableName;
  }
  
  public function primaryKey()
  {
    return 'GateUserId';
  }
  
  public function relations()
  {
    return array(   
      'UserIp' => array(self::HAS_MANY, 'GateUserIp', 'GateUserId'),
      'UserEvent' => array(self::MANY_MANY, 'Event', 'Link_GateUser_Event(EventId, GateUserId)'),
    );
  }
  
  /**
  * Ищет и авторизует API-пользователя с заданным логином и вторым паролем.
  * 
  */
  public static function GetAPIUser()
  {
    $login = Cookie::Get('Login');    
    $password2 = Cookie::Get('Password');
    if (! empty($login) && ! empty($password2))
    {
      $gateUser = GateUser::model()->with('UserIp', 'UserEvent')->
        together()->find('t.Login = :Login', array(':Login' => $login));
      if (! empty($gateUser) && $gateUser->checkLogin2($password2))
      {
        return $gateUser;
      }
    }
    return null;
  }
  
  /**
  * Проввяет, соответствуют password данному пользователю
  * 
  * @param string $password
  * @return bool
  */
  private function checkLogin($password)
  {
    if ($this->GetPassword() === $password)
    {
      return true;
    }
    return false;
  }
  
  /**
  * Проввяет, соответствуют password2 данному пользователю
  * 
  * @param string $password2
  * @return bool
  */
  private function checkLogin2($password2)
  {
    if ($this->GetPassword2() === $password2)
    {
      return true;
    }
    return false;
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GateUserId()
  {
    return $this->GateUserId;
  }
  
  //Login
  public function GetLogin()
  {
    return $this->Login;
  }
  
  public function SetLogin($value)
  {
    $this->Login = $value;
  }
  
  //Password
  public function GetPassword()
  {
    return $this->Password;
  }
  
  public function SetPassword($value)
  {
    $this->Password = $value;
  }
  
  //Password2
  public function GetPassword2()
  {
    return $this->Password2;
  }
  
  public function SetPassword2($value)
  {
    $this->Password2 = $value;
  }
  
  //Description
  public function GetDescription()
  {
    return $this->Description;
  }
  
  public function SetDescription($value)
  {
    $this->Description = $value;
  }
  
  //Permitions
  /**
  * 
  * @return GatePermitions
  */
  public function GetPermitions()
  {
    if (isset($this->Permitions))
    {
      return unserialize($this->Permitions);
    }
    return null;
  }
  /**
  * 
  * @param GatePermitions $value
  */
  public function SetPermitions($value)
  {
    $this->Private = serialize($value);
  }  
}