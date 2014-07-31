<?php
use application\components\controllers\PublicMainController;

/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 29.04.14
 * Time: 16:33
 */

class TestController extends PublicMainController
{
  public function actionIndex()
  {
    $this->render('index');
  }
}