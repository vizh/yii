<?php
AutoLoader::Import('library.rocid.user.User');

abstract class AuthCommand extends AbstractCommand
{
  /**
  * 
  * @var User
  */
  protected $LoginUser = null;
  
  protected function preExecute()
  {
    parent::preExecute();
    if (!Yii::app()->user->isGuest)
    {
      $this->LoginUser = User::GetById(Yii::app()->user->getId());
      if (empty($this->LoginUser) || !$this->LoginUser->CheckSecretKey() || $this->LoginUser->Settings->Visible == 0)
      {
        Yii::app()->user->logout();
        Cookie::Clear();
        $this->LoginUser = null;
        Lib::Redirect('/');
      }
    }

    Registry::SetVariable('LoginUser', $this->LoginUser);
  }

  protected function checkAdminAccess()
  {
    if (empty($this->LoginUser))
    {
      return false;
    }
    foreach ($this->LoginUser->Groups as $group)
    {
      if ($group->GroupId == CoreGroup::AdminAccessGroupId)
      {
        return true;
      }
    }
    return false;
  }
}