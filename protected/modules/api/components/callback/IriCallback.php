<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 17.05.16
 * Time: 18:15
 */

namespace api\components\callback;


class IriCallback extends Base
{
    protected function getUrlRegisterOnEvent()
    {
        return 'http://api.id.iri.center/event/callback';
    }

    public function registerOnEvent(\user\models\User $user, \event\models\Role $role)
    {
        $res = $this->sendMessage($this->getUrlRegisterOnEvent(), [$this->account->EventId, $user->RunetId,$role->Id], true);
    }

}