<?php
namespace ruvents\controllers\stat;

use application\components\web\ArrayDataProvider;
use event\models\UserData;
use ruvents\models\Visit;

/**
 * Shows the page with statistics for participants
 */
class ParticipantsTS16Action extends StatAction
{
    /**
     * Shifts for TS
     *
     * @var array
     */
    private static $shifts = [
        'Молодые ученые и преподаватели общественных наук' => 1,
        'Молодые депутаты и политические лидеры' => 2,
        'Молодые ученые и преподаватели в области IT-технологий' => 3,
        'Молодые специалисты в области межнациональных отношений' => 4,
        'Молодые ученые и преподаватели экономических наук' => 5,
        'Молодые ученые и преподаватели в области здравоохранения' => 6,
        'Молодые руководители социальных НКО и проектов' => 7,
        'Молодые преподаватели факультетов журналистики, молодые журналисты' => 8
    ];
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $eventId = 2783;
        $this->controller->layout = '//layouts/clear';

        $stat = $this->fetchGroups($eventId);

        usort($stat, function ($a, $b) {
            if (!isset(self::$shifts[$a['group']]) && isset(self::$shifts[$b['group']])) {
                return 1;
            }

            if (isset(self::$shifts[$a['group']]) && !isset(self::$shifts[$b['group']])) {
                return -1;
            }

            return self::$shifts[$a['group']] < self::$shifts[$b['group']] ? -1 : 1;
        });

        $this->controller->render('participants-ts16', [
            'dataProvider' => new ArrayDataProvider($stat, [
                'sort' => false
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
        $filterExpression = 'SUBSTRING(d."Attributes"::TEXT FROM \'"smena":"([^"]+)"\')';

        $data = \Yii::app()->getDb()->createCommand()
            ->select($filterExpression . 'AS "Group", COUNT(*) AS "Count", COUNT(DISTINCT v."UserId") AS "Registered"')
            ->from(UserData::model()->tableName() . ' d')
            ->leftJoin(Visit::model()->tableName() . ' v', 'v."UserId" = d."UserId" AND v."EventId" = d."EventId"')
            ->where('d."EventId" = :eventId', [
                ':eventId' => $eventId
            ])
            ->group($filterExpression)
            ->query();

        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'group' => $row['Group'],
                'total' => $row['Count'],
                'registered' => $row['Registered']
            ];
        }

        return $result;
    }
}
