<?php
namespace ruvents\controllers\stat;

use application\components\web\ArrayDataProvider;
use event\models\UserData;
use ruvents\models\Badge;
use application\components\services\AIS;

/**
 * Shows the page with statistics for participants
 */
class ParticipantsTS16Action extends StatAction
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $eventId = 2783;
        $shifts = array_flip(AIS::getShifts());

        $this->controller->layout = '//layouts/clear';

        $stat = $this->fetchGroups($eventId);

        usort($stat, function ($a, $b) use ($shifts) {
            if (!isset($shifts[$a['group']]) && isset($shifts[$b['group']])) {
                return 1;
            }

            if (isset($shifts[$a['group']]) && !isset($shifts[$b['group']])) {
                return -1;
            }

            return $shifts[$a['group']] < $shifts[$b['group']] ? -1 : 1;
        });

        $this->controller->render('participants-ts16', [
            'dataProvider' => new ArrayDataProvider($stat, [
                'sort' => false,
                'pagination' => false
            ])
        ]);
    }

    /**
     * Fetches groups for participants
     *
     * @param int $eventId
     * @return string[]
     */
    private function fetchGroups($eventId)
    {        
        $filterExpression = 'COALESCE(SUBSTRING(d."Attributes"::TEXT FROM \'"smena":"([^"]+)"\'), \'Смена не указана\')';

        $data = \Yii::app()->getDb()->createCommand()
            ->select($filterExpression . 'AS "Group", COUNT(*) AS "Count", COUNT(DISTINCT v."UserId") AS "Registered"')
            ->from(UserData::model()->tableName() . ' d')
            ->leftJoin(Badge::model()->tableName() . ' v', 'v."UserId" = d."UserId" AND v."EventId" = d."EventId"')
            ->where('d."EventId" = :eventId', [
                ':eventId' => $eventId
            ])
            ->group($filterExpression)
            ->query();

        $result = [];
        $totalSum = 0;
        $registeredSum = 0;
        foreach ($data as $row) {
            $result[] = [
                'group' => $row['Group'],
                'total' => $row['Count'],
                'registered' => $row['Registered']
            ];

            $totalSum += $row['Count'];
            $registeredSum += $row['Registered'];
        }

        $result[] = [
            'group' => 'Итого',
            'total' => $totalSum,
            'registered' => $registeredSum
        ];

        return $result;
    }
}
