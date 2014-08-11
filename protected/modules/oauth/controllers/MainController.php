<?php
class MainController extends \oauth\components\Controller
{
  public function actionDialog()
  {
    if ($this->Account->Id === self::SelfId)
    {
      if (!Yii::app()->user->isGuest)
      {
        Yii::app()->user->setIsRecentlyLogin();
      }
      if ($this->url === '' || $this->url === null)
      {
        echo '
        <script>
          window.top.modalAuthObj.success();
        </script>';
        return;
      }
      else
      {
        $this->redirect($this->url);
      }
    }

    $user = Yii::app()->user->getCurrentUser();
    if ($user === null)
    {
      $this->redirect($this->createUrl('/oauth/main/auth'));
    }

    $permission = \oauth\models\Permission::model()->byUserId($user->Id)->byAccountId($this->Account->Id)->find();
    if ($permission !== null)
    {
      $this->redirectWithToken();
    }
    elseif (Yii::app()->getRequest()->isPostRequest)
    {
      $permission = new \oauth\models\Permission();
      $permission->UserId  = $user->Id;
      $permission->AccountId = $this->Account->Id;
      $permission->Verified = true;
      $permission->save();
      $this->redirectWithToken();
    }

    $this->render('dialog', array('user' => $user, 'event' => $this->Account->Event));
  }

  private function redirectWithToken()
  {
    $user = Yii::app()->user->getCurrentUser();

    $accessToken = new \oauth\models\AccessToken();
    $accessToken->UserId = $user->Id;
    $accessToken->AccountId = $this->Account->Id;
    $accessToken->EndingTime = date('Y-m-d H:i:s', time()+86400);
    $accessToken->createToken($this->Account);
    $accessToken->save();

    $redirectUrl = trim($this->url, '#');
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
    $fast = $this->fast;
    $this->fast = null;

    $socialProxy = !empty($this->social) ? new \oauth\components\social\Proxy($this->social) : null;

    $request = \Yii::app()->getRequest();
    $authForm = new \oauth\components\form\AuthForm();
    $authForm->attributes = $request->getParam(get_class($authForm));
    if ($request->getIsPostRequest() && $authForm->validate())
    {
      $identity = new application\components\auth\identity\Password($authForm->Login, $authForm->Password);
      $identity->authenticate();
      if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
      {
        if ($authForm->RememberMe == 1)
        {
          \Yii::app()->user->login($identity, $identity->GetExpire());
        }
        else
        {
          \Yii::app()->user->login($identity);
        }
        \user\models\Log::create(\Yii::app()->user->getCurrentUser());
        if (isset($socialProxy) && $socialProxy->isHasAccess())
        {
          $socialProxy->saveSocialData(\Yii::app()->user->getCurrentUser());
        }
        $this->redirect($this->createUrl('/oauth/main/dialog'));
      }
      else
      {
        $authForm->addError('Login', 'Пользователя с такими Эл. почтой или RUNET-ID и паролем не существует.');
      }
    }

    $this->render('auth', [
      'model' => $authForm,
      'socialProxy' => $socialProxy,
      'fast' => $fast
    ]);
  }

  public function actionRegister()
  {
    if (!Yii::app()->user->isGuest)
    {
      $this->redirect($this->createUrl('/oauth/main/dialog'));
    }

    $formRegister = new \oauth\components\form\RegisterForm($this->Account);
    $socialProxy  = null;

    $socialProxy = !empty($this->social) ? new \oauth\components\social\Proxy($this->social) : null;
    if ($socialProxy !== null && $socialProxy->isHasAccess())
    {
      $formRegister->LastName = $socialProxy->getData()->LastName;
      $formRegister->FirstName = $socialProxy->getData()->FirstName;
      $formRegister->Email = $socialProxy->getData()->Email;
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
      $user->PrimaryPhone = $formRegister->Phone;
      $user->register();

      if (!$formRegister->Address->getIsEmpty())
      {
        $address = new \contact\models\Address();
        $address->setAttributes($formRegister->Address->getAttributes(), false);
        $address->save();
        $user->setContactAddress($address);
      }

      if (!empty($formRegister->Company))
      {
        $user->setEmployment($formRegister->Company);
      }
      $identity = new \application\components\auth\identity\RunetId($user->RunetId);
      $identity->authenticate();
      if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
      {
        \Yii::app()->user->login($identity);
        if ($socialProxy !== null && $socialProxy->isHasAccess())
        {
          $socialProxy->saveSocialData($user);
        }
        \user\models\Log::create($user);
        $this->redirect($this->createUrl('/oauth/main/dialog'));
      }
      else
      {
        throw new \application\components\Exception('Не удалось пройти авторизацию после регистрации. Код ошибки: ' . $identity->errorCode);
      }
    }
    \Yii::app()->getClientScript()->registerPackage('runetid.jquery.ui');
    \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
    $this->render('register', array('model' => $formRegister, 'socialProxy' => $socialProxy));
  }

  public function actionRecover()
  {
    $request = \Yii::app()->getRequest();
    $form = new user\models\forms\Recovery();
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      $user = user\models\User::model()->byEmail($form->Email)->byVisible(true)->find();
      if ($user !== null)
      {
        $mailer = new \mail\components\mailers\PhpMailer();
        //$mailer = new \mail\components\mailers\AmazonMailer();
        $form->ShowCode = true;
        if (empty($form->Code))
        {
          $mail = new \user\components\handlers\RecoverCode($mailer, $user);
          $mail->send();
          \Yii::app()->user->setFlash('success', \Yii::t('app', 'На указанный адрес электронной почты было отправлено письмо с кодом, введите его для смены пароля.'));
        }
        else
        {
          if ($user->checkRecoveryHash($form->Code))
          {
            $password = $user->changePassword();
            $mail = new \user\components\handlers\RecoverPassword($mailer, $user, $password);
            $mail->send();
            $identity = new \application\components\auth\identity\RunetId($user->RunetId);
            $identity->authenticate();
            \Yii::app()->user->login($identity);
            $this->redirect($this->createUrl('/oauth/main/dialog'));
          }
          else 
          {
            $form->addError('Code', \Yii::t('app', 'Указан не верный код для смены пароля.'));
          }
        }
      }
      else 
      {
        $form->addError('Email', \Yii::t('app', 'Ошибка! Не найден пользователь с указанным адресом электронной почты.'));
      }
    }
    $this->render('recover', array('form' => $form));
  }
 
  public function actionError()
  {
    $error = \Yii::app()->errorHandler->error;
    $this->render('error');
  }
}

?>
