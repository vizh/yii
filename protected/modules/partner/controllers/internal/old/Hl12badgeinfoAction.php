<?php
namespace partner\controllers\internal;

class Hl12badgeinfoAction extends \partner\components\Action
{
    public function run()
    {
        if (\Yii::app()->partner->getAccount()->EventId != 385) {
            return;
        }

        $start = '2012-10-22 05:00:00';
        $end = '2012-10-23 23:00:00';

        $criteria = new \CDbCriteria();
        $criteria->addCondition('t.CreationTime >= :StartTime');
        $criteria->addCondition('t.CreationTime <= :EndTime');
        $criteria->params = [
            'StartTime' => strtotime($start),
            'EndTime' => strtotime($end)
        ];
        $criteria->order = 't.CreationTime ASC';

        /** @var $participants \event\models\Participant[] */
        $participants = \event\models\Participant::model()->byEventId(385)->findAll($criteria);

        echo '<table>';
        foreach ($participants as $participant) {
            $result = [];
            echo '<tr><td>';
            $result[] = $participant->User->LastName;
            $result[] = $participant->User->FirstName;
            $result[] = $participant->User->FatherName;

            $result[] = $participant->User->EmploymentPrimary() != null ? $participant->User->EmploymentPrimary()->Company->Name : '';
            $result[] = $participant->User->Email;
            $result[] = !empty($participant->User->Phones) ? urldecode($participant->User->Phones[0]->Phone) : '';

            $result[] = $participant->Role->Name;
            $result[] = date('Y-m-d H:i:s', $participant->CreationTime);

            echo implode('</td><td>', $result);

            echo '</td></tr>';
        }
        echo '</table>';
    }
}
