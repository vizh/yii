<?php
namespace api\components\callback;

use event\models\Role;
use event\models\UserData;
use user\models\User;

class AccountBu16 extends Base
{
    /**
     * @inheritDoc
     */
    protected function getUrlRegisterOnEvent()
    {
        return 'https://api.rb.ru/partnerscoregistration/?token=d2ab0561182da5001698e36f169cad62';
    }

    /**
     * @param User $user
     * @param Role $role
     */
    public function registerOnEvent(User $user, Role $role)
    {
        $data = UserData::getDefinedAttributeValues($this->account->Event, $user);
        if ($role->Id !== 64 || !isset($data['Viadeo']) || $data['Viadeo'] != 1) {
            return;
        }

        $user->refresh();
        $params = [
            'name' => $user->FirstName,
            'sname' => $user->LastName,
            'email' => $user->Email,
            'charset' => 'utf-8',
            'ip' => '127.0.0.1'
        ];

        $employment = $user->getEmploymentPrimary();
        if (!empty($employment)) {
            $params['company'] = $employment->Company->Name;
            $params['position'] = $employment->Position;
        }
        $response = $this->sendMessage($this->getUrlRegisterOnEvent(), $params);
        if ($response === null) {
            $this->log->save();
        }
    }
}