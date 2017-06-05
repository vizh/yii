<?php

namespace application\components\mail;

use mail\components\Mail as AbstractMail;
use mail\components\Mailer;

class Mail extends AbstractMail
{
    public function __construct(Mailer $mailer, array $attributes)
    {
        parent::__construct($mailer, $attributes);
    }

    /**
     * Получатель
     *
     * @return string
     */
    public function getTo()
    {
        return $this->attributes['to'];
    }

    /**
     * Отправитель
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->attributes['from'];
    }

    /**
     * Тело письма
     *
     * @return string
     */
    public function getBody()
    {
        return $this->attributes['body'];
    }
}