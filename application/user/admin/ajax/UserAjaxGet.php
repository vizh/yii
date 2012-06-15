<?php
AutoLoader::Import('library.rocid.user.*');

class UserAjaxGet extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $name = Registry::GetRequestVar('term');
    $users = User::GetBySearch($name, 10);
    $result = array();
    foreach ($users as $user)
    {
      $result[] = array('id' => $user->RocId, 'label' => $user->LastName . ' ' . $user->FirstName . ' ' . $user->FatherName);
    }
    echo json_encode($result);
  }
}
