<?php

use application\components\controllers\PublicMainController;

/**
 * Class StatController Shows statistics for ruvents module
 */
class StatController extends PublicMainController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'food' => 'ruvents\controllers\stat\FoodAction',
            'users-list' => 'ruvents\controllers\stat\UsersListAction',
            'ts-16-participants' => 'ruvents\controllers\stat\ParticipantsTS16Action',
        ];
    }
}
