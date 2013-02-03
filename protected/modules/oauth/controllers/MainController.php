<?php
class MainController extends \oauth\components\Controller 
{
  public function actionDialog() 
  {
    $user = Yii::app()->user->CurrentUser();
    if ($user === null)
    {
      $this->redirect($this->createUrl('/oauth/main/auth'));
    }
    
    $permission = \oauth\models\Permission::model()->byUserId($user->Id)->byEventId($this->Account->EventId)->find();
    if ($permission !== null)
    {
      $this->redirectWithToken();
    }
    elseif (Yii::app()->getRequest()->isPostRequest)
    {
      $permission = new \oauth\models\Permission();
      $permission->UserId  = $user->Id;
      $permission->EventId = $this->Account->EventId;
      $permission->Verified = true;
      $permission->save();
      $this->redirectWithToken();
    }

    $this->render('dialog', array('user' => $user, 'event' => $this->Account->Event));
  }

  private function redirectWithToken()
  {
    $user = Yii::app()->user->CurrentUser();

    $accessToken = new \oauth\models\AccessToken();
    $accessToken->UserId = $user->Id;
    $accessToken->EventId = $this->Account->EventId;
    $accessToken->EndingTime = date('Y-m-d H:i:s', time()+86400);
    $accessToken->createToken($this->Account);
    $accessToken->save();

    $redirectUrl = Yii::app()->request->getParam('url');
    $pos = strrpos($redirectUrl, '?');
    $redirectUrl .= ($pos === false ? '?' : (($pos+1) != strlen($redirectUrl) ? '&' : '')) . http_build_query(array('token' => $accessToken->Token));
    $this->redirect($redirectUrl);
  }
  
  public function actionAuth()
  {
    if (!\Yii::app()->user->isGuest)
    {
       $this->redirect($this->createUrl('/oauth/main/dialog'));
    }
    if (!empty($this->social))
    {
      $socialProxy = new \oauth\components\social\Proxy($this->social);
      if ($socialProxy->isHasAccess())
      {
        \Yii::app()->user->setFlash('message', 'Чтоб в следующий раз авторизоваться через соц. сеть авторизуйся щас!');
      }
    }

    $request = \Yii::app()->getRequest();
    $authForm = new \oauth\components\form\AuthForm();
    $authForm->attributes = $request->getParam(get_class($authForm));
    if ($request->getIsPostRequest() 
      && $authForm->validate())
    { 
      $identity = new application\components\auth\identity\Password($authForm->RocIdOrEmail, $authForm->Password);
      $identity->authenticate();
      if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
      {
        \Yii::app()->user->login($identity, $identity->GetExpire());
        
        if (isset($socialProxy)
          && $socialProxy->isHasAccess())
        {
          $user = \user\models\User::GetById(\Yii::app()->user->getId());
          $socialProxy->addConnect($user);
          $socialProxy->addContact($user);
        }
        
        \Yii::app()->user->setFlash('message', null);
        $this->redirect($this->createUrl('/oauth/main/dialog'));
      }
      else
      {
        $authForm->addError('RocIdOrEmail', 'Пользваотеля с таким Email / rocID не существует.');
      }
    }

    $fbUrl  = $this->createUrl('/oauth/social/request', array('social' => 'facebook'));
    $twiUrl = $this->createUrl('/oauth/social/request', array('social' => 'twitter'));
    $this->render('auth', array('model' => $authForm, 'fbUrl' => $fbUrl, 'twiUrl' => $twiUrl));
  }
  
  
  public function actionRegister()
  {
    if (!Yii::app()->user->isGuest)
    {
       $this->redirect($this->createUrl('/oauth/main/dialog'));
    }
    
    $formRegister = new \oauth\components\form\RegisterForm();
    $socialProxy = null;

    if (!empty($this->social))
    {
      $socialProxy = new \oauth\components\social\Proxy($this->social);
      if ($socialProxy->isHasAccess())
      {
        \Yii::app()->user->setFlash('message', 'Чтоб в следующий раз авторизоваться через соц. сеть авторизуйся щас!');
        $formRegister->LastName = $socialProxy->getData()->LastName;
        $formRegister->FirstName = $socialProxy->getData()->FirstName; 
        $formRegister->Email = $socialProxy->getData()->Email;
      }
    }

    $request = \Yii::app()->getRequest();
    $formRegister->attributes = $request->getParam(get_class($formRegister));
    if ($request->getIsPostRequest() && $formRegister->validate())
    {
      $user = new \user\models\User();
      $user->LastName = $formRegister->LastName;
      $user->FirstName = $formRegister->FirstName;
      $user->FatherName = $formRegister->FatherName;
      $user->Email = $formRegister->Email;
      $user->register();
      $identity = new \application\components\auth\identity\FastAuth($user->RunetId);
      $identity->authenticate();
      if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
      {
        \Yii::app()->user->login($identity);

        if (isset($socialProxy) && $socialProxy->isHasAccess())
        {
          $socialProxy->addConnect($user);
        }
        
        \Yii::app()->user->setFlash('message', null);
        $this->redirect($this->createUrl('/oauth/main/dialog'));
      }
      else
      {
        throw new \application\components\Exception('Не удалось пройти авторизацию после регистрации. Код ошибки: ' . $identity->errorCode);
      }
    }
    
    $this->render('register', array('model' => $formRegister));
  }

  public function actionRecover()
  {

  }
  
  public function actionError()
  {
    $error = \Yii::app()->errorHandler->error;
    $this->render('error');
  }
}

?>
