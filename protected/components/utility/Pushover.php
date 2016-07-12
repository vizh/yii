<?php

namespace application\components\utility;

/**
 * Позволяет отправлять push сообщения на подключенные
 * устройства, используя сервис pushover.net
 * @package application\components\utility
 */
class Pushover
{
    /**
     * Отправка Push сообщения
     * @param $msg mixed Переменная, значение которой необходимо отправить. Отправляется как есть, если имеет скалярный тип, или с помощью print_r(..., true)
     */
    public static function send($msg)
    {
        curl_setopt_array($ch = curl_init(), [
            CURLOPT_URL => 'https://api.pushover.net/1/messages.json',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => [
                'token' => 'aee4f7kms7wrqyodaods5cvxqvpx2u',
                'user' => '3KblqbgicuJzHYNidByVvBXA4P7qZa',
                'message' => is_scalar($msg) ? $msg : print_r($msg, true)
            ]
        ]);

        curl_exec($ch);
        curl_close($ch);
    }
}