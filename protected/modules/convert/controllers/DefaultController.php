<?php
class DefaultController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    $this->render('index');
  }
}

?>
