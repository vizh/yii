<?php
class UtilityController extends ruvents\components\Controller
{
  public function actionPing()
  {
    $result = new stdClass();
    $result->Success = true;
    echo json_encode($result);
  }

  public function actionChanges()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId', null);

    $user = \user\models\User::model()->byRunetId($runetId);
    if ($user === null)
    {
      throw new \ruvents\components\Exception(202, array($runetId));
    }

    $logModel = \ruvents\models\DetailLog::model()
      ->byEventId($this->Operator()->EventId)->byUserId($user->UserId);
    $logModel->getDbCriteria()->order = 't.CreationTime ASC';
    $logs = $logModel->findAll();

    $result = array();
    foreach ($logs as $log)
    {
      $result[] = $this->DataBuilder()->CreateDetailLog($log);
    }

    echo json_encode(array('Changes' => $result));
  }
}