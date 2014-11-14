<?php
namespace oauth\components\exceptions;

class TwitterException extends Exception
{

    public function __construct($message = '', $errors = [], $previous = null)
    {
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $message .= sprintf("%s: %s \r\n", $error->code, $error->message);
            }
        }
        $message = trim($message);
        parent::__construct($message, static::TWITTER, $previous);
    }
} 