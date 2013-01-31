<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 10/1/12
 * Time: 12:45 PM
 * To change this template use File | Settings | File Templates.
 */
class FacebookController extends \oauth\components\Controller
{
  const FbAppId = 201234113248910;
  const FbUrl = 'https://www.facebook.com/dialog/oauth?';

  public function actionIndex()
  {
    $state = md5(uniqid(rand(), true));
    \Yii::app()->session->add('FbState', $state);

    $redirectUrl = $this->createAbsoluteUrl('/oauth/facebook/response');
    $params = array(
      'client_id' => self::FbAppId,
      'redirect_uri' => $redirectUrl,
      'state' => $state,
      'scope' => 'email'
    );

    $this->redirect(self::FbUrl . http_build_query($params));
  }

  public function actionResponse()
  {
    print_r($_REQUEST);
  }
}
