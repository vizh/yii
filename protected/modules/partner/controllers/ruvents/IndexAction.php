<?php
namespace partner\controllers\ruvents;


class IndexAction extends \partner\components\Action
{
    public function run()
    {
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
        $logs = \Yii::app()->db->createCommand()
            ->select('"RoleId", CAST("CreationTime" AS DATE) as "Date", count("UserId") AS "Count"')
            ->from('(SELECT DISTINCT ON ("UserId") "UserId", "CreationTime", "RoleId" FROM "RuventsBadge"
                WHERE "EventId" = :EventId ORDER BY "UserId", "CreationTime") p')
            ->group('"RoleId", CAST("CreationTime" AS DATE)')
            ->query(['EventId' => $this->getEvent()->Id]);

        $byRoles = [];
        $all = [];
        $roles = [];
        $total = 0;
        foreach ($logs as $log)
        {
            $date = $log['Date'];
            if (!isset($byRoles[$date]))
            {
                $byRoles[$date] = [];
                $all[$date] = 0;
            }
            $roles[] = $log['RoleId'];
            $byRoles[$date][$log['RoleId']] = $log['Count'];
            $all[$date] += $log['Count'];
            $total += $log['Count'];
        }

        $dates = array_keys($all);
        sort($dates, SORT_STRING);

        $result = new \stdClass();
        $result->Roles = array_unique($roles);
        $result->Dates = $dates;
        $result->ByRoles = $byRoles;
        $result->All = $all;
        $result->Total = $total;

        return $result;
    }
}
