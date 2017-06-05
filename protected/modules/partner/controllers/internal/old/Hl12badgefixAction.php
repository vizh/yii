<?php
namespace partner\controllers\internal;

class Hl12badgefixAction extends \partner\components\Action
{
    const Path = '/files/';
    const FileName = 'event385-badges.csv';

    public function run()
    {
        if (\Yii::app()->partner->getAccount()->EventId != 385) {
            return;
        }

        $fieldMap = [
            'RocId' => 0,
            'LastName' => 1,
            'FirstName' => 2,
            'Company' => 3,
            'BadgeCount' => 4
        ];

        $time = strtotime('2012-10-22 00:00:00');

        $parser = new \application\components\parsing\CsvParser($_SERVER['DOCUMENT_ROOT'].self::Path.self::FileName);

        $parser->SetInEncoding('utf-8');

        $results = $parser->Parse($fieldMap, true);

        foreach ($results as $info) {
            $criteria = \user\models\User::GetSearchCriteria($info->LastName.' '.$info->FirstName);
            $criteria->addCondition('t.Email LIKE :Email OR t.CreationTime > :Time');
            $criteria->params[':Email'] = \Utils::PrepareStringForLike('hl12+').'%';
            $criteria->params[':Time'] = $time;

            $lostBadges = 0;

            /** @var $users \user\models\User[] */
            $users = \user\models\User::model()->with(['Settings'])->findAll($criteria);
            if (sizeof($users) == 1) {
                $badge = \ruvents\models\Badge::model()->byEventId(\Yii::app()->partner->getAccount()->EventId)->byUserId($users[0]->UserId)->find();
                if (empty($badge)) {
                    $lostBadges++;
                }
            } elseif (sizeof($users) > 1) {
                echo '<br><br>';
                echo 'find many ('.sizeof($users).') users <br>';

                foreach ($users as $user) {
                    $empl = $user->EmploymentPrimary();
                    echo $user->UserId.' '.$user->RocId.' '.$user->LastName.' '.$user->FirstName.' '.(!empty($empl) ? $empl->Company->Name : '').'<br>';
                }
                echo '<br><br><br>';
            } else {
                echo 'NONE by: '.$info->LastName.' '.$info->FirstName.'<br>';
            }
        }

        echo '<br><br><br> LOST BADGES: '.$lostBadges;
    }
}
