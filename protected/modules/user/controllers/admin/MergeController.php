<?php

class MergeController extends \application\components\controllers\AdminMainController
{
  public function actionIndex()
  {
    $this->setPageTitle('Объединение пользователей');

    $request = Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {

    }
    else
    {
      $this->render('init');
    }
  }


}