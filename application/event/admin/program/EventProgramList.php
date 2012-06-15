<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 15.09.11
 * Time: 13:47
 * To change this template use File | Settings | File Templates.
 */
 
class EventProgramList extends AdminCommand
{

  const CellWidth = 750;

  /**
   * @var Event
   */
  private $event;

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    $this->event = Event::GetById(intval($eventId));
    if (empty($this->event))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('event', '', 'list'));
    }
    $this->view->Name = $this->event->Name;

    $program = array();
    foreach ($this->event->Program as $eventProgram)
    {
      $date = date('Y-m-d',strtotime($eventProgram->DatetimeStart));
      $program[$date][$eventProgram->DatetimeStart.$eventProgram->DatetimeFinish][] = $eventProgram;
    }

    foreach ($program as $date => $day)
    {
      $dayView = new View();
      $dayView->SetTemplate('day');
      $dayView->Date = strftime('%d %B', strtotime($date));
      foreach ($day as $line)
      {
        $dayView->Lines .= $this->getProgramLine($line);
      }
      $this->view->Days .= $dayView;
    }

    $this->view->EventId = $this->event->EventId;

    echo $this->view;
  }

  /**
   * @param EventProgram[] $line
   * @return string
   */
  private function getProgramLine($line)
  {
    $lineView = new View();
    $lineView->SetTemplate('line');
    $width = (int)(self::CellWidth / sizeof($line));
    $lineView->StartTime = date('H:i', strtotime($line[0]->DatetimeStart));
    $lineView->EndTime = date('H:i', strtotime($line[0]->DatetimeFinish));

    foreach ($line as $eventProgram)
    {
      $itemView = new View();
      $itemView->SetTemplate('item');
      $itemView->EventProgramId = $eventProgram->EventProgramId;
      $itemView->Section = $eventProgram->Abbr;
      $itemView->Type = $eventProgram->Type;
      $itemView->Place = $eventProgram->Place;
      $itemView->Title = $eventProgram->Title;
      $itemView->Width = $width;
      
      $lineView->Items .= $itemView;
    }
    return $lineView;
  }
}
