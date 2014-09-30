<?php
namespace sms\components\gates;


use sms\components\Exception;
use sms\components\Gate;
use sms\components\Message;

class SmsRu extends Gate
{
    /**
     * @param Message $message
     * @return mixed|void
     * @throws \sms\components\Exception
     */
    public function internalSend(Message $message)
    {
        $gate = new \ext\smsru\smsru('f2957000-6bd1-8654-251d-6b20ca7eef37');
        $response = $gate->sms_send($message->getTo(), $message->getMessage());
        if ($response['code'] != 100) {
            throw new Exception($response['description']);
        }
    }
}