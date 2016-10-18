<?php

use application\hacks\AbstractHack;
use \partner\components\Controller;

class RuventsController extends Controller
{
    public function actions()
    {
        return AbstractHack::getByEvent($this->getEvent())->onPartnerRegisterControllerActions([
            'index' => '\partner\controllers\ruvents\IndexAction',
            'operator' => '\partner\controllers\ruvents\OperatorAction',
            'mobile' => '\partner\controllers\ruvents\MobileAction',
            'csvinfo' => '\partner\controllers\ruvents\CsvinfoAction',
            'userlog' => '\partner\controllers\ruvents\UserlogAction',
            'print' => '\partner\controllers\ruvents\PrintAction',
            'settings' => '\partner\controllers\ruvents\SettingsAction',
            'settingsPush' => '\partner\controllers\ruvents\SettingsPushAction'
        ]);
    }
}