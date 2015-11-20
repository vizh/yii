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
            'RunetId'=> 321,
            'FirstName' => 'Коротов',
            'LastName'  => 'Андрей',
            'FatherName'=> 'Сергеевич',
            'Company'   => 'Internet Media Holding',
            'Position'  => 'Программист 3',
            'Country'   => 'Россия',
            'City'      => 'Moscow',
            'Phone'     => '71112223332',
        );
        print_r($params);
        $this->apiRequest('/api/ms/updateuser', $params);
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
