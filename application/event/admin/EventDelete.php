<?php
class EventDelete extends AdminCommand
{
  protected function doExecute($eventId = null) 
  {
    $event = Event::GetById($eventId);
    echo $event->Name;
  }
}

?>
