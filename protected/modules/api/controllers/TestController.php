<?php

class TestController extends CController
{
    public function actionIndex()
    {
        exit;
        //$api = 'zrnzd5rs8i';
        //$secret = 'YzyrQiHRGDZhsh7ENiRi6YdE5';
        $api = 't826ybtyi6';
        $secret = 'ZF4F85hRhBD4Ntty9943kAyzG';

        $params = array(
            'ApiKey' => $api,
            'Hash' => md5($api . $secret),
            'Phone' => '792510938855',
            'FirstName' => 'PssPPPP',
            'LastName' => 'PPPPP',
            'FatherName' => 'PPPP',
            'Email' => 'andrey.kor123otov@yandex.ru',
            'Company' => 'Google',
            'Position' => 'Какая-то компания',
            'ExternalId' => 'kasj213123121kasdasasd'
        );
        print_r($params);
        $this->apiRequest('/api/ms/createuser', $params);
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
