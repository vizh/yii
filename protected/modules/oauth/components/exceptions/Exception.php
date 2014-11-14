<?php
namespace oauth\components\exceptions;

class Exception extends \application\components\Exception
{
    const NONE = 'none';
    const TWITTER = 'Twitter';
    const VK = 'VK';
    const FACEBOOK = 'Facebook';
    const GOOGLE = 'Google';
    const PAYPAL = 'PayPal';

    public function __construct($message, $social, $previous = null)
    {
        parent::__construct($this->getErrorMessage($message, $social), 0, $previous);
    }

    /**
     * Возвращает текст сообщения исключения
     * @param $message
     * @param $social
     * @return string
     */
    private function getErrorMessage($message, $social)
    {
        if ($social != static::NONE) {
            return sprintf('Ошибка при авторизации через %s: "%s"', $social, $message);
        } else {
            return $message;
        }
    }

} 