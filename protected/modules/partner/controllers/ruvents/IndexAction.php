<?php
namespace partner\controllers\ruvents;


class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->initActiveBottomMenu('index');

    $stat = new \stdClass();
    $stat->Operators = new \stdClass();
    $stat->Operators->Count = 0;
    $stat->CountParticipants = 0;

    $stat->New = array();

    $stat->Roles = array();


    $event = $this->getEvent();

    // Кол-во всего выданных бейджей
    $stat->CountBadges = \ruvents\models\Badge::model()->byEventId($event->Id)->count();


    // Список ролей на мероприятии
    $criteria = new \CDbCriteria();
    $criteria->select = '"t"."RoleId", "count"("t"."Id") as "CountBadges"';
    $criteria->group = '"t"."RoleId"';
    /** @var $badges \ruvents\models\Badge[] */
    $badges = \ruvents\models\Badge::model()->byEventId($event->Id)->findAll($criteria);
    foreach ($badges as $badge)
    {
      $stat->Roles[$badge->RoleId] = $badge->Role->Title;
    }


    // Подсчет участников по каждому дню
    $dateStart = new \DateTime($event->StartYear.'-'.$event->StartMonth.'-'.$event->StartDay);
    $dateEnd   = new \DateTime($event->EndYear.'-'.$event->EndMonth.'-'.$event->EndDay);
    while ($dateStart <= $dateEnd)
    {
      //по бейджам
      foreach ($stat->Roles as $roleId => $roleName)
      {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."CreationTime" >= :MinDateTime AND "t"."CreationTime" <= :MaxDateTime AND "t"."UserId" NOT IN (SELECT "t1"."UserId" FROM "'.\ruvents\models\Badge::model()->tableName().'" "t1" WHERE "t1"."CreationTime" < :MinDateTime AND "t1"."EventId" = :EventId) AND "t"."EventId" = :EventId AND "t"."RoleId" = :RoleId';
        $criteria->params['MinDateTime'] = $dateStart->format('Y-m-d').' 00:00:00';
        $criteria->params['MaxDateTime'] = $dateStart->format('Y-m-d').' 23:59:59';
        $criteria->params['EventId'] = $event->Id;
        $criteria->params['RoleId'] = $roleId;
        $criteria->select = '"count"(Distinct "t"."UserId") as "CountForCriteria"';
        $badges = \ruvents\models\Badge::model()->findAll($criteria);
        foreach ($badges as $badge)
        {
          $stat->Participants[$dateStart->format('d.m.Y')][$roleId] = $badge->CountForCriteria;
          $stat->CountParticipants += $badge->CountForCriteria;
        }
      }

      //новых участников в каждый за день

      $criteria = new \CDbCriteria();
      $criteria->addCondition('"t"."CreationTime" >= :MinDateTime');
      $criteria->addCondition('"t"."CreationTime" <= :MaxDateTime');
      $criteria->addCondition('"t"."EventId" = :EventId');
      $criteria->params = array(
        'MinDateTime' => $dateStart->format('Y-m-d').' 05:00:00',
        'MaxDateTime' => $dateStart->format('Y-m-d').' 22:00:00',
        'EventId' => $event->Id
      );

      /** @var $participants \event\models\Participant[] */
      $participants = \event\models\Participant::model()->findAll($criteria);
      $userIdList = array();


      $stat->New[$dateStart->format('d.m.Y')]['AllParticipants'] = sizeof($participants);
      $stat->New[$dateStart->format('d.m.Y')]['AllParticipantsByRuvents'] = 0;

      foreach ($participants as $participant)
      {
        $badge = \ruvents\models\Badge::model()
            ->byEventId($event->Id)
            ->byUserId($participant->UserId);
        $badge = $badge->find('"t"."CreationTime" - timestamp :CreationTime < interval \'1 hour\'', array('CreationTime' => $participant->CreationTime));
        if (!empty($badge))
        {
          $stat->New[$dateStart->format('d.m.Y')]['AllParticipantsByRuvents']++;
          $userIdList[] = $participant->UserId;
        }
      }
      //новых пользователей за день
      $criteria = new \CDbCriteria();
      $criteria->addCondition('"t"."CreationTime" >= :MinDateTime');
      $criteria->addCondition('"t"."CreationTime" <= :MaxDateTime');
      $criteria->params = array(
        'MinDateTime' => $dateStart->format('Y-m-d').' 05:00:00',
        'MaxDateTime' => $dateStart->format('Y-m-d').' 22:00:00',
      );
      $criteria->addInCondition('"t"."Id"', $userIdList);

      /** @var $users \user\models\User[] */
      $users = \user\models\User::model()->findAll($criteria);
      $stat->New[$dateStart->format('d.m.Y')]['AllUsers'] = sizeof($users);
      $stat->New[$dateStart->format('d.m.Y')]['AllUsersByRuvents'] = 0;

      foreach ($users as $user)
      {
        $badge = \ruvents\models\Badge::model()
            ->byEventId($event->Id)
            ->byUserId($user->Id);

        $badge = $badge->find('"t"."CreationTime" - timestamp :CreationTime < interval \'1 hour\'', array('CreationTime' => $user->CreationTime));
        if (!empty($badge))
        {
          $stat->New[$dateStart->format('d.m.Y')]['AllUsersByRuvents']++;
        }
      }


      $dateStart->modify('+1 day');
    }

    // Список операторов
    $operators = \ruvents\models\Operator::model()->findAll('"t"."EventId" = :EventId AND "t"."Role" = :Role', array('EventId' => $event->Id, 'Role' => 'Operator'));
    $operatorsLogin = array();
    foreach ($operators as $operator)
    {
      $operatorsLogin[$operator->Id] = $operator->Login;
    }


    $dateStart = new \DateTime($event->StartYear.'-'.$event->StartMonth.'-'.$event->StartDay);
    $dateEnd   = new \DateTime($event->EndYear.'-'.$event->EndMonth.'-'.$event->EndDay);
    while ($dateStart <= $dateEnd)
    {
      // Подсчет печатей бейджей по каждому дню
      $criteria = new \CDbCriteria();
      $criteria->select = '"t"."OperatorId", "count"(*) as "CountForCriteria"';
      $criteria->group  = '"t"."OperatorId"';
      $criteria->condition = '"t"."CreationTime" >= :MinDateTime AND "t"."CreationTime" <= :MaxDateTime AND "t"."EventId" = :EventId';
      $criteria->params = array(
        'MinDateTime' => $dateStart->format('Y-m-d').' 00:00:00',
        'MaxDateTime' => $dateStart->format('Y-m-d').' 23:59:59',
        'EventId'     => $event->Id
      );
      $badges = \ruvents\models\Badge::model()->findAll($criteria);
      foreach ($badges as $badge)
      {
        $stat->PrintBadges[$dateStart->format('d.m.Y')][$badge->OperatorId] = new \stdClass();
        $stat->PrintBadges[$dateStart->format('d.m.Y')][$badge->OperatorId]->OperatorLogin = $operatorsLogin[$badge->OperatorId];
        $stat->PrintBadges[$dateStart->format('d.m.Y')][$badge->OperatorId]->Count = $badge->CountForCriteria;
      }
      $dateStart->modify('+1 day');
    }




    // Подсчет повторных печатей бейджей
    $criteria = new \CDbCriteria();
    $criteria->select = '"t"."UserId", "count"(*) as "CountForCriteria"';
    $criteria->group  = '"t"."UserId", "t"."PartId"';
    $criteria->having = '"count"(*) > 1';
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params = array(
      'EventId' => $event->Id
    );
    $badges = \ruvents\models\Badge::model()->findAll($criteria);
    foreach ($badges as $badge)
    {
      $stat->RePrintBadges[$badge->UserId] = new \stdClass();
      $stat->RePrintBadges[$badge->UserId]->User = $badge->User;
      $stat->RePrintBadges[$badge->UserId]->Count = $badge->CountForCriteria;
    }

    $this->getController()->render('index', array(
      'event' => $event,
      'stat' => $stat,
      'operators' => $operatorsLogin)
    );
  }
}