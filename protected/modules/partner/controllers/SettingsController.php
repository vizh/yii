<?php
use \partner\components\Controller;

class SettingsController extends Controller
{
    public function actions()
    {
        return [
            'roles' => '\partner\controllers\settings\RolesAction',
            'loyalty' => '\partner\controllers\settings\LoyaltyAction'
        ];
    }
} 