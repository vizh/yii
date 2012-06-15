<?php
AutoLoader::Import('library.social.*');
 
class MainTwitterConnect extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->view->SetLayout('simple');
    $session = Registry::GetSession();

    $twi_oauth_token = $session->get('twi_oauth_token');
    if (isset($_REQUEST['oauth_token']) && $twi_oauth_token != null &&
        $twi_oauth_token == $_REQUEST['oauth_token'])
    {
      $connection = RocidTwitterOAuth::GetConnection($twi_oauth_token, $session->get('twi_oauth_token_secret'));
      $accessToken = $connection->getAccessToken($_REQUEST['oauth_verifier']);

      if ($connection->http_code == 200)
      {
        $session->add('twi_access_token', $accessToken);
        $session->remove('twi_oauth_token');
        $session->remove('twi_oauth_token_secret');        

        $call = Registry::GetRequestVar('call');

        $this->view->Call = $call;
        echo $this->view;
      }
      else
      {

        $this->view->SetTemplate('error');
        $this->SetTitle('Регистрация/авторизация через Twitter');
        echo $this->view;
      }
    }
    else
    {
      $call = Registry::GetRequestVar('call');
      $call = ! empty($call) ? '?call=' . urlencode($call) : '';
      $connection = RocidTwitterOAuth::GetConnection();
      $request_token = $connection->getRequestToken(OAUTH_CALLBACK . $call);

      if ($connection->http_code == 200)
      {
        $session->add('twi_oauth_token', $request_token['oauth_token']);
        $session->add('twi_oauth_token_secret', $request_token['oauth_token_secret']);

        $url = $connection->getAuthorizeURL($request_token['oauth_token']);
        Lib::Redirect($url);
      }
      else
      {
        $this->view->SetTemplate('error');
        $this->SetTitle('Регистрация/авторизация через Twitter');
        echo $this->view;
      }
    }
  }
}
