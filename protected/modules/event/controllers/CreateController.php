<?php
class CreateController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    $form = new \event\models\forms\Create();
    $this->render('index', array('form' => $form));
  }
}
