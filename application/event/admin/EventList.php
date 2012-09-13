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
  protected function doExecute($status = 'visible')
  {
    $this->SetTitle('Список мероприятий');

    $page = (int) Registry::GetRequestVar('page', 1);
    if ($page < 1)
    {
      $page = 1;
    }
    
    $criteria = new CDbCriteria();
    $criteria->limit  = self::EventsByPage;
    $criteria->offset = self::EventsByPage * ($page - 1);
    $criteria->order = 't.DateStart DESC, t.DateEnd DESC';
    
    $criteria->condition = 't.Visible = :Visible';
    if ($status == 'visible')
    {
      $criteria->params[':Visible'] = 'Y';
    }
    else
    {
      $criteria->params[':Visible'] = 'N';
    }
    
    $search = Registry::GetRequestVar('Search', null);
    if ($search !== null)
    {
      $query = $search['Query'];
      if (!empty($query))
      {
        $criteria->addSearchCondition('t.Name', $query);
        $criteria->addSearchCondition('t.EventId', $query, true, 'OR');
        $criteria->addSearchCondition('t.IdName', $query, true, 'OR');
      }
    }
    $this->view->Search = $search;
    
    $events = Event::model()->findAll($criteria);
    foreach ($events as $event)
    {
      $view = new View();
      $view->SetTemplate('event');
      $view->Event = $event;
      $this->view->Events .= $view;
    }
    $this->view->Paginator = new Paginator(RouteRegistry::GetAdminUrl('event', '', 'list', array('status' => $status)) . '?page=%s', $page, self::EventsByPage, Event::model()->count($criteria));
    echo $this->view;
  }

}
