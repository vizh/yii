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
    if ($accessToken->AccountId != $this->Account()->Id)
    {
      throw new \api\components\Exception(222);
    }
    /** @var $user \user\models\User */
    $user = \user\models\User::model()->findByPk($accessToken->UserId);
    if (empty($user))
    {
      throw new \api\components\Exception(223);
    }

    $this->getController()->setResult($this->getAccount()->DataBuilder()->CreateUser($user));
    //$this->Account()->DataBuilder()->BuildUserEmail($user);
    //$this->Account()->DataBuilder()->BuildUserEmployment($user);
    //$this->result = $this->Account()->DataBuilder()->BuildUserEvent($user);
  }
}
