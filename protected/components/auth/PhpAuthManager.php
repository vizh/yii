<?php
namespace application\components\auth;

class PhpAuthManager extends \CPhpAuthManager
{
  public function init(){
    \Yii::app()->user->loginUrl = null;

    // Иерархию ролей расположим в файле auth.php в директории config приложения
    if($this->authFile === null)
    {
      $this->authFile = \Yii::getPathOfAlias('application.components.auth.auth').'.php';
    }

    parent::init();

    // Для гостей у нас и так роль по умолчанию guest.
    if(!\Yii::app()->user->getIsGuest())
    {
      /** @var $group \application\models\admin\Group */
      $group = \application\models\admin\Group::model()
          ->byUserId(\Yii::app()->user->getCurrentUser()->Id)
          ->with('Roles')->find();
      if ($group !== null)
      {
        foreach ($group->Roles as $role)
        {
          $this->assign($role->Code, \Yii::app()->user->getId());
        }
      }
    }
  }
}
