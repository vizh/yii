<?php
AutoLoader::Import('comission.source.*');
 
class ComissionUsers extends AdminCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/admin/comission.edit.js'));
    $this->view->HeadScript(array('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
    $this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css'));
  }

  /**
   * Основные действия комманды
   * @param int $id
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    $comission = Comission::GetById($id);
    if (empty($comission))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'index'));
    }

    $comissionUsers = ComissionUser::GetByComissionId($comission->ComissionId);
    foreach ($comissionUsers as $cUser)
    {
      $view = new View();
      $view->SetTemplate('user');
      $view->CUser = $cUser;
      $this->view->Users .= $view->__toString();
    }

    $this->view->Roles = ComissionRole::GetAll();
    $this->view->Comission = $comission;

    echo $this->view;
  }
}
