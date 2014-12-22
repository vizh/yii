<?php
namespace api\components\callback;

class AccountDevcon15 extends AccountMicrosoft
{
    protected function getUrlRegisterOnEvent()
    {
        return 'http://www.msdevcon.ru/payment/paycallback?provider=runet';
    }
}