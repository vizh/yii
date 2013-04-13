<?php
namespace api\controllers\user;

class AuthAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();

    $token = $request->getParam('token');
    /** @var $accessToken \oauth\models\AccessToken */
    $accessToken = \oauth\models\AccessToken::model()->byToken($token)->find();

    if (empty($accessToken))
    {
      throw new \api\components\Exception(222);
    }
    if ($accessToken->AccountId != $this->getAccount()->Id)
    {
      throw new \api\components\Exception(222);
    }
    /** @var $user \user\models\User */
    $user = \user\models\User::model()->findByPk($accessToken->UserId);
    if (empty($user))
    {
      throw new \api\components\Exception(223);
    }

    $this->getAccount()->getDataBuilder()->createUser($user);
    $this->getAccount()->getDataBuilder()->buildUserContacts($user);
    $this->getAccount()->getDataBuilder()->buildUserEmployment($user);
    $this->getController()->setResult($this->getAccount()->getDataBuilder()->buildUserEvent($user));
  }
}
