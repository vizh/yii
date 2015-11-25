<?php
namespace application\components\controllers;

class AdminMainController extends MainController
{
    public $layout = '//layouts/admin';

    protected function initResources()
    {
        \Yii::app()->getClientScript()->registerPackage('runetid.admin');
        parent::initResources();
    }

}
