<?php
namespace api\components;

class PhpAuthManager extends \CPhpAuthManager
{
  public function init(){
    WebUser::Instance()->loginUrl = null;

    // Иерархию ролей расположим в файле auth.php в директории config приложения
    if($this->authFile === null)
    {
      $this->authFile = \Yii::getPathOfAlias('api.auth').'.php';
    }

    parent::init();

    // Для гостей у нас и так роль по умолчанию guest.
    if(!WebUser::Instance()->getIsGuest())
    {
      $this->assign(WebUser::Instance()->getRole(), WebUser::Instance()->getId());
    }
  }
}