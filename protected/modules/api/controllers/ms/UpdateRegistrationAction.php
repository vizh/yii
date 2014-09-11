<?php
namespace api\controllers\ms;

class UpdateRegistrationAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $externalId = $request->getParam('ExternalId');
    $roleId = $request->getParam('RoleId');

    $externalUser = \api\models\ExternalUser::model()
        ->byExternalId($externalId)->byAccountId($this->getAccount()->Id)->find();
    if ($externalUser === null)
      throw new \api\components\Exception(3003, array($externalId));

    $role = \event\models\Role::model()->findByPk($roleId);
    if (empty($role))
      throw new \api\components\Exception(3005);

    $this->getEvent()->skipOnRegister = true;
    try
    {
      if (empty($this->getEvent()->Parts))
      {
        $this->getEvent()->registerUser($externalUser->User, $role);
      }
      else
      {
        $this->getEvent()->registerUserOnAllParts($externalUser->User, $role);
      }
    }
    catch(\Exception $e)
    {
      throw new \api\components\Exception(100, array($e->getMessage()));
    }

    $this->setResult(array('Success' => true));
  }
}