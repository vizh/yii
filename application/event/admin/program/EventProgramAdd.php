<?php
AutoLoader::Import('library.rocid.event.*');
 
class EventProgramAdd extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    $event = Event::GetById($eventId);
    if (empty($event))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('event', '', 'list'));
    }
    $eventProgram = new EventProgram();
    $eventProgram->EventId = $event->EventId;
    $eventProgram->DatetimeStart = $event->DateStart . ' 10:00:00';
    $eventProgram->DatetimeFinish = $event->DateStart . ' 11:00:00';
    $eventProgram->Type = EventProgram::ProgramTypeShort;
    $eventProgram->save();

    Lib::Redirect(RouteRegistry::GetAdminUrl('event', 'program', 'edit', array('id'=>$eventProgram->EventProgramId)));
  }
}
