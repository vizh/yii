<?php
class RuventsController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'operator' => '\partner\controllers\ruvents\OperatorAction'
    );
  }

  public function initBottomMenu()
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Статистика',
        'Url' => \Yii::app()->createUrl('/partner/ruvents/index'),
        'Access' => $this->getAccessFilter()->checkAccess('ruvents', 'index')
      ),
      'operator' => array(
        'Title' => 'Генерация операторов',
        'Url' => \Yii::app()->createUrl('/partner/ruvents/operator'),
        'Access' => $this->getAccessFilter()->checkAccess('ruvents', 'operator')
      ),
    );
  }

  public function actionIndex()
  {
    $this->initActiveBottomMenu('index');

    $stat = new stdClass();
    $stat->Operators = new stdClass();
    $stat->Operators->Count = 0;
    $stat->CountParticipants = 0;

    $stat->Roles = array();
    
    
    $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    
    // Кол-во всего выданных бейджей
    $stat->CountBadges = \ruvents\models\Badge::model()->count('t.EventId = :EventId', array(':EventId' => $event->EventId));
    
    // Список ролей на мероприятии
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Eventid = :EventId';
    $criteria->params['EventId'] = $event->EventId;
    $criteria->group = 't.RoleId';
    $criteria->with = array('Role');
    $badges = \ruvents\models\Badge::model()->findAll($criteria);
    foreach ($badges as $badge)
    {
      $stat->Roles[$badge->RoleId] = $badge->Role->Name;
    }
    
    
    // Подсчет участников по каждому дню
    $dateStart = new DateTime($event->DateStart);
    $dateEnd   = new DateTime($event->DateEnd);
    while ($dateStart <= $dateEnd)
    {
      foreach ($stat->Roles as $roleId => $roleName)
      {
        $criteria = new CDbCriteria();
        $criteria->condition = 't.CreationTime >= :MinDateTime AND t.CreationTime <= :MaxDateTime AND t.UserId NOT IN (SELECT t1.UserId FROM '.\ruvents\models\Badge::model()->tableName().' t1 WHERE t1.CreationTime < :MinDateTime AND t1.EventId = :EventId) AND t.EventId = :EventId AND t.RoleId = :RoleId';
        $criteria->params['MinDateTime'] = $dateStart->format('Y-m-d').' 00:00:00';
        $criteria->params['MaxDateTime'] = $dateStart->format('Y-m-d').' 23:59:59';
        $criteria->params['EventId'] = $event->EventId;
        $criteria->params['RoleId'] = $roleId;
        $criteria->select = 'Count(Distinct t.UserId) as `CountForCriteria`';
        $badges = \ruvents\models\Badge::model()->findAll($criteria);
        foreach ($badges as $badge)
        {
          $stat->Participants[$dateStart->format('d.m.Y')][$roleId] = $badge->CountForCriteria; 
          $stat->CountParticipants += $badge->CountForCriteria;
        }
      }
      $dateStart->modify('+1 day');
    }
    
    
    // Список операторов
    $operators = \ruvents\models\Operator::model()->findAll('t.EventId = :EventId AND t.Role = \'Operator\'', array('EventId' => $event->EventId));
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