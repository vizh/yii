<?php
namespace api\components\callback;

class AccountDevcon16 extends AccountMicrosoft
{
    protected function getUrlRegisterOnEvent()
    {
        return 'http://events.techdays.ru/payment/paycallback?provider=RUNET';
    }
}