<?php
namespace partner\controllers\connect;

use application\components\web\ArrayDataProvider;
use connect\models\MeetingLinkUser;

class StatsAction extends \partner\components\Action
{
    public function run()
    {
        $this->getController()->render('stats', [
            'stats' => new ArrayDataProvider($this->getStats(), ['keyField' => 'date']),
            'event' => $this->getEvent(),
        ]);
    }

    public function getStats()
    {
        $stats = [];
        $date = new \DateTime(date('Y-m-d', $this->getEvent()->getTimeStampStartDate()));
        $command = \Yii::app()->db->createCommand('
            select count(*)
            from "ConnectMeeting"
            inner join "ConnectMeetingLinkUser" on "ConnectMeetingLinkUser"."MeetingId" = "ConnectMeeting"."Id"
            where "ConnectMeeting"."Type" = 1 and date("Date") = :date and "ConnectMeetingLinkUser"."Status" = :status;
        ');

        $i=0;
        while ($date->getTimestamp() <= $this->getEvent()->getTimeStampEndDate()){
            $command->bindValue(':date', $date->format('Y-m-d'));
            $stats[$i]['date'] = $date->format('d.m.Y');
            $stats[$i]['sent'] = $command->bindValue(':status', MeetingLinkUser::STATUS_SENT)->queryScalar();
            $stats[$i]['accepted'] = $command->bindValue(':status', MeetingLinkUser::STATUS_ACCEPTED)->queryScalar();
            $stats[$i]['declined'] = $command->bindValue(':status', MeetingLinkUser::STATUS_DECLINED)->queryScalar();
            $stats[$i]['cancelled'] = $command->bindValue(':status', MeetingLinkUser::STATUS_CANCELLED)->queryScalar();
            $date->modify('+1day');
            $i++;
        }

        return $stats;
    }
}