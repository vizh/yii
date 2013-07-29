<?php

class OneuseController extends \application\components\controllers\AdminMainController
{
  public function actionClearphdays()
  {
    $eventId = 497;

    $command = \Yii::app()->getDb()->createCommand()
        ->select('EventParticipant.UserId')->from('EventParticipant')
        ->where('"EventParticipant"."EventId" = '.$eventId);

    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');
    $criteria->limit = 200;

    $users = \user\models\User::model()->findAll($criteria);


    $counterExist = 0;
    $counterDelete = 0;
    foreach ($users as $user)
    {
      $flag = false;
      foreach ($user->Participants as $participant)
      {
        if ($participant->EventId == $eventId)
        {
          $participant->delete();
        }
        else
        {
          $flag = true;
        }
      }
      if (!$flag)
      {
        $user->Visible = false;
        $user->save();
        $counterDelete++;
      }
      else
      {
        $counterExist++;
      }
    }

    echo 'Оставлено: ' . $counterExist . ' Удалено: ' . $counterDelete;

  }
}