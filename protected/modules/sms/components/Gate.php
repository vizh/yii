<?php
namespace sms\components;

use sms\models\Log;

abstract class Gate
{
    /**
     * @param Message $message
     * @return mixed
     */
    abstract public function internalSend(Message $message);

    /**
     * @param Message $message
     * @return bool
     */
    public final function send(Message $message)
    {
        $result = true;
        $log = new Log();
        try {
            $this->internalSend($message);
        }
        catch (Exception $e) {
            $log->Error = $e->getMessage();
            $result = false;
        }
        $log->To = $message->getTo();
        $log->Message = $message->getMessage();
        $log->save();
        return $result;
    }
} 