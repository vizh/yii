<?php
AutoLoader::Import('library.rocid.event.*');

class EventMain extends GeneralCommand
{
  const MinEventCount = 6;

  public static $ActualEvent = 'site12';

  protected function preExecute()
  {    
    parent::preExecute();  
    
    $this->view->HeadScript(array('src'=>'/js/events.js?1.1.1'));

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['event']);
  }
  
  protected function doExecute($year = '', $month = '')
  {
    if (! empty($year) && ! empty($month))
    {
      echo $this->getListEventsHtml($year, $month);
      return;
    }

    $this->view->TodayEvent = $this->getTodayEventHtml();
    $this->view->DatePicker = $this->getDatePickerHtml();

    $this->view->Events = $this->getListEventsHtml($year, $month);
    
    echo $this->view;
  }

  private function getTodayEventHtml()
  {

    $viewContainer = new View();
    $viewContainer->SetTemplate('todayevent-container');

    $events = Event::GetEventsByDates(date('Y-m-d'), date('Y-m-d'));
    if (! empty($events))
    {
      if (sizeof($events) == 1 && $events[0]->EventId == 256)
      {
        return '';
      }
      foreach ($events as $event)
      {
        if ($event->EventId == 256) { continue;}

        $view = new View();
        $view->SetTemplate('todayevent');

        $view->IdName = $event->IdName;
        $view->DateStart = getdate(strtotime($event->DateStart));
        $view->DateEnd = getdate(strtotime($event->DateEnd));
        $view->Name = $event->GetName();
        $view->Place = $event->Place;
        $view->Info = $event->GetInfo();
        $view->Logo = $event->GetLogo();

        $viewContainer->Events .= $view;
      }

      return $viewContainer;
    }
    else
    {
      return '';
    }    
  }
  
  private function getDatePickerHtml()
  {
    $view = new View();
    $view->SetTemplate('datepicker');
    
    $view->StartYear = 2007;
    $view->EndYear = 2012;
    
    $date = getdate();
    $view->Year = $date['year'];
    $view->Month = $date['mon'];
    
    return $view;
  }

  private function getListEventsHtml($year = '', $month = '')
  {
    $view = new View();
    $view->SetTemplate('list');

    $year = intval($year);
    $month = intval($month);

    $date = getdate();
    if (empty($year))
    {
      $year = $date['year'];
    }
    if (empty($month))
    {
      $month = $date['mon'];
    }

    if ($year == $date['year'] && $month == $date['mon'])
    {
      $view->ShowEventsButton = true;
    }

    $start = date('Y-m-', mktime(0, 0, 0, $month, 1, $year)).'00';
    $end = date('Y-m-d', mktime(0, 0, 0, $month+1, 0, $year));
    
    $events = Event::GetEventsByDates($start, $end);
    $prevEventsContainer = new ViewContainer();
    $nextEventsContainer = new ViewContainer();

    $actualEvent = $this->getActualEvent();



    foreach ($events as $event)
    {
      if ($actualEvent != null && $actualEvent->EventId == $event->EventId)
      {
        continue;
      }
      $viewEvent = $this->getEventView($event);

      if (date('Y-m-d') > $event->DateEnd)
      {
        $prevEventsContainer->AddView($viewEvent);
      }
      elseif (date('Y-m-d') < $event->DateStart)
      {
        $nextEventsContainer->AddView($viewEvent);
      }
    }

//    if ($nextEventsContainer->IsEmpty())
//    {
//      $events = Event::GetFutureEvents(3);
//      foreach ($events as $event)
//      {
//        $viewEvent = $this->getEventView($event);
//        $nextEventsContainer->AddView($viewEvent);
//      }
//    }
    $view->ActualEvent = $actualEvent != null ? $this->getEventView($actualEvent) : '';
    $view->ActualEventIsEmpty = $actualEvent == null;

    $view->PrevEvents = $prevEventsContainer;
    $view->PrevEventsIsEmpty = $prevEventsContainer->IsEmpty();

    $view->NextEvents = $nextEventsContainer;
    $view->NextEventsIsEmpty = $nextEventsContainer->IsEmpty();

    $words = Registry::GetWord('calendar');
    $view->Month = $words['months']['3'][$month];

    $view->Date = array($year, $month);
    
    return $view;
  }

  /**
   * @return Event
   */
  private function getActualEvent()
  {
    $event = null;
    if (! empty(self::$ActualEvent))
    {
      $event = Event::GetEventByIdName(self::$ActualEvent);
    }
    if ($event == null || $event->DateStart <= date('Y-m-d'))
    {
      $event = Event::GetFutureEvents(1);
      if (! empty($event))
      {
        $event = $event[0];
      }
      else
      {
        $event = null;
      }
    }
    return $event;
  }

  /**
   * @param Event $event
   * @return View
   */
  private function getEventView($event)
  {
    $viewEvent = new View();
    $viewEvent->SetTemplate('event');

    $viewEvent->IdName = $event->IdName;
    $viewEvent->DateStart = getdate(strtotime($event->DateStart));
    $viewEvent->DateEnd = getdate(strtotime($event->DateEnd));
    if ($event->DateStart == $event->DateEnd)
    {
      $viewEvent->EmptyDay = intval(substr($event->DateStart, 8, 2)) == '00';
    }
    $viewEvent->Name = $event->GetName();
    $viewEvent->Place = $event->Place;
    $viewEvent->Info = $event->GetInfo();
    $viewEvent->Logo = $event->GetLogo();

    return $viewEvent;
  }
}