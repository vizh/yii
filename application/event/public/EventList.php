<?php
AutoLoader::Import('library.rocid.event.*');

class EventList extends GeneralCommand
{
  protected function preExecute()
  {
    parent::preExecute();  
  }
  
  protected function doExecute($year = '', $month = '')
  {
        

    $events = Event::GetLastEvents(15);
    $container = new ViewContainer();
    foreach ($events as $event)
    {
      $view = new View();
      $view->SetTemplate('event');
      $view->IdName = $event->IdName;
      $view->Name = $event->Name;
      
      $container->AddView($view);
    }
    $this->view->Events = $container;
    
    echo $this->view;
  }
}