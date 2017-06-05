<?php
namespace api\components\callback;

class AccountDevcon14 extends AccountMicrosoft
{
    protected function getUrlRegisterOnEvent()
    {
        return 'http://www.msdevcon.ru/payment/PayCallback/';
    }
}