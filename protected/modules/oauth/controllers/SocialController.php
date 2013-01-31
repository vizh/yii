<?php


class SocialController extends \oauth\components\Controller
{
  public function actionRequest()
  {
    $socialProxy = new \oauth\components\social\Proxy($this->social);

    $test = \Yii::app()->request->getParam('test', null);
    if (!empty($test))
    {
      //print_r($_REQUEST);
    }

    if ($socialProxy->isHasAccess())
    {
      $data = $socialProxy->getData();
      $connect = $socialProxy->getConnect($data->Hash);
      if (!empty($connect))
      {
        $identity = new \application\components\auth\identity\Rocid($connect->User->RocId);
        $identity->authenticate();
        if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
        {
          \Yii::app()->user->login($identity, $identity->GetExpire());
        }
        else
        {
          throw new CHttpException(400);
        }
      }
      $this->redirect($this->createUrl('/oauth/main/dialog'));
    }
    else
    {
      $this->redirect($socialProxy->getOAuthUrl());
    }
  }
}