<?php
AutoLoader::Import('library.rocid.event.*');
 
class EventNew extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $event = new Event();
    $event->DateStart = date('Y-m-d', time() + 2*365*24*60*60);
    $event->DateEnd = date('Y-m-d', time() + 2*365*24*60*60);
    $event->Visible = 'N';
    $event->IdName = Event::GetUniqueIdName('new');
    $event->save();

    Lib::Redirect(RouteRegistry::GetAdminUrl('event', '', 'edit', array('id' => $event->EventId)));
  }
}
