<?php
 
class UserStatistics extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $date = getdate();
    $time = mktime(0, 0, 0, $date['mon'], $date['mday'], $date['year']);
    $users = User::GetByRegisterTime($time);
    $this->view->Count = sizeof($users);
    foreach ($users as $user)
    {
      $view = new View();
      $view->SetTemplate('user');
      $view->FullName = $user->LastName . ' ' . $user->FirstName . ' ' . $user->FatherName;
      $view->RocId = $user->RocId;
      $view->Photo = $user->GetMiniPhoto();
      $view->Email = $user->Email;
      $this->view->Today .= $view;
    }

    $yesterday = mktime(0, 0, 0, $date['mon'], $date['mday']-1, $date['year']);
    $users = User::GetByRegisterTime($yesterday, $time);
    $this->view->CountYesterday = sizeof($users);
    foreach ($users as $user)
    {
      $view = new View();
      $view->SetTemplate('user');
      $view->FullName = $user->LastName . ' ' . $user->FirstName . ' ' . $user->FatherName;
      $view->RocId = $user->RocId;
      $view->Photo = $user->GetMiniPhoto();
      $view->Email = $user->Email;
      $this->view->Yesterday .= $view;
    }

    echo $this->view;
  }
}
