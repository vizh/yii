<?php

namespace connect\components\handlers\decline;

use connect\models\Meeting;
use mail\components\MailLayout;
use user\models\User;

class Base extends MailLayout
{
    /** @var Meeting */
    protected $meeting;

    /** @var User */
    protected $user;

    /** @var string */
    protected $response;

    /**
     * @param \mail\components\Mailer $mailer
     * @param \CEvent $event
     */
    public function __construct(\mail\components\Mailer $mailer, \CEvent $event)
    {
        parent::__construct($mailer);
        $this->meeting = $event->params['meeting'];
        $this->user = $event->params['user'];
        $this->response = $event->params['response'];
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->getUser()->getFullName().' не сможет встретится с Вами';
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return 'connect@runet-id.com';
    }

    /**
     * @inheritdoc
     */
    public function getFromName()
    {
        return '—RUNET—ID—';
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

    /**
     * Путь к шаблону письма
     * @return string
     */
    public function getViewName()
    {
        $dir = 'connect.views.mail.decline';
        $view = $this->meeting->Place->Event->IdName;
        if (is_file(\Yii::getPathOfAlias($dir).'/'.$view.'.php')){
            return $dir.'.'.$view;
        }
        else{
            return $dir.'.base';
        }
    }

    /**
     * @inheritdoc
     */
    public function getUser()
    {
        return $this->user;
    }
}