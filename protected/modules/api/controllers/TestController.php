<?php

class TestController extends CController
{
    public function actionIndex()
    {
        exit;
        //$api = 'zrnzd5rs8i';
        //$secret = 'YzyrQiHRGDZhsh7ENiRi6YdE5';
        $api = '2fya967ars';
        $secret = '6sYyyfYAZBBsn2bf3G8fnd2z6';

        $params = array(
            'ApiKey' => $api,
            'Hash' => md5($api . $secret),
            'Raec' => true
        );
        print_r($params);
        $this->apiRequest('/api/company/list', $params);
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
