<?php

class UserEditDelete extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if (empty($this->LoginUser))
    {
      Lib::Redirect('/');
    }

    $password = Registry::GetRequestVar('pass_delete', '');
    if ($this->LoginUser->Password === User::GetPasswordHash($password))
    {
      $this->LoginUser->Settings->Visible = 0;
      $this->LoginUser->Settings->save();
    }
    else
    {
      $this->view->SetTemplate('wrong-password');
    }

    echo $this->view;
  }
}
