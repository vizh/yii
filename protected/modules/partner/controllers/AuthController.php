<?php
class AuthController extends partner\components\Controller
{
  public $error = false;

  public function actionIndex ()
  {
    $request = Yii::app()->request;
    if ($request->getIsPostRequest())
    {
      $login = $request->getParam('login');
      $password = $request->getParam('password');

      $identity = new \partner\components\Identity($login, $password);
      $identity->authenticate();
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        Yii::app()->partner->login($identity);
        $backUrl = $request->getParam('backUrl', null);
        $this->redirect($backUrl == null ? Yii::app()->createUrl('/partner/main/home') : $backUrl);
      }
      else
      {
        $this->error = true;
      }
    }

    if (!Yii::app()->partner->isGuest)
    {
      Yii::app()->partner->logout();
      $this->refresh();
    }

    $this->render('index');
  }

  public function actionLogout($extended = null)
  {
    if ($extended == 'reset' && \Yii::app()->partner->getAccount()->getIsExtended())
    {
      \Yii::app()->getSession()->remove('PartnerAccountEventId');
    }
    else
    {
      \Yii::app()->partner->logout(false);
    }

    $this->redirect(\Yii::app()->createUrl('/partner/main/index'));
  }
}