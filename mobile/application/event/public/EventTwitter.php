<?php
  
class EventTwitter extends MobileCommand
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
  
  protected function doExecute($idName = '')
  {
    $this->event = Event::GetEventByIdName($idName, Event::LoadOnlyEvent);
    
    if (empty($this->event))
    {
      throw new Exception('Мероприятие с текстовым идентификатором ' . $idName . ' не обнаружено.');
    }    
    
    $this->view->IdName = $this->event->IdName;
    
    echo $this->view;
  }  
}