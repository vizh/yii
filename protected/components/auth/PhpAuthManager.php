<?php

namespace application\components\auth;

use application\models\admin\Group;
use Yii;

class PhpAuthManager extends \CPhpAuthManager
{
    public function init()
    {
        // Иерархию ролей расположим в файле auth.php в директории config приложения
        if ($this->authFile === null) {
            $this->authFile = Yii::getPathOfAlias('application.components.auth.auth').'.php';
        }

        parent::init();

        // Для гостей у нас и так роль по умолчанию guest.
        $user = Yii::app()->getUser();
        if (false === $user->getIsGuest()) {
            $groups = Group::model()
                ->byUserId($user->getCurrentUser()->Id)
                ->with('Roles')
                ->findAll();

            if (false === empty($groups)) {
                $userid = $user->getId();
                foreach ($groups as $group) {
                    foreach ($group->Roles as $role) {
                        $this->assign($role->Code, $userid);
                    }
                }
            }
        }
    }
}
