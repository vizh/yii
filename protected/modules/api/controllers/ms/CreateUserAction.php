<?php
namespace api\controllers\ms;

class CreateUserAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $externalId = $request->getParam('ExternalId');
    $email = $request->getParam('Email');
    $lastName = $request->getParam('LastName');
    $firstName = $request->getParam('FirstName');
    $company = $request->getParam('Company');
    $position = $request->getParam('Position');

    $externalUser = \api\models\ExternalUser::model()
        ->byExternalId($externalId)->byPartner(\MsController::Partner)->find();
    if ($externalUser !== null)
      throw new \api\components\Exception(3002, array($externalId));
    if (empty($externalId))
      throw new \api\components\Exception(3004, array('ExternalId'));
    if (empty($email))
      throw new \api\components\Exception(3004, array('Email'));
    if (empty($lastName))
      throw new \api\components\Exception(3004, array('LastName'));
    if (empty($firstName))
      throw new \api\components\Exception(3004, array('FirstName'));

    $user = new \user\models\User();
    $user->FirstName = $firstName;
    $user->LastName = $lastName;
    $user->Email = strtolower($email);
    $user->register(false);

    $user->Visible = false;
    $user->Temporary = true;
    $user->save();

    $user->Settings->UnsubscribeAll = true;
    $user->Settings->save();

    $externalUser = new \api\models\ExternalUser();
    $externalUser->Partner = \MsController::Partner;
    $externalUser->UserId = $user->Id;
    $externalUser->ExternalId = $externalId;
    $externalUser->save();

    if (!empty($company))
    {
      try
      {
        $user->setEmployment($company, !empty($position) ? $position : '');
      }
      catch (\application\components\Exception $e)
      {
      }
    }

    $role = \event\models\Role::model()->findByPk(24);
    $this->getEvent()->skipOnRegister = true;
    $this->getEvent()->registerUser($user, $role);

    $url = $user->getFastauthUrl(\Yii::app()->createUrl('/pay/cabinet/register', ['eventIdName' => $this->getEvent()->IdName]));
    $this->setResult(['PayUrl' => $url]);
  }
}