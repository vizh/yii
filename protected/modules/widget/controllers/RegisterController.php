<?php
use widget\components\Controller;

use \widget\models\forms\ProductCount as ProductCountForm;

class RegisterController extends Controller
{
    protected $useBootstrap3 = true;

    protected function initResources()
    {
        \Yii::app()->getClientScript()->registerPackage('angular');
        parent::initResources();
    }

    /**
     *  Выбор кол-ва заказываемых продуктов
     */
    public function actionIndex()
    {
        $form = new ProductCountForm($this->getEvent());
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->validate()) {
                $form->pack();
                $this->redirect(['participants']);
            }
        }
        $this->render('index', ['form' => $form]);
    }

    /**
     * Регистрация пользовтелей
     */
    public function actionParticipants()
    {
        $form = new ProductCountForm($this->getEvent());
        $this->render('participants', ['form' => $form]);
    }
}