<?php

namespace application\hacks\forinnovations16;

use api\models\Account;
use application\models\translation\ActiveRecord;
use event\models\Event;
use event\models\UserData;
use user\models\User;
use Yii;

class Builder extends \api\components\builders\Builder
{
    protected function createBaseUser($user)
    {
        $this->applyLocale($user);

        $this->user = new \stdClass();

        $this->user->RunetId = $user->RunetId;
        $this->user->LastName = $user->LastName;
        $this->user->FirstName = $user->FirstName;
        $this->user->FatherName = $user->FatherName;
        $this->user->Gender = $user->Gender;
        $this->user->FullName = $user->getFullName();

        $this->user->Photo = new \stdClass();
        $this->user->Photo->Small = 'http://'.RUNETID_HOST.$user->getPhoto()->get50px();;
        $this->user->Photo->Medium = 'http://'.RUNETID_HOST.$user->getPhoto()->get90px();
        $this->user->Photo->Large = 'http://'.RUNETID_HOST.$user->getPhoto()->get200px();
        $this->user->Photo->Original = 'http://'.RUNETID_HOST.$user->getPhoto()->getOriginal();

        $this->user->Locales = $this->getActiveRecordLocales($user);

        return $this->user;
    }

    protected function buildUserAttributes($user)
    {
        if ($this->account->Role !== Account::ROLE_MOBILE) {
            parent::buildUserAttributes($user);
        }

        UserData::setEnableRawValues();
        $this->user->AttributesRaw = (object)UserData::getDefinedAttributeValues($this->account->Event, $user);
        UserData::setDisableRawValues();

        if ($this->account->Role === Account::ROLE_MOBILE) {
            unset(
                $this->user->AttributesRaw->passportCountry,
                $this->user->AttributesRaw->passportSeries,
                $this->user->AttributesRaw->passportNumber,
                $this->user->AttributesRaw->needsVisaSupport,
                $this->user->AttributesRaw->studak,
                $this->user->AttributesRaw->activity_sphere,
                $this->user->AttributesRaw->business_size,
                $this->user->AttributesRaw->how_learned,
                $this->user->AttributesRaw->industry,
                $this->user->AttributesRaw->position_category,
                $this->user->AttributesRaw->responsibility_area,
                $this->user->AttributesRaw->staff_number,
                $this->user->AttributesRaw->previous_forums,
                $this->user->AttributesRaw->articles,
                $this->user->AttributesRaw->position_journals,
                $this->user->AttributesRaw->fsoStatus,
                $this->user->AttributesRaw->biography,
                $this->user->AttributesRaw->statusOffline
            );
        }

        return $this->user;
    }

    protected function buildUserContacts($user)
    {
        $this->user->Email = $user->Email;
        $this->user->Phone = $user->getPhone(false);
        $this->user->PhoneFormatted = $user->getPhone();

        $this->user->Phones = [];
        foreach ($user->LinkPhones as $link) {
            $this->user->Phones[] = (string)$link->Phone;
        }

        return $this->user;
    }

    protected function buildUserEvent($user)
    {
        $user = parent::buildUserEvent($user);

        if ($this->account->Role !== Account::ROLE_MOBILE) {
            $this->user->Paid = in_array($this->user->Status->RoleId, [347, 355, 354, 352, 363, 338, 362, 357, 340]);
            $this->user->Confirmed = in_array($this->user->Status->RoleId, [401, 402, 368, 347, 355, 354, 352, 363, 338, 362, 400, 403, 344, 357, 358, 340]);
        }

        return $user;
    }

    protected function buildUserEmployment($user)
    {
        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $this->user->Work = new \stdClass();
            $this->user->Work->Position = $employment->Position;
            $this->user->Work->Company = $this->createEmploymentCompany($employment->Company);
            $this->user->Work->StartYear = $employment->StartYear;
            $this->user->Work->StartMonth = $employment->StartMonth;
            $this->user->Work->EndYear = $employment->EndYear;
            $this->user->Work->EndMonth = $employment->EndMonth;

            $this->user->Locales = array_merge_recursive(
                $this->user->Locales,
                $this->getActiveRecordLocales($employment->Company, 'WorkCompany')
            );

            $position = $this->user->AttributesRaw->position;
            if (!empty($position) && is_array($position)) {
                foreach ($position as $lang => $value) {
                    if (isset($this->user->Locales[$lang])) {
                        $this->user->Locales[$lang]['WorkPositionName'] = $value;
                    }
                }
            }
        }

        return $this->user;
    }

    public function buildEventStatistics(Event $event)
    {
        $event = parent::buildEventStatistics($event);

        $this->event->Statistics['Participants']['MobileCount']
            = array_sum(array_intersect_key($this->event->Statistics['Participants']['ByRole'], array_flip([349, 368, 347, 355, 354, 352, 363, 338, 362, 344, 357, 358, 340])));

        if ($runetid = Yii::app()->getRequest()->getParam('RunetId')) {
            $user = User::model()
                ->byRunetId($runetid)
                ->find();

            if ($user !== null) {
                $this->event->Statistics['Meetings'] = [
                    'TotalCount' => Yii::app()->getDb()->createCommand('
                        SELECT
                          count(*)
                        FROM "ConnectMeeting"
                          LEFT JOIN "ConnectMeetingLinkUser" ON "ConnectMeeting"."Id" = "ConnectMeetingLinkUser"."MeetingId"
                        WHERE "ConnectMeetingLinkUser"."Status" = 2
                          AND ("CreatorId" = :UserId OR "ConnectMeetingLinkUser"."UserId" = :UserId);
                    ')->queryScalar([':UserId' => $user->Id])
                ];
            }
        }

        return $event;
    }

    protected function getActiveRecordLocales(ActiveRecord $model, $prefix = '')
    {
        $locales = [];

        foreach (Yii::app()->params['Languages'] as $lang) {
            $model->setLocale($lang);
            $localeStd = [];
            foreach ($model->getTranslationFields() as $key) {
                $localeStd[$prefix.$key] = $model->{$key};
            }
            $locales[$lang] = $localeStd;
        }
        $model->resetLocale();

        return $locales;
    }
}
