<?php
AutoLoader::Import('library.rocid.company.*');

class EventShow extends MobileCommand
{  
  private $event = null;
  
  protected function preExecute()
  {
    parent::preExecute();    
    //Установка хеадера       
    $this->RedirectNonAuth(); 
    
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['mobile']);
  }
  
  protected function doExecute($idName = '', $date = '')
  {
    $this->event = Event::GetEventByIdName($idName, Event::LoadOnlyEvent);
    
    if (empty($this->event))
    {
      throw new Exception('Мероприятие с текстовым идентификатором ' . $idName . ' не обнаружено.');
    }
    
    $this->view->IdName = $this->event->IdName;
    $this->view->Name = $this->event->GetName();
    $this->view->MiniLogo = $this->event->GetMiniLogo();
    $this->view->Info = $this->event->GetInfo();
    $this->view->Date = $date;
    
    $this->view->IdName = $idName;   
    
    echo $this->view;
  }  
}
