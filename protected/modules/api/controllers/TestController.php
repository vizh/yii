<?php

class TestController extends CController
{
  public function actionIndex()
  {
    $api = 'ny2bp534c3';
    $secret = '62z9526EcX4r35t79m368T44R';
    $timestamp = time();

    $params = array(
      'ApiKey' => $api,
      'Hash' => substr(md5($api . $timestamp . $secret), 0, 16),
      'Timestamp' => $timestamp
    );

    //$params['CompanyId'] = 449;
    $this->apiRequest('/api/event/statistics', $params);
  }

  private function apiRequest($url, $params)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $url = $this->createAbsoluteUrl($url, $params);

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
