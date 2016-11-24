<?php

use application\components\console\BaseConsoleCommand;
use event\models\Participant;
use connect\models\Meeting;

class ConnectCommand extends BaseConsoleCommand
{
    public function actionReport($event_id)
    {
        $meetings = Meeting::model()
            ->with(['Place', 'UserLinks', 'UserLinks.User', 'Creator'])
            ->findAll('"Place"."EventId" = :event_id', [':event_id' => $event_id]);

        $result = [];
        $result[] = [
            'Дата приглашения',
            'Дата встречи',
            'ФИО пригласившего',
            'Роль пригласившего',
            'ФИО приглашенного',
            'Роль приглашенного',
            'Статус'
        ];
        foreach ($meetings as $meeting) {
            $result[] = [
                $meeting->CreateTime,
                $meeting->Date,

                $meeting->Creator->getFullName(),
                Participant::model()->byEventId($meeting->Place->EventId)->byUserId($meeting->CreatorId)->find()->Role->Title,

                $meeting->UserLinks[0]->User->getFullName(),
                Participant::model()->byEventId($meeting->Place->EventId)->byUserId($meeting->UserLinks[0]->UserId)->find()->Role->Title,

                $meeting->getStatusText(),
            ];
        }

        $file = fopen(Yii::getPathOfAlias('application.runtime').'/connect.csv', 'w+');
        foreach ($result as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }

}