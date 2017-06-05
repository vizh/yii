<?php
namespace partner\controllers\ruvents;

use application\models\attribute\Definition;
use event\models\UserData;
use ruvents\models\Badge;
use ruvents\models\Visit;
use Yii;

class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $stat = new \stdClass();
        $stat->Operators = new \stdClass();
        $stat->Operators->Count = 0;
        $stat->Roles = [];
        $stat->Visits = [];
        $event = $this->getEvent();

        // Кол-во всего выданных бейджей
        $stat->CountBadges = Badge::model()
            ->byEventId($event->Id)
            ->count();

        $badgesSql = /** @lang PostgreSQL */
            '
            WITH
                "BadgesAll" AS (SELECT "RoleId", count("UserId") AS "Count" FROM "RuventsBadge" WHERE "EventId" = :EventId GROUP BY "RoleId"),
                "BadgesUnique" AS (SELECT "RoleId", count(DISTINCT "UserId") AS "Count" FROM "RuventsBadge" WHERE "EventId" = :EventId GROUP BY "RoleId")
            SELECT
                "EventRole"."Title",
                "BadgesUnique"."Count",
                "BadgesAll"."Count"
            FROM "BadgesAll"
                LEFT JOIN "BadgesUnique" ON "BadgesUnique"."RoleId" = "BadgesAll"."RoleId"
                LEFT JOIN "EventRole" ON "BadgesUnique"."RoleId" = "EventRole"."Id"
            ORDER BY "BadgesUnique"."Count" DESC';

        $stat->BadgesByRole = Yii::app()
            ->getDb()
            ->createCommand($badgesSql)
            ->queryAll(false, [
                'EventId' => $event->Id
            ]);

        // Список ролей на мероприятии
        $criteria = new \CDbCriteria();
        $criteria->select = '"t"."RoleId", "count"("t"."Id") as "CountBadges"';
        $criteria->group = '"t"."RoleId"';
        /** @var $badges Badge[] */
        $badges = Badge::model()->byEventId($event->Id)->findAll($criteria);
        foreach ($badges as $badge) {
            $stat->Roles[$badge->RoleId] = $badge->Role->Title;
        }

        $stat->Users = $this->getUserStatistics();

        // Список операторов
        $operators = \ruvents\models\Operator::model()->findAllByAttributes([
            'EventId' => $event->Id,
            'Role' => 'Operator'
        ]);

        $operatorsLogin = [];
        foreach ($operators as $operator) {
            $operatorsLogin[$operator->Id] = $operator->Login;
        }

        $dateStart = new \DateTime($event->StartYear.'-'.$event->StartMonth.'-'.$event->StartDay);
        $dateEnd = new \DateTime($event->EndYear.'-'.$event->EndMonth.'-'.$event->EndDay);
        while ($dateStart <= $dateEnd) {
            // Подсчет печатей бейджей по каждому дню
            $criteria = new \CDbCriteria();
            $criteria->select = '"t"."OperatorId", "count"(*) as "CountForCriteria"';
            $criteria->group = '"t"."OperatorId"';
            $criteria->condition = '"t"."CreationTime" >= :MinDateTime AND "t"."CreationTime" <= :MaxDateTime AND "t"."EventId" = :EventId';
            $criteria->params = [
                'MinDateTime' => $dateStart->format('Y-m-d').' 00:00:00',
                'MaxDateTime' => $dateStart->format('Y-m-d').' 23:59:59',
                'EventId' => $event->Id
            ];
            $badges = Badge::model()->findAll($criteria);
            foreach ($badges as $badge) {
                // Бывает, что бейдж напечатан администратором или оператором, который уже не принадлежит мероприятию или был удалён.
                // Не будем выбрасывать (не показывать) данные по ним. Но и не будем делать выборку всех операторов по всем мероприятиям сразу.
                // Действуем по-необходимости.
                if (!isset($operatorsLogin[$badge->OperatorId])) {
                    $operator = \ruvents\models\Operator::model()->findByPk($badge->OperatorId);
                    if (!$operator) // Похоже, что оператор был удалён из базы. Не теряем его из статистики.
                    {
                        $operator = (object)['Login' => "Удалённый оператор #{$badge->OperatorId}"];
                    }

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
        $criteria->group = '"t"."UserId", "t"."PartId"';
        $criteria->having = '"count"(*) > 1';
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = [
            'EventId' => $event->Id
        ];

        $badges = Badge::model()
            ->findAll($criteria);

        foreach ($badges as $badge) {
            $stat->RePrintBadges[$badge->UserId] = (object)[
                'User' => $badge->User,
                'Count' => $badge->CountForCriteria
            ];
        }

        // Список ролей на мероприятии
        $visits = Visit::model()
            ->byEventId($event->Id)
            ->orderBy('"t"."MarkId"')
            ->findAll();

        foreach ($visits as $visit) {
            $datetime = new \DateTime($visit->CreationTime);
            if ($visit->MarkId === 'Зал 1' || $visit->MarkId === 'Зал 2') {
                $time = $datetime->format('H:i');
                if ($time >= '09:50' && $time <= '11:00') {
                    $visit->MarkId .= ' Открытие';
                } elseif ($time >= '11:20' && $time <= '13:30') {
                    $visit->MarkId .= ' Поток 1';
                } elseif ($time >= '14:20' && $time <= '16:30') {
                    $visit->MarkId .= ' Поток 2';
                }
            }
            $visit->MarkId .= ' '.$datetime->format('d.m.Y');
            $stat->Visits[$visit->MarkId]++;
        }

        $this->getController()->render('index', [
                'event' => $event,
                'stat' => $stat,
                'operators' => $operatorsLogin,
                'counters' => $this->getCountersStatistics()
            ]
        );
    }

    private function getUserStatistics()
    {
        $logs = Yii::app()->db->createCommand()
            ->select('"RoleId", CAST("CreationTime" AS DATE) as "Date", count("UserId") AS "Count"')
            ->from('(SELECT DISTINCT ON ("UserId") "UserId", "CreationTime", "RoleId" FROM "RuventsBadge"
                WHERE "EventId" = :EventId ORDER BY "UserId", "CreationTime") p')
            ->group('"RoleId", CAST("CreationTime" AS DATE)')
            ->query(['EventId' => $this->getEvent()->Id]);

        $byRoles = [];
        $all = [];
        $roles = [];
        $total = 0;
        foreach ($logs as $log) {
            $date = $log['Date'];
            if (!isset($byRoles[$date])) {
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

        return (object)[
            'Roles' => array_unique($roles),
            'Dates' => $dates,
            'ByRoles' => $byRoles,
            'All' => $all,
            'Total' => $total
        ];
    }

    /**
     * Рассчитывает и возвращает статистику по использованию атрибутов типа CounterDefinition
     *
     * @return array|null
     */
    private function getCountersStatistics()
    {
        $result = [];

        $definitions = Definition::model()
            ->byModelName('EventUserData')
            ->byModelId($this->getEvent()->Id)
            ->byClassName('CounterDefinition')
            ->findAll();

        if (empty($definitions)) {
            return null;
        }

        // По хорошему, надо начинать использовать возможности JSON в PostgreSQL.
        // Но пока не будет обновления до 9.4 и появления json_typeof, это не удастся
        $usersData = UserData::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            // ->byAttributeExists($definitionName)
            ->with('User')
            ->findAll();

        foreach ($definitions as $definition) {
            $definitionName = $definition->Name;
            $result[$definitionName] = [
                'total' => 0,
                'definitionName' => $definition->Title,
                'users' => []
            ];
            /** @var UserData $userData */
            foreach ($usersData as $userData) {
                $dataManager = $userData->getManager();
                $dataValue = (int)trim($dataManager->$definitionName);
                if (isset($dataManager->$definitionName) && $dataValue > 0) {
                    $result[$definitionName]['total'] += $dataValue;
                    $result[$definitionName]['users'][$userData->UserId] = [
                        'count' => $dataValue,
                        'userName' => $userData->User->getFullName(),
                        'userEmail' => $userData->User->Email
                    ];
                }
            }
        }

        return $result;
    }
}
