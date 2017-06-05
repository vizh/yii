<?php

namespace connect\components\handlers\invite;

class Base extends \connect\components\handlers\Base
{
    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->meeting->Creator->getFullName().' предлагает Вам встретится';
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
            'user' => $this->getUser()
        ];

        return $this->renderBody($this->getViewName(), $params);
    }

    public function getViewPath()
    {
        return 'connect.views.mail.invite';
    }
}