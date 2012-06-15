<?php

class MainLogout extends GeneralCommand
{
  protected function preExecute()
  {
    parent::preExecute();    
  }
  
  protected function doExecute()
  {
    if ($this->LoginUser != null)
    {
      Yii::app()->user->logout(false);
    }
    
    Lib::Redirect('/');
  }
}
