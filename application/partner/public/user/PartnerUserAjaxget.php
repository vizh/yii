<?php
AutoLoader::Import('library.rocid.user.*');

class PartnerUserAjaxget extends PartnerCommand
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
      $result[] = array('id' => $user->RocId, 'label' => $user->GetFullName());
    }
    echo json_encode($result);
  }

  protected function postExecute()
  {

  }
}
