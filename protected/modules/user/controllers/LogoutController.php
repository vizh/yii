<?php

class LogoutController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    if (!Yii::app()->user->isGuest)
    {
      Yii::app()->user->logout();
    }
    $this->redirect(Yii::app()->createUrl('/main/default/index'));
  }
}
