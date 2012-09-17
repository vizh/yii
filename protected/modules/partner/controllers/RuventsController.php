<?php
class RuventsController extends \partner\components\Controller
{
  public function actionIndex()
  {
    $stat = new stdClass();
    $stat->Operators = new stdClass();
    $stat->Operators->Count = 0;
    
    $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    
    // Подсчет участников по каждому дню
    if (!empty($event->Days))
    {
      foreach ($event->Days as $day) 
      {
        $stat->Participants[$day->DayId] = new \stdClass();
        $stat->Participants[$day->DayId]->DayTitle = $day->Title;
        $stat->Participants[$day->DayId]->Count = \event\models\Participant::model()->byEventId($event->EventId)->byDayId($day->DayId)->count();
      }
    }
    else
    {
      $stat->Participants = new \stdClass();
      $stat->Participants->Count = \event\models\Participant::model()->byEventId($event->EventId)->count();
    }
  
    // Список операторов
    $operators = \ruvents\models\Operator::model()->findAll('t.EventId = :EventId', array('EventId' => $event->EventId));
    $operatorsLogin = array();
    foreach ($operators as $operator)
    {
      $operatorsLogin[$operator->OperatorId] = $operator->Login;
    }
    
    
    $dateStart = new DateTime($event->DateStart);
    $dateEnd   = new DateTime($event->DateEnd);
    while ($dateStart <= $dateEnd)
    {
      // Подсчет печатей бейджей по каждому дню
      $criteria = new CDbCriteria();
      $criteria->select = 't.OperatorId, Count(*) as `CountForCriteria`';
      $criteria->group  = 't.OperatorId';
      $criteria->condition = 't.CreationTime >= :MinDateTime AND t.CreationTime <= :MaxDateTime AND t.EventId = :EventId';
      $criteria->params = array(
        'MinDateTime' => $dateStart->format('Y-m-d').' 00:00:00',
        'MaxDateTime' => $dateStart->format('Y-m-d').' 23:59:59',
        'EventId'     => $event->EventId
      );
      $badges = \ruvents\models\Badge::model()->findAll($criteria);
      foreach ($badges as $badge)
      { 
        $stat->PrintBadges[$dateStart->format('d.m.Y')][$badge->OperatorId]->OperatorLogin = $operatorsLogin[$badge->OperatorId];
        $stat->PrintBadges[$dateStart->format('d.m.Y')][$badge->OperatorId]->Count = $badge->CountForCriteria;
      }
      $dateStart->modify('+1 day');
    }
    
    
    // Подсчет повторных печатей бейджей
    $criteria = new CDbCriteria();
    $criteria->select = 't.UserId, Count(*) as `CountForCriteria`';
    $criteria->group  = 't.UserId, t.DayId';
    $criteria->having = 'CountForCriteria > 1';
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(
      'EventId' => $event->EventId
    );
    $badges = \ruvents\models\Badge::model()->findAll($criteria);
    foreach ($badges as $badge)
    {
      $stat->RePrintBadges[$badge->UserId]->User = $badge->User;
      $stat->RePrintBadges[$badge->UserId]->Count = $badge->CountForCriteria;
    }
    
    $this->render('index', array('event' => $event, 'stat' => $stat, 'operators' => $operatorsLogin));
  }
}