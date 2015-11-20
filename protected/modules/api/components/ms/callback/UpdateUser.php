<?php
namespace api\components\ms\callback;

use api\components\callback\AccountMicrosoft;
use api\models\ExternalUser;
use event\models\UserData;
use user\models\User;

class UpdateUser extends AccountMicrosoft
{
    protected function getUrlRegisterOnEvent()
    {
        return 'http://events.techdays.ru/callback/userchange?provider=RUNET';
    }

    public function registerOnEvent(User $user)
    {
        $url = $this->getUrlRegisterOnEvent();
        $externalUser = ExternalUser::model()->byUserId($user->Id)->byAccountId($this->account->Id)->find();
        if ($externalUser === null) {
            $this->logError(3001, [$user->Id]);
            return;
        }

        $data = new \stdClass();
        $data->ApiKey = $this->account->Key;
        $data->ExternalId = $externalUser->ExternalId;

        $data->FirstName = $user->FirstName;
        $data->LastName = $user->LastName;
        $data->FatherName = $user->FatherName;
        $data->Email = $user->Email;

        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $employment->refresh();
            $data->Company = $employment->Company->Name;
            $data->Position = $employment->Position;
        }
        $data->Phone = $user->PrimaryPhone;
        foreach (UserData::getDefinedAttributeValues($this->account->Event, $user) as $name => $value) {
            $data->$name = $value;
        }
        $params = [
            'UserData' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ];
        $resultJson = $this->sendMessage($url, $params, true);
        $result = json_decode($resultJson);

        if (!isset($result->Success) || !$result->Success) {
            $this->log->ErrorCode = 3002;
            $this->log->ErrorMessage = $this->getErrorMessage(3002);
            $this->log->save();
        }
    }
}