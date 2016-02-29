<?php
namespace ruvents\controllers\stat;

use ruvents\models\Visit;

/**
 * Shows the page with statistics for food
 */
class FoodAction extends \CAction
{
    /**
     * @param int $eventId Identifier of the event
     */
    public function run($eventId)
    {
        $this->controller->layout = '//layouts/clear';

        $groups = $this->fetchUniqueGroups($eventId);

        $this->controller->render('food', [
            'allStat' => $this->collectAllStat($eventId, $groups),
            'dataProviders' => $this->constructDataProviders($eventId, $groups)
        ]);
    }

    /**
     * Fetches unique names of the groups
     * @param int $eventId Identifier of the event
     * @return string[]
     */
    private function fetchUniqueGroups($eventId)
    {
        $substringPattern = "SUBSTRING(\"MarkId\" FROM '^Питание\\s\\d{2}\\.\\d{2}/\\w+')";

        $groups = \Yii::app()->getDb()->createCommand()
            ->select($substringPattern)
            ->from(Visit::model()->tableName())
            ->where('"EventId" = :eventId', [':eventId' => $eventId])
            ->group($substringPattern)
            ->queryColumn();

        return array_filter($groups, function ($name) {
            return !is_null($name);
        });
    }

    /**
     * Collects visits statistics by a group name
     * @param string[] $groups Group names
     * @param int $eventId Identifier of the event
     * @return array
     */
    private function collectAllStat($eventId, $groups)
    {
        $stat = [];
        foreach ($groups as $group) {
            $item = ['group' => $group];

            $item['users'] = \Yii::app()->getDb()->createCommand()
                ->select('COUNT(DISTINCT "UserId")')
                ->from(Visit::model()->tableName())
                ->where('"EventId" = :eventId AND "MarkId" ILIKE :group', [
                    ':eventId' => $eventId,
                    ':group' => $group.'%'
                ])
                ->queryScalar();

            $item['count'] = \Yii::app()->getDb()->createCommand()
                ->select('COUNT(*)')
                ->from(Visit::model()->tableName())
                ->where('"EventId" = :eventId AND "MarkId" ILIKE :group', [
                    ':eventId' => $eventId,
                    ':group' => $group.'%'
                ])
                ->queryScalar();

            $stat[] = $item;
        }

        return $stat;
    }

    /**
     * Generates data providers by using groups
     * @param string[] $groups Group names
     * @param int $eventId Identifier of the event
     * @return array
     */
    private function constructDataProviders($eventId, $groups)
    {
        $dataProviders = [];
        foreach ($groups as $group) {
            $dataProviders[$group] = new \CActiveDataProvider(Visit::model()->byEventId($eventId), [
                'criteria' => [
                    'condition' => '"MarkId" ILIKE :group',
                    'params' => [':group' => $group.'%']
                ],
                'sort' => [
                    'defaultOrder' => '"CreationTime" DESC'
                ],
                'pagination' => false
            ]);
        }

        return $dataProviders;
    }
}
