<?php

namespace connect\components\handlers\cancelcreator\creator;

use connect\models\Meeting;
use mail\components\MailLayout;
use user\models\User;

class Base extends \connect\components\handlers\Base
{
    /** @var string */
    protected $response;

    /**
     * @param \mail\components\Mailer $mailer
     * @param \CEvent $event
     */
    public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer, $event);
        $this->response = $event->params['response'];
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return 'Вы отменили встречу с '.$this->getUser()->getFullName();
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
            'user' => $this->getUser(),
            'response' => $this->response
        ];

        return $this->renderBody($this->getViewName(), $params);
    }

    public function getViewPath()
    {
        return 'connect.views.mail.cancelcreator.creator';
    }
}