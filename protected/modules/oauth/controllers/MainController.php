<?php
class MainController extends \oauth\components\Controller 
{
  protected function initResources() 
  {
    Yii::app()->clientScript->registerCssFile(
      Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('oauth.assets').'/oauth.css'
      )
    );
  }

  public function actionDialog() 
  {
    if (\Yii::app()->user->isGuest)
    {
      $this->redirect($this->createUrl('/oauth/main/auth'));
    }
    
    $redirect = false;
    $user = \user\models\User::model()->findByPk(Yii::app()->user->getId()); 
    
    $permission = \oauth\models\Permission::model()->byUserId(Yii::app()->user->getId())->byEventId($this->Account->EventId)->find();
    if ($permission !== null)
    {
      $redirect = true;
    }
    else 
    {
      $reqDialog = \Yii::app()->request->getParam('Dialog');
      if ($reqDialog !== null
        && isset($reqDialog['Success']))
      {
        $permission = new \oauth\models\Permission();
        $permission->UserId  = $user->UserId;
        $permission->EventId = $this->Account->EventId; 
        $permission->save();
        $redirect = true;
      }
    }
    
    if ($redirect === true)
    {
      $accessToken = new \oauth\models\AccessToken();
      $accessToken->UserId    = $permission->UserId;
      $accessToken->EventId   = $permission->EventId;
      $accessToken->DeathTime = date('Y-m-d H:i:s', time()+86400);
      $accessToken->createToken($this->Account);
      $accessToken->save();
      
      $redirectUrl = Yii::app()->request->getParam('url');
      $pos = strrpos($redirectUrl, '?');
      $redirectUrl .= ($pos === false ? '?' : (($pos+1) != strlen($redirectUrl) ? '&' : '')) . http_build_query(array('token' => $accessToken->Token));
      $this->redirect($redirectUrl);
    }
    $this->render('dialog', array('user' => $user, 'event' => $this->Account->Event));
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
    if ($request->getIsPostRequest()
      && $formRegister->validate())
    {
      $user = new \user\models\User();
      $user->attributes = $formRegister->attributes;
      $user->register();
      $identity = new \application\components\auth\identity\FastAuth($user->RocId);
      $identity->authenticate();
      if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
      {
        \Yii::app()->user->login($identity);

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
    }
    
    $this->render('register', array('model' => $formRegister));
  }
  
  public function actionError()
  {
    $error = \Yii::app()->errorHandler->error;
    $this->render('error');
  }
}

?>
