<?php
class AuthController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($runetId, $hash, $redirectUrl = '')
  {
    $user = user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null || $user->getHash() != $hash)
    {
      throw new CHttpException(404);
    }
    
    $identity = new \application\components\auth\identity\RunetId($user->RunetId);
    $identity->authenticate();
    if ($identity->errorCode == \CUserIdentity::ERROR_NONE)
    {
      \Yii::app()->user->login($identity);
      if (!empty($redirectUrl))
      {
        if (strpos($redirectUrl, '/') !== false)
        {
          $this->redirect($redirectUrl);
        }
        else 
        {
          $shortUrl = \main\models\ShortUrl::model()->byHash($redirectUrl)->find();
          if ($shortUrl !== null)
          {
            $this->redirect($shortUrl->Url);
          }
        }
      }
    }
  }
}
