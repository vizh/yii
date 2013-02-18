<?php

class LogoutController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    if (!Yii::app()->user->isGuest)
    {
      Yii::app()->user->logout();
    }
    $this->redirect('/main/default/index');
  }
}
