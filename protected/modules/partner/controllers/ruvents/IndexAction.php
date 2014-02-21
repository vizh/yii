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

    $stat->Users = $this->getUserStatistics();

    // Список операторов
    $operators = \ruvents\models\Operator::model()->findAllByAttributes([
      'EventId' => $event->Id,
      'Role' => 'Operator'
    ]);

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
        // Бывает, что бейдж напечатан администратором или оператором, который уже не принадлежит мероприятию или был удалён.
        // Не будем выбрасывать (не показывать) данные по ним. Но и не будем делать выборку всех операторов по всем мероприятиям сразу.
        // Действуем по-необходимости.
        if (!isset($operatorsLogin[$badge->OperatorId]))
        {
          $operator = \ruvents\models\Operator::model()->findByPk($badge->OperatorId); if (!$operator) // Похоже, что оператор был удалён из базы. Не теряем его из статистики.
            $operator = (object)['Login' => "Удалённый оператор #{$badge->OperatorId}"];

          $operatorsLogin[$badge->OperatorId] = $operator->Login; // кешируем некорректного оператора, дабы не проделывать всё это каждый раз
        }

        $stat->PrintBadges[$dateStart->format('d.m.Y')][$badge->OperatorId] = (object)[
          'OperatorLogin' => $operatorsLogin[$badge->OperatorId],
          'Count' => $badge->CountForCriteria
        ];
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


  private function getUserStatistics()
  {
    $result = new \stdClass();
    $result->ByRoles = [];
    $result->All = 0;

    $logs = \Yii::app()->db->createCommand()
      ->select('DISTINCT ON ("UserId") *')
      ->from('(SELECT DISTINCT ON ("UserId") "UserId", "CreationTime", "Changes" FROM "RuventsDetailLog"
      WHERE "EventId" = :EventId AND "Controller" = :Controller AND "Action" = :Action ORDER BY "UserId", "CreationTime" DESC) p')
      ->query([
        'EventId' => $this->getEvent()->Id,
        'Controller' => 'event',
        'Action' => 'register'
      ]);

    foreach ($logs as $log)
    {
      $changes = unserialize(base64_decode($log['Changes']))[0];
      if (!isset($result->ByRoles[$changes->to]))
      {
        $result->ByRoles[$changes->to] = 0;
      }
      $result->ByRoles[$changes->to]++;
      $result->All++;
    }

    $result->New = \Yii::app()->getDb()->createCommand()
      ->from('RuventsDetailLog')
      ->select('Count(*) as Count')
      ->where('"EventId" = :EventId AND "Controller" = :Controller AND "Action" = :Action')
      ->queryColumn([
        'EventId' => $this->getEvent()->Id,
        'Controller' => 'user',
        'Action' => 'create'
      ])[0];

    return $result;
  }
}