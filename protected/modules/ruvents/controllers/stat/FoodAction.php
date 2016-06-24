<?php
namespace ruvents\controllers\stat;

use event\models\Event;
use ruvents\models\Visit;

/**
 * Shows the page with statistics for food
 */
class FoodAction extends StatAction
{
    /**
     * @inheritdoc
     * @param int $eventId Identifier of the event
     */
    public function run($eventId)
    {
        $this->controller->layout = '//layouts/clear';

        if ($eventId == Event::TS16) {
            var_dump($this->fetchTS16Stat());

            /*$this->controller->render('food-ts16', [
                'allStat' => $allStat
            ]);*/
        } else {
            $groups = $this->fetchUniqueGroups($eventId);
            $allStat = $this->collectAllStat($eventId, $groups);

            $this->controller->render('food', [
                'allStat' => $allStat
            ]);
        }

    }

    /**
     * Collects visits statistics by a group name
     * @param int $eventId Identifier of the event
     * @param string[] $groups Group names
     * @return array
     */
    private function collectAllStat($eventId, $groups)
    {
        $stat = [];
        foreach ($groups as $groupId => $group) {
            $item = [
                'group' => $group,
                'listUrl' => \Yii::app()->getUrlManager()->createUrl('/ruvents/stat/users-list', [
                    'eventId' => $eventId,
                    'group' => $groupId
                ])
            ];

            $item['users'] = \Yii::app()->getDb()->createCommand()
                ->select('COUNT(DISTINCT "UserId")')
                ->from(Visit::model()->tableName())
                ->where('"EventId" = :eventId AND "MarkId" ILIKE :group', [
                    ':eventId' => $eventId,
                    ':group' => $group . '%'
                ])
                ->queryScalar();

            $item['count'] = \Yii::app()->getDb()->createCommand()
                ->select('COUNT(*)')
                ->from(Visit::model()->tableName())
                ->where('"EventId" = :eventId AND "MarkId" ILIKE :group', [
                    ':eventId' => $eventId,
                    ':group' => $group . '%'
                ])
                ->queryScalar();

            $stat[] = $item;
        }

        return $stat;
    }
    
    private function fetchTS16Stat()
    {
        $shiftsDates = [
            ['2016-06-27', '2016-07-03'],
            ['2016-07-05', '2016-07-11'],
            ['2016-07-13', '2016-07-19'],
            ['2016-07-21', '2016-07-27'],
            ['2016-07-29', '2016-08-04'],
            ['2016-08-06', '2016-08-12'],
            ['2016-08-14', '2016-08-20'],
            ['2016-08-22', '2016-08-28']
        ];
        
        $dates = [];
        foreach ($shiftsDates as $d) {
            $dates[] = '('.implode(',', $d).')';
        }
        $dates = implode(',', $dates);
        
        $sql = <<<SQL
WITH "Dates" AS (
    SELECT *
    FROM (VALUES $dates) AS "Dates"(start_date, end_date)
)
SELECT u."RunetId", v."CreationTime":DATE, SUBSTRING("MarkId" FROM '^Питание\\s\\d{2}\\.\\d{2}/\\w+') AS "Mark", Dates".start_date || '-' || "Dates".end_date AS "Shift" FROM "RuventsVisit" v
    INNER JOIN "Dates" ON v."CreationTime"::DATE >= "Dates".start_date::DATE AND v."CreationTime"::DATE <= "Dates".end_date::DATE
    INNER JOIN "User" u ON u."UserId" = v."UserId"
    WHERE v."EventId" = :eventId AND v."MarkId" ~ '^Питание';
SQL;
        $rows = \Yii::app()->getDb()->createCommand($sql)
            ->query([
                ':eventId' => Event::TS16
            ]);

        $result = [];
        foreach ($rows as $row) {
            $shift = $row['Shift'];
            
            $match = [];
            if (!preg_match('/^Питание\s(\d{2}\.\d{2})\/(\w+)/', $row['Mark'], $match)) {
                continue;
            }
            
            if (!isset($match[1]) || !isset($match[2])) {
                continue;
            }
            
            $date = $match[1];
            $food = $match[2];
            
            if (!isset($result[$shift])) {
                $result[$shift] = [];
            }
            
            if (!isset($result[$shift][$date])) {
                $result[$shift][$date] = [];
            }

            if (!isset($result[$shift][$date][$food])) {
                $result[$shift][$date][$food] = [
                    'total' => 0,
                    'touched' => 0
                ];
            }

            $result[$shift][$date][$food]['total']++;
            $result[$shift][$date][$food]['touched']++;
        }

        return $result;
    }

    private function separateGroupsByShifts($groups)
    {
        $shifts = [
            [
                'start' => '27'
            ]
        ];
    }
}
