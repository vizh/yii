<?php

use ruvents\components\Exception;
use ruvents\models\Operator;
use user\models\User;

class UtilityController extends ruvents\components\Controller
{
    public function actionPing()
    {
        $this->setUseLog(false);
        $this->renderJson([
            'DateSignal' => date('Y-m-d H:i:s')
        ]);
    }

    public function actionOperators()
    {
        if ($this->getAccount() === null)
            throw new Exception(104);

        $operators = Operator::model()
            ->byEventId($this->getAccount()->EventId)
            ->findAll();

        $result = [];
        foreach ($operators as $operator)
            $result[] = $this->getDataBuilder()->createOperator($operator);

        $this->renderJson(['Operators' => $result]);
    }

    public function actionChanges()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId', null);

        $user = User::model()
            ->byRunetId($runetId)->find();
        
        if ($user === null)
            throw new Exception(202, $runetId);

        $logModel = \ruvents\models\DetailLog::model()
            ->byEventId($this->getAccount()->EventId)->byUserId($user->Id);
        $logModel->getDbCriteria()->order = '"t"."CreationTime" ASC';
        $logs = $logModel->findAll();

        $result = [];
        foreach ($logs as $log) {
            $result[] = $this->getDataBuilder()->createDetailLog($log);
        }

        $this->renderJson(['Changes' => $result]);
    }
}