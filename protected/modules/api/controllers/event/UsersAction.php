<?php

namespace api\controllers\event;

use api\components\Action;
use api\components\builders\Builder;
use CDbCriteria;
use user\models\User;
use Yii;

class UsersAction extends Action
{
    public function run()
    {
        $request = Yii::app()->getRequest();
        $maxResults = (int)$request->getParam('MaxResults', $this->getMaxResults());
        $maxResults = min($maxResults, $this->getMaxResults());
        $pageToken = $request->getParam('PageToken', null);
        $roles = $request->getParam('RoleId');

        $command = Yii::app()->getDb()->createCommand()
            ->select('EventParticipant.UserId')->from('EventParticipant')
            ->where('"EventParticipant"."EventId" = '.$this->getEvent()->Id);

        if (!empty($roles)) {
            $command->andWhere(['in', 'EventParticipant.RoleId', $roles]);
        }

        $criteria = new CDbCriteria();

        if ($pageToken === null) {
            $criteria->limit = $maxResults;
            $criteria->offset = 0;
        } else {
            $criteria->limit = $maxResults;
            $criteria->offset = $this->getController()->parsePageToken($pageToken);
        }

        $criteria->with = [
            'Participants' => [
                'on' => '"Participants"."EventId" = :EventId',
                'params' => [
                    'EventId' => $this->getEvent()->Id,
                ],
                'together' => false,
            ],
            'Employments.Company' => ['on' => '"Employments"."Primary"', 'together' => false],
            'LinkPhones.Phone' => ['together' => false],
        ];
        $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';
        $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');

        $users = User::model()->findAll($criteria);
        $totalCount = User::model()->count($criteria);

        $result = [];
        $result['Users'] = [];

        // Билдеры по умолчанию
        $defaultBuilders = [
            Builder::USER_EVENT,
            Builder::USER_EMPLOYMENT,
            Builder::USER_ATTRIBUTES,
        ];

        // Не совсем понятно почему, но ок..
        if ($this->getAccount()->Role !== 'mobile') {
            $defaultBuilders[] = Builder::USER_CONTACTS;
        }

        // Определим какие данные будут в результате
        $builders = $request->getParam('Builders', $defaultBuilders);

        // Не совсем понятно почему, но ок..
        if ($this->getAccount()->Role !== 'mobile') {
            $builders[] = Builder::USER_CONTACTS;
        }

        $result['TotalCount'] = $totalCount;

        foreach ($users as $user) {
            $result['Users'][] = $this
                ->getDataBuilder()
                ->createUser($user, $builders);
        }

        if ($this->hasRequestParam('ArchivePhotos')) {
            $archive = \Yii::getPathOfAlias('application.runtime').'/'.uniqid().'.tar';
            $tar = new \PharData($archive);
            foreach ($users as $user) {
                $photo = $user->getPhoto()->getOriginal(true);
                if (is_file($photo)) {
                    $tar->addFile($photo, basename($photo));
                }
            }
            if (is_file($archive)){
                $tar->compress(\Phar::GZ);
                unset($tar);
                unlink($archive);
                $archive .= '.gz';
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($archive).'"');
                header('Content-Length: '.filesize($archive));
                readfile($archive);
                unlink($archive);
            }
            exit;
        }

        if (count($users) === $maxResults) {
            $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $maxResults);
        }

        $this->setResult($result);
    }
}
