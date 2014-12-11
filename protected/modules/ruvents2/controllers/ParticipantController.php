<?php

class ParticipantController extends CController
{

    public function actionIndex()
    {
        $headers = getallheaders();
        print_r($headers);
    }

    public function actionTest()
    {
        $ch = curl_init('https://ruvents2.runet-id.loc/participant/index/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Runet-Id-Key: abra-kadabra',
            'X-Runet-Id-Secret: sdfsdf7sd9f8sdfhsduif'
        ]);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($ch);

        echo $result;
        echo '<br>';
        $error = curl_error($ch);
        echo $error;
        echo '<br>';
        echo curl_errno($ch);
    }
}