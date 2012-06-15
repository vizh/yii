<?php
AutoLoader::Import('library.rocid.user.*');

 
class UserEditDisconnect extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($service = '')
  {
    if ($this->LoginUser == null)
    {
      Lib::Redirect('/');
    }

    if ($service == 'twitter')
    {
      $connect = UserConnect::GetByUser($this->LoginUser->UserId, UserConnect::TwitterId);
      if (! empty($connect))
      {
        $connect->delete();
      }
    }
    elseif ($service == 'facebook')
    {
      $connect = UserConnect::GetByUser($this->LoginUser->UserId, UserConnect::FacebookId);
      if (! empty($connect))
      {
        $connect->delete();
      }
    }

    Lib::Redirect('/user/edit/#contact');
  }
}
