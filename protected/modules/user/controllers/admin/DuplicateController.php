<?php

use user\models\User;

class DuplicateController extends \application\components\controllers\AdminMainController
{
    public function actionIndex($last_id = 0)
    {
        $data = [];
        $ids = [];

        while (count($data) < 10) {
            $query = User::model();
            $query->dbCriteria
                ->addNotInCondition('"t"."Id"', $ids)
                ->mergeWith([
                    'select' => '"t".*, count("EventParticipant"."EventId") as "EventCount"',
                    'join' => 'inner join "EventParticipant" on "EventParticipant"."UserId" = "t"."Id"',
                    'condition' => '"t"."Email" is not null and "t"."Email" <> \'\'',
                    'group' => '"t"."Id"',
                    'order' => '"EventCount" desc'
                ]);
            $user = $query->find();
            if (!$user) {
                break;
            }
            $ids[] = $user->Id;

            $duplicates = $query->findAll([
                'select' => '"t".*, count("EventParticipant"."EventId") as "EventCount"',
                'join' => 'inner join "EventParticipant" on "EventParticipant"."UserId" = "t"."Id"',
                'condition' => '"t"."Email" = :email and "t"."Id" <> :id',
                'group' => '"t"."Id"',
                'params' => [
                    ':email' => $user->Email,
                    ':id' => $user->Id
                ]
            ]);

            if (count($duplicates) > 0) {
                $data[] = [
                    'user' => $user,
                    'duplicates' => $duplicates
                ];
                $ids = array_merge($ids, array_map(function ($duplicate) {
                    return $duplicate->Id;
                }, $duplicates));
            }
        }

        $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionMerge()
    {
        $user_id = Yii::app()->request->getPost('user_id');
        $duplicate_id = Yii::app()->request->getPost('duplicate_id');

        $tables_to_update = [
            'AdminGroupUser' => 'UserId',
            'ApiExternalUser' => 'UserId',
            'CommissionProjectUser' => 'UserId',
            'CommissionUser' => 'UserId',
            'CompanyLinkModerator' => 'UserId',
            'CompetenceResult' => 'UserId',
            'ConnectMeeting' => 'CreatorId',
            'ConnectMeetingLinkUser' => 'UserId',
            'EventInvite' => 'UserId',
            'EventInviteRequest' => ['OwnerUserId', 'SenderUserId'],
            'EventParticipant' => 'UserId',
            'EventParticipantLog' => ['UserId', 'EditorId'],
            'EventSectionFavorite' => 'UserId',
            'EventSectionLinkUser' => 'UserId',
            'EventSectionUserVisit' => 'UserId',
            'EventSectionVote' => 'UserId',
            'EventUserAdditionalAttribute' => 'UserId',
            'EventUserData' => ['UserId', 'CreatorId'],
            'IriUser' => 'UserId',
            'Link' => ['UserId', 'OwnerId'],
            'MailTemplate' => 'LastUserId',
            'OAuthAccessToken' => 'UserId',
            'OAuthPermission' => 'UserId',
            'OAuthSocial' => 'UserId',
            'PartnerCallbackUser' => 'UserId',
            'PartnerExport' => 'UserId',
            'PayCoupon' => 'OwnerId',
            'PayCouponActivation' => 'UserId',
            'PayOrder' => 'PayerId',
            'PayOrderItem' => ['PayerId', 'OwnerId', 'ChangedOwnerId'],
            'PayProductCheck' => 'UserId',
            'PayProductUserAccess' => 'UserId',
            'RaecBrief' => 'UserId',
            'RaecBriefLinkUser' => 'UserId',
            'RaecCompanyUser' => 'UserId',
            'RuventsBadge' => 'UserId',
            'RuventsDetailLog' => 'UserId',
            'RuventsVisit' => 'UserId',
            'User' => 'MergeUserId',
            'UserDevice' => 'UserId',
            'UserDocument' => 'UserId',
            'UserEducation' => 'UserId',
            'UserEmployment' => 'UserId',
            'UserLinkAddress' => 'UserId',
            'UserLinkEmail' => 'UserId',
            'UserLinkEventPurpose' => 'UserId',
            'UserLinkPhone' => 'UserId',
            'UserLinkProfessionalInterest' => 'UserId',
            'UserLinkServiceAccount' => 'UserId',
            'UserLinkSite' => 'UserId',
            'UserLoyaltyProgram' => 'UserId',
            'UserReferral' => ['UserId', 'ReferrerUserId'],
//            'UserSettings' => 'UserId',
            'UserUnsubscribeEventMail' => 'UserId'
        ];

        $db = Yii::app()->db;
        $tr = $db->beginTransaction();
        foreach ($tables_to_update as $table => $columns) {
            if (is_string($columns)) {
                $columns = [$columns];
            }
            foreach ($columns as $column) {
                $db->createCommand()->update($table, [$column => $user_id], '"'.$column.'" = :id', [':id' => $duplicate_id]);
            }
        }
        $db->createCommand()->update('Translation', ['ResourceId' => $user_id], '"ResourceName" = \'User\' and "ResourceId" = :id', [':id' => $duplicate_id]);
        $db->createCommand('DELETE FROM "User" WHERE "Id" = :id')->execute([':id' => $duplicate_id]);
        $tr->commit();
        $this->redirect(['index']);
    }
}