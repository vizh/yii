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
            'Hash'   => md5($api . $secret),
            'FirstName' => 'Тестовый тест',
            'LastName' => '<h1>12312</h1>',
            'Email' => 'andrey.korotov22@yandex.ru',
            'FatherName' => 'Сергвчч',
            'Phone' => '+7 (925) 093-88-65',
            'Company' => 'Компания',
            'Position' => 'Должность',
            'Password' => 123444
        );

        //$params['Email'] = 'alaris.nik@gmail.com';
        //$params['LastName'] = 'Никитин';
        //$params['FirstName'] = 'Виталий';
        //$params['ExternalId'] = 121;
        //$params['RoleId'] = 5;

        //$params['OnlyPublic'] = true;
        //$params['WithDeleted'] = 1;

        //$params['SectionId'] = 12322;
        //$this->apiRequest('/api/section/deleteFavorite', $params);
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
