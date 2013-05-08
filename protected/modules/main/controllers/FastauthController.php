<?php
class FastauthController extends \application\components\controllers\PublicMainController
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
      if (!$user->Temporary)
      {
        \Yii::app()->user->login($identity);
      }
      else
      {
        \Yii::app()->payUser->login($identity);
      }

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
      else
      {
        $this->redirect(
          $this->createUrl('/main/default/index')
        );
      }
    }
  }
}
