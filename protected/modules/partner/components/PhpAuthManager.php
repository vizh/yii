<?php
namespace partner\components;

class PhpAuthManager extends \CPhpAuthManager
{
    public function init()
    {
        \Yii::app()->partner->loginUrl = \Yii::app()->createUrl('/partner/auth/index');

        // Иерархию ролей расположим в файле auth.php в директории config приложения
        if ($this->authFile === null) {
            $this->authFile = \Yii::getPathOfAlias('partner.auth').'.php';
        }

        parent::init();

        // Для гостей у нас и так роль по умолчанию guest.
        if (!\Yii::app()->partner->getIsGuest()) {
            $this->assign(\Yii::app()->partner->getRole(), \Yii::app()->partner->getId());
        }
    }
}