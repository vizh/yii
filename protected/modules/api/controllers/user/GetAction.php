<?php
namespace api\controllers\user;

use user\models\User;

class GetAction extends \api\components\Action
{
  public function run()
  {
    $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
    if ($runetId === null)
    {
      $runetId = \Yii::app()->getRequest()->getParam('RocId', null);
    }

    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user !== null)
    {
      if ($this->getAccount()->Role == 'sberbank')
      {
        $participant = \event\models\Participant::model()
            ->byUserId($user->Id)->byEventId($this->getEvent()->Id)->find();
        if ($participant === null || $participant->RoleId == 24)
        {
          throw new \api\components\Exception(2001, array($runetId));
        }
      }

      $this->getDataBuilder()->createUser($user);
      $this->getDataBuilder()->buildUserEmployment($user);
      $this->getDataBuilder()->buildUserEvent($user);
      $userData = $this->getDataBuilder()->buildUserBadge($user);


      if ($this->hasContactsPermission($user, $userData))
      {
        $userData = $this->getDataBuilder()->buildUserContacts($user);
      }
      $this->setResult($userData);
    }
    else
    {
      throw new \api\components\Exception(202, array($runetId));
    }
  }

    private function hasContactsPermission(User $user, $userData)
    {
        switch ($this->getAccount()->Role) {
            case 'own':
                return true;
            case 'mobile':
                return false;
            default:
                $permissionModel = \oauth\models\Permission::model()->byUserId($user->Id)
                    ->byAccountId($this->getAccount()->Id)->byDeleted(false);
                return isset($userData->Status) || $permissionModel->exists();
        }
    }
}
