<?php

namespace application\hacks\forinnovations16;

use application\hacks\AbstractHack;
use GuzzleHttp;
use user\models\User;

class Hack extends AbstractHack
{
    /**
     * Проверка корректности логина и пароля средствами forinnovations.ru
     * --
     * {@inheritdoc}
     */
    public function apiCustomLogin($email, $password)
    {
        $request = (new GuzzleHttp\Client())->post('https://forinnovations.ru/login/runetid', [
            'body' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        return $request->getBody()->getContents() === 'true'
            ? User::model()->byEmail($email)->find()
            : null;
    }

}