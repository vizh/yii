<?php


class TestController extends CController
{
  public $layout = '/layouts/oauth';

  public function actionIndex()
  {
    $api = 'test';
    $secret = '1234567890';
    $timestamp = time();
    $hash = substr(md5($api . $timestamp . $secret), 0, 16);

    $params = array(
      'ApiKey' => $api,
    );

    $request = \Yii::app()->getRequest();
    $token = $request->getParam('token', null);
    $token = 'NllZD1Eo6ZBD.KHuHHLMZJW37ei8zcPhpTeEchULhf5';
    if ($token !== null)
    {
      $params['Hash'] = $hash;
      $params['Timestamp'] = $timestamp;
      $params['token'] = $token;
      $this->apiRequest($params);
    }
    else
    {
      $params['r_state'] = md5(uniqid(rand(), true));
      $params['url'] = $this->createAbsoluteUrl('/oauth/test/index');

      $url = $this->createAbsoluteUrl('/oauth/main/dialog', $params);

      $this->renderPartial('index', array('url' => $url, 'rState' => $params['r_state']));
    }
  }

  private function apiRequest($params)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $url = $this->createAbsoluteUrl('/api/user/auth', $params);

    echo $url;

    curl_setopt($curl, CURLOPT_URL, $url);


    $result = curl_exec($curl);

    echo '<pre>';
    print_r($result);

    echo  curl_error ($curl);
    $result = json_decode($result);

    print_r($result);
    echo '</pre>';
  }
}
