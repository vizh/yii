<?php
AutoLoader::Import('library.social.*');
 
class UserEditConnect extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @param string $social
   * @return void
   */
  protected function doExecute($social = '')
  {
    if (empty($this->LoginUser))
    {
      Lib::Redirect('/');
    }

    $socialId = SocialWrapper::UserId($social);
    if (!empty($socialId))
    {
      SocialWrapper::CreateUserConnect($social, $socialId, $this->LoginUser->UserId);
      Lib::Redirect('/user/edit/#contact');
    }
    else
    {
      //todo: вывести корректные ошибки
      $this->Send404AndExit();
    }


//    if ($service == 'twitter')
//    {
//      if ($this->LoginUser == null)
//      {
//        echo RocidTwitterOAuth::GetResultHtml();
//        exit;
//      }
//
//      $content = RocidTwitterOAuth::GetContent();
//      if ($content)
//      {
//        //print_r($content);
//
//        $id = $content->id;
//        $connectTwitter = UserConnect::GetDublicate($this->LoginUser->UserId, $id, UserConnect::TwitterId);
//        if ($connectTwitter == null)
//        {
//          $connectTwitter = new UserConnect();
//        }
//
//        $connectTwitter->UserId = $this->LoginUser->UserId;
//        $connectTwitter->ServiceTypeId = UserConnect::TwitterId;
//        $connectTwitter->Hash = $id;
//        $connectTwitter->save();
//
//        //print_r($connectTwitter);
//      }
//
//      echo RocidTwitterOAuth::GetResultHtml();
//    }
//    elseif ($service == 'facebook')
//    {
//      if ($this->LoginUser == null)
//      {
//        Lib::Redirect('/');
//      }
//
//      $uid = RocidFacebook::GetUserId();
//      if (! empty($uid))
//      {
//        $connectFacebook = UserConnect::GetDublicate($this->LoginUser->UserId, $uid, UserConnect::FacebookId);
//        if ($connectFacebook == null)
//        {
//          $connectFacebook = new UserConnect();
//        }
//
//        $connectFacebook->UserId = $this->LoginUser->UserId;
//        $connectFacebook->ServiceTypeId = UserConnect::FacebookId;
//        $connectFacebook->Hash = $uid;
//        $connectFacebook->save();
//      }
//
//      Lib::Redirect('/user/edit/#contact');
//    }
  }
}
