<?php
namespace api\controllers\event;

class RegisterAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId');
    $roleId = $request->getParam('RoleId');
    $usePriority = $request->getParam('UsePriority', true);

    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if (empty($user))
    {
      throw new \api\components\Exception(202, array($runetId));
    }

    $role = \event\models\Role::model()->findByPk($roleId);
    if (empty($role))
    {
      throw new \api\components\Exception(302);
    }

    try{
      if (empty($this->getEvent()->Parts))
      {
        $participant = $this->getEvent()->registerUser($user, $role, $usePriority);
      }
      else
      {
        $participant = $this->getEvent()->registerUserOnAllParts($user, $role);
      }
    }
    catch(\Exception $e)
    {
      throw new \api\components\Exception(100, array($e->getMessage()));
    }
    if (empty($participant))
    {
      throw new \api\components\Exception(303);
    }

    $this->setResult(array('Success' => true));
  }
}
