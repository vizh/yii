<?php
AutoLoader::Import('library.social.*');
 
class MainFacebookConnect extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $facebook = RocidFacebook::GetConnection();

    $session = $facebook->getSession();
    if ($session)
    {
      $call = Registry::GetRequestVar('call');
      if (! empty($call))
      {
        Lib::Redirect($call);
      }
      else
      {
        echo RocidFacebook::GetResultHtml();
        exit;
      }
    }

    $loginUrl = $facebook->getLoginUrl(
      array('display'=>'popup',
           'locale' => 'ru_RU',));
    Lib::Redirect($loginUrl);
  }
}
