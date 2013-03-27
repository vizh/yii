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

    /** @var $event \event\models\Event */
    $event = \event\models\Event::model()->findByPk($this->getAccount()->EventId);
    if (empty($event))
    {
      throw new \api\components\Exception(301);
    }

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
      $eventUser = $event->registerUser($user, $role, $usePriority);
    }
    catch(\Exception $e)
    {
      throw new \api\components\Exception(100, array($e->getMessage()));
    }
    if (empty($eventUser))
    {
      throw new \api\components\Exception(303);
    }

    $this->setResult(array('Success' => true));
  }
}
