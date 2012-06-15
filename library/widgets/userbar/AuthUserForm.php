<?php

class AuthUserForm extends UserForm
{
  public function __construct($id = 'AuthForm')
  {
    parent::__construct($id);
    
    $rocid = new UserFormElement('rocid_or_mail');
    $rocid->AddValidator('NotEmpty');
    $password = new UserFormElement('password');
    $password->AddValidator('NotEmpty');
    $notRemember = new UserFormElement('notRemember');    
    $submit = new UserFormElement('submit');    
    $this->AddElements(array($rocid, $password, $notRemember, $submit));    
  }
  
  public function GetRocidOrEmail()
  {
    return $this->GetValue('rocid_or_mail');
  }
  
  public function GetPassword()
  {
    return $this->GetValue('password');
  }
  
  public function NotRemember()
  {
    return $this->GetValue('notRemember') != null;
  }
}