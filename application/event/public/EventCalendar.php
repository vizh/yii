<?php
AutoLoader::Import('library.rocid.event.*');

class EventCalendar extends AjaxNonAuthCommand
{
  
  private $events = null;

  private $year = 0;
  private $month = 0;
  private $start = 0;
  private $end = 0;
  
  protected function preExecute()
  {        
    parent::preExecute();
  }
  
  protected function doExecute($year = '', $month = '')
  {
//    if (! Lib::IsSelfReferer())
//    {
//      exit();
//    }
    $this->year = intval($year);
    $this->month = intval($month);
    
    $date = getdate();
    if (empty($this->year))
    {
      $this->year = $date['year'];
    }
    if (empty($this->month))
    {
      $this->month = $date['mon'];
    }
    $this->start = mktime(0, 0, 0, $this->month, 1, $this->year);
    $this->end = mktime(0, 0, 0, $this->month+1, 0, $this->year);
    $start = date( 'Y-m-d', mktime(0, 0, 0, $this->month, -6, $this->year));
    $end = date( 'Y-m-d', mktime(0, 0, 0, $this->month+1, 6, $this->year));
    $events = Event::GetEventsByDates($start, $end);
    $this->events = $this->GetEventsArray($events, $start, $end);
    
    $this->view->Weeks = $this->GetCalendarHtml($this->month, $this->year);
    
    echo $this->view;
  }

  /**
   * @param Event[] $events
   * @param string $dateStart
   * @param string $dateEnd
   * @return array
   */
  private function GetEventsArray($events, $dateStart, $dateEnd)
  {
    $result = array();
    foreach ($events as $event)
    {
      $start = Lib::ConvertDateToArray($event->DateStart);
      $end = Lib::ConvertDateToArray($event->DateEnd);
      //print_r($start);
      //print_r($end);      
      
      if ($event->DateStart == $event->DateEnd)
      {
        if ($start && $start['day'] != 0)
        {
//          if (! isset($result[$start['month']]))
//          {
//            $result[$start['month']] = array();
//          }
          $result[$start['month']][$start['day']][] = $event;
        }
      }
      else
      {
        if ((strtotime($event->DateEnd) - strtotime($event->DateStart)) / (24 * 60 * 60) > 5)
        {
          continue;
        }
        $end = min(strtotime($event->DateEnd), strtotime($dateEnd));
        $current = max(strtotime($event->DateStart), strtotime($dateStart));
        while ($current <= $end)
        {
          $date = getdate($current);
          $result[$date['mon']][$date['mday']][] = $event;
          $current = mktime(0, 0, 0, $date['mon'], $date['mday']+1, $date['year']);
        }
      }
      //echo $event->DateStart . ' - ' . $event->DateEnd . ' - ' . $event->IdName . ' <br />';
    }
    
    return $result;
    //print_r($result);    
  }
  
  private function GetCalendarHtml($month, $year)
  {
    $timestamp = mktime(0, 0, 0, $month, 1, $year);
    $dateList = getdate($timestamp);      
    $firstWeekDay = Lib::GetWeekDay($timestamp);
    $startDay = $dateList['yday'] - $firstWeekDay;
    $monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//    echo '$monthDays: ' . $monthDays;
//    echo '<br /> $firstWeekDay: '. $firstWeekDay;
    
    if ($monthDays == 28 && $firstWeekDay == 0)
    {
      $weeks = 4;
    }
    else if (35 - $monthDays >= $firstWeekDay)
    {
      $weeks = 5;
    }
    else
    {
      $weeks = 6;
    }
    $endDay = $startDay + $weeks * 7;
    
    
    $result = new ViewContainer();
    $week = null;
    $days = null;
    $isFirstWeek = true;
    for ($i = $startDay, $j=0; $i < $endDay; $i++, $j++)
    {
      if ($j == 0)
      {
        $week = new View();
        $week->SetTemplate('week');
        $days = new ViewContainer();
      }
      $days->AddView($this->GetDayHtml($i, $year, $j==0));
      
      if ($j == 6)
      {
        $week->Class = $isFirstWeek ? 'cb' : '';
        $isFirstWeek = false;
        $j = -1;
        $week->Days = $days;
        $result->AddView($week);
      }
    }
    
    return $result;
  }
  
  private function GetDayHtml($day, $year, $isFirst)
  {
    $view = new View();
    $view->SetTemplate('day');
    
    $day = $day+1;
    if ($day <= 0)
    {
      $year = $year - 1;
      $day = cal_days_in_month(CAL_GREGORIAN, 2, $year) == 28 ? 365 + $day : 366 + $day;
    }

    $date = mktime(0, 0, 0, 1, $day, $year);
    $view->ClassTitle = $this->start <= $date && $date <= $this->end ? 'd' : 'dp';

    $date = getdate($date);
    
    //print_r($date);
    $day = $date['mday'];
    $month = $date['mon'];
    
    $view->Day = $day;
    $view->Month = $month;
        
    if (! empty($this->events[$month][$day]))
    {
      $container = new ViewContainer();
      $containerHide = new ViewContainer();
      $i = 0;
      foreach ($this->events[$month][$day] as $event)
      {
        $viewEvent = new View();
        $viewEvent->SetTemplate('event');
        $viewEvent->Logo = $event->GetMiniLogo();
        $viewEvent->Name = $event->Name;
        $viewEvent->IdName = $event->IdName;
        
        if ($i == 0)
        {
          $view->Event = (string)$viewEvent;
        }
        $viewEvent->ShowControls = true;
        $containerHide->AddView($viewEvent);
        $i++;
      }
      $view->Events = $container;
      $view->EventsHide = $containerHide;
      //$view->ClassPointer = $containerHide->IsEmpty() ? '' : 'calendar_event_pointer';
    }
    
    return $view;
  }
  
  private function GetDayEvents($date)
  {
    
  } 
  
}