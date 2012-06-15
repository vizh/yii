<?php

class TestForm extends GeneralCommand
{
  protected function doExecute()
  {
    //print_r($_POST);
    //print_r(Registry::GetInstance());
    $form = new UserForm('LoginForm');    
    $rocid = new UserFormElement('rocid');    
    $password = new UserFormElement('password');    
    $rememberMe = new UserFormElement('rememberMe');    
    $submit = new UserFormElement('submit');    
    $form->AddElements(array($rocid, $password, $rememberMe, $submit));
    
    if ($form->IsRequest())
    {
      echo 'Обработка данных формы';
    }
           
    $this->view->Form = $form;    

    echo $this->view;
  }
}