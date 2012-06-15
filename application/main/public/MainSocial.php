<?php
AutoLoader::Import('library.social.*');
AutoLoader::Import('library.texts.*');
 
class MainSocial extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @param string $social
   * @return void
   */
  protected function doExecute($social = '')
  {
    if (! empty($this->LoginUser))
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index'));
    }

    $socialId = SocialWrapper::UserId($social);
    if (!empty($socialId))
    {
      $userConnect = SocialWrapper::GetUserConnect($social, $socialId);
      if (!empty($userConnect))
      {
        $this->authUser($social, $socialId);
      }
      else
      {
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
          $data = Registry::GetRequestVar('data');
          $purifier = new CHtmlPurifier();
          $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');
          $data['LastName'] = $purifier->purify($data['LastName']);
          $data['FirstName'] = $purifier->purify($data['FirstName']);
          $emailValidator = new CEmailValidator();
          if (empty($data['LastName']) || empty($data['FirstName']))
          {
            $this->AddErrorNotice('Фамилия и имя не могут быть пустыми');
          }
          elseif (empty($data['Email']) || !$emailValidator->validateValue($data['Email']))
          {
            $this->AddErrorNotice('Контактный email задан некорректно');
          }
          else
          {
            $this->registerUser($social, $socialId, $data);
          }
          $this->view->LastName = $data['LastName'];
          $this->view->FirstName = $data['FirstName'];
          $this->view->Email = $data['Email'];
        }
        else
        {
          $this->view->LastName = SocialWrapper::LastName($social);
          $this->view->FirstName = SocialWrapper::FirstName($social);
          $this->view->Email = SocialWrapper::Email($social);
        }
      }
    }
    else
    {
      $this->showError($social);
    }

    echo $this->view;
  }

  private function showError($social)
  {
    $this->view->SetTemplate('error');
      switch ($social)
      {
        case SocialWrapper::Facebook:
          $this->view->Error = 'Ошибка обращения к Facebook';
          break;
        case SocialWrapper::Twitter:
          $this->view->Error = 'Ошибка обращения к Twitter';
          break;
      }
  }

  private function authUser($social, $socialId)
  {
    $identity = SocialWrapper::Identity($social, $socialId);
    if (! empty($identity))
    {
      $identity->authenticate();
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        Yii::app()->user->login($identity, $identity->GetExpire());
        $call = Registry::GetRequestVar('call');
        $call = !empty($call) ? $call : RouteRegistry::GetUrl('main', '', 'index');
        Lib::Redirect($call);
      }
    }
    $this->showError($social);
  }

  private function registerUser($social, $socialId, $data)
  {
    $user = User::Register($data['Email'], Texts::GeneratePassword());
    if (! empty($user))
    {
      $user->LastName = $data['LastName'];
      $user->FirstName = $data['FirstName'];
      $user->save();

      SocialWrapper::CreateUserConnect($social, $socialId, $user->UserId);

      if ($social == SocialWrapper::Facebook)
      {
        $path = 'http://graph.facebook.com/'. $socialId .'/picture?type=large';
        $photo = file_get_contents($path);
        if ($photo)
        {
          $user->SavePhoto($photo);
        }
      }

      $this->authUser($social, $socialId);
    }
    else
    {
      $this->AddErrorNotice('Учётная запись с введённым вами email уже зарегистрирована.', 'Вероятнее всего вы уже регистрировались на сайте — попробуйте восстановить пароль.');
    }
  }
}
