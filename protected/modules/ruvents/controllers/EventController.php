<?php

class EventController extends ruvents\components\Controller
{

    public function actions()
    {
        return [
            'info' => 'ruvents\controllers\event\InfoAction',
            'register' => 'ruvents\controllers\event\RegisterAction',
            'unregister' => 'ruvents\controllers\event\UnregisterAction',
            'roles' => 'ruvents\controllers\event\RolesAction',
            'parts' => 'ruvents\controllers\event\PartsAction',
            'badge' => 'ruvents\controllers\event\BadgeAction',
            'updatedusers' => 'ruvents\controllers\event\UpdatedUsersAction',
        ];
    }
}
