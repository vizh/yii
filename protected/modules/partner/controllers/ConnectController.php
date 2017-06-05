<?php
use partner\components\Controller;

class ConnectController extends Controller
{
    const UsersOnPage = 20;

    public function actions()
    {
        return [
            'index' => '\partner\controllers\connect\IndexAction',
            'stats' => '\partner\controllers\connect\StatsAction',
        ];
    }
}
