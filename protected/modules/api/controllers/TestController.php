<?php

class TestController extends CController
{
  public function actionIndex()
  {
    //$api = 'zrnzd5rs8i';
    //$secret = 'YzyrQiHRGDZhsh7ENiRi6YdE5';
    $api = 'bcOGdeQYwz';
    $secret = 'ULWCFtNbAsdCPLqRQXZ9b0kUg';

    $params = array(
      'ApiKey' => $api,
      'Hash' => md5($api . $secret),
      'Filter' => ['Attributes' => ['TEST' => 3]]
    );

    //$params['Email'] = 'alaris.nik@gmail.com';
    //$params['LastName'] = 'Никитин';
    //$params['FirstName'] = 'Виталий';
    //$params['ExternalId'] = 121;
    //$params['RoleId'] = 5;

    $params['PayerRunetId'] = 321;

    //$params['SectionId'] = 12322;
    //$this->apiRequest('/api/section/deleteFavorite', $params);

    print_r($params);

    $this->apiRequest('/api/section/list', $params);
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
