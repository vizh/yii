<?php

class UserController extends \api\components\Controller
{


//  public function actionAuth()
//  {
//    $request = \Yii::app()->getRequest();
//
//    $token = $request->getParam('token');
//    $accessToken = \oauth\models\AccessToken::model()->byToken($token)->find();
//
//    if (empty($accessToken))
//    {
//      throw new \api\components\Exception(222);
//    }
//    if ($accessToken->EventId != $this->Account()->EventId)
//    {
//      throw new \api\components\Exception(222);
//    }
//    /** @var $user User */
//    $user = \user\models\User::model()->findByPk($accessToken->UserId);
//    if (empty($user))
//    {
//      throw new \api\components\Exception(223);
//    }
//
//    $this->Account()->DataBuilder()->CreateUser($user);
//    $this->Account()->DataBuilder()->BuildUserEmail($user);
//    $this->Account()->DataBuilder()->BuildUserEmployment($user);
//    $this->result = $this->Account()->DataBuilder()->BuildUserEvent($user);
//  }
}
