<?php

class VisitController extends \ruvents\components\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'halls' => '\ruvents\controllers\visit\HallsAction',
            'create' => '\ruvents\controllers\visit\CreateAction',
            'creategroup' => '\ruvents\controllers\visit\CreateGroupAction',
            'list' => '\ruvents\controllers\visit\ListAction'
        ];
    }
}
