<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 16.09.11
 * Time: 17:32
 * To change this template use File | Settings | File Templates.
 */
 
class EventProgramDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $id
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $eventProgram = EventProgram::GetEventProgramById($id);
    if (empty($eventProgram))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('event', '', 'list'));
    }

    $eventProgram->delete();
    Lib::Redirect(RouteRegistry::GetAdminUrl('event', 'program', 'list', array('eventId'=>$eventProgram->EventId)));
  }
}
