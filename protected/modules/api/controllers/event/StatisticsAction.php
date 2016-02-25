<?php
namespace api\controllers\event;

class StatisticsAction extends \api\components\Action
{
    public function run()
    {
        $result = [];
        if (count($this->getEvent()->Parts) == 0) {
            $criteria = new \CDbCriteria();
            $criteria->select = '"t"."RoleId", Count(*) as "CountForCriteria"';
            $criteria->condition = '"t"."EventId" = :EventId';
            $criteria->params['EventId'] = $this->getEvent()->Id;
            $criteria->group = '"t"."RoleId"';


            $participants = \event\models\Participant::model()->findAll($criteria);
            $statistics['Total'] = 0;
            $total = 0;

            foreach ($participants as $participant) {
                $resultRole = $this->getDataBuilder()->createRole($participant->Role);
                $resultRole->Count = $participant->CountForCriteria;
                $result['Roles'][] = $resultRole;
                $total += $participant->CountForCriteria;
            }

            $result['Total'] = $total;
        } else {
            $command = \Yii::app()->getDb()->createCommand();
            $command->select('count(DISTINCT "UserId")')->from('EventParticipant')->where('"EventId" = :EventId');
            $command->bindValue('EventId', $this->getEvent()->Id);
            $result['Total'] = $command->queryScalar();
        }

        $this->setResult($result);
    }
}
