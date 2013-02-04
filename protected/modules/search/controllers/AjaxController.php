<?php
class AjaxController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    $search = new \search\models\Search();
    $search->appendModel(\user\models\User::model())
      ->appendModel(\company\models\Company::model());
    $found = $search->findAll('Коротов');
    print_r($found);
  }
}
