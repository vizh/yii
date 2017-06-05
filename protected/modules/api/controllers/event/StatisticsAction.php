<?php
namespace api\controllers\event;

use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class StatisticsAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Статистика",
     *     description="Статистика по мероприятию. Возвращает колличество участников мероприятия, сгруппированные по ролям.",
     *     samples={
     *          @Sample(lang="shell",code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/statistics'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/statistics",
     *          response=@Response(body="{
    'Roles': [
    { 'RoleId': 25, 'Name': 'Эксперт ПК', 'Priority': 72, 'Count': 32 },
    { 'RoleId': 26, 'Name': 'Видеоучастник', 'Priority': 15, 'Count': 4 }
    ],
    'Total': 36
    }"))
     * )
     */
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
