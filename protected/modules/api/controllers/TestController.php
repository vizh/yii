<?php

class TestController extends CController
{
    public function actionIndex()
    {
        //$api = 'zrnzd5rs8i';
        //$secret = 'YzyrQiHRGDZhsh7ENiRi6YdE5';
        $api = 'fazr454y5i';
        $secret = 'bBh8h3Bzd84a3Kb2DK4iaTADa';

        $params = array(
            'ApiKey' => $api,
            'Hash'   => md5($api . $secret),
            'FirstName' => 'Тестовый',
            'LastName' => 'Devcon',
            'Email' => 'test@devcon111.ru',
            'Phone' => '+7 (925) 093-88-11',
            'Company' => 'Компания',
            'Position' => 'Должность',
            'ExternalId' => '4bd4c40e-ee33-46e3-82d7-fa31c43ae582290'
        );
        exit;
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
