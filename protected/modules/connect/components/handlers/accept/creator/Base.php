<?php

namespace connect\components\handlers\accept\creator;

class Base extends \connect\components\handlers\Base
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->getUser()->getFullName().' подтверждает возможность встречи';
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->meeting->Creator->Email;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        $params = [
            'meeting' => $this->meeting,
            'user' => $this->getUser()
        ];

        return $this->renderBody($this->getViewName(), $params);
    }

    /**
     * Путь к шаблону письма
     * @return string
     */
    public function getViewPath()
    {
        return 'connect.views.mail.accept.creator';
    }
}