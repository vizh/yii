<?php
namespace api\controllers\user;

class LoginAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = intval($request->getParam('RunetId', null));
    if (empty($runetId))
    {
      $runetId = intval($request->getParam('RocId', null));
    }
    $email = $request->getParam('Email', null);
    //$password = $request->getParam('Password');
    //$password2 = $request->getParam('PasswordCp1251');
    $password = base64_decode($request->getParam('Password'));

    /** @var $user \user\models\User */
    $user = null;
    if (!empty($runetId))
    {
      $user = \user\models\User::model()->byRunetId($runetId)->find();
      if ($user === null)
      {
        throw new \api\components\Exception(202, array($runetId));
      }
    }
    elseif (! empty($email))
    {
      $user = \user\models\User::model()->byEmail($email)->find();
      if ($user === null)
      {
        throw new \api\components\Exception(210, array($email));
      }
    }
    else
    {
      throw new \api\components\Exception(110);
    }

    if (!$user->checkLogin($password))
    {
      throw new \api\components\Exception(201);
    }

    $this->getAccount()->getDataBuilder()->createUser($user);
      if ($this->getAccount()->Role != 'mobile') {
          $this->getAccount()->getDataBuilder()->buildUserContacts($user);
      }
    $this->getAccount()->getDataBuilder()->buildUserEmployment($user);
    $result = $this->getAccount()->getDataBuilder()->buildUserEvent($user);

    $this->setResult($result);
  }
}
