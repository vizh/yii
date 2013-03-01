<?php

class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionList()
  {
    $this->render('list');
  }
}
