<?php
class ServiceController extends \application\components\controllers\PublicMainController
{
  public function actionAbout()
  {
    $this->render('about');
  }
}
