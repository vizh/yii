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
      \Yii::log('Token: ' . $token, \CLogger::LEVEL_ERROR);
      throw new \api\components\Exception(222);
    }
    if ($accessToken->AccountId != $this->getAccount()->Id)
    {
      throw new \api\components\Exception(223);
    }
    /** @var $user \user\models\User */
    $user = \user\models\User::model()->findByPk($accessToken->UserId);
    if (empty($user))
    {
      throw new \api\components\Exception(224);
    }

    $this->getAccount()->getDataBuilder()->createUser($user);
      if ($this->getAccount()->Role != 'mobile') {
          $this->getAccount()->getDataBuilder()->buildUserContacts($user);
      }
    $this->getAccount()->getDataBuilder()->buildUserEmployment($user);
    $this->getAccount()->getDataBuilder()->buildUserEvent($user);

    $this->getController()->setResult($this->getAccount()->getDataBuilder()->buildUserBadge($user));
  }
}
