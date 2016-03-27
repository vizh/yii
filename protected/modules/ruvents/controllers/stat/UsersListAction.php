<?php
namespace ruvents\controllers\stat;

use ruvents\models\Visit;

/**
 * Class UsersListAction Shows list of the users for current group
 */
class UsersListAction extends StatAction
{
    /**
     * @inheritdoc
     * @param int $eventId Identifier of the event
     * @throws \CHttpException
     */
    public function run($eventId, $group)
    {
        $this->controller->layout = '//layouts/clear';

        $groups = $this->fetchUniqueGroups($eventId);

        if (!isset($groups[$group]))
            throw new \CHttpException(404);

        $groupName = $groups[$group];

        $this->controller->render('users-list', [
            'dataProvider' => $this->constructDataProvider($eventId, $groupName),
            'groupName' => $groupName
        ]);
    }

    /**
     * Generates data providers by using groups
     * @param int $eventId Identifier of the event
     * @param string $group Group name
     * @return array
     */
    private function constructDataProvider($eventId, $group)
    {
        return new \CActiveDataProvider(Visit::model()->byEventId($eventId), [
            'criteria' => [
                'condition' => 't."MarkId" ILIKE :group',
                'params' => [':group' => $group . '%'],
                'with' => [
                    'UserData'
                ]
            ],
            'sort' => [
                'defaultOrder' => 't."CreationTime" DESC'
            ],
            'pagination' => false
        ]);
    }
}
