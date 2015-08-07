<?php
use widget\components\Controller;

use \widget\models\forms\ProductCount as ProductCountForm;

class CabinetController extends Controller
{
    protected $useBootstrap3 = true;

    protected function initResources()
    {
        \Yii::app()->getClientScript()->registerPackage('angular');
        parent::initResources();
    }

    public function actionIndex()
    {
        $form = new ProductCountForm($this->getEvent());
        $this->render('index', ['form' => $form]);
    }
}