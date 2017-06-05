<?php

use api\models\Account;
use api\models\ExternalUser;
use application\components\controllers\PublicMainController;
use event\models\Participant;
use user\models\User;

class InfoController extends PublicMainController
{
    public function actionAppday14($time = '10:00')
    {
        $testId = 16;
        $eventId = 1369;
        $date = '2014-11-21 ';
        $times = [
            '10:00' => '11:00',
            '11:00' => '12:00',
            '12:00' => '13:00',
            '13:00' => '14:00',
            '14:00' => '16:00',
            '16:00' => '17:00',
            '17:00' => '18:00',
            '18:00' => '19:00'
        ];

        if (!isset($times[$time])) {
            $this->redirect($this->createUrl('/main/info/appday14'));
        }

        $command = Yii::app()->getDb()->createCommand('SELECT "UserId" FROM "CompetenceResult" WHERE "TestId" = :TestId AND "Finished"');
        $command->bindValue('TestId', $testId);
        $userIds = $command->queryColumn();

        $sql = 'SELECT t."UserId" FROM "EventSectionVote" t
            LEFT JOIN "EventSection" ON "EventSection"."Id" = t."SectionId"
            WHERE "UserId" IN (%S) AND "EventSection"."EventId" = :EventId
            AND :StartTime < t."CreationTime" AND t."CreationTime" < :EndTime
            AND (t."SpeakerSkill" IS NOT NULL OR t."ReportInteresting" IS NOT NULL)';
        $command = Yii::app()->getDb()->createCommand(sprintf($sql, implode(',', $userIds)));
        $command->bindValue('EventId', $eventId);
        $command->bindValue('StartTime', $date.$time.':00');
        $command->bindValue('EndTime', $date.$times[$time].':00');
        $userIds = $command->queryColumn();

        $criteria = new CDbCriteria();
        $criteria->addInCondition('t."Id"', $userIds);
        $criteria->order = 't."RunetId"';
        $users = User::model()->findAll($criteria);

        $this->render('appday14', [
            'times' => $times,
            'time' => $time,
            'users' => $users
        ]);
    }

    public function actionAppdaycodes()
    {
        $eventId = 1369;
        $api = Account::model()->byEventId($eventId)->find();

        $criteria = new CDbCriteria();
        $criteria->addCondition('t."RoleId" != 24');
        $criteria->with = ['User' => ['together' => true]];
        $criteria->order = '"User"."LastName", "User"."FirstName"';

        $participants = Participant::model()->byEventId($eventId)->findAll($criteria);

        $externalUsers = ExternalUser::model()->byAccountId($api->Id)->findAll(['index' => 'UserId']);

        $this->render('appdaycodes', ['participants' => $participants, 'externalUsers' => $externalUsers]);
    }
} 