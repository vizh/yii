<?php
use application\components\controllers\AdminMainController;
use user\models\search\admin\Contacts;

class MainController extends AdminMainController
{
    public function actionContacts()
    {
        $search = new Contacts();
        $this->render('contacts', ['search' => $search]);
    }
}