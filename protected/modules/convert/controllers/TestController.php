<?php
class TestController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    $connection = \Yii::app()->dbOld;
    $command = $connection->createCommand();
    $command->Text = 'Select * From `Users`';
    echo '123';
  }
}
