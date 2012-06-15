<?php
AutoLoader::Import('library.rocid.event.*');

class EventShareIcal extends AbstractCommand
{

  protected function preExecute()
  {
    parent::preExecute();
    header('Content-Type: text/html; charset=utf-8');
  }
  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($idName = '')
  {
    $this->view->UseLayout(false);

    $event = Event::GetEventByIdName($idName);
    if (empty($event))
    {
      exit;
    }
    $this->view->Name = $event->GetName();
    $this->view->DateStart = date('Ymd', strtotime($event->DateStart));
    $this->view->DateEnd = date('Ymd', strtotime($event->DateEnd));
    $this->view->SiteHost = $_SERVER['HTTP_HOST'];
    $this->view->Info = $event->GetInfo();
    $this->view->IdName = $event->IdName;


    echo $this->view;
  }
}
