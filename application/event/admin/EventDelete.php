<?php
class EventDelete extends AdminCommand
{
  protected function doExecute($eventId = null) 
  {
    $event = Event::GetById($eventId);
    if ($event != null)
    {
      if ($event->Deleted == 0)
      {
        $event->Deleted = 1;
        $event->Visible = 'N';
        $event->save();
        $this->view->Message = 'Мероприятие успешно удалено.';
      }
      else 
      {
        $this->view->Message = 'Это мероприятие уже было удалено.';
      }
    }
    else
    {
      $this->view->Message = 'Мероприятие не найдено.';
    }
    echo $this->view;
  }
}

?>
