<?php

use partner\components\Controller;

class SettingsController extends Controller
{
    public function actions()
    {
        return [
            'roles' => '\partner\controllers\settings\RolesAction',
            'loyalty' => '\partner\controllers\settings\LoyaltyAction',
            'api' => '\partner\controllers\settings\ApiAction',
            'definitions' => '\partner\controllers\settings\DefinitionsAction',
            'callbacks' => '\partner\controllers\settings\CallbacksAction',
            'counter' => '\partner\controllers\settings\CounterAction'
        ];
    }
}