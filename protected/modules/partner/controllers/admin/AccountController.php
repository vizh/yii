<?php

class AccountController extends \application\components\controllers\AdminMainController
{
  public function actionIndex()
  {




    $accounts = \partner\models\Account::model()->findAll(['order' => '"t".""']);

    $this->render('index');
  }
}