<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 13.09.11
 * Time: 15:48
 * To change this template use File | Settings | File Templates.
 */

class EventList extends AdminCommand
{
  const EventsByPage = 20;

  /**
   * Основные действия комманды
   * @param int $page
   * @return void
   */
  protected function doExecute($page = 1)
  {
    $this->SetTitle('Список мероприятий');

    $page = max(1, intval($page));
    $events = Event::GetByPage(self::EventsByPage, $page);
    $count = Event::$GetByPageCountLast;
    $url = RouteRegistry::GetAdminUrl('event', '', 'list') . '%s/';
    $this->view->Paginator = new Paginator($url, $page, self::EventsByPage, $count);
    foreach ($events as $event)
    {
      $view = new View();
      $view->SetTemplate('event');

      $view->EventId = $event->EventId;
      $view->IdName = $event->IdName;
      $view->Name = $event->Name;
      $view->Info = $event->Info;
      $view->Type = $event->Type;
      $view->DateStart = getdate(strtotime($event->DateStart));
      $view->DateEnd = getdate(strtotime($event->DateEnd));
      if ($event->DateStart == $event->DateEnd)
      {
        $view->EmptyDay = intval(substr($event->DateStart, 8, 2)) == '00';
      }
      $view->Place = $event->Place;
      $view->Url = $event->Url;
      $view->UrlRegistration = $event->UrlRegistration;
      $view->Visible = $event->Visible;
      $view->Logo = $event->GetMiniLogo();

      $this->view->Events .= $view;
    }
    echo $this->view;
  }

}
