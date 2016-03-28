<?php
namespace ruvents\controllers\stat;

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

        $groups = $this->fetchUniqueGroups($eventId);
        $allStat = $this->collectAllStat($eventId, $groups);

        $this->controller->render('food', [
            'allStat' => $allStat
        ]);
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
}
