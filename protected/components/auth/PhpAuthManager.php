<?php
namespace application\components\auth;

class PhpAuthManager extends \CPhpAuthManager
{
  public function init()
  {
    // Иерархию ролей расположим в файле auth.php в директории config приложения
    if($this->authFile === null)
    {
      $this->authFile = \Yii::getPathOfAlias('application.components.auth.auth').'.php';
    }

    parent::init();

    // Для гостей у нас и так роль по умолчанию guest.
    if(!\Yii::app()->user->getIsGuest())
    {
      /** @var $groups \application\models\admin\Group[] */
      $groups = \application\models\admin\Group::model()
          ->byUserId(\Yii::app()->user->getCurrentUser()->Id)
          ->with('Roles')->findAll();
      if (sizeof($groups) !== null)
      {
        foreach ($groups as $group)
        {
          foreach ($group->Roles as $role)
          {
            $this->assign($role->Code, \Yii::app()->user->getId());
          }
        }
      }
    }
  }
}
