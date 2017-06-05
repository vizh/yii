<?php
namespace ruvents\controllers\stat;

use event\models\Event;

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

        if (!isset($groups[$group])) {
            throw new \CHttpException(404);
        }

        $groupName = $groups[$group];

        if ($eventId == Event::TS16) {
            $this->controller->render('food-users-list-ts16', [
                'dataProvider' => $this->constructUsersListDataProvider($eventId, $groupName),
                'groupName' => $groupName,
                'eventId' => $eventId
            ]);
        } else if ($eventId == Event::AR17) {
            $this->controller->render('food-users-list-ar17', [
                'dataProvider' => $this->constructUsersListDataProvider($eventId, $groupName),
                'groupName' => $groupName,
                'eventId' => $eventId
            ]);
        } else {
            $this->controller->render('users-list', [
                'dataProvider' => $this->constructUsersListDataProvider($eventId, $groupName),
                'groupName' => $groupName,
                'eventId' => $eventId
            ]);
        }
    }
}
