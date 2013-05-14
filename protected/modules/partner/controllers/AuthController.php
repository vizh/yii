<?php
class AuthController extends partner\components\Controller
{
  public $error = false;

  public function actionIndex ()
  {
    $this->setPageTitle('Страница авторизации');


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
        $this->redirect($backUrl == null ? Yii::app()->createUrl('/partner/main/index') : $backUrl);
      }
      else
      {
        $this->error = true;
      }
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