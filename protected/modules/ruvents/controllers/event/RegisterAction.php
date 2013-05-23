<?php
namespace ruvents\controllers\event;

class RegisterAction extends \ruvents\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId', null);
    $roleId = $request->getParam('RoleId', null);
    $partId = $request->getParam('PartId', null);

    $event = $this->getEvent();
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user === null)
    {
      throw new \ruvents\components\Exception(202, array($runetId));
    }

    /** @var $role \event\models\Role */
    $role = \event\models\Role::model()->findByPk($roleId);
    if ($role === null)
    {
      throw new \ruvents\components\Exception(302);
    }

    $part = null;
    try
    {
      if (sizeof($event->Parts) > 0)
      {
//        $part = \event\models\Part::model()->findByPk($partId);
//        if ($part === null)
//        {
//          throw new \ruvents\components\Exception(306, array($partId));
//        }
//        $event->registerUserOnPart($part, $user, $role);
        $event->registerUserOnAllParts($user, $role);
      }
      else
      {
        $event->registerUser($user, $role);
      }
    }
    catch (\Exception $e)
    {
      throw new \ruvents\components\Exception(100, array($e->getMessage()));
    }

    $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Role', 0, $role->Id));
    if ($part !== null)
    {
      $this->getDetailLog()->addChangeMessage(new \ruvents\models\ChangeMessage('Part', $part->Id, $part->Id));
    }
    $this->getDetailLog()->UserId = $user->Id;
    $this->getDetailLog()->save();

    echo json_encode(array('Success' => true));
  }
}
