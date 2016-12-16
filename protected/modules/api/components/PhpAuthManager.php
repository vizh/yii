<?php
namespace api\components;

use Yii;

class PhpAuthManager extends \CPhpAuthManager
{
    public function init()
    {
        $webuser = WebUser::Instance();
        $webuser->loginUrl = null;

        // Иерархию ролей расположим в файле auth.php в директории config приложения
        if ($this->authFile === null) {
            $this->authFile = Yii::getPathOfAlias('api.auth').'.php';
        }

        parent::init();

        // Для гостей у нас и так роль по умолчанию guest.
        if (!$webuser->getIsGuest()) {
            $this->assign($webuser->getRole(), $webuser->getId());
        }
    }
}