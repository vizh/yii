<?php
namespace partner\controllers\ruvents;

class UserlogAction extends \partner\components\Action
{
    private $user;

    public function run($runetId, $backUrl = null)
    {
        $this->user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($this->user == null) {
            throw new \CHttpException(404);
        }

        $isParticipant = \event\models\Participant::model()->byEventId($this->getEvent()->Id)->byUserId($this->user->Id)->exists();
        if (!$isParticipant) {
            throw new \CHttpException(404);
        }

        $this->getController()->render('userlog', ['user' => $this->user, 'logs' => $this->getLogs(), 'backUrl' => $backUrl]);
    }

    /**
     * @return \partner\models\RuventsUserLogData[]
     */
    private function getLogs()
    {
        $logs = $this->getBadgesLog();
        $logs = array_merge($logs, $this->getDetailLog());
        usort($logs, function ($a, $b) {
            if ($a->CreationTime == $b->CreationTime) {
                return 0;
            }
            return ($a->CreationTime < $b->CreationTime) ? -1 : 1;
        });
        return $logs;
    }

    /**
     * @return \partner\models\RuventsUserLogData[]
     */
    private function getBadgesLog()
    {
        $logs = [];
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."CreationTime" ASC';
        $criteria->with = ['Operator', 'User'];
        $badges = \ruvents\models\Badge::model()->byUserId($this->user->Id)->byEventId($this->getEvent()->Id)->findAll($criteria);
        foreach ($badges as $badge) {
            $log = new \partner\models\RuventsUserLogData();
            $log->Operator = $badge->Operator;
            $log->CreationTime = $badge->CreationTime;
            $log->User = $badge->User;
            $log->Action = 'badge';
            $log->appendData('Role', $badge->RoleId);
            $logs[] = $log;
        }
        return $logs;
    }

    /**
     * @return \partner\models\RuventsUserLogData[]
     */
    private function getDetailLog()
    {
        $logs = [];
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."CreationTime" ASC';
        $criteria->with = ['Operator', 'User'];
        $detailLogs = \ruvents\models\DetailLog::model()->byUserId($this->user->Id)->byEventId($this->getEvent()->Id)->findAll();
        foreach ($detailLogs as $detailLog) {
            $log = new \partner\models\RuventsUserLogData();
            $log->Operator = $detailLog->Operator;
            $log->CreationTime = $detailLog->CreationTime;
            $log->User = $detailLog->User;
            $log->Action = $detailLog->Controller.'.'.$detailLog->Action;
            $changes = $detailLog->getChangeMessages();
            foreach ($changes as $change) {
                $log->appendData($change->key, $change->from, $change->to);
            }
            $logs[] = $log;
        }
        return $logs;
    }
} 