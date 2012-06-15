<?php
AutoLoader::Import('library.rocid.event.*');

class MainIndex extends MobileCommand
{  
  protected function preExecute()
  {
    parent::preExecute();    
    //Установка хеадера        
    
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['mobile']);
  }
  
  protected function doExecute()
  {
    if ($this->LoginUser === null)
    {
      $this->fillNonAuthTemplate();
    }
    else
    {
      $this->fillAuthTemplate();
    }
    echo $this->view;
  }
  
  protected function fillNonAuthTemplate()
  {
    $this->view->SetTemplate('nonauth');
    
    $formid = Registry::GetRequestVar('formid');
    if ($formid != null)
    {
      $rocidOrEmail = Registry::GetRequestVar('rocid');
      $password = Registry::GetRequestVar('password');
      $isRemember = Registry::GetRequestVar('save');

      $identity = null;
      $validator = new CEmailValidator();
      if ($validator->validateValue($rocidOrEmail))
      {
        $identity = new EmailIdentity($rocidOrEmail, $password);
      }
      else
      {
        $identity = new RocidIdentity($rocidOrEmail, $password);
      }
      $identity->authenticate();

      $user = null;

      //$user = User::Login($rocidOrEmail, $password, $isRemember != null ? 14 : 0);
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        if (!$isRemember)
        {
          Yii::app()->user->login($identity);
        }
        else
        {
          Yii::app()->user->login($identity, $identity->GetExpire());
        }
        Lib::Redirect('/');
      }
      else
      {
        $this->view->ErrorAuth = true;
      }
    }
  }
  
  protected function fillAuthTemplate()
  {
    $this->view->SetTemplate('auth');
    
    $eventList = $this->getEventList();
    
    $days = new ViewContainer();    
    foreach ($eventList as $date => $dateEvents)
    {
      $view = new View();
      $view->SetTemplate('day');
      
      $view->Date = $this->getDateHeaderHtml($date);
      
      $events = new ViewContainer();
      foreach ($dateEvents as $event)
      {
        $viewEvent = new View();
        $viewEvent->SetTemplate('event');

        $viewEvent->IdName = $event->IdName;
        $viewEvent->Name = $event->GetName();
        $viewEvent->Place = $event->Place;
        $viewEvent->Date = $date;
        $events->AddView($viewEvent);
      }
      $view->Events = $events;
      
      $days->AddView($view);
    }
    
    $this->view->Days = $days;
  }
  
  private function getEventList()
  {
    $DateStart = date('Y-m-d', time());
    $DateEnd = date('Y-m-d', time() + 60*60*24*30);
    $events = Event::GetEventsByDates($DateStart, $DateEnd);
    
    $list = array();
    foreach ($events as $event)
    {
      $start = Lib::ConvertDateToArray($event->DateStart);
      $end = Lib::ConvertDateToArray($event->DateEnd);
      
      //НАЧАЛО ГОВНОКОДИНГА, УДАЛЕНИЕ ЛИШЕИХ МЕРОПРИЯТИЙ      
//      if ($event->IdName != 'rif-spb11')
//      {
//        continue;
//      }
      //КОНЕЦ ГОВНОКОДИНГА
      
      if ($event->DateStart == $event->DateEnd)
      {
        if ($start && $start['day'] != 0)
        {
          $list[$event->DateStart][] = $event;
        }
      }
      else
      {
        $current = strtotime($event->DateStart);
        $end = strtotime($event->DateEnd);
        if (($end - $current) / (24 * 60 * 60) > 5)
        {
          continue;
        }
        while($current <= $end)
        {
          $date = date('Y-m-d', $current);
          $list[$date][] = $event;
          $current += 24*60*60;
        }
      }
    }
    
    return $list;
  }
  
  private function getDateHeaderHtml($date)
  {    
    $view = new View();
    $view->SetTemplate('date');
    
    //if ($date != date('Y-m-d', time()))
    //{
      $date = strtotime($date);
      $date = getdate($date);    
      $view->Date = $date;
//    }
//    else
//    {
//      $view->Date = false;
//    }
    
    return $view;
  }
}