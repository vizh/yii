<?php


class SocialController extends \oauth\components\Controller
{
  public function actionRequest()
  {
    $socialProxy = new \oauth\components\social\Proxy($this->social);

    if ($socialProxy->isHasAccess())
    {
      $socialProxy->clearData();
      $data = $socialProxy->getData();
      $social = $socialProxy->getSocial($data->Hash);
      if (!empty($social))
      {
        $identity = new \application\components\auth\identity\RunetId($social->User->RunetId);
        $identity->authenticate();
        if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
        {
          \Yii::app()->user->login($identity, $identity->GetExpire());
        }
        else
        {
          throw new CHttpException(400);
        }
        $this->redirect($this->createUrl('/oauth/main/dialog'));
      }
      else
      {
        $this->redirect($this->createUrl('/oauth/main/register'));
      }
    }
    else
    {
      $this->redirect($socialProxy->getOAuthUrl());
    }
  }
}