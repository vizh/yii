<?php
AutoLoader::Import('library.social.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.texts.*');
 
class MainRegister extends AbstractCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    header('Content-Type: text/html; charset=utf-8');
  }

  /**
   * Основные действия комманды
   * @param string $service
   * @return void
   */
  protected function doExecute($service = '')
  {
    if ($service == 'twitter')
    {
      $form = Registry::GetRequestVar('twitter');
      if (! empty($form))
      {
        $email = Registry::GetRequestVar('email');
        $email = strip_tags($email);
        if (!empty($email))
        {
          $content = RocidTwitterOAuth::GetContent();
          if ($content)
          {
            $id = $content->id;
            $connectTwitter = UserConnect::GetByHash($id, UserConnect::TwitterId);
            if (empty($connectTwitter))
            {
              $newUser = User::Register($email, Texts::GeneratePassword());
              if (! empty($newUser))
              {
                $name = $content->name;
                $parts = preg_split('/ /', $name, -1,PREG_SPLIT_NO_EMPTY);
                $newUser->FirstName = isset($parts[0])? $parts[0] : '';
                $newUser->LastName = isset($parts[1])? $parts[1] : '';
                $newUser->save();
                $connectFacebook = new UserConnect();
                $connectFacebook->UserId = $newUser->UserId;
                $connectFacebook->ServiceTypeId = UserConnect::TwitterId;
                $connectFacebook->Hash = $id;
                $connectFacebook->save();

                $identity = new TwitterIdentity($id);
                $identity->authenticate();
                if ($identity->errorCode == CUserIdentity::ERROR_NONE)
                {
                  Yii::app()->user->login($identity, $identity->GetExpire());
                  echo RocidTwitterOAuth::GetResultHtml('/user/edit/');
                  exit;
                }                
              }
              echo RocidTwitterOAuth::GetResultHtml('/?error=email_reg_fail');
              exit;
            }
            else
            {
              Lib::Redirect('/main/auth/twitter/');
            }
          }
          echo RocidTwitterOAuth::GetResultHtml('/?error=twi_connect_reg_fail');
          exit;
        }
      }
      $view = new View();
      $view->SetLayout('simple');
      $view->UseLayout(true);
      $view->SetTemplate('register');
      $view->Title = 'Регистрация через Twitter';

      echo $view;
    }
    elseif ($service == 'facebook')
    {
      $user = RocidFacebook::GetUserInfo();
      if (! empty($user))
      {
        $uid = $user['id'];
        $connectFacebook = UserConnect::GetByHash($uid, UserConnect::FacebookId);
        if (empty($connectFacebook))
        {
          $newUser = User::Register($user['email'], Texts::GeneratePassword());
          if (! empty($newUser))
          {
            $newUser->FirstName = $user['first_name'];
            $newUser->LastName = $user['last_name'];
            $newUser->save();
            $connectFacebook = new UserConnect();
            $connectFacebook->UserId = $newUser->UserId;
            $connectFacebook->ServiceTypeId = UserConnect::FacebookId;
            $connectFacebook->Hash = $uid;
            $connectFacebook->save();
            $path = 'http://graph.facebook.com/'. $uid .'/picture?type=large';
            $photo = file_get_contents($path);
            if ($photo)
            {
              $newUser->SavePhoto($photo);
            }
            $identity = new FacebookIdentity($uid);
            $identity->authenticate();
            if ($identity->errorCode == CUserIdentity::ERROR_NONE)
            {
              Yii::app()->user->login($identity, $identity->GetExpire());
            }
            Lib::Redirect('/user/edit/');
          }
          Lib::Redirect('/?error=email_reg_fail');
        }
        else
        {
          Lib::Redirect('/main/auth/facebook/');
        }
      }
      Lib::Redirect('/?error=fb_connect_reg_fail');
    }
  }
}
