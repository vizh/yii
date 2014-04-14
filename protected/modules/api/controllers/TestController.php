<?php

class TestController extends CController
{
  public function actionIndex()
  {
    //$api = 'zrnzd5rs8i';
    //$secret = 'YzyrQiHRGDZhsh7ENiRi6YdE5';
    $api = 'ny2bp534c3';
    $secret = '62z9526EcX4r35t79m368T44R';

    $params = array(
      'ApiKey' => $api,
      'Hash' => md5($api . $secret)
    );

    //$params['Email'] = 'alaris.nik@gmail.com';
    //$params['LastName'] = 'Никитин';
    //$params['FirstName'] = 'Виталий';
    //$params['ExternalId'] = 121;
    //$params['RoleId'] = 5;

    $params['RunetId'] = 321;

    //$params['SectionId'] = 12322;
    //$this->apiRequest('/api/section/deleteFavorite', $params);

    $this->apiRequest('/api/section/favorites', $params);
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
