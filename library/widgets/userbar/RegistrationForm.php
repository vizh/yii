<?php

class RegistrationForm extends UserForm
{
  public function __construct($id = 'RegForm')
  {
    parent::__construct($id);

    $lastName = new UserFormElement('lastname');
    $lastName->AddValidator('NotEmpty');
    $firstName = new UserFormElement('firstname');
    $firstName->AddValidator('NotEmpty');
    $email = new UserFormElement('email');
    $email->AddValidator('NotEmpty');
    $email->AddValidator('Email');
    $password = new UserFormElement('password');
    $password->AddValidator('NotEmpty');   
    $submit = new UserFormElement('submit');    
    $this->AddElements(array($lastName, $firstName, $email, $password, $submit));
  }

  public function GetLastName()
  {
    return $this->GetValue('lastname');
  }

  public function GetFirstName()
  {
    return $this->GetValue('firstname');
  }

  public function GetEmail()
  {
    return $this->GetValue('email');
  }
  
  public function GetPassword()
  {
    return $this->GetValue('password');
  }  

}