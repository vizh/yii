<?php
AutoLoader::Import('library.rocid.event.*');

class EventRoleList extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $roles = EventRoles::GetAll();

    $result = array();
    foreach ($roles as $role)
    {
      $result[] = $this->Account->DataBuilder()->CreateRole($role);
    }

    $this->SendJson($result);
  }
}