<?php

class EventProgramUsers extends AdminCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/admin/program.user.edit.js'));
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
    $eventProgram = EventProgram::GetEventProgramById($id);
    if (empty($eventProgram ) || empty($eventProgram->Event))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('event', '', 'list'));
    }
    $userLinks = $eventProgram->UserLinks;
    foreach ($userLinks as $userLink)
    {
      $view = new View();
      $view->SetTemplate('user');

      $view->LinkId = $userLink->LinkId;
      $view->RocId = $userLink->User->RocId;
      $view->FullName = $userLink->User->LastName . ' ' . $userLink->User->FirstName . ' ' . $userLink->User->FatherName;
      $view->Photo = $userLink->User->GetMiniPhoto();
      $view->Role = $userLink->Role->Name;
      $view->Order = $userLink->Order;
      if (!empty($userLink->Report))
      {
        $view->LinkPresentation = $userLink->Report->LinkPresentation;
      }


      $this->view->Users .= $view;
    }

    $this->view->EventProgramId = $eventProgram->EventProgramId;
    $this->view->EventId = $eventProgram->EventId;

    $this->view->Roles = EventProgramRoles::GetAll();


    echo $this->view;
  }
}
