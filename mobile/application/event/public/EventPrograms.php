<?php

/**
 * @throws Exception
 */
class EventPrograms extends MobileCommand
{
  /**
   * @var Event
   */
  private $event;
  
  protected function preExecute()
  {
    parent::preExecute();    
    //Установка хеадера        
    $this->RedirectNonAuth();
    
    $titles = Registry::GetWord('titles'); 
    $this->SetTitle($titles['mobile']);
  }
  
  protected function doExecute($idName = '', $arg1 = '', $arg2 = '')
  {
    $date = null;
    $place = null;

    $this->event = Event::GetEventByIdName($idName, Event::LoadOnlyEvent);

    if (empty($this->event))
    {
      throw new Exception('Мероприятие с текстовым идентификатором ' . $idName . ' не обнаружено.');
    }    
    
    $this->view->IdName = $this->event->IdName;
    $this->view->Name = $this->event->GetName();
    
    $itemList = $this->getItemsListByDate($this->event->GetProgram());
    $keys = array_keys($itemList);
    
    if (sizeof($itemList) == 1)
    {
      $date = $keys[0];
    }
    else if (! empty($arg1))
    {
      if (in_array($arg1, $keys))
      {
        $date = $arg1;
      }
    }
    
    $view = new View();
    if (empty($date))
    {
      $view->SetTemplate('dates');
      $view->Dates = $keys;
      $view->CurrentDay = date('Y-m-d', time());
      $view->EventIdName = $this->event->IdName;
    }
    else
    {
      $itemList = $this->getItemsListByPlace($itemList[$date]);
      $keys = array_keys($itemList);
      
      if (sizeof($itemList) == 1)
      {
        
        $place = $keys[0];
      }
      else if ($arg2 !== '' && sizeof($itemList) > intval($arg2))
      {
        $place = $keys[intval($arg2)];         
      }
      
      $placeDateView = new View();
      $placeDateView->SetTemplate('placeinfo');
      $placeDateView->Date = $date;
      
      if (empty($place))
      {
        $view->SetTemplate('places');
        
        $view->Places = $keys;
        $view->Date = $date;
        $view->EventIdName = $this->event->IdName;        
      }
      else
      {
        $view->SetTemplate('items');
        
        if ($place != 'default')
        {
          $list = $this->getFullItemList($itemList[$place], $itemList['default']);
        }
        else
        {
          $list = $itemList[$place];
        }
        
        $view->Items = $list;//$itemList[$place];
        $placeDateView->Place = $place;
      }
      
      $this->view->PlaceInfo = $placeDateView;
    }
     
    $this->view->ListContent = $view;    
    echo $this->view;
  } 
  
  private function getItemsListByDate($program)
  {
    $list = array();
    foreach ($program as $item)
    {
      $time = strtotime($item->DatetimeStart);
      $date = date('Y-m-d', $time);
      $list[$date][] = $item;
    }
    
    return $list;
  }
  
  private function getItemsListByPlace($program)
  {
    $list = array();
    foreach ($program as $item)
    {
      $place = empty($item->Place) ? 'default' : $item->Place;
      $list[$place][] = $item;
    }
    return $list;
  }
  
  private function getFullItemList($list, $default)
  {
    $result = array();
    $i = 0;
    $j = 0;
    for (;$i<sizeof($list) && $j<sizeof($default);)
    {
//      echo 'i = ' . $i . '  j = ' . $j . "\n";
      if ($list[$i]->DatetimeStart > $default[$j]->DatetimeStart)
      {
        $result[] = $default[$j];
        $j++;
      }
      else
      {
        $result[] = $list[$i];
        $i++;
      }
    }
    for(;$i<sizeof($list); $i++)
    {
      $result[] = $list[$i];
    }
    for(;$j<sizeof($default); $j++)
    {
      $result[] = $default[$j];
    }
    return $result;
  }
}