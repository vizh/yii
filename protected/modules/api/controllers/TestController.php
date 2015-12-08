<?php

class TestController extends CController
{
    public function actionIndex()
    {
        //$api = 'zrnzd5rs8i';
        //$secret = 'YzyrQiHRGDZhsh7ENiRi6YdE5';
        $api = 't826ybtyi6';
        $secret = 'ZF4F85hRhBD4Ntty9943kAyzG';

        $params = array(
            'ApiKey' => $api,
            'Hash' => md5($api . $secret),
            'Code' => 'bitrix',
            'Raec' => true,
            'FirstName' => 'asdhasфывфjkdhashdkaf',
            'LastName' => 'asdmaasdasdsldajsldas',
            'Company' => 'ЗЗЗЗЗ',
            'Position' => 1231231231231231,
            'Email' => 'j51156qweq1111weqwq@trbvm.com',
            'Password' => '123456',
            'City' => 'Москва',
            'Country' => 'Россия',
            'ExternalId' => 'dasdasd-asdasda-1ssss231333323---22--'
        );
        print_r($params);
        $this->apiRequest('/api/user/create', $params);
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
