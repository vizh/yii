<?php
class RuventsController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'operator' => '\partner\controllers\ruvents\OperatorAction',
      'csvinfo' => '\partner\controllers\ruvents\CsvinfoAction',
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
      'csvinfo' => array(
        'Title' => 'Итоги мероприятия (csv)',
        'Url' => \Yii::app()->createUrl('/partner/ruvents/csvinfo'),
        'Access' => $this->getAccessFilter()->checkAccess('ruvents', 'csvinfo')
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

    $stat->New = array();

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
      //по бейджам
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



      //новых участников в каждый за день

      $criteria = new CDbCriteria();
      $criteria->addCondition('t.CreationTime >= :MinDateTime');
      $criteria->addCondition('t.CreationTime <= :MaxDateTime');
      $criteria->addCondition('t.EventId = :EventId');
      $criteria->params = array(
        'MinDateTime' => strtotime($dateStart->format('Y-m-d').' 05:00:00'),
        'MaxDateTime' => strtotime($dateStart->format('Y-m-d').' 22:00:00'),
        'EventId' => $event->EventId
      );

      /** @var $participants \event\models\Participant[] */
      $participants = \event\models\Participant::model()->findAll($criteria);
      $userIdList = array();


      $stat->New[$dateStart->format('d.m.Y')]['AllParticipants'] = sizeof($participants);
      $stat->New[$dateStart->format('d.m.Y')]['AllParticipantsByRuvents'] = 0;

      foreach ($participants as $participant)
      {
        $badge = \ruvents\models\Badge::model()
          ->byEventId($event->EventId)
          ->byUserId($participant->UserId);
        $badge = $badge->find('ABS(UNIX_TIMESTAMP(t.CreationTime) - :CreationTime) < 1200', array('CreationTime' => $participant->CreationTime));
        if (!empty($badge))
        {
          $stat->New[$dateStart->format('d.m.Y')]['AllParticipantsByRuvents']++;
          $userIdList[] = $participant->UserId;
        }
      }
      //новых пользователей за день
      $criteria = new CDbCriteria();
      $criteria->addCondition('t.CreationTime >= :MinDateTime');
      $criteria->addCondition('t.CreationTime <= :MaxDateTime');
      $criteria->params = array(
        'MinDateTime' => strtotime($dateStart->format('Y-m-d').' 05:00:00'),
        'MaxDateTime' => strtotime($dateStart->format('Y-m-d').' 22:00:00'),
      );
      $criteria->addInCondition('t.UserId', $userIdList);

      /** @var $users \user\models\User[] */
      $users = \user\models\User::model()->findAll($criteria);
      $stat->New[$dateStart->format('d.m.Y')]['AllUsers'] = sizeof($users);
      $stat->New[$dateStart->format('d.m.Y')]['AllUsersByRuvents'] = 0;

      foreach ($users as $user)
      {
        $badge = \ruvents\models\Badge::model()
          ->byEventId($event->EventId)
          ->byUserId($user->UserId);

        $badge = $badge->find('ABS(UNIX_TIMESTAMP(t.CreationTime) - :CreationTime) < 1200', array('CreationTime' => $user->CreationTime));
        if (!empty($badge))
        {
          $stat->New[$dateStart->format('d.m.Y')]['AllUsersByRuvents']++;
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