<?php

namespace connect\components\handlers\accept\user;

use connect\models\Meeting;
use mail\components\MailLayout;
use user\models\User;

class Base extends \connect\components\handlers\Base
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'Вы подтвердили встречу с '.$this->meeting->Creator->FullName;
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->getUser()->Email;
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        $params = [
            'meeting' => $this->meeting,
            'user' => $this->meeting->Creator
        ];

        return $this->renderBody($this->getViewName(), $params);
    }

    public function getViewPath()
    {
        return 'connect.views.mail.accept.user';
    }
}