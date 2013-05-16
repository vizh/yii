<?php
class UtilityController extends ruvents\components\Controller
{
  public function actionPing()
  {
    $this->renderJson([
      'DateSignal' => date('Y-m-d H:i:s')
    ]);
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
      ->byEventId($this->getOperator()->EventId)->byUserId($user->Id);
    $logModel->getDbCriteria()->order = '"t"."CreationTime" ASC';
    $logs = $logModel->findAll();

    $result = array();
    foreach ($logs as $log)
    {
      $result[] = $this->getDataBuilder()->createDetailLog($log);
    }

    echo json_encode(array('Changes' => $result));
  }
}