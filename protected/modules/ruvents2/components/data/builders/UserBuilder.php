<?php

namespace ruvents2\components\data\builders;

use api\models\Account;
use api\models\ExternalUser;
use application\components\helpers\ArrayHelper;
use event\models\Event;
use ruvents2\components\data\AbstractBuilder;
use user\models\User;
use Yii;

/**
 * Class UserBuilder
 * @package ruvents2\components\data
 *
 * @method static UserBuilder create()
 * @method UserBuilder setEvent(Event $event)
 * @method UserBuilder setApiAccount(Account $account)
 * @method UserBuilder setUser(User $user)
 */
class UserBuilder extends AbstractBuilder
{
    /** @var User */
    protected $user;

    /** @var Event */
    protected $event;

    /** @var Account */
    protected $apiAccount;

    protected function buildData()
    {
        $this->stash(ArrayHelper::toArray($this->user, [
            'user\models\User' => [
                'Id' => 'RunetId',
                'CreationTime',
                'Email',
                'Birthday'
            ]
        ]));

        $this->setExternalId();
        $this->setLocales();
        $this->setStatuses();
        $this->setPhone();
        $this->setRegistrationTime();

        $this->stash('Photo', 'http://'.RUNETID_HOST.$this->user->getPhoto()->get200px());
        $this->stash('BadgesCount', count($this->user->Badges));
    }

    private function setExternalId()
    {
        if ($this->apiAccount == null) {
            return;
        }

        if (ExternalUser::model()->byAccountId($this->apiAccount->Id)->exists() === false) {
            return;
        }

        if (empty($this->user->ExternalAccounts)) {
            return;
        }

        $this->stash('ExternalId', $this->user->ExternalAccounts[0]->ExternalId);
    }

    private function setLocales()
    {
        $localesData = [];
        $employment = $this->user->getEmploymentPrimary();

        foreach (Yii::app()->params['Languages'] as $lang) {
            $this->user->setLocale($lang);

            $localeData = ArrayHelper::toArray($this->user, [
                'user\models\User' => [
                    'LastName',
                    'FirstName',
                    'FatherName'
                ]
            ]);

            if ($employment !== null) {
                $employment->Company->setLocale($lang);
                $localeData['Company'] = $employment->Company->Name;
            }

            $localesData[$lang] = $localeData;
        }

        $this->stash('Locales', $localesData);

        if ($employment !== null) {
            $this->stash('Position', $employment->Position);
        }
    }

    private function setPhone()
    {
        $phone = null;

        if (!empty($this->user->PrimaryPhone)) {
            $phone = $this->user->PrimaryPhone;
        } else if ($this->user->getContactPhone() !== null) {
            $data['Phone'] = $this->user->getContactPhone()->__toString();
        }

        if ($phone !== null) {
            $this->stash('Phone', $phone);
        }
    }

    private function setStatuses()
    {
        $statuses = [];

        foreach ($this->user->Participants as $participant) {
            $statuses[] = [
                'StatusId' => $participant->RoleId,
                'PartId' => $participant->PartId
            ];
        }

        $this->stash('Statuses', $statuses);
    }

    private function setRegistrationTime()
    {
        $time = null;

        foreach ($this->user->Participants as $participant) {
            if ($time === null || $time > $participant->UpdateTime) {
                $time = $participant->UpdateTime;
            }
        }

        $this->stash('RegistrationTime', $time);
    }
}